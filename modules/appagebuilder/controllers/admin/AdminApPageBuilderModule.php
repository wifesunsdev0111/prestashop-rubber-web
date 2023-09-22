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

class AdminApPageBuilderModuleController extends ModuleAdminControllerCore
{

    public function __construct()
    {
        parent::__construct();
        $url = 'index.php?controller=adminmodules&configure=appagebuilder&tab_module=front_office_features&module_name=appagebuilder&token='.Tools::getAdminTokenLite('AdminModules');
        Tools::redirectAdmin($url);
    }
}
