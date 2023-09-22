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
 * Alias model for Prestashop 1.5+
 */
class OgoneAlias extends ObjectModel
{

    public $id_customer;

    public $alias;

    public $active;

    public $cardno;

    public $cn;

    public $brand;

    public $expiry_date;

    public $date_add;

    public $date_upd;

    public $is_temporary;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ogone_alias',
        'primary' => 'id_ogone_alias',
        'fields' => array(
            'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'alias' => array('type' => self::TYPE_STRING),
            'active' => array('type' => self::TYPE_BOOL),
            'cardno' => array('type' => self::TYPE_STRING),
            'brand' => array('type' => self::TYPE_STRING),
            'cn' => array('type' => self::TYPE_STRING),
            'expiry_date' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'is_temporary' => array('type' => self::TYPE_INT),
        ),
    );

    public static function getCustomerActiveAliases($id_customer)
    {
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . self::$definition['table'] .
        ' WHERE id_customer = ' . (int) $id_customer . ' AND active = 1 AND (expiry_date > DATE(NOW()) OR expiry_date = "0000-00-00 00:00:00")';
        return Db::getInstance()->executeS($query);
    }

    public static function getByAlias($alias)
    {
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . self::$definition['table'] . ' WHERE alias = "' . pSql($alias) . '"';
        return Db::getInstance()->getRow($query);
    }

    public function toArray()
    {
        return $this->getFields();
    }
}
