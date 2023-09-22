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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Aei_Specials extends Module implements WidgetInterface
{
    private $templateFile;

    public function __construct()
    {
        $this->name = 'aei_specials';
        $this->tab = 'front_office_features';
        $this->author = 'Aeipix';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = array(
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        );

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('AX Special Product', array(), 'Modules.Specials');
        $this->description = $this->trans('Display your products that are currently on sale as slider or grid in the central column of your homepage.', array(), 'Modules.Specials');

        $this->templateFile = 'module:aei_specials/views/templates/hook/aei_specials.tpl';
    }

    public function install()
    {
        $this->_clearCache('*');

        Configuration::updateValue('AEI_BLOCKSPECIALS_SPECIALS_NBR', 8);
		Configuration::updateValue('AEI_BLOCKSPECIALS_SLIDER', 0);

        return parent::install()
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete')
            && $this->registerHook('actionObjectSpecificPriceCoreDeleteAfter')
            && $this->registerHook('actionObjectSpecificPriceCoreAddAfter')
            && $this->registerHook('actionObjectSpecificPriceCoreUpdateAfter')
            && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        $this->_clearCache('*');

        return parent::uninstall();
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

    public function hookActionObjectSpecificPriceCoreDeleteAfter($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionObjectSpecificPriceCoreAddAfter($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionObjectSpecificPriceCoreUpdateAfter($params)
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

        if (Tools::isSubmit('submitAeiSpecials')) {
            Configuration::updateValue('AEI_BLOCKSPECIALS_SPECIALS_NBR', (int)Tools::getValue('AEI_BLOCKSPECIALS_SPECIALS_NBR'));
			Configuration::updateValue('AEI_BLOCKSPECIALS_SLIDER', (int)Tools::getValue('AEI_BLOCKSPECIALS_SLIDER'));

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
                        'label' => $this->trans('Products to display', array(), 'Modules.Specials.Admin'),
                        'name' => 'AEI_BLOCKSPECIALS_SPECIALS_NBR',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->trans('Define the number of products to be displayed in this block on home page.', array(), 'Modules.Specials.Admin'),
                    ),
					array(
                        'type' => 'switch',
                        'label' => $this->trans('Display Special Product as Slider', array(), 'Modules.Specials'),
                        'name' => 'AEI_BLOCKSPECIALS_SLIDER',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->trans('Display Slider or Grid.(Note:Slider is working if "Number of product" is set more than 4).', array(), 'Modules.Specials'),
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
                    'title' => $this->trans('Save', array(), 'Admin.Actions'),
                ),
            ),
        );

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAeiSpecials';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .
            '&configure=' . $this->name .
            '&tab_module=' . $this->tab .
            '&module_name=' . $this->name;
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
            'AEI_BLOCKSPECIALS_SPECIALS_NBR' => Tools::getValue('AEI_BLOCKSPECIALS_SPECIALS_NBR', Configuration::get('AEI_BLOCKSPECIALS_SPECIALS_NBR')),
			'AEI_BLOCKSPECIALS_SLIDER' => Tools::getValue('AEI_BLOCKSPECIALS_SLIDER', Configuration::get('AEI_BLOCKSPECIALS_SLIDER')),
        );
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('aei_specials'))) {
            $variables = $this->getWidgetVariables($hookName, $configuration);

            if (empty($variables)) {
                return false;
            }

            $this->smarty->assign($variables);
        }

        return $this->fetch($this->templateFile, $this->getCacheId('aei_specials'));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $products = $this->getSpecialProducts();

        if (!empty($products)) {
            return array(
                'products' => $products,
                'allSpecialProductsLink' => Context::getContext()->link->getPageLink('prices-drop'),
				'no_prod' => (int) Configuration::get('AEI_BLOCKSPECIALS_SPECIALS_NBR'),
				'slider' => (int) Configuration::get('AEI_BLOCKSPECIALS_SLIDER'),	
            );
        }
        return false;
    }

    private function getSpecialProducts()
    {
        $products = Product::getPricesDrop(
            (int)Context::getContext()->language->id,
            0,
            (int)Configuration::get('AEI_BLOCKSPECIALS_SPECIALS_NBR')
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

        $products_for_template = array();

        if (is_array($products)) {
            foreach ($products as $rawProduct) {
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
                );
            }
        }

        return $products_for_template;
    }
}
