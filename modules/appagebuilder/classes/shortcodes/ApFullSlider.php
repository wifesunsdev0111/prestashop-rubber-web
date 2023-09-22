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

class ApFullSlider extends ApShortCodeBase
{
    public $name = 'ApFullSlider';

    public function getInfo()
    {
        return array('label' => $this->l('Full Slider'), 'position' => 6,
            'desc' => $this->l('You can create Inner slideshow'), 'icon_class' => 'icon icon-chevron-right',
            'tag' => 'content slider');
    }

    public function getConfigList()
    {
        $href = Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&imgDir=images&is_ajax=true';
        $ad = __PS_BASE_URI__.basename(_PS_ADMIN_DIR_);
        $iso_tiny_mce = Context::getContext()->language->iso_code;
        $iso_tiny_mce = (file_exists(_PS_JS_DIR_.'tiny_mce/langs/'.$iso_tiny_mce.'.js') ? $iso_tiny_mce : 'en');
        $list_slider = '<button type="button" id="btn-add-slider" class="btn btn-default">
				<i class="icon-plus-sign-alt"></i> '.$this->l('Add slider').'</button><hr/>';
        $list_slider_button = '<div id="frm-slider" class="hide">
							<div class="form-group">
								<div class="col-lg-12 ">
									<button type="button" class="btn btn-primary btn-save-fullslider" 
									data-error="'.$this->l('Please enter the title and description').'">'.$this->l('Save').'</button>
									<button type="button" class="btn btn-default btn-reset-fullslider">'.$this->l('Reset').'</button>
									<button type="button" class="btn btn-default btn-cancel-fullslider">'.$this->l('Cancel').'</button>
								</div>
							</div>
							<script>
								var ad = "'.$ad.'";
								var iso = "'.$iso_tiny_mce.'";
							</script>
							<hr/>
						</div>';
        $input = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'class',
                'label' => $this->l('Class'),
                'desc' => $this->l('css class cover the slider, example: container, container-fluid,...'),
                'default' => 'container'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Width slider'),
                'desc' => $this->l('Example: 100%, 1170px'),
                'name' => 'width',
                'default' => '100%'
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Height slider'),
                'name' => 'height',
                'default' => '400px',
                'desc' => $this->l('Example: 100%, 400px'),
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Interval'),
                'name' => 'interval',
                'default' => 2000,
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Display title in slider'),
                'name' => 'display_title',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Display indicators in slider'),
                'name' => 'display_indicators',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Open new tab'),
                'desc' => $this->l('Open new tab when click to link in slider'),
                'name' => 'is_open',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Next step: Add content for sliders').'</div>'
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => $list_slider
            ),
            array(
                'label' => $this->l('Image'),
                'type' => 'selectImg',
                'href' => $href,
                'name' => 'temp_image',
                'lang' => 'true',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row select-img',
            ),
            array(
                'type' => 'text',
                'name' => 'temp_title',
                'label' => $this->l('Title'),
                'lang' => 'true',
                'default' => '',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row title-slide',
            ),
            array(
                'type' => 'text',
                'name' => 'temp_link',
                'label' => $this->l('Link'),
                'lang' => 'true',
                'default' => '',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row link-slide',
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Description'),
                'name' => 'temp_descript',
                'cols' => 40,
                'rows' => 10,
                'value' => true,
                'lang' => true,
                'default' => '',
                'class' => 'item-add-slide ignore-lang',
                'form_group_class' => 'apfullslider-row description-slide',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => $list_slider_button
            ),
            array(
                'type' => 'hidden',
                'name' => 'total_slider',
                'default' => ''
            ),
        );
        return $input;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $total_slider = isset($assign['formAtts']['total_slider']) ? $assign['formAtts']['total_slider'] : '';
        $list = explode('|', $total_slider);
        $sliders = array();
        $lang = Language::getLanguage(Context::getContext()->language->id);
        $lang_default = $lang['id_lang'];
        foreach ($list as $item) {
            if ($item) {
                $temp = $item.'_'.$lang_default;
                $slider = array();
                $slider['id'] = $item;
                $slider['title'] = isset($assign['formAtts']['tit_'.$temp]) ? $assign['formAtts']['tit_'.$temp] : '';
                $slider['link'] = isset($assign['formAtts']['link_'.$temp]) ? $assign['formAtts']['link_'.$temp] : '';
                if (isset($assign['formAtts']['img_'.$temp]) && $assign['formAtts']['img_'.$temp]) {
                    // validate module
                    $slider['img'] = _THEME_IMG_DIR_.'modules/'.$this->module_name.'/images/'.$assign['formAtts']['img_'.$temp];
                } else {
                    // validate module
                    $slider['img'] = '';
                }

                $desc = isset($assign['formAtts']['descript_'.$temp]) ? $assign['formAtts']['descript_'.$temp] : '';
                $slider['descript'] = str_replace($this->str_search, $this->str_relace_html, $desc);
                //$slider['descript'] = $assign['formAtts']['descript_'.$temp];
                $sliders[] = $slider;
            }
        }
        $assign['formAtts']['is_open'] = isset($assign['formAtts']['is_open']) ? $assign['formAtts']['is_open'] : 0;
        $assign['formAtts']['slides'] = $sliders;
        return $assign;
    }
}
