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

class LeoWidgetMap extends LeoWidgetBase
{
    public $name = 'map';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Google Map'), 'explain' => $this->l('Create A Google Map'));
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();
        $soption = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Latitude'),
                    'name' => 'latitude',
                    'default' => 21.010904,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Longitude'),
                    'name' => 'longitude',
                    'default' => 105.787736,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Zoom'),
                    'name' => 'zoom',
                    'default' => 11,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'default' => 250,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Height'),
                    'name' => 'height',
                    'default' => 200,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Market'),
                    'name' => 'show_market',
                    'values' => $soption,
                    'default' => 1,
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

        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        # validate module
        unset($args);
        $default_country = new Country((int)Configuration::get('PS_COUNTRY_DEFAULT'));
        //Context::getContext()->controller->addJS('http'.((Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) ? 's' : '').'://maps.google.com/maps/api/js?sensor=true&amp;region='.Tools::substr($default_country->iso_code, 0, 2));
        $t = array(
            'latitude' => '21.010904',
            'longitude' => '105.787736',
            'zoom' => 11,
            'width' => 250,
            'height' => 200,
            'show_market' => 1,
            'iso_code' => Tools::substr($default_country->iso_code, 0, 2)
        );

        $setting = array_merge($t, $setting);

        $setting['height'] = $setting['height'].'px';
        $setting['width'] = $setting['width'] == '100%' ? '100%' : $setting['width'].'px';

        $output = array('type' => 'map', 'data' => $setting);

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
                'latitude',
                'longitude',
                'zoom',
                'width',
                'height',
                'show_market',
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
