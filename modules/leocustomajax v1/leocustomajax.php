<?php
/*
* 2011-2013 LeoTheme.com
*
*/

if (!defined('_PS_VERSION_'))
	exit;

class Leocustomajax extends Module
{
	public function __construct()
	{
		$this->name = 'leocustomajax';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'LeoTheme';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Leo Custom Ajax');
		$this->description = $this->l('Display product number of category and show rating.');
	}
	
	public function install()
	{
			if( parent::install() == false ||
				!$this->registerHook('footer') ||
				!$this->registerHook('productfooter') ||			
				!Configuration::updateValue('leo_customajax_img', 1) ||
				!Configuration::updateValue('leo_customajax_pn', 1) ||
				!Configuration::updateValue('leo_customajax_count', 1) ||
				!Configuration::updateValue('leo_customajax_acolor', 1) ||
				!Configuration::updateValue('leo_customajax_color', "") ||
				!Configuration::updateValue('leo_customajax_tran', 1))
				return false;
		$this->_installDataSample();	
		return true;
	}

	private function _installDataSample(){
        if (!file_exists(_PS_MODULE_DIR_ . 'leotempcp/libs/DataSample.php')) return false;        
        require_once( _PS_MODULE_DIR_ . 'leotempcp/libs/DataSample.php' );
        
        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }
	
	
	public function uninstall()
	{
			if( !parent::uninstall() ||
				!$this->unregisterHook('footer') ||
				!$this->unregisterHook('productfooter') ||
				!Configuration::deleteByName('leo_customajax_tran') ||
				!Configuration::deleteByName('leo_customajax_pn') ||
				!Configuration::deleteByName('leo_customajax_count') ||
				!Configuration::deleteByName('leo_customajax_acolor') ||
				!Configuration::deleteByName('leo_customajax_color') ||
				!Configuration::deleteByName('leo_customajax_img')
			)
				return false;
		return true;
		return (parent::uninstall() || $this->unregisterHook('header'));
	}

	public function getContent()
	{
		$output = '';
		if (Tools::isSubmit('submitLeocustomajax'))
		{
            Configuration::updateValue('leo_customajax_img', Tools::getValue('leo_customajax_img'));
            Configuration::updateValue('leo_customajax_tran', Tools::getValue('leo_customajax_tran'));
            Configuration::updateValue('leo_customajax_pn', Tools::getValue('leo_customajax_pn'));
			Configuration::updateValue('leo_customajax_count', Tools::getValue('leo_customajax_count'));
			Configuration::updateValue('leo_customajax_acolor', Tools::getValue('leo_customajax_acolor'));
			if(Tools::getValue('leo_customajax_color')){
				$str_leocolor = "";
				$str_col = Tools::getValue('leo_customajax_color');
				if($str_col){
					$result = array();
					$arr_col = explode(',',$str_col);
					if($arr_col)
						foreach($arr_col as $cols){
							$items = explode(':',$cols);							
							if($items && count($items) > 1){
								$result[$items[0]] = $items[1];
							}
						}
					ksort($result);	
					$arr_leocolor = array();
					foreach($result as $key => $row)
							$arr_leocolor[] = $key.':'.$row;
					$str_leocolor = implode(",",$arr_leocolor); 	
				}
				if($str_leocolor )
					Configuration::updateValue('leo_customajax_color', $str_leocolor);
				else
					$output .= $this->displayError($this->l('The input string is not correct.'));
			}
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Your settings have been updated.'));
		}
		return $output.$this->renderForm();
	}
	
	public function renderForm()
	{
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
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->l( 'Show Quantity Category' ),
						'name' => 'leo_customajax_pn',
						'default' => 1,
						'values' => $soption,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'You can add this code in category-tree-branch.tpl file of module you want to show Quantity product of category' ),
						'name' => 'leo_customajax_tpn',
						'cols' => 100,
					),
					array(
						'type' => 'switch',
						'label' => $this->l( 'Show More Product Image' ),
						'name' => 'leo_customajax_tran',
						'default' => 1,
						'values' => $soption,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'You can add this code in tpl file of module you want to show More Product Image' ),
						'name' => 'leo_customajax_ttran',
						'cols' => 100,
					),
					array(
						'type' => 'switch',
						'label' => $this->l( 'Show Multiple Product Image' ),
						'name' => 'leo_customajax_img',
						'default' => 1,
						'values' => $soption,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'You can add this code in tpl file of module you want to show Multiple Product Image' ),
						'name' => 'leo_customajax_rti',
						'cols' => 100,
					),
					array(
						'type' => 'switch',
						'label' => $this->l( 'Show Count Down Product' ),
						'name' => 'leo_customajax_count',
						'default' => 1,
						'values' => $soption,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'You can add this code in tpl file of module you want to show Count Down' ),
						'name' => 'leo_customajax_tcount',
						'cols' => 100,
					),
					array(
						'type' => 'switch',
						'label' => $this->l( 'Show Discount Color' ),
						'name' => 'leo_customajax_acolor',
						'default' => 1,
						'values' => $soption,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'You can add this code in tpl file of module you want to show color discount' ),
						'name' => 'leo_customajax_tcolor',
						'cols' => 100,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l( 'For color (Ex: 10:#ff0000,20:#152ddb,40:#ffee001) ' ),
						'name' => 'leo_customajax_color',
						'cols' => 100
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('If you want my script run fine with blog layer module.
									Please copy to override file modules/blocklayered/blocklayered.js to folder themes/TEMPLATE_NAME/js/modules/blocklayered/blocklayered.js.
									Then find function reloadContent(params_plus).'),
						'name' => 'leo_customajax_rtn',
						'cols' => 100
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);
		
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitLeocustomajax';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		return $helper->generateForm(array($fields_form));
	}
	
	public function hookFooter()
	{
		$leo_customajax_img = Configuration::get('leo_customajax_img');
		$leo_customajax_tran = Configuration::get('leo_customajax_tran');
		$leo_customajax_pn = Configuration::get('leo_customajax_pn');
		$leo_customajax_count = Configuration::get('leo_customajax_count');
		$leo_customajax_acolor = Configuration::get('leo_customajax_acolor');
		$this->smarty->assign(array(
			'leo_customajax_img'	=>	$leo_customajax_img,
			'leo_customajax_tran'	=>	$leo_customajax_tran,
			'leo_customajax_pn'		=>	$leo_customajax_pn,
			'leo_customajax_count'	=>	$leo_customajax_count,
			'leo_customajax_acolor' => 	$leo_customajax_acolor
		));
		$this->context->controller->addJqueryPlugin('fancybox');
		$this->context->controller->addJS(($this->_path).'leocustomajax.js');
		$this->context->controller->addCSS(($this->_path).'leocustomajax.css', 'all');
		if($leo_customajax_count)
			$this->context->controller->addJS(_MODULE_DIR_.$this->name.'/countdown.js');
		if($leo_customajax_img || $leo_customajax_tran ) 
			$this->context->controller->addCSS(($this->_path).'leocustomajax.css', 'all');
		
		if($leo_customajax_img){
			$this->context->controller->addJqueryPlugin(array('scrollTo', 'serialScroll'));
		}
		return $this->display(__FILE__, 'footer.tpl');
	}
        
        
        /**
	 * Get Grade By product
	 *
	 * @return array Grades
	 */
	public static function getGradeByProducts($listProduct)
	{
		$validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');
                $id_lang = (int)Context::getContext()->language->id;    

		return (Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT pc.`id_product_comment`, pcg.`grade`, pccl.`name`, pcc.`id_product_comment_criterion`, pc.`id_product`
		FROM `'._DB_PREFIX_.'product_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'product_comment_grade` pcg ON (pcg.`id_product_comment` = pc.`id_product_comment`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion` pcc ON (pcc.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl ON (pccl.`id_product_comment_criterion` = pcg.`id_product_comment_criterion`)
		WHERE pc.`id_product` in ('.$listProduct.')
		AND pccl.`id_lang` = '.(int)$id_lang.
		($validate == '1' ? ' AND pc.`validate` = 1' : '')));
	}
        
        /**
	 * Return number of comments and average grade by products
	 *
	 * @return array Info
	 */
	public static function getGradedCommentNumber($listProduct)
	{
		$validate = (int)Configuration::get('PRODUCT_COMMENTS_MODERATE');
                
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT COUNT(pc.`id_product`) AS nbr, pc.`id_product` 
		FROM `'._DB_PREFIX_.'product_comment` pc
		WHERE `id_product` in ('.$listProduct.')'.($validate == '1' ? ' AND `validate` = 1' : '').'
		AND `grade` > 0 GROUP BY pc.`id_product`');
		return $result;
	}
        
        
        
    public static function getByProduct($id_product)
	{
		$id_lang = (int)Context::getContext()->language->id;
                
                if (!Validate::isUnsignedId($id_product) ||
			!Validate::isUnsignedId($id_lang))
			die(Tools::displayError());
		$alias = 'p';
		$table = '';
		// check if version > 1.5 to add shop association
		if (version_compare(_PS_VERSION_, '1.5', '>'))
		{
			$table = '_shop';
			$alias = 'ps';
		}
		return Db::getInstance()->executeS('
			SELECT pcc.`id_product_comment_criterion`, pccl.`name`
			FROM `'._DB_PREFIX_.'product_comment_criterion` pcc
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_lang` pccl
				ON (pcc.id_product_comment_criterion = pccl.id_product_comment_criterion)
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_product` pccp
				ON (pcc.`id_product_comment_criterion` = pccp.`id_product_comment_criterion` AND pccp.`id_product` = '.(int)$id_product.')
			LEFT JOIN `'._DB_PREFIX_.'product_comment_criterion_category` pccc
				ON (pcc.`id_product_comment_criterion` = pccc.`id_product_comment_criterion`)
			LEFT JOIN `'._DB_PREFIX_.'product'.$table.'` '.$alias.'
				ON ('.$alias.'.id_category_default = pccc.id_category AND '.$alias.'.id_product = '.(int)$id_product.')
			WHERE pccl.`id_lang` = '.(int)($id_lang).'
			AND (
				pccp.id_product IS NOT NULL
				OR ps.id_product IS NOT NULL
				OR pcc.id_product_comment_criterion_type = 1
			)
			AND pcc.active = 1
			GROUP BY pcc.id_product_comment_criterion
		');
	}
        
   public function hookProductMoreImg($listPro)
	{
            $id_lang = Context::getContext()->language->id;
            //get product info
            $productList = $this->getProducts($listPro,$id_lang);
            
            $this->smarty->assign(array(
                'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium'))	
            ));
            
            $obj = array();
            foreach ($productList as $key=>$product){
                $this->smarty->assign('product',$product);
                $obj[] = array("id"=>$product["id_product"],"content"=>utf8_encode($this->display(__FILE__, 'product.tpl')));
            }
            return $obj;
	}
        
    public function hookProductOneImg($listPro)
	{
            global $link;
            $id_lang = Context::getContext()->language->id;
            $where  = " WHERE i.`id_product` IN (".$listPro.") AND i.`cover`=0";
            $order  = " ORDER BY i.`id_product`,`position`";
            $limit  = " LIMIT 0,1";
            //get product info
            $listImg = $this->getAllImages($id_lang, $where, $order, $limit);
            $savedImg = array();
            $obj = array();
			$this->smarty->assign(array(
                'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),	
                'smallSize' => Image::getSize(ImageType::getFormatedName('small'))	
            ));
            foreach ($listImg as $product){
                if(!in_array($product["id_product"], $savedImg))
                $obj[] = array("id"=>$product["id_product"],"content"=>utf8_encode($link->getImageLink($product['link_rewrite'], $product["id_image"], 'home_default')));
                $savedImg[] = $product["id_product"];
            }
            return $obj;
	}
	
	public function hookProductCdown($leoProCdown)
	{
        $id_lang = Context::getContext()->language->id;
			$productList = $this->getProducts($leoProCdown,$id_lang);
            $obj = array();
            foreach ($productList as $key=>$product){
                $this->smarty->assign('product',$product);
                $obj[] = array("id"=>$product["id_product"],"content"=>utf8_encode($this->display(__FILE__, 'cdown.tpl')));
            }
            return $obj;  
	}
	
	public function hookProductColor($leoProColor)
	{
        $id_lang = Context::getContext()->language->id;
			$colors = array();
			$leo_customajax_color = Configuration::get('leo_customajax_color');
			if($leo_customajax_color){
				$arrs = explode(",",$leo_customajax_color);
				foreach($arrs as $arr){
					$items = explode(":",$arr);
					$colors[$items[0]] = $items[1]; 
				}
			}
			$this->smarty->assign(array(
                'colors' => $colors,
				));	
			$productList = $this->getProducts($leoProColor,$id_lang);
            $obj = array();
            foreach ($productList as $key=>$product){
                $this->smarty->assign('product',$product);
                $obj[] = array("id"=>$product["id_product"],"content"=>utf8_encode($this->display(__FILE__, 'color.tpl')));
            }
            return $obj;  
	}
        
	public function getProducts($productList,$id_lang,$colors = array())
	{           
		$context = Context::getContext();
		$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
		$ids = Address::getCountryAndState($id_address);
		$id_country = (int)($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));
		$sql = 'SELECT p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name,sp.`id_specific_price`
				FROM `'._DB_PREFIX_.'product` p
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)
				LEFT JOIN `'._DB_PREFIX_.'specific_price` sp ON (sp.`id_product` = p.`id_product`
						AND sp.`id_shop` IN(0, '.(int)($context->shop->id).')
						AND sp.`id_currency` IN(0, '.(int)($context->currency->id).')
						AND sp.`id_country` IN(0, '.(int)($id_country).')
						AND sp.`id_group` IN(0, '.(int)($context->customer->id_default_group).')
						AND sp.`id_customer` IN(0, '.(int)($context->customer->id).')
						AND sp.`reduction` > 0
					)
				WHERE pl.`id_lang` = '.(int)$id_lang.
                        ' AND p.`id_product` in ('.$productList .')';
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		
                if($productList){
                    $tmpImg = array();
                    $coverImg = array();
                    $where  = " WHERE i.`id_product` IN (".$productList.")";
                    $order  = " ORDER BY i.`id_product`,`position`";

                    switch(Configuration::get('LEO_MINFO_SORT')){
                            case "position2":
                                    break;
                            case "random":
                                    $order = " ORDER BY RAND()";
                                    break;
                            default:
                                    $order = " ORDER BY i.`id_product`,`position` DESC";
                    }


                    $listImg = $this->getAllImages($id_lang, $where, $order);
                    foreach($listImg as $val){
                        $tmpImg[$val["id_product"]][$val["id_image"]] = $val;
                        if($val["cover"]==1)
                        $coverImg[$val["id_product"]] = $val["id_image"];
                    }
                }
				$now = date('Y-m-d H:i:s');
				$finish = $this->l('Expired');
                foreach ($result as &$val){
					$time = false;
                    if(isset($tmpImg[$val["id_product"]])){
                        $val["images"] =  $tmpImg[$val["id_product"]];
                        $val["id_image"] =  $coverImg[$val["id_product"]];
                    }else{
                        $val["images"] =  array();
                    }
					$val['specific_prices'] = self::getSpecificPriceById($val['id_specific_price']);
					if(isset($val['specific_prices']['from']) && $val['specific_prices']['from'] > $now){
						$time = strtotime($val['specific_prices']['from']);
						$val['finish'] 	= $finish;
						$val['check_status'] = 0;
						$val['lofdate'] = Tools::displayDate($val['specific_prices']['from']);
					}elseif(isset($val['specific_prices']['to']) && $val['specific_prices']['to'] > $now){
						$time = strtotime($val['specific_prices']['to']);
						$val['finish'] 	= $finish;
						$val['check_status'] 	= 1;
						$val['lofdate'] = Tools::displayDate($val['specific_prices']['to']);
					}elseif(isset($val['specific_prices']['to']) && $val['specific_prices']['to'] == '0000-00-00 00:00:00'){
						$val['js'] 	= 'unlimited';
						$val['finish'] 	= $this->l('Unlimited');
						$val['check_status'] 	= 1;
						$val['lofdate'] = $this->l("Unlimited");
					}else if(isset($val['specific_prices']['to'])){
						$time = strtotime($val['specific_prices']['to']);
						$val['finish'] 	= $finish;
						$val['check_status'] 	= 2;
						$val['lofdate'] = Tools::displayDate($val['specific_prices']['from']);
					}
					if($time){
						$val['js'] 	= array(
							'month' => date('m',$time),
							'day' => date('d',$time),
							'year' => date('Y',$time),
							'hour' => date('H',$time),
							'minute' => date('i',$time),
							'seconds' => date('s',$time)
						);
					}
                }
                
                return Product::getProductsProperties($id_lang, $result);
	}
    
	public static function getSpecificPriceById($id_specific_price)
	{
		if (!SpecificPrice::isFeatureActive())
			return array();
		
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT *
			FROM `'._DB_PREFIX_.'specific_price` sp
			WHERE `id_specific_price` ='.(int)($id_specific_price));
		
		return $res;
	}
		
        
    public function getAllImages($id_lang, $where, $order){
		$sql = 'SELECT i.`id_product`, image_shop.`cover`, i.`id_image`, il.`legend`, i.`position`,pl.`link_rewrite`
				FROM `'._DB_PREFIX_.'image` i
				'.Shop::addSqlAssociation('image', 'i').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (i.`id_product` = pl.`id_product`) 
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')'.$where.' '.$order;
		
		return Db::getInstance()->executeS($sql);
	}
	
	public function getConfigFieldsValues()
	{
		return array(
			'leo_customajax_rti' => 
						'add this code
                        <div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
                             in
                       <div class="left-block">...</div>',
			'leo_customajax_rtn' =>'                                      
                                            }
                                        });
                                        ajaxQueries.push(ajaxQuery);
                                        
                                        -------edit it to-----------
                                            if (typeof LeoCustomAjax !== "undefined" && $.isFunction(LeoCustomAjax)) {
								                var leoCustomAjax = new $.LeoCustomAjax();
								                leoCustomAjax.processAjax();
								            }
                                        });
                                        ajaxQueries.push(ajaxQuery);
                         ',
			'leo_customajax_tcount' => '<div class="leo-more-cdown" data-idproduct="{$product.id_product}"></div>',
			'leo_customajax_ttran' 	=> '<span class="product-additional" data-idproduct="{$product.id_product}"></span>',
			'leo_customajax_tcolor' => '<div class="leo-more-color" data-idproduct="{$product.id_product}"></div>',
			'leo_customajax_tpn'	=> 'add this code
					<span id="leo-cat-{$node.id}" style="display:none" class="leo-qty badge pull-right"></span>
						after
						{$node.name|escape:html:UTF-8}',	
			'leo_customajax_img' 	=> Tools::getValue('leo_customajax_img', Configuration::get('leo_customajax_img')),
			'leo_customajax_tran' 	=> Tools::getValue('leo_customajax_tran', Configuration::get('leo_customajax_tran')),
			'leo_customajax_count' 	=> Tools::getValue('leo_customajax_count', Configuration::get('leo_customajax_count')),
			'leo_customajax_pn' 	=> Tools::getValue('leo_customajax_pn', Configuration::get('leo_customajax_pn')),
			'leo_customajax_color' 	=> Tools::getValue('leo_customajax_color', Configuration::get('leo_customajax_color')),
			'leo_customajax_acolor' => Tools::getValue('leo_customajax_acolor', Configuration::get('leo_customajax_acolor')),
			);
	}
}