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

class ApTwitter extends ApShortCodeBase
{
    public $name = 'ApTwitter';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Twitter'),
            'position' => 6,
            'desc' => $this->l('You can config for display Twitter box'),
            'icon_class' => 'icon-twitter-sign',
            'tag' => 'social');
    }

    public function getConfigList()
    {
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
                'type' => 'text',
                'label' => $this->l('Twitter'),
                'name' => 'twidget_id',
                'default' => '578806287158251521',
                'desc' => 'Please go to the page https://twitter.com/settings/widgets/new, 
						then create a widget, and get data-widget-id to input in this param.'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Count'),
                'name' => 'count',
                'default' => 2,
                'desc' => 'If the param is empty or equal 0, the widget will show 
						scrollbar when more items. Or you can input number from 1-20. Default NULL.'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('User'),
                'name' => 'username',
                'default' => 'prestashop',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/jquery.colorpicker.js"></script>',
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
                'values' => ApPageSetting::returnYesNo(),
                'default' => 0,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Replies'),
                'name' => 'show_replies',
                'values' => ApPageSetting::returnYesNo(),
                'default' => 0,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Header'),
                'name' => 'show_header',
                'values' => ApPageSetting::returnYesNo(),
                'default' => 0,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Footer'),
                'name' => 'show_footer',
                'values' => ApPageSetting::returnYesNo(),
                'default' => 0,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Border'),
                'name' => 'show_border',
                'values' => ApPageSetting::returnYesNo(),
                'default' => 0,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Scrollbar'),
                'name' => 'show_scrollbar',
                'values' => ApPageSetting::returnYesNo()
            )
        );
        return $inputs;
    }
}
