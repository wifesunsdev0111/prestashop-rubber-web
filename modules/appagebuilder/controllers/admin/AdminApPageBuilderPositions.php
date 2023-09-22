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

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderPositionsModel.php');

class AdminApPageBuilderPositionsController extends ModuleAdminControllerCore
{
    public $position_js_folder = '';
    public $position_css_folder = '';
    public $module_name = 'appagebuilder';
    public $explicit_select;
    public $order_by;
    public $order_way;
    public $theme_dir;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'appagebuilder_positions';
        $this->className = 'ApPageBuilderPositionsModel';
        $this->lang = false;
        $this->explicit_select = true;
        $this->allow_export = true;
        $this->context = Context::getContext();
        $this->order_by = 'position';
        $this->order_way = 'DESC';
        $this->_join = '
			INNER JOIN `'._DB_PREFIX_.'appagebuilder_positions_shop` ps ON (ps.`id_appagebuilder_positions` = a.`id_appagebuilder_positions`)';

        $this->fields_list = array(
            'id_appagebuilder_positions' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 50,
                'class' => 'fixed-width-xs'
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 140,
                'type' => 'text',
                'filter_key' => 'a!position',
                'remove_onclick' => true
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'width' => 140,
                'type' => 'text',
                'filter_key' => 'a!name',
                'remove_onclick' => true
            ),
            'position_key' => array(
                'title' => $this->l('Key'),
                'filter_key' => 'a!position_key',
                'type' => 'text',
                'width' => 140,
                'remove_onclick' => true
            )
        );
        $this->list_no_link = 'no';
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
            )
        );
        parent::__construct();
        $this->_where = ' AND ps.id_shop='.(int)$this->context->shop->id;

        $this->theme_dir = _PS_ROOT_DIR_.'/themes/'.Context::getContext()->shop->getTheme().'/';
        $this->position_css_folder = $this->theme_dir.'css/modules/'.$this->module_name.'/positions/';
        $this->position_js_folder = $this->theme_dir.'js/modules/'.$this->module_name.'/positions/';

        if (!is_dir($this->position_css_folder)) {
            if (!is_dir($this->theme_dir.'css/modules/'.$this->module_name)) {
                mkdir($this->theme_dir.'css/modules/'.$this->module_name, 0755);
            }
            mkdir($this->position_css_folder, 0755);
        }
        if (!is_dir($this->position_js_folder)) {
            if (!is_dir($this->theme_dir.'js/modules/'.$this->module_name)) {
                mkdir($this->theme_dir.'js/modules/'.$this->module_name, 0755);
            }
            mkdir($this->position_js_folder, 0755);
        }
    }

    public function processDelete()
    {
        $object = $this->loadObject();
        // Check using other profile
        $result = ApPageBuilderPositionsModel::getProfileUsingPosition($object->id);
        if (!$result) {
            $object = parent::processDelete();
            if ($object->position_key) {
                Tools::deleteFile($this->position_css_folder.$object->position.$object->position_key.'.css');
                Tools::deleteFile($this->position_js_folder.$object->position.$object->position_key.'.js');
            }
        } else {
            $name_profile = '';
            $sep = '';
            foreach ($result as $item) {
                $name_profile .= $sep.$item['name'];
                $sep = ', ';
            }
            $this->errors[] = Tools::displayError("Can not delete default this Positions. It is using by Profile: [$name_profile]");
        }
        return $object;
    }

    public function renderView()
    {
        $object = $this->loadObject();
        if ($object->page == 'product_detail') {
            $this->redirect_after = Context::getContext()->link->getAdminLink('AdminApPageBuilderProductDetail');
        } else {
            $this->redirect_after = Context::getContext()->link->getAdminLink('AdminApPageBuilderHome');
        }
        $this->redirect_after .= '&id_appagebuilder_positions='.$object->id;
        $this->redirect();
    }

    public function processStatus()
    {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            if ($object->toggleStatus()) {
                $matches = array();
                if (preg_match('/[\?|&]controller=([^&]*)/', (string)$_SERVER['HTTP_REFERER'], $matches) !== false && Tools::strtolower($matches[1]) != Tools::strtolower(preg_replace('/controller/i', '', get_class($this)))) {
                    $this->redirect_after = preg_replace('/[\?|&]conf=([^&]*)/i', '', (string)$_SERVER['HTTP_REFERER']);
                } else {
                    $this->redirect_after = self::$currentIndex.'&token='.$this->token;
                }

                $id_category = (($id_category = (int)Tools::getValue('id_category')) && Tools::getValue('id_product')) ? '&id_category='.$id_category : '';
                $this->redirect_after .= '&conf=5'.$id_category;
            } else {
                $this->errors[] = Tools::displayError('You can not disable default profile, Please select other profile as default');
            }
        } else {
            $this->errors[] = Tools::displayError('An error occurred while updating the status for an object.')
                    .' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
        }

        return $object;
    }

    public function postProcess()
    {
        parent::postProcess();
        if (Tools::getIsset('duplicateappagebuilder_positions')) {
            $id = Tools::getValue('id_appagebuilder_positions');
            $this->duplicatePosition($id, '');
        }
    }

    public function duplicatePosition($id, $type = '', $name = '')
    {
        $id = (int)$id;
        $object = ApPageBuilderPositionsModel::getPositionById($id);
        if ($object) {
            $key = ApPageSetting::getRandomNumber();
            $old_key = $object->position_key;
            $name = $name ? $name : $this->l('Duplicate ').$key;
            $data = array('name' => $name, 'position' => $object['position'], 'position_key' => 'duplicate_'.$key);
            $model = new ApPageBuilderPositionsModel();
            $duplicate_id = $model->addAuto($data);
            AdminApPageBuilderShortcodesController::duplcateDataPosition($id, $duplicate_id);
            if ($duplicate_id) {
                //duplicate shortCode
                ApPageSetting::writeFile($this->position_js_folder, $data['position'].$data['position_key'].'.js', Tools::file_get_contents($this->position_js_folder.$data['position'].$old_key.'.js'));
                ApPageSetting::writeFile($this->position_css_folder, $data['position'].$data['position_key'].'.css', Tools::file_get_contents($this->position_css_folder.$data['position'].$old_key.'.css'));
                if ($type != 'ajax') {
                    $this->redirect_after = self::$currentIndex.'&token='.$this->token;
                    $this->redirect();
                } else {
                    return $duplicate_id;
                }
            } else {
                if ($type != 'ajax') {
                    Tools::displayError('Can not duplicate Position');
                } else {
                    return 0;
                }
            }
        } else if ($type != 'ajax') {
            Tools::displayError('Can not duplicate Position');
        } else {
            return 0;
        }
    }

    public function renderList()
    {
        $this->initToolbar();

        $this->addRowAction('view');
        $this->addRowAction('edit');
        $this->addRowAction('duplicate');
        $this->addRowAction('delete');
        return parent::renderList();
    }

    public function renderForm()
    {
        $this->initToolbar();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Ap Position Manage'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'required' => true,
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Position Key'),
                    'name' => 'position_key',
                    'required' => true,
                    'desc' => $this->l('Use it to save as file name of css and js of Position'),
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Type'),
                    'name' => 'position',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'header',
                                'name' => $this->l('Header'),
                            ),
                            array(
                                'id' => 'content',
                                'name' => $this->l('Content'),
                            ),
                            array(
                                'id' => 'footer',
                                'name' => $this->l('Footer'),
                            ),
                            array(
                                'id' => 'product',
                                'name' => $this->l('Product'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Custom Css'),
                    'name' => 'css',
                    'desc' => sprintf($this->l('Please set write Permission for folder %s'), $this->position_css_folder),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Custom Js'),
                    'name' => 'js',
                    'desc' => sprintf($this->l('Please set write Permission for folder %s'), $this->position_js_folder),
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            ),
            'buttons' => array(
                'save-and-stay' => array(
                    'title' => $this->l('Save and Stay'),
                    'name' => 'submitAdd'.$this->table.'AndStay',
                    'type' => 'submit',
                    'class' => 'btn btn-default pull-right',
                    'icon' => 'process-icon-save'
                ))
        );
        return parent::renderForm();
    }

    public function getFieldsValue($obj)
    {
        $file_value = parent::getFieldsValue($obj);
        if ($obj->id && $obj->position_key) {
            $file_value['css'] = Tools::file_get_contents($this->position_css_folder.$obj->position.$obj->position_key.'.css');
            $file_value['js'] = Tools::file_get_contents($this->position_js_folder.$obj->position.$obj->position_key.'.js');
        } else {
            $file_value['position_key'] = 'position'.ApPageSetting::getRandomNumber();
        }
        return $file_value;
    }

    public function processAdd()
    {
        if ($obj = parent::processAdd()) {
            $this->saveCustomJsAndCss($obj->position.$obj->position_key, '');
        }
    }

    public function processUpdate()
    {
        // Check ifchange position => need delete current file css/js before update
        $old_object = parent::loadObject();
        if ($obj = parent::processUpdate()) {
            $this->saveCustomJsAndCss($obj->position.$obj->position_key, $old_object->position.$obj->position_key);
        }
    }

    public function saveCustomJsAndCss($key, $old_key = '')
    {
        // Delete old file
        if ($old_key) {
            Tools::deleteFile($this->position_css_folder.$old_key.'.css');
            Tools::deleteFile($this->position_js_folder.$old_key.'.js');
        }
        ApPageSetting::writeFile($this->position_js_folder, $key.'.js', Tools::getValue('js'));
        ApPageSetting::writeFile($this->position_css_folder, $key.'.css', Tools::getValue('css'));
    }

    /**
     * Auto create a position for page build profile editing/creating
     * @param type $obj
     */
    public function autoCreatePosition($obj)
    {
        $model = new ApPageBuilderPositionsModel();
        $id = $model->addAuto($obj);
        if ($id) {
            $this->saveCustomJsAndCss($obj['position'].$obj['position_key'], '');
        }
        return $id;
    }

    public function updateName($id, $name)
    {
        return ApPageBuilderPositionsModel::updateName($id, $name);
    }

    public function processBulkDelete()
    {
        // Remove resouce and update table profiles
        $arr = $this->boxes;
        if (!$arr) {
            return;
        }
        foreach ($arr as $item) {
            //$data = ApPageBuilderPositionsModel::getAllPosition();
            $object = ApPageBuilderPositionsModel::getPositionById($item);
            if ($object['position_key']) {
                Tools::deleteFile($this->position_css_folder.$object['position'].$object['position_key'].'.css');
                Tools::deleteFile($this->position_js_folder.$object['position'].$object['position_key'].'.js');
            }
            ApPageBuilderPositionsModel::deletePositionById($item, $object['position']);
        }
        //parent::processBulkDelete();
    }
}
