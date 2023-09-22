<?php

/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2018 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class PsAgeChecker extends \Module
{
    public $css_path;
    public $js_path;
    public $controller_name;
    public $author_address;
    public $bootstrap;
    public $output;
    public $ps_version;
    public $img_path;
    public $docs_path;
    public $logo_path;
    public $module_path;
    public $slides_path;
    public $slides_url;
    public $confirmUninstall;

    private $settings_conf = array(
        'show_popup' => 'PS_AGE_CHECKER_SHOW_POPUP',
        'minimum_age' => 'PS_AGE_CHECKER_AGE_MINIMUM',
        'verification_method' => 'PS_AGE_CHECKER_VERIFICATION_METHOD',
        'number_columns' => 'PS_AGE_CHECKER_NUMBER_COLUMNS',
        'select_fonts' => 'PS_AGE_CHECKER_FONTS',
        'custom_title' => 'PS_AGE_CHECKER_CUSTOM_TITLE',
        'custom_msg' => 'PS_AGE_CHECKER_CUSTOM_MSG',
        'deny_msg' => 'PS_AGE_CHECKER_DENY_MSG',
        'confirm_button_text' => 'PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT',
        'deny_button_text' => 'PS_AGE_CHECKER_DENY_BUTTON_TEXT',
        'popup_height' => 'PS_AGE_CHECKER_POPUP_HEIGHT',
        'popup_width' => 'PS_AGE_CHECKER_POPUP_WIDTH',
        'background_color' => 'PS_AGE_CHECKER_BACKGROUND_COLOR',
        'opacity_slider' => 'PS_AGE_CHECKER_OPACITY',
        'show_image' => 'PS_AGE_CHECKER_SHOW_IMAGE',
        'image' => 'slide-image',
        'confirm_button_bground_color' => 'PS_AGE_CHECKER_CONFIRM_BUTTON_BACKGROUND_COLOR',
        'confirm_button_text_color' => 'PS_AGE_CHECKER_CONFIRM_BUTTON_TXT_COLOR',
        'deny_button_bground_color' => 'PS_AGE_CHECKER_DENY_BUTTON_BACKGROUND_COLOR',
        'deny_button_text_color' => 'PS_AGE_CHECKER_DENY_BUTTON_TXT_COLOR',
    );

    public $fontsCss = array(
        'https://fonts.googleapis.com/css?family=Roboto', // font-family: 'Roboto', sans-serif;
        'https://fonts.googleapis.com/css?family=Hind', // font-family: 'Hind', sans-serif;
        'https://fonts.googleapis.com/css?family=Maven+Pro', // font-family: 'Maven Pro', sans-serif;
        'https://fonts.googleapis.com/css?family=Noto+Serif', // font-family: 'Noto Serif', serif;
        'https://fonts.googleapis.com/css?family=Bitter', // font-family: 'Bitter', serif;
        'https://fonts.googleapis.com/css?family=Forum', // font-family: 'Forum', serif;
    );

    public $fonts = array(1 => 'Roboto', 2 => 'Hind', 3 => 'Maven Pro', 4 => 'Noto Serif', 5 => 'Bitter', 6 => 'Forum');

    public function __construct()
    {
        // Settings
        $this->name = 'psagechecker';
        $this->tab = 'social_networks';
        $this->version = '1.1.1';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;

        $this->module_key = 'eed93aa31215a587fa9f9584f6f9105a';
        $this->author_address = '0x64aa3c1e4034d07015f639b0e171b0d7b27d01aa';

        $this->controller_name = 'AdminAjaxpsagechecker';

        // bootstrap -> always set to true
        $this->bootstrap = true;

        parent::__construct();

        $this->output = '';

        $this->displayName = $this->l('Age Verification Popup');
        $this->description = $this->l('This module allows you to check your visitors age by displaying an age verification popup as soon as they reach your store');
        $this->ps_version = (bool) version_compare(_PS_VERSION_, '1.7', '>=');

        // Settings paths
        $this->js_path = $this->_path . 'views/js/';
        $this->css_path = $this->_path . 'views/css/';
        $this->img_path = $this->_path . 'views/img/';
        $this->docs_path = $this->_path . 'docs/';
        $this->logo_path = $this->_path . 'logo.png';
        $this->module_path = $this->_path;
        $this->slides_path = dirname(__FILE__) . '/img/';
        $this->slides_url = $this->_path . '/img/';

        // Confirm uninstall
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->controller_name = 'AdminAjaxPsAgeChecker';
    }

    /**
     * install()
     *
     * @return bool
     */
    public function install()
    {
        \Configuration::updateValue('PS_AGE_CHECKER_SHOW_POPUP', '0');
        \Configuration::updateValue('PS_AGE_CHECKER_AGE_MINIMUM', '18');
        \Configuration::updateValue('PS_AGE_CHECKER_METHOD', '0');
        \Configuration::updateValue('PS_AGE_CHECKER_POPUP_HEIGHT', '400');
        \Configuration::updateValue('PS_AGE_CHECKER_POPUP_WIDTH', '500');
        \Configuration::updateValue('PS_AGE_CHECKER_OPACITY', '70');
        \Configuration::updateValue('PS_AGE_CHECKER_CONFIRM_BUTTON_BACKGROUND_COLOR', '#006211');
        \Configuration::updateValue('PS_AGE_CHECKER_DENY_BUTTON_BACKGROUND_COLOR', '#686868');
        \Configuration::updateValue('PS_AGE_CHECKER_BACKGROUND_COLOR', '#3b3b3b');
        \Configuration::updateValue('PS_AGE_CHECKER_CONFIRM_BUTTON_TXT_COLOR', '#ffffff');
        \Configuration::updateValue('PS_AGE_CHECKER_DENY_BUTTON_TXT_COLOR', '#ffffff');
        \Configuration::updateValue('PS_AGE_CHECKER_SHOW_IMAGE', '0');
        $now = new \DateTime('now');
        \Configuration::updateValue('PS_AGE_CHECKER_DATE_INSTALL', $now->format('Y-m-d H:i:s'));
        \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE', 'false');
        \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES', '');
        \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS', '');

        $values = array();
        $languages = \Language::getLanguages(false);
        foreach ($languages as $lang) {
            $values['PS_AGE_CHECKER_CUSTOM_TITLE'][$lang['id_lang']] = '<h1 style="#7d7d7d">The access of this website is not granted to underage users</h1>';
            $values['PS_AGE_CHECKER_CUSTOM_MSG'][$lang['id_lang']] = '<p><span style="color:#7d7d7d">In order to enter this site, please certify that you are of legal age to access a shop selling age restricted products</p></span>';
            $values['PS_AGE_CHECKER_DENY_MSG'][$lang['id_lang']] = '<p><span style="color:#7d7d7d">SORRY, you don\'t have legal age to access to our website</p></span>';
            $values['PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT'][$lang['id_lang']] = 'I’m over 18, enter';
            $values['PS_AGE_CHECKER_DENY_BUTTON_TEXT'][$lang['id_lang']] = 'I’m underage';
        }
        \Configuration::updateValue('PS_AGE_CHECKER_CUSTOM_TITLE', $values['PS_AGE_CHECKER_CUSTOM_TITLE']);
        \Configuration::updateValue('PS_AGE_CHECKER_CUSTOM_MSG', $values['PS_AGE_CHECKER_CUSTOM_MSG']);
        \Configuration::updateValue('PS_AGE_CHECKER_DENY_MSG', $values['PS_AGE_CHECKER_DENY_MSG']);
        \Configuration::updateValue('PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT', $values['PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT']);
        \Configuration::updateValue('PS_AGE_CHECKER_DENY_BUTTON_TEXT', $values['PS_AGE_CHECKER_DENY_BUTTON_TEXT']);

        // register hook used by the module
        if (parent::install() &&
            $this->installTab() &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayFooterProduct')
        ) {
            if ($this->ps_version) {
                $this->registerHook('actionFrontControllerSetMedia');
            } else {
                $this->registerHook('header');
            }

            return true;
        } else {
            $this->_errors[] = $this->l('There was an error during the uninstallation. Please contact us through Addons website.');

            return false;
        }
    }

    /**
     * uninstall()
     *
     * @return bool
     */
    public function uninstall()
    {
        foreach ($this->settings_conf as $value) {
            \Configuration::deleteByName($value);
        }

        \Configuration::deleteByName('PS_AGE_CHECKER_DATE_INSTALL');
        \Configuration::deleteByName('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE');
        \Configuration::deleteByName('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES');
        \Configuration::deleteByName('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS');

        // unregister hook
        if (parent::uninstall() &&
            $this->uninstallTab()) {
            return true;
        } else {
            $this->_errors[] = $this->l('There was an error during the desinstallation. Please contact us through Addons website');

            return false;
        }

        return parent::uninstall();
    }

    /**
     * installTab()
     *
     * @return bool
     */
    public function installTab()
    {
        $tab = new \Tab();
        $tab->active = true;
        $tab->class_name = $this->controller_name;
        $tab->name = array();
        foreach (\Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->name;
        }
        $tab->id_parent = -1;
        $tab->module = $this->name;
        $result = $tab->add();

        return (bool) $result;
    }

    /**
     * uninstall tab
     *
     * @return bool
     */
    public function uninstallTab()
    {
        $id_tab = (int) \Tab::getIdFromClassName($this->controller_name);

        if ($id_tab) {
            $tab = new \Tab($id_tab);

            if (\Validate::isLoadedObject($tab)) {
                return $tab->delete();
            } else {
                $return = false;
            }
        } else {
            $return = true;
        }

        return $return;
    }

    /**
     * load dependencies
     */
    public function loadAsset()
    {
        $controller = $this->context->controller;
        // Load CSS
        $css = array(
            $this->css_path . 'font-awesome.min.css',
            $this->css_path . 'faq.css',
            $this->css_path . 'menu.css',
            $this->css_path . 'bootstrap-slider.css',
            $this->css_path . 'back.css',
            $this->css_path . 'select2.min.css',
            $this->css_path . 'select2-bootstrap.min.css',
            $this->css_path . $this->name . '.css',
            $this->fontsCss,
            $this->css_path . 'front.css',
            $this->css_path . 'jstree.min.css',
        );

        $this->context->controller->addCSS($css, 'all');

        // Load JS
        $jss = array(
            $this->js_path . 'vue.min.js',
            $this->js_path . 'vue-paginate.min.js',
            $this->js_path . 'faq.js',
            $this->js_path . 'menu.js',
            $this->js_path . 'bootstrap-slider.js',
            $this->js_path . 'back.js',
            $this->js_path . 'sweetalert.min.js',
            $this->js_path . 'select2.full.min.js',
            $this->js_path . 'jstree.min.js',
            _PS_ROOT_DIR_ . 'js/tiny_mce/tiny_mce.js',
            _PS_ROOT_DIR_ . 'js/admin/tinymce.inc.js',
        );

        // prestashop plugin
        //$controller->addJqueryPlugin('select2');
        $controller->addJqueryPlugin('colorpicker');

        $this->context->controller->addJS($jss);

        // Clean memory
        unset($jss, $css);

        \Media::addJsDef(array(
            'AjaxPsAgeCheckerController' => $this->context->link->getAdminLink('AdminAjaxPsAgeChecker'),
            'PS_HOME_CATEGORY' => \Configuration::get('PS_HOME_CATEGORY'),
        ));
    }

    /**
     * FAQ API
     */
    public function loadFaq()
    {
        require_once 'classes/ApiFaq.php';
        $api = new PrestaShop\Modules\PsAgeChecker\ApiFaq();
        $faq = $api->getData($this->module_key, $this->version);

        return $faq;
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        if ($this->ps_version) {
            $params = array('configure' => $this->name);
            $apiCallback = $this->context->link->getAdminLink('AdminModules', true, false, $params);
        } else {
            $apiCallback = _PS_BASE_URL_ . '/' . $this->context->controller->admin_webpath . '/' . $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&module_name=' . $this->name;
        }

        $faq = $this->loadFaq();
        $this->loadAsset();
        $this->postProcess();

        // some stuff useful in smarty
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if ($this->ps_version) {
            $params = array('configure' => $this->name);
            $moduleAdminLink = $this->context->link->getAdminLink('AdminModules', true, false, $params);
        } else {
            $moduleAdminLink = $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&module_name=' . $this->name;
        }
        // controller ajax url
        $link = new \Link();
        $controller_url = $link->getAdminLink($this->controller_name);

        // get readme
        $iso_lang = \Language::getIsoById($id_lang);
        $doc = $this->docs_path . 'readme_' . $iso_lang . '.pdf';

        // get tuto
        $iso_lang = \Language::getIsoById($id_lang);
        $tuto = $this->docs_path . 'tuto/tuto_' . $iso_lang . '.pdf';

        // get current page
        $currentPage = 'conf';
        $page = \Tools::getValue('page');
        if (!empty($page)) {
            $currentPage = \Tools::getValue('page');
        }

        $tmp = array();
        $languages = \Language::getLanguages(false);
        foreach ($this->settings_conf as $index => $value) {
            if ($value === 'PS_AGE_CHECKER_CUSTOM_TITLE'
                || $value === 'PS_AGE_CHECKER_CUSTOM_MSG'
                || $value === 'PS_AGE_CHECKER_DENY_MSG'
                || $value === 'PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT'
                || $value === 'PS_AGE_CHECKER_DENY_BUTTON_TEXT'
            ) {
                foreach ($languages as $lang) {
                    $tmp[$value][$lang['id_lang']] = \Configuration::get($value, $lang['id_lang']);
                    $this->context->smarty->assign($index, $tmp[$value]);
                }
            } else {
                $tmp[$value] = \Configuration::get($value);
                $this->context->smarty->assign($index, $tmp[$value]);
            }
        }

        $popupDisplaySelectedProducts = array();
        $configDisplaySelectedProducts = \Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS');

        foreach (explode(',', $configDisplaySelectedProducts) as $idProduct) {
            $products = new \PrestaShopCollection('Product', $id_lang);
            $products->where('id_product', '=', $idProduct);
            /** @var \Product $product */
            $product = $products->getFirst();
            if (false != $product) {
                $idImage = $product->getCover($idProduct);
                $imgLink = \Tools::getProtocol() . $link->getImageLink($product->link_rewrite, $idImage['id_image'], ImageType::getFormatedName('large'));
                $product->imgLink = $imgLink;
                $popupDisplaySelectedProducts[] = $product;
            }
        }

        $popupDisplaySelectedCategories = array();
        $configDisplaySelectedCategories = \Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES');
        foreach (explode(',', $configDisplaySelectedCategories) as $idCategory) {
            $category = new \PrestaShopCollection('Category', $id_lang);
            $category->where('id_category', '=', $idCategory);
            $category = $category->getFirst();
            if (false !== $category) {
                $popupDisplaySelectedCategories[] = $category;
            }
        }

        $showRateModule = \DateTime::createFromFormat('Y-m-d H:i:s', \Configuration::get('PS_AGE_CHECKER_DATE_INSTALL'));
        $now = new \DateTime('now');

        $showRateModule = (int) $now->diff($showRateModule)->format('%a') > 7 && (int) $now->diff($showRateModule)->format('%a') < 92;

        // assign var to smarty
        $this->context->smarty->assign(array(
            'api_redirect_url' => $apiCallback,
            'module_name' => $this->name,
            'id_shop' => $id_shop,
            'module_version' => $this->version,
            'moduleAdminLink' => $moduleAdminLink,
            'id_lang' => $id_lang,
            'controller_url' => $controller_url,
            'apifaq' => $faq,
            'doc' => $doc,
            'tuto' => $tuto,
            'module_display' => $this->displayName,
            'module_path' => $this->module_path,
            'logo_path' => $this->logo_path,
            'img_path' => $this->img_path,
            'languages' => $this->context->controller->getLanguages(),
            'currentLangIsoCode' => $this->context->language->iso_code,
            'defaultFormLanguage' => (int) $this->context->employee->id_lang,
            'currentPage' => $currentPage,
            'ps_base_dir' => _PS_BASE_URL_,
            'ps_version' => _PS_VERSION_,
            'isPs17' => $this->ps_version,
            'fonts' => $this->fonts,
            'PS_AGE_CHECKER_OPACITY' => 1,
            'popupDisplaySelectedEverywhere' => \Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE'),
            'popupDisplaySelectedProducts' => $popupDisplaySelectedProducts,
            'configDisplaySelectedProducts' => $configDisplaySelectedProducts,
            'popupDisplaySelectedCategories' => $popupDisplaySelectedCategories,
            'configDisplaySelectedCategories' => $configDisplaySelectedCategories,
            'showRateModule' => $showRateModule,
        ));

        $this->output .= $this->context->smarty->fetch($this->local_path . 'views/templates/admin/menu.tpl');

        return $this->output;
    }

    /**
     * postProcess
     * Handle post data from the configuration
     */
    public function postProcess()
    {
        if (\Tools::isSubmit('submitpsagecheckerModule')) {
            $errors = array();
            $languages = \Language::getLanguages(false);
            $nbErrors = 0;
            if ($nbErrors == 0) {
                foreach ($this->settings_conf as $value) {
                    if ($value === 'PS_AGE_CHECKER_CUSTOM_TITLE'
                        || $value === 'PS_AGE_CHECKER_CUSTOM_MSG'
                        || $value === 'PS_AGE_CHECKER_DENY_MSG'
                        || $value === 'PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT'
                        || $value === 'PS_AGE_CHECKER_DENY_BUTTON_TEXT'
                    ) {
                        $values = array();
                        foreach ($languages as $lang) {
                            $values[$value][$lang['id_lang']] = \Tools::getValue($value . '_' . $lang['id_lang']);
                        }
                        \Configuration::updateValue($value, $values[$value], true);
                    } else {
                        \Configuration::updateValue($value, \Tools::getValue($value));
                    }
                }
                $this->output .= $this->displayConfirmation($this->l('Saved with success !'));
            } else {
                $this->output .= $this->displayError($errors);
            }

            if (empty($_FILES['image']['name']) && empty($_FILES['image']['size'])) {
                $langIsoCode = Language::getIsoById($this->context->language->id);
                $errors[] = $this->l('You need to upload an image before saving the slide') . ' (' . $langIsoCode . ')';
            } elseif (empty(\Tools::getValue('slide-image'))) {
                $langIsoCode = Language::getIsoById($this->context->language->id);
                $errors[] = $this->l('You need to upload an image before saving the slide') . ' (' . $langIsoCode . ')';
            } else {
                $filename = str_replace(' ', '', $_FILES['image']['name']);
                $type = \Tools::strtolower(\Tools::substr(strrchr($filename, '.'), 1));
                $imagesize = @getimagesize($_FILES['image']['tmp_name']);
                if (isset($_FILES['image']) &&
                    isset($_FILES['image']['tmp_name']) &&
                    !empty($_FILES['image']['tmp_name']) &&
                    !empty($imagesize) &&
                    in_array(\Tools::strtolower(\Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) &&
                    in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                ) {
                    if ($error = \ImageManager::validateUpload($_FILES['image'])) {
                        $errors[] = $error;
                    } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $this->slides_path . $filename)) {
                        $errors[] = $this->l('Error on upload.');
                    }
                    \Configuration::updateValue('PS_AGE_CHECKER_IMG', $filename);
                } else {
                    if (!empty($_FILES['image']['tmp_name'])) {
                        $errors[] = $this->l('Only .jpg .gif .jpeg .png formats are allowed');
                    }
                }
                if (empty($errors)) {
                    $this->output .= $this->displayConfirmation($this->l('Saved with success !'));
                } else {
                    $this->output .= $this->displayError($errors);
                }
            }

            \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE', \Tools::getValue('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE'));
            \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES', \Tools::getValue('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES'));
            \Configuration::updateValue('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS', \Tools::getValue('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS'));
        }
    }

    /**
     * hookdisplayTop
     *
     * @return void|string
     */
    public function hookDisplayTop()
    {
        if ($this->currentPageIsUnderAgeChecker()) {
            return $this->showPopupInHook();
        }
    }

    /**
     * currentPageIsUnderAgeChecker
     * Check if current page need to load the age checker popin
     *
     * @return bool
     */
    private function currentPageIsUnderAgeChecker()
    {
        $actif = \Configuration::get('PS_AGE_CHECKER_SHOW_POPUP');

        if ($actif != 0) {
            if (\Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE') == 'true') {
                return true;
            } else {
                $controllerType = $this->context->controller->php_self;

                if ($controllerType == 'category') {
                    $categories = \Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES');
                    /** @var \CategoryController $controller */
                    $controller = $this->context->controller;
                    $currentCategoryId = $controller->getCategory()->id;

                    foreach (explode(',', $categories) as $category) {
                        if ($category == $currentCategoryId) {
                            return true;
                        }
                    }
                }

                if ($controllerType == 'product') {
                    $products = \Configuration::get('PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS');
                    /** @var \ProductController $controller */
                    $controller = $this->context->controller;
                    $currentProductId = $controller->getProduct()->id;

                    foreach (explode(',', $products) as $product) {
                        if ($product == $currentProductId) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * showPopupInHook
     *
     * @return string
     */
    public function showPopupInHook()
    {
        $this->loadFrontAsset();
        $this->displayWall();

        return $this->display(__FILE__, 'views/templates/hook/displayWall.tpl');
    }

    public function displayWall()
    {
        $this->context->controller->addCSS($this->fontsCss);
        $shop = new \Shop((int) $this->context->shop->id);
        $id_lang = $this->context->language->id;
        $img = $this->slides_url . '/' . \Configuration::get('PS_AGE_CHECKER_IMG');

        $this->context->smarty->assign(array(
            'opacity' => \Configuration::get('PS_AGE_CHECKER_OPACITY') / 100,
            'show_img' => \Configuration::get('PS_AGE_CHECKER_SHOW_IMAGE'),
            'img_upload' => $img,
            'display_popup' => \Configuration::get('PS_AGE_CHECKER_SHOW_POPUP'),
            'age_required' => \Configuration::get('PS_AGE_CHECKER_AGE_MINIMUM'),
            'method' => \Configuration::get('PS_AGE_CHECKER_VERIFICATION_METHOD'),
            'popup_width' => \Configuration::get('PS_AGE_CHECKER_POPUP_WIDTH'),
            'popup_height' => \Configuration::get('PS_AGE_CHECKER_POPUP_HEIGHT'),
            'deny_txt_color' => \Configuration::get('PS_AGE_CHECKER_DENY_BUTTON_TXT_COLOR'),
            'confirm_txt_color' => \Configuration::get('PS_AGE_CHECKER_CONFIRM_BUTTON_TXT_COLOR'),
            'deny_bg_color' => \Configuration::get('PS_AGE_CHECKER_DENY_BUTTON_BACKGROUND_COLOR'),
            'confirm_bg_color' => \Configuration::get('PS_AGE_CHECKER_CONFIRM_BUTTON_BACKGROUND_COLOR'),
            'font_family' => \Configuration::get('PS_AGE_CHECKER_FONTS'),
            'popup_bg_color' => \Configuration::get('PS_AGE_CHECKER_BACKGROUND_COLOR'),
            'custom_tit' => \Configuration::get('PS_AGE_CHECKER_CUSTOM_TITLE', $id_lang),
            'custom_msg' => \Configuration::get('PS_AGE_CHECKER_CUSTOM_MSG', $id_lang),
            'deny_msg' => \Configuration::get('PS_AGE_CHECKER_DENY_MSG', $id_lang),
            'confirm_button' => \Configuration::get('PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT', $id_lang),
            'deny_button' => \Configuration::get('PS_AGE_CHECKER_DENY_BUTTON_TEXT', $id_lang),
            'column' => \Configuration::get('PS_INSTA_NUMBER_COLUMNS'),
            'base_url' => $shop->getBaseURL(),
            'header' => 0,
        ));
    }

    // load css and js in front -> ps16 only
    public function loadFrontAsset()
    {
        if (!$this->ps_version) {
            if ($this->currentPageIsUnderAgeChecker()) {
                $this->context->controller->addCSS($this->css_path . 'front.css');
                $this->context->controller->addJS($this->js_path . 'front.js');
                $this->context->controller->addJS($this->js_path . 'bootstrap-slider.js');
            }
        }
    }

    // load css and js in front -> ps17 only
    public function hookActionFrontControllerSetMedia()
    {
        if ($this->ps_version) {
            if ($this->currentPageIsUnderAgeChecker()) {
                $this->context->controller->registerStylesheet(
                    'psageverifymedia-front-css',
                    'modules/' . $this->name . '/views/css/front.css'
                );
                $this->context->controller->registerJavascript(
                    'psageverifymedia-front-js',
                    'modules/' . $this->name . '/views/js/front.js'
                );
            }
        }
    }
}
