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

class ApFontAwesome extends ApShortCodeBase
{
    public $name = 'ApFontAwesome';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Font Awesome'),
            'position' => 5,
            'desc' => $this->l('Add a font Awesome'),
            'icon_class' => 'icon icon-font',
            'tag' => 'content control');
    }

    public function getConfigList()
    {
        $rotate = array(
            array(
                'value' => 'normal',
                'text' => $this->l('Normal')
            ),
            array(
                'value' => 'icon-rotate-90',
                'text' => $this->l('Rotate Left')
            ),
            array(
                'value' => 'icon-rotate-180',
                'text' => $this->l('Rotate Inverser')
            ),
            array(
                'value' => 'icon-rotate-270',
                'text' => $this->l('Rotate Right')
            ),
            array(
                'value' => 'icon-flip-horizontal',
                'text' => $this->l('Flip Horizontal')
            ),
            array(
                'value' => 'icon-flip-vertical',
                'text' => $this->l('Flip Vertical')
            ),
        );
        $sizes = array(
            array(
                'value' => 'size-default',
                'text' => $this->l('Size Default')
            ),
            array(
                'value' => 'icon-large',
                'text' => $this->l('Size Large')
            ),
            array(
                'value' => 'icon-2x',
                'text' => $this->l('Size 2x')
            ),
            array(
                'value' => 'icon-3x',
                'text' => $this->l('Size 3x')
            ),
            array(
                'value' => 'icon-4x',
                'text' => $this->l('Size 4x')
            )
        );
        $default_font = Tools::getIsset('font_name') ? Tools::getValue('font_name') : 'icon-font';
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
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<input type="text" name="font_name" id="font_name" value="'.$default_font.
                '"/><div class="box-list-font-awesome">'.$this->renderListFont($default_font).'</div>'
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<hr/><div class="preview-widget"><i class="icon '.$default_font.
                '" data-default="'.$default_font.'"></i></div>'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Font Rotate'),
                'name' => 'font_type',
                'options' => array('query' => $rotate,
                    'id' => 'value',
                    'name' => 'text'),
                'default' => '',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Font Size'),
                'name' => 'font_size',
                'options' => array('query' => $sizes,
                    'id' => 'value',
                    'name' => 'text'),
                'default' => 'size-default',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Is Spin'),
                'name' => 'is_spin',
                'options' => array('query' => array(
                        array('value' => '', 'text' => $this->l('No spin')),
                        array('value' => 'icon-spin', 'text' => $this->l('Spin')),
                    ),
                    'id' => 'value',
                    'name' => 'text'),
                'default' => 'btn-lg',
            ),
        );
        return $inputs;
    }

    public function renderListFont($default = 'icon-font')
    {
        $list = ApPageSetting::listFontAwesome();
        $result = '';
        foreach ($list as $item) {
            $cls = '';
            if ($default === $item['value']) {
                $cls = 'selected';
            }
            $result .= '<li class="'.$cls.'"><i class="icon '.$item['value'].'" data-default="'.$item['value'].'"></i>';
        }
        return "<ul class='list-font-awesome'>$result</ul>";
    }
}
