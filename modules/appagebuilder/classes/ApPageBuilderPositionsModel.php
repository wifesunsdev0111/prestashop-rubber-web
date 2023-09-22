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

require_once(_PS_MODULE_DIR_.'appagebuilder/libs/apPageHelper.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/shortcodes.php');
require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php');

class ApPageBuilderPositionsModel extends ObjectModel
{
    public $name;
    public $params;
    public $position;
    public $position_key;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'appagebuilder_positions',
        'primary' => 'id_appagebuilder_positions',
        'multilang' => false,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'position' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'position_key' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'params' => array('type' => self::TYPE_HTML)
        )
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null, Context $context = null)
    {
        // validate module
        unset($context);
        parent::__construct($id, $id_lang, $id_shop);
    }

    public static function getProfileUsingPosition($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_profiles` P
				WHERE 
					P.`header`='.(int)$id.'
					OR P.`content`='.(int)$id.'
					OR P.`footer`='.(int)$id;
        //die($sql);
        return Db::getInstance()->executes($sql);
    }

    public function add($autodate = true, $null_values = false)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'appagebuilder_positions_shop` (`id_shop`, `id_appagebuilder_positions`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.')'
        );
        return $res;
    }

    public function addAuto($data)
    {
        $sql = 'INSERT INTO `'._DB_PREFIX_.'appagebuilder_positions` (name, position, position_key)
				VALUES("'.$data['name'].'", "'.$data['position'].'", "'.$data['position_key'].'")';
        Db::getInstance()->execute($sql);
        $id = Db::getInstance()->Insert_ID();
        Db::getInstance()->execute('
		INSERT INTO `'._DB_PREFIX_.'appagebuilder_positions_shop` (`id_shop`, `id_appagebuilder_positions`)
		VALUES('.(int)Context::getContext()->shop->id.', '.(int)$id.')'
        );
        return $id;
    }

    public static function getAllPosition()
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_positions`';
        return Db::getInstance()->getRow($sql);
    }

    public static function getPositionById($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_positions` WHERE id_appagebuilder_positions='.$id;
        return Db::getInstance()->getRow($sql);
    }

    public static function deletePositionById($id, $position)
    {
        $sql = 'DELETE FROM '._DB_PREFIX_.'appagebuilder_shop WHERE id_appagebuilder IN (
					SELECT pa.id_appagebuilder FROM `'._DB_PREFIX_.'appagebuilder` pa 
				WHERE pa.`id_appagebuilder_positions`='.(int)$id.')';
        Db::getInstance()->execute($sql);
        $sql = 'DELETE FROM '._DB_PREFIX_.'appagebuilder_lang WHERE id_appagebuilder IN (
					SELECT pa.id_appagebuilder FROM `'._DB_PREFIX_.'appagebuilder` pa 
				WHERE pa.`id_appagebuilder_positions`='.(int)$id.')';
        Db::getInstance()->execute($sql);
        $sql = 'DELETE FROM '._DB_PREFIX_.'appagebuilder WHERE `id_appagebuilder_positions`='.(int)$id;
        Db::getInstance()->execute($sql);
        $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_positions` WHERE id_appagebuilder_positions='.(int)$id;
        Db::getInstance()->execute($sql);
        $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_positions_shop` WHERE id_appagebuilder_positions='.(int)$id.' 
				AND id_shop='.(int)Context::getContext()->shop->id;
        Db::getInstance()->execute($sql);
        if (in_array($position, array('header', 'content', 'footer', 'product'))) {
            $sql = 'UPDATE '._DB_PREFIX_.'appagebuilder_profiles SET `'.pSQL($position).'`=0 WHERE `'.pSQL($position).'`='.(int)$id;
            Db::getInstance()->execute($sql);
        }
    }

    public static function updateName($id, $name)
    {
        $id = (int)$id;
        if ($id && $name) {
            $sql = 'UPDATE '._DB_PREFIX_.'appagebuilder_positions SET name=\''.pSQL($name).'\' WHERE id_appagebuilder_positions='.(int)$id;
            return Db::getInstance()->execute($sql);
        }
        return false;
    }
}
