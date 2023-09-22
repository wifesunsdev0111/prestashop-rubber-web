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

class ApModule extends ApShortCodeBase
{
    public $name = 'ApModule';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Module'),
            'position' => 5,
            'desc' => $this->l('Custom moule'),
            'icon_class' => 'icon-copy',
            'tag' => 'module');
    }

    public function getConfigList()
    {
        if (Tools::getIsset('edit')) {
            $name_module = Tools::getValue('name_module');
        } else {
            $name_module = Tools::getValue('type_shortcode');
        }
        if (!$name_module) {
            return array();
        }
        // Get list hook by id (this source code was coped from AdminApPageBuilderShortcodesController)
        $hook_assign = array('rightcolumn', 'leftcolumn', 'topcolumn', 'home', 'top', 'footer', 'nav');
        $module_instance = ModuleCore::getInstanceByName($name_module);
        //echo "<pre>";print_r($module_instance);
        $hooks = array();
        $result = array();
        foreach ($hook_assign as $hook) {
            $retro_hook_name = Hook::getRetroHookName($hook);
            if ($hook == 'topcolumn') {
                $retro_hook_name = 'displayTopColumn';
            }
            if ($hook == 'nav') {
                $retro_hook_name = 'displayNav';
            }
            if (is_callable(array($module_instance, 'hook'.$hook)) || is_callable(array($module_instance, 'hook'.$retro_hook_name))) {
                $hooks[] = $retro_hook_name;
            }
        }
        if ($hooks) {
            $result = Db::getInstance()->ExecuteS('
				SELECT `id_hook`, `name`
				FROM `'._DB_PREFIX_.'hook`
				WHERE `name` IN (\''.implode("','", $hooks).'\')');
        }
        $arr = array(array('id' => '', 'name' => $this->l('--------- Select a Hook ---------')));
        $len = count($result);
        if ($result && $len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $arr[] = array('id' => $result[$i]['name'], 'name' => $result[$i]['name']);
            }
        }
        $inputs = array(
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">Module name: <b>"'.$name_module
                .'"</b><input type="hidden" id="select-hook-error" value="'.$this->l('Please select a hook').'"/>
										<input type="hidden" id="name-module" name="name_module" value="'.$name_module.'"/>
									</div>',
            ),
            array(
                'type' => 'select',
                'id' => 'select-hook',
                'label' => $this->l('Select hook of module (*)'),
                'name' => 'hook',
                'options' => array('query' => $arr,
                    'id' => 'id',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Remove display'),
                'desc' => $this->l('This module will remove in this hook'),
                'name' => 'is_display',
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-danger">'.$this->l('Please consider using this function. 
						This function is only for advance user, 
						It will load other module and display in column of leomanagewidget. 
						With some module have ID in wrapper DIV, your site will have Javascript Conflicts. 
						We will not support this error ').'</div>',
            )
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $form_attr = $assign['formAtts'];
        $context = Context::getContext();
        if (isset($form_attr['hook']) && isset($form_attr['name_module'])) {
            $assign['apContent'] = $this->execModuleHook($form_attr['hook'], array(), $form_attr['name_module'], false, $context->shop->id);
        }
        return $assign;
    }

    public static function execModuleHook($hook_name, $hook_args = array(), $module_name, $use_push = false, $id_shop = null)
    {
        static $disable_non_native_modules = null;
        if ($disable_non_native_modules === null) {
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
        }
        // Check arguments validity
        if (!Validate::isModuleName($module_name) || !Validate::isHookName($hook_name)) {
            return '';
        }
        //throw new PrestaShopException('Invalid module name or hook name');
        // If no modules associated to hook_name or recompatible hook name, we stop the function
        if (!Hook::getHookModuleExecList($hook_name)) {
            return '';
        }
        // Check if hook exists
        if (!$id_hook = Hook::getIdByName($hook_name)) {
            return false;
        }
        // Store list of executed hooks on this page
        Hook::$executed_hooks[$id_hook] = $hook_name;
        $context = Context::getContext();
        if (!isset($hook_args['cookie']) || !$hook_args['cookie']) {
            $hook_args['cookie'] = $context->cookie;
        }
        if (!isset($hook_args['cart']) || !$hook_args['cart']) {
            $hook_args['cart'] = $context->cart;
        }
        $retro_hook_name = Hook::getRetroHookName($hook_name);
        // Look on modules list
        $altern = 0;
        $output = '';
        if ($disable_non_native_modules && !isset(Hook::$native_module)) {
            Hook::$native_module = Module::getNativeModuleList();
        }
        $different_shop = false;
        if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID()) {
            //$old_context_shop_id = $context->shop->getContextShopID();
            $old_context = $context->shop->getContext();
            $old_shop = clone $context->shop;
            $shop = new Shop((int)$id_shop);
            if (Validate::isLoadedObject($shop)) {
                $context->shop = $shop;
                $context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
                $different_shop = true;
            }
        }
        // Check errors
        if ((bool)$disable_non_native_modules && Hook::$native_module && count(Hook::$native_module) && !in_array($module_name, self::$native_module)) {
            return;
        }
        if (!($module_instance = Module::getInstanceByName($module_name))) {
            return;
        }
        if ($use_push && !$module_instance->allow_push) {
            return;
        }
        // Check which / if method is callable
        $hook_callable = is_callable(array($module_instance, 'hook'.$hook_name));
        $hook_retro_callable = is_callable(array($module_instance, 'hook'.$retro_hook_name));
        if (($hook_callable || $hook_retro_callable) && Module::preCall($module_instance->name)) {
            $hook_args['altern'] = ++$altern;
            if ($use_push && isset($module_instance->push_filename) && file_exists($module_instance->push_filename)) {
                Tools::waitUntilFileIsModified($module_instance->push_filename, $module_instance->push_time_limit);
            }
            if ($hook_callable) {
                // Call hook method
                $display = $module_instance->{'hook'.$hook_name}($hook_args);
            } elseif ($hook_retro_callable) {
                $display = $module_instance->{'hook'.$retro_hook_name}($hook_args);
            }
            $output .= $display;
        }
        if ($different_shop) {
            $context->shop = $old_shop;
            $context->shop->setContext($old_context, $shop->id);
        }
        return $output; // Return html string
    }
}
