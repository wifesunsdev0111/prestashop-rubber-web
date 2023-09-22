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
 * Braintree Gateway module
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */
class Gateway
{
    /**
     *
     * @var Configuration
     */
    public $config;

    public function __construct($config)
    {
        if (is_array($config)) {
            $config = new Configuration($config);
        }
        $this->config = $config;
    }

    /**
     *
     * @return AddOnGateway
     */
    public function addOn()
    {
        return new AddOnGateway($this);
    }

    /**
     *
     * @return AddressGateway
     */
    public function address()
    {
        return new AddressGateway($this);
    }

    /**
     *
     * @return ClientTokenGateway
     */
    public function clientToken()
    {
        return new ClientTokenGateway($this);
    }

    /**
     *
     * @return CreditCardGateway
     */
    public function creditCard()
    {
        return new CreditCardGateway($this);
    }

    /**
     *
     * @return CreditCardVerificationGateway
     */
    public function creditCardVerification()
    {
        return new CreditCardVerificationGateway($this);
    }

    /**
     *
     * @return CustomerGateway
     */
    public function customer()
    {
        return new CustomerGateway($this);
    }

    /**
     *
     * @return DiscountGateway
     */
    public function discount()
    {
        return new DiscountGateway($this);
    }

    /**
     *
     * @return MerchantGateway
     */
    public function merchant()
    {
        return new MerchantGateway($this);
    }

    /**
     *
     * @return MerchantAccountGateway
     */
    public function merchantAccount()
    {
        return new MerchantAccountGateway($this);
    }

    /**
     *
     * @return OAuthGateway
     */
    public function oauth()
    {
        return new OAuthGateway($this);
    }

    /**
     *
     * @return PaymentMethodGateway
     */
    public function paymentMethod()
    {
        return new PaymentMethodGateway($this);
    }

    /**
     *
     * @return PaymentMethodNonceGateway
     */
    public function paymentMethodNonce()
    {
        return new PaymentMethodNonceGateway($this);
    }

    /**
     *
     * @return PayPalAccountGateway
     */
    public function payPalAccount()
    {
        return new PayPalAccountGateway($this);
    }

    /**
     *
     * @return PlanGateway
     */
    public function plan()
    {
        return new PlanGateway($this);
    }

    /**
     *
     * @return SettlementBatchSummaryGateway
     */
    public function settlementBatchSummary()
    {
        return new SettlementBatchSummaryGateway($this);
    }

    /**
     *
     * @return SubscriptionGateway
     */
    public function subscription()
    {
        return new SubscriptionGateway($this);
    }

    /**
     *
     * @return TestingGateway
     */
    public function testing()
    {
        return new TestingGateway($this);
    }

    /**
     *
     * @return TransactionGateway
     */
    public function transaction()
    {
        return new TransactionGateway($this);
    }

    /**
     *
     * @return TransparentRedirectGateway
     */
    public function transparentRedirect()
    {
        return new TransparentRedirectGateway($this);
    }
}
class_alias('Braintree\Gateway', 'Braintree_Gateway');
