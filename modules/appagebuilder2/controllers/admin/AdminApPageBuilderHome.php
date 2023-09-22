<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderModel.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderProfilesModel.php');

class AdminApPageBuilderHomeController extends ModuleAdminControllerCore
{
    public static $shortcode_lang;
    public static $lang_id;
    public static $language;
    public $error_text = '';
    public $module_name;
    public $module_path;
    public $module_path_resource;
    public $tpl_path;
    public $theme_dir;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = true;
        $this->table = 'appagebuilder';
        $this->className = 'ApPageBuilderHome';
        $this->context = Context::getContext();
        $this->module_name = 'appagebuilder';
        $this->module_path = __PS_BASE_URI__.'modules/'.$this->module_name.'/';
        $this->module_path_resource = $this->module_path.'views/';
        $this->tpl_path = _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin';
        parent::__construct();
        $this->multishop_context = false;
        $this->theme_dir = _PS_ROOT_DIR_.'/themes/'.Context::getContext()->shop->getTheme().'/';
    }

    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_btn['save'] = array(
            //'short' => $this->l('Save', null, null, false),
            'short' => 'SaveAndStay',
            'href' => 'javascript:;',
            //'desc' => $this->l('Save', null, null, false),
            'desc' => $this->l('Save and stay'),
            'confirm' => 1,
            'js' => 'submitform()'
        );
        $current_id = Tools::getValue('id_appagebuilder_profiles');
        if (!$current_id) {
            $profile = ApPageBuilderProfilesModel::getActiveProfile('index');
            $current_id = $profile['id_appagebuilder_profiles'];
        }
        $lang = '';
        if (Configuration::get('PS_REWRITING_SETTINGS') && count(Language::getLanguages(true)) > 1) {
            $lang = Language::getIsoById($this->context->employee->id_lang).'/';
        }
        $url_preview = $this->context->shop->getBaseUrl().(Configuration::get('PS_REWRITING_SETTINGS') ? '' : 'index.php')
                .$lang.'?id_appagebuilder_profiles='.$current_id;
        $this->page_header_toolbar_btn['preview'] = array(
            //'short' => $this->l('Save', null, null, false),
            'short' => 'Preview',
            'href' => $url_preview,
            'target' => '_blank',
            //'desc' => $this->l('Save', null, null, false),
            'desc' => $this->l('Preview'),
            'confirm' => 0
        );
        parent::initPageHeaderToolbar();
    }
    /*
     * process ajax
     */

    public function postProcess()
    {
        $action = Tools::getValue('action');
        if ($action == 'processPosition') {
            $this->processPosition();
            die;
        } else if ($action == 'selectPosition') {
            $this->selectPosition();
            die;
        }
        if (Tools::getIsset('importData')) {
            $this->error_text = AdminApPageBuilderShortcodesController::importData(Language::getLanguages(false), (int)$this->context->language->id);
            if ($this->error_text == 'ok') {
                $id_profile = Tools::getIsset('id_appagebuilder_profiles') ?
                        '&id_appagebuilder_profiles='.Tools::getValue('id_appagebuilder_profiles') : '';
                Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminApPageBuilderHome').$id_profile);
            }
            if ($this->error_text == 'ERORR_ALL') {
                $this->error_text = $this->l('That is the file for module, please select import for: module');
            }
            if ($this->error_text == 'ERORR_NOT_ALL') {
                $this->error_text = $this->l('That is not file for module, please select other import for');
            }
            if ($this->error_text == 'ERORR_POSITION') {
                $this->error_text = $this->l('That is not file for position, please select import for positon: header or content or footer or product');
            }
        }
    }

    public function renderList()
    {
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJqueryUI('ui.draggable');
        $this->context->controller->addCss($this->module_path_resource.'css/admin/form.css');
        $this->context->controller->addCss($this->module_path_resource.'css/animate.css');
        $this->context->controller->addJs($this->module_path_resource.'js/admin/form.js');
        $this->context->controller->addJs($this->module_path_resource.'js/admin/home.js');
        $this->context->controller->addJs($this->module_path_resource.'js/admin/isotope.pkgd.min.js');
        $this->context->controller->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');

        $this->context->controller->addJs($this->module_path_resource.'js/admin/jquery-validation-1.9.0/jquery.validate.js');
        $this->context->controller->addCss($this->module_path_resource.'js/admin/jquery-validation-1.9.0/screen.css');

        $version = Configuration::get('PS_INSTALL_VERSION');
        $tiny_path = ($version >= '1.6.0.13') ? 'admin/' : '';
        $tiny_path .= 'tinymce.inc.js';
        $this->context->controller->addJS(_PS_JS_DIR_.$tiny_path);
        $bo_theme = ((Validate::isLoadedObject($this->context->employee) && $this->context->employee->bo_theme) ? $this->context->employee->bo_theme : 'default');
        if (!file_exists(_PS_BO_ALL_THEMES_DIR_.$bo_theme.DIRECTORY_SEPARATOR.'template')) {
            $bo_theme = 'default';
        }
        $this->addJs(__PS_BASE_URI__.$this->admin_webpath.'/themes/'.$bo_theme.'/js/jquery.fileupload.js');
        $this->addJs(__PS_BASE_URI__.$this->admin_webpath.'/themes/'.$bo_theme.'/js/jquery.fileupload-process.js');
        $this->addJs(__PS_BASE_URI__.$this->admin_webpath.'/themes/'.$bo_theme.'/js/jquery.fileupload-validate.js');
        $this->context->controller->addJs(__PS_BASE_URI__.'js/vendor/spin.js');
        $this->context->controller->addJs(__PS_BASE_URI__.'js/vendor/ladda.js');
        //load javascript for menu tree
        $tree = new HelperTreeCategories('123', null);
        $tree->render();
        $model = new ApPageBuilderModel();
        $id_profile = Tools::getValue('id_appagebuilder_profiles');
        if (!$id_profile) {
            $result_profile = ApPageBuilderProfilesModel::getActiveProfile('index');
            //if empty default profile redirect to other
            if (!$result_profile) {
                $this->redirect_after = Context::getContext()->link->getAdminLink('AdminApPageBuilderProfiles');
                $this->redirect();
            }
            $id_profile = $result_profile['id_appagebuilder_profiles'];
        } else {
            $profile_obj = new ApPageBuilderProfilesModel($id_profile);
            if ($profile_obj->id) {
                $result_profile['id_appagebuilder_profiles'] = $profile_obj->id;
                $result_profile['name'] = $profile_obj->name;
                $result_profile['header'] = $profile_obj->header;
                $result_profile['content'] = $profile_obj->content;
                $result_profile['footer'] = $profile_obj->footer;
                $result_profile['product'] = $profile_obj->product;
                $result_profile['page'] = $profile_obj->page;
            }
        }
        if (isset($result_profile) && $result_profile) {
            $positions_dum = array();
            // Get default config - data of current position
            $positions_dum['header'] = $result_profile['header'] ?
                    $model->getAllItemsByPosition('header', $result_profile['header'], $id_profile) :
                    array('content' => $this->extractHookDefault(Configuration::get('HEADER_HOOK')), 'dataForm' => array());
            $positions_dum['content'] = $result_profile['content'] ?
                    $model->getAllItemsByPosition('content', $result_profile['content'], $id_profile) :
                    array('content' => $this->extractHookDefault(Configuration::get('CONTENT_HOOK')), 'dataForm' => array());
            $positions_dum['footer'] = $result_profile['footer'] ?
                    $model->getAllItemsByPosition('footer', $result_profile['footer'], $id_profile) :
                    array('content' => $this->extractHookDefault(Configuration::get('FOOTER_HOOK')), 'dataForm' => array());
            $positions_dum['product'] = $result_profile['product'] ?
                    $model->getAllItemsByPosition('product', $result_profile['product'], $id_profile) :
                    array('content' => $this->extractHookDefault(Configuration::get('PRODUCT_HOOK')), 'dataForm' => array());
            // Extract for display
            $positions = array();
            $position_data_form = array();
            foreach ($positions_dum as $key => $val) {
                $temp = $val['content'];
                $position_data_form[$key] = Tools::jsonEncode($val['dataForm']);
                foreach ($temp as $key_hook => &$row) {
                    if (!is_array($row)) {
                        $row = array('hook_name' => $key_hook, 'content' => '');
                    }
                    if ($key_hook == 'displayLeftColumn' || $key_hook == 'displayRightColumn') {
                        $row['class'] = 'col-md-3';
                    } else {
                        $row['class'] = 'col-md-12';
                    }
                }
                $positions[$key] = $temp;
            }
            // Get list position for dropdowns
            $list_positions = array();
            $list_positions['header'] = $model->getListPositisionByType('header', $this->context->shop->id);
            $list_positions['content'] = $model->getListPositisionByType('content', $this->context->shop->id);
            $list_positions['footer'] = $model->getListPositisionByType('footer', $this->context->shop->id);
            $list_positions['product'] = $model->getListPositisionByType('product', $this->context->shop->id);
            // Get current position name

            $current_position = array();
            $current_position['header'] = $this->getCurrentPosition($list_positions['header'], $result_profile['header']);
            $current_position['content'] = $this->getCurrentPosition($list_positions['content'], $result_profile['content']);
            $current_position['footer'] = $this->getCurrentPosition($list_positions['footer'], $result_profile['footer']);
            $current_position['product'] = $this->getCurrentPosition($list_positions['product'], $result_profile['product']);
            $data_by_hook = array();
            $data_form = '{}';
            $data = $model->getAllItems($result_profile);

            if ($data) {
                $data_by_hook = $data['content'];
                $data_form = Tools::jsonEncode($data['dataForm']);

                foreach ($data_by_hook as $key_hook => &$row) {
                    if (!is_array($row)) {
                        $row = array('hook_name' => $key_hook, 'content' => '');
                    }
                    if ($key_hook == 'displayLeftColumn' || $key_hook == 'displayRightColumn') {
                        $row['class'] = 'col-md-3';
                    } else {
                        $row['class'] = 'col-md-12';
                    }
                }
            }

            // Get list item for dropdown export
            $export_items = array();
            $export_items['Header'] = ApPageSetting::getHook('header');
            $export_items['Content'] = ApPageSetting::getHook('content');
            $export_items['Footer'] = ApPageSetting::getHook('footer');
            $export_items['Product'] = ApPageSetting::getHook('product');
            // get shortcode information
            $shortcode_infos = ApShortCodeBase::getShortCodeInfos();
            //include all short code default
            $shortcodes = Tools::scandir($this->tpl_path.'/ap_page_builder_shortcodes', 'tpl');
            $shortcode_form = array();
            foreach ($shortcodes as $s_from) {
                if ($s_from == 'shortcodelist.tpl') {
                    continue;
                }
                $shortcode_form[] = $this->tpl_path.'/ap_page_builder_shortcodes/'.$s_from;
            }
            $tpl = $this->createTemplate('home.tpl');
            $languages = array();
            foreach (Language::getLanguages(false) as $lang) {
                $languages[$lang['iso_code']] = $lang['id_lang'];
            }
            $tpl->assign(array(
                'positions' => $positions,
                'listPositions' => $list_positions,
                //'positionDataForm' => $position_data_form,
                'dataByHook' => $data_by_hook,
                'exportItems' => $export_items,
                'currentProfile' => $result_profile,
                'currentPosition' => $current_position,
                'profilesList' => $this->getAllProfiles($result_profile['id_appagebuilder_profiles']),
                'tplPath' => $this->tpl_path,
                'ajaxShortCodeUrl' => Context::getContext()->link->getAdminLink('AdminApPageBuilderShortcodes'),
                'ajaxHomeUrl' => Context::getContext()->link->getAdminLink('AdminApPageBuilderHome'),
                'shortcodeForm' => $shortcode_form,
                'moduleDir' => _MODULE_DIR_,
                // Not run with multi_shop (ex block carousel cant get image in backend multi_shop)
//				'imgModuleLink' => _THEME_IMG_DIR_.'modules/'.$this->module_name.'/images/',
                'imgModuleLink' => (_THEMES_DIR_.Context::getContext()->shop->getTheme().'/img/modules/'.$this->module_name.'/images/'),
                'shortcodeInfos' => Tools::jsonEncode($shortcode_infos),
                'languages' => Tools::jsonEncode($languages),
                'dataForm' => $data_form,
                'errorText' => $this->error_text,
                'imgController' => Context::getContext()->link->getAdminLink('AdminApPageBuilderImages'),
                'widthList' => ApPageSetting::returnWidthList(),
                'lang_id' => (int)$this->context->language->id,
                'idProfile' => $id_profile
            ));
            $path_guide = $this->getTemplatePath().'guide.tpl';
            $guide_box = ApPageSetting::buildGuide($this->context, $path_guide, 3);
            return $guide_box.$tpl->fetch();
        } else {
            $this->errors[] = Tools::displayError('Your Profile ID is not exist!');
        }
    }

    public function extractHookDefault($str_hook = '')
    {
        $result = array();
        if ($str_hook) {
            $arr = explode(',', $str_hook);
            $len = count($arr);
            for ($i = 0; $i < $len; $i++)
                $result[$arr[$i]] = $i;
        }
        return $result;
    }

    public function getAllProfiles($id)
    {
        $current_id = Tools::getValue('id_appagebuilder_profiles');
        $profile_obj = new ApPageBuilderProfilesModel($current_id);
        return $profile_obj->getProfilesInPage($id);
    }

    /**
     * Check this position is using by other profile before get template
     */
    public function checkStatusUsingPosition()
    {
        $id_position = (int)Tools::getValue('id');
        $id_profile = (int)Tools::getValue('id_profile');
        $data = array();
        if ($id_position) {
            $model = new ApPageBuilderModel();
            $data = $model->findOtherProfileUsePosition($id_position, $id_profile);
        }
        $message = '';
        $sep = '';
        $status = 'SUCCESS';
        if ($data && count($data) > 0) {
            $status = 'ERROR';
            foreach ($data as $item) {
                $message .= $sep.$item['name'];
                $sep = ', ';
            }
            $message = $this->l('The profile:').'"'.$message.'" '.(count($data) > 1 ? $this->l(' are ') : ' is ')
                    .'this position. Do you want duplicate this position?
				(Click cancel and then this position is changed and saved, all profile using it will also change.)';
        } else {
            $this->selectPosition();
            die;
        }
        die(Tools::jsonEncode(array('status' => $status, 'message' => $message)));
        // Check this position is using by other profile
    }

    /**
     * Get template a position
     */
    public function selectPosition($id = '')
    {
        $position = Tools::getValue('position');
        $id_position = $id ? $id : (int)Tools::getValue('id');
        $id_duplicate = (int)Tools::getValue('is_duplicate');
        $content = '';
        $tpl_name = 'position.tpl';
        $path = '';

        if (file_exists($this->theme_dir.'modules/'.$this->module->name.'/views/templates/admin/'.$tpl_name)) {
            $path = $this->theme_dir.'modules/'.$this->module->name.'/views/templates/admin/'.$tpl_name;
        } elseif (file_exists($this->getTemplatePath().$this->override_folder.$tpl_name)) {
            $path = $this->getTemplatePath().$this->override_folder.$tpl_name;
        }
        $model = new ApPageBuilderModel();
        $positions_dum = $id_position ?
                $model->getAllItemsByPosition($position, $id_position) :
                array('content' => $this->extractHookDefault(Configuration::get(Tools::strtoupper($position).'_HOOK')), 'dataForm' => array());
        $list_positions = $model->getListPositisionByType(Tools::strtolower($position), $this->context->shop->id);
        $current_position = $this->getCurrentPosition($list_positions, $id_position);

        foreach ($positions_dum['content'] as $key_hook => &$row) {
            if (!is_array($row)) {
                $row = array('hook_name' => $key_hook, 'content' => '');
            }
            if ($key_hook == 'displayLeftColumn' || $key_hook == 'displayRightColumn') {
                $row['class'] = 'col-md-3';
            } else {
                $row['class'] = 'col-md-12';
            }
        }
        $positions = $positions_dum['content'];
        $data_form = Tools::jsonEncode($positions_dum['dataForm']);
        $id_position = $id_duplicate ? 0 : $id_position;
        $this->context->smarty->assign(
                array('default' => $current_position,
                    'position' => $position,
                    'listPositions' => $list_positions,
                    'config' => $positions));
        $content = $this->context->smarty->fetch($path);
        $result = array('status' => 'SUCCESS', 'message' => '', 'html' => $content,
            'position' => $position, 'id' => $id_position, 'data' => $data_form);

        die(Tools::jsonEncode($result));
        // Check this position is using by other profile
    }

    /**
     * Process: add, update, duplicate a position
     */
    public function processPosition()
    {
        $name = Tools::getValue('name');
        $position = Tools::getValue('position');
        $id_position = (int)Tools::getValue('id');
        $mode = Tools::getValue('mode');
        if ($mode == 'duplicate') {
            $adapter = new AdminApPageBuilderPositionsController();
            $id_position = $adapter->duplicatePosition($id_position, 'ajax', $name);
        } else if ($mode == 'new') {
            $key = ApPageSetting::getRandomNumber();
            $name = $name ? $name : $position.$key;
            $position_controller = new AdminApPageBuilderPositionsController();

            $position_data = array('name' => $name,
                'position' => $position,
                'position_key' => 'position'.$key);
            $id_position = $position_controller->autoCreatePosition($position_data);
        }
        // Edit only name
        else if ($mode == 'edit') {
            $position_controller = new AdminApPageBuilderPositionsController();
            $position_controller->updateName($id_position, $name);
        }
        // Reload position
        if ($mode == 'new' || $mode == 'duplicate') {
            $this->selectPosition($id_position);
        } else {
            die(Tools::jsonEncode(array('status' => 'SUCCESS')));
        }
    }

    private function getCurrentPosition($list, $id)
    {
        if ($list) {
            foreach ($list as $item) {
                if (isset($item['id_appagebuilder_positions']) && $item['id_appagebuilder_positions'] == $id) {
                    return array('id' => $id, 'name' => $item['name']);
                }
            }
        }
        return array('id' => '0', 'name' => '');
    }
}
