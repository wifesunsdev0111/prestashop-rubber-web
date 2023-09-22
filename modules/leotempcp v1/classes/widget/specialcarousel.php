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

class LeoWidgetSpecialcarousel extends LeoWidgetBase {

		public $name = 'specialcarousel';
		public $for_module = 'manage';
		
		public function getWidgetInfo(){
			return  array('label' => $this->l('Product Special Carousel'), 'explain' =>$this->l('Only for module leomanagewidget !')) ;
		}

		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();
			$types = array();	
		 	$types[] = array(
		 		'value' => 'newest',
		 		'text'  => $this->l('Products Newest')
		 	);
		 	$types[] = array(
		 		'value' => 'bestseller',
		 		'text'  => $this->l('Products Bestseller')
		 	);

		 	$types[] = array(
		 		'value' => 'special',
		 		'text'  => $this->l('Products Special')
		 	);

		 	$types[] = array(
		 		'value' => 'featured',
		 		'text'  => $this->l('Products Featured')
		 	);
				
			
			$orderby = array(
			  array(
				'order' => 'date_add',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Date Add')             // The value of the text content of the  <option> tag.
			  ),
			  array(
				'order' => 'date_upd',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Date Update')             // The value of the text content of the  <option> tag.
			  ),
			  array(
				'order' => 'name',
				'name' 	=> $this->l('Name')
			  ),
			  array(
				'order' => 'id_product',
				'name' 	=> $this->l('Product Id')
			  ),
			  array(
				'order' => 'price',
				'name' 	=> $this->l('Price')
			  ),
			);
			
			$orderway = array(
			  array(
				'orderway' => 'ASC',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Ascending')             // The value of the text content of the  <option> tag.
			  ),
			  array(
				'orderway' => 'DESC',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Descending')             // The value of the text content of the  <option> tag.
			  ),
			);
			

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Special Form.'),
	            ),
	            'input' => array(
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l('Products List Type'),
	                    'name' 	  => 'specialtype',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "newest",
	                    'desc'    => $this->l('Select a Product List Type')
	                ),
					
					array(
					  'type' => 'select',                              
					  'label' => $this->l('Order By:'),         
					  'desc' => $this->l('The maximum number of products in each page Carousel (default: 3).'),  
					  'name' => 'orderby',   
					  'default' => 'date_add',		                          
					  'options' => array(
						'query' => $orderby,                          
						'id' => 'order',                           
						'name' => 'name'                               
					  )
					),
					
					array(
					  'type' => 'select',                              
					  'label' => $this->l('Order Way:'),         
					  'desc' => $this->l('The maximum number of products in each page Carousel (default: 3).'),  
					  'name' => 'orderway',   
					  'default' => 'date_add',		                          
					  'options' => array(
						'query' => $orderway,                          
						'id' => 'orderway',                           
						'name' => 'name'                               
					  )
					),
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
	                    'default'=> 8,
						'desc'  => $this->l('The maximum number of products in each Carousel (default: 6).')
	                ), 
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Interval'),
	                    'name'  => 'interval',
	                    'default'=> 8000,
						'desc'  => $this->l('Enter Time(miniseconds) to play carousel. Value 0 to stop.')
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
						
			$nb = ($setting['itemstab']) ? (int)($setting['itemstab']) : 8;
            $orderby = ($setting['orderby']) ? ($setting['orderby']) : 'date_add';
			$orderway = ($setting['orderway']) ? ($setting['orderway']) : 'date_add';
			$items_page = $columns_page = 3;
			if(isset($setting['itemspage']) && $setting['itemspage'])
				$items_page 	= $setting['itemspage'];
			if(isset($setting['columns']) && $setting['columns'])
            	$columns_page 	= $setting['columns'];
			$interval 		= 	(isset($setting['interval'])) ? (int)($setting['interval']) : 8000;
						 switch ( $setting['specialtype'] ) {
								case 'newest':
									 $products = Product::getNewProducts($this->langID, 0, $nb,false,$orderby,$orderway );
									break;
								case 'featured':
									$category = new Category(Context::getContext()->shop->getCategory(), $this->langID );
									$products = $category->getProducts((int)$this->langID, 1, $nb,$orderby,$orderway);
									break;
								case 'bestseller':
									$products = ProductSale::getBestSalesLight((int)$this->langID, 0, $nb);
									break;	
								case 'special': 
									 $products = Product::getPricesDrop( $this->langID, 0, $nb,false,$orderby,$orderway);
									break;
					}
			$setting['specialtype'] = $setting['specialtype'];	
			Context::getContext()->controller->addColorsToProductList($products);	
			$setting['products'] = $products;	
			$setting['itemsperpage'] 	= $items_page; 
			$setting['columnspage'] 	= $columns_page; 
			$setting['scolumn']    		= 12 / $columns_page;
			$setting['interval'] 		= $interval;
			$setting['tab'] 			= 'leospecialproduct'.rand(20,rand());
			$output = array('type'=>'specialproduct','data' => $setting );

			return $output;
		} 
		
	
	}
?>