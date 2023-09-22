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

class ApBlockLink extends ApShortCodeBase
{
    public $name = 'ApBlockLink';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Block Link'),
            'position' => 5,
            'desc' => $this->l('Create List Block Links'),
            'icon_class' => 'icon icon-list',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        $languages = Language::getLanguages(true, Context::getContext()->shop->id);
        $inputs = array(
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<script>var totalLanguage = "'.count($languages).'";</script>'
            ),
            array(
                'type' => 'hidden',
                'name' => 'total_link',
                'default' => '0'
            ),
            array(
                'type' => 'text',
                'name' => 'name',
                'lang' => 'true',
                'label' => $this->l('Title widget'),
                'default' => ''
            ),
            array(
                'type' => 'blockLink',
                'name' => 'title',
                'lang' => 'true',
                'label' => $this->l('Title'),
                'default' => ''
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<ul class="list-link-block"></ul><hr style="clear:both; margin:0;"/><div class="col-lg-12">
					<button type="button" class="btn btn-default btn-add-block-link fr">'.$this->l('Add new').'</button></div>',
            ),
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $total = (int)$assign['formAtts']['total_link'];
        $links = array();
//		$languages = Language::getLanguages(true, Context::getContext()->shop->id);
//		$total_lang = count($languages);
        $id_lang = Context::getContext()->language->id;
        for ($i = 1; $i <= $total; $i++) {
            $link = array();
            $name = $i.'_'.$id_lang;
            $link['title'] = isset($assign['formAtts']['title_'.$name]) ? $assign['formAtts']['title_'.$name] : '';
            $link['link'] = isset($assign['formAtts']['link_'.$name]) ? $assign['formAtts']['link_'.$name] : '';
            $links[] = $link;
        }
        $assign['formAtts']['links'] = $links;
        return $assign;
    }
}
