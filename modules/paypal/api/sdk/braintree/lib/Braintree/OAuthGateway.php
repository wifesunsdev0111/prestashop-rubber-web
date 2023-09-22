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

/**
 * Braintree OAuthGateway module
 * PHP Version 5
 * Creates and manages Braintree Addresses
 *
 * @package   Braintree
 * @copyright 2015 Braintree, a division of PayPal, Inc.
 */
class OAuthGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_http = new Http($gateway->config);
        $this->_http->useClientCredentials();

        $this->_config->assertHasClientCredentials();
    }

    public function createTokenFromCode($params)
    {
        $params['grantType'] = "authorization_code";
        return $this->_createToken($params);
    }

    public function createTokenFromRefreshToken($params)
    {
        $params['grantType'] = "refresh_token";
        return $this->_createToken($params);
    }

    private function _createToken($params)
    {
        $params = ['credentials' => $params];
        $response = $this->_http->post('/oauth/access_tokens', $params);
        return $this->_verifyGatewayResponse($response);
    }

    private function _verifyGatewayResponse($response)
    {
        if (isset($response['credentials'])) {
            $result =  new Result\Successful(
                OAuthCredentials::factory($response['credentials'])
            );
            return $this->_mapSuccess($result);
        } else if (isset($response['apiErrorResponse'])) {
            $result = new Result\Error($response['apiErrorResponse']);
            return $this->_mapError($result);
        } else {
            throw new Exception\Unexpected(
                "Expected credentials or apiErrorResponse"
            );
        }
    }

    public function _mapError($result)
    {
        $error = $result->errors->deepAll()[0];

        if ($error->code == Error\Codes::OAUTH_INVALID_GRANT) {
            $result->error = 'invalid_grant';
        } else if ($error->code == Error\Codes::OAUTH_INVALID_CREDENTIALS) {
            $result->error = 'invalid_credentials';
        } else if ($error->code == Error\Codes::OAUTH_INVALID_SCOPE) {
            $result->error = 'invalid_scope';
        }
        $result->errorDescription = explode(': ', $error->message)[1];
        return $result;
    }

    public function _mapSuccess($result)
    {
        $credentials = $result->credentials;
        $result->accessToken = $credentials->accessToken;
        $result->refreshToken = $credentials->refreshToken;
        $result->tokenType = $credentials->tokenType;
        $result->expiresAt = $credentials->expiresAt;
        return $result;
    }

    public function connectUrl($params = [])
    {
        $query = Util::camelCaseToDelimiterArray($params, '_');
        $query['client_id'] = $this->_config->getClientId();
        $queryString = preg_replace('/\%5B\d+\%5D/', '%5B%5D', http_build_query($query));
        $url = $this->_config->baseUrl() . '/oauth/connect?' . $queryString;

        return $url . '&signature=' . $this->computeSignature($url) . '&algorithm=SHA256';
    }

    public function computeSignature($url)
    {
        $key = hash('sha256', $this->_config->getClientSecret(), true);
        return hash_hmac('sha256', $url, $key);
    }
}
class_alias('Braintree\OAuthGateway', 'Braintree_OAuthGateway');
