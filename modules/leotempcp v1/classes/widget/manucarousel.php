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

class LeoWidgetManucarousel extends LeoWidgetBase {

		public $name = 'Manucarousel';
		public $for_module = 'manage';
		
		public function getWidgetInfo(){
			return  array('label' => $this->l('Manufacture Logo Carousel'), 'explain' => $this->l('Create Manufacture Carousel')) ;
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
			$imagesTypes = ImageType::getImagesTypes('manufacturers');
			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Items Per Page'),
	                    'name'  => 'itemspage',
	                    'default'=> 3,
						'desc'  => $this->l('The maximum number of products in each page Carousel (default: 3).')
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Colums In Tab'),
	                    'name'  => 'columns',
	                    'default'=> 3,
						'desc'  => 'The maximum column products in each page Carousel (default: 3).'
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Items In Tab'),
	                    'name'  => 'itemstab',
	                    'default'=> 6,
						'desc'  => $this->l('The maximum number of products in each Carousel (default: 6).')
	                ),
					array(
						  'type' => 'select',                              
						  'label' => $this->l('Image:'),         
						  'desc' => $this->l('Select type image for manufacture.'),  
						  'name' => 'image',   
						  'default' => 'small_default',		                          
						  'options' => array(
							'query' => $imagesTypes,                          
							'id' => 'name',                           
							'name' => 'name'                            
					  )
					),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Interval'),
	                    'name'  => 'interval',
	                    'default'=> 8000,
						'desc'  => $this->l('Enter Time(miniseconds) to play carousel. Value 0 to stop.')
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

		public function renderContent( $args, $setting ){
			$t  = array(
				'name'=> '',
				'html'   => '',
			);
			$setting = array_merge( $t, $setting );
			$items_page 	= 	($setting['itemspage']) ? (int)($setting['itemspage']) : 3;
            $columns_page 	= ($setting['columns']) ? (int)($setting['columns']) : 3;
			$items_tab 	= ($setting['itemstab']) ? (int)($setting['itemstab']) : 6;
			$interval 		= 	(isset($setting['interval'])) ? (int)($setting['interval']) : 8000;
			$image_type 		= 	($setting['image']) ? ($setting['image']) : 'small_default';

			$data = Manufacturer::getManufacturers(true, Context::getContext()->language->id, true, false ,$items_tab, false);

			foreach ($data as &$item)
			{
				$id_images = (!file_exists(_PS_MANU_IMG_DIR_.'/'.$item['id_manufacturer'].'-'.$image_type.'.jpg')) ? Language::getIsoById(Context::getContext()->language->id).'-default' : $item['id_manufacturer'];
				$item['image'] = _THEME_MANU_DIR_.$id_images.'-'.$image_type.'.jpg';
			}
			
			$setting['manufacturers'] = $data; 
			$setting['itemsperpage'] = $items_page; 
			$setting['columnspage'] = $columns_page; 
			$setting['scolumn']    = 12 / $columns_page;
			$setting['interval'] 	= $interval;
			$setting['tab'] 	= 'leomanulogocarousel'.rand(20,rand());
			$output = array('type'=>'manucarousel','data' => $setting );

			return $output;
		} 

	}
?>