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

if (!defined('_PS_VERSION_'))
    exit;
if (file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widgetbase.php'))
    require_once( _PS_MODULE_DIR_ . 'leotempcp/classes/widgetbase.php' );
if (file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widget.php'))
    require_once( _PS_MODULE_DIR_ . 'leotempcp/classes/widget.php' );
require_once( _PS_MODULE_DIR_ . 'leomanagewidgets/classes/LeoManageWidget.php' );
require_once( _PS_MODULE_DIR_ . 'leomanagewidgets/classes/LeoManageWidgetGroup.php' );

class LeoManagewidgets extends Module {

    private $_html = '';
    private $_postErrors = array();
    private $_hooksPos = array();
    private $_hooksException = array();
    private $_widgets = array();
    private $_groupField = array();
    private $_columnField = array();
    private $_groupList = array();
    private $_columnList = array();
    private $_widgetObj;
    private $_currentPage;
    private $_themeName;
    private $_hookAssign = '';

    function __construct() {
        $this->name = 'leomanagewidgets';
        $this->tab = 'leotheme';
        $this->version = '2.0';
        $this->author = 'LeoTheme';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->_themeName = Context::getContext()->shop->getTheme();
        parent::__construct();
        
        //hook name is lower
        $this->_hooksPos = array(
            'displayNav',
            'displayTop',
            'displaySlideshow',
            'topNavigation',
            'displayTopColumn',
            'displayLeftColumn',
            'displayHome',
            'displayContentBottom',
            'displayRightColumn',
            'displayBottom',
            'displayFooterTop',
            'displayfooter',
            'displayFooterBottom',
            'displayFootNav',
            'productTabContent',
            'productFooter',
            'displayRightColumnProduct');
        //$this->_hooksException = array('displayRightColumn'=>array(""));
        $langList = Language::getLanguages(false);
        $gParam = array("class", "background");
        foreach($langList as $lang){
            $gParam[] = 'title_'.$lang["id_lang"];
        }
        $this->_hookAssign = array('rightcolumn', 'leftcolumn','topcolumn', 'home', 'top', 'footer','nav');
        $this->_groupField = array("id", "active", "hook_name", "type", "position", "params" => $gParam);
        $this->_columnField = array("id", "active", "id_group", "key_widget", "position", "params" => array("module","hook","class", "lg", "md", "sm", "xs", "sp" ,"background", "pages"));
        
        if (strtolower(Tools::getValue('controller')) == 'adminmodules' && Tools::getValue('configure') == $this->name){
            $leoWidget = new LeoTempcpWidget();
            $this->_widgets = $leoWidget->getWidgets();
        }
        
        $this->displayName = $this->l('Leo Manage Widget');
        $this->description = $this->l('Leo Manage Widget support Leo FrameWork Verion 3.0.');
    }

    /**
     * @see Module::install()
     */
    public function install() {
        /* Adds Module */
        $res = true;
        if (parent::install()){
            $res &= $this->registerHook("header");
            $res &= $this->registerHook("actionShopDataDuplication");
            foreach($this->_hooksPos as $value){
                $res &= $this->registerHook($value);
            }
        }
        /* Creates tables */
        $res &= $this->createTables();

        return (bool)$res;
    }

    /**
     * Creates tables
     */
    protected function createTables() {
        /* Group type:0-top 1-middle 2-bottom */
        if($this->_installDataSample()) return true;
        $res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'leomanagewidget_group` (
				`id_leomanagewidget_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
                                `position` int(10) unsigned NOT NULL DEFAULT \'0\',
                                `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                                `hook_name` varchar(64) NOT NULL,
                                `type` int(1) unsigned,
                                `params` text,
				PRIMARY KEY (`id_leomanagewidget_group`, `id_shop`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');
        
        /* widget configuration */
        $res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'leomanagewidget` (
			  `id_leomanagewidget` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `id_group` int(10) unsigned NOT NULL,
                          `id_shop` int(10) unsigned NOT NULL,
			  `position` int(10) unsigned NOT NULL DEFAULT \'0\',
			  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                          `key_widget` int(10) unsigned NOT NULL,
                          `params` text,
			  PRIMARY KEY (`id_leomanagewidget`, `id_shop`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
		');
        
        return $res;
    }

    private function _installDataSample(){
        if (!file_exists(_PS_MODULE_DIR_ . 'leotempcp/libs/DataSample.php')) return false;        
        require_once( _PS_MODULE_DIR_ . 'leotempcp/libs/DataSample.php' );
        
        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }
    
    public function uninstall() {
        if (parent::uninstall()) {
            /* Deletes tables */
            return true;
            $res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'leomanagewidget`,`'._DB_PREFIX_.'leomanagewidget_group`;');
            return $res;
        }
    }

    /**
     * deletes tables
     */
    protected function deleteTables() {
        $slides = $this->getSlides();
        foreach ($slides as $slide) {
            $to_del = new HomeSlide($slide['id_slide']);
            $to_del->delete();
        }

        return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'homeslider`, `' . _DB_PREFIX_ . 'homeslider_slides`, `' . _DB_PREFIX_ . 'homeslider_slides_lang`;
		');
    }

    public function getContent() {
        if (!file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widgetbase.php')){
            return $this->l("Please install leotemcp module");
        }
        if (!file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widgetbase.php') || !file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widget.php'))
            return '<div class="alert alert-danger">' . $this->l("Please install module leotemcp") . '</div>';
        
        if(Tools::isSubmit('correctData')){
            $this->correctData();
        }
        
        $this->headerHTML();

        if (Tools::isSubmit('submitMWidget')) {
            $this->_postProcess();
        }

        return $this->renderForm();
    }
    
    public function correctData(){
        $groups = LeoManageWidgetGroup::getAllGroupId(-1);
        foreach($groups as $group_id){
            $groupObj = new LeoManageWidgetGroup($group_id);
            if(Validate::isLoadedObject($groupObj)){
                $tmp = Tools::unSerialize($groupObj->params);
                if($tmp){
                    $groupObj->params = base64_encode(Tools::jsonEncode($tmp));
                    $groupObj->save();
                }
            }
            
        }
        
        $columns = LeoManageWidget::getAllColumnId(-1);
        
        foreach($columns as $column_id){
            $columnObj = new LeoManageWidget($column_id);
            if(Validate::isLoadedObject($columnObj)){
                $tmp = Tools::unSerialize($columnObj->params);
                if($tmp){
                    $columnObj->params = base64_encode(Tools::jsonEncode($tmp));           
                    $columnObj->save();
                }
            }
            
        }
        
        $this->_html = $this->displayConfirmation($this->l('Correct data done.'));
    }
    
    private function _postProcess() {
        $listGroupId = LeoManageWidgetGroup::getAllGroupId();
        $listColumnId = LeoManageWidget::getAllColumnId();
        $res = 1;
        $data_form = Tools::getValue("data_form");
        $data_form = Tools::jsonDecode($data_form, true);
        //echo "<pre>";print_r($data_form);die;
        $context = Context::getContext();
        $id_shop = $context->shop->id;

        if ($data_form["deletedObj"]) {
            //delete column
            if (isset($data_form["deletedObj"]["deletedColumn"]) && $data_form["deletedObj"]["deletedColumn"]) {
                $columnList = explode(",", $data_form["deletedObj"]["deletedColumn"]);
                //remove empty element
                $columnList = array_filter($columnList);
                foreach ($columnList as $value) {
                    if ($value && ($key = array_search($value, $listColumnId)) !== false) {
                        $columnModel = new LeoManageWidget();
                        $columnModel->id = $value;
                        if ($columnModel->delete())
                            unset($listColumnId[$key]);
                    }
                }
            }
            //delete group
            if (isset($data_form["deletedObj"]["deletedGroup"]) && $data_form["deletedObj"]["deletedGroup"]) {
                $groupList = explode(",", $data_form["deletedObj"]["deletedGroup"]);
                $groupList = array_filter($groupList);
                foreach ($groupList as $value) {
                    if ($value && ($key = array_search($value, $listGroupId)) !== false) {
                        $groupModel = new LeoManageWidgetGroup();
                        $groupModel->id = $value;
                        if ($groupModel->delete())
                            unset($listGroupId[$key]);
                    }
                }
            }
        }
        $positionGroupByHook = array();
        $positionColumnByGroup = array();

        if ($data_form["groups"]) {
            foreach ($data_form["groups"] as $group) {

                if (!isset($group["params"]) || !$group["params"]) {
                    continue;
                }
                //get all group value
                $params = $group["params"];

                $groupModel = new LeoManageWidgetGroup();
                //asign group value to model object
                foreach ($this->_groupField as $gKey => $gField) {
                    if (is_array($gField)) {
                        $tmpObj = array();
                        foreach ($gField as $gF) {
                            if (isset($params[$gF]))
                                $tmpObj[$gF] = $params[$gF];
                        }
                        $groupModel->{$gKey} = base64_encode(Tools::jsonEncode($tmpObj));
                    }
                    else
                        $groupModel->{$gField} = $params[$gField];
                }
                //assign postion number for group in each hook
                if (!isset($positionGroupByHook[$groupModel->hook_name])) {
                    $groupModel->position = 1;
                    $positionGroupByHook[$groupModel->hook_name] = 1;
                } else {
                    $positionGroupByHook[$groupModel->hook_name] = (int)$positionGroupByHook[$groupModel->hook_name] + 1;
                    $groupModel->position = $positionGroupByHook[$groupModel->hook_name];
                }
                $groupModel->id_shop = $id_shop;
                $groupModel->hook_name = strtolower($groupModel->hook_name);
                //add new group
                
                if ($groupModel->id == 0 || !in_array($groupModel->id, $listGroupId)) {
                    if (!$groupModel->add()) {
                        $res = 0;
                        $this->_html .= $this->displayError('Could add new Group in hook %s.', $groupModel->hook_name);
                    }
                } else {
                    if (!$groupModel->update()) {
                        $res = 0;
                        $this->_html .= $this->displayError('Could update Group in hook %s.', $groupModel->hook_name);
                    }
                }
                if (isset($group["columns"]) && $group["columns"])
                    foreach ($group["columns"] as $column) {
                        $columnModel = new LeoManageWidget();
                        //asign group value to model object
                        foreach ($this->_columnField as $cKey => $cField) {
                            if (is_array($cField)) {
                                $tmpObj = array();
                                foreach ($cField as $cF) {
                                    if (isset($column[$cF]))
                                        $tmpObj[$cF] = $column[$cF];
                                }
                                $columnModel->{$cKey} = base64_encode(Tools::jsonEncode($tmpObj));
                            }
                            else
                                $columnModel->{$cField} = $column[$cField];
                        }
                        //assign grop ID
                        $columnModel->id_group = $groupModel->id;
                        //assign postion number for column in each group
                        if (!isset($positionColumnByGroup[$columnModel->id_group])) {
                            $columnModel->position = 1;
                            $positionColumnByGroup[$columnModel->id_group] = 1;
                        } else {
                            $positionColumnByGroup[$columnModel->id_group] = (int)$positionColumnByGroup[$columnModel->id_group] + 1;
                            $columnModel->position = $positionColumnByGroup[$columnModel->id_group];
                        }

                        $columnModel->id_shop = $id_shop;

                        if ($columnModel->id == 0 || !in_array($columnModel->id, $listColumnId)) {
                                if (!$columnModel->add()) {
                                $res = 0;
                                    $this->_html .= $this->displayError('Add process is error');
                            }
                          } else {
                                 if (!$columnModel->update()){
                                    $res = 0;
                                    $this->_html .= $this->displayError('Update process is error');
            }
                        }//close else
                        if(isset($column["deleteModule"]) && $column["deleteModule"] == "1"){
                                $this -> deleteModuleFromHook($column["hook"], $column["module"]);
                        }
                    }//close a column
            }//close a group
        }//close group
        
        $this->clearHookCache();
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);
        //$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('The configuration could not be updated.')));
    }

    public function makeFieldsOptions() {
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Manage Widget control Page'),
                'icon' => 'icon-cogs'
            ),
            'description' => $this->l('You can create new column from Avail Widget. Please consider when creating column in non-group or group'),
            'submit' => array(
                'title' => $this->l('Save'),
            ),
            'input' => array(
                array(
                    'type' => 'hook_list',
                    'name' => 'hook_list',
                ),
                array(
                    'type' => 'setting_form',
                    'name' => 'setting_form',
                ),
            ),
            'buttons' => array(
                array(
                    'id' => 'closeoropen',
                    'class' => 'closeoropen',
                    'title' => $this->l('Close all Forms'),
                    'icon' => 'process-icon-minus',
                ),
                array(
                    'id' => 'openorclose',
                    'class' => 'closeoropen',
                    'title' => $this->l('Expand all Forms'),
                    'icon' => 'process-icon-plus',
                ),
                array(
                    'id' => 'correctdata',
                    'title' => $this->l('Correct Data'),
                    'icon' => 'process-icon-edit',
                    'name' => 'correctData',
                    'type' => 'submit',
                ),
                array(
                    'title' => $this->l('Manage Widget'),
                    'icon' => 'process-icon-cogs',
                    'class' => 'button btn btn-addnewwidget'
                )
            ),
            'submit' => array(
                'id' => 'leobtnsave',
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right leobtnsave'
            ),
        );
        $i = 1;
        foreach ($this->_hooksPos as $hook) {
            $hook = strtolower($hook);
            $fields_form[$i]['form'] = array(
                'input' => array(
                    array(
                        'type' => 'hook_data',
                        'name' => $hook,
                        'lang' => true,
                    ),
                ),
                'buttons' => array(
                    array(
                        'title' => $this->l('Manage Widget'),
                        'icon' => 'process-icon-cogs',
                        'class' => 'button btn btn-addnewwidget'
                    )
                ),
                'submit' => array(
                    'id' => 'leobtnsave_' . $hook,
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right leobtnsave'
                ),
            );
            $i++;
        }

        return $fields_form;
    }

    public function headerHTML() {
        if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
            return;

        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addCSS($this->_path . 'assets/admin/style.css');
        $this->context->controller->addJS($this->_path . 'assets/admin/script.js');
        $this->context->controller->addJS($this->_path . 'assets/admin/bootbox.js');
        $this->context->controller->addJS(_PS_JS_DIR_.'jquery/plugins/jquery.colorpicker.js');
        //$this->context->controller->addJqueryUI('ui.resizable');
    }

    public function formatWidget() {
        $widgets = array();
        $widgetsByID = array();
        foreach ($this->_widgets as $key => $value) {
            $widgets[$value["type"]][] = array("id" => $value["key_widget"], "name" => $value["name"]);
            $widgetsByID[$value["name"]] = $value;
        }
        return $widgets;
    }

    public function parseColumnByGroup($dataColumn, $isfont=0) {
        $result = array();
        foreach ($dataColumn as $row) {
            $row["id"] = $row["id_leomanagewidget"];
            unset($row["id_leomanagewidget"]);
            if ($row["params"]) {
                $myParam = Tools::jsonDecode(base64_decode($row["params"]), true);
                if($myParam)
                    foreach ($myParam as $key => $value) {
                        $row[$key] = $value;
                    }
                //set class for column
                $tmpArray = array("lg", "md", "sm", "xs", "sp");
                $row["col_value"] = "";
                foreach ($tmpArray as $col)
                    if (isset($row[$col]) && $row[$col]){
                        $valCol = $row[$col];
                        if (strpos($valCol, ".") !== false) $valCol = str_replace('.','-',$valCol);
                        $row["col_value"] .= " col-" . $col . "-" . $valCol;
                    }
            }
            unset($row["params"]);
            //call from font-office
            if($isfont){
                if((isset($row['key_widget']) && $row['key_widget']) || (isset($row['module']) && $row['module']))
                $result[$row["id_group"]][] = $row;
            }
            else
                $result[$row["id_group"]][] = $row;
        }
        return $result;
    }

    public function parseGroupByHook($dataGroup) {
        $result = array();
        $titleLang = "title_".$this->context->language->id;
        foreach ($dataGroup as $row) {
            $row["id"] = $row["id_leomanagewidget_group"];
            unset($row["id_leomanagewidget_group"]);
            if ($row["params"]) {
                $myParam = Tools::jsonDecode(base64_decode($row["params"]), true);
                if($myParam)
                foreach ($myParam as $key => $value) {
                    $row[$key] = $value;
                    if($key == $titleLang){
                        $row["title"] = $value;
                    }
                }
            }
            unset($row["params"]);
            //add column to group
            if (isset($this->_columnList[$row["id"]])) {
                $row["columns"] = $this->_columnList[$row["id"]];
            }
            $result[$row["hook_name"]][$row["type"]][] = $row;
        }
        return $result;
    }

    public function displayModuleExceptionList() {
        $file_list = array();
        $shop_id = 0;
        $content = '<p><input type="text" name="column_pages" value="" class="em_text"/></p>';

        $content .= '<p>
                                    <select size="25" name="column_pages_select" class="em_list" multiple="multiple">
                                    <option disabled="disabled">' . $this->l('___________ CUSTOM ___________') . '</option>';

        // @todo do something better with controllers
        $controllers = Dispatcher::getControllers(_PS_FRONT_CONTROLLER_DIR_);
        $controllers['module'] = $this->l('Module Page');
        ksort($controllers);

        foreach ($file_list as $k => $v)
            if (!array_key_exists($v, $controllers))
                $content .= '<option value="' . $v . '">' . $v . '</option>';

        $content .= '<option disabled="disabled">' . $this->l('____________ CORE ____________') . '</option>';

        foreach ($controllers as $k => $v)
            $content .= '<option value="' . $k . '">' . $k . '</option>';

        $modules_controllers_type = array('admin' => $this->l('Admin modules controller'), 'front' => $this->l('Front modules controller'));
        foreach ($modules_controllers_type as $type => $label)
        {
            $content .= '<option disabled="disabled">____________ '.$label.' ____________</option>';
            $all_modules_controllers = Dispatcher::getModuleControllers($type);
            foreach ($all_modules_controllers as $module => $modules_controllers)
                foreach ($modules_controllers as $cont)
                $content .= '<option value="module-'.$module.'-'.$cont.'">module-'.$module.'-'.$cont.'</option>';
        }
        $content .= '</select>
                                    </p>';
        return $content;
    }

    public function renderForm() {
        //get all group and column
        $this->_columnList = $this->parseColumnByGroup(LeoManageWidget::getAllColumn('',0,1));
        $this->_groupList = $this->parseGroupByHook(LeoManageWidgetGroup::getAllGroup());
        
        $fields_form = $this->makeFieldsOptions();
       
        $widthArray = array(
                                1=>array('12'=> $this->l("1/1")),
                                2=>array('6'=> $this->l("1/2")),
                                3=>array('4'=> $this->l("1/3"),'8'=> $this->l("2/3")),
                                4=>array('3'=> $this->l("1/4"),'9'=> $this->l("3/4")),
                                5=>array('2.4'=> $this->l("1/5"),'4.8'=> $this->l("2/5"),'7.2'=> $this->l("3/5"),'9.6'=> $this->l("4/5")),
                                6=>array('2'=> $this->l("1/6"),'10'=> $this->l("5/6"))
                            );
        $widthArray = array('12','10','9.6','9','8','7.2','6','4.8','4','3','2.4','2','1');
        //$widthArray = array("12"=>);
        //echo "<pre>";print_r($widthArray);die;
        $widgets = $this->formatWidget();

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitMWidget';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $groupField = 'new Array(';
        //set widget field
        foreach ($this->_groupField as $val) {
            if (!is_array($val))
                $groupField .= '"' . $val . '",';
            else
                foreach ($val as $paramv) {
                    $groupField .= '"' . $paramv . '",';
                }
        }
        $groupField = substr($groupField, 0, -1) . ');';
        //die($groupField);
        $columnField = 'new Array(';
        //set widget field
        foreach ($this->_columnField as $val) {
            if (!is_array($val))
                $columnField .= '"' . $val . '",';
            else
                foreach ($val as $paramv) {
                    $columnField .= '"' . $paramv . '",';
                }
        }
        $columnField = substr($columnField, 0, -1) . ');';
        $hidden_config = array('hidden-lg'=>$this->l('Hidden in Large devices'),'hidden-md'=>$this->l('Hidden in Medium devices'),
            'hidden-sm'=>$this->l('Hidden in Small devices'),'hidden-xs'=>$this->l('Hidden in Extra small devices'),'hidden-sp'=>$this->l('Hidden in Smart Phone'));
        $leo_json_data = json_encode($this->_groupList);
        $leo_json_data = str_replace(array("\n", "\r", "\t", '\'', '"'), array("","","","\'",'\"'), $leo_json_data);
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'leo_widgets' => $widgets,
            'leo_modules'=>$this->getModules(),
            'leo_width' => $widthArray,
            'img_admin_url' => _PS_ADMIN_IMG_,
            'leo_groupField' => $groupField,
            'leo_columnField' => $columnField,
            'leo_group_list' => $this->_groupList,
            'leo_json_data' => $leo_json_data,
            'leo_tpl_group' => _PS_MODULE_DIR_ . $this->name . '/views/templates/admin/_configure/helpers/form/form_grouplist.tpl',
            'exception_list' => $this->displayModuleExceptionList(),
            'leo_submit_link' => $this->context->shop->physical_uri . $this->context->shop->virtual_uri . 'modules/' . $this->name . '/ajax_' . $this->name . '.php?secure_key=' . $this->secure_key . '&action=submitForm',
            'widget_link' => Context::getContext()->link->getAdminLink('AdminLeotempcpWidgets'),
			'module_link' => Context::getContext()->link->getAdminLink('AdminModules'),
            'languages'   => $this->context->controller->getLanguages(),
            'hidden_config' => $hidden_config
        );

        $helper->override_folder = '/';

        return $helper->generateForm($fields_form);
    }
    public function deleteModuleFromHook($hook_name, $module_name){
            $res = true;
            $sql = "        DELETE
                            FROM
                                `"._DB_PREFIX_."hook_module`
                            WHERE
                                `id_hook` IN(
                                    SELECT
                                        `id_hook`
                                    FROM
                                        `"._DB_PREFIX_."hook`
                                    WHERE
                                        NAME ='" .$hook_name."'".
                    "            )
                            AND `id_module` IN(
                                SELECT
                                    `id_module`
                                FROM
                                    `"._DB_PREFIX_."module`
                                WHERE
                                    NAME ='" .$module_name."')";
            $res &= Db::getInstance()->execute($sql);
            return $res;
    }
    public function getAddFieldsValues() {
        
    }

    public function clearCache() {
        
    }

    public function getConfigFieldsValues() {
        return array(
            'HOME_FEATURED_NBR' => Tools::getValue('HOME_FEATURED_NBR', Configuration::get('HOME_FEATURED_NBR')),
        );
    }
    
    private function _setGroupData($groupsList, $hook_name) {
        foreach ($groupsList as $groupType => &$groups) {
            foreach ($groups as &$group) {
                if (isset($group["columns"]))
                    foreach ($group["columns"] as &$column) {
                        $pages = array();
                        if (isset($column["pages"]) && $column["pages"]){
                            $column["pages"] = str_replace(", ", ",", $column["pages"]);
                            $pages = explode(",", $column["pages"]);
                        }
                        //check show in current page
                        if (in_array($this->_currentPage, $pages) || (in_array('module', $pages) && Tools::getIsset('fc'))) {
                            $column["active"] = 0;
                        } else {
                             //is a widget
                            if ($column["key_widget"] != 0) {
                                $content = $this->_widgets->renderContent($column["key_widget"]);
                                $column["content"] = $this->getWidgetContent($hook_name, $column["key_widget"], $content['type'], $content['data']);
                            //is a module   
                            }else{
                                    if(isset($column["module"]) && isset($column["hook"]) && $column["module"] && $column["hook"]){
                                        $column["content"] = $this -> execModuleHook($column["hook"], array(), $column["module"], false, $this->context->shop->id);
                                    }
                            }
                        }
                    }
            }
        }
        return $groupsList;
    }
    
    /**
     *
     */
    public function getWidgetContent( $hook_name, $key_widget, $type, $data ){
        $data['id_lang'] =   $this->context->language->id;
        $this->smarty->assign( $data );
        //check override widget key
        if(file_exists(_PS_ALL_THEMES_DIR_.$this->_themeName.'/modules/leomanagewidgets/views/widgets/'.$hook_name.'/'.$key_widget.'/widget_'.$type.'.tpl')){
            $output = $this->display(__FILE__, 'views/widgets/'.$hook_name.'/'.$key_widget.'/widget_'.$type.'.tpl' );
        }elseif (file_exists(dirname(__FILE__).'/views/widgets/'.$hook_name.'/'.$key_widget.'/widget_'.$type.'.tpl')) {
            $output = $this->display(__FILE__, 'views/widgets/'.$hook_name.'/'.$key_widget.'/widget_'.$type.'.tpl' );
        }
        //override widget in hook_name
        elseif (file_exists(_PS_ALL_THEMES_DIR_.$this->_themeName.'/modules/leomanagewidgets/views/widgets/'.$hook_name.'/widget_'.$type.'.tpl') ){
            $output = $this->display(__FILE__, 'views/widgets/'.$hook_name.'/widget_'.$type.'.tpl' );
        }
        elseif (file_exists(dirname(__FILE__).'/views/widgets/'.$hook_name.'/widget_'.$type.'.tpl')) {
            $output = $this->display(__FILE__, 'views/widgets/'.$hook_name.'/widget_'.$type.'.tpl' );
        }else {
            $output = $this->display(__FILE__, 'views/widgets/widget_'.$type.'.tpl' );
        }
        
        return $output;

    }
    
    private function _processHook($hook_name){
        $hook_name = strtolower($hook_name);
        if (!file_exists(_PS_MODULE_DIR_ . 'leotempcp/classes/widgetbase.php')){
            return $this->l("Please install leotemcp module");
        }
        if (file_exists(_PS_ALL_THEMES_DIR_.$this->_themeName.'/modules/leomanagewidgets/views/widgets/'.$hook_name.'/group.tpl')) {
            $tplFile = '/views/widgets/'.$hook_name.'/group.tpl';
        }elseif (file_exists(dirname(__FILE__).'/views/widgets/'.$hook_name.'/group.tpl')) {
            $tplFile = '/views/widgets/'.$hook_name.'/group.tpl';
        }else{
            $tplFile = '/views/widgets/group.tpl';
        }
        if (!$this->isCached($tplFile, $this->getCacheId($this->name.$hook_name)))
        {
            if(!$this->_currentPage){
               $this->_currentPage = Dispatcher::getInstance()->getController();
            }
            if(!$this->_widgets){
                $this->_widgets = new LeoTempcpWidget();
                $this->_widgets->setTheme( Context::getContext()->shop->getTheme());
                $this->_widgets->langID =  Context::getContext()->language->id;
                $this->_widgets->loadWidgets();
                $this->_widgets->loadEngines();
            }
            if(!$this->_groupList){
                $this->_columnList = $this->parseColumnByGroup(LeoManageWidget::getAllColumn(" AND mw.`active`=1"), 1);
                $this->_groupList = $this->parseGroupByHook(LeoManageWidgetGroup::getAllGroup(" AND `active`=1"));
            }
            $groups = array();
            if(isset($this->_groupList[$hook_name])){
                //load container
                $groups = $this->_setGroupData($this->_groupList[$hook_name], $hook_name);
                $this->smarty->assign('leoGroup', $groups);
            }else{
                return;
            }
        }
        
        return $this->display(__FILE__, $tplFile , $this->getCacheId($this->name.$hook_name));
    }
    public static function execModuleHook($hook_name, $hook_args = array(), $module_name, $use_push = false, $id_shop = null)
    {
        static $disable_non_native_modules = null;
        if ($disable_non_native_modules === null)
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
        // Check arguments validity
        if (!Validate::isModuleName($module_name) || !Validate::isHookName($hook_name))
            throw new PrestaShopException('Invalid module name or hook name');
        // If no modules associated to hook_name or recompatible hook name, we stop the function
        if (!$module_list = Hook::getHookModuleExecList($hook_name))
            return '';
        // Check if hook exists
        if (!$id_hook = Hook::getIdByName($hook_name))
            return false;
        // Store list of executed hooks on this page
        Hook::$executed_hooks[$id_hook] = $hook_name;
        $live_edit = false;
        $context = Context::getContext();
        if (!isset($hook_args['cookie']) || !$hook_args['cookie'])
            $hook_args['cookie'] = $context->cookie;
        if (!isset($hook_args['cart']) || !$hook_args['cart'])
            $hook_args['cart'] = $context->cart;
        $retro_hook_name = Hook::getRetroHookName($hook_name);
        // Look on modules list
        $altern = 0;
        $output = '';
        if ($disable_non_native_modules && !isset(Hook::$native_module))
            Hook::$native_module = Module::getNativeModuleList();
        $different_shop = false;
        if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID())
        {   
            $old_context_shop_id = $context->shop->getContextShopID();
            $old_context = $context->shop->getContext();
            $old_shop = clone $context->shop;
            $shop = new Shop((int)$id_shop);
            if (Validate::isLoadedObject($shop))
            {
                $context->shop = $shop;
                $context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
                $different_shop = true;
            }
        }
        // Check errors
        if ((bool)$disable_non_native_modules && Hook::$native_module && count(Hook::$native_module) && !in_array($module_name, self::$native_module))
            return;
        if (!($moduleInstance = Module::getInstanceByName($module_name)))
            return;

        if ($use_push && !$moduleInstance->allow_push)
            return false;
        // Check which / if method is callable
        //echo($hook_name);die;
        $hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
        $hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));
    
        if (($hook_callable || $hook_retro_callable) && Module::preCall($moduleInstance->name))
        {
            $hook_args['altern'] = ++$altern;
            if ($use_push && isset($moduleInstance->push_filename) && file_exists($moduleInstance->push_filename))
                Tools::waitUntilFileIsModified($moduleInstance->push_filename, $moduleInstance->push_time_limit);
            // Call hook method
            if ($hook_callable)
                $display = $moduleInstance->{'hook'.$hook_name}($hook_args);
            elseif ($hook_retro_callable)
                $display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);

                $output .= $display;
        }
        if ($different_shop)
        {
            $context->shop = $old_shop;
            $context->shop->setContext($old_context, $shop->id);
        }
        return $output;// Return html string
    }
    public function getModules(){
        $notModule = array( $this->name, 'leoblog', 'leotempcp', 'themeinstallator', 'cheque' );
        $where = '';
        if( count($notModule) == 1){
                $where = ' WHERE m.`name` <> \''.$notModule[0].'\'';
        }elseif( count($notModule) > 1){
                $where = ' WHERE m.`name` NOT IN (\''.implode("','",$notModule).'\')';
        }
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $modules = Db::getInstance()->ExecuteS('
        SELECT m.name, m.id_module
        FROM `'._DB_PREFIX_.'module` m
        JOIN `'._DB_PREFIX_.'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = '.(int)($id_shop).')
        '.$where );
        $result = array();
        foreach ($modules as $m) {
            $m['hook_list'] = "";
            $arrHooks = $this -> getHooksByModuleId($m['id_module'], $id_shop);
            if($arrHooks){
                $strArrHooks = "";
                if(count($arrHooks) > 0){
                    $strArrHooks= $arrHooks[0]['name'];
                    //find if exist a row of module-hook in database
                    if($this -> checkModuleInHook($m['id_module'], $arrHooks[0]['id_hook'])){
                        $strArrHooks .= '-'.'1';
                    }else{
                        $strArrHooks .= '-'.'0';
                    }
                }
                if(count($arrHooks)>1)
                    for($i=1; $i < count($arrHooks); $i++){
                        $strArrHooks .= ','. $arrHooks[$i]['name'] ;
                        if($this -> checkModuleInHook($m['id_module'], $arrHooks[$i]['id_hook'])){
                            $strArrHooks .= '-'.'1';
                        }else{
                            $strArrHooks .= '-'.'0';
                        }
                   }
                $m['hook_list'] = $strArrHooks;
            }
            $result[] = $m;
        }
        //echo "<pre>";print_r($result);die;
        return $result;
    }
        /**
     * Get list of all registered hooks with modules
     *
     * @since 1.5.0
     * @return array
     */
    public static function checkModuleInHook($module_id, $id_hook)
    {
        if(!$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT *
            FROM `'._DB_PREFIX_.'hook_module` hm
            WHERE hm.id_module = '.$module_id. 
                ' AND hm.id_hook = '.$id_hook
            ))
            return false;
        else return true;
    }
    public static function getHookModuleList($module_id, $position= false)
    {
            $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT h.id_hook, h.name as h_name, title, description, h.position, live_edit, hm.position as hm_position, m.id_module, m.name, active
            FROM `'._DB_PREFIX_.'hook` h 
            INNER JOIN `'._DB_PREFIX_.'hook_module` hm ON (h.id_hook = hm.id_hook AND hm.id_shop = '.(int)Context::getContext()->shop->id.')
            INNER JOIN `'._DB_PREFIX_.'module` as m ON (m.id_module = hm.id_module) AND m.id_module =' .(int)$module_id. '
            '.($position ? 'WHERE h.`position` = 1' : '').'
            ORDER BY hm.position');
            return $results;
    }
    public function getModulById( $id_module, $id_shop ){
        return Db::getInstance()->getRow('
        SELECT m.*
        FROM `'._DB_PREFIX_.'module` m
        JOIN `'._DB_PREFIX_.'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = '.(int)($id_shop).')
        WHERE m.`id_module` = '.$id_module);
    }
    public static function getHookByArrName($arrName){
            $result = Db::getInstance()->ExecuteS('
            SELECT `id_hook`, `name`
            FROM `'._DB_PREFIX_.'hook` 
            WHERE `name` IN (\''.implode("','",$arrName).'\')');
            return $result ;
    }
    public function getHooksByModuleId( $id_module, $id_shop ){
        $module = self::getModulById( $id_module, $id_shop );
        $moduleInstance = Module::getInstanceByName( $module['name'] );
        //echo "<pre>";print_r($moduleInstance);die;
        $hooks = array();
        if($this->_hookAssign)
                foreach( $this->_hookAssign as $hook){
                    $retro_hook_name = Hook::getRetroHookName($hook);
                    if($hook == "topcolumn")
                        $retro_hook_name = "displayTopColumn";
                    if($hook == "nav")
                        $retro_hook_name = "displayNav";
                    if (is_callable(array($moduleInstance, 'hook'.$hook)) || is_callable(array($moduleInstance, 'hook'.$retro_hook_name))){
                            $hooks[] = $retro_hook_name;
                    }
                }
        $results = self::getHookByArrName( $hooks );
        return $results;
    }
    public function hookDisplayNav(){
        return $this->_processHook("displayNav");
    }
    
    public function hookDisplayTop() {
        return $this->_processHook("displayTop");
    }

    public function hookDisplayHeaderRight() {
        return $this->_processHook("displayHeaderRight");
    }

    public function hookDisplaySlideshow() {
        return $this->_processHook("displaySlideshow");
    }

    public function hookTopNavigation() {
        return $this->_processHook("topNavigation");
    }

    public function hookDisplayPromoteTop() {
        return $this->_processHook("displayPromoteTop");
    }

    public function hookDisplayRightColumn() {
        return $this->_processHook("displayRightColumn");
    }

    public function hookDisplayLeftColumn() {
        return $this->_processHook("displayLeftColumn");
    }

    public function hookDisplayHome() {
        return $this->_processHook("displayHome");
    }

    public function hookDisplayFooter() {
        return $this->_processHook("displayFooter");
    }

    public function hookDisplayBottom() {
        return $this->_processHook("displayBottom");
    }

    public function hookDisplayContentBottom() {
        return $this->_processHook("displayContentBottom");
    }

    public function hookDisplayFootNav() {
        return $this->_processHook("displayFootNav");
    }

    public function hookDisplayFooterTop() {
        return $this->_processHook("displayFooterTop");
    }

    public function hookDisplayFooterBottom() {
        return $this->_processHook("displayFooterBottom");
    }
    
    public function hookHeader(){
        $this->context->controller->addCSS($this->_path.'assets/styles.css');
        $this->context->controller->addJS($this->_path.'js/script.js');
    }
    
    //public function hookProductTab(){
    //    return ($this->display(__FILE__, '/tab.tpl'));
    //}
    
    public function hookProductTabContent($params){
        return $this->_processHook("productTabContent");
    }
    
    public function hookProductFooter($params){
        return $this->_processHook("productFooter");
    }
    
    public function hookDisplayTopColumn(){
        return $this->_processHook("displayTopColumn");
    }
    
    public function displayFootNav(){
        return $this->_processHook("displayFootNav");
    }
    
    public function hookDisplayRightColumnProduct($params){
        return $this->_processHook("displayRightColumnProduct");
    }
    
    /*public function hookDisplayProductButtons(){
        return $this->_processHook("displayLeftColumnProduct");
    }*/
    

    public function hookActionShopDataDuplication($params)
    {
        //select all group
        $listGroupId = LeoManageWidgetGroup::getAllGroupId((int)$params['old_id_shop']);
        foreach ($listGroupId as $groupId){
            $group = new LeoManageWidgetGroup($groupId);
            $oldID = $group->id;
            $group->id_shop = (int)$params['new_id_shop'];
            $group->id = 0;
            if($group->add()){
                $columns = LeoManageWidget::getAllColumn(" AND `id_group` = ".$oldID, (int)$params['old_id_shop']);
                if($columns)
                foreach ($columns as $columnID){
                    $column = new LeoManageWidget($columnID["id_leomanagewidget"]);
                    $column->id = 0;
                    $column->id_group = $group->id;
                    $column->add();
                }
            }
        }
        
        $this->clearHookCache();
    }
    
    public function clearHookCache(){
        //$template, $cache_id
        foreach($this->_hooksPos as $val){
            $this->_clearCache('group.tpl', $this->name.$val);
        }
    }
    
    public function hookCategoryAddition($params) {
        $this->clearHookCache();
    }

    public function hookCategoryUpdate($params) {
        $this->clearHookCache();
    }

    public function hookCategoryDeletion($params) {
        $this->clearHookCache();
    }
    
    public function hookAddProduct($params) {
        $this->clearHookCache();
    }

    public function hookUpdateProduct($params) {
        $this->clearHookCache();
    }

    public function hookDeleteProduct($params) {
        $this->clearHookCache();
    }
    
}