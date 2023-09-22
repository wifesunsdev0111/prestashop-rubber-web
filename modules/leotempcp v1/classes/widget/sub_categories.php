<?php 
/******************************************************
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

class LeoWidgetSub_categories extends LeoWidgetBase {
	public $name = 'sub_categories';
	public $for_module = 'all';
	
	public function getWidgetInfo(){
		return  array('label' => $this->l('Sub Categories In Parent'), 'explain' => 'Show List Of Categories Links Of Parent' );
	}


	public function renderForm( $args, $data ){

		 

	 	$helper = $this->getFormHelper();

		$this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Parent Category ID'),
                    'name' => 'category_id',
                    'default'=> '6',
					),
               
				),
                'buttons' => array(
                    array(
                        'title' => $this->l('Save And Stay'),
                        'icon' => 'process-icon-save',
                        'class' => 'pull-right',
                        'type' => 'submit',
                        'name' => 'saveandstayleotempcp'
                    ),
                    array(
                        'title' => $this->l('Save'),
                        'icon' => 'process-icon-save',
                        'class' => 'pull-right',
                        'type' => 'submit',
                        'name' => 'saveleotempcp'
                    ),
                )
        );


	 	$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		$helper->tpl_vars = array(
                'fields_value' => $this->getConfigFieldsValues( $data  ),
                'languages' => Context::getContext()->controller->getLanguages(),
                'id_language' => $default_lang
    	);  


		return  $helper->generateForm( $this->fields_form );
	}

	public function renderContent(  $args, $setting ){
		$t  = array(
			'category_id'=> '',
		);
		$setting = array_merge( $t, $setting );
		$nb = (int)$setting['limit'];

		$category = new Category($setting['category_id'], $this->langID );
		$subCategories = $category->getSubCategories( $this->langID );	
 		$setting['title'] = $category->name;	


 		$setting['subcategories'] = $subCategories;
		$output = array('type'=>'sub_categories','data' => $setting );

		return $output;
	}
}
?>