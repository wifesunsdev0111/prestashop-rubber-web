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

class OgoneProductSubscription extends ObjectModel
{

    public $id_product = null;

    public $id_product_attribute = null;

    public $installments = null;

    public $first_amount = null;

    public $first_payment_delay = null;

    public $period_unit = null;

    // d, ww or m
    public $period_number = null;

    public $period_moment = null;

    public $active = null;

    public $description = null;

    public $date_add = null;

    public $date_upd = null;

    /**
     *
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'ogone_product_subscription',
        'primary' => 'id_ogone_product_subscription',
        'multilang' => true,
        'fields' => array(
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
                'validate' => 'isPrice',
            ),
            'first_payment_delay' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
            ),
            'installments' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
            ),
            'period_unit' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isAnything',
            ),
            'period_moment' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
            ),
            'period_number' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
            ),
            'description' => array(
                'type' => self::TYPE_STRING,
                'lang' => true
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool'
            )
        )
    );

    public function getPeriodMoment()
    {
        if ($this->period_unit === Ogone::PERIOD_WEEK) {
            if ((int)$this->period_moment > 0 && (int)$this->period_moment < 8) {
                return $this->period_moment;
            } else {
                return (int)date('w') + 1;
            }
        } elseif ($this->period_unit === Ogone::PERIOD_MONTH) {
            if ((int)$this->period_moment > 0 && (int)$this->period_moment < 32) {
                return $this->period_moment;
            } else {
                return (int)date('j');
            }
        }
        return null;
    }

    public function getStartDate($format = 'Y-m-d')
    {
        $days = $this->first_payment_delay;
        $date = 'today';
        $date .= sprintf(' +%d %s', $days, 'days');
        return date($format, strtotime($date));
    }

    public function getEndDate($format = 'Y-m-d')
    {
        $shift = array(
            'months' => 0,
            'weeks' => 0,
            'days' => $this->first_payment_delay
        );

        switch ($this->period_unit) {
            case Ogone::PERIOD_DAY:
                $shift['days'] = $shift['days'] + $this->installments * $this->period_number;
                break;
            case Ogone::PERIOD_WEEK:
                $shift['weeks'] = $this->installments * $this->period_number;
                break;
            case Ogone::PERIOD_MONTH:
                $shift['months'] = $this->installments * $this->period_number;
                break;
        }

        $shift = array_filter($shift);

        $date = 'today';
        foreach ($shift as $unit => $value) {
            $date .= sprintf(' +%d %s', $value - 1, $unit);
        }

        return date($format, strtotime($date));
    }

    public static function getSubscriptionInstanceForProduct($product_id, $product_attribute_id = 0)
    {
        $query = 'SELECT id_ogone_product_subscription FROM ' . _DB_PREFIX_ . 'ogone_product_subscription ops WHERE ops.id_product = ' . (int)$product_id . ' AND
 ops.id_product_attribute = ' . (int)$product_attribute_id;
        $id = (int)Db::getInstance()->getValue($query);
        if ($id) {
            return new OgoneProductSubscription($id);
        }
        return null;
    }

    public static function getSubscriptionInstancesForCombinations($product_id)
    {
        $result = array();
        $query = 'SELECT id_ogone_product_subscription FROM ' . _DB_PREFIX_ . 'ogone_product_subscription ops WHERE ops.id_product = ' . (int)$product_id . ' AND
 ops.id_product_attribute > 0 ';
        foreach (Db::getInstance()->executeS($query) as $row) {
            $result[] = new OgoneProductSubscription((int)$row['id_ogone_product_subscription']);
        }
        return $result;
    }
}
