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

class LeoWidgetProduct_list extends LeoWidgetBase
{
    public $name = 'product_list';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Product List'), 'explain' => $this->l('Create Products List'));
    }

    public function renderForm($args, $data)
    {
        $helper = $this->getFormHelper();
        $types = array();
        $types[] = array(
            'value' => 'newest',
            'text' => $this->l('Products Newest')
        );
        $types[] = array(
            'value' => 'bestseller',
            'text' => $this->l('Products Bestseller')
        );

        $types[] = array(
            'value' => 'special',
            'text' => $this->l('Products Special')
        );

        $types[] = array(
            'value' => 'featured',
            'text' => $this->l('Products Featured')
        );

        $types[] = array(
            'value' => 'random',
            'text' => $this->l('Products Random')
        );

        $source = array(
            array(
                'value' => 'pcategories', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Category')    // The value of the text content of the  <option> tag.
            ),
            array(
                'value' => 'ptype',
                'name' => $this->l('Product')
            ),
            array(
                'value' => 'pmanufacturers',
                'name' => $this->l('Manufacturers')
            ),
            array(
                'value' => 'pproductids',
                'name' => $this->l('Product Ids')
        ));

        $orderby = array(
            array(
                'order' => 'date_add', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Date Add')    // The value of the text content of the  <option> tag.
            ),
            array(
                'order' => 'date_upd', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Date Update')    // The value of the text content of the  <option> tag.
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
                'name' => $this->l('Ascending')    // The value of the text content of the  <option> tag.
            ),
            array(
                'orderway' => 'DESC', // The value of the 'value' attribute of the <option> tag.
                'name' => $this->l('Descending')    // The value of the text content of the  <option> tag.
            ),
        );

        $pmanufacturers = $this->getManufacturers(Context::getContext()->shop->id);
        $selected_cat = array();
        if ($data) {
            if ($data['params'] && isset($data['params']['categories']) && $data['params']['categories']) {
                $selected_cat = $data['params']['categories'];
            }
            if ($data['params'] && isset($data['params']['pmanufacturer']) && $data['params']['pmanufacturer']) {
                $data['params']['pmanufacturer[]'] = $data['params']['pmanufacturer'];
            }
        }
        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Source:'),
                    //'desc' => $this->l('The maximum number of products in each page Carousel (default: 3).'),
                    'name' => 'source',
                    'class' => 'group',
                    'default' => 'date_add',
                    'options' => array(
                        'query' => $source,
                        'id' => 'value',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'categories',
                    'label' => $this->l('Categories'),
                    'name' => 'categories',
                    'default' => '',
                    'tree' => array(
                        'id' => 'pcategories',
                        'title' => 'Categories',
                        'selected_categories' => $selected_cat,
                        'use_search' => true,
                        'use_checkbox' => true
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Products List Type'),
                    'name' => 'ptype',
                    'options' => array('query' => $types,
                        'id' => 'value',
                        'name' => 'text'),
                    'default' => 'newest',
                    'desc' => $this->l('Select a Product List Type')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Product Ids'),
                    'name' => 'pproductids',
                    'default' => '',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Manufacturer:'),
                    'name' => 'pmanufacturer[]',
                    'id' => 'pmanufacturers',
                    'default' => '',
                    'multiple' => true,
                    'options' => array(
                        'query' => $pmanufacturers,
                        'id' => 'id_manufacturer',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'limit',
                    'default' => 6,
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
            'fields_value' => $this->getConfigFieldsValues($data),
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_language' => $default_lang
        );
        unset($args);

        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        $t = array(
            'ptype' => '',
            'limit' => 12,
            'image_width' => '200',
            'image_height' => '200',
        );
        $products = array();
        $setting = array_merge($t, $setting);
        $orderby = ($setting['orderby']) ? ($setting['orderby']) : 'position';
        $orderway = ($setting['orderway']) ? ($setting['orderway']) : 'ASC';
        $plimit = ($setting['limit']) ? (int)($setting['limit']) : 6;
        switch ($setting['source']) {
            case 'ptype':
                switch ($setting['ptype']) {
                    case 'newest':
                        $products = Product::getNewProducts($this->langID, 0, $plimit, false, $orderby, $orderway);
                        break;
                    case 'featured':
                        $category = new Category(Context::getContext()->shop->getCategory(), $this->langID);
//						$nb = (int)$setting['limit'];
                        $products = $category->getProducts((int)$this->langID, 1, $plimit, $orderby, $orderway);
                        break;
                    case 'bestseller':
                        $products = ProductSale::getBestSalesLight((int)$this->langID, 0, $plimit);
                        break;
                    case 'special':
                        $products = Product::getPricesDrop($this->langID, 0, $plimit, false, $orderby, $orderway);
                        break;
                    case 'random':
                        $random = true;
                        $products = $this->getProducts('WHERE  p.id_product > 0', (int)Context::getContext()->language->id, 1, $plimit, $orderby, $orderway, false, true, $random, $plimit);
                        Configuration::updateValue('LEO_CURRENT_RANDOM_CACHE', '1');
                        break;
                }

                break;

            case 'pproductids':

                $where = '';
                if (empty($setting['pproductids'])) {
                    return false;
                }
                if ($pproductids = $setting['pproductids']) {
                    $where = 'WHERE  p.id_product IN  ('.pSQL($pproductids).')';
                }

                $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $plimit, $orderby, $orderway);

                break;

            case 'pcategories':
                $where = '';
                $catids = (isset($setting['categories']) && $setting['categories']) ? ($setting['categories']) : array();
                if ($catids) {
                    $categorys = implode(',', $catids);
                    $where = 'WHERE  cp.id_category IN  ('.pSQL($categorys).')';
                }
                $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $plimit, $orderby, $orderway);
                break;

            case 'pmanufacturers':
                $where = '';
                $manufacturers = ($setting['pmanufacturer']) ? ($setting['pmanufacturer']) : array();
                if ($manufacturers) {
                    $manufacturers = implode(',', $manufacturers);
                    $where = 'WHERE  p.id_manufacturer IN  ('.pSQL($manufacturers).')';
                }
                $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $plimit, $orderby, $orderway);

                break;
        }
        Context::getContext()->controller->addColorsToProductList($products);
        $setting['products'] = $products;
        $setting['homeSize'] = Image::getSize(ImageType::getFormatedName('home'));
        $output = array('type' => 'products', 'data' => $setting);
        unset($args);

        return $output;
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
                'source',
                'categories',
                'ptype',
                'pproductids',
                'limit',
                'orderby',
                'orderway',
            );
        } elseif ($multi_lang == 1) {
            return array(
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
