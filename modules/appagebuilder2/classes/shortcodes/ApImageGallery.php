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

class ApImageGallery extends ApShortCodeBase
{
    public $name = 'ApImageGallery';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Image Gallery'),
            'position' => 7,
            'desc' => $this->l('Create Images Mini Gallery From A Folder'),
            'icon_class' => 'icon-th',
            'tag' => 'content');
    }

    public function getConfigList()
    {
//		$selected_categories = array();
//		if (Tools::getIsset('categorybox'))
//		{
//			$category_box = Tools::getValue('categorybox');
//			$category_box = explode(',', $category_box);
//			$selected_categories = $category_box;
//		}
        $theme = Context::getContext()->shop->getTheme();
        $link = new Link();
        $current_link = $link->getPageLink('', false, Context::getContext()->language->id);
        $path_info = 'Example: '.$current_link.'themes/'.$theme.'/img/modules/appagebuilder/yourFolderImage';
        $inputs = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'),
                'lang' => 'true',
                'form_group_class' => 'aprow_general',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'path',
                'label' => $this->l('Path'),
                'desc' => $this->l($path_info),
                'lang' => 'true',
                'form_group_class' => 'aprow_general',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Limit'),
                'name' => 'limit',
                'default' => '12',
                'desc' => $this->l('Enter a number')
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Columns'),
                'name' => 'columns',
                'options' => array('query' => array(
                        array('id' => '1', 'name' => $this->l('1 Column')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns')),
                        array('id' => '4', 'name' => $this->l('4 Columns')),
                        array('id' => '5', 'name' => $this->l('5 Columns')),
                        array('id' => '6', 'name' => $this->l('6 Columns')),
                    ),
                    'id' => 'id',
                    'name' => 'name'),
                'default' => '4',
            )
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $form_atts = $assign['formAtts'];
        $limit = (int)$form_atts['limit'];
        $images = array();
        $link = new Link();
        $current_link = $link->getPageLink('', false, Context::getContext()->language->id);
        $path = _PS_ROOT_DIR_.DS.str_replace($current_link, '', isset($form_atts['path']) ? $form_atts['path'] : '');
        $arr_exten = array('jpg', 'jpge', 'gif', 'png');
        if ($path && is_dir($path)) {
            if ($handle = opendir($path)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != '.' && $entry != '..' && is_file($path.DS.$entry)) {
                        $ext = pathinfo($path.DS.$entry, PATHINFO_EXTENSION);
                        if (in_array($ext, $arr_exten)) {
                            $images[] = __PS_BASE_URI__.'/'.str_replace($current_link, '', $form_atts['path']).'/'.$entry;
                        }
                    }
                }
                closedir($handle);
            }
        }
        $c = (int)$form_atts['columns'];
        $assign['columns'] = $c > 0 ? $c : 4;
        $assign['images'] = $images;
        // validate module
        unset($limit);
        return $assign;
    }
}
