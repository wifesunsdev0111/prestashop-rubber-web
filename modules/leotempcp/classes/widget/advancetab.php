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

class LeoWidgetAdvancetab extends LeoWidgetBase
{
    public $widget_name = 'advancetab';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Advance Tabs'), 'explain' => $this->l('Create Advance Tabs'));
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
//		$options = array(
//			array(
//				'id' => 'active_on',
//				'value' => 1,
//				'label' => $this->l('Enabled')
//			),
//			array(
//				'id' => 'active_off',
//				'value' => 0,
//				'label' => $this->l('Disabled')
//			)
//		);
        $orderby = array(
            array(
                'order' => 'date_add', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Date Add') // The value of the text content of the  <option> tag.
            ),
            array(
                'order' => 'date_upd', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Date Update') // The value of the text content of the  <option> tag.
            ),
            array(
                'order' => 'name',
                'name' => $this->l('Name')
            ),
            array(
                'order' => 'id_product',
                'name' => $this->l('Product Id')
            ),
            array(
                'order' => 'price',
                'name' => $this->l('Price')
            ),
        );

        $orderway = array(
            array(
                'orderway' => 'ASC', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Ascending') // The value of the text content of the  <option> tag.
            ),
            array(
                'orderway' => 'DESC', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Descending') // The value of the text content of the  <option> tag.
            ),
        );
        $root = Category::getRootCategory();
        $categories = array();
        $helper = $this->getFormHelper();
        $items = '';
        $tab_edit = '';
        if ($data['params'] && isset($data['params']['leotab']) && $data['params']['leotab']) {
            $tabs = $data['params']['leotab'];
            $items = $this->getTabs($tabs);
            if (Tools::getValue('id_tab')) {
                $id_tab = Tools::getValue('id_tab');
                $tab_edit = $items[$id_tab] ? $items[$id_tab] : '';
                $categories = $items[$id_tab]['categories'] ? $items[$id_tab]['categories'] : array();
            }
        }
        $tree = new HelperTreeCategories('categories-tree', 'Categories');
        $tree->setRootCategory($root->id)->setUseCheckBox(true)->setUseSearch(true)->setSelectedCategories($categories);

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Carousel Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Order By:'),
                    'desc' => $this->l('The maximum number of products in each page  (default: 3).'),
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
                    'desc' => $this->l('The maximum number of products in each page  (default: 3).'),
                    'name' => 'orderway',
                    'default' => 'date_add',
                    'options' => array(
                        'query' => $orderway,
                        'id' => 'orderway',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'itemstab',
                    'default' => 6,
                    'desc' => $this->l('The maximum number of products in each tab (default: 6).')
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Carousel type'),
                    'name' => 'carousel_type',
                    'default' => LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'class' => 'form-action',
                    'options' => array(
                        'query' => LeomanagewidgetsOwlCarousel::getCaroulseOptions(),
                        'id' => 'value',
                        'name' => 'name'
                    )
                ),
                # config for Bootstrap Carousel - BEGIN
                array(
                    'type' => 'text',
                    'label' => $this->l('Number of Items In Page'),
                    'name' => 'itemspage',
                    'default' => 3,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'desc' => $this->l('The maximum number of products in each page tab (default: 3).')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Number of Columns In Page'),
                    'name' => 'columns',
                    'default' => 3,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'desc' => $this->l('The maximum number of products in each page tab (default: 3).')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Interval'),
                    'name' => 'interval',
                    'default' => 8000,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'desc' => $this->l('Enter Time(miniseconds) to play carousel. Value 0 to stop.')
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

        // Add library owl carousel
        $owl_carousel = new LeomanagewidgetsOwlCarousel();
        $arrays = $owl_carousel->getOwlCarouselAdminFormOptions();
        foreach ($arrays as $key => $array) {
            # validate module
            unset($key);
            $this->fields_form[1]['form']['input'][] = $array;
        }

        $this->fields_form[1]['form']['input'][] = array(
            'type' => 'setting_tab',
            'name' => 'setting_tab',
            'lang' => true,
            'tree' => $tree->render(),
            'default' => '',
        );

        $theme_dir = Context::getContext()->shop->theme_directory;
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($data),
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_lang_default' => (int)Configuration::get('PS_LANG_DEFAULT'),
            'iso_code' => Context::getContext()->language->iso_code,
            'text_title' => 'title_'.Context::getContext()->language->iso_code,
            'path' => __PS_BASE_URI__.'themes/'.$theme_dir.'/img/icontab/',
            'images' => LeoWidgetBase::getImageList(_PS_ROOT_DIR_.'/themes/'.$theme_dir.'/img/icontab/'),
            'url' => AdminController::$currentIndex.'&id_leowidgets='.Tools::getValue('id_leowidgets').'&updateleowidgets&token='.Tools::getValue('token').'&conf=4',
            'items' => $items,
            'tab_edit' => $tab_edit
        );
        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        # validate module
        unset($args);
        $t = array(
            'name' => '',
            'html' => '',
        );
        $setting = array_merge($t, $setting);
        $nb = ($setting['itemstab']) ? (int)($setting['itemstab']) : 6;
        $orderby = ($setting['orderby']) ? ($setting['orderby']) : 'position';
        $orderway = ($setting['orderway']) ? ($setting['orderway']) : 'ASC';
        $items_page = ($setting['itemspage']) ? (int)($setting['itemspage']) : 3;
        $columns_page = ($setting['columns']) ? (int)($setting['columns']) : 3;
        $interval = ($setting['interval']) ? (int)($setting['interval']) : 8000;
        $iso_code = Context::getContext()->language->iso_code;
        $setting['tabs'] = array();
        $result = array();
        $result['products'] = array();
        if (isset($setting['leotab'])) {
            $tabs = $setting['leotab'];
            $items = $this->getTabs($tabs);
            foreach ($items as $item) {
                if ($item['categories'] || $item['type']) {
                    $categories = $item['categories'] ? implode($item['categories'], ',') : '';
                    $where = '';
                    if ($categories) {
                        $where = 'cp.`id_category` IN ('.$categories.') AND ';
                    }
                    if ($item['type'] == 'new') {
                        $result['products'] = $this->getNewProducts($where, (int)(Context::getContext()->language->id), 0, $nb, false, $orderby, $orderway);
                    } elseif ($item['type'] == 'special') {
                        $result['products'] = $this->getPricesDrop($where, (int)(Context::getContext()->language->id), 0, $nb, false, $orderby, $orderway);
                    } elseif ($item['type'] == 'bestseller') {
                        $result['products'] = $this->getBestSales($where, (int)(Context::getContext()->language->id), 0, $nb, $orderby, $orderway);
                    } elseif ($item['type'] == 'featured') {
                        $product_ids = $this->getFeatureProducts();
                        $lang_id = Context::getContext()->language->id;
                        $result['products'] = $this->getFeatureProductsByCategoryID($categories, $product_ids, $lang_id, 1, $nb, $orderby, $orderway, false, true, false, 1, false, null);
                    } else {
                        if ($categories) {
                            $where = 'WHERE cp.`id_category` IN ('.$categories.')';
                        }
                        $result['products'] = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $nb, $orderby, $orderway);
                    }

                    $result['title'] = $item['title_'.$iso_code] ? $item['title_'.$iso_code] : '';
                    $result['icon'] = $item['icon'] ? $item['icon'] : '';
                    $result['id_tab'] = $item['id_tab'] ? $item['id_tab'] : 0;
                    $setting['tabs'][] = $result;
                }
            }
        }
        $setting['itemsperpage'] = $items_page;
        $setting['columnspage'] = $columns_page;
        $setting['interval'] = $interval;
        $setting['path'] = __PS_BASE_URI__.'themes/'._THEME_NAME_.'/img/icontab/';
        $setting['scolumn'] = 12 / $columns_page;
        $setting['myTab'] = 'advancetab'.rand(20, rand());
        $output = array('type' => 'advancetab', 'data' => $setting);

        return $output;
    }

    public function getTabs($tabs)
    {
        $datas = array();
        foreach ($tabs as $tab) {
            if ($tab) {
                $data = Tools::jsonDecode($tab, true);
                $data['tab'] = $tab;
            }
            $datas[$data['id_tab']] = $data;
        }
        return $datas;
    }

    public function getNewProducts($where, $id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if ($page_number < 0) {
            $page_number = 0;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'p';
        } else if ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND p.`id_product` IN (
					SELECT cp.`id_product`
					FROM `'._DB_PREFIX_.'category_group` cg
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
					WHERE cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').'
				)';
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }

        if ($count) {
            $sql = 'SELECT COUNT(p.`id_product`) AS nb
						FROM `'._DB_PREFIX_.'product` p
						'.Shop::addSqlAssociation('product', 'p').'
						WHERE product_shop.`active` = 1
						AND product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'"
						'.pSQL($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
						'.pSQL($sql_groups);
            return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        }

        $sql = 'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
                pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
                product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new';
        $sql = new DbQuery();
        $sql->select($sql);
        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', 'p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl'));
        $sql->leftJoin('image', 'i', 'i.`id_product` = p.`id_product`');
        $sql->join(Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1'));
        $sql->leftJoin('image_lang', 'il', 'i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');

        $sql->where('product_shop.`active` = 1');
        if ($front) {
            $sql->where('product_shop.`visibility` IN ("both", "catalog")');
        }
        $sql->where('product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'"');

        $sql->where('p.`id_product` IN (
				SELECT cp.`id_product`
				FROM `'._DB_PREFIX_.'category_group` cg
				LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
				WHERE '.$where.' cg.`id_group` '.$sql_groups.'
			)');
        $sql->groupBy('product_shop.id_product');

        $sql->orderBy((isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way));
        $sql->limit($nb_products, $page_number * $nb_products);

        if (Combination::isFeatureActive()) {
            $sql->select('MAX(product_attribute_shop.id_product_attribute) id_product_attribute');
            $sql->leftOuterJoin('product_attribute', 'pa', 'p.`id_product` = pa.`id_product`');
            $sql->join(Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on = 1'));
        }
        $sql->join(Product::sqlStock('p', Combination::isFeatureActive() ? 'product_attribute_shop' : 0));

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        if (!$result) {
            return false;
        }

        $products_ids = array();
        foreach ($result as $row) {
            $products_ids[] = $row['id_product'];
        }
        // Thus you can avoid one query per product, because there will be only one query for all the products of the cart
        Product::cacheFrontFeatures($products_ids, $id_lang);

        return Product::getProductsProperties((int)$id_lang, $result);
    }

    public function getPricesDrop($where, $id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
    {
        if (!Validate::isBool($count)) {
            die(Tools::displayError());
        }

        if (!$context) {
            $context = Context::getContext();
        }
        if ($page_number < 0) {
            $page_number = 0;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'price';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'p';
        } else if ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        $current_date = date('Y-m-d H:i:s');
        $ids_product = $this->_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);
        $tab_id_product = array();
        foreach ($ids_product as $product) {
            if (is_array($product)) {
                $tab_id_product[] = (int)$product['id_product'];
            } else {
                $tab_id_product[] = (int)$product;
            }
        }
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        $sql_groups = '';

        $groups = FrontController::getCurrentCustomerGroups();
        $sql_groups = 'AND p.`id_product` IN (
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_group` cg
			LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
			WHERE '.$where.' cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').'
		)';

        if ($count) {
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(DISTINCT p.`id_product`)
			FROM `'._DB_PREFIX_.'product` p
			'.Shop::addSqlAssociation('product', 'p').'
			WHERE product_shop.`active` = 1
			AND product_shop.`show_price` = 1
			'.pSQL($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
			'.pSQL((!$beginning && !$ending) ? 'AND p.`id_product` IN('.pSQL((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')' : '').'
			'.$sql_groups);
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
        }

        $sql = '
		SELECT
			p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`,
			MAX(product_attribute_shop.id_product_attribute) id_product_attribute,
			pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
			pl.`name`, MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
			DATEDIFF(
				p.`date_add`,
				DATE_SUB(
					NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
				)
			) > 0 AS new
		FROM `'._DB_PREFIX_.'product` p
		'.Shop::addSqlAssociation('product', 'p').'
		LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.id_product = p.id_product)
		'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1').'
		'.Product::sqlStock('p', 0, false, $context->shop).'
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
		)
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
		WHERE product_shop.`active` = 1
		AND product_shop.`show_price` = 1
		'.($front ? ' AND p.`visibility` IN ("both", "catalog")' : '').'
		'.((!$beginning && !$ending) ? ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')' : '').'
		'.$sql_groups.'
		GROUP BY product_shop.id_product
		ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way).'
		LIMIT '.(int)($page_number * $nb_products).', '.(int)$nb_products;

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }

        return Product::getProductsProperties($id_lang, $result);
    }

    public function getBestSales($where, $id_lang, $page_number = 0, $nb_products = 10, $order_by = null, $order_way = null)
    {
        if ($page_number < 0) {
            $page_number = 0;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        $final_order_by = $order_by;
        $order_table = '';
        if (is_null($order_by) || $order_by == 'position' || $order_by == 'price') {
            $order_by = 'sales';
        }
        if ($order_by == 'date_add' || $order_by == 'date_upd') {
            $order_table = 'product_shop';
        }
        if (is_null($order_way) || $order_by == 'sales') {
            $order_way = 'DESC';
        }

        $sql_groups = '';

        $groups = FrontController::getCurrentCustomerGroups();
        $sql_groups = 'WHERE cp.`id_product` IS NOT NULL AND '.pSQL($where).' cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');

        $interval = Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20;

        // Subquery: get product ids in a separate query to (greatly!) improve performances and RAM usage
        $products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT cp.`id_product`
		FROM `'._DB_PREFIX_.'category_group` cg
		INNER JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
		'.$sql_groups);

        $ids = array();
        foreach ($products as $product) {
            if (Validate::isUnsignedId($product['id_product'])) {
                $ids[$product['id_product']] = 1;
            }
        }
        $ids = array_keys($ids);
        $ids = array_filter($ids);
        sort($ids);
        $ids = count($ids) > 0 ? implode(',', $ids) : 'NULL';

        //Main query
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
					pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
					pl.`meta_keywords`, pl.`meta_title`, pl.`name`,
					m.`name` AS manufacturer_name, p.`id_manufacturer` as id_manufacturer,
					MAX(image_shop.`id_image`) id_image, il.`legend`,
					ps.`quantity` AS sales, t.`rate`, pl.`meta_keywords`, pl.`meta_title`, pl.`meta_description`,
					DATEDIFF(p.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.$interval.' DAY)) > 0 AS new
				FROM `'._DB_PREFIX_.'product_sale` ps
				LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
				'.Shop::addSqlAssociation('product', 'p', false).'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group`)
					AND tr.`id_country` = '.(int)Context::getContext()->country->id.'
					AND tr.`id_state` = 0
				LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
				'.Product::sqlStock('p').'
				WHERE product_shop.`active` = 1
					AND p.`visibility` != \'none\'
					AND p.`id_product` IN ('.$ids.')
				GROUP BY product_shop.id_product
				ORDER BY '.(!empty($order_table) ? '`'.pSQL($order_table).'`.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way).'
				LIMIT '.(int)($page_number * $nb_products).', '.(int)$nb_products;

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($final_order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        if (!$result) {
            return false;
        }
        return Product::getProductsProperties($id_lang, $result);
    }

    protected function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination = false)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
        $ids = Address::getCountryAndState($id_address);
        $id_country = (int)($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));

        return SpecificPrice::getProductIdByDate($context->shop->id, $context->currency->id, $id_country, $context->customer->id_default_group, $beginning, $ending, 0, $with_combination);
    }

    /**
     * Return current category products
     *
     * @param integer $id_lang Language ID
     * @param integer $p Page number
     * @param integer $n Number of products per page
     * @param boolean $get_total return the number of results instead of the results themself
     * @param boolean $active return only active products
     * @param boolean $random active a random filter for returned products
     * @param int $random_number_products number of products to return if random is activated
     * @param boolean $check_access set to false to return all products (even if customer hasn't access)
     * @return mixed Products or number of products
     */
    public function getFeatureProductsByCategoryID($categories_id, $product_ids, $id_lang, $p, $n, $order_by = null, $order_way = null, $get_total = false, $active = true, $random = false, $random_number_products = 1, $check_access = true, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        if ($check_access && !$this->checkAccess($context->customer->id)) {
            return false;
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

        $order_by_prefix = false;
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
					WHERE cp.`id_category` IN ('.pSQL($categories_id).')'.
                    pSQL($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
                    pSQL($active ? ' AND product_shop.`active` = 1' : '').
                    pSQL($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');
            return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        }

        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
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
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
					AND cp.`id_category` IN ('.pSQL($categories_id).')'
                .'AND cp.`id_product` IN ('.pSQL($product_ids).')'
                .($active ? ' AND product_shop.`active` = 1' : '')
                .($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
                .($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
                .' GROUP BY product_shop.id_product';
        if ($random === true) {
            $sql .= ' ORDER BY RAND() LIMIT '.(int)$random_number_products;
        } else {
            $sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way).'
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

    /**
     * Select product_id in featured product
     */
    public function getFeatureProducts()
    {
        $home_category_id = (int)Configuration::get('HOME_FEATURED_CAT');
        $sql = 'SELECT id_product FROM `'._DB_PREFIX_.'category_product` cp
				WHERE cp.`id_category` = ('.pSQL($home_category_id).')';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        # Default, have one category not show error
        $product_ids = '-99';

        foreach ($result as $key => $row) {
            # validate module
            unset($key);
            $product_ids .= ','.implode(',', $row);
        }

        return $product_ids;
    }

    /**
     * 0 no multi_lang
     * 1 multi_lang follow id_lang
     * 2 multi_lnag follow code_lang
     */
    public function getConfigKey($multi_lang = 0)
    {
        if ($multi_lang == 0) {
            return array(
                'orderby',
                'orderway',
                'itemstab',
                'carousel_type',
                'itemspage',
                'columns',
                'interval',
                'owl_items',
                'owl_rows',
                'owl_autoPlay',
                'owl_stopOnHover',
                'owl_autoHeight',
                'owl_responsive',
                'owl_mouseDrag',
                'owl_touchDrag',
                'owl_navigation',
                'owl_slideSpeed',
                'owl_itemsDesktop',
                'owl_itemsDesktopSmall',
                'owl_itemsTablet',
                'owl_itemsTabletSmall',
                'owl_itemsMobile',
                'owl_itemsCustom',
                'owl_lazyLoad',
                'owl_lazyEffect',
                'owl_lazyFollow',
                'owl_pagination',
                'owl_paginationNumbers',
                'owl_paginationSpeed',
                'owl_rewindNav',
                'owl_rewindSpeed',
                'owl_scrollPerPage',
                'categoryBox',
                'tabtype',
                'icon',
                'leotab',
            );
        } elseif ($multi_lang == 1) {
            return array(
                'tabtitle',
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
