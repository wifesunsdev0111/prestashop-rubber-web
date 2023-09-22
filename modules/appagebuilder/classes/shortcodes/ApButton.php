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

class ApButton extends ApShortCodeBase
{
    public $name = 'ApButton';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Buttons'),
            'position' => 5,
            'desc' => $this->l('Custom color, size and create a link for button'),
            'icon_class' => 'icon-edit',
            'tag' => 'content control');
    }

    public function getConfigList()
    {
        $types = array(
            array(
                'value' => 'btn-default',
                'text' => $this->l('Button Default')
            ),
            array(
                'value' => 'btn-primary',
                'text' => $this->l('Button Primary')
            ),
            array(
                'value' => 'btn-success',
                'text' => $this->l('Button Success')
            ),
            array(
                'value' => 'btn-info',
                'text' => $this->l('Button Info')
            ),
            array(
                'value' => 'btn-warning',
                'text' => $this->l('Button Warning')
            ),
            array(
                'value' => 'btn-danger',
                'text' => $this->l('Alert Danger')
            )
        );
        $sizes = array(
            array(
                'value' => 'size-default',
                'text' => $this->l('Size Default')
            ),
            array(
                'value' => 'btn-lg',
                'text' => $this->l('Size Large')
            ),
            array(
                'value' => 'btn-sm',
                'text' => $this->l('Size Small')
            ),
            array(
                'value' => 'btn-xs',
                'text' => $this->l('Size Extra Small')
            )
        );
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
                'name' => 'name',
                'label' => $this->l('Name'),
                'lang' => 'true',
                'form_group_class' => 'aprow_general',
                'default' => 'Button'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Button Type'),
                'name' => 'button_type',
                'options' => array('query' => $types,
                    'id' => 'value',
                    'name' => 'text'),
                'default' => '1',
                'desc' => $this->l('Select a button type')
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Button Size'),
                'name' => 'button_size',
                'options' => array('query' => $sizes,
                    'id' => 'value',
                    'name' => 'text'),
                'default' => 'btn-lg',
                'desc' => $this->l('Select a button size')
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Is Block'),
                'name' => 'is_block',
                'desc' => $this->l('If is block, will display width is full 100%'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0'
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<hr/>'
            ),
            array(
                'type' => 'text',
                'name' => 'class',
                'label' => $this->l('Class'),
                'desc' => $this->l('This vaule is use for css code'),
                'default' => ''
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => $this->l('You can add code in ').'<a href="'.self::getUrlProfileEdit().'" target="_blank">here</a>'
            ),
            array(
                'type' => 'text',
                'name' => 'url',
                'label' => $this->l('Url'),
                'desc' => $this->l('Exmaple: http://prestashop.com'),
                'default' => ''
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Open new window'),
                'name' => 'is_blank',
                'desc' => $this->l('If is Yes, will open new tab with url when click'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0'
            ),
        );
        return $inputs;
    }
}
