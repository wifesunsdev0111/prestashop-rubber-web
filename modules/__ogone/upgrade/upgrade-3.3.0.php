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
function upgrade_module_3_3_0($module)
{
    $log_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'upgrade.' . date('YmdHis') . '.log';

    file_put_contents($log_file, 'Upgrading to 3.3.0' . PHP_EOL, FILE_APPEND);
    $result = Configuration::updateValue('OGONE_SKIP_AC', 0) &&
            Configuration::updateValue('OGONE_MAKE_IP', 0) &&
            Configuration::updateValue('OGONE_DISPLAY_FRAUD_SCORING', 0) &&
            Configuration::updateValue('OGONE_PROPOSE_ALIAS', 0) &&
            Configuration::updateValue('OGONE_DONT_STORE_ALIAS', 0);

    $alias_pm = Configuration::get('OGONE_ALIAS_PM');
    $new_alias_pm = array(
        'CreditCard' => 0,
        'DirectDebits DE' => 0,
        'DirectDebits NL' => 0,
        'DirectDebits AT' => 0,
    );
    if (isset($new_alias_pm[$alias_pm])) {
        $new_alias_pm[$alias_pm] = 1;
    }
    Configuration::updateValue('OGONE_ALIAS_PM', Tools::jsonEncode($new_alias_pm));

    try {
        $query = 'SHOW CREATE TABLE ' ._DB_PREFIX_.'ogone_alias'; /* to verify existence of index */
        file_put_contents($log_file, $query . PHP_EOL, FILE_APPEND);
        $sql = Db::getInstance()->executeS($query);
        $create_table = (is_array($sql) && isset($sql[0]['Create Table']) ? $sql[0]['Create Table'] : '');
        file_put_contents($log_file, var_export($create_table, true) . PHP_EOL, FILE_APPEND);
        $is_temporary = stristr($create_table, 'is_temporary');
        file_put_contents($log_file, var_export($is_temporary, true) . PHP_EOL, FILE_APPEND);
        if (!$is_temporary) {
            file_put_contents($log_file, 'Adding "is_temporary" field' . PHP_EOL, FILE_APPEND);
            Db::getInstance()->execute('ALTER TABLE '._DB_PREFIX_.'ogone_alias ADD is_temporary INT(1) NOT NULL DEFAULT "0" , ADD INDEX (is_temporary)');
        } else {
            file_put_contents($log_file, 'Field "is_temporary" already present' . PHP_EOL, FILE_APPEND);
        }
    } catch (Exception $ex) {
        file_put_contents($log_file, $ex->getMessage() . PHP_EOL, FILE_APPEND);
        $result = false;
    }

    $new_paos_names = array (
        'OGONE_PAYMENT_AUTHORIZED' => array('en' => 'Ingenico ePayments - payment reserved', 'fr' => 'Ingenico ePayments - paiement reservé'),
        'OGONE_PAYMENT_IN_PROGRESS' => array('en' => 'Ingenico ePayments - payment in progress', 'fr' => 'Ingenico ePayments - paiement en cours'),
        'OGONE_PAYMENT_UNCERTAIN' => array('en' => 'Ingenico ePayments - payment uncertain', 'fr' => 'Ingenico ePayments - paiement incertain'),
    );

    foreach ($new_paos_names as $state_var_name => $names) {
        $order_state = new OrderState((int)Configuration::get($state_var_name));
        if ($result && Validate::isLoadedObject($order_state)) {
            foreach (array_keys($order_state->name) as $id_lang) {
                $lang = new Language($id_lang);
                $iso_code = Tools::strtolower($lang->iso_code);
                if (isset($names[$iso_code])) {
                    $order_state->name[(int)$id_lang] = $names[$iso_code];
                }
            }
            if (!$order_state->update()) {
                $result = false;
            }
        }

        if (version_compare(_PS_VERSION_, '1.5', 'ge') && is_callable('Cache', 'clean')) {
            Cache::clean('OrderState::getOrderStates*');
        }
    }
    $tabs = array(
        'AdminOgoneTransactions' => $module->l('Ingenico ePayments Transactions'),
        'AdminOgoneOrders' => $module->l('Ingenico ePayments Orders'),
    );
    foreach ($tabs as $class_name => $name) {
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $class_name = $class_name.'14';
        }
        $tab_id = Tab::getIdFromClassName($class_name);
        if (!$tab_id) {
            continue;
        }
        $tab = new Tab($tab_id);
        foreach (Language::getLanguages(false) as $language) {
            $tab->name[(int) $language['id_lang']] = $module->l($name);
        }
        $tab->update();
    }

    file_put_contents($log_file, ($result ? 'Module updated': 'Update failed') . PHP_EOL, FILE_APPEND);

    return $result;
}
