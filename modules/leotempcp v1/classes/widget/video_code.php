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


class LeoWidgetVideo_code extends LeoWidgetBase {

		public $name = 'video_code';
		public $for_module = 'all';
		
		public function getWidgetInfo(){
			return  array('label' => $this->l('Video Code'), 'explain' => 'Make Video widget via putting Youtube Code, Vimeo Code' );
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
 
	                array(
	                    'type' => 'textarea',
	                    'label' => $this->l('Content'),
	                    'name' => 'video_code',
	                    'cols' => 40,
	                    'rows' => 10,
	                    'value' => true,
	        
	                    'default'=> '',
	                    'autoload_rte' => false,
	                    'desc'	=> 'Copy  Video CODE  from youtube, vimeo and put here'
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
				'name'=> '',
				'video_code'   => '',
			);

			$setting = array_merge( $t, $setting );
			$html =  $setting['video_code'];
			
	 		$html = html_entity_decode( $html, ENT_QUOTES, 'UTF-8' );
			$header= '';
			$content = $html;

			$output = array('type'=>'video','data' => $setting );
	  		return $output;
		}
	}
?>