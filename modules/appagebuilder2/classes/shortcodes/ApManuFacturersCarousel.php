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

class ApManuFacturersCarousel extends ApShortCodeBase
{
    public $name = 'ApManuFacturersCarousel';

    public function getInfo()
    {
        return array('label' => $this->l('Manufacturers carousel'), 'position' => 6,
            'desc' => $this->l('Show manufacturers in Carousel'), 'icon_class' => 'icon icon-chevron-right',
            'tag' => 'content slider');
    }

    public function getConfigList()
    {
        //get all manufacture
        $manufacturers = Manufacturer::getManufacturers(false, 0, true, false, false, false, true);
        // get image type
        $imagetype = ImageType::getImagesTypes('manufacturers');
        $iselect = Tools::getValue('select_by_manufacture');
        if ($iselect === '0') {
            $script_update_select = '<script>$("#select_by_manufacture").attr("checked", "checked");</script>';
        } else {
            $script_update_select = '<script>$("#select_by_manufacture").removeAttr("checked");</script>';
        }

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
                'desc' => $this->l('css class'),
                'default' => ''
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.
                $this->l('Step 1: Use latest manufacturers or select Manufacturers').'</div>'.$script_update_select,
            ),
            array(
                'type' => 'checkbox',
                'name' => 'select_by',
                'label' => $this->l('Select manufacturers'),
                'class' => 'checkbox-group',
                'desc' => $this->l('Unchecked to show latest manufacturers'),
                'values' => array(
                    'query' => array(
                        array(
                            'id' => 'manufacture',
                            'name' => $this->l('Select Manufacturers'),
                            'val' => '0'
                        )
                    ),
                    'id' => 'id',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Manufacture'),
                'name' => 'manuselect[]',
                'multiple' => true,
                'options' => array(
                    'query' => $manufacturers,
                    'id' => 'id_manufacturer',
                    'name' => 'name'
                ),
                'default' => 'all',
                'form_group_class' => 'select_by_manufacture',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 2: Select image type').'</div>',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Image:'),
                'desc' => $this->l('Select image type for manufacture.'),
                'name' => 'imagetype',
                'default' => ApPageSetting::getDefaultNameImage('small'),
                'options' => array(
                    'query' => $imagetype,
                    'id' => 'name',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 3: Product Order And Limit').'</div>',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Order Way'),
                'class' => 'form-action',
                'name' => 'order_way',
                'options' => array(
                    'query' => array(
                        array('id' => 'asc', 'name' => $this->l('Asc')),
                        array('id' => 'desc', 'name' => $this->l('Desc')),
                        array('id' => 'random', 'name' => $this->l('Random'))),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'all'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Order By'),
                'name' => 'order_by',
                'options' => array(
                    'query' => ApPageSetting::getOrderByManu(),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'order_type_sub order_type-asc order_type-desc',
                'default' => 'all'
            ),
            array(
                'type' => 'text',
                'name' => 'manu_limit',
                'label' => $this->l('Limit'),
                'default' => '10',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 3: Carousel Setting').'</div>',
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
                'label' => $this->l('items'),
                'desc' => $this->l('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width'),
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
						divisible by Item per Line (Desktop, Table, mobile)(default:12)'),
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
                'default' => '12',
            ),
            array(
                'type' => 'text',
                'name' => 'nbitemsperline',
                'label' => $this->l('Number column'),
                'desc' => $this->l('Number column show per row (Default:1)'),
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
                'desc' => $this->l('The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle.'),
                'default' => '5000',
                'form_group_class' => 'carousel_type_sub carousel_type-boostrap carousel_type-desc',
            )
        );
        return $input;
    }

    public function prepareFontContent($assign, $module = null)
    {
        if (isset($assign['formAtts']['select_by_manufacture']) && $assign['formAtts']['select_by_manufacture'] == '0') {
            // validate module
            $assign['manuselect'] = $module->getManufacturersSelect($assign['formAtts'], $module);
        } else {
            // validate module
            $assign['manuselect'] = Manufacturer::getManufacturers(false, 0, true, 1, (int)$assign['formAtts']['manu_limit'], false, true);
        }
        $assign['manufacturers'] = Manufacturer::getManufacturers(false, 0, true, 1, (int)$assign['formAtts']['manu_limit'], false, true);
        $assign['image_type'] = ($assign['formAtts']['imagetype']) ? ($assign['formAtts']['imagetype']) : ApPageSetting::getDefaultNameImage('small');
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
