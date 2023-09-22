<?php
/**
 * 2007-2017 PrestaShop
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

/**
 * We need it here - even in constructor is too late
 */
if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
    Shop::addTableAssociation('ogone_pm', array('type' => 'shop'));
    Shop::addTableAssociation('ogone_pm_lang', array('type' => 'fk_shop'));
}

/**
 * PM model for Prestashop 1.5+
 */
class OgonePM extends ObjectModel
{

    public $pm;

    public $brand;

    public $name;

    public $description;

    public $position;

    public $active;

    public $date_add;

    public $date_upd;

    public $logo;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ogone_pm',
        'primary' => 'id_ogone_pm',
        'multilang' => true,
        'multilang_shop' => false,
        'fields' => array(
            'pm' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128),
            'brand' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128),
            'active' => array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'description' => array('type' => self::TYPE_STRING, 'lang' => true),
            'name' => array('type' => self::TYPE_STRING, 'lang' => true),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'shop' => true),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );
    public static function getAllIds()
    {
        $result = array();
        $query = 'SELECT id_ogone_pm FROM ' . _DB_PREFIX_ . 'ogone_pm';
        foreach (Db::getInstance()->executeS($query, true, false) as $row) {
            $result[] = (int) $row['id_ogone_pm'];
        }

        return $result;
    }
}
