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

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderProfilesModel.php');

class ApPageBuilderHookModel
{
    public $profile_data;
    public $profile_param;
    public $hook;

    public function create()
    {
        $this->profile_data = ApPageBuilderProfilesModel::getActiveProfile('index');
        $this->profile_param = Tools::jsonDecode($this->profile_data['params'], true);
        $this->fullwidth_index_hook = $this->fullwidthIndexHook();
        $this->fullwidth_other_hook = $this->fullwidthOtherHook();
        return $this;
    }

    public function fullwidthIndexHook()
    {
        return isset($this->profile_param['fullwidth_index_hook']) ? $this->profile_param['fullwidth_index_hook'] : ApPageSetting::getIndexHook(3);
    }

    public function fullwidthOtherHook()
    {
        return isset($this->profile_param['fullwidth_other_hook']) ? $this->profile_param['fullwidth_other_hook'] : ApPageSetting::getOtherHook(3);
    }

    public function fullwidthHook($hook_name, $page)
    {
        if ($page == 'index') {
            // validate module
            return isset($this->fullwidth_index_hook[$hook_name]) ? $this->fullwidth_index_hook[$hook_name] : 0;
        } else {
            # other page
            return isset($this->fullwidth_other_hook[$hook_name]) ? $this->fullwidth_other_hook[$hook_name] : 0;
        }
    }
}
