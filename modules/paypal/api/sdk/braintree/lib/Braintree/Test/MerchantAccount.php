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

namespace Braintree\Test;

/**
 * Merchant Account constants used for testing purposes
 *
 * @package    Braintree
 * @subpackage Test
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */
class MerchantAccount
{
    public static $approve = "approve_me";

    public static $insufficientFundsContactUs = "insufficient_funds__contact";
    public static $accountNotAuthorizedContactUs = "account_not_authorized__contact";
    public static $bankRejectedUpdateFundingInformation = "bank_rejected__update";
    public static $bankRejectedNone = "bank_rejected__none";


}
class_alias('Braintree\Test\MerchantAccount', 'Braintree_Test_MerchantAccount');
