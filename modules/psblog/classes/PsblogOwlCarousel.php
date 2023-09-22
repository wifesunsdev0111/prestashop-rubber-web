<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}
if (!class_exists('PsblogOwlCarousel')) {

    class PsblogOwlCarousel
    {
        const MODULE_NAME = 'pstempcp';

        public static function l($string, $specific = false, $name = '')
        {
            if (empty($name)) {
                # validate module
                $name = self::MODULE_NAME;
            }
            return Translate::getModuleTranslation($name, $string, ($specific) ? $specific : $name);
        }
        const ENABLE = '1';
        const DISABLE = '0';

        public static function getEnableOptions()
        {
            return array(array(
                    'id' => 'active_on',
                    'value' => self::ENABLE,
                    'label' => self::l('Enabled')
                ),
                array(
                    'id' => 'active_off',
                    'value' => self::DISABLE,
                    'label' => self::l('Disabled')
            ));
        }
        const CAROUSEL_BOOTSTRAP = 'carousel_bootstrap';
        const CAROUSEL_OWL = 'carousel_owl';

        public static function getCaroulseOptions()
        {
            return array(
                array(
                    'value' => self::CAROUSEL_BOOTSTRAP,
                    'name' => self::l('Bootstrap'),
                ),
                array(
                    'value' => self::CAROUSEL_OWL,
                    'name' => self::l('Own Carousel'),
                ),
            );
        }
        const TRANSITIONSTYLE_FADE = 'fade';
        const TRANSITIONSTYLE_BACKSLIDE = 'backSlide';
        const TRANSITIONSTYLE_GODOWN = 'goDown';
        const TRANSITIONSTYLE_FADEUP = 'fadeUp';

        public static function getTransitionStyleOptions()
        {
            return array(
                array(
                    'value' => self::TRANSITIONSTYLE_FADE,
                    'name' => self::l('Fade'),
                ),
                array(
                    'value' => self::TRANSITIONSTYLE_BACKSLIDE,
                    'name' => self::l('Back Slide'),
                ),
                array(
                    'value' => self::TRANSITIONSTYLE_GODOWN,
                    'name' => self::l('Go Down'),
                ),
                array(
                    'value' => self::TRANSITIONSTYLE_FADEUP,
                    'name' => self::l('Fade Up'),
                ),
            );
        }

        /**
         * Declare owl carousel inputs of form in Backend
         */
        public function getOwlCarouselAdminFormOptions()
        {
            return array(
                # config for Owl Carousel - BEGIN
                array(
                    'type' => 'text',
                    'label' => $this->l('Items Per Row'),
                    'name' => 'owl_items',
                    'default' => 3,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'fixed-width-xl digits',
                    'desc' => $this->l('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width'),
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Number of rows'),
                    'name' => 'owl_rows',
                    'default' => 1,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'fixed-width-xl digits',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Auto Play'),
                    'name' => 'owl_autoPlay',
                    'default' => 8000,
                    'desc' => $this->l('Enter Time(miniseconds) to play carousel. Value 0 to stop.'),
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'fixed-width-xl digits',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Stop On Hover'),
                    'name' => 'owl_stopOnHover',
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'values' => self::getEnableOptions(),
                    'desc' => $this->l('Stop "Auto Play" on mouse hover.'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Auto Height'),
                    'name' => 'owl_autoHeight',
                    'default' => self::DISABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'values' => self::getEnableOptions(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Reponsive'),
                    'name' => 'owl_responsive',
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'values' => self::getEnableOptions(),
                ),
                /*
                  array(
                  'type' => 'select',
                  'label' => $this->l('Transition Style'),
                  'name' => 'owl_transitionStyle',
                  'default' => PsmanagewidgetsOwlCarousel::TRANSITIONSTYLE_FADE,
                  'form_group_class' => 'carousel_type_sub carousel_type-' . self::CAROUSEL_OWL,
                  'options' => array(
                  'query' => PsmanagewidgetsOwlCarousel::getTransitionStyleOptions(),
                  'id' => 'value',
                  'name' => 'name'
                  )
                  ),
                 */
                array(
                    'type' => 'switch',
                    'label' => $this->l('Mouse Drag'),
                    'name' => 'owl_mouseDrag',
                    'desc' => $this->l('Turn off/on mouse events.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Touch Drag'),
                    'name' => 'owl_touchDrag',
                    'desc' => $this->l('Turn off/on touch events.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Navigation'),
                    'name' => 'owl_navigation',
                    'desc' => $this->l('Display "next" and "prev" buttons.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_slideSpeed',
                    'label' => $this->l('Slide Speed'),
                    'desc' => $this->l('Slide speed in milliseconds. Time to next/drag/tough each item. Ex 200.'),
                    'default' => '200',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'fixed-width-xl digits',
                ),
                array(
                    'type' => 'html',
                    'name' => 'noname',
                    'html_content' => '<div class="space"><strong>'.$this->l('Items for Screens').'</strong><hr/></div>',
                    'default' => 'novalue',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsDesktop',
                    'label' => $this->l('Items Desktop (~1199)'),
                    'desc' => $this->l('This allows you to preset the number of slides visible with ItemsDesktop (1199). Value 0 to disable. (Ex 4).'),
                    'default' => '0',
                    'form_group_class' => 'required carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                //'required' => 'true',
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsDesktopSmall',
                    'label' => $this->l('Items Desktop Small (~979)'),
                    'desc' => $this->l('This allows you to preset the number of slides visible with itemsDesktopSmall (979px). Value 0 to disable. (Ex 3).'),
                    'default' => '0',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsTablet',
                    'label' => $this->l('Items Tablet (~768)'),
                    'desc' => $this->l('This allows you to preset the number of slides visible with itemsTablet (768). Value 0 to disable. (Ex 2).'),
                    'default' => '0',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsTabletSmall',
                    'label' => $this->l('Items Tablet Small (~640)'),
                    'desc' => $this->l('This allows you to preset the number of slides visible with itemsTabletSmall (640). Value 0 to disable. (Ex 2).'),
                    'default' => '0',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsMobile',
                    'label' => $this->l('Items Mobile (~479)'),
                    'desc' => $this->l('This allows you to preset the number of slides visible with itemsmobile (360). Value 0 to disable. (Ex 1).'),
                    'default' => '0',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_itemsCustom',
                    'label' => $this->l('Items Custom'),
                    //'desc' => $this->l('(Advance User) Example: [[0, 2], [400, 4], [700, 6], [1000, 8], [1200, 10], [1600, 16]]. The format is [x,y] whereby x=browser width and y=number of slides displayed. Value 0 to disable.'),
                    'desc' => $this->l('(Advance User) Example: [[320, 1], [360, 1], [480, 2], [568, 2], [600, 2], [640, 2], [768, 3], [900, 3], [960, 3], [1024, 4]]. The format is [x,y] whereby x=browser width and y=number of slides displayed. Override all above Items. Value 0 to disable.'),
                    'default' => '0',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'owl_items_custom',
                ),
                array(
                    'type' => 'html',
                    'name' => 'noname',
                    'html_content' => '<div class="space"><strong>'.$this->l('Effect').'</strong><hr/></div>',
                    'default' => 'novalue',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Lazy Load'),
                    'name' => 'owl_lazyLoad',
                    'default' => self::DISABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'values' => self::getEnableOptions(),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Lazy Effect'),
                    'name' => 'owl_lazyEffect',
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'values' => self::getEnableOptions(),
                    'desc' => $this->l('Default is fadeIn on 400ms speed.'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Lazy Follow'),
                    'name' => 'owl_lazyFollow',
                    'is_bool' => true,
                    'desc' => $this->l('When pagination used, it skips loading the images from pages that got skipped. It only loads the images that get displayed in viewport. If set to false, all images get loaded when pagination used. It is a sub setting of the lazy load function.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'html',
                    'name' => 'noname',
                    'html_content' => '<div class="space"><strong>'.$this->l('Pagination').'</strong><hr/></div>',
                    'default' => 'novalue',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Pagination'),
                    'name' => 'owl_pagination',
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Pagination Numbers'),
                    'name' => 'owl_paginationNumbers',
                    'values' => self::getEnableOptions(),
                    'default' => self::DISABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_paginationSpeed',
                    'label' => $this->l('Pagination Speed'),
                    'desc' => $this->l('Enter Time(miniseconds) to next/prev page. Ex 800.'),
                    'default' => '800',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Rewind Nav'),
                    'name' => 'owl_rewindNav',
                    'is_bool' => true,
                    'desc' => $this->l('Slide to first page. Use "Rewind Speed" to change animation speed.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::ENABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
                array(
                    'type' => 'text',
                    'name' => 'owl_rewindSpeed',
                    'label' => $this->l('Rewind Speed'),
                    'desc' => $this->l('Enter Time(miniseconds) to back first page. "Rewind Nav" must be enable. Ex 1000'),
                    'default' => '1000',
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                    'class' => 'digits',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Scroll Per Page'),
                    'name' => 'owl_scrollPerPage',
                    'is_bool' => true,
                    'desc' => $this->l('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging. Use "Slide Speed" to change animation speed.'),
                    'values' => self::getEnableOptions(),
                    'default' => self::DISABLE,
                    'form_group_class' => 'carousel_type_sub carousel_type-'.self::CAROUSEL_OWL,
                ),
            );
        }
    }

}
