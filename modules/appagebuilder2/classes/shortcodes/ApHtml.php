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

class ApHtml extends ApShortCodeBase
{
    public $name = 'ApHtml';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Html'), 'position' => 3, 'desc' => $this->l('You can put html'),
            'icon_class' => 'icon-html5', 'tag' => 'content structure');
    }

    public function getConfigList()
    {
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'lang' => 'true',
                'default' => '',
            ),
            array(
                'type' => 'textarea',
                'name' => 'content_html',
                'class' => 'ap_html',
                'rows' => '50',
                'lang' => true,
                'label' => $this->l('Html'),
                'values' => '',
                'autoload_rte' => true,
                'default' => "<div>\n</div>"
            ),
        );
        return $inputs;
    }
}
