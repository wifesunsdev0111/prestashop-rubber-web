<?php
/**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author    Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*/

if (!defined('_PS_VERSION_'))
    exit;

abstract class opc_OptionType
{
    const RadioBox   = 0;
    const InputField = 1;
    const TextField  = 2;
}

class opc_Option
{

    /**
     * @var opc_OptionType $optionType
     */
    public $optionType;
    /**
     * @var string $title
     */
    public $title;
    /**
     * @var string $description
     */
    public $description;

    public function __construct($optionType, $title, $description)
    {
        $this->optionType  = $optionType;
        $this->title       = $title;
        $this->description = $description;
    }

}


class OnePageCheckout extends Module
{

    /**
     * @var array $module_settings   An array of settings provided on configuration page
     */
    public $conf_prefix = "opc_";
    private $module_settings;
    private $need_override_instructions = false;
    private $need_change_options = false;
    private $need_patch_instructions = false;

    public function __construct()
    {
        $this->name       = 'onepagecheckout';
        $this->tab        = 'checkout';
        $this->version    = '2.3.9';
        $this->author     = 'Zelarg';
        $this->module_key = "38254238bedae1ccc492a65148109fdd";

        $this->need_instance = 1;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.7'); 
        $this->bootstrap = false;


        parent::__construct(); // The parent construct is required for translations

        $this->page        = basename(__FILE__, '.php');
        $this->displayName = $this->l('One Page Checkout for Prestashop');
        $this->description = $this->l('Powerful and intuitive checkout process.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->_setOptions();

        // check whether required options are set properly in PS
//        $need_options = Configuration::getMultiple(array('PS_FORCE_SMARTY_2'));
//        if ($need_options['PS_FORCE_SMARTY_2'] == 1) {
//            $this->warning             = $this->l('Some Prestashop preferences need to be changed, click for more info.') . " ";
//            $this->need_change_options = true;
//        }

        // check whether override controllers and classes were copied properly
        if (
            !$this->isPatched("override/controllers/front/ParentOrderController.php", "/isOpcModuleActive/") ||
            !$this->isPatched("override/controllers/front/AddressController.php", "/isOpcModuleActive/") ||
            !$this->isPatched("override/classes/Address.php", "/isDifferent/") ||
            !$this->isPatched("override/classes/Cart.php", "/resetCartDiscountCache/") ||
            !$this->isPatched("override/classes/Customer.php", "/isOpcModuleActive/")
        ) {
            $this->warning                    = $this->l('Incomplete installation, overrides are not correct, please reinstall module!') . " ";
            $this->need_override_instructions = true;
        }

// Uz to nie je potrebne, prislusna rutina je rovno v OPC overridoch
//        if (!$this->isPatched("controllers/front/AddressController.php", "/false && \\\$address_old-\>isUsed\(\)/")) {
//            $this->warning                 = $this->l('Please patch controller/AddressController.php as instructed in UserGuide.') . " ";
//            $this->need_patch_instructions = true;
//        }

    }

    /**
     *
     * @param string $filename
     * @param string $pattern Rexexp pattern to be searched for in a file.
     * @return bool
     */
    public function isPatched($filename, $pattern)
    {
        $file   = _PS_ROOT_DIR_ . "/" . $filename;
        $result = false;
        if (file_exists($file)) {
            $file_content = Tools::file_get_contents($file);
            $result       = (preg_match($pattern, $file_content) > 0);
        }
        return $result;
    }

    /* overload */
    public function l($string, $specific = false) {
        if (!Tools::getIsset('notrans'))
            return parent::l($string);
        else
            return $string;
    }

    public function _setOptions()
    {
        // key=option_name, value=option_type, option_display_name, option_description
        $this->module_settings = array(
            "general"          => array(
                "two_column_opc"             => new opc_Option(opc_OptionType::RadioBox,   $this->l('Two column checkout'), $this->l('Displays checkout form in 2 columns. For best results, please') ." <a onclick='setTwoColumnOptions($(this))' class='highlight_anchor'>".$this->l('click here')."</a> ". $this->l('to set also these options: sticky header cart-off, cart summary at bottom-on, offer password on top-on, remove ref.-on')),
                "three_column_opc"           => new opc_Option(opc_OptionType::RadioBox,   $this->l('Three column checkout'), $this->l('Displays checkout form in 3 columns - address, shipping, payment and summary below. Useful when very little shipping / payment options ara available. For best results, please')." <a onclick='setThreeColumnOptions($(this))' class='highlight_anchor'>".$this->l('click here')."</a> ".$this->l('to set also these options: animate fields padding-off, sticky header cart-off, cart summary at bottom-on, offer password on top-on, remove ref.-on')),
                "use_custom_styling"         => new opc_Option(opc_OptionType::RadioBox,   $this->l('Use custom styling'), $this->l('If turned on, OPC module\'s custom styling - regardless of your theme\'s styles. Turn off to use your theme\'s styling.')),
                "scroll_cart"                => new opc_Option(opc_OptionType::RadioBox,   $this->l('Sticky cart block'), $this->l('Keep cart block sticky when scrolling down on checkout page.')),
                "scroll_header_cart"         => new opc_Option(opc_OptionType::RadioBox,   $this->l('Sticky header cart'), $this->l('Keep header cart (e.g. ps1.5 default theme) sticky when scrolling down on checkout page.')),
                "scroll_summary"             => new opc_Option(opc_OptionType::RadioBox,   $this->l('Sticky cart summary'), $this->l('Keep cart summary sticky when scrolling down on checkout page. CSS style \'floating-summary\' is applied where additional fine-tuning of floating box can be made.')),
                "scroll_products"            => new opc_Option(opc_OptionType::RadioBox,   $this->l('Sticky cart products'), $this->l('Make also products in cart summary floating. Sticky cart summary option above must be turned on.')),
                "sample_values"              => new opc_Option(opc_OptionType::RadioBox,   $this->l('Sample values'), $this->l('Display sample values next to checkout form fields. You may want to change values (texts) in BO-Tools-Translations-Front Office, section order-carrier. Also styles \'i.ex_focus\' and \'i.ex_blur\' in global.css should be created.')),
                "sample_to_placeholder"      => new opc_Option(opc_OptionType::RadioBox,   $this->l('Samples in field'), $this->l('Display sample values directly in form field using HTML5 placeholder.')),
                "compact_form"               => new opc_Option(opc_OptionType::RadioBox,   $this->l('Compact form'), $this->l('Makes your checkout form more compact by removing redundant labels and captions.')),
                "remove_ref"                 => new opc_Option(opc_OptionType::RadioBox,   $this->l('Remove Ref. field'), $this->l('Removes Ref. field from cart-summary, to make more room for product name.')),
                "inline_validation"          => new opc_Option(opc_OptionType::RadioBox,   $this->l('Inline validation'), $this->l('Perform formal inline validation on checkout fields.')),
                "validation_checkboxes"      => new opc_Option(opc_OptionType::RadioBox,   $this->l('Validation checkboxes'), $this->l('In addition to validation, display green tick or red exclamation mark next to field.')),
                "animate_fields_padding"     => new opc_Option(opc_OptionType::RadioBox,   $this->l('Animate fields padding'), $this->l('Should spaces between address fields squeeze when invoice address is expanded?')),
                "page_fading"                => new opc_Option(opc_OptionType::RadioBox,   $this->l('Page fading'), $this->l('Visual effect after visiting checkout form - page elements, except center column and blockcart will be fade out a bit, see two more settings below.')),
                "fading_duration"            => new opc_Option(opc_OptionType::InputField, $this->l('Fading duration'), $this->l('How long should page fadeOut effect take? It\'s set in miliseconds, low values (<500) mean very quick fadeOut, above 3000ms it fades out gradually.')),
                "fading_opacity"             => new opc_Option(opc_OptionType::InputField, $this->l('Fading opacity'), $this->l('Target fading opacity in a range 0-100%, 0-invisible, 100-totally visible.')),
                "display_info_block"         => new opc_Option(opc_OptionType::RadioBox,   $this->l('Display info block'), $this->l('Displays info block below cart block on checkout page. For customization, please see file /modules/onepagecheckout/views/templates/fron/info-block-content.tpl')),
                //"ship2pay"                   => new Option(OptionType::RadioBox,   $this->l('Ship2pay module support'), $this->l('Support for ship2pay module. For more instructions how to set it up, please see'). ' <a href='.__PS_BASE_URI__.'modules/onepagecheckout/Installation_and_Setup.pdf" class="highlight_anchor" target="_blank">Installation_and_Setup document</a>'),
                "hide_carrier"               => new opc_Option(opc_OptionType::RadioBox,   $this->l('Hide carrier selection'), $this->l('Hide block with carrier selection, if there is only one carrier for selected country.')),
                "hide_payment"               => new opc_Option(opc_OptionType::RadioBox,   $this->l('Hide payment selection'), $this->l('Hide block with payment selection, if there is only one payment for selected country / carrier (if ship2pay installed) AND only if \'Payment options on same page\' is also enabled.')),
                "override_checkout_btn"      => new opc_Option(opc_OptionType::RadioBox,   $this->l('Override checkout button'), $this->l('Override checkout button when being on checkout page. When overriden, default \'page reload\' is replaced by fast scroll down to payment methods and blink of payment methods to gently notify customer.')),
                "email_verify"               => new opc_Option(opc_OptionType::RadioBox,   $this->l('Email verify box'), $this->l('Displays additional email input field, so that customer enters email twice when \'registering\' on OPC page.')),
                "live_zip"                   => new opc_Option(opc_OptionType::RadioBox,   $this->l('Live ZIP code'), $this->l('Refresh shipping methods / prices when ZIP code changes. Necessary for ZIP based shipping modules.')),
                "live_city"                  => new opc_Option(opc_OptionType::RadioBox,   $this->l('Live City field'), $this->l('Refresh shipping methods / prices when City field changes. Necessary for City based shipping modules (e.g. Russian SPSRCarrier).')),
                "cart_summary_bottom"        => new opc_Option(opc_OptionType::RadioBox,   $this->l('Cart Summary at bottom'), $this->l('Must have for German e-shops to comply with new regulations from 1.8.2012')),
                "above_confirmation_message" => new opc_Option(opc_OptionType::RadioBox,   $this->l('Message above Confirm button'), $this->l('Display message (e.g. EU regulations / taxes) just above Confirmation button. Please translate \'above confirmation button msg\' in BO / Tools / Translations / Translations of installed modules')),
                "order_detail_review"        => new opc_Option(opc_OptionType::RadioBox,   $this->l('Summary review box'), $this->l('Display box with Shipping / Invoice address / Carrier / Payment review, above confirmation button.')),
                "goods_return_cms"           => new opc_Option(opc_OptionType::InputField, $this->l('Goods return CMS ID'), $this->l('Display message \'You are entitled to cancel your order within 7 Working Days upon goods receive.\' (translatable) with link to CMS for more details. Set to 0 to disable.')),
                "move_cgv"                   => new opc_Option(opc_OptionType::RadioBox,   $this->l('Move Terms & Conditions'), $this->l('Moves Terms & Conditions checkbox down from carrier section, above \'I confirm my order\' button.')),
                "move_message"               => new opc_Option(opc_OptionType::RadioBox,   $this->l('Move Order Message box'), $this->l('Moves Order Message box down from carrier section, above \'I confirm my order\' button.')),
                "responsive_layout"          => new opc_Option(opc_OptionType::RadioBox,   $this->l('Responsive Layout'), $this->l('Responsive cart-summary table layout - NB: you need to have responsive theme to use this feature.')),
                "company_based_vat"          => new opc_Option(opc_OptionType::RadioBox,   $this->l('Company based VAT'), $this->l('Force EU VAT field to behave like in standard PS, i.e. when company is filled in, it\'ll show up, regardless of country chosen.')),
                //"info_block_content" => new Option(OptionType::TextField, "Info block content", "HTML content displayed in info block."),
            ),
            "customer"         => array(
                "offer_password_top"       => new opc_Option(opc_OptionType::RadioBox, $this->l('Offer password on Top'), $this->l('Display \'Create an account...\' checkbox and password field on top of the checkout for. Otherwise, it\'ll be displayed in the bottom part, above confirm button.')),
                "display_password_msg"     => new opc_Option(opc_OptionType::RadioBox, $this->l('Display create account message'), $this->l('Display \'Create an account and enjoy benefits of registered customers\' message above password box (applicable only when guest checkout is turned OFF in PS preferences)')),
                "password_checked"         => new opc_Option(opc_OptionType::RadioBox, $this->l('Create account checked'), $this->l('Checkbox \'Create an account...\' will be checked by default.')),
                "hide_password_box"        => new opc_Option(opc_OptionType::RadioBox, $this->l('Hide password box'), $this->l('The \'Create an account...\' checkbox and password field won\'t be displayed at all.')),
                "create_customer_password" => new opc_Option(opc_OptionType::RadioBox, $this->l('Create customer password'), $this->l('Create & Send password behind the scenes if customer checks-out for the first time. Password box is hidden, so it seems like guest checkout, but creates account. Guest accounts must be turned off in Preferences / Orders!')),
                "gender"                   => new opc_Option(opc_OptionType::RadioBox, $this->l('Gender'), $this->l('Display radio buttons with gender selection.')),
                "birthday"                 => new opc_Option(opc_OptionType::RadioBox, $this->l('Birthday'), $this->l('Display dropdowns for birthday.')),
                "newsletter"               => new opc_Option(opc_OptionType::RadioBox, $this->l('Newsletter'), $this->l('Display \'Sign up for newsletter.\' checkbox in checkout form.')),
                "newsletter_checked"       => new opc_Option(opc_OptionType::RadioBox, $this->l('Newsletter checked'), $this->l('Checkbox \'Sign up for newsletter.\' will be checked by default.')),
                "special_offers"           => new opc_Option(opc_OptionType::RadioBox, $this->l('Special offers'), $this->l('Display \'Sign up for special offers...\' checkbox in checkout form.')),
                "special_offers_checked"   => new opc_Option(opc_OptionType::RadioBox, $this->l('Special offers checked'), $this->l('Checkbox \'Sign up for special offers...\' will be checked by default.')),
                "order_msg"                => new opc_Option(opc_OptionType::RadioBox, $this->l('Order message'), $this->l('Display textbox \'leave us comment about your order\'.')),
            ),
            "delivery_address" => array(
                "company_delivery"         => new opc_Option(opc_OptionType::RadioBox,  $this->l('Company'), $this->l('Display field \'Company\' in delivery address.')),
                "address2_delivery"        => new opc_Option(opc_OptionType::RadioBox,  $this->l('Address (2)'), $this->l('Display field \'Address (2)\' in delivery address.')),
                "country_delivery"         => new opc_Option(opc_OptionType::RadioBox,  $this->l('Country'), $this->l('Display field \'Country\' in delivery address.')),
                "phone_mobile_delivery"    => new opc_Option(opc_OptionType::RadioBox,  $this->l('Mobile Phone'), $this->l('Display field \'Mobile phone\' in delivery address. Applicable only when \'Phone number\' in Preferences / Customers is turned off.')),
                "phone_delivery"           => new opc_Option(opc_OptionType::RadioBox,  $this->l('Home Phone'), $this->l('Display field \'Home phone\' in delivery address.')),
                "additional_info_delivery" => new opc_Option(opc_OptionType::RadioBox,  $this->l('Additional Info'), $this->l('Display field \'Additional Information\' in delivery address.')),
                "check_number_in_address"  => new opc_Option(opc_OptionType::RadioBox,  $this->l('Check number in address'), $this->l('Check for number in address1 field and display message to customer if they forget to add it.')),
                "capitalize_fields"        => new opc_Option(opc_OptionType::TextField, $this->l('Capitalize fields as typed'), $this->l('Capitalize following fields as customer types in. E.g.: #postcode, #postcode_invoice, #lastname, #lastname_invoice')),
                "virtual_no_delivery"      => new opc_Option(opc_OptionType::RadioBox,  $this->l('Virtual goods - no delivery address'), $this->l('Hide all fields in delivery address when only downloadable products are in cart.').' <strong>'.$this->l('Please read'). ' <a href="'.__PS_BASE_URI__.'modules/onepagecheckout/Installation_and_Setup.pdf" class="highlight_anchor" target="_blank">Installation_and_Setup document</a>'. $this->l('for additional changes required when this option is turned on!').'</strong>'),
            ),
            "invoice_address"  => array(
                "invoice_checkbox"        => new opc_Option(opc_OptionType::RadioBox, $this->l('Offer invoice address'), $this->l('Display checkbox \'Please use another address for invoice\'.')),
                "company_invoice"         => new opc_Option(opc_OptionType::RadioBox, $this->l('Company'), $this->l('Display field \'Company\' in invoice address.')),
                "address2_invoice"        => new opc_Option(opc_OptionType::RadioBox, $this->l('Address (2)'), $this->l('Display field \'Address (2)\' in invoice address.')),
                "country_invoice"         => new opc_Option(opc_OptionType::RadioBox, $this->l('Country'), $this->l('Display field \'Country\' in invoice address.')),
                "phone_mobile_invoice"    => new opc_Option(opc_OptionType::RadioBox, $this->l('Mobile Phone'), $this->l('Display field \'Mobile phone\' in invoice address. Applicable only when \'Phone number\' in Preferences / Customers is turned off.')),
                "phone_invoice"           => new opc_Option(opc_OptionType::RadioBox, $this->l('Home Phone'), $this->l('Display field \'Home phone\' in invoice address.')),
                "additional_info_invoice" => new opc_Option(opc_OptionType::RadioBox, $this->l('Additional Info'), $this->l('Display field \'Additional Information\' in invoice address.')),
            ),
            "system"           => array(
               // "invoice_first"           => new Option(OptionType::RadioBox, $this->l('Invoice address first (experimental!)'), $this->l('Invoice address will be at the top and will be required. Delivery address will be optional, expandable below it. This setup is used mostly in US stores or flower stores generally.')),
                "default_ps_carriers"     => new opc_Option(opc_OptionType::RadioBox,   $this->l('Default PS carriers view (experimental!)'), $this->l('Table based and \'delivery_option\' named carrier selection mode. It\'s here for compatibility with certain shipping modules, e.g. Paczkomaty, SoCollissimo, ...')),
                "payment_customer_id"     => new opc_Option(opc_OptionType::InputField, $this->l('Simulated customer id'), $this->l('Customer ID \'template\' for initial payment methods display with proper group restrictions.'). ' <br /><a id=edit_sim_cust href=index.php?tab=AdminCustomers&addcustomer&id_customer='. Configuration::get(Tools::strtoupper($this->conf_prefix . 'payment_customer_id')) . '&token=' . Tools::getAdminToken('AdminCustomers' . (int)(Tab::getIdFromClassName('AdminCustomers')) . ((isset($this->context->cookie)) ? (int)($this->context->cookie->id_employee) : 0)) . '>'.$this->l('Click here to edit default group for this customer.').' </a> '),
                "before_info_element"     => new opc_Option(opc_OptionType::InputField, $this->l('Before InfoBlock element'), $this->l('Element after which infoblock should be displayed - use this as an alternative if you don\'t have standard blockcart in left or right column. By default, value is \'#cart_block\' and info block displays right under the cart. With PS 1.5 default template (and similar), use value \'#cart_block .block_content\' (applicable with scroll header cart option).')),
                "update_payments_relay"   => new opc_Option(opc_OptionType::RadioBox,   $this->l('Update payments after account save'), $this->l('This options is required only for relay-style payment modules, or generally any payment module handling with http_cookie, like Moneybookers, ePay, Payson or Dibs. If you use such module and use relay mode, turn this option ON.')),
                "online_country_id"       => new opc_Option(opc_OptionType::InputField, $this->l('Online country id'), $this->l('ID of country set to be as Online delivery country for virtual items.')),
                "payment_radio_buttons"   => new opc_Option(opc_OptionType::RadioBox,   $this->l('Payment options as radio buttons'), $this->l('Display payment options as radio buttons on checkout page. If turned off, payment options will be displayed in blocks (default in PS). For most payment modules radio buttons work better and rarely it needs to be turned off.')),
                "cookie_cache"            => new opc_Option(opc_OptionType::RadioBox,   $this->l('OPC form cookie cache'), $this->l('Use cookie saving / restoring of fields when leaving OPC form, even when customer did not confirmed the form.')),
                "save_account_overlay"    => new opc_Option(opc_OptionType::RadioBox,   $this->l('Save account overlay'), $this->l('Displays overlay on payment methods, thus requiring customer to click \'Save account\' prior to proceeding with payment.')),
                "paypal_express_fallback" => new opc_Option(opc_OptionType::RadioBox,   $this->l('Paypal express fallback'), $this->l('Turn this on if you\'re using Paypal Express button as checkout option.')),
                "hidden_fields"           => new opc_Option(opc_OptionType::TextField,  $this->l('Hidden fields (experimental!)'), $this->l('Enter IDs of fields to be hidden on checkout form')),
                "mobile_fallback"         => new opc_Option(opc_OptionType::RadioBox,   $this->l('Mobile device fallback'), $this->l('Turn off OPC module on mobile devices (use default checkout from theme) - useful if you have special customized mobile checkout in your theme.'))
            )
        );
    }

    public function _getAllOptionsValues()
    {
        $config_keys = array();
        foreach ($this->module_settings as $options_group) {
            foreach ($options_group as $option_name => $option) {
                $config_keys[] = Tools::strtoupper($this->conf_prefix . $option_name);
            }
        }
        $db_values     = Configuration::getMultiple($config_keys);
        $prefix_length = Tools::strlen($this->conf_prefix);
        $config        = array();
        $db_keys       = array_keys($db_values);
        foreach ($config_keys as $config_key) {
            $value                                                   = (in_array($config_key, $db_keys)) ? $db_values[$config_key] : 0;
            $config[Tools::strtolower(Tools::substr($config_key, $prefix_length))] = $value;
        }

        return $config;
    }

    private function _setSimulatedCustomer()
    {

        $simulatedCustomer            = new Customer();
        $simulatedCustomer->lastname  = 'OPC';
        $simulatedCustomer->firstname = 'Module';
        $simulatedCustomer->passwd    = Tools::encrypt('opcpasswd');
        $simulatedCustomer->email     = 'no-customer@prestashop.com';
        $simulatedCustomer->enabled   = 0;
        $simulatedCustomer->deleted   = 1;

        $simulatedCustomer->add();
        return $simulatedCustomer->id;
    }

    private static function createMultiLangField($field)
    {
        $languages = Language::getLanguages(false);
        $res       = array();
        foreach ($languages AS $lang)
            $res[$lang['id_lang']] = $field;
        return $res;
    }


    private function setOnlineCountryPayments($online_country_id)
    {
        // Add this new country to be available for payment modules
        $return = Db::getInstance()->Execute('
                INSERT INTO `' . _DB_PREFIX_ . 'module_country` (id_module, id_country)
                SELECT distinct(id_module), ' . (int)$online_country_id . ' FROM `' . _DB_PREFIX_ . 'module_country`');
    }

    private function setOnlineCountryAddressFormat($online_country_id)
    {
        $tmp_addr_format = new AddressFormat($online_country_id);

        $save_status = false;

        $is_new = is_null($tmp_addr_format->id_country);
        if ($is_new) {
            $tmp_addr_format             = new AddressFormat();
            $tmp_addr_format->id_country = $online_country_id;
        }

        $tmp_addr_format->format = "Country:name\nCustomer:email\nphone";

        $save_status = ($is_new) ? $tmp_addr_format->save() : $tmp_addr_format->update();
        // we don't rely on result, so we won't return it at all
    }


    private function _setOnlineCountry()
    {

        $online_country_iso = "ONL";
        $online_country_id  = Country::getByIso($online_country_iso);

        if ($online_country_id < 1) {

            $country                             = new Country();
            $country->active                     = 0; // TODO: must be enabled later on
            $country->name                       = self::createMultiLangField("Online");
            $country->id_zone                    = 0; // Default zone for country to create
            $country->iso_code                   = $online_country_iso; // Default iso for country to create
            $country->contains_states            = 0; // Default value for country to create
            $country->id_currency                = 0; // 0=default store currency
            $country->need_identification_number = 0;

            $country->add();
            $online_country_id = $country->id;
            $this->setOnlineCountryPayments($online_country_id);
            $this->setOnlineCountryAddressFormat($online_country_id);
        }
        return $online_country_id;
    }

    private function _copyTranslations()
    {
        $translation_files = array(
            'order-carrier.tpl',
            'order-opc-new-account.tpl',
            'order-opc.tpl',
            'order-payment.tpl',
            'payment-methods.tpl',
            'shopping-cart.tpl'
        );

        $orig_lang = $this->context->cookie->id_lang;
        $mod       = 'onepagecheckout';

        foreach (Language::getLanguages() as $curr_lang) // get all active languages
        {
            if ($curr_lang["active"] == 0) continue;
            //echo "\n\n<hr /> Processing lang " . $curr_lang["name"] . "\n\n";
            $this->context->cookie->id_lang = $curr_lang["id_lang"];
            Tools::setCookieLanguage();

            $_LANG        = array();
            $ps_lang_file = _PS_THEME_DIR_ . 'lang/' . $curr_lang["iso_code"] . ".php";
            if (file_exists($ps_lang_file))
                include($ps_lang_file);
            // translations are now prepared in $_LANG

            $mod_lang_file = _PS_MODULE_DIR_ . $mod . '/translations/' . $curr_lang["iso_code"] . ".php";

            if (file_exists($mod_lang_file))
                include($mod_lang_file);
            else
                $_MODULE = array();
            // $_MODULE is now set

            // read all translation keys with mod='$mod'
            $str_write = "<?php\n\nglobal \$_MODULE;\n\$_MODULE = array();\n";


            foreach ($translation_files as $filename) {
                $content = @Tools::file_get_contents(_PS_MODULE_DIR_ . $mod . '/views/templates/front/' . $filename);
                preg_match_all("/\{l s='(.+?)' mod='$mod'/", $content, $matches);
                foreach ($matches[1] as $string) {
                    $key     = Tools::substr(basename($filename), 0, -4) . '_' . md5($string);
                    $ps_val  = isset($_LANG[$key]) ? $_LANG[$key] : "";
                    $opc_val = isset($_MODULE['<{' . $mod . '}prestashop>' . $key]) ? $_MODULE['<{' . $mod . '}prestashop>' . $key] : "";

                    if (trim($opc_val) == "" && trim($ps_val) != "") {
                        $_MODULE['<{' . $mod . '}prestashop>' . $key] = $ps_val;
                    }
                }

            }

            foreach ($_MODULE as $key => $value) {
                $str_write .= '$_MODULE[\'' . $key . '\'] = \'' . pSQL($value) . '\';' . "\n";
            }
            if (!file_put_contents($mod_lang_file, $str_write)) {
                echo "<br /><br /><p class='error'>(!) ERROR: We need to write translations to file $mod_lang_file, please grant write permissions.</p><br /><br />";
                exit;
            }
        }
        //foreach(Language...)

        $this->context->cookie->id_lang = $orig_lang;

    } //_copyTranslations()

    // verify whether there are relay style modules installed and active
    private function _isRelayStyleModuleActive()
    {
        $relay_style_modules = array("payson", "dibs", "moneybookers", "epay");

        $query          = 'SELECT m.name FROM `' . _DB_PREFIX_ . 'module_group` mg
          LEFT JOIN `' . _DB_PREFIX_ . 'module` m ON (mg.id_module = m.id_module)
          WHERE mg.id_group = 1 and m.active = 1';
        $result         = Db::getInstance()->ExecuteS($query);
        $active_modules = array();
        foreach ($result as $row)
            $active_modules[] = $row['name'];

        return count(array_intersect($active_modules, $relay_style_modules));
    } //_isRelayStyleModuleActive()

    public function checkWritable($directories)
    {
        foreach ($directories as $dir) {
			if (!file_exists(_PS_ROOT_DIR_ . "/" . $dir) &&
				strpos($dir, "override/", 0) === 0)
				return false;
            if (!is_writable(_PS_ROOT_DIR_ . "/" . $dir))
                return false;
	}
        return true;
    }


    public function isPS1608_Bug() {
	    return $this->isPatched("classes/module/Module.php", "/php\)\?\\\s#/");
		        }

    public function install()
    {
    //     if (!$this->checkWritable(array("override/classes/Address.php", "override/classes/Cart.php", "override/classes/Customer.php",
    //         "override/controllers/front/AddressController.php", "override/controllers/front/OrderOpcController.php", "override/controllers/front/ParentOrderController.php","override/controllers/front/AuthController.php"))
    //         ) {
    //         $this->_errors[] = $this->l('Files in /override folder are not writable, we need these: classes: Address.php, Cart.php, Customer.php; controllers/front: AddressController.php, OrderOpcController.php, ParentOrderController.php, AuthController.php');
    //     return false;
    //      }


	if ($this->isPS1608_Bug()) {
		$this->_errors[] = $this->l('Unpatched PS 1.6.0.8 detected, to proceed with installation please patch classes/module/Module.php with these two bugfixes: 1/ in addOverride method: http://scm.prestashop.com/viewrep/PrestaShop_v.1.5/classes/module/Module.php?r1&r2=3d5ec8c0dd434dcf733ba3604e4f52980a2a613d  and 2/ in removeOverride method: http://scm.prestashop.com/viewrep/PrestaShop_v.1.5/classes/module/Module.php?r1&r2=038120a7c0e188f7fa04a71a20effaec1b51ac7a');
		return false;
	}


        if (!parent::install()
            //OR (_THEME_NAME_ != "default" && Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'scroll_cart'), 1) == false)
            OR (_THEME_NAME_ == "default" && Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'scroll_header_cart'), 1) == false)
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'sample_values'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'sample_to_placeholder'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'compact_form'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'payment_radio_buttons'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'inline_validation'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'validation_checkboxes'), 1) == false
            //OR (_THEME_NAME_ != "default" && Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'page_fading'), 1) == false)
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'fading_duration'), '3000') == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'fading_opacity'), '40') == false
            //OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'display_info_block'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'newsletter'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'order_msg'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'phone_delivery'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'country_delivery'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'company_invoice'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'country_invoice'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'payment_customer_id'), $this->_setSimulatedCustomer()) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'before_info_element'), (_THEME_NAME_ != "default")?'#cart_block':'#cart_block .block_content') == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'capitalize_fields'), '#firstname, #firstname_invoice, #lastname, #lastname_invoice, #address1, #address1_invoice, #city, #city_invoice') == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'online_country_id'), $this->_setOnlineCountry()) == false
           // OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'display_password_msg'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'override_checkout_btn'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'animate_fields_padding'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'invoice_checkbox'), 1) == false
            OR Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'use_custom_styling'), 1) == false
            OR Configuration::updateValue('PS_ORDER_PROCESS_TYPE', 1) == false // OPC checkout
            OR Configuration::updateValue('PS_FORCE_SMARTY_2', 0) == false // We need Smarty 3 (tpl_vars, relative includes)
            OR Configuration::updateValue('PS_JS_HTML_THEME_COMPRESSION', 0) == false // Turn off inline JS compression
            OR Configuration::updateValue('PS_GUEST_CHECKOUT_ENABLED', 1) == false

        )
            return false;

        //if ($this->_isRelayStyleModuleActive())
        // There seem to be more and more relay-style or modules relaying on initial form, so we rather
        // enable this option by default for every new installation
        Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'update_payments_relay'), 1);

        $this->_copyTranslations();

        return true;
    }

    private function _updateRadioValue($name)
    {
        $ret       = "";
        $opc_value = Tools::getValue($this->conf_prefix . $name);
        if ($opc_value != 0 AND $opc_value != 1)
            $ret = '<div class="alert error">' . $this->l($name . ' : Invalid choice.') . '</div>';
        else {
            Configuration::updateValue(Tools::strtoupper($this->conf_prefix . $name), (int)$opc_value);
            $ret = "";
        }
        return $ret;
    }

    private function _updateValue($name)
    {
        $opc_value = Tools::getValue($this->conf_prefix . $name);
        Configuration::updateValue(Tools::strtoupper($this->conf_prefix . $name), $opc_value);
    }

    private function _updateOptions($options_array)
    {
        $ret = "";
        foreach ($options_array as $options_group) {
            foreach ($options_group as $option_name => $option) {
                switch ($option->optionType) {
                    case opc_OptionType::RadioBox:
                        $ret .= $this->_updateRadioValue($option_name);
                        break;
                    default:
                        $ret .= $this->_updateValue($option_name);
                        break;
                }
            }
        }
        return $ret;
    }

    public function _setStyles() {
        return '<link type="text/css" rel="stylesheet" href="'.$this->_path.'views/css/bo.css">';
    }

    private function _displaySupport() {
        $this->_html .= '<center><a href="javascript:displaySupport()" id="display_support_anchor" class="highlight_anchor">Troubles? Get support here.</a>' .
            '<div id="opc-support">'.
            '<form id="submitSupportEmailForm" action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post">'.
            '<p class="bigger_margins">Before posting support request, we would like to kindly ask you to read <a href="'.__PS_BASE_URI__.'modules/onepagecheckout/Installation_and_Setup.pdf" class="highlight_anchor" target="_blank">Installation_and_Setup document</a> for solving common problems. If that does not help, here is the contact form.</p>'.
            '<label for="emailFrom">Your email address</label><input id="emailFrom" type="text" name="emailFrom" value="'.Configuration::get('PS_SHOP_EMAIL').'" /><br />'.
            '<label for="emailMessage">Issue description - please be specific how to reproduce it and whether it occurs in more browsers</label><textarea id="emailMessage" name="emailMessage"></textarea><br />'.
            '<input name="submitSupportEmail" type="button" value="Send support request" />'.
            '</form></div><div id="help-topics-header">Online help topics:</div><div id="help-topics"></div></center>'.
            '';
    }

    public function getContent()
    {

        if (Tools::isSubmit('emailLangFile')) {
            $this->emailLangFile();
            Configuration::updateValue(Tools::strtoupper($this->conf_prefix . 'lang_file_sent'), 1);
            $return = array("result" => 1);
            die(Tools::jsonEncode($return));
        }

        if (Tools::isSubmit('submitSupportEmail')) {
            $this->emailSupportRequest();
            $return = array("result" => 1);
            die(Tools::jsonEncode($return));
        }

        $this->_html = $this->_setStyles();

        $this->_html .= '<h2>' . $this->displayName . '</h2>';

        if (Tools::isSubmit('submitOPC')) {
            $output = $this->_updateOptions($this->module_settings);
            $output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="' . $this->l('Confirmation') . '" />' . $this->l('Settings updated') . '</div>';
            $this->_html .= $output;
        }

        if ($this->need_override_instructions)
            $this->_html .= '<div class="alert">
                            <strong>Incomplete installation</strong> -
                            Overrides from files <u>AddressController.php</u>, <u>ParentOrderController.php</u>, <u>Customer.php</u>, <u>Cart.php</u> and <u>Address.php</u>
                            are not present in /overrides folder, please reinstall module!
                            </div>';
        // Not needed in PS 1.5
//        if ($this->need_patch_instructions)
//            $this->_html .= '<div class="alert">
//                            <strong>Incomplete installation</strong> -
//                            Small update must be performed in  <u>/controllers/AddressController.php</u>, depending on PS version - around line 201, change this: <br />
//				if ($address_old->isUsed()) <br />
//				to this: <br />
//				if (<b>false && </b>$address_old->isUsed()) <br />
//				NB: This file is in main /controllers directory in Prestashop installation, not in /override/controllers folder !
//                            </div>';
//        if ($this->need_change_options) {
//            $this->_html .= '<div class="alert">
//                            <strong>Some prestashop options need to be changed so that OPC could work properly</strong><br />';
//
//            //$need_options = Configuration::getMultiple(array('PS_FORCE_SMARTY_2'));
//
//            //if ($need_options['PS_FORCE_SMARTY_2'] == 1)
//            //    $this->_html .= "- " . $this->l('Force smarty v2 option in Preferences must be turned off') . "<br />";
//            $this->_html .= '</div>';
//        }

        $this->_displaySupport();

        $this->_displayForm();

        return $this->_html;
    }

    private function _displayOption($title, $name, $desc)
    {
        return '
                <div class="conf-line">
				<label class="conf_title">' . $this->l($title) . '</label>
				<div class="margin-form">
					<label class="t" for="' . $this->conf_prefix . $name . '_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Yes') . '" title="' . $this->l('Yes') . '" /></label>
					<input type="radio" name="' . $this->conf_prefix . $name . '" id="' . $this->conf_prefix . $name . '_on" value="1" ' . Tools::safeOutput((Tools::getValue($this->conf_prefix . $name, Configuration::get(Tools::strtoupper($this->conf_prefix . $name))) ? 'checked="checked" ' : '')) . '/>
					<label for="' . $this->conf_prefix . $name . '_on" class="t"> ' . $this->l('Yes') . '</label>
					<label class="t" for="' . $this->conf_prefix . $name . '_off"> <img style="margin-left: 15px" src="../img/admin/disabled.gif" alt="' . $this->l('No') . '" title="' . $this->l('No') . '" /></label>
					<input type="radio" name="' . $this->conf_prefix . $name . '" id="' . $this->conf_prefix . $name . '_off" value="0" ' . Tools::safeOutput((!Tools::getValue($this->conf_prefix . $name, Configuration::get(Tools::strtoupper($this->conf_prefix . $name))) ? 'checked="checked" ' : '')) . '/>
					<label for="' . $this->conf_prefix . $name . '_off" class="t"> ' . $this->l('No') . '</label>
					<p class="preference_description">' . $desc . '</p>
				</div>
				</div>
		';
    }

    private function _displayTextField($title, $name, $desc)
    {
        return '
                <div class="conf-line">
				<label class="conf_title">' . $this->l($title) . '</label>
				<div class="margin-form">
					<textarea rows="2" cols="50" name="' . $this->conf_prefix . $name . '" id="' . $this->conf_prefix . $name . '">' . Tools::safeOutput(Tools::getValue($this->conf_prefix . $name, Configuration::get(Tools::strtoupper($this->conf_prefix . $name)))) . '</textarea>
					<p class="preference_description">' . $desc . '</p>
				</div>
				</div>
		';
    }

    private function _displayInputField($title, $name, $desc)
    {
        return '
                <div class="conf-line">
				<label class="conf_title">' . $this->l($title) . '</label>
				<div class="margin-form">
					<input type="text" size="15" name="' . $this->conf_prefix . $name . '" id="' . $this->conf_prefix . $name . '" value="' . Tools::safeOutput(Tools::getValue($this->conf_prefix . $name, Configuration::get(Tools::strtoupper($this->conf_prefix . $name)))) . '" />
					<p class="preference_description">' . $desc . '</p>
				</div>
				</div>
		';
    }

    private function _displayEmailLangFile() {
        $def_lang = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT', null, $this->context->shop->id_shop_group, $this->context->shop->id));
        $lang_name = $def_lang["name"];

        $mod_lang_file = _PS_MODULE_DIR_ . 'onepagecheckout/translations/' . $def_lang["iso_code"] . ".php";
        if (!file_exists($mod_lang_file))
            return "";

        $translated = array("en");

        $email_link = '<b><a href="javascript:emailLangFile()">Click here to send '.$lang_name.' translations.</a></b>';
        $ret = '';
        if (Configuration::get(Tools::strtoupper($this->conf_prefix . 'lang_file_sent')))
            $ret .= 'If you made changes to your translations in '.$lang_name.', we would appreciate you sending it to us again. '.$email_link;
        else if (!in_array($def_lang["iso_code"], $translated))
            $ret .= 'We have noticed we don\'t have yet OPC module fully translated into '.$lang_name.'. After you finish with translations, would you please send us your file? '.$email_link;
        if (trim($ret) != "")
            $ret = '<div id="emailLangFile">'.$ret.'</div>';
        return $ret;
    }

    private function _displayOptions($options_array)
    {
        $ret = "";
        foreach ($options_array as $option_name => $option) {
            switch ($option->optionType) {
                case opc_OptionType::RadioBox:
                    $ret .= $this->_displayOption($option->title, $option_name, $option->description);
                    break;
                case opc_OptionType::InputField:
                    $ret .= $this->_displayInputField($option->title, $option_name, $option->description);
                    break;
                case opc_OptionType::TextField:
                    $ret .= $this->_displayTextField($option->title, $option_name, $option->description);
                    break;
                default:
                    break;
            }
            $ret .= '<div class="clear"></div>';
        }
        return $ret;
    }

    private function _includeJs()
    {
        $ret = '<script type="text/javascript">var ps_guest_checkout = ' . Configuration::get('PS_GUEST_CHECKOUT_ENABLED') . ';</script>';
        $ret .= '<script type="text/javascript" src="../modules/onepagecheckout/views/js/bo.js"></script>';
       // $ret .= '<script type="text/javascript" src="../modules/onepagecheckout/views/js/list.min.js"></script>';
        return $ret;
    }

    private function _displayForm()
    {

        /* Languages preliminaries */

// Commented-out, it's not used here anymore
//        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
//        $languages       = Language::getLanguages();
//        $iso             = Language::getIsoById($defaultLanguage);
//        $divLangName     = 'text_left¤text_right';

        $this->_html .= '
		<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post" name="opc_config">
			<fieldset>
				<legend><img src="' . $this->_path . 'logo.gif" alt="" title="" />' . $this->l('Settings') . '</legend>' .
            '<center><input type="submit" id="floating-save" name="submitOPC" value="' . $this->l('Save all settings') . '" class="button hidden floating-save" /></center>' .

            '<a id="general_settings_anchor" class="settings_anchor" title="Collapse / Expand this group"><span class="monosp">[-]</span> General settings:</a><div class="settings_group" id="general_settings">' .
            $this->_displayOptions($this->module_settings["general"]) .
            '</div>'.

            '<a id="customer_settings_anchor" class="settings_anchor" title="Collapse / Expand this group"><span class="monosp">[-]</span> Customer section:</a><div class="settings_group" id="customer_settings">' .
            $this->_displayOptions($this->module_settings["customer"]) .
            '</div>'.

            '<a id="delivery_settings_anchor" class="settings_anchor" title="Collapse / Expand this group"><span class="monosp">[-]</span> Delivery address:</a><div class="settings_group" id="delivery_settings">' .
            $this->_displayOptions($this->module_settings["delivery_address"]) .
            '</div>'.

            '<a id="invoice_settings_anchor" class="settings_anchor" title="Collapse / Expand this group"><span class="monosp">[-]</span> Invoice address:</a><div class="settings_group" id="invoice_settings">' .
            $this->_displayOptions($this->module_settings["invoice_address"]) .
            '</div>'.
            '<center><input type="submit" name="submitOPC" value="' . $this->l('Save all settings') . '" class="button" /></center>'.

            '<a id="system_settings_anchor" class="settings_anchor" title="Collapse / Expand this group"><span class="monosp">[+]</span> System settings:</a><div class="settings_group" id="system_settings">' .
            '<p>! Change these only when you understand what they mean - please see <a href="'.__PS_BASE_URI__.'modules/onepagecheckout/Installation_and_Setup.pdf" class="highlight_anchor" target="_blank">Installation_and_Setup document</a> to read more.<p>' .
            $this->_displayOptions($this->module_settings["system"]) .
            '</div>'.

            $this->_displayEmailLangFile().'
			</fieldset>
		</form>' . $this->_includeJs();
    }

    public function putContent($xml_data, $key, $field, $forbidden)
    {
        foreach ($forbidden AS $line)
            if ($key == $line)
                return 0;
        $field = htmlspecialchars($field) ;
        if (!$field)
            return 0;
        return ("\n" . '		<' . $key . '>' . $field . '</' . $key . '>');
    }

    public function uninstall()
    {
        //require(_PS_MODULE_DIR_."onepagecheckout/uninstall_files.php");

        if (!parent::uninstall())
            return false;
        return true;
    }

    public function emailLangFile()
    {
        $def_lang = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT', null, $this->context->shop->id_shop_group, $this->context->shop->id));

        $mod_lang_file = _PS_MODULE_DIR_ . 'onepagecheckout/translations/' . $def_lang["iso_code"] . ".php";
        $content       = @Tools::file_get_contents($mod_lang_file);

        $file_attachment = array();

        $file_attachment['content'] = $content;
        $file_attachment['name']    = $def_lang["iso_code"] . '.php';
        $file_attachment['mime']    = 'text/x-php';
        $data                       = array("{message}"    => "lang file for " . $def_lang["name"],
                                            "{ps_version}" => _PS_VERSION_, "{opc_version}" => $this->version);
        Mail::Send(
            1, // english
            'support_request',
            'OPC lang file - ' . $def_lang["iso_code"],
            $data,
            'prestamodules+lang-file@gmail.com',
            null,
            null,
            null,
            $file_attachment,
            null, _PS_MODULE_DIR_ . 'onepagecheckout/mails/', false, $this->context->shop->id
        );
    }

    public function emailSupportRequest()
    {
        $debug_info = "theme: ". _PS_THEME_DIR_ ."\n";

        $debug_info .= "\n************* Permissions\n\n";

        if (!$this->isPatched("override/controllers/front/ParentOrderController.php", "/isOpcModuleActive/"))
            $debug_info .= "(!) ParentOrderController.php is not overridden! \n";
        if (!$this->isPatched("override/controllers/front/AddressController.php", "/isOpcModuleActive/"))
            $debug_info .= "(!) AddressController.php is not overridden! \n";
        if (!$this->isPatched("override/classes/Address.php", "/isDifferent/"))
            $debug_info .= "(!) Address.php is not overridden! \n";
        if (!$this->isPatched("override/classes/Cart.php", "/resetCartDiscountCache/"))
            $debug_info .= "(!) Cart.php is not overridden! \n";
        if (!$this->isPatched("override/classes/Customer.php", "/isOpcModuleActive/"))
            $debug_info .= "(!) Customer.php is not overridden! \n";

        $check_permissions = array(_PS_MODULE_DIR_."onepagecheckout",
            _PS_MODULE_DIR_."onepagecheckout/translations",
            _PS_ROOT_DIR_."/override/classes",
            _PS_ROOT_DIR_."/override/controllers/front");

        $debug_info .= "Script user: " . get_current_user() . " (uid=" . getmyuid() . ", gid=" . getmygid() . ")\n\n";

        $root_length = Tools::strlen(_PS_ROOT_DIR_);

        foreach ($check_permissions as $filename) {
            $owner = function_exists('posix_getpwuid') ? @posix_getpwuid(fileowner($filename)) : fileowner($filename);

            $debug_info .= Tools::substr($filename, $root_length) . ": " . Tools::substr(sprintf('%o', fileperms($filename)), -4) . ", " . $owner['name'] .
                " (uid=" . $owner['uid'] . ", gid=" . $owner['gid'] . ")\n";
        }

        $debug_info .= "\n************* Module:version\n\n";

        foreach (Module::getModulesInstalled() as $module)
            $debug_info .= $module["name"] . ":" . $module["version"] . ($module["active"] ? "" : " (inactive)") . "\n";

        $debug_info .= "\n";

        foreach (Module::getPaymentModules() as $module)
            $debug_info .= "payment: " . $module["name"] . "\n";

        $debug_info .= "\n************* OPC configuration\n\n";

        foreach ($this->_getAllOptionsValues() as $key=> $value)
            $debug_info .= "$key: $value\n";

        $file_attachment = array();

        $file_attachment['content'] = $debug_info;
        $file_attachment['name']    = "debug_info.txt";
        $file_attachment['mime']    = 'text/html';
        $data                       = array("{message}"    => nl2br(Tools::safeOutput(Tools::getValue('emailMessage'))),
                                            "{ps_version}" => _PS_VERSION_, "{opc_version}" => $this->version);
        Mail::Send(
            1, // english
            'support_request',
            'OPC support',
            $data,
            'prestamodules+first@gmail.com',
            null,
            Tools::getValue('emailFrom'),
            null,
            $file_attachment,
            null, _PS_MODULE_DIR_ . 'onepagecheckout/mails/', false, $this->context->shop->id
        );
    }

}
