<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2017 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

require_once dirname(__FILE__) . '/../../config/config.inc.php';

$token =  Tools::getValue('token');
$id_cart = Tools::getValue('id_cart');
$secure_key = Tools::getValue('key');

if (empty($token) || md5($id_cart . '-' . $secure_key . '-' . _COOKIE_KEY_) != $token) {
    die('Invalid token');
}

$query = 'SELECT id_order FROM ' . _DB_PREFIX_ . 'orders WHERE id_cart = ' .
    (int)$id_cart . ' AND secure_key = "' . pSQL($secure_key) . '" AND current_state > 0';
$result = Db::getInstance()->getValue($query) ? 'ok' : 'ko';

if (Configuration::get('OGONE_USE_LOG')) {
    $ogone = Module::getInstanceByName('ogone');
    $ogone->log(sprintf('Check waiting order: id_cart: %s secure key: %s result: %s', $id_cart, $secure_key, $result));
}

die($result);
