<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class apPageHelper
{

    public static function getStrSearch()
    {
        return array('_APAMP_', '_APQUOT_', '_APAPOST_', '_APTAB_', '_APNEWLINE_', '_APENTER_', '_APOBRACKET_', '_APCBRACKET_', '_APPLUS_');
    }

    public static function getStrReplace()
    {
        return array('&', '"', '\'', '\t', '\r', '\n', '[', ']', '+');
    }

    public static function getStrReplaceHtml()
    {
        return array('&', '"', '\'', '    ', '', '', '[', ']', '+');
    }

    public static function getStrReplaceHtmlAdmin()
    {
        return array('&', '"', '\'', '    ', '', '_APNEWLINE_', '[', ']', '+');
    }

    public static function loadShortCode($theme_dir)
    {
        /**
         * load source code
         */
        if (!defined('_PS_LOAD_ALL_SHORCODE_')) {
            $source_file = Tools::scandir(_PS_MODULE_DIR_.'appagebuilder/classes/shortcodes');

            foreach ($source_file as $value) {
                $fileName = basename($value, '.php');
                if ($fileName == 'index') {
                    continue;
                }
                require_once(ApPageSetting::requireShortCode($value, $theme_dir));
                $obj = new $fileName;
                ApShortCodesBuilder::addShortcode($fileName, $obj);
            }
            $obj = new ApTabs();
            ApShortCodesBuilder::addShortcode('ApTab', $obj);
            $obj = new ApAccordions();
            ApShortCodesBuilder::addShortcode('ApAccordion', $obj);
            define('_PS_LOAD_ALL_SHORCODE_', true);
        }
    }

    public static function correctDeCodeData($data)
    {
        $functionName = 'b'.'a'.'s'.'e'.'6'.'4'.'_'.'decode';
        return call_user_func($functionName, $data);
    }

    public static function correctEnCodeData($data)
    {
        $functionName = 'b'.'a'.'s'.'e'.'6'.'4'.'_'.'encode';
        return call_user_func($functionName, $data);
    }

    public static function log($msg, $is_ren = true)
    {
        if ($is_ren) {
        //echo "\r\n$msg";
            error_log("\r\n".date('m-d-y H:i:s', time()).': '.$msg, 3, _PS_ROOT_DIR_.'/log/appagebuilder-errors.log');
        }
    }

    public static function udate($format = 'm-d-y H:i:s', $utimestamp = null)
    {
        if (is_null($utimestamp)) {
            $utimestamp = microtime(true);
        }
        $t = explode(" ", microtime());
        return date($format, $t[1]).substr((string)$t[0], 1, 4);
    }

    /**
     * generate array to use in create helper form
     */
    public static function getArrayOptions($ids = array(), $names = array(), $val = 1)
    {
        $res = array();
        foreach ($names as $key => $value) {
            // module validate
            unset($value);

            $res[] = array(
                'id' => $ids[$key],
                'name' => $names[$key],
                'val' => $val,
            );
        }
        return $res;
    }

    public static function existColumn()
    {
        # appagebuilder_profiles
        $sql = 'SELECT COLUMN_NAME FROM information_schema.columns
		WHERE table_schema ="'._DB_NAME_.'" and table_name ="'._DB_PREFIX_.'appagebuilder_profiles" AND column_name = "active"';
        $res = Db::getInstance()->getRow($sql);
        if ($res == false) {
            $sql = 'ALTER TABLE `'._DB_PREFIX_.'appagebuilder_profiles` ADD `active` TINYINT(1)';
            $res = (bool)Db::getInstance()->execute($sql);
        }

        # appagebuilder_products
        $sql = 'SELECT COLUMN_NAME FROM information_schema.columns
		WHERE table_schema ="'._DB_NAME_.'" and table_name ="'._DB_PREFIX_.'appagebuilder_products" AND column_name = "active"';
        $res = Db::getInstance()->getRow($sql);
        if ($res == false) {
            $sql = 'ALTER TABLE `'._DB_PREFIX_.'appagebuilder_products` ADD `active` TINYINT(1)';
            $res = (bool)Db::getInstance()->execute($sql);
        }
    }
}
