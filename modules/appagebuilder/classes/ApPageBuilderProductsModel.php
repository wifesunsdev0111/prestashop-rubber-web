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

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/shortcodes.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php');

class ApPageBuilderProductsModel extends ObjectModel
{
    public $name;
    public $params;
    public $type;
    public $active;
    public $plist_key;
    public $class;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'appagebuilder_products',
        'primary' => 'id_appagebuilder_products',
        'multilang' => false,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'plist_key' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'type' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'active' => array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'params' => array('type' => self::TYPE_HTML),
            'class' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
        )
    );

    public function getAllProductProfileByShop()
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $where = ' WHERE id_shop='.(int)$id_shop;
        $sql = 'SELECT p.*, ps.*
				 FROM '._DB_PREFIX_.'appagebuilder_products p 
				 INNER JOIN '._DB_PREFIX_.'appagebuilder_products_shop ps ON (ps.id_appagebuilder_products = p.id_appagebuilder_products)'
                .$where;
        return Db::getInstance()->executes($sql);
    }

    public function __construct($id = null, $id_lang = null, $id_shop = null, Context $context = null)
    {
        // validate module
        unset($context);
        parent::__construct($id, $id_lang, $id_shop);
    }

    public function add($autodate = true, $null_values = false)
    {
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;
        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'appagebuilder_products_shop` (`id_shop`, `id_appagebuilder_products`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.')'
        );
        if (Db::getInstance()->getValue('SELECT COUNT(p.`id_appagebuilder_products`) AS total FROM `'
                        ._DB_PREFIX_.'appagebuilder_products` p INNER JOIN `'
                        ._DB_PREFIX_.'appagebuilder_products_shop` ps ON(p.id_appagebuilder_products = ps.id_appagebuilder_products) WHERE id_shop='
                        .(int)$id_shop) <= 1) {
            $this->deActiveAll();
        } else if ($this->active) {
            $this->deActiveAll($this->page);
        }
        return $res;
    }

    public function toggleStatus()
    {
        $this->deActiveAll();
        return true;
    }

    public function deActiveAll()
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $sql = 'UPDATE '._DB_PREFIX_.'appagebuilder_products_shop SET active=0 where id_shop='.(int)$id_shop;
        Db::getInstance()->execute($sql);
        $where = ' WHERE ps.id_shop='.(int)$id_shop." AND ps.id_appagebuilder_products = '".(int)$this->id."'";
        Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'appagebuilder_products_shop` ps set ps.active = 1 '.$where);
    }

    public static function getActive()
    {
        $id_shop = Context::getContext()->shop->id;
        if (Tools::getIsset('plist_key') && Tools::getValue('plist_key')) {
            // validate module
            $where = " p.plist_key='".pSQL(Tools::getValue('plist_key'))."' and ps.id_shop=".(int)$id_shop;
        } else {
            // validate module
            $where = ' ps.active=1 and ps.id_shop='.$id_shop;
        }

        $sql = 'SELECT * FROM '._DB_PREFIX_.'appagebuilder_products p
				INNER JOIN '._DB_PREFIX_.'appagebuilder_products_shop ps on(p.id_appagebuilder_products = ps.id_appagebuilder_products) WHERE '
                .$where;
        return Db::getInstance()->getRow($sql);
    }
}
