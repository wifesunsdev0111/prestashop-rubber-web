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

class LeoWidgetImageProduct extends LeoWidgetBase {

		public $name = 'imageproduct';
		public $for_module = 'all';
		
		public function getWidgetInfo(){
			return array('label' => $this->l('Images Gallery Product'), 'explain' => 'Create Images Mini Generalallery From Product' );
		}


		public function renderForm( $args, $data ){
			//echo($this -> getImagesByCategory('4,8',(int) Context::getContext()->language->id));die;
			$helper = $this->getFormHelper();
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
		 	$source = array(
			  array(
				'value' => 'pcategories',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Category')             // The value of the text content of the  <option> tag.
			  ),
			  array(
				'value' => 'pproductids',
				'name' 	=> $this->l('Product Ids')
			  ));
		 	$pimagetypes = $this->getImageTypes();
		 	$selected_cat = array();
			if($data){
				if($data['params'] &&  isset($data['params']['categories']) && $data['params']['categories'])
					$selected_cat = $data['params']['categories'];
			}

		 	$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	           	'input' => array(
	                array(
					  	'type' => 'select',                              
					  	'label' => $this->l('Source'),          
					 	 'name' => 'source',
					 	 'class' => 'group',
					 	 'default' => '',					  
					 	 'options' => array(
					  	 'query' => $source,                          
						 'id' => 'value',                           
						 'name' => 'name'                               
					  )
					),
					array(
						'type'  => 'categories',
						'label' => $this->l('Categories'),
						'name'  => 'categories',
						'default' => '',	
						'tree'  => array(
							'id'                  => 'pcategories',
							'title'               => 'Categories',
							'selected_categories' => $selected_cat,
							'use_search'          => true,
							'use_checkbox'        => true
						)
					),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Product Ids'),
	                    'name'  => 'pproductids',
	                    'default'=> '',
	                    'desc'  =>  $this ->l('Enter Product Ids with format id1,id2,...')
	                ),
	                array(
						'type' => 'select',                              
						'label' => $this->l('Small image'),          
						'name' => 'smallimage',
						'class'=> 'group',
						'id' => 'psmallimagetypes',
						'default'=> '',		
						'options' => array(
							'query' => $pimagetypes,
							'id' => 'name',                           
							'name' => 'name'                               
					  )
					),
					array(
						'type' => 'select',                              
						'label' => $this->l('Thick image'),          
						'name' => 'thickimage',
						'id' => 'pthickimagetypes',
						'default'=> '',	
						'options' => array(
							'query' => $pimagetypes,
							'id' => 'name',                           
							'name' => 'name'                               
					  )
					),
                	array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> '12',
	                    'desc'  =>  $this ->l('Enter a number')
	                ),
	                 array(
	                    'type' => 'select',
	                    'label' => $this->l('Columns'),
	                    'name' => 'columns',
	                    'options' => array(  'query' => array(
	                        array('id' => '1', 'name' => $this->l('1 Column')),
	                        array('id' => '2', 'name' => $this->l('2 Columns')),
                          	array('id' => '3', 'name' => $this->l('3 Columns')),
                            array('id' => '4', 'name' => $this->l('4 Columns')),
                            array('id' => '5', 'name' => $this->l('5 Columns')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "4",
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
	                'fields_value' => $this->getConfigFieldsValues( $data ),
	                'languages' => Context::getContext()->controller->getLanguages(),
	                'id_language' => $default_lang
        	);  


			return  $helper->generateForm( $this->fields_form );

		}
 
		public function renderContent( $args, $setting ){
			$link = new Link();
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	        $url = Tools::htmlentitiesutf8($protocol . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__) ;
			$smallimage = ($setting['smallimage']) ? ($setting['smallimage']) : 'small_default';

			$thickimage = ($setting['thickimage']) ? ($setting['thickimage']) : 'thickbox_default';
			switch ( $setting['source'] ) {					
				case 'pproductids':
						if(empty($setting['pproductids'])){
							return false;
						}
						if($pproductids = $setting['pproductids']){
							$results = $this->getImagesByProductId($pproductids, 0, $setting['limit'], (int) Context::getContext()->language->id);
							$setting['images'] = $results;
						}
				 break;
				 
				 case 'pcategories':		
						$catids = (isset($setting['categories']) && $setting['categories']) ? ($setting['categories']) : array();
						if($catids){
							$categories = implode(",",$catids);
							$results = $this->getImagesByCategory($categories, 0, $setting['limit'],(int) Context::getContext()->language->id);
							$setting['images'] = $results;
						}
				 break;
			}
				 $setting['thickimage'] = $thickimage;
				 $setting['smallimage'] = $smallimage;

				 $output = array('type'=>'imageproduct','data' => $setting );

	      		 return $output;
		}
		//them
		public function getImageTypes(){
			$pimagetypes = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT tp.`id_image_type`,tp.`name`
			FROM `'._DB_PREFIX_.'image_type` tp
			WHERE tp.`products` = 1
			ORDER BY tp.`name` ASC');
			return $pimagetypes;
		}
		public function getImagesByProductId($productids, $start, $limit, $id_lang){
			$sql = 	'SELECT
			 					i.`id_image`,
								pl.`link_rewrite`
			 				FROM
			 					`'._DB_PREFIX_.'image` i
			 				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON(i.`id_image` = il.`id_image`)
			 				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON(
			 					i.`id_product` = pl.`id_product`)';

			$sql .=			' WHERE
								i.`id_product` IN ('.$productids.')
			 				  AND il.`id_lang` =' .$id_lang.
							' AND pl.`id_lang` =' .$id_lang.
							' AND i.cover = 1
			 				  ORDER BY
								i.`position` ASC'
								.($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '');
			 $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
			 return $results;

		}
		public static function getImagesByCategory($categories, $start, $limit, $id_lang, Context $context = null)
		{
			if (!$context)
				$context = Context::getContext();

			$front = true;
			if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
				$front = false;			
			if (Group::isFeatureActive())
			{
				$groups = FrontController::getCurrentCustomerGroups();
				$sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
			}			
			$sql = 'SELECT
							i.`id_image`,
							pl.`link_rewrite`
					FROM
							`'._DB_PREFIX_.'image` i 
					INNER JOIN `'._DB_PREFIX_.'image_lang` il ON(i.`id_image` = il.`id_image`)
			 		INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON(
			 					i.`id_product` = pl.`id_product`)';
			$sql .=	'WHERE
							i.`id_product` IN (	SELECT cp.`id_product`
												FROM `'._DB_PREFIX_.'category_product` cp
												'.(Group::isFeatureActive() ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
												INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
												INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product`
												'.Shop::addSqlAssociation('product', 'p', false).'
												LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
												WHERE c.`active` = 1
												AND product_shop.`active` = 1
												'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
												
												'.$sql_groups .
												' AND cp.id_category in ('.$categories . ')'.
												' AND pl.id_lang ='.$id_lang
												.')
			 		AND   il.`id_lang` =' .$id_lang.
						' AND pl.id_lang = '.$id_lang. 
			 			' AND i.cover = 1
			 			  ORDER BY 
						i.`position` ASC' .($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '') ;
			return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		}

	}
?>