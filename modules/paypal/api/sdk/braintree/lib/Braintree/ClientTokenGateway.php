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

use InvalidArgumentException;

class ClientTokenGateway
{
    /**
     *
     * @var Gateway
     */
    private $_gateway;

    /**
     *
     * @var Configuration
     */
    private $_config;

    /**
     *
     * @var Http
     */
    private $_http;

    /**
     *
     * @param Gateway $gateway
     */
    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_config->assertHasAccessTokenOrKeys();
        $this->_http = new Http($gateway->config);
    }

    public function generate($params=[])
    {
        if (!array_key_exists("version", $params)) {
            $params["version"] = ClientToken::DEFAULT_VERSION;
        }

        $this->conditionallyVerifyKeys($params);
        $generateParams = ["client_token" => $params];

        return $this->_doGenerate('/client_token', $generateParams);
    }

    /**
     * sends the generate request to the gateway
     *
     * @ignore
     * @param var $url
     * @param array $params
     * @return mixed
     */
    public function _doGenerate($subPath, $params)
    {
        $fullPath = $this->_config->merchantPath() . $subPath;
        $response = $this->_http->post($fullPath, $params);

        return $this->_verifyGatewayResponse($response);
    }

    /**
     *
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function conditionallyVerifyKeys($params)
    {
        if (array_key_exists("customerId", $params)) {
            Util::verifyKeys($this->generateWithCustomerIdSignature(), $params);
        } else {
            Util::verifyKeys($this->generateWithoutCustomerIdSignature(), $params);
        }
    }

    /**
     *
     * @return mixed[]
     */
    public function generateWithCustomerIdSignature()
    {
        return [
            "version", "customerId", "proxyMerchantId",
            ["options" => ["makeDefault", "verifyCard", "failOnDuplicatePaymentMethod"]],
            "merchantAccountId", "sepaMandateType", "sepaMandateAcceptanceLocation"];
    }

    /**
     *
     * @return string[]
     */
    public function generateWithoutCustomerIdSignature()
    {
        return ["version", "proxyMerchantId", "merchantAccountId"];
    }

    /**
     * generic method for validating incoming gateway responses
     *
     * If the request is successful, returns a client token string.
     * Otherwise, throws an InvalidArgumentException with the error
     * response from the Gateway or an HTTP status code exception.
     *
     * @ignore
     * @param array $response gateway response values
     * @return string client token
     * @throws InvalidArgumentException | HTTP status code exception
     */
    private function _verifyGatewayResponse($response)
    {
        if (isset($response['clientToken'])) {
            return $response['clientToken']['value'];
        } elseif (isset($response['apiErrorResponse'])) {
            throw new InvalidArgumentException(
                $response['apiErrorResponse']['message']
            );
        } else {
            throw new Exception\Unexpected(
                "Expected clientToken or apiErrorResponse"
            );
        }
    }

}
class_alias('Braintree\ClientTokenGateway', 'Braintree_ClientTokenGateway');
