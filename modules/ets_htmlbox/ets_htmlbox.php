<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once(dirname(__FILE__) . '/classes/HBHtmlbox.php');
require_once(dirname(__FILE__) . '/classes/HBHtmlboxPosition.php');
require_once(dirname(__FILE__) . '/classes/Ets_htmlbox_paggination.php');
class Ets_htmlbox extends Module
{
    protected $config_form = false;
    public $_html = '';
    public $_errors = array();
	public $fields_form = array();
    public function __construct()
    {
        $this->name = 'ets_htmlbox';
        $this->tab = 'administration';
        $this->version = '1.0.6';
        $this->author = 'ETS - Soft';
        $this->need_instance = 0;
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('HTML Box');
        $this->description = $this->l('Create, display and highlight content wherever you want on your PrestaShop store, depending on the purpose of use to emphasize or attract customers');
$this->refs = 'https://prestahero.com/';
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');
        return parent::install() &&
            $this->_registerHook() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');
        return parent::uninstall() &&
            $this->_removeHook() &&
            $this->unregisterHook('header') &&
            $this->unregisterHook('displayHeader') &&
            $this->unregisterHook('backOfficeHeader') &&
            $this->unregisterHook('displayBackOfficeHeader');
    }

    public function _registerHook()
    {
        $hooks = HBHtmlbox::getHookPosition();
        if (sizeof($hooks) > 0) {
            foreach ($hooks as $hook) {
                $this->registerHook($hook['hook']);
            }
        }
        return true;
    }

    public function _removeHook()
    {
        $hooks = HBHtmlbox::getHookPosition();
        if (sizeof($hooks) > 0) {
            foreach ($hooks as $hook) {
                $this->unregisterHook($hook['hook']);
            }
        }
        return true;
    }

    public function _addTab()
    {
        $t = new Tab();
        $t->active = 1;
        $t->class_name = 'AdminEtsHB';
        $t->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $t->name[$lang['id_lang']] = 'HTML Box';
        }
        $t->id_parent = 0;
        $t->module = $this->name;
        if ($t->add()) {
            $t2 = new Tab();
            $t2->active = 1;
            $t2->class_name = 'AdminEtsHBBase';
            $t2->name = array();
            foreach (Language::getLanguages(true) as $lang) {
                $t2->name[$lang['id_lang']] = 'List HTML Box';
            }
            $t2->id_parent = $t->id;
            $t2->module = $this->name;
            $t2->add();
        }
        return true;
    }

    public function _removeTab()
    {
        while ($tabId = (int)Tab::getIdFromClassName("AdminEtsHBBase")) {
            if (!$tabId) {
                return true;
            }
            $tab = new Tab($tabId);
            if ($tab->delete()) {
                $tabId2 = (int)Tab::getIdFromClassName("AdminEtsHB");
                if (!$tabId2) {
                    return true;
                }
                $tab2 = new Tab($tabId2);
                $tab2->delete();
            }
        }
        return true;
    }

    public function getAdminModuleLink()
    {
       return $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name;
    }

    public function getContent()
    {
        if(Tools::isSubmit('saveHTMLBox') || Tools::isSubmit('submitSaveAndStay'))
        {
            $this->saveHTMLBox();
        }
        if(Tools::isSubmit('submitBulkDelete') && ($ids = array_map('intval',Tools::getValue('bulk_action_selected_html_boxs'))))
        {
            if(HBHtmlbox::deleteSelected($ids))
                $this->context->cookie->_success = $this->l('Deleted box selected succesfully');
            Tools::redirectAdmin($this->getAdminModuleLink());
            $this->context->cookie->write();
        }
        if(Tools::isSubmit('submitBulkEnable') && ($ids = array_map('intval',Tools::getValue('bulk_action_selected_html_boxs'))))
        {
            if(HBHtmlbox::enableSelected($ids))
                $this->context->cookie->_success = $this->l('Enabled box selected succesfully');
            Tools::redirectAdmin($this->getAdminModuleLink());
            $this->context->cookie->write();
        }
        if(Tools::isSubmit('submitBulkDisable') && ($ids = array_map('intval',Tools::getValue('bulk_action_selected_html_boxs'))))
        {
            if(HBHtmlbox::disableSelected($ids))
                $this->context->cookie->_success = $this->l('Disabled box selected succesfully');
            Tools::redirectAdmin($this->getAdminModuleLink());
            $this->context->cookie->write();
        }
        if(Tools::isSubmit('change_enabled') && ($id_ets_hb_html_box = (int)Tools::getValue('id_ets_hb_html_box')))
        {
            $active = (int)Tools::getValue('change_enabled');
            $htmlBox = new HBHtmlbox($id_ets_hb_html_box);
            $htmlBox->active = $active;
            if($htmlBox->update())
            {
                $this->context->cookie->_success = $this->l('Updated succesfully');
                Tools::redirectAdmin($this->getAdminModuleLink());
            }
        }
        if(Tools::isSubmit('del') && ($id_ets_hb_html_box = (int)Tools::getValue('id_ets_hb_html_box')))
        {
            $htmlBox = new HBHtmlbox($id_ets_hb_html_box);
            if($htmlBox->delete())
            {
                $this->context->cookie->_success = $this->l('Deleted successfull');
                Tools::redirect($this->getAdminModuleLink());
            }
        }
        if($this->context->cookie->_success)
        {
            $this->_html .= $this->displayConfirmation($this->context->cookie->_success);
            $this->context->cookie->_success ='';
        }
        if(Tools::isSubmit('addNewBox') || (Tools::isSubmit('edithtml_box') && ($id_ets_hb_html_box = (int)Tools::getValue('id_ets_hb_html_box')) && ($htmlBox = new HBHtmlbox($id_ets_hb_html_box)) && Validate::isLoadedObject($htmlBox)))
        {
             $this->_html .= $this->renderForm();
        }
        else
        {
            $this->_html .= $this->displayListHtmlBox();
        }
        $this->_html .=$this->displayIframe();
        return $this->_html;
    }
    public function displayListHtmlBox()
    {
       $fields_list = array(
            'input_box' => array(
                'title' => '',
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'id_ets_hb_html_box' => array(
                'title' => $this->l('ID'),
                'type' => 'text',
                'sort' => true,
                'filter' => true,
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'type' => 'text',
                'sort' => true,
                'filter' => true,
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'type' => 'select',
                'sort' => false,
                'filter' => true,
                'strip_tag'=> false,
                'filter_list' => array(
                    'id_option' => 'id',
                    'value' => 'name',
                    'list' => HBHtmlbox::getHookPosition(),
                )
            ), 
            'active'=> array(
                'title' => $this->l('Active'),
                'type' => 'active',
                'sort' => false,
                'filter' => true,
                'strip_tag'=>false,
                'filter_list' => array(
                    'id_option' => 'active',
                    'value' => 'title',
                    'list' => array(
                        0 => array(
                            'active' => 1,
                            'title' => $this->l('Yes')
                        ),
                        1 => array(
                            'active' => 0,
                            'title' => $this->l('No')
                        )
                    )
                )
            ),
        );
        $filter = '';
        $show_resset = false;
        if(($id_ets_hb_html_box = Tools::getValue('id_ets_hb_html_box'))!='' && Validate::isCleanHtml($id_ets_hb_html_box))
        {
            $filter .= ' AND b.id_ets_hb_html_box='.(int)$id_ets_hb_html_box;
            $show_resset = true;
        }
        if(($name=Tools::getValue('name'))!='' && Validate::isCleanHtml($name))
        {
            $filter .= ' AND b.name LIKE "%'.pSQL($name).'%"';
            $show_resset = true;
        }
        if(($position = Tools::getValue('position'))!='' && Validate::isCleanHtml($position))
        {
            $filter .= ' AND c.position = "'.(int)$position.'"';
            $show_resset = true;
        }
        if(($active = Tools::getValue('active'))!='' && Validate::isCleanHtml($active))
        {
            $filter .= ' AND b.active = "'.pSQL($active).'"';
            $show_resset = true;
        }
        $sort = "";
        $sort_type=Tools::getValue('sort_type','asc');
        $sort_value = Tools::getValue('sort','id_ets_hb_html_box');
        if($sort_value)
        {
            switch ($sort_value) {
                case 'id_ets_hb_html_box':
                    $sort .=' b.id_ets_hb_html_box';
                    break;
                case 'name':
                    $sort .=' b.name';
                    break;
                case 'active':
                    $sort .=' b.active';
                    break;
            }
            if($sort && $sort_type && in_array($sort_type,array('asc','desc')))
                $sort .= ' '.$sort_type;
        }
        //Paggination
        $page = (int)Tools::getValue('page');
        if($page<=0)
            $page = 1;
        $totalRecords = (int)HBHtmlbox::getHTMLBoxs($filter,$sort,0,0,true);
        $paggination = new Ets_htmlbox_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->url = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&page=_page_'.$this->getFilterParams($fields_list,'html_box');
        $paggination->limit = (int)Tools::getValue('paginator_html_box_select_limit',20);
        $paggination->name ='html_box';
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $boxs = HBHtmlbox::getHTMLBoxs($filter,$sort,$start,$paggination->limit,false);
        if($boxs)
        {
            foreach($boxs as &$box)
            {
                $box['input_box'] = $this->displayText('','input','','bulk_action_selected-html_box'.$box['id_ets_hb_html_box'],'','','','bulk_action_selected_html_boxs[]',$box['id_ets_hb_html_box'],'checkbox');
                $box['position'] = $this->getPositions($box['position']);
            }
        }
        $paggination->text =  $this->l('Showing {start} to {end} of {total} ({pages} Pages)');
        $paggination->style_links = $this->l('links');
        $paggination->style_results = $this->l('results');
        $listData = array(
            'name' => 'html_box',
            'actions' => array('view','delete'),
            'icon' => 'icon-rule',
            'currentIndex' => $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.($paggination->limit!=20 ? '&paginator_html_box_select_limit='.$paggination->limit:''),
            'postIndex' => $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name,
            'identifier' => 'id_ets_hb_html_box',
            'show_toolbar' => true,
            'show_action' => true,
            'show_add_new' => true,
            'link_new' => $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&addNewBox',
            'title' => $this->l('List HTML box'),
            'fields_list' => $fields_list,
            'field_values' => $boxs,
            'paggination' => $paggination->render(),
            'filter_params' => $this->getFilterParams($fields_list,'html_box'),
            'show_reset' =>$show_resset,
            'totalRecords' => $totalRecords,
            'sort'=> $sort_value,
            'sort_type' => $sort_type,
            'show_bulk_action'=>true,
        );            
        return  $this->renderList($listData);
    }
    public function saveHTMLBox()
    {
        if(Tools::isSubmit('edithtml_box') && ($id_ets_hb_html_box = (int)Tools::getValue('id_ets_hb_html_box')))
        {
            $htmlBox = new HBHtmlbox($id_ets_hb_html_box);
        }
        else
            $htmlBox = new HBHtmlbox();
        $name = Tools::getValue('name');
        if(!$name)
            $this->_errors[] = $this->l('Name is required');
        elseif(!Validate::isCleanHtml($name))
            $this->_errors[] = $this->l('Name is not valid');
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $html = Tools::getValue('html_'.$id_lang_default);
        if(!$html)
            $this->_errors[] = $this->l('HTML is required');
        elseif(!Validate::isCleanHtml($html, true))
            $this->_errors[] = $this->l('HTML is not valid');
        $htmls = array();
        foreach($languages as $language)
        {
            $id_lang = $language['id_lang'];
            if($id_lang!= $id_lang_default)
            {
                $htmls[$id_lang] = Tools::getValue('html_'.$id_lang);
                if($htmls[$id_lang] && !Validate::isCleanHtml($htmls[$id_lang], true))
                    $this->_errors[] = sprintf($this->l('HTML is not valid in %s'),$language['iso_code']);
            }
            else
               $htmls[$id_lang] = $html; 
        }
        $style = Tools::getValue('style');
        if($style && !Validate::isString($style))
            $this->_errors[] = $this->l('Style is not valid');
        $positions = Tools::getValue('position');
        if($positions)
        {
            foreach($positions as $position)
            {
                if(!Validate::isInt($position))
                {
                    $this->_errors[] = $this->l('Position is not valid');
                }
            }
        }
        $active = (int)Tools::getValue('active');
        if($this->_errors)
        {
            $this->_html .= $this->displayError($this->_errors);
        }
        else{
            $htmlBox->name = $name;
            $htmlBox->style = $style;
            $htmlBox->active= $active;
            $htmlBox->html = $htmls;
            if($htmlBox->id)
            {
                if($htmlBox->update())
                    $this->context->cookie->_success = $this->l('Edited successfull');
                else
                    $this->_errors[] = $this->l('Edit error');
            }
            else{
                if($htmlBox->add())
                {
                    $this->context->cookie->_success = $this->l('Added successfull');
                }
                else
                    $this->_errors[] = $this->l('Add error');
            }
            if(!$this->_errors)
            {
                HBHtmlboxPosition::deletePosition($htmlBox->id);
                if (sizeof($positions) > 0) {
                    foreach ($positions as $p) {
                        $obj = new HBHtmlboxPosition();
                        $obj->id_ets_hb_html_box = $htmlBox->id;
                        $obj->position = $p;
                        $obj->add();
                    }
                }
                if(Tools::isSubmit('submitSaveAndStay'))
                    Tools::redirect($this->getAdminModuleLink().'&edithtml_box=1&id_ets_hb_html_box='.$htmlBox->id);
                else
                    Tools::redirect($this->getAdminModuleLink());
                    
            }
            else
                $this->_html .= $this->displayError($this->_errors);
        }
    }
    public function renderForm()
    {
        if(Tools::isSubmit('edithtml_box') && ($id_ets_hb_html_box = (int)Tools::getValue('id_ets_hb_html_box')))
        {
            $htmlBox = new HBHtmlbox($id_ets_hb_html_box);
        }
        else
            $htmlBox = new HBHtmlbox();
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $htmlBox->id ? $this->l('Edit HTML box') : $this->l('Add HTML box'),
                    'icon' => $htmlBox->id ? 'icon-edit' : 'icon-plus',				
				),
				'input' => array(					
				    'name' => array(
                        'name' => 'name',
                        'type' => 'text',
                        'label' => $this->l('Name'),
                        'lang' => false,
                        'required' => true
                    ),
                    'html' => array(
                        'name' => 'html',
                        'type' => 'textarea',
                        'label' => $this->l('HTML'),
                        'lang' => true,
                        'required' => true
                    ),
                    'style' => array(
                        'name' => 'style',
                        'type' => 'textarea',
                        'label' => $this->l('CSS'),
                        'lang' => false,
                        'required' => false
                    ),
                    'position' => array(
                        'name' => 'position',
                        'type' => 'checkbox',
                        'label' => $this->l('Position'),
                        'lang' => false,
                        'required' => false,
                        'values' => array(
                            'query' => HBHtmlbox::getHookPosition(),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    'active' => array(
                        'type' => 'switch',
                        'label' => $this->l('Active'),
                        'name' => 'active',
                        'default' => true,
                        'is_bool' => true,
                        'required' => false,
                        'lang' => false,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Activate')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Deactivate')
                            )
                        ),
                    ),
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				),
                'buttons'=> array(
                    array(
                        'type'=>'submit',
                        'name' =>'submitSaveAndStay',
                        'title' => $this->l('Save and stay'),
                        'icon'=>'process-icon-save',
                        'class'=>'pull-right'
                    ),
                    array(
                        'href'=>$this->getAdminModuleLink(),
                        'title' => $this->l('Cancel'),
                        'icon'=>'process-icon-Cancel',
                        'class'=>'pull-left'
                    )
                ),
            )
		);
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'saveHTMLBox';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.($htmlBox->id ? '&edithtml_box=1&id_ets_hb_html_box='.$htmlBox->id:'');
		$helper->token = $this->context->employee->id ? Tools::getAdminTokenLite('AdminModules'): false;
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
			'fields_value' => $this->getFieldsValues($htmlBox),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'link' => $this->context->link,
		);
        if($htmlBox->id)
        { 
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_ets_hb_html_box');
        }
		$helper->override_folder = '/';
        $this->_html .= $helper->generateForm(array($fields_form));	
    }
    public function getFieldsValues($htmlBox)
    {
        $fields = array(
            'id_ets_hb_html_box' => $htmlBox->id,
            'name' => Tools::getValue('name',$htmlBox->name),
            'style' => Tools::getValue('style',$htmlBox->style),
            'position' => Tools::getValue('position',$htmlBox->position ? $htmlBox->position :array()),
            'active'=> Tools::getValue('active',$htmlBox->active),
        );;
        foreach(Language::getLanguages(false) as $lang)
        {
            $fields['html'][$lang['id_lang']]  = Tools::getValue('html_'.$lang['id_lang'], $htmlBox->html[$lang['id_lang']] ?? '');
        }
        return $fields;
    }
    public function displayHooks($hook_name)
    {
        $hooks = HBHtmlbox::getHTMLBoxByHook($hook_name, Context::getContext()->language->id);
        $this->smarty->assign(array(
            'hooks' => $hooks,
        ));
        return $this->display(__FILE__, 'display-hooks.tpl');
    }
    public function _backHeader()
    {
        if (
            (string)Tools::getValue('module_name') == $this->name ||
            (string)Tools::getValue('configure') == $this->name ||
            (string)Tools::getValue('controller') == 'AdminEtsHBBase'
        ) {
            $this->context->controller->setMedia();
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
        $this->context->controller->addCSS($this->_path . 'views/css/admin_all.css');

    }

    public function hookBackOfficeHeader()
    {
        $this->_backHeader();
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->_backHeader();
    }

    public function _header()
    {
        if ($this->context->controller->php_self == 'category') {
            $this->smarty->assign(array(
                'hookDisplayProductListHeaderAfter' => $this->hookDisplayProductListHeaderAfter(),
                'hookDisplayProductListHeaderBefore' => $this->hookDisplayProductListHeaderBefore(),
            ));
        }
        if ($this->context->controller->php_self == 'product') {
            $this->smarty->assign(array(
                'hookDisplayProductVariantsBefore' => $this->hookDisplayProductVariantsBefore(),
                'hookDisplayProductVariantsAfter' => $this->hookDisplayProductVariantsAfter(),
                'hookDisplayProductCommentsListHeaderBefore' => $this->hookDisplayProductCommentsListHeaderBefore(),
            ));
        }
        if ($this->context->controller->php_self == 'cart') {
            $this->smarty->assign(array(
                'hookDisplayCartGridBodyBefore1' => $this->hookDisplayCartGridBodyBefore1(),
            ));
        }
        if ($this->context->controller->php_self == 'order') {
            $this->smarty->assign(array(
                'hookDisplayCartGridBodyBefore1' => $this->hookDisplayCartGridBodyBefore1(),
                'hookDisplayCartGridBodyBefore2' => $this->hookDisplayCartGridBodyBefore2(),
                'hookDisplayCartGridBodyAfter' => $this->hookDisplayCartGridBodyAfter(),
            ));
        }
        $this->smarty->assign(array(
            'hookDisplayLeftColumnBefore' => $this->hookDisplayLeftColumnBefore(),
            'hookDisplayRightColumnBefore' => $this->hookDisplayRightColumnBefore(),
        ));
        $this->context->controller->addJS($this->_path . 'views/js/front.js');
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');
        return $this->display(__FILE__, 'render-js.tpl');
    }

    public function hookHeader()
    {
        return $this->_header();
    }

    public function hookDisplayHeader()
    {
        return $this->_header();
    }

    public function hookDisplayCartGridBodyAfter()
    {
        return $this->displayHooks('displayCartGridBodyAfter');
    }

    public function hookDisplayCartGridBodyBefore1()
    {
        return $this->displayHooks('displayCartGridBodyBefore1');
    }

    public function hookDisplayCartGridBodyBefore2()
    {
        return $this->displayHooks('displayCartGridBodyBefore2');
    }

    public function hookDisplayProductCommentsListHeaderBefore()
    {
        return $this->displayHooks('displayProductCommentsListHeaderBefore');
    }

    public function hookDisplayProductVariantsBefore()
    {
        return $this->displayHooks('displayProductVariantsBefore');
    }

    public function hookDisplayProductVariantsAfter()
    {
        return $this->displayHooks('displayProductVariantsAfter');
    }

    public function hookDisplayLeftColumnBefore()
    {
        return $this->displayHooks('displayLeftColumnBefore');
    }

    public function hookDisplayRightColumnBefore()
    {
        return $this->displayHooks('displayRightColumnBefore');
    }

    public function hookDisplayProductListHeaderBefore()
    {
        return $this->displayHooks('displayProductListHeaderBefore');
    }

    public function hookDisplayProductListHeaderAfter()
    {
        return $this->displayHooks('displayProductListHeaderAfter');
    }

    public function hookDisplayNav1()
    {
        return $this->displayHooks('displayNav1');
    }

    public function hookDisplayBanner()
    {
        return $this->displayHooks('displayBanner');
    }

    public function hookDisplayHome()
    {
        return $this->displayHooks('displayHome');
    }
    public function hookDisplayFooter()
    {
       return $this->displayHooks('displayFooter'); 
    }
    public function hookDisplayFooterBefore()
    {
        return $this->displayHooks('displayFooterBefore');
    }
    public function hookDisplayFooterAfter()
    {
        return $this->displayHooks('displayFooterAfter');
    }

    public function hookDisplayFooterCategory()
    {
        return $this->displayHooks('displayFooterCategory');
    }

    public function hookDisplayShoppingCartFooter()
    {
        return $this->displayHooks('displayShoppingCartFooter');
    }

    public function hookDisplayLeftColumn()
    {
        return $this->displayHooks('displayLeftColumn');
    }
    public function hookDisplayCustomHTMLBox()
    {
        return $this->displayHooks('displayCustomHTMLBox');
    }
    public function hookDisplayRightColumn()
    {
        return $this->displayHooks('displayRightColumn');
    }

    public function hookDisplayAfterProductThumbs()
    {
        return $this->displayHooks('displayAfterProductThumbs');
    }

    public function hookDisplayProductActions()
    {
        return $this->displayHooks('displayProductActions');
    }

    public function hookDisplayReassurance()
    {
        return $this->displayHooks('displayReassurance');
    }

    public function hookDisplayFooterProduct()
    {
        return $this->displayHooks('displayFooterProduct');
    }

    public function hookDisplayProductListReviews()
    {
        if ($this->context->controller->php_self == 'product') {
            return $this->displayHooks('displayProductListReviews');
        }
    }
    public function renderList($listData)
    { 
        if(isset($listData['fields_list']) && $listData['fields_list'])
        {
            foreach($listData['fields_list'] as $key => &$val)
            {
                $value_key = (string)Tools::getValue($key);
                $value_key_max = (string)Tools::getValue($key.'_max');
                $value_key_min = (string)Tools::getValue($key.'_min');
                if(isset($val['filter']) && $val['filter'] && ($val['type']=='int' || $val['type']=='date'))
                {
                    if(Tools::isSubmit('ets_htmlbox_submit_'.$listData['name']))
                    {
                        $val['active']['max'] =  trim($value_key_max);   
                        $val['active']['min'] =  trim($value_key_min); 
                    }
                    else
                    {
                        $val['active']['max']='';
                        $val['active']['min']='';
                    }  
                }  
                elseif(!Tools::isSubmit('del') && Tools::isSubmit('ets_htmlbox_submit_'.$listData['name']))               
                    $val['active'] = trim($value_key);
                else
                    $val['active']='';
            }
        }  
        if(!isset($listData['class']))
            $listData['class']='';  
        $this->smarty->assign($listData);
        return $this->display(__FILE__, 'list_helper.tpl');
    }
    public function getFilterParams($field_list,$table='')
    {
        $params = '';        
        if($field_list)
        {
            if(Tools::isSubmit('ets_htmlbox_submit_'.$table))
                $params .='&ets_htmlbox_submit_'.$table.='=1';
            foreach($field_list as $key => $val)
            {
                $value_key = Tools::getValue($key);
                $value_key_max = Tools::getValue($key.'_max');
                $value_key_min = Tools::getValue($key.'_min');
                if($value_key!='')
                {
                    $params .= '&'.$key.'='.urlencode($value_key);
                }
                if($value_key_max!='')
                {
                    $params .= '&'.$key.'_max='.urlencode($value_key_max);
                }
                if($value_key_min!='')
                {
                    $params .= '&'.$key.'_min='.urlencode($value_key_min);
                } 
            }
            unset($val);
        }
        return $params;
    }
    public function displayText($content,$tag,$class=null,$id=null,$href=null,$blank=false,$src = null,$name = null,$value = null,$type = null,$data_id_product = null,$rel = null,$attr_datas=null)
    {
        $this->smarty->assign(
            array(
                'content' =>$content ?? '',
                'tag' => $tag,
                'tag_class'=> $class,
                'tag_id' => $id,
                'href' => $href,
                'blank' => $blank,
                'src' => $src,
                'attr_name' => $name,
                'value' => $value,
                'type' => $type,
                'data_id_product' => $data_id_product,
                'attr_datas' => $attr_datas,
                'rel' => $rel,
            )
        );
        return $this->display(__FILE__,'html.tpl');
    }
    public function displayPaggination($limit,$name)
    {
        $this->context->smarty->assign(
            array(
                'limit' => $limit,
                'pageName' => $name,
            )
        );
        return $this->display(__FILE__,'limit.tpl');
    }
    public function getPositions($value)
    {
        if ($value != null) {
            $arr = explode(',', $value);
        } else {
            $arr = array();
        }
        $html = '<ul class="ets-list-hook">';
        $position = HBHtmlbox::getHookPosition();
        if (sizeof($arr)) {
            if (sizeof($position)) {
                foreach ($position as $item) {
                    if (in_array($item['id'], $arr)) {
                        $html = $html . '<li>' . $item['name'] . ' <span>(' . $item['hook'] . ')</span></li>';
                    }
                }
            }
        }
        $html = $html . '</ul>';
        return $html;
    }
    public function displayIframe()
    {
        switch($this->context->language->iso_code) {
            case 'en':
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'it':
                $url = 'https://cdn.prestahero.com/it/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'fr':
                $url = 'https://cdn.prestahero.com/fr/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'es':
                $url = 'https://cdn.prestahero.com/es/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            default:
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
        }
        $this->smarty->assign(
            array(
                'url_iframe' => $url
            )
        );
        return $this->display(__FILE__,'iframe.tpl');
    }
}
