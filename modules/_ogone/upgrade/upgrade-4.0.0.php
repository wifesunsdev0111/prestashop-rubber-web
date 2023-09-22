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
function upgrade_module_4_0_0($module)
{
    $log_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'upgrade.' . date('YmdHis') . '.log';
    file_put_contents($log_file, 'Upgrading to 4.0.0' . PHP_EOL, FILE_APPEND);
    $result = true;

    file_put_contents($log_file, 'Adding scheduled payment configurations' . PHP_EOL, FILE_APPEND);

    $new_configuration = array(
        'OGONE_SP_MINIMUM' => 100,
        'OGONE_SP_INSTALLMENTS' => 3,
        'OGONE_SP_DAYS' => 10,
        'OGONE_SP_OPTION' => 1,
        'OGONE_USE_SP' => 0,
        'OGONE_USE_SUBSCRIPTION' => 0,
        'OGONE_SUB_PERIOD_UNIT' => 'm',
        'OGONE_SUB_PERIOD_NUMBER' => 1,
        'OGONE_SUB_INSTALLMENTS' => 12,
        'OGONE_SUB_PERIOD_MOMENT' => 0,
        'OGONE_SUB_FIRST_AMOUNT' => 0,
        'OGONE_SUB_FIRST_PAYMENT_DELAY' => 0,
    );

    foreach ($new_configuration as $key => $value) {
        if (Configuration::updateValue($key, $value)) {
            file_put_contents($log_file, sprintf('Added configuration variable %s', $key) . PHP_EOL, FILE_APPEND);
        } else {
            file_put_contents($log_file, sprintf('Unable to add configuration variable %s', $key). PHP_EOL, FILE_APPEND);
            $result = false;
        }
    }

    file_put_contents($log_file, sprintf('Adding new statuses') . PHP_EOL, FILE_APPEND);

    $new_statuses= array(
        'OGONE_SUB_PAYMENT_IN_PROGRESS' => array(
            'names' => array('en' => 'Ingenico ePayments - subscription payment in progress', 'fr' => 'Ingenico ePayments - scheduled paiement en cours'),
            'properties' => array('color' => 'royalblue', 'logable' => true, 'paid' => 1, 'pdf_invoice' => 1, 'invoice' => 1),
        ),
        'OGONE_SCH_PAYMENT_IN_PROGRESS' => array(
            'names' => array('en' => 'Ingenico ePayments - scheduled payment in progress', 'fr' => 'Ingenico ePayments - scheduled paiement en cours'),
            'properties' => array('color' => 'royalblue', 'logable' => true, 'paid' => 1, 'pdf_invoice' => 1, 'invoice' => 1),
        )

    );

    $iso = 'en';
    $statuses = $module->getExistingStatuses();
    foreach ($new_statuses as $code => $status) {
        if (isset($statuses[$status['names'][$iso]])) {
            if ((int) Configuration::get($code) !== (int) $statuses[$status['names'][$iso]]) {
                Configuration::updateValue($code, (int) $statuses[$status['names'][$iso]]);
            }
            continue;
        }
        $properties = isset($status['properties']) ? $status['properties'] : array();
        if (!$module->addStatus($code, $status['names'], $properties)) {
            $result = false;
        }
    }
    if (version_compare(_PS_VERSION_, '1.5', 'ge') && is_callable('Cache', 'clean')) {
        Cache::clean('OrderState::getOrderStates*');
    }

    file_put_contents($log_file, sprintf('Adding subscription tables') . PHP_EOL, FILE_APPEND);

    if (!Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'ogone_alias` CHANGE `alias` `alias` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\'')) {
        $result = false;
    }

    if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_product` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product_attribute` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_product_subscription`),
            KEY(`id_product`),
            KEY(`id_product_attribute`),
            KEY(`active`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
        $result = false;
    }

    if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription_shop` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_product_subscription`, `id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
        $result = false;
    }

    if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription_lang` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_lang` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            PRIMARY KEY (`id_ogone_product_subscription`, `id_lang`, `id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
        $result = false;
    }

    if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_subscription` (
            `id_ogone_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_subscription` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_cart` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product_attribute` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `payid` VARCHAR(1024) NOT NULL DEFAULT "",
            `cn` VARCHAR(1024) NOT NULL DEFAULT "",
            `com` VARCHAR(1024) NOT NULL DEFAULT "",
            `comment` VARCHAR(1024) NOT NULL DEFAULT "",
            `status` VARCHAR(1024) NOT NULL DEFAULT "",

            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            `start_date` datetime NOT NULL,
            `end_date` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_subscription`),
            KEY(`id_cart`),
            KEY(`id_subscription`),
            KEY(`id_customer`),
            KEY(`start_date`),
            KEY(`end_date`),
            KEY(`payid`),
            KEY(`active`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
        $result = false;
    }

    if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_order_subscription` (
            `id_ogone_order_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_subscription` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_order` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_cart` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `payid` VARCHAR(1024) NOT NULL DEFAULT "",
            `status` VARCHAR(1024) NOT NULL DEFAULT "",
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_order_subscription`),
            KEY(`id_subscription`),
            KEY(`id_order`),
            KEY(`id_cart`),
            KEY(`payid`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
        $result = false;
    }
    file_put_contents($log_file, 'Adding hooks' . PHP_EOL, FILE_APPEND);

    $hooks = array();
    if (version_compare(_PS_VERSION_, '1.7', 'ge')) {
        $hooks[] = 'paymentOptions';
        $hooks[] = 'paymentReturn';
        $hooks[] = 'displayPaymentByBinaries';
        $hooks[] = 'displayProductAdditionalInfo';
    } elseif (!version_compare(_PS_VERSION_, '1.5', 'lt')) {
        $hooks[] = 'displayProductButtons';
    }

    if (!version_compare(_PS_VERSION_, '1.5', 'lt')) {
        $hooks[] = 'displayAdminProductsExtra';
    }

    if (version_compare(_PS_VERSION_, '1.6', 'ge') && version_compare(_PS_VERSION_, '1.7', 'lt')) {
        $hooks[] = 'actionAfterDeleteProductInCart';
    }

    if (version_compare(_PS_VERSION_, '1.7', 'ge')) {
        $hooks[] = 'actionObjectProductInCartDeleteAfter';
    }

    foreach ($hooks as $hook) {
        $result = $result && $module->registerHook($hook);
    }

    file_put_contents($log_file, ($result ? 'Module updated': 'Update failed') . PHP_EOL, FILE_APPEND);



    return $result;
}
