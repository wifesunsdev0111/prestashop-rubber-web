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

final class Disbursement extends Base
{
    private $_merchantAccount;

    protected function _initialize($disbursementAttribs)
    {
        $this->_attributes = $disbursementAttribs;
        $this->merchantAccountDetails = $disbursementAttribs['merchantAccount'];

        if (isset($disbursementAttribs['merchantAccount'])) {
            $this->_set('merchantAccount',
                MerchantAccount::factory($disbursementAttribs['merchantAccount'])
            );
        }
    }

    public function transactions()
    {
        $collection = Transaction::search([
            TransactionSearch::ids()->in($this->transactionIds),
        ]);

        return $collection;
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
            'id', 'merchantAccountDetails', 'exceptionMessage', 'amount',
            'disbursementDate', 'followUpAction', 'retry', 'success',
            'transactionIds'
            ];

        $displayAttributes = [];
        foreach ($display AS $attrib) {
            $displayAttributes[$attrib] = $this->$attrib;
        }
        return __CLASS__ . '[' .
                Util::attributesToString($displayAttributes) .']';
    }
}
class_alias('Braintree\Disbursement', 'Braintree_Disbursement');
