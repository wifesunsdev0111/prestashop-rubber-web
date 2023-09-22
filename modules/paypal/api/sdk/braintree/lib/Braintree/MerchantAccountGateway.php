<?php
/**
 *
 *  2007-2021 PayPal
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Academic Free License (AFL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/afl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to license@prestashop.com so we can send you a copy immediately.
 *
 *  DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 *  versions in the future. If you wish to customize PrestaShop for your
 *  needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2021 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 *  @copyright PayPal
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

namespace Braintree;

final class MerchantAccountGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_config->assertHasAccessTokenOrKeys();
        $this->_http = new Http($gateway->config);
    }

    public function create($attribs)
    {
        Util::verifyKeys(self::detectSignature($attribs), $attribs);
        return $this->_doCreate('/merchant_accounts/create_via_api', ['merchant_account' => $attribs]);
    }

    public function find($merchant_account_id)
    {
        try {
            $path = $this->_config->merchantPath() . '/merchant_accounts/' . $merchant_account_id;
            $response = $this->_http->get($path);
            return MerchantAccount::factory($response['merchantAccount']);
        } catch (Exception\NotFound $e) {
            throw new Exception\NotFound('merchant account with id ' . $merchant_account_id . ' not found');
        }
    }

    public function update($merchant_account_id, $attributes)
    {
        Util::verifyKeys(self::updateSignature(), $attributes);
        return $this->_doUpdate('/merchant_accounts/' . $merchant_account_id . '/update_via_api', ['merchant_account' => $attributes]);
    }

    public static function detectSignature($attribs)
    {
        if (isset($attribs['applicantDetails'])) {
            trigger_error("DEPRECATED: Passing applicantDetails to create is deprecated. Please use individual, business, and funding", E_USER_NOTICE);
            return self::createDeprecatedSignature();
        } else {
            return self::createSignature();
        }
    }

    public static function updateSignature()
    {
        $signature = self::createSignature();
        unset($signature['tosAccepted']);
        return $signature;
    }

    public static function createSignature()
    {
        $addressSignature = ['streetAddress', 'postalCode', 'locality', 'region'];
        $individualSignature = [
            'firstName',
            'lastName',
            'email',
            'phone',
            'dateOfBirth',
            'ssn',
            ['address' => $addressSignature]
        ];

        $businessSignature = [
            'dbaName',
            'legalName',
            'taxId',
            ['address' => $addressSignature]
        ];

        $fundingSignature = [
            'routingNumber',
            'accountNumber',
            'destination',
            'email',
            'mobilePhone',
            'descriptor',
        ];

        return [
            'id',
            'tosAccepted',
            'masterMerchantAccountId',
            ['individual' => $individualSignature],
            ['funding' => $fundingSignature],
            ['business' => $businessSignature]
        ];
    }

    public static function createDeprecatedSignature()
    {
        $applicantDetailsAddressSignature = ['streetAddress', 'postalCode', 'locality', 'region'];
        $applicantDetailsSignature = [
            'companyName',
            'firstName',
            'lastName',
            'email',
            'phone',
            'dateOfBirth',
            'ssn',
            'taxId',
            'routingNumber',
            'accountNumber',
            ['address' => $applicantDetailsAddressSignature]
        ];

        return [
            ['applicantDetails' =>  $applicantDetailsSignature],
            'id',
            'tosAccepted',
            'masterMerchantAccountId'
        ];
    }

    public function _doCreate($subPath, $params)
    {
        $fullPath = $this->_config->merchantPath() . $subPath;
        $response = $this->_http->post($fullPath, $params);

        return $this->_verifyGatewayResponse($response);
    }

    private function _doUpdate($subPath, $params)
    {
        $fullPath = $this->_config->merchantPath() . $subPath;
        $response = $this->_http->put($fullPath, $params);

        return $this->_verifyGatewayResponse($response);
    }

    private function _verifyGatewayResponse($response)
    {
        if (isset($response['merchantAccount'])) {
            // return a populated instance of merchantAccount
            return new Result\Successful(
                    MerchantAccount::factory($response['merchantAccount'])
            );
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
            "Expected merchant account or apiErrorResponse"
            );
        }
    }
}
class_alias('Braintree\MerchantAccountGateway', 'Braintree_MerchantAccountGateway');
