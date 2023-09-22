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
require_once(_PS_MODULE_DIR_.'appagebuilder/libs/apPageHelper.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderModel.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderProfilesModel.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderProductsModel.php');

class APPageBuilder extends Module
{
    protected $default_language;
    protected $languages;
    protected $theme_name;
    protected $data_index_hook;
    protected $profile_data;
    protected $hook_index_data;
    protected $profile_param;
    protected $path_resource;
    protected $product_active;
    protected $backup_dir;
    protected $header_content;

    public function __construct()
    {
        $this->name = 'appagebuilder';
        $this->module_key = '9da746af2f0aa356120277ab2a148484';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ApolloTheme';
        $this->displayName = $this->l('Apollo Page Builder');
        $this->description = $this->l('Apollo Page Builder build content for your site.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();
        apPageHelper::loadShortCode(_PS_THEME_DIR_);
        $this->theme_name = Context::getContext()->shop->getTheme();
        $this->default_language = Language::getLanguage(Context::getContext()->language->id);
        $this->languages = Language::getLanguages();
        $this->profile_data = ApPageBuilderProfilesModel::getActiveProfile('index');
        $this->profile_param = Tools::jsonDecode($this->profile_data['params'], true);
        $this->path_resource = $this->_path.'views/';
        $this->setFullwidthHook();
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        /* Adds Module */
        $res = true;
        if (parent::install()) {
            $res &= $this->registerHook('header');
            $res &= $this->registerHook('actionShopDataDuplication');
            $res &= $this->registerHook('displayBackOfficeHeader');
            foreach (ApPageSetting::getHook('all') as $value) {
                $res &= $this->registerHook($value);
            }
            $this->registerHook('pagebuilderConfig');
            //register hook to show category and tags of product
            $this->registerHook('displayProductInformation');
            $res &= Configuration::updateValue('APPAGEBUILDER_PRODUCT_MAX_RANDOM', 20);
            $res &= Configuration::updateValue('APPAGEBUILDER_GUIDE', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_OWL', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_STELLAR', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_WAYPOINTS', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_INSTAFEED', 0);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_HTML5VIDEO', 0);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_FULLPAGEJS', 0);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_AJAX', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_PN', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_TRAN', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_IMG', 0);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_COUNT', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_COLOR', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_LOAD_ACOLOR', 1);
            $res &= Configuration::updateValue('APPAGEBUILDER_COLOR', '');
            $res &= Configuration::updateValue('APPAGEBUILDER_COOKIE_PROFILE', 0);

            $res &= Configuration::updateValue('HEADER_HOOK', implode(',', ApPageSetting::getHook('header')));
            $res &= Configuration::updateValue('CONTENT_HOOK', implode(',', ApPageSetting::getHook('content')));
            $res &= Configuration::updateValue('FOOTER_HOOK', implode(',', ApPageSetting::getHook('footer')));
            $res &= Configuration::updateValue('PRODUCT_HOOK', implode(',', ApPageSetting::getHook('product')));
            //module install
            require_once(_PS_MODULE_DIR_.$this->name.'/libs/setup.php');
            $res &= ApPageSetup::install();
            return (bool)$res;
        }
        return false;
    }

    public function uninstall()
    {
        if (parent::uninstall()) {
            /* Deletes tables */
            require_once(_PS_MODULE_DIR_.$this->name.'/libs/setup.php');
            $res = ApPageSetup::unInstall();
            $res &= Configuration::deleteByName('APPAGEBUILDER_IMGDIR');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_OWL');
            $res &= Configuration::deleteByName('APPAGEBUILDER_GUIDE');
            $res &= Configuration::deleteByName('HEADER_HOOK');
            $res &= Configuration::deleteByName('CONTENT_HOOK');
            $res &= Configuration::deleteByName('FOOTER_HOOK');
            $res &= Configuration::deleteByName('PRODUCT_HOOK');

            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_AJAX');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_PN');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_TRAN');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_IMG');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_COUNT');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_COLOR');
            $res &= Configuration::deleteByName('APPAGEBUILDER_COOKIE_PROFILE');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_ACOLOR');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_INSTAFEED');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_HTML5VIDEO');
            $res &= Configuration::deleteByName('APPAGEBUILDER_LOAD_FULLPAGEJS');
            $res &= Configuration::deleteByName('APPAGEBUILDER_COLOR');

            $res &= Configuration::deleteByName('APPAGEBUILDER_PRODUCT_MAX_RANDOM');
            //$this->deleteFileResource(_PS_THEME_DIR_.'css'.DS.'modules'.DS.$this->name);
            //$this->deleteFileResource(_PS_THEME_DIR_.'js'.DS.'modules'.DS.$this->name);
            return $res;
        }
        return false;
    }

    protected function deleteFileResource($dir)
    {
        $files = glob($dir.DS.'*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteFileResource($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }

    /**
     * Uninstall
     */
    public function getContent()
    {
        //$this->registerHook('pagebuilderConfig');
        $output = '';
        $this->backup_dir = _PS_CACHE_DIR_.'backup/'.$this->name.'/';
        if (Tools::isSubmit('installdemo')) {
            require_once(_PS_MODULE_DIR_.$this->name.'/libs/setup.php');
            ApPageSetup::installSample();
        } else if (Tools::isSubmit('resetmodule')) {
            require_once(_PS_MODULE_DIR_.$this->name.'/libs/setup.php');
            ApPageSetup::createTables(1);
        } else if (Tools::isSubmit('deleteposition')) {
            $this->processDeleteOldPosition();
        } else if (Tools::isSubmit('updatemodule')) {
            $this->processUpdateModule();
        } else if (Tools::isSubmit('backup')) {
            $this->processBackup();
        } else if (Tools::isSubmit('restore')) {
            $this->processRestore();
        } else if (Tools::isSubmit('submitApPageBuilder')) {
            $path_root = Tools::getValue('APPAGEBUILDER_IMGDIR');
            $load_owl = Tools::getValue('APPAGEBUILDER_LOAD_OWL');
            $header_hook = Tools::getValue('HEADER_HOOK');
            $content_hook = Tools::getValue('CONTENT_HOOK');
            $footer_hook = Tools::getValue('FOOTER_HOOK');
            $product_hook = Tools::getValue('PRODUCT_HOOK');
            Configuration::updateValue('APPAGEBUILDER_IMGDIR', $path_root);
            Configuration::updateValue('APPAGEBUILDER_LOAD_OWL', (int)$load_owl);
            Configuration::updateValue('APPAGEBUILDER_COOKIE_PROFILE', Tools::getValue('APPAGEBUILDER_COOKIE_PROFILE'));
            Configuration::updateValue('HEADER_HOOK', $header_hook);
            Configuration::updateValue('CONTENT_HOOK', $content_hook);
            Configuration::updateValue('FOOTER_HOOK', $footer_hook);
            Configuration::updateValue('PRODUCT_HOOK', $product_hook);
            Configuration::updateValue('APPAGEBUILDER_LOAD_AJAX', Tools::getValue('APPAGEBUILDER_LOAD_AJAX'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_STELLAR', Tools::getValue('APPAGEBUILDER_LOAD_STELLAR'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_WAYPOINTS', Tools::getValue('APPAGEBUILDER_LOAD_WAYPOINTS'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_INSTAFEED', Tools::getValue('APPAGEBUILDER_LOAD_INSTAFEED'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_HTML5VIDEO', Tools::getValue('APPAGEBUILDER_LOAD_HTML5VIDEO'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_FULLPAGEJS', Tools::getValue('APPAGEBUILDER_LOAD_FULLPAGEJS'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_PN', Tools::getValue('APPAGEBUILDER_LOAD_PN'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_TRAN', Tools::getValue('APPAGEBUILDER_LOAD_TRAN'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_IMG', Tools::getValue('APPAGEBUILDER_LOAD_IMG'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_COUNT', Tools::getValue('APPAGEBUILDER_LOAD_COUNT'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_COLOR', Tools::getValue('APPAGEBUILDER_LOAD_COLOR'));
            Configuration::updateValue('APPAGEBUILDER_COLOR', Tools::getValue('APPAGEBUILDER_COLOR'));
            Configuration::updateValue('APPAGEBUILDER_LOAD_ACOLOR', Tools::getValue('APPAGEBUILDER_LOAD_ACOLOR'));
        }
        $create_profile_link = $this->context->link->getAdminLink('AdminApPageBuilderProfiles').'&addappagebuilder_profiles';
        $profile_link = $this->context->link->getAdminLink('AdminApPageBuilderProfiles');
        $position_link = $this->context->link->getAdminLink('AdminApPageBuilderPositions');
        $product_link = $this->context->link->getAdminLink('AdminApPageBuilderProducts');
        $path_guide = _PS_MODULE_DIR_.$this->name.'/views/templates/admin/guide.tpl';
        $guide_box = ApPageSetting::buildGuide($this->context, $path_guide, 1);

        $module_link = $this->context->link->getAdminLink('AdminModules', false)
                .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules');
        $back_up_file = @Tools::scandir($this->backup_dir, 'php');

        $this->context->smarty->assign(array(
            'guide_box' => $guide_box,
            'create_profile_link' => $create_profile_link,
            'profile_link' => $profile_link,
            'position_link' => $position_link,
            'product_link' => $product_link,
            'module_link' => $module_link,
            'back_up_file' => $back_up_file
        ));
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        return $output.$this->renderForm();
    }

    public function processDeleteOldPosition()
    {
        $sql = 'SELECT header,content,footer,product FROM `'._DB_PREFIX_.'appagebuilder_profiles` GROUP BY id_appagebuilder_profiles';
        $result = Db::getInstance()->executeS($sql);
        $list = array();
        foreach ($result as $val) {
            foreach ($val as $v) {
                if (!in_array($v, $list) && $v) {
                    $list[] = $v;
                }
            }
        }
        if ($list) {
            $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_positions` WHERE id_appagebuilder_positions NOT IN ('.implode(',', $list).')';
            Db::getInstance()->execute($sql);
            $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_positions_shop` WHERE id_appagebuilder_positions NOT IN ('.implode(',', $list).')';
            Db::getInstance()->execute($sql);
        }
    }

    public function processUpdateModule()
    {
        //run one time for update - update position in shop
        $schema = Db::getInstance()->executeS('SHOW TABLES LIKE \'%appagebuilder_positions_shop%\'');
        if (!$schema) {
            require_once(_PS_MODULE_DIR_.$this->name.'/libs/setup.php');
            ApPageSetup::updatePositionShop($this->context->shop->id);
        }
        //register hook to show when paging
        $this->registerHook('pagebuilderConfig');
        //register hook to show category and tags of product
        $this->registerHook('displayProductInformation');
        //add ative field in table profile and table product
        apPageHelper::existColumn();

        $tab = array('class_name' => 'AdminApPageBuilderModule', 'name' => 'Ap Page Builder Configuration');
        if (!Db::getInstance()->getRow('SELECT class_name FROM `'._DB_PREFIX_.'tab` WHERE class_name = \'AdminApPageBuilderModule\'')) {
            $id_parent = Db::getInstance()->getRow('SELECT id_tab FROM `'._DB_PREFIX_.'tab` WHERE class_name = \'AdminApPageBuilder\'');

            if ($id_parent) {
                $newtab = new Tab();
                $newtab->class_name = $tab['class_name'];
                $newtab->id_parent = $id_parent['id_tab'];
                $newtab->module = $this->name;
                foreach (Language::getLanguages() as $l) {
                    $newtab->name[$l['id_lang']] = $tab['name'];
                }
                $newtab->save();
            }
        }
    }

    public function processRestore()
    {
        $file = Tools::getValue('backupfile');
        if (file_exists($this->backup_dir.$file)) {
            $query = $data_lang = '';
            require_once( $this->backup_dir.$file );
            if (isset($query) && !empty($query)) {
                $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $query);
                $query = str_replace('_MYSQL_ENGINE_', _MYSQL_ENGINE_, $query);
                $query = str_replace('ID_SHOP', (int)Context::getContext()->shop->id, $query);
                $query = str_replace("\\'", "\'", $query);

                $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
                foreach ($db_data_settings as $query) {
                    $query = trim($query);
                    if (!empty($query)) {
                        if (!Db::getInstance()->Execute($query)) {
                            $this->_html['error'][] = 'Can not restore for '.$this->name;
                            return false;
                        }
                    }
                }

                if (isset($data_lang) && !empty($data_lang)) {
                    $languages = Language::getLanguages(true, Context::getContext()->shop->id);
                    foreach ($languages as $lang) {
                        if (isset($data_lang[Tools::strtolower($lang['iso_code'])])) {
                            $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $data_lang[Tools::strtolower($lang['iso_code'])]);
                            //if not exist language in list, get en
                        } else {
                            if (isset($data_lang['en'])) {
                                $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $data_lang['en']);
                            } else {
                                //firt item in array
                                foreach (array_keys($data_lang) as $key) {
                                    $query = str_replace('_DB_PREFIX_', _DB_PREFIX_, $data_lang[$key]);
                                    break;
                                }
                            }
                        }
                        $query = str_replace('_MYSQL_ENGINE_', _MYSQL_ENGINE_, $query);
                        $query = str_replace('ID_SHOP', (int)Context::getContext()->shop->id, $query);
                        $query = str_replace('ID_LANGUAGE', (int)$lang['id_lang'], $query);
                        $query = str_replace("\\\'", "\'", $query);

                        $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
                        foreach ($db_data_settings as $query) {
                            $query = trim($query);
                            if (!empty($query)) {
                                if (!Db::getInstance()->Execute($query)) {
                                    $this->_html['error'][] = 'Can not restore for data lang '.$this->name;
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function processBackup()
    {
        $install_folder = _PS_CACHE_DIR_.'backup/';
        if (!is_dir($install_folder)) {
            mkdir($install_folder, 0755);
        }
        $install_folder = $this->backup_dir;
        if (!is_dir($install_folder)) {
            mkdir($install_folder, 0755);
        }
        $list_table = Db::getInstance()->executeS("SHOW TABLES LIKE '%appagebuilder%'");

        $create_table = '';
        $data_with_lang = '';
        $backup_file = $install_folder.$this->name.time().'.php';
        $fp = @fopen($backup_file, 'w');
        if ($fp === false) {
            die('Unable to create backup file '.addslashes($backup_file));
        }

        fwrite($fp, '<?php');
        fwrite($fp, "\n/* back up for module".$this->name."*/\n");

        $data_language = Array();
        $list_lang = array();
        $languages = Language::getLanguages(true, Context::getContext()->shop->id);
        foreach ($languages as $lang) {
            $list_lang[$lang['id_lang']] = $lang['iso_code'];
        }

        foreach ($list_table as $table) {
            $table = current($table);
            $table_name = str_replace(_DB_PREFIX_, '_DB_PREFIX_', $table);
            // Skip tables which do not start with _DB_PREFIX_
            if (Tools::strlen($table) < Tools::strlen(_DB_PREFIX_) || strncmp($table, _DB_PREFIX_, Tools::strlen(_DB_PREFIX_)) != 0) {
                continue;
            }
            $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.pSQL($table).'`');
            if (count($schema) != 1 || !isset($schema[0]['Table']) || !isset($schema[0]['Create Table'])) {
                fclose($fp);
                die($this->l('An error occurred while backing up. Unable to obtain the schema of').' '.$table);
            }
            $create_table .= 'DROP TABLE IF EXISTS `'.$table_name."`;\n".$schema[0]['Create Table'].";\n";

            if (strpos($schema[0]['Create Table'], '`id_shop`')) {
                $data = Db::getInstance()->query('SELECT * FROM `'.pSQL($schema[0]['Table']).'` WHERE `id_shop`='.(int)Context::getContext()->shop->id, false);
            } else {
                $data = Db::getInstance()->query('SELECT * FROM `'.pSQL($schema[0]['Table']).'`', false);
            }

            $sizeof = DB::getInstance()->NumRows();
            $lines = explode("\n", $schema[0]['Create Table']);

            if ($data && $sizeof > 0) {
                //if table is language
                $id_language = 0;
                if (strpos($schema[0]['Table'], 'lang') !== false) {
                    $data_language[$schema[0]['Table']] = array();
                    $i = 1;
                    while ($row = DB::getInstance()->nextRow($data)) {
                        $s = '(';
                        foreach ($row as $field => $value) {
                            if ($field == 'id_lang') {
                                $id_language = $value;
                                $tmp = "'".pSQL('ID_LANGUAGE', true)."',";
                            } else if ($field == 'ID_SHOP') {
                                $tmp = "'".pSQL('ID_SHOP', true)."',";
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

                        if (!isset($list_lang[$id_language])) {
                            continue;
                        }

                        if (!isset($data_language[$schema[0]['Table']][Tools::strtolower($list_lang[$id_language])])) {
                            $data_language[$schema[0]['Table']][Tools::strtolower($list_lang[$id_language])] = 'INSERT INTO `'.$table_name."` VALUES\n";
                        }

                        $s = rtrim($s, ',');
                        if ($i % 200 == 0 && $i < $sizeof) {
                            $s .= ");\nINSERT INTO `".$table_name."` VALUES\n";
                        } else {
                            $s .= "),\n";
                        }
                        $data_language[$schema[0]['Table']][Tools::strtolower($list_lang[$id_language])] .= $s;
                    }
                }
                //normal table
                else {
                    $create_table .= $this->createInsert($data, $table_name, $lines, $sizeof);
                }
            }
        }

        $create_table = str_replace('$', '\$', $create_table);
        $create_table = '$query = "'.$create_table;
        //foreach by table
        $tpl = array();

        fwrite($fp, $create_table."\";\n");
        if ($data_language) {
            foreach ($data_language as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if (!isset($tpl[$key1])) {
                        $tpl[$key1] = Tools::substr($value1, 0, -2).";\n";
                    } else {
                        $tpl[$key1] .= Tools::substr($value1, 0, -2).";\n";
                    }
                }
            }
            foreach ($tpl as $key => $value) {
                if ($data_with_lang) {
                    $data_with_lang .= ',"'.$key.'"=>'.'"'.$value.'"';
                } else {
                    $data_with_lang .= '"'.$key.'"=>'.'"'.$value.'"';
                }
            }

            //delete base uri when export
            $data_with_lang = str_replace('$', '\$', $data_with_lang);
            $data_with_lang = '$data_lang = Array('.$data_with_lang;

            fwrite($fp, $data_with_lang.');');
        }
        fclose($fp);
    }
    /*
     * sub function of back-up database
     */

    public function createInsert($data, $table_name, $lines, $sizeof)
    {
        $data_no_lang = 'INSERT INTO `'.$table_name."` VALUES\n";
        $i = 1;
        while ($row = DB::getInstance()->nextRow($data)) {
            $s = '(';
            foreach ($row as $field => $value) {
                if ($field == 'ID_SHOP') {
                    $tmp = "'".pSQL('ID_SHOP', true)."',";
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
                $s .= ");\nINSERT INTO `".$table_name."` VALUES\n";
            } elseif ($i < $sizeof) {
                $s .= "),\n";
            } else {
                $s .= ");\n";
            }
            $data_no_lang .= $s;

            ++$i;
        }
        return $data_no_lang;
    }

    public function renderForm()
    {
        $list_all_hooks = $this->renderListAllHook(ApPageSetting::getHook('all'));
        $list_header_hooks = (Configuration::get('HEADER_HOOK')) ?
                Configuration::get('HEADER_HOOK') : implode(',', ApPageSetting::getHook('header'));
        $list_content_hooks = (Configuration::get('CONTENT_HOOK')) ?
                Configuration::get('CONTENT_HOOK') : implode(',', ApPageSetting::getHook('content'));
        $list_footer_hooks = (Configuration::get('FOOTER_HOOK')) ?
                Configuration::get('FOOTER_HOOK') : implode(',', ApPageSetting::getHook('footer'));
        $list_product_hooks = (Configuration::get('PRODUCT_HOOK')) ?
                Configuration::get('PRODUCT_HOOK') : implode(',', ApPageSetting::getHook('product'));
        $themes = Context::getContext()->shop->getTheme();
        $default_path_img = 'img/modules/appagebuilder/';
        $form_general = array(
            'legend' => array(
                'title' => $this->l('General Settings'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Image root dir'),
                    'name' => 'APPAGEBUILDER_IMGDIR',
                    'class' => '',
                    'desc' => $this->l('(If change this path, old images and folders still in old directory)'),
                    'default' => $default_path_img
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'name' => 'dump_name',
                    'html_content' => '<div class="cover-preview">Default root is: "~/themes/'.$themes
                    .'/<span class="appagebuilder-preview-url"></span></div>'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Jquery Stellar Library'),
                    'name' => 'APPAGEBUILDER_LOAD_STELLAR',
                    'desc' => $this->l('This script is use for parallax. If you load it in other plugin please turn it off'),
                    'is_bool' => true,
                    'values' => ApPageSetting::returnYesNo(),
                    'default' => '1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Owl Carousel Library'),
                    'name' => 'APPAGEBUILDER_LOAD_OWL',
                    'desc' => $this->l('This script is use for Carousel. If you load it in other plugin please turn it off'),
                    'is_bool' => true,
                    'values' => ApPageSetting::returnYesNo(),
                    'default' => '1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Waypoints Library'),
                    'name' => 'APPAGEBUILDER_LOAD_WAYPOINTS',
                    'desc' => $this->l('This script is use for Animated. If you load it in other plugin please turn it off'),
                    'is_bool' => true,
                    'values' => ApPageSetting::returnYesNo(),
                    'default' => '1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Instafeed Library'),
                    'name' => 'APPAGEBUILDER_LOAD_INSTAFEED',
                    'default' => 0,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Full Page JS'),
                    'name' => 'APPAGEBUILDER_LOAD_FULLPAGEJS',
                    'default' => 0,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Load Video HTML5 Library'),
                    'name' => 'APPAGEBUILDER_LOAD_HTML5VIDEO',
                    'default' => 0,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Save profile and postion id to cookie'),
                    'name' => 'APPAGEBUILDER_COOKIE_PROFILE',
                    'default' => 0,
                    'desc' => $this->l('That is only for demo, please turn off it in live site'),
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'name' => 'dump_name',
                    'html_content' => '<br/><hr/><br/><div class="alert alert-info">'
                    .$this->l('Setting for Custom Ajax.').
                    '<input type="hidden" id="position-hook-select"/></div>',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Use Ajax Feature'),
                    'name' => 'APPAGEBUILDER_LOAD_AJAX',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Quantity Category'),
                    'name' => 'APPAGEBUILDER_LOAD_PN',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('You can add this code in category-tree-branch.tpl file of module you want to show Quantity product of category'),
                    'name' => 'APPAGEBUILDER_LOAD_TPN',
                    'cols' => 100,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show More Product Image'),
                    'name' => 'APPAGEBUILDER_LOAD_TRAN',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('You can add this code in tpl file of module you want to show More Product Image'),
                    'name' => 'APPAGEBUILDER_LOAD_TTRAN',
                    'cols' => 100,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Multiple Product Image'),
                    'name' => 'APPAGEBUILDER_LOAD_IMG',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('You can add this code in tpl file of module you want to show Multiple Product Image'),
                    'name' => 'APPAGEBUILDER_LOAD_TIMG',
                    'cols' => 100,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Count Down Product'),
                    'name' => 'APPAGEBUILDER_LOAD_COUNT',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('You can add this code in tpl file of module you want to show Count Down'),
                    'name' => 'APPAGEBUILDER_LOAD_TCOUNT',
                    'cols' => 100,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Discount Color'),
                    'name' => 'APPAGEBUILDER_LOAD_ACOLOR',
                    'default' => 1,
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('You can add this code in tpl file of module you want to show color discount'),
                    'name' => 'APPAGEBUILDER_LOAD_TCOLOR',
                    'cols' => 100,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('For color (Ex: 10:#ff0000,20:#152ddb,40:#ffee001) '),
                    'name' => 'APPAGEBUILDER_LOAD_COLOR',
                    'cols' => 100
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('If you want my script run fine with Layered navigation block.
								Please copy to override file modules/blocklayered/blocklayered.js to folder 
								themes/TEMPLATE_NAME/js/modules/blocklayered/blocklayered.js.
								Then find function reloadContent(params_plus).'),
                    'name' => 'APPAGEBUILDER_LOAD_RTN',
                    'cols' => 100
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('For color (Ex: 10:#ff0000,20:#152ddb,40:#ffee001)'),
                    'name' => 'APPAGEBUILDER_COLOR',
                    'default' => '',
                    'cols' => 100
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'name' => 'dump_name',
                    'html_content' => '<br/><hr/><br/><div class="alert alert-info">'
                    .$this->l('Setting hook in positions (This setting will apply for all profiles).').
                    '<input type="hidden" id="position-hook-select"/></div>',
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'name' => 'dump_name',
                    'html_content' => '<div class="list-all-hooks">'.$this->l('Default all hooks: [').$list_all_hooks.']</div>',
                    'desc' => $this->l('(Focus to a posistion hook then can select hook in this list for add)'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Hooks in header'),
                    'name' => 'HEADER_HOOK',
                    'class' => '',
                    'default' => $list_header_hooks
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Hooks in content'),
                    'name' => 'CONTENT_HOOK',
                    'class' => '',
                    'default' => $list_content_hooks
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Hooks in footer'),
                    'name' => 'FOOTER_HOOK',
                    'class' => '',
                    'default' => $list_footer_hooks
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Hooks in product-footer'),
                    'name' => 'PRODUCT_HOOK',
                    'class' => '',
                    'default' => $list_product_hooks
                ),
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'name' => 'html_content_de',
                    'html_content' => '<input type="hidden" name="hook_header_old" id="hook_header_old"/>
						<input type="hidden" name="hook_content_old" id="hook_content_old"/>
						<input type="hidden" name="hook_footer_old" id="hook_footer_old"/>
						<input type="hidden" name="hook_product_old" id="hook_product_old"/>
						<input type="hidden" name="is_change" id="is_change" value=""/>
						<input type="hidden" id="message_confirm" value="'
                    .$this->l('The hook is changing. Click OK will save new config hooks and will
								 REMOVE ALL current data widget. Are you sure?').'"/>',
                ),
            ),
            'submit' => array(
                'id' => 'btn-save-appagebuilder',
                'title' => $this->l('Save'),
            )
        );
        $fields_form = array(
            'form' => $form_general
        );
        $data = $this->getConfigFieldsValues($form_general);
        // Check existed the folder root store resources of module
        $path_img = _PS_ALL_THEMES_DIR_.$this->theme_name.'/'.$data['APPAGEBUILDER_IMGDIR'];
        if (!file_exists($path_img)) {
            mkdir($path_img, 0755, true);
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
                Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitApPageBuilder';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
                .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $data,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    private function renderListAllHook($arr)
    {
        $html = '';
        if ($arr) {
            foreach ($arr as $item) {
                $html .= "<a href='javascript:;'>$item</a>";
            }
        }
        return $html;
    }

    public function hookPagebuilderConfig($param)
    {
        $cf = $param['configName'];
        //get detail profile
        if ($cf == 'profile' || $cf == 'header' || $cf == 'footer' || $cf == 'content' || $cf == 'product' || $cf == 'product_builder') {
            if (!$this->isCached('config.tpl', $this->getCacheId().$cf)) {
                $ap_type = $cf;

                if ($cf == 'profile') {
                    $ap_type = 'id_appagebuilder_profiles';
                } else if ($cf == 'product_builder') {
                    $ap_type = 'plist_key';
                }
                $this->smarty->assign(
                        array(
                            'ap_cfdata' => $this->getConfigData($cf),
                            'ap_cf' => $cf,
                            'ap_type' => $ap_type
                        )
                );
            }
            return $this->display(__FILE__, 'config.tpl', $this->getCacheId().$cf);
        }

        if (!$this->product_active) {
            $this->product_active = ApPageBuilderProductsModel::getActive();
        }
        if ($cf == 'productClass') {
            // validate module
            return $this->product_active['class'];
        }
        if ($cf == 'productKey') {
            // validate module
            return $this->product_active['plist_key'];
        }
    }

    public function getConfigData($cf)
    {
        if ($cf == 'profile') {
            $sql = 'SELECT p.`id_appagebuilder_profiles` AS `id`, p.`name`, ps.`active`'
                    .' FROM `'._DB_PREFIX_.'appagebuilder_profiles` p '
                    .' INNER JOIN `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps '
                    .' ON (ps.`id_appagebuilder_profiles` = p.`id_appagebuilder_profiles`)'
                    .' WHERE ps.id_shop='.(int)Context::getContext()->shop->id;
        } else if ($cf == 'product_builder') {
            $sql = 'SELECT p.`plist_key` AS `id`, p.`name`, ps.`active`'
                    .' FROM `'._DB_PREFIX_.'appagebuilder_products` p '
                    .' INNER JOIN `'._DB_PREFIX_.'appagebuilder_products_shop` ps '
                    .' ON (ps.`id_appagebuilder_products` = p.`id_appagebuilder_products`)'
                    .' WHERE ps.id_shop='.(int)Context::getContext()->shop->id;
        } else {
            $sql = 'SELECT p.`id_appagebuilder_positions` AS `id`, p.`name`'
                    .' FROM `'._DB_PREFIX_.'appagebuilder_positions` p '
                    .' INNER JOIN `'._DB_PREFIX_.'appagebuilder_positions_shop` ps '
                    .' ON (ps.`id_appagebuilder_positions` = p.`id_appagebuilder_positions`)'
                    .' WHERE p.`position` = \''.PSQL($cf).'\' AND ps.id_shop='.(int)Context::getContext()->shop->id;
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        foreach ($result as &$val) {
            if ($cf == 'profile') {
                $val['active'] = 0;
                if ($val['id'] == $this->profile_data['id_appagebuilder_profiles']) {
                    $val['active'] = 1;
                }
            } else if ($cf == 'product_builder') {
                if (Tools::getIsset('plist_key')) {
                    $val['active'] = 0;
                    if ($val['id'] == Tools::getValue('plist_key')) {
                        $val['active'] = 1;
                    }
                }
            } else {
                $val['active'] = 0;
                if (Tools::getIsset($cf)) {
                    if ($val['id'] == Tools::getValue($cf)) {
                        $val['active'] = 1;
                    }
                } else {
                    if ($val['id'] == $this->profile_data[$cf]) {
                        $val['active'] = 1;
                    }
                }
            }
        }
        return $result;
    }

    public function getConfigFieldsValues($form_general)
    {
        $this->context->controller->addCss($this->path_resource.'css/style.css');
        $result = array();
        foreach ($form_general['input'] as $form) {
            //$form['name'] = isset($form['name']) ? $form['name'] : '';
            if (Configuration::hasKey($form['name'])) {
                $result[$form['name']] = Tools::getValue($form['name'], Configuration::get($form['name']));
            } else {
                $result[$form['name']] = Tools::getValue($form['name'], isset($form['default']) ? $form['default'] : '');
            }
        }

        $result['APPAGEBUILDER_LOAD_RTI'] = 'add this code
                        <div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
                             in
                       <div class="left-block">...</div>';

        $result['APPAGEBUILDER_LOAD_RTN'] = '                                      
                                            }
                                        });
                                        ajaxQueries.push(ajaxQuery);
                                        
                                        -------edit it to-----------
                                            if (typeof LeoCustomAjax !== "undefined" && $.isFunction(LeoCustomAjax)) {
								                var leoCustomAjax = new $.LeoCustomAjax();
								                leoCustomAjax.processAjax();
								            }
                                        });
                                        ajaxQueries.push(ajaxQuery);
                         ';
        $result['APPAGEBUILDER_LOAD_TCOUNT'] = '<div class="leo-more-cdown" data-idproduct="{$product.id_product}"></div>';
        $result['APPAGEBUILDER_LOAD_TTRAN'] = '<span class="product-additional" data-idproduct="{$product.id_product}"></span>';
        $result['APPAGEBUILDER_LOAD_TIMG'] = 'add this code
                        <div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
                             in
                       <div class="left-block">...</div>';
        $result['APPAGEBUILDER_LOAD_TCOLOR'] = '<div class="leo-more-color" data-idproduct="{$product.id_product}"></div>';
        $result['APPAGEBUILDER_LOAD_TPN'] = 'add this code
					<span id="leo-cat-{$node.id}" style="display:none" class="leo-qty badge pull-right" data-str="{l s=\' item(s)\' mod=\'appagebuilder\'}"></span>
						after
						{$node.name|escape:html:UTF-8}';

        return $result;
    }

    public function fontContent($assign, $tpl_name)
    {
        // Setting live edit mode
        $assign['apLiveEdit'] = '';
        $assign['apLiveEditEnd'] = '';
        $is_live = Tools::getIsset('ap_live_edit') ? Tools::getValue('ap_live_edit') : '';
        if ($is_live) {
            $live_token = Tools::getIsset('liveToken') ? Tools::getValue('liveToken') : '';
            if (!$this->checkLiveEditAccess($live_token)) {
                Tools::redirect('index.php?controller=404');
            }
            $cookie = new Cookie('url_live_back');
            $url_edit_profile = $cookie->variable_name;
            // Get id_profile in url
            $id_profile = Tools::getIsset('id_appagebuilder_profiles') ? Tools::getValue('id_appagebuilder_profiles') : '';
            $cookie = new Cookie('ap_id_profile');
            if (!$id_profile) {
                if ($cookie->variable_name) {
                    $url_edit_profile .= '&id_appagebuilder_profiles='.$cookie->variable_name;
                }
            } else {
                // Restor id_profile to cookie
                $cookie = new Cookie('ap_id_profile');
                $cookie->setExpire(time() + 60 * 60);
                $cookie->variable_name = $id_profile;
                $cookie->write();
                $url_edit_profile .= '&id_appagebuilder_profiles='.$id_profile;
            }
            $assign['urlEditProfile'] = $url_edit_profile;
            $assign['isLive'] = $is_live;
            $assign['apLiveEdit'] = '<div class="cover-live-edit"><a class="link-to-back-end" href="';
            if (isset($assign['formAtts']) && isset($assign['formAtts']['form_id']) && $assign['formAtts']['form_id']) {
                // validate module
                $assign['apLiveEdit'] .= $url_edit_profile.'#'.$assign['formAtts']['form_id'];
            } else {
                $assign['apLiveEdit'] .= $url_edit_profile;
            }
            $assign['apLiveEdit'] .= '" target="_blank"><i class="icon-pencil"></i> <span>Edit</span></a>';
            $assign['apLiveEditEnd'] = '</div>';
        }
        $hook_name = ApShortCodesBuilder::$hook_name;

        //override by widget folder
        if (isset($assign['formAtts']['override_folder']) && file_exists(_PS_ALL_THEMES_DIR_.$this->theme_name.'/modules/'.$this->name.'/views/templates/hook/'.$assign['formAtts']['override_folder'].'/'.$tpl_name)) {
            // validate module
            $tpl_file = 'views/templates/hook/'.$assign['formAtts']['override_folder'].'/'.$tpl_name;
        } elseif (file_exists(_PS_ALL_THEMES_DIR_.$this->theme_name.'/modules/'.$this->name.'/views/templates/hook/'.$hook_name.'/'.$tpl_name) || file_exists(dirname(__FILE__).'/views/templates/hook/'.$hook_name.'/'.$tpl_name)) {
            $tpl_file = 'views/templates/hook/'.$hook_name.'/'.$tpl_name;
        } elseif (file_exists(_PS_ALL_THEMES_DIR_.$this->theme_name.'/modules/'.$this->name.'/views/templates/hook/'.$tpl_name) || file_exists(dirname(__FILE__).'/views/templates/hook/'.$tpl_name)) {
            $tpl_file = 'views/templates/hook/'.$tpl_name;
        } else {
            $tpl_file = 'views/templates/hook/ApGeneral.tpl';
        } if ($assign) {
            foreach ($assign as $key => $ass) {
                $this->smarty->assign(array($key => $ass));
            }
        }
        $content = $this->display(__FILE__, $tpl_file);
        return $content;
    }

    public function checkLiveEditAccess($live_token)
    {
        $cookie = new Cookie('ap_token');
        return $live_token === $cookie->variable_name;
    }

    /**
     * TuNV added: for render view for request ajax
     * @param type $assign
     * @param type $tpl_name
     * @return type
     */
    public function ajaxProccessFetch($assign, $tpl_name)
    {
        //$hook_name = ApShortCodesBuilder::$hook_name;
        if ($assign) {
            foreach ($assign as $key => $ass) {
                Context::getContext()->smarty->assign(array($key => $ass));
            }
        }
        $content = Context::getContext()->smarty->fetch($tpl_name);
        return $content;
    }

    /**
     * $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null
     */
    public function getProductsFont($params)
    {
        $id_lang = $this->context->language->id;
        $context = Context::getContext();
        //assign value from params
        $p = isset($params['page_number']) ? $params['page_number'] : 1;
        if ($p < 0) {
            $p = 1;
        }
        $n = isset($params['nb_products']) ? $params['nb_products'] : 10;
        if ($n < 1) {
            $n = 10;
        }
        $order_by = isset($params['order_by']) ? Tools::strtolower($params['order_by']) : 'position';
        $order_way = isset($params['order_way']) ? $params['order_way'] : 'ASC';
        $random = false;
        if ($order_way == 'random') {
            $random = true;
        }
        $get_total = isset($params['get_total']) ? $params['get_total'] : false;
        $order_by_prefix = false;
        if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd' || $order_by == 'reference') {
            $order_by_prefix = 'p';
        } else if ($order_by == 'name') {
            $order_by_prefix = 'pl';
        } elseif ($order_by == 'manufacturer') {
            $order_by_prefix = 'm';
            $order_by = 'name';
        } elseif ($order_by == 'position') {
            $order_by_prefix = 'cp';
        }
        if ($order_by == 'price') {
            $order_by = 'orderprice';
        }
        $active = 1;
        if (!Validate::isBool($active) || !Validate::isOrderBy($order_by)) {
            die(Tools::displayError());
        }
        //build where
        $where = '';
        $select_by_categories = isset($params['select_by_categories']) ? $params['select_by_categories'] : 0;
        if ($select_by_categories) {
            $id_categories = isset($params['categorybox']) ? $params['categorybox'] : '';
            if (isset($params['category_type']) && $params['category_type'] == 'default') {
                $where .= ' AND p.`id_category_default` '.(strpos($id_categories, ',') === false ?
                                '= '.(int)$id_categories : 'IN ('.$id_categories.')');
            } else {
                $where .= ' AND cp.`id_category` '.(strpos($id_categories, ',') === false ?
                                '= '.(int)$id_categories : 'IN ('.$id_categories.')');
            }
        }
        $select_by_supplier = isset($params['select_by_supplier']) ? $params['select_by_supplier'] : 0;
        if ($select_by_supplier && isset($params['supplier'])) {
            $id_suppliers = $params['supplier'];
            $where .= ' AND p.id_supplier '.(strpos($id_suppliers, ',') === false ? '= '.(int)$id_suppliers : 'IN ('.$id_suppliers.')');
        }
        $select_by_product_id = isset($params['select_by_product_id']) ? $params['select_by_product_id'] : 0;
        if ($select_by_product_id && isset($params['product_id'])) {
            $temp = explode(',', $params['product_id']);
            foreach ($temp as $key => $value) {
                // validate module
                $temp[$key] = (int)$value;
            }

            $product_id = implode(',', $temp);
            $where .= ' AND p.id_product '.(strpos($product_id, ',') === false ? '= '.(int)$product_id : 'IN ('.$product_id.')');
        }

        $select_by_manufacture = isset($params['select_by_manufacture']) ? $params['select_by_manufacture'] : 0;
        if ($select_by_manufacture && isset($params['manufacture'])) {
            $id_manufactures = $params['manufacture'];
            $where .= ' AND p.id_manufacturer '.(strpos($id_manufactures, ',') === false ? '= '.(int)$id_manufactures : 'IN ('.$id_manufactures.')');
        }
        $product_type = isset($params['product_type']) ? $params['product_type'] : '';
        $select_by_product_type = isset($params['select_by_product_type']) ? $params['select_by_product_type'] : 0;
        if ($select_by_product_type && $product_type == 'new_product')
            $where .= ' AND product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ?
                                            (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'"';
        //home feature
        if ($select_by_product_type && $product_type == 'home_featured') {
            $ids = array();
            $category = new Category(Context::getContext()->shop->getCategory(), (int)Context::getContext()->language->id);
            $result = $category->getProducts((int)Context::getContext()->language->id, 1, 100, 'position');
            foreach ($result as $product) {
                $ids[$product['id_product']] = 1;
            }
            $ids = array_keys($ids);
            sort($ids);
            $ids = count($ids) > 0 ? implode(',', $ids) : 'NULL';
            $where .= ' AND p.`id_product` IN ('.$ids.')';
        }
        //special or price drop
        if ($select_by_product_type && $product_type == 'price_drop') {
            $current_date = date('Y-m-d H:i:s');
            $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
            $ids = Address::getCountryAndState($id_address);
            $id_country = $ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT');
            $id_country = (int)$id_country;
            $ids_product = SpecificPrice::getProductIdByDate(
                            $context->shop->id, $context->currency->id, $id_country, $context->customer->id_default_group, $current_date, $current_date, 0, false
            );
            $tab_id_product = array();
            foreach ($ids_product as $product) {
                if (is_array($product)) {
                    $tab_id_product[] = (int)$product['id_product'];
                } else {
                    $tab_id_product[] = (int)$product;
                }
            }
            $where .= ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')';
        }
        if ($select_by_product_type && $product_type == 'best_sellers') {
            $sql = 'SELECT cp.`id_product`';
        } else {
            $sql = 'SELECT p.*, product_shop.*, p.`reference`, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, 
					MAX(product_attribute_shop.id_product_attribute) id_product_attribute, 
					product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, 
					pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, 
					pl.`name`, MAX(image_shop.`id_image`) id_image,
					il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
					DAY)) > 0 AS new, product_shop.price AS orderprice';
        }
        $sql .= '
			FROM `'._DB_PREFIX_.'category_product` cp
			LEFT JOIN `'._DB_PREFIX_.'product` p
				ON p.`id_product` = cp.`id_product`
			'.Shop::addSqlAssociation('product', 'p').'
			LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
			ON (p.`id_product` = pa.`id_product`)
			'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
			'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON (product_shop.`id_category_default` = cl.`id_category`
				AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
				ON (p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
			LEFT JOIN `'._DB_PREFIX_.'image` i
				ON (i.`id_product` = p.`id_product`)'.
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
			LEFT JOIN `'._DB_PREFIX_.'image_lang` il
				ON (image_shop.`id_image` = il.`id_image`
				AND il.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
				ON m.`id_manufacturer` = p.`id_manufacturer`
			WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
				AND product_shop.`active` = 1 
				AND product_shop.`visibility` IN ("both", "catalog")'
                .$where
                .' GROUP BY product_shop.id_product';
        if (!($select_by_product_type && $product_type == 'best_sellers')) {
            if ($random === true) {
                $sql .= ' ORDER BY RAND() '.(!$get_total ? ' LIMIT '.(int)$n : '');
            } else {
                $sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way)
                        .(!$get_total ? ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n : '');
            }
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        //best sellers only
        if ($select_by_product_type && $product_type == 'best_sellers') {
            $ids = array();
            foreach ($result as $product) {
                $ids[$product['id_product']] = 1;
            }
            $ids = array_keys($ids);
            sort($ids);
            $ids = count($ids) > 0 ? implode(',', $ids) : 'NULL';
            $sql = '
				SELECT
					p.id_product, p.`reference`, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, 
					pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
					MAX(image_shop.`id_image`) id_image, il.`legend`,
					ps.`quantity` AS sales, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, 
					IFNULL(stock.quantity, 0) as quantity, p.customizable,
					IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
					product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ?
                                            (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new, product_shop.`on_sale`
				FROM `'._DB_PREFIX_.'product_sale` ps
				LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
					ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
                    Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON cl.`id_category` = product_shop.`id_category_default`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
				WHERE product_shop.`active` = 1
				AND p.`visibility` != \'none\'
				AND p.`id_product` IN ('.$ids.')
				GROUP BY product_shop.id_product
				ORDER BY sales DESC
				LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        }
        if ($order_by == 'orderprice') {
            Tools::orderbyPrice($result, $order_way);
        }
        if (!$result) {
            return array();
        }
        /* Modify SQL result */
        $this->context->controller->addColorsToProductList($result);
        return Product::getProductsProperties($id_lang, $result);
    }

    public function hookdisplayHeader()
    {
        if (Configuration::get('APPAGEBUILDER_LOAD_WAYPOINTS')) {
            $this->context->controller->addCSS($this->path_resource.'css/animate.css');
            $this->context->controller->addJS($this->path_resource.'js/waypoints.min.js');
        }
        if (Configuration::get('APPAGEBUILDER_LOAD_INSTAFEED')) {
            // validate module
            $this->context->controller->addJS($this->path_resource.'js/instafeed.min.js');
        }
        if (Configuration::get('APPAGEBUILDER_LOAD_STELLAR')) {
            // validate module
            $this->context->controller->addJS($this->path_resource.'js/jquery.stellar.js');
        }
        if (Configuration::get('APPAGEBUILDER_LOAD_OWL')) {
            $this->context->controller->addJS($this->path_resource.'js/owl.carousel.js', 'all');
            $this->context->controller->addCSS($this->path_resource.'css/owl.carousel.css', 'all');
            $this->context->controller->addCSS($this->path_resource.'css/owl.theme.css', 'all');
        }
        if (Configuration::get('APPAGEBUILDER_LOAD_AJAX')) {
            $leo_customajax_img = Configuration::get('APPAGEBUILDER_LOAD_IMG');
            $leo_customajax_tran = Configuration::get('APPAGEBUILDER_LOAD_TRAN');
            $leo_customajax_pn = Configuration::get('APPAGEBUILDER_LOAD_PN');
            $leo_customajax_count = Configuration::get('APPAGEBUILDER_LOAD_COUNT');

            $leo_customajax_acolor = Configuration::get('APPAGEBUILDER_LOAD_ACOLOR');
            $this->smarty->assign(array(
                'leo_customajax' => Configuration::get('APPAGEBUILDER_LOAD_AJAX'),
                'leo_customajax_img' => $leo_customajax_img,
                'leo_customajax_tran' => $leo_customajax_tran,
                'leo_customajax_pn' => $leo_customajax_pn,
                'leo_customajax_count' => $leo_customajax_count,
                'leo_customajax_acolor' => $leo_customajax_acolor
            ));
            $this->context->controller->addJqueryPlugin('fancybox');
            if ($leo_customajax_count) {
                $this->context->controller->addJS($this->path_resource.'js/countdown.js', 'all');
            }
            if ($leo_customajax_img) {
                // validate module
                $this->context->controller->addJqueryPlugin(array('scrollTo', 'serialScroll'));
            }
        }
        //add js for html5 youtube video
        if (Configuration::get('APPAGEBUILDER_LOAD_HTML5VIDEO')) {
            $this->context->controller->addJS($this->path_resource.'js/mediaelement-and-player.js');
            $this->context->controller->addCSS($this->path_resource.'css/mediaelementplayer.min.css', 'all');
        }
        //add js,css for full page js
        if (Configuration::get('APPAGEBUILDER_LOAD_FULLPAGEJS')) {
            $this->context->controller->addCSS($this->path_resource.'css/jquery.fullPage.css');
            $this->context->controller->addJS($this->path_resource.'js/jquery.fullPage.js');
        }
        // TuNV OOP: For animation of product list
        //$this->context->controller->addJS($this->path_resource.'js/admin/isotope.pkgd.min.js');
        //$this->context->controller->addJS($this->path_resource.'js/jquery.infinitescroll.min.js');
        // Common resource
        $hook_name = 'displayHeader';
        //apPageHelper::log("Call processHook=== $hook_name", ApPageSetting::getModeDebugLog());
        $this->context->controller->addCSS($this->path_resource.'css/styles.css');
        $this->context->controller->addJS($this->path_resource.'js/script.js');
        if (!$this->product_active) {
            $this->product_active = ApPageBuilderProductsModel::getActive();
        }
        $this->smarty->smarty->assign(array('productClassWidget' => $this->product_active['class']));
        $this->smarty->smarty->assign(array('productProfileDefault' => $this->product_active['plist_key']));
        // apPageHelper::log($product_active['class']);
        // In the case not exist: create new cache file for template
        if (!$this->isCached('header.tpl', $this->getCacheId($hook_name))) {
            $ap_header_config = '// Javascript code';
            if (!$this->hook_index_data) {
                $model = new ApPageBuilderModel();
                $this->hook_index_data = $model->getAllItems(
                        $this->profile_data, 1, $this->default_language['id_lang']);
            }
            $this->smarty->assign(array('ap_header_config' => $ap_header_config));
            $this->smarty->assign(array(
                'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium'))
            ));
        }
        //apPageHelper::log("End processHook=== $hook_name", ApPageSetting::getModeDebugLog());
        // Read file cache and render view
        $this->header_content = $this->display(__FILE__, 'header.tpl', $this->getCacheId($hook_name));
    }

    private function processHook($hook_name, $params = 'null')
    {
        $cover_hook_live = '';
        //apPageHelper::log("Call processHook=== $hook_name", ApPageSetting::getModeDebugLog());
        if (!$this->isCached('appagebuilder.tpl', $this->getCacheId($hook_name))) {
            $is_live = Tools::getIsset('ap_live_edit') ? Tools::getValue('ap_live_edit') : '';
            if ($is_live) {
                $token = Tools::getIsset('ap_edit_token') ? Tools::getValue('ap_edit_token') : '';
                $admin_dir = Tools::getIsset('ad') ? Tools::getValue('ad') : '';
                $controller = 'AdminApPageBuilderHome';
                $id_lang = Context::getContext()->language->id;
                $id_profile = Tools::getIsset('id_appagebuilder_profiles') ? Tools::getValue('id_appagebuilder_profiles') : '';
                $params = array('token' => $token, 'id_appagebuilder_profiles' => $id_profile);
                $current_link = _PS_BASE_URL_.__PS_BASE_URI__;
                $url_design_layout = $current_link.$admin_dir.'/'.Dispatcher::getInstance()->createUrl($controller, $id_lang, $params, false);
                $cover_hook_live = '<div class="cover-hook"><a title="'.$this->l('Click to edit').'" class="lnk-hook" href="'
                        .$url_design_layout.'#'.$hook_name.'" target="_blank">Hook: '.Tools::strtoupper($hook_name).'</a></div>';
            }
            $model = new ApPageBuilderModel();
            if (!$this->hook_index_data) {
                $this->hook_index_data = $model->getAllItems(
                        $this->profile_data, 1, $this->default_language['id_lang']);
            }
            if (!isset($this->hook_index_data[$hook_name]) || trim($this->hook_index_data[$hook_name]) == '') {
                return $cover_hook_live;
            }
            $ap_content = $model->parseData($hook_name, $this->hook_index_data[$hook_name], $this->profile_param);
            if ($is_live) {
                $ap_content = '<div class="ap-cover-hook">'.$ap_content.'</div>';
            }
            $this->smarty->assign(array('apContent' => $ap_content));
        }
        //apPageHelper::log("End processHook=== $hook_name", ApPageSetting::getModeDebugLog());
        return $cover_hook_live.$this->display(__FILE__, 'appagebuilder.tpl', $this->getCacheId($hook_name));
    }

    public function hookDisplayBanner($params)
    {
        return $this->processHook('displayBanner', $params);
    }

    public function hookDisplayNav($params)
    {
        return $this->processHook('displayNav', $params);
    }

    public function hookDisplayTop($params)
    {
        return $this->processHook('displayTop', $params);
    }

    public function hookDisplaySlideshow($params)
    {
        return $this->processHook('displaySlideshow', $params);
    }

    public function hookTopNavigation($params)
    {
        return $this->processHook('topNavigation', $params);
    }

    public function hookDisplayPromoteTop($params)
    {
        return $this->processHook('displayPromoteTop', $params);
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->processHook('displayRightColumn', $params);
    }

    public function hookDisplayLeftColumn($params)
    {
        return $this->processHook('displayLeftColumn', $params);
    }

    public function hookDisplayHome($params)
    {
        return $this->processHook('displayHome', $params);
    }

    public function hookDisplayFooter($params)
    {
        $this->loadResouceForProfile();
        return $this->processHook('displayFooter', $params).$this->header_content;
    }

    public function hookProductTabContent($params)
    {
        return $this->processHook('productTabContent', $params);
    }

    public function hookDisplayBottom($params)
    {
        return $this->processHook('displayBottom', $params);
    }

    public function hookDisplayFooterProduct($params)
    {
        return $this->processHook('displayFooterProduct', $params);
    }

    public function hookDisplayTopColumn($params)
    {
        return $this->processHook('displayTopColumn', $params);
    }

    public function hookDisplayRightColumnProduct($params)
    {
        return $this->processHook('displayRightColumnProduct', $params);
    }

    public function hookDisplayLeftColumnProduct($params)
    {
        return $this->processHook('displayLeftColumnProduct', $params);
    }

    public function hookDisplayMaintenance($params)
    {
        return $this->processHook('displayMaintenance', $params);
    }

    public function hookDisplayOrderConfirmation($params)
    {
        return $this->processHook('displayOrderConfirmation', $params);
    }

    public function hookDisplayOrderDetail($params)
    {
        return $this->processHook('displayOrderDetail', $params);
    }

    public function hookDisplayPayment($params)
    {
        return $this->processHook('displayPayment', $params);
    }

    public function hookDisplayPaymentReturn($params)
    {
        return $this->processHook('displayPaymentReturn', $params);
    }

    public function hookDisplayProductComparison($params)
    {
        return $this->processHook('displayProductComparison', $params);
    }

    public function hookDisplayShoppingCartFooter($params)
    {
        return $this->processHook('displayShoppingCartFooter', $params);
    }

    public function hookDisplayContentBottom($params)
    {
        return $this->processHook('displayContentBottom', $params);
    }

    public function hookDisplayFootNav($params)
    {
        return $this->processHook('displayFootNav', $params);
    }

    public function hookDisplayFooterTop($params)
    {
        return $this->processHook('displayFooterTop', $params);
    }

    public function hookDisplayFooterBottom($params)
    {
        return $this->processHook('displayFooterBottom', $params);
    }

    public function hookdisplayHomeTab()
    {
        return $this->display(__FILE__, 'htab.tpl', $this->getCacheId($this->name.'-htab'));
    }

    public function hookdisplayHomeTabContent($params)
    {
        return $this->processHook('displayHomeTabContent', $params);
    }

    public function hookProductFooter($params)
    {
        return $this->processHook('productFooter', $params);
    }

    public function displayFootNav($params)
    {
        return $this->processHook('displayFootNav', $params);
    }

    public function hookActionShopDataDuplication()
    {
        $this->clearHookCache();
    }

    protected function getCacheId($hook_name = null)
    {
        $cache_array = array();
        $cache_array[] = $this->name;
        $cache_array[] = $hook_name;
        if ($this->profile_param && isset($this->profile_param[$hook_name]) && $this->profile_param[$hook_name]) {
            //$cache_array[] = $hook_name;
            $current_page = Dispatcher::getInstance()->getController();
            //show ocurrentPagenly in controller
            if (isset($this->profile_param[$hook_name][$current_page])) {
                $cache_array[] = $current_page;
                if ($current_page != 'index' && $cache_id = ApPageSetting::getControllerId($current_page, $this->profile_param[$hook_name][$current_page])) {
                    $cache_array[] = $cache_id;
                }
            } elseif (isset($this->profile_param[$hook_name]['productCarousel'])) {
                $random = round(rand(1, max(Configuration::get('APPAGEBUILDER_PRODUCT_MAX_RANDOM'), 1)));
                $cache_array[] = "productCarousel|$random";
            } else if (isset($this->profile_param[$hook_name]['exception']) && in_array($cache_array, $this->profile_param[$hook_name]['exception'])) {
                //show but not in controller
                $cache_array[] = $current_page;
            }
        }
        if (Configuration::get('PS_SSL_ENABLED')) {
            $cache_array[] = (int)Tools::usingSecureMode();
        }
        if (Shop::isFeatureActive()) {
            $cache_array[] = (int)$this->context->shop->id;
        }
        if (Group::isFeatureActive()) {
            $cache_array[] = (int)Group::getCurrent()->id;
        }
        if (Language::isMultiLanguageActivated()) {
            $cache_array[] = (int)$this->context->language->id;
        }
        if (Currency::isMultiCurrencyActivated()) {
            $cache_array[] = (int)$this->context->currency->id;
        }
        $cache_array[] = (int)$this->context->country->id;
        if (Tools::getIsset('id_appagebuilder_profiles')) {
            $cache_array[] = Tools::getValue('id_appagebuilder_profiles');
        }
        return implode('|', $cache_array);
    }

    /**
     * Overide function isCached of Module.php
     * @param type $template
     * @param type $cache_id
     * @param type $compile_id
     * @return boolean
     */
    public function isCached($template, $cache_id = null, $compile_id = null)
    {
        if (Tools::getIsset('live_edit')) {
            return false;
        }
        Tools::enableCache();
        $is_cached = $this->getCurrentSubTemplate($this->getTemplatePath($template), $cache_id, $compile_id);
        $is_cached = $is_cached->isCached($this->getTemplatePath($template), $cache_id, $compile_id);
        Tools::restoreCacheSettings();
        return $is_cached;
    }

    /**
     * This function base on the function getCurrentSubTemplate of Module.php (not overide)
     * @param type $template
     * @param type $cache_id
     * @param type $compile_id
     * @return type
     */
    protected function getCurrentSubTemplate($template, $cache_id = null, $compile_id = null)
    {
        if (!isset($this->current_subtemplate[$template.'_'.$cache_id.'_'.$compile_id])) {
            $this->current_subtemplate[$template.'_'.$cache_id.'_'.$compile_id] = $this->context->smarty->createTemplate(
                    $this->getTemplatePath($template), $cache_id, $compile_id, $this->smarty
            );
        }
        return $this->current_subtemplate[$template.'_'.$cache_id.'_'.$compile_id];
    }

    /**
     * Overide function display of Module.php
     * @param type $file
     * @param type $template
     * @param null $cache_id
     * @param type $compile_id
     * @return type
     */
    public function display($file, $template, $cache_id = null, $compile_id = null)
    {
        //apPageHelper::log('Call display', ApPageSetting::getModeDebugLog());
        if (($overloaded = Module::_isTemplateOverloadedStatic(basename($file, '.php'), $template)) === null) {
            //return Tools::displayError('No template found for module').' '.basename($file, '.php');
            //apPageHelper::log("No template [$template] found for module ".basename($file, '.php'));
            return '';
        } else {
            if (Tools::getIsset('live_edit')) {
                $cache_id = null;
            }
            $this->smarty->assign(array(
                'module_dir' => __PS_BASE_URI__.'modules/'.basename($file, '.php').'/',
                'module_template_dir' => ($overloaded ? _THEME_DIR_ : __PS_BASE_URI__).'modules/'.basename($file, '.php').'/',
                'allow_push' => $this->allow_push
            ));
            if ($cache_id !== null) {
                Tools::enableCache();
            }
            $result = $this->getCurrentSubTemplate($template, $cache_id, $compile_id)->fetch();
            if ($cache_id !== null) {
                Tools::restoreCacheSettings();
            }
            $this->resetCurrentSubTemplate($template, $cache_id, $compile_id);
            //apPageHelper::log('End display', ApPageSetting::getModeDebugLog());
            return $result;
        }
    }

    public function clearHookCache()
    {
        $this->_clearCache('appagebuilder.tpl', $this->name);
    }

    public function hookCategoryAddition()
    {
        $this->clearHookCache();
    }

    public function hookCategoryUpdate()
    {
        $this->clearHookCache();
    }

    public function hookCategoryDeletion()
    {
        $this->clearHookCache();
    }

    public function hookAddProduct()
    {
        $this->clearHookCache();
    }

    public function hookUpdateProduct()
    {
        $this->clearHookCache();
    }

    public function hookDeleteProduct()
    {
        $this->clearHookCache();
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (method_exists($this->context->controller, 'addJquery')) {
            // validate module
            $this->context->controller->addJquery();
        }
        $this->context->controller->addCSS($this->path_resource.'css/admin/style.css');
        $this->context->controller->addJS($this->path_resource.'js/admin/setting.js');
    }

    public function getManufacturersSelect($params)
    {
        $id_lang = $this->context->language->id;
        //fix for previos version
        if ($params['order_by'] == 'position') {
            $params['order_by'] = 'id_manufacturer';
        }
        if (isset($params['order_way']) && $params['order_way'] == 'random') {
            $order = ' RAND()';
        } else {
            $order = (isset($params['order_by']) ? ' '.$params['order_by'] : '').(isset($params['order_way']) ? ' '.$params['order_way'] : '');
        }
        $sql = 'SELECT m.*, ml.`description`, ml.`short_description`
			FROM `'._DB_PREFIX_.'manufacturer` m
			'.Shop::addSqlAssociation('manufacturer', 'm').'
			INNER JOIN `'._DB_PREFIX_.'manufacturer_lang` ml ON (m.`id_manufacturer` = ml.`id_manufacturer` AND ml.`id_lang` = '.(int)$id_lang.')
			WHERE m.`active` = 1 '.(isset($params['manuselect']) ? 'AND m.`id_manufacturer` IN ('.$params['manuselect'].')' : '').' 
			ORDER BY '.$order;
        $manufacturers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($manufacturers === false) {
            return false;
        }
        $total_manufacturers = count($manufacturers);
        $rewrite_settings = (int)Configuration::get('PS_REWRITING_SETTINGS');
        for ($i = 0; $i < $total_manufacturers; $i++)
            $manufacturers[$i]['link_rewrite'] = ($rewrite_settings ? Tools::link_rewrite($manufacturers[$i]['name']) : 0);
        return $manufacturers;
    }

    public function loadResouceForProfile()
    {
        $profile = $this->profile_data;
        $arr = array();
        if ($profile['header']) {
            $arr[] = $profile['header'];
        }
        if ($profile['content']) {
            $arr[] = $profile['content'];
        }
        if ($profile['footer']) {
            $arr[] = $profile['footer'];
        }
        if ($profile['product']) {
            $arr[] = $profile['product'];
        }
        if (count($arr) > 0) {
            $model = new ApPageBuilderProfilesModel();
            $list_positions = $model->getPositionsForProfile(implode(',', $arr));
            if ($list_positions) {
                foreach ($list_positions as $item) {
                    $name = $item['position'].$item['position_key'];
                    $this->context->controller->addCSS(__PS_BASE_URI__.'themes/'.$this->theme_name.
                            '/css/modules/'.$this->name.'/positions/'.$name.'.css');
                    $this->context->controller->addJS(__PS_BASE_URI__.'themes/'.$this->theme_name.
                            '/js/modules/'.$this->name.'/positions/'.$name.'.js');
                }
            }
        }
        $this->context->controller->addCSS(__PS_BASE_URI__.'themes/'.$this->theme_name.
                '/css/modules/'.$this->name.'/profiles/'.$profile['profile_key'].'.css');
        $this->context->controller->addJS(__PS_BASE_URI__.'themes/'.$this->theme_name.
                '/js/modules/'.$this->name.'/profiles/'.$profile['profile_key'].'.js');
    }

    public function getProfileData()
    {
        return $this->profile_data;
    }

    public function setFullwidthHook()
    {
        if (in_array(Context::getContext()->controller->controller_type, array('front', 'modulefront'))) {
            # frontend
            $page_name = $this->context->smarty->tpl_vars['page_name']->value;

            if ($page_name == 'index') {
                $this->context->smarty->assign(array(
                    'fullwidth_hook' => isset($this->profile_param['fullwidth_index_hook']) ? $this->profile_param['fullwidth_index_hook'] : ApPageSetting::getIndexHook(3),
                ));
            } else {
                $this->context->smarty->assign(array(
                    'fullwidth_hook' => isset($this->profile_param['fullwidth_other_hook']) ? $this->profile_param['fullwidth_other_hook'] : ApPageSetting::getOtherHook(3),
                ));
            }
        }
    }

    /**
     * Get Grade By product
     *
     * @return array Grades
     */
    public static function getGradeByProducts($list_product)
    {
        $validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');
        $id_lang = (int)Context::getContext()->language->id;

        return (Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT pc.`id_product_comment`, pcg.`grade`, pccl.`name`, pcc.`id_product_comment_criterion`, pc.`id_product`
		FROM `'._DB_PREFIX_.'product_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'product_comment_grade` pcg ON (pcg.`id_product_comment` = pc.`id_product_comment`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion` pcc ON (pcc.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl ON (pccl.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		WHERE pc.`id_product` in ('.$list_product.')
		AND pccl.`id_lang` = '.(int)$id_lang.
                        ($validate == '1' ? ' AND pc.`validate` = 1' : '')));
    }

    /**
     * Return number of comments and average grade by products
     *
     * @return array Info
     */
    public static function getGradedCommentNumber($list_product)
    {
        $validate = (int)Configuration::get('PRODUCT_COMMENTS_MODERATE');

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT COUNT(pc.`id_product`) AS nbr, pc.`id_product` 
		FROM `'._DB_PREFIX_.'product_comment` pc
		WHERE `id_product` in ('.$list_product.')'.($validate == '1' ? ' AND `validate` = 1' : '').'
		AND `grade` > 0 GROUP BY pc.`id_product`');
        return $result;
    }

    public static function getByProduct($id_product)
    {
        $id_lang = (int)Context::getContext()->language->id;

        if (!Validate::isUnsignedId($id_product) || !Validate::isUnsignedId($id_lang)) {
            die(Tools::displayError());
        }
        $alias = 'p';
        $table = '';
        // check if version > 1.5 to add shop association
        if (version_compare(_PS_VERSION_, '1.5', '>')) {
            $table = '_shop';
            $alias = 'ps';
        }
        return Db::getInstance()->executeS('
			SELECT pcc.`id_product_comment_criterion`, pccl.`name`
			FROM `'._DB_PREFIX_.'product_comment_criterion` pcc
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl
				ON (pcc.id_product_comment_criterion = pccl.id_product_comment_criterion)
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_product` pccp
				ON (pcc.`id_product_comment_criterion` = pccp.`id_product_comment_criterion` AND pccp.`id_product` = '.(int)$id_product.')
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_category` pccc
				ON (pcc.`id_product_comment_criterion` = pccc.`id_product_comment_criterion`)
			LEFT JOIN `'._DB_PREFIX_.'product'.pSQL($table).'` '.pSQL($alias).'
				ON ('.pSQL($alias).'.id_category_default = pccc.id_category AND '.pSQL($alias).'.id_product = '.(int)$id_product.')
			WHERE pccl.`id_lang` = '.(int)$id_lang.'
			AND (
				pccp.id_product IS NOT NULL
				OR ps.id_product IS NOT NULL
				OR pcc.id_product_comment_criterion_type = 1
			)
			AND pcc.active = 1
			GROUP BY pcc.id_product_comment_criterion
		');
    }

    public function hookProductMoreImg($list_pro)
    {
        $id_lang = Context::getContext()->language->id;
        //get product info
        $product_list = $this->getProducts($list_pro, $id_lang);

        $this->smarty->assign(array(
            'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
            'mediumSize' => Image::getSize(ImageType::getFormatedName('medium'))
        ));

        $obj = array();
        foreach ($product_list as $product) {
            $this->smarty->assign('product', $product);
            $obj[] = array('id' => $product['id_product'], 'content' => ($this->display(__FILE__, 'product.tpl')));
        }
        return $obj;
    }

    public function hookProductOneImg($list_pro)
    {
        $protocol_link = (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) ? 'https://' : 'http://';
        $use_ssl = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
        $protocol_content = ($use_ssl) ? 'https://' : 'http://';
        $link = new Link($protocol_link, $protocol_content);

        $id_lang = Context::getContext()->language->id;
        $where = ' WHERE i.`id_product` IN ('.$list_pro.') AND (ish.`cover`=0 OR ish.`cover` IS NULL) AND ish.`id_shop` = '.Context::getContext()->shop->id;
        $order = ' ORDER BY i.`id_product`,`position`';
        $limit = ' LIMIT 0,1';
        //get product info
        $list_img = $this->getAllImages($id_lang, $where, $order, $limit);
        $saved_img = array();
        $obj = array();
        $this->smarty->assign(array(
            'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
            'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
            'smallSize' => Image::getSize(ImageType::getFormatedName('small'))
        ));

        $image_name = 'home';
        $image_name .= '_default';
        foreach ($list_img as $product) {
            if (!in_array($product['id_product'], $saved_img)) {
                $obj[] = array('id' => $product['id_product'], 'content' => ($link->getImageLink($product['link_rewrite'], $product['id_image'], $image_name)));
            }
            $saved_img[] = $product['id_product'];
        }
        return $obj;
    }

    public function hookProductCdown($leo_pro_cdown)
    {
        $id_lang = Context::getContext()->language->id;
        $product_list = $this->getProducts($leo_pro_cdown, $id_lang);
        $obj = array();
        foreach ($product_list as $product) {
            $this->smarty->assign('product', $product);
            $obj[] = array('id' => $product['id_product'], 'content' => ($this->display(__FILE__, 'cdown.tpl')));
        }
        return $obj;
    }

    public function hookProductColor($leo_pro_color)
    {
        $id_lang = Context::getContext()->language->id;
        $colors = array();
        $leo_customajax_color = Configuration::get('APPAGEBUILDER_COLOR');
        if ($leo_customajax_color) {
            $arrs = explode(',', $leo_customajax_color);
            foreach ($arrs as $arr) {
                $items = explode(':', $arr);
                $colors[$items[0]] = $items[1];
            }
        }
        $this->smarty->assign(array(
            'colors' => $colors,
        ));
        $product_list = $this->getProducts($leo_pro_color, $id_lang);
        $obj = array();
        foreach ($product_list as $product) {
            $this->smarty->assign('product', $product);
            $obj[] = array('id' => $product['id_product'], 'content' => ($this->display(__FILE__, 'color.tpl')));
        }
        return $obj;
    }

    public function getProducts($product_list, $id_lang, $colors = array())
    {
        $context = Context::getContext();
        $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
        $ids = Address::getCountryAndState($id_address);
        $id_country = ($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
        $sql = 'SELECT p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name,sp.`id_specific_price`
				FROM `'._DB_PREFIX_.'product` p
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)
				LEFT JOIN `'._DB_PREFIX_.'specific_price` sp ON (sp.`id_product` = p.`id_product`
						AND sp.`id_shop` IN(0, '.(int)$context->shop->id.')
						AND sp.`id_currency` IN(0, '.(int)$context->currency->id.')
						AND sp.`id_country` IN(0, '.(int)$id_country.')
						AND sp.`id_group` IN(0, '.(int)$context->customer->id_default_group.')
						AND sp.`id_customer` IN(0, '.(int)$context->customer->id.')
						AND sp.`reduction` > 0
					)
				WHERE pl.`id_lang` = '.(int)$id_lang.
                ' AND p.`id_product` in ('.$product_list.')';
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($product_list) {
            $tmp_img = array();
            $cover_img = array();
            $where = ' WHERE i.`id_product` IN ('.$product_list.') AND ish.`id_shop` = '.Context::getContext()->shop->id;
            $order = ' ORDER BY i.`id_product`,`position`';

            switch (Configuration::get('LEO_MINFO_SORT')) {
                case 'position2':
                    break;
                case 'random':
                    $order = ' ORDER BY RAND()';
                    break;
                default:
                    $order = ' ORDER BY i.`id_product`,`position` DESC';
            }

            $list_img = $this->getAllImages($id_lang, $where, $order);
            foreach ($list_img as $val) {
                $tmp_img[$val['id_product']][$val['id_image']] = $val;
                if ($val['cover'] == 1)
                    $cover_img[$val['id_product']] = $val['id_image'];
            }
        }
        $now = date('Y-m-d H:i:s');
        $finish = $this->l('Expired');
        foreach ($result as &$val) {
            $time = false;
            if (isset($tmp_img[$val['id_product']])) {
                $val['images'] = $tmp_img[$val['id_product']];
                $val['id_image'] = $cover_img[$val['id_product']];
            } else {
                $val['images'] = array();
            }

            $val['specific_prices'] = self::getSpecificPriceById($val['id_specific_price']);
            if (isset($val['specific_prices']['from']) && $val['specific_prices']['from'] > $now) {
                $time = strtotime($val['specific_prices']['from']);
                $val['finish'] = $finish;
                $val['check_status'] = 0;
                $val['lofdate'] = Tools::displayDate($val['specific_prices']['from']);
            } elseif (isset($val['specific_prices']['to']) && $val['specific_prices']['to'] > $now) {
                $time = strtotime($val['specific_prices']['to']);
                $val['finish'] = $finish;
                $val['check_status'] = 1;
                $val['lofdate'] = Tools::displayDate($val['specific_prices']['to']);
            } elseif (isset($val['specific_prices']['to']) && $val['specific_prices']['to'] == '0000-00-00 00:00:00') {
                $val['js'] = 'unlimited';
                $val['finish'] = $this->l('Unlimited');
                $val['check_status'] = 1;
                $val['lofdate'] = $this->l('Unlimited');
            } else if (isset($val['specific_prices']['to'])) {
                $time = strtotime($val['specific_prices']['to']);
                $val['finish'] = $finish;
                $val['check_status'] = 2;
                $val['lofdate'] = Tools::displayDate($val['specific_prices']['from']);
            }
            if ($time) {
                $val['js'] = array(
                    'month' => date('m', $time),
                    'day' => date('d', $time),
                    'year' => date('Y', $time),
                    'hour' => date('H', $time),
                    'minute' => date('i', $time),
                    'seconds' => date('s', $time)
                );
            }
        }
        unset($colors);
        return Product::getProductsProperties($id_lang, $result);
    }

    public static function getSpecificPriceById($id_specific_price)
    {
        if (!SpecificPrice::isFeatureActive()) {
            return array();
        }

        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT *
			FROM `'._DB_PREFIX_.'specific_price` sp
			WHERE `id_specific_price` ='.(int)$id_specific_price);

        return $res;
    }

    public function getAllImages($id_lang, $where, $order)
    {
        $id_shop = Context::getContext()->shop->id;
        $sql = 'SELECT DISTINCT i.`id_product`, ish.`cover`, i.`id_image`, il.`legend`, i.`position`,pl.`link_rewrite`
				FROM `'._DB_PREFIX_.'image` i
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (i.`id_product` = pl.`id_product`) 
				LEFT JOIN `'._DB_PREFIX_.'image_shop` ish ON (ish.`id_image` = i.`id_image` AND ish.`id_shop` = '.(int)$id_shop.') 
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')'.pSql($where).' '.pSQL($order);
        return Db::getInstance()->executeS($sql);
    }

    // show category and tags of product
    public function hookdisplayProductInformation($params)
    {
        $return = '';
        $product_id = $params['product']->id;
        $category_id = $params['product']->id_category_default;
        $cat = new Category($category_id, $this->context->language->id);
        $product_tags = Tag::getProductTags($product_id);
        $product_tags = $product_tags[(int)$this->context->cookie->id_lang];
        $return .= '<div class =category>Category: <a href="'.$this->context->link->getCategoryLink($category_id, $cat->link_rewrite).'">'.$cat->name.'</a>.</div>';
        $return .= '<div class="producttags clearfix">';
        $return .= 'Tag: ';
        if ($product_tags && count($product_tags) > 1) {
            $count = 0;
            foreach ($product_tags as $tag) {
                $return .= '<a href="'.$this->context->link->getPageLink('search', true, NULL, "tag=$tag").'">'.$tag.'</a>';
                if ($count < count($product_tags) - 1) {
                    $return .= ',';
                } else {
                    $return .= '.';
                }
                $count++;
            }
        }
        $return .= '</div>';
        return $return;
    }
}
