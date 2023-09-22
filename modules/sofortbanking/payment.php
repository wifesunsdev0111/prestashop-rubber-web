<?php
/**
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category  Payment
 * @author    Christin Gruber, <www.touchdesign.de>
 * @copyright 19.08.2009, touchdesign
 * @link      http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * Description:
 *
 * Payment module sofortbanking
 *
 * --
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@touchdesign.de so we can send you a copy immediately.
 */

require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/sofortbanking.php';

/* If PS 1.5 or higher redirect to module controller */
if (version_compare(_PS_VERSION_, '1.5', '>='))
	Tools::redirect(Context::getContext()->link->getModuleLink('sofortbanking', 'payment').'?token='.Tools::getValue('token'));
else
{

	$controller = new FrontController();
	$controller->init();
	$controller->auth = true;

	/* Check if token is valid */
	if (Configuration::get('PS_TOKEN_ENABLE') && !(strcasecmp(Tools::getToken(false), Tools::getValue('token')) == 0))
		Tools::redirect('order.php', 'order=back.php');

	$controller->setMedia();
	$controller->displayHeader();

	$sofortbanking = new sofortbanking();

	/* Build and display payment page */
	echo $sofortbanking->backwardPaymentController();

	$controller->displayFooter();

}

?>