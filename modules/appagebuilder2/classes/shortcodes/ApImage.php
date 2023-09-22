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

class ApImage extends ApShortCodeBase
{
    public $name = 'ApImage';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Image'),
            'position' => 5,
            'desc' => $this->l('Single Image'),
            'icon_class' => 'icon-image',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        Context::getContext()->smarty->assign('path_image', $this->getPathImgage());
        $href = Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&imgDir=images&is_ajax=true';
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Animations'),
                'name' => 'animation',
                'class' => 'animation-select',
                'options' => array(
                    'optiongroup' => array(
                        'label' => 'name',
                        'query' => ApPageSetting::getAnimations(),
                    ),
                    'options' => array(
                        'id' => 'id',
                        'name' => 'name',
                        'query' => 'query',
                    ),
                ),
                'form_group_class' => 'apimage_animation',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div id="animationSandbox">Prestashop.com</div>',
                'form_group_class' => 'apimage_animation animate_sub',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Delay'),
                'name' => 'animation_delay',
                'default' => '0.5',
                'suffix' => 's',
                'class' => 'fixed-width-xs',
                'form_group_class' => 'apimage_animation animate_sub',
            ),
            array(
                'label' => $this->l('Image'),
                'type' => 'selectImg',
                'href' => $href,
                'name' => 'image',
                'lang' => 'true',
            ),
            array(
                'type' => 'text',
                'name' => 'alt',
                'label' => $this->l('Alt'),
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'css_class',
                'label' => $this->l('CSS Class'),
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'url',
                'label' => $this->l('Link to'),
                'lang' => true,
                'desc' => 'Example: http://prestashop.com',
                'default' => ''
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Open new tab'),
                'name' => 'is_open',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
            ),
            array(
                'type' => 'text',
                'name' => 'width',
                'label' => $this->l('Image size width'),
                'desc' => $this->l('Example: auto, 100%, 100px'),
                'default' => '100%'
            ),
            array(
                'type' => 'text',
                'name' => 'height',
                'label' => $this->l('Image size height'),
                'desc' => $this->l('Example: auto, 100%, 100px'),
                'default' => 'auto'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Description'),
                'name' => 'description',
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'lang' => true,
                'default' => '',
                'autoload_rte' => true,
            )
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $assign['path'] = $this->getPathImgage();

        if (!isset($assign['formAtts']['animation']) || $assign['formAtts']['animation'] == 'none') {
            $assign['formAtts']['animation'] = 'none';
            $assign['formAtts']['animation_delay'] = '';
        } elseif ($assign['formAtts']['animation'] != 'none' && (int)$assign['formAtts']['animation_delay'] > 0) {
            // validate module
            $assign['formAtts']['animation_delay'] .= 's';
        } elseif ($assign['formAtts']['animation'] != 'none' && (int)$assign['formAtts']['animation_delay'] <= 0) {
            // Default delay
            $assign['formAtts']['animation_delay'] = '1s';
        }
        return $assign;
    }

    public function getPathImgage()
    {
        return __PS_BASE_URI__.'themes/'.Context::getContext()->shop->getTheme().'/img/modules/appagebuilder/images/';
    }
}
