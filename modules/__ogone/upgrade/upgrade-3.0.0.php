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
function upgrade_module_3_0_0($module)
{
    $log_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'upgrade.' . date('YmdHis') . '.log';

    file_put_contents($log_file, 'Upgrading to 3.0.0' . PHP_EOL, FILE_APPEND);

    Configuration::updateValue('OGONE_ALIAS_PM', 'CreditCard');
    Configuration::updateValue('OGONE_BGCOLOR', '#ffffff');
    Configuration::updateValue('OGONE_BUTTONBGCOLOR', '');
    Configuration::updateValue('OGONE_BUTTONTXTCOLOR', '#000000');
    Configuration::updateValue('OGONE_DL_PASSWORD', '');
    Configuration::updateValue('OGONE_DL_SHA_IN', '');
    Configuration::updateValue('OGONE_DL_TIMEOUT', 30);
    Configuration::updateValue('OGONE_DL_USER', '');
    Configuration::updateValue('OGONE_FONTTYPE', 'Verdana');
    Configuration::updateValue('OGONE_LOGO', '');
    Configuration::updateValue('OGONE_TBLBGCOLOR', '#ffffff');
    Configuration::updateValue('OGONE_TBLTXTCOLOR', '#000000');
    Configuration::updateValue('OGONE_TITLE', '');
    Configuration::updateValue('OGONE_TXTCOLOR', '#000000');
    Configuration::updateValue('OGONE_USE_ALIAS', 0);
    Configuration::updateValue('OGONE_USE_DL', 0);
    Configuration::updateValue('OGONE_USE_KLARNA', 0);
    Configuration::updateValue('OGONE_USE_PM', 0);
    Configuration::updateValue('OGONE_USE_TPL', 0);
    Configuration::updateValue('OGONE_USE_LOG', 0);

    $ogone_default_name = array();
    $languages = Language::getLanguages(false);
    foreach ($languages as $language) {
        $ogone_default_name[$language['id_lang']] = '';
    }
    $value = Tools::jsonEncode($ogone_default_name);
    Configuration::updateValue('OGONE_DEFAULT_NAME', $value);
    file_put_contents($log_file, 'Configuration upgraded' . PHP_EOL, FILE_APPEND);

    $result = $module->installHooks();
    file_put_contents($log_file, ($result ? 'Hooks installed' : 'Error installing hooks') . PHP_EOL, FILE_APPEND);

    $result = $result && $module->installTabs();
    file_put_contents($log_file, ($result ? 'Tabs installed' : 'Error installing tabs') . PHP_EOL, FILE_APPEND);

    $result = $result && $module->installDbTables();
    file_put_contents($log_file, ($result ? 'DB installed' : 'Error installing DB') . PHP_EOL, FILE_APPEND);

    $result = $result && $module->addDefaultPaymentModes();
    $message = ($result ? 'Default payment methods added' : 'Default payment methods NOT added') . PHP_EOL;
    file_put_contents($log_file, $message, FILE_APPEND);

    if (!file_exists($module->getPMUserLogoDir())) {
        $permissions = fileperms(dirname(__FILE__));
        mkdir($module->getPMUserLogoDir(), $permissions, true);
        copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'index.php', $module->getPMUserLogoDir());
        file_put_contents($log_file, ($result ? 'dir created': 'dir creation failed') . PHP_EOL, FILE_APPEND);
    }

    file_put_contents($log_file, ($result ? 'Module updated': 'Update failed') . PHP_EOL, FILE_APPEND);

    return $result;
}
