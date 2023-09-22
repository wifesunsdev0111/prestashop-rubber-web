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
function upgrade_module_3_3_2($module)
{
    $log_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'upgrade.' . date('YmdHis') . '.log';
    file_put_contents($log_file, 'Upgrading to 3.3.2' . PHP_EOL, FILE_APPEND);
    $result = true;

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

    $queries = array(
        'ALTER TABLE '._DB_PREFIX_.'ogone_pm_shop DROP INDEX (id_ogone_pm)',
        'ALTER TABLE '._DB_PREFIX_.'ogone_pm_shop DROP INDEX (id_shop)',
        'ALTER TABLE '._DB_PREFIX_.'ogone_pm_shop DROP INDEX (id_shop_group)',
        'ALTER TABLE '._DB_PREFIX_.'ogone_pm_shop ADD PRIMARY KEY (`id_ogone_pm`,`id_shop`, `id_shop_group`)',
    );

    foreach ($queries as $query) {
        try {
            file_put_contents($log_file, $query . PHP_EOL, FILE_APPEND);
            if (Db::getInstance()->execute($query)) {
                file_put_contents($log_file, ' query result true' . PHP_EOL, FILE_APPEND);
            } else {
                file_put_contents($log_file, ' query result false' . PHP_EOL, FILE_APPEND);
            }
        } catch (Exception $ex) {
            file_put_contents($log_file, $ex->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }

    foreach (OgonePM::getAllIds() as $id) {
        $pm = new OgonePM($id);
        foreach ($pm->name as $key => $name) {
            if (empty($name)) {
                $pm->name[$key] = $pm->brand;
            }
        }
        $pm->save();
    }

    file_put_contents($log_file, ($result ? 'Module updated': 'Update failed') . PHP_EOL, FILE_APPEND);
    return $result;
}
