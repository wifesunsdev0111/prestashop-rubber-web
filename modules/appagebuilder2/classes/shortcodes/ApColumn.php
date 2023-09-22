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

class ApColumn extends ApShortCodeBase
{
    public $name = 'ApColumn';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Column'), 'position' => 2, 'desc' => $this->l('A column can have one or more widget'),
            'tag' => 'content structure');
    }

    public function getAdditionConfig()
    {
        return array(
            array(
                'type' => '',
                'name' => 'lg',
                'default' => '12'
            ),
            array(
                'type' => '',
                'name' => 'md',
                'default' => '12'
            ),
            array(
                'type' => '',
                'name' => 'sm',
                'default' => '12'
            ),
            array(
                'type' => '',
                'name' => 'xs',
                'default' => '12'
            ),
            array(
                'type' => '',
                'name' => 'sp',
                'default' => '12'
            )
        );
    }

    public function getConfigList()
    {
        $input = array(
            array(
                'type' => 'tabConfig',
                'name' => 'title',
                'values' => array(
                    'aprow_general' => $this->l('General'),
                    'aprow_style' => $this->l('Width'),
                    'aprow_animation' => $this->l('Animation'),
                    'aprow_exceptions' => $this->l('Exceptions'))
            ),
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
                'name' => 'id',
                'label' => $this->l('ID'),
                'form_group_class' => 'aprow_general',
                'desc' => $this->l('Use for css and javascript'),
                'default' => ''
            ),
            array(
                'type' => 'ApColumnclass',
                'name' => 'class',
                'values' => '',
                'default' => '',
                'form_group_class' => 'aprow_general',
            ),
            array(
                'type' => 'column_width',
                'name' => 'width',
                'values' => '',
                'columnGrids' => ApPageSetting::getColumnGrid(),
                'form_group_class' => 'aprow_style',
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
                'form_group_class' => 'aprow_animation',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div id="animationSandbox">Prestashop.com</div>',
                'form_group_class' => 'aprow_animation animate_sub',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Delay'),
                'name' => 'animation_delay',
                'default' => '2',
                'suffix' => 's',
                'class' => 'fixed-width-xs',
                'form_group_class' => 'aprow_animation animate_sub',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Specific Controller'),
                'name' => 'specific_type',
                'class' => 'form-action',
                'options' => array(
                    'query' => array(
                        array(
                            'id' => 'all',
                            'name' => $this->l('Show on all Page Controller'),
                        ),
                        array(
                            'id' => 'index',
                            'name' => $this->l('Show on only Index'),
                        ),
                        array(
                            'id' => 'category',
                            'name' => $this->l('Show on only Category'),
                        ),
                        array(
                            'id' => 'product',
                            'name' => $this->l('Show on only Product'),
                        ),
                        array(
                            'id' => 'cms',
                            'name' => $this->l('Show on only CMS'),
                        )
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'aprow_exceptions',
                'default' => 'all'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Controller ID'),
                'name' => 'controller_id',
                'desc' => $this->l('Example: 1,2,3'),
                'default' => '',
                'form_group_class' => 'aprow_exceptions specific_type_sub specific_type-category specific_type-product specific_type-cms',
            ),
            array(
                'type' => 'apExceptions',
                'name' => 'controller_pages',
                'form_group_class' => 'aprow_exceptions specific_type_sub specific_type-all',
            ),
        );
        return $input;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
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
        $assign['formAtts']['class'] = str_replace('.', '-', $assign['formAtts']['class']);
        return $assign;
    }
}
