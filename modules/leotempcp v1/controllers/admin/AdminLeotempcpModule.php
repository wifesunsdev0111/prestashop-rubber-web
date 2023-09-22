<?php
/******************************************************
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

if (!defined('_CAN_LOAD_FILES_'))
    exit;

class AdminLeotempcpModuleController extends ModuleAdminControllerCore {
	

	public function __construct()
	{
        
        $url = 'index.php?controller=adminmodules&configure=leotempcp&token='.Tools::getAdminTokenLite('AdminModules').'&tab_module=Home&module_name=leotempcp';
        Tools::redirectAdmin( $url ); 

		$this->bootstrap = true;
		$this->className = 'Configuration';
		$this->table = 'configuration';
        $this->themeName = Context::getContext()->shop->getTheme();

		parent::__construct();

	}
}
?>