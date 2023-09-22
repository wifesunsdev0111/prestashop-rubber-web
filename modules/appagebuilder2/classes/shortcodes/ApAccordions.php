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

class ApAccordions extends ApShortCodeBase
{
    public $name = 'ApAccordions';

    public function getInfo()
    {
        return array('label' => $this->l('Accordions'),
            'position' => 5, 'desc' => $this->l('You can put widget in accordions'),
            'icon_class' => 'icon icon-align-justify',
            'tag' => 'content');
    }

    public function getConfigList($sub_tab = 0)
    {
        if (Tools::getIsset('subTab') || $sub_tab) {
            $input = array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'label' => $this->l('Title'),
                    'lang' => 'true',
                    'values' => '',
                ),
                array(
                    'type' => 'text',
                    'name' => 'id',
                    'label' => $this->l('ID Accordion'),
                    'values' => ''
                )
            );
            $this->name = 'ApSubAccordion';
        } else {
            $input = array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'label' => $this->l('Title'),
                    'lang' => 'true',
                    'default' => '',
                ),
                array(
                    'type' => 'text',
                    'name' => 'class',
                    'label' => $this->l('Class'),
                    'default' => '',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Accordion Type'),
                    'name' => 'accordion_type',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'vertical',
                                'name' => $this->l('Vertical'),
                            ),
                            array(
                                'id' => 'horizontal',
                                'name' => $this->l('Horizontal'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Showing Type'),
                    'name' => 'active_type',
                    'class' => 'form-action',
                    'default' => 'hideall',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'set',
                                'name' => $this->l('Set active'),
                            ),
                            array(
                                'id' => 'showall',
                                'name' => $this->l('Show all'),
                            ),
                            array(
                                'id' => 'hideall',
                                'name' => $this->l('Hide all'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'text',
                    'name' => 'active_accordion',
                    'label' => $this->l('Active Accordion'),
                    'default' => '1',
                    'form_group_class' => 'active_type_sub active_type-set',
                ),
            );
        }
        return $input;
    }

    /**
     * overide in tabs module
     */
    public function adminContent($atts, $content = null, $tag_name = null, $is_gen_html = null)
    {
        $this->preparaAdminContent($atts, $tag_name);
        if ($is_gen_html) {
            $assign = array();
            $w_info = $this->getInfo();
            $w_info['name'] = $this->name;
            if ($tag_name == 'ApAccordion') {
                $assign['isSubTab'] = 1;
                $w_info['name'] = 'ApAccordion';
            } else {
                preg_match_all('/ parent_id="([^\"]+)"{0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE);
                if (isset($matches['1']['0']['0'])) {
                    $atts['id'] = $matches['1']['0']['0'];
                }
            }
            $assign['formAtts'] = $atts;
            $assign['apInfo'] = $w_info;
            $assign['apContent'] = ApShortCodesBuilder::doShortcode($content);
            $controller = new AdminApPageBuilderShortcodesController();
            return $controller->adminContent($assign, $this->name.'.tpl');
        } else {
            ApShortCodesBuilder::doShortcode($content);
        }
    }

    /**
     * overide in tabs module
     */
    public function fontContent($atts, $content = null, $tag_name = null, $is_gen_html = null)
    {
        foreach ($atts as $key => $val) {
            if (strpos($key, 'content') !== false || strpos($key, 'link') !== false || strpos($key, 'url') !== false || strpos($key, 'alt') !== false || strpos($key, 'tit') !== false || strpos($key, 'name') !== false || strpos($key, 'desc') !== false || strpos($key, 'itemscustom') !== false) {
                $atts[$key] = str_replace($this->str_search, $this->str_relace_html, $val);
                if (strpos($atts[$key], '_AP_IMG_DIR') !== false) {
                    // validate module
                    $atts[$key] = str_replace('_AP_IMG_DIR/', $this->theme_img_module, $atts[$key]);
                }
            }
        }
        // validate module
        unset($is_gen_html);
        $assign = $w_info = array();
        $w_info['name'] = $this->name;
        if ($tag_name == 'ApAccordion') {
            $assign['isSubTab'] = 1;
            $w_info['name'] = 'ApAccordion';
        } else {
            preg_match_all('/ parent_id="([^\"]+)"{0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE);
            if (isset($matches['1']['0']['0'])) {
                $atts['id'] = $matches['1']['0']['0'];
            }
            if (!isset($atts['active_accordion'])) {
                $active_tab = 0;
            }
            else {
                $active_tab = (int)$atts['active_accordion'] - 1;
            }
            $atts['active_accordion'] = $active_tab;
        }
        $content = ApShortCodesBuilder::doShortcode($content);
        $assign['apContent'] = $content;
        $assign['formAtts'] = $atts;
        $module = new APPageBuilder();
        return $module->fontContent($assign, $this->name.'.tpl');
    }
}
