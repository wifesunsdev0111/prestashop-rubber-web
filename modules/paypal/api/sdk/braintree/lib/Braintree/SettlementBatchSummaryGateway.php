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

class SettlementBatchSummaryGateway
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

    /**
     *
     * @param string $settlement_date
     * @param string $groupByCustomField
     * @return SettlementBatchSummary|Result\Error
     */
    public function generate($settlement_date, $groupByCustomField = NULL)
    {
        $criteria = ['settlement_date' => $settlement_date];
        if (isset($groupByCustomField))
        {
            $criteria['group_by_custom_field'] = $groupByCustomField;
        }
        $params = ['settlement_batch_summary' => $criteria];
        $path = $this->_config->merchantPath() . '/settlement_batch_summary';
        $response = $this->_http->post($path, $params);

        if (isset($groupByCustomField))
        {
            $response['settlementBatchSummary']['records'] = $this->_underscoreCustomField(
                $groupByCustomField,
                $response['settlementBatchSummary']['records']
            );
        }

        return $this->_verifyGatewayResponse($response);
    }

    /**
     *
     * @param string $groupByCustomField
     * @param array $records
     * @return array
    */
    private function _underscoreCustomField($groupByCustomField, $records)
    {
        $updatedRecords = [];

        foreach ($records as $record)
        {
            $camelized = Util::delimiterToCamelCase($groupByCustomField);
            $record[$groupByCustomField] = $record[$camelized];
            unset($record[$camelized]);
            $updatedRecords[] = $record;
        }

        return $updatedRecords;
    }

    /**
     *
     * @param array $response
     * @return Result\Successful|Result\Error
     * @throws Exception\Unexpected
     */
    private function _verifyGatewayResponse($response)
    {
        if (isset($response['settlementBatchSummary'])) {
            return new Result\Successful(
                SettlementBatchSummary::factory($response['settlementBatchSummary'])
            );
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
                "Expected settlementBatchSummary or apiErrorResponse"
            );
        }
    }
}
class_alias('Braintree\SettlementBatchSummaryGateway', 'Braintree_SettlementBatchSummaryGateway');
