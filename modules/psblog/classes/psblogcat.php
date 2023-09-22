<?php
/**
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Psblogcat extends ObjectModel
{
    public $id;
    public $id_psblogcat;
    public $image;
    public $icon_class;
    public $id_parent = 1;
    public $is_group = 0;
    public $width;
    public $submenu_width;
    public $colum_width;
    public $submenu_colum_width;
    public $item;
    public $colums = 1;
    public $type;
    public $is_content = 0;
    public $show_title = 1;
    public $type_submenu;
    public $level_depth;
    public $active = 1;
    public $position;
    public $show_sub;
    public $url;
    public $target;
    public $privacy;
    public $position_type;
    public $menu_class;
    public $content;
    public $submenu_content;
    public $level;
    public $left;
    public $right;
    public $date_add;
    public $date_upd;
    # Lang
    public $title;
    public $description;
    public $content_text;
    public $submenu_content_text;
    public $submenu_catids;
    public $is_cattree = 1;
    public $template = '';
    public $meta_keywords = '';
    public $meta_description = '';
    private $shop_url;
    public $link_rewrite = '';
    private $megaConfig = array();
    private $_editStringCol = '';
    private $_isLiveEdit = true;
    private $_module = null;
    public $id_shop = '';
    public $select_data = array();

    public function setModule($module)
    {
        $this->_module = $module;
    }
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'psblogcat',
        'primary' => 'id_psblogcat',
        'multilang' => true,
        'fields' => array(
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName'),
            'id_parent' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'level_depth' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position' => array('type' => self::TYPE_INT),
            'privacy' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'size' => 6),
            'template' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 200),
            'menu_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 25),
            'icon_class' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'size' => 125),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            # Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255),
            'content_text' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString', 'required' => false),
            'meta_description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255, 'required' => false),
            'meta_keywords' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255, 'required' => false),
            'link_rewrite' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
        ),
    );

    public static function findByRewrite($parrams)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $id = 0;
        if(isset($parrams['link_rewrite']) && $parrams['link_rewrite'])
        {
            $sql = 'SELECT cl.id_psblogcat FROM '._DB_PREFIX_.'psblogcat_lang cl';
            $sql .= ' INNER JOIN '._DB_PREFIX_.'psblogcat_shop cs on cl.id_psblogcat=cs.id_psblogcat AND id_shop='.$id_shop;
            $sql .= ' INNER JOIN '._DB_PREFIX_.'psblogcat      cc on cl.id_psblogcat=cc.id_psblogcat AND cl.id_psblogcat != cc.id_parent';  # FIX : PARENT IS NOT THIS CATEGORY
            $sql .= ' WHERE id_lang = ' . $id_lang ." AND link_rewrite = '".$parrams['link_rewrite']."'";

            if($row = Db::getInstance()->getRow($sql))
            {
                $id = $row['id_psblogcat'];
            }
        }
        return new Psblogcat($id, $id_lang);
    }

    public function add($autodate = true, $null_values = false)
    {
        $this->position = self::getLastPosition((int)$this->id_parent);
        $this->level_depth = $this->calcLevelDepth();
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);
        $sql = 'INSERT INTO `'._DB_PREFIX_.'psblogcat_shop` (`id_shop`, `id_psblogcat`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')';
        $res &= Db::getInstance()->execute($sql);
        $this->cleanPositions($this->id_parent);
        return $res;
    }

    public function update($null_values = false)
    {
        $this->level_depth = $this->calcLevelDepth();
        return parent::update($null_values);
    }

    protected function recursiveDelete(&$to_delete, $id_psblogcat)
    {
        if (!is_array($to_delete) || !$id_psblogcat) {
            die(Tools::displayError());
        }

        $result = Db::getInstance()->executeS('
		SELECT `id_psblogcat`
		FROM `'._DB_PREFIX_.'psblogcat`
		WHERE `id_parent` = '.(int)$id_psblogcat);
        foreach ($result as $row) {
            $to_delete[] = (int)$row['id_psblogcat'];
            $this->recursiveDelete($to_delete, (int)$row['id_psblogcat']);
        }
    }

    public function delete()
    {
        if ($this->id == 1) {
            return false;
        }
        $this->clearCache();

        // Get children categories
        $to_delete = array((int)$this->id);
        $this->recursiveDelete($to_delete, (int)$this->id);
        $to_delete = array_unique($to_delete);

        // Delete CMS Category and its child from database
        $list = count($to_delete) > 1 ? implode(',', $to_delete) : (int)$this->id;
        //delete blog
        //get all blog from category ID
        //$where   = '`id_psblogcat` IN (' . $list . ')';
        $result_blog = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT `id_psblog_blog` as id FROM `'._DB_PREFIX_.'psblog_blog` WHERE `id_psblogcat` IN ('.$list.')');
        foreach ($result_blog as $value) {
            $blog = new PsBlogBlog($value['id']);
            $blog->delete();
        }


        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'psblogcat` WHERE `id_psblogcat` IN ('.$list.')');
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'psblogcat_shop` WHERE `id_psblogcat` IN ('.$list.')');
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'psblogcat_lang` WHERE `id_psblogcat` IN ('.$list.')');
        psblogcat::cleanPositions($this->id_parent);
        return true;
    }

    public static function countCats()
    {
        $row = Db::getInstance()->executeS('SELECT COUNT(id_psblogcat) as total FROM `'._DB_PREFIX_.'psblogcat` WHERE  id_psblogcat!=1 AND 1=1');
        return $row[0]['total'];
    }

    public function deleteSelection($menus)
    {
        $return = 1;
        foreach ($menus as $id_psblogcat) {
            $obj_menu = new Psblogcat($id_psblogcat);
            $return &= $obj_menu->delete();
        }
        return $return;
    }

    public function calcLevelDepth()
    {
        $parentpsblogcat = new Psblogcat($this->id_parent);
        if (!$parentpsblogcat) {
            die('parent Menu does not exist');
        }
        return $parentpsblogcat->level_depth + 1;
    }

    public function updatePosition($way, $position)
    {
        $sql = 'SELECT cp.`id_psblogcat`, cp.`position`, cp.`id_parent`
			FROM `'._DB_PREFIX_.'psblogcat` cp
			WHERE cp.`id_parent` = '.(int)$this->id_parent.'
			ORDER BY cp.`position` ASC';
        !$res = Db::getInstance()->executeS($sql);
        if ($res) {
            return false;
        }
        
        foreach ($res as $menu) {
            if ((int)$menu['id_psblogcat'] == (int)$this->id) {
                $moved_menu = $menu;
            }
        }

        if (!isset($moved_menu) || !isset($position)) {
            return false;
        }
        // < and > statements rather than BETWEEN operator
        // since BETWEEN is treated differently according to databases
        return (Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'psblogcat`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way ? '> '.(int)$moved_menu['position'].' AND `position` <= '.(int)$position : '< '.(int)$moved_menu['position'].' AND `position` >= '.(int)$position).'
			AND `id_parent`='.(int)$moved_menu['id_parent']) && Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'psblogcat`
			SET `position` = '.(int)$position.'
			WHERE `id_parent` = '.(int)$moved_menu['id_parent'].'
			AND `id_psblogcat`='.(int)$moved_menu['id_psblogcat']));
    }

    public static function cleanPositions($id_parent)
    {
        $result = Db::getInstance()->executeS('
		SELECT `id_psblogcat`
		FROM `'._DB_PREFIX_.'psblogcat`
		WHERE `id_parent` = '.(int)$id_parent.'
		ORDER BY `position`');
        $sizeof = count($result);
        for ($i = 0; $i < $sizeof; ++$i) {
            $sql = '
			UPDATE `'._DB_PREFIX_.'psblogcat`
			SET `position` = '.(int)$i.'
			WHERE `id_parent` = '.(int)$id_parent.'
			AND `id_psblogcat` = '.(int)$result[$i]['id_psblogcat'];
            Db::getInstance()->execute($sql);
        }
        return true;
    }

    public static function getLastPosition($id_parent)
    {
        return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'psblogcat` WHERE `id_parent` = '.(int)$id_parent));
    }

    public function getInfo($id_psblogcat, $id_lang = null, $id_shop = null)
    {
        if (!$id_lang) {
            $id_lang = Context::getContext()->language->id;
        }
        if (!$id_shop) {
            $id_shop = Context::getContext()->shop->id;
        }
        $sql = 'SELECT m.*, md.title, md.description, md.content_text
				FROM '._DB_PREFIX_.'megamenu m
				LEFT JOIN '._DB_PREFIX_.'psblogcat_lang md ON m.id_psblogcat = md.id_psblogcat AND md.id_lang = '.(int)$id_lang
                .' JOIN '._DB_PREFIX_.'psblogcat_shop bs ON m.id_psblogcat = bs.id_psblogcat AND bs.id_shop = '.(int)($id_shop);
        $sql .= ' WHERE m.id_psblogcat='.(int)$id_psblogcat;

        return Db::getInstance()->executeS($sql);
    }

    public function getChild($id_psblogcat = null, $id_lang = null, $id_shop = null, $active = false)
    {
        if (!$id_lang) {
            $id_lang = Context::getContext()->language->id;
        }
        if (!$id_shop) {
            $id_shop = Context::getContext()->shop->id;
        }

        $sql = ' SELECT m.*, md.*
				FROM '._DB_PREFIX_.'psblogcat m
				LEFT JOIN '._DB_PREFIX_.'psblogcat_lang md ON m.id_psblogcat = md.id_psblogcat AND md.id_lang = '.(int)$id_lang
                .' JOIN '._DB_PREFIX_.'psblogcat_shop bs ON m.id_psblogcat = bs.id_psblogcat AND bs.id_shop = '.(int)($id_shop);
        if ($active) {
            $sql .= ' WHERE m.`active`=1 ';
        }

        if ($id_psblogcat != null) {
            # validate module
            $sql .= ' WHERE id_parent='.(int)$id_psblogcat;
        }
        $sql .= ' ORDER BY `position` ';
        return Db::getInstance()->executeS($sql);
    }

    public function getAllChild($id_psblogcat = null, $id_lang = null, $id_shop = null, $active = false)
    {
        if (!$id_lang) {
            $id_lang = Context::getContext()->language->id;
        }
        if (!$id_shop) {
            $id_shop = Context::getContext()->shop->id;
        }

        $sql = ' SELECT m.id_psblogcat AS id_category, m.id_parent, md.title AS name
				FROM '._DB_PREFIX_.'psblogcat m
				LEFT JOIN '._DB_PREFIX_.'psblogcat_lang md ON m.id_psblogcat = md.id_psblogcat AND md.id_lang = '.(int)$id_lang
                .' JOIN '._DB_PREFIX_.'psblogcat_shop bs ON m.id_psblogcat = bs.id_psblogcat AND bs.id_shop = '.(int)($id_shop);
        if ($active) {
            $sql .= ' WHERE m.`active`=1 ';
        }

        if ($id_psblogcat != null) {
            # validate module
            $sql .= ' WHERE id_parent='.(int)$id_psblogcat;
        }
        $sql .= ' ORDER BY `position` ';
        return Db::getInstance()->executeS($sql);
    }

    public function hasChild($id)
    {
        return isset($this->children[$id]);
    }

    public function getNodes($id)
    {
        return $this->children[$id];
    }

    public function getTree($id = null)
    {
        $childs = $this->getChild($id);

        foreach ($childs as $child) {
            # validate module
            $this->children[$child['id_parent']][] = $child;
        }
        $parent = 1;
        $output = $this->genTree($parent, 1);
        return $output;
    }

    public function getDropdown($id, $selected = 1)
    {
        $this->children = array();
        $childs = $this->getChild($id);
        foreach ($childs as $child) {
            # validate module
            $this->children[$child['id_parent']][] = $child;
        }
        $output = array(array('id' => '1', 'title' => 'Root', 'selected' => ''));
        $output = $this->genOption(1, 1, $selected, $output);

        return $output;
    }

    /**
     * @param int $level (default 0 )
     * @param type $output ( default array )
     * @param type $output
     */
    public function genOption($parent, $level, $selected, $output)
    {
        # module validation
        !is_null($level) ? $level : $level = 0;
        is_array($output) ? true : $output = array();
        
        if ($this->hasChild($parent)) {
            $data = $this->getNodes($parent);
            foreach ($data as $menu) {
                //$select = $selected == $menu['id_psblogcat'] ? 'selected="selected"' : "";
                $output[] = array('id' => $menu['id_psblogcat'], 'title' => str_repeat('-', $level).' '.$menu['title'].' (ID:'.$menu['id_psblogcat'].')', 'selected' => $selected);
                if ($menu['id_psblogcat'] != $parent) {
                    $output = $this->genOption($menu['id_psblogcat'], $level + 1, $selected, $output);
                }
            }
        }
        return $output;
    }

    public function genTree($parent, $level)
    {
        if ($this->hasChild($parent)) {
            $data = $this->getNodes($parent);
            $t = $level == 1 ? ' sortable' : '';
            $output = '<ol class="level'.$level.$t.' ">';

            foreach ($data as $menu) {
                $cls = Tools::getValue('id_psblogcat') == $menu['id_psblogcat'] ? 'selected' : '';
                $output .= '<li id="list_'.$menu['id_psblogcat'].'" class="'.$cls.'">
				<div><span class="disclose"><span></span></span>'.($menu['title'] ? $menu['title'] : '').' (ID:'.$menu['id_psblogcat'].') <span class="quickedit" rel="id_'.$menu['id_psblogcat'].'">E</span><span class="quickdel" rel="id_'.$menu['id_psblogcat'].'">D</span></div>';
                if ($menu['id_psblogcat'] != $parent) {
                    $output .= $this->genTree($menu['id_psblogcat'], $level + 1);
                }
                $output .= '</li>';
            }

            $output .= '</ol>';
            return $output;
        }
        return false;
    }

    private function genTreeForApPageBuilder($parent, $level, $select = array())
    {
        if ($this->hasChild($parent)) {
            $data = $this->getNodes($parent);
            $output = '<ol class="level'.$level.' ">';
            foreach ($data as $menu) {
                $check = $select ? (array_search($menu['id_psblogcat'], $select) !== false ? 'checked="checked"' : '') : '';
                $output .= '<li id="list_'.$menu['id_psblogcat'].'">
					<input type="checkbox" value="'.$menu['id_psblogcat'].'" name="chk_cat[]" id="chk-'.$menu['id_psblogcat'].'" '.$check.'/>
					<label for="chk-'.$menu['id_psblogcat'].'">'.($menu['title'] ? $menu['title'] : '')
                        .' (ID:'.$menu['id_psblogcat'].')</label>';
                if ($menu['id_psblogcat'] != $parent) {
                    $output .= $this->genTreeForApPageBuilder($menu['id_psblogcat'], $level + 1, $select);
                }
                $output .= '</li>';
            }
            $output .= '</ol>';
            return $output;
        }
        return '';
    }

    public function getTreeForApPageBuilder($select = array(), $id = null)
    {
        $childs = $this->getChild($id);
        foreach ($childs as $child) {
            $this->children[$child['id_parent']][] = $child;
        }
        $parent = 1;
        $output = $this->genTreeForApPageBuilder($parent, 1, $select);
        return $output;
    }

    public function getFrontEndTree($id, $helper)
    {
        $childs = $this->getChild(null);

        foreach ($childs as $child) {
            # validate module
            $this->children[$child['id_parent']][] = $child;
        }

        $parent = $id;
        $output = $this->genFontEndTree($parent, 1, $helper);

        return $output;
    }

    public function genFontEndTree($parent, $level, $helper)
    {
        if ($this->hasChild($parent)) {
            $data = $this->getNodes($parent);
            $t = $level == 1 ? ' tree dhtml' : ' collapse';
			$id_sub = '';
			if ($level != 1)
			{
				$id_sub = 'sub_'.$parent;
			}
            $output = '<ul id="'.$id_sub.'" class="level'.$level.$t.' ">';

            foreach ($data as $menu) {

                $params = array(
                    'rewrite' => $menu['link_rewrite'],
                    'id' => $menu['id_psblogcat']
                );

                $category_link = $helper->getBlogCatLink($params);

                $cls = Tools::getValue('id_psblogcat') == $menu['id_psblogcat'] ? 'selected' : '';
                $output .= '<li id="list_'.$menu['id_psblogcat'].'" class="'.$cls.' '.$menu['menu_class'].'"><a href="'.$category_link.'" title="'.$menu['title'].'">';
                if ($menu['icon_class']) {
                    $output .= '<i class="'.$menu['icon_class'].'"></i>';
                }
                $output .= '<span>'.$menu['title'].'</span></a> ';

                if ($menu['id_psblogcat'] != $parent) {
                    # validate module
			if ($this->hasChild($menu['id_psblogcat']))
			{
				$output .= '<div class="navbar-toggler collapse-icons" data-toggle="collapse" data-target="#sub_'.$menu['id_psblogcat'].'">
					<i class="material-icons add">add</i>
					<i class="material-icons remove">remove</i>
				</div>';
			}
                    $output .= $this->genFontEndTree($menu['id_psblogcat'], $level + 1, $helper);
                }
                $output .= '</li>';
            }

            $output .= '</ul>';
            return $output;
        }
        return false;
    }
}
