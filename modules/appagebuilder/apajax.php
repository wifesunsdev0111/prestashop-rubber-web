<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
include_once(dirname(__FILE__).'/appagebuilder.php');
include_once(dirname(__FILE__).'/classes/shortcodes.php');
include_once(dirname(__FILE__).'/classes/shortcodes/ApProductList.php');
$module = new APPageBuilder();
if (Tools::getValue('leoajax') == 1) {
    # process category
    $list_cat = Tools::getValue('cat_list');
    $leo_pro_info = Tools::getValue('pro_info');
    $leo_pro_add = Tools::getValue('pro_add');
    $leo_pro_cdown = Tools::getValue('pro_cdown');
    $leo_pro_color = Tools::getValue('pro_color');
    //add function wishlist compare
    $wishlist_compare = Tools::getValue('wishlist_compare');

    $result = array();

    //get number product of compare + wishlist
    if ($wishlist_compare) {
        $current_user = (int)Context::getContext()->cookie->id_customer;
        $id_wishlist = Db::getInstance()->getValue("SELECT id_wishlist FROM `"._DB_PREFIX_."wishlist` WHERE id_customer = '$current_user'");
        $wishlist_products = Db::getInstance()->getValue("SELECT COUNT(id_wishlist_product) FROM `"._DB_PREFIX_."wishlist_product` WHERE id_wishlist = '$id_wishlist'");

        $compared_products = array();
        if (Configuration::get('PS_COMPARATOR_MAX_ITEM') && isset(Context::getContext()->cookie->id_compare)) {
            $compared_products = CompareProduct::getCompareProducts(Context::getContext()->cookie->id_compare);
        }
        $result['wishlist_products'] = $wishlist_products;
        $result['compared_products'] = count($compared_products);
    }

    if ($list_cat) {
        $list_cat = explode(',', $list_cat);
        $list_cat = array_unique($list_cat);
        $list_cat = implode(',', $list_cat);

        $sql = 'SELECT COUNT(cp.`id_product`) AS total, cp.`id_category`
					FROM `'._DB_PREFIX_.'product` p
					'.Shop::addSqlAssociation('product', 'p').'
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
					WHERE cp.`id_category` IN ('.$list_cat.')
				AND product_shop.`visibility` IN ("both", "catalog")
				AND product_shop.`active` = 1
				GROUP BY cp.`id_category`';
        $cat = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($cat) {
            $result['cat'] = $cat;
        }
    }

    if ($leo_pro_cdown) {
        $leo_pro_cdown = explode(',', $leo_pro_cdown);
        $leo_pro_cdown = array_unique($leo_pro_cdown);
        $leo_pro_cdown = implode(',', $leo_pro_cdown);
        $result['pro_cdown'] = $module->hookProductCdown($leo_pro_cdown);
    }

    if ($leo_pro_color) {
        $leo_pro_color = explode(',', $leo_pro_color);
        $leo_pro_color = array_unique($leo_pro_color);
        $leo_pro_color = implode(',', $leo_pro_color);
        $result['pro_color'] = $module->hookProductColor($leo_pro_color);
    }


    if ($leo_pro_info) {
        $leo_pro_info = explode(',', $leo_pro_info);
        $leo_pro_info = array_unique($leo_pro_info);
        $leo_pro_info = implode(',', $leo_pro_info);

        # $leocustomajax = new Leocustomajax();
        $result['pro_info'] = $module->hookProductMoreImg($leo_pro_info);
    }
    if ($leo_pro_add) {
        $leo_pro_add = explode(',', $leo_pro_add);
        $leo_pro_add = array_unique($leo_pro_add);
        $leo_pro_add = implode(',', $leo_pro_add);

        $result['pro_add'] = $module->hookProductOneImg($leo_pro_add);
    }

    if ($result) {
        die(Tools::jsonEncode($result));
    }
}
else {
    $obj = new ApProductList();
    $result = $obj->ajaxProcessRender($module);
    die(Tools::jsonEncode($result));
}
