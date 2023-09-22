<?php
/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
class Ets_ttn_search
{
   public static function searchProduct()
   {
        $query = trim(Tools::getValue('q', false));
        if (empty($query) || !Validate::isCleanHtml($query)) {
            die();
        }
        if(version_compare(_PS_VERSION_, '1.7', '>='))
            $type_image= ImageType::getFormattedName('small');
        else
            $type_image= ImageType::getFormatedName('small');
        //if ($pos = Tools::strpos($query, ' (ref:')) {
//            $query = Tools::substr($query, 0, $pos);
//        }
        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }
        $exclude_packs = (bool) Tools::getValue('exclude_packs', true);
        $context = Context::getContext();
        $active = (int)Tools::getValue('active') ? 1 :0;
        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
                FROM `' . _DB_PREFIX_ . 'product` p
                ' . Shop::addSqlAssociation('product', 'p') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int) $context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
                LEFT JOIN `'._DB_PREFIX_.'image` image ON (image.id_product=p.id_product)
                LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_image` = image.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $context->language->id . ')
                WHERE (p.id_product="'.(int)$query.'" OR pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\')' .
                (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
                ($active ? ' AND p.active=1':'').
                ($exclude_packs ? ' AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
                ' GROUP BY p.id_product';
        $items = Db::getInstance()->executeS($sql);
        if ($items) {
            foreach ($items as $item) {
                if(!$item['id_image'])
                    $item['id_image'] = Db::getInstance()->getValue('SELECT id_image FROM `'._DB_PREFIX_.'image` WHERE id_product='.(int)$item['id_product']);
                echo $item['id_product'].'|'.trim(str_replace('|','',$item['name'])).'|'.$item['reference'].'|'.($item['id_image'] ? str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], $type_image)):'')."\n";
            }
        }
        die();
   } 
}