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

class LeoWidgetTabHTML extends LeoWidgetBase {

		public $name = 'tabhtml';
		public $for_module  = 'all';
		
		public function getWidgetInfo(){
			return array( 'label' => $this->l('HTML Tab'), 'explain' =>$this->l('Create HTML Tab'));
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form'),
	            ),
	            'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Number of HTML Tab'),
						'name' => 'nbtabhtml',
						'default' => 5,
						'desc' => 'Enter a number greater 0'
					)
	
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

			if(!isset($data['params']['nbtabhtml']) || !$data['params']['nbtabhtml'])
			    $nbtabhtml = 5;
			else
			    $nbtabhtml = $data['params']['nbtabhtml']; 
			for($i = 1; $i <= $nbtabhtml; $i++){
				$tmpArray = array(
	                    'type'  => 'text',
	                    'label' => $this->l('Title '.$i),
	                    'name'  => 'title_'.$i,
	                    'default'=> 'Title Sample '.$i,
	                    'lang'=> true
	                );
				$this->fields_form[1]['form']['input'][] = $tmpArray;
	            $tmpArray = array(
	                    'type'  => 'textarea',
	                    'label' => $this->l('Content '.$i),
	                    'name'  => 'content_'.$i,
	                    'default'=> 'Content Sample '.$i,
	                    'cols' => 40,
	                    'rows' => 10,
	                    'value' => true,
	                    'lang'  => true,
	              
	                    'autoload_rte' => true,

	                    'desc'	=> $this->l('Enter Content '.$i)
	            );
	            $this->fields_form[1]['form']['input'][] = $tmpArray;

			}
			//$this->fields_form[1]['form']['input'][] = $tmpArray;
			
		 	$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
			$helper->tpl_vars = array(
	                'fields_value' => $this->getConfigFieldsValues( $data  ),
	                'languages' => Context::getContext()->controller->getLanguages(),
	                'id_language' => $default_lang
        	);  

			return  $helper->generateForm( $this->fields_form );

		}
		public function renderContent(  $args, $setting ){
	 		$content = '';	

	 		$tabs = array();
	 		$languageID = Context::getContext()->language->id;
			


	 		for( $i=1; $i<=$setting['nbtabhtml']; $i++ ){
	 			$title =  isset($setting['title_'.$i."_".$languageID])?$setting['title_'.$i."_".$languageID]: "";
	 			
	 			if(!empty($title) ) {
	 				$content = isset($setting['content_'.$i."_".$languageID])?$setting['content_'.$i."_".$languageID]: "";
	 				$tabs[] = array( 'title' => trim($title), 'content' => trim($content) );
	 			}
	 		}
	 	 	$setting['tabhtmls'] = $tabs; 
	 	 	$setting['id']	 = rand()+count($tabs);
		
			$output = array('type'=>'tabhtml','data' => $setting );
			//echo "<pre>";print_r($setting);die;
	  		return $output;
		}
		 
	}
?>