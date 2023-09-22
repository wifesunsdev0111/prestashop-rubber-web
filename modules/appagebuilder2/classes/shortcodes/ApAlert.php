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

class ApAlert extends ApShortCodeBase
{
    public $name = 'ApAlert';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Alert'),
            'position' => 5,
            'desc' => $this->l('Alert Message box'),
            'icon_class' => 'icon-info-sign',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        $types = array(
            array(
                'value' => 'alert-success',
                'text' => $this->l('Alert Success')
            ),
            array(
                'value' => 'alert-info',
                'text' => $this->l('Alert Info')
            ),
            array(
                'value' => 'alert-warning',
                'text' => $this->l('Alert Warning')
            ),
            array(
                'value' => 'alert-danger',
                'text' => $this->l('Alert Danger')
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
                'type' => 'textarea',
                'lang' => true,
                'label' => $this->l('Content'),
                'name' => 'content_html',
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'lang' => true,
                'default' => '',
                'autoload_rte' => true,
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Alert Type'),
                'name' => 'alert_type',
                'options' => array('query' => $types,
                    'id' => 'value',
                    'name' => 'text'),
                'default' => '1',
                'desc' => $this->l('Select a alert style')
            )
        );
        return $inputs;
    }
}
