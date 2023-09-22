<?php

/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2018 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
class AdminAjaxPsAgeCheckerController extends \ModuleAdminController
{
    /**
     * ajaxProcessGetCategories
     * Return all categories of the shop
     *
     * @return string
     */
    public function ajaxProcessGetCategories()
    {
        $currentIdLang = $this->context->language->id;
        $categories = \Category::getCategories($currentIdLang);
        $cleanedCategories = array();

        $rootCategory = \Configuration::get('PS_ROOT_CATEGORY');
        $homeCategory = \Configuration::get('PS_HOME_CATEGORY');

        foreach ($categories as $category) {
            $currentCat = current($category);
            if ($currentCat['infos']['id_category'] === $rootCategory
                || $currentCat['infos']['id_category'] === $homeCategory
            ) {
                continue;
            }

            foreach ($category as $cat) {
                $cleanedCategories[$cat['infos']['id_parent']][] = array(
                    'id' => $cat['infos']['id_category'],
                    'id_parent' => $cat['infos']['id_parent'],
                    'name' => $cat['infos']['name'],
                );
            }
        }

        $this->ajaxDie(json_encode($cleanedCategories));
    }

    /**
     * ajaxProcessGetProductsByNameLike
     * Return all products with the term in the name or reference
     *
     * @return string
     */
    public function ajaxProcessGetProductsByNameLike()
    {
        $currentIdLang = $this->context->language->id;
        $searchTerm = \Tools::getValue('searchTerm');
        $results = \Product::searchByName($currentIdLang, $searchTerm);

        foreach ($results as $key => $result) {
            $products = new \PrestaShopCollection('Product', $currentIdLang);
            $products->where('id_product', '=', $result['id_product']);
            /** @var \Product $product */
            $product = $products->getFirst();
            $idImage = $product->getCover($result['id_product']);
            $link = new \Link();
            $imgLink = \Tools::getProtocol() . $link->getImageLink($product->link_rewrite, $idImage['id_image'], ImageType::getFormatedName('large'));

            $results[$key]['imgLink'] = $imgLink;
        }

        $this->ajaxDie(json_encode($results));
    }
}
