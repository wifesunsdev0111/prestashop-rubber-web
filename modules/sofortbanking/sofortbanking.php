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
 * @author patworx multimedia GmbH <service@patworx.de>
 * @copyright  2018 patworx multimedia GmbH Sofort.
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit();
}

class Sofortbanking extends PaymentModule
{
    const TIMEOUT = 10;
    const OS_ACCEPTED = 5;
    const OS_ERROR = 8;
    const OS_RECEIVED = 2;
    const OS_REFUNDED = 7;

    /** @var string HTML */
    private $html = '';

    /** @var string Supported languages */
    private $languages = array(
        'en' => array(
            'iso' => 'en',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/en_gb/pay_now/standard/pink.svg'
        ),
        'de' => array(
            'iso' => 'de',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_now/standard/pink.svg'
        ),
        'es' => array(
            'iso' => 'es',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/es_es/pay_now/standard/pink.svg'
        ),
        'fr' => array(
            'iso' => 'fr',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/fr_fr/pay_now/standard/pink.svg'
        ),
        'it' => array(
            'iso' => 'it',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/it_it/pay_now/standard/pink.svg'
        ),
        'nl' => array(
            'iso' => 'nl',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/nl_nl/pay_now/standard/pink.svg'
        ),
        'pl' => array(
            'iso' => 'pl',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/pl_pl/pay_now/standard/pink.svg'
        ),
        'gb' => array(
            'iso' => 'gb',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/en_gb/pay_now/standard/pink.svg'
        ),
        'hu' => array(
            'iso' => 'hu',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/en_gb/pay_now/standard/pink.svg'
        ),
        'cs' => array(
            'iso' => 'cs',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/en_gb/pay_now/standard/pink.svg'
        ),
        'sk' => array(
            'iso' => 'sk',
            'logo' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/en_gb/pay_now/standard/pink.svg'
        )
    );

    /**
     * Build module
     *
     * @see PaymentModule::__construct()
     */
    public function __construct()
    {
        $this->name = 'sofortbanking';
        $this->tab = 'payments_gateways';
        $this->version = '3.0.3';
        $this->author = 'patworx multimedia GmbH';
        $this->module_key = '4cc00016176bce10ba2670d6bc283a9a';
        $this->currencies = true;
        $this->currencies_mode = 'radio';
        $this->is_eu_compatible = 1;
        $this->bootstrap = true;
        $this->controllers = array(
            'payment'
        );
        parent::__construct();
        $this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('SOFORT');
        $this->description = $this->l('SOFORT - online direct payment method. More than 35,000 merchants in Europe trust SOFORT.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details?');

        if (!isset($this->context->smarty->registered_plugins['function']['displayPrice'])) {
            smartyRegisterFunction($this->context->smarty, 'function', 'displayPrice', array(
                'Tools',
                'displayPriceSmarty'
            ));
        }
        /* Add configuration warnings if needed */
        if (!Configuration::get('SOFORTBANKING_USER_ID')
            || !Configuration::get('SOFORTBANKING_PROJECT_ID')
            || !Configuration::get('SOFORTBANKING_API_KEY')) {
            $this->warning = $this->l('Module configuration is incomplete.');
        }
    }

    /**
     * Install module
     *
     * @see PaymentModule::install()
     */
    public function install()
    {
        if (!parent::install()
            || !Configuration::updateValue('SOFORTBANKING_USER_ID', '')
            || !Configuration::updateValue('SOFORTBANKING_PROJECT_ID', '')
            || !Configuration::updateValue('SOFORTBANKING_API_KEY', '')
            || !Configuration::updateValue('SOFORTBANKING_OS_ERROR', self::OS_ERROR)
            || !Configuration::updateValue('SOFORTBANKING_OS_ACCEPTED', self::OS_ACCEPTED)
            || !Configuration::updateValue('SOFORTBANKING_OS_ERROR_IGNORE', 'N')
            || !Configuration::updateValue('SOFORTBANKING_OS_ACCEPTED_IGNORE', 'N')
            || !$this->registerHook('payment')
            || !$this->registerHook('displayPaymentEU')
            || !$this->registerHook('paymentReturn')
            || !$this->registerHook('leftColumn')
            || !$this->registerHook('displayTop')
            || !$this->registerHook('paymentOptions')) {
            return false;
        }

        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'touchdesign_sofortbanking_transaction(
            order_id INT(11) NOT NULL,
            transaction_id VARCHAR(255) NOT NULL,
            received DATETIME NULL,
            UNIQUE transaction (order_id, transaction_id)
        ) ENGINE=MyISAM default CHARSET=utf8';
        if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($sql)) {
            return false;
        }

        return true;
    }

    /**
     * Uninstall module
     *
     * @see PaymentModule::uninstall()
     */
    public function uninstall()
    {
        if (!Configuration::deleteByName('SOFORTBANKING_USER_ID', '')
            || !Configuration::deleteByName('SOFORTBANKING_PROJECT_ID', '')
            || !Configuration::deleteByName('SOFORTBANKING_API_KEY', '')
            || !Configuration::deleteByName('SOFORTBANKING_OS_ERROR', 8)
            || !Configuration::deleteByName('SOFORTBANKING_OS_ACCEPTED', 5)
            || !Configuration::deleteByName('SOFORTBANKING_OS_ERROR_IGNORE', 'N')
            || !Configuration::deleteByName('SOFORTBANKING_OS_ACCEPTED_IGNORE', 'N')
            || !parent::uninstall()) {
            return false;
        }

        $sql = 'DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'touchdesign_sofortbanking_transaction';
        if (!Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($sql)) {
            return false;
        }

        return true;
    }

    /**
     * Validate submited data
     */
    private function postValidation()
    {
        $this->_errors = array();
        if (Tools::getValue('submitUpdate')) {
            if (!Tools::getValue('SOFORTBANKING_USER_ID')) {
                $this->_errors[] = $this->l('sofortueberweisung "user id" is required.');
            }
            if (!Tools::getValue('SOFORTBANKING_PROJECT_ID')) {
                $this->_errors[] = $this->l('sofortueberweisung "project id" is required.');
            }
            if (!Tools::getValue('SOFORTBANKING_API_KEY')) {
                $this->_errors[] = $this->l('sofortueberweisung "API-Key" is required.');
            }
        }
    }

    /**
     * Update submited configurations
     */
    public function getContent()
    {
        $this->html = '';
        if (Tools::isSubmit('submitUpdate')) {
            Configuration::updateValue('SOFORTBANKING_USER_ID', Tools::getValue('SOFORTBANKING_USER_ID'));
            Configuration::updateValue('SOFORTBANKING_PROJECT_ID', Tools::getValue('SOFORTBANKING_PROJECT_ID'));
            Configuration::updateValue('SOFORTBANKING_API_KEY', Tools::getValue('SOFORTBANKING_API_KEY'));
            Configuration::updateValue('SOFORTBANKING_OS_ACCEPTED', Tools::getValue('SOFORTBANKING_OS_ACCEPTED'));
            Configuration::updateValue('SOFORTBANKING_OS_ERROR', Tools::getValue('SOFORTBANKING_OS_ERROR'));
            Configuration::updateValue('SOFORTBANKING_OS_ACCEPTED_IGNORE', Tools::getValue('SOFORTBANKING_OS_ACCEPTED_IGNORE') == '1' ? 'Y' : 'N');
            Configuration::updateValue('SOFORTBANKING_OS_ERROR_IGNORE', Tools::getValue('SOFORTBANKING_OS_ERROR_IGNORE') == '1' ? 'Y' : 'N');
        }

        $this->postValidation();
        if (isset($this->_errors) && count($this->_errors)) {
            foreach ($this->_errors as $err) {
                $this->html .= $this->displayError($err);
            }
        } elseif (Tools::getValue('submitUpdate') && !count($this->_errors)) {
            $this->html .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $this->html . $this->displayForm();
    }

    /**
     * Build order state dropdown
     */
    private function getOrderStatesOptionFields($selected = null, $logable = false)
    {
        $order_states = OrderState::getOrderStates((int) $this->context->language->id);

        $result = '';
        foreach ($order_states as $state) {
            if ((!$logable && !$state['logable']) || ($logable && $state['logable'])) {
                $result .= '<option value="' . $state['id_order_state'] . '" ';
                $result .= $state['id_order_state'] == $selected ? 'selected' : '';
                $result .= '>' . $state['name'] . '</option>';
            }
        }

        return $result;
    }

    /**
     * Save transaction with associated order
     *
     * @param string $transaction
     * @param integer $order_id
     * @return boolean
     */
    public function saveTransaction($transaction, $order_id)
    {
        if (($order = $this->getOrderByTransaction($transaction)) && $order->id === null) {
            $sql = 'INSERT INTO ' . _DB_PREFIX_ . 'touchdesign_sofortbanking_transaction SET
                order_id = ' . (int) trim($order_id) . ',
                transaction_id = \'' . pSQL(trim($transaction)) . '\',
                received = NOW()';
            if (Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($sql)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get order by transaction id
     *
     * @param string $transaction
     * @return Order|NULL
     */
    public function getOrderByTransaction($transaction)
    {
        if (!empty($transaction)) {
            return new Order(Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
                SELECT order_id
                FROM `' . _DB_PREFIX_ . 'touchdesign_sofortbanking_transaction` AS o
                WHERE o.transaction_id = \'' . pSQL(trim($transaction)) . '\''));
        }

        return null;
    }

    /**
     * Build and display admin form for configurations
     */
    private function displayForm()
    {
        $this->context->controller->addJS($this->_path.'views/js/riot-compiler.js');
        $supportedLang = $this->isSupportedLang($this->context->language->iso_code);

        $dfl = array(
            'action' => $_SERVER['REQUEST_URI'],
            'mod_lang' => $supportedLang,
            'img_path' => $this->_path . 'views/img/' . $supportedLang['iso'],
            'path' => $this->_path
        );

        $config = Configuration::getMultiple(array(
            'SOFORTBANKING_USER_ID',
            'SOFORTBANKING_PROJECT_ID',
            'SOFORTBANKING_API_KEY',
            'SOFORTBANKING_OS_ACCEPTED_IGNORE',
            'SOFORTBANKING_OS_ERROR_IGNORE'
        ));

        $order_states = array(
            'accepted' => $this->getOrderStatesOptionFields(Configuration::get('SOFORTBANKING_OS_ACCEPTED'), true),
            'error' => $this->getOrderStatesOptionFields(Configuration::get('SOFORTBANKING_OS_ERROR'))
        );

        $this->context->smarty->assign(array(
            'sofort' => array(
                'order_states' => $order_states,
                'dfl' => $dfl,
                'config' => $config
            )
        ));
        
        $html = $this->display(__FILE__, 'views/templates/admin/display_form.tpl');
        return $html.$this->display(__FILE__, 'views/templates/admin/prestui/ps-tags.tpl');
    }

    /**
     * Check supported languages
     *
     * @param string $iso
     * @return string iso
     */
    private function isSupportedLang($iso = null)
    {
        if ($iso === null) {
            $iso = Language::getIsoById((int) $this->context->cart->id_lang);
        }

        if (isset($this->languages[$iso])) {
            return $this->languages[$iso];
        }

        return $this->languages['en'];
    }

    /**
     * Build and display payment button
     *
     * @param unknown $params
     * @return boolean|\PrestaShop\PrestaShop\Core\Payment\PaymentOption[]
     */
    public function hookPaymentOptions($params)
    {
        if (!$this->isPayment($params)) {
            return false;
        }

        $this->context->smarty->assign('mod_lang', $this->isSupportedLang());

        $paymentOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $paymentOption->setCallToActionText($this->l('SOFORT (Online Bank Transfer)'))
            ->setAction($this->context->link->getModuleLink($this->name, 'payment', array(
                'token' => Tools::getToken(false)
            ), true))
            ->setAdditionalInformation($this->context->smarty->fetch('module:sofortbanking/views/templates/hook/payment_options.tpl'));

        return array(
            $paymentOption
        );
    }
    
    public function hookDisplayTop()
    {
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            return;
        }
        $controller = $this->context->controller;
        if ($controller->php_self != 'order' && $controller->php_self != 'order-opc') {
            return;
        }
        if (isset($this->context->cookie->sofort_error_message)) {
            $controller->errors[] = $this->l($this->context->cookie->sofort_error_message);
            unset($this->context->cookie->sofort_error_message);
        }
        return;
    }

    /**
     * Build and display payment button
     *
     * @param array $params
     * @return string Templatepart
     */
    public function hookPayment($params)
    {
        if (!$this->isPayment($params)) {
            if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                return array();
            }
            return false;
        }
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            return array();
        }

        $this->context->smarty->assign('mod_lang', $this->isSupportedLang());
        $this->context->smarty->assign('static_token', Tools::getToken(false));

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    /**
     * Build datas for eu payment hook
     *
     * @param array $params
     * @return array $result
     */
    public function hookDisplayPaymentEU($params)
    {
        if (!$this->isPayment($params)) {
            if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                return array();
            }
            return false;
        }
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            return array();
        }

        $supportedLang = $this->isSupportedLang();

        $result = array(
            'cta_text' => $this->l('Pay easy and secure with SOFORT Banking.'),
            'logo' => $supportedLang['logo'],
            'action' => $this->context->link->getModuleLink($this->name, 'payment', array(
                'token' => Tools::getToken(false),
                'redirect' => true
            ), true)
        );

        return $result;
    }

    /**
     * Build and display confirmation
     *
     * @param array $params
     * @return string Templatepart
     */
    public function hookPaymentReturn($params)
    {
        if (!$this->isPayment()) {
            return false;
        }

        /* If PS version is >= 1.7 */
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->context->smarty->assign(array(
                'amount' => Tools::displayPrice($params['order']->getOrdersTotalPaid(), new Currency($params['order']->id_currency), false),
                'status' => ($params['order']->getCurrentState() == Configuration::get('SOFORTBANKING_OS_ACCEPTED') ? true : false)
            ));
        } else {
            $this->context->smarty->assign(array(
                'amount' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
                'status' => ($params['objOrder']->getCurrentState() == Configuration::get('SOFORTBANKING_OS_ACCEPTED') ? true : false)
            ));
        }

        $this->context->smarty->assign('shop_name', $this->context->shop->name);

        return $this->display(__FILE__, 'views/templates/hook/payment_return.tpl');
    }

    /**
     * Build and display left column banner
     *
     * @param array $params
     * @return string Templatepart
     */
    public function hookLeftColumn()
    {
        return;
    }

    /**
     * Check if payment is active
     *
     * @return boolean
     */
    public function isPayment($params = false)
    {
        if (!$this->active) {
            return false;
        }

        if (!Configuration::get('SOFORTBANKING_USER_ID')
            || !Configuration::get('SOFORTBANKING_PROJECT_ID')
            || !Configuration::get('SOFORTBANKING_API_KEY')) {
            return false;
        }
        
        if ($params) {
            if (!$this->checkCurrency($params['cart'])) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check if currency matches selections in backend
     *
     * @param unknown $cart
     * @return boolean
     */
    public function checkCurrency($cart)
    {
        $currency_order = new Currency((int) ($cart->id_currency));
        $currencies_module = $this->getCurrency((int) $cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        } elseif (is_object($currencies_module) && isset($currencies_module->id)) {
            if ($currency_order->id == $currencies_module->id) {
                return true;
            }
        }
        return false;
    }
}
