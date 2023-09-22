<?php
/**
 * 2007-2013 PrestaShop
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

$log_dir =  realpath(_PS_MODULE_DIR_ .  'ogone/' . (Tools::getValue('type') == 'upgrade'  ?  'upgrade/' : 'logs/'));

if ($log_dir === false) {
    die('A "logs" directory does not exist.');
}

if (!$log_file = Tools::getValue('filename')) {
    die('No file has been specified.');
}

$log_file = realpath($log_dir . '/' . $log_file);

if ($log_file === false || strncmp($log_dir, $log_file, Tools::strlen($log_dir)) != 0) {
    die('Invalid file');
}

if (!Tools::getValue('key') || sha1($log_file . Configuration::get('OGONE_PSPID')) !== Tools::getValue('key')) {
    die('Invalid_key');
}

$content_type = 'text';
$fp = fopen($log_file, 'r');

if ($fp === false) {
    die('Unable to open log file.');
}

header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . Tools::getValue('filename') . '"');

ob_clean();
$ret = fpassthru($fp);

fclose($fp);

if ($ret === false) {
    die('Unable to display log file(s).');
}
