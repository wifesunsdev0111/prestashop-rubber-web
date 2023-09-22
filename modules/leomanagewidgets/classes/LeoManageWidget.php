<?php
/* * ****************************************************
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ***************************************************** */

class LeoManageWidget extends ObjectModel
{
	public $id_group;
	public $key_widget;
	public $active;
        public $params;
        public $position;
        public $id_shop;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'leomanagewidget',
		'primary' => 'id_leomanagewidget',
		'multilang' => false,
		'fields' => array(
			'active' =>             array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			'position' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
			'id_group' =>           array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'id_shop' =>           array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'key_widget' =>           array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
			'params' =>                     array('type' => self::TYPE_HTML, 'lang' => false)
		)
	);

	public	function __construct($id_slide = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_slide, $id_lang, $id_shop);
	}

        
        public static function getAllColumn($where = '', $id_shop = 0, $widgetInfo=0){
                $context = Context::getContext();
                if(!$id_shop)
                    $id_shop = $context->shop->id;
                $tmpWhere = " WHERE mw.`id_shop` = ".$id_shop.$where;
                $orderBy = ' ORDER BY `id_group`,`position`';
                
                $sql = 'SELECT mw.* FROM `'._DB_PREFIX_.'leomanagewidget` as mw'.$tmpWhere.$orderBy;
                $resultMW = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
                if(!$widgetInfo) return $resultMW;
                $sql = 'SELECT mw.* FROM `'._DB_PREFIX_.'leowidgets` as mw'.$tmpWhere;
                $resultW = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
                $widgetList = array();
                foreach ($resultW as $row)
                    $widgetList[$row["key_widget"]] = array("name"=>$row["name"],"id"=>$row["id_leowidgets"]);
                foreach ($resultMW as &$row){
                    if(isset($widgetList[$row["key_widget"]])){
                        $row["wid"] = $widgetList[$row["key_widget"]]["id"];
                        $row["name"] = $widgetList[$row["key_widget"]]["name"];
                    }else{
                        $row["wid"] = 0;
                        $row["name"] = '';
                    }
                }
                return $resultMW;
        }

        public static function getAllColumnId($id_shop = 0){
                $context = Context::getContext();
                if(!$id_shop)
                    $id_shop = $context->shop->id;
                $orderBy = ' ORDER BY `id_group`,`position`';
                $tmpWhere = '';
                if($id_shop != -1)
                    $tmpWhere = " WHERE `id_shop` = ".$id_shop;
                $sql = 'SELECT `id_leomanagewidget` FROM `'._DB_PREFIX_.'leomanagewidget` '.$tmpWhere.$orderBy;
                
                $result =  Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
                if(!$result) return array();
                $tmpData = array();
                foreach($result as $val){
                    $tmpData[] = $val["id_leomanagewidget"];
                }
                return $tmpData;
        }
}
