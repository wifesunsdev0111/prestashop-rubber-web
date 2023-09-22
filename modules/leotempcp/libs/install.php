<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}
if (!class_exists("LeoThemeControlInstall")) {

    class LeoThemeControlInstall
    {

        public static function checkInstall()
        {
            require_once( dirname(dirname(__FILE__))."/sql/sql.tables.php" );
            $error = true;

            if (isset($query) && !empty($query)) {
                if (!($data = Db::getInstance()->ExecuteS("SHOW TABLES LIKE '"._DB_PREFIX_."leohook'")) && !($data1 = Db::getInstance()->ExecuteS("SHOW TABLES LIKE '"._DB_PREFIX_."leowidgets'"))) {
                    $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $query);
                    $query = str_replace("_MYSQL_ENGINE_", _MYSQL_ENGINE_, $query);
                    $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
                    foreach ($db_data_settings as $query) {
                        $query = trim($query);
                        if (!empty($query)) {
                            if (!Db::getInstance()->Execute($query)) {
                                $error = false;
                            }
                        }
                    }
                }
            }
            if (isset($queryUpgrade)) {
                $query = $queryUpgrade;
                $query = str_replace("_DB_PREFIX_", _DB_PREFIX_, $query);
                $query = str_replace("_MYSQL_ENGINE_", _MYSQL_ENGINE_, $query);
                $db_data_settings = preg_split("/;\s*[\r\n]+/", $query);
                foreach ($db_data_settings as $query) {
                    $query = trim($query);
                    if (!empty($query)) {
                        if (!Db::getInstance()->Execute($query)) {
                            $error = false;
                        }
                    }
                }
            }
            return $error;
        }
    }

}
