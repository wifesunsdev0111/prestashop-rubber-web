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

class LeoWidgetManucarousel extends LeoWidgetBase
{
    public $name = 'Manucarousel';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Manufacture Logo Carousel'), 'explain' => $this->l('Create Manufacture Carousel'));
    }

    public function renderForm($args, $data)
    {
        $helper = $this->getFormHelper();
        $imagesTypes = ImageType::getImagesTypes('manufacturers');
        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Image'),
                    'desc' => $this->l('Select type image for manufacture.'),
                    'name' => 'image',
                    'default' => 'small'.'_default',
                    'options' => array(
                        'query' => $imagesTypes,
                        'id' => 'name',
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
        foreach ($arrays as $array) {
            # validate module
            $this->fields_form[1]['form']['input'][] = $array;
        }

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
            'name' => '',
            'html' => '',
        );
        $setting = array_merge($t, $setting);
        $items_page = ($setting['itemspage']) ? (int)($setting['itemspage']) : 3;
        $columns_page = ($setting['columns']) ? (int)($setting['columns']) : 3;
        $items_tab = ($setting['itemstab']) ? (int)($setting['itemstab']) : 6;
        $interval = (isset($setting['interval'])) ? (int)($setting['interval']) : 8000;
        $image_type = ($setting['image']) ? ($setting['image']) : 'small'.'_default';

        $data = Manufacturer::getManufacturers(true, Context::getContext()->language->id, true, 1, $items_tab, false);

        foreach ($data as &$item) {
            $id_images = (!file_exists(_PS_MANU_IMG_DIR_.'/'.$item['id_manufacturer'].'-'.$image_type.'.jpg')) ? Language::getIsoById(Context::getContext()->language->id).'-default' : $item['id_manufacturer'];
            $item['image'] = _THEME_MANU_DIR_.$id_images.'-'.$image_type.'.jpg';
        }

        $setting['manufacturers'] = $data;
        $setting['itemsperpage'] = $items_page;
        $setting['columnspage'] = $columns_page;
        $setting['scolumn'] = 12 / $columns_page;
        $setting['interval'] = $interval;
        $setting['tab'] = 'leomanulogocarousel'.rand(20, rand());
        $output = array('type' => 'manucarousel', 'data' => $setting);
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
                'image',
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
