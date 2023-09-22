<?php
/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registred Trademark & Property of PrestaShop SA
*/

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\BestSales\BestSalesProductSearchProvider;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Aei_BestSellers extends Module implements WidgetInterface
{
    private $templateFile;

    public function __construct()
    {
        $this->name = 'aei_bestsellers';
		$this->tab = 'front_office_features';
        $this->author = 'Aeipix';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        ];

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('AX Bestseller Product', array(), 'Modules.Bestsellers');
        $this->description = $this->trans('Displays top-selling products as slider or grid in the central column of your homepage.', array(), 'Modules.Bestsellers');

        $this->templateFile = 'module:aei_bestsellers/views/templates/hook/aei_bestsellers.tpl';
    }

    public function install()
    {
        $this->_clearCache('*');

        return parent::install()
            && Configuration::updateValue('AEI_BLOCK_BESTSELLERS_TO_DISPLAY', 8)
            && Configuration::updateValue('AEI_BLOCK_BESTSELLERS_SLIDER', 0)
			&& $this->registerHook('actionOrderStatusPostUpdate')
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete')
            && $this->registerHook('displayAeiBestseller')
			//&& $this->registerHook('displayHome')
            && ProductSale::fillProductSales()
        ;
    }

    public function uninstall()
    {
        $this->_clearCache('*');

        if (!parent::uninstall() ||
            !Configuration::deleteByName('AEI_BLOCK_BESTSELLERS_TO_DISPLAY')) {
            return false;
        }

        return true;
    }

    public function hookActionProductAdd($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductUpdate($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductDelete($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        $this->_clearCache('*');
    }

    public function _clearCache($template, $cache_id = null, $compile_id = null)
    {
        parent::_clearCache($this->templateFile);
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitAeiBestSellers')) {
            Configuration::updateValue('AEI_BLOCK_BESTSELLERS_TO_DISPLAY', (int)Tools::getValue('AEI_BLOCK_BESTSELLERS_TO_DISPLAY'));
			Configuration::updateValue('AEI_BLOCK_BESTSELLERS_SLIDER', (int)Tools::getValue('AEI_BLOCK_BESTSELLERS_SLIDER'));
            $this->_clearCache('*');
            $output .= $this->displayConfirmation($this->trans('The settings have been updated.', array(), 'Admin.Notifications.Success'));
        }

        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans('Settings', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->trans('Products to display', array(), 'Modules.Bestsellers.Admin'),
                        'name' => 'AEI_BLOCK_BESTSELLERS_TO_DISPLAY',
                        'desc' => $this->trans('Determine the number of product to display in this block', array(), 'Modules.Bestsellers.Admin'),
                        'class' => 'fixed-width-xs',
                    ),
					array(
                        'type' => 'switch',
                        'label' => $this->trans('Display Bestseller Product as Slider', array(), 'Modules.Bestsellers'),
                        'name' => 'AEI_BLOCK_BESTSELLERS_SLIDER',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->trans('Display Slider or Grid.(Note:Slider is working if "Number of product" is set more than 8).', array(), 'Modules.Bestsellers'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans('Save', array(), 'Admin.Actions')
                )
            )
        );

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAeiBestSellers';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'AEI_BLOCK_BESTSELLERS_TO_DISPLAY' => (int)Tools::getValue('AEI_BLOCK_BESTSELLERS_TO_DISPLAY', Configuration::get('AEI_BLOCK_BESTSELLERS_TO_DISPLAY')),
			'AEI_BLOCK_BESTSELLERS_SLIDER' => Tools::getValue('AEI_BLOCK_BESTSELLERS_SLIDER',(int)  Configuration::get('AEI_BLOCK_BESTSELLERS_SLIDER')),			
        );
    }

    public function renderWidget($hookName, array $configuration)
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('aei_bestsellers'))) {
            $variables = $this->getWidgetVariables($hookName, $configuration);

            if (empty($variables)) {
                return false;
            }

            $this->smarty->assign($variables);
        }

        return $this->fetch($this->templateFile, $this->getCacheId('aei_bestsellers'));
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $products = $this->getBestSellers();

        if (!empty($products)) {
            return array(
                'products' => $products,
                'allBestSellers' => Context::getContext()->link->getPageLink('best-sales'),
				'no_prod' => (int) Configuration::get('AEI_BLOCK_BESTSELLERS_TO_DISPLAY'),
				'slider' => (int) Configuration::get('AEI_BLOCK_BESTSELLERS_SLIDER'),
				'image_url' => $this->context->link->getMediaLink(_MODULE_DIR_.'aei_bestsellers/views/img'),				
            );
        }

        return false;
    }

    protected function getBestSellers()
    {
        if (Configuration::get('PS_CATALOG_MODE')) {
            //return false;
        }

        $searchProvider = new BestSalesProductSearchProvider(
            $this->context->getTranslator()
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        $nProducts = (int) Configuration::get('AEI_BLOCK_BESTSELLERS_TO_DISPLAY');

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        $query->setSortOrder(SortOrder::random());

        $result = $searchProvider->runQuery(
            $context,
            $query
        );

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        $products_for_template = [];

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }
}