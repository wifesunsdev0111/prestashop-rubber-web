<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}
if (!class_exists('LeoWidgetBase')) {

    abstract class LeoWidgetBase
    {
        public $widget_name = 'base';
        public $name = 'leotempcp';
        public $id_shop = 0;
        public $fields_form = array();
        public $types = array();

        /**
         * abstract method to return html widget form
         */
        public function getWidgetInfo()
        {
            return array('key' => 'base', 'label' => 'Widget Base');
        }

        /**
         * abstract method to return html widget form
         */
        public function renderForm($args, $data)
        {
            # validate module
            unset($args);
            unset($data);
            return false;
        }

        /**
         * abstract method to return widget data 
         */
        public function renderContent($args, $data)
        {
            # validate module
            unset($args);
            unset($data);
            return false;
        }

        /**
         * Get translation for a given module text
         *
         * Note: $specific parameter is mandatory for library files.
         * Otherwise, translation key will not match for Module library
         * when module is loaded with eval() Module::getModulesOnDisk()
         *
         * @param string $string String to translate
         * @param boolean|string $specific filename to use in translation key
         * @return string Translation
         */
        public function l($string, $specific = false)
        {
            return Translate::getModuleTranslation($this->name, $string, ($specific) ? $specific : $this->name);
        }

        /**
         * Asign value for each input of Data form
         */
        public function getConfigFieldsValues($data = null)
        {
            $languages = Language::getLanguages(false);
            $fields_values = array();
            $obj = isset($data['params']) ? $data['params'] : array();

            foreach ($this->fields_form as $k => $f) {
                foreach ($f['form']['input'] as $j => $input) {
                    if (isset($input['lang'])) {
                        foreach ($languages as $lang) {
                            $fields_values[$input['name']][$lang['id_lang']] = isset($obj[$input['name'].'_'.$lang['id_lang']]) ? Tools::stripslashes($obj[$input['name'].'_'.$lang['id_lang']]) : $input['default'];
                        }
                    } else {
                        if (isset($obj[trim($input['name'])])) {
                            $value = $obj[trim($input['name'])];

                            if ($input['name'] == 'image' && $value) {
                                $thumb = __PS_BASE_URI__.'modules/'.$this->name.'/img/'.$value;
                                $this->fields_form[$k]['form']['input'][$j]['thumb'] = $thumb;
                            }
                            $fields_values[$input['name']] = Tools::stripslashes($value);
                        } else {
                            $v = Tools::getValue($input['name'], Configuration::get($input['name']));
                            $fields_values[$input['name']] = $v ? $v : $input['default'];
                        }
                    }
                }
            }
            if (isset($data['id_leowidgets'])) {
                $fields_values['id_leowidgets'] = $data['id_leowidgets'];
            }

            return $fields_values;
        }

        public function getFormHelper()
        {
            $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

            $this->fields_form[0]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Widget Info.'),
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'label' => $this->l('Megamenu ID'),
                        'name' => 'id_leowidgets',
                        'default' => 0,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Widget Name'),
                        'name' => 'widget_name',
                        'default' => '',
                        'required' => true,
                        'desc' => $this->l('Using for show in Listing Widget Management')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Widget Title'),
                        'name' => 'widget_title',
                        'default' => '',
                        'lang' => true,
                        'desc' => $this->l('This tile will be showed as header of widget block. Empty to disable')
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Widget Type'),
                        'id' => 'widget_type',
                        'name' => 'widget_type',
                        'options' => array('query' => $this->types,
                            'id' => 'type',
                            'name' => 'label'
                        ),
                        'default' => Tools::getValue('wtype'),
                        'desc' => $this->l('Select a alert style')
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

            $helper = new HelperForm();
            $helper->show_cancel_button = true;
            $helper->module = $this;
            $helper->name_controller = $this->name;
            $helper->identifier = $this->name;
            $helper->token = Tools::getAdminTokenLite('AdminLeotempcpWidgets');
            foreach (Language::getLanguages(false) as $lang) {
                $helper->languages[] = array(
                    'id_lang' => $lang['id_lang'],
                    'iso_code' => $lang['iso_code'],
                    'name' => $lang['name'],
                    'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
                );
            }
            $helper->currentIndex = AdminController::$currentIndex.'&widgets=1&rand='.rand().'&wtype='.Tools::getValue('wtype');
            $helper->default_form_language = $default_lang;
            $helper->allow_employee_form_lang = $default_lang;
            $helper->toolbar_scroll = true;
            $helper->title = $this->name;
            $helper->submit_action = 'addleowidgets';

            # validate module
//			$liveeditorURL = AdminController::$currentIndex.'&edit=1&token='.Tools::getAdminTokenLite('AdminLeotempcpWidgets');


            $helper->toolbar_btn = array(
                'back' =>
                array(
                    'desc' => $this->l('Back'),
                    'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLeotempcpWidgets').'&widgets=1&rand='.rand(),
                ),
            );

            return $helper;
        }

        public function getManufacturers($id_shop)
        {
            if (!$id_shop) {
                $id_shop = $this->context->shop->id;
            }
            $pmanufacturers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT m.`id_manufacturer`,m.`name`
			FROM `'._DB_PREFIX_.'manufacturer` m
			LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` ms ON (m.`id_manufacturer` = ms.`id_manufacturer` AND ms.`id_shop` = '.(int)$id_shop.')');
            return $pmanufacturers;
        }

        public function getProducts($where, $id_lang, $p, $n, $order_by = null, $order_way = null, $get_total = false, $active = true, $random = false, $random_number_products = 1, $check_access = true, Context $context = null)
        {
            # validate module
            unset($check_access);
            if (!$context) {
                $context = Context::getContext();
            }

            $front = true;
            if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
                $front = false;
            }

            if ($p < 1) {
                $p = 1;
            }
            if (empty($order_by)) {
                $order_by = 'position';
            } else {
                /* Fix for all modules which are now using lowercase values for 'orderBy' parameter */
                $order_by = Tools::strtolower($order_by);
            }

            if (empty($order_way)) {
                $order_way = 'ASC';
            }
            if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd') {
                $order_by_prefix = 'p';
            } elseif ($order_by == 'name') {
                $order_by_prefix = 'pl';
            } elseif ($order_by == 'manufacturer') {
                $order_by_prefix = 'm';
                $order_by = 'name';
            } elseif ($order_by == 'position') {
                $order_by_prefix = 'cp';
            }

            if ($order_by == 'price') {
                $order_by = 'orderprice';
            }

            if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
                die(Tools::displayError());
            }

            $id_supplier = (int)Tools::getValue('id_supplier');

            /* Return only the number of products */
            if ($get_total) {
                $sql = 'SELECT COUNT(cp.`id_product`) AS total
					FROM `'._DB_PREFIX_.'product` p
					'.Shop::addSqlAssociation('product', 'p').'
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
					'.$where.'
					'.pSQL($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
                        pSQL($active ? ' AND product_shop.`active` = 1' : '').
                        pSQL($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');
                return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            }

            $sql = 'SELECT DISTINCT p.id_product, p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, product_attribute_shop.`id_product_attribute`, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, image_shop.`id_image`,
					il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new, product_shop.price AS orderprice
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
					ON (i.`id_product` = p.`id_product`)'.
                    Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				'.$where.'	
				AND  product_shop.`id_shop` = '.(int)$context->shop->id.'
				AND (pa.id_product_attribute IS NULL OR product_attribute_shop.id_shop='.(int)$context->shop->id.') 
				AND (i.id_image IS NULL OR image_shop.id_shop='.(int)$context->shop->id.')
					'.($active ? ' AND product_shop.`active` = 1' : '')
                    .($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
                    .($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '');
            if ($random === true) {
                $sql .= ' ORDER BY RAND()';
                $sql .= ' LIMIT 0, '.(int)$random_number_products;
            } else {
                $sql .= ' ORDER BY '.(isset($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way).'
			LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
            }

            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
            if ($order_by == 'orderprice') {
                Tools::orderbyPrice($result, $order_way);
            }

            if (!$result) {
                return array();
            }

            /* Modify SQL result */
            return Product::getProductsProperties($id_lang, $result);
        }

        public static function getImageList($path)
        {
            if (!file_exists($path) && !is_dir($path)) {
                @mkdir($path, 0777, true);
            }

            $items = array();
            $handle = opendir($path);
            if (!$handle) {
                return $items;
            }
            while (false !== ($file = readdir($handle))) {
                //if (is_dir($path . $file))
                $items[$file] = $file;
            }
            unset($items['.'], $items['..'], $items['.svn']);
            return $items;
        }
    }

}
