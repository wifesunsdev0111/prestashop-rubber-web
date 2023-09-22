<?php
/**
* 2007-2017 PrestaShop.
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
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'sdk.php';
require_once 'store.php';

function startsWith($haystack, $needle)
{
    return $needle === '' || strrpos($haystack, $needle, -Tools::strlen($haystack)) !== false;
}

class Bablic extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bablic';
        $this->tab = 'i18n_localization';
        $this->version = '1.0.8';
        $this->author = 'Bablic';
        $this->need_instance = 0;
        $this->author = 'Ishai Jaffe';
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
        $this->ps_iso_langs = null;
        $this->bootstrap = true;
        $this->module_key = '85b91d2e4c985df4f58cdc3beeaaa87d';
        $this->is_subdir = false;
        $this->orig_path = '';
        parent::__construct();

        $this->displayName = $this->l('Bablic Localization');
        $this->description = $this->l('Connects your Prestashop to every language instantly');

        $this->confirmUninstall = $this->l('Please note, this will not delete your account. Please visit Bablic.com in order to delete your account or cancel your subscription if need be. Do you wish to continue?');

        $controller = Tools::getValue('controller');
        $options = array(
             'channel_id' => 'ps',
             'store' => new BablicPrestashopStore(),
             'use_snippet_url' => true,
        );
        $ps_langs = Language::getLanguages(true, $this->context->shop->id);
        if (sizeof($ps_langs) > 1) {
            $ps_iso_langs = array();
            foreach ($ps_langs as $lang) {
                $lang_code = Tools::strtolower(str_replace('-', '_', $lang['language_code']));
                $ps_iso_langs[$lang['iso_code']] = $lang_code;
                $options['folders'] = $ps_iso_langs;
            }
            $this->ps_iso_langs = $ps_iso_langs;
            $options['subdir'] = true;
            $this->is_subdir = true;
            $options['subdir_base'] = $this->getDirBase();
            $this->orig_path = $ps_langs[0]['iso_code'];
        }
        $this->sdk = new BablicSDK($options);

        if (startsWith($controller, 'Admin')) {
            return;
        }
        $this->sdk->handleRequest();
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        Configuration::updateValue('bablic_uninstalled', 'true');

        return parent::uninstall();
    }

    /**
     * Load the configuration form.
     */
    public function getContent()
    {
        /*
         * If values have been submitted in the form, process.
         */
        if (((bool) Tools::isSubmit('submitBablicModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->title = $this->displayName;
        $helper->name_controller = 'bablic_container';
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBablicModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => "For more information visit <a href='https://www.bablic.com'>Bablic.com</a> or contact us at <a href='mailto: support@bablic.com'>support@bablic.com</a>",
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_raw_data',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_siteId',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_trial',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_editor',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_token',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_data',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'check',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'bablic_uninstalled',
                    ),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $this->sdk->refreshSite();
        $values = array();
        $was_installed = Configuration::get('bablic_uninstalled');
        $values['bablic_uninstalled'] = $was_installed == '' ? '' : 'true';
        $values['bablic_raw_data'] = $this->sdk->getMeta();
        $values['bablic_siteId'] = $this->sdk->site_id;
        $values['bablic_trial'] = $this->sdk->trial_started;
        $values['bablic_editor'] = $this->sdk->editorUrl();
        $values['bablic_token'] = $this->sdk->access_token;
        $values['bablic_data'] = '{}';
        $values['check'] = 'yes';

        return $values;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $data = Tools::jsonDecode(Tools::getValue('bablic_data'), true);
        $message = '';
        $error = '';
        $action = isset($data['action']) ? $data['action'] : '';
        switch ($action) {
            case 'create':
                $this->siteCreate();
                if (!$this->sdk->site_id) {
                    $error = 'There was a problem registering this site, please check that website is online and there is that Bablic snippet was not integrated before.';
                } else {
                    $message = 'Website was registered successfully';
                }
                break;
            case 'set':
                $site = $data['site'];
                $this->sdk->setSite($site);
                $message = '';
                break;
            case 'keep':
                Configuration::updateValue('bablic_uninstalled', '');
                break;
            case 'clear':
                Configuration::updateValue('bablic_uninstalled', '');
                $this->sdk->removeSite();
                break;
            case 'update':
                $this->sdk->refreshSite();
                break;
            case 'delete':
                $this->sdk->removeSite();
                $message = 'Website was deleted from Bablic';
                break;
        }
        $this->sdk->clearCache();
    }

    public function getDirBase()
    {
        $url = Tools::getHttpHost(true).__PS_BASE_URI__;
        $path = parse_url($url, PHP_URL_PATH);

        return preg_replace("/\/$/", '', $path);
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name || Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS('//cdn2.bablic.com/addons/prestashop.js');
            $this->context->controller->addCSS('//cdn2.bablic.com/addons/prestashop.css');
        }
    }

    public function hookDisplayHeader()
    {
        $alt_tags = $this->sdk->getAltTags();
        $this->context->smarty->assign('version', $this->version);
        $this->context->smarty->assign('locales', $alt_tags);
        $this->context->smarty->assign('snippet_url', $this->sdk->getSnippet());
        $this->context->smarty->assign('async', ($this->sdk->getLocale() == $this->sdk->getOriginal()));
        $this->context->smarty->assign('subdir', $this->is_subdir);
        $this->context->smarty->assign('subdir_base', $this->getDirBase());
        $this->context->smarty->assign('orig_path', $this->orig_path);
        if ($this->ps_iso_langs) {
            $this->context->smarty->assign('folders_json', json_encode($this->ps_iso_langs));
        }

        return $this->display(__FILE__, 'altTags.tpl');
    }

    private function siteCreate()
    {
        $rslt = $this->sdk->createSite(
            array(
                'site_url' => Tools::getHttpHost(true).__PS_BASE_URI__,
            )
        );

        return empty($rslt['error']);
    }
}
