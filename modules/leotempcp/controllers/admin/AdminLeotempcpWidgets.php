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
require_once(_PS_MODULE_DIR_.'leotempcp/libs/helper.php');
if (file_exists(_PS_MODULE_DIR_.'leotempcp/classes/widgetbase.php')) {
    require_once( _PS_MODULE_DIR_.'leotempcp/classes/widgetbase.php' );
}
if (file_exists(_PS_MODULE_DIR_.'leotempcp/classes/widget.php')) {
    require_once( _PS_MODULE_DIR_.'leotempcp/classes/widget.php' );
}
if (file_exists(_PS_MODULE_DIR_.'leomanagewidgets/classes/LeomanagewidgetsOwlCarousel.php')) {
    require_once(_PS_MODULE_DIR_.'leomanagewidgets/classes/LeomanagewidgetsOwlCarousel.php');
}

class AdminLeotempcpWidgetsController extends ModuleAdminControllerCore
{
    public $widget;
    public $base_config_url;
    private $_imageField = array('htmlcontent', 'content', 'information');
    private $_langField = array('widget_title', 'text_link', 'htmlcontent', 'header', 'content', 'information');
    private $_theme_dir = '';

    public function __construct()
    {
        $this->widget = new LeoTempcpWidget();
        $this->className = 'LeoTempcpWidget';
        $this->bootstrap = true;
        $this->table = 'leowidgets';
        $this->fields_list = array(
            'id_leowidgets' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 50,
                'class' => 'fixed-width-xs'
            ),
            'key_widget' => array(
                'title' => $this->l('Widget Key'),
                'filter_key' => 'a!key_widget',
                'type' => 'text',
                'width' => 140,
            ),
            'name' => array(
                'title' => $this->l('Widget Name'),
                'width' => 140,
                'type' => 'text',
                'filter_key' => 'a!name'
            ),
            'type' => array(
                'title' => $this->l('Widget Type'),
                'width' => 50,
                'type' => 'text',
                'filter_key' => 'a!type'
            ),
        );
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            ),
            'correctlink' => array(
                'text' => $this->l('Correct Image Link'),
                'confirm' => $this->l('Are you sure you want to change image url from old theme to new theme?'),
                'icon' => 'icon-edit'
            ),
            'insertLang' => array(
                'text' => $this->l('Auto Input Data for New Lang'),
                'confirm' => $this->l('Auto insert data for new language?'),
                'icon' => 'icon-edit'
            ),
            'correctContent' => array(
                'text' => $this->l('Correct Content use basecode64(Just for developer)'),
                'confirm' => $this->l('Are you sure?'),
                'icon' => 'icon-edit'
            ),
        );
        parent::__construct();
        $this->_where = ' AND id_shop='.(int)($this->context->shop->id);
        $this->_theme_dir = Context::getContext()->shop->getTheme();
    }

    public function renderList()
    {
        $this->initToolbar();
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        return parent::renderList();
    }

    public function renderForm()
    {
        if (!$this->loadObject(true)) {
            return;
        }
        if (Validate::isLoadedObject($this->object)) {
            $this->display = 'edit';
        } else {
            $this->display = 'add';
        }
        $this->initToolbar();
        $this->context->controller->addJqueryUI('ui.sortable');
        return $this->_showWidgetsSetting();
    }

    public function _showWidgetsSetting()
    {
        $this->context->controller->addJS(__PS_BASE_URI__.'modules/leotempcp/assets/admin/jquery-validation-1.9.0/jquery.validate.js');
        $this->context->controller->addCSS(__PS_BASE_URI__.'modules/leotempcp/assets/admin/jquery-validation-1.9.0/screen.css');

        $this->context->controller->addJS(__PS_BASE_URI__.'modules/leotempcp/assets/admin/show.js');
        $tpl = $this->createTemplate('widget.tpl');
//		$disabled = false;
        $form = '';
        $widget_selected = '';
        $id = (int)Tools::getValue('id_leowidgets');
        $key = (int)Tools::getValue('key');
        if (Tools::getValue('id_leowidgets')) {
            $model = new LeoTempcpWidget((int)Tools::getValue('id_leowidgets'));
        } else {
            $model = $this->widget;
        }
        $model->loadEngines();
        $model->id_shop = Context::getContext()->shop->id;

        $types = $model->getTypes();
        if ($key) {
            $widget_data = $model->getWidetByKey($key, Context::getContext()->shop->id);
        } else {
            $widget_data = $model->getWidetById($id);
        }

        $id = (int)$widget_data['id'];
        $widget_selected = trim(Tools::strtolower(Tools::getValue('wtype')));
        if ($widget_data['type']) {
            $widget_selected = $widget_data['type'];
//			$disabled = true;
        }

        $form = $model->getForm($widget_selected, $widget_data);
        $is_using_managewidget = 1;
        if (!file_exists(_PS_MODULE_DIR_.'leomanagewidgets/leomanagewidgets.php') || !Module::isInstalled('leomanagewidgets')) {
            # validate module
            $is_using_managewidget = 0;
        }
        $tpl->assign(array(
            'types' => $types,
            'form' => $form,
            'is_using_managewidget' => $is_using_managewidget,
            'widget_selected' => $widget_selected,
            'table' => $this->table,
            'max_size' => Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),
            'PS_ALLOW_ACCENTED_CHARS_URL' => Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
            'action' => AdminController::$currentIndex.'&add'.$this->table.'&token='.$this->token,
        ));
        return $tpl->fetch();
    }

    public function postProcess()
    {
        if ((Tools::isSubmit('saveleotempcp') || Tools::isSubmit('saveandstayleotempcp')) && Tools::isSubmit('widgets')) {
            if (!Tools::getValue('widget_name')) {
                $this->errors[] = Tools::displayError('Widget Name Empty !');
            }
            if (!count($this->errors)) {
                if (Tools::getValue('id_leowidgets')) {
                    $model = new LeoTempcpWidget((int)Tools::getValue('id_leowidgets'));
                } else {
                    $model = $this->widget;
                }
                $model->loadEngines();
                $model->id_shop = Context::getContext()->shop->id;
//				$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
                $languages = Language::getLanguages(false);

                $tmp = array();


                # GET POST - BEGIN
                $widget_type = Tools::getValue('widget_type');
                $file_name = _PS_MODULE_DIR_.'leotempcp/classes/widget/'.$widget_type.'.php';
                require_once($file_name);
                $class_name = 'LeoWidget'.Tools::ucfirst($widget_type);
                $widget = new $class_name;
                $keys = array('addleowidgets', 'id_leowidgets', 'widget_name', 'widget_type', 'saveandstayleotempcp');
                $post = LeoFrameworkHelper::getPost($keys, 0);
                $keys = array('widget_title');
                $post += LeoFrameworkHelper::getPost($keys, 1);
                $keys = $widget->getConfigKey(0);
                $post += LeoFrameworkHelper::getPost($keys, 0);
                $keys = $widget->getConfigKey(1);
                $post += LeoFrameworkHelper::getPost($keys, 1);
                $keys = $widget->getConfigKey(2);
                $post += LeoFrameworkHelper::getPost($keys, 2);
                # GET POST - END

                foreach ($post as $key => $value) {
                    $tmp[$key] = str_replace(array('\'', '\"'), array("'", '"'), $value);
                    foreach ($this->_langField as $fVal) {
                        if (strpos($key, $fVal) !== false) {
                            foreach ($languages as $language) {
                                if (!Tools::getValue($fVal.'_'.$language['id_lang'])) {
                                    $tmp[$fVal.'_'.$language['id_lang']] = $value;
                                }
                            }
                        }
                    }
                }

                $data = array(
                    'id' => Tools::getValue('id_leowidgets'),
                    'params' => call_user_func('base64'.'_encode', Tools::jsonEncode($tmp)),
                    'type' => Tools::getValue('widget_type'),
                    'name' => Tools::getValue('widget_name')
                );

                foreach ($data as $k => $v) {
                    $model->{$k} = $v;
                }

                if ($model->id) {
                    if (!$model->update()) {
                        $this->errors[] = Tools::displayError('Can not update new widget');
                    } else {
                        $model->clearCaches();
                        if (Tools::isSubmit('saveandstayleotempcp')) {
                            $this->confirmations[] = $this->l('Update successful');
                            Tools::redirectAdmin(self::$currentIndex.'&id_leowidgets='.$model->id.'&updateleowidgets&token='.$this->token.'&conf=4');
                        } else {
                            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token.'&conf=4');
                        }
                    }
                } else {
                    $model->key_widget = time();
                    if (!$model->add()) {
                        $this->errors[] = Tools::displayError('Can not add new widget');
                    } else {
                        $model->clearCaches();
                        if (Tools::isSubmit('saveandstayleotempcp')) {
                            $this->confirmations[] = $this->l('Update successful');
                            Tools::redirectAdmin(self::$currentIndex.'&id_leowidgets='.$model->id.'&updateleowidgets&token='.$this->token.'&conf=4');
                        } else {
                            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token.'&conf=4');
                        }
                    }
                }
            }
        }
        if (Tools::isSubmit('submitBulkcorrectlinkleowidgets')) {
            $leowidgetsBox = Tools::getValue('leowidgetsBox');
            if ($leowidgetsBox) {
                foreach ($leowidgetsBox as $widgetID) {
                    $model = new LeoTempcpWidget($widgetID);
                    $params = Tools::jsonDecode(call_user_func('base64'.'_decode', $model->params), true);

                    $tmp = array();
                    foreach ($params as $widKey => $widValue) {
                        foreach ($this->_imageField as $fVal) {
                            if (strpos($widKey, $fVal) !== false && strpos($widValue, 'img') !== false) {
//                            $widValue = str_replace('src="' . __PS_BASE_URI__ . 'modules/', 'src="' . __PS_BASE_URI__ . 'themes/'.$this->_theme_dir.'/img/modules/', $widValue);
//                            $patterns = array('/\/leomanagewidgets\/data\//','/\/leobootstrapmenu\/img\//','/\/leobootstrapmenu\/images\//'
//                                ,'/\/leomanagewidgets\/images\//','/\/leomenusidebar\/images\//');
//                            $replacements = array('/leomanagewidgets/','/leobootstrapmenu/','/leobootstrapmenu/','/leomanagewidgets/','/leomenusidebar/');
//                            $widValue = preg_replace($patterns, $replacements, $widValue);
                                //remove comment when install theme base
                                //$widValue = str_replace('/prestashop/base-theme/themes/', __PS_BASE_URI__. 'themes/', $widValue);

                                $widValue = preg_replace('/\/themes\/(\w+)\/img/', '/themes/'.$this->_theme_dir.'/img', $widValue);
                                break;
                            }
                        }

                        $tmp[$widKey] = $widValue;
                    }

                    $model->params = call_user_func('base64'.'_encode', Tools::jsonEncode($tmp));
                    $model->save();
                }
            }
        }

        if (Tools::isSubmit('submitBulkinsertLangleowidgets')) {
            $leowidgetsBox = Tools::getValue('leowidgetsBox');
            $id_currentLang = $this->context->language->id;
            $languages = Language::getLanguages(false);

            if ($leowidgetsBox) {
                foreach ($leowidgetsBox as $widgetID) {
                    $model = new LeoTempcpWidget($widgetID);
                    $tmp = Tools::jsonDecode(call_user_func('base64'.'_decode', $model->params), true);

                    $defauleVal = array();
                    if ($tmp) {
                        foreach ($tmp as $widKey => $widValue) {
                            $defaulArray = explode('_', $widKey);
                            if (strpos($widKey, '_'.$id_currentLang) !== false && $defaulArray[count($defaulArray) - 1] == $id_currentLang) {
                                $defauleVal[$widKey] = $widValue;
                            }
                        }
                    }
                    if ($defauleVal) {
                        foreach ($languages as $lang) {
                            if ($lang['id_lang'] == $id_currentLang) {
                                continue;
                            }

                            foreach ($defauleVal as $widKey => $widValue) {
                                $keyRemove = Tools::substr($widKey, 0, -Tools::strlen('_'.$id_currentLang));
                                $keyReal = $keyRemove.'_'.$lang['id_lang'];
                                if (!isset($tmp[$keyReal]) || trim($tmp[$keyReal]) == '') {
                                    $tmp[$keyReal] = $widValue;
                                }
                            }
                        }
                    }
                    if ($defauleVal) {
                        $model->params = call_user_func('base64'.'_encode', Tools::jsonEncode($tmp));
                        $model->save();
                    }
                }
            }
        }

        if (Tools::isSubmit('submitBulkcorrectContentleowidgets')) {
            $leowidgetsBox = Tools::getValue('leowidgetsBox');
            $id_currentLang = $this->context->language->id;
            $languages = Language::getLanguages(false);

            if ($leowidgetsBox) {
                foreach ($leowidgetsBox as $widgetID) {
                    $model = new LeoTempcpWidget($widgetID);
                    $tmp = @unserialize($model->params);
                    if (!$tmp) {
                        $tmp = Tools::json_decode($model->params, true);
                    }
                    if ($tmp) {
                        $model->params = call_user_func('base64'.'_encode', Tools::jsonEncode($tmp));
                        $model->save();
                    }
                }
            }
        }

        parent::postProcess();
    }
}
