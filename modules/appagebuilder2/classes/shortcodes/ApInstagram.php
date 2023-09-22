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

class ApInstagram extends ApShortCodeBase
{
    public $name = 'ApInstagram';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Instagram'),
            'position' => 6,
            'desc' => $this->l('You can config Instagram box'),
            'icon_class' => 'icon-instagram',
            'tag' => 'social');
    }

    public function getConfigList()
    {
        $soption = ApPageSetting::returnYesNo();
        $get = array(
            array(
                'id' => 'popular',
                'label' => self::l('Popular')
            ),
            array(
                'id' => 'tagged',
                'label' => self::l('Tagged'),
            ),
            array(
                'id' => 'location',
                'label' => self::l('Location')
            ),
            array(
                'id' => 'user',
                'label' => self::l('User')
            ),
        );
        $sort = array(
            array(
                'id' => 'none',
                'label' => self::l('None')
            ),
            array(
                'id' => 'most-recent',
                'label' => self::l('Newest to oldest.'),
            ),
            array(
                'id' => 'least-recent',
                'label' => self::l('Oldest to newest.')
            ),
            array(
                'id' => 'most-liked',
                'label' => self::l('Highest # of likes to lowest.')
            ),
            array(
                'id' => 'least-liked',
                'label' => self::l('Lowest # likes to highest.')
            ),
            array(
                'id' => 'most-commented',
                'label' => self::l('Highest # of comments to lowest.')
            ),
            array(
                'id' => 'least-commented',
                'label' => self::l('Lowest # of comments to highest.')
            ),
            array(
                'id' => 'random',
                'label' => self::l('Random order.')
            ),
        );
        $resolution = array(
            array(
                'id' => 'thumbnail',
                'label' => self::l('thumbnail - 150x150')
            ),
            array(
                'id' => 'low_resolution',
                'label' => self::l('low_resolution - 306x306'),
            ),
            array(
                'id' => 'standard_resolution',
                'label' => self::l('standard_resolution - 612x612')
            )
        );
//		$display_type = array(
//			array(
//				'id' => 'list',
//				'label' => self::l('Display as List')
//			),
//			array(
//				'id' => 'carousel',
//				'label' => self::l('Display as Boostrap Carousel'),
//			),
//			array(
//				'id' => 'owl-carousel',
//				'label' => self::l('Display as Owl Carousel')
//			)
//		);
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'form_group_class' => 'aprow_general',
                'desc' => $this->l('The script was get from http://instafeedjs.com/'),
                'default' => ''
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Client ID'),
                'name' => 'client_id',
                'class' => 'ap_instagram',
                'desc' => $this->l('Your API client id from Instagram. Required.'),
                'default' => '981ec7c9426149c5b01a775543b9ade0',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Access Token'),
                'name' => 'access_token',
                'class' => 'ap_instagram',
                'desc' => $this->l('A valid oAuth token. Required to use get: "user".'),
                'default' => '',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Target'),
                'name' => 'target',
                'class' => 'ap_instagram',
                'desc' => $this->l('The ID of a DOM element you want to add the images to.'),
                'default' => '',
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Template'),
                'name' => 'template',
                'class' => 'ap_instagram',
                'desc' => $this->l('(Developer Only) Custom HTML template to use for images.'),
                'default' => '',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Get'),
                'name' => 'get',
                'class' => 'ap_instagram',
                'options' => array(
                    'query' => $get,
                    'id' => 'id',
                    'name' => 'label'
                ),
                'desc' => $this->l('Customize what Instafeed fetches'),
                'default' => 'popular',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Tag Name'),
                'name' => 'tag_name',
                'desc' => $this->l('Name of the tag to get. Use with get: "tagged".'),
                'default' => '',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Location ID'),
                'name' => 'location_id',
                'desc' => $this->l('(number) Unique id of a location to get. Use with get: "location".'),
                'default' => '',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('User ID'),
                'name' => 'user_id',
                'desc' => $this->l('(number) - Unique id of a user to get. Use with get: "user".'),
                'default' => '',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Sort By'),
                'name' => 'sort_by',
                'class' => 'ap_instagram',
                'options' => array(
                    'query' => $sort,
                    'id' => 'id',
                    'name' => 'label'
                ),
                'desc' => $this->l('Sort the images in a set order. Available options are'),
                'default' => 'none',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Links'),
                'desc' => $this->l('Wrap the images with a link to the photo on Instagram.'),
                'name' => 'links',
                'default' => '60',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Links'),
                'name' => 'links',
                'values' => $soption,
                'desc' => $this->l('Wrap the images with a link to the photo on Instagram.'),
                'default' => '0',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Limit'),
                'desc' => $this->l('Maximum number of Images to add. Max of 60.'),
                'name' => 'limit',
                'default' => '60',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Resolution'),
                'name' => 'resolution',
                'class' => 'ap_instagram',
                'options' => array(
                    'query' => $resolution,
                    'id' => 'id',
                    'name' => 'label'
                ),
                'desc' => $this->l('Size of the images to get. Available options are'),
                'default' => 'thumbnail',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Profile Link'),
                'desc' => $this->l('Create link in footer link to profile'),
                'name' => 'profile_link',
                'default' => '',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="space" style="color:red">'.$this->l('Template Type').'</div>',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Carousel Type'),
                'class' => 'form-action',
                'name' => 'carousel_type',
                'options' => array(
                    'query' => array(
                        array('id' => 'list', 'name' => $this->l('Normal List')),
                        array('id' => 'owlcarousel', 'name' => $this->l('Owl Carousel')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'owlcarousel'
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
                'label' => $this->l('items'),
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
                'label' => $this->l('itemsDesktopSmall (~979)'),
                'desc' => $this->l('This allows you to preset the number of slides visible with itemsDesktopSmall (~979px)'),
                'default' => '3',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'text',
                'name' => 'itemstablet',
                'label' => $this->l('itemsTablet (~768)'),
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
                'label' => $this->l('itemsCustom'),
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
                'label' => $this->l('items per Column'),
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
                'label' => $this->l('slideSpeed'),
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
                'is_bool' => true,
                'desc' => $this->l('You can use Owl Carousel on desktop-only websites too! 
						Just change that to "false" to disable resposive capabilities'),
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
                'type' => 'switch',
                'label' => $this->l('scrollPerPage'),
                'name' => 'scrollperpage',
                'is_bool' => true,
                'desc' => $this->l('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '0',
                'form_group_class' => 'carousel_type_sub carousel_type-owlcarousel',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('autoHeight'),
                'name' => 'autoheight',
                'is_bool' => true,
                'desc' => $this->l('Add height to owl-wrapper-outer so you can use diffrent heights on slides. 
						Use it only for one item per page setting.'),
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
        );
        return $inputs;
    }
}
