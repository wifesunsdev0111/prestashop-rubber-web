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

class LeoWidgetCustomerCarousel extends LeoWidgetBase
{
    public $name = 'customercarousel';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Customer HTML Carousel'), 'explain' => $this->l('Create Customer HTML Carousel'));
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form'),
            ),
            'input' => array(
                array(
                    'type' => 'radio',
                    'label' => $this->l('Show Button Controls'),
                    'name' => 'show_controls',
                    'default' => '',
                    'values' => array(
                        array(
                            'id' => 'no',
                            'value' => false,
                            'label' => $this->l('No')
                        ),
                        array(
                            'id' => 'yes',
                            'value' => true,
                            'label' => $this->l('Yes')
                        ),
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Start Slide'),
                    'name' => 'startSlide',
                    'default' => 0
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Number of Customer HTML'),
                    'name' => 'nbcusthtml',
                    'default' => 5,
                    'desc' => 'Enter a number greater 0'
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
                    'label' => $this->l('Interval'),
                    'name' => 'interval',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'default' => 4000
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Auto Play'),
                    'name' => 'auto_play',
                    'default' => '',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.LeomanagewidgetsOwlCarousel::CAROUSEL_BOOTSTRAP,
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => false,
                                'name' => $this->l('No')
                            ),
                            array(
                                'id' => true,
                                'name' => $this->l('Yes')
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                //'hint' => $this->l('Out-of-range behavior occurs when none is defined (e.g. when a customer\'s cart weight is greater than the highest range limit).')
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
        if (!isset($data['params']['nbcusthtml']) || !$data['params']['nbcusthtml']) {
            $nbcusthtml = 5;
        } else {
            $nbcusthtml = $data['params']['nbcusthtml'];
        }
        for ($i = 1; $i <= $nbcusthtml; $i++) {
            $tmpArray = array(
                'type' => 'text',
                'label' => $this->l('Title '.$i),
                'name' => 'title_'.$i,
                'default' => 'Title Sample '.$i,
                'lang' => true
            );
            $this->fields_form[1]['form']['input'][] = $tmpArray;
            $tmpArray = array(
                'type' => 'text',
                'label' => $this->l('Header '.$i),
                'name' => 'header_'.$i,
                'default' => 'Header Sample '.$i,
                'lang' => true
            );
            $this->fields_form[1]['form']['input'][] = $tmpArray;
            $tmpArray = array(
                'type' => 'textarea',
                'label' => $this->l('Content '.$i),
                'name' => 'content_'.$i,
                'default' => 'Content Sample '.$i,
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'lang' => true,
                'autoload_rte' => true,
                'desc' => $this->l('Enter Content '.$i)
            );
            $this->fields_form[1]['form']['input'][] = $tmpArray;
        }

        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($data),
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_language' => $default_lang
        );
        // echo "<pre>";print_r($nbcusthtml);die;
        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        # validate module
        unset($args);
        $header = '';
        $content = '';

        $cs = array();
        $languageID = Context::getContext()->language->id;
        for ($i = 1; $i <= $setting['nbcusthtml']; $i++) {
            $title = isset($setting['title_'.$i.'_'.$languageID]) ? $setting['title_'.$i.'_'.$languageID] : '';
            $header = isset($setting['header_'.$i.'_'.$languageID]) ? $setting['header_'.$i.'_'.$languageID] : '';

            if (!empty($header) && !empty($title)) {
                $content = isset($setting['content_'.$i.'_'.$languageID]) ? Tools::stripslashes($setting['content_'.$i.'_'.$languageID]) : '';
                $cs[] = array('title' => trim($title), 'header' => trim($header), 'content' => trim($content));
            }
        }
        if ($setting['auto_play']) {
            $setting['interval'] = (isset($setting['interval'])) ? (int)($setting['interval']) : 4000;
        } else {
            $setting['interval'] = 'false';
        }
        $setting['startSlide'] = ($setting['startSlide']) ? $setting['startSlide'] : '0';
        $setting['customercarousel'] = $cs;
        $setting['id'] = rand() + count($cs);
        $setting['random_number'] = rand(20, rand());

        $output = array('type' => 'customercarousel', 'data' => $setting);
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
                'show_controls',
                'startSlide',
                'nbcusthtml',
                'carousel_type',
                'interval',
                'auto_play',
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
            $number_html = Tools::getValue('nbcusthtml');
            $array = array();
            for ($i = 1; $i <= $number_html; $i++) {
                $array[] = 'title_'.$i;
                $array[] = 'header_'.$i;
                $array[] = 'content_'.$i;
            }
            return $array;
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
