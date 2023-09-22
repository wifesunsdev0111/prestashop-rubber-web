<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\ObjectPresenter;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

require_once _PS_MODULE_DIR_ . 'aei_cmstop/classes/AEICmsTop.php';
class Aei_Cmstop extends Module implements WidgetInterface
{
    // Equivalent module on PrestaShop 1.6, sharing the same data
    const MODULE_16 = 'blockcmsinfo';

    /**
     * @var string Template used by widget
     */
    private $templateFile;

    public function __construct()
    {
        $this->name = 'aei_cmstop';
        $this->author = 'Aeipix';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        Shop::addTableAssociation('aeicmstopinfo', ['type' => 'shop']);

        $this->displayName = $this->trans('AX CMS Top', [], 'Modules.AEICmsTop.Admin');
        $this->description = $this->trans('Add CMS Top in your store.', [], 'Modules.AEICmsTop.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.4.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:aei_cmstop/views/templates/hook/aei_cmstop.tpl';
    }

    /**
     * @return bool
     */
    public function install()
    {
        // Remove 1.6 equivalent module to avoid DB issues
        if (Module::isInstalled(self::MODULE_16)) {
            return $this->installFrom16Version();
        }

        return $this->runInstallSteps()
            && $this->installFixtures();
    }

    /**
     * @return bool
     */
    public function runInstallSteps()
    {
        return parent::install()
            && $this->installDB()
            && $this->registerHook('displayNavFullWidth')
            && $this->registerHook('actionShopDataDuplication');
    }

    /**
     * @return bool
     */
    public function installFrom16Version()
    {
        require_once _PS_MODULE_DIR_ . $this->name . '/classes/MigrateData.php';
        $migration = new MigrateData();
        $migration->retrieveOldData();

        $oldModule = Module::getInstanceByName(self::MODULE_16);
        if ($oldModule) {
            $oldModule->uninstall();
        }

        return $this->uninstallDB()
            && $this->runInstallSteps()
            && $migration->insertData();
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallDB();
    }

    /**
     * @return bool
     */
    public function installDB()
    {
        $return = Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstopinfo` (
                `id_aeicmstopinfo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_aeicmstopinfo`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstopinfo_shop` (
                `id_aeicmstopinfo` INT(10) UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`id_aeicmstopinfo`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstopinfo_lang` (
                `id_aeicmstopinfo` INT UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                `id_lang` INT(10) UNSIGNED NOT NULL ,
                `text` text NOT NULL,
                PRIMARY KEY (`id_aeicmstopinfo`, `id_lang`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        return $return;
    }

    /**
     * @param bool $drop_table
     *
     * @return bool
     */
    public function uninstallDB($drop_table = true)
    {
        if (!$drop_table) {
            return true;
        }

        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'aeicmstopinfo`, `' . _DB_PREFIX_ . 'aeicmstopinfo_shop`, `' . _DB_PREFIX_ . 'aeicmstopinfo_lang`');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('saveaei_cmstop')) {
            if (!Tools::getValue('text_' . (int) Configuration::get('PS_LANG_DEFAULT'), false)) {
                $output = $this->displayError($this->trans('Please fill out all fields.', [], 'Admin.Notifications.Error'));
            } else {
                $update = $this->processSaveAEICmsTop();

                if (!$update) {
                    $output = '<div class="alert alert-danger conf error">'
                        . $this->trans('An error occurred on saving.', [], 'Admin.Notifications.Error')
                        . '</div>';
                }

                $this->_clearCache($this->templateFile);

                if ($update) {
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=4');
                }
            }
        }

        return $output . $this->renderForm();
    }

    /**
     * @return bool
     */
    public function processSaveAEICmsTop()
    {
        $shops = Tools::getValue('checkBoxShopAsso_configuration', [$this->context->shop->id]);
        $text = [];
        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $text[$lang['id_lang']] = (string) Tools::getValue('text_' . $lang['id_lang']);
        }

        $saved = true;
        foreach ($shops as $shop) {
            Shop::setContext(Shop::CONTEXT_SHOP, $shop);
            $aeicmstopinfo = new AEICmsTop(Tools::getValue('id_aeicmstopinfo', 1));
            $aeicmstopinfo->text = $text;
            $saved = $saved && $aeicmstopinfo->save();
        }

        return $saved;
    }

    /**
     * @return string
     */
    protected function renderForm()
    {
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');

        $fields_form = [
            'tinymce' => true,
            'legend' => [
                'title' => $this->trans('AX CMS Top', [], 'Modules.AEICmsTop.Admin'),
            ],
            'input' => [
                'id_aeicmstopinfo' => [
                    'type' => 'hidden',
                    'name' => 'id_aeicmstopinfo',
                ],
                'content' => [
                    'type' => 'textarea',
                    'label' => $this->trans('Text block', [], 'Modules.AEICmsTop.Admin'),
                    'lang' => true,
                    'name' => 'text',
                    'cols' => 40,
                    'rows' => 10,
                    'class' => 'rte',
                    'autoload_rte' => true,
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
        ];

        if (Shop::isFeatureActive() && Tools::getValue('id_aeicmstopinfo') == false) {
            $fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso_theme',
            ];
        }

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'aei_cmstop';
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang) {
            $helper->languages[] = [
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0),
            ];
        }

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->submit_action = 'saveaei_cmstop';

        $helper->fields_value = $this->getFormValues();

        return $helper->generateForm([['form' => $fields_form]]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormValues()
    {
        $fields_value = [];
        $idShop = $this->context->shop->id;
        $idInfo = AEICmsTop::getAEICmsTopIdByShop($idShop);

        Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
        $aeicmstopinfo = new AEICmsTop((int) $idInfo);

        $fields_value['text'] = $aeicmstopinfo->text;
        $fields_value['id_aeicmstopinfo'] = $idInfo;

        return $fields_value;
    }

    /**
     * @param string|null $hookName
     * @param array $configuration
     *
     * @return string
     */
    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('aei_cmstop'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('aei_cmstop'));
    }

    /**
     * @param string|null $hookName
     * @param array $configuration
     *
     * @return array<string, mixed>
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $aeicmsTop = new AEICmsTop(1, (int) $this->context->language->id, (int) $this->context->shop->id);
        $objectPresenter = new ObjectPresenter();
        $data = $objectPresenter->present($aeicmsTop);
        $data['id_lang'] = $this->context->language->id;
        $data['id_shop'] = $this->context->shop->id;
        unset($data['id']);

        return [
		'aeicmstopinfos' => $data,
		'image_url' => $this->context->link->getMediaLink(_MODULE_DIR_.'aei_cmstop/views/img'),
		];
    }

    /**
     * @return bool
     */
    public function installFixtures()
    {
        $return = true;
        $tabTexts = [
            [
                'text' => '<div class="cmstop">
<div class="customtext">Get upto 25% Cashback on first order :<a href="#"> GET25OFF</a></div>
</div>',
            ],
        ];

        $shopsIds = Shop::getShops(true, null, true);
        $languages = Language::getLanguages(false);
        $text = [];

        foreach ($tabTexts as $tab) {
            $aeicmstopinfo = new AEICmsTop();
            foreach ($languages as $lang) {
                $text[$lang['id_lang']] = $tab['text'];
            }
            $aeicmstopinfo->text = $text;
            $return = $return && $aeicmstopinfo->add();
        }

        if ($return && count($shopsIds) > 1) {
            foreach ($shopsIds as $idShop) {
                Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
                $aeicmstopinfo->text = $text;
                $return = $return && $aeicmstopinfo->save();
            }
        }

        return $return;
    }

    /**
     * Add AEICmsTop when adding a new Shop
     *
     * @param array{cookie: Cookie, cart: Cart, altern: int, old_id_shop: int, new_id_shop: int} $params
     */
    public function hookActionShopDataDuplication(array $params)
    {
        if ($aeicmstopinfoId = AEICmsTop::getAEICmsTopIdByShop($params['old_id_shop'])) {
            Shop::setContext(Shop::CONTEXT_SHOP, $params['old_id_shop']);
            $oldInfo = new AEICmsTop($aeicmstopinfoId);

            Shop::setContext(Shop::CONTEXT_SHOP, $params['new_id_shop']);
            $newInfo = new AEICmsTop($aeicmstopinfoId, null, $params['new_id_shop']);
            $newInfo->text = $oldInfo->text;

            $newInfo->save();
        }
    }
}
