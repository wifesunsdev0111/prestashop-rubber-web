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

class LeotempcpWidgetModuleFrontController extends ModuleFrontController
{

    public function init()
    {
        parent::init();
        require_once( $this->module->getLocalPath().'leotempcp.php' );
    }

    public function initContent()
    {
        parent::initContent();
        $module = new Leotempcp();
        echo $module->renderwidget();
        die;
    }
}
