<?php
/**
 * 2007-2018 PrestaShop
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
 * @author patworx multimedia GmbH <service@patworx.de>
 * @copyright  2018 patworx multimedia GmbH Sofort.
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

function loadPackage($dir)
{
    $composer = json_decode(file_get_contents("$dir/composer.json"), 1);
    $namespaces = $composer['autoload']['psr-0'];
    
    // Foreach namespace specified in the composer, load the given classes
    foreach ($namespaces as $namespace => $classpaths) {
        if (!is_array($classpaths)) {
            $classpaths = array($classpaths);
        }
        spl_autoload_register(function ($classname) use ($namespace, $classpaths, $dir) {
            // Check if the namespace matches the class we are looking for
            if (preg_match("#^".preg_quote($namespace)."#", $classname)) {
                // Remove the namespace from the file path since it's psr4
                $classname = str_replace($namespace, "", $classname);
                $filename = preg_replace("#\\\\#", "/", $classname).".php";
                foreach ($classpaths as $classpath) { 
                    $fullpath = $dir."/".$classpath."/".str_replace("\\", "/", $namespace).$filename;
                    echo $fullpath;
                    if (file_exists($fullpath)) {
                        include_once $fullpath;
                    }
                }
            }
        });
    }
}

loadPackage(__DIR__);