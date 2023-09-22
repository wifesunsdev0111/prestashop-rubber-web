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

require_once _PS_MODULE_DIR_ . 'aei_cmsservice/classes/AEICmsService.php';
class Aei_Cmsservice extends Module implements WidgetInterface
{
    // Equivalent module on PrestaShop 1.6, sharing the same data
    const MODULE_16 = 'blockcmsinfo';

    /**
     * @var string Template used by widget
     */
    private $templateFile;

    public function __construct()
    {
        $this->name = 'aei_cmsservice';
        $this->author = 'Aeipix';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        Shop::addTableAssociation('aeicmsserviceinfo', ['type' => 'shop']);

        $this->displayName = $this->trans('AX Service', [], 'Modules.AEICmsService.Admin');
        $this->description = $this->trans('Add Service on your store.', [], 'Modules.AEICmsService.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.4.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:aei_cmsservice/views/templates/hook/aei_cmsservice.tpl';
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
            && $this->registerHook('displayTopColumn')
			&& $this->registerHook('displayHeader')
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
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmsserviceinfo` (
                `id_aeicmsserviceinfo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_aeicmsserviceinfo`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmsserviceinfo_shop` (
                `id_aeicmsserviceinfo` INT(10) UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`id_aeicmsserviceinfo`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmsserviceinfo_lang` (
                `id_aeicmsserviceinfo` INT UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                `id_lang` INT(10) UNSIGNED NOT NULL ,
                `text` text NOT NULL,
                PRIMARY KEY (`id_aeicmsserviceinfo`, `id_lang`, `id_shop`)
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

        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'aeicmsserviceinfo`, `' . _DB_PREFIX_ . 'aeicmsserviceinfo_shop`, `' . _DB_PREFIX_ . 'aeicmsserviceinfo_lang`');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('saveaei_cmsservice')) {
            if (!Tools::getValue('text_' . (int) Configuration::get('PS_LANG_DEFAULT'), false)) {
                $output = $this->displayError($this->trans('Please fill out all fields.', [], 'Admin.Notifications.Error'));
            } else {
                $update = $this->processSaveAEICmsService();

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
    public function processSaveAEICmsService()
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
            $aeicmsserviceinfo = new AEICmsService(Tools::getValue('id_aeicmsserviceinfo', 1));
            $aeicmsserviceinfo->text = $text;
            $saved = $saved && $aeicmsserviceinfo->save();
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
                'title' => $this->trans('AX Service', [], 'Modules.AEICmsService.Admin'),
            ],
            'input' => [
                'id_aeicmsserviceinfo' => [
                    'type' => 'hidden',
                    'name' => 'id_aeicmsserviceinfo',
                ],
                'content' => [
                    'type' => 'textarea',
                    'label' => $this->trans('Text block', [], 'Modules.AEICmsService.Admin'),
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

        if (Shop::isFeatureActive() && Tools::getValue('id_aeicmsserviceinfo') == false) {
            $fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso_theme',
            ];
        }

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'aei_cmsservice';
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
        $helper->submit_action = 'saveaei_cmsservice';

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
        $idInfo = AEICmsService::getAEICmsServiceIdByShop($idShop);

        Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
        $aeicmsserviceinfo = new AEICmsService((int) $idInfo);

        $fields_value['text'] = $aeicmsserviceinfo->text;
        $fields_value['id_aeicmsserviceinfo'] = $idInfo;

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
        if (!$this->isCached($this->templateFile, $this->getCacheId('aei_cmsservice'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('aei_cmsservice'));
    }

    /**
     * @param string|null $hookName
     * @param array $configuration
     *
     * @return array<string, mixed>
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $aeicmsService = new AEICmsService(1, (int) $this->context->language->id, (int) $this->context->shop->id);
        $objectPresenter = new ObjectPresenter();
        $data = $objectPresenter->present($aeicmsService);
        $data['id_lang'] = $this->context->language->id;
        $data['id_shop'] = $this->context->shop->id;
        unset($data['id']);

        return [
		'aeicmsserviceinfos' => $data,
		'image_url' => $this->context->link->getMediaLink(_MODULE_DIR_.'aei_cmsservice/views/img'),
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
                'text' => '<ul id="service-item">

<li class="aei-service-item first">
<a class="aei-service-item-inner" href="#">
<span class="aei-image-block"><span class="aei-image-icon">&nbsp;</span></span>
<span class="service-right">
<span class="aei-service-title">Lowest Price guarantee</span>
</span>
</a>
</li>
<li class="aei-service-item second">
<a class="aei-service-item-inner" href="#">
<span class="aei-image-block"><span class="aei-image-icon">&nbsp;</span></span>
<span class="service-right">
<span class="aei-service-title">online support 24/7</span>
</span>
</a>
</li>
<li class="aei-service-item third">
<a class="aei-service-item-inner" href="#">
<span class="aei-image-block"><span class="aei-image-icon">&nbsp;</span></span>
<span class="service-right">
<span class="aei-service-title">Eassy Return policy</span>
</span>
</a>
</li>
<li class="aei-service-item fourth">
<a class="aei-service-item-inner" href="#">
<span class="aei-image-block"><span class="aei-image-icon">&nbsp;</span></span>
<span class="service-right">
<span class="aei-service-title">Free World Shipping</span>
</span>
</a>
</li>
</ul>',
            ],
        ];

        $shopsIds = Shop::getShops(true, null, true);
        $languages = Language::getLanguages(false);
        $text = [];

        foreach ($tabTexts as $tab) {
            $aeicmsserviceinfo = new AEICmsService();
            foreach ($languages as $lang) {
                $text[$lang['id_lang']] = $tab['text'];
            }
            $aeicmsserviceinfo->text = $text;
            $return = $return && $aeicmsserviceinfo->add();
        }

        if ($return && count($shopsIds) > 1) {
            foreach ($shopsIds as $idShop) {
                Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
                $aeicmsserviceinfo->text = $text;
                $return = $return && $aeicmsserviceinfo->save();
            }
        }

        return $return;
    }

    /**
     * Add AEICmsService when adding a new Shop
     *
     * @param array{cookie: Cookie, cart: Cart, altern: int, old_id_shop: int, new_id_shop: int} $params
     */
    public function hookActionShopDataDuplication(array $params)
    {
        if ($aeicmsserviceinfoId = AEICmsService::getAEICmsServiceIdByShop($params['old_id_shop'])) {
            Shop::setContext(Shop::CONTEXT_SHOP, $params['old_id_shop']);
            $oldInfo = new AEICmsService($aeicmsserviceinfoId);

            Shop::setContext(Shop::CONTEXT_SHOP, $params['new_id_shop']);
            $newInfo = new AEICmsService($aeicmsserviceinfoId, null, $params['new_id_shop']);
            $newInfo->text = $oldInfo->text;

            $newInfo->save();
        }
    }
}
