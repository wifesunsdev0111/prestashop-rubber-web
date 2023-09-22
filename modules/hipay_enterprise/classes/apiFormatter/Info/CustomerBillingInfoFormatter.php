<?php
/**
 * HiPay Enterprise SDK Prestashop
 *
 * 2017 HiPay
 *
 * NOTICE OF LICENSE
 *
 * @author    HiPay <support.tpp@hipay.com>
 * @copyright 2017 HiPay
 * @license   https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 */

require_once(dirname(__FILE__) . '/../../../lib/vendor/autoload.php');
require_once(dirname(__FILE__) . '/../../../lib/vendor/autoload.php');
require_once(dirname(__FILE__) . '/../ApiFormatterAbstract.php');

/**
 *
 * Customer billing information request formatter
 *
 * @author      HiPay <support.tpp@hipay.com>
 * @copyright   Copyright (c) 2017 - HiPay
 * @license     https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 * @link    https://github.com/hipay/hipay-enterprise-sdk-prestashop
 */
class CustomerBillingInfoFormatter extends ApiFormatterAbstract
{

    public function __construct($module, $cart = false, $payment_product = '')
    {
        parent::__construct($module, $cart);
        // fields only used for customer billing mapping
        $this->invoice = new Address((int) $this->cart->id_address_invoice);
        $this->country = new Country((int) $this->invoice->id_country);
        $this->payment_product = $payment_product;
    }

    /**
     * return mapped customer billing informations
     * @return \HiPay\Fullservice\Gateway\Request\Info\CustomerBillingInfoRequest
     */
    public function generate()
    {
        $customerBillingInfo = new \HiPay\Fullservice\Gateway\Request\Info\CustomerBillingInfoRequest();

        $this->mapRequest($customerBillingInfo);

        return $customerBillingInfo;
    }

    /**
     * map prestashop billing informations to request fields (Hpayment Post)
     * @param \HiPay\Fullservice\Gateway\Request\Info\CustomerBillingInfoRequest $customerBillingInfo
     */
    protected function mapRequest(&$customerBillingInfo)
    {
        $customerBillingInfo->firstname = $this->customer->firstname;
        $customerBillingInfo->lastname = $this->customer->lastname;
        $customerBillingInfo->email = $this->customer->email;

        $dob = $this->customer->birthday;
        if (!is_null($dob) && !empty($dob)) {
            $dob = str_replace('-', '', $dob);
            if (!preg_match("/00000000/", $dob)) {
                $customerBillingInfo->birthdate = $dob;
            }
        }

        $customerBillingInfo->gender = $this->getGender($this->customer->id_gender);

        $customerBillingInfo->streetaddress = $this->invoice->address1;
        $customerBillingInfo->streetaddress2 = $this->invoice->address2;
        $customerBillingInfo->city = $this->invoice->city;
        $customerBillingInfo->zipcode = $this->invoice->postcode;
        $customerBillingInfo->country = $this->country->iso_code;
        $customerBillingInfo->phone = $this->getPhone();
        $customerBillingInfo->state = ($this->deliveryState) ? $this->deliveryState->name : '';
        $customerBillingInfo->recipientinfo = $this->store->name;
    }

    /**
     * return well formatted phone number
     * @return string
     */
    private function getPhone()
    {
        $phone = '';
        if (isset($this->invoice->phone) && !empty($this->invoice->phone)) {
            $phone = $this->invoice->phone;
        } elseif (isset($this->invoice->phone_mobile) && !empty($this->invoice->phone_mobile)) {
            $phone = $this->invoice->phone_mobile;
        }

        try {
            if (!empty($phone)) {
                $phoneNumberUtil = libphonenumber\PhoneNumberUtil::getInstance();

                $phoneNumber = $phoneNumberUtil->parse(
                    $phone,
                    Country::getIsoById($this->invoice->id_country)
                );

                if ($phoneNumberUtil->isValidNumber($phoneNumber) ) {
                    $format = libphonenumber\PhoneNumberFormat::E164;
                    if ($this->payment_product == "mbway" ) {
                        $format = libphonenumber\PhoneNumberFormat::NATIONAL;
                    }

                    $phone = $phoneNumberUtil->format(
                        $phoneNumber,
                        $format
                    );

                    // To Remove in futur release.
                    $phone = $this->payment_product == "mbway" ? str_replace(' ','',$phone) : $phone;
                }
            }
        } catch (Exception $e) {
            $this->module->getLogs()->logErrors($e);
        }

        return $phone;
    }
}
