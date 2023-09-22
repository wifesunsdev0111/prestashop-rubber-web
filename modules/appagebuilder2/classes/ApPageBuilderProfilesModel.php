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

class ApPageBuilderProfilesModel extends ObjectModel
{
    public $name;
    public $params;
    public $page;
    public $profile_key;
    public $header;
    public $content;
    public $footer;
    public $product;
    public $active;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'appagebuilder_profiles',
        'primary' => 'id_appagebuilder_profiles',
        'multilang' => false,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'page' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'profile_key' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'header' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'content' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'footer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' => array('type' => self::TYPE_BOOL, 'shop' => true, 'validate' => 'isBool'),
            'params' => array('type' => self::TYPE_HTML)
        )
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null, Context $context = null)
    {
        // validate module
        unset($context);
        parent::__construct($id, $id_lang, $id_shop);
    }

    public function toggleStatus()
    {
        $this->deActiveAll($this->page);
        return true;
    }

    public function deActiveAll($page)
    {
        // validate module
        unset($page);
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        //$where = ' WHERE ps.id_shop='.$id_shop." AND ps.id_appagebuilder_profiles != '".(int)$this->id."'";
        $where = ' WHERE ps.id_shop='.(int)$id_shop;
        Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps set ps.active = 0 '.$where);
        $where = ' WHERE ps.id_shop='.$id_shop." AND ps.id_appagebuilder_profiles = '".(int)$this->id."'";
        Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps set ps.active = 1 '.$where);
    }

    public function getAllProfileByShop()
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $where = ' WHERE id_shop='.(int)$id_shop;
        $sql = 'SELECT p.*, ps.*
			 FROM '._DB_PREFIX_.'appagebuilder_profiles p 
			 INNER JOIN '._DB_PREFIX_.'appagebuilder_profiles_shop ps ON (ps.id_appagebuilder_profiles = p.id_appagebuilder_profiles)'
                .$where;
        return Db::getInstance()->executes($sql);
    }

    public function add($autodate = true, $null_values = false)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'appagebuilder_profiles_shop` (`id_shop`, `id_appagebuilder_profiles`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.')'
        );
        if (Db::getInstance()->getValue('SELECT COUNT(p.`id_appagebuilder_profiles`) AS total FROM `'._DB_PREFIX_.'appagebuilder_profiles` p 
				INNER JOIN `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps ON(p.id_appagebuilder_profiles = ps.id_appagebuilder_profiles) 
				WHERE id_shop='.(int)$id_shop) <= 1)
            $this->deActiveAll($this->page);
        else if ($this->active) {
            $this->deActiveAll($this->page);
        }
        return $res;
    }

    public function update($null_values = false)
    {
        // validate module
        unset($null_values);
        if ($this->active) {
            $this->deActiveAll($this->page);
        }

        return parent::update();
    }

    public function getProfilesInPage($id = 0)
    {
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $where = ' WHERE ps.id_shop='.$id_shop." AND p.page='".pSQL($this->page)."'";
        if ($id) {
            $where .= ' AND p.id_appagebuilder_profiles !='.(int)$id;
        }
        $inner_join = 'INNER JOIN `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps ON (ps.id_appagebuilder_profiles = p.id_appagebuilder_profiles)';
        $sql = 'SELECT p.* from `'._DB_PREFIX_.'appagebuilder_profiles` p '.$inner_join.$where;
        return Db::getInstance()->executes($sql);
    }

    public static function getActiveProfile($page)
    {
        // validate module
        unset($page);

        # Fix bug http://screencast.com/t/flCEjya6
        $updatePositions = Tools::getValue('action');
        $ajax = Tools::getValue('ajax');
        if($updatePositions == 'updatePositions' && $ajax == '1'){
            return null;
        }

        $result = null;
        try {
            $context = Context::getContext();
            $id_shop = $context->shop->id;
            $id_profile = Tools::getIsset('id_appagebuilder_profiles') ? Tools::getValue('id_appagebuilder_profiles') : '';
            //check cookie
            $is_use_co = Configuration::get('APPAGEBUILDER_COOKIE_PROFILE');
            if ($is_use_co) {
                if (!$id_profile && $context->cookie->ap_profile) {
                    $id_profile = $context->cookie->ap_profile;
                }
                else {
                    $context->cookie->ap_profile = $id_profile;
                }
            }

            $id_lang = $context->language->id;
            $cache_id = 'ApPageBuilderProfilesModel::getActiveProfile_'.md5((int)$id_profile.(int)$id_lang.(int)$id_shop);
            if (!Cache::isStored($cache_id)) {
                if ($id_profile) {
                    $where = ' WHERE ps.id_shop='.$id_shop.' AND p.id_appagebuilder_profiles='.(int)$id_profile;
                }
                else {
                    $where = ' WHERE ps.id_shop='.(int)$id_shop.' AND ps.active=1 ';
                }
                $inner_join = 'INNER JOIN `'._DB_PREFIX_.'appagebuilder_profiles_shop` ps ON (ps.id_appagebuilder_profiles = p.id_appagebuilder_profiles)';
                $sql = 'SELECT p.* from `'._DB_PREFIX_.'appagebuilder_profiles` p '.$inner_join.$where;
                $result = Db::getInstance()->getRow($sql);
                Cache::store($cache_id, $result);
            } else {
                $result = Cache::retrieve($cache_id);
            }
        } catch (Exception $ex) {
            $result = null;
        }
        foreach (array('header', 'content', 'footer', 'product') as $val) {
            $pos_key = 'ap_'.$val;
            if (Tools::getIsset($val)) {
                $result[$val] = Tools::getValue($val);
                $context->cookie->{$pos_key} = $result[$val];
            } else if ($is_use_co && $context->cookie->{$pos_key}) {
                $result[$val] = $context->cookie->{$pos_key};
            }
        }

        return $result;
    }

    public function getProfile($id)
    {
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_profiles` WHERE id_appagebuilder_profiles='.(int)$id;
        $object = Db::getInstance()->getRow($sql);
        return $object ? $object : null;
    }

    public function duplicateProfile($id, $name, $profile_key, $id_shop)
    {
        $new_id = 0;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_profiles` WHERE id_appagebuilder_profiles='.(int)$id;
        $object_duplicated = Db::getInstance()->getRow($sql);
        if ($object_duplicated) {
            $sql = 'INSERT INTO `'._DB_PREFIX_.'appagebuilder_profiles`(name, profile_key, page, active) VALUES("'
                    .$name.$object_duplicated['name'].'", "'.pSQL($profile_key).'", "index", 0)';
            Db::getInstance()->execute($sql);
            $new_id = Db::getInstance()->Insert_ID();
            $sql = 'INSERT INTO `'._DB_PREFIX_.'appagebuilder_profiles_shop`(id_appagebuilder_profiles, id_shop) VALUES('
                    .(int)$new_id.', '.(int)$id_shop.')';
            Db::getInstance()->execute($sql);
            return $new_id;
        }
        return 0;
    }

    public function customDuplicateObject($message)
    {
        $object_duplicated = parent::duplicateObject();
        $object_duplicated->active = 0;
        $object_duplicated->name = $message.' '.$object_duplicated->name;
        return $object_duplicated;
    }

    public function save($null_values = false, $autodate = true)
    {
        // validate module
        unset($null_values);
        unset($autodate);
        $context = Context::getContext();
        $this->id_shop = $context->shop->id;
        if ($this->active) {
            $this->deActiveAll($this->page);
        }
        return parent::save();
    }

    public static function deleteById($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_profiles` WHERE id_appagebuilder_profiles='.(int)$id;
        $object_duplicated = Db::getInstance()->getRow($sql);
        if ($object_duplicated) {
            $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_profiles` WHERE id_appagebuilder_profiles='.(int)$id;
            Db::getInstance()->execute($sql);
            $sql = 'DELETE FROM `'._DB_PREFIX_.'appagebuilder_profiles_shop` WHERE id_appagebuilder_profiles='.(int)$id;
            Db::getInstance()->execute($sql);
            return $object_duplicated;
        }
        return array();
    }

    public function getPositionsForProfile($id_positions)
    {
        if ($id_positions) {
            $sql = 'SELECT * FROM `'._DB_PREFIX_.'appagebuilder_positions` WHERE id_appagebuilder_positions IN('.pSQL($id_positions).')';
            return Db::getInstance()->executes($sql);
        }
        return array();
    }
}
