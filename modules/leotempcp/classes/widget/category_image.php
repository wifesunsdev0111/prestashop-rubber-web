<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class LeoWidgetCategory_image extends LeoWidgetBase
{
    public $widget_name = 'category_image';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Images of categories'), 'explain' => 'Chosing images for categories');
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();
        $root = Category::getRootCategory();
        $selected_cat = array();
        $selected_cates = '';
        $selected_images = '';
        $themeName = Context::getContext()->shop->getTheme();
        $image_path = 'themes/'.$themeName.'/img/icontab/';
        $imageList = $this->getImages($image_path);
        if ($data) {
            if ($data['params'] && isset($data['params']['categoryBox']) && $data['params']['categoryBox']) {
                $selected_cat = $data['params']['categoryBox'];
            }
            if ($data['params'] && isset($data['params']['category_img']) && $data['params']['category_img']) {
                //$selected_images = Tools::jsonDecode($data['params']['category_val'],true);
                $selected_images = $data['params']['category_img'];
            }
            if ($data['params'] && isset($data['params']['selected_cates']) && $data['params']['selected_cates']) {
                $selected_cates = $data['params']['selected_cates'];
            }
        }
        // $cate = new Category(13);
        // $result = $cate-> getParentsCategories();
        // echo "<pre>";print_r($result);die;
        $tree = new HelperTreeCategories('image_cate_tree', 'All Categories');
        $tree->setRootCategory($root->id)->setUseCheckBox(true)->setUseSearch(true)->setSelectedCategories($selected_cat);
//		$list_image = array('default.gif', 'leo.gif');
        $orderby = array(
            array(
                'order' => 'position',
                'name' => $this->l('Position')
            ),
            array(
                'order' => 'depth',
                'name' => $this->l('Depth')
            ),
            array(
                'order' => 'name',
                'name' => $this->l('Name')
            )
        );
        $showicons = array(
            array(
                'show' => '1',
                'name' => $this->l('Yes')
            ),
            array(
                'show' => '2',
                'name' => $this->l('Level 1 categories')
            ),
            array(
                'show' => '0',
                'name' => $this->l('No')
            )
        );

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'img_cat',
                    'name' => 'img_cat',
                    'imageList' => $imageList,
                    'selected_images' => $selected_images,
                    'selected_cates' => $selected_cates,
                    'lang' => true,
                    'tree' => $tree->render(),
                    'default' => '',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Depth'),
                    'name' => 'cate_depth',
                    'default' => '1',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Order By:'),
                    'name' => 'orderby',
                    'default' => 'position',
                    'options' => array(
                        'query' => $orderby,
                        'id' => 'order',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Show icons:'),
                    'name' => 'showicons',
                    'default' => '1',
                    'options' => array(
                        'query' => $showicons,
                        'id' => 'show',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'limit',
                    'default' => '5',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_root',
                    'default' => '2',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_lang',
                    'default' => '1',
                ),
            ),
            'buttons' => array(
                array(
                    'title' => $this->l('Save And Stay'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right sub_categories',
                    'type' => 'submit',
                    'name' => 'saveandstayleotempcp'
                ),
                array(
                    'title' => $this->l('Save'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right sub_categories',
                    'type' => 'submit',
                    'name' => 'saveleotempcp'
                ),
            )
        );

        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $data_form = $this->getConfigFieldsValues($data);
        $data_form['id_root'] = $root->id;
        $data_form['id_lang'] = Context::getContext()->employee->id_lang;
        //echo "<pre>";print_r($data);die;
        $helper->tpl_vars = array(
            // 'fields_value' => $this->getConfigFieldsValues($data),
            'fields_value' => $data_form,
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_language' => $default_lang,
        );

        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        # validate module
        unset($args);
        // $category = new Category(3, 1 );
        // $subCategories = $category->getSubCategories( 1 );
        $images = array();
        if (isset($setting['category_img']) && $setting['category_img']) {
            # validate module
            $images = Tools::jsonDecode($setting['category_img'], true);
        }
        $sql_filter = '';
        $sql_sort = '';

        if (isset($setting['orderby']) && $setting['orderby']) {
            if ($setting['orderby'] == 'depth') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC';
            }
            if ($setting['orderby'] == 'position') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC, category_shop.`position` ASC';
            }
            if ($setting['orderby'] == 'name') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC, cl.`name` ASC';
            }
        }
        $catids = (isset($setting['categoryBox']) && $setting['categoryBox']) ? ($setting['categoryBox']) : array();
        $result = array();
        $limit = (isset($setting['limit']) && $setting['limit']) ? $setting['limit'] : 5;
        foreach ($catids as $cate_id) {
            if (isset($setting['cate_depth']) && ($setting['cate_depth'] || $setting['cate_depth'] == '0')) {
                # validate module
                $sql_filter = ' AND c.`level_depth` <= '.(int)$setting['cate_depth'].' + (select c.`level_depth` from `'._DB_PREFIX_.'category` c where c.id_category ='.$cate_id.')';
            }
            if ($limit) {
                $result_cate = $this->getNestedCategories($images, $cate_id, Context::getContext()->language->id, false, null, true, $sql_filter, $sql_sort, $limit);
            }
            $result[] = $result_cate;
        }
        // echo "<pre>";print_r($result);die;
        $setting['categories'] = $result;
        $output = array('type' => 'category_image', 'data' => $setting);
        //echo "<pre>";print_r($setting);die;
        return $output;
    }

    public function getImages($image_folder)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);

        $path = _PS_ROOT_DIR_.'/'.$image_folder.'/';
        $path = str_replace('//', '/', $path);
        $oimages = array();
        if (is_dir($path)) {
            $images = glob($path.'*.*');
            $exts = array('jpg', 'gif', 'png');
            foreach ($images as $key => $image) {
                # validate module
                unset($key);
                $ext = Tools::substr($image, Tools::strlen($image) - 3, Tools::strlen($image));
                if (in_array(Tools::strtolower($ext), $exts)) {
                    $i = str_replace('\\', '/', $image_folder.'/'.basename($image));
                    $i = str_replace('//', '/', $i);
                    $aimage = array();
                    $aimage['path'] = $url.$i;
                    $aimage['name'] = basename($image);
                    $oimages[] = $aimage;
                }
            }
        }
        return $oimages;
    }

    public static function getNestedCategories($images, $root_category = null, $id_lang = false, $active = true, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
        $themeName = Context::getContext()->shop->getTheme();
        $image_path = 'themes/'.$themeName.'/img/icontab/';

        if (isset($root_category) && !Validate::isInt($root_category)) {
            die(Tools::displayError());
        }

        if (!Validate::isBool($active)) {
            die(Tools::displayError());
        }

        if (isset($groups) && Group::isFeatureActive() && !is_array($groups)) {
            $groups = (array)$groups;
        }

        $cache_id = 'Category::getNestedCategories_'.md5((int)$root_category.(int)$id_lang.(int)$active.(int)$active.(isset($groups) && Group::isFeatureActive() ? implode('', $groups) : ''));

        if (!Cache::isStored($cache_id)) {

            if ($sql_limit) {
                $sql = ' 
                    (SELECT c.*, cl.*
                    FROM `'._DB_PREFIX_.'category` c
                    '.($use_shop_restriction ? Shop::addSqlAssociation('category', 'c') : '').'
                    LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').'
                    WHERE c.`id_category`='.(int)$root_category.'
                    AND `id_lang`='.(int)$id_lang.') UNION';
            }
            $sql .= '
                (SELECT c.*, cl.*
                FROM `'._DB_PREFIX_.'category` c
                '.($use_shop_restriction ? Shop::addSqlAssociation('category', 'c') : '').'
                LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').'
                '.(isset($groups) && Group::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON c.`id_category` = cg.`id_category`' : '').'
                '.(isset($root_category) ? 'RIGHT JOIN `'._DB_PREFIX_.'category` c2 ON c2.`id_category` = '.(int)$root_category.' AND c.`nleft` >= c2.`nleft` AND c.`nright` <= c2.`nright`' : '').'
                WHERE 1 '.$sql_filter.' '.($id_lang ? 'AND `id_lang` = '.(int)$id_lang : '').'
                '.($active ? ' AND c.`active` = 1' : '');

            if ($sql_limit) {
                $sql .= ' AND c.`id_category`<>'.(int)$root_category;
            }

            $sql .= (isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN ('.implode(',', $groups).')' : '').'
            '.(!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '').'
            '.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC').'
            '.($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '');

            if ($sql_limit) {
                $sql .= ' LIMIT 0,'.(int)$sql_limit;
            }
            $sql .= ')';

            $result = Db::getInstance()->executeS($sql);
            $categories = array();
            $buff = array();

            if (!isset($root_category)) {
                $root_category = 1;
            }
            foreach ($result as $row) {
                //add image to a category
                if (array_key_exists($row['id_category'], $images)) {
                    # validate module
                    $row['image'] = $url.$image_path.$images[$row['id_category']];
                }
                $current = &$buff[$row['id_category']];
                $current = $row;
                if ($row['id_category'] == $root_category) {
                    # validate module
                    $categories[$row['id_category']] = &$current;
                } else {
                    # validate module
                    $buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
                }
            }

            Cache::store($cache_id, $categories);
        }
        return Cache::retrieve($cache_id);
    }

    /**
     * 0 no multi_lang
     * 1 multi_lang follow id_lang
     * 2 multi_lnag follow code_lang
     */
    public function getConfigKey($multi_lang = 0)
    {
        if ($multi_lang == 0) {
            return array(
                'categoryBox',
                'category_img',
                'cate_depth',
                'orderby',
                'showicons',
                'limit',
                'id_root',
                'id_lang',
            );
        } elseif ($multi_lang == 1) {
            return array(
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
