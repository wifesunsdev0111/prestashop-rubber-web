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

final class MerchantGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_config->assertHasClientCredentials();
        $this->_http = new Http($gateway->config);
        $this->_http->useClientCredentials();
    }

    public function create($attribs)
    {
        $response = $this->_http->post('/merchants/create_via_api', ['merchant' => $attribs]);
        return $this->_verifyGatewayResponse($response);
    }

    private function _verifyGatewayResponse($response)
    {
        if (isset($response['response']['merchant'])) {
            // return a populated instance of merchant
            return new Result\Successful([
                Merchant::factory($response['response']['merchant']),
                OAuthCredentials::factory($response['response']['credentials']),
            ]);
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
            "Expected merchant or apiErrorResponse"
            );
        }
    }
}
class_alias('Braintree\MerchantGateway', 'Braintree_MerchantGateway');
