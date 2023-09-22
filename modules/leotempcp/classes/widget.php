<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}
if (!class_exists('LeoTempcpWidget')) {

    /**
     * LeoFooterBuilderWidget Model Class
     */
    class LeoTempcpWidget extends ObjectModel
    {
        public $name;
        public $type;
        public $params;
        public $key_widget;
        public $id_shop;
        private $widgets = array();
        public $modName = 'leotempcp';
        public $theme = '';
        public $langID = 1;
        public $engines = array();
        public $engineTypes = array();

        public function setTheme($theme)
        {
            $this->theme = $theme;
            return $this;
        }
        public static $definition = array(
            'table' => 'leowidgets',
            'primary' => 'id_leowidgets',
            'fields' => array(
                'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255, 'required' => true),
                'type' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
                'params' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
                'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                'key_widget' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'size' => 11)
            )
        );

        /**
         * Get translation for a given module text
         *
         * Note: $specific parameter is mandatory for library files.
         * Otherwise, translation key will not match for Module library
         * when module is loaded with eval() Module::getModulesOnDisk()
         *
         * @param string $string String to translate
         * @param boolean|string $specific filename to use in translation key
         * @return string Translation
         */
        public function l($string, $specific = false)
        {
            return Translate::getModuleTranslation($this->modName, $string, ($specific) ? $specific : $this->modName);
        }

        public function delete()
        {
            $this->clearCaches();
            return parent::delete();
        }

        public function loadEngines()
        {
            if (!$this->engines) {
                $wds = glob(dirname(__FILE__).'/widget/*.php');
                foreach ($wds as $w) {
                    if (basename($w) == 'index.php') {
                        continue;
                    }
                    require_once( $w );
                    $f = str_replace('.php', '', basename($w));
                    $class = 'LeoWidget'.Tools::ucfirst($f);

                    if (class_exists($class)) {
                        $this->engines[$f] = new $class;
                        $this->engines[$f]->id_shop = Context::getContext()->shop->id;
                        $this->engines[$f]->langID = Context::getContext()->language->id;
                        $this->engineTypes[$f] = $this->engines[$f]->getWidgetInfo();
                        $this->engineTypes[$f]['type'] = $f;
                        $this->engineTypes[$f]['for'] = $this->engines[$f]->for_module;
                    }
                }
            }
        }

        /**
         * get list of supported widget types.
         */
        public function getTypes()
        {
            return $this->engineTypes;
        }

        /**
         * get list of widget rows. 
         */
        public function getWidgets()
        {
            $sql = ' SELECT * FROM '._DB_PREFIX_.'leowidgets WHERE `id_shop` = '.(int)Context::getContext()->shop->id;
            return Db::getInstance()->executeS($sql);
        }

        /**
         * get widget data row by id
         */
        public function getWidetById($id)
        {
            $output = array(
                'id' => '',
                'id_leowidgets' => '',
                'name' => '',
                'params' => '',
                'type' => '',
            );
            if (!$id) {
                # validate module
                return $output;
            }
            $sql = ' SELECT * FROM '._DB_PREFIX_.'leowidgets WHERE id_leowidgets='.(int)$id;

            $row = Db::getInstance()->getRow($sql);

            if ($row) {
                $output = array_merge($output, $row);
                $output['params'] = Tools::jsonDecode(call_user_func('base64'.'_decode', $output['params']), true);
                $output['id'] = $output['id_leowidgets'];
            }
            return $output;
        }

        /**
         * get widget data row by id
         */
        public function getWidetByKey($key, $id_shop)
        {
            $output = array(
                'id' => '',
                'id_leowidgets' => '',
                'name' => '',
                'params' => '',
                'type' => '',
                'key_widget' => '',
            );
            if (!$key) {
                # validate module
                return $output;
            }
            $sql = ' SELECT * FROM '._DB_PREFIX_.'leowidgets WHERE key_widget='.(int)$key.' AND id_shop='.(int)$id_shop;
            $row = Db::getInstance()->getRow($sql);
            if ($row) {
                $output = array_merge($output, $row);
                $output['params'] = Tools::jsonDecode(call_user_func('base64'.'_decode', $output['params']), true);
                $output['id'] = $output['id_leowidgets'];
            }
            return $output;
        }

        /**
         * render widget Links Form.
         */
        public function getWidgetInformationForm($args, $data)
        {
            $fields = array(
                'html' => array('type' => 'textarea', 'value' => '', 'lang' => 1, 'values' => array(), 'attrs' => 'cols="40" rows="6"')
            );
            unset($args);
            return $this->_renderFormByFields($fields, $data);
        }

        public function renderWidgetSub_categoriesContent($args, $setting)
        {
            # validate module
            unset($args);
            $t = array(
                'category_id' => '',
                'limit' => '12'
            );
            $setting = array_merge($t, $setting);
//			$nb = (int)$setting['limit'];

            $category = new Category($setting['category_id'], $this->langID);
            $subCategories = $category->getSubCategories($this->langID);
            $setting['title'] = $category->name;


            $setting['subcategories'] = $subCategories;
            $output = array('type' => 'sub_categories', 'data' => $setting);

            return $output;
        }

        /**
         * general function to render FORM 
         *
         * @param String $type is form type.
         * @param Array default data values for inputs.
         *
         * @return Text.
         */
        public function getForm($type, $data = array())
        {
            if (isset($this->engines[$type])) {
                $args = array();
                $this->engines[$type]->types = $this->getTypes();

                return $this->engines[$type]->renderForm($args, $data);
            }
            return $this->l('Sorry, Form Setting is not avairiable for this type');
        }

        /**
         *
         */
        public function getWidgetContent($type, $data)
        {
//			$method = 'renderWidget'.Tools::ucfirst($type).'Content';
            $args = array();
            $data = Tools::jsonDecode(call_user_func('base64'.'_decode', $data), true);

            $data['widget_heading'] = isset($data['widget_title_'.$this->langID]) ? Tools::stripslashes($data['widget_title_'.$this->langID]) : '';

            //echo $method;
            if (isset($this->engines[$type])) {
                $args = array();
                return $this->engines[$type]->renderContent($args, $data);
            }
            return false;
        }

        /**
         *
         */
        public function renderContent($id)
        {
            $output = array('id' => $id, 'type' => '', 'data' => '');
            if (isset($this->widgets[$id])) {
                # validate module
                $output = $this->getWidgetContent($this->widgets[$id]['type'], $this->widgets[$id]['params']);
            }

            return $output;
        }

        /**
         *
         */
        public function loadWidgets()
        {
            if (empty($this->widgets)) {
                $widgets = $this->getWidgets();
                foreach ($widgets as $widget) {
                    $widget['id'] = $widget['id_leowidgets'];
                    $this->widgets[$widget['key_widget']] = $widget;
                }
            }
        }

        public function clearCaches()
        {
            if (file_exists(_PS_MODULE_DIR_.'leobootstrapmenu/leobootstrapmenu.php')) {
                require_once( _PS_MODULE_DIR_.'leobootstrapmenu/leobootstrapmenu.php' );
                $leobootstrapmenu = new leobootstrapmenu();
                $leobootstrapmenu->clearCache();
            }
            if (file_exists(_PS_MODULE_DIR_.'leomenusidebar/leomenusidebar.php')) {
                require_once( _PS_MODULE_DIR_.'leomenusidebar/leomenusidebar.php' );
                $leomenusidebar = new leomenusidebar();
                $leomenusidebar->clearCache();
            }
            if (file_exists(_PS_MODULE_DIR_.'leomanagewidgets/leomanagewidgets.php')) {
                require_once( _PS_MODULE_DIR_.'leomanagewidgets/leomanagewidgets.php' );
                $leomanagewidgets = new LeoManagewidgets();
                $leomanagewidgets->clearHookCache();
            }
        }
    }

}
