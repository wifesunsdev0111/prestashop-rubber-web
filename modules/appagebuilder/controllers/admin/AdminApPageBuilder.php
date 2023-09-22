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

class AdminApPageBuilderController extends ModuleAdminControllerCore
{
    public static $shortcode_lang;
    public static $lang_id;
    public static $language;
    public $error_text = '';
    public $theme_name;

    public function __construct()
    {
        $url = 'index.php?controller=adminmodules&configure=appagebuilder&token='.Tools::getAdminTokenLite('AdminModules')
                .'&tab_module=Home&module_name=appagebuilder';
        Tools::redirectAdmin($url);
        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'configuration';
        $this->theme_name = Context::getContext()->shop->getTheme();
        parent::__construct();
    }
}
