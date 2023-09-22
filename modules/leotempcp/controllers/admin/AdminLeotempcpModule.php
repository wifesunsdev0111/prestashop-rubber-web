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

class AdminLeotempcpModuleController extends ModuleAdminControllerCore
{

    public function __construct()
    {
        $url = 'index.php?controller=adminmodules&configure=leotempcp&tab_module=Home&module_name=leotempcp&token='.Tools::getAdminTokenLite('AdminModules');
        Tools::redirectAdmin($url);

        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'configuration';
        $this->themeName = Context::getContext()->shop->getTheme();

        parent::__construct();
    }
}
