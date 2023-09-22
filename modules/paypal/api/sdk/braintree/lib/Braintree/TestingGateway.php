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

final class TestingGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_http = new Http($this->_config);
    }

    public function settle($transactionId)
    {
        return self::_doTestRequest('/settle', $transactionId);
    }

    public function settlementPending($transactionId)
    {
        return self::_doTestRequest('/settlement_pending', $transactionId);
    }

    public function settlementConfirm($transactionId)
    {
        return self::_doTestRequest('/settlement_confirm', $transactionId);
    }

    public function settlementDecline($transactionId)
    {
        return self::_doTestRequest('/settlement_decline', $transactionId);
    }

    private function _doTestRequest($testPath, $transactionId)
    {
        self::_checkEnvironment();
        $path = $this->_config->merchantPath() . '/transactions/' . $transactionId . $testPath;
        $response = $this->_http->put($path);
        return Transaction::factory($response['transaction']);
    }

    private function _checkEnvironment()
    {
        if (Configuration::$global->getEnvironment() === 'production') {
            throw new Exception\TestOperationPerformedInProduction();
        }
    }
}
class_alias('Braintree\TestingGateway', 'Braintree_TestingGateway');
