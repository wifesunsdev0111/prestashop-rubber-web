<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ets_hb_html_box` (
    `id_ets_hb_html_box` int(11) NOT NULL AUTO_INCREMENT,
    `id_shop` int(11) UNSIGNED NOT NULL DEFAULT 1,
    `name` varchar(50) NULL,
    `style` text NULL,
    `active` tinyint(1) NOT NULL,
    PRIMARY KEY  (`id_ets_hb_html_box`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';
$sql[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_hb_html_box_lang` (
        `id_ets_hb_html_box_lang` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `id_ets_hb_html_box` int(11) unsigned NOT NULL,
        `id_lang` int(10) unsigned NOT NULL,
        `html` text NOT NULL,
        PRIMARY KEY (`id_ets_hb_html_box_lang`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sql[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_hb_html_box_position` (
        `id_ets_hb_html_box_position` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_ets_hb_html_box` int(11) unsigned NOT NULL,
        `position` int(11) unsigned NOT NULL,
        PRIMARY KEY (`id_ets_hb_html_box_position`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
