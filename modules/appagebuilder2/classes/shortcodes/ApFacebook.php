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

class ApFacebook extends ApShortCodeBase
{
    public $name = 'ApFacebook';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Facebook'),
            'position' => 5,
            'desc' => $this->l('You can config Facebook Like box'),
            'icon_class' => 'icon-facebook-sign',
            'tag' => 'social');
    }

    public function getConfigList()
    {
        $soption = ApPageSetting::returnYesNo();
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
                'label' => $this->l('Page URL'),
                'name' => 'page_url',
                'class' => 'ap_facebook',
                'default' => 'https://www.facebook.com/prestashop',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Is Border'),
                'name' => 'border',
                'values' => $soption,
                'default' => '1',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Color'),
                'name' => 'target',
                'options' => array('query' => array(
                        array('id' => 'dark', 'name' => $this->l('Dark')),
                        array('id' => 'light', 'name' => $this->l('Light')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'default' => '_self',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Width'),
                'name' => 'width',
                'default' => '',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Height'),
                'name' => 'height',
                'default' => '',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Stream'),
                'name' => 'show_stream',
                'values' => $soption,
                'default' => '0',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Faces'),
                'name' => 'show_faces',
                'values' => $soption,
                'default' => '1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Header'),
                'name' => 'show_header',
                'values' => $soption,
                'default' => '0',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Show Border'),
                'name' => 'show_border',
                'values' => $soption,
                'default' => '0',
            )
        );
        return $inputs;
    }
}
