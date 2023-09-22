<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

class PsBlogBlog extends ObjectModel
{
    /** @var string Name */
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $content;
    public $description;
    public $video_code;
    public $image = '';
	public $thumb = '';
    public $link_rewrite;
    public $id_psblogcat;
    public $position;
    public $indexation;
    public $active;
    public $id_psblog_blog;
    public $date_add;
    public $date_upd;
    public $hits = 0;
    public $id_employee;
    public $tags;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'psblog_blog',
        'primary' => 'id_psblog_blog',
        'multilang' => true,
        'fields' => array(
            'id_psblogcat' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName'),
            'position' => array('type' => self::TYPE_INT),
            'id_employee' => array('type' => self::TYPE_INT),
            'indexation' => array('type' => self::TYPE_BOOL),
            'active' => array('type' => self::TYPE_BOOL),
            'image' => array('type' => self::TYPE_STRING, 'lang' => false,),
			'thumb' => array('type' => self::TYPE_STRING, 'lang' => false,),
            'hits' => array('type' => self::TYPE_INT),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'video_code' => array('type' => self::TYPE_HTML, 'validate' => 'isString', 'required' => false),
            # Lang fields
            'meta_description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
            'meta_keywords' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
            'tags' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
            'meta_title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'link_rewrite' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 3999999999999),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 3999999999999),
        ),
    );
    protected $webserviceParameters = array(
        'objectNodeName' => 'content',
        'objectsNodeName' => 'content_management_system',
    );
    public static function findByRewrite($parrams)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $id = 0;
        if(isset($parrams['link_rewrite']) && $parrams['link_rewrite'])
        {
            $sql = 'SELECT bl.id_psblog_blog FROM '._DB_PREFIX_.'psblog_blog_lang bl';
            $sql .= ' INNER JOIN '._DB_PREFIX_.'psblog_blog_shop bs on bl.id_psblog_blog=bs.id_psblog_blog AND id_shop='.$id_shop;
            $sql .= ' WHERE id_lang = ' . $id_lang ." AND link_rewrite = '".$parrams['link_rewrite']."'";
            if($row = Db::getInstance()->getRow($sql))
            {
                $id = $row['id_psblog_blog'];
            }
        }
        return new PsBlogBlog($id, $id_lang);
    }
    public function add($autodate = true, $null_values = false)
    {
        $this->position = self::getLastPosition((int)$this->id_psblogcat);

        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $res = parent::add($autodate, $null_values);

        $sql = 'INSERT INTO `'._DB_PREFIX_.'psblog_blog_shop` (`id_shop`, `id_psblog_blog`)
                VALUES('.(int)$id_shop.', '.(int)$this->id.')';
        $res &= Db::getInstance()->execute($sql);
        $this->cleanPositions($this->id_psblogcat);
        return $res;
    }

    public function update($null_values = false)
    {
        if (parent::update($null_values)) {
            return $this->cleanPositions($this->id_psblogcat);
        }
        return false;
    }

    public function updateField($id, $fields)
    {
        $sql = 'UPDATE `'._DB_PREFIX_.'psblog_blog` SET ';
        $last_key = current(array_keys($fields));
        foreach ($fields as $field => $value) {
            $sql .= $field." = '".$value."'";
            if ($field != $last_key) {
                # validate module
                $sql .= ',';
            }
        }

        $sql .= ' WHERE `id_psblog_blog`='.(int)$id;
        return Db::getInstance()->execute($sql);
    }

    /**
     *
     */
    public function delete()
    {
        //delete comment
        $result_comment = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT `id_comment` as id FROM `'._DB_PREFIX_.'psblog_comment` WHERE `id_psblog_blog` = '.(int)$this->id.'');
        foreach ($result_comment as $value) {
            $comment = new PsBlogComment($value['id']);
            $comment->delete();
        }
        if (parent::delete()) {
            return $this->cleanPositions($this->id_psblogcat);
        }
        return false;
    }

    /**
     * @param Array $condition ( default array )
     * @param Boolean $is_active ( default false )
     */
    public static function getListBlogs($id_category, $id_lang, $page_number, $nb_products, $order_by, $order_way, $condition = array(), $is_active = false, $id_shop = null)
    {
        # module validation
        !is_null($nb_products) ? true : $nb_products = 10;
        !is_null($page_number) ? true : $page_number = 0;

        if (!$id_shop) {
            $context = Context::getContext();
            $id_shop = $context->shop->id;
        }

        if (empty($id_lang)) {
            $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        }
        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_psblog_blog' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'c';
        } else if ($order_by == 'title') {
            $order_by_prefix = 'c';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }

        $where = '';

        if ($id_category) {
            # validate module
            $where .= ' AND c.id_psblogcat='.(int)$id_category;
        }
        if ($id_shop) {
            # validate module
            $where .= ' AND s.id_shop='.(int)$id_shop;
        }
        if (isset($condition['type'])) {
            switch ($condition['type']) {
                case 'author':
                    $where .= ' AND id_employee='.(int)$condition['id_employee'];
                    break;

                case 'tag':
                    $tmp = explode(',', $condition['tag']);

                    if (!empty($tmp) && count($tmp) > 1) {
                        $t = array();
                        foreach ($tmp as $tag) {
                            # validate module
                            $t[] = 'l.tags LIKE "%'.pSQL(trim($tag)).'%"';
                        }
                        $where .= ' AND  '.implode(' OR ', $t).' ';
                    } else {
                        # validate module
                        $where .= ' AND l.tags LIKE "%'.pSQL($condition['tag']).'%"';
                    }
                    break;
                case 'samecat':
                    $where .= ' AND c.id_psblog_blog!='.$condition['id_psblog_blog'];
                    break;
            }
        }

        if ($is_active) {
            # validate module
            $where .= ' AND c.active=1';
        }
        $query = '
		SELECT c.*, l.*, l.meta_title as title, blc.link_rewrite as category_link_rewrite , blc.title as category_title
		FROM  '._DB_PREFIX_.'psblog_blog c
		LEFT JOIN '._DB_PREFIX_.'psblog_blog_lang l ON (c.id_psblog_blog = l.id_psblog_blog) and  l.id_lang='.(int)$id_lang
                .' LEFT JOIN '._DB_PREFIX_.'psblog_blog_shop s ON  (c.id_psblog_blog = s.id_psblog_blog) '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat bc ON  bc.id_psblogcat = c.id_psblogcat '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat_lang blc ON blc.id_psblogcat=bc.id_psblogcat and blc.id_lang='.(int)$id_lang
                .' '.Shop::addSqlAssociation('blog', 'c').'
		WHERE l.id_lang = '.(int)$id_lang.$where.'
		GROUP BY c.id_psblog_blog
		 ';

        $query .= 'ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way)
                .' LIMIT '.(int)(($page_number - 1) * $nb_products).', '.(int)$nb_products;

        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        return $data;
    }

    /**
     * @param Array $condition ( default array )
     * @param Boolean $is_active ( default false )
     */
    public static function countBlogs($id_category, $id_lang, $condition = array(), $is_active = false, $id_shop = null)
    {
        if (!$id_shop) {
            $context = Context::getContext();
            $id_shop = $context->shop->id;
        }
        $where = '';
        if ($id_category) {
            # validate module
            $where .= ' AND c.id_psblogcat='.(int)$id_category;
        }
        if ($is_active) {
            # validate module
            $where .= ' AND c.active=1';
        }
        if ($id_shop) {
            # validate module
            $where .= ' AND s.id_shop='.(int)$id_shop;
        }
        if (isset($condition['type'])) {
            switch ($condition['type']) {
                case 'author':
                    $where .= ' AND id_employee='.(int)$condition['id_employee'];
                    break;

                case 'tag':
                    $tmp = explode(',', $condition['tag']);

                    if (!empty($tmp) && count($tmp) > 1) {
                        $t = array();
                        foreach ($tmp as $tag) {
                            # validate module
                            $t[] = 'l.tags LIKE "%'.pSQL(trim($tag)).'%"';
                        }
                        $where .= ' AND  '.implode(' OR ', $t).' ';
                    } else {
                        # validate module
                        $where .= ' AND l.tags LIKE "%'.pSQL($condition['tag']).'%"';
                    }
                    break;
                case 'samecat':
                    $where .= ' AND c.id_psblog_blog!='.$condition['id_psblog_blog'];
                    break;
            }
        }
        $query = '
		SELECT  c.id_psblog_blog
		FROM  '._DB_PREFIX_.'psblog_blog c
		LEFT JOIN '._DB_PREFIX_.'psblog_blog_lang l ON (c.id_psblog_blog = l.id_psblog_blog) and  l.id_lang='.(int)$id_lang
                .' LEFT JOIN '._DB_PREFIX_.'psblog_blog_shop s ON  (c.id_psblog_blog = s.id_psblog_blog) '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat bc ON  bc.id_psblogcat = c.id_psblogcat '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat_lang blc ON blc.id_psblogcat=bc.id_psblogcat and blc.id_lang='.(int)$id_lang
                .'
		WHERE l.id_lang = '.(int)$id_lang.$where.'
		GROUP BY c.id_psblog_blog
		 ';

        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        return count($data);
    }

    public static function listblog($id_lang = null, $id_block = false, $active = true, $id_shop = null)
    {
        if (!$id_shop) {
            $context = Context::getContext();
            $id_shop = $context->shop->id;
        }

        if (empty($id_lang)) {
            $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        }

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT c.id_psblog_blog, l.meta_title
		FROM  '._DB_PREFIX_.'blog c
		JOIN '._DB_PREFIX_.'blog_lang l ON (c.id_psblog_blog = l.id_psblog_blog)
                JOIN '._DB_PREFIX_.'psblog_blog_lang s ON (c.id_psblog_blog = s.id_psblog_blog)
		'.Shop::addSqlAssociation('blog', 'c').'
		'.(($id_block) ? 'JOIN '._DB_PREFIX_.'block_blog b ON (c.id_psblog_blog = b.id_psblog_blog)' : '').'
		WHERE s.id_shop = '.(int)$id_shop.' AND l.id_lang = '.(int)$id_lang.(($id_block) ? ' AND b.id_block = '.(int)$id_block : '').($active ? ' AND c.`active` = 1 ' : '').'
		GROUP BY c.id_psblog_blog
		ORDER BY c.`position`');
    }

    public function updatePosition($way, $position)
    {
        $sql = 'SELECT cp.`id_psblog_blog`, cp.`position`, cp.`id_psblogcat`
			FROM `'._DB_PREFIX_.'blog` cp
			WHERE cp.`id_psblogcat` = '.(int)$this->id_psblogcat.'
			ORDER BY cp.`position` ASC';
        if (!$res = Db::getInstance()->executeS($sql)) {
            return false;
        }

        foreach ($res as $blog) {
            if ((int)$blog['id_psblog_blog'] == (int)$this->id) {
                $moved_blog = $blog;
            }
        }

        if (!isset($moved_blog) || !isset($position)) {
            return false;
        }

        // < and > statements rather than BETWEEN operator
        // since BETWEEN is treated differently according to databases
        return (Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'blog`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way ? '> '.(int)$moved_blog['position'].' AND `position` <= '.(int)$position : '< '.(int)$moved_blog['position'].' AND `position` >= '.(int)$position).'
			AND `id_psblogcat`='.(int)$moved_blog['id_psblogcat']) && Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'blog`
			SET `position` = '.(int)$position.'
			WHERE `id_psblog_blog` = '.(int)$moved_blog['id_psblog_blog'].'
			AND `id_psblogcat`='.(int)$moved_blog['id_psblogcat']));
    }

    public static function cleanPositions($id_category)
    {
        $sql = '
		SELECT `id_psblog_blog`
		FROM `'._DB_PREFIX_.'psblog_blog`
		WHERE `id_psblogcat` = '.(int)$id_category.'
		ORDER BY `position`';

        $result = Db::getInstance()->executeS($sql);

        for ($i = 0, $total = count($result); $i < $total; ++$i) {
            $sql = 'UPDATE `'._DB_PREFIX_.'psblog_blog`
					SET `position` = '.(int)$i.'
					WHERE `id_psblogcat` = '.(int)$id_category.'
						AND `id_psblog_blog` = '.(int)$result[$i]['id_psblog_blog'];
            Db::getInstance()->execute($sql);
        }
        return true;
    }

    public static function getLastPosition($id_category)
    {
        $sql = '
		SELECT MAX(position) + 1
		FROM `'._DB_PREFIX_.'psblog_blog`
		WHERE `id_psblogcat` = '.(int)$id_category;

        return (Db::getInstance()->getValue($sql));
    }

    public static function getblogPages($id_lang = null, $id_psblogcat = null, $active = true, $id_shop = null)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('blog', 'c');
        if ($id_lang) {
            $sql->innerJoin('blog_lang', 'l', 'c.id_psblog_blog = l.id_psblog_blog AND l.id_lang = '.(int)$id_lang);
        }

        if ($id_shop) {
            $sql->innerJoin('blog_shop', 'cs', 'c.id_psblog_blog = cs.id_psblog_blog AND cs.id_shop = '.(int)$id_shop);
        }

        if ($active) {
            $sql->where('c.active = 1');
        }

        if ($id_psblogcat) {
            $sql->where('c.id_psblogcat = '.(int)$id_psblogcat);
        }

        $sql->orderBy('position');

        return Db::getInstance()->executeS($sql);
    }

    public static function getUrlRewriteInformations($id_psblog_blog)
    {
        $sql = 'SELECT l.`id_lang`, c.`link_rewrite`
				FROM `'._DB_PREFIX_.'psblog_blog_lang` AS c
				LEFT JOIN  `'._DB_PREFIX_.'lang` AS l ON c.`id_lang` = l.`id_lang`
				WHERE c.`id_psblog_blog` = '.(int)$id_psblog_blog.'
				AND l.`active` = 1';

        return Db::getInstance()->executeS($sql);
    }

    /**
     * This function is build for module ApPageBuilder, most logic query Sqlis clone from function getListBlog.
     * @param Int $id_category ( default '' )
     * @param Int $nb_blog ( default 10 )
     * @param Array $condition ( default array )
     * @param Boolean $is_active ( default false )
     */
    public static function getListBlogsForApPageBuilder($id_category, $id_lang, $nb_blog, $order_by, $order_way, $condition, $is_active, $id_shop = null)
    {
        # module validation
        !is_null($id_category) ? true : $id_category = '';
        !is_null($nb_blog) ? true : $nb_blog = 10;
        is_array($condition) ? true : $condition = array();
        !is_null($is_active) ? true : $is_active = false;

        if (!$id_shop) {
            $context = Context::getContext();
            $id_shop = $context->shop->id;
        }
        if (empty($id_lang)) {
            $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        }
        if ($nb_blog < 1) {
            $nb_blog = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_psblog_blog' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'c';
        } else if ($order_by == 'title') {
            $order_by_prefix = 'c';
        }
//        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
//            die(Tools::displayError());
//        }
        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }
        $where = '';
        if ($id_category) {
            $where .= ' AND c.id_psblogcat IN('.$id_category.') ';
        }
        if ($id_shop) {
            $where .= ' AND s.id_shop='.(int)$id_shop;
        }
        if (isset($condition['type'])) {
            switch ($condition['type']) {
                case 'author':
                    $where .= ' AND id_employee='.(int)$condition['id_employee'];
                    break;
                case 'tag':
                    $tmp = explode(',', $condition['tag']);
                    if (!empty($tmp) && count($tmp) > 1) {
                        $t = array(); # validate module
                        foreach ($tmp as $tag) {
                            $t[] = 'l.tags LIKE "%'.pSQL(trim($tag)).'%"';
                        }
                        $where .= ' AND  '.implode(' OR ', $t).' ';
                    } else {
                        $where .= ' AND l.tags LIKE "%'.pSQL($condition['tag']).'%"';
                    }
                    break;
                case 'samecat':
                    $where .= ' AND c.id_psblog_blog!='.$condition['id_psblog_blog'];
                    break;
            }
        }
        if ($is_active) {
            $where .= ' AND c.active=1';
        }
        $query = '
			SELECT c.*, l.*, l.meta_title as title, blc.link_rewrite as category_link_rewrite , blc.title as category_title
			FROM  '._DB_PREFIX_.'psblog_blog c
			LEFT JOIN '._DB_PREFIX_.'psblog_blog_lang l ON (c.id_psblog_blog = l.id_psblog_blog) and  l.id_lang='.(int)$id_lang
                .' LEFT JOIN '._DB_PREFIX_.'psblog_blog_shop s ON  (c.id_psblog_blog = s.id_psblog_blog) '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat bc ON  bc.id_psblogcat = c.id_psblogcat '
                .' LEFT JOIN '._DB_PREFIX_.'psblogcat_lang blc ON blc.id_psblogcat=bc.id_psblogcat and blc.id_lang='.(int)$id_lang
                .' '.Shop::addSqlAssociation('blog', 'c').'
			WHERE l.id_lang = '.(int)$id_lang.$where.'
			GROUP BY c.id_psblog_blog ';

        if($order_way == 'random'){
            $query .= 'ORDER BY rand() LIMIT 0, '.(int)$nb_blog;
        }else{
            $query .= 'ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '')
                    .pSQL($order_by).' '.pSQL($order_way).' LIMIT 0, '.(int)$nb_blog;
            
        }

        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
        return $data;
    }
}
