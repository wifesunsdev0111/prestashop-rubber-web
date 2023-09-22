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

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class ApImageGalleryProduct extends ApShortCodeBase
{
    public $name = 'ApImageGalleryProduct';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Image Gallery Product'),
            'position' => 7,
            'desc' => $this->l('Create Images Mini Gallery From Product'),
            'icon_class' => 'icon-th',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        $source = array(
            array(
                'value' => 'ip_pcategories',
                'name' => $this->l('Category')
            ),
            array(
                'value' => 'ip_pproductids',
                'name' => $this->l('Product Ids')
            )
        );
        $pimagetypes = $this->getImageTypes();
        $selected_categories = array();
        if (Tools::getIsset('categorybox')) {
            $category_box = Tools::getValue('categorybox');
            $category_box = explode(',', $category_box);
            $selected_categories = $category_box;
        }
        $id_root_category = Context::getContext()->shop->getCategory();
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'form_group_class' => 'aprow_general',
                'default' => ''
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Source'),
                'name' => 'ip_source',
                'class' => 'group form-action',
                'default' => '',
                'options' => array(
                    'query' => $source,
                    'id' => 'value',
                    'name' => 'name'
                ),
                'desc' => 'Select source type'
            ),
            array(
                'type' => 'categories',
                'label' => $this->l('Select Category'),
                'name' => 'categorybox',
                'tree' => array(
                    'root_category' => $id_root_category,
                    'use_search' => false,
                    'id' => 'categorybox',
                    'use_checkbox' => true,
                    'selected_categories' => $selected_categories,
                ),
                'form_group_class' => 'ip_source_sub ip_source-ip_pcategories'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Product Ids'),
                'form_group_class' => 'ip_source_sub ip_source-ip_pproductids',
                'name' => 'ip_pproductids',
                'default' => '',
                'desc' => $this->l('Enter Product Ids with format id1,id2,...')
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Small image'),
                'name' => 'smallimage',
                'class' => 'group',
                'id' => 'psmallimagetypes',
                'default' => '',
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
                'default' => ApPageSetting::getDefaultNameImage('thickbox'),
                'options' => array(
                    'query' => $pimagetypes,
                    'id' => 'name',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Limit'),
                'name' => 'limit',
                'default' => '12',
                'desc' => $this->l('Enter a number')
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Columns'),
                'name' => 'columns',
                'options' => array('query' => array(
                        array('id' => '1', 'name' => $this->l('1 Column')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns')),
                        array('id' => '4', 'name' => $this->l('4 Columns')),
                        array('id' => '5', 'name' => $this->l('5 Columns')),
                        array('id' => '6', 'name' => $this->l('6 Columns')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'default' => '4',
            )
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $form_atts = $assign['formAtts'];
        $limit = (int)$form_atts['limit'];
        $images = array();
        $smallimage = ($form_atts['smallimage']) ? ($form_atts['smallimage']) : ApPageSetting::getDefaultNameImage('small');
        $thickimage = ($form_atts['thickimage']) ? ($form_atts['thickimage']) : ApPageSetting::getDefaultNameImage('thickbox');
        switch ($form_atts['ip_source']) {
            case 'ip_pproductids':
                if (empty($form_atts['ip_pproductids'])) {
                    return false;
                }
                $pproductids = $form_atts['ip_pproductids'];
                if ($pproductids) {
                    $images = $this->getImagesByProductId($pproductids, 0, $limit, (int)Context::getContext()->language->id);
                }
                break;
            case 'ip_pcategories':
                $catids = (isset($form_atts['categorybox']) && $form_atts['categorybox']) ? ($form_atts['categorybox']) : array();
                if ($catids) {
                    $images = $this->getImagesByCategory($catids, 0, $limit, (int)Context::getContext()->language->id);
                }
                break;
        }
        $c = (int)$form_atts['columns'];
        $assign['columns'] = $c > 0 ? $c : 4;
        $assign['thickimage'] = $thickimage;
        $assign['smallimage'] = $smallimage;
        $assign['images'] = $images;
        return $assign;
    }

    public function getImagesByProductId($productids, $start, $limit, $id_lang)
    {
        $sql = 'SELECT DISTINCT(i.`id_image`), pl.`link_rewrite`
				FROM
					`'._DB_PREFIX_.'image` i
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON(i.`id_image` = il.`id_image`)
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON(
					i.`id_product` = pl.`id_product`)';
        $sql .= ' WHERE i.`id_product` IN ('.$productids.')
					AND il.`id_lang` ='.$id_lang.
                ' AND pl.`id_lang` ='.$id_lang.
                ' AND i.cover = 1
				ORDER BY
				i.`position` ASC'.($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '');
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        return $results;
    }

    public static function getImagesByCategory($categories, $start, $limit, $id_lang, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
        }
        $sql = 'SELECT i.`id_image`, pl.`link_rewrite`
				FROM
					`'._DB_PREFIX_.'image` i 
					INNER JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image`)
					 INNER JOIN `'._DB_PREFIX_.'product_lang` pl ON (i.`id_product` = pl.`id_product`)
					INNER JOIN `'._DB_PREFIX_.'image_shop` ish ON (i.`id_image` = ish.`id_image`)';
        $sql .= 'WHERE i.`id_product` IN (
					SELECT cp.`id_product`
					FROM `'._DB_PREFIX_.'category_product` cp
						'.(Group::isFeatureActive() ? 'INNER JOIN `'._DB_PREFIX_.'category_group` cg ON cp.`id_category` = cg.`id_category`' : '').'
						INNER JOIN `'._DB_PREFIX_.'category` c ON cp.`id_category` = c.`id_category`
						INNER JOIN `'._DB_PREFIX_.'product` p ON cp.`id_product` = p.`id_product`
						'.Shop::addSqlAssociation('product', 'p', false).'
						LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
						WHERE c.`active` = 1
						AND product_shop.`active` = 1
						'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
                .$sql_groups.' AND cp.id_category in ('.$categories.') AND pl.id_lang ='.$id_lang.')
					AND il.`id_lang` ='.$id_lang.
                ' AND pl.id_lang = '.$id_lang.
                ' AND pl.id_shop = '.$context->shop->id.
                ' AND ish.id_shop = '.$context->shop->id.
                ' AND ish.cover = 1
				ORDER BY i.`position` ASC'.($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }

    public function getImageTypes()
    {
        $pimagetypes = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT tp.id_image_type,tp.name
			FROM '._DB_PREFIX_.'image_type tp
			WHERE tp.products = 1
			ORDER BY tp.name ASC');
        return $pimagetypes;
    }
}
