<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop etSA
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *          International Registered Trademark & Property of PrestaShop SA
 */

use Gelf\Publisher;
use Gelf\Transport\TcpTransport;
use Monolog\Formatter\GelfMessageFormatter;
use Monolog\Handler\GelfHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

if (!defined('_PS_VERSION_')) {
    exit();
}

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . '/autoload.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'DirectLink.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'CurrencyCacheCleaner.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'ProductCacheCleaner.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'SpecificPriceCacheCleaner.php';

if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneTransactionLog.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneAlias.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgonePM.php';

    if (version_compare(_PS_VERSION_, '1.6', 'ge')) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneProductSubscription.php';
    } else {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneProductSubscription15.php';
    }
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneSubscription.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OgoneOrderSubscription.php';
}

class Ogone extends PaymentModule
{

    const AUTHORIZATION_CANCELLED = 'OGONE_AUTHORIZATION_CANCELLED';

    const CANCELLED = 'OGONE_CANCELLED';

    const PAYMENT_ACCEPTED = 'OGONE_PAYMENT_ACCEPTED';

    const PAYMENT_AUTHORIZED = 'OGONE_PAYMENT_AUTHORIZED';

    const PAYMENT_CANCELLED = 'OGONE_PAYMENT_CANCELLED';

    const PAYMENT_ERROR = 'OGONE_PAYMENT_ERROR';

    const PAYMENT_IN_PROGRESS = 'OGONE_PAYMENT_IN_PROGRESS';

    const SCHEDULED_PAYMENT_IN_PROGRESS = 'OGONE_SCH_PAYMENT_IN_PROGRESS';

    const PAYMENT_UNCERTAIN = 'OGONE_PAYMENT_UNCERTAIN';

    const REFUND = 'OGONE_REFUND';

    const REFUND_ERROR = 'OGONE_REFUND_ERROR';

    const REFUND_IN_PROGRESS = 'OGONE_REFUND_IN_PROGRESS';

    const SUBSCRIPTION_PAYMENT_IN_PROGRESS = 'OGONE_SUB_PAYMENT_IN_PROGRESS';

    const OPERATION_SALE = 'SAL';

    const OPERATION_AUTHORISE = 'RES';

    const MAX_LOG_FILES_ADVISED = 10;

    const DL_ALIAS_RET_PAYMENT_DONE = 1;

    const DL_ALIAS_RET_INJECT_HTML = 2;

    const DL_ALIAS_RET_ERROR = 3;

    // ECI value "7" must be sent for reccurring transactions. - asking for CVC
    // ECI value "9" must be sent for reccurring transactions. - not asking for CVC
    const INGENICO_ECI_ECOMMERCE = 7;

    const INGENICO_ECI_DL = 9;

    // Scheduled payments constants
    // @see https://payment-services.ingenico.com/int/en/ogone/support/guides/integration%20guides/scheduled-payments
    const MIN_SP_INSTALLMENTS = 2;

    //
    const MAX_SP_INSTALLMENTS = 10;

    //
    const MIN_SP_DAYS = 1;

    //
    const MAX_SP_DAYS = 43;

    // the maximum number of days between two execution dates within a series of scheduled payments is limited to 43 days.
    const MIN_SP_AMOUNT = 1;

    //
    const MAX_SP_AMOUNT = 10000;

    //

    // subscription constants
    const MIN_SUB_PERIOD_NUMBER = 1;

    const MAX_SUB_PERIOD_NUMBER = 43;

    const MIN_SUB_INSTALLMENTS = 2;

    const MAX_SUB_INSTALLMENTS = 99;

    const PERIOD_DAY = 'd';

    const PERIOD_WEEK = 'ww';

    const PERIOD_MONTH = 'm';

    // Time in seconds to block possibilite of launching many payments for same order (ie when user clicks frantically)
    const TRANSACTION_COOLDOWN_TIME = 10;

    /*
     * flag for eu_legal
     * @see https://github.com/EU-Legal/
     */
    public $is_eu_compatible = true;

    /**
     *
     * @var unknown
     */
    protected $log_file = null;

    /**
     * DirectLink library instance
     *
     * @var DirectLink
     */
    protected $direct_link_instance = null;

    /**
     * Cache of colors associated with Ingenico payment statuses
     *
     * @var array
     */
    protected $return_code_list_colors = array();

    /**
     * List of fields to ignore in sha sign generation
     *
     * @var array
     */
    protected $ignore_key_list = array(
        'secure_key',
        'ORIG',
        'controller',
        '3ds',
        'aid',
        'dg',
        'result',
        'RESULT',
        'alias_full',
        'fc',
        'module',
        'controller',
        'id_lang',
        'aip',
        'isolang',
        'controlleruri',
        'controllerUri',
        'CONTROLLERURI'
    );

    /**
     * List of required fields for payment return
     *
     * @var array
     */
    protected $needed_key_list = array(
        'ACCEPTANCE',
        'amount',
        'BRAND',
        'CARDNO',
        'currency',
        'NCERROR',
        'orderID',
        'PAYID',
        'PM',
        'SHASIGN',
        'STATUS'
    );

    protected $sha_out_fields = array(
        'AAVADDRESS',
        'AAVCHECK',
        'AAVZIP',
        'ACCEPTANCE',
        'ALIAS',
        'AMOUNT',
        'BIC',
        'BIN',
        'BRAND',
        'CARDNO',
        'CCCTY',
        'CN',
        'COMPLUS',
        'CURRENCY',
        'CVCCHECK',
        'DCC_COMMPERCENTAGE',
        'DCC_CONVAMOUNT',
        'DCC_CONVCCY',
        'DCC_EXCHRATE',
        'DCC_EXCHRATESOURCE',
        'DCC_EXCHRATETS',
        'DCC_INDICATOR',
        'DCC_MARGINPERCENTAGE',
        'DCC_VALIDHOURS',
        'DEVICE',
        'DIGESTCARDNO',
        'ED',
        'HTML_ANSWER',
        'IP',
        'IPCTY',
        'MANDATEID',
        'NCERROR',
        'NCERRORPLUS',
        'NCSTATUS',
        'ORDERID',
        'PARAMPLUS',
        'PAYID',
        'PAYIDSUB',
        'PM',
        'PSPID',
        'SCO_CATEGORY',
        'SCORING',
        'SEQUENCETYPE',
        'SIGNDATE',
        'STATUS',
        'SUBBRAND',
        'SUBSCRIPTION_ID',
        'TRXDATE',
        'VC'
    );

    /**
     * List of operations allowed
     *
     * @var array
     */
    protected $allowed_operations = array(
        self::OPERATION_SALE,
        self::OPERATION_AUTHORISE
    );

    /**
     * Return codes
     *
     * @var array
     */
    protected $return_codes = array(
        0 => array(
            'Incomplete or invalid',
            self::PAYMENT_CANCELLED
        ),
        1 => array(
            'Cancelled by customer',
            self::PAYMENT_CANCELLED
        ),
        2 => array(
            'Authorisation declined',
            self::PAYMENT_ERROR
        ),
        4 => array(
            'Order stored',
            self::PAYMENT_AUTHORIZED
        ),
        40 => array(
            'Stored waiting external result',
            self::PAYMENT_AUTHORIZED
        ),
        41 => array(
            'Waiting for client payment',
            self::PAYMENT_AUTHORIZED
        ),
        46 => array(
            'Waiting for authentication',
            self::PAYMENT_IN_PROGRESS
        ),
        5 => array(
            'Authorised',
            self::PAYMENT_AUTHORIZED
        ),
        50 => array(
            'Authorized waiting external result',
            self::PAYMENT_AUTHORIZED
        ),
        51 => array(
            'Authorisation waiting',
            self::PAYMENT_AUTHORIZED
        ),
        52 => array(
            'Authorisation not known',
            self::PAYMENT_AUTHORIZED
        ),
        55 => array(
            'Standby',
            self::PAYMENT_AUTHORIZED
        ),
        56 => array(
            'OK with scheduled payments',
            self::SCHEDULED_PAYMENT_IN_PROGRESS
        ),
        57 => array(
            'Not OK with scheduled payments',
            self::PAYMENT_ERROR
        ),
        59 => array(
            'Authoris. to be requested manually',
            self::PAYMENT_ERROR
        ),
        6 => array(
            'Authorised and cancelled',
            self::AUTHORIZATION_CANCELLED
        ),
        61 => array(
            'Author. deletion waiting',
            self::AUTHORIZATION_CANCELLED
        ),
        62 => array(
            'Author. deletion uncertain',
            self::AUTHORIZATION_CANCELLED
        ),
        63 => array(
            'Author. deletion refused',
            self::AUTHORIZATION_CANCELLED
        ),
        64 => array(
            'Authorised and cancelled',
            self::AUTHORIZATION_CANCELLED
        ),
        7 => array(
            'Payment deleted',
            self::CANCELLED
        ),
        71 => array(
            'Payment deletion pending',
            self::CANCELLED
        ),
        72 => array(
            'Payment deletion uncertain',
            self::CANCELLED
        ),
        73 => array(
            'Payment deletion refused',
            self::CANCELLED
        ),
        74 => array(
            'Payment deleted',
            self::CANCELLED
        ),
        75 => array(
            'Deletion processed by merchant',
            self::CANCELLED
        ),
        8 => array(
            'Refund',
            self::REFUND
        ),
        81 => array(
            'Refund pending',
            self::REFUND_IN_PROGRESS
        ),
        82 => array(
            'Refund uncertain',
            self::REFUND_IN_PROGRESS
        ),
        83 => array(
            'Refund refused',
            self::REFUND_ERROR
        ),
        84 => array(
            'Payment declined by the acquirer',
            self::REFUND_ERROR
        ),
        85 => array(
            'Refund processed by merchant',
            self::REFUND
        ),
        9 => array(
            'Payment requested',
            self::PAYMENT_ACCEPTED
        ),
        91 => array(
            'Payment processing',
            self::PAYMENT_IN_PROGRESS
        ),
        92 => array(
            'Payment uncertain',
            self::PAYMENT_UNCERTAIN
        ),
        93 => array(
            'Payment refused',
            self::PAYMENT_ERROR
        ),
        94 => array(
            'Refund declined',
            self::PAYMENT_ERROR
        ),
        95 => array(
            'Payment processed by merchant',
            self::PAYMENT_ACCEPTED
        ),
        96 => array(
            'Refund reversed',
            self::PAYMENT_ACCEPTED
        ),
        99 => array(
            'Being processed',
            self::PAYMENT_IN_PROGRESS
        )
    );

    /**
     * List of new states to install
     * At list names['en'] is mandatory
     *
     * @var array
     */
    protected $new_statuses = array(
        self::SUBSCRIPTION_PAYMENT_IN_PROGRESS => array(
            'names' => array(
                'en' => 'Ingenico ePayments - subscription payment in progress',
                'fr' => 'Ingenico ePayments - abonnement en cours'
            ),
            'properties' => array(
                'color' => 'royalblue',
                'logable' => true,
                'paid' => 1,
                'pdf_invoice' => 1,
                'invoice' => 1,
            )
        ),
        self::SCHEDULED_PAYMENT_IN_PROGRESS => array(
            'names' => array(
                'en' => 'Ingenico ePayments - scheduled payment in progress',
                'fr' => 'Ingenico ePayments - scheduled paiement en cours'
            ),
            'properties' => array(
                'color' => 'royalblue',
                'logable' => true,
                'template' => 'order_conf',
                'paid' => 1,
                'pdf_invoice' => 1,
                'invoice' => 1,
            )
        ),
        self::PAYMENT_IN_PROGRESS => array(
            'names' => array(
                'en' => 'Ingenico ePayments - payment in progress',
                'fr' => 'Ingenico ePayments - paiement en cours'
            ),
            'properties' => array(
                'color' => 'royalblue',
                'logable' => true
            )
        ),
        self::PAYMENT_UNCERTAIN => array(
            'names' => array(
                'en' => 'Ingenico ePayments - payment uncertain',
                'fr' => 'Ingenico ePayments - paiement incertain'
            ),
            'properties' => array(
                'color' => 'orange'
            )
        ),
        self::PAYMENT_AUTHORIZED => array(
            'names' => array(
                'en' => 'Ingenico ePayments - payment reserved',
                'fr' => 'Ingenico ePayments - paiement reservé'
            ),
            'properties' => array(
                'color' => 'royalblue'
            )
        )
    );

    /**
     * List of disponible languages for Ingenico urls and docs
     *
     * @var array
     */
    protected $documentation_languages = array(
        'en',
        'fr',
        'es',
        'de',
        'nl'
    );

    protected $test_account_url = 'https://secure.ogone.com/Ncol/Test/BackOffice/accountcreation/create';

    protected $ingenico_server = 'https://payment-services.ingenico.com/';

    protected $int_guide = '%s/%s/ogone/support/guides/integration%%20guides/prestashop-extension';

    protected $dl_guide = '%s/%s/ogone/support/guides/integration%%20guides/directlink';

    protected $support_url = '%s/%s/ogone/support/contact';

    /* Public API to check whether TSL version is correct */
    protected $check_tls_api = 'https://www.howsmyssl.com/a/check';

    protected $cipher_tool = null;

    protected $tls_version_expected = '1.2';

    /**
     * Localized contact and documentation data
     * Used in backoffice templates
     *
     * @var array
     */
    protected $localized_contact_data = array(
        'en' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+44 (0)203 147 4966',
            'sales_email' => 'salesuk.ecom@ingenico.com',
            'sales_phone_number' => '+44 (0)203 147 4966',
            'test_account_query' => 'BRANDING=ogone&ISP=OGB&SubId=7&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=GB&Lang=1'
        ),
        'fr' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+33 (0)1 70 70 09 03',
            'sales_email' => 'salesfr.ecom@ingenico.com',
            'sales_phone_number' => '+33 (0)1 70 70 09 03',
            'test_account_query' => 'BRANDING=ogone&ISP=OFR&SubId=3&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=FR&Lang=2'
        ),
        'es' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+34 91 312 74 00',
            'sales_email' => 'salesfr.ecom@ingenico.com',
            'sales_phone_number' => '+34 91 312 74 00',
            'test_account_query' => 'BRANDING=ogone&ISP=ODE&SubId=5&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=ES&Lang=6'
        ),
        'de' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+49 0800 673 50 00',
            'sales_email' => 'salesde.ecom@ingenico.com',
            'sales_phone_number' => '+49 0800 673 50 00',
            'test_account_query' => '?BRANDING=ogone&ISP=ODE&SubId=5&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=DE&Lang=5'
        ),
        'nl' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+31 (0)20 840 8400',
            'sales_email' => 'salesnl.ecom@ingenico.com',
            'sales_phone_number' => '+31 (0)20 840 8400',
            'test_account_query' => 'BRANDING=ogone&ISP=ONL&SubId=2&MODE=STD&SOLPRO=prestashopcosp&ACOUNTRY=NL&Lang=8'
        ),
        'it' => array(
            'support_email' => 'support@ecom.ingenico.com',
            'support_phone_number' => '+44 (0)203 147 4966',
            'sales_email' => 'sales.italy@ecom.ingenico.com',
            'sales_phone_number' => '+39-023320 3628',
            'test_account_query' => 'BRANDING=ogone&ISP=OGB&SubId=7&MODE=STD&SOLPRO=prestashopCOSP&ACOUNTRY=IT&Lang=4'
        )
    );

    /**
     * List of allowed fonts for static template
     *
     * @var array
     */
    protected $static_template_fonts = array(
        'Arial',
        'Charcoal',
        'Courier',
        'Helvetica',
        'Impact',
        'Monaco',
        'Tahoma',
        'Verdana'
    );

    /**
     * List of required fields for alias creation return
     *
     * @var array
     */
    protected $expected_alias_return_fields = array(
        'ALIAS',
        'CARDNO',
        'CN',
        'ED',
        'NCERROR',
        'STATUS',
        'BRAND'
    );

    protected $tpl_fields = array(
        'TITLE',
        'BGCOLOR',
        'TXTCOLOR',
        'TBLBGCOLOR',
        'TBLTXTCOLOR',
        'BUTTONBGCOLOR',
        'BUTTONTXTCOLOR',
        'FONTTYPE'
    );

    protected $selected_tab = null;

    protected $klarna_countries = array(
        'SE',
        'FI',
        'DK',
        'NO',
        'DE',
        'NL'
    );

    protected $priceFormatter = null;

    /**
     * @var Logger
     */
    protected $logger;

    // 1.7 only

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->name = 'ogone';
        $this->tab = 'payments_gateways';
        $this->version = '4.0.6';
        $this->author = 'Ingenico ePayments';
        $this->module_key = 'bd2bfda4b61f90c8f852ff252d8baaef';
        $this->ps_versions_compliancy = array('min' => '1.6.0', 'max' => _PS_VERSION_);

        parent::__construct();

        $this->displayName = 'Ingenico ePayments (formerly Ogone)';
        $this->description = $this->l('Ingenico ePayment offers you one single platform to handle all your online transactions whatever the channel.');

        /* Backward compatibility */
        if (!$this->isPS17x()) {
            require_once _PS_MODULE_DIR_ . 'ogone/backward_compatibility/backward.php';
        }
        if (!isset($this->context) && version_compare(_PS_VERSION_, 1.5, 'lt')) {
            $this->context = Context::getContext();
        }

        $this->logger = new \Psr\Log\NullLogger();
        if (Configuration::get('OGONE_USE_LOG')) {
            // Initialize Logger
            $iniFile = _PS_ROOT_DIR_ . '/config/logger.ini';
            if (file_exists($iniFile) && $data = parse_ini_file($iniFile, true)) {
                $this->logger = $this->createGelfLogger('log', $data['gelf']['host'], $data['gelf']['port'], \Monolog\Logger::DEBUG);
            } elseif (is_writable($this->getLogFileDir())) {
                $this->logger = $this->createLogger('log', $this->getLogFileDir() . $this->getLogFileName(), \Monolog\Logger::DEBUG);
            }
        }

        if (!Configuration::get('OGONE_STATS_SENT')) {
            // Send statistics
            if (Cache::isStored('OgoneStatsLastCheck') &&
                $time = Cache::retrieve('OgoneStatsLastCheck')
            ) {
                if (time() < $time + (1 * 60 * 60)) {
                    // Skip checking
                    return;
                }
            }

            $aliases = 0;
            try {
                $aliases = Db::getInstance()->executeS('SELECT * FROM ' . _DB_PREFIX_ . 'ogone_alias' . ';');
            } catch (Exception $e) {
                //
            }

            // Send
            $data = array(
                'pspid' => Configuration::get('OGONE_PSPID'),
                'store_url' => Tools::getShopDomainSsl(true, true),
                'php_version' => PHP_VERSION,
                'extension_version' => _PS_VERSION_,
                'platform' => 'PS',
                'aliases_count' => count((array) $aliases)
            );

            $result = Tools::file_get_contents('http://statistics.ing.limegrow.com/?' . http_build_query($data));
            if ($result) {
                Configuration::updateValue('OGONE_STATS_SENT', true);
            } else {
                Cache::store('OgoneStatsLastCheck', time());
            }
        }
    }

    /**
     * Build logger
     *
     * @param string $channel
     * @param string $path
     * @param int    $level
     *
     * @return Logger
     *
     * @throws \Exception
     */
    protected function createLogger($channel, $path = '/tmp/ogone.log', $level = Logger::DEBUG)
    {
        $logger = new Logger($channel);
        $logger->pushHandler(new StreamHandler($path, $level));
        $logger->pushProcessor(new WebProcessor());

        return $logger;
    }

    /**
     * Build Gelf logger
     *
     * @param string $channel
     * @param string $host
     * @param int $port
     * @param int $level
     *
     * @return Logger
     */
    protected function createGelfLogger($channel, $host, $port = 12201, $level = Logger::DEBUG)
    {
        $transport = new TcpTransport($host, $port);
        $publisher = new Publisher($transport);

        $handler = new GelfHandler($publisher, $level);
        $handler->setFormatter(new GelfMessageFormatter());

        $logger = new Logger($channel);
        $logger->pushHandler($handler);

        return $logger;
    }

    /* INSTALL */

    /**
     * Install
     */
    public function install()
    {
        $this->updatePaymentConfig();
        $result = parent::install() && $this->addStatuses() && $this->installDBTables() && $this->installHooks() && $this->initConfigVars() && $this->installTabs() && $this->addDefaultPaymentModes() && $this->installFiles();
        return $result;
    }

    public function uninstall()
    {
        return $this->doDataBackup() && $this->removeTabs() && $this->removeStatuses() && $this->deleteConfiguration() && $this->uninstallDBTables() && parent::uninstall();
    }

    protected function installFiles()
    {
        $source = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'v-model.php';
        $target = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR  . '..' . DIRECTORY_SEPARATOR . 'v.php';
        return copy($source, $target);
    }

    protected function uninstallFiles()
    {
        $target = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR  . '..' . DIRECTORY_SEPARATOR . 'v.php';
        return unlink($target);
    }

    /**
     * Creates config values for payment states for 1.4.3 and less compatibility
     */
    protected function updatePaymentConfig()
    {
        $states = array(
            'PS_OS_CHEQUE',
            'PS_OS_PAYMENT',
            'PS_OS_PREPARATION',
            'PS_OS_SHIPPING',
            'PS_OS_CANCELED',
            'PS_OS_REFUND',
            'PS_OS_ERROR',
            'PS_OS_OUTOFSTOCK',
            'PS_OS_BANKWIRE',
            'PS_OS_PAYPAL',
            'PS_OS_WS_PAYMENT'
        );
        if (!Configuration::get('PS_OS_PAYMENT')) {
            foreach ($states as $u) {
                if (!Configuration::get($u) && defined('_' . $u . '_')) {
                    Configuration::updateValue($u, constant('_' . $u . '_'));
                }
            }
        }
        return true;
    }

    /**
     * Install hooks
     */
    public function installHooks()
    {
        $result = true;
        foreach ($this->getHooksList() as $hook) {
            $result = $result && $this->registerHook($hook);
        }
        return $result;
    }

    protected function getHooksList()
    {
        $hooks = array(
            'payment',
            'header',
            'orderConfirmation',
            'backOfficeHeader',
            'customerAccount'
        );

        if ($this->isPS14x()) {
            $hooks[] = 'adminOrder';
        } else {
            $hooks[] = 'displayAdminOrder';
        }

        if ($this->isPS15x()) {
            $hooks[] = 'displayHeader';
        }

        if ($this->isPS17x()) {
            $hooks[] = 'paymentOptions';
            $hooks[] = 'paymentReturn';
            $hooks[] = 'displayPaymentByBinaries';
            $hooks[] = 'displayProductAdditionalInfo';
        } elseif (!$this->isPS14x()) {
            $hooks[] = 'displayProductButtons';
        }

        if (!$this->isPS14x()) {
            $hooks[] = 'displayAdminProductsExtra';
        }

        if ($this->isPS16x()) {
            $hooks[] = 'actionAfterDeleteProductInCart';
        }

        if ($this->isPS17x()) {
            $hooks[] = 'actionObjectProductInCartDeleteAfter';
        }

        if (method_exists('Hook', 'getIdByName') && is_callable(array(
            'Hook',
            'getIdByName'
        )) && Hook::getIdByName('displayPaymentEU')) {
            $hooks[] = 'displayPaymentEU';
        }

        return $hooks;
    }

    /**
     * Init config variables
     */
    public function initConfigVars()
    {
        $new_alias_pm = array(
            'CreditCard' => 1,
            'DirectDebits DE' => 0,
            'DirectDebits NL' => 0,
            'DirectDebits AT' => 0
        );

        $result = Configuration::updateValue('OGONE_ALIAS_PM', Tools::jsonEncode($new_alias_pm)) && Configuration::updateValue('OGONE_BGCOLOR', '#ffffff') && Configuration::updateValue('OGONE_BUTTONBGCOLOR', '') && Configuration::updateValue('OGONE_BUTTONTXTCOLOR', '#000000') && Configuration::updateValue('OGONE_DL_PASSWORD', '') && Configuration::updateValue('OGONE_DL_SHA_IN', '') && Configuration::updateValue('OGONE_DL_TIMEOUT', 30) && Configuration::updateValue('OGONE_DL_USER', '') && Configuration::updateValue('OGONE_FONTTYPE', 'Verdana') && Configuration::updateValue('OGONE_LOGO', '') && Configuration::updateValue('OGONE_MODE', 0) && Configuration::updateValue('OGONE_OPERATION', self::OPERATION_SALE) && Configuration::updateValue('OGONE_TBLBGCOLOR', '#ffffff') && Configuration::updateValue('OGONE_TBLTXTCOLOR', '#000000') && Configuration::updateValue('OGONE_TITLE', '') && Configuration::updateValue('OGONE_TXTCOLOR', '#000000') && Configuration::updateValue('OGONE_USE_ALIAS', 0) && Configuration::updateValue('OGONE_USE_DL', 0) && Configuration::updateValue('OGONE_USE_KLARNA', 0) && Configuration::updateValue('OGONE_USE_LOG', 0) && Configuration::updateValue('OGONE_USE_PM', 0) && Configuration::updateValue('OGONE_USE_TPL', 0) && Configuration::updateValue('OGONE_ALIAS_BY_DL', 0) && Configuration::updateValue('OGONE_USE_D3D', 0) && Configuration::updateValue('OGONE_WIN3DS', 'MAINW') && Configuration::updateValue('OGONE_SKIP_AC', 0) && Configuration::updateValue('OGONE_MAKE_IP', 0) && Configuration::updateValue('OGONE_DISPLAY_FRAUD_SCORING', 0) && Configuration::updateValue('OGONE_PROPOSE_ALIAS', 0) && Configuration::updateValue('OGONE_DONT_STORE_ALIAS', 0) && Configuration::updateValue('OGONE_DISPLAY_DEFAULT_OPTION', 1) && Configuration::updateValue('OGONE_SP_MINIMUM', 100) && Configuration::updateValue('OGONE_SP_INSTALLMENTS', 3) && Configuration::updateValue('OGONE_SP_DAYS', 1) && Configuration::updateValue('OGONE_SP_OPTION', 1) && Configuration::updateValue('OGONE_USE_SP', 0) && Configuration::updateValue('OGONE_USE_SUBSCRIPTION', 0) && Configuration::updateValue('OGONE_SUB_PERIOD_UNIT', 'm') && Configuration::updateValue('OGONE_SUB_PERIOD_NUMBER', 1) && Configuration::updateValue('OGONE_SUB_INSTALLMENTS', 12) && Configuration::updateValue('OGONE_SUB_PERIOD_MOMENT', 0) && Configuration::updateValue('OGONE_SUB_FIRST_PAYMENT_DELAY', 0) && Configuration::updateValue('OGONE_SUB_FIRST_AMOUNT', 0);

        $ogone_default_name = array();
        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $ogone_default_name[$language['id_lang']] = '';
        }
        $value = Tools::jsonEncode($ogone_default_name);
        $result = $result && Configuration::updateValue('OGONE_DEFAULT_NAME', $value);

        return $result;
    }

    /**
     * Installs tabs
     */
    public function installTabs()
    {
        $id_parent = (int)Tab::getIdFromClassName($this->isPS17x() ? 'AdminParentOrders' : 'AdminOrders');

        $tabs_to_add = array(
            'AdminOgoneTransactions' => $this->l('Ingenico Transactions'),
            'AdminOgoneOrders' => $this->l('Ingenico Orders')
        );
        if (!$this->isPS14x()) {
            $tabs_to_add['AdminOgoneProductSubscriptions'] = $this->l('Ingenico Subscriptions Models');
            $tabs_to_add['AdminOgoneSubscriptions'] = $this->l('Ingenico Subscriptions');
        }

        foreach ($tabs_to_add as $class_name => $name) {
            if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
                $class_name = $class_name . '14';
            }
            if (Tab::getIdFromClassName($class_name)) {
                continue;
            }
            if (!$this->addTab($class_name, $name, $id_parent)) {
                return false;
            }
        }
        return true;
    }

    protected function addTab($class_name, $name, $id_parent)
    {
        $tab = new Tab();
        $tab->id_parent = $id_parent;
        $tab->module = $this->name;
        $tab->class_name = $class_name;
        $tab->active = 1;
        foreach (Language::getLanguages(false) as $language) {
            $tab->name[(int)$language['id_lang']] = $this->l($name);
        }
        return $tab->save();
    }

    protected function removeTabs()
    {
        $result = true;
        $controllers = array(
            'AdminOgoneOrders',
            'AdminOgoneTransactions'
        );
        foreach ($controllers as $class_name) {
            if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
                $class_name = $class_name . '14';
            }
            $id = Tab::getIdFromClassName($class_name);
            if (!$id) {
                continue;
            }
            $tab = new Tab($id);
            if (!Validate::isLoadedObject($tab) || !$tab->delete()) {
                $result = false;
            }
        }
        return $result;
    }

    public function doDataBackup()
    {
        $tables = array(
            'ogone_tl',
            'ogone_alias',
            'ogone_pm',
            'ogone_pm_shop',
            'ogone_pm_lang'
        );
        if (version_compare(_PS_VERSION_, '1.6.0.3', 'ge')) {
            foreach ($tables as $table) {
                $backup_data = Tools::jsonEncode(Db::getInstance()->executeS('SELECT * FROM ' . _DB_PREFIX_ . $table));
                $target_path = PrestaShopBackup::getBackupPath() . 'backup_ingenico_' . $table . '-' . date('YmdHis') . '.json';
                if (file_put_contents($target_path, $backup_data) === false) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * Install database tables
     */
    public function installDBTables()
    {
        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_tl` (
            `id_ogone_tl` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_order` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_cart` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `payid` varchar(50) NOT NULL DEFAULT "",
            `status` INT(10) NOT NULL DEFAULT 0,
            `response` TEXT NOT NULL  DEFAULT "",
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_tl`), KEY(`id_cart`), KEY(`id_order`), KEY(`payid`), KEY(`date_add`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_alias` (
            `id_ogone_alias` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `alias` VARCHAR(512) NOT NULL DEFAULT "",
            `active` INT(10) NOT NULL DEFAULT 0,
            `cardno` VARCHAR(64) NOT NULL DEFAULT "",
            `cn` VARCHAR(128) NOT NULL DEFAULT "",
            `brand` VARCHAR(128) NOT NULL DEFAULT "",
            `expiry_date` DATE NOT NULL,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
             is_temporary INT(1) NOT NULL DEFAULT "0",
            PRIMARY KEY (`id_ogone_alias`),
            KEY(`id_customer`),
            KEY(`alias`),
            KEY(`active`),
            KEY(`expiry_date`),
            KEY (is_temporary)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_pm` (
            `id_ogone_pm` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `pm` VARCHAR(64) NOT NULL DEFAULT "",
            `brand` VARCHAR(64) NOT NULL DEFAULT "",
            `position` INT(10) NOT NULL DEFAULT 0,
            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_pm`), KEY(`active`), KEY(`position`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_pm_shop` (
            `id_ogone_pm` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_shop_group` VARCHAR(64) NOT NULL DEFAULT "",
            `position` INT(10) NOT NULL DEFAULT 0,
            `active` INT(10) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id_ogone_pm`,`id_shop`, `id_shop_group`), KEY(`active`), KEY(`position`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_pm_lang` (
            `id_ogone_pm` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_lang` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `name` VARCHAR(64) NOT NULL DEFAULT "",
            `description`  VARCHAR(64) NOT NULL DEFAULT "",
            PRIMARY KEY (`id_ogone_pm`,  `id_shop`, `id_lang`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_product` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product_attribute` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_product_subscription`),
            KEY(`id_product`),
            KEY(`id_product_attribute`),
            KEY(`active`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription_shop` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_product_subscription`, `id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_product_subscription_lang` (
            `id_ogone_product_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_lang` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `description` VARCHAR(1024) NOT NULL DEFAULT "",
            PRIMARY KEY (`id_ogone_product_subscription`, `id_lang`, `id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_subscription` (
            `id_ogone_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_subscription` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_cart` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_product_attribute` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `first_amount` DECIMAL(15,6) NOT NULL DEFAULT 0.0,
            `first_payment_delay` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `installments` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_unit` ENUM("d", "ww", "m") NOT NULL DEFAULT "m",
            `period_moment` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `period_number` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `payid` VARCHAR(1024) NOT NULL DEFAULT "",
            `cn` VARCHAR(1024) NOT NULL DEFAULT "",
            `com` VARCHAR(1024) NOT NULL DEFAULT "",
            `comment` VARCHAR(1024) NOT NULL DEFAULT "",
            `status` VARCHAR(1024) NOT NULL DEFAULT "",

            `active` INT(10) NOT NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            `start_date` datetime NOT NULL,
            `end_date` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_subscription`),
            KEY(`id_cart`),
            KEY(`id_subscription`),
            KEY(`id_customer`),
            KEY(`start_date`),
            KEY(`end_date`),
            KEY(`payid`),
            KEY(`active`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        if (!Db::getInstance()->Execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ogone_order_subscription` (
            `id_ogone_order_subscription` INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            `id_subscription` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_order` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_cart` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `id_customer` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `payid` VARCHAR(1024) NOT NULL DEFAULT "",
            `status` VARCHAR(1024) NOT NULL DEFAULT "",
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_ogone_order_subscription`),
            KEY(`id_subscription`),
            KEY(`id_order`),
            KEY(`id_cart`),
            KEY(`payid`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')) {
            return false;
        }

        return true;
    }

    public function uninstallDBTables($tables = null)
    {
        if (!is_array($tables)) {
            $tables = array(
                'ogone_tl',
                'ogone_alias',
                'ogone_pm',
                'ogone_pm_shop',
                'ogone_pm_lang',
                'ogone_order_subscription',
                'ogone_product_subscription',
                'ogone_product_subscription_lang',
                'ogone_product_subscription_shop',
                'ogone_subscription'
            );
        }
        $result = true;
        foreach ($tables as $table) {
            Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . $table);
        }
        return $result;
    }

    public function truncateDBTables($tables = null)
    {
        if (!is_array($tables)) {
            $tables = array(
                'ogone_tl',
                'ogone_alias',
                'ogone_pm',
                'ogone_pm_shop',
                'ogone_pm_lang'
            );
        }
        $result = true;
        foreach ($tables as $table) {
            Db::getInstance()->Execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . $table);
        }
        return $result;
    }

    public function deleteConfiguration()
    {
        $query = 'DELETE FROM ' . _DB_PREFIX_ . 'configuration WHERE name LIKE "OGONE%"';
        Db::getInstance()->execute($query);
        return true;
    }

    public function removeStatuses()
    {
        $result = true;

        $select_lang_id = (int)Language::getIdByIso('en');
        if (!$select_lang_id) {
            $select_lang_id = (int)Configuration::get('PS_LANG_DEFAULT');
        }

        $lang = new Language($select_lang_id);
        $iso = $lang->iso_code;

        $statuses = $this->getExistingStatuses();
        foreach ($this->new_statuses as $code => $status) {
            if (isset($statuses[$status['names'][$iso]])) {
                $status = new OrderState($status);
                $status->delete();
                Configuration::deleteByName($code);
            }
        }
        if (version_compare(_PS_VERSION_, '1.5', 'ge') && is_callable('Cache', 'clean')) {
            Cache::clean('OrderState::getOrderStates*');
        }
        return $result;
    }

    protected function arePaymentModesCreated()
    {
        $query = 'SELECT COUNT(*) FROM ' . _DB_PREFIX_ . 'ogone_pm';
        return (int)Db::getInstance()->getValue($query) > 0;
    }

    public function addDefaultPaymentModes()
    {
        /* there is something in the table. Leave it alone */
        if ($this->arePaymentModesCreated()) {
            return true;
        }

        if (version_compare(_PS_VERSION_, '1.5', 'ge') && method_exists('Shop', 'getContextListShopID')) {
            $shops = Shop::getContextListShopID();
        } else {
            $shops = array();
        }

        foreach ($this->getDefaultPaymentModes() as $idx => $row) {
            $pm = new OgonePM();
            $pm->pm = $row['pm'];
            $pm->brand = $row['brand'];
            $pm->name = $this->createMultilangArray($row['name']);
            $pm->description = $this->createMultilangArray($row['brand']);
            $pm->position = ++ $idx;
            $pm->active = 0;

            $result = $pm->save();

            /*
             * This is not so important, so we are failing silently if there is a problem
             */
            if ($result && Validate::isLoadedObject($pm)) {
                if ($shops) {
                    $pm->associateTo($shops);
                }
                $logo_source = implode(DIRECTORY_SEPARATOR, array(
                    $this->_path,
                    'views',
                    'img',
                    $pm->logo
                ));
                if (file_exists($logo_source)) {
                    $logo_target = $this->getPMUserLogoDir() . $pm->id . '.png';
                    copy($logo_source, $logo_target);
                }
            }
        }
        return true;
    }

    protected function createMultilangArray($value)
    {
        $result = array();
        foreach (Language::getLanguages() as $language) {
            $result[(int)$language['id_lang']] = $value;
        }
        return $result;
    }

    /**
     * Adds itermediary statuses.
     * Needs to be public, because it's called by upgrade_module_2_11
     *
     * @return boolean
     */
    public function addStatuses()
    {
        $result = true;

        $select_lang_id = (int)Language::getIdByIso('en');
        if (!$select_lang_id) {
            $select_lang_id = (int)Configuration::get('PS_LANG_DEFAULT');
        }

        $lang = new Language($select_lang_id);
        $iso = $lang->iso_code;

        $statuses = $this->getExistingStatuses();
        foreach ($this->new_statuses as $code => $status) {
            if (isset($statuses[$status['names'][$iso]])) {
                if ((int)Configuration::get($code) !== (int)$statuses[$status['names'][$iso]]) {
                    Configuration::updateValue($code, (int)$statuses[$status['names'][$iso]]);
                }
                continue;
            }
            $properties = isset($status['properties']) ? $status['properties'] : array();
            if (!$this->addStatus($code, $status['names'], $properties)) {
                $result = false;
            }
        }
        if (version_compare(_PS_VERSION_, '1.5', 'ge') && is_callable('Cache', 'clean')) {
            Cache::clean('OrderState::getOrderStates*');
        }

        Configuration::updateValue(self::PAYMENT_ACCEPTED, Configuration::get('PS_OS_PAYMENT'), false, false);
        Configuration::updateValue(self::PAYMENT_ERROR, Configuration::get('PS_OS_ERROR'), false, false);
        return $result;
    }

    /**
     * Returns list of existing order statuses
     *
     * @return multitype:number
     */
    public function getExistingStatuses()
    {
        $statuses = array();
        $select_lang_id = (int)Language::getIdByIso('en');
        if (!$select_lang_id) {
            $select_lang_id = (int)Configuration::get('PS_LANG_DEFAULT');
        }

        foreach (OrderState::getOrderStates($select_lang_id) as $status) {
            $statuses[$status['name']] = (int)$status['id_order_state'];
        }

        return $statuses;
    }

    /**
     * Adds new order state on install
     *
     * @param string $code
     * @param array $names
     * @param array $properties
     * @return boolean
     */
    public function addStatus($code, array $names = array(), array $properties = array())
    {
        $order_state = new OrderState();
        foreach (Language::getLanguages(false) as $language) {
            $iso_code = Tools::strtolower($language['iso_code']);
            $name = isset($names[$iso_code]) ? $names[$iso_code] : $names['en'];
            $order_state->name[(int)$language['id_lang']] = $name;
        }
        foreach ($properties as $property => $value) {
            $order_state->{$property} = $value;
        }

        $order_state->module_name = $this->name;
        $result = $order_state->add() && Validate::isLoadedObject($order_state);
        if ($result) {
            Configuration::updateValue($code, $order_state->id, false, false);
            $source = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logo.gif';
            if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
                $mb_logo = sprintf('order_state_mini_%d_%d.gif', $order_state->id, Context::getContext()->shop->id);
                $ms_tgt = _PS_TMP_IMG_DIR_ . DIRECTORY_SEPARATOR . $mb_logo;
            } else {
                $ms_tgt = null;
            }

            $targets = array(
                _PS_IMG_DIR_ . DIRECTORY_SEPARATOR . 'os' . DIRECTORY_SEPARATOR . sprintf('%d.gif', $order_state->id),
                _PS_TMP_IMG_DIR_ . DIRECTORY_SEPARATOR . sprintf('order_state_mini_%d.gif', $order_state->id),
                $ms_tgt
            );
            foreach (array_filter($targets) as $target) {
                copy($source, $target);
            }
        }
        return $result;
    }

    public function hookActionObjectProductInCartDeleteAfter($params)
    {
        return $this->hookActionAfterDeleteProductInCart($params);
    }


    public function hookActionAfterDeleteProductInCart($params)
    {
        $subscription_data = OgoneSubscription::getSubscriptionByCartId($params['id_cart']);
        if ($subscription_data) {
            $subscription = new OgoneSubscription($subscription_data['id_ogone_subscription']);
            if ($subscription->id_product == $params['id_product'] && $subscription->id_product_attribute == $params['id_product_attribute']) {
                $subscription->delete();
            }
        }
    }

    public function hookDisplayProductButtons($params)
    {
        return $this->hookDisplayProductAdditionalInfo($params);
    }

    /* HOOKS */
    public function hookDisplayProductAdditionalInfo($params)
    {
        $id_product = is_array($params['product']) ? $params['product']['id_product'] : $params['product']->id;

        $product = new Product($id_product);
        $tpl_vars = array();

        $tpl_vars['delete_add_to_cart'] = true;
        $tpl_vars['id_product_attribute'] = is_array($params['product']) && isset($params['product']['id_product_attribute']) ? $params['product']['id_product_attribute'] : Tools::getvalue('id_product_attribute');

        $subscription = OgoneProductSubscription::getSubscriptionInstanceForProduct($product->id);
        $tpl = null;
        if ($subscription) {
            $tpl_vars['subscription'] = $subscription;
            $tpl_vars['subscription_data'] = $this->getFutureSubscriptionReadableDetails($subscription, $product->getPrice());
            $tpl_vars['type'] = 'product';
            $tpl = 'product-standalone';
        } else {
            $subscriptions = OgoneProductSubscription::getSubscriptionInstancesForCombinations($product->id);
            $tpl_vars['subscriptions'] = $subscriptions;
            $tpl_vars['subscription_datas'] = array();
            foreach ($subscriptions as $subscription) {
                // $combination = new Combination($subscription->id_product_attribute);
                $tpl_vars['subscription_datas'][$subscription->id] = $this->getFutureSubscriptionReadableDetails($subscription, $product->getPrice(true, $subscription->id_product_attribute));
            }
            $tpl_vars['type'] = 'combinations';
            $tpl = 'product-combinations';
        }
        if ($tpl) {
            $tpl_vars['subscribe_link'] = $this->context->link->getModuleLink('ogone', 'subscribe', array('noop'=>'1'));
            $this->context->smarty->assign($tpl_vars);
            return $this->display(__FILE__, 'views/templates/front/' . $tpl . '.tpl');
        }

        return $tpl_vars['type'];
    }

    /*
     * public function hookDisplayProductExtraContent($params) {
     * $product = $params['product'];
     * $content = $product->name;
     *
     * if ($this->isPS17x()) {
     * $result = new PrestaShop\PrestaShop\Core\Product\ProductExtraContent();
     * $result->setTitle($this->module->l('Subscription'));
     * $result->setContent($content);
     * $result->addAttr(array('id'=>'ogone_subscription_container', 'class'=>'ogone_subscriptions'));
     * return $result->toArray();
     * }
     *
     * return $content;
     *
     * }
     */
    public function hookAdminOrder($params)
    {
        return $this->hookDisplayAdminOrder($params);
    }

    public function hookDisplayAdminOrder($params)
    {
        $id_order = (int)$params['id_order'];
        $order = new Order($id_order);
        if (!$order->module === $this->name) {
            return '';
        }

        list ($can_refund, $refund_error) = $this->canRefund($order);
        list ($can_capture, $capture_error) = $this->canCapture($order);
        $last = OgoneTransactionLog::getLastByOrderId($order->id);
        $response = ($last && is_array($last) && isset($last['response'])) ? Tools::jsonDecode($last['response'], true) : array();
        $orderid = ($response && is_array($response) && isset($response['ORDERID'])) ? $response['ORDERID'] : '';
        $payid = ($response && is_array($response) && isset($response['PAYID'])) ? $response['PAYID'] : '';

        $captured = $this->getCaptureTransactionsAmount($id_order);
        $captured_pending = $this->getPendingCaptureTransactionsAmount($id_order);
        $capture_max_amount = $this->getCaptureMaxAmount($id_order); // number_format(max(0, $order->total_paid - $order->total_paid_real - $captured_pending), 2),

        $refunded = $this->getRefundTransactionsAmount($id_order);
        $refunded_pending = $this->getPendingRefundTransactionsAmount($id_order);
        $refund_max_amount = $this->getRefundMaxAmount($id_order); // max(0, $order->total_paid_real - $refunded - $refunded_pending)

        $scoring = $this->getFraudScoring($order);
        $currency = new Currency($order->id_currency);
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $controller = 'AdminOgoneOrders14';
            $capture_link = 'index.php?tab=' . $controller . '&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite($controller);
            $return_link = 'index.php?tab=AdminOrders&vieworder&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite('AdminOrders');
            $refund_link = 'index.php?tab=' . $controller . '&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite($controller);
        } else {
            $controller = 'AdminOgoneOrders';
            $capture_link = 'index.php?controller=' . $controller . '&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite($controller);
            $return_link = 'index.php?controller=AdminOrders&vieworder&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite('AdminOrders');
            $refund_link = 'index.php?controller=' . $controller . '&id_order=' . (int)$id_order . '&token=' . Tools::getAdminTokenLite($controller);
        }
        $tpl_vars = array(
            'orderid' => $orderid,
            'payid' => $payid,
            'scoring' => $scoring,
            'currency_code' => $currency->iso_code,
            'return_link' => $return_link,
            'can_use_direct_link' => $this->canUseDirectLink(),
            'can_capture' => $can_capture,
            'cc_title' => $can_capture ? $this->l('Capture') : $capture_error,
            'capture_link' => $can_capture ? $capture_link : '',
            'max_capture_amount' => number_format($capture_max_amount, 2),
            'captured' => number_format($captured, 2),
            'captured_pending' => number_format($captured_pending, 2),
            'can_refund' => $can_refund,
            'refund_title' => $can_refund ? $this->l('Refund') : $refund_error,
            'refund_link' => $can_refund ? $refund_link : '',
            'max_refund_amount' => number_format($refund_max_amount, 2),
            'refunded' => number_format($refunded, 2),
            'refunded_pending' => number_format($refunded_pending, 2)
        );
        $os = OgoneOrderSubscription::getInstanceByOrderId($order->id);
        if ($os) {
            $subscription = new OgoneSubscription($os->id_subscription);
            $amount = $this->getSubscriptionTotal(new Cart($subscription->id_cart));
            $data = $this->getCurrentSubscriptionReadableDetails($subscription, $amount);
            foreach ($data['orders'] as &$order) {
                $order['link'] = $this->context->link->getAdminLink('AdminOrders') . '&vieworder&id_order=' . $order['id_order'];
            }
            $tpl_vars['product_url'] = $this->getProductLink($subscription->id_product);
            $tpl_vars['customer'] = new Customer($subscription->id_customer);
            $tpl_vars['customer_link'] = $this->context->link->getAdminLink('AdminCustomers') . '&viewcustomer&id_customer=' . $subscription->id_customer;
            $tpl_vars['subscription_data'] = $data;
        }
        $this->context->smarty->assign($tpl_vars);
        $tpl_name = version_compare(_PS_VERSION_, '1.5', 'ge') ? 'views/templates/admin/order.tpl' : 'views/templates/admin/order14.tpl';
        return $this->display(__FILE__, $tpl_name);
    }

    protected function getProductLink($id)
    {
        return $this->context->link->getAdminLink('AdminProducts', true, array(
            'id_product' => $id,
            'updateproduct' => 1
        )) . '#tab-hooks';
    }

    public function hookCustomerAccount()
    {
        $tpl_vars = array(
            'alias_page_link' => '',
            'subscription_page_link' => ''
        );

        if ($this->canUseAliases()) {
            $tpl_vars['alias_page_link'] = version_compare(_PS_VERSION_, '1.5', 'ge') ? $this->context->link->getModuleLink('ogone', 'aliases', array(), true) : (_PS_SSL_ENABLED_ ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/ogone/aliases.php';
        }

        if ($this->canUseSubscription()) {
            $tpl_vars['subscription_page_link'] = version_compare(_PS_VERSION_, '1.5', 'ge') ? $this->context->link->getModuleLink('ogone', 'subscriptions', array(), true) : (_PS_SSL_ENABLED_ ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/ogone/subscription.php';
        }

        $this->context->smarty->assign($tpl_vars);
        return $this->display(__FILE__, $this->isPS17x() ? 'views/templates/front/my-account-17.tpl' : 'views/templates/front/my-account.tpl');
    }
    public function hookDisplayHeader()
    {
         return $this->hookHeader();
    }

    public function hookHeader()
    {
        $paths = array(
            $this->_path . 'views/css/front.css',
            $this->_path . 'views/css/front' . $this->getPsVersionSqueezed() . '.css'
        );
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $result = array();
            foreach ($paths as $path) {
                // $result[] = '<link type="text/css" rel="stylesheet" href="' . $path . '" />';
            }
            return implode(PHP_EOL, $result);
        } else {
            foreach ($paths as $path) {
                $this->context->controller->addCss($path);
            }
            if ($this->isPS17x()) {
                $this->context->controller->registerJavascript('modules-ogone-product', 'modules/' . $this->name . '/views/js/product.js');
                $this->context->controller->registerJavascript('modules-ogone-payment', 'modules/' . $this->name . '/views/js/payment.js');
            } else {
                $this->context->controller->addJs(($this->isPS15x() ? $this->_path : 'modules/' . $this->name ). '/views/js/product.js');
                $this->context->controller->addJs(($this->isPS15x() ? $this->_path : 'modules/' . $this->name ). '/views/js/payment.js');
            }
        }
    }

    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('configure', Tools::getValue('module_name')) == $this->name || $this->context->controller->controller_name === 'AdminOrders' || $this->context->controller->controller_name === 'AdminOgoneProductSubscriptions') {
            if (version_compare(_PS_VERSION_, '1.5', '<')) {
                // removed
            } else {
                $this->context->controller->addJquery();
                $this->context->controller->addJQueryPlugin('fancybox');
                $this->context->controller->addJqueryPlugin('colorpicker');
                $this->context->controller->addJqueryUI('ui.sortable');
                $this->context->controller->addJs($this->_path . 'views/js/backoffice.js');
                $this->context->controller->addCss($this->_path . 'views/css/admin.css');
            }
        }
        return '';
    }

    public function hookDisplayPaymentByBinaries($params)
    {
        return '';
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        if (Module::isInstalled('ingenico_epayments') & Module::isEnabled('ingenico_epayments')) {
            return;
        }

        $total = $params['cart']->getOrderTotal(true, Cart::BOTH);
        $result = array();
        try {
            // see below
            $params['force_klarna_display'] = false;
            // aliases
            if (Configuration::get('OGONE_USE_ALIAS') && !$this->isSubscriptionCart($params['cart'])) {
                $params['pm'] = null;
                foreach (OgoneAlias::getCustomerActiveAliases((int)$params['cart']->id_customer) as $alias) {
                    if ($alias['is_temporary'] == 1) {
                        $creation_timestamp = strtotime($alias['date_add']);
                       /* if (time() - $creation_timestamp > 7100) {
                            // temporary aliases are stocked for 2 hours
                            continue;
                        }*/
                        continue;
                    }
                    $params['alias'] = $alias;
                    $params['eci'] = self::INGENICO_ECI_ECOMMERCE;
                    $params['immediate_payment'] = false;
                    if ($this->canUseAliasesViaDL()) {
                        $params['3ds_active'] = $this->use3DSecureForDL();
                        $params['immediate_payment'] = $this->skipAliasPaymentConfirmation();
                        $result[] = $this->getLocalAliasPaymentOption($params);
                    } else {
                        $result[] = $this->getAliasPaymentOption($params);
                    }
                }
                unset($params['3ds_active']);
                unset($params['alias']);
                unset($params['eci']);
                unset($params['immediate_payment']);

                foreach ($this->getAliasAddVariables() as $alias_add_vars) {
                    $result[] = $this->getAliasIframePaymentOption($alias_add_vars);
                }
            }
            $params['force_klarna_display'] = true;

            // payment modes
            if (Configuration::get('OGONE_USE_PM') && !$this->isSubscriptionCart($params['cart'])) {
                foreach ($this->getPaymentMethodsList() as $pm) {
                    if (!$pm->active) {
                        continue;
                    }
                    $params['pm'] = $pm;
                    $result[] = $this->getPaymentOption($params);
                }
                $params['pm'] = null;
            }

            if ($this->canUseScheduledPayment($total) && $this->useScheduledPaymentAsOption() && !$this->isSubscriptionCart($params['cart'])) {
                $result[] = $this->getScheduledPaymentOption($params);
            }

            // default
            if (empty($result) || Configuration::get('OGONE_DISPLAY_DEFAULT_OPTION')) {
                // we want to display generic option with klarna vars even if country do not match
                if ($this->isSubscriptionCart($params['cart'])) {
                    $result[] = $this->getSubscriptionPaymentOption($params);
                    // $result[] = $this->getSubscriptionPaymentOption($params);
                } elseif ($this->canUseScheduledPayment($total) && !$this->useScheduledPaymentAsOption()) {
                    $result[] = $this->getScheduledPaymentOption($params);
                } else {
                    $result[] = $this->getPaymentOption($params);
                }
            }
        } catch (Exception $ex) {
            $this->log($ex->getMessage());
            // die($ex->getMessage());
            return $ex->getMessage();
        }
        return $result;
    }

    protected function getAliasPaymentOption($params)
    {
        $params['ogone_htp_logo'] = Media::getMediaPath(_PS_MODULE_DIR_ . $this->name . '/views/img/' . $params['type_class'] . '.png');
        $this->context->smarty->assign($params);
        $option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l($params['type_name']))
            ->setAdditionalInformation($this->context->smarty->fetch('module:ogone/views/templates/front/htp-iframe-inline-17.tpl'))
            ->setForm('<form></form>')
            ->setBinary(true)
            ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_ . $this->name . '/views/img/cc_medium.png'));
        return $option;
    }

    protected function getLocalAliasPaymentOption($params)
    {
        static $c = 1;
        $vars = $this->getPaymentVars($params);
        $this->context->smarty->assign($vars);
        $option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();

        $options = array(
            'cta_text' => sprintf('%s - %s', $params['alias']['cn'], $params['alias']['cardno']),
            'additionalInformation' => $this->context->smarty->fetch('module:ogone/views/templates/front/ogone17-alias-local.tpl'),
            'action' =>$vars['local_alias_link'],
            // 'form' => $vars['local_alias_link'],
            'method' => 'POST',
            'inputs' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'id_alias',
                        'value' => $vars['alias_data']['id_ogone_alias']
                    )
                 )
            );


        if ($params['3ds_active'] && $params['immediate_payment']) {
            $inputs =  $options['inputs'];
            $inputs[] = array(
                'label' => 'CVC',
                    'type' => 'text',
                    'name' => 'CVC',
                    'value' => ''
            );

            $this->context->smarty->assign('option', array(
                'action' =>$vars['local_alias_link'],
                'id' => (int)($this->id) * 100 + (int)($vars['alias_data']['id_ogone_alias']),
                'inputs' => $inputs
            ));
            $options['form'] = $this->context->smarty->fetch('module:ogone/views/templates/front/option-local-action-3ds-form.tpl');
            $options['inputs'] = array();
            $option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $option
                ->setCallToActionText($options['cta_text'])
                ->setAdditionalInformation($options['additionalInformation'])
                ->setForm($options['form'])
                ->setBinary(false);
            return $option;
        }

        return PrestaShop\PrestaShop\Core\Payment\PaymentOption::convertLegacyOption($options)[0];
    }

    protected function getAliasIframePaymentOption($params)
    {
        $params['ogone_htp_logo'] = Media::getMediaPath(_PS_MODULE_DIR_ . $this->name . '/views/img/' . $params['type_class'] . '.png');
        $this->context->smarty->assign($params);
        $option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l($params['type_name']))
            ->setAdditionalInformation($this->context->smarty->fetch('module:ogone/views/templates/front/htp-iframe-inline-17.tpl'))
            ->setForm('<form></form>')
            ->setBinary(true)
            ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_ . $this->name . '/views/img/cc_medium.png'));

        return $option;
    }

    protected function getSubscriptionPaymentOption($params)
    {
        $params['subscription_payment'] = true;
        $subscriptions = $this->getSubscriptionArticlesFromCart($params['cart']);
        if (count($subscriptions) > 1) {
            // @todo limit this restriction - only if subscription terms differs
            throw new Exception($this->l('Cannot create two subscriptions with one cart'));
        }
        if (count($subscriptions) == 0) {
            throw new Exception($this->l('No subscriptions in this cart'));
        }
        /*
         * if (count($subscriptions) != count($params['cart']->getProducts())) {
         * // @todo remove this restriction
         * throw new Exception($this->l('Cannot command subscription with other products'));
         * }
         */
        $params['subscriptions'] = $subscriptions;
        foreach ($subscriptions as $subscription_product) {
            $params['first_amount'] = $subscription_product->first_amount;
            $params['first_payment_delay'] = $subscription_product->first_payment_delay;
            $params['period_unit'] = $subscription_product->period_unit;
            $params['period_moment'] = $subscription_product->period_moment;
            $params['period_number'] = $subscription_product->period_number;
            $this->context->smarty->assign('subscription_data', $this->getFutureSubscriptionReadableDetails($subscription_product, $this->getSubscriptionTotal($params['cart'])));
        }

        $vars = $this->getPaymentVars($params);
        if ($vars['ogone_params']['AMOUNT'] != $vars['ogone_params']['SUB_AMOUNT']) {
            $this->context->smarty->assign('first_amount_real', $vars['ogone_params']['AMOUNT'] / 100);
        }

        $options = array(
            'cta_text' => $this->l('Subscribe with Ingenico ePayments'),
            'additionalInformation' => $this->context->smarty->fetch('module:ogone/views/templates/front/subscription_presentation_before.tpl'),
            'action' => sprintf('https://secure.ogone.com/ncol/%s/orderstandard_utf8.asp', Configuration::get('OGONE_MODE') ? 'prod' : 'test'),
            'form' => null,
            'method' => 'POST',
            'inputs' => array(),
            'logo' => $this->getDefaultOptionLogoUrl()
        );

        foreach ($vars['ogone_params'] as $name => $value) {
            $options['inputs'][] = array(
                'type' => 'hidden',
                'name' => $name,
                'value' => $value
            );
        }

        if (isset($params['ogone_url'])) {
            $options['action'] = $params['ogone_url'];
        }

        if (isset($params['pm'])) {
            $options['logo'] = $params['pm']->logo_url;
            $options['cta_text'] = $params['pm']->name;
            $options['additionalInformation'] = $params['pm']->description;
        }
        return PrestaShop\PrestaShop\Core\Payment\PaymentOption::convertLegacyOption($options)[0];
    }

    protected function getPaymentOption($params)
    {
        $options = array(
            'cta_text' => isset($params['default_option_name']) ? $params['default_option_name'] : $this->l('Pay with Ingenico ePayments'),
            'additionalInformation' => $this->l('Pay safely on the next page with Ingenico using your preferred payment method'),
            'action' => sprintf('https://secure.ogone.com/ncol/%s/orderstandard_utf8.asp', Configuration::get('OGONE_MODE') ? 'prod' : 'test'),
            'form' => null,
            'method' => 'POST',
            'inputs' => array(),
            'logo' => $this->getDefaultOptionLogoUrl()
        );

        $vars = $this->getPaymentVars($params);

        foreach ($vars['ogone_params'] as $name => $value) {
            $options['inputs'][] = array(
                'type' => 'hidden',
                'name' => $name,
                'value' => $value
            );
        }

        if (isset($params['ogone_url'])) {
            $options['action'] = $params['ogone_url'];
        }

        if (isset($params['pm'])) {
            $options['logo'] = $params['pm']->logo_url;
            $options['cta_text'] = $params['pm']->name;
            $options['additionalInformation'] = $params['pm']->description;
        }

        return PrestaShop\PrestaShop\Core\Payment\PaymentOption::convertLegacyOption($options)[0];
    }

    protected function renderScheduledPaymentTemplate($params)
    {
        $params['scheduled_payment'] = true;
        $vars = $this->getPaymentVars($params);
        $this->context->smarty->assign(array(
            'scheduled' => $vars['scheduled_payment_data']
        ));

        $options = array(
            'cta_text' => sprintf($this->l('Pay on %d times with Ingenico ePayments'), count($vars['scheduled_payment_data'])),
            'additionalInformation' => $this->display(__FILE__, 'views/templates/front/scheduled_info-16.tpl'),
            'action' => sprintf('https://secure.ogone.com/ncol/%s/orderstandard_utf8.asp', Configuration::get('OGONE_MODE') ? 'prod' : 'test'),
            'form' => null,
            'method' => 'POST',
            'inputs' => array(),
            'logo' => $this->getDefaultOptionLogoUrl()
        );

        foreach ($vars['ogone_params'] as $name => $value) {
            $options['inputs'][] = array(
                'type' => 'hidden',
                'name' => $name,
                'value' => $value
            );
        }

        if (isset($params['ogone_url'])) {
            $options['action'] = $params['ogone_url'];
        }

        if (isset($params['pm'])) {
            $options['logo'] = $params['pm']->logo_url;
            $options['cta_text'] = $params['pm']->name;
            $options['additionalInformation'] = $params['pm']->description;
        }
        $this->context->smarty->assign('ogone_params', $vars['ogone_params']);

        $this->context->smarty->assign($options);

        return $this->display(__FILE__, 'views/templates/front/ogone-scheduled.tpl');
    }

    protected function renderSubscriptionPaymentTemplate($params)
    {
        $params['subscription_payment'] = true;
        $subscriptions = $this->getSubscriptionArticlesFromCart($params['cart']);
        if (count($subscriptions) > 1) {
            // @todo limit this restriction - only if subscription terms differs
            throw new Exception($this->l('Cannot create two subscriptions with one cart'));
        }
        if (count($subscriptions) == 0) {
            throw new Exception($this->l('No subscriptions in this cart'));
        }
        /*
         * if (count($subscriptions) != count($params['cart']->getProducts())) {
         * // @todo remove this restriction
         * throw new Exception($this->l('Cannot command subscription with other products'));
         * }
         */
        $params['subscriptions'] = $subscriptions;
        foreach ($subscriptions as $subscription_product) {
            $params['first_amount'] = $subscription_product->first_amount;
            $params['first_payment_delay'] = $subscription_product->first_payment_delay;
            $params['period_unit'] = $subscription_product->period_unit;
            $params['period_moment'] = $subscription_product->period_moment;
            $params['period_number'] = $subscription_product->period_number;
            $this->context->smarty->assign('subscription_data', $this->getFutureSubscriptionReadableDetails($subscription_product, $this->getSubscriptionTotal($params['cart'])));
        }

        $vars = $this->getPaymentVars($params);
        if ($vars['ogone_params']['AMOUNT'] != $vars['ogone_params']['SUB_AMOUNT']) {
            $this->context->smarty->assign('first_amount_real', $vars['ogone_params']['AMOUNT'] / 100);
        }

        $options = array(
            'cta_text' => $this->l('Subscribe with Ingenico ePayments'),
            'additionalInformation' => $this->display(__FILE__, 'views/templates/front/subscription_presentation_before.tpl'),
            'action' => sprintf('https://secure.ogone.com/ncol/%s/orderstandard_utf8.asp', Configuration::get('OGONE_MODE') ? 'prod' : 'test'),
            'form' => null,
            'method' => 'POST',
            'inputs' => array(),
            'logo' => $this->getDefaultOptionLogoUrl()
        );

        foreach ($vars['ogone_params'] as $name => $value) {
            $options['inputs'][] = array(
                'type' => 'hidden',
                'name' => $name,
                'value' => $value
            );
        }

        if (isset($params['ogone_url'])) {
            $options['action'] = $params['ogone_url'];
        }

        if (isset($params['pm'])) {
            $options['logo'] = $params['pm']->logo_url;
            $options['cta_text'] = $params['pm']->name;
            $options['additionalInformation'] = $params['pm']->description;
        }
        $this->context->smarty->assign('ogone_params', $vars['ogone_params']);

        $this->context->smarty->assign($options);
        return $this->display(__FILE__, 'views/templates/front/ogone-subscription.tpl');
    }

    protected function getScheduledPaymentOption($params)
    {
        $params['scheduled_payment'] = true;
        $vars = $this->getPaymentVars($params);
        $this->context->smarty->assign(array(
            'scheduled' => $vars['scheduled_payment_data']
        ));
        $options = array(
            'cta_text' => sprintf($this->l('Pay on %d times with Ingenico ePayments'), count($vars['scheduled_payment_data'])),
            'additionalInformation' => $this->context->smarty->fetch('module:ogone/views/templates/front/scheduled_info.tpl'),
            'action' => sprintf('https://secure.ogone.com/ncol/%s/orderstandard_utf8.asp', Configuration::get('OGONE_MODE') ? 'prod' : 'test'),
            'form' => null,
            'method' => 'POST',
            'inputs' => array(),
            'logo' => $this->getDefaultOptionLogoUrl()
        );

        foreach ($vars['ogone_params'] as $name => $value) {
            $options['inputs'][] = array(
                'type' => 'hidden',
                'name' => $name,
                'value' => $value
            );
        }

        if (isset($params['ogone_url'])) {
            $options['action'] = $params['ogone_url'];
        }

        if (isset($params['pm'])) {
            $options['logo'] = $params['pm']->logo_url;
            $options['cta_text'] = $params['pm']->name;
            $options['additionalInformation'] = $params['pm']->description;
        }

        return PrestaShop\PrestaShop\Core\Payment\PaymentOption::convertLegacyOption($options)[0];
    }

    /**
     * hookPayment replacement for compatibility with module eu_legal
     *
     * @param array $params
     * @return string Generated html
     */
    public function hookDisplayPaymentEU($params)
    {
        $this->assignPaymentVars($params);
        return array(
            'cta_text' => $this->l('Ogone'),
            'logo' => $this->_path . 'views/img/ogone.gif',
            'form' => $this->context->smarty->fetch(dirname(__FILE__) . '/views/templates/front/ogone_eu.tpl')
        );
    }

    public function hookPayment($params)
    {
        try {
            $result = array();
            // see below
            $params['force_klarna_display'] = false;
            // aliases

            $total = $params['cart']->getOrderTotal(true, Cart::BOTH);

            if (Configuration::get('OGONE_USE_ALIAS') && !$this->isSubscriptionCart($params['cart'])) {
                $params['pm'] = null;
                foreach (OgoneAlias::getCustomerActiveAliases((int)$params['cart']->id_customer) as $alias) {
                    if ($alias['is_temporary'] == 1) {
                        $creation_timestamp = strtotime($alias['date_add']);
                       /* if (time() - $creation_timestamp > 7100) {
                            // temporary aliases are stocked for 2 hours
                            continue;
                        }*/
                        continue;
                    }
                    $params['alias'] = $alias;
                    $params['eci'] = self::INGENICO_ECI_ECOMMERCE;
                    $params['immediate_payment'] = false;
                    if ($this->canUseAliasesViaDL()) {
                        $params['immediate_payment'] = $this->skipAliasPaymentConfirmation();
                        $params['3ds_active'] = $this->use3DSecureForDL();
                        $result[] = $this->renderPaymentTemplate($params, 'alias-local');
                    } else {
                        $result[] = $this->renderPaymentTemplate($params, 'alias');
                    }
                }
                unset($params['alias']);
                unset($params['eci']);
                unset($params['3ds_active']);
                unset($params['immediate_payment']);

                foreach ($this->renderAliasAddTemplates() as $alias_add_tpl) {
                    $result[] = $alias_add_tpl;
                }
            }
            $params['force_klarna_display'] = true;

            // payment modes
            if (Configuration::get('OGONE_USE_PM') && !$this->isSubscriptionCart($params['cart'])) {
                foreach ($this->getPaymentMethodsList() as $pm) {
                    if (!$pm->active) {
                        continue;
                    }
                    $params['pm'] = $pm;
                    $result[] = $this->renderPaymentTemplate($params, 'pm');
                }
                $params['pm'] = null;
            }

            if ($this->canUseScheduledPayment($total) && $this->useScheduledPaymentAsOption() && !$this->isSubscriptionCart($params['cart'])) {
                $result[] = $this->renderScheduledPaymentTemplate($params);
            }

            // default
            if (empty($result) || Configuration::get('OGONE_DISPLAY_DEFAULT_OPTION')) {
                if ($this->isSubscriptionCart($params['cart'])) {
                    $result[] = $this->renderSubscriptionPaymentTemplate($params);
                } elseif ($this->canUseScheduledPayment($total) && !$this->useScheduledPaymentAsOption()) {
                    $result[] = $this->renderScheduledPaymentTemplate($params);
                } else {
                    // we want to display generic option with klarna vars even if country do not match

                    $result[] = $this->renderPaymentTemplate($params);
                }
            }
            return implode(PHP_EOL, $result);
        } catch (Exception $ex) {
            $this->log($ex->getMessage());
            return '';
        }
    }

    public function getLocalAliasPaymentLink($params = array())
    {
        if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
            return $this->context->link->getModuleLink($this->name, $this->skipAliasPaymentConfirmation() ? 'validation' : 'payment', $params, true);
        } else {
            return (_PS_SSL_ENABLED_ ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/ogone/' . ($this->skipAliasPaymentConfirmation() ? 'validate_alias' : 'payment') . '.php' . ($params ? '?' . http_build_query($params) : '');
        }
    }

    protected function getPsVersionSqueezed()
    {
        return implode('', array_slice(explode('.', _PS_VERSION_), 0, 2));
    }

    protected function getAliasAddVariables()
    {
        $customer = $this->context->customer;
        $result = array();
        if ($customer && $customer->id) {
            foreach ($this->getHostedTokenizationPageRegistrationUrls($customer->id, $this->makeImmediateAliasPayment()) as $type => $url) {
                $tpl_vars = array();
                $tpl_vars['type'] = $type;
                $tpl_vars['type_class'] = Tools::strtolower(str_replace(' ', '', $type));
                $tpl_vars['type_name'] = $this->getHTPPaymentMethodName($type);
                $tpl_vars['htp_url'] = $url;
                $tpl_vars['has_aliases'] = (bool)OgoneAlias::getCustomerActiveAliases($customer->id);
                $tpl_vars['immediate_payment'] = $this->makeImmediateAliasPayment();
                if ($this->canUseAliases()) {
                    if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
                        $tpl_vars['alias_page_url'] = $this->context->link->getModuleLink($this->name, 'aliases', array(), true);
                    } else {
                        $tpl_vars['alias_page_url'] = (_PS_SSL_ENABLED_ ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/ogone/aliases.php';
                    }
                } else {
                    $tpl_vars['alias_page_url'] = '';
                }
                $result[] = $tpl_vars;
            }
        }
        return $result;
    }

    protected function renderAliasAddTemplates()
    {
        $result = array();
        foreach ($this->getAliasAddVariables() as $tpl_vars) {
            $this->context->smarty->assign($tpl_vars);
            $result[] = $this->display(__FILE__, 'views/templates/front/htp-iframe-inline.tpl');
        }
        return $result;
    }

    protected function renderPaymentTemplate($params, $type = '')
    {
        if ($this->assignPaymentVars($params)) {
            return $this->display(__FILE__, $this->getPaymentTemplate($type));
        }
        return '';
    }

    protected function getPaymentTemplate($type = '')
    {
        if (version_compare(_PS_VERSION_, '1.6', 'ge')) {
            $tpl = 'ogone16';
        } elseif (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $tpl = 'ogone14';
        } else {
            $tpl = 'ogone';
        }
        if ($type) {
            $tpl .= '-' . $type;
        }
        $tpl .= '.tpl';
        return 'views/templates/front/' . $tpl;
    }

    public function hookOrderConfirmation($params)
    {
        $order = isset($params['objOrder']) ? $params['objOrder'] : $params['order'];

        if ($order->module != $this->name) {
            return;
        }

        $current_state = (isset($order->current_state) && $order->current_state) ? $order->current_state : $order->getCurrentState();
        if ($order->valid || (Configuration::get('OGONE_OPERATION') == self::OPERATION_AUTHORISE && (int)$current_state === (int)Configuration::get('OGONE_PAYMENT_AUTHORIZED'))) {
            $this->context->smarty->assign(array(
                'status' => 'ok',
                'id_order' => $order->id
            ));
        } else {
            $this->context->smarty->assign('status', 'failed');
        }

        $this->context->smarty->assign('operation', Configuration::get('OGONE_OPERATION') ? Configuration::get('OGONE_OPERATION') : self::OPERATION_SALE);

        $link = method_exists('Link', 'getPageLink') ? $this->context->link->getPageLink(version_compare(_PS_VERSION_, '1.5', 'lt') ? 'contact-form.php' : 'contact', true) : Tools::getHttpHost(true) . 'contact';
        $this->context->smarty->assign('ogone_link', $link);
        return $this->display(__FILE__, 'views/templates/hook/hookorderconfirmation.tpl');
    }

    public function getProductName($id_product, $id_combination = null)
    {
        $product = new Product($id_product);
        $name = $product->name[$this->context->language->id];
        if ($id_combination) {
            $combinations = $this->getProductCombinationsWithNames($product);
            $name .= ' - ' . (isset($combinations[$id_combination]) ? $combinations[$id_combination]['name'] : $id_combination);
        }
        return $name;
    }

    public function getProductCombinationsWithNames($product)
    {
        $combinations = array();
        foreach ($product->getAttributeCombinations($this->context->language->id) as $combination) {
            $idx = (int)$combination['id_product_attribute'];
            $combinations[$idx]['id'] = $idx;
            $combinations[$idx]['reference'] = $combination['reference'];
            $combinations[$idx]['names'][] = sprintf('%s : %s', $combination['group_name'], $combination['attribute_name']);
        }
        foreach ($combinations as $idx => $combination) {
            $combinations[$idx]['name'] = implode(', ', $combination['names']);
        }
        return $combinations;
    }

    public function getProductCombinationName($product, $id_product_attribute)
    {
        $combinations = $this->getProductCombinationsWithNames($product);
        return $combinations[$id_product_attribute]['name'];
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        if (!$this->canUseSubscription()) {
            $this->context->smarty->assign('bo_module_url', 'index.php?tab=AdminModules&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
            return $this->context->smarty->fetch(dirname(__FILE__) . '/views/templates/admin/product-subscription-inactive.tpl');
        }

        $product_id = $this->isPS17x() ? $params['id_product'] : (int)Tools::getValue('id_product');

        if (!$product_id) {
            return '';
        }

        $product = new Product($product_id);

        $subscriptions = array();

        $product_subscription = OgoneProductSubscription::getSubscriptionInstanceForProduct($product_id);

        if ($product_subscription && $product_subscription->id) {
            $subscriptions[] = array(
                'type' => 'product',
                'id_product' => $product_id,
                'id_product_attribute' => 0,
                'name' => $product->name[$this->context->language > id],
                'reference' => $product->reference,
                'subscription' => $product_subscription,
                'period' => $this->getSubscriptionFrequency($product_subscription->period_moment, $product_subscription->period_number, $product_subscription->period_unit),
                'edit_link' => $product_subscription ? $this->getSubscriptionProductEditLink($product_subscription->id, $product_subscription->id_product) : '',
                'delete_link' => $product_subscription ? $this->getSubscriptionProductDeleteLink($product_subscription->id) : '',
                'create_link' => ''

            );
        } else {
            $combinations = $this->getProductCombinationsWithNames($product);
            if (!empty($combinations)) {
                foreach ($combinations as $idx => $combination) {
                    $subscription = OgoneProductSubscription::getSubscriptionInstanceForProduct($product_id, $idx);
                    $subscriptions[] = array(
                        'type' => 'combination',
                        'id_product' => $product_id,
                        'id_product_attribute' => $combination['id'],
                        'name' => $combination['name'],
                        'reference' => $combination['reference'],
                        'subscription' => $subscription,
                        'period' => $subscription ? $this->getSubscriptionFrequency($subscription->period_moment, $subscription->period_number, $subscription->period_unit) : '',
                        'edit_link' => $subscription ? $this->getSubscriptionProductEditLink($subscription->id, $subscription->id_product, $subscription->id_product_attribute) : '',
                        'delete_link' => $subscription ? $this->getSubscriptionProductDeleteLink($subscription->id) : '',
                        'create_link' => $subscription ? '' : $this->getSubscriptionProductCreateLink($product_id, $combination['id'])
                    );
                }
            } else {
                $subscriptions[] = array(
                    'type' => 'product',
                    'id_product' => $product_id,
                    'id_product_attribute' => 0,
                    'name' => $product->name[$this->context->language > id],
                    'reference' => $product->reference,
                    'subscription' => null,
                    'delete_link' => '',
                    'edit_link' => '',
                    'create_link' => $this->getSubscriptionProductCreateLink($product_id, 0)
                );
            }
        }

        $tpl_vars = array(
            'subscriptions' => $subscriptions
        );

        $this->context->smarty->assign($tpl_vars);
        return $this->context->smarty->fetch(dirname(__FILE__) . '/views/templates/admin/product-subscription.tpl');
    }

    protected function getSubscriptionProductEditLink($id_ogone_product_subscription, $id_product, $id_product_attribute = null)
    {

        $data = array(
            'updateogone_product_subscription' => 1,
            'id_ogone_product_subscription' => (int)$id_ogone_product_subscription,
            'id_product' => $id_product
        );
        if ($id_product_attribute) {
            $data['id_product_attribute'] = $id_product_attribute;
        }
        return $this->getBackofficeControllerLink('AdminOgoneProductSubscriptions', $data);
    }

    protected function getSubscriptionProductDeleteLink($id_ogone_product_subscription)
    {
        return $this->getBackofficeControllerLink('AdminOgoneProductSubscriptions', array(
            'deleteogone_product_subscription' => 1,
            'id_ogone_product_subscription' => (int)$id_ogone_product_subscription
        ));
    }

    protected function getSubscriptionProductCreateLink($id_product, $id_product_attribute = 0)
    {
        return $this->getBackofficeControllerLink('AdminOgoneProductSubscriptions', array(
            'addogone_product_subscription' => 1,
            'id_product' => (int)$id_product,
            'id_product_attribute' => (int)$id_product_attribute
        ));
    }

    protected function getBackofficeControllerLink($controller, $params = array())
    {
        return $this->context->link->getAdminLink($controller) . '&' . http_build_query($params);
    }

    /* BACKOFFICE DISPLAY */
    public function getContent()
    {
        $messages = $this->processConfig();
        foreach ($this->checkSettings() as $type => $check_messages) {
            if ($check_messages) {
                foreach ($check_messages as $message) {
                    $messages[$type][] = $message;
                }
            }
        }

        $tpl_vars = array(
            'notify_url' => Tools::version_compare(_PS_VERSION_, '1.7.6', '>=') ? true : false,
            'messages' => $messages,
            'tabs' => $this->getConfigurationTabs(),
            'ps_tracker_url' => $this->getPrestashopTrackerUrl(),
            'selected_tab' => $this->getSelectedTab()
        );

        $this->context->smarty->assign($tpl_vars);

        return $this->display(__FILE__, 'views/templates/admin/tabs.tpl');
    }

    protected function getSelectedTab()
    {
        if ($this->selected_tab !== null) {
            return $this->selected_tab;
        }

        if (Tools::getValue('selected_tab')) {
            return Tools::getValue('selected_tab');
        }

        if (Configuration::get('OGONE_PSPID')) {
            return 'configuration';
        }

        return 'info';
    }

    protected function processConfig()
    {
        $messages = array(
            'errors' => array(),
            'warnings' => array(),
            'informations' => array(),
            'successes' => array()
        );

        if (Tools::getValue('action')) {
            $action = Tools::getValue('action');
            if ($action === 'delete_pm') {
                $this->selected_tab = 'pm';
                if ($this->deletePM((int)Tools::getValue('pmid'))) {
                    $messages['successes'][] = $this->l('Payment method deleted');
                } else {
                    $messages['errors'][] = $this->l('Unable to delete payment method');
                }
            }
        }

        if (Tools::isSubmit('submitOgoneDeleteLogo')) {
            $this->selected_tab = 'pm';
            $files_deleted = $this->deleteDefaultOptionLogo();
            if ($files_deleted) {
                $messages['successes'][] = $this->l('Logo deleted');
            } else {
                $messages['errors'][] = $this->l('Unable to delete logo');
            }
        }
        if (Tools::isSubmit('submitOgoneClearLogs')) {
            $this->selected_tab = 'logs';
            $files_deleted = $this->clearLogFiles();
            if ($files_deleted) {
                $messages['successes'][] = sprintf($this->l('%d log files deleted'), $files_deleted);
            } else {
                $messages['errors'][] = $this->l('Unable to delete log files');
            }
        }

        if (Tools::isSubmit('submitOgoneClearUpgradeLogs')) {
            $this->selected_tab = 'logs';
            $files_deleted = $this->clearUpgradeLogFiles();
            if ($files_deleted) {
                $messages['successes'][] = sprintf($this->l('%d log files deleted'), $files_deleted);
            } else {
                $messages['errors'][] = $this->l('Unable to delete log files');
            }
        }

        if (Tools::isSubmit('submitOgone')) {
            $this->selected_tab = 'configuration';
            $this->updateConfiguration();
            $messages['successes'][] = $this->l('General configuration updated');
        }
        if (Tools::isSubmit('submitOgoneStatic')) {
            $this->selected_tab = 'static';
            $this->updateStaticConfiguration();
            $messages['successes'][] = $this->l('Static template updated');
        }
        if (Tools::isSubmit('submitOgoneScheduled')) {
            $this->selected_tab = 'scheduled';
            $this->updateScheduledConfiguration();
            $messages['successes'][] = $this->l('Scheduled payments updated');
        }
        if (Tools::isSubmit('submitOgoneSubscription')) {
            $this->selected_tab = 'subscription';
            $this->updateSubscriptionConfiguration();
            $messages['successes'][] = $this->l('Subscription configuration updated');
        }
        if (Tools::isSubmit('submitOgonePM')) {
            $this->selected_tab = 'pm';
            if ($this->updatePMConfiguration()) {
                $messages['successes'][] = $this->l('Payment methods updated');
            } else {
                $messages['errors'][] = $this->l('Unable to update payment methods');
            }
            list ($image_upload, $message) = $this->uploadPaymentLogo('OGONE_DEFAULT_LOGO', $this->getDefaultOptionLogoFilename());
            if ($image_upload === true) {
                $messages['successes'][] = $message;
            } elseif ($image_upload === false) {
                $messages['errors'][] = $message;
            }
        }
        if (Tools::isSubmit('submitOgoneAddPM')) {
            $this->selected_tab = 'pm';
            $pm = $this->addPaymentMethod();
            if ($pm) {
                // $messages['successes'][] = $this->l('Payment method was added');
                list ($image_upload, $message) = $this->uploadPaymentLogo('add_pm_logo', $this->getPMUserLogoDir() . $pm->id . '.png');
                if ($image_upload === null) {
                    $messages['successes'][] = $this->l('Payment method was added');
                } elseif ($image_upload === true) {
                    $messages['successes'][] = $this->l('Payment method was added with image');
                } else {
                    $messages['warnings'][] = $this->l('Payment method was added but') . ' ' . lcfirst($message);
                }
            } else {
                $messages['errors'][] = $this->l('Unable to add payment method');
            }
        }
        if (Tools::isSubmit('submitOgoneLog')) {
            $this->selected_tab = 'logs';
            $this->updateLogConfiguration();
            $messages['successes'][] = $this->l('Log configuration updated');
        }
        return $messages;
    }

    protected function deletePM($pmid)
    {
        $pm = new OgonePM((int)$pmid);
        if (Validate::isLoadedObject($pm)) {
            return $pm->delete();
        }
        return false;
    }

    /**
     * Checks all necessary module settings
     */
    protected function checkSettings()
    {
        $errors = array();
        $warnings = array();
        $successes = array();
        $informations = array();

        if (version_compare(_PS_VERSION_, 1.5, 'le')) {
            $errors[] = $this->l('Invalid Prestashop version. Minimal version required is 1.6.0.');
        }

        $can_use_dl = $this->canUseDirectLink();
        if (!function_exists('curl_init')) {
            $errors[] = $this->l('In order to use DirectLink, PHP\'s curl extension is necessary.');
        }

        if (!function_exists('simplexml_load_string')) {
            $errors[] = $this->l('In order to use DirectLink, PHP\'s simplexml extension is necessary.');
        }

        if (!function_exists('mcrypt_encrypt')) {
            $errors[] = $this->l('In order to store aliases securely, PHP\'s mcrypt extension is necessary.');
        }
        $tls_version = $this->getTLSVersion();

        if ($tls_version === null) {
            $warnings[] = $this->l('Unable to verify TLS version. Please contact your hosting provider.');
        } elseif (version_compare($tls_version, $this->tls_version_expected, 'lt')) {
            $message = $this->l('TLS version detected is %s, expected version is at least %s.');
            $errors[] = sprintf($message, $tls_version, $this->tls_version_expected);
            $errors[] = $this->l('For security reasons, you should upgrade your server.');
            $errors[] = $this->l('Some functionalities will not work with incorrect TLS version.');
            $errors[] = $this->l('Please contact your hosting provider or server administrator.');
        } else {
            $message = $this->l('TLS version detected is %s, it seems that your server is secure.');
            $successes[] = sprintf($message, $tls_version);
        }

        if (Configuration::get('OGONE_MODE') && !Configuration::get('OGONE_PSPID')) {
            $errors[] = $this->l('You activated Production mode, but PSPID parameter is not defined.');
        }

        if (Configuration::get('OGONE_MODE') && !Configuration::get('OGONE_SHA_IN')) {
            $errors[] = $this->l('You activated Production mode, but SHA-IN parameter is not defined.');
        }

        if (Configuration::get('OGONE_MODE') && !Configuration::get('OGONE_SHA_OUT')) {
            $errors[] = $this->l('You activated Production mode, but SHA-OUT parameter is not defined.');
        }

        if (Configuration::get('OGONE_PSPID') && !Configuration::get('OGONE_SHA_IN')) {
            $errors[] = $this->l('You entered PSPID, but SHA-IN parameter is not defined.');
        }

        if (Configuration::get('OGONE_PSPID') && !Configuration::get('OGONE_SHA_OUT')) {
            $errors[] = $this->l('You entered PSPID, but SHA-OUT parameter is not defined.');
        }

        if (Configuration::get('OGONE_USE_DL') && !Configuration::get('OGONE_DL_SHA_IN')) {
            $errors[] = $this->l('You activated Direct Link usage, but DirectLink SHA-IN parameter is not defined.');
        }

        if (Configuration::get('OGONE_USE_DL') && !Configuration::get('OGONE_DL_USER')) {
            $errors[] = $this->l('You activated Direct Link usage, but DirectLink user is not defined.');
        }

        if (Configuration::get('OGONE_USE_D3D') && !$can_use_dl) {
            $errors[] = $this->l('You activated 3-D Secure over DirectLink usage, but DirectLink is not configured properly.');
        }

        if (Configuration::get('OGONE_MAKE_IP') && !$can_use_dl) {
            $warnings[] = $this->l('You activated Make Immediate Alias mode, but DirectLink is not configured properly.');
        }

        if (Configuration::get('OGONE_USE_DL') && !Configuration::get('OGONE_DL_PASSWORD')) {
            $errors[] = $this->l('You activated Direct Link usage, but DirectLink password is not defined.');
        }

        if (Configuration::get('OGONE_OPERATION') == self::OPERATION_AUTHORISE && !$can_use_dl) {
            $warnings[] = $this->l('You activated Capture mode, but DirectLink is not configured properly.');
            $warnings[] = $this->l('You will need to capture orders manully via Ingenico BackOffice.');
        }

        if (!file_exists($this->getPMUserLogoDir())) {
            $errors[] = sprintf($this->l('Directory %s do not exisits.'), $this->getPMUserLogoDir());
        }

        if (Configuration::get('OGONE_USE_LOG')) {
            $log_files = count($this->getLogFiles());
            if ($log_files > self::MAX_LOG_FILES_ADVISED) {
                $warnings[] = sprintf($this->l('You activated error logging and you have %d log files.'), $log_files);
                $warnings[] = $this->l('Deactivate this option if it is not necessary or delete unnecessary the files');
            }
            $informations[] = $this->l('Logging is activated');
        }
        $lg = $this->getIngenicoLanguageCode();
        $statuses_to_check = array();
        foreach ($this->new_statuses as $status_var => $definition) {
            $statuses_to_check[$status_var] = isset($definition['names'][$lg]) ? $definition['names'][$lg] : $definition['names']['en'];
        }

        $statuses_to_check[self::PAYMENT_ACCEPTED] = $this->l('Payment accepted');
        $statuses_to_check[self::PAYMENT_ERROR] = $this->l('Payment error');
        $status_errors = false;
        foreach ($statuses_to_check as $status_var => $status_name) {
            $status_id = (int)Configuration::get($status_var);
            if (!$status_id) {
                $errors[] = sprintf($this->l('Order status "%s" cannot be find.'), $status_name);
                $status_errors = true;
                continue;
            }
            $status = new OrderState($status_id);
            if (!Validate::isLoadedObject($status)) {
                $pattern = $this->l('Order status "%s" (id %d) id cannot be loaded.');
                $errors[] = sprintf($pattern, $status_name, $status_id);
                $status_errors = true;
            }
        }

        $validation_url = $this->getValidationUrl();
        if ($this->canUseSubscription() && $this->isValidationUrlTooLong($validation_url)) {
            $short_validation_url = $this->getValidationUrl(true);
//            if ($this->isValidationUrlTooLong($short_validation_url)) {
//                $errors[] = sprintf($this->l('URLs %s and %s are both too long to be used as validation url for subscription. It cannot be longer than 50 characters. Try tu use shorter domain name.'), $validation_url, $short_validation_url);
//            } else {
//                $warnings[] = sprintf($this->l('URL %s is too long to be used as validation url for subscription. It cannot be longer than 50 characters. You can use %s instead.'), $validation_url, $short_validation_url);
//            }
        }

        if ($status_errors) {
            $errors[] = $this->l('Please try reinstall module or contact support');
        }

        if ($this->areSettingsOverridenByShop()) {
            $warnings[] = $this->l('Some module settings are different depending on shop / shop group context; please verify if you are using the good context');
        }

        if (empty($errors) && empty($warnings)) {
            $successes[] = $this->l('Module is properly configured');
        }

        return array(
            'errors' => $errors,
            'warnings' => $warnings,
            'successes' => $successes,
            'informations' => $informations
        );
    }

    protected function isValidationUrlTooLong($url)
    {
        return Tools::strlen($url) > 50;
    }

    protected function areSettingsOverridenByShop()
    {
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            return false;
        }
        if (!Shop::isFeatureActive()) {
            return false;
        }
        $query = 'SELECT * FROM ' . _DB_PREFIX_ . 'configuration WHERE name LIKE "OGONE%"';
        $sets = array();
        foreach (Db::getInstance()->executeS($query) as $row) {
            $sets[sprintf('%d-%d', $row['id_shop'], $row['id_shop_group'])][$row['name']] = $row['value'];
        }
        if (count($sets) == 1) {
            return false;
        }
        foreach ($sets as $i => $set1) {
            foreach ($sets as $j => $set2) {
                if ($i == $j) {
                    continue;
                }
                ksort($set1);
                ksort($set2);
                if ($set1 !== $set2) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function getConfigurationTabs()
    {
        $tabs = array();
        $tabs[] = array(
            'id' => 'info',
            'title' => $this->l('Presentation'),
            'content' => $this->getInfoTemplateHtml()
        );
        $tabs[] = array(
            'id' => 'prices',
            'title' => $this->l('Pricing'),
            'content' => $this->getPricingTemplateHtml()
        );
        $tabs[] = array(
            'id' => 'configuration',
            'title' => $this->l('Configuration'),
            'content' => $this->getConfigurationFormHtml()
        );
        $tabs[] = array(
            'id' => 'pm',
            'title' => $this->l('Payment methods'),
            'content' => $this->getPaymentModesFormHtml()
        );
        $tabs[] = array(
            'id' => 'templates',
            'title' => $this->l('Static template'),
            'content' => $this->getStaticTemplateHtml()
        );
        $tabs[] = array(
            'id' => 'scheduled',
            'title' => $this->l('Scheduled payments'),
            'content' => $this->getScheduledPaymentsHtml()
        );

        $tabs[] = array(
            'id' => 'subscription',
            'title' => $this->l('Subscriptions'),
            'content' => $this->getSubscriptionHtml()
        );

        $tabs[] = array(
            'id' => 'logs',
            'title' => $this->l('Debug'),
            'content' => $this->getDebugHtml()
        );
        return $tabs;
    }

    protected function getInfoTemplateHtml()
    {
        $lg_code = $this->getIngenicoLanguageCode();
        $this->context->smarty->assign('lg_code', $lg_code);
        $this->context->smarty->assign($this->getLocalizedContactData($lg_code));
        return $this->display(__FILE__, 'views/templates/admin/info.tpl');
    }

    protected function getPricingTemplateHtml()
    {
        $lg_code = $this->getIngenicoLanguageCode();
        $this->context->smarty->assign('lg_code', $lg_code);
        $this->context->smarty->assign($this->getLocalizedContactData($lg_code));
        return $this->display(__FILE__, 'views/templates/admin/prices.tpl');
    }

    protected function getFormActionUrl()
    {
        $form_url = null;
        $components = parse_url($_SERVER['REQUEST_URI']);
        if ($components) {
            parse_str($components['query'], $query);
            if ($query) {
                unset($query['action'], $query['pmid']);
                $components['query'] = http_build_query($query);
                $form_url = $components['path'] . '?' . $components['query'];
            }
        }
        return $form_url ? $form_url : $_SERVER['REQUEST_URI'];
    }

    protected function getConfigurationFormHtml()
    {
        $tpl_vars = array(
            'form_action' => $this->getFormActionUrl(),
            'module_url' => $this->getModuleUrl(),
            'server_ip' => $this->getServerIp(),
            'direct_link_doc_url' => $this->getDirectLinkDocUrl(),
            'validation_url' => $this->getValidationUrl(),
            'confirmation_url' => $this->getConfirmationUrl()
        );
        $this->context->smarty->assign($tpl_vars);
        $this->context->smarty->assign($this->getConfigurationVariables());
        return $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
    }

    protected function getScheduledPaymentsHtml()
    {
        $tpl_vars = array(
            'form_action' => $_SERVER['REQUEST_URI'],
            'module_url' => $this->getModuleUrl(),
            'max_installments' => self::MAX_SP_INSTALLMENTS,
            'min_installments' => self::MIN_SP_INSTALLMENTS,
            'max_days' => self::MAX_SP_DAYS,
            'min_days' => self::MIN_SP_DAYS,
            'max_amount' => self::MAX_SP_AMOUNT,
            'min_amount' => self::MIN_SP_AMOUNT
        );
        $this->context->smarty->assign($tpl_vars);
        $this->context->smarty->assign($this->getConfigurationVariables());
        return $this->display(__FILE__, 'views/templates/admin/scheduled.tpl');
    }

    protected function getSubscriptionHtml()
    {
        $tpl_vars = array(
            'form_action' => $_SERVER['REQUEST_URI'],
            'module_url' => $this->getModuleUrl(),
            'min_period_number' => self::MIN_SUB_PERIOD_NUMBER,
            'max_period_number' => self::MAX_SUB_PERIOD_NUMBER,
            'min_sub_installments' => self::MIN_SUB_INSTALLMENTS,
            'max_sub_installments' => self::MAX_SUB_INSTALLMENTS,

            'current_period_moments' => $this->getPeriodMoments(Configuration::get('OGONE_SUB_PERIOD_UNIT')),
            'period_moments_ww_json' => Tools::jsonEncode($this->getPeriodMoments('ww')),
            'period_moments_m_json' => Tools::jsonEncode($this->getPeriodMoments('m'))
        );

        $this->context->smarty->assign($tpl_vars);
        $this->context->smarty->assign($this->getConfigurationVariables());
        if ($this->isPS14x()) {
            return $this->display(__FILE__, 'views/templates/admin/subscription-14.tpl');
        }
        return $this->display(__FILE__, 'views/templates/admin/subscription.tpl');
    }

    public function getPeriodMoments($unit)
    {
        $result = array();
        $result[0] = $this->l('Same day');
        if ($unit == 'm') {
            foreach (range(1, 31, 1) as $day) {
                $result[$day] = $day;
            }
        } elseif ($unit == 'ww') {
            foreach ($this->getWeekdays() as $idx => $name) {
                $result[$idx] = $name;
            }
        }
        return $result;
    }


    public function getSubscriptionFrequencyFront($period_moment, $period_number, $period_unit)
    {
        $return = array(
            'frequency' => '',
            'billing' => '',
        );

        if ($period_unit == self::PERIOD_DAY && $period_number == 1) {
            $return['frequency'] = $this->l('every day');
        } else if ($period_unit == self::PERIOD_DAY && $period_number > 1) {
            $return['frequency'] = sprintf($this->l('every %s days'), $period_number);
        } if ($period_unit == self::PERIOD_WEEK && $period_number == 1) {
            $return['frequency'] = $this->l('every week');
        } else if ($period_unit == self::PERIOD_WEEK && $period_number > 1) {
            $return['frequency'] = sprintf($this->l('every %s weeks'), $period_number);
        } else if ($period_unit == self::PERIOD_MONTH && $period_number == 1) {
            $return['frequency'] = sprintf($this->l('every month'));
        } else if ($period_unit == self::PERIOD_MONTH && $period_number > 1) {
            $return['frequency'] = sprintf($this->l('every %s months'), $period_number);
        }

        if ($period_moment == 0) {
            if ($period_unit == self::PERIOD_WEEK) {
                $period_moment = (int)date('w') + 1;
            } else if ($period_unit == self::PERIOD_MONTH) {
                $period_moment = (int)date('j');
            }
        }

        $names = $this->getPeriodNames($period_unit, $period_moment);
        if ($period_unit == self::PERIOD_DAY && $period_number == 1) {
            $return['billing'] = $this->l('every day');
        } else if ($period_unit == self::PERIOD_DAY && $period_number > 1) {
            $return['billing'] = sprintf($this->l('every %s days'), $period_number);
        } else if ($period_unit == self::PERIOD_WEEK && $period_number == 1) {
            $return['billing'] = sprintf($this->l('on every %s every week'), $names['period_moment_name']);
        } else if ($period_unit == self::PERIOD_WEEK && $period_number > 1) {
            $return['billing'] = sprintf($this->l('on every %1$s every %2$s weeks'), $names['period_moment_name'], $period_number);
        } else if ($period_unit == self::PERIOD_MONTH && $period_number == 1) {
            $return['billing'] = sprintf($this->l('on every %s every month'), $names['period_moment_name']);
        } else if ($period_unit == self::PERIOD_MONTH && $period_number > 1) {
            $return['billing'] = sprintf($this->l('on every %1$s every %2$s months'), $names['period_moment_name'], $period_number);
        }



        return $return;
    }


    public function getSubscriptionFrequency($period_moment, $period_number, $period_unit)
    {
        $names = $this->getPeriodNames($period_unit, $period_moment);

        if ($period_unit == self::PERIOD_DAY) {
            $begin = '';
        } elseif ($period_moment == 0) {
            $begin = $this->l('the same day');
        } else {
            $begin = sprintf($this->l('on %s'), $names['period_moment_name']);
        }

        if ($period_unit == self::PERIOD_DAY) {
            $middle = $this->l('every');
        } elseif ($period_number == 1) {
            $middle = $this->l('of every');
        } else {
            $middle = $this->l('every');
        }

        if ($period_number > 1) {
            $end = sprintf('%d %s', $period_number, $names['period_unit_name_plural']);
        } else {
            $end = $names['period_unit_name'];
        }

        return trim(sprintf('%s %s %s', $begin, $middle, $end));
    }

    protected function getWeekdays()
    {
        return array(
            1 => $this->l('Sunday'),
            2 => $this->l('Monday'),
            3 => $this->l('Tuesday'),
            4 => $this->l('Wednesday'),
            5 => $this->l('Thursday'),
            6 => $this->l('Friday'),
            7 => $this->l('Saturday')
        );
    }

    protected function getCardinalDays()
    {
        return array(
            1 => $this->l('1st'),
            2 => $this->l('2nd'),
            3 => $this->l('3rd'),
            4 => $this->l('4th'),
            5 => $this->l('5th'),
            6 => $this->l('6th'),
            7 => $this->l('7th'),
            8 => $this->l('8th'),
            9 => $this->l('9th'),
            10 => $this->l('10th'),
            11 => $this->l('11th'),
            12 => $this->l('12th'),
            13 => $this->l('13th'),
            14 => $this->l('14th'),
            15 => $this->l('15th'),
            16 => $this->l('16th'),
            17 => $this->l('17th'),
            18 => $this->l('18th'),
            19 => $this->l('19th'),
            20 => $this->l('20th'),
            21 => $this->l('21st'),
            22 => $this->l('22nd'),
            23 => $this->l('23rd'),
            24 => $this->l('24nd'),
            25 => $this->l('25rd'),
            26 => $this->l('26th'),
            27 => $this->l('27th'),
            28 => $this->l('28th'),
            29 => $this->l('29th'),
            30 => $this->l('30th'),
            31 => $this->l('31st')

        );
    }

    protected function getStaticTemplateHtml()
    {
        $tpl_vars = array(
            'form_action' => $_SERVER['REQUEST_URI'],
            'module_url' => $this->getModuleUrl(),
            'fonts' => $this->static_template_fonts
        );
        $this->context->smarty->assign($tpl_vars);
        $this->context->smarty->assign($this->getConfigurationVariables());
        return $this->display(__FILE__, 'views/templates/admin/static.tpl');
    }

    public function getCurrentIndex()
    {
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            return $_SERVER['SCRIPT_NAME'] . (($controller = Tools::getValue('controller')) ? '?controller=' . $controller : '');
        }
        return AdminController::$currentIndex;
    }

    protected function getModuleUrl()
    {
        $token = Tools::getAdminTokenLite('AdminModules');
        return $this->getCurrentIndex() . '&configure=' . $this->name . '&token=' . $token;
    }

    protected function addPaymentMethod()
    {
        $brand = Tools::getValue('add_pm_brand');
        $pm = Tools::getValue('add_pm_pm');

        $name = array();
        $description = array();

        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $id_lang = $language['id_lang'];
            $name[$id_lang] = Tools::getValue('add_pm_name_' . $id_lang) ? Tools::getValue('add_pm_name_' . $id_lang) : Tools::getValue('add_pm_pm');
            $description[$id_lang] = Tools::getValue('add_pm_desc_' . $id_lang);
        }

        if (empty($pm) || empty($brand) || count($name) !== count(array_filter($name))) {
            return false;
        }

        $payment_method = new OgonePM();
        $payment_method->brand = $brand;
        $payment_method->pm = $pm;
        $payment_method->active = 1;
        $payment_method->name = $name;
        $payment_method->description = $description;

        if (!$payment_method->save()) {
            return false;
        }

        return $payment_method;
    }

    public function getPMUserLogoDir()
    {
        return implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__),
            'views',
            'img',
            'pm',
            ''
        ));
    }

    protected function getPaymentModesFormHtml()
    {
        clearstatcache();
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $default_names = $this->getDefaultOptionNames();
        foreach ($languages as $language) {
            if (!isset($default_names[(int)$language['id_lang']])) {
                $default_names[(int)$language['id_lang']] = '';
            }
        }

        $tpl_vars = array(
            'payment_methods' => $this->getPaymentMethodsList(),
            'default_names' => $default_names,
            'defaultLanguage' => $default_lang,
            'custom_logo_exists' => file_exists($this->getDefaultOptionLogoFilename()),
            'ogone_logo_url' => $this->getDefaultOptionLogoUrl(),
            'languages' => $languages,
            'flags' => $this->displayFlags($languages, $default_lang, 'OGONE_DEFAULT_NAME', 'OGONE_DEFAULT_NAME', true),
            'flags_pm_name' => $this->displayFlags($languages, $default_lang, 'add_pm_name', 'add_pm_name', true),
            'flags_pm_desc' => $this->displayFlags($languages, $default_lang, 'add_pm_desc', 'add_pm_desc', true)
        );

        $this->context->smarty->assign($tpl_vars);
        return $this->display(__FILE__, 'views/templates/admin/pm.tpl');
    }

    protected function getLocalizedContactData($lg_code)
    {
        if (!isset($this->localized_contact_data[$lg_code])) {
            $lg_code = 'en';
        }

        $lg_code2 = ($lg_code == 'en' ? 'int' : $lg_code);
        $data = $this->localized_contact_data[$lg_code];

        $data['create_test_account_url'] = $this->test_account_url . '?' . $data['test_account_query'];
        $data['integration_guide_url'] = $this->ingenico_server . sprintf($this->int_guide, $lg_code2, $lg_code);
        $data['support_url'] = $this->ingenico_server . sprintf($this->support_url, $lg_code2, $lg_code);
        return $data;
    }

    protected function getIngenicoLanguageCode($code = null, $default = 'en')
    {
        $code = $code ? Tools::strtolower(trim($code)) : Context::getContext()->language->iso_code;
        return in_array($code, $this->documentation_languages) ? $code : $default;
    }

    protected function getPrestashopTrackerUrl()
    {
        $pspid = Configuration::get('OGONE_PSPID');
        if ($pspid) {
            $query = array(
                'pspid' => $pspid,
                'mode' => (int)Configuration::get('OGONE_MODE')
            );
            return 'http://api.prestashop.com/modules/ogone.png?' . http_build_query($query);
        }
        return '';
    }

    protected function getConfigurationVariables()
    {
        $alias_pm = Tools::jsonDecode(Configuration::get('OGONE_ALIAS_PM'), true);
        if (!is_array($alias_pm)) {
            $alias_pm = array(
                'CreditCard' => 0,
                'DirectDebits DE' => 0,
                'DirectDebits NL' => 0,
                'DirectDebits AT' => 0
            );
            if (Configuration::get('OGONE_ALIAS_PM') && isset($alias_pm[Configuration::get('OGONE_ALIAS_PM')])) {
                $alias_pm[Configuration::get('OGONE_ALIAS_PM')] = 1;
            }
        }

        return array(
            'OGONE_PSPID' => Configuration::get('OGONE_PSPID'),
            'OGONE_SHA_IN' => Configuration::get('OGONE_SHA_IN'),
            'OGONE_SHA_OUT' => Configuration::get('OGONE_SHA_OUT'),
            'OGONE_MODE' => Configuration::get('OGONE_MODE'),
            'OGONE_OPERATION' => Configuration::get('OGONE_OPERATION'),
            'OGONE_DL_USER' => Configuration::get('OGONE_DL_USER'),
            'OGONE_DL_PASSWORD' => Configuration::get('OGONE_DL_PASSWORD'),
            'OGONE_DL_SHA_IN' => Configuration::get('OGONE_DL_SHA_IN'),
            'OGONE_USE_ALIAS' => Configuration::get('OGONE_USE_ALIAS'),
            'OGONE_USE_LOG' => Configuration::get('OGONE_USE_LOG'),
            'OGONE_USE_PM' => Configuration::get('OGONE_USE_PM'),
            'OGONE_USE_TPL' => Configuration::get('OGONE_USE_TPL'),
            'OGONE_TITLE' => Configuration::get('OGONE_TITLE'),
            'OGONE_BGCOLOR' => Configuration::get('OGONE_BGCOLOR'),
            'OGONE_TXTCOLOR' => Configuration::get('OGONE_TXTCOLOR'),
            'OGONE_TBLBGCOLOR' => Configuration::get('OGONE_TBLBGCOLOR'),
            'OGONE_TBLTXTCOLOR' => Configuration::get('OGONE_TBLTXTCOLOR'),
            'OGONE_BUTTONBGCOLOR' => Configuration::get('OGONE_BUTTONBGCOLOR'),
            'OGONE_BUTTONTXTCOLOR' => Configuration::get('OGONE_BUTTONTXTCOLOR'),
            'OGONE_FONTTYPE' => Configuration::get('OGONE_FONTTYPE'),
            'OGONE_LOGO' => Configuration::get('OGONE_LOGO'),
            'OGONE_USE_DL' => Configuration::get('OGONE_USE_DL'),
            'OGONE_ALIAS_PM' => $alias_pm,
            'OGONE_DL_TIMEOUT' => Configuration::get('OGONE_DL_TIMEOUT'),
            'OGONE_USE_KLARNA' => Configuration::get('OGONE_USE_KLARNA'),
            'OGONE_ALIAS_BY_DL' => Configuration::get('OGONE_ALIAS_BY_DL'),
            'OGONE_USE_D3D' => Configuration::get('OGONE_USE_D3D'),
            'OGONE_WIN3DS' => Configuration::get('OGONE_WIN3DS'),
            'OGONE_SKIP_AC' => Configuration::get('OGONE_SKIP_AC'),
            'OGONE_MAKE_IP' => Configuration::get('OGONE_MAKE_IP'),
            'OGONE_DISPLAY_FRAUD_SCORING' => Configuration::get('OGONE_DISPLAY_FRAUD_SCORING'),
            'OGONE_PROPOSE_ALIAS' => Configuration::get('OGONE_PROPOSE_ALIAS'),
            'OGONE_DONT_STORE_ALIAS' => Configuration::get('OGONE_DONT_STORE_ALIAS'),
            'OGONE_DISPLAY_DEFAULT_OPTION' => Configuration::get('OGONE_DISPLAY_DEFAULT_OPTION'),

            // Scheduled payments
            'OGONE_SP_OPTION' => Configuration::get('OGONE_SP_OPTION'),
            'OGONE_USE_SP' => Configuration::get('OGONE_USE_SP'),
            'OGONE_SP_MINIMUM' => Configuration::get('OGONE_SP_MINIMUM'),
            'OGONE_SP_INSTALLMENTS' => Configuration::get('OGONE_SP_INSTALLMENTS'),
            'OGONE_SP_DAYS' => Configuration::get('OGONE_SP_DAYS'),

            // subscriptions
            'OGONE_USE_SUBSCRIPTION' => Configuration::get('OGONE_USE_SUBSCRIPTION'),
            'OGONE_SUB_PERIOD_UNIT' => Configuration::get('OGONE_SUB_PERIOD_UNIT'),
            'OGONE_SUB_PERIOD_NUMBER' => Configuration::get('OGONE_SUB_PERIOD_NUMBER'),
            'OGONE_SUB_PERIOD_MOMENT' => Configuration::get('OGONE_SUB_PERIOD_MOMENT'),
            'OGONE_SUB_INSTALLMENTS' => Configuration::get('OGONE_SUB_INSTALLMENTS')

        );
    }

    protected function updatePMConfiguration()
    {
        Configuration::updateValue('OGONE_USE_KLARNA', Tools::getValue('OGONE_USE_KLARNA') ? 1 : 0);
        Configuration::updateValue('OGONE_USE_PM', Tools::getValue('OGONE_USE_PM') ? 1 : 0);
        Configuration::updateValue('OGONE_DISPLAY_DEFAULT_OPTION', Tools::getValue('OGONE_DISPLAY_DEFAULT_OPTION') ? 1 : 0);

        $languages = Language::getLanguages(false);
        $ogone_default_name = array();
        foreach ($languages as $language) {
            $var_name = 'OGONE_DEFAULT_NAME_' . $language['id_lang'];
            $ogone_default_name[$language['id_lang']] = Tools::getValue($var_name);
        }
        Configuration::updateValue('OGONE_DEFAULT_NAME', Tools::jsonEncode($ogone_default_name));
        $statuses = Tools::getValue('OGONE_PM_STATUS');
        $positions = Tools::getValue('OGONE_PM_POSITION');
        $result = true;
        foreach ($this->getPaymentMethodsList() as $pm) {
            $pm->position = $positions[$pm->id];
            $pm->active = isset($statuses[$pm->id]);
            if (!$pm->update()) {
                $result = false;
            }
        }
        return $result;
    }

    protected function updateLogConfiguration()
    {
        Configuration::updateValue('OGONE_USE_LOG', Tools::getValue('OGONE_USE_LOG') ? 1 : 0);
        return true;
    }

    protected function updateStaticConfiguration()
    {
        Configuration::updateValue('OGONE_BGCOLOR', Tools::getValue('OGONE_BGCOLOR'));
        Configuration::updateValue('OGONE_BUTTONBGCOLOR', Tools::getValue('OGONE_BUTTONBGCOLOR'));
        Configuration::updateValue('OGONE_BUTTONTXTCOLOR', Tools::getValue('OGONE_BUTTONTXTCOLOR'));
        Configuration::updateValue('OGONE_FONTTYPE', Tools::getValue('OGONE_FONTTYPE'));
        Configuration::updateValue('OGONE_LOGO', Tools::getValue('OGONE_LOGO'));
        Configuration::updateValue('OGONE_TBLBGCOLOR', Tools::getValue('OGONE_TBLBGCOLOR'));
        Configuration::updateValue('OGONE_TBLTXTCOLOR', Tools::getValue('OGONE_TBLTXTCOLOR'));
        Configuration::updateValue('OGONE_TITLE', Tools::getValue('OGONE_TITLE'));
        Configuration::updateValue('OGONE_TXTCOLOR', Tools::getValue('OGONE_TXTCOLOR'));
        Configuration::updateValue('OGONE_USE_TPL', Tools::getValue('OGONE_USE_TPL') ? 1 : 0);
        return true;
    }

    protected function updateScheduledConfiguration()
    {
        Configuration::updateValue('OGONE_SP_MINIMUM', min(max(self::MIN_SP_AMOUNT, (int)Tools::getValue('OGONE_SP_MINIMUM')), self::MAX_SP_AMOUNT));
        Configuration::updateValue('OGONE_SP_INSTALLMENTS', min(max(self::MIN_SP_INSTALLMENTS, (int)Tools::getValue('OGONE_SP_INSTALLMENTS')), self::MAX_SP_INSTALLMENTS));
        Configuration::updateValue('OGONE_SP_DAYS', min(max(self::MIN_SP_DAYS, (int)Tools::getValue('OGONE_SP_DAYS')), self::MAX_SP_DAYS));
        Configuration::updateValue('OGONE_USE_SP', Tools::getValue('OGONE_USE_SP') ? 1 : 0);
        Configuration::updateValue('OGONE_SP_OPTION', Tools::getValue('OGONE_SP_OPTION') ? 1 : 0);
        return true;
    }

    protected function updateSubscriptionConfiguration()
    {
        Configuration::updateValue('OGONE_USE_SUBSCRIPTION', Tools::getValue('OGONE_USE_SUBSCRIPTION') ? 1 : 0);
        Configuration::updateValue('OGONE_SUB_PERIOD_NUMBER', min(max(self::MIN_SUB_PERIOD_NUMBER, (int)Tools::getValue('OGONE_SUB_PERIOD_NUMBER')), self::MAX_SUB_PERIOD_NUMBER));
        Configuration::updateValue('OGONE_SUB_INSTALLMENTS', min(max(self::MIN_SUB_INSTALLMENTS, (int)Tools::getValue('OGONE_SUB_INSTALLMENTS')), self::MAX_SUB_INSTALLMENTS));

        $period_unit = in_array(Tools::getValue('OGONE_SUB_PERIOD_UNIT'), array(
            self::PERIOD_DAY,
            self::PERIOD_WEEK,
            self::PERIOD_MONTH
        )) ? Tools::getValue('OGONE_SUB_PERIOD_UNIT') : 'm';
        Configuration::updateValue('OGONE_SUB_PERIOD_UNIT', $period_unit);

        $period_moment = 0;
        switch ($period_unit) {
            case self::PERIOD_MONTH:
                $period_moment = min(max((int)Tools::getValue('OGONE_SUB_PERIOD_MOMENT'), 0), 31);
                break;
            case self::PERIOD_WEEK:
                $period_moment = min(max((int)Tools::getValue('OGONE_SUB_PERIOD_MOMENT'), 0), 7);
                break;
        }

        Configuration::updateValue('OGONE_SUB_PERIOD_MOMENT', $period_moment);
        Configuration::updateValue('OGONE_SUB_FIRST_AMOUNT', (float)Tools::getValue('OGONE_SUB_FIRST_AMOUNT'));
        Configuration::updateValue('OGONE_SUB_FIRST_PAYMENT_DELAY', (float)Tools::getValue('OGONE_SUB_FIRST_PAYMENT_DELAY'));

        return true;
    }

    protected function updateConfiguration()
    {
        $operation = in_array(Tools::getValue('OGONE_OPERATION'), $this->allowed_operations) ? Tools::getValue('OGONE_OPERATION') : self::OPERATION_SALE;

        $alias_pm = array(
            'CreditCard' => 0,
            'DirectDebits DE' => 0,
            'DirectDebits NL' => 0,
            'DirectDebits AT' => 0
        );
        if (is_array(Tools::getValue('OGONE_ALIAS_PM'))) {
            foreach (Tools::getValue('OGONE_ALIAS_PM') as $k) {
                $alias_pm[$k] = 1;
            }
        }

        Configuration::updateValue('OGONE_ALIAS_PM', Tools::jsonEncode($alias_pm));
        Configuration::updateValue('OGONE_DL_PASSWORD', Tools::getValue('OGONE_DL_PASSWORD'));
        Configuration::updateValue('OGONE_DL_SHA_IN', Tools::getValue('OGONE_DL_SHA_IN'));
        Configuration::updateValue('OGONE_DL_TIMEOUT', (int)Tools::getValue('OGONE_DL_TIMEOUT'));
        Configuration::updateValue('OGONE_DL_USER', Tools::getValue('OGONE_DL_USER'));
        Configuration::updateValue('OGONE_MODE', (int)Tools::getValue('OGONE_MODE'));
        Configuration::updateValue('OGONE_OPERATION', $operation);
        Configuration::updateValue('OGONE_PSPID', Tools::getValue('OGONE_PSPID'));
        Configuration::updateValue('OGONE_SHA_IN', Tools::getValue('OGONE_SHA_IN'));
        Configuration::updateValue('OGONE_SHA_OUT', Tools::getValue('OGONE_SHA_OUT'));
        Configuration::updateValue('OGONE_USE_ALIAS', Tools::getValue('OGONE_USE_ALIAS') ? 1 : 0);
        Configuration::updateValue('OGONE_ALIAS_BY_DL', Tools::getValue('OGONE_ALIAS_BY_DL') ? 1 : 0);
        Configuration::updateValue('OGONE_USE_DL', Tools::getValue('OGONE_USE_DL') ? 1 : 0);
        Configuration::updateValue('OGONE_USE_D3D', Tools::getValue('OGONE_USE_D3D') ? 1 : 0);
        Configuration::updateValue('OGONE_WIN3DS', Tools::getValue('OGONE_WIN3DS'));

        Configuration::updateValue('OGONE_SKIP_AC', Tools::getValue('OGONE_SKIP_AC') ? 1 : 0);
        Configuration::updateValue('OGONE_MAKE_IP', Tools::getValue('OGONE_MAKE_IP') ? 1 : 0);
        Configuration::updateValue('OGONE_DISPLAY_FRAUD_SCORING', Tools::getValue('OGONE_DISPLAY_FRAUD_SCORING') ? 1 : 0);
        Configuration::updateValue('OGONE_PROPOSE_ALIAS', Tools::getValue('OGONE_PROPOSE_ALIAS') ? 1 : 0);
        Configuration::updateValue('OGONE_DONT_STORE_ALIAS', Tools::getValue('OGONE_DONT_STORE_ALIAS') ? 1 : 0);

        return true;
    }

    public function getIgnoreKeyList()
    {
        return $this->ignore_key_list;
    }

    public function getNeededKeyList()
    {
        return $this->needed_key_list;
    }

    protected function assignPaymentVars($params)
    {
        $this->context->smarty->assign($this->getPaymentVars($params));
        return true;
    }

    /**
     * Assigns all vars to smarty
     *
     * @param unknown_type $params
     */
    protected function getPaymentVars($params)
    {
        $tpl_vars = array();

        $currency = new Currency((int)$params['cart']->id_currency);
        $lang = new Language((int)$params['cart']->id_lang);
        $customer = new Customer((int)$params['cart']->id_customer);
        $address = new Address((int)$params['cart']->id_address_invoice);
        $country = new Country((int)$address->id_country, (int)$params['cart']->id_lang);

        $ogone_params = array();
        $ogone_params['PSPID'] = Configuration::get('OGONE_PSPID');
        $ogone_params['OPERATION'] = (Configuration::get('OGONE_OPERATION') === self::OPERATION_AUTHORISE ? self::OPERATION_AUTHORISE : self::OPERATION_SALE);

        $ogone_params['ACCEPTURL'] = $this->getConfirmationUrl();
        $ogone_params['DECLINEURL'] = $this->getDeclineUrl();
        $ogone_params['EXCEPTIONURL'] = $this->getExceptionUrl();
        $ogone_params['CANCELURL'] = $this->getCancelUrl();
        $ogone_params['BACKURL'] = $this->getBackUrl();

        $total = $params['cart']->getOrderTotal(true, Cart::BOTH);
        $amount = $this->convertPrice($total);

        $ogone_params['ORDERID'] = $this->generateOrderId($params['cart']->id);
        $ogone_params['AMOUNT'] = $amount;

        if (isset($params['scheduled_payment'])) {
            $scheduled = $this->getScheduledPaymentVars($total);
            $ogone_params = array_merge($ogone_params, $scheduled);
            $scheduled['EXECUTIONDATE1'] = date('d/m/Y');
            $tpl_vars['scheduled_payment_data'] = array();
            for ($i = 1; $i <= count($scheduled) / 2; $i ++) {
                $tpl_vars['scheduled_payment_data'][] = array(
                    'amount' => number_format(round($scheduled[sprintf('AMOUNT%d', $i)] / 100, 2), 2),
                    'date' => $scheduled[sprintf('EXECUTIONDATE%d', $i)],
                    'currency_sign' => $currency->sign
                );
            }
        } else {
            $tpl_vars['scheduled_payment_data'] = null;
        }
        if (isset($params['subscription_payment'])) {
            $subscription = $this->getSubscriptionPaymentVars($params);
            $ogone_params = array_merge($ogone_params, $subscription);
            if (isset($subscription['AMOUNT'])) {
                $ogone_params['AMOUNT'] = $subscription['AMOUNT'];
            }
            $ogone_params['SUB_ORDERID'] = $ogone_params['ORDERID'];
        }

        $ogone_params['CURRENCY'] = $currency->iso_code;
        $ogone_params['LANGUAGE'] = $lang->iso_code . '_' . Tools::strtoupper($lang->iso_code);
        $ogone_params['CN'] = $customer->lastname;
        $ogone_params['EMAIL'] = $customer->email;
        $ogone_params['OWNERZIP'] = Tools::substr($address->postcode, 0, 10);
        $ogone_params['OWNERADDRESS'] = Tools::substr(trim($address->address1), 0, 35);
        $ogone_params['OWNERCTY'] = $country->iso_code;
        $ogone_params['OWNERTOWN'] = Tools::substr($address->city, 0, 40);
        $ogone_params['PARAMPLUS'] = 'secure_key=' . $params['cart']->secure_key;

        if (!empty($address->phone)) {
            $ogone_params['OWNERTELNO'] = $address->phone;
        }

        if (Configuration::get('OGONE_USE_PM') && isset($params['pm']) && $params['pm'] instanceof OgonePM) {
            $ogone_params['BRAND'] = $params['pm']->brand;
            $ogone_params['PM'] = $params['pm']->pm;
            $tpl_vars['pm_obj'] = $params['pm'];
        }

        if (Configuration::get('OGONE_USE_TPL')) {
            foreach ($this->tpl_fields as $field) {
                $var_name = 'OGONE_' . $field;
                $value = Configuration::get($var_name);
                if ($value) {
                    $ogone_params[$field] = $value;
                }
            }
            $value = Configuration::get('OGONE_LOGO');
            if ($value) {
                $ogone_params['LOGO'] = $value;
            }
        }
        $tpl_vars['alias_data'] = null;
        if (Configuration::get('OGONE_USE_ALIAS') && isset($params['alias'])) {
            $tpl_vars['local_alias_link'] = $this->getLocalAliasPaymentLink();
            $ogone_params['ALIAS'] = $this->decryptAlias($params['alias']['alias']);
            $ogone_params['ALIASUSAGE'] = $this->l('You can use payment method stored on secure server');
            $ogone_params['BRAND'] = $params['alias']['brand'];
            $ogone_params['PM'] = 'CreditCard';

            $ogone_params['ECI'] = isset($params['eci']) ? $params['eci'] : '';
            $params['alias']['logo'] = $this->getAliasLogoUrl($params['alias'], 'cc_medium.png');

            $tpl_vars['alias_data'] = $params['alias'];
            if (!$this->isDirectDebitBrand($params['alias']['brand'])) {
                $tpl_vars['expiry_date'] = date('m/Y', strtotime($params['alias']['expiry_date']));
            } else {
                $tpl_vars['expiry_date'] = '';
            }
        } else {
            if (Configuration::get('OGONE_PROPOSE_ALIAS') && $this->canUseAliases()) {
                $ogone_params['ALIAS'] = $this->getDirectLinkInstance()->generateAlias($customer->id);
                $ogone_params['ALIASUSAGE'] = $this->l('You can use payment method stored on secure server');
            }

            $default_option_names = $this->getDefaultOptionNames();
            $default_option_name = isset($default_option_names[$lang->id]) ? $default_option_names[$lang->id] : null;
            $tpl_vars['default_option_name'] = $default_option_name;
        }

        $tpl_vars['ogone_logo_url'] = $this->getDefaultOptionLogoUrl();
        $tpl_vars['default_option_logo'] = $this->getDefaultOptionLogoUrl();

        $mode = (Configuration::get('OGONE_MODE') ? 'prod' : 'test');
        $tpl_vars['OGONE_MODE'] = Configuration::get('OGONE_MODE');

        if ($this->isKlarna($ogone_params) && !isset($params['alias'])) {
            if ($params['force_klarna_display'] || $this->canUseKlarna($country)) {
                $klarna_params = $this->getKlarnaVars($params['cart'], $params['force_klarna_display']);
                if (!$klarna_params) {
                    return false;
                }

                foreach ($klarna_params as $key => $value) {
                    $ogone_params[$key] = $value;
                }
                /* to avoid problem with sha signature on utf-8 like string (Klarna wants ISO) */
                foreach ($ogone_params as $key => $value) {
                    $ogone_params[$key] = $this->convertToASCII($value);
                }
                /* ISO */
                $tpl_vars['ogone_url'] = 'https://secure.ogone.com/ncol/' . $mode . '/orderstandard.asp';
                $tpl_vars['form_encoding'] = 'ISO-8859-1';
            } else {
                return false;
            }
        } else {
            $tpl_vars['ogone_url'] = 'https://secure.ogone.com/ncol/' . $mode . '/orderstandard_utf8.asp';
            $tpl_vars['form_encoding'] = 'UTF-8';
        }

        // Add customer data
        $ogone_params['ADDRMATCH'] = '0';
        $ogone_params['ECOM_BILLTO_POSTAL_CITY'] = $address->city;
        $ogone_params['ECOM_BILLTO_POSTAL_COUNTRYCODE'] = Country::getIsoById($address->id_country);
        $ogone_params['ECOM_BILLTO_POSTAL_STREET_LINE1'] = $address->address1;
        $ogone_params['ECOM_BILLTO_POSTAL_STREET_LINE2'] = $address->address2;
        $ogone_params['ECOM_BILLTO_POSTAL_POSTALCODE'] = $address->postcode;
        $ogone_params['REMOTE_ADDR'] = Tools::getRemoteAddr();
        $ogone_params['EMAIL'] = $customer->email;
        $ogone_params['CUID'] = $customer->email;

        // Add delivery data
        if ($params['cart']->id_address_delivery > 0) {
            $delivery = new Address($params['cart']->id_address_delivery);
            $ogone_params['ECOM_SHIPTO_POSTAL_CITY'] = $delivery->city;
            $ogone_params['ECOM_SHIPTO_POSTAL_COUNTRYCODE'] = Country::getIsoById($delivery->id_country);
            $ogone_params['ECOM_SHIPTO_POSTAL_STREET_LINE1'] = $delivery->address1;
            $ogone_params['ECOM_SHIPTO_POSTAL_STREET_LINE2'] = $delivery->address2;
            $ogone_params['ECOM_SHIPTO_POSTAL_POSTALCODE'] = $delivery->postcode;
        }

        $ogone_params['BROWSERACCEPTHEADER'] = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
        $ogone_params['BROWSERUSERAGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;

        // Add Browser values
        $browserValues = [
            'browserColorDepth',
            'browserJavaEnabled',
            'browserLanguage',
            'browserScreenHeight',
            'browserScreenWidth',
            'browserTimeZone'
        ];
        foreach ($browserValues as $key) {
            if (isset($_COOKIE[$key])) {
                $ogone_params[strtoupper($key)] = $_COOKIE[$key];
            }
        }

        $ogone_params['ORIG'] = Tools::substr('ORPR' . str_replace('.', '', $this->version), 0, 10);
        $ogone_params['SHASign'] = $this->calculateShaSign($ogone_params, Configuration::get('OGONE_SHA_IN'));
        $this->log('ogone_params: ' . var_export($ogone_params, true));

        $tpl_vars['ogone_params'] = $ogone_params;
        $tpl_vars['immediate_payment'] = isset($params['immediate_payment']) ? $params['immediate_payment'] : false;
        $tpl_vars['module_dir'] =_MODULE_DIR_ . $this->name  . '/' ;
        $tpl_vars['3ds_active'] = isset($params['3ds_active']) ? $params['3ds_active'] : false;



        return $tpl_vars;
    }

    public function getSubscriptionPaymentVars($params)
    {
        $result = array();
        $cart = $params['cart'];
        // one subscription only, normally we cannot have more than that
        // it can change in the future
        /**
         *
         * @var OgoneProductSubscription
         *
         */
        $subscription = end($params['subscriptions']);

        $subscription_id = sprintf('c%su%sd%s', $params['cart']->id, $params['cart']->id_customer, date('YmdHis'));

        $result['SUBSCRIPTION_ID'] = $subscription_id;
        $result['SUB_AMOUNT'] = $this->convertPrice($this->getSubscriptionTotal($params['cart']));
        $result['SUB_COM'] = 'Product ' . $subscription->id_product . ' ' . $subscription->id_product_attribute;
        $result['SUB_ORDERID'] = $params['cart']->id;
        $result['SUB_PERIOD_UNIT'] = $subscription->period_unit;
        $result['SUB_PERIOD_NUMBER'] = $subscription->period_number;

        if ($this->getSubscriptionTotal($cart) != $cart->getOrderTotal()) {
            if ($subscription->first_amount > 0) {
                $result['AMOUNT'] = $this->convertPrice($cart->getOrderTotal() - $this->getSubscriptionTotal($cart) + $subscription->first_amount + $cart->getOrderTotal(true, Cart::ONLY_SHIPPING, null, null, false));
            } else {
                $result['AMOUNT'] = $this->convertPrice($cart->getOrderTotal());
            }
        } elseif ($subscription->first_amount > 0) {
            $result['AMOUNT'] = $this->convertPrice($subscription->first_amount + $cart->getOrderTotal(true, Cart::ONLY_SHIPPING, null, null, false));
        }

        $period_moment = $subscription->getPeriodMoment();

        if ($period_moment > 0) {
            $result['SUB_PERIOD_MOMENT'] = $period_moment;
        }

        $result['SUB_STARTDATE'] = $subscription->getStartDate('d/m/Y');
        $result['SUB_ENDDATE'] = $subscription->getEndDate('d/m/Y');
        $result['SUB_STATUS'] = 1;
        $result['SUB_COMMENT'] = 'Cart ' . $cart->id;
        $result['CN'] = $this->context->customer->lastname;

        return $result;
    }

    public function getSubscriptionTotal($cart)
    {
        $products = $cart->getProducts();

        foreach ($products as $key => $product) {
            $subscription = OgoneProductSubscription::getSubscriptionInstanceForProduct($product['id_product'], $product['id_product_attribute']);
            if (!$subscription) {
                unset($products[$key]);
            }
        }

        $total = $cart->getOrderTotal(true, Cart::ONLY_PRODUCTS, $products, null, false) + $cart->getOrderTotal(true, Cart::ONLY_SHIPPING, null, null, false);

        return $total;
    }

    public function isKlarna($ogone_params)
    {
        if (Configuration::get('OGONE_USE_KLARNA')) {
            return true;
        }

        if (!is_array($ogone_params) || !isset($ogone_params['BRAND'])) {
            return false;
        }
        $elements = explode(' ', $ogone_params['BRAND']);
        return (count($elements) == 2 && $elements[0] == 'Installment' && in_array($elements[1], $this->klarna_countries)) || (count($elements) == 3 && $elements[0] == 'Open' && $elements[1] == 'Invoice' && in_array($elements[2], $this->klarna_countries));
    }

    /**
     *
     * @see https://payment-services.ingenico.com/int/en/ogone/support/guides/integration%20guides/klarna
     * @param unknown $order
     * @return boolean
     */
    public function canUseKlarna($country)
    {
        return in_array(Tools::strtoupper($country->iso_code), $this->klarna_countries);
    }

    /**
     *
     * @see https://payment-services.ingenico.com/int/en/ogone/support/guides/integration%20guides/klarna
     * @param unknown $ogone_params
     * @param unknown $order
     */
    public function getKlarnaVars($cart, $no_fail_on_empty_fields = false)
    {
        $customer = new Customer((int)$cart->id_customer);
        $address = new Address((int)$cart->id_address_invoice);
        $country = new Country((int)$address->id_country, $cart->id_lang);
        $carrier = new Carrier((int)$cart->id_carrier);
        $gender = new Gender((int)$customer->id_gender);

        $klarna_params = array();
        $klarna_params['OPERATION'] = 'RES';

        /* required in all countries */

        $klarna_params['ECOM_BILLTO_POSTAL_NAME_FIRST'] = Tools::substr($address->firstname, 0, 50);
        $klarna_params['ECOM_BILLTO_POSTAL_NAME_LAST'] = Tools::substr($address->lastname, 0, 50);
        $owneraddress = Tools::substr(implode(' ', array_filter(array(
            $address->address1,
            $address->address2
        ))), 0, 35);
        $klarna_params['OWNERADDRESS'] = $owneraddress;
        $klarna_params['OWNERZIP'] = Tools::substr($address->postcode, 0, 10);
        $klarna_params['EMAIL'] = Tools::substr($customer->email, 0, 50);
        $klarna_params['OWNERTOWN'] = Tools::substr($address->city, 0, 25);
        $ownertelno = Tools::substr($address->phone_mobile ? $address->phone_mobile : $address->phone, 0, 20);
        $klarna_params['OWNERTELNO'] = $ownertelno;
        $klarna_params['OWNERCTY'] = $country->iso_code;
        $klarna_params['ORDERSHIPMETH'] = Tools::substr($carrier->name, 0, 20);
        // if (in_array(Tools::strtoupper($country->iso_code), array('SE', 'FI', 'DK', 'NO'))) {
        if ($customer->siret ? $customer->siret : ($customer->ape ? $customer->ape : null)) {
            $nr = Tools::substr($customer->siret ? $customer->siret : ($customer->ape ? $customer->ape : null), 0, 50);
            $klarna_params['CUID'] = $nr;
        } elseif (in_array(Tools::strtoupper($country->iso_code), array(
            'SE',
            'FI',
            'DK',
            'NO'
        )) && !$no_fail_on_empty_fields) {
            return false;
        }

        /* required in DE and NL */
        // if (in_array(Tools::strtoupper($country->iso_code), array('DE', 'NL'))) {
        $klarna_params['ECOM_CONSUMER_GENDER'] = ($gender->type == 1 ? 'F' : 'M');
        if ($customer->birthday && $customer->birthday != '0000-00-00') {
            $birthday = implode('/', array_reverse(explode('-', $customer->birthday)));
        } else {
            $birthday = date('Y/m/d', 1);
        }

        $klarna_params['ECOM_SHIPTO_DOB'] = $birthday;

        $klarna_params['ECOM_BILLTO_POSTAL_STREET_NUMBER'] = $this->getStreetNumber($address);
        if ($klarna_params['ECOM_BILLTO_POSTAL_STREET_NUMBER']) {
            $pattern = '/\s*' . preg_quote($klarna_params['ECOM_BILLTO_POSTAL_STREET_NUMBER'], '/') . '\s*/';
            $klarna_params['OWNERADDRESS'] = preg_replace($pattern, '', $owneraddress);
        }
        // }

        /* if some parameters are empty, this payment cannot be used */
        if (!$no_fail_on_empty_fields && count($klarna_params) !== count(array_filter($klarna_params))) {
            return null;
        }

        /*
         * ORDERSHIPCOST and ORDERSHIPTAXCODE are not required and it's suggested to use items
         */
        $products = $cart->getProducts();
        $total_shipping = $cart->getOrderTotal(true, Cart::ONLY_SHIPPING);
        if ($total_shipping > 0) {
            $products[] = array(
                'reference' => $this->l('Shipping'),
                'name' => $carrier->name,
                'price_with_reduction' => $total_shipping,
                'quantity' => 1,
                'rate' => isset($cart->carrier_tax_rate) ? $cart->carrier_tax_rate : 0
            );
        }
        $idx = 1;
        foreach ($products as $product) {
            $product_row = array(
                'ITEMID' => Tools::substr($product['reference'], 0, 40),
                'ITEMNAME' => Tools::substr($product['name'], 0, 40),
                'ITEMPRICE' => round($product['quantity'] * (isset($product['price_with_reduction']) ? $product['price_with_reduction'] : $product['price_wt']), 2) / $product['quantity'],
                'ITEMQUANT' => $product['quantity'],
                'ITEMVATCODE' => $product['rate'] . '%',
                'TAXINCLUDED' => '1'
            );

            foreach ($product_row as $key => $value) {
                $klarna_params[$key . $idx] = $value;
            }
            $idx ++;
        }
        return $klarna_params;
    }

    protected function getStreetNumber($address)
    {
        $matches = array();
        $possible_matches = array();
        preg_match('/^(\d+)\s+.*$|^.*\s+(\d+)$/', $address->address1, $matches);
        $possible_matches[] = isset($matches[1]) ? $matches[1] : null;
        preg_match('/^(\d+)\s+.*$|^.*\s+(\d+)$/', $address->address2, $matches);
        $possible_matches[] = isset($matches[1]) ? $matches[1] : null;
        preg_match('/^.*(\d+).*$/', $address->address1, $matches);
        $possible_matches[] = isset($matches[1]) ? $matches[1] : null;
        preg_match('/^.*(\d+).*$/', $address->address2, $matches);
        $possible_matches[] = isset($matches[1]) ? $matches[1] : null;
        $possible_matches[] = 1;
        $possible_matches = array_values(array_filter($possible_matches));
        if ($possible_matches && !empty($possible_matches)) {
            return $possible_matches[0];
        }
        return null;
    }

    public function useScheduledPaymentAsOption()
    {
        return (bool)Configuration::get('OGONE_SP_OPTION');
    }

    public function canUseScheduledPayment($total)
    {
        return (Configuration::get('OGONE_USE_SP') && $total >= Configuration::get('OGONE_SP_MINIMUM'));
    }

    public function getScheduledPaymentVars($total)
    {
        $result = array();
        $amount = $this->convertPrice($total);
        $installments = (int)Configuration::get('OGONE_SP_INSTALLMENTS');
        $days = (int)Configuration::get('OGONE_SP_DAYS');
        $installment_date = new DateTime();
        $interval = new DateInterval(sprintf('P%dD', $days));
        if ($installments >= self::MIN_SP_INSTALLMENTS && $installments <= self::MAX_SP_INSTALLMENTS && $days >= self::MIN_SP_DAYS && $days <= self::MAX_SP_DAYS) {
            $installment_amount = (int)($amount / $installments);
            for ($installment = 1; $installment <= $installments; $installment ++) {
                if ($installment > 1) {
                    $result[sprintf('EXECUTIONDATE%d', $installment)] = $installment_date->format('d/m/Y');
                }
                $result[sprintf('AMOUNT%d', $installment)] = $installment < $installments ? $installment_amount : $amount - (($installments - 1) * $installment_amount);
                $installment_date->add($interval);
            }
        }
        return $result;
    }

    public function validate($id_cart, $id_order_state, $amount, $message = '', $secure_key = '')
    {
        $this->currentOrder = null;
        $this->log($this->currentOrder);
        $this->log('validate order ' . $this->currentOrder);

        $this->validateOrder((int)$id_cart, $id_order_state, $amount, $this->displayName, $message, null, null, true, $secure_key ? pSQL($secure_key) : false);
        $this->log('validated order ' . $this->currentOrder);
        return $this->currentOrder;
    }

    /**
     * Gets translated description of Ogone payment status, based on code.
     * Defaults to "Unknown code: xxx"
     *
     * @param int $code
     * @return string Translated Ogone payment status description
     */
    public function getCodeDescription($code)
    {
        $code = (int)$code;
        return isset($this->return_codes[$code]) ? $this->l($this->return_codes[$code][0]) : sprintf('%s %s', $this->l('Unknown code'), $code);
    }

    /**
     * Gets name of Ogone payment status, based on code.
     * Defaults to self::PAYMENT_ERROR
     *
     * @param int $code
     *            See Ogone::$return_codes
     * @return string Ogone payment status
     */
    public function getCodePaymentStatus($code)
    {
        return isset($this->return_codes[(int)$code]) ? $this->return_codes[(int)$code][1] : self::PAYMENT_ERROR;
    }

    /**
     * Gets id of Prestashop order status corresponding to Ogone status.
     * Defaults to PS_OS_ERROR
     *
     * @param string $ogone_status
     *            name of Ogone return state
     * @return int
     */
    public function getPaymentStatusId($ogone_status)
    {
        $status_id = (int)Configuration::get((string)$ogone_status);
        return ($status_id ? $status_id : (int)Configuration::get('PS_OS_ERROR'));
    }

    /**
     * Adds message to order
     *
     * @param int $id_order
     * @param string $message
     * @return boolean
     */
    public function addMessage($id_order, $message)
    {
        $this->log('Adding message for ' . $id_order . ' ' . Tools::substr($message, 0, 16));
        if (!is_int($id_order) || $id_order <= 0) {
            return false;
        }

        if (!Validate::isCleanHtml($message)) {
            return false;
        }

        $order = new Order($id_order);
        $customer = new Customer($order->id_customer);
        if ($this->isPS17x()) {
            $ct_id = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($customer->email, $order->id);
            if ($ct_id) {
                $ct = new CustomerThread($ct_id);
            } else {
                $ct = new CustomerThread();
                $ct->id_customer = (int)$order->id_customer;
                $ct->id_shop = (int)$order->id_shop;
                $ct->id_order = (int)$order->id;
                $ct->id_lang = (int)$this->context->language->id;
                $ct->id_contact = 0;
                $ct->email = $customer->email;
                $ct->status = 'open';
                $ct->token = Tools::passwdGen(12);
                $ct->add();
            }
            $result = false;
            if ($ct && $ct->id) {
                $cm = new CustomerMessage();
                $cm->id_customer_thread = $ct->id;
                $cm->message = $message;
                $cm->private = true;
                $cm->ip_address = (int)ip2long(Tools::getRemoteAddr());
                $cm->user_agent = $_SERVER['HTTP_USER_AGENT'];
                $result = $cm->add();
            }
        } else {
            $message_obj = new Message();
            $message_obj->id_order = $id_order;
            $message_obj->id_cart = $order->id_cart;
            $message_obj->id_customer = $order->id_customer;
            $message_obj->message = $message . date(' (H:i:s)');
            $message_obj->private = true;
            $result = $message_obj->add();
        }
        if (!$result) {
            $this->log('Message not added added :' . $message);
        }
        return $result;
    }

    public function calculateShaSign($ogone_params, $sha_key)
    {
        $result = DirectLink::getShaSign($ogone_params, $sha_key);
        $this->log(sprintf('SHA SIGN: %s => %s', Tools::jsonEncode($ogone_params), $result));
        return $result;
    }

    protected function getPaymentMethodsList()
    {
        $pm_tpl_list = array();
        foreach (OgonePM::getAllIds() as $id) {
            $pm = new OgonePM($id, $this->context->language->id, $this->context->shop->id);
            $pm_tpl_list[] = $pm;
            $logo_path = '/views/img/pm/' . $id . '.png';
            $pm->logo_url = file_exists(dirname(__FILE__) . $logo_path) ? _MODULE_DIR_ . $this->name . $logo_path : _MODULE_DIR_ . $this->name . '/views/img/cc_medium.png';
        }
        usort($pm_tpl_list, array(
            $this,
            'sortByPosition'
        ));
        return $pm_tpl_list;
    }

    protected function sortByPosition($a, $b)
    {
        return $a->position - $b->position;
    }

    protected function getValidationUrl($short = false)
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.6', '>=')) {
            $baseLink = $this->context->link->getBaseLink();
            if (Configuration::get('PS_REWRITING_SETTINGS')) {
                return $baseLink.'module/ogone/notify';
            } else {
                $url = $this->context->link->getModuleLink('ogone', 'notify', array(), true, false);
                $urlParts = parse_url($url);
                $queryParams = array();
                parse_str($urlParts['query'], $queryParams);
                unset($queryParams['id_lang']);
                $queryString = http_build_query($queryParams);

                return $baseLink.'index.php?'.$queryString;
            }
        }

        if (!$short) {
            return Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'] . _MODULE_DIR_ . 'ogone/' . 'validation.php';
        }

        $url = Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'] . '/v.php';

        if (file_exists(dirname(__FILE__) . '/../../v.php') && trim(Tools::file_get_contents($url .'?ogone_check_url=1') == 'uok')) {
            return $url;
        } else {
            return Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'] . _MODULE_DIR_ . 'ogone/' . 'v.php';
        }

        return Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'] . _MODULE_DIR_ . 'ogone/' . ($short ? 'v.php' : 'validation.php');
    }

    protected function getConfirmationUrl()
    {
        return (version_compare(_PS_VERSION_, '1.5', 'ge')) ? $this->context->link->getModuleLink('ogone', 'confirmation', array(), Configuration::get('PS_SSL_ENABLED')) : Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'] . _MODULE_DIR_ . 'ogone/confirmation.php';
    }

    protected function getDeclineUrl()
    {
        return $this->getConfirmationUrl();
    }

    protected function getExceptionUrl()
    {
        return $this->getConfirmationUrl();
    }

    protected function getCancelUrl()
    {
        $params = array(
            'step' => 3
        );
        return (version_compare(_PS_VERSION_, '1.5', 'ge')) ? $this->context->link->getPageLink('order', true, (int)$this->context->language->id, $params) : Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'];
    }

    protected function getBackUrl()
    {
        $params = array(
            'step' => 3
        );
        return (version_compare(_PS_VERSION_, '1.5', 'ge')) ? $this->context->link->getPageLink('order', true, (int)$this->context->language->id, $params) : Tools::getProtocol(Configuration::get('PS_SSL_ENABLED')) . $_SERVER['HTTP_HOST'];
    }

    /**
     * Returns directlink doc's url, in function of the current language
     *
     * @return string URL
     */
    protected function getDirectLinkDocUrl()
    {
        $lg_code = $this->getIngenicoLanguageCode();
        $lg_code2 = ($lg_code == 'en' ? 'int' : $lg_code);
        $direct_link_doc_url = $this->ingenico_server . $this->dl_guide;
        return sprintf($direct_link_doc_url, $lg_code2, $lg_code);
    }

    /**
     * Tries to find server's IP
     *
     * @return string|null Ip address, prioritizing IPV4, or null if not found
     */
    protected function getServerIp()
    {
        if (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) {
            foreach (array(
                DNS_A,
                DNS_AAAA
            ) as $flag) {
                $record = dns_get_record($_SERVER['HTTP_HOST'], $flag);
                if ($record && isset($record[0]) && isset($record[0]['ip']) && $record[0]['ip']) {
                    return $record[0]['ip'];
                }
            }
        }
        return null;
    }

    protected function getDefaultPaymentModes()
    {
        $pm_file = implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__),
            'data',
            'payments.json'
        ));
        $pm_data = (array)Tools::jsonDecode(Tools::file_get_contents($pm_file), true);
        return is_array($pm_data) ? array_values($pm_data) : array();
    }

    /**
     * Logs data to file if OGONE_USE_LOG config var is set
     *
     * @param mixed $message
     * @param array $context
     */
    public function log($message, $context = array())
    {
        if (!is_array($context)) {
            $context = array($context);
        }

        $message = is_string($message) ? $message : var_export($message, true);
        $file = isset($_SERVER) && isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : __FILE__;
        $source = isset($_SERVER) && isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : PHP_SAPI;

        $backtrace = debug_backtrace();
        $from = '???:???';
        if ($backtrace && isset($backtrace[0])) {
            $line = isset($backtrace[0]['line']) ? $backtrace[0]['line'] : '???';
            $file = isset($backtrace[0]['file']) ? pathinfo($backtrace[0]['file'], PATHINFO_BASENAME) : '???';
            $class = isset($backtrace[1]['class']) ? $backtrace[1]['class'] : '???';
            $method = isset($backtrace[1]['function']) ? $backtrace[1]['function'] : '???';
            $from = sprintf('%s::%s (%s:%d)', $class, $method, $file, $line);
        }

        $context = array_merge($context, array(
            'file' => $file,
            'source' => $source,
            'from' => $from
        ));

        $this->logger->debug($message, $context);
    }

    protected function getLogFileDir()
    {
        return implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__),
            'logs',
            ''
        ));
    }

    protected function getLogFileName()
    {
        return date('Ymd_') . sha1('ogone' . date('Ymd') . Configuration::get('OGONE_PSPID')) . '.ogone.log';
    }

    protected function getLogFiles()
    {
        $pattern = $this->getLogFileDir() . '*.ogone.log';
        return glob($pattern);
    }

    protected function getLogFilesWithUrls()
    {
        $result = array();
        foreach ($this->getLogFiles() as $log_file) {
            $log_name = basename($log_file);
            $file_key = sha1(realpath($log_file) . Configuration::get('OGONE_PSPID'));
            $result[$log_name] = _MODULE_DIR_ . 'ogone/logs.php?filename=' . $log_name . '&key=' . $file_key;
        }
        return $result;
    }

    protected function getLogFilesData()
    {
        $result = array();
        foreach ($this->getLogFiles() as $log_file) {
            $log_name = basename($log_file);
            $file_key = sha1(realpath($log_file) . Configuration::get('OGONE_PSPID'));
            $time = filemtime($log_file);
            $result[$time ? $time : $log_name] = array(
                'name' => $log_name,
                'url' => _MODULE_DIR_ . 'ogone/logs.php?filename=' . $log_name . '&key=' . $file_key,
                'dt' => date('Y-m-d H:i:s', $time),
                'size' => filesize($log_file)
            );
        }

        krsort($result);
        return $result;
    }

    protected function clearLogFiles()
    {
        $deleted_files = 0;
        foreach ($this->getLogFiles() as $log_file) {
            if (unlink($log_file)) {
                $deleted_files ++;
            }
        }
        return $deleted_files;
    }

    protected function getUpgradeLogFiles()
    {
        $pattern = $this->getUpgradeLogFileDir() . '*.log';
        return glob($pattern);
    }

    protected function getUpgradeLogFileDir()
    {
        return implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__),
            'upgrade',
            ''
        ));
    }

    protected function getUpgradeLogFilesWithUrls()
    {
        $result = array();
        foreach ($this->getUpgradeLogFiles() as $log_file) {
            $log_name = basename($log_file);
            $file_key = sha1(realpath($log_file) . Configuration::get('OGONE_PSPID'));
            $result[$log_name] = _MODULE_DIR_ . 'ogone/logs.php?filename=' . $log_name . '&key=' . $file_key . '&type=upgrade';
        }
        return $result;
    }

    protected function clearUpgradeLogFiles()
    {
        $deleted_files = 0;
        foreach ($this->getUpgradeLogFiles() as $log_file) {
            if (unlink($log_file)) {
                $deleted_files ++;
            }
        }
        return $deleted_files;
    }

    protected function getUpgradeLogFilesData()
    {
        $result = array();
        foreach ($this->getUpgradeLogFiles() as $log_file) {
            $log_name = basename($log_file);
            $file_key = sha1(realpath($log_file) . Configuration::get('OGONE_PSPID'));
            $time = filemtime($log_file);
            $result[$log_name] = array(
                'name' => $log_name,
                'url' => _MODULE_DIR_ . 'ogone/logs.php?filename=' . $log_name . '&key=' . $file_key . '&type=upgrade',
                'dt' => date('Y-m-d H:i:s', $time),
                'size' => filesize($log_file)
            );
        }

        krsort($result);
        return $result;
    }

    protected function getDebugHtml()
    {
        $this->context->smarty->assign('log_files', $this->getLogFilesData());
        $this->context->smarty->assign('upgrade_log_files', $this->getUpgradeLogFilesData());

        return $this->display(__FILE__, 'views/templates/admin/logs.tpl');
    }

    protected function uploadPaymentLogo($name, $target, $width = 194, $height = 80)
    {
        if (isset($_FILES[$name]) && isset($_FILES[$name]['tmp_name']) && !empty($_FILES[$name]['tmp_name'])) {
            $ext = Tools::substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.') + 1);
            if ($ext !== 'png') {
                return array(
                    false,
                    $this->l('Only png images are accepted')
                );
            }

            if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
                if (ImageManager::validateUpload($_FILES[$name], 400000)) {
                    return array(
                        false,
                        $this->l('Invalid image.')
                    );
                } else {
                    $result = ImageManager::resize($_FILES[$name]['tmp_name'], $target, $width, $height, $ext);
                    return array(
                        $result,
                        $result ? $this->l('Image updated.') : $this->l('Error resizing image.')
                    );
                }
            } else {
                if (checkImage($_FILES[$name], 400000)) {
                    return array(
                        false,
                        $this->l('Invalid image.')
                    );
                } else {
                    $result = imageResize($_FILES[$name]['tmp_name'], $target, $width, $height, $ext);
                    return array(
                        $result,
                        $result ? $this->l('Image updated.') : $this->l('Error resizing image.')
                    );
                }
            }
        }
        return array(
            null,
            $this->l('Image not uploaded.')
        );
    }

    protected function getDefaultOptionLogoFilename()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views/img/default_user_logo.png';
    }

    protected function deleteDefaultOptionLogo()
    {
        $logo_filename = $this->getDefaultOptionLogoFilename();
        clearstatcache();
        $result = (file_exists($logo_filename) && unlink($logo_filename));
        clearstatcache();
        return $result;
    }

    protected function getDefaultOptionLogo()
    {
        $logo_filename = $this->getDefaultOptionLogoFilename();
        return file_exists($logo_filename) ? basename($logo_filename) : 'ogone.gif';
    }

    protected function getDefaultOptionLogoUrl()
    {
        return _MODULE_DIR_ . 'ogone/views/img/' . $this->getDefaultOptionLogo() . '?r=' . mt_rand();
    }

    protected function getDefaultOptionHtml()
    {
        clearstatcache();
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $default_names = $this->getDefaultOptionNames();
        foreach ($languages as $language) {
            if (!isset($default_names[(int)$language['id_lang']])) {
                $default_names[(int)$language['id_lang']] = '';
            }
        }

        $tpl_vars = array(
            'default_names' => $default_names,
            'defaultLanguage' => $default_lang,
            'custom_logo_exists' => file_exists($this->getDefaultOptionLogoFilename()),
            'logo_url' => $this->getDefaultOptionLogoUrl(),
            'languages' => $languages,
            'flags' => $this->displayFlags($languages, $default_lang, 'OGONE_DEFAULT_NAME', 'OGONE_DEFAULT_NAME', true),
            'flags_pm_desc' => $this->displayFlags($languages, $default_lang, 'add_pm_desc', 'add_pm_desc', true),
            'flags_pm_name' => $this->displayFlags($languages, $default_lang, 'add_pm_name', 'add_pm_name', true)

        );

        $this->context->smarty->assign($tpl_vars);
        return $this->display(__FILE__, 'views/templates/admin/default_option.tpl');
    }

    protected function getDefaultOptionNames()
    {
        $default_names = Tools::jsonDecode(Configuration::get('OGONE_DEFAULT_NAME'), true);
        if (!is_array($default_names)) {
            $default_names = array();
        }
        return $default_names;
    }

    public function getDirectLinkInstance()
    {
        if ($this->direct_link_instance === null) {
            $this->direct_link_instance = $this->createDirectLinkInstance();
        }
        return $this->direct_link_instance;
    }

    public function createDirectLinkInstance()
    {
        $dl = new DirectLink();
        $dl->setPSPId(Configuration::get('OGONE_PSPID'));
        $dl->setUserId(Configuration::get('OGONE_DL_USER'));
        $dl->setPassword(Configuration::get('OGONE_DL_PASSWORD'));
        $dl->setShaInPassphrase(Configuration::get('OGONE_DL_SHA_IN'));
        $dl->setShaOutPassphrase(Configuration::get('OGONE_SHA_OUT'));
        $dl->setUrl((int)Configuration::get('OGONE_MODE') === 1 ? DirectLink::URL_PROD : DirectLink::URL_TEST);
        $dl->setTimeout(Configuration::get('OGONE_DL_TIMEOUT'));
        return $dl;
    }

    public function addTransactionLog($id_cart, $id_order, $id_customer, $response)
    {
        $tl = new OgoneTransactionLog();
        $tl->id_cart = (int)$id_cart;
        $tl->id_order = (int)$id_order;
        $tl->id_customer = (int)$id_customer;
        $tl->payid = isset($response['PAYID']) ? (int)$response['PAYID'] : '';
        $tl->status = isset($response['STATUS']) ? (int)$response['STATUS'] : '';
        $tl->response = OgoneTransactionLog::encodeResponse(is_array($response) ? $response : '');
        return $tl->save() ? $tl : null;
    }

    /**
     * Checks whether direct link can be used
     *
     * @return boolean true if direct link instance is initalized and can be used
     */
    public function canUseDirectLink()
    {
        $dl = $this->getDirectLinkInstance();
        return $dl && Configuration::get('OGONE_USE_DL') && $dl->checkPrerequisites() && $dl->isInitialized();
    }

    /**
     *
     * @param Order $order
     * @return boolean[]|NULL[]|boolean[]|string[]
     */
    public function canCapture(Order $order)
    {
        if (!Validate::isLoadedObject($order)) {
            return array(
                false,
                $this->l('Order capture: Invalid order')
            );
        }

        if (!$this->active) {
            return array(
                false,
                $this->l('To capture orders you need to activate module')
            );
        }

        if ($order->module !== $this->name) {
            return array(
                false,
                $this->l('You can only capture orders paid via Ingenico')
            );
        }

        /**
         * We are checking if prestashop order state is ok
         */
        /*
         * $expected_state_id = (int) Configuration::get(self::PAYMENT_AUTHORIZED);
         * $current_state_id = (int) $order->getCurrentState();
         * if (!$current_state_id || !$expected_state_id || $expected_state_id !== $current_state_id) {
         * $current_state = new OrderState($current_state_id);
         * $current_state_name = Validate::isLoadedObject($current_state) ?
         * $current_state->name[$this->context->language->id] :
         * $current_state_id;
         * $expected_state = new OrderState($expected_state_id);
         * $expected_state_name = Validate::isLoadedObject($expected_state) ?
         * $expected_state->name[$this->context->language->id] :
         * $expected_state_id;
         * $pattern = $this->l('Invalid order state - "%s" expected, "%s" found');
         * return array(false, sprintf($pattern, $expected_state_name, $current_state_name));
         * }
         */

        /**
         * We should have at least one transaction
         */
        $last_transaction = OgoneTransactionLog::getLastByCartId($order->id_cart);
        if (!$last_transaction || !is_array($last_transaction)) {
            $pattern = $this->l('Unable to find transaction for order %d - cart %d');
            return array(
                false,
                sprintf($pattern, $order->id, $order->id_cart)
            );
        }
        /*
         * if (!isset($last_transaction['status']) || !(in_array((int)$last_transaction['status'], array(DirectLink::STATUS_AUTHORISED, 0)))) {
         * $pattern = $this->l('You can only capture order with status %d, last saved status: %d');
         * return array(false, sprintf($pattern, DirectLink::STATUS_AUTHORISED, $last_transaction['status']));
         * }
         */
        return array(
            true,
            ''
        );
    }

    /**
     *
     * @param Order $order
     * @return boolean[]|NULL[]|boolean[]|string[]
     */
    public function canRefund(Order $order)
    {
        if (!Validate::isLoadedObject($order)) {
            return array(
                false,
                $this->l('Order capture: Invalid order')
            );
        }

        if (!$this->active) {
            return array(
                false,
                $this->l('To capture orders you need to activate module')
            );
        }

        if ($order->module !== $this->name) {
            return array(
                false,
                $this->l('You can only capture orders paid via Ingenico')
            );
        }

        /**
         * We should have at least one transaction
         */
        $last_transaction = OgoneTransactionLog::getLastByCartId($order->id_cart);
        if (!$last_transaction || !is_array($last_transaction)) {
            $pattern = $this->l('Unable to find transaction for order %d - cart %d');
            return array(
                false,
                sprintf($pattern, $order->id, $order->id_cart)
            );
        }

        if ($order->total_paid_real == 0) {
            $pattern = $this->l('Nothing to refund for order %d - cart %d');
            return array(
                false,
                sprintf($pattern, $order->id, $order->id_cart)
            );
        }
        /*
         * if (!isset($last_transaction['status']) || !(in_array((int)$last_transaction['status'], array(DirectLink::STATUS_AUTHORISED, 0)))) {
         * $pattern = $this->l('You can only capture order with status %d, last saved status: %d');
         * return array(false, sprintf($pattern, DirectLink::STATUS_AUTHORISED, $last_transaction['status']));
         * }
         */

        return array(
            true,
            ''
        );
    }

    public function refund($order, $refund_amount = null)
    {
        $result = false;
        $message = '';

        if (!($order instanceof Order) || !Validate::isLoadedObject($order)) {
            $message = $this->l('Invalid order');
        } else {
            $last_transaction = OgoneTransactionLog::getLastByCartId($order->id_cart);
            if (!$last_transaction || !is_array($last_transaction)) {
                $pattern = $this->l('Order refund: unable to find transaction for cart %d');
                return array(
                    false,
                    sprintf($pattern, $order->id_cart)
                );
            }

            $max_refund_amount = $order->total_paid_real - $this->getRefundTransactionsAmount($order->id);
            if ($refund_amount === null) {
                $refund_amount = $max_refund_amount;
            }
            $refund_amount = max(0, min($max_refund_amount, $refund_amount));

            $data = array(
                'AMOUNT' => (int)round($refund_amount * 100),
                'OPERATION' => DirectLink::REFUND
            );

            $orderid = OgoneTransactionLog::getOgoneOrderIdFromTransaction($last_transaction);
            if ($orderid) {
                $data['ORDERID'] = $orderid;
            } else {
                $data['PAYID'] = $last_transaction['payid'];
            }

            try {
                $this->addMessage($order->id, 'Making request of refund: ' . $this->convertArrayToReadableString($data, ' ; <br />'));

                $response = $this->getDirectLinkInstance()->maintenance($data);
                $this->addTransactionLog($order->id_cart, $order->id, $order->id_customer, $response);
                if (isset($response['NCERROR']) && !empty($response['NCERROR'])) {
                    $message = isset($response['NCERRORPLUS']) && !empty($response['NCERRORPLUS']) ? $response['NCERRORPLUS'] : sprintf($this->l('Refund error %s', $response['NCERROR']));
                } elseif (isset($response['STATUS'])) {
                    // $response_status = (int) $response['STATUS'];
                    $result = true;
                    $message = 'Refund request sended. Response: ' . $this->convertArrayToReadableString($response, ' ; <br />');
                } else {
                    $message = $this->l('Refund error: invalid response, no status nor error included');
                }
            } catch (Exception $ex) {
                $message = $ex->getMessage();
            }
        }
        if ($order && $order->id) {
            $this->addMessage($order->id, $message);
        }
        return array(
            $result,
            $message
        );
    }

    /**
     * Captures order
     *
     * @param Order $order
     */
    public function capture($order, $capture_amount = null)
    {
        $result = false;
        $message = '';

        $accepted_payment_state_id = (int)Configuration::get(self::PAYMENT_ACCEPTED);
        $accepted_payment_state = new OrderState($accepted_payment_state_id);

        $transition_payment_state_id = (int)Configuration::get(self::PAYMENT_IN_PROGRESS);
        $transition_payment_state = new OrderState($transition_payment_state_id);

        $allowed_statuses = array(
            DirectLink::STATUS_CAPTURED,
            DirectLink::STATUS_PAYMENT_PROCESSING,
            DirectLink::STATUS_PAYMENT_BEING_PROCESSED
        );

        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $captured = $this->getCaptureTransactionsAmount($order->id);
            $captured_pending = $this->getPendingCaptureTransactionsAmount($order->id);
            $capture_amount = max(0, min($order->total_paid - $captured - $captured_pending, $capture_amount ? $capture_amount : $order->total_paid));
        } else {
            $capture_amount = max(0, min($order->total_paid - $order->total_paid_real, $capture_amount ? $capture_amount : $order->total_paid));
        }

        list ($can_capture, $error) = $this->canCapture($order);

        if (!($order instanceof Order) || !Validate::isLoadedObject($order)) {
            $message = $this->l('Invalid order');
        } elseif (!$accepted_payment_state_id || !Validate::isLoadedobject($accepted_payment_state)) {
            $message = sprintf($this->l('Unable to load accepted payment order state %d'), $accepted_payment_state_id);
        } elseif (!$transition_payment_state || !Validate::isLoadedobject($transition_payment_state)) {
            $pattern = $this->l('Unable to load transitional payment order state %d');
            $message = sprintf($pattern, $transition_payment_state_id);
        } elseif (!$can_capture) {
            $message = sprintf($this->l('Unable to capture order %s : %s'), $order->id, $error);
        } elseif (!$this->canUseDirectLink()) {
            $message = $this->l('Unable to use DirectLink. Please check prerequisites and configuration.');
        } elseif ($capture_amount !== null && ($capture_amount <= 0 || $capture_amount > $order->total_paid)) {
            $message = $this->l('Invalid capture amount.');
        } else {
            $last_transaction = OgoneTransactionLog::getLastByCartId($order->id_cart);
            if (!$last_transaction || !is_array($last_transaction)) {
                $pattern = $this->l('Order capture: unable to find transaction for cart %d');
                return array(
                    false,
                    sprintf($pattern, $order->id_cart)
                );
            }
            $data = array(
                'AMOUNT' => (int)round($capture_amount * 100),
                'OPERATION' => DirectLink::CAPTURE
            );

            $orderid = OgoneTransactionLog::getOgoneOrderIdFromTransaction($last_transaction);
            if ($orderid) {
                $data['ORDERID'] = $orderid;
            } else {
                $data['PAYID'] = $last_transaction['payid'];
            }

            try {
                $response = $this->getDirectLinkInstance()->maintenance($data);
                $this->addTransactionLog($order->id_cart, $order->id, $order->id_customer, $response);
                $this->log(sprintf('Capture result: %s', Tools::jsonEncode($response)));

                if (isset($response['NCERROR']) && !empty($response['NCERROR'])) {
                    $message = isset($response['NCERRORPLUS']) && !empty($response['NCERRORPLUS']) ? $response['NCERRORPLUS'] : sprintf($this->l('Capture error %s', $response['NCERROR']));
                } elseif (isset($response['STATUS']) && in_array((int)$response['STATUS'], $allowed_statuses)) {
                    $response_status = (int)$response['STATUS'];
                    try {
                        if ($response_status === DirectLink::STATUS_CAPTURED) {
                            $precision = defined('_PS_PRICE_COMPUTE_PRECISION_') ? _PS_PRICE_COMPUTE_PRECISION_ : 6;
                            /**
                             * Order captured directly, we can make update now
                             */
                            $order->total_paid_real = $order->total_paid_real + round($response['AMOUNT'], $precision);
                            if ($order->update()) {
                                $update_history = true;
                                $message = sprintf($this->l('Amount of %s captured', $response['AMOUNT']));
                            } else {
                                $update_history = false;
                                $message = sprintf($this->l('Order capture: unable to update order %d'), $order->id);
                            }
                            $payment_state_id = $accepted_payment_state_id;
                        } else {
                            /**
                             * Order authorisation in progress, final capture will be confirmed via direct request
                             *
                             * @var unknown
                             */
                            $update_history = true;
                            $payment_state_id = $transition_payment_state_id;
                            $currency = new Currency($order->id_currency);
                            $message = sprintf($this->l('Capture of %s %s in progress, final capture will be confirmed via direct request'), $response['AMOUNT'], $currency->iso_code);
                        }

                        if ($update_history) {
                            if ((int)$order->current_state === $payment_state_id) {
                                // no need to update history
                                $result = true;
                            } else {
                                $history = new OrderHistory();
                                $history->id_order = (int)$order->id;
                                $history->changeIdOrderState($payment_state_id, (int)$order->id);
                                $result = $history->addWithemail(true, array());
                                if (!$result) {
                                    $message .= $this->l('Error updating message history');
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $message = sprintf($this->l('Error adding order history - %s', $ex->getMessage()));
                    }
                } elseif (isset($response['STATUS'])) {
                    $pattern = $this->l('Capture error: expecting status %d,  %d sent');
                    $message = sprintf($pattern, DirectLink::STATUS_CAPTURED, (int)$response['STATUS']);
                } else {
                    $message = $this->l('Capture error: invalid response, no status nor error included');
                }
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $this->addMessage($order->id, $message);
            }
        }

        $this->log($message);
        if (!$result) {
            if (version_compare(_PS_VERSION_, '1.6', 'ge')) {
                $id_order = Validate::isLoadedObject($order) ? $order->id : null;
                $id_employee = isset($this->context->employee) ? (int)$this->context->employee->id : null;
                if (class_exists('PrestaShopLogger')) {
                    PrestaShopLogger::addLog($message, 2, null, 'Order', $id_order, true, $id_employee);
                }
            }
        }
        if ($order && $order->id) {
            $this->addMessage($order->id, $message);
        }
        return array(
            $result,
            $message
        );
    }

    /* TABS DISPLAY */

    /**
     * Return list of Ingenico return codes, usable in HelperList
     *
     * @return array
     */
    public function getReturnCodesList()
    {
        $result = array();
        foreach ($this->return_codes as $code => $description) {
            $result[(int)$code] = $this->l($description[0]);
        }
        return $result;
    }

    /**
     * Return colors associated to Ingenico status
     * Background color is taken from associated order status
     * Foreground color is calculated by Tools::getBrightness
     *
     * @param int $status
     * @return array [background color: hex color, foreground color : hex color]
     */
    public function getPaymentStatusColor($status)
    {
        if (!isset($this->return_code_list_colors[(int)$status])) {
            $order_state_id = $this->getPaymentStatusId($this->getCodePaymentStatus($status));
            if ($order_state_id) {
                $order_state = new OrderState($order_state_id);
                $bg_color = $order_state->color ? $order_state->color : '#999999';
            } else {
                $bg_color = '#999';
            }

            $color = Tools::getBrightness($bg_color) < 128 ? '#ffffff' : '#383838';
            $this->return_code_list_colors[$status] = array(
                $bg_color,
                $color
            );
        }
        return $this->return_code_list_colors[$status];
    }

    /* ALIAS & HTP */
    public function canUseAliases()
    {
        return Configuration::get('OGONE_USE_ALIAS') && $this->canUseDirectLink();
    }

    public function canUseAliasesViaDL()
    {
        return $this->canUseAliases() && Configuration::get('OGONE_ALIAS_BY_DL');
    }

    public function getHostedTokenizationPageRegistrationUrls($id_customer, $allow_immediate_payment = false)
    {
        $result = array();
        $pms = Tools::jsonDecode(Configuration::get('OGONE_ALIAS_PM'), true);
        if (is_array($pms)) {
            foreach ($pms as $alias_pm => $active) {
                if (!$active) {
                    continue;
                }
                $result[$alias_pm] = $this->getHostedTokenizationPageRegistrationUrl($id_customer, $alias_pm, $allow_immediate_payment);
            }
        }
        return $result;
    }

    /**
     * Gets unique url to hosted tokenization page
     * Generates alias name based on customer id
     *
     * @param integer $id_customer
     */
    public function getHostedTokenizationPageRegistrationUrl($id_customer, $alias_pm, $allow_immediate_payment = false)
    {
        $url = Configuration::get('OGONE_MODE') ? 'https://secure.ogone.com' : 'https://ogone.test.v-psp.com';
        $url .= '/Tokenization/HostedPage';
        $alias = $this->getDirectLinkInstance()->generateAlias($id_customer);
        $params_ok = array(
            'result' => 'ok',
            'alias_full' => $alias
        );
        $params_ko = array(
            'result' => 'ko',
            'alias_full' => $alias
        );

        if ($allow_immediate_payment) {
            $params_ok['aip'] = 1;
        }

        if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
            $accept_url = $this->context->link->getModuleLink($this->name, 'aliases', $params_ok, Configuration::get('PS_SSL_ENABLED'));
            $exception_url = $this->context->link->getModuleLink($this->name, 'aliases', $params_ko, Configuration::get('PS_SSL_ENABLED'));
        } else {
            $base_url = (_PS_SSL_ENABLED_ ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/ogone/aliases.php';
            $accept_url = $base_url . '?' . http_build_query($params_ok);
            $exception_url = $base_url . '?' . http_build_query($params_ko);
        }

        $query = array(
            'ACCOUNT.PSPID' => Configuration::get('OGONE_PSPID'),
            'ALIAS.ALIASID' => $alias,
            'CARD.PAYMENTMETHOD' => $alias_pm,
            'PARAMETERS.ACCEPTURL' => $accept_url,
            'PARAMETERS.EXCEPTIONURL' => $exception_url,
            'PARAMETERS.PARAMPLUS' => $alias
        );

        // for Direct Debits BRAND need to be the same as PAYMENTMETHOD
        if (stristr($alias_pm, 'DirectDebit') !== false) {
            $query['CARD.BRAND'] = str_replace('DirectDebits', 'Direct Debits', $alias_pm);
            $query['CARD.PAYMENTMETHOD'] = str_replace('DirectDebits', 'Direct Debits', $alias_pm);
        }
        if (Configuration::get('OGONE_DONT_STORE_ALIAS') && $allow_immediate_payment) {
            $query['ALIAS.STOREPERMANENTLY'] = 'N';
        }

        $language_code = $this->getLanguageCode();
        if ($language_code) {
            $query['LAYOUT.LANGUAGE'] = $language_code;
        }
        $sha_sign = Configuration::get('OGONE_SHA_IN');
        $query['SHASIGNATURE.SHASIGN'] = DirectLink::getShaSign($query, $sha_sign);
        return $url . '?' . http_build_query($query);
    }

    protected function getLanguageCode()
    {
        $code = $this->context->language->language_code;
        $elements = explode('-', $code);
        if (count($elements) == 2) {
            return Tools::strtolower($elements[0]) . '-' . Tools::strtoupper($elements[1]);
        }
        return Tools::strtolower($this->context->language->language_code);
    }

    public function createAlias($id_customer, $data, $skip_sha_verification = false)
    {
        $this->log(sprintf('Creating alias for customer %s :  %s', $id_customer, $this->convertArrayToReadableString($data, ' ; ')));

        foreach ($this->expected_alias_return_fields as $name) {
            if (!array_key_exists($name, $data)) {
                return array(
                    false,
                    sprintf($this->l('Unable to save alias - field %s do not exists'), $name)
                );
            }
        }
        if (!$skip_sha_verification && !array_key_exists('SHASIGN', $data)) {
            return array(
                false,
                sprintf($this->l('Unable to save alias - field %s do not exists'), 'SHASIGN')
            );
        }

        if (!$skip_sha_verification) {
            $ogone_params = $data;
            unset($ogone_params['SHASIGN']);

            $passphrase = Configuration::get('OGONE_SHA_OUT');
            $sha_calculated = DirectLink::getShaSign($ogone_params, $passphrase);

            if ($sha_calculated !== $data['SHASIGN']) {
                $pattern = $this->l('Unable to save alias - sha calculated (%s) do not match sha received (%s)');
                return array(
                    false,
                    sprintf($pattern, $sha_calculated, $data['SHASIGN'])
                );
            }
        }

        if (!empty($data['NCERROR'])) {
            return array(
                false,
                sprintf($this->l('Unable to save alias - %s'), $data['NCERROR'])
            );
        }

        if (OgoneAlias::getByAlias($this->encryptAlias($data['ALIAS']))) {
            return array(
                false,
                sprintf($this->l('Unable to save alias - alias %s exists'), $data['ALIAS'])
            );
        }

        $alias_parts = explode('_', $data['ALIAS']);
        if (count($alias_parts) < 2 || (int)$alias_parts[0] !== (int)$id_customer || !Validate::isLoadedObject(new Customer($id_customer))) {
            return array(
                false,
                $this->l('Unable to save alias - invalid customer')
            );
        }

        if (!$this->isDirectDebitBrand($data['BRAND'])) {
            $expiry_date = DateTime::createFromFormat('my', $data['ED']);
            if (!$expiry_date) {
                return array(
                    false,
                    sprintf($this->l('Unable to save alias - invalid expiry date %s'), $data['ED'])
                );
            }
        } else {
            $expiry_date = null;
        }

        $ogone_alias = new OgoneAlias();
        $ogone_alias->id_customer = $id_customer;
        $ogone_alias->alias = $this->encryptAlias($data['ALIAS']);
        $ogone_alias->cn = $data['CN'];
        $ogone_alias->cardno = $data['CARDNO'];
        $ogone_alias->brand = $data['BRAND'];
        $ogone_alias->active = 1;
        if ($expiry_date) {
            $ogone_alias->expiry_date = $expiry_date->format('Y-m-t 23:59:59'); // last day of month
        }
        $ogone_alias->is_temporary = isset($data['STOREPERMANENTLY']) && $data['STOREPERMANENTLY'] == 'N' ? 1 : 0;

        if (!$ogone_alias->save()) {
            return array(
                false,
                $this->l('Unable to save alias')
            );
        }

        return array(
            true,
            $ogone_alias->id
        );
    }

    protected function isDirectDebitBrand($brand)
    {
        return (Tools::substr(str_replace(' ', '', Tools::strtolower($brand)), 0, 11) == 'directdebit');
    }

    /**
     * Changes shop context if necessary
     *
     * @param Cart $cart
     */
    public function setShopContext($cart)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            return false;
        }

        if (!Shop::isFeatureActive()) {
            return false;
        }

        $context = Context::getContext();
        if ($context->shop->id != $cart->id_shop) {
            Cache::clean('*');
            CurrencyCacheCleaner::clean();
            ProductCacheCleaner::clean();
            SpecificPriceCacheCleaner::clean();
            $context->shop = new Shop($cart->id_shop);
            Shop::setContext(Shop::CONTEXT_SHOP, $cart->id_shop);
            Cache::clean('*');
            CurrencyCacheCleaner::clean();
            ProductCacheCleaner::clean();
            SpecificPriceCacheCleaner::clean();
            return true;
        }

        return false;
    }

    public function setEmployee()
    {
        if ($this->isPS16x() || $this->isPS17x()) {
            if (!isset(Context::getContext()->employee)) {
                $employees = Employee::getEmployees();
                if (isset($employees[0])) {
                    Context::getContext()->employee = new Employee($employees[0]['id_employee']);
                }
            }
        }
    }

    /**
     * We cannot assume that iconv / transliterate / mb_convert works as it is needed
     *
     * @param string $str
     */
    protected function convertToASCII($str)
    {
        $src = array ('Á','À','Ȧ','Â','Ä','Ǟ','Ǎ','Ă','Ā','Ã','Å','Ǻ','Ǽ','Ǣ','Ć','Ċ','Ĉ','Č','Ď','Ḍ','Ḑ','Ḓ','É','È','Ė','Ê','Ë','Ě','Ĕ','Ē','Ẽ','E̊','Ẹ','Ġ','Ĝ','Ǧ','Ğ','G̃','Ģ','Ĥ','Ḥ','á','à','ȧ','â','ä','ǟ','ǎ','ă','ā','ã','å','ǻ','ǽ','ǣ','ć','ċ','ĉ','č','ď','ḍ','ḑ','ḓ','é','è','ė','ê','ë','ě','ĕ','ē','ẽ','e̊','ẹ','ġ','ĝ','ǧ','ğ','g̃','ģ','ĥ','ḥ','Í','Ì','İ','Î','Ï','Ǐ','Ĭ','Ī','Ĩ','Ị','Ĵ','Ķ','Ǩ','Ĺ','Ļ','Ľ','Ŀ','Ḽ','M̂','M̄','N','Ń','N̂','Ṅ','N̈','Ň','N̄','Ñ','Ņ','Ṋ','Ó','Ò','Ȯ','Ȱ','Ô','Ö','Ȫ','Ǒ','Ŏ','Ō','Õ','Ȭ','Ő','Ọ','Ǿ','Ơ','í','ì','i','î','ï','ǐ','ĭ','ī','ĩ','ị','ĵ','ķ','ǩ','ĺ','ļ','ľ','ŀ','ḽ','m̂','m̄','ŉ','ń','n̂','ṅ','n̈','ň','n̄','n̄','ņ','ṋ','ó','ò','ô','ȯ','ȱ','ö','ȫ','ǒ','ŏ','ō','õ','ȭ','ő','ọ','ǿ','ơ','P̄','Ŕ','Ř','Ŗ','Ś','Ŝ','Ṡ','Š','Ș','Ṣ','Ť','Ț','Ṭ','Ṱ','Ú','Ù','Û','Ü','Ǔ','Ŭ','Ū','Ũ','Ű','Ů','Ụ','Ẃ','Ẁ','Ŵ','Ẅ','Ý','Ỳ','Ŷ','Ÿ','Ȳ','Ỹ','Ź','Ż','Ž','Ẓ','Ǯ','p̄','ŕ','ř','ŗ','ś','ŝ','ṡ','š','ş','ṣ','ť','ț','ṭ','ṱ','ú','ù','û','ü','ǔ','ŭ','ū','ũ','ű','ů','ụ','ẃ','ẁ','ŵ','ẅ','ý','ỳ','ŷ','ÿ','ȳ','ỹ','ź','ż','ž','ẓ','ǯ');
        $tgt = array ('A','A','A','A','A','A','A','A','A','A','A','A','A','A','C','C','C','C','D','D','D','D','E','E','E','E','E','E','E','E','E','E','E','G','G','G','G','G','G','H','H','a','a','a','a','a','a','a','a','a','a','a','a','a','a','c','c','c','c','d','d','d','d','e','e','e','e','e','e','e','e','e','e','e','g','g','g','g','g','g','h','h','I','I','I','I','I','I','I','I','I','I','J','K','K','L','L','L','L','L','M','M','N','N','N','N','N','N','N','N','N','N','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','i','i','i','i','i','i','i','i','i','i','j','k','k','l','l','l','l','l','m','m','n','n','n','n','n','n','n','n','n','n','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','P','R','R','R','S','S','S','S','S','S','T','T','T','T','U','U','U','U','U','U','U','U','U','U','U','W','W','W','W','Y','Y','Y','Y','Y','Y','Z','Z','Z','Z','Z','p','r','r','r','s','s','s','s','s','s','t','t','t','t','u','u','u','u','u','u','u','u','u','u','u','w','w','w','w','y','y','y','y','y','y','z','z','z','z','z');
        return utf8_decode(str_replace($src, $tgt, $str));
    }

    public function getAliasLogoUrl(array $alias, $default = 'cc_small.png')
    {
        $path = array(
            'views',
            'img',
            Tools::strtolower(str_replace(' ', '', $alias['brand']) . '.png')
        );

        $logo_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);
        $base_url = _MODULE_DIR_ . $this->name;
        if (file_exists($logo_path)) {
            return implode('/', array(
                $base_url,
                implode('/', $path)
            ));
        } else {
            return implode('/', array(
                $base_url,
                'views',
                'img',
                $default
            ));
        }
    }

    public function generateOrderId($id_cart)
    {
        return sprintf('%d-%s', $id_cart, base_convert(time(), 10, 36));
    }

    public function extractCartId($id_order)
    {
        $id_cart = stristr($id_order, '-', true);
        return $id_cart ? $id_cart : $id_order;
    }

    public function doDirectLinkAliasPayment(Cart $cart, OgoneAlias $alias)
    {
        try {
            $result = false;

            list ($check_result, $error) = $this->checkAliasPaymentPrerequisites($cart, $alias);
            if (!$check_result) {
                return array(
                    self::DL_ALIAS_RET_ERROR,
                    $error
                );
            }

            $data = array(
                'ALIAS' => $this->decryptAlias($alias->alias),
                'AMOUNT' => round($cart->getOrderTotal(true, Cart::BOTH) * 100),
                'ORDERID' => $this->generateOrderId($cart->id),
                'CURRENCY' => $this->context->currency->iso_code,
                'ECI' => self::INGENICO_ECI_DL, // ECI value "9" must be sent for reccurring transactions.
                'OPERATION' => Configuration::get('OGONE_OPERATION')
            );

            if ($this->use3DSecureForDL()) {
                $data = $this->getDirectLink3DSData($cart, $alias) + $data;
            }

            $this->log('DATA');
            $this->log($data);

            $transactions = (OgoneTransactionLog::getAllByCartId($cart->id));
            $astatuses = array(
                DirectLink::STATUS_REFUSED,
                DirectLink::STATUS_REFUSED,
                DirectLink::STATUS_WAITING_FOR_IDENTIFICATION
            );

            foreach ($transactions as $k => $transaction) {
                $this->log($transaction['response']);
                $tr = Tools::jsonDecode($transaction['response'], true);
                if ($tr && isset($tr['ORDERID']) && $tr['ORDERID'] != $data['ORDERID'] && ((isset($tr['STATUS']) && in_array($tr['STATUS'], $astatuses)) || (time() - strtotime($transaction['date_add']) > self::TRANSACTION_COOLDOWN_TIME))) {
                    $this->log('unset ' . $transaction['response']);
                    unset($transactions[$k]);
                }
            }

            if ($this->issetDLProcessingToken($cart->id) || !empty($transactions)) {
                $skip = false;
                if ($this->issetDLProcessingToken($cart->id)) {
                    $this->log('PREVIOUS TRANSACTION DETECTED');
                }

                if (!empty($transactions)) {
                    $this->log('PROCESSING TOKEN');
                    // trying not to block transactions if error was detected
                    $transactions = array_values($transactions);
                    if (isset($transactions[0]) && $transactions[0]['payid'] == 0 && $transactions[0]['status'] == 0) {
                        $response = Tools::jsonDecode($transactions[0]['response'], true);
                        if ($response && is_array($response) && isset($response['NCSTATUS']) && $response['NCSTATUS'] == 5) {
                            $this->log('SKIPPING TOKEN');
                            $skip = true;
                        }
                    }
                }
                if (!$skip) {
                    $id_order = Order::getOrderByCartId($cart->id);
                    $customer = new Customer($cart->id_customer);

                    if ($id_order) {
                        $this->log('ORDER DETECTED ' . $id_order);
                        $redirect = 'index.php?controller=order-confirmation&id_cart=' . $cart->id . '&id_module=' . $this->id . '&id_order=' . $id_order . '&key=' . $customer->secure_key . '&why=pt';
                    } else {
                        $this->log('REDIRECT ');

                        $redirect = 'index.php?controller=order&step=3&why=ptno';
                    }
                    Tools::redirect($redirect);
                }
            }

            $this->log("setDLProcessingToken");
            $this->setDLProcessingToken($cart->id);

            $this->log("RESPONSE");
            $response = $this->getDirectLinkInstance()->order($data);
            $this->log($response);

            $this->log("ADDING TL");
            $this->addTransactionLog($cart->id, null, $alias->id_customer, $response);

            $this->log("deleteDLProcessingToken");
            $this->deleteDLProcessingToken($cart->id);

            if ($this->use3DSecureForDL() && $response && isset($response['STATUS']) && (int)$response['STATUS'] === DirectLink::STATUS_WAITING_FOR_IDENTIFICATION) {
                $this->log("processDLAP3DS");

                list ($result, $message) = $this->processDLAP3DS($response, $cart);
                if ($result && $message) {
                    return array(
                        self::DL_ALIAS_RET_INJECT_HTML,
                        $message
                    );
                }
            } else {
                $this->log("processDLAPResponse");

                list ($result, $message) = $this->processDLAPResponse($response, $cart);
                if ($result) {
                    return array(
                        self::DL_ALIAS_RET_PAYMENT_DONE,
                        $message
                    );
                }
            }

            if ($message) {
                $this->log($message);
            }

            return array(
                self::DL_ALIAS_RET_ERROR,
                $message ? $message : $this->l('DirectLink payment error')
            );
        } catch (Exception $ex) {
            $this->log($ex->getMessage());
            return array(
                self::DL_ALIAS_RET_ERROR,
                $this->l('DirectLink payment error')
            );
        }
    }

    protected function processDLAP3DS($response, $cart)
    {
        if (!$response || !isset($response['STATUS']) || (int)$response['STATUS'] !== DirectLink::STATUS_WAITING_FOR_IDENTIFICATION) {
            return array(
                false,
                $this->l('Status error')
            );
        }

        if (!isset($response['HTML_ANSWER']) || empty($response['HTML_ANSWER'])) {
            return array(
                false,
                $this->l('No expected answer')
            );
        }

        $html_answer = base64_decode($response['HTML_ANSWER']); /* required to decode API response */

        return ($html_answer ? array(
            true,
            $html_answer
        ) : array(
            false,
            $this->l('Unable to decode response')
        ));
    }

    protected function processDLAPResponse($response, $cart)
    {
        if (!$response || !is_array($response) || !isset($response['STATUS'])) {
            return array(
                false,
                $this->l('Response error')
            );
        }

        if (!empty($response['NCERROR'])) {
            $message = (isset($response['NCERRORPLUS']) && !empty($response['NCERRORPLUS']) ? $response['NCERRORPLUS'] : $response['NCERROR']);
            return array(
                false,
                $this->l($message)
            );
        }

        $ogone_return_code = (int)$response['STATUS'];
        $this->log('ogone_return_code : ' . $ogone_return_code);

        $ogone_state = $this->getCodePaymentStatus($ogone_return_code);
        $this->log('ogone_state : ' . $ogone_state);

        $ogone_state_description = $this->getCodeDescription($ogone_return_code);
        $this->log('ogone_state_description : ' . $ogone_state_description);

        $payment_state_id = $this->getPaymentStatusId($ogone_state);
        $this->log('payment_state_id : ' . $payment_state_id);

        $amount_paid = ($ogone_state === Ogone::PAYMENT_ACCEPTED || $ogone_state === Ogone::PAYMENT_AUTHORIZED || $ogone_state === Ogone::PAYMENT_IN_PROGRESS ? (float)$response['AMOUNT'] : 0);

        $this->log('amount_paid : ' . $amount_paid);

        $this->addTransactionLog($cart->id, 0, $cart->id_customer, $response);

        $message = sprintf('%s %s', $ogone_state_description, Tools::safeOutput($ogone_state));
        $this->log($message);
        $this->log('Validating order, state ' . $payment_state_id);
        $result = (bool)$this->validate($cart->id, $payment_state_id, $amount_paid, $message, $cart->secure_key);

        $this->log($result ? sprintf('Order validated as %s', $this->currentOrder) : 'Order not validated');

        $this->log('Order validate result ' . $this->currentOrder);
        if ($this->currentOrder) {
            $this->addTransactionLog($cart->id, $this->currentOrder, $cart->id_customer, $response);
        }

        return array(
            $result,
            $result ? '' : $this->l('Unable to validate order')
        );
    }

    public function use3DSecureForDL()
    {
        return (bool)Configuration::get('OGONE_USE_D3D');
    }

    public function getDirectLink3DSData(Cart $cart, OgoneAlias $alias)
    {
        $data = array(
            'FLAG3D' => 'Y',
            'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'WIN3DS' => $this->getWin3DSOption(),
            'ACCEPTURL' => $this->getConfirmationUrl(),
            'DECLINEURL' => $this->getDeclineUrl(),
            'EXCEPTIONURL' => $this->getExceptionUrl(),
            'PARAMPLUS' => '3ds=1&aid=' . $alias->id . '&secure_key=' . $cart->secure_key . '&dg=' . $this->get3DSecureConfirmationDigest($cart, $alias),
            'COMPLUS' => '',
            'LANGUAGE' => $this->getLanguageCode(),
            'ECI' => self::INGENICO_ECI_ECOMMERCE,
            'BROWSERACCEPTHEADER' => isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null,
            'BROWSERUSERAGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
        );

        // Add customer data
        $address = new Address($cart->id_address_invoice);
        $customer = new Customer($cart->id_customer);

        $data['ADDRMATCH'] = '0';
        $data['ECOM_BILLTO_POSTAL_CITY'] = $address->city;
        $data['ECOM_BILLTO_POSTAL_COUNTRYCODE'] = Country::getIsoById($address->id_country);
        $data['ECOM_BILLTO_POSTAL_STREET_LINE1'] = $address->address1;
        $data['ECOM_BILLTO_POSTAL_STREET_LINE2'] = $address->address2;
        $data['ECOM_BILLTO_POSTAL_POSTALCODE'] = $address->postcode;
        $data['REMOTE_ADDR'] = Tools::getRemoteAddr();
        $data['EMAIL'] = $customer->email;
        $data['CUID'] = $customer->email;

        // Add delivery data
        if ($cart->id_address_delivery > 0) {
            $delivery = new Address($cart->id_address_delivery);
            $data['ECOM_SHIPTO_POSTAL_CITY'] = $delivery->city;
            $data['ECOM_SHIPTO_POSTAL_COUNTRYCODE'] = Country::getIsoById($delivery->id_country);
            $data['ECOM_SHIPTO_POSTAL_STREET_LINE1'] = $delivery->address1;
            $data['ECOM_SHIPTO_POSTAL_STREET_LINE2'] = $delivery->address2;
            $data['ECOM_SHIPTO_POSTAL_POSTALCODE'] = $delivery->postcode;
        }

        // Add Browser values
        $browserValues = [
            'browserColorDepth',
            'browserJavaEnabled',
            'browserLanguage',
            'browserScreenHeight',
            'browserScreenWidth',
            'browserTimeZone'
        ];
        foreach ($browserValues as $key) {
            if (isset($_COOKIE[$key])) {
                $data[strtoupper($key)] = $_COOKIE[$key];
            }
        }

        if (Tools::getValue('CVC') && is_numeric(Tools::getValue('CVC'))) {
            $data['CVC'] = trim(Tools::getValue('CVC'));
        }

        $this->log('ogone_params: ' . var_export($data, true));

        return $data;
    }

    public function getWin3DSOption()
    {
        $win3ds = Configuration::get('OGONE_WIN3DS');
        return ($win3ds && in_array($win3ds, array(
            'MAINW',
            'POPUP',
            'POPIX'
        )) ? $win3ds : 'MAINW');
    }

    protected function get3DSecureConfirmationDigest(Cart $cart, OgoneAlias $alias)
    {
        $data = array(
            _COOKIE_KEY_,
            $cart->id,
            $alias->alias,
            $alias->id,
            Configuration::get('OGONE_PSPID'),
            Configuration::get('OGONE_SHA_IN'),
            __FILE__
        );
        return sha1(implode(_COOKIE_KEY_, array_map('sha1', $data)));
    }

    protected function checkAliasPaymentPrerequisites(Cart $cart, OgoneAlias $alias)
    {
        $result = array(
            false,
            ''
        );

        $this->log('checkAliasPaymentPrerequisites');
        $this->log(__LINE__);
        $this->log($cart->id, Validate::isLoadedObject($cart));
        if (!$cart->id || !Validate::isLoadedObject($cart)) {
            $result[1] = $this->l('Invalid cart');
            return $result;
        }
        $this->log(__LINE__);

        if (!Validate::isLoadedObject($alias)) {
            $result[1] = $this->l('Invalid alias');
            return $result;
        }
        $this->log(__LINE__);

        if (!$alias->active) {
            $result[1] = $this->l('Alias is inactive');
            return $result;
        }
        $this->log(__LINE__);

        if (!$this->isDirectDebitBrand($alias->brand)) {
            if (!$alias->expiry_date || strtotime($alias->expiry_date) < time()) {
                $result[1] = $this->l('Alias expired!');
                return $result;
            }
        }
        $this->log(__LINE__);

        if (!$cart->id_customer || !$alias->id_customer || (int)$cart->id_customer !== (int)$alias->id_customer) {
            $result[1] = $this->l('Invalid customer');
            return $result;
        }
        $this->log(__LINE__);

        if (Order::getOrderByCartId($cart->id)) {
            $result[1] = $this->l('Order has been already placed for this cart');
            return $result;
        }
        $this->log(__LINE__);

        return array(
            true,
            ''
        );
    }

    public function encryptAlias($alias)
    {
        if (Tools::substr($alias, 0, 1) === '!') {
            return $alias;
        }
        return '!' . $this->getCipherTool()->encrypt($alias);
    }

    public function decryptAlias($alias)
    {
        if (Tools::substr($alias, 0, 1) === '!') {
            $encrypted = Tools::substr($alias, 1);
            return $this->getCipherTool()->decrypt($encrypted);
        }
        return $alias;
    }

    protected function initCipherTool()
    {
        if ($this->isPS17x()) {
            return new PhpEncryption(_NEW_COOKIE_KEY_);
        }

        if (!Configuration::get('PS_CIPHER_ALGORITHM') || !defined('_RIJNDAEL_KEY_')) {
            return new Blowfish(_COOKIE_KEY_, _COOKIE_IV_);
        }
        return new Rijndael(_RIJNDAEL_KEY_, _RIJNDAEL_IV_);
    }

    protected function getCipherTool()
    {
        if ($this->cipher_tool === null) {
            $this->cipher_tool = $this->initCipherTool();
        }
        return $this->cipher_tool;
    }

    protected function getTLSVersion()
    {
        if (function_exists('curl_init') && $ch = curl_init()) {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $this->check_tls_api,
                CURLOPT_TIMEOUT => 10
            );
            curl_setopt_array($ch, $options);
            $result = curl_exec($ch);
            if ($result) {
                $decoded = Tools::jsonDecode($result, true);
                if ($decoded && is_array($decoded) && isset($decoded['tls_version'])) {
                    return ltrim($decoded['tls_version'], 'A..Z ');
                }
            }
            curl_close($ch);
        }
        return null;
    }

    public function skipAliasPaymentConfirmation()
    {
        return (bool)Configuration::get('OGONE_SKIP_AC');
    }

    public function makeImmediateAliasPayment()
    {
        return (bool)Configuration::get('OGONE_MAKE_IP') && $this->canUseDirectLink();
    }

    public function useFraudScoring()
    {
        return (bool)Configuration::get('OGONE_DISPLAY_FRAUD_SCORING');
    }

    public function getFraudScoring($order)
    {
        if (!$this->useFraudScoring()) {
            return null;
        }
        $last_transaction = OgoneTransactionLog::getLastByCartId($order->id_cart);
        if (!$last_transaction || !is_array($last_transaction)) {
            return null;
        }
        try {
            $data = array(
                'PAYID' => $last_transaction['payid']
            );
            $result = $this->getDirectLinkInstance()->query($data);
            if ($result && is_array($result) && isset($result['SCO_CATEGORY']) && isset($result['SCORING'])) {
                return array(
                    'category' => $result['SCO_CATEGORY'],
                    'score' => (int)$result['SCORING']
                );
            }
        } catch (Exception $ex) {
            return array(
                'category' => 'X',
                'score' => $ex->getMessage()
            );
        }
    }

    public function convertArrayToReadableString(array $array, $glue = '<br />', $pattern = '%s : %s')
    {
        $callback = function ($k, $v) use ($pattern) {
            return sprintf($pattern, $k, $v);
        };
        return implode($glue, array_map($callback, array_keys($array), array_values($array)));
    }

    public function getOrderSlipsAmount($id_order)
    {
        $query = 'SELECT SUM(amount + shipping_cost_amount) FROM `' . _DB_PREFIX_ . 'order_slip` WHERE id_order = ' . (int)$id_order;
        return Db::getInstance()->getValue($query);
    }

    public function getCaptureTransactionsAmount($id_order)
    {
        $amount = 0;
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $order = new Order($id_order);
            $transactions = OgoneTransactionLog::getTransactionsByCartIdAndStatus($order->id_cart, array(
                DirectLink::STATUS_CAPTURED
            ));
        } else {
            $transactions = OgoneTransactionLog::getTransactionsByOrderIdAndStatus($id_order, array(
                DirectLink::STATUS_CAPTURED
            ));
        }

        foreach ($transactions as $transaction) {
            $response = $transaction['response'];
            if ($response && $response['AMOUNT'] && empty($response['NCERROR'])) {
                $amount += (float)$response['AMOUNT'];
            }
        }
        return $amount;
    }

    public function getPendingCaptureTransactionsAmount($id_order)
    {
        $amount = 0;
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $order = new Order($id_order);
            $transactions = OgoneTransactionLog::getTransactionsByCartIdAndStatus($order->id_cart, array(
                DirectLink::STATUS_PAYMENT_PROCESSING
            ));
        } else {
            $transactions = OgoneTransactionLog::getTransactionsByOrderIdAndStatus($id_order, array(
                DirectLink::STATUS_PAYMENT_PROCESSING
            ));
        }
        foreach ($transactions as $transaction) {
            $response = $transaction['response'];
            if ($response && $response['AMOUNT'] && empty($response['NCERROR'])) {
                $amount += (float)$response['AMOUNT'];
            }
        }
        return $transactions ? max($amount - $this->getCaptureTransactionsAmount($id_order), 0) : 0;
    }

    public function getCaptureMaxAmount($id_order)
    {
        $order = new Order($id_order);
        $captured_pending = $this->getPendingCaptureTransactionsAmount($id_order);
        $captured = $this->getCaptureTransactionsAmount($id_order);
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            return max(0, min($order->total_paid, $order->total_paid - $captured - $captured_pending));
        } else {
            return max(0, min($order->total_paid, $order->total_paid - $order->total_paid_real - $captured_pending));
        }
    }

    public function getRefundTransactionsAmount($id_order)
    {
        $amount = 0;
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $order = new Order($id_order);
            $transactions = OgoneTransactionLog::getTransactionsByCartIdAndStatus($order->id_cart, array(
                DirectLink::STATUS_REFUND
            ));
        } else {
            $transactions = OgoneTransactionLog::getTransactionsByOrderIdAndStatus($id_order, array(
                DirectLink::STATUS_REFUND
            ));
        }

        foreach ($transactions as $transaction) {
            $response = $transaction['response'];
            if ($response && $response['AMOUNT'] && empty($response['NCERROR'])) {
                $amount += (float)$response['AMOUNT'];
            }
        }
        return $amount;
    }

    public function getPendingRefundTransactionsAmount($id_order)
    {
        $amount = 0;
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $order = new Order($id_order);
            $transactions = OgoneTransactionLog::getTransactionsByCartIdAndStatus($order->id_cart, array(
                DirectLink::STATUS_REFUND_PENDING
            ));
        } else {
            $transactions = OgoneTransactionLog::getTransactionsByOrderIdAndStatus($id_order, array(
                DirectLink::STATUS_REFUND_PENDING
            ));
        }
        foreach ($transactions as $transaction) {
            $response = $transaction['response'];
            if ($response && $response['AMOUNT'] && empty($response['NCERROR'])) {
                $amount += (float)$response['AMOUNT'];
            }
        }
        return $transactions ? max($amount - $this->getRefundTransactionsAmount($id_order), 0) : 0;
    }

    public function getRefundMaxAmount($id_order)
    {
        $order = new Order($id_order);
        $refunded = $this->getRefundTransactionsAmount($id_order);
        $refunded_pending = $this->getPendingRefundTransactionsAmount($id_order);
        $scheduled = $this->getScheduledRefundMaxAmount($id_order);
        $value = ($scheduled ? $scheduled : $order->total_paid_real);
        return max(0, min($value - $refunded - $refunded_pending, $value));
    }

    public function getScheduledRefundMaxAmount($id_order)
    {
        $amount = 0;
        if (version_compare(_PS_VERSION_, '1.5', 'lt')) {
            $order = new Order($id_order);
            $transactions = OgoneTransactionLog::getTransactionsByCartIdAndStatus($order->id_cart, array(
                DirectLink::STATUS_SCHEDULED_OK
            ));
        } else {
            $transactions = OgoneTransactionLog::getTransactionsByOrderIdAndStatus($id_order, array(
                DirectLink::STATUS_SCHEDULED_OK
            ));
        }

        $is_scheduled = false;
        $scheduled = 0;
        foreach ($transactions as $transaction) {
            if ((int)$transaction['response']['STATUS'] == DirectLink::STATUS_SCHEDULED_OK) {
                $amount = (float)$transaction['response']['AMOUNT'];
                $is_scheduled = true;
                $scheduled ++;
            }
        }
        if ($is_scheduled) {
            $order = new Order($id_order);
            $cart = new Cart($order->id_cart);
            $total = $cart->getOrderTotal();
            $schedules = $this->getScheduledPaymentVars($total);
            $amount = 0;
            for ($i = 1; $i <= $scheduled; $i ++) {
                $amount += round($schedules[sprintf('AMOUNT%d', $i)] / 100, 2);
            }
        }
        return $amount;
    }

    public function getShaOutVariablesFromGet()
    {
        $data = array_change_key_case($_GET, CASE_UPPER); // impossible to use Tools::getValue because exact case can vary
        return array_intersect_key($data, array_combine($this->sha_out_fields, $this->sha_out_fields));
    }

    public function setDLProcessingToken($id_cart)
    {
        $token = new OgoneTransactionLog();
        $token->id_cart = $id_cart;
        $token->response = 'PROCESSING_TOKEN';
        return $token->save();
    }

    public function issetDLProcessingToken($id_cart)
    {
        $query = 'SELECT * FROM `' . _DB_PREFIX_ . 'ogone_tl` WHERE id_cart = ' . (int)$id_cart . ' AND response="PROCESSING_TOKEN"';
        return count((array) Db::getInstance()->executeS($query));
    }

    public function deleteDLProcessingToken($id_cart)
    {
        $query = 'DELETE FROM `' . _DB_PREFIX_ . 'ogone_tl` WHERE id_cart = ' . (int)$id_cart . ' AND response="PROCESSING_TOKEN"';
        Db::getInstance()->execute($query);

        return Db::getInstance()->numRows();
    }

    public function getHTPPaymentMethodName($type)
    {
        switch (Tools::strtolower($type)) {
            case 'creditcard':
                return $this->l('Credit Card');
            case 'directdebits de':
                return $this->l('Direct Debits DE');
            case 'directdebits at':
                return $this->l('Direct Debits AT');
            case 'directdebits nl':
                return $this->l('Direct Debits NL');
            default:
                return '';
        }
    }

    public function verifyShaSignatureFromGet()
    {
        $ogone_params = array();
        $ignore_key_list = $this->getIgnoreKeyList();
        foreach ($_GET as $key => $value) {
            if (Tools::strtoupper($key) != 'SHASIGN' && $value != '' && !in_array($key, $ignore_key_list)) {
                $key = Tools::strtoupper($key);
                if (Tools::substr($key, 0, 5) == 'CARD_' || Tools::substr($key, 0, 6) == 'ALIAS_') {
                    $key = str_replace('_', '.', $key);
                }
                if (!in_array($key, $ignore_key_list)) {
                    $ogone_params[$key] = $value;
                }
            }
        }

        $sha_sign = $this->calculateShaSign($ogone_params, Configuration::get('OGONE_SHA_OUT'));
        return Tools::getValue('SHASign') && $sha_sign && Tools::getValue('SHASign') == $sha_sign;
    }

    public function getAliasReturnVariables()
    {
        $raw_data = $_GET; // cannot use Tools::getValue
        $raw_data = array_change_key_case($raw_data, CASE_UPPER);
        $data = array();
        $data['ALIAS'] = isset($raw_data['ALIAS_ALIASID']) ? $raw_data['ALIAS_ALIASID'] : null;
        $data['CARDNO'] = isset($raw_data['CARD_CARDNUMBER']) ? $raw_data['CARD_CARDNUMBER'] : null;
        $data['CN'] = isset($raw_data['CARD_CARDHOLDERNAME']) ? $raw_data['CARD_CARDHOLDERNAME'] : null;
        $data['ED'] = isset($raw_data['CARD_EXPIRYDATE']) ? $raw_data['CARD_EXPIRYDATE'] : null;
        $data['BRAND'] = isset($raw_data['CARD_BRAND']) ? $raw_data['CARD_BRAND'] : null;
        $data['NCERROR'] = isset($raw_data['ALIAS_NCERROR']) ? $raw_data['ALIAS_NCERROR'] : null;
        $data['STATUS'] = isset($raw_data['ALIAS_STATUS']) ? $raw_data['ALIAS_STATUS'] : null;
        if (isset($raw_data['ALIAS_STOREPERMANENTLY'])) {
            $data['STOREPERMANENTLY'] = $raw_data['ALIAS_STOREPERMANENTLY'];
        }
        $data['SHASIGN'] = isset($raw_data['SHASIGN']) ? $raw_data['SHASIGN'] : null;
        return $data;
    }

    public function isPS14x()
    {
        return version_compare(_PS_VERSION_, '1.5', 'lt');
    }

    public function isPS15x()
    {
        return  !$this->isPS14x() && version_compare(_PS_VERSION_, '1.6', 'lt');
    }

    public function isPS16x()
    {
        return  !$this->isPS15x() && version_compare(_PS_VERSION_, '1.7', 'lt');
    }

    public function isPS17x()
    {
        return version_compare(_PS_VERSION_, '1.7', 'ge');
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency((int)($cart->id_currency));
        $currencies_module = $this->getCurrency((int)$cart->id_currency);
        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }

    public function canUseSubscription()
    {
        return !$this->isPS14x() && Configuration::get('OGONE_USE_SUBSCRIPTION');
    }

    public function isSubscriptionCart($cart)
    {
        $cs = OgoneSubscription::getSubscriptionByCartId($cart->id);
        $ac = $this->getSubscriptionArticlesFromCart($cart);

        return $cs &&  count($ac) > 0 && (int)$ac[0]->id_product == (int)$cs['id_product'] && (int)$ac[0]->id_product_attribute == (int)$cs['id_product_attribute'];
    }

    public function getSubscriptionArticlesFromCart($cart)
    {
        $result = array();
        foreach ($cart->getProducts() as $product) {
            $product_subscription = OgoneProductSubscription::getSubscriptionInstanceForProduct($product['id_product'], $product['id_product_attribute']);
            if ($product_subscription) {
                $result[] = $product_subscription;
            }
        }
        return $result;
    }

    public function getPriceFormatter()
    {
        if ($this->priceFormatter === null) {
            $this->priceFormatter = new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter();
        }
        return $this->priceFormatter;
    }

    public function convertAndformatPrice($price, $currency)
    {
        if ($this->isPS17x()) {
            return $this->getPriceFormatter()->format($price, $currency);
        }
        return Tools::displayPrice((float)Tools::convertPrice($price, $currency));
    }

    public function formatPrice($price, $currency = null)
    {
        if ($this->isPS17x()) {
            return $this->getPriceFormatter()->format($price, $currency);
        }
        return Tools::displayPrice($price, $currency);
    }

    public function getCurrentSubscriptionReadableDetails($subscription, $amount)
    {
        $result = array();
        $product = new Product($subscription->id_product);
        $result['product_name'] = $product->name[$this->context->language->id];

        if ($subscription->id_product_attribute) {
            $result['product_name'] .= ' - ' . $this->getProductCombinationName($product, $subscription->id_product_attribute);
        }

        $cart = new Cart($subscription->id_cart);

        $result['start_date'] = $subscription->getStartDate('d/m/Y');
        $result['end_date'] = $subscription->getEndDate('d/m/Y');
        $result['has_started'] = $subscription->hasStarted();
        $result['has_ended'] = ($subscription->hasEnded() || !$subscription->active);

        $result['stop_link'] = !$subscription->hasEnded() ? $this->context->link->getModuleLink('ogone', 'subscriptions', array(
            'id_subscription' => $subscription->id
        )) : '';
        $result['stop_link'] = '';

        $result['installments'] = $subscription->installments;
        $result['period_number'] = $subscription->period_number;
        $result['period_unit'] = $subscription->period_unit;

        $result['period_moment'] = $subscription->getPeriodMoment();

        $period_names = $this->getPeriodNames($result['period_unit'], $result['period_moment']);

        $hr_period =  $this->getSubscriptionFrequencyFront($subscription->period_moment, $subscription->period_number, $subscription->period_unit);
        $result['hr_frequency'] = $hr_period['frequency'];
        $result['hr_billing'] = $hr_period['billing'];

        $result = $result + $period_names;
        $result['amount'] = $this->formatPrice($amount, new Currency($cart->id_currency));
        // $result['amount_formatted'] = $this->formatPrice($amount);

        // $priceFormatter->convertAndFormat($price - ($price * $row['reduction_with_tax']))
        $result['orders'] = array();

        foreach ($subscription->getInstallmentsInstances() as $so) {
            $order = new Order($so->id_order);
            $state = new OrderState($order->getCurrentState());
            $result['orders'][] = array(
                'link' => $this->context->link->getPageLink('order-detail', null, null, array(
                    'id_order' => $so->id_order
                )),
                'id_order' => $order->id,
                'amount' => $this->formatPrice($order->getTotalPaid(), new Currency($order->id_currency)),
                'reference' => $order->reference,
                'payid' => $so->payid,
                'date' => date('d/m/Y', strtotime($so->date_add)),
                'status' => $state->name[$this->context->language->id],
                'status_color' => $state->color
            );
        }

        return $result;
    }

    public function getPeriodNames($period_unit, $period_moment)
    {
        $result = array();

        switch ($period_unit) {
            case self::PERIOD_DAY:
                $result['period_unit_name'] = $this->l('day');
                $result['period_unit_name_plural'] = $this->l('days');
                $result['period_moment_name'] = '';
                break;
            case self::PERIOD_MONTH:
                $days = $this->getCardinalDays();
                $result['period_unit_name'] = $this->l('month');
                $result['period_unit_name_plural'] = $this->l('months');
                $result['period_moment_name'] = ($period_moment == 0 ? $this->l('The same day') : $days[$period_moment]); // @tddo make cardinal number + translation
                break;
            case self::PERIOD_WEEK:
                $weekdays = $this->getWeekdays();
                $result['period_unit_name'] = $this->l('week');
                $result['period_unit_name_plural'] = $this->l('weeks');
                $result['period_moment_name'] = ($period_moment == 0 ? $this->l('The same day') : $weekdays[$period_moment]);
                break;
        }

        return $result;
    }

    public function getFutureSubscriptionReadableDetails($subscription, $amount)
    {
        $result = array();
        $product = new Product($subscription->id_product);
        /*
         * if ($subscription->id_product_attribute) {
         * $combination = new Combination($subscription->id_product_attribute);
         *
         * }
         */

        $result['product_name'] = $product->name[$this->context->language->id];

        if ($subscription->id_product_attribute) {
            $result['product_name'] .=  ' - ' .  $this->getProductCombinationName($product, $subscription->id_product_attribute);
        }

        $result['id_product_attribute'] = $subscription->id_product_attribute;

        $result['id_product'] = $subscription->id_product;

        $result['start_date'] = $subscription->getStartDate('d/m/Y');
        $result['end_date'] = $subscription->getEndDate('d/m/Y');
        $result['installments'] = $subscription->installments;
        $result['period_number'] = $subscription->period_number;
        $result['period_unit'] = $subscription->period_unit;

        $result['period_moment'] = $subscription->getPeriodMoment();


        $hr_period =  $this->getSubscriptionFrequencyFront($subscription->period_moment, $subscription->period_number, $subscription->period_unit);
        $result['hr_frequency'] = $hr_period['frequency'];
        $result['hr_billing'] = $hr_period['billing'];


        $period_names = $this->getPeriodNames($result['period_unit'], $result['period_moment']);
        $result = $result + $period_names;

        $result['amount'] = $this->formatPrice($amount);

        return $result;
    }

    public function convertPrice($price)
    {
        return number_format((float)number_format($price, 2, '.', ''), 2, '.', '') * 100;
    }

    // @stub
    public function stopSubscription($subscription)
    {
        if ($subscription->hasEnded()) {
            throw new Exception('This subscription has ended');
        }
        if (!$subscription->active) {
            throw new Exception('This subscription is not active');
        }

        $subscription->active = false;
        if (!$subscription->update()) {
            throw new Exception('This subscription cannot be stopped');
        }
        $customer = new Customer($subscription->id_customer);
        $this->sendSubscriptionMail($subscription, 'subscription_end', $this->l('Your subscription will be deactivated'), $customer->email);
        $this->sendSubscriptionMail($subscription, 'subscription_end_admin', $this->l('Request for subscription deactivation'), Configuration::get('PS_SHOP_EMAIL'));

        return true;
    }

    public function sendSubscriptionMail($subscription, $template, $subject, $to)
    {
        $amount = $this->getSubscriptionTotal(new Cart($subscription->id_cart));

        $tpl_vars = array(
            'id_subscription' => $subscription->id,
            'subscription_data' => $this->getCurrentSubscriptionReadableDetails($subscription, $amount)
        );

        $this->context->smarty->assign($tpl_vars);

        $employee_exists = (isset(Context::getContext()->employee) && Validate::isLoadedObject(Context::getContext()->employee));

        if (!$employee_exists) {
            $this->setEmployee();
        }

        $templateVars = array(
            '{SUBSCRIPTION_ID}' => $subscription->id,
            '{SUBSCRIPTION_URL}' => $this->context->link->getModuleLink('ogone', 'subscriptions'),
            '{SUBSCRIPTION_URL_BO}' => $this->context->link->getAdminLink('AdminOgoneSubscriptions') . '&viewogone_subscription&&id_ogone_subscription=' . $subscription->id,
            '{SUBSCRIPTION_DESCRIPTION_HTML}' => $this->display(__FILE__, 'views/templates/front/subscription-mail-html.tpl'),
            '{SUBSCRIPTION_DESCRIPTION_TXT}' => $this->display(__FILE__, 'views/templates/front/subscription-mail-txt.tpl')
        );
        $this->log(sprintf('sending mail %s to %s', $template, $to));

        if (!$employee_exists) {
            Context::getContext()->employee = null;
        }


        return Mail::Send($this->context->language->id, $template, $subject, $templateVars, $to, null, null, null, null, null, dirname(__FILE__) . '/mails/');
    }

    public function isSubscription($id_cart)
    {
        return (bool)OgoneSubscription::getSubscriptionByCartId($id_cart);
    }

    public function handleSubscription($id_initial_cart, $ogone_params)
    {
        $this->log('handleSubscription');

        $subscription = OgoneSubscription::getSubscriptionInstanceByCartId($id_initial_cart);

        if (!$subscription) {
            $this->log('Subscription cannot be loaded');
            throw new Exception('Subscription cannot be loaded');
        }
        if (!$subscription->active) {
            $this->log('Subscription is not active');
            throw new Exception('Subscription is not active');
        }

        $ogone_return_code = (int)$ogone_params['STATUS'];
        $this->log('ogone_return_code : ' . $ogone_return_code);
        $initial_id_order = (int)Order::getOrderByCartId($id_initial_cart);
        $this->log('initial_id_order : ' . $initial_id_order);
        $this->log('NS: ' . $this->isNextSubscriptionOk($subscription, $ogone_return_code));
        // if ok, create new order
        if ($this->subscriptionInstallmentExists($subscription, $ogone_params)) {
            $this->logAndDie(sprintf('Subscription exists for payid %s', $ogone_params['PAYID']));
        } else if ($initial_id_order && $this->isNextSubscriptionOk($subscription, $ogone_return_code)) {
            $this->log('INSTALLMENT');
            $new_cart = $this->cloneCart($subscription);
            $customer = new Customer($new_cart->id_customer);

            if ($new_cart && Validate::isLoadedObject($new_cart)) {
                if ($this->validateSubscriptionOrder($subscription, $new_cart, $ogone_params)) {
                    $this->sendSubscriptionMail($subscription, 'subscription_installment', $this->l('Your subscription'), $customer->email);
                }
            }
        } elseif (!$initial_id_order && isset($ogone_params['CREATION_STATUS']) && $ogone_params['CREATION_STATUS'] == 'OK') {
            $this->log('START');
            $cart = new Cart($id_initial_cart);
            $customer = new Customer($cart->id_customer);
            $result = $this->validateSubscriptionOrder($subscription, $cart, $ogone_params);
            $this->log("VS RESULT " . $result);
            if ($result) {
                $this->sendSubscriptionMail($subscription, 'subscription_start', $this->l('Your subscription starts'), $customer->email);
            }
        } // if not, error
    }

    public function subscriptionInstallmentExists($subscription, $ogone_params)
    {
        $payid = $ogone_params['PAYID'];
        $transactions = OgoneTransactionLog::getAllByPayId($payid);
        return count($transactions) > 0;
    }

    public function isNextSubscriptionOk(OgoneSubscription $subscription, $ogone_return_code)
    {
        return $this->isValidSubscriptionReturnCode($ogone_return_code) && $subscription->isInTrain();
    }

    public function isValidSubscriptionReturnCode($ogone_return_code)
    {
        return $ogone_return_code == 9;
    }

    public function cloneCart($subscription)
    {
        $this->log('Cloning order');
        $cart = new Cart($subscription->id_cart);
        $new_cart = null;
        try {
            $result = $cart->duplicate();

            if ($result['success']) {
                $new_cart = $result['cart'];
                foreach ($new_cart->getProducts() as $product) {
                    if (!((int)$product['id_product'] == (int)$subscription->id_product && (int)$product['id_product_attribute'] == (int)$subscription->id_product_attribute)) {
                        $new_cart->deleteProduct($product['id_product'], $product['id_product_attribute']);
                    }
                }

                foreach ($new_cart->getCartRules() as $rule) {
                    if ($this->removeRule($subscription, $cart, $new_cart, $rule)) {
                        $new_cart->removeCartRule($rule['id_cart_rule']);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->logAndDie($ex->getMessage());
        }

        if ($new_cart) {
            return $new_cart;
        }
        return null;
    }

    /*
     * Returns true if we can remove rule from cart creating another instance
     * By default we are removing every rule
     */
    protected function removeRule($subscription, $old_cart, $new_cart, $rule)
    {
        return true;
    }

    public function validateSubscriptionOrder($subscription, $cart, $ogone_params)
    {
        $ogone_return_code = (int)$ogone_params['STATUS'];
        $ogone_state = $this->getCodePaymentStatus($ogone_return_code);
        // $ogone_state_description = $this->getCodeDescription($ogone_return_code);
        $payment_state_id = $this->getPaymentStatusId($ogone_state);

        if ($ogone_return_code == 9) {
            $payment_state_id = $this->getPaymentStatusId(self::SUBSCRIPTION_PAYMENT_IN_PROGRESS);
        }

        $amount_paid = (float)$ogone_params['AMOUNT'];

        $customer = new Customer($cart->id_customer);
        $secure_key = $customer->secure_key;

        $message = sprintf('%s %s %s', $cart->id, Tools::safeOutput($ogone_state), Tools::jsonEncode($ogone_params));

        $this->log($message);
        $this->log('Validating subscription order, state ' . $payment_state_id);
        $result = $this->validate($cart->id, $payment_state_id, $amount_paid, $message, Tools::safeOutput($secure_key));

        $this->log('Order subscription validate result ' . ($result ? 'OK' : 'FAIL'));

        if ($this->currentOrder) {
            $this->addTransactionLog($cart->id, $this->currentOrder, $cart->id_customer, $ogone_params);
            $this->createSubscriptionOrder($subscription, new Order($this->currentOrder), $ogone_params['PAYID'], $ogone_params['STATUS']);
            $subscription->payid = $ogone_params['PAYID'];
            $subscription->update();
            $this->addMessage($this->currentOrder, $this->l('Subscription installment') . ' : ' . $message);
        } else {
            $this->addTransactionLog($cart->id, 0, $cart->id_customer, $ogone_params);
        }
        return $result;
    }

    public function createSubscriptionOrder($subscription, $order, $payid, $status)
    {
        $this->log('createSubscriptionOrder ' . $subscription->id . ' ' . $order->id);
        $so = new OgoneOrderSubscription();
        $so->id_subscription = $subscription->id;
        $so->id_order = $order->id;
        $so->id_cart = $order->id_cart;
        $so->id_customer = $order->id_customer;
        $so->payid = $payid;
        $so->status = $status;
        return $so->save();
    }

    public function getParamsListAsHtml($params)
    {
        $result = array();
        foreach ($params as $k => $v) {
            $result[] = sprintf('<strong>%s</strong> : %s', $k, $v);
        }
        return implode('<br />', $result);
    }

    public function getParamsListAsJson($params)
    {
        $result = array();
        foreach ($params as $k => $v) {
            $result[] = sprintf('<strong>%s</strong> : %s', $k, $v);
        }
        return implode('<br />', $result);
    }

    public function listMissingReturnArgs()
    {
        $result = array();
        foreach ($this->getNeededKeyList() as $k) {
            if (!Tools::getIsset($k)) {
                $result[] = Tools::strtoupper($k);
            }
        }
        return $result;
    }

    public function verifyReturnArgs()
    {
        return count($this->listMissingReturnArgs()) == 0;
    }

    public function getOgoneParams($source)
    {
        $ogone_params = array();
        $ignore_key_list = $this->getIgnoreKeyList();
        foreach ($source as $key => $value) {
            if (Tools::strtoupper($key) != 'SHASIGN' && $value != '' && !in_array($key, $ignore_key_list)) {
                $ogone_params[Tools::strtoupper($key)] = $value;
            }
        }
        return $ogone_params;
    }

    public function addPayment($order, $amount_paid, $ogone_params)
    {
        $this->log(sprintf('addPayment(%s %s %s)', $order->id, $amount_paid, Tools::jsonEncode($ogone_params)));
        $payment = new OrderPayment();
        $payment->order_reference = $order->reference;
        $payment->amount = $amount_paid;
        $payment->id_currency = $order->id_currency;
        $payment->payment_method = $this->displayName;
        $payment->transaction_id =  isset($ogone_params['PAYID']) ? $ogone_params['PAYID'] :  '';
        $payment->card_number =  isset($ogone_params['CARDNO']) ? $ogone_params['CARDNO'] :  '';
        $payment->card_brand =  isset($ogone_params['BRAND']) ? $ogone_params['BRAND'] :  '';
        $payment->card_expiration =  isset($ogone_params['ED']) ? $ogone_params['ED'] :  '';
        $payment->card_holder =  isset($ogone_params['CN']) ? $ogone_params['CN'] :  '';
        return $payment->save();
    }

    public function addHistory($id_order, $new_order_state, $use_existing_payment)
    {
        $this->log(sprintf('addHistory(%s %s %s)', $id_order, $new_order_state, $use_existing_payment));
        $history = new OrderHistory();
        $history->id_order = (int) $id_order;
        $history->changeIdOrderState($new_order_state, (int)$id_order, $use_existing_payment);
        return $history->addWithemail(true, array());
    }

    public function logAndDie($message)
    {
        $this->log($message);
        die($message);
    }
}
