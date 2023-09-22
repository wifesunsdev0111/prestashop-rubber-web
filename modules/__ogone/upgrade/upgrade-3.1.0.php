<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
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
 *  @copyright 2007-2014 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Function used to update your module from previous versions to the version 1.1,
 * Don't forget to create one file per version.
 */
function upgrade_module_3_1_0($module)
{
    $log_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'upgrade.' . date('YmdHis') . '.log';

    file_put_contents($log_file, 'Upgrading to 3.1.0' . PHP_EOL, FILE_APPEND);

    $result = Configuration::updateValue('OGONE_ALIAS_BY_DL', 0) &&
              Configuration::updateValue('OGONE_USE_D3D', 0) &&
              Configuration::updateValue('OGONE_WIN3DS', 'MAINW');

    Db::getInstance()->execute("ALTER TABLE `". _DB_PREFIX_ ."ogone_alias` CHANGE `alias` `alias` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");

    file_put_contents($log_file, ($result ? 'Module updated': 'Update failed') . PHP_EOL, FILE_APPEND);

    return $result;
}
