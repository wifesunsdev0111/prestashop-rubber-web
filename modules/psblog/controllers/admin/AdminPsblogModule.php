<?php
/**
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class AdminPsblogModuleController extends ModuleAdminControllerCore
{

    public function __construct()
    {
        parent::__construct();
		
		$url = 'index.php?controller=adminmodules&configure=psblog&tab_module=front_office_features&module_name=psblog&token='.Tools::getAdminTokenLite('AdminModules');
        Tools::redirectAdmin($url);
    }
}
