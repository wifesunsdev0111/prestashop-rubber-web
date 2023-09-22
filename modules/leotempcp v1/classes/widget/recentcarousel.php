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

class LeoWidgetRecentcarousel extends LeoWidgetBase {

		public $name = 'Recentcarousel';
		public $for_module = 'manage';
		
		public function getWidgetInfo(){
			return  array('label' => $this->l('Recent Reviews Carousel'), 'explain' => $this->l('Create Recent Reviews')) ;
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
			
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
			
			
			$type = array(
			  array(
				'type' => 'avg',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('Top Reviews')             // The value of the text content of the  <option> tag.
			  ),
			  array(
				'type' => 'dateadd',                 // The value of the 'value' attribute of the <option> tag.
				'name' 	=> 	$this->l('New Reviews')             // The value of the text content of the  <option> tag.
			  ),
			);
			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
					
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
	                    'default'=> 6,
						'desc'  => $this->l('The maximum number of products in each Carousel (default: 6).')
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Interval'),
	                    'name'  => 'interval',
	                    'default'=> 8000,
						'desc'  => $this->l('Enter Time(miniseconds) to play carousel. Value 0 to stop.')
	                ),
					array(
						  'type' => 'select',                              
						  'label' => $this->l('Type:'),         
						  'desc' => $this->l('Select Type Recent Reviews.'),  
						  'name' => 'type',   
						  'default' => 'new',		                          
						  'options' => array(
							'query' => $type,                          
							'id' => 'type',                           
							'name' => 'name'                            
							)
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
			$nb = ($setting['itemstab']) ? (int)($setting['itemstab']) : 6;
			$orderway = ($setting['orderway']) ? ($setting['orderway']) : 'ASC';
			$items_page 	= 	($setting['itemspage']) ? (int)($setting['itemspage']) : 3;
            $columns_page 	= ($setting['columns']) ? (int)($setting['columns']) : 3;
			$interval 		= 	(isset($setting['interval'])) ? (int)($setting['interval']) : 8000;
			$type 		= 	($setting['type']) ? ($setting['type']) : 'new';
			$products = $this->getRecentProducts((int)Context::getContext()->language->id, 1, $nb, $type,$orderway);

			$setting['itemsperpage'] = $items_page; 
			$setting['columnspage'] = $columns_page; 
			$setting['scolumn']    = 12 / $columns_page;
			$setting['interval'] 	= $interval;
			$setting['tab'] 	= 'recentcarousel'.rand(20,rand());
			$setting['products'] = $products;
			$output = array('type'=>'recentcarousel','data' => $setting );

			return $output;
		} 
		
		public function getRecentProducts($id_lang, $p, $n, $order_by = null, $order_way = null, $get_total = false, $active = true, $random = false, $random_number_products = 1, $check_access = true, Context $context = null) {
			if (!$context)
				$context = Context::getContext();


			$front = true;
			if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
				$front = false;

			if ($p < 1)
				$p = 1;
			if (empty($order_by))
				$order_by = 'position';
			else
			/* Fix for all modules which are now using lowercase values for 'orderBy' parameter */
				$order_by = strtolower($order_by);

			if (empty($order_way))
				$order_way = 'ASC';
				
			//	$order_by = 'dateadd';
			//if ($order_by == 'price')
				//$order_by = 'orderprice';

			if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
				die(Tools::displayError());

			$id_supplier = (int) Tools::getValue('id_supplier');

			/* Return only the number of products */
			if ($get_total) {
				$sql = 'SELECT COUNT(cp.`id_product`) AS total
						FROM `' . _DB_PREFIX_ . 'product` p
						' . Shop::addSqlAssociation('product', 'p') . '
						LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON p.`id_product` = cp.`id_product`
						'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') .
						($active ? ' AND product_shop.`active` = 1' : '') .
						($id_supplier ? 'AND p.id_supplier = ' . (int) $id_supplier : '');
				return (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			}

			$sql = 'SELECT DISTINCT p.id_product, p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, product_attribute_shop.`id_product_attribute`, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
						pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, image_shop.`id_image`,
						il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
						(SUM(pc.`grade`) / COUNT(pc.`grade`)) AS avg,
						pc.`date_add` as dateadd,
						DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
						INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . '
							DAY)) > 0 AS new, product_shop.price AS orderprice
					FROM `' . _DB_PREFIX_ . 'category_product` cp
					LEFT JOIN `' . _DB_PREFIX_ . 'product` p
						ON p.`id_product` = cp.`id_product`
					' . Shop::addSqlAssociation('product', 'p') . '
					LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa
					ON (p.`id_product` = pa.`id_product`)
					' . Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1') . '
					' . Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) . '
					LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
						ON (product_shop.`id_category_default` = cl.`id_category`
						AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
					LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
						ON (p.`id_product` = pl.`id_product`
						AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . ')
					LEFT JOIN `' . _DB_PREFIX_ . 'image` i
						ON (i.`id_product` = p.`id_product`)' .
					Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
					LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
						ON (image_shop.`id_image` = il.`id_image`
						AND il.`id_lang` = ' . (int) $id_lang . ')
					LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
						ON m.`id_manufacturer` = p.`id_manufacturer`
					LEFT JOIN `' . _DB_PREFIX_ . 'product_comment` pc
						ON p.`id_product` = pc.`id_product`	
					AND  product_shop.`id_shop` = ' . (int) $context->shop->id . '
					AND (pa.id_product_attribute IS NULL OR product_attribute_shop.id_shop=' . (int) $context->shop->id . ') 
					AND (i.id_image IS NULL OR image_shop.id_shop=' . (int) $context->shop->id . ')
						'. ($active ? ' AND product_shop.`active` = 1' : '')
						. ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
						. ($id_supplier ? ' AND p.id_supplier = ' . (int) $id_supplier : '');
						
			$sql .= ' GROUP BY pc.id_product ';
							
			if ($random === true) {
				$sql .= ' ORDER BY RAND()';
				$sql .= ' LIMIT 0, ' . (int) $random_number_products;
			}
			else
				$sql .= ' ORDER BY `' . pSQL($order_by) . '` ' . pSQL($order_way) . '
				LIMIT ' . (((int) $p - 1) * (int) $n) . ',' . (int) $n;
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

			if (!$result)
				return array();
				
			/* Modify SQL result */
			return Product::getProductsProperties($id_lang, $result);
    }

	}
?>