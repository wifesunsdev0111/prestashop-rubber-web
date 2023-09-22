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

class ApPageBuilderModel extends ObjectModel
{
    public $hook_name;
    public $params;
    public $id_appagebuilder_positions;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'appagebuilder',
        'primary' => 'id_appagebuilder',
        'multilang' => true,
        'fields' => array(
            'hook_name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'id_appagebuilder_positions' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'params' => array('type' => self::TYPE_HTML, 'lang' => true)
        )
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null, Context $context = null)
    {
        # validate module
        unset($context);
        parent::__construct($id, $id_lang, $id_shop);
    }

    public function getIdbyHookName($hook_name, $position_id)
    {
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;
        $sql = 'SELECT p.id_appagebuilder 
				FROM '._DB_PREFIX_.'appagebuilder p 
					LEFT JOIN '._DB_PREFIX_.'appagebuilder_shop ps ON (ps.id_appagebuilder = p.id_appagebuilder) 
					WHERE ps.id_shop = '.(int)$id_shop.'
						AND hook_name=\''.pSql($hook_name).'\'
						AND p.id_appagebuilder_positions='.(int)$position_id.' ORDER BY p.id_appagebuilder';
        // apPageHelper::log($sql, 1);
        $result = Db::getInstance()->executeS($sql);
        if (!$result) {
            return false;
        }

        foreach ($result as $value) {
            $sql = 'DELETE FROM '._DB_PREFIX_.'appagebuilder_shop
					WHERE id_appagebuilder IN(SELECT id_appagebuilder
						FROM '._DB_PREFIX_.'appagebuilder
						WHERE hook_name=\''.pSql($hook_name).'\'
						AND id_appagebuilder_positions='.(int)$position_id.'
						AND id_appagebuilder != '.(int)$value['id_appagebuilder'].')';
            Db::getInstance()->execute($sql);

            $sql = 'DELETE FROM '._DB_PREFIX_.'appagebuilder
					WHERE hook_name=\''.pSql($hook_name).'\'
						AND id_appagebuilder_positions='.(int)$position_id.'
						AND id_appagebuilder != '.(int)$value['id_appagebuilder'];
            Db::getInstance()->execute($sql);

            return $value['id_appagebuilder'];
        }
    }

    public function getIdbyHookNameAndProfile($hook_name, $profile, $id_lang)
    {
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;

        //$id_lang = (int)$id_lang;
        if (!$profile->header && !$profile->content && !$profile->footer && !$profile->product) {
            return array();
        }

        $arr = array($profile->header, $profile->content, $profile->footer, $profile->product);

        $sql = 'SELECT p.id_appagebuilder, pl.params
				FROM '._DB_PREFIX_.'appagebuilder p 
					LEFT JOIN '._DB_PREFIX_.'appagebuilder_shop ps ON (ps.id_appagebuilder = p.id_appagebuilder AND id_shop='.(int)$id_shop.')
					LEFT JOIN '._DB_PREFIX_.'appagebuilder_lang pl ON (p.id_appagebuilder = pl.id_appagebuilder AND pl.id_lang='.(int)$id_lang.')
				WHERE p.`hook_name`=\''.$hook_name.'\'
					AND ps.id_shop='.(int)$id_shop.'
					AND pl.id_lang='.(int)$id_lang.'
					AND p.id_appagebuilder_positions IN ('.implode(',', $arr).')
					ORDER BY p.id_appagebuilder';
        return Db::getInstance()->getRow($sql);
    }

    /**
     * getListPositisionByType
     * @param type $type = {all, header, content, footer, product}
     * @return type
     */
    public function getListPositisionByType($type = 'all', $id_shop)
    {
        $str = Tools::strtolower($type);
        $sql = 'SELECT p.* FROM `'._DB_PREFIX_.'appagebuilder_positions` p'
                .' INNER JOIN `'._DB_PREFIX_.'appagebuilder_positions_shop` ps ON (p.id_appagebuilder_positions = ps.id_appagebuilder_positions)';
        if ($type != 'all') {
            $sql .= ' WHERE p.position=\''.pSQL($str).'\' AND ps.id_shop='.(int)$id_shop;
        }

        return Db::getInstance()->executeS($sql, 1);
    }

    public function add($autodate = true, $null_values = false)
    {
        //echo 'BuilderModel method ADD';
        //die;
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);
        $res &= Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'appagebuilder_shop` (`id_shop`, `id_appagebuilder`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.')'
        );
        return $res;
    }

    public function save($null_values = false, $autodate = true)
    {
        # validate module
        unset($null_values);
        unset($autodate);
        $context = Context::getContext();
        $this->id_shop = $context->shop->id;
        return parent::save();
    }

    public function parseData($hook_name, $data, $profile_param)
    {
        ApShortCodesBuilder::$is_front_office = 1;
        ApShortCodesBuilder::$is_gen_html = 1;
        ApShortCodesBuilder::$profile_param = $profile_param;
        $ap_helper = new ApShortCodesBuilder();
        ApShortCodesBuilder::$hook_name = $hook_name;
        $result = $ap_helper->parse($data);
        return $result;
    }

    /**
     * Get all item by position include information: hooks postion and data
     * @param type $pos
     * @param type $id_position
     * @param type $id_profile
     * @param type $is_font
     * @param type $id_lang
     * @return type
     */
    public function getAllItemsByPosition($pos, $id_position, $id_profile = 0, $is_font = 0, $id_lang = 0)
    {
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;
        $id_position = (int)$id_position;
        $id_profile = (int)$id_profile;
        $where = ' WHERE ps.id_shop='.(int)$id_shop.' AND pp.id_appagebuilder_positions='.(int)$id_position;
        if ($id_profile) {
            $where .= ' AND ppr.id_appagebuilder_profiles='.(int)$id_profile;
        }
        if ($id_lang) {
            $where .= ' AND pl.id_lang = '.(int)$id_lang;
        } else {
            $id_lang = $context->language->id;
        }
        $sql = 'SELECT p.*, pl.params, pl.id_lang 
				FROM `'._DB_PREFIX_.'appagebuilder` p 
					LEFT JOIN `'._DB_PREFIX_.'appagebuilder_shop` ps ON (ps.id_appagebuilder = p.id_appagebuilder) 
					LEFT JOIN `'._DB_PREFIX_.'appagebuilder_lang` pl ON (pl.id_appagebuilder = p.id_appagebuilder) 
					LEFT JOIN `'._DB_PREFIX_.'appagebuilder_positions` pp ON (p.id_appagebuilder_positions=pp.id_appagebuilder_positions)
					LEFT JOIN `'._DB_PREFIX_.'appagebuilder_profiles` ppr ON (ppr.'.pSQL($pos).'=pp.id_appagebuilder_positions)
				'.pSql($where).' ORDER BY p.id_appagebuilder';
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $data_lang = array();
        if ($is_font) {
            foreach ($result as $row) {
                $data_lang[$row['hook_name']] = $row['params'];
            }
            return $data_lang;
        }
        $ap_helper = new ApShortCodesBuilder();
        ApShortCodesBuilder::$is_front_office = $is_font;
        ApShortCodesBuilder::$is_gen_html = 1;
        foreach ($result as $row) {
            if (isset($data_lang[$row['id_appagebuilder']])) {
                $data_lang[$row['id_appagebuilder']]['params'][$row['id_lang']] = $row['params'];
            } else {
                $data_lang[$row['id_appagebuilder']] = array(
                    'id' => $row['id_appagebuilder'],
                    'hook_name' => $row['hook_name'],
                );
                $data_lang[$row['id_appagebuilder']]['params'][$row['id_lang']] = $row['params'];
            }
        }
        //$data_hook = array_flip(ApPageSetting::getHookHome());
        $hook_config = Configuration::get(Tools::strtoupper($pos).'_HOOK');
        $hook_config = explode(',', $hook_config ? $hook_config : ApPageSetting::getHook($pos));
        $data_hook = array_flip($hook_config);
        foreach ($data_lang as $row) {
            //process params
            foreach ($row['params'] as $key => $value) {
                ApShortCodesBuilder::$lang_id = $key;
                if ($key == $id_lang) {
                    ApShortCodesBuilder::$is_gen_html = 1;
                    $row['content'] = $ap_helper->parse($value);
                } else {
                    ApShortCodesBuilder::$is_gen_html = 0;
                    $ap_helper->parse($value);
                }
            }
            $data_hook[$row['hook_name']] = $row;
        }
        return array('content' => $data_hook, 'dataForm' => ApShortCodesBuilder::$data_form);
    }

    /**
     * Get all items - datas of all hooks by shop Id, lang Id for front-end or back-end
     * @param type $list_pos_id array
     */
    public function getAllItemsByPositionId($list_pos_id)
    {
        if ($list_pos_id) {
            $sql = 'SELECT DISTINCT(id_appagebuilder) as id FROM `'._DB_PREFIX_.'appagebuilder` p
					WHERE id_appagebuilder_positions IN('.implode($list_pos_id, ',').')';
            return Db::getInstance()->executes($sql);
        }
        return array();
    }

    /**
     * Get all items - datas of all hooks by shop Id, lang Id for front-end or back-end
     * @param type $id_profiles
     * @param type $is_font (=0: for back-end; =1: for front-end)
     * @param type $id_lang
     * @return type
     */
    public function getAllItems($profile, $is_font = 0, $id_lang = 0)
    {
        //print_r("Input: $id_profiles - $is_font - $id_lang"); 2-1-1
        $context = Context::getContext();
//		$id_profiles = (int)$profile['id_appagebuilder_profiles'];
        $id_shop = (int)$context->shop->id;
        $id_lang = $id_lang ? (int)$id_lang : (int)$context->language->id;
        if (!$profile['header'] && !$profile['content'] && !$profile['footer'] && !$profile['product']) {
            return array();
        }

        $arr = array($profile['header'], $profile['content'], $profile['footer'], $profile['product']);

        $sql = 'SELECT p.*, pl.params, pl.id_lang 
				FROM '._DB_PREFIX_.'appagebuilder p 
					LEFT JOIN '._DB_PREFIX_.'appagebuilder_shop ps ON (ps.id_appagebuilder = p.id_appagebuilder AND id_shop='.(int)$id_shop.') 
					LEFT JOIN '._DB_PREFIX_.'appagebuilder_lang pl ON (pl.id_appagebuilder = p.id_appagebuilder)
				WHERE 
					pl.id_lang='.$id_lang.'
					AND ps.id_shop='.(int)$id_shop.'
					AND p.id_appagebuilder_positions IN ('.implode(',', $arr).')
				ORDER BY p.id_appagebuilder';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        //echo '<pre>';print_r($result);die;
        $data_lang = array();
        if ($is_font) {
            foreach ($result as $row) {
                $data_lang[$row['hook_name']] = $row['params'];
            }
            return $data_lang;
        }
        $ap_helper = new ApShortCodesBuilder();
        ApShortCodesBuilder::$is_front_office = $is_font;
        ApShortCodesBuilder::$is_gen_html = 1;
        foreach ($result as $row) {
            if (isset($data_lang[$row['id_appagebuilder']])) {
                $data_lang[$row['id_appagebuilder']]['params'][$row['id_lang']] = $row['params'];
            } else {
                $data_lang[$row['id_appagebuilder']] = array(
                    'id' => $row['id_appagebuilder'],
                    'hook_name' => $row['hook_name'],
                );
                $data_lang[$row['id_appagebuilder']]['params'][$row['id_lang']] = $row['params'];
            }
        }
        $data_hook = array_flip(ApPageSetting::getHookHome());
        foreach ($data_lang as $row) {
            //process params
            foreach ($row['params'] as $key => $value) {
                ApShortCodesBuilder::$lang_id = $key;
                if ($key == $id_lang) {
                    ApShortCodesBuilder::$is_gen_html = 1;
                    $row['content'] = $ap_helper->parse($value);
                } else {
                    ApShortCodesBuilder::$is_gen_html = 0;
                    $ap_helper->parse($value);
                }
            }
            $data_hook[$row['hook_name']] = $row;
        }

        return array('content' => $data_hook, 'dataForm' => ApShortCodesBuilder::$data_form);
    }

    public function getAllStoreByShop()
    {
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;
        $id_lang = (int)$context->language->id;
        //$where = ' WHERE id_shop="'.$id_shop.'"';
        $sql = '
			SELECT  a.*, cl.name country, st.name state
			FROM '._DB_PREFIX_.'store a
				LEFT JOIN '._DB_PREFIX_.'country_lang cl
				ON (cl.id_country = a.id_country
				AND cl.id_lang = '.(int)$id_lang.')
				LEFT JOIN '._DB_PREFIX_.'state st
				ON (st.id_state = a.id_state) 
			WHERE a.id_store IN (
				SELECT sa.id_store
				FROM '._DB_PREFIX_.'store_shop sa
				WHERE sa.id_shop = '.(int)$id_shop.'
			)';
        return Db::getInstance()->executes($sql);
    }

    public function findOtherProfileUsePosition($id_position, $id_profile)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'appagebuilder_profiles ap 
				WHERE (ap.`header`='.(int)$id_position.' OR ap.`content`='.(int)$id_position.'
					OR ap.`footer`='.(int)$id_position.' OR ap.`product`='.(int)$id_position.')
					AND ap.`id_appagebuilder_profiles`<>'.(int)$id_profile;
        return Db::getInstance()->executes($sql);
    }

    public function updateAppagebuilderLang($id, $id_lang, $params)
    {
        //can not use psql, because pramram is import function
        $data = array('params' => $params);
        Db::getInstance()->update('appagebuilder_lang', $data, 'id_appagebuilder='.(int)$id.' AND id_lang='.(int)$id_lang);
    }
}
