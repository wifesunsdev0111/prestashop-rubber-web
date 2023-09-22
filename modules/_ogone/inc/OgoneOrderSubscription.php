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
 * @author PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *          International Registered Trademark & Property of PrestaShop SA
 */

class OgoneOrderSubscription extends ObjectModel
{

    public $id_subscription = null;

    public $id_order = null;

    public $id_cart = null;

    public $id_customer = null;

    public $payid = null;

    public $status = null;

    public $date_add = null;

    public $date_upd = null;

    /**
     *
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ogone_order_subscription',
        'primary' => 'id_ogone_order_subscription',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'id_subscription' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'id_cart' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'id_order' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'id_customer' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),

            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),

            'status' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'payid' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            )
        )
    );

    public static function getInstancesBySubscriptionId($id_subscription)
    {
        $result = array();
        foreach (self::getIdsBySubscriptionId($id_subscription) as $id) {
            $result[] = new OgoneOrderSubscription($id);
        }
        return $result;
    }

    public static function getIdsBySubscriptionId($id_subscription)
    {
        $result = array();
        $query = 'SELECT id_ogone_order_subscription FROM ' . _DB_PREFIX_ . 'ogone_order_subscription WHERE id_subscription =' . (int)$id_subscription . ' ORDER BY id_ogone_order_subscription DESC';
        foreach (Db::getInstance()->executeS($query) as $row) {
            $result[] = (int)$row['id_ogone_order_subscription'];
        }
        return $result;
    }

    public static function getInstanceByOrderId($id_order)
    {
        $query = 'SELECT id_ogone_order_subscription FROM ' . _DB_PREFIX_ . 'ogone_order_subscription WHERE id_order=' . (int)$id_order;
        $id = Db::getInstance()->getValue($query);
        if ($id) {
            return new self($id);
        }
        return null;
    }

    // gets order associated with this subscription
    public function getOrder()
    {
        return new Order($this->id_order);
    }

    // get subscription
    public function getSubscription()
    {
        return new OgoneSubscription($this->id_subscription);
    }

    public static function createFromOrder($order)
    {
        $so = new OgoneOrderSubscription();
        $so->id_cart = $order->id_cart;
        $so->id_order = $order->id;
        $so->id_customer = $order->id_customer;
        if ($so->save() && Validate::isLoadedObject($so)) {
            return $so;
        }
        throw new Exception('Unable to create order subscription object');
    }
}
