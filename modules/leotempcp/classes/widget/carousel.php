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

class LeoWidgetCarousel extends LeoWidgetBase
{
    public $name = 'Carousel';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Product List Carousel'), 'explain' => $this->l('Create Products List Carousel !'));
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
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
                'title' => $this->l('Carousel Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Source'),
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
                    'label' => $this->l('Manufacturer'),
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
                    'type' => 'select',
                    'label' => $this->l('Order By'),
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
                    'label' => $this->l('Order Way'),
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
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'itemstab',
                    'default' => 6,
                    'desc' => $this->l('The maximum number of products in each Carousel (default: 6).')
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
                    'label' => $this->l('Items Per Page'),
                    'name' => 'itemspage',
                    'default' => 3,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'desc' => $this->l('The maximum number of products in each page Carousel (default: 3).')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Colums In Tab'),
                    'name' => 'columns',
                    'default' => 3,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'desc' => 'The maximum column products in each page Carousel (default: 3).'
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

        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($data),
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_language' => $default_lang
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
        $orderby = ($setting['orderby']) ? ($setting['orderby']) : 'date_add';
        $orderway = ($setting['orderway']) ? ($setting['orderway']) : 'ASC';
        $items_page = ($setting['itemspage']) ? (int)($setting['itemspage']) : 3;
        $columns_page = ($setting['columns']) ? (int)($setting['columns']) : 3;
        $interval = (isset($setting['interval'])) ? (int)($setting['interval']) : 8000;
        switch ($setting['source']) {
            case 'ptype':
                switch ($setting['ptype']) {
                    case 'newest':
                        $products = Product::getNewProducts($this->langID, 0, $nb, false, $orderby, $orderway);
                        break;
                    case 'featured':
                        $category = new Category(Context::getContext()->shop->getCategory(), $this->langID);
                        $products = $category->getProducts((int)$this->langID, 1, $nb, $orderby, $orderway);
                        break;
                    case 'bestseller':
                        $products = ProductSale::getBestSalesLight((int)$this->langID, 0, $nb);
                        break;
                    case 'special':
                        $products = Product::getPricesDrop($this->langID, 0, $nb, false, $orderby, $orderway);
                        break;
                    case 'random':
                        $random = true;
                        $products = $this->getProducts('WHERE  p.id_product > 0', (int)Context::getContext()->language->id, 1, $nb, $orderby, $orderway, false, true, $random, $nb);
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

                $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $nb, $orderby, $orderway);

                break;

            case 'pcategories':
                $where = '';
                $catids = (isset($setting['categories']) && $setting['categories']) ? ($setting['categories']) : array();
                $products = array();
                if ($catids) {
                    $categorys = implode(',', $catids);
                    $where = 'WHERE  cp.id_category IN  ('.pSQL($categorys).')';
                    $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $nb, $orderby, $orderway);
                }

                break;

            case 'pmanufacturers':
                $where = '';
                $manufacturers = ($setting['pmanufacturer']) ? ($setting['pmanufacturer']) : array();
                if ($manufacturers) {
                    $manufacturers = implode(',', $manufacturers);
                    $where = 'WHERE  p.id_manufacturer IN  ('.pSQL($manufacturers).')';
                }
                $products = $this->getProducts($where, (int)Context::getContext()->language->id, 1, $nb, $orderby, $orderway);

                break;
        }
        Context::getContext()->controller->addColorsToProductList($products);
        $setting['products'] = $products;
        $setting['itemsperpage'] = $items_page;
        $setting['columnspage'] = $columns_page;
        $setting['scolumn'] = 12 / $columns_page;
        $setting['interval'] = $interval;
        $setting['homeSize'] = Image::getSize(ImageType::getFormatedName('home'));
        $setting['tab'] = 'leoproductcarousel'.rand(20, rand());
        $output = array('type' => 'carousel', 'data' => $setting);

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
