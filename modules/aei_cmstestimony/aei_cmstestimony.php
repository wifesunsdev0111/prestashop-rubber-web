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

require_once _PS_MODULE_DIR_ . 'aei_cmstestimony/classes/AEICmsTestimony.php';
class Aei_Cmstestimony extends Module implements WidgetInterface
{
    // Equivalent module on PrestaShop 1.6, sharing the same data
    const MODULE_16 = 'blockcmsinfo';

    /**
     * @var string Template used by widget
     */
    private $templateFile;

    public function __construct()
    {
        $this->name = 'aei_cmstestimony';
        $this->author = 'Aeipix';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        Shop::addTableAssociation('aeicmstestimonyinfo', ['type' => 'shop']);

        $this->displayName = $this->trans('AX Testimonial CMS', [], 'Modules.AEICmsTestimony.Admin');
        $this->description = $this->trans('Add Testimonial block on your store.', [], 'Modules.AEICmsTestimony.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.4.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:aei_cmstestimony/views/templates/hook/aei_cmstestimony.tpl';
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
            && $this->registerHook('displayHome')
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
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstestimonyinfo` (
                `id_aeicmstestimonyinfo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_aeicmstestimonyinfo`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstestimonyinfo_shop` (
                `id_aeicmstestimonyinfo` INT(10) UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`id_aeicmstestimonyinfo`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return = $return && Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aeicmstestimonyinfo_lang` (
                `id_aeicmstestimonyinfo` INT UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                `id_lang` INT(10) UNSIGNED NOT NULL ,
                `text` text NOT NULL,
                PRIMARY KEY (`id_aeicmstestimonyinfo`, `id_lang`, `id_shop`)
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

        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'aeicmstestimonyinfo`, `' . _DB_PREFIX_ . 'aeicmstestimonyinfo_shop`, `' . _DB_PREFIX_ . 'aeicmstestimonyinfo_lang`');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('saveaei_cmstestimony')) {
            if (!Tools::getValue('text_' . (int) Configuration::get('PS_LANG_DEFAULT'), false)) {
                $output = $this->displayError($this->trans('Please fill out all fields.', [], 'Admin.Notifications.Error'));
            } else {
                $update = $this->processSaveAEICmsTestimony();

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
    public function processSaveAEICmsTestimony()
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
            $aeicmstestimonyinfo = new AEICmsTestimony(Tools::getValue('id_aeicmstestimonyinfo', 1));
            $aeicmstestimonyinfo->text = $text;
            $saved = $saved && $aeicmstestimonyinfo->save();
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
                'title' => $this->trans('AX Testimonial CMS', [], 'Modules.AEICmsTestimony.Admin'),
            ],
            'input' => [
                'id_aeicmstestimonyinfo' => [
                    'type' => 'hidden',
                    'name' => 'id_aeicmstestimonyinfo',
                ],
                'content' => [
                    'type' => 'textarea',
                    'label' => $this->trans('Text block', [], 'Modules.AEICmsTestimony.Admin'),
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

        if (Shop::isFeatureActive() && Tools::getValue('id_aeicmstestimonyinfo') == false) {
            $fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso_theme',
            ];
        }

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'aei_cmstestimony';
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
        $helper->submit_action = 'saveaei_cmstestimony';

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
        $idInfo = AEICmsTestimony::getAEICmsTestimonyIdByShop($idShop);

        Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
        $aeicmstestimonyinfo = new AEICmsTestimony((int) $idInfo);

        $fields_value['text'] = $aeicmstestimonyinfo->text;
        $fields_value['id_aeicmstestimonyinfo'] = $idInfo;

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
        if (!$this->isCached($this->templateFile, $this->getCacheId('aei_cmstestimony'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('aei_cmstestimony'));
    }

    /**
     * @param string|null $hookName
     * @param array $configuration
     *
     * @return array<string, mixed>
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $aeicmsTestimony = new AEICmsTestimony(1, (int) $this->context->language->id, (int) $this->context->shop->id);
        $objectPresenter = new ObjectPresenter();
        $data = $objectPresenter->present($aeicmsTestimony);
        $data['id_lang'] = $this->context->language->id;
        $data['id_shop'] = $this->context->shop->id;
        unset($data['id']);

        return [
		'aeicmstestimonyinfos' => $data,
		'image_url' => $this->context->link->getMediaLink(_MODULE_DIR_.'aei_cmstestimony/views/img'),
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
                'text' => '<div id="aeicmstestimony" class="testimony-block">
<h1 class="h1 ax-product-title">What People Says</h1>
<ul id="aeitestimony-carousel" class="aeitestimony-carousel product_list">
<li class="item">
<div class="owl-item">
<div class="item cms_face">
<div class="test-left">
<div class="testmonial-image">
<img alt="testmonial" title="testmonial" src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/person1.png" />
</div>
<div class="test-image-desc">
<div class="icon"><img src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/icon.png""></div>
<div class="name"><a href="#">Mack Jeckno</a></div>
<div class="designation"><a title="Iphone Developer" href="#">Designer</a></div>
</div>
</div>
<div class="product_inner_cms">
<div class="desc">
<p>We have compiled few guidelines for you to keep your bags in its best possible state and retain its stunning, antique look even after many years of usage.</p>
</div>
</div>
</div>
</div>
</li>
<li class="item">
<div class="owl-item">
<div class="item cms_face">
<div class="test-left">
<div class="testmonial-image">
<img alt="testmonial" title="testmonial" src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/person2.png" />
</div>
<div class="test-image-desc">
<div class="icon"><img src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/icon.png""></div>
<div class="name"><a href="#">leesa charls</a></div>
<div class="designation"><a title="Iphone Developer" href="#">Iphone Developer</a></div>
</div>
</div>
<div class="product_inner_cms">
<div class="desc">
<p>We have compiled few guidelines for you to keep your bags in its best possible state and retain its stunning, antique look even after many years of usage.</p>
</div>
</div>
</div>
</div>
</li>
<li class="item">
<div class="owl-item">
<div class="item cms_face">
<div class="test-left">
<div class="testmonial-image">
<img alt="testmonial" title="testmonial" src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/person3.png" />
</div>
<div class="test-image-desc">
<div class="icon"><img src="https://demoprestashop.aeipix.com/AX01/kenzy13/modules/aei_cmstestimony/views/img/icon.png""></div>
<div class="name"><a href="#">jecob goeckno</a></div>
<div class="designation"><a title="Iphone Developer" href="#">Web Developer</a></div>
</div>
</div>
<div class="product_inner_cms">
<div class="desc">
<p>We have compiled few guidelines for you to keep your bags in its best possible state and retain its stunning, antique look even after many years of usage.</p>
</div>
</div>
</div>
</div>
</li>
</ul>
</div>',
            ],
        ];

        $shopsIds = Shop::getShops(true, null, true);
        $languages = Language::getLanguages(false);
        $text = [];

        foreach ($tabTexts as $tab) {
            $aeicmstestimonyinfo = new AEICmsTestimony();
            foreach ($languages as $lang) {
                $text[$lang['id_lang']] = $tab['text'];
            }
            $aeicmstestimonyinfo->text = $text;
            $return = $return && $aeicmstestimonyinfo->add();
        }

        if ($return && count($shopsIds) > 1) {
            foreach ($shopsIds as $idShop) {
                Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
                $aeicmstestimonyinfo->text = $text;
                $return = $return && $aeicmstestimonyinfo->save();
            }
        }

        return $return;
    }

    /**
     * Add AEICmsTestimony when adding a new Shop
     *
     * @param array{cookie: Cookie, cart: Cart, altern: int, old_id_shop: int, new_id_shop: int} $params
     */
    public function hookActionShopDataDuplication(array $params)
    {
        if ($aeicmstestimonyinfoId = AEICmsTestimony::getAEICmsTestimonyIdByShop($params['old_id_shop'])) {
            Shop::setContext(Shop::CONTEXT_SHOP, $params['old_id_shop']);
            $oldInfo = new AEICmsTestimony($aeicmstestimonyinfoId);

            Shop::setContext(Shop::CONTEXT_SHOP, $params['new_id_shop']);
            $newInfo = new AEICmsTestimony($aeicmstestimonyinfoId, null, $params['new_id_shop']);
            $newInfo->text = $oldInfo->text;

            $newInfo->save();
        }
    }
}
