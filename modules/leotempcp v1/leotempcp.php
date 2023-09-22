<?php

/* * ****************************************************
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ***************************************************** */

if (!defined('_CAN_LOAD_FILES_'))
    exit;

require_once(_PS_MODULE_DIR_ . 'leotempcp/libs/helper.php');
require_once(_PS_MODULE_DIR_ . 'leotempcp/libs/DataSample.php');
require_once( _PS_MODULE_DIR_ . 'leotempcp/libs/install.php' );

class Leotempcp extends Module {

    /**
     * @var Array $themeInfo
     * 
     * @access protected
     */
    public $themeInfo = array();

    /**
     * @var String $themePrefix
     * 
     * @access protected
     */
    protected $themeKey = 'LEOTHEME';

    /**
     * @var Array $fonts
     * 
     * @access protected
     */
    protected $hookspos = array();

    /**
     * @var Integer $amounts
     * 
     * @access protected
     */
    protected $amounts = 4;

    /**
     * @var String $base_config_url
     * 
     * @access protected
     */
    protected $base_config_url = '';

    /**
     * @var Array $overrideHooks
     * 
     * @access protected
     */
    protected $overrideHooks = array();

    /**
     * @var Array $overrideHooks
     * 
     * @access protected
     */
    protected $themeName = '';

    /**
     * @var Array $overrideHooks
     * 
     * @access protected
     */
    protected $themePath = '';

    /**
     * @var Array $fields_options
     * 
     * @access protected
     */
    protected $fields_options = array();

    /**
     * Constructor   
     */
    function __construct($createOnly = false) {

        $this->hookspos = LeoFrameworkHelper::getHookPositions();
        $this->bootstrap = true;
        if (!$createOnly) {

            global $currentIndex;

            $this->name = 'leotempcp';
            $this->tab = 'Home';
            $this->version = '2.0';
            $this->author = 'leotheme';
            $this->tab = 'front_office_features';
            parent::__construct();

            $this->displayName = $this->l('Leo Theme Control Panel');
            $this->description = $this->l('Global Theme Panel To Configure Theme Skin, Customization, Layout, Development....(Version 2.0)');
            $this->confirmUninstall = $this->l('Are you sure you want to unistall Theme Skins?');


            $this->themeName = Context::getContext()->shop->getTheme();
            /* merging addition configuration from current theme */
            $theme_dir = $this->themeName;
            $this->themePath = _PS_ALL_THEMES_DIR_ . $theme_dir . '/';


            $this->themeInfo = $this->getInfo();

            $this->base_config_url = $currentIndex . '&configure=' . $this->name . '&token=' . Tools::getValue('token');
        }
    }

    /**
     * Install SQL Queries
     */
    private function _installTradDone() {
        if($this->_installDataSample()) return true;
        
        return LeoThemeControlInstall::checkInstall();
    }
    
    private function _installDataSample(){
        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }

    /**
     * Install SQL and Register Hooks, Tabs
     */
    public function install() {
        if (!parent::install() OR !$this->_installHook() OR !$this->registerHook('header') OR !$this->_installTradDone() OR Configuration::updateValue('DISPLAY_THMSKINSBLACK', 1) == false
        )
            return false;

        $this->installModuleTab('Leo Theme Configuration', 'module', 'AdminParentModules');
        $this->installModuleTab('Leo Positions Control Panel', 'panel', 'AdminParentModules');
        $this->installModuleTab('Leo Live Theme Editor', 'theme', 'AdminParentModules');
        $this->installModuleTab('Leo Manage widgets', 'widgets', 'AdminParentModules');
        $this->installModuleTab('Leo Manage Images', 'images', -1);

        //$this->_installConfig();
        return true;
    }

    /**
     * Un-install module
     */
    public function uninstall() {
        if (!parent::uninstall())
            return false;

        $this->uninstallModuleTab("module");
        $this->uninstallModuleTab("panel");
        $this->uninstallModuleTab("theme");
        $this->uninstallModuleTab("widgets");
        $this->uninstallModuleTab("images");

        //return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'leohook`, `'._DB_PREFIX_.'leowidgets`;');

        return true;
    }

    /**
     * Install Hooks using for framework
     */
    private function _installHook() {
        $hookspos = LeoFrameworkHelper::getHookPositions();

        foreach ($hookspos as $hook) {
            if (Hook::getIdByName($hook)) {
                
            } else {
                $new_hook = new Hook();
                $new_hook->name = pSQL($hook);
                $new_hook->title = pSQL($hook);
                $new_hook->live_edit = 1;
                $new_hook->position = 1;
                $new_hook->add();
                $id_hook = $new_hook->id;
            }
        }
        return true;
    }

    /**
     * Uninstall
     */
    private function uninstallModuleTab($class_sfx = '') {
        $tabClass = 'Admin' . ucfirst($this->name) . ucfirst($class_sfx);

        $idTab = Tab::getIdFromClassName($tabClass);
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
            return true;
        }
        return false;
    }

    /**
     * Install Module Tabs
     */
    private function installModuleTab($title, $class_sfx = '', $parent = '') {
        $class = 'Admin' . ucfirst($this->name) . ucfirst($class_sfx);
        @copy(_PS_MODULE_DIR_ . $this->name . '/logo.gif', _PS_IMG_DIR_ . 't/' . $class . '.gif');
        if ($parent == '') {
            $position = Tab::getCurrentTabId();
        } else {
            $position = Tab::getIdFromClassName($parent);
        }

        $tab1 = new Tab();
        $tab1->class_name = $class;
        $tab1->module = $this->name;
        $tab1->id_parent = intval($position);
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            $tab1->name[$l['id_lang']] = $title;
        }
        if($parent == -1){
            $tab1->id_parent = -1;
            $id_tab1 = $tab1->add();
        }
        else
            $id_tab1 = $tab1->add(true, false);
    }

    
    /*
     * Install Default Configuration
     */
    
    private function _installConfig() {
        return true;
    }

    /*
     * Display Configuration Form and process updating form.
     */

    function getContent() {

        $errors = array();
        $this->_html = '<h2>' . $this->displayName . '</h2>';


        if (Tools::isSubmit('submitModule') || Tools::isSubmit('submitModule')) {
            $result = $this->saveThemeConfigs();
        }
        if (Tools::isSubmit('submitSample') || Tools::isSubmit('submitBackup') || Tools::isSubmit('submitRestore') || Tools::isSubmit('submitImport') || Tools::isSubmit('submitExportDBStruct') || Tools::isSubmit('submitConfigsTheme') || Tools::isSubmit('submitApplyConfigs')) {
            $this->processData();
        }

        return $this->_html . $this->renderForm();
    }

    /**
     * Check Local Css Files with writeable permission
     */
    public function checkingInfo() {
        $output = '';
        if (!is_writable($this->themePath . 'css/local/custom.css')) {
            $output .= '<div class="alert error">' . $this->l('Local Custom File Is not writeable')
                    . ': <span>' . $this->themePath . 'css/local/custom.css' . '</span></div>';
        }

        if (!is_writable($this->themePath . 'css/customize')) {
            $output .= '<div class="alert error">' . $this->l('Live Edit Custom Folder Is not writeable')
                    . ': <span>' . $this->themePath . 'css/customize' . '</span></div>';
        }

        if (!is_writable($this->themePath . 'css')) {
            $output .='<div class="alert error">' . $this->l('Folder stylesheet is not writeable for development')
                    . ': <span>' . $this->themePath . 'css' . '</span></div>';
        }
        
        if (!is_writable($this->themePath . 'layout')) {
            $output .='<div class="alert error">' . $this->l('Folder layout is not writeable for development')
                    . ': <span>' . $this->themePath . 'layout' . '</span></div>';
        }

        return $output;
    }

    /*
     * Mass Update Theme Configurations
     */

    public function saveThemeConfigs() {


        $t = $this->themePath . 'css/local/custom.css';
        if (is_dir($this->themePath . 'css/local/')) {
            if (is_writeable($this->themePath . 'css/local/custom.css')) {
                $css = trim(Tools::getValue($this->getConfigName('C_CODECSS')));
                if ($css) {
                    LeoFrameworkHelper::writeToCache($this->themePath . 'css/local/', 'custom', $css, 'css');
                } else if (file_exists($t) && filesize($t)) {
                    @unlink($t);
                    LeoFrameworkHelper::writeToCache($this->themePath . 'css/local/', 'custom', "", 'css');
                }
            }
        }

        $t = $this->themePath . 'js/local/custom.js';
        if (is_dir($this->themePath . 'js/local/')) {
            if (is_writeable($this->themePath . 'js/local/custom.js')) {
                $js = trim(Tools::getValue($this->getConfigName('C_CODEJS')));
                if ($js) {
                    LeoFrameworkHelper::writeToCache($this->themePath . 'js/local/', 'custom', $js, 'js');
                } else if (file_exists($t) && filesize($t)) {
                    @unlink($t);
                    LeoFrameworkHelper::writeToCache($this->themePath . 'js/local/', 'custom', "", 'js');
                }
            }
        }
        

        $languages = Language::getLanguages(false);
        $this->makeFieldsOptions();
        $content = '';
        //echo "<pre>";print_r($this->fields_options);die;
        foreach ($this->fields_options as $f) {
            foreach ($f['form']['input'] as $input) {
                if ($input['name'] == $this->getConfigName('C_CODECSS')) {
                    continue;
                }
                if (isset($input['lang'])) {
                    $data = array();
                    foreach ($languages as $lang) {
                        $v = Tools::getValue(trim($input['name']) . '_' . $lang['id_lang']);
                        $data[$lang['id_lang']] = $v ? $v : $input['default'];
                    }
                    Configuration::updateValue(trim($input['name']), $data);
                } else {                    
                    $v = Tools::getValue($input['name'], Configuration::get($input['name']));
                    $dataSave = $v ? $v : $input['default'];
                    Configuration::updateValue(trim($input['name']), $dataSave );
                    if(trim($input['name']) == $this->getConfigName('listing_mode')){
                        if(trim($dataSave) == '') $dataSave = 'grid';
                        $content .= '
{assign var="LISTING_GRIG_MODE" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('grid_column')){
                        if(trim($dataSave) == '') $dataSave = '3';
                        $content .= '
{assign var="LISTING_PRODUCT_COLUMN" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('grid_column_tablet')){
                        if(trim($dataSave) == '') $dataSave = '2';
                        $content .= '
{assign var="LISTING_PRODUCT_TABLET" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('grid_column_mobile')){
                        if(trim($dataSave) == '') $dataSave = '1';
                        $content .= '
{assign var="LISTING_PRODUCT_MOBILE" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('grid_column_module')){
                        if(trim($dataSave) == '') $dataSave = '4';
                        $content .= '
{assign var="LISTING_PRODUCT_COLUMN_MODULE" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('enable_color')){
                        $content .= '
{assign var="ENABLE_COLOR" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('enable_wishlist')){
                        $content .= '
{assign var="ENABLE_WISHLIST" value="'.$dataSave.'" scope="global"}';
                    }elseif(trim($input['name']) == $this->getConfigName('enable_responsive')){
                        $content .= '{assign var="ENABLE_RESPONSIVE" value="'.$dataSave.'" scope="global"}';
                    }
                }
            }
        }
        if (is_writeable($this->themePath . 'layout/setting.tpl')) {
            $content .= '
{if $LISTING_PRODUCT_COLUMN=="5"}
    {assign var="colValue" value="col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-2-4" scope="global"}
{else}
    {assign var="colValue" value="col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-{12/$LISTING_PRODUCT_COLUMN}" scope="global"}
{/if}';
            
            LeoFrameworkHelper::writeToCache($this->themePath . 'layout/', 'setting', $content, 'tpl');
        }
        
    }

    /*
     * proccess data
     */

    public function processData() {
        //process databsample
        $dataSample = new Datasample();
        $html = array();
        if (Tools::isSubmit('submitSample')) {
            $dataSample->processSample();
        }else if (Tools::isSubmit('submitImport')) {
            $dataSample->processImport();
        } else if (Tools::isSubmit('submitBackup')) {
            $dataSample->processBackUp();
        } else if (Tools::isSubmit('submitRestore')) {
            $dataSample->restoreBackUpFile();
        } else if (Tools::isSubmit('submitExportDBStruct')) {
            $dataSample->exportDBStruct();
            $dataSample->exportThemeSql();
        }
		elseif (Tools::isSubmit('submitConfigsTheme')) {
            $dataSample->processConfigs();
		}	
		elseif (Tools::isSubmit('submitApplyConfigs')) {
            $dataSample->processApplyConfigs();
		}        
		$html = $dataSample->getMessager();

        foreach ($html as $key => $val) {
            if ($key == "error") {
                foreach ($val as $v)
                    $this->_html .= $this->displayError($v);
            } else {
                foreach ($val as $v)
                    $this->_html .= $this->displayConfirmation($v);
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
        }
    }

    /**
     * get Value of configuration based on actived theme
     */
    public function getConfig($key, $default = '', $id_lang=null) {
        return Configuration::get($this->getConfigName($key), $id_lang);
    }

    /*
     * Get Theme Configurations
     */

    public function getThemeConfigs() {
        
    }

    /**
     * Get Configuration Name With Theme Key 
     *
     */
    public function getConfigName($name) {
        return strtoupper($this->themeKey . "_" . $name);
    }

    /**
     * Build Fields Parameter Options
     */
    public function makeFieldsOptions() {

        $soption = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );

        $tskins = LeoFrameworkHelper::getSkins($this->themeName);
        $directions = LeoFrameworkHelper::getLayoutDirections($this->themeName);

        $this->lang = true;
        $skins = array();
        $skins[] = array('name' => $this->l('Default'), 'id' => '');
        $skins = array_merge_recursive($skins, $tskins);

        /* GENERAL SETTING */
        $general_fields = array(
             array(
                'type' => 'setting_list',
                'name' => 'moduleList',
                'values' => "",
                'default' => ''
            ),
            array(
                'type' => 'hidden',
                'label' => $this->l('Theme Key'),
                'name' => "theme_key",
                'default' => strtoupper($this->themeKey),
                'cast' => 'string',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Responsive'),
                'name' => $this->getConfigName('enable_responsive'),
                'default' => 0,
                'values' => $soption,
            ),
            array(
                'label' => $this->l('Layout Direction'),
                'name' => $this->getConfigName('layout_direction'),
                'default' => 'default',
                'type' => 'select',
                'options' => array(
                    'query' => $directions,
                    'id' => 'id',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Layout Width'),
                'name' => $this->getConfigName('layout_width'),
                'default' => "auto",
                'cast' => 'intval',
                'desc' => $this->l('You can input auto or WIDTHpx, such as: 1170px'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Default Skin'),
                'name' => $this->getConfigName('default_skin'),
                'default' => '',
                'options' => array(
                    'query' => $skins,
                    'id' => 'id',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Copyright'),
                'name' => $this->getConfigName('enable_copyright'),
                'values' => $soption,
                'default' => "0",
                'desc' => $this->l('Allow to display your copyright information at bottom of site.'),
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Copyright'),
                'name' => $this->getConfigName('copyright'),
                'default' => "Copyright " . date('Y') . " Powered by PrestaShop. All Rights Reserved.",
                'rows' => '12',
                'cols' => '30',
                'autoload_rte' => true,
                'lang' => true,
                'autoload_rte' => true
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Panel Tool'),
                'name' => $this->getConfigName('paneltool'),
                'default' => 0,
                'values' => $soption,
                'desc' => $this->l('Whethere to display Panel Tool appearing on left of site.'),
            ),
        );


        $theme_customizations = LeoFrameworkHelper::getLayoutSettingByTheme($this->themeName);

        if (isset($theme_customizations['layout'])) {

            foreach ($theme_customizations['layout'] as $key => $value) {
                $o = array(
                    'label' => $this->l((isset($value['title']) ? $value['title'] : $key)),
                    'name' => $this->getConfigName(trim($key)),
                    'default' => $value['default'],
                    'type' => 'select',
                    'options' => array(
                        'query' => $value['option'],
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => isset($value['desc']) ? $this->l($value['desc']) : null
                );
                array_push($general_fields, $o);
            }
        }



        /* Page Setting */
        $page_fields = array(
            array(
                'type' => 'setting_list',
                'name' => 'moduleList',
                'values' => "",
                'default' => ''
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Products Listing Mode'),
                'name' => $this->getConfigName('listing_mode'),
                'default' => "grid",
                'options' => array('query' => array(
                        array('id' => 'grid', 'name' => $this->l('Grid Mode')),
                        array('id' => 'list', 'name' => $this->l('List Mode')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'desc' => $this->l('Display Products In List Mode Or Grid Mode In Product List....'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Columns in Product List page On Desktop'),
                'name' => $this->getConfigName('grid_column'),
                'default' => ' ',
                'options' => array('query' => array(
                        array('id' => '', 'name' => $this->l('Default')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns')),
                        array('id' => '4', 'name' => $this->l('4 Columns')),
                        array('id' => '5', 'name' => $this->l('5 Columns')),
                        array('id' => '6', 'name' => $this->l('6 Columns'))
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'desc' => $this->l('How many column display in grid mode of product list.'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Columns in Default Module On Desktop'),
                'name' => $this->getConfigName('grid_column_module'),
                'default' => ' ',
                'options' => array('query' => array(
                        array('id' => '', 'name' => $this->l('Default')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns')),
                        array('id' => '4', 'name' => $this->l('4 Columns')),
                        array('id' => '5', 'name' => $this->l('5 Columns')),
                        array('id' => '6', 'name' => $this->l('6 Columns'))
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'desc' => $this->l('How many column display in default module of prestashop.'),
            ),
            
            array(
                'type' => 'select',
                'label' => $this->l('Product Grid Columns On Tablet'),
                'name' => $this->getConfigName('grid_column_tablet'),
                'default' => '',
                'options' => array('query' => array(
                        array('id' => '', 'name' => $this->l('Default')),
                        array('id' => '1', 'name' => $this->l('1 Column')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns'))
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'desc' => $this->l('How many column display in table of grid mode.'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Product Grid Columns On Mobile'),
                'name' => $this->getConfigName('grid_column_mobile'),
                'default' => '',
                'options' => array('query' => array(
                        array('id' => '', 'name' => $this->l('Default')),
                        array('id' => '1', 'name' => $this->l('1 Column')),
                        array('id' => '2', 'name' => $this->l('2 Columns'))
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'desc' => $this->l('How many column display in Mobile of grid mode'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Wishlist Link'),
                'name' => $this->getConfigName('enable_wishlist'),
                'default' => 0,
                'values' => $soption,
                'desc' => $this->l('Select no when you don not enable wishlist moduel of prestashop'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Color Option'),
                'name' => $this->getConfigName('enable_color'),
                'default' => 0,
                'values' => $soption,
                'desc' => $this->l('Select no when you don not want to show color option'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Tab in product Detail'),
                'name' => $this->getConfigName('enable_ptab'),
                'default' => 0,
                'values' => $soption,
                'desc' => $this->l('Select no when you don not want to use tab in product detail'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Float Header'),
                'name' => $this->getConfigName('enable_fheader'),
                'default' => 0,
                'values' => $soption,
                'desc' => $this->l('Select no when you don not want your header float'),
            ),
        );

        $font_fields = array(
        );


        $tskins = LeoFrameworkHelper::getUserProfiles($this->themeName);
        $skins = array();
        $skins[] = array('name' => $this->l('No Use'), 'skin' => '');
        $skins = array_merge_recursive($skins, $tskins);
        $cssCode = '';
        if (file_exists($this->themePath . 'css/local/custom.css')) {
            $cssCode = trim(file_get_contents($this->themePath . 'css/local/custom.css'));
        }


        $customization_fields = array(
            array(
                'type' => 'setting_list',
                'name' => 'moduleList',
                'values' => "",
                'default' => ''
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Custom Profile'),
                'name' => $this->getConfigName('c_profile'),
                'default' => 0,
                'options' => array(
                    'query' => $skins,
                    'id' => 'skin',
                    'name' => 'name'
                ),
                'desc' => $this->l('Select A Custom Theme Profile Which Generated Via Using Live Customizing Theme Tool.'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Custom Css Code'),
                'name' => $this->getConfigName('enable_codecss'),
                'default' => 0,
                'values' => $soption,
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Custom Css Code'),
                'name' => $this->getConfigName('c_codecss'),
                'default' => $cssCode,
                'values' => $soption,
                'rows' => '6',
                'cols' => ''
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Custom JS Code'),
                'name' => $this->getConfigName('enable_codejs'),
                'default' => "",
                'values' => $soption,
                'desc' => $this->l('Whethere to display Custom JS Code In Theme.'),
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Custom JS Code'),
                'name' => $this->getConfigName('c_codejs'),
                'default' => "",
                'values' => $soption,
                'rows' => '6',
                'cols' => ''
            ),
        );
        $this->context->controller->addJs(__PS_BASE_URI__ . str_replace("//", "/", 'modules/leotempcp') . '/assets/admin/form.js', 'all');
        /* FONTS FORM */
        $fonts_fields = array();
        $fonts = array(
            array('id' => 'Verdana', 'font' => htmlspecialchars('Verdana, Geneva, sans-serif'), 'name' => 'Verdana'),
            array('id' => 'Georgia', 'font' => htmlspecialchars('Georgia, "Times New Roman", Times, serif'), 'name' => 'Georgia'),
            array('id' => 'Arial', 'font' => htmlspecialchars('Arial, Helvetica, sans-serif'), 'name' => 'Arial'),
            array('id' => 'Impact', 'font' => htmlspecialchars('Impact, Arial, Helvetica, sans-serif'), 'name' => 'Impact'),
            array('id' => 'Tahoma', 'font' => htmlspecialchars('Tahoma, Geneva, sans-serif'), 'name' => 'Tahoma'),
            array('id' => 'Trebuchet', 'font' => htmlspecialchars('"Trebuchet MS", Arial, Helvetica, sans-serif'), 'name' => 'Trebuchet MS'),
            array('id' => 'Arial', 'font' => htmlspecialchars('"Arial Black", Gadget, sans-serif'), 'name' => 'Arial Black'),
            array('id' => 'Times', 'font' => htmlspecialchars('Times, "Times New Roman", serif'), 'name' => 'Times'),
            array('id' => 'Palatino', 'font' => htmlspecialchars('"Palatino Linotype", "Book Antiqua", Palatino, serif'), 'name' => 'Palatino Linotype'),
            array('id' => 'Lucida', 'font' => htmlspecialchars('"Lucida Sans Unicode", "Lucida Grande", sans-serif'), 'name' => 'Lucida Sans Unicode'),
            array('id' => 'MS', 'font' => htmlspecialchars('"MS Serif", "New York", serif'), 'name' => 'MS Serif'),
            array('id' => 'Comic', 'font' => htmlspecialchars('"Comic Sans MS", cursive'), 'name' => 'Comic Sans MS'),
            array('id' => 'Courier', 'font' => htmlspecialchars('"Courier New", Courier, monospace'), 'name' => 'Courier New'),
            array('id' => 'Lucida', 'font' => htmlspecialchars('"Lucida Console", Monaco, monospace'), 'name' => 'Lucida Console')
        );

        $fs = array(
            array('id' => '', 'name' => $this->l('Default')),
            array('id' => '10', 'name' => $this->l('10')),
            array('id' => '11', 'name' => $this->l('11')),
            array('id' => '12', 'name' => $this->l('12')),
            array('id' => '13', 'name' => $this->l('13')),
            array('id' => '14', 'name' => $this->l('14'))
        );
        $fonts_fields = array(
            array(
                'type' => 'setting_list',
                'name' => 'moduleList',
                'values' => "",
                'default' => ''
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Enable Custom Font'),
                'name' => $this->getConfigName('enable_customfont'),
                'default' => 0,
                'values' => $soption,
            ),
            /* FONT 1 */
            array(
                'type' => 'select',
                'label' => $this->l('Font Engines 1'),
                'name' => $this->getConfigName('font_engine1'),
                'default' => 'local',
                'options' => array('query' => array(
                        array('id' => 'local', 'name' => $this->l('Local')),
                        array('id' => 'google', 'name' => $this->l('Google')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Local Font Family'),
                'name' => $this->getConfigName('engine1_local_font'),
                'default' => '',
                'options' => array('query' => $fonts,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Link'),
                'name' => $this->getConfigName('engine1_google_link'),
                'default' => '',
                'identifier' => 'id',
                'class' => 'localfont',
                'desc' => 'For Example: http://fonts.googleapis.com/css?family=Gorditas'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Font Family'),
                'name' => $this->getConfigName('engine1_google_font'),
                'default' => '',
                'desc' => "For Example: 'Gorditas', cursive",
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Css Selector'),
                'name' => $this->getConfigName('font1_selector'),
                'default' => '',
                'rows' => '6',
                'cols' => '',
                'desc' => $this->l('Example: body, h1,h2,h3, #yourstyle, .myrule div')
            ),
            /* FONT 2 */
            array(
                'type' => 'select',
                'label' => $this->l('Font Engines 2'),
                'name' => $this->getConfigName('font_engine2'),
                'default' => 'local',
                'options' => array('query' => array(
                        array('id' => 'local', 'name' => $this->l('Local')),
                        array('id' => 'google', 'name' => $this->l('Google')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Local Font Family'),
                'name' => $this->getConfigName('engine2_local_font'),
                'default' => '',
                'options' => array(
                    'query' => $fonts,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Link'),
                'name' => $this->getConfigName('engine2_google_link'),
                'default' => '',
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Font Family'),
                'name' => $this->getConfigName('engine2_google_font'),
                'default' => '',
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Css Selector'),
                'name' => $this->getConfigName('font2_selector'),
                'default' => '',
                'rows' => '6',
                'cols' => '',
                'desc' => $this->l('Example: body, h1,h2,h3, #yourstyle, .myrule div')
            ),
            /* FONT 3 */
            array(
                'type' => 'select',
                'label' => $this->l('Font Engines 3'),
                'name' => $this->getConfigName('font_engine3'),
                'default' => 'local',
                'options' => array('query' => array(
                        array('id' => 'local', 'name' => $this->l('Local')),
                        array('id' => 'google', 'name' => $this->l('Google')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Local Font Family'),
                'name' => $this->getConfigName('engine3_local_font'),
                'default' => '',
                'options' => array(
                    'query' => $fonts,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Link'),
                'name' => $this->getConfigName('engine3_google_link'),
                'default' => '',
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Google Font Family'),
                'name' => $this->getConfigName('engine3_google_font'),
                'default' => '',
                'identifier' => 'id',
                'class' => 'localfont'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Css Selector'),
                'name' => $this->getConfigName('font3_selector'),
                'default' => '',
                'rows' => '6',
                'cols' => '',
                'desc' => $this->l('Example: body, h1,h2,h3, #yourstyle, .myrule div')
            ),
        );

        $liveThemeURL = 'index.php?tab=AdminLeotempcpTheme&token=' . Tools::getAdminTokenLite('AdminLeotempcpTheme') . '&refer=1';
        /* RENDER */
        $this->fields_options[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => '<span class="label label-info">' . $this->l('General Setting') . '</span>',
                'icon' => 'icon-cogs',
            ),
            'description' => 'Configure Default Skin and General Information',
            'input' => $general_fields,
            'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-danger'),
        );

        $this->fields_options[1]['form'] = array(
            'legend' => array('title' => '<span class="label label-success">' . $this->l('Pages Setting') . '</span>',
                'icon' => 'icon-cogs',),
            'input' => $page_fields,
            'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-danger'),
        );
        $this->fields_options[2]['form'] = array(
            'legend' => array('title' => '<span class="label label-danger">' . $this->l('Customization Setting') . '</span>',
                'icon' => 'icon-cogs',),
            'description' => $this->l('Support Customize Theme Skin Without experting Css Code') . $this->l(' The framework supports you two way to put your customization on theme.') . '<br />
                <p>' . $this->l('1. You create your css file(s) and put in LEO_YOURTHEME/css/local.') . '</p>'
            . $this->l('2. All files will be loaded automatic Or use tools at bellow') . '</p><hr>'
            . $this->l('Click Live Customizing Theme to create custom-theme-profiles and they will be listed in above dropdown box. You select one profile theme to apply for your site')
            . '<p>' . $this->l('!important: All theme profiles are stored in folder LEO_YOURTHEME/css/customize, it need permission 0755 to put files inside') . '</p>
                <a href="' . $liveThemeURL . '" class="btn-danger btn"><i class="icon-external-link-sign"></i> ' .
            $this->l('Live Customizing Theme') . '</a><br /><hr>',
            'input' => $customization_fields,
            'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-danger'),
        );

        $this->fields_options[3]['form'] = array(
            'legend' => array('title' => '<span class="label label-default">' . $this->l('Font Setting') . '</span>',
                'icon' => 'icon-cogs',),
            'description' => $this->l('Enable Custom Configure Font With Google Font Or Local Font') . '<hr>' . $this->l('To Use Google Font, Please visit google font page to explore all avariable fonts http://www.google.com/fonts. Then Add Expected to Collection and paste link and font name for following inputs')
            . '<p><a href="#">' . $this->l('Click Here To Read Guide') . '</a></p>',
            'input' => $fonts_fields,
            'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-danger'),
        );

        $sample = new Datasample();
        $moduleList = $sample->getModuleList();

        $sample_field = array(
            array(
                'type' => 'setting_list',
                'name' => 'moduleList',
                'values' => "",
                'default' => ''
            ),
            array(
                'type' => 'modules_block',
                'label' => $this->l('Module List:'),
                'name' => 'moduleList',
                'values' => $moduleList,
                'default' => ''
            ),
        );

        //data sample
        $this->fields_options[4]['form'] = array(
            'legend' => array('title' => '<span class="label label-default">' . $this->l('Sample data') . '</span>',
                'icon' => 'icon-cogs',),
            'description' => $this->l('You can import-Export Sample data') . '<hr>' . $this->l('Or can Back-up, Restore Database of Module from Leotheme'),
            'input' => $sample_field,
            'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-danger'),
        );
    }

    /**
     *
     */
    protected function renderForm() {

        if (!$this->themeInfo) {
            return '<div class="panel"><div class="panel-content"><div class="alert alert-danger">' . $this->l('Theme Control Panel Is only avariable using for theme From <b>leotheme.com</b> or using theme built-in <b>Leo Framework</b>') . '</div></div></div>';
        }
        $this->makeFieldsOptions();

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm($this->fields_options);
    }

    /**
     *
     */
    public function getConfigFieldsValues() {
        $languages = Language::getLanguages(false);
        $fields_values = array();

        foreach ($this->fields_options as $f) {
            foreach ($f['form']['input'] as $input) {
                if (isset($input['lang'])) {
                    foreach ($languages as $lang) {
                        $v = Tools::getValue('title', Configuration::get($input['name'], $lang['id_lang']));
                        $fields_values[$input['name']][$lang['id_lang']] = $v ? $v : $input['default'];
                    }
                } else {
                    $v = Tools::getValue($input['name'], Configuration::get($input['name']));
                    $fields_values[$input['name']] = $v ? $v : $input['default'];
                }
            }
        }

        return $fields_values;
    }

    /*
     * Get Current Theme Configuration.
     */

    public function getInfo() {

        $theme_dir = $this->themeName;
        if (!file_exists(_PS_ALL_THEMES_DIR_ . $theme_dir . '/layout/default/header.tpl')) {
            return;
        }

        $output = array("skins" => "", 'layouts' => '');
        $output['skins']['default'] = $this->l('Default Theme');

        $directories = glob(_PS_ALL_THEMES_DIR_ . $theme_dir . '/sass/skins/*', GLOB_ONLYDIR);
		if($directories){
			foreach ($directories as $dir) {
				$output['skins'][basename($dir)] = $this->l(basename($dir));
			}
		}
        $directories = glob(_PS_ALL_THEMES_DIR_ . $theme_dir . '/layout/*', GLOB_ONLYDIR);
        foreach ($directories as $dir) {
            $output['layouts'][basename($dir)] = $this->l(ucfirst(str_replace("-", " ", basename($dir))));
        }

        $xml = LeoFrameworkHelper::getThemeInfo($this->themeName);
        if (isset($xml->theme_key)) {
            $this->themeKey = trim((string) $xml->theme_key);
        }

        return $output;
    }

    function hooktop($params) {

        return false;
    }

    /**
     * Proccess Hook Header
     */
    public function hookHeader() {
        global $smarty;

        $output = '';
        if ($this->themeInfo) {
            $isRTL = $this->context->language->is_rtl;
            $helper = LeoFrameworkHelper::getInstance();
            $helper->setActivedTheme($this->themeName)->loadOverridedHooks(Context::getContext()->shop->id);
            $panelTool = $this->getConfig('PANELTOOL');
            $backGroundValue = '';
            //get skin in config in font office when turn on paneltool
            if ($panelTool) {
                $this->context->controller->addCss(__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/paneltool.css');
                $this->context->controller->addJs( ($this->_path).'/assets/admin/colorpicker/js/colorpicker.js', 'all');
                $this->context->controller->addCss( ($this->_path).'/assets/admin/colorpicker/css/colorpicker.css', 'all'); 
                $this->context->controller->addJS(($this->_path).'assets/admin/paneltool.js','all');

                $helper->triggerUserParams(array('layout_dir', 'layout_mode', 'skin'));
                $layout = $helper->getParam('layout_dir');
                if (!$layout)
                    $layout = $this->getConfig('layout_direction');
                $layout_mode = $helper->getParam('layout_mode');
                if (!$layout_mode)
                    $layout_mode = $this->getConfig('layout_mode');
                
                $skin = $helper->getParam('skin');
                if (!$skin)
                    $skin = $this->getConfig('default_skin');
                
                $backGroundValue = array(
                        "attachment"  => array("scroll","fixed","local","initial","inherit"),
                        "repeat"  => array("repeat","repeat-x","repeat-y","no-repeat","initial","inherit"),
                        "position" => array("left top","left center","left bottom","right top","right center","right bottom","center top","center center","center bottom")
                );
            }else {
                $layout = $this->getConfig('layout_direction');
                $layout_mode = $this->getConfig('layout_mode');
                $skin = $this->getConfig('default_skin');
            }
            $css_custom = array();
            if($isRTL && file_exists(_PS_THEME_DIR_ . 'css/custom-rtl.css')){
                $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/custom-rtl.css'] = 'all';
            }
            /* load skin css file */
            if ($skin != "default" && file_exists(_PS_THEME_DIR_ . 'css/skins/' . $skin . '/skin.css'))
                $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/skins/' . $skin . '/skin.css'] = 'all';
            if($isRTL && file_exists(_PS_THEME_DIR_ . 'css/skins/' . $skin . '/custom-rtl.css')){
                $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/skins/' . $skin . '/custom-rtl.css'] = 'all';
            }
            //only load mobile.css when disable responsive
            if($this->context->getMobileDevice() != false && !$this->getConfig('enable_responsive')){
                if(file_exists( _PS_THEME_DIR_ . '/css/mobile.css'))
                    $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/mobile.css'] = 'all';
            }
            /* load custom css profile */
            if ($profile = $this->getConfig('c_profile')) {
                if(file_exists( _PS_THEME_DIR_. '/css/customize/' . $profile . '.css'))
                        $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/customize/' . $profile. '.css'] = 'all';
            }
            /* load and add custom css file in local folder */
            if ($csses = $helper->loadLocalCss()) {
                foreach ($csses as $css) {
                    if(file_exists( _PS_THEME_DIR_ . '/css/local/' . $css) && trim(Tools::file_get_contents( _PS_THEME_DIR_ . '/css/local/' . $css))){
                        $css_custom[__PS_BASE_URI__ . 'themes/' . $this->themeName . '/css/local/' . $css] = 'all';
                    }
                }
            }

            /* load and add custom js file in local folder */
            if ($jss = $helper->loadLocalJs()) {
                foreach ($jss as $js) {
                    $this->context->controller->addJS(__PS_BASE_URI__ . 'themes/' . $this->themeName . '/js/local/' . $js, 'all');
                }
            }

            if (is_dir(_PS_ALL_THEMES_DIR_ . $this->themeName . "/layout/" . trim($layout)) && $layout) {
                $defaultLayout = trim($layout);
            }
            else
                $defaultLayout = 'default';


            $customFont = '';
            /* check enable customize font */
            if ($this->getConfig('ENABLE_CUSTOMFONT')) {
                $selector = $this->getConfig('FONT1_SELECTOR');
                if ($selector = $this->getConfig('FONT1_SELECTOR')) {
                    $customFont .= $helper->loadLocalFont()->renderFontTagHeader($this->getConfig('FONT_ENGINE1'), $this->getConfig('ENGINE1_LOCAL_FONT'), $this->getConfig('ENGINE1_GOOGLE_LINK'), $this->getConfig('ENGINE1_GOOGLE_FONT'), $selector
                    );
                }
                if ($selector = $this->getConfig('FONT2_SELECTOR')) {
                    $customFont .= $helper->loadLocalFont()->renderFontTagHeader($this->getConfig('FONT_ENGINE2'), $this->getConfig('ENGINE2_LOCAL_FONT'), $this->getConfig('ENGINE2_GOOGLE_LINK'), $this->getConfig('ENGINE2_GOOGLE_FONT'), $selector
                    );
                }
                if ($selector = $this->getConfig('FONT3_SELECTOR')) {
                    $customFont .= $helper->loadLocalFont()->renderFontTagHeader($this->getConfig('FONT_ENGINE3'), $this->getConfig('ENGINE3_LOCAL_FONT'), $this->getConfig('ENGINE3_GOOGLE_LINK'), $this->getConfig('ENGINE3_GOOGLE_FONT'), $selector
                    );
                }
            }
            $layout_width_val = '';
            $layout_width = $this->getConfig('layout_width');
            if(trim($layout_width) != 'auto' && trim($layout_width) != ''){
               $layout_width = str_replace('px', '', $layout_width);
               $layout_width_val = '<style type="text/css">.container{max-width:'.$layout_width.'px}</style>';
               if(is_numeric($layout_width)){$layout_width_val .= '<script type="text/javascript">layout_width = '.  $layout_width .';</script>';}
               
            }
            //  'FOOTER_BUIDER'      => $this->getFooterBuilder(),
            /* Asign to vars */
            $ps = array(
                //'LEO_LAYOUT_DIRECTION'  => 'default',  
                'HOOK_TOPNAVIGATION' => $helper->exec('topNavigation'),
                'HOOK_SLIDESHOW' => $helper->exec('displaySlideshow'),
                'HOOK_HEADERRIGHT' => $helper->exec('displayHeaderRight'),
                'HOOK_BOTTOM' => $helper->exec('displayBottom'),
                'HOOK_CONTENTBOTTOM' => $helper->exec('displayContentBottom'),
                'HOOK_FOOTERTOP' => $helper->exec('displayFooterTop'),
                'HOOK_FOOTERBOTTOM' => $helper->exec('displayFooterBottom'),
                'HOOK_FOOTNAV' => $helper->exec('displayFootNav'),
                //'BODY_FONT_SIZE' => $customFont,
                'CUSTOM_FONT' => $customFont,
                /*  */
                'LEO_THEMENAME' => $this->themeName,
                'LEO_PANELTOOL' => $panelTool,
                'LEO_LAYOUT_DIRECTION' => $defaultLayout,
                'LEO_DEFAULT_SKIN' => $skin,
                'LEO_LAYOUT_MODE' => $layout_mode,
                'CUSTOM_COPYRIGHT' => $this->getConfig('COPYRIGHT', '' , $this->context->language->id),
                'ENABLE_COPYRIGHT' => $this->getConfig('ENABLE_COPYRIGHT'),
                'BACKGROUNDVALUE' => $backGroundValue,
                'LAYOUT_WIDTH'    => $layout_width_val,
                'LEO_CSS'  => $css_custom,
                'IS_RTL'    => $isRTL,
                'USE_PTABS' => $this->getConfig('ENABLE_PTAB'),
                'USE_FHEADER' => $this->getConfig('ENABLE_FHEADER')
            );


            $smarty->assign($ps);
        }

        return $output;
    }

    protected function getCacheId($name = null, $hook = '') {
        $cache_array = array(
            $name !== null ? $name : $this->name,
            $hook,
            date('Ymd'),
            (int) Tools::usingSecureMode(),
            (int) $this->context->shop->id,
            (int) Group::getCurrent()->id,
            (int) $this->context->language->id,
            (int) $this->context->currency->id,
            (int) $this->context->country->id,
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
        );
        return implode('|', $cache_array);
    }

    public function _clearBLHLCache() {
        $this->_clearCache('footer_builder.tpl');
        $this->_clearCache('widget_map.tpl');
    }

}
