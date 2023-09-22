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
 * Creates an instance of Dispute as returned from a transaction
 *
 *
 * @package    Braintree
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $amount
 * @property-read string $currencyIsoCode
 * @property-read date   $receivedDate
 * @property-read string $reason
 * @property-read string $status
 * @property-read string $disbursementDate
 * @property-read object $transactionDetails
 */
final class Dispute extends Base
{
    protected $_attributes = [];

    /* Dispute Status */
    const OPEN  = 'open';
    const WON  = 'won';
    const LOST = 'lost';

    /* deprecated; for backwards compatibilty */
    const Open  = 'open';

    /* Dispute Reason */
    const CANCELLED_RECURRING_TRANSACTION = "cancelled_recurring_transaction";
    const CREDIT_NOT_PROCESSED            = "credit_not_processed";
    const DUPLICATE                       = "duplicate";
    const FRAUD                           = "fraud";
    const GENERAL                         = "general";
    const INVALID_ACCOUNT                 = "invalid_account";
    const NOT_RECOGNIZED                  = "not_recognized";
    const PRODUCT_NOT_RECEIVED            = "product_not_received";
    const PRODUCT_UNSATISFACTORY          = "product_unsatisfactory";
    const TRANSACTION_AMOUNT_DIFFERS      = "transaction_amount_differs";
    const RETRIEVAL                       = "retrieval";

    /* Dispute Kind */
    const CHARGEBACK      = 'chargeback';
    const PRE_ARBITRATION = 'pre_arbitration';
    // RETRIEVAL for kind already defined under Dispute Reason

    protected function _initialize($disputeAttribs)
    {
        $this->_attributes = $disputeAttribs;

        if (isset($disputeAttribs['transaction'])) {
            $this->_set('transactionDetails',
                new Dispute\TransactionDetails($disputeAttribs['transaction'])
            );
        }
    }

    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    public function  __toString()
    {
        $display = [
            'amount', 'reason', 'status',
            'replyByDate', 'receivedDate', 'currencyIsoCode'
            ];

        $displayAttributes = [];
        foreach ($display AS $attrib) {
            $displayAttributes[$attrib] = $this->$attrib;
        }
        return __CLASS__ . '[' .
                Util::attributesToString($displayAttributes) .']';
    }
}
class_alias('Braintree\Dispute', 'Braintree_Dispute');
