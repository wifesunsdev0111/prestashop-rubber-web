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
 * Partner Merchant information that is generated when a partner is connected
 * to or disconnected from a user.
 *
 * Creates an instance of PartnerMerchants
 *
 * @package    Braintree
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $merchantPublicId
 * @property-read string $publicKey
 * @property-read string $privateKey
 * @property-read string $clientSideEncryptionKey
 * @property-read string $partnerMerchantId
 */
class PartnerMerchant extends Base
{
    protected $_attributes = [];

    /**
     * @ignore
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);

        return $instance;
    }

    /**
     * @ignore
     */
    protected function _initialize($attributes)
    {
        $this->_attributes = $attributes;
    }
}
class_alias('Braintree\PartnerMerchant', 'Braintree_PartnerMerchant');
