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
 * Braintree PaymentMethodNonceGateway module
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */

/**
 * Creates and manages Braintree PaymentMethodNonces
 *
 * <b>== More information ==</b>
 *
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 */
class PaymentMethodNonceGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_http = new Http($gateway->config);
    }


    public function create($token)
    {
        $subPath = '/payment_methods/' . $token . '/nonces';
        $fullPath = $this->_config->merchantPath() . $subPath;
        $response = $this->_http->post($fullPath);

        return new Result\Successful(
            PaymentMethodNonce::factory($response['paymentMethodNonce']),
            "paymentMethodNonce"
        );
    }

    /**
     * @access public
     *
     */
    public function find($nonce)
    {
        try {
            $path = $this->_config->merchantPath() . '/payment_method_nonces/' . $nonce;
            $response = $this->_http->get($path);
            return PaymentMethodNonce::factory($response['paymentMethodNonce']);
        } catch (Exception\NotFound $e) {
            throw new Exception\NotFound(
            'payment method nonce with id ' . $nonce . ' not found'
            );
        }

    }
}
class_alias('Braintree\PaymentMethodNonceGateway', 'Braintree_PaymentMethodNonceGateway');
