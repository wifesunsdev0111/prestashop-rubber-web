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

class ApSliderLayer extends ApShortCodeBase
{
    public $name = 'ApSliderLayer';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Slider Layer Module'), 'position' => 3, 'desc' => $this->l('You can group from leosliderlayer module to display'),
            'icon_class' => 'icon icon-chevron-right', 'tag' => 'content slider');
    }

    public function getConfigList()
    {
        if (Module::isInstalled('leosliderlayer') and Module::isEnabled('leosliderlayer')) {
            include_once(_PS_MODULE_DIR_.'leosliderlayer/leosliderlayer.php');
            $module = new LeoSliderLayer();
            $list = $module->getAllSlides();
            $controller = 'AdminModules';
            $id_lang = Context::getContext()->language->id;
            $params = array('token' => Tools::getAdminTokenLite($controller),
                'configure' => 'leosliderlayer',
                'tab_module' => 'front_office_features',
                'module_name' => 'leosliderlayer');
            $url = dirname($_SERVER['PHP_SELF']).'/'.Dispatcher::getInstance()->createUrl($controller, $id_lang, $params, false);
            if ($list && count($list) > 0) {
                $inputs = array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select a group for slider layer'),
                        'name' => 'slideshow_group',
                        'options' => array(
                            'query' => $this->getListGroup($list),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                        'form_group_class' => 'select_by_categories',
                        'default' => 'all'
                    ),
                    array(
                        'type' => 'html',
                        'name' => 'default_html',
                        'html_content' => '<div class=""><a class="" href="'.$url.'" target="_blank">'.
                        $this->l('Go to page configuration Slider').'</a></div>'
                    )
                );
            } else {
                // Go to page setting of the module LeoSlideShow
                $inputs = array(
                    array(
                        'type' => 'html',
                        'name' => 'default_html',
                        'html_content' => '<div class="alert alert-warning">'.
                        $this->l('There is no group slide in Leosliderlayer Module.').
                        '</div><br/><div><center><a class="btn btn-primary" href="'.$url.'" target="_blank">'.
                        $this->l(' CREATE GROUP SLIDER').'</a></center></div>'
                    )
                );
            }
        } else {
            $inputs = array(
                array(
                    'type' => 'html',
                    'name' => 'default_html',
                    'html_content' => '<div class="alert alert-warning">'.
                    $this->l('"Leosliderlayer" Module must be installed and enabled before using.').
                    '</div><br/><h4><center>You can take this module at leo-theme or apollo-theme</center></h4>'
                )
            );
        }
        return $inputs;
    }

    public function getListGroup($list)
    {
        $result = array();
        foreach ($list as $item) {
            $status = ' ('.($item['active'] ? $this->l('Active') : $this->l('Deactive')).')';
            $result[] = array('id' => $item['id_leosliderlayer_groups'], 'name' => $item['title'].$status);
        }
        return $result;
    }

    public function prepareFontContent($assign, $module = null)
    {
        if (Module::isInstalled('leosliderlayer') and Module::isEnabled('leosliderlayer')) {
            $assign['formAtts']['isEnabled'] = true;
            include_once(_PS_MODULE_DIR_.'leosliderlayer/leosliderlayer.php');
            $module = new LeoSliderLayer();
            //print_r($assign['slideshow_group']['slideshow_group']);
            $link_array = explode(',', $assign['formAtts']['slideshow_group']);
            if ($link_array && !is_numeric($link_array['0'])) {
                $where = '';
                foreach ($link_array as $val) {
                    // validate module
                    $where .= ($where == '') ? "'".$val."'" : ",'".$val."'";
                }

                $where = ' WHERE title IN ('.$where.')';
                $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_leoslideshow_groups FROM `'._DB_PREFIX_.'leoslideshow_groups` '.$where);
                $where = '';
                foreach ($result as $blog) {
                    // validate module
                    $where .= ($where == '') ? $blog['id_leoslideshow_groups'] : ','.$blog['id_leoslideshow_groups'];
                }
                $assign['formAtts']['slideshow_group'] = $where;
            }
            $assign['content_slider'] = $module->processHookCallBack($assign['formAtts']['slideshow_group']);
            //$module->processHookCallBack();
        } else {
            // validate module
            $assign['formAtts']['isEnabled'] = false;
        }
        return $assign;
    }
}
