<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

include_once(_PS_MODULE_DIR_.'psblog/loader.php');

class AdminPsblogCategoriesController extends ModuleAdminController
{
    public $name = 'psblog';
    protected $fields_form = array();
	private $_html = '';
	
    public function __construct()
    {
        $this->bootstrap = true;
        $this->id_psblogcat = true;
        $this->table = 'psblogcat';

        $this->className = 'psblogcat';
        $this->lang = true;
        $this->fields_options = array();		
        
        parent::__construct();
		
		$this->toolbar_title = $this->l('Categories Management');
		// echo '<pre>';
		// print_r($this->l('Ps Blog Management'));die();
    }

    /**
     * Build List linked Icons Toolbar
     */
    public function initPageHeaderToolbar()
    {
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/ui/themes/base/jquery.ui.tabs.css');
        if (file_exists(_PS_THEME_DIR_.'css/modules/psblog/assets/admin/form.css')) {
            $this->context->controller->addCss(__PS_BASE_URI__.'modules/psblog/assets/admin/form.css');
        } else {
            $this->context->controller->addCss(__PS_BASE_URI__.'modules/psblog/views/css/admin/form.css');
        }

        if (empty($this->display)) {
            parent::initPageHeaderToolbar();
        }
    }

    /**
     *
     */
    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJqueryUi('ui.widget');
        $this->addJqueryPlugin('tagify');
		$this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/ui/jquery.ui.sortable.min.js');
        if (file_exists(_PS_THEME_DIR_.'js/modules/psblog/assets/admin/jquery.nestable.js')) {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/psblog/assets/admin/jquery.nestable.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/psblog/views/js/admin/jquery.nestable.js');
        }
        if (file_exists(_PS_THEME_DIR_.'js/modules/psblog/assets/admin/form.js')) {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/psblog/assets/admin/form.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/psblog/views/js/admin/form.js');
        }

        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/jquery.cookie-plugin.js');
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/ui/jquery.ui.tabs.min.js');
    }

    /**
     * get live Edit URL
     */
    public function getLiveEditUrl($live_edit_params)
    {
        $url = $this->context->shop->getBaseURL().Dispatcher::getInstance()->createUrl('index', (int)$this->context->language->id, $live_edit_params);
        if (Configuration::get('PS_REWRITING_SETTINGS')) {
            $url = str_replace('index.php', '', $url);
        }
        return $url;
    }

    /**
     * add toolbar icons
     */
    public function initToolbar()
    {
        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
        $this->context->smarty->assign('title', $this->toolbar_title);
    }

    public function postProcess()
    {
        if (Tools::getValue('doupdatepos') && Tools::isSubmit('updatePosition')) {
            $list = Tools::getValue('list');
            $root = 1;
            $child = array();
            foreach ($list as $id => $parent_id) {
                if ($parent_id <= 0) {
                    # validate module
                    $parent_id = $root;
                }
                $child[$parent_id][] = $id;
            }
            $res = true;
            foreach ($child as $id_parent => $menus) {
                $i = 0;
                foreach ($menus as $id_psblogcat) {
                    $sql = 'UPDATE `'._DB_PREFIX_.'psblogcat` SET `position` = '.(int)$i.', id_parent = '.(int)$id_parent.' 
	                        WHERE `id_psblogcat` = '.(int)$id_psblogcat;
                    $res &= Db::getInstance()->execute($sql);
                    $i++;
                }
            }
            die($this->l('Update Positions Done'));
        }
        /* delete megamenu item */
        if (Tools::getValue('dodel')) {
            $obj = new psblogcat((int)Tools::getValue('id_psblogcat'));
            $res = $obj->delete();
            Tools::redirectAdmin(AdminController::$currentIndex.'&token='.Tools::getValue('token'));
        }
        if (Tools::isSubmit('save'.$this->name) && Tools::isSubmit('active')) {
            if ($id_psblogcat = Tools::getValue('id_psblogcat')) {
                # validate module
                $megamenu = new psblogcat((int)$id_psblogcat);
            } else {
                # validate module
                $megamenu = new psblogcat();
            }

            $this->copyFromPost($megamenu, $this->table);
            $megamenu->id_shop = $this->context->shop->id;
            if ($megamenu->validateFields(false) && $megamenu->validateFieldsLang(false)) {
                $megamenu->save();
                if (isset($_FILES['image_link']) && isset($_FILES['image_link']['tmp_name']) && !empty($_FILES['image_link']['tmp_name'])) {
					if ($megamenu->image != '')
					{
						$old_image = $megamenu->image;
					}
					
                    if (ImageManager::validateUpload($_FILES['image_link'])) {
                        return false;
                    } elseif (!($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['image_link']['tmp_name'], $tmp_name)) {
                        return false;
                    } elseif (!ImageManager::resize($tmp_name, _PsBLOG_BLOG_IMG_DIR_.'c/'.$_FILES['image_link']['name'])) {
                        return false;
                    }
                    unlink($tmp_name);
                    $megamenu->image = $_FILES['image_link']['name'];
			if (isset($old_image))
			{
				unlink(_PsBLOG_BLOG_IMG_DIR_.'c/'.$old_image);
			}
					
                    $megamenu->save();
                }
                Tools::redirectAdmin(AdminController::$currentIndex.'&savepsblog&token='.Tools::getValue('token').'&id_psblogcat='.$megamenu->id);
            } else {
                // validate module
                $this->_html .= '<div class="conf error alert alert-warning">'.$this->l('An error occurred while attempting to save.').'</div>';
            }
        }
    }

    /**
     *
     *
     */
    public function renderList()
    {
        $this->initToolbar();
        if (!$this->loadObject(true)) {
            return;
        }
	        
        $obj = $this->object;
        $tree = $obj->getTree();
        $menus = $obj->getDropdown(null, $obj->id_parent);

        # FIX : PARENT IS NOT THIS CATEGORY
        $id_psblogcat = (int) (Tools::getValue('id_psblogcat'));
        foreach ($menus as $key => $menu) {
            if($menu['id'] == $id_psblogcat)
            {
                unset($menus[$key]);
            }
        }

        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $templates = PsBlogHelper::getTemplates();

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

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Category Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Category ID'),
                    'name' => 'id_psblogcat',
                    'default' => 0,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Theme - Template'),
                    'name' => 'template',
                    'options' => array('query' => $templates,
                        'id' => 'template',
                        'name' => 'template'),
                    'default' => 'default',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta title:'),
                    'default' => '',
                    'name' => 'title',
                    'id' => 'name', // for copyMeta2friendlyURL compatibility
                    'lang' => true,
                    'required' => true,
                    'class' => 'copyMeta2friendlyURL',
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Friendly URL'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'lang' => true,
                    'default' => '',
                    'hint' => $this->l('Only letters and the minus (-) character are allowed')
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Parent ID'),
                    'name' => 'id_parent',
                    'options' => array('query' => $menus,
                        'id' => 'id',
                        'name' => 'title'),
                    'default' => 'url',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Is Active'),
                    'name' => 'active',
                    'values' => $soption,
                    'default' => '1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Title'),
                    'name' => 'show_title',
                    'values' => $soption,
                    'default' => '1',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Addion Css Class'),
                    'name' => 'menu_class',
                    'display_image' => true,
                    'default' => ''
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Menu Icon Class'),
                    'name' => 'icon_class',
                    'display_image' => true,
                    'default' => '',
                    'desc' => $this->l('The module integrated with FontAwesome').'. '
                    .$this->l('Check list of icons and class name in here')
                    .' <a href="http://fontawesome.io/" target="_blank">http://fontawesome.io/</a> or your icon class'
                ),
		array(
                    'type' => 'hidden',
                    'label' => $this->l('Image name'),
                    'name' => 'image',
					'default' => '',
				),
                array(
                    'type' => 'file',
                    'label' => $this->l('Image'),
                    'name' => 'image_link',
                    'display_image' => true,
                    'default' => '',
                    'desc' => $this->l(''),
                    'thumb' => '',
                    'title' => $this->l('Icon Preview'),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'content_text',
                    'lang' => true,
                    'default' => '',
                    'autoload_rte' => true
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-large btn-danger'
            )
        );

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('SEO META'),
            ),
            'input' => array(
                // custom template
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Meta description'),
                    'name' => 'meta_description',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}',
                    'default' => ''
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Meta keywords'),
                    'name' => 'meta_keywords',
                    'lang' => true,
                    'default' => '',
                    'hint' => array(
                        $this->l('Invalid characters:').' &lt;&gt;;=#{}',
                        $this->l('To add "tags" click in the field, write something, and then press "Enter."')
                    )
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-large btn-danger'
            )
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getValue('token');
        foreach (Language::getLanguages(false) as $lang) {
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );
        }

        $helper->currentIndex = AdminController::$currentIndex;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->l('Categories Management');
        $helper->submit_action = 'save'.$this->name;
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($obj),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')
        );

        $html = '
					<script type="text/javascript">
						var PS_ALLOW_ACCENTED_CHARS_URL = '.(int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL').';
						var psblog_del_img_txt = "'.$this->l('Delete').'";
						var psblog_del_img_mess = "'.$this->l('Are you sure delete this?').'";
					</script>
			';

        $action = AdminController::$currentIndex.'&save'.$this->name.'&token='.Tools::getValue('token');
        $addnew = AdminController::$currentIndex.'&token='.Tools::getValue('token');
        $helper->toolbar_btn = false;

        $output = $html.'
	              <div class="" id="megamenu">
	        ';
        $output .= '<div class="col-md-4"><div class="panel panel-default"><h3 class="panel-title">'.$this->l('Tree Blog Categories Management').'</h3>'
                .'<div class="panel-content">'.$this->l('To sort orders or update parent-child, you drap and drop expected menu.')
                .'<hr><p><input type="button" value="'.$this->l('New Category').'" id="addcategory" data-loading-text="'.$this->l('Processing ...').'" class="btn btn-danger" name="addcategory"></p><hr>'.$tree.'</div></div></div>'
                .'<div class="col-md-8">'.$helper->generateForm($this->fields_form).'</div>'
                .'<script type="text/javascript"> var action="'.$action.'"; var addnew ="'.$addnew.'"; $("#content").PavMegaMenuList({action:action,addnew:addnew});</script>';
        $output .= '</div>';

        return $this->_html.$output;
    }

    /**
     * Asign value for each input of Data form
     */
    public function getConfigFieldsValues($obj)
    {
        $languages = Language::getLanguages(false);
        $fields_values = array();

		$id_shop = (int)Context::getContext()->shop->id;
		$url = _PS_BASE_URL_;
        if (Tools::usingSecureMode()) {
            # validate module
            $url = _PS_BASE_URL_SSL_;
        }
        foreach ($this->fields_form as $k => $f) {
            foreach ($f['form']['input'] as $j => $input) {
                if (isset($obj->{trim($input['name'])})) {
                    if (isset($obj->{trim($input['name'])})) {
                        $data = $obj->{trim($input['name'])};
                    } else {
                        $data = $input['default'];
                    }

        

                    if (isset($input['lang'])) {
                        foreach ($languages as $lang) {
                            # validate module
                            $fields_values[$input['name']][$lang['id_lang']] = isset($data[$lang['id_lang']]) ? $data[$lang['id_lang']] : $input['default'];
                        }
                    } else {
                        # validate module
                        $fields_values[$input['name']] = $data;
                    }
                } else {
					//if ($input['name'] == 'image_link' && $data) {
					if ($input['name'] == 'image_link' && $obj->image != '') {
						// print_r($obj->image);die();
                        //$thumb = __PS_BASE_URI__.'modules/'.$this->name.'/views/img/c/'.$data;
						$thumb = __PS_BASE_URI__.'modules/'.$this->name.'/views/img/c/'.$obj->image;
                        $this->fields_form[$k]['form']['input'][$j]['thumb'] = $thumb;
                    }
					
                    if (isset($input['lang'])) {
                        foreach ($languages as $lang) {
                            $v = Tools::getValue('title', Configuration::get($input['name'], $lang['id_lang']));
                            $fields_values[$input['name']][$lang['id_lang']] = $v ? $v : $input['default'];
                        }
                    } else {
                        $v = Tools::getValue($input['name'], Configuration::get($input['name']));
                        $fields_values[$input['name']] = $v ? $v : $input['default'];
                    }

                    if ($input['name'] == $obj->type.'_type') {
                        # validate module
                        $fields_values[$input['name']] = $obj->item;
                    }
                }
            }
        }

        return $fields_values;
    }
}
