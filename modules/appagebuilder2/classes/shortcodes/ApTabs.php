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

class ApTabs extends ApShortCodeBase
{
    public $name = 'ApTabs';

    public function getInfo()
    {
        return array('label' => $this->l('Tabs'), 'position' => 4,
            'desc' => $this->l('You can put widget in tab'),
            'icon_class' => 'icon-html5', 'tag' => 'content');
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
                    'label' => $this->l('ID Tab'),
                    'values' => '',
                ),
                array(
                    'type' => 'text',
                    'name' => 'css_class',
                    'label' => $this->l('CSS Class'),
                    'values' => '',
                ),
            );
            $this->name = 'ap_sub_tabs';
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
                    'label' => $this->l('Select Type'),
                    'name' => 'tab_type',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'tabs-top',
                                'name' => $this->l('Tabs Top'),
                            ),
                            array(
                                'id' => 'tabs-below',
                                'name' => $this->l('Tabs below'),
                            ),
                            array(
                                'id' => 'tabs-left',
                                'name' => $this->l('Tabs Left'),
                            ),
                            array(
                                'id' => 'tabs-right',
                                'name' => $this->l('Tabs Right'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Is toggle tab'),
                    'name' => 'is_toggle',
                    'is_bool' => true,
                    'desc' => $this->l('To make tab is toggle when click'),
                    'values' => ApPageSetting::returnYesNo(),
                ),
                array(
                    'type' => 'text',
                    'name' => 'active_tab',
                    'label' => $this->l('Active Tab'),
                    'default' => '1',
                    'desc' => $this->l('input a number, if "Is toggle tab" is Yes and enter is blank, all tab default is inactive;
							else is No and enter is blank, default will first tab is active'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Use Fade effect'),
                    'name' => 'fade_effect',
                    'is_bool' => true,
                    'desc' => $this->l('To make tabs fade in.'),
                    'values' => ApPageSetting::returnYesNo(),
                )
            );
        }
        return $input;
    }

    /**
     * Overide in tabs module
     * @param type $atts
     * @param type $content
     * @param type $tag_name
     * @param type $is_gen_html
     * @return type
     */
    public function adminContent($atts, $content = null, $tag_name = null, $is_gen_html = null)
    {
        $this->preparaAdminContent($atts, $tag_name);
        if ($is_gen_html) {
            $assign = array();
            $assign['formAtts'] = $atts;
            $w_info = $this->getInfo();
            $w_info['name'] = $this->name;
            $assign['apInfo'] = $w_info;
            if ($tag_name == 'ApTab') {
                $assign['tabID'] = $atts['id'];
                $assign['isSubTab'] = 1;
                $w_info['name'] = 'ApTab';
            } else {
                preg_match_all('/ApTab form_id="([^\"]+)" id\=\"([^\"]+)\" css_class\=\"([^\"]+){0,1}\" title\=\"([^\"]+)\"{0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE);
                $sub_tab_content = array();
                $len = count($matches[0]);
                for ($i = 0; $i < $len; $i++) {
                    $title = $matches[4][$i][0];
                    $title = str_replace($this->str_search, $this->str_relace_html, $title);
                    $form_id = $matches[1][$i][0];
                    $sub_tab_content[$form_id] = array(
                        'form_id' => $form_id,
                        'id' => $matches[2][$i][0],
                        'css_class' => $matches[3][$i][0],
                        'title' => $title,
                    );
                }
                // validate module
                $pattern = '/ApTab form_id="([^\"]+)" id\=\"([^\"]+)\" css_class\=\"([^\"]+){0,1}\" ';
                $pattern .= 'override_folder\=\"([^\"]+){0,1}\" title\=\"([^\"]+)\"{0,1}/i';
                preg_match_all($pattern, $content, $matches2, PREG_OFFSET_CAPTURE);
                $sub_tab_content2 = array();
                $len2 = count($matches2[0]);
                for ($i = 0; $i < $len2; $i++) {
                    $title2 = $matches2[5][$i][0];
                    $title2 = str_replace($this->str_search, $this->str_relace_html, $title2);
                    $form_id2 = $matches2[1][$i][0];
                    $sub_tab_content2[$form_id2] = array(
                        'form_id' => $form_id2,
                        'id' => $matches2[2][$i][0],
                        'css_class' => $matches2[3][$i][0],
                        'title' => $title2,
                    );
                }
                $assign['subTabContent'] = array_merge($sub_tab_content, $sub_tab_content2);
            }
            $assign['apContent'] = ApShortCodesBuilder::doShortcode($content);
            $controller = new AdminApPageBuilderShortcodesController();
            return $controller->adminContent($assign, $this->name.'.tpl');
        } else {
            ApShortCodesBuilder::doShortcode($content);
        }
        //preg_match_all( '/ap_tab id="([^\"]+)"(\id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
    }

    /**
     * Overide in tabs module
     * @param type $atts
     * @param type $content
     * @param type $tag_name
     * @param type $is_gen_html
     * @return type
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
        $assign = array();
        if ($tag_name == 'ApTab') {
            $assign['tabID'] = $atts['id'];
            $assign['isSubTab'] = 1;
        } else {
            preg_match_all('/ApTab form_id="([^\"]+)" id\=\"([^\"]+)\" css_class\=\"([^\"]+){0,1}\" title\=\"([^\"]+)\"{0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE);
            $sub_tab_content = array();
            $len = count($matches[0]);
            for ($i = 0; $i < $len; $i++) {
                $title = $matches[4][$i][0];
                $title = str_replace($this->str_search, $this->str_relace_html, $title);
                $sub_tab_content[] = array(
                    'form_id' => $matches[1][$i][0],
                    'id' => $matches[2][$i][0],
                    'css_class' => $matches[3][$i][0],
                    'title' => $title,
                );
            }
            // validate module
            $pattern = '/ApTab form_id="([^\"]+)" id\=\"([^\"]+)\" css_class\=\"([^\"]+){0,1}\" ';
            $pattern .= 'override_folder\=\"([^\"]+){0,1}\" title\=\"([^\"]+)\"{0,1}/i';
            preg_match_all($pattern, $content, $matches2, PREG_OFFSET_CAPTURE);
            $sub_tab_content2 = array();
            $len2 = count($matches2[0]);
            for ($i = 0; $i < $len2; $i++) {
                $title2 = $matches2[5][$i][0];
                $title2 = str_replace($this->str_search, $this->str_relace_html, $title2);
                $form_id2 = $matches2[1][$i][0];
                $sub_tab_content2[$form_id2] = array(
                    'form_id' => $form_id2,
                    'id' => $matches2[2][$i][0],
                    'css_class' => $matches2[3][$i][0],
                    'title' => $title2,
                );
            }
            if (isset($atts['active_tab']) && $atts['active_tab']) {
                if ((int)$atts['active_tab'] <= count($matches2) && (int)$atts['active_tab'] >= 1) {
                    $active_tab = (int)$atts['active_tab'];
                    $atts['active_tab'] = $active_tab - 1;
                } else {
                    $atts['active_tab'] = 0;
                }
            } else {
                $atts['active_tab'] = -1;
            }
            $assign['subTabContent'] = array_merge($sub_tab_content, $sub_tab_content2);
            $atts['id'] = 'tab_'.ApPageSetting::getRandomNumber();
            $atts['class'] = ((isset($atts['class']) && $atts['class']) ? $atts['class'].' ' : '').(isset($atts['tab_type']) ? $atts['tab_type'] : '');
        }
        $assign['formAtts'] = $atts;
        $assign['apContent'] = ApShortCodesBuilder::doShortcode($content);
        $module = new APPageBuilder();
        return $module->fontContent($assign, $this->name.'.tpl');
    }

    /**
     * @Override
     * Fixed css_class is empty -> cant set to $apHomeBuilder.process (json) in javascript
     */
    public function preparaAdminContent($atts, $tag_name = null)
    {
        if ($tag_name == null) {
            $tag_name = $this->name;
        }
        if (is_array($atts)) {
            if (!isset(ApShortCodesBuilder::$shortcode_lang[$tag_name])) {
                $inputs = $this->getConfigList();
                $lang_field = array();
                foreach ($inputs as $input) {
                    if (isset($input['lang']) && $input['lang']) {
                        $lang_field[] = $input['name'];
                    }
                }
                ApShortCodesBuilder::$shortcode_lang[$tag_name] = $lang_field;
            } else {
                $lang_field = ApShortCodesBuilder::$shortcode_lang[$tag_name];
            }
            foreach ($atts as $key => $val) {
                if ($lang_field && in_array($key, $lang_field)) {
                    $key .= '_'.ApShortCodesBuilder::$lang_id;
                }
                if (!isset(ApShortCodesBuilder::$data_form[$atts['form_id']][$key])) {
                    ApShortCodesBuilder::$data_form[$atts['form_id']][$key] = $val;
                }
            }
        }
    }
}
