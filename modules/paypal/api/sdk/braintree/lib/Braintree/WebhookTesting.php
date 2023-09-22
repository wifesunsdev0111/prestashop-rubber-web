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

class WebhookTesting
{
    public static function sampleNotification($kind, $id)
    {
        $payload = base64_encode(self::_sampleXml($kind, $id)) . "\n";
        $signature = Configuration::publicKey() . "|" . Digest::hexDigestSha1(Configuration::privateKey(), $payload);

        return [
            'bt_signature' => $signature,
            'bt_payload' => $payload
        ];
    }

    private static function _sampleXml($kind, $id)
    {
        switch ($kind) {
            case WebhookNotification::SUB_MERCHANT_ACCOUNT_APPROVED:
                $subjectXml = self::_merchantAccountApprovedSampleXml($id);
                break;
            case WebhookNotification::SUB_MERCHANT_ACCOUNT_DECLINED:
                $subjectXml = self::_merchantAccountDeclinedSampleXml($id);
                break;
            case WebhookNotification::TRANSACTION_DISBURSED:
                $subjectXml = self::_transactionDisbursedSampleXml($id);
                break;
            case WebhookNotification::DISBURSEMENT_EXCEPTION:
                $subjectXml = self::_disbursementExceptionSampleXml($id);
                break;
            case WebhookNotification::DISBURSEMENT:
                $subjectXml = self::_disbursementSampleXml($id);
                break;
            case WebhookNotification::PARTNER_MERCHANT_CONNECTED:
                $subjectXml = self::_partnerMerchantConnectedSampleXml($id);
                break;
            case WebhookNotification::PARTNER_MERCHANT_DISCONNECTED:
                $subjectXml = self::_partnerMerchantDisconnectedSampleXml($id);
                break;
            case WebhookNotification::PARTNER_MERCHANT_DECLINED:
                $subjectXml = self::_partnerMerchantDeclinedSampleXml($id);
                break;
            case WebhookNotification::DISPUTE_OPENED:
                $subjectXml = self::_disputeOpenedSampleXml($id);
                break;
            case WebhookNotification::DISPUTE_LOST:
                $subjectXml = self::_disputeLostSampleXml($id);
                break;
            case WebhookNotification::DISPUTE_WON:
                $subjectXml = self::_disputeWonSampleXml($id);
                break;
            case WebhookNotification::SUBSCRIPTION_CHARGED_SUCCESSFULLY:
                $subjectXml = self::_subscriptionChargedSuccessfullySampleXml($id);
                break;
            case WebhookNotification::CHECK:
                $subjectXml = self::_checkSampleXml();
                break;
            case WebhookNotification::ACCOUNT_UPDATER_DAILY_REPORT:
                $subjectXml = self::_accountUpdaterDailyReportSampleXml($id);
                break;
            default:
                $subjectXml = self::_subscriptionSampleXml($id);
                break;
        }
        $timestamp = self::_timestamp();
        return "
        <notification>
            <timestamp type=\"datetime\">{$timestamp}</timestamp>
            <kind>{$kind}</kind>
            <subject>{$subjectXml}</subject>
        </notification>
        ";
    }

    private static function _merchantAccountApprovedSampleXml($id)
    {
        return "
        <merchant_account>
            <id>{$id}</id>
            <master_merchant_account>
                <id>master_ma_for_{$id}</id>
                <status>active</status>
            </master_merchant_account>
            <status>active</status>
        </merchant_account>
        ";
    }

    private static function _merchantAccountDeclinedSampleXml($id)
    {
        return "
        <api-error-response>
            <message>Credit score is too low</message>
            <errors>
                <errors type=\"array\"/>
                    <merchant-account>
                        <errors type=\"array\">
                            <error>
                                <code>82621</code>
                                <message>Credit score is too low</message>
                                <attribute type=\"symbol\">base</attribute>
                            </error>
                        </errors>
                    </merchant-account>
                </errors>
                <merchant-account>
                    <id>{$id}</id>
                    <status>suspended</status>
                    <master-merchant-account>
                        <id>master_ma_for_{$id}</id>
                        <status>suspended</status>
                    </master-merchant-account>
                </merchant-account>
        </api-error-response>
        ";
    }

    private static function _transactionDisbursedSampleXml($id)
    {
        return "
        <transaction>
            <id>${id}</id>
            <amount>100</amount>
            <disbursement-details>
                <disbursement-date type=\"date\">2013-07-09</disbursement-date>
            </disbursement-details>
        </transaction>
        ";
    }

    private static function _disbursementExceptionSampleXml($id)
    {
        return "
        <disbursement>
          <id>${id}</id>
          <transaction-ids type=\"array\">
            <item>asdfg</item>
            <item>qwert</item>
          </transaction-ids>
          <success type=\"boolean\">false</success>
          <retry type=\"boolean\">false</retry>
          <merchant-account>
            <id>merchant_account_token</id>
            <currency-iso-code>USD</currency-iso-code>
            <sub-merchant-account type=\"boolean\">false</sub-merchant-account>
            <status>active</status>
          </merchant-account>
          <amount>100.00</amount>
          <disbursement-date type=\"date\">2014-02-10</disbursement-date>
          <exception-message>bank_rejected</exception-message>
          <follow-up-action>update_funding_information</follow-up-action>
        </disbursement>
        ";
    }

    private static function _disbursementSampleXml($id)
    {
        return "
        <disbursement>
          <id>${id}</id>
          <transaction-ids type=\"array\">
            <item>asdfg</item>
            <item>qwert</item>
          </transaction-ids>
          <success type=\"boolean\">true</success>
          <retry type=\"boolean\">false</retry>
          <merchant-account>
            <id>merchant_account_token</id>
            <currency-iso-code>USD</currency-iso-code>
            <sub-merchant-account type=\"boolean\">false</sub-merchant-account>
            <status>active</status>
          </merchant-account>
          <amount>100.00</amount>
          <disbursement-date type=\"date\">2014-02-10</disbursement-date>
          <exception-message nil=\"true\"/>
          <follow-up-action nil=\"true\"/>
        </disbursement>
        ";
    }

    private static function _disputeOpenedSampleXml($id)
    {
        return "
        <dispute>
          <amount>250.00</amount>
          <currency-iso-code>USD</currency-iso-code>
          <received-date type=\"date\">2014-03-01</received-date>
          <reply-by-date type=\"date\">2014-03-21</reply-by-date>
          <kind>chargeback</kind>
          <status>open</status>
          <reason>fraud</reason>
          <id>${id}</id>
          <transaction>
            <id>${id}</id>
            <amount>250.00</amount>
          </transaction>
          <date-opened type=\"date\">2014-03-21</date-opened>
        </dispute>
        ";
    }

    private static function _disputeLostSampleXml($id)
    {
        return "
        <dispute>
          <amount>250.00</amount>
          <currency-iso-code>USD</currency-iso-code>
          <received-date type=\"date\">2014-03-01</received-date>
          <reply-by-date type=\"date\">2014-03-21</reply-by-date>
          <kind>chargeback</kind>
          <status>lost</status>
          <reason>fraud</reason>
          <id>${id}</id>
          <transaction>
            <id>${id}</id>
            <amount>250.00</amount>
          </transaction>
          <date-opened type=\"date\">2014-03-21</date-opened>
        </dispute>
        ";
    }

    private static function _disputeWonSampleXml($id)
    {
        return "
        <dispute>
          <amount>250.00</amount>
          <currency-iso-code>USD</currency-iso-code>
          <received-date type=\"date\">2014-03-01</received-date>
          <reply-by-date type=\"date\">2014-03-21</reply-by-date>
          <kind>chargeback</kind>
          <status>won</status>
          <reason>fraud</reason>
          <id>${id}</id>
          <transaction>
            <id>${id}</id>
            <amount>250.00</amount>
          </transaction>
          <date-opened type=\"date\">2014-03-21</date-opened>
          <date-won type=\"date\">2014-03-22</date-won>
        </dispute>
        ";
    }

    private static function _subscriptionSampleXml($id)
    {
        return "
        <subscription>
            <id>{$id}</id>
            <transactions type=\"array\">
            </transactions>
            <add_ons type=\"array\">
            </add_ons>
            <discounts type=\"array\">
            </discounts>
        </subscription>
        ";
    }

    private static function _subscriptionChargedSuccessfullySampleXml($id)
    {
        return "
        <subscription>
            <id>{$id}</id>
            <billing-period-start-date type=\"date\">2016-03-21</billing-period-start-date>
            <billing-period-end-date type=\"date\">2017-03-31</billing-period-end-date>
            <transactions type=\"array\">
                <transaction>
                    <status>submitted_for_settlement</status>
                    <amount>49.99</amount>
                </transaction>
            </transactions>
            <add_ons type=\"array\">
            </add_ons>
            <discounts type=\"array\">
            </discounts>
        </subscription>
        ";
    }

    private static function _checkSampleXml()
    {
        return "
            <check type=\"boolean\">true</check>
        ";
    }

    private static function _partnerMerchantConnectedSampleXml($id)
    {
        return "
        <partner-merchant>
          <merchant-public-id>public_id</merchant-public-id>
          <public-key>public_key</public-key>
          <private-key>private_key</private-key>
          <partner-merchant-id>abc123</partner-merchant-id>
          <client-side-encryption-key>cse_key</client-side-encryption-key>
        </partner-merchant>
        ";
    }

    private static function _partnerMerchantDisconnectedSampleXml($id)
    {
        return "
        <partner-merchant>
          <partner-merchant-id>abc123</partner-merchant-id>
        </partner-merchant>
        ";
    }

    private static function _partnerMerchantDeclinedSampleXml($id)
    {
        return "
        <partner-merchant>
          <partner-merchant-id>abc123</partner-merchant-id>
        </partner-merchant>
        ";
    }

    private static function _accountUpdaterDailyReportSampleXml($id)
    {
        return "
        <account-updater-daily-report>
            <report-date type=\"date\">2016-01-14</report-date>
            <report-url>link-to-csv-report</report-url>
        </account-updater-daily-report>
        ";
    }

    private static function _timestamp()
    {
        $originalZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strftime('%Y-%m-%dT%TZ');
        date_default_timezone_set($originalZone);

        return $timestamp;
    }
}
class_alias('Braintree\WebhookTesting', 'Braintree_WebhookTesting');
