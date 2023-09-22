<?php
/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2022 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

class Ets_ttn_defines
{
    public static $instance;
    public $context;
    public function __construct()
    {
        $this->context = Context::getContext();
    }
    public static function getInstance()
    {
        if (!(isset(self::$instance)) || !self::$instance) {
            self::$instance = new Ets_ttn_defines();
        }
        return self::$instance;
    }
    public function installDb()
    {
        return Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ttn_review` ( 
        `id_ets_ttn_review` INT(11) NOT NULL AUTO_INCREMENT , 
        `id_product` INT(11) NOT NULL , 
        `id_shop` INT(11) NOT NULL , 
        `avatar` VARCHAR(200) NOT NULL , 
        `additional` VARCHAR(200) NOT NULL , 
        `rate` FLOAT(10,1) NOT NULL , 
        `license` VARCHAR(100) NOT NULL ,
        `enabled` INT(1),
        `position` INT(11),
        `date_add` datetime,
        `date_upd` datetime,
         PRIMARY KEY (`id_ets_ttn_review`),
         INDEX (`id_product`),
         INDEX (`id_shop`)) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci')
        && Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_ttn_review_lang` ( 
        `id_ets_ttn_review` INT(11) NOT NULL , 
        `id_lang` INT(11) NOT NULL , 
        `testimonial` TEXT NOT NULL , 
        PRIMARY KEY (`id_ets_ttn_review`, `id_lang`)) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
    }
    public function unInstallDb(){
        $tables = array(
            'ets_ttn_review',
            'ets_ttn_review_lang',
        );
        if($tables)
        {
            foreach($tables as $table)
               Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . pSQL($table).'`'); 
        }
        return true;
    }
}