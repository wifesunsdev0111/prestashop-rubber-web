<?php
/**
 *  Leo Prestashop Blockleoblogs for Prestashop 1.6.x
 *
 * @package   blockleoblogs
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class Blockgrouptop extends Module
{

    public function __construct()
    {
        $this->name = 'blockgrouptop';
        $this->tab = 'front_office_features';
        $this->version = '1.3.1';
        $this->author = 'LeoTheme';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Block Group Top');
        $this->description = $this->l('Adds a block allowing customers to select a language for your stores content.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('displayNav') || !$this->registerHook('displayHeader')) {
            return false;
        }
        $this->_installDataSample();
        return true;
    }

    private function _installDataSample()
    {
        if (!file_exists(_PS_MODULE_DIR_.'leotempcp/libs/DataSample.php')) {
            return false;
        }
        require_once( _PS_MODULE_DIR_.'leotempcp/libs/DataSample.php' );

        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }

    private function _prepareHook($params)
    {
        # module validation
        unset($params);
        $languages = Language::getLanguages(true, $this->context->shop->id);
        if (!count($languages)) {
            return false;
        }
        $link = new Link();

        if ((int)Configuration::get('PS_REWRITING_SETTINGS')) {
            $default_rewrite = array();
            if (Dispatcher::getInstance()->getController() == 'product' && ($id_product = (int)Tools::getValue('id_product'))) {
                $rewrite_infos = Product::getUrlRewriteInformations((int)$id_product);
                foreach ($rewrite_infos as $infos) {
                    $default_rewrite[$infos['id_lang']] = $link->getProductLink((int)$id_product, $infos['link_rewrite'], $infos['category_rewrite'], $infos['ean13'], (int)$infos['id_lang']);
                }
            }

            if (Dispatcher::getInstance()->getController() == 'category' && ($id_category = (int)Tools::getValue('id_category'))) {
                $rewrite_infos = Category::getUrlRewriteInformations((int)$id_category);
                foreach ($rewrite_infos as $infos) {
                    $default_rewrite[$infos['id_lang']] = $link->getCategoryLink((int)$id_category, $infos['link_rewrite'], $infos['id_lang']);
                }
            }

            if (Dispatcher::getInstance()->getController() == 'cms' && (($id_cms = (int)Tools::getValue('id_cms')) || ($id_cms_category = (int)Tools::getValue('id_cms_category')))) {
                $rewrite_infos = (isset($id_cms) && !isset($id_cms_category)) ? CMS::getUrlRewriteInformations($id_cms) : CMSCategory::getUrlRewriteInformations($id_cms_category);
                foreach ($rewrite_infos as $infos) {
                    $arr_link = (isset($id_cms) && !isset($id_cms_category)) ?
                            $link->getCMSLink($id_cms, $infos['link_rewrite'], null, $infos['id_lang']) :
                            $link->getCMSCategoryLink($id_cms_category, $infos['link_rewrite'], $infos['id_lang']);
                    $default_rewrite[$infos['id_lang']] = $arr_link;
                }
            }
            $this->smarty->assign('lang_rewrite_urls', $default_rewrite);
        }

        $this->smarty->assign('blockcurrencies_sign', $this->context->currency->sign);
        $this->smarty->assign('catalog_mode', Configuration::get('PS_CATALOG_MODE'));
        return true;
    }

    /**
     * Returns module content for header
     *
     * @param array $params Parameters
     * @return string Content
     */
    public function hookDisplayTop($params)
    {

        if (!$this->_prepareHook($params)) {
            return;
        }
        return $this->display(__FILE__, 'blockgrouptop.tpl');
    }

    public function hookDisplayNav($params)
    {
        return $this->hookDisplayTop($params);
    }

    public function hookDisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path.'blockgrouptop.css', 'all');
    }
}
