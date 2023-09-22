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

class LeoWidgetTwitter extends LeoWidgetBase
{
    public $name = 'twitter';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Twitter Widget'), 'explain' => 'Get Latest Twitter TimeLife');
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
                    'label' => $this->l('Twitter'),
                    'name' => 'twidget_id',
                    'default' => '578806287158251521',
                    'desc' => 'Please go to the page https://twitter.com/settings/widgets/new, then create a widget, and get data-widget-id to input in this param.'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Count'),
                    'name' => 'count',
                    'default' => 2,
                    'desc' => 'If the param is empty or equal 0, the widget will show scrollbar when more items. Or you can input number from 1-20. Default NULL.'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('User'),
                    'name' => 'username',
                    'default' => 'prestashop',
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Border Color'),
                    'name' => 'border_color',
                    'default' => '#000',
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Link Color'),
                    'name' => 'link_color',
                    'default' => '#000',
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Text Color'),
                    'name' => 'text_color',
                    'default' => '#000',
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Name Color'),
                    'name' => 'name_color',
                    'default' => '#000',
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Nick name Color'),
                    'name' => 'mail_color',
                    'default' => '#000',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'default' => 180,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Height'),
                    'name' => 'height',
                    'default' => 200,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show background'),
                    'name' => 'transparent',
                    'values' => $soption,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Replies'),
                    'name' => 'show_replies',
                    'values' => $soption,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Header'),
                    'name' => 'show_header',
                    'values' => $soption,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Footer'),
                    'name' => 'show_footer',
                    'values' => $soption,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Border'),
                    'name' => 'show_border',
                    'values' => $soption,
                    'default' => 0,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Scrollbar'),
                    'name' => 'show_scrollbar',
                    'values' => $soption,
                    'default' => 0,
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
        $t = array(
            'name' => '',
            'twidget_id' => '578806287158251521',
            'count' => 2,
            'username' => 'prestashop',
            'theme' => 'light',
            'border_color' => '#000',
            'link_color' => '#000',
            'text_color' => '#000',
            'name_color' => '#000',
            'mail_color' => '#000',
            'width' => 180,
            'height' => 200,
            'show_replies' => 0,
            'show_header' => 0,
            'show_footer' => 0,
            'show_border' => 0,
            'show_scrollbar' => 0,
            'transparent' => 0,
        );

        $setting = array_merge($t, $setting);

        $setting['chrome'] = '';

        if (isset($setting['show_header']) && $setting['show_header'] == 0) {
            $setting['chrome'] .= 'noheader ';
        }
        if ($setting['show_footer'] == 0) {
            $setting['chrome'] .= 'nofooter ';
        }
        if ($setting['show_border'] == 0) {
            $setting['chrome'] .= 'noborders ';
        }

        if ($setting['transparent'] == 0) {
            $setting['chrome'] .= 'transparent';
        }
        $setting['iso_code'] = Context::getContext()->language->iso_code;
        $setting['js'] = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
        $output = array('type' => 'twitter', 'data' => $setting);
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
                'twidget_id',
                'count',
                'username',
                'border_color',
                'link_color',
                'text_color',
                'name_color',
                'mail_color',
                'width',
                'height',
                'transparent',
                'show_replies',
                'show_header',
                'show_footer',
                'show_border',
                'show_scrollbar',
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
