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

class OgoneSubscription extends ObjectModel
{

    public $id_subscription = null;

    public $id_cart = null;

    public $id_customer = null;

    public $id_product = null;

    public $id_product_attribute = null;

    public $first_amount = null;

    public $first_payment_delay = null;

    public $installments = null;

    public $period_unit = null;
 // d, ww or m
    public $period_number = null;

    public $period_moment = null;

    public $start_date = null;

    public $end_date = null;

    public $com = null;

    public $status = null;

    public $comment = null;

    public $cn = null;

    public $payid = null;

    public $date_add = null;

    public $date_upd = null;

    // @todo add amount
    public $active = null;

    /**
     *
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ogone_subscription',
        'primary' => 'id_ogone_subscription',
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
            'id_customer' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'id_product' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'id_product_attribute' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),

            'first_amount' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isPrice'
            ),
            'first_payment_delay' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'installments' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'period_unit' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'period_number' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'period_moment' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),

            'start_date' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'end_date' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),

            'com' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'status' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'comment' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'cn' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),
            'payid' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything'
            ),

            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool'
            )
        )
    );

    public static function createFromSubscriptionProduct($product_subscription)
    {
        $subscription = new OgoneSubscription();
        $subscription->id_subscription = $product_subscription->id;
        $subscription->id_product = $product_subscription->id_product;
        $subscription->id_product_attribute = $product_subscription->id_product_attribute;
        $subscription->first_amount = $product_subscription->first_amount;
        $subscription->installments = $product_subscription->installments;
        $subscription->period_unit = $product_subscription->period_unit;
        $subscription->period_number = $product_subscription->period_number;
        $subscription->period_moment = $product_subscription->period_moment;
        $subscription->start_date = date('Y-m-d');
        $subscription->active = $product_subscription->active;

        $units = $subscription->period_number * $subscription->installments;

        switch ($subscription->period_unit) {
            case 'mm':
                $period = 'months';
                break;
            case 'ww':
                $period = 'weeks';
                break;
            default:
                $period = 'days';
                break;
        }
        $subscription->end_date = date('Y-m-d', strtotime(sprintf('today +%d %s', $units - 1, $period)));
        return $subscription;
    }

    public static function getCustomerSubscriptionsInstances($id_customer)
    {
        $result = array();
        foreach (self::getCustomerSubscriptionsIds($id_customer) as $id_subscription) {
            $result[] = new OgoneSubscription($id_subscription);
        }
        return $result;
    }

    public static function getCustomerActiveSubscriptionsInstances($id_customer)
    {
        $result = array();
        foreach (self::getCustomerActiveSubscriptionsIds($id_customer) as $id_subscription) {
            $result[] = new OgoneSubscription($id_subscription);
        }
        return $result;
    }

    public function hasStarted()
    {
        return date('Y-m-d', strtotime($this->start_date)) < date('Y-m-d', time());
    }

    public function hasEnded()
    {
        return date('Y-m-d', strtotime($this->end_date)) < date('Y-m-d');
    }

    public function isInTrain()
    {
        return $this->hasStarted() && !$this->hasEnded();
    }

    public function getStartDate($format = 'Y-m-d')
    {
        return date($format, strtotime($this->start_date));
    }

    public function getPeriodMoment()
    {
        return $this->period_moment;
    }

    public function getEndDate($format = 'Y-m-d')
    {
        return date($format, strtotime($this->end_date));
    }

    public static function getCustomerActiveSubscriptions($id_customer)
    {
        // @todo ass shop association on cart
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'ogone_subscription WHERE active = 1 AND id_customer = ' . (int)$id_customer . ' ORDER BY end_date ASC, start_date ASC';
        return Db::getInstance()->executeS($query);
    }

    public static function getCustomerSubscriptionsIds($id_customer)
    {
        // @todo ass shop association on cart
        $result = array();
        $query = 'SELECT id_ogone_subscription FROM ' . _DB_PREFIX_ . 'ogone_subscription WHERE  id_customer = ' . (int)$id_customer . ' ORDER BY end_date DESC, start_date ASC';
        foreach (Db::getInstance()->executeS($query) as $row) {
            $result[] = (int)$row['id_ogone_subscription'];
        }
        return $result;
    }

    public static function getCustomerActiveSubscriptionsIds($id_customer)
    {
        // @todo ass shop association on cart
        $result = array();
        $query = 'SELECT id_ogone_subscription FROM ' . _DB_PREFIX_ . 'ogone_subscription WHERE active = 1 AND id_customer = ' . (int)$id_customer . ' ORDER BY end_date DESC, start_date ASC';
        foreach (Db::getInstance()->executeS($query) as $row) {
            $result[] = (int)$row['id_ogone_subscription'];
        }
        return $result;
    }

    public static function getSubscriptionInstanceByCartId($id_cart)
    {
        $row = self::getSubscriptionByCartId($id_cart);
        if ($row && isset($row['id_ogone_subscription'])) {
            return new OgoneSubscription($row['id_ogone_subscription']);
        }
        return null;
    }

    public static function getSubscriptionByCartId($id_cart)
    {
        // @todo ass shop association on cart
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'ogone_subscription WHERE active = 1 AND id_cart = ' . (int)$id_cart . ' ORDER BY id_ogone_subscription DESC';
        return Db::getInstance()->getRow($query);
    }

    public static function extractCartAndUserIds($subscription_id)
    {
        $subscription_id = Tools::getValue('subscription_id');
        preg_match('/c(\d+)u(\d+)d(\d+)/', $subscription_id, $matches);
        if ($matches) {
            return array(
                $matches[1],
                $matches[2]
            );
        }
        return array(
            null,
            null
        );
    }

    // returns yes if subscription was stopped
    public function getInstallmentsList()
    {
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'ogone_order_subscription WHERE id_subscription =' . (int)$this->id . ' ORDER BY date_add ASC';
        return Db::getInstance()->executeS($query);
    }

    public function getInstallmentsIds()
    {
        return OgoneOrderSubscription::getIdsBySubscriptionId($this->id);
    }

    public function getInstallmentsInstances()
    {
        return OgoneOrderSubscription::getInstancesBySubscriptionId($this->id);
    }

    public function getTotalPaid()
    {
        $results = array();
        foreach ($this->getInstallmentsInstances() as $os) {
            $order = new Order($os->id_order);
            $results[$os->id_order] = $order->total_paid_real;
        }
        return array_sum($results);
    }

    /*
     * // gets order associated with this subscription
     * public function getOrder(){}
     *
     *
     * // get list of all subscriptions in chain
     * public function getAll(){}
     *
     * // get last subscription in chain
     * public function getLast(){}
     *
     * // get first subscription in chain
     * public function getFirst(){}
     *
     * // get ids of all subscriptions in chain
     * public function getAllIds(){}
     *
     * // get id of last subscription in chain
     * public function getLastId(){}
     *
     * // get id of first subscription in chain
     * public function getFirstId(){}
     *
     * // creates next installement
     * public function createNext(){}
     *
     * // returns yes if subscription has reached end
     * public function isFinished(){}
     *
     * // returns yes if subscription was stopped
     * public function isStopped(){}
     *
     *
     *
     * // stops subscription
     * public function stop(){}
     *
     * // duplicates underlying order
     * public function duplicateOrder(){}
     *
     */
}
