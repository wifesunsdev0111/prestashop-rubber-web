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

class CreditCardVerificationGateway
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

    public function create($attributes)
    {
        $response = $this->_http->post($this->_config->merchantPath() . "/verifications", ['verification' => $attributes]);
        return $this->_verifyGatewayResponse($response);
    }

    private function _verifyGatewayResponse($response)
    {

        if(isset($response['verification'])){
            return new Result\Successful(
                CreditCardVerification::factory($response['verification'])
            );
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
                "Expected transaction or apiErrorResponse"
            );
        }
    }

    public function fetch($query, $ids)
    {
        $criteria = [];
        foreach ($query as $term) {
            $criteria[$term->name] = $term->toparam();
        }
        $criteria["ids"] = CreditCardVerificationSearch::ids()->in($ids)->toparam();
        $path = $this->_config->merchantPath() . '/verifications/advanced_search';
        $response = $this->_http->post($path, ['search' => $criteria]);

        return Util::extractattributeasarray(
            $response['creditCardVerifications'],
            'verification'
        );
    }

    public function search($query)
    {
        $criteria = [];
        foreach ($query as $term) {
            $criteria[$term->name] = $term->toparam();
        }

        $path = $this->_config->merchantPath() . '/verifications/advanced_search_ids';
        $response = $this->_http->post($path, ['search' => $criteria]);
        $pager = [
            'object' => $this,
            'method' => 'fetch',
            'methodArgs' => [$query]
            ];

        return new ResourceCollection($response, $pager);
    }
}
class_alias('Braintree\CreditCardVerificationGateway', 'Braintree_CreditCardVerificationGateway');
