<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Datasample
{
    private $_content = '';
    private $_createTable = '';
    public $_id_shop = 0;
    public $_id_lang = 0;
    private $_languages = array();
    private $_languagesKey = array();
    private $_html = array("error" => array(), "confirm" => array());
    private $_theme_dir = 'leo_tennis';
    private $_paramsMenu = '';
    private $_currentBackupFile = '';
    private $_langField = array('widget_title', 'text_link', 'htmlcontent', 'header', 'content', 'information');
    private $_imageField = array('htmlcontent', 'content', 'information', 'raw_html');
    private $_parentField = 'id_parent';

    public function __construct($findTheme = 0)
    {
        $this->context = Context::getContext();
        $context = Context::getContext();
        $this->_id_shop = $context->shop->id;
        $this->_id_lang = $this->context->language->id;
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $this->_languages[$lang["iso_code"]] = $lang["id_lang"];
            $this->_languagesKey[$lang["id_lang"]] = $lang["iso_code"];
        }
        $theme_dir = Context::getContext()->shop->getTheme();
        if ($findTheme) {
            $id_theme = Tools::getValue("id_theme");
            $themeInfo = new Theme($id_theme);
            if ($themeInfo->directory) {
                $this->_theme_dir = $themeInfo->directory;
            } else if (is_dir(_PS_ALL_THEMES_DIR_.$theme_dir.'/samples')) {
                $this->_theme_dir = $theme_dir;
            }
        } else {
            $this->_theme_dir = $theme_dir;
        }

        $this->_theme_dir .= '/';
    }
    /*
     * import sample data
     */

    public function processImport($moduleName = '')
    {
        $data = simplexml_load_file(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'config.xml');
        if (!$data || !isset($data->modules)) {
            return false;
        }
        if (!$moduleName) {
            $moduleList = Tools::getValue("moduleList");
        } else {
            $moduleList[] = $moduleName;
        }
        $error = 0;

        foreach ($moduleList as $module) {
            if (file_exists(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'samples/'.$module.'.xml')) {
                $content = simplexml_load_file(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'samples/'.$module.'.xml');
                if (!$content) {
                    $this->_html["error"][] = "Content of sample data of module: ".$module.' is null';
                    continue;
                }
                //insert sql first
                if (isset($content->sql) && $content->sql) {
                    $metaData = array(
                        'PREFIX_' => _DB_PREFIX_,
                        'ENGINE_TYPE' => _MYSQL_ENGINE_,
                    );
                    $cSql = str_replace(array_keys($metaData), array_values($metaData), Module::configXmlStringFormat($content->sql));
                    $queries = preg_split('#;\s*[\r\n]+#', $cSql);
                    foreach ($queries as $query) {
                        $query = trim($query);
                        if (!$query) {
                            continue;
                        }
                        Db::getInstance()->execute(($query));
                    }
                }

                //insert config
                if (isset($content->configurations) && $content->configurations)
                    foreach ($content->configurations->children() as $contentConfig) {
                        Configuration::updateValue(Module::configXmlStringFormat($contentConfig->name), Module::configXmlStringFormat($contentConfig->value));
                    }

                //insert hook
                if (isset($content->hooks) && $content->hooks) {
                    $moduleObj = Module::getInstanceByName($module);
                    if ($moduleObj && $moduleObj->id) {
                        $module_hook = array();
                        foreach ($content->hooks->children() as $row) {
                            $exceptions = array_filter(isset($row->attributes()->exceptions) ? explode(',', strval($row->attributes()->exceptions)) : array());

                            if (Hook::getIdByName(strval($row->attributes()->hook))) {
                                $module_hook[] = array(
                                    'hook' => strval($row->attributes()->hook),
                                    'position' => strval($row->attributes()->position),
                                    'exceptions' => $exceptions
                                );
                            }
                        }
                        if ((int)$moduleObj->id > 0) {
                            $this->hookModule($moduleObj->id, $module_hook, $this->_id_shop);
                        }
                    }
                }

                //insert data
                foreach ($content->fields as $fields) {
                    if (isset($fields->attributes()->table_name) && $fields->attributes()->table_name) {
                        $this->deleteDataByTableName((string)$fields->attributes()->table_name, $fields->attributes()->searchField, $this->_id_shop);
                        $this->importDataByTable($fields, (string)$fields->attributes()->table_name, (string)$fields->attributes()->struct);
                        continue;
                    }
                    if (isset($fields->attributes()->objectName) && $fields->attributes()->objectName) {
                        if (!$this->includeObjModel($module, (string)$fields->attributes()->objectFile))
                            continue;
                        $this->deleteDataOfModByShop((string)$fields->attributes()->objectName, $fields->attributes()->searchField, $this->_id_shop, $module);
                        $this->importData($fields, (string)$fields->attributes()->objectName, (string)$fields->attributes()->searchField, $this->_id_shop, $module);
                    }
                }
                if ($module == "leobootstrapmenu") {
                    Configuration::updateValue('LEO_MEGAMENU_PARAMS', '');
                    Configuration::updateValue('LEO_MEGAMENU_PARAMS', Tools::jsonEncode($this->_paramsMenu), true);
                }
                if ($module == "leomenusidebar") {
                    Configuration::updateValue('LEO_MENUSIDEBAR_PARAMS', '');
                    Configuration::updateValue('LEO_MENUSIDEBAR_PARAMS', Tools::jsonEncode($this->_paramsMenu), true);
                }
            } else {
                $this->_html["error"][] = "Can not find sample file of module: ".$module;
                $error = 1;
            }
            if (!$error) {
                $this->_html["confirm"][] .= 'Restore DataSample success for : '.$module;
            }
            // reset data import
            $this->_paramsMenu = '';
        }
        return !$error;
    }

    private function hookModule($id_module, $module_hooks, $shop)
    {
        Db::getInstance()->execute('INSERT IGNORE INTO '._DB_PREFIX_.'module_shop (id_module, id_shop) VALUES('.(int)$id_module.', '.(int)$shop.')');
        Db::getInstance()->execute($sql = 'DELETE FROM `'._DB_PREFIX_.'hook_module` WHERE `id_module` = '.pSQL($id_module).' AND id_shop = '.(int)$shop);

        foreach ($module_hooks as $hook) {
            $sql_hook_module = 'INSERT INTO `'._DB_PREFIX_.'hook_module` (`id_module`, `id_shop`, `id_hook`, `position`)
                                                        VALUES ('.(int)$id_module.', '.(int)$shop.', '.(int)Hook::getIdByName($hook['hook']).', '.(int)$hook['position'].')';

            if (count($hook['exceptions']) > 0) {
                foreach ($hook['exceptions'] as $exception) {
                    $sql_hook_module_except = 'INSERT INTO `'._DB_PREFIX_.'hook_module_exceptions` (`id_module`, `id_hook`, `file_name`) VALUES ('.(int)$id_module.', '.(int)Hook::getIdByName($hook['hook']).', "'.pSQL($exception).'")';

                    Db::getInstance()->execute($sql_hook_module_except);
                }
            }
            Db::getInstance()->execute($sql_hook_module);
        }
    }
    /*
     * 
     */

    public function importData($content, $objectMName, $searchField, $searchValue, $moduleName, $parentID = 0)
    {
        $obj = new $objectMName();
        $defined = $obj->getDefinition($obj);
        //top field to include file + define Object
        if ($parentID) {
            $realContent = $content->field;
        } else {
            $realContent = $content->children();
        }

        foreach ($realContent as $parrentField) {
            $parrentObj = new $objectMName();
            foreach ($defined["fields"] as $ke => $val) {
                if ($ke == "id") {
                    continue;
                }
                if ($ke == $searchField) {
                    $parrentObj->{$searchField} = $searchValue;
                    continue;
                }

                if (isset($val["lang"]) && $val["lang"]) {
                    $defaultData = array();
                    foreach ($this->_languages as $langC => $langID) {
                        if (isset($parrentField->{$ke}->$langC) && $parrentField->{$ke}->$langC) {
                            //echo "--lang".$ke.'--valule:'.Module::configXmlStringFormat($parrentField->{$ke}->$langC).'<br/>';
                            $parrentObj->{$ke}[$langID] = Module::configXmlStringFormat($parrentField->{$ke}->$langC);
                        } else {
                            $parrentObj->{$ke}[$langID] = Module::configXmlStringFormat($parrentField->{$ke}->en);
                        }
                    }
                } else if (isset($parrentField->{$ke})) {
                    if ($val["type"] == 3 || $val["type"] == 5 || $val["type"] == 6) {
                        //echo "--nolang-but cdata".$ke.'--valule:'.Module::configXmlStringFormat($parrentField->{$ke}).'<br/>';
                        $parrentObj->{$ke} = Module::configXmlStringFormat($parrentField->{$ke});
                    } else {
                        //echo "--nolang-".$ke.'--valule:'.$parrentField->{$ke}.'<br/>';
                        $parrentObj->{$ke} = (string)$parrentField->{$ke};
                    }
                }
            }
            if (($objectMName == 'Btmegamenu' || $objectMName == 'Sbmegamenu') && isset($obj->content_text)) {
                //change image link
                foreach ($obj->content_text as &$submenu_text) {
                    $submenu_text = str_replace('"modules/'.$moduleName, '"'.__PS_BASE_URI__.'modules/'.$moduleName, $submenu_text);
                    $submenu_text = str_replace('"themes/', '"'.__PS_BASE_URI__.'themes/', $submenu_text);
                }
            } else if ($objectMName == 'LeoTempcpWidget') {
                $widgetParam = Tools::jsonDecode(base64_decode($parrentField->params), true);

                $tmpWidParam = array();
                $defaultData = array();
                foreach ($widgetParam as $widKey => $widValue) {
                    //replace image url
                    foreach ($this->_imageField as $fVal) {
                        if (strpos($widKey, $fVal) !== false && strpos($widValue, 'img') !== false) {
                            $widValue = str_replace('src="modules/', 'src="'.__PS_BASE_URI__.'modules/', $widValue);
                            $widValue = str_replace('src="img/', 'src="'.__PS_BASE_URI__.'img/', $widValue);
                            $widValue = str_replace('src="themes/', 'src="'.__PS_BASE_URI__.'themes/', $widValue);
                            break;
                        }
                    }
                    $removeLangKey = preg_replace("/_en$/", "_", $widKey, -1, $count);
                    if ($count) {
                        $defaultData[$removeLangKey] = $widValue;
                    }

                    //replace from en to 1, and set lnguage if not exist
                    foreach ($this->_langField as $fVal) {
                        if (strpos($widKey, $fVal) !== false) {
                            foreach ($this->_languages as $lKey => $lValue) {
                                $widKey = preg_replace("/_".$lKey."$/", "_".$lValue, $widKey, -1, $count);
                                if ($count) {
                                    break;
                                }
                            }
                            break;
                        }
                    }

                    $tmpWidParam[$widKey] = $widValue;
                }
                //set data for other language if data sample is not support
                foreach ($this->_languages as $lKey => $lValue) {
                    foreach ($defaultData as $dKey => $dValue) {
                        if (!isset($tmpWidParam[$dKey.$lValue])) {
                            $tmpWidParam[$dKey.$lValue] = $dValue;
                        }
                    }
                }

                $parrentObj->params = base64_encode(Tools::jsonEncode($tmpWidParam));
            } elseif ($objectMName == 'LeoManageWidgetGroup') {
                $widgetParam = Tools::jsonDecode(base64_decode($parrentObj->params), true);
                $tmpWidParam = array();
                foreach ($widgetParam as $widKey => $widValue) {
                    if (strpos($widKey, 'title') !== false) {
                        foreach ($this->_languages as $lKey => $lValue) {
                            $widKey = preg_replace("/_".$lKey."$/", "_".$lValue, $widKey, -1, $count);
                            if ($count) {
                                break;
                            }
                        }
                    }
                    $tmpWidParam[$widKey] = $widValue;
                }
                $parrentObj->params = base64_encode(Tools::jsonEncode($tmpWidParam));
            }

            if ($moduleName == "leomanagewidgets" && !$parrentObj->id_shop) {
                $parrentObj->id_shop = $this->_id_shop;
            }

            if ($parentID) {
                $parrentObj->{$this->_parentField} = $parentID;
            }

            //root category of blog
            if ($moduleName == "leoblog" && (int)$parrentField->id == 1) {
                //update shop for root category
                $resultCheck = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT `id_leoblogcat` as id FROM `'._DB_PREFIX_.'leoblogcat_shop` WHERE `id_leoblogcat` = 1 AND `id_shop`='.(int)($this->_id_shop));
                if ($resultCheck["id"] != 1) {
                    Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'leoblogcat_shop`(`id_leoblogcat`,`id_shop`) VALUES( 1, '.(int)($this->_id_shop).' )');
                }
                $resultCheck = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT `id_leoblogcat` as id FROM `'._DB_PREFIX_.'leoblogcat` WHERE `id_leoblogcat` = 1');
                if ($resultCheck["id"] != 1) {
                    Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'leoblogcat`(`id_leoblogcat`,`id_parent`) VALUES( 1,0)');
                }
                foreach ($this->_languages as $langVal) {
                    Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'leoblogcat_lang`(`id_leoblogcat`,`id_lang`,`title`) VALUES(1, '.(int)$langVal.', \'Root\')');
                }
            } else if ($moduleName == "leobootstrapmenu" && (int)$parrentField->id == 1) {
                $resultCheck = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT `id_btmegamenu` as id FROM `'._DB_PREFIX_.'btmegamenu_shop` WHERE `id_btmegamenu` = 1 AND `id_shop`='.(int)($this->_id_shop));
                if ($resultCheck["id"] != 1) {
                    foreach ($this->_languages as $langVal) {
                        Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'btmegamenu_lang`(`id_btmegamenu`,`id_lang`,`title`) VALUES(1, '.(int)$langVal.', \'Root\')');
                    }
                    Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'btmegamenu_shop`(`id_btmegamenu`,`id_shop`) VALUES( 1, '.(int)($this->_id_shop).' )');
                }
            } else if ($moduleName == "leomenusidebar" && (int)$parrentField->id == 1) {
                $resultCheck = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT `id_sbmegamenu` as id FROM `'._DB_PREFIX_.'sbmegamenu_shop` WHERE `id_sbmegamenu` = 1 AND `id_shop`='.(int)($this->_id_shop));
                if ($resultCheck["id"] != 1) {
                    foreach ($this->_languages as $lang) {
                        Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'sbmegamenu_lang`(`id_sbmegamenu`,`id_lang`,`title`) VALUES(1, '.(int)$langVal.', \'Root\')');
                    }
                    Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'sbmegamenu_shop`(`id_sbmegamenu`,`id_shop`) VALUES( 1, '.(int)($this->_id_shop).' )');
                }
            } else if ($objectMName == "SliderLayer" && $this->isEmptyArray($parrentObj->title)) {
                
            } else {
                if ($objectMName != "ApPageBuilderProfilesModel") {
                    if (!$parrentObj->add()) {
                        //print_r($parrentObj);
                    }
                }
            }
            //update params widget for menu
            if (($objectMName == 'Btmegamenu' || $objectMName == 'Sbmegamenu') && isset($parrentField->params) && $parrentField->params && $parrentObj->id) {
                $configMenu = Module::configXmlStringFormat($parrentField->params);
                $configMenu = Tools::jsonDecode($configMenu);
                if (isset($configMenu->id)) {
                    $configMenu->id = $parrentObj->id;
                }
                $this->_paramsMenu[] = $configMenu;
            }
            //import database of sub menu
            if (isset($parrentField->child_field)) {
                if (isset($parrentField->child_field->attributes()->field)) {
                    $this->_parentField = (string)$parrentField->child_field->attributes()->field;
                }
                $this->importData($parrentField->child_field, $objectMName, $searchField, $searchValue, $moduleName, $parrentObj->id);
            }

            //only for appagebuilder
            if ($objectMName == "ApPageBuilderProfilesModel") {
                if (!$this->includeObjModel($moduleName, $parrentField->fields->attributes()->objectFile)) {
                    continue;
                }

                foreach ($parrentField->fields as $posField) {
                    $parrentObj->{(string)$posField->attributes()->position} = $this->importData($posField, (string)$posField->attributes()->objectName, (string)$posField->attributes()->searchField, (int)$parrentObj->id, $moduleName);
                }


                if (!$parrentObj->add()) {
                    
                }
            } else {
                if (isset($parrentField->fields)) {
                    if (!$this->includeObjModel($moduleName, $parrentField->fields->attributes()->objectFile)) {
                        continue;
                    }
                    $this->importData($parrentField->fields, (string)$parrentField->fields->attributes()->objectName, (string)$parrentField->fields->attributes()->searchField, (int)$parrentObj->id, $moduleName);
                }
            }
        }
        if (isset($parrentObj) && isset($parrentObj->id)) {
            return $parrentObj->id;
        }
    }

    public function isEmptyArray($array)
    {
        foreach ($array as $value) {
            if ($value) {
                return false;
            }
        }
        return true;
    }

    public function importDataByTable($content, $tableName)
    {
        $tableName = _DB_PREFIX_.$tableName;

        foreach ($content as $contentFields) {
            $isCorrect = 1;
            $sql = "INSERT IGNORE INTO `".pSQL($tableName)."`";
            $f = "(";
            $v = "VALUE (";
            $hookId = 0;
            $moduleId = 0;
            foreach ($contentFields as $kF => $vF) {
                if ($kF == "id_shop") {
                    $vF = $this->_id_shop.",";
                } else {
                    if (isset($vF->attributes()->type)) {
                        if ($vF->attributes()->type == "module_name") {
                            $moduleId = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT id_module FROM `'._DB_PREFIX_.'module'.'` WHERE name=\''.pSQL($vF).'\'');
                            if (!$moduleId) {
                                $isCorrect = 0;
                                break;
                            }
                            $vF = $moduleId.",";
                        } elseif ($vF->attributes()->type == "hook_name") {
                            $hookId = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT id_hook FROM `'._DB_PREFIX_.'hook'.'` WHERE name=\''.pSQL($vF).'\'');
                            //can not find hook name refunr
                            if (!$hookId) {
                                $isCorrect = 0;
                                break;
                            }
                            $vF = $hookId.",";
                        } else {
                            $vF = "'".$vF."',";
                        }
                    } else {
                        $vF = $vF.",";
                    }
                }

                $f .= "`".$kF."`,";
                $v .= $vF;
            }
            $f = Tools::substr($f, 0, -1).')';
            $v = Tools::substr($v, 0, -1).')';
            $sql .= " ".$f." ".$v;

            if ($isCorrect) {
                Db::getInstance()->execute($sql);
            }

            //insert module to hook_module table
            if ($isCorrect && $hookId && $moduleId) {
                $sql = "INSERT IGNORE INTO `"._DB_PREFIX_."hook_module` (`id_module` ,`id_shop` ,`id_hook` ,`position`) VALUES (".(int)$moduleId.",".(int)$this->_id_shop.",".(int)$hookId.",1)";
                Db::getInstance()->execute($sql);
            }
        }
    }

    public function deleteDataByTableName($tableName, $searchField, $searchValue)
    {
        $tableName = _DB_PREFIX_.$tableName;
        if (count(Db::getInstance()->executeS('SHOW TABLES LIKE \''.pSQL($tableName).'\''))) {
            $where = ' WHERE `'.$searchField.'`='.$searchValue;
            Db::getInstance()->execute("DELETE FROM `".pSQL($tableName)."` ".pSQL($where));
        }
    }
    /*
     * delete data of module by Shop
     */

    public function deleteDataOfModByShop($objectMName, $searchField, $searchValue, $moduleName)
    {
        $obj = new $objectMName();
        $defined = $obj->getDefinition($obj);
        $tableName = _DB_PREFIX_.$defined["table"];
        if (!count(Db::getInstance()->executeS('SHOW TABLES LIKE \''.pSQL($tableName).'\'')))
            return false;
        if ($searchField == "id_shop") {
            $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($tableName).'`');
            if (strpos($schema[0]['Create Table'], "`id_shop`") == false) {
                $tableName = _DB_PREFIX_.$defined["table"].'_shop';
            }
        }
        if ($searchField != "") {
            $where = ' WHERE `'.$searchField.'`='.$searchValue;
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'.pSQL($tableName).'`'.pSQL($where));
        foreach ($result as $value) {
            $obj = new $objectMName($value[$defined["primary"]]);
            if ($obj->id) {
                $obj->delete();
            }
        }
    }
    /*
     * create sample for module save in template file
     */

    public function processConfigs()
    {
        $savePath = _PS_ALL_THEMES_DIR_.$this->_theme_dir."samples/";
        if (!is_dir($savePath)) {
            if (!mkdir($savePath, 0755)) {
                die("Please create folder samples in "._PS_ALL_THEMES_DIR_.$this->_theme_dir." and set permission 755");
            }
        }
        $id_theme = Context::getContext()->shop->id_theme;
        $theme_name = Context::getContext()->shop->theme_name;
        $theme = Db::getInstance()->executeS('SELECT `responsive`,`default_left_column`,`default_right_column`,`product_per_page` FROM `'._DB_PREFIX_.'theme` WHERE id_theme='.(int)$id_theme.'');

        $theme_meta = Db::getInstance()->executeS('SELECT `id_meta`,`left_column`,`right_column` FROM `'._DB_PREFIX_.'theme_meta` WHERE id_theme='.(int)$id_theme.'');

        $this->_content = '<?xml version="1.0" encoding="UTF-8" ?>
            <dataSample>';
        $this->_content .= '<fields objectName="theme">';
        $this->getContentXml($theme);
        $this->_content .= '</fields>';
        $this->_content .= '<fields objectName="theme_meta">';
        $this->getContentXml($theme_meta);
        $this->_content .= '</fields>';
        $this->_content .=
                '</dataSample>';
        $fp = @fopen($savePath."themeconfig.xml", 'w');
        fwrite($fp, $this->_content);
        $this->_content = '';
        fclose($fp);
        $this->_html["confirm"][] .= 'Restore configs theme success';
    }

    public function processApplyConfigs()
    {
        $id_theme = Context::getContext()->shop->id_theme;
        $theme_name = Context::getContext()->shop->theme_name;
        $data = simplexml_load_file(_PS_ALL_THEMES_DIR_.$theme_name.'/samples/themeconfig.xml');
        if (!$data) {
            $this->_html["error"][] = "Can not find  field in themes/LEOTHEME/themeconfig.xml";
            return false;
        }
        foreach ($data->fields as $fields) {
            if (isset($fields->attributes()->objectName) && $fields->attributes()->objectName && $fields->attributes()->objectName == 'theme') {
                $json = json_encode($fields->field);
                $theme = json_decode($json, TRUE);
                $new_theme = new Theme($id_theme);
                foreach ($theme as $k => $field) {
                    $new_theme->$k = $field;
                }
                if ($new_theme->update()) {
                    foreach ($data->fields as $items) {
                        if (($items->attributes()->objectName == "theme_meta")) {
                            $jsons = json_encode($items);
                            $item = json_decode($jsons, TRUE);
                            $meta = $this->getMetaById($id_theme);
                            if (count($item) > 0) {
                                $this->deleteMeta($id_theme);
                            }
                            foreach ($item['field'] as $row) {
                                $this->addMeta($row, $id_theme);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getMetaById($id_theme)
    {
        return Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'theme_meta` WHERE id_theme='.(int)$id_theme.'');
    }

    public function deleteMeta($id_theme)
    {
        return Db::getInstance()->execute('DELETE  FROM `'._DB_PREFIX_.'theme_meta` WHERE id_theme='.(int)$id_theme.'');
    }

    public function addMeta($row, $id_theme)
    {
        $sql = "INSERT INTO `"._DB_PREFIX_."theme_meta`";
        $f = "(id_theme,id_meta,left_column,right_column)";
        $v = "VALUE (".(int)$id_theme.",".(int)$row['id_meta'].",".pSQL($row['left_column']).",".pSQL($row['right_column']).")";
        $sql .= " ".$f." ".$v;
        return Db::getInstance()->execute($sql);
    }

    public function getContentXml($items)
    {
        foreach ($items as $row) {
            $this->_content .= '
            <field>';
            foreach ($row as $key => $value) {
                if (in_array($key, $strList)) {
                    $this->_content .= '
                <'.$key.' type="string"><![CDATA['.$value.']]></'.$key.'>';
                } else {
                    $this->_content .= '
                <'.$key.'>'.$value.'</'.$key.'>';
                }
            }
            $this->_content .= '
            </field>';
        }
    }

    public function processSample()
    {
        $savePath = _PS_ALL_THEMES_DIR_.$this->_theme_dir."samples/";
        if (!is_dir($savePath)) {
            if (!mkdir($savePath, 0755)) {
                die("Please create folder samples in "._PS_ALL_THEMES_DIR_.$this->_theme_dir." and set permission 755");
            }
        }

        $data = simplexml_load_file(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'config.xml');
        if (!$data || !isset($data->modules)) {
            $this->_html["error"][] = "Can not find modules field in themes/LEOTHEME/config.xml";
            return false;
        }
        $moduleList = Tools::getValue("moduleList");
        if ($moduleList) {
            foreach ($data->modules->children() as $moduleXml) {
                //only create sample for module if select
                if (in_array((string)$moduleXml->name, $moduleList)) {
                    $this->_createTable = '';
                    $this->_content = '<?xml version="1.0" encoding="UTF-8" ?>
<dataSample>';
                    //export config of module first
                    if ($moduleXml->config_prefix) {

                        if (strpos((string)$moduleXml->config_prefix, ',') !== false) {
                            $listPrefix = explode(",", (string)$moduleXml->config_prefix);
                            $configs = array();
                            foreach ($listPrefix as $configPre) {
                                $listTmp = $this->getConfigByName($configPre);
                                if ($configs) {
                                    $configs = array_merge($configs, $listTmp);
                                } else {
                                    $configs = $listTmp;
                                }
                            }
                        } else {
                            $configs = $this->getConfigByName((string)$moduleXml->config_prefix);
                        }

                        if ($configs) {
                            $this->_content .= '<configurations>';
                            foreach ($configs as $config) {
                                if ($config["name"] != "LEO_MEGAMENU_PARAMS") {
                                    $this->_content .= '<config>';
                                    $this->_content .= '<name><![CDATA['.$config["name"].']]></name>';
                                    $this->_content .= '<value><![CDATA['.$config["value"].']]></value>';
                                    $this->_content .= '</config>';
                                }
                            }
                            $this->_content .= '</configurations>';
                        }
                    }
                    foreach ($moduleXml->fields->children() as $field) {
                        if (!isset($field->table_name)) {
                            if (!$this->includeObjModel($moduleXml->name, $field->objectMFile)) {
                                continue;
                            }
                        }

                        if (isset($field->table_name)) {
                            $this->_content .= '<fields table_name="'.$field->table_name.'" searchField="'.$field->searchField.'">';
                        } else {
                            $this->_content .= '<fields objectName="'.$field->objectMName.'" objectFile="'.$field->objectMFile.'" searchField="'.$field->searchField.'">';
                        }
                        if (isset($field->table_name)) {
                            $this->buildStructNoneObject($field, $field->searchField, $this->_id_shop, $field->string_column);
                        } else {
                            $this->buildStruct($field, $field->searchField, $this->_id_shop, $moduleXml->name);
                        }
                        $this->_content .= '</fields>';
                    }
                    //export create table
                    if (isset($moduleXml->table_prefix)) {
                        $prefixList = explode(",", (string)$moduleXml->table_prefix);
                        foreach ($prefixList as $pfl) {
                            $listTable = Db::getInstance()->executeS("SHOW TABLES LIKE  '%".pSQL($pfl)."%'");
                            foreach ($listTable as $table) {
                                //don't export back-up table
                                if (strpos(current($table), "leomanagewidget_backup") == false) {
                                    $this->showcreateTable(current($table));
                                }
                            }
                        }
                    }
                    $this->_content .= '<sql><![CDATA['.$this->_createTable.']]></sql>';
                    //export hook
                    $this->_content .= '<hooks>';
                    $hook_list = Db::getInstance()->executeS('
                SELECT h.`id_hook`, h.`name` as name_hook, hm.`position`, hm.`id_module`, m.`name` as name_module, GROUP_CONCAT(hme.`file_name`, ",") as exceptions
                FROM `'._DB_PREFIX_.'hook` h
                LEFT JOIN `'._DB_PREFIX_.'hook_module` hm ON hm.`id_hook` = h.`id_hook`
                LEFT JOIN `'._DB_PREFIX_.'module` m ON hm.`id_module` = m.`id_module`
                LEFT OUTER JOIN `'._DB_PREFIX_.'hook_module_exceptions` hme ON (hme.`id_module` = hm.`id_module` AND hme.`id_hook` = h.`id_hook`)
                WHERE hm.`id_shop` = '.(int)$this->_id_shop.' AND m.`name`= \''.pSQL((string)$moduleXml->name).'\'
                GROUP BY `id_module`, `id_hook`
                ORDER BY `name_module`');

                    foreach ($hook_list as $hook) {
                        $exception = '';
                        if (trim($hook["exceptions"]) != '' && $hook["exceptions"] != null) {
                            $exceptions = array_filter(isset($hook['exceptions']) ? explode(',', strval($hook['exceptions'])) : array());
                            $exceptions = implode(",", $exceptions);
                        }

                        $this->_content .= '<hook module="'.(string)$moduleXml->name.'" hook="'.$hook["name_hook"].'" position="'.$hook["position"].'" exceptions="'.$exception.'"/>';
                    }
                    $this->_content .= '</hooks>';
                    $this->_content .= '</dataSample>';

                    //replace sample for module
                    if ($moduleXml->name == 'appagebuilder') {
                        if (strpos($this->_content, "ApBlog") != false) {
                            preg_match_all('/chk_cat\=\"([^\"]+)\"{0,1}/i', $this->_content, $matches, PREG_OFFSET_CAPTURE);
                            if (isset($matches['1'])) {
                                foreach ($matches['1'] as $slideVal) {
                                    $where = " WHERE id_leoblogcat IN (".$slideVal[0].") AND id_lang = ".(int)$this->_id_lang;
                                    $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_leoblogcat,link_rewrite FROM `'._DB_PREFIX_.'leoblogcat_lang` '.pSQL($where));
                                    $blogLink = "";
                                    foreach ($result as $blogVal) {
                                        $blogLink .= ($blogLink == "") ? $blogVal['link_rewrite'] : ",".$blogVal['link_rewrite'];
                                    }

                                    $this->_content = str_replace('chk_cat="'.$slideVal[0].'"', 'chk_cat="'.$blogLink.'"', $this->_content);
                                }
                            }
                        }

                        //slideshow_group
                        if (strpos($this->_content, "ApSlideShow") != false) {
                            preg_match_all('/slideshow_group\=\"([^\"]+)\"{0,1}/i', $this->_content, $matches, PREG_OFFSET_CAPTURE);

                            if (isset($matches['1'])) {
                                $where = "";
                                foreach ($matches['1'] as $slideVal) {
                                    $where .= ($where == "") ? "".$slideVal[0] : ",".$slideVal[0];
                                }
                                $where = " WHERE id_leoslideshow_groups IN (".pSQL($where).")";
                                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_leoslideshow_groups,title FROM `'._DB_PREFIX_.'leoslideshow_groups` '.$where);
                                $strSearch = $strReplace = array();
                                foreach ($result as $slideVal) {
                                    $strSearch[] = 'slideshow_group="'.$slideVal['id_leoslideshow_groups'].'"';
                                    $strReplace[] = 'slideshow_group="'.$slideVal['title'].'"';
                                }
                                $this->_content = str_replace($strSearch, $strReplace, $this->_content);
                            }
                        }

                        //slideshow_group
                        if (strpos($this->_content, "ApSliderLayer") != false) {
                            preg_match_all('/slideshow_group\=\"([^\"]+)\"{0,1}/i', $this->_content, $matches, PREG_OFFSET_CAPTURE);

                            if (isset($matches['1'])) {
                                $where = "";
                                foreach ($matches['1'] as $slideVal) {
                                    $where .= ($where == "") ? "".$slideVal[0] : ",".$slideVal[0];
                                }
                                $where = " WHERE id_leosliderlayer_groups IN (".pSQL($where).")";
                                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_leosliderlayer_groups,title FROM `'._DB_PREFIX_.'leosliderlayer_groups` '.$where);
                                $strSearch = $strReplace = array();
                                foreach ($result as $slideVal) {
                                    $strSearch[] = 'slideshow_group="'.$slideVal['id_leosliderlayer_groups'].'"';
                                    $strReplace[] = 'slideshow_group="'.$slideVal['title'].'"';
                                }
                                $this->_content = str_replace($strSearch, $strReplace, $this->_content);
                            }
                        }
                    }

                    //save data
                    $fp = @fopen($savePath.$moduleXml->name.".xml", 'w');
                    fwrite($fp, $this->_content);
                    $this->_content = '';
                    fclose($fp);
                    $this->_html["confirm"][] .= 'Export success for : '.$moduleXml->name;
                    //reset data when done - in export
                    $this->_paramsMenu = null;
                }
            }
        }
    }

    public function showcreateTable($table)
    {
        $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($table).'`');
        $data = $schema[0]['Create Table'].";\n\n";
        $data = str_replace("CREATE TABLE `"._DB_PREFIX_, "CREATE TABLE IF NOT EXISTS `PREFIX_", $data);
        $data = str_replace("="._MYSQL_ENGINE_, "=ENGINE_TYPE", $data);
        $this->_createTable .= $data;
    }

    public function buildStructNoneObject($field, $searchField, $searchValue, $stringField)
    {
        $strList = explode(",", $stringField);
        $where = ' WHERE `'.pSQL($searchField).'`='.pSQL($searchValue);
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.pSQL($field->table_name).'`'.$where);

        foreach ($result as $row) {
            $this->_content .= '<field>';
            foreach ($row as $key => $value) {
                if (in_array($key, $strList)) {
                    $this->_content .= '<'.$key.' type="string"><![CDATA['.$value.']]></'.$key.'>';
                } else {
                    if ($field->table_name == "leohook" && $key == "id_module") {
                        $resultModule = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT name FROM `'._DB_PREFIX_.'module'.'` WHERE id_module='.(int)$value);
                        $this->_content .= '<'.$key.' type="module_name">'.$resultModule.'</'.$key.'>';
                    } elseif ($field->table_name == "leohook" && $key == "id_hook") {
                        $resultHook = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT name FROM `'._DB_PREFIX_.'hook'.'` WHERE id_hook='.(int)$value);
                        $this->_content .= '<'.$key.' type="hook_name">'.$resultHook.'</'.$key.'>';
                    } else {
                        $this->_content .= '<'.$key.'>'.$value.'</'.$key.'>';
                    }
                }
            }
            $this->_content .= '</field>';
        }
    }

    public function buildStruct($field, $searchField, $searchValue, $moduleName, $isChild = 0, $result = array())
    {
        $className = (string)$field->objectMName;
        $obj = new $className();

        $defined = $obj->getDefinition($obj);
        $tableName = _DB_PREFIX_.$defined["table"];
        if (!$isChild) {
            $tableShop = '';
            if ($searchField == "id_shop") {
                $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($tableName).'`');
                if (strpos($schema[0]['Create Table'], "`id_shop`") == false) {
                    $tableShop = $tableName.'_shop';
                }
            }
            if ($searchField != "")
                $where = ' WHERE `'.$searchField.'`='.$searchValue;

            if (isset($field->treeField) && $field->treeField) {
                $treeField = (string)$field->treeField;
                if ($tableShop != '') {
                    $getIDs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT `'.pSQL($defined['primary']).'` FROM '.pSQL($tableShop).pSQL($where));
                    $arrayExport = array();
                    foreach ($getIDs as $getID) {
                        $arrayExport[] = $getID[$defined['primary']];
                    }
                    $result = array();
                    if ($arrayExport) {
                        $where = ' WHERE '.$defined['primary'].' IN('.implode(',', $arrayExport).')';
                        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT m.`'.pSQL($defined['primary']).'`, m.`'.pSQL($treeField).'` FROM `'.pSQL($tableName).'` as m'.pSQL($where));
                    }
                } else {
                    $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT DISTINCT m.`'.pSQL($defined['primary']).'`, m.`'.pSQL($treeField).'` FROM `'.pSQL($tableName).'` '.pSQL($tableShop).pSQL($where));
                }
                $children = array();
                foreach ($result as $v) {
                    $pt = $v[$treeField];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $v);
                    $children[$pt] = $list;
                }
                if (isset($children[0])) {
                    $idRoot = 0;
                } else {
                    $idRoot = 1;
                }
                $result = $this->treeCategory($idRoot, $children, $defined['primary']);
            } else {
                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'.(pSQL($tableShop) != '' ? pSQL($tableShop) : pSQL($tableName)).'`'.pSQL($where));
            }
        }


        foreach ($result as $value) {


            $obj = new $className($value[$defined["primary"]]);

            if (!$obj->id) {
                continue;
            }

            if ($className == 'ApPageBuilderProfilesModel') {

                if (!$this->ap_profile_status) {
                    $this->ap_profile_status = $this->getProfileStatus();
                }

                if (isset($this->ap_profile_status[$value[$defined["primary"]]])) {
                    $obj->active = $this->ap_profile_status[$value[$defined["primary"]]];
                }
            }

            if ($className == 'ApPageBuilderProductsModel') {

                if (!$this->ap_products_status) {
                    $this->ap_products_status = $this->getProfileProductStatus();
                }

                if (isset($this->ap_products_status[$value[$defined["primary"]]])) {
                    $obj->active = $this->ap_products_status[$value[$defined["primary"]]];
                }
            }

            if ($className == 'Btmegamenu' || $className == 'Sbmegamenu') {
                //change image link
                foreach ($obj->submenu_content_text as &$submenu_text) {
                    $submenu_text = str_replace('"'.__PS_BASE_URI__.'modules/'.$moduleName, '"modules/'.$moduleName, $submenu_text);
                    $submenu_text = str_replace('"'.__PS_BASE_URI__.'themes/', '"themes/', $submenu_text);
                }
            } else if ($className == 'LeoTempcpWidget') {
                $widgetParam = Tools::jsonDecode(base64_decode($obj->params), true);
                //replace language from 1 to en and image link
                $tmpWidParam = array();
                foreach ($widgetParam as $widKey => $widValue) {
                    foreach ($this->_langField as $fVal) {
                        if (strpos($widKey, $fVal) !== false) {
                            $widKey = $this->replaceLangIDToIso($fVal, $widKey);
                            break;
                        }
                    }
                    foreach ($this->_imageField as $fVal) {
                        if (strpos($widKey, $fVal) !== false && strpos($widValue, 'img') !== false) {
                            $widValue = str_replace('"'.__PS_BASE_URI__.'modules/', '"modules/', $widValue);
                            $widValue = str_replace('"'.__PS_BASE_URI__.'themes/', '"themes/', $widValue);
                            $widValue = str_replace('"'.__PS_BASE_URI__.'img/', '"img/', $widValue);
                            break;
                        }
                    }
                    $tmpWidParam[$widKey] = $widValue;
                }
                $obj->params = base64_encode(Tools::jsonEncode($tmpWidParam));
            } else if ($className == "LeoManageWidgetGroup") {
                $widgetParam = Tools::jsonDecode(base64_decode($obj->params), true);
                $tmpWidParam = array();
                foreach ($widgetParam as $widKey => $widValue) {
                    if (strpos($widKey, 'title') !== false) {
                        $widKey = $this->replaceLangIDToIso('title', $widKey);
                    }
                    $tmpWidParam[$widKey] = $widValue;
                }

                $obj->params = base64_encode(Tools::jsonEncode($tmpWidParam));
            }

            $this->_content .= '<field>';
            //add ID
            $this->_content .= '<id>'.$obj->id.'</id>';

            //add other field
            foreach ($defined["fields"] as $ke => $val) {
                //don't need id_shop
                if ($ke == "id_shop") {
                    continue;
                }
                //if that field is language
                if (isset($val["lang"]) && $val["lang"]) {
                    $this->_content .= '<'.$ke.'>';
                    foreach ($this->_languages as $langISO => $langID) {
                        $this->_content .= '<'.$langISO.'><![CDATA['.$obj->{$ke}[$langID].']]></'.$langISO.'>';
                    }
                    $this->_content .= '</'.$ke.'>';
                }
                //normal field
                else {
                    //param field of module leoboostrapmenu
                    if ($val["type"] == 3 || $val["type"] == 5 || $val["type"] == 6) {
                        $this->_content .= '<'.$ke.'><![CDATA['.$obj->{$ke}.']]></'.$ke.'>';
                    } else {
                        $this->_content .= '<'.$ke.'>'.$obj->{$ke}.'</'.$ke.'>';
                    }
                }
            }

            //only fix for megamenu module
            if ($moduleName == 'leobootstrapmenu' && $className == 'Btmegamenu') {
                //get parrams of menu
                if (!$this->_paramsMenu) {
                    $configMenu = Configuration::get('LEO_MEGAMENU_PARAMS');
                    $configMenu = json_decode($configMenu);

                    foreach ($configMenu as $param) {
                        if ($param) {
                            $this->_paramsMenu[$param->id] = $param;
                        }
                    }
                }
                $this->_content .= '<params><![CDATA['.Tools::jsonEncode($this->_paramsMenu[$obj->id]).']]></params>';
            }

            //only fix for megamenu module
            if ($moduleName == 'leomenusidebar' && $className == 'Sbmegamenu') {
                //get parrams of menu
                if (!$this->_paramsMenu) {
                    $configMenu = Configuration::get('LEO_MENUSIDEBAR_PARAMS');
                    $configMenu = json_decode($configMenu);

                    foreach ($configMenu as $param) {
                        if ($param) {
                            $this->_paramsMenu[$param->id] = $param;
                        }
                    }
                }
                $this->_content .= '<params><![CDATA['.Tools::jsonEncode($this->_paramsMenu[$obj->id]).']]></params>';
            }

            //add child in same table
            if (isset($value['child']) && $value['child']) {
                $this->_content .= '<child_field field="'.(string)$field->treeField.'">';
                //foreach ($value['child'] as $child){
                $this->buildStruct($field, $searchField, $searchValue, $moduleName, 1, $value['child']);
                //}
                $this->_content .= '</child_field>';
            }

            //add child field
            if (isset($field->field) && $field->field && $obj->id) {
                foreach ($field->field as $f) {
                    if (!$this->includeObjModel($moduleName, $f->objectMFile)) {
                        return;
                    }
                    if ($className == 'ApPageBuilderProfilesModel') {

                        $this->_content .= '<fields objectName="'.$f->objectMName.'" objectFile="'.$f->objectMFile.'" searchField="'.$f->searchField.'" position="header">';
                        $this->buildStruct($f, $f->searchField, $obj->header, $moduleName);
                        $this->_content .= '</fields>';

                        $this->_content .= '<fields objectName="'.$f->objectMName.'" objectFile="'.$f->objectMFile.'" searchField="'.$f->searchField.'" position="content">';
                        $this->buildStruct($f, $f->searchField, $obj->content, $moduleName);
                        $this->_content .= '</fields>';

                        $this->_content .= '<fields objectName="'.$f->objectMName.'" objectFile="'.$f->objectMFile.'" searchField="'.$f->searchField.'" position="footer">';
                        $this->buildStruct($f, $f->searchField, $obj->footer, $moduleName);
                        $this->_content .= '</fields>';

                        $this->_content .= '<fields objectName="'.$f->objectMName.'" objectFile="'.$f->objectMFile.'" searchField="'.$f->searchField.'" position="product">';
                        $this->buildStruct($f, $f->searchField, $obj->product, $moduleName);
                        $this->_content .= '</fields>';
                    } else {
                        //build struct of sub table
                        $this->_content .= '<fields objectName="'.$f->objectMName.'" objectFile="'.$f->objectMFile.'" searchField="'.$f->searchField.'">';
                        $this->buildStruct($f, $f->searchField, $obj->id, $moduleName);
                        $this->_content .= '</fields>';
                    }
                }
            }
            $this->_content .= '</field>';
        }
    }

    public static function getProfileStatus()
    {
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_profiles_shop` WHERE id_shop='.(int)$id_shop;
        $result = Db::getInstance()->executes($sql);
        $profiles = array();
        foreach ($result as $key => $val) {
            $profiles[$val['id_appagebuilder_profiles']] = $val['active'];
        }

        return $profiles;
    }

    public static function getProfileProductStatus()
    {
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_products_shop` WHERE id_shop='.(int)$id_shop;
        $result = Db::getInstance()->executes($sql);
        $profiles = array();
        foreach ($result as $key => $val) {
            $profiles[$val['id_appagebuilder_products']] = $val['active'];
        }

        return $profiles;
    }

    public function treeCategory($id, $children, $fieldName)
    {
        $list = array();
        if (isset($children[$id])) {
            foreach ($children[$id] as $v) {
                $sub = $this->treeCategory($v[$fieldName], $children, $fieldName);
                if ($sub) {
                    $v['child'] = $sub;
                }
                $list[] = $v;
            }
        }
        return $list;
    }

    public function replaceLangIDToIso($fieldName, $fullName)
    {
        $find = str_replace($fieldName, "", $fullName);
        $list = explode("_", $find);
        //count and language
        if (substr_count($find, '_') == 2) {
            $list[2] = $this->_languagesKey[$list[2]];
        } else {
            $list[1] = $this->_languagesKey[$list[1]];
        }
        $find = implode("_", $list);
        return $fieldName.$find;
    }

    public function replaceLangIsoToID($fieldName)
    {
        foreach ($this->_languages as $key => $value) {
            $fieldName = preg_replace("/_".$key."$/", "_".$value, $fieldName, -1, $count);
        }
        return $fieldName;
    }

    public function includeObjModel($moduleName, $file)
    {
        if (file_exists(_PS_MODULE_DIR_.$moduleName."/classes/".$file)) {
            include_once _PS_MODULE_DIR_.$moduleName."/classes/".$file;
        } else if (file_exists(_PS_MODULE_DIR_.$moduleName."/".$file)) {
            include_once _PS_MODULE_DIR_.$moduleName."/".$file;
        } else {
            $this->_html["error"][] = "Can not load Model Object ".$file." of module: ".$moduleName;
            return false;
        }
        return true;
    }
    /*
     * 
     */

    public function changeLangIsoID($textKey, $type = 0)
    {
        $tmp = explode("_", $textKey);
        if ($type == 1) {
            if (isset($tmp[2])) {
                $tmp[2] = $this->_languages[$tmp[2]];
            } else {
                $tmp[1] = $this->_languages[$tmp[1]];
            }
        } else {
            foreach ($this->_languages as $key => $value) {
                if ((!isset($tmp[2]) && $value == $tmp[1]) || (isset($tmp[2]) && $value == $tmp[2])) {
                    if (isset($tmp[2])) {
                        $tmp[2] = $key;
                    } else {
                        $tmp[1] = $key;
                    }
                    break;
                }
            }
        }
        return implode(",", $tmp);
    }

    public function getModuleList($path = '', $onlyModName = 0)
    {
        if (!file_exists(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'config.xml')) {
            return;
        }

        $data = simplexml_load_file(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'config.xml');

        if (!$data || !isset($data->modules)) {
            return null;
        }
        $moduleList = array();
        $path = _PS_CACHE_DIR_.'backup/';
        //module name
        foreach ($data->modules as $modules) {
            foreach ($modules as $module) {
                if ((Module::isInstalled((string)$module->name) || $onlyModName) && file_exists(_PS_MODULE_DIR_.(string)$module->name)) {
                    if ($onlyModName == 1) {
                        $moduleList[] = (string)$module->name;
                        continue;
                    }
                    $moduleList[(string)$module->name]["name"] = (string)$module->name;
                    if (is_dir($path.(string)$module->name)) {
                        $fileList = @Tools::scandir($path.(string)$module->name);
                        if ($fileList) {
                            arsort($fileList);
                            $moduleList[(string)$module->name]["files"] = $fileList;
                        }
                    }
                }
            }
        }
        return $moduleList;
    }

    public function getConfigByName($name)
    {
        $where = ' WHERE `name` LIKE "%'.pSQL($name).'%"';

        $configAllShop = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT DISTINCT name FROM `'._DB_PREFIX_.'configuration`'.$where);
        $result = array();
        foreach ($configAllShop as &$config) {
            $config['value'] = Configuration::get($config['name']);
        }

        return $configAllShop;
    }

    /**
     * export db struct to download file
     */
    public function exportDBStruct()
    {
        $ignore_insert_table = array(
            _DB_PREFIX_.'sekeyword', _DB_PREFIX_.'statssearch', _DB_PREFIX_.'favorite_product',
            _DB_PREFIX_.'pagenotfound');
        //copy + export to 
        $installFolder = _PS_MODULE_DIR_."leotempcp/install";
        if (!is_dir($installFolder)) {
            mkdir($installFolder, 0755);
        }
        $backupfile = $installFolder."/db_structure.sql";

        $fp = @fopen($backupfile, 'w');
        if ($fp === false) {
            $this->_html["error"] = "Error when export DbStruct! Can not write file in leotemcp/install";
            return false;
        }
        fwrite($fp, 'SET NAMES \'utf8\';'."\n\n");
        // Find all tables
        $tables = Db::getInstance()->executeS('SHOW TABLES');
        //$found = 0;
        $data = "";

        foreach ($tables as $table) {
            $table = current($table);

            // Skip tables which do not start with _DB_PREFIX_
            if (Tools::strlen($table) < Tools::strlen(_DB_PREFIX_) || strncmp($table, _DB_PREFIX_, Tools::strlen(_DB_PREFIX_)) != 0) {
                continue;
            }
            // Export the table schema
            $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($table).'`');
            if (in_array($schema[0]['Table'], $ignore_insert_table)) {
                continue;
            }

            $data .= $schema[0]['Create Table'].";\n\n";
            if (count($schema) != 1 || !isset($schema[0]['Table']) || !isset($schema[0]['Create Table'])) {
                fclose($fp);
                $this->_html["error"] = "An error occurred while backing up. Unable to obtain the schema of ".$table;
                return false;
            }
        }

        $data = str_replace("CREATE TABLE `"._DB_PREFIX_, "CREATE TABLE `PREFIX_", $data);
        //$tableName = str_replace(_DB_PREFIX_, "_DB_PREFIX_", $table);
        fwrite($fp, $data);
        fclose($fp);
        $this->_html["confirm"][] .= 'Create datastruct was successful';
    }
    /*
     * export db data to download file
     */

    public function exportThemeSql()
    {
        $ignore_insert_table = array(
            _DB_PREFIX_.'connections', _DB_PREFIX_.'connections_page', _DB_PREFIX_.'connections_source',
            _DB_PREFIX_.'guest', _DB_PREFIX_.'statssearch',
            _DB_PREFIX_.'sekeyword', _DB_PREFIX_.'favorite_product',
            _DB_PREFIX_.'pagenotfound', _DB_PREFIX_.'shop_url',
            _DB_PREFIX_.'employee', _DB_PREFIX_.'employee_shop',
            _DB_PREFIX_.'contact', _DB_PREFIX_.'contact_lang',
            _DB_PREFIX_.'contact', _DB_PREFIX_.'contact_shop'
        );
        $installFolder = _PS_MODULE_DIR_."leotempcp/install";
        if (!is_dir($installFolder)) {
            mkdir($installFolder, 0755);
        }
        $backupfile = $installFolder."/theme.sql";

        $fp = @fopen($backupfile, 'w');
        if ($fp === false) {
            $this->_html["error"] = "Error when export DbStruct! Can not write file in leotemcp/install";
            return false;
        }
        fwrite($fp, 'SET NAMES \'utf8\';'."\n\n");
        // Find all tables
        $tables = Db::getInstance()->executeS('SHOW TABLES');
        $found = 0;
        $sql = '';
        foreach ($tables as $table) {
            $table = current($table);

            // Skip tables which do not start with _DB_PREFIX_
            if (Tools::strlen($table) < Tools::strlen(_DB_PREFIX_) || strncmp($table, _DB_PREFIX_, Tools::strlen(_DB_PREFIX_)) != 0) {
                continue;
            }

            // Export the table schema
            $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($table).'`');

            if (count($schema) != 1 || !isset($schema[0]['Table']) || !isset($schema[0]['Create Table'])) {
                fclose($fp);
                //$this->delete();
                //echo Tools::displayError('An error occurred while backing up. Unable to obtain the schema of').' "'.$table;
                $this->_html["error"] = "An error occurred while backing up. Unable to obtain the schema of ".$table;
                return false;
            }

            if (!in_array($schema[0]['Table'], $ignore_insert_table)) {
                $sql .= "\n".'TRUNCATE TABLE '.str_replace("`"._DB_PREFIX_, "`PREFIX_", "`".$schema[0]['Table']).'`;'."\n";

                $data = Db::getInstance()->query('SELECT * FROM `'.pSQL($schema[0]['Table']).'`', false);
                $sizeof = DB::getInstance()->NumRows();
                $lines = explode("\n", $schema[0]['Create Table']);

                if ($data && $sizeof > 0) {
                    // Export the table data
                    $sql .= 'INSERT INTO '.str_replace('`'._DB_PREFIX_, '`PREFIX_', '`'.$schema[0]['Table'])."` VALUES\n";
                    //fwrite($fp, 'INSERT INTO `'.$schema[0]['Table']."` VALUES\n");
                    $i = 1;
                    while ($row = DB::getInstance()->nextRow($data)) {
                        $s = '(';

                        foreach ($row as $field => $value) {
                            //special table
                            if ($schema[0]['Table'] == _DB_PREFIX_."leowidgets" && $field == "params") {
                                $configs = Tools::jsonDecode(base64_decode($value), true);

                                foreach ($configs as $kconfig => $vconfig) {
                                    if (strpos($kconfig, "htmlcontent") !== false || strpos($kconfig, "content") !== false || strpos($kconfig, "information") !== false || strpos($kconfig, "raw_html") !== false) {
                                        $vconfig = str_replace('"'.__PS_BASE_URI__.'modules/', '"modules/', $vconfig);
                                        $configs[$kconfig] = str_replace('"'.__PS_BASE_URI__.'themes/', '"themes/', $vconfig);
                                    }
                                }
                                $value = base64_encode(Tools::jsonEncode($configs));
                            }

                            $tmp = "'".pSQL($value, true)."',";
                            if ($tmp != "'',") {
                                $s .= $tmp;
                            } else {
                                foreach ($lines as $line) {
                                    if (strpos($line, '`'.$field.'`') !== false) {
                                        if (preg_match('/(.*NOT NULL.*)/Ui', $line)) {
                                            $s .= "'',";
                                        } else {
                                            $s .= 'NULL,';
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                        $s = rtrim($s, ',');

                        if (($schema[0]['Table'] == _DB_PREFIX_."appagebuilder_lang" && $i % 10 == 0) && $i < $sizeof) {
                            # Insert 1 time have 10 records, only appagebuilder_lang table
                            $s .= ");\nINSERT INTO ".str_replace('`'._DB_PREFIX_, '`PREFIX_', '`'.$schema[0]['Table'])."` VALUES\n";
                        }elseif (($i % 200 == 0 || ($schema[0]['Table'] == _DB_PREFIX_."leowidgets" && $i % 20 == 0)) && $i < $sizeof) {
                            $s .= ");\nINSERT INTO ".str_replace('`'._DB_PREFIX_, '`PREFIX_', '`'.$schema[0]['Table'])."` VALUES\n";
                        } elseif ($i < $sizeof) {
                            $s .= "),\n";
                        } else {
                            $s .= ");\n";
                        }
                        $sql .= $s;

                        //fwrite($fp, $s);
                        ++$i;
                    }
                }
            }
            $found++;
        }
        //table PREFIX_condition
        $sql = str_replace(" "._DB_PREFIX_, " PREFIX_", $sql);
        //img link
        //$sql = str_replace('src=\"' . __PS_BASE_URI__ . 'modules/', 'src=\"modules/', $sql);

        fwrite($fp, $sql);
        fclose($fp);
        if ($found == 0) {
            //echo Tools::displayError('No valid tables were found to backup.' );
            $this->_html["error"] = "No valid tables were found to backup.";
            return false;
        }

        $this->_html["confirm"][] .= 'Create theme.sql was successful';
    }

    public function getMessager()
    {
        return $this->_html;
    }
    /*
     * back-up database
     */

    function restoreBackUpFile()
    {
        $moduleList = Tools::getValue("moduleList");

        foreach ($moduleList as $module) {
            $installFolder = _PS_CACHE_DIR_.'backup/'.$module.'/';
            $file = Tools::getValue("file_".$module);
            if (file_exists($installFolder.$file)) {
                if ($this->installSampleModule($installFolder.$file, $module)) {
                    $this->_html["confirm"][] .= 'Restore data and config was done for '.$module;
                }
            }
        }
    }
    /*
     * back-up database
     */

    function processBackUp()
    {

        $data = simplexml_load_file(_PS_ALL_THEMES_DIR_.$this->_theme_dir.'config.xml');
        if (!$data || !isset($data->modules)) {
            $this->_html["error"][] = "Can not find modules field in themes/".$this->_theme_dir."config.xml";
            return false;
        }
        $moduleList = Tools::getValue("moduleList");
        if ($moduleList) {
            foreach ($data->modules->children() as $moduleXml) {
                //only create sample for module if select
                if (in_array((string)$moduleXml->name, $moduleList)) {
                    $installFolder = _PS_CACHE_DIR_.'backup/';
                    if (!is_dir($installFolder)) {
                        mkdir($installFolder, 0755);
                    }
                    $installFolder .= (string)$moduleXml->name.'/';
                    if (!is_dir($installFolder)) {
                        mkdir($installFolder, 0755);
                    }

                    if ($moduleXml->table_prefix) {
                        if ($this->createTableSample((string)$moduleXml->name, (string)$moduleXml->table_prefix, $installFolder)) {
                            $this->_html["confirm"][] = 'Back-up database was done for module '.(string)$moduleXml->name;
                        }
                    }
                    //export config
                    if ($moduleXml->config_prefix) {
                        if ($this->createConfigSample((string)$moduleXml->name, $moduleXml->config_prefix)) {
                            $this->_html["confirm"][] = 'Back-up Configuration was done for module '.(string)$moduleXml->name;
                        }
                        $this->_currentBackupFile = '';
                    }
                }
            }
        }
    }
    /*
     * back-up config to php file
     */

    public function createConfigSample($module, $configPrefix)
    {
        if (strpos((string)$configPrefix, ',') !== false) {
            $listPrefix = explode(",", (string)$configPrefix);

            $where = '';
            foreach ($listPrefix as $configPre) {
                if ($where == '') {
                    $where .= ' name LIKE (\'%'.pSQL($configPre).'%\')';
                } else {
                    $where .= ' AND name LIKE (\'%'.pSQL($configPre).'%\')';
                }
            }
            $sql = 'SELECT * FROM '._DB_PREFIX_.'configuration WHERE '.$where;
        } else {
            $sql = 'SELECT * FROM '._DB_PREFIX_.'configuration WHERE name LIKE (\'%'.pSQL($configPrefix).'%\')';
        }

        $data = Db::getInstance()->executeS($sql);

        if (!$data || empty($data)) {
            //echo Tools::displayError('Do not find configuration');
            $this->_html["error"][] = 'Do not find configuration of  '.$module;
            return false;
        }


        $backupfile = $this->_currentBackupFile;


        $oldData = Tools::file_get_contents($backupfile);

        //if this module have query create table
        $fp = @fopen($backupfile, 'w');
        if ($fp === false) {
            $this->_html["error"][] = 'Unable to back-up config for '.$module;
            return false;
        }
        $configData = "\n\$dataConfig = Array(";
        //echo "<pre>";print_r($data);die;
        foreach ($data as $key => $val) {
            if ($configData != "\n\$dataConfig = Array(") {
                $configData .= ",\"";
            } else {
                $configData .= "\"";
            }

            $configData .= $val["name"]."\"=>array(\"value\"=>\"".pSQL($val["value"])."\",\"id_shop_group\"=>\"".$val["id_shop_group"]."\",\"id_shop\"=>\"".$val["id_shop"]."\")";
        }
        $configData .= ")";
        fwrite($fp, $oldData);
        fwrite($fp, $configData.";");
        fclose($fp);
        return true;
    }
    /*
     * back-up database to php file
     */

    public function createTableSample($module, $tablePrefix, $installFolder = "")
    {
        //get create table from Prefix
        $listPrefix = explode(",", $tablePrefix);
        $list = array();
        $preList = array();
        foreach ($listPrefix as $tablePrefix) {
            $listTmp = Db::getInstance()->executeS("SHOW TABLES LIKE  '%".pSQL($tablePrefix)."%'");
            if ($preList) {
                $list = array_merge($list, $listTmp);
            } else {
                $list = $listTmp;
            }
            $preList = $list;
        }

        //$date = time();
        $createTable = "\$query = \"";
        $dataWithLang = "\$dataLang = Array(";

        if (count($list)) {
            $backupfile = $installFolder.$module.time().".php";
            $this->_currentBackupFile = $backupfile;

            $fp = @fopen($backupfile, 'w');
            if ($fp === false) {
                $this->_html["error"][] = 'Unable to create backup file '.addslashes($backupfile);
                return false;
            }
            fwrite($fp, "<?php");
            fwrite($fp, "\n/* Data sample for module".$module."*/\n");

            $dataLanguage = Array();

            $listLang = array();
            $languages = Language::getLanguages(true, Context::getContext()->shop->id);
            foreach ($languages as $lang) {
                $listLang[$lang["id_lang"]] = $lang["iso_code"];
            }

            foreach ($list as $table) {
                $table = current($table);
                $tableName = str_replace(_DB_PREFIX_, "_DB_PREFIX_", $table);
                // Skip tables which do not start with _DB_PREFIX_
                if (Tools::strlen($table) < Tools::strlen(_DB_PREFIX_) || strncmp($table, _DB_PREFIX_, Tools::strlen(_DB_PREFIX_)) != 0) {
                    continue;
                }
                $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($table).'`');

                if (count($schema) != 1 || !isset($schema[0]['Table']) || !isset($schema[0]['Create Table'])) {
                    fclose($fp);
                    //echo Tools::displayError('An error occurred while backing up. Unable to obtain the schema of') . ' "' . $table;
                    return "ERROR_BACKING_UP";
                }

                $createTable .= "DROP TABLE IF EXISTS `".$tableName."`;\n".$schema[0]['Create Table'].";\n";

                if (strpos($schema[0]['Create Table'], "`id_shop`")) {
                    $data = Db::getInstance()->query("SELECT * FROM `".pSQL($schema[0]['Table'])."` WHERE `id_shop`=".(int)Context::getContext()->shop->id, false);
                } else {
                    $data = Db::getInstance()->query('SELECT * FROM `'.pSQL($schema[0]['Table']).'`', false);
                }

                $sizeof = DB::getInstance()->NumRows();
                $lines = explode("\n", $schema[0]['Create Table']);

                if ($data && $sizeof > 0) {
                    //if table is language
                    $id_language = 0;
                    if (strpos($schema[0]['Table'], "lang") !== false) {
                        $dataLanguage[$schema[0]['Table']] = array();
                        $i = 1;
                        while ($row = DB::getInstance()->nextRow($data)) {
                            $s = '(';
                            foreach ($row as $field => $value) {
                                if ($field == "id_lang") {
                                    $id_language = $value;
                                    $tmp = "'".pSQL("LEO_ID_LANGUAGE", true)."',";
                                } else if ($field == "id_shop") {
                                    $tmp = "'".pSQL("LEO_ID_SHOP", true)."',";
                                } else {
                                    $tmp = "'".pSQL($value, true)."',";
                                }

                                if ($tmp != "'',") {
                                    $s .= $tmp;
                                } else {
                                    foreach ($lines as $line) {
                                        if (strpos($line, '`'.$field.'`') !== false) {
                                            if (preg_match('/(.*NOT NULL.*)/Ui', $line)) {
                                                $s .= "'',";
                                            } else {
                                                $s .= 'NULL,';
                                            }
                                            break;
                                        }
                                    }
                                }
                            }

                            if (!isset($listLang[$id_language])) {
                                continue;
                            }

                            if (!isset($dataLanguage[$schema[0]['Table']][strtolower($listLang[$id_language])])) {
                                $dataLanguage[$schema[0]['Table']][strtolower($listLang[$id_language])] = 'INSERT INTO `'.$tableName."` VALUES\n";
                            }

                            $s = rtrim($s, ',');
                            if ($i % 200 == 0 && $i < $sizeof) {
                                $s .= ");\nINSERT INTO `".$tableName."` VALUES\n";
                            } else {
                                $s .= "),\n";
                            }
                            /* elseif ($i < $sizeof)
                              $s .= "),\n";
                              else
                              $s .= ");\n"; */
                            $dataLanguage[$schema[0]['Table']][strtolower($listLang[$id_language])] .= $s;
                            //++$i;
                        }
                    } else if (strpos($schema[0]['Table'], "ps_leowidgets") !== false) {
                        $createTable .= $this->createInsert($data, $tableName, $lines, $sizeof, $listLang, 1);
                    }
                    //normal table
                    else {
                        $createTable .= $this->createInsert($data, $tableName, $lines, $sizeof, $listLang);
                    }
                }
            }
            //foreach by table
            $tpl = array();

            fwrite($fp, $createTable."\";\n");
            if ($dataLanguage) {
                foreach ($dataLanguage as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        if (!isset($tpl[$key1])) {
                            $tpl[$key1] = Tools::substr($value1, 0, -2).";\n";
                        } else {
                            $tpl[$key1] .= Tools::substr($value1, 0, -2).";\n";
                        }
                    }
                }

                foreach ($tpl as $key => $value) {
                    if ($dataWithLang != "\$dataLang = Array(") {
                        $dataWithLang .= ",\"".$key."\"=>"."\"".$value."\"";
                    } else {
                        $dataWithLang .= "\"".$key."\"=>"."\"".$value."\"";
                    }
                }
                //delete base uri when export

                fwrite($fp, $dataWithLang.");");
            }
            fclose($fp);
        }
        return true;
    }
    /*
     * sub function of back-up database
     */

    public function createInsert($data, $tableName, $lines, $sizeof, $listLang, $specialTable = 0)
    {
        $dataNoLang = 'INSERT INTO `'.$tableName."` VALUES\n";
        $i = 1;
        while ($row = DB::getInstance()->nextRow($data)) {
            if ($specialTable) {
                $configs = Tools::jsonDecode(base64_decode($row['params']), true);
                $tmp = array();

                foreach ($configs as $key => $value) {
                    $value = str_replace('"'.__PS_BASE_URI__.'modules/', '"modules/', $value);
                    $value = str_replace('"'.__PS_BASE_URI__.'themes/', '"themes/', $value);
                    $tmp[$key] = $value;
                }

                $row['params'] = base64_encode(Tools::jsonEncode($tmp));
            }

            $s = '(';
            foreach ($row as $field => $value) {
                if ($field == "id_shop") {
                    $tmp = "'".pSQL("LEO_ID_SHOP", true)."',";
                } else {
                    $tmp = "'".pSQL($value, true)."',";
                }
                if ($tmp != "'',") {
                    $s .= $tmp;
                } else {
                    foreach ($lines as $line) {
                        if (strpos($line, '`'.$field.'`') !== false) {
                            if (preg_match('/(.*NOT NULL.*)/Ui', $line)) {
                                $s .= "'',";
                            } else {
                                $s .= 'NULL,';
                            }
                            break;
                        }
                    }
                }
            }
            $s = rtrim($s, ',');
            if ($i % 200 == 0 && $i < $sizeof) {
                $s .= ");\nINSERT INTO `".$tableName."` VALUES\n";
            } elseif ($i < $sizeof) {
                $s .= "),\n";
            } else {
                $s .= ");\n";
            }
            $dataNoLang .= $s;

            ++$i;
        }
        return $dataNoLang;
    }

    public function installSampleModule($file, $module = '')
    {
        require_once( $file );
        //install with no language
        if (isset($query) && !empty($query)) {
            $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $query);
            $query = str_replace("_MYSQL_ENGINE_", _MYSQL_ENGINE_, $query);
            $query = str_replace("LEO_ID_SHOP", (int)Context::getContext()->shop->id, $query);
            $query = str_replace("_MYSQL_ENGINE_", _MYSQL_ENGINE_, $query);
            $query = str_replace("\\'", "\'", $query);
            if ($module) {
                $query = str_replace('"modules/'.$module.'/', '"'.__PS_BASE_URI__.'modules/'.$module.'/', $query);
                $query = str_replace('"themes/', '"'.__PS_BASE_URI__.'themes/', $query);
            }

            $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
            foreach ($db_data_settings as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    if (!Db::getInstance()->Execute(pSQL($query))) {
                        //echo "---error--" . $query . "---error--";
                        $this->_html["error"][] = "Can not restore for ".$module;
                        return false;
                    }
                }
            }
        }
        //echo "<pre>";print_r($dataLang);
        //install with with language
        if (isset($dataLang) && !empty($dataLang)) {
            $languages = Language::getLanguages(true, Context::getContext()->shop->id);
            //print_r($languages);die;
            foreach ($languages as $lang) {
                if (isset($dataLang[strtolower($lang["iso_code"])])) {
                    $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $dataLang[strtolower($lang["iso_code"])]);
                } else {
                    //if not exist language in list, get en
                    if (isset($dataLang["en"])) {
                        $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $dataLang["en"]);
                    } else {
                        //firt item in array
                        foreach ($dataLang as $key => $value) {
                            $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $dataLang[$key]);
                            break;
                        }
                    }
                }
                $query = str_replace("_MYSQL_ENGINE_", _MYSQL_ENGINE_, $query);
                $query = str_replace("LEO_ID_SHOP", (int)Context::getContext()->shop->id, $query);
                $query = str_replace("LEO_ID_LANGUAGE", (int)$lang["id_lang"], $query);
                $query = str_replace("\\\'", "\'", $query);
                if ($module) {
                    $query = str_replace('"modules/'.$module.'/', '"'.__PS_BASE_URI__.'modules/'.$module.'/', $query);
                    $query = str_replace('"themes/', '"'.__PS_BASE_URI__.'themes/', $query);
                }

                $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
                foreach ($db_data_settings as $query) {
                    $query = trim($query);
                    if (!empty($query)) {
                        //echo "---".$query."<br/>";
                        if (!Db::getInstance()->Execute($query)) {
                            $this->_html["error"][] = "Can not restore for data lang".$module;
                            return false;
                        }
                    }
                }
            }
        }

        //install config
        //echo "<pre>";print_r($dataConfig);die;
        if (isset($dataConfig) && !empty($dataConfig)) {
            foreach ($dataConfig as $key => $value) {
                //print_r($value);die;
                Configuration::updateValue($key, $value["value"], false, $value["id_shop_group"], $value["id_shop"]);
            }
        }

        return true;
    }

    public static function correctImgLink()
    {
        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("SELECT * FROM `"._DB_PREFIX_."leowidgets`");
        foreach ($data as $row) {
            $params = Tools::jsonDecode(base64_decode($row["params"]), true);
            foreach ($params as $kconfig => $vconfig) {
                if (strpos($kconfig, "htmlcontent") !== false || strpos($kconfig, "content") !== false || strpos($kconfig, "information") !== false || strpos($kconfig, "raw_html") !== false) {
                    $vconfig = str_replace('"modules/', '"'.__PS_BASE_URI__.'modules/', $vconfig);
                    $params[$kconfig] = str_replace('"themes/', '"'.__PS_BASE_URI__.'themes/', $vconfig);
                }
            }
            $sql = 'UPDATE `'._DB_PREFIX_.'leowidgets` SET `params` = \''.base64_encode(Tools::jsonEncode($params)).'\' WHERE `id_leowidgets` = '.(int)$row["id_leowidgets"];
            Db::getInstance()->execute($sql);
        }
    }
}
