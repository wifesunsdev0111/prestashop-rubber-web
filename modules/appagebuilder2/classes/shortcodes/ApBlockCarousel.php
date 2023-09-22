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

class ApBlockCarousel extends ApShortCodeBase
{
    public $name = 'ApBlockCarousel';

    public function getInfo()
    {
        return array('label' => $this->l('Block Carousel'), 'position' => 6,
            'desc' => $this->l('Show block in Carousel'),
            'icon_class' => 'icon icon-chevron-right',
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
									<button type="button" class="btn btn-primary btn-save-slider" 
									data-error="'.$this->l('Please enter the title and description').'">'.$this->l('Save').'</button>
									<button type="button" class="btn btn-default btn-reset-slider">'.$this->l('Reset').'</button>
									<button type="button" class="btn btn-default btn-cancel-slider">'.$this->l('Cancel').'</button>
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
                'name' => 'description',
                'label' => $this->l('Description'),
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
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 1: Select type').'</div>'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Carousel Type'),
                'class' => 'form-action',
                'name' => 'carousel_type',
                'options' => array(
                    'query' => array(
                        array('id' => 'boostrap', 'name' => $this->l('Bootstrap')),
                        array('id' => 'owlcarousel', 'name' => $this->l('Owl Carousel')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'boostrap'
            ),
            //Owl Carousel begin
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="space">'.$this->l('Items per Row').'</div>',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'items',
                'label' => $this->l('Items'),
                'desc' => $this->l('This variable allows you to set the maximum amount 
						of items displayed at a time with the widest browser width'),
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
                'default' => '5',
            ),
            array(
                'type' => 'text',
                'name' => 'itemsdesktop',
                'label' => $this->l('ItemsDesktop (~1199)'),
                'desc' => $this->l('This allows you to preset the number of slides visible with ItemsDesktop (1199)'),
                'default' => '4',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itemsdesktopsmall',
                'label' => $this->l('ItemsDesktopSmall (~979)'),
                'desc' => $this->l('This allows you to preset the number of slides visible with itemsDesktopSmall (~979px)'),
                'default' => '3',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itemstablet',
                'label' => $this->l('ItemsTablet (~768)'),
                'desc' => $this->l('This allows you to preset the number of slides visible with itemsTablet (768)'),
                'default' => '2',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itemsmobile',
                'label' => $this->l('Number Item per Line (~479)'),
                'desc' => $this->l('This allows you to preset the number of slides visible with itemsmobile (479)'),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itemscustom',
                'label' => $this->l('ItemsCustom'),
                'desc' => $this->l('(Advance User) Example: [[0, 2], [400, 4], [700, 6], [1000, 8], [1200, 10], [1600, 16]]. 
							The format is [x,y] whereby x=browser width and y=number of slides displayed'),
                'default' => '',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="space">'.$this->l('Items per column').'</div>',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itempercolumn',
                'label' => $this->l('Items per Column'),
                'desc' => $this->l('Please put item per a column'),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="space">'.$this->l('Effect').'</div>',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Autoplay'),
                'name' => 'autoplay',
                'is_bool' => true,
                'desc' => $this->l('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'slidespeed',
                'label' => $this->l('SlideSpeed'),
                'desc' => $this->l('Slide speed in milliseconds'),
                'default' => '200',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('stopOnHover'),
                'name' => 'stoponhover',
                'is_bool' => true,
                'desc' => $this->l('Stop autoplay on mouse hover'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('responsive'),
                'name' => 'responsive',
                'desc' => $this->l('You can use Owl Carousel on desktop-only websites too! Just change that to "false" to disable resposive capabilities'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('navigation'),
                'name' => 'navigation',
                'is_bool' => true,
                'desc' => $this->l('Display "next" and "prev" buttons.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'label' => $this->l('Scroll Per Page'),
                'name' => 'scrollperpage',
                'type' => 'text',
                'name' => 'scrollperpage',
                'label' => $this->l('scrollPerPage'),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('autoHeight'),
                'name' => 'autoheight',
                'is_bool' => true,
                'desc' => $this->l('Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('mouseDrag'),
                'name' => 'mousedrag',
                'is_bool' => true,
                'desc' => $this->l('Turn off/on mouse events.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('touchdrag'),
                'name' => 'touchdrag',
                'is_bool' => true,
                'desc' => $this->l('Turn off/on touch events.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="space">'.$this->l('lazyLoad: This function 
						is only work when have 1 item per column').'</div>',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('lazyLoad'),
                'name' => 'lazyload',
                'options' => array(
                    'query' => array(
                        array('id' => 'false', 'name' => $this->l('No')),
                        array('id' => 'true', 'name' => $this->l('Yes')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'desc' => $this->l('Delays loading of images. Images outside of viewport will not be loaded 
						before user scrolls to them. Great for mobile devices to speed up page loadings'),
                'default' => 'false',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('lazyFollow'),
                'name' => 'lazyfollow',
                'is_bool' => true,
                'desc' => $this->l('When pagination used, it skips loading the images from pages that got skipped. 
						It only loads the images that get displayed in viewport. 
						If set to false, all images get loaded when pagination used. 
						It is a sub setting of the lazy load function.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('lazyEffect'),
                'name' => 'lazyeffect',
                'options' => array(
                    'query' => array(
                        array('id' => 'fade', 'name' => $this->l('fade')),
                        array('id' => 'false', 'name' => $this->l('No')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'desc' => $this->l('Default is fadeIn on 400ms speed. Use false to remove that effect.'),
                'default' => 'fade',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('pagination'),
                'name' => 'pagination',
                'options' => array(
                    'query' => array(
                        array('id' => 'true', 'name' => $this->l('True')),
                        array('id' => 'false', 'name' => $this->l('False')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'false',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('paginationNumbers'),
                'name' => 'paginationnumbers',
                'is_bool' => true,
                'desc' => $this->l('Show numbers inside pagination buttons'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'paginationspeed',
                'label' => $this->l('paginationSpeed'),
                'desc' => $this->l('Pagination speed in milliseconds'),
                'default' => '800',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            //Owl Carousel end
            //boostrap carousel begin
            array(
                'type' => 'text',
                'name' => 'nbitemsperpage',
                'label' => $this->l('Number of Item per Page'),
                'desc' => $this->l('How many product you want to display in a Page. 
						Divisible by Item per Line (Desktop, Table, mobile)(default:12)'),
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
                'default' => '12',
            ),
            array(
                'type' => 'text',
                'name' => 'nbitemsperline',
                'label' => $this->l('Number Item per Line'),
                'desc' => $this->l('How many product you want to display in a row of page (default:4)'),
                'default' => '4',
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
            ),
            array(
                'type' => 'text',
                'name' => 'nbitemsperlinetablet',
                'label' => $this->l('Number Item per Line (Table)'),
                'desc' => $this->l('How many product you want to display in a row of page (default:3)'),
                'default' => '3',
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
            ),
            array(
                'type' => 'text',
                'name' => 'nbitemsperlinemobile',
                'label' => $this->l('Number Item per Line (Mobile)'),
                'desc' => $this->l('How many product you want to display in a row of page (default:2)'),
                'default' => '2',
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
            ),
            array(
                'type' => 'text',
                'name' => 'interval',
                'label' => $this->l('interval'),
                'desc' => $this->l('The amount of time to delay between automatically cycling an item. 
						If false, carousel will not automatically cycle.'),
                'default' => '5000',
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 2: Add content for sliders').'</div>'
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
        $list = explode('|', isset($assign['formAtts']['total_slider']) ? $assign['formAtts']['total_slider'] : '');
        $sliders = array();
        // $lang = Language::getLanguage(Context::getContext()->language->id);
        // $lang_default = $lang['id_lang'];
        // foreach ($list as $item)
        // 	if ($item)
        // 	{
        // 		$slider = array();
        // 		$slider['id'] = $item;
        // 		$slider['title'] = isset($assign['formAtts']['tit_'.$item]) ? $assign['formAtts']['tit_'.$item] : '';
        // 		$slider['image'] = isset($assign['formAtts']['image_'.$item]) ? $assign['formAtts']['image_'.$item] : '';
        // 		$slider['link'] = isset($assign['formAtts']['link_'.$item]) ? $assign['formAtts']['link_'.$item] : '';
        // 		$slider['descript'] = str_replace($this->str_search, $this->str_relace_html, isset($assign['formAtts']['descript_'.$item])
        // 		? $assign['formAtts']['descript_'.$item] : '');
        // 		$sliders[] = $slider;
        // 	}
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
                    $slider['image'] = _THEME_IMG_DIR_.'modules/'.$this->module_name.'/images/'.$assign['formAtts']['img_'.$temp];
                } else {
                    // validate module
                    $slider['image'] = '';
                }
                $desc = isset($assign['formAtts']['descript_'.$temp]) ? $assign['formAtts']['descript_'.$temp] : '';
                $slider['descript'] = str_replace($this->str_search, $this->str_relace_html, $desc);
                //$slider['descript'] = $assign['formAtts']['descript_'.$temp];
                $sliders[] = $slider;
            }
        }
        $assign['formAtts']['is_open'] = isset($assign['formAtts']['is_open']) ? $assign['formAtts']['is_open'] : 0;
        $assign['formAtts']['slides'] = $sliders;
        $assign['carouselName'] = 'carousel-'.ApPageSetting::getRandomNumber();
        if ($assign['formAtts']['carousel_type'] == 'boostrap') {
            $assign['nbItemsPerLine'] = $assign['formAtts']['nbitemsperline'];
            $assign['nbItemsPerLineTablet'] = $assign['formAtts']['nbitemsperlinetablet'];
            $assign['nbItemsPerLineMobile'] = $assign['formAtts']['nbitemsperlinemobile'];
            $assign['tabname'] = 'carousel-'.ApPageSetting::getRandomNumber();
            $assign['itemsperpage'] = (int)$assign['formAtts']['nbitemsperpage'];
            $assign['scolumn'] = 'col-xs-'.str_replace('.', '-', (12 / (int)$assign['nbItemsPerLineMobile'])).' col-sm-'
                    .str_replace('.', '-', (12 / (int)$assign['nbItemsPerLineTablet'])).' col-md-'
                    .str_replace('.', '-', (12 / (int)$assign['nbItemsPerLine']));
        } else {
            $assign['formAtts']['itemscustom'] = (isset($assign['formAtts']['itemscustom']) && $assign['formAtts']['itemscustom'] != '') ?
                    $assign['formAtts']['itemscustom'] : 'false';
            $assign['formAtts']['autoplay'] = ($assign['formAtts']['autoplay'] ? 'true' : 'false');
            if ($assign['formAtts']['itempercolumn'] > 1) {
                $assign['formAtts']['lazyload'] = 'false';
            }
        }
        return $assign;
    }
}
