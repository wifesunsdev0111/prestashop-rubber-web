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

class ApVideo extends ApShortCodeBase
{
    public $name = 'ApVideo';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Video'),
            'position' => 5,
            'desc' => $this->l('Embed video box'),
            'icon_class' => 'icon-facetime-video',
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
                'type' => 'textarea',
                'label' => $this->l('Code'),
                'name' => 'content_html',
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'default' => '',
                'desc' => 'Example embed video: "&ltdiv class="embed-responsive"&gt&ltiframe src="https://www.youtube.com/embed/iZoR21juRzs" 
						frameborder="0" allowfullscreen&gt&lt/iframe&gt&lt/div&gt"',
                'autoload_rte' => false,
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Align'),
                'name' => 'align',
                'options' => array('query' => array(
                        array('id' => 'left', 'name' => $this->l('Left')),
                        array('id' => 'center', 'name' => $this->l('Center')),
                        array('id' => 'right', 'name' => $this->l('Right'))
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'center',
            )
        );
        return $inputs;
    }
}
