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

class ApCategoryImage extends ApShortCodeBase
{
    public $name = 'ApCategoryImage';
    public $for_module = 'manage';
    public $module_name = 'appagebuilder';
    public $level = 4;

    public function getInfo()
    {
        return array('label' => $this->l('Images of categories'),
            'position' => 5,
            'desc' => $this->l('Choosing images for categories'),
            'icon_class' => 'icon-picture',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        $root = Category::getRootCategory();
        $selected_cat = array();
        $selected_cates = '';
        $selected_images = '';
        $image_path = 'themes'.DS._THEME_NAME_.DS.'img'.DS.'modules'.DS;
        $image_list = $this->getImages($image_path);
        if (Tools::getIsset('categorybox')) {
            $category_box = Tools::getValue('categorybox');
            $selected_cat = explode(',', $category_box);
        }
        if (Tools::getIsset('category_img')) {
            $selected_images = str_replace($this->str_search, $this->str_relace_html, Tools::getValue('category_img'));
        }
        if (Tools::getIsset('selected_cates')) {
            $selected_cates = Tools::getValue('selected_cates');
        }
        $tree = new HelperTreeCategories('categorybox', 'All Categories');
        // fix tree category with ps version 1.6.1 or newer
        if (version_compare(_PS_VERSION_, '1.6.1', '>=')) {
            $tree->setRootCategory($root->id)->setUseCheckBox(true)->setFullTree(true)->setSelectedCategories($selected_cat)->setInputName('categorybox');
        } else {
            $tree->setRootCategory($root->id)->setUseCheckBox(true)->setSelectedCategories($selected_cat)->setInputName('categorybox');
        }
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
        $path_image = __PS_BASE_URI__.'themes/'.Context::getContext()->shop->getTheme().'/img/modules/'.$this->module_name.'/icon/';
        Context::getContext()->smarty->assign('path_image', $path_image);
        $href = Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&imgDir=icon&is_ajax=true';
        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setSavePath(_PS_ALL_THEMES_DIR_.Context::getContext()->shop->getTheme().'/img/modules/'.$this->module_name.'/icon/');
        $image_uploader->setMultiple(true)->setUseAjax(true)->setUrl(
                Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&ajax=1&action=ajaxProcessAddImage&imgDir=icon');
        $tree_html = $tree->render();
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'img_cat',
                'name' => 'img_cat',
                'imageList' => $image_list,
                'selected_images' => $selected_images,
                'selected_cates' => $selected_cates,
                'lang' => true,
                'tree' => $tree_html,
                'href_image' => $href,
                'path_image' => $path_image,
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
            )
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $form_atts = $assign['formAtts'];
        $images = array();
        if (isset($form_atts['category_img']) && $form_atts['category_img']) {
            $selected_images = str_replace($this->str_search, $this->str_relace_html, $form_atts['category_img']);
            $images = Tools::jsonDecode($selected_images, true);
        }
        $sql_filter = '';
        $sql_sort = '';
        if (isset($form_atts['orderby']) && $form_atts['orderby']) {
            if ($form_atts['orderby'] == 'depth') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC';
            }
            if ($form_atts['orderby'] == 'position') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC, category_shop.`position` ASC';
            }
            if ($form_atts['orderby'] == 'name') {
                $sql_sort = ' ORDER BY c.`level_depth` ASC, cl.`name` ASC';
            }
        }
        $catids = (isset($form_atts['categorybox']) && $form_atts['categorybox']) ? ($form_atts['categorybox']) : '';
        $catids = explode(',', $catids);
        $result = array();
        $this->level = (int)$form_atts['cate_depth'];
        $limit = (isset($form_atts['limit']) && $form_atts['limit']) ? ((int)$form_atts['limit']) : 0;
        $limit++;
        foreach ($catids as $cate_id) {
            if ($cate_id && Validate::isInt($cate_id)) {
                // echo ("\n<pre>$cate_id</pre>");
                $result_cate = $this->getNestedCategories($cate_id, 1, $images, $limit);
                if ($result_cate) {
                    $result[] = $result_cate;
                }
            }
        }
        $assign['categories'] = $result;
        $assign['random'] = 'categories-image-'.ApPageSetting::getRandomNumber();
        $assign['type'] = 'category_image';
        // validate module
        unset($sql_filter);
        unset($sql_sort);
        return $assign;
    }

    public function getImages($image_folder)
    {
        $module = $this->module_name.DS;
        $path_module = $this->module_name.DS.'icon'.DS;
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
        $path = _PS_ROOT_DIR_.DS.$image_folder;
        $path = str_replace('//', '/', $path);
        $oimages = array();
        if (is_dir($path.$module) && is_dir($path.$path_module)) {
            $images = glob($path.$path_module.'*.*');
            $exts = array('jpg', 'gif', 'png');
            foreach ($images as $key => $image) {
                $ext = Tools::substr($image, Tools::strlen($image) - 3, Tools::strlen($image));
                if (in_array(Tools::strtolower($ext), $exts)) {
                    $i = str_replace('\\', '/', $image_folder.$path_module.basename($image));
                    $i = str_replace('//', '/', $i);
                    $aimage = array();
                    $aimage['path'] = $url.$i;
                    $aimage['name'] = basename($image);
                    $oimages[] = $aimage;
                }
                // validate module
                unset($key);
            }
        } else {
            if (!is_dir($path.$module)) {
                mkdir($path.$module);
            }
            if (!is_dir($path.$path_module)) {
                mkdir($path.$path_module);
            }
        }
        return $oimages;
    }

    public function getNestedCategories($parent, $level, $images, $limit)
    {
        $buff = array();
        if ($level <= $this->level) {
            $lang = Context::getContext()->language->id;
            $current = array();
            $child = array();
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            $url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
            $image_path = 'themes/'._THEME_NAME_.'/img/modules/'.$this->module_name.'/icon/';
            $sql = '
					SELECT c.*, cl.*
					FROM `'._DB_PREFIX_.'category` c'.Shop::addSqlAssociation('category', 'c').' 
					LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').' 
					WHERE c.id_parent='.$parent.' AND `id_lang` = '.(int)$lang.' 
					AND c.`active` = 1
					ORDER BY c.`level_depth` ASC, category_shop.`position` ASC';
            $result = Db::getInstance()->executeS($sql);
            $current_category = Db::getInstance()->executeS('SELECT c.*, cl.*
				FROM `'._DB_PREFIX_.'category` c'.Shop::addSqlAssociation('category', 'c').' 
					LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON c.`id_category` = cl.`id_category`'.Shop::addSqlRestrictionOnLang('cl').' 
					WHERE c.id_category='.(int)$parent.' AND `id_lang` = '.(int)$lang.' 
					AND c.`active` = 1');
            if ($current_category) {
                if (array_key_exists($current_category[0]['id_category'], $images)) {
                    $current_category[0]['image'] = $url.$image_path.$images[$current_category[0]['id_category']];
                }
                if ($result) {
                    foreach ($result as &$row) {
                        if ($row && isset($row['id_category'])) {
                            $child = $this->getNestedCategories($row['id_category'], $level + 1, $images, $limit);
                            if ($child) {
                                foreach ($child as $item) {
                                    if (array_key_exists($item['id_category'], $images))
                                        $item['image'] = $url.$image_path.$images[$item['id_category']];
                                    $current[$row['id_category']] = $item;
                                }
                            }
                            $buff[$row['id_parent']] = $current_category[0];
                            if ($current) {
                                $buff[$row['id_parent']]['children'] = &$current;
                            }
                        }
                    }
                } else {
                    // validate module
                    $buff[$parent] = $current_category[0];
                }
            }
        }
        return $buff;
    }
}
