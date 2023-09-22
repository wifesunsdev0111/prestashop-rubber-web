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

class HBHtmlboxPosition extends ObjectModel
{
    protected static $instance;
    public $position;
    public static $definition = array(
        'table' => 'ets_hb_html_box_position',
        'primary' => 'id_ets_hb_html_box_position',
        'fields' => array(
            'id_ets_hb_html_box' => array('type' => self::TYPE_INT, 'lang' => false, 'validate' => 'isInt'),
            'position' => array('type' => self::TYPE_INT, 'lang' => false, 'validate' => 'isInt'),
        )
    );

    public function __construct($id_item = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_item, $id_lang, $id_shop);
    }

    public function add($auto_date = true, $null_values = false)
    {
        return parent::add($auto_date, $null_values);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new HBHtmlboxPosition();
        }
        return self::$instance;
    }

    public static function getPosition($id_item = false)
    {
        $row = Db::getInstance()->getRow('
            SELECT GROUP_CONCAT(position) as position 
            FROM `' . _DB_PREFIX_ . 'ets_hb_html_box_position` 
            WHERE id_ets_hb_html_box = ' . (int)$id_item);
        if ($row) {
            return explode(',', $row['position']);
        }
        return $row;
    }

    public static function deletePosition($id = false)
    {
        if ($id) {
            return Db::getInstance()->execute('
            DELETE FROM `' . _DB_PREFIX_ . 'ets_hb_html_box_position` 
            WHERE id_ets_hb_html_box = ' . (int)$id);

        } else {
            return false;
        }
    }
}
