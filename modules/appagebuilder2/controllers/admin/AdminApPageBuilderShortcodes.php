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

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php' );
require_once(_PS_MODULE_DIR_.'appagebuilder/controllers/admin/AdminApPageBuilderPositions.php');

class AdminApPageBuilderShortcodesController extends ModuleAdminControllerCore
{
    public static $shortcode_lang;
    public static $language;
    public static $lang_id;
    public $file_content = '';
    protected $max_image_size = null;
    public $theme_name;
    public $img_path;
    public $img_url;
    public static $replaced_element;
    public $config_module;
    public $hook_assign;
    public $module_name;
    public $module_path;
    public $tpl_controller_path;
    public $tpl_front_path;
    public $shortcode_dir;
    public $shortcode_override_dir;
    public $theme_dir;
    public $theme_url;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = true;
        $this->table = 'appagebuilder';
        $this->className = 'ApPageBuilderShortCode';
        $this->context = Context::getContext();
        $this->module_name = 'appagebuilder';
        $this->module_path = __PS_BASE_URI__.'modules/'.$this->module_name.'/';
        $this->tpl_controller_path = _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin/ap_page_builder_shortcodes/';
        $this->tpl_front_path = _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/font/';
        $this->shortcode_dir = _PS_MODULE_DIR_.'appagebuilder/classes/shortcodes/';

        self::$language = Language::getLanguages(false);
        //image
        parent::__construct();
        $this->theme_dir = _PS_ROOT_DIR_.'/themes/'.Context::getContext()->shop->getTheme().'/';
        $this->theme_url = _THEMES_DIR_.Context::getContext()->shop->getTheme().'/';
        $this->shortcode_override_dir = $this->theme_dir.'modules/appagebuilder/classes/shortcodes/';
        $this->max_image_size = (int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
        $this->theme_name = Context::getContext()->shop->getTheme();
        $this->img_path = _PS_ALL_THEMES_DIR_.$this->theme_name.'/img/modules/appagebuilder/';
        $this->img_url = __PS_BASE_URI__.'themes/'.$this->theme_name.'/img/modules/appagebuilder/';
        $this->hook_assign = array('rightcolumn', 'leftcolumn', 'topcolumn', 'home', 'top', 'footer', 'nav');
    }

    public function renderList()
    {
        if (Tools::getIsset('type_shortcode')) {
            $this->renderForm();
        }
        $tpl = $this->createTemplate('shortcodelist.tpl');
        $id_profile = Tools::getValue('idProfile');
        if (Tools::getValue('showImportForm')) {
            $helper = new HelperForm();
            $helper->submit_action = 'importData';
            $hook = array();
            $hook[] = array('id' => 'all', 'name' => $this->l('Profile'));
            $hook[] = array('id' => 'header', 'name' => $this->l('Position Header'));
            foreach (ApPageSetting::getHook('header') as $val) {
                $hook[] = array('id' => $val, 'name' => '----'.$val);
            }
            $hook[] = array('id' => 'content', 'name' => $this->l('Position Content'));
            foreach (ApPageSetting::getHook('content') as $val) {
                $hook[] = array('id' => $val, 'name' => '----'.$val);
            }
            $hook[] = array('id' => 'footer', 'name' => $this->l('Position Footer'));
            foreach (ApPageSetting::getHook('footer') as $val) {
                $hook[] = array('id' => $val, 'name' => '----'.$val);
            }
            $hook[] = array('id' => 'product', 'name' => $this->l('Position Product'));
            foreach (ApPageSetting::getHook('product') as $val) {
                $hook[] = array('id' => $val, 'name' => '----'.$val);
            }
            $inputs = array(
                array(
                    'type' => 'file',
                    'name' => 'importFile',
                    'label' => $this->l('File'),
                    'desc' => $this->l('Only accept xml file')
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Import For'),
                    'name' => 'import_for',
                    'options' => array(
                        'query' => $hook,
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('Select hook you want to import. Override all is only avail for import appagebuilderhome.xml file')
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Override'),
                    'name' => 'override',
                    'is_bool' => true,
                    'desc' => $this->l('Override current data or not.'),
                    'values' => ApPageSetting::returnYesNo()
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'html_content' => '<input type="hidden" name="id_profile" id="id_profile" value="'.$id_profile.'"/>'
                )
            );
            $fields_form = array(
                'form' => array(
                    'action' => Context::getContext()->link->getAdminLink('AdminApPageBuilderShortcodes'),
                    'input' => $inputs,
                    'name' => 'importData',
                    //'buttons' => array(array('title' => $this->l('Save'), 'class' => 'button btn')),
                    'submit' => array('title' => $this->l('Save'), 'class' => 'button btn btn-success'),
                    'tinymce' => false,
                ),
            );
            $helper->fields_value = isset($this->fields_value) ? $this->fields_value : array();
            die($helper->generateForm(array($fields_form)));
        } else {
            // get list module installed by hook position
            $list_modules = $this->getModules();
            // Get list author
            $author = array();
            foreach ($list_modules as $mi) {
                $str = Tools::ucwords(Tools::strtolower($mi['author'] ? $mi['author'] : ' '));
                if (!in_array($str, $author)) {
                    array_push($author, $str);
                }
            }
            //Get list of image or shortcodeFile
            $tpl->assign(array(
                'author' => $author,
                'listModule' => $list_modules,
                'shortCodeList' => ApShortCodeBase::getShortCodeInfos()
            ));
        }
        die($tpl->fetch());
    }

    public function getModules()
    {
        $not_module = array($this->module_name, 'themeconfigurator', 'leotempcp', 'themeinstallator', 'cheque');
        $where = '';
        if (count($not_module) == 1) {
            $where = ' WHERE m.`name` <> \''.$not_module[0].'\'';
        } elseif (count($not_module) > 1) {
            $where = ' WHERE m.`name` NOT IN (\''.implode("','", $not_module).'\')';
        }
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $sql = 'SELECT m.name, m.id_module
				FROM `'._DB_PREFIX_.'module` m
				JOIN `'._DB_PREFIX_.'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = '.(int)$id_shop.')
				'.$where;
        $module_list = Db::getInstance()->ExecuteS($sql);
        $module_info = ModuleCore::getModulesOnDisk(true);
        $modules = array();
        foreach ($module_list as $m) {
            foreach ($module_info as $mi) {
                if ($m['name'] === $mi->name) {
                    $m['tab'] = (isset($mi->tab) && $mi->tab) ? $mi->tab : '';
                    $m['interest'] = (isset($mi->interest) && $mi->interest) ? $mi->interest : '';
                    $m['author'] = (isset($mi->author) && $mi->author) ? Tools::ucwords(Tools::strtolower($mi->author)) : '';
                    $m['image'] = (isset($mi->image) && $mi->image) ? $mi->image : '';
                    $m['avg_rate'] = (isset($mi->avg_rate) && $mi->avg_rate) ? $mi->avg_rate : '';
                    $m['description'] = (isset($mi->description) && $mi->description) ? $mi->description : '';
                    $sub = '';
                    if (isset($mi->description) && $mi->description) {
                        // Get sub word 50 words from description
                        $sub = Tools::substr($mi->description, 0, 50);
                        $spo = Tools::strrpos($sub, ' ');
                        $sub = Tools::substr($mi->description, 0, ($spo != -1 ? $spo : 0)).'...';
                    }
                    $m['description_short'] = $sub;
                    break;
                }
            }
            if (in_array($m['name'], array('leosliderlayer'))) {
                $m['author'] = 'Apollotheme';
            }
            $modules[] = $m;
        }
        return $modules;
    }

    /**
     * Get list of all registered hooks with modules
     *
     * @since 1.5.0
     * @return array
     */
    public function checkModuleInHook($module_id, $id_hook)
    {
        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT *
			FROM `'._DB_PREFIX_.'hook_module` hm
			WHERE hm.id_module = '.$module_id.
                ' AND hm.id_hook = '.$id_hook);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }

    public function getHooksByModuleId($id_module, $id_shop)
    {
        $module = $this->getModulById($id_module, $id_shop);
        $module_instance = ModuleCore::getInstanceByName($module['name']);
        //echo "<pre>";print_r($module_instance);
        $hooks = array();
        if ($this->hook_assign) {
            foreach ($this->hook_assign as $hook) {
                $retro_hook_name = Hook::getRetroHookName($hook);
                if ($hook == 'topcolumn') {
                    $retro_hook_name = 'displayTopColumn';
                }
                if ($hook == 'nav') {
                    $retro_hook_name = 'displayNav';
                }
                if (is_callable(array($module_instance, 'hook'.$hook)) || is_callable(array($module_instance, 'hook'.$retro_hook_name))) {
                    $hooks[] = $retro_hook_name;
                }
            }
        }
        $results = $this->getHookByArrName($hooks);
        return $results;
    }

    public function getModulById($id_module, $id_shop)
    {
        return Db::getInstance()->getRow('
			SELECT m.*
			FROM `'._DB_PREFIX_.'module` m
			JOIN `'._DB_PREFIX_.'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = '.(int)$id_shop.')
			WHERE m.`id_module` = '.$id_module);
    }

    public function getHookByArrName($arr_name)
    {
        $result = Db::getInstance()->ExecuteS('
			SELECT `id_hook`, `name`
			FROM `'._DB_PREFIX_.'hook`
			WHERE `name` IN (\''.implode("','", $arr_name).'\')');
        return $result;
    }

    /**
     * Duplicate all data relate with profile
     * @param type int $old_id : current profile id is duplicating
     * @param type int $new_id : new profile id after duplicated
     */
    public static function duplicateData($old_id, $new_id)
    {
//		$context = Context::getContext();
        $positions = array();
        $sql = 'SELECT *
				FROM `'._DB_PREFIX_.'appagebuilder_profiles` p 
				WHERE p.id_appagebuilder_profiles='.(int)$old_id;
        $result = Db::getInstance()->getRow($sql);
        if ($result) {
            $positions[] = $result['header'];
            $positions[] = $result['content'];
            $positions[] = $result['footer'];
            $positions[] = $result['product'];
        }
        $sql_update = 'UPDATE '._DB_PREFIX_.'appagebuilder_profiles ';
        $sep = ' SET ';
        $is_update = false;
        // Duplicate positions
        foreach ($positions as $item) {
            $id = (int)$item;
            $object = ApPageBuilderPositionsModel::getPositionById($id);
            if ($object) {
                $key = ApPageSetting::getRandomNumber();
                $old_key = $object['position_key'];
                $name = 'Duplicate '.$key;
                $data = array('name' => $name, 'position' => $object['position'], 'position_key' => 'duplicate_'.$key);
                $model = new ApPageBuilderPositionsModel();
                $duplicate_id = $model->addAuto($data);
                if ($duplicate_id) {
                    $position_controller = new AdminApPageBuilderPositionsController();
                    $sql_update .= $sep.$data['position'].'='.$duplicate_id;
                    $sep = ', ';
                    $is_update = true;
                    self::duplcateDataPosition($id, $duplicate_id);
                    ApPageSetting::writeFile($position_controller->position_js_folder, $data['position'].$data['position_key'].'.js', Tools::file_get_contents($position_controller->position_js_folder.$data['position'].$old_key.'.js'));
                    ApPageSetting::writeFile($position_controller->position_css_folder, $data['position'].$data['position_key'].'.css', Tools::file_get_contents($position_controller->position_css_folder.$data['position'].$old_key.'.css'));
                }
            }
        }
        if ($is_update) {
            $sql_update .= ' WHERE id_appagebuilder_profiles='.(int)$new_id;
            Db::getInstance()->execute($sql_update);
        }
    }

    /**
     * Duplicate a position: dulicate data in table appagebuilder_lang; appagebuilder; appagebuilder_shop;
     * @param type int $old_id: position id for duplicate
     * @param type int $duplicate_id: new position id
     */
    public static function duplcateDataPosition($old_id, $duplicate_id)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        // Get list appagebuilder for copy
        $sql = 'SELECT * from '._DB_PREFIX_.'appagebuilder p WHERE p.id_appagebuilder_positions='.(int)$old_id;
        $result = Db::getInstance()->executeS($sql);
        foreach ($result as $item) {
            // Duplicate to tables appagebuilder
            $sql = 'INSERT INTO '._DB_PREFIX_.'appagebuilder (id_appagebuilder_positions, hook_name)
				VALUES("'.(int)$duplicate_id.'", "'.pSQL($item['hook_name']).'")';
            Db::getInstance()->execute($sql);
            // Duplicate to tables appagebuilder_shop
            $id_new = Db::getInstance()->Insert_ID();
            $sql = 'INSERT INTO '._DB_PREFIX_.'appagebuilder_shop (id_appagebuilder, id_shop)
					VALUES('.(int)$id_new.', '.(int)$id_shop.')';
            Db::getInstance()->execute($sql);
            // Copy data and languages
            $sql = 'SELECT * from '._DB_PREFIX_.'appagebuilder_lang p 
					 WHERE p.id_appagebuilder='.(int)$item['id_appagebuilder'];
            $old_data = Db::getInstance()->executeS($sql);
            foreach ($old_data as $temp) {
                $sql = 'INSERT INTO '._DB_PREFIX_."appagebuilder_lang (id_appagebuilder, id_lang, params)
				VALUES('".(int)$id_new."', '".(int)$temp['id_lang']."', '".pSql(self::replaceFormId($temp['params']))."')";
                Db::getInstance()->execute($sql);
            }
        }
    }

    public static function importData($language, $lang_id)
    {
        $upload_file = new Uploader('importFile');
        $upload_file->setAcceptTypes(array('xml'));
        $file = $upload_file->process();
        $file = $file[0];
        $files_content = simplexml_load_file($file['save_path']);
        $hook_list = array();
        $hook_list = array_merge($hook_list, explode(',', Configuration::get('HEADER_HOOK')));
        $hook_list = array_merge($hook_list, explode(',', Configuration::get('CONTENT_HOOK')));
        $hook_list = array_merge($hook_list, explode(',', Configuration::get('FOOTER_HOOK')));
        $hook_list = array_merge($hook_list, explode(',', Configuration::get('PRODUCT_HOOK')));
        $import_for = Tools::getValue('import_for');
        $override = Tools::getValue('override');
        self::$language = Language::getLanguages(false);
        $id_profile = Tools::getValue('id_profile');
        $profile = new ApPageBuilderProfilesModel($id_profile);
        if (!$profile->id || !$profile->header || !$profile->content || !$profile->footer || !$profile->product) {
            // validate module
            die('Pease click save Profile before run import function. click back to try again!');
        }

        $lang_iso = 'en';
        $lang_list = array();
        foreach ($language as $lang) {
            $lang_list[$lang['iso_code']] = $lang['id_lang'];
            if ($lang['id_lang'] == $lang_id) {
                $lang_iso = $lang['iso_code'];
            }
        }
        // Import all mdoule
        if (isset($files_content->module)) {
            if ($import_for != 'all') {
                return 'ERORR_ALL';
            }
            $module = $files_content->module;
            foreach ($hook_list as $hook) {
                $import_hook = $module->{$hook};
                $model = new ApPageBuilderModel();
                foreach ($language as $lang) {
                    $obj = $model->getIdbyHookNameAndProfile($hook, $profile, $lang_list[$lang['iso_code']]);
                    if ($override) {
                        $params = self::replaceFormId($import_hook->{$lang['iso_code']});
                    } else {
                        $params = $obj['params'];
                        $params .= self::replaceFormId($import_hook->{$lang['iso_code']});
                    }
                    $model->updateAppagebuilderLang($obj['id_appagebuilder'], $lang_list[$lang['iso_code']], $params);
                }
            }
        }
        // Import a position
        else if (isset($files_content->position)) {
            $arr_positions = array('header', 'content', 'footer', 'product');
            if (!in_array($import_for, $arr_positions)) {
                return 'ERORR_POSITION';
            }
            $position = $files_content->position;
            $hook_name = '';
            if ($import_for == 'header') {
                $hook_name = 'HEADER_HOOK';
            } else if ($import_for == 'content') {
                $hook_name = 'CONTENT_HOOK';
            } else if ($import_for == 'footer') {
                $hook_name = 'FOOTER_HOOK';
            } else if ($import_for == 'product') {
                $hook_name = 'PRODUCT_HOOK';
            }
            $hook_list = explode(',', Configuration::get($hook_name));
            foreach ($hook_list as $hook) {
                $import_hook = $position->{$hook};
                $model = new ApPageBuilderModel();
                foreach ($language as $lang) {
                    $obj = $model->getIdbyHookNameAndProfile($hook, $profile, $lang_list[$lang['iso_code']]);
                    if ($override) {
                        $params = self::replaceFormId($import_hook->{$lang['iso_code']});
                    } else {
                        $params = $obj['params'];
                        $params .= self::replaceFormId($import_hook->{$lang['iso_code']});
                    }
                    $model->updateAppagebuilderLang($obj['id_appagebuilder'], $lang_list[$lang['iso_code']], $params);
                }
            }
        }
        // Import only for a group - a hook
        else {
            $arr_positions = array('header', 'content', 'footer', 'product');
            if ($import_for == 'all' || in_array($import_for, $arr_positions)) {
                return 'ERORR_NOT_ALL';
            }
            $import_hook = $import_for;
            $hook = $import_for;
            foreach ($language as $lang) {
                $model = new ApPageBuilderModel();
                $obj = $model->getIdbyHookNameAndProfile($hook, $profile, $lang_list[$lang['iso_code']]);
                if ($override) {
                    $params = self::replaceFormId($files_content->{$lang['iso_code']});
                } else {
                    $params = $obj['params'];
                    $params .= self::replaceFormId($files_content->{$lang['iso_code']});
                }
                $model->updateAppagebuilderLang($obj['id_appagebuilder'], $lang_list[$lang['iso_code']], $params);
            }
        }
        // validate module
        unset($lang_iso);
        return 'ok';
    }

    public static function replaceFormId($param)
    {
        preg_match_all('/form_id="([^\"]+)"/i', $param, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $row) {
            if (!isset(self::$replaced_element[$row[0]])) {
                $form_id = 'form_id="form_'.ApPageSetting::getRandomNumber().'"';
                self::$replaced_element[$row[0]] = $form_id;
            } else {
                $form_id = self::$replaced_element[$row[0]];
            }
            $param = str_replace($row[0], $form_id, $param);
        }
        preg_match_all('/ id="([^\"]+)"/i', $param, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $row) {
            if (!isset(self::$replaced_element[$row[0]])) {
                if (strpos($row[0], 'tab')) {
                    $form_id = ' id="tab_'.ApPageSetting::getRandomNumber().'"';
                } else if (strpos($row[0], 'accordion')) {
                    $form_id = ' id="accordion_'.ApPageSetting::getRandomNumber().'"';
                } else if (strpos($row[0], 'collapse')) {
                    $form_id = ' id="collapse_'.ApPageSetting::getRandomNumber().'"';
                } else {
                    $form_id = '';
                }
                self::$replaced_element[$row[0]] = $form_id;
            } else {
                $form_id = self::$replaced_element[$row[0]];
            }
            if ($form_id) {
                $param = str_replace($row[0], $form_id, $param);
                //ifreplace id="accordion_8223663723713862" to new id="accordion_8223663723713862"
                if (strpos($row[0], 'accordion')) {
                    $parent_id = Tools::substr(str_replace(' id="accordion_', 'accordion_', $row[0]), 0, -1);
                    $parent_form_id = Tools::substr(str_replace(' id="accordion_', 'accordion_', $form_id), 0, -1);
                    $param = str_replace(' parent_id="'.$parent_id.'"', ' parent_id="'.$parent_form_id.'"', $param);
                }
            }
        }
        return $param;
    }

    public function renderForm()
    {
        $type_shortcode = Tools::ucfirst(Tools::getValue('type_shortcode'));
        $type = Tools::getValue('type');
        $shor_code_dir = '';
        // Add new widget from apollotheme
        if ($type === 'widget') {
            if (!$shor_code_dir = ApPageSetting::requireShortCode($type_shortcode.'.php', $this->theme_dir)) {
                die($this->l('This short code is not exist'));
            }
            if (class_exists($type_shortcode) != true) {
                // validate module
                require_once($shor_code_dir);
            }

            $obj = new $type_shortcode;
            die($obj->renderForm());
        }
        // Custom a module
        elseif ($type === 'module') {
            $shor_code_dir = ApPageSetting::requireShortCode('ApModule.php', $this->theme_dir);
            if (class_exists('ApModule') != true) {
                // validate module
                require_once ($shor_code_dir);
            }
            $obj = new ApModule();
            die($obj->renderForm());
        }
        die;
    }

    public function adminContent($assign, $tpl_name)
    {
        if (file_exists($this->tpl_controller_path.$tpl_name)) {
            $tpl = $this->createTemplate($tpl_name);
        } else {
            $tpl = $this->createTemplate('ApGeneral.tpl');
        }
        $assign['moduleDir'] = _MODULE_DIR_;
        foreach ($assign as $key => $ass) {
            $tpl->assign(array($key => $ass));
        }
        return $tpl->fetch();
    }

    public function createXmlFile($title)
    {
        $file_content = '<?xml version="1.0" encoding="UTF-8"?>';
        $file_content .= '<data>';
        $file_content .= $this->file_content;
        $file_content .= '</data>';
        //save file content to sample data

        $folder = $this->theme_dir.'export/';
        if (!is_dir($folder)) {
            mkdir($folder, 0755);
        }
        if ($title == 'all') {
            $title = 'appagebuilder';
        }

        ApPageSetting::writeFile($folder, $title.'.xml', $file_content);

        echo $this->theme_url.'export/'.$title.'.xml';
    }

    public function postProcess()
    {
        $action = Tools::getValue('action');
        $type = Tools::getValue('type');
        if ($action == 'save' || $action == 'export') {
            $data = $this->saveData($action, $type);
            if ($action == 'export' && $data) {
                if ($type == 'all') {
                    $this->file_content = '<module>';
                    foreach ($data as $key => $hook) {
                        $this->file_content .= '<'.$key.'>';
                        if (is_string($hook)) {
                            $hook = array();
                        }
                        foreach ($hook as $lang => $group) {
                            $this->file_content .= '<'.$lang.'>';
                            $this->file_content .= '<![CDATA['.$group.']]>';
                            $this->file_content .= '</'.$lang.'>';
                        }
                        $this->file_content .= '</'.$key.'>';
                    }
                    $this->file_content .= '</module>';
                }
                // Export position
                else if (strpos($type, 'position') !== false) {
                    $this->file_content = '<position>';
                    foreach ($data as $key => $hook) {
                        $this->file_content .= '<'.$key.'>';
                        if (is_string($hook)) {
                            $hook = array();
                        }
                        foreach ($hook as $lang => $group) {
                            $this->file_content .= '<'.$lang.'>';
                            $this->file_content .= '<![CDATA['.$group.']]>';
                            $this->file_content .= '</'.$lang.'>';
                        }
                        $this->file_content .= '</'.$key.'>';
                    }
                    $this->file_content .= '</position>';
                }
                //export group
                else if ($type == 'group') {
                    foreach ($data as $lang => $group) {
                        if (is_string($group)) {
                            $this->file_content .= '<'.$lang.'>';
                            $this->file_content .= '<![CDATA['.$group.']]>';
                            $this->file_content .= '</'.$lang.'>';
                        }
                    }
                } else {
                    //export all group in hook
                    foreach ($data as $lang => $group) {
                        if (is_string($group)) {
                            $this->file_content .= '<'.$lang.'>';
                            $this->file_content .= '<![CDATA['.$group.']]>';
                            $this->file_content .= '</'.$lang.'>';
                        }
                    }
                }
                $this->createXmlFile($type);
            }
            die;
        }
    }

    public function saveData($action, $type)
    {
        //apPageHelper::loadShortCode($this->theme_dir);
        $data_form = Tools::getValue('dataForm');
        $data_form = Tools::jsonDecode($data_form, 1);
        self::$language = Language::getLanguages(false);
        $data = array();
        $arr_id = array('header' => 0, 'content' => 0, 'footer' => 0, 'product' => 0);
        foreach ($data_form as $hook) {
            $position_id = (int)isset($hook['position_id']) ? $hook['position_id'] : '0';
            $hook['position'] = (isset($hook['position']) && $hook['position']) ? $hook['position'] : '';
            $hook['name'] = (isset($hook['name']) && $hook['name']) ? $hook['name'] : 0;
            $position = Tools::strtolower($hook['position']);
            $arr_id[$position] = (isset($arr_id[$position]) && $arr_id[$position]) ? $arr_id[$position] : '';
            // apPageHelper::log("$position_id - $position", true);
            // Create new position with name is auto random, and save id of new for other positions reuse
            // position for other hook in this position to variable $header, $content...
            if ($position_id == 0 && $arr_id[$position] == 0) {
                $key = ApPageSetting::getRandomNumber();
                $position_controller = new AdminApPageBuilderPositionsController();
                $position_data = array('name' => $position.$key,
                    'position' => $position,
                    'position_key' => 'position'.$key);
                $position_id = $position_controller->autoCreatePosition($position_data);
                $arr_id[$position] = $position_id;
            } else if ($position_id != 0 && $arr_id[$position] == 0) {
                $arr_id[$position] = $position_id;
            }
            $obj_model = new ApPageBuilderModel();
            $obj_model->id = $obj_model->getIdbyHookName($hook['name'], $arr_id[$position]);
            $obj_model->hook_name = $hook['name'];
            $obj_model->page = 'index';
            $obj_model->id_appagebuilder_positions = $arr_id[$position];
            if (isset($hook['groups'])) {
                foreach (self::$language as $lang) {
                    $params = '';
                    if (self::$shortcode_lang) {
                        foreach (self::$shortcode_lang as &$s_type) {
                            foreach ($s_type as $key => $value) {
                                $s_type[$key] = $key.'_'.$lang['id_lang'];
                                // validate module
                                unset($value);
                            }
                        }
                    }
                    $obj_model->params[$lang['id_lang']] = '';
                    ApShortCodesBuilder::$lang_id = $lang['id_lang'];
                    foreach ($hook['groups'] as $groups) {
                        $params = $this->getParamByHook($groups, $params, $hook['name'], $action);
                    }
                    $obj_model->params[$lang['id_lang']] = $params;
                    if ($action == 'export') {
                        $data[$lang['iso_code']] = (isset($data[$lang['iso_code']]) && $data[$lang['iso_code']]) ? $data[$lang['iso_code']] : '';
                        $data[$hook['name']][$lang['iso_code']] = (isset($data[$hook['name']][$lang['iso_code']]) && $data[$hook['name']][$lang['iso_code']]) ? $data[$hook['name']][$lang['iso_code']] : '';

                        if ($type == 'all' || (strpos($type, 'position') !== false)) {
                            $data[$hook['name']][$lang['iso_code']] .= $params;
                        } else {
                            $data[$lang['iso_code']] .= $params;
                        }
                    }
                }
            }
            if ($action == 'save') {
                if ($obj_model->id) {
                    $this->clearModuleCache();
                    $obj_model->save();
                } else {
                    $this->clearModuleCache();
                    $obj_model->add();
                }
                $path = _PS_ROOT_DIR_.DS.'cache'.DS.'smarty'.DS.'cache'.DS.$this->module_name;
                $this->deleteDirectory($path);
            }
        }
        if ($action == 'save') {
            $obj_model->id_appagebuilder_profiles = Tools::getValue('id_profile');
            $profile = new ApPageBuilderProfilesModel($obj_model->id_appagebuilder_profiles);

            # Fix : must keep other data in param. ( exception + other data )
            $params = Tools::jsonDecode($profile->params);
            isset($params->fullwidth_index_hook) ? $this->config_module['fullwidth_index_hook'] = $params->fullwidth_index_hook : false;
            isset($params->fullwidth_other_hook) ? $this->config_module['fullwidth_other_hook'] = $params->fullwidth_other_hook : false;

            $profile->params = Tools::jsonEncode($this->config_module);
            $profile->header = $arr_id['header'];
            $profile->content = $arr_id['content'];
            $profile->footer = $arr_id['footer'];
            $profile->product = $arr_id['product'];
            $profile->save();
        }
        return $data;
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir) || is_link($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDirectory($dir.'/'.$item)) {
                chmod($dir.'/'.$item, 0777);
                if (!$this->deleteDirectory($dir.'/'.$item)) {
                    return false;
                }
            }
        }
        return rmdir($dir);
    }

    public function getProduct()
    {
        // validate module
        return true;
    }

    public function clearModuleCache()
    {
        $module = new APPageBuilder();
        $module->clearHookCache();
    }

    public function saveExceptionConfig($hook, $type, $page, $ids)
    {
        if (!$type) {
            return;
        }

        if ($type == 'all') {
            if ($type != '') {
                $list = explode(',', $page);
                foreach ($list as $val) {
                    $val = trim($val);
                    if ($val && (!is_array($this->config_module) || !isset($this->config_module[$hook]) || !isset($this->config_module[$hook]['exception']) || !isset($val, $this->config_module[$hook]['exception']))) {
                        $this->config_module[$hook]['exception'][] = $val;
                    }
                }
            }
        } else {
            $this->config_module[$hook][$type] = array();
            if ($type != 'index') {
                $ids = explode(',', $ids);
                foreach ($ids as $val) {
                    $val = trim($val);
                    if (!in_array($val, $this->config_module[$hook][$type])) {
                        $this->config_module[$hook][$type][] = $val;
                    }
                }
            }
        }
    }

    public function getParamByHook($groups, $params, $hook, $action = 'save')
    {
        $groups['params']['specific_type'] = (isset($groups['params']['specific_type']) && $groups['params']['specific_type']) ? $groups['params']['specific_type'] : '';
        $groups['params']['controller_pages'] = (isset($groups['params']['controller_pages']) && $groups['params']['controller_pages']) ? $groups['params']['controller_pages'] : '';
        $groups['params']['controller_id'] = (isset($groups['params']['controller_id']) && $groups['params']['controller_id']) ? $groups['params']['controller_id'] : '';
        $params .= '[ApRow'.ApShortCodesBuilder::converParamToAttr($groups['params'], 'ApRow', $this->theme_dir).']';
        //check exception page
        $this->saveExceptionConfig($hook, $groups['params']['specific_type'], $groups['params']['controller_pages'], $groups['params']['controller_id']);
        foreach ($groups['columns'] as $columns) {
            $columns['params']['specific_type'] = (isset($columns['params']['specific_type']) && $columns['params']['specific_type']) ? $columns['params']['specific_type'] : '';
            $columns['params']['controller_pages'] = (isset($columns['params']['controller_pages']) && $columns['params']['controller_pages']) ? $columns['params']['controller_pages'] : '';
            $columns['params']['controller_id'] = (isset($columns['params']['controller_id']) && $columns['params']['controller_id']) ? $columns['params']['controller_id'] : '';
            $this->saveExceptionConfig($hook, $columns['params']['specific_type'], $columns['params']['controller_pages'], $columns['params']['controller_id']);
            $params .= '[ApColumn'.ApShortCodesBuilder::converParamToAttr($columns['params'], 'ApColumn', $this->theme_dir).']';
            foreach ($columns['widgets'] as $widgets) {
                if ($widgets['type'] == 'ApTabs' || $widgets['type'] == 'ApAccordions') {
                    $params .= '['.$widgets['type'].ApShortCodesBuilder::converParamToAttr($widgets['params'], $widgets['type'], $this->theme_dir).']';
                    foreach ($widgets['widgets'] as $sub_widgets) {
                        $type_sub = Tools::substr($widgets['type'], 0, -1);
                        $params .= '['.$type_sub.ApShortCodesBuilder::converParamToAttr($sub_widgets['params'], str_replace('_', '_sub_', $widgets['type']), $this->theme_dir).']';
                        foreach ($sub_widgets['widgets'] as $sub_widget)
                            $params .= '['.$sub_widget['type']
                                    .ApShortCodesBuilder::converParamToAttr($sub_widget['params'], $sub_widget['type'], $this->theme_dir).'][/'
                                    .$sub_widget['type'].']';
                        $params .= '[/'.$type_sub.']';
                    }
                    $params .= '[/'.$widgets['type'].']';
                } else {
                    $params .= '['.$widgets['type'].ApShortCodesBuilder::converParamToAttr($widgets['params'], $widgets['type'], $this->theme_dir).'][/'.$widgets['type'].']';
                    if ($widgets['type'] == 'ApModule' && $action == 'save') {
                        $is_delete = (int)$widgets['params']['is_display'];
                        if ($is_delete) {
                            $this->deleteModuleFromHook($widgets['params']['hook'], $widgets['params']['name_module']);
                        }
                    } else if ($widgets['type'] == 'ApProductCarousel') {
                        if ($widgets['params']['order_way'] == 'random') {
                            $this->config_module[$hook]['productCarousel']['order_way'] = 'random';
                        }
                    }
                }
            }
            $params .= '[/ApColumn]';
        }
        $params .= '[/ApRow]';
        return $params;
    }

    public function getImageList($sort_by)
    {
        $path = $this->img_path;
        $images = glob($path.'/{*.jpeg,*.JPEG,*.jpg,*.JPG,*.gif,*.GIF,*.png,*.PNG}', GLOB_BRACE);
        if (!$images) {
            $images = $this->getAllImage($path);
        }
        if ($sort_by == 'name_desc') {
            rsort($images);
        }
        if ($sort_by == 'date' || $sort_by == 'date_desc') {
            array_multisort(array_map('filemtime', $images), SORT_NUMERIC, SORT_DESC, $images);
        }
        if ($sort_by == 'date_desc') {
            rsort($images);
        }
        $result = array();
        foreach ($images as &$file) {
            $file_info = pathinfo($file);
            $result[] = array('name' => $file_info['basename'], 'link' => $this->img_url.$file_info['basename']);
        }
        return $result;
    }

    public function getAllImage($path)
    {
        $images = array();
        foreach (scandir($path) as $d) {
            if (preg_match('/(.*)\.(jpg|png|gif|jpeg)$/', $d)) {
                $images[] = $d;
            }
        }
        return $images;
    }

    public function ajaxProcessaddSliderImage()
    {
        if (isset($_FILES['file'])) {
            $image_uploader = new HelperUploader('file');
            if (!is_dir($this->img_path)) {
                if (!is_dir(_PS_ALL_THEMES_DIR_.$this->theme_name.'/img')) {
                    mkdir(_PS_ALL_THEMES_DIR_.$this->theme_name.'/img', 0755);
                }
                if (!is_dir(_PS_ALL_THEMES_DIR_.$this->theme_name.'/img/modules')) {
                    mkdir(_PS_ALL_THEMES_DIR_.$this->theme_name.'/img/modules', 0755);
                }
                mkdir(_PS_ALL_THEMES_DIR_.$this->theme_name.'/img/modules/leosliderlayer', 0755);
            }
            $image_uploader->setSavePath($this->img_path);
            $image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'))->setMaxSize($this->max_image_size);
            $files = $image_uploader->process();
            $total_errors = array();
            foreach ($files as &$file) {
                $errors = array();
                // Evaluate the memory required to resize the image: ifit's too much, you can't resize it.
                if (!ImageManager::checkImageMemoryLimit($file['save_path'])) {
                    $errors[] = Tools::displayError('Due to memory limit restrictions, this image cannot be loaded. 
							Please increase your memory_limit value via your server\'s configuration settings. ');
                }
                if (count($errors)) {
                    $total_errors = array_merge($total_errors, $errors);
                }
                //unlink($file['save_path']);
                //Necesary to prevent hacking
                unset($file['save_path']);
                //Add image preview and delete url
            }
            if (count($total_errors)) {
                $this->context->controller->errors = array_merge($this->context->controller->errors, $total_errors);
            }
            $images = $this->getImageList('date');
            $tpl = $this->createTemplate('imagemanager.tpl');
            $tpl->assign(array(
                'images' => $images,
                'reloadSliderImage' => 1,
                'link' => Context::getContext()->link
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }
    }

    public function deleteModuleFromHook($hook_name, $module_name)
    {
        $res = true;
        $sql = 'DELETE FROM `'._DB_PREFIX_.'hook_module`
				WHERE
				`id_hook` IN(
					SELECT
						`id_hook`
					FROM
						`'._DB_PREFIX_.'hook`
					WHERE
						name ="'.pSQL($hook_name).'")
						AND `id_module` IN(
							SELECT `id_module` FROM
							`'._DB_PREFIX_.'module`
							WHERE name ="'.pSQL($module_name).'")';
        $res &= Db::getInstance()->execute($sql);
        return $res;
    }
}
