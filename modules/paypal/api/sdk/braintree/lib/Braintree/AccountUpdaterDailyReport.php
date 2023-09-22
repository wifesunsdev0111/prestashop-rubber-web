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
 * Creates an instance of AccountUpdaterDailyReport
 *
 *
 * @package    Braintree
 * @copyright  2016 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $reportUrl
 * @property-read date   $reportDate
 * @property-read date   $receivedDate
 */
final class AccountUpdaterDailyReport extends Base
{
    protected $_attributes = [];

    protected function _initialize($disputeAttribs)
    {
        $this->_attributes = $disputeAttribs;
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
            'reportDate', 'reportUrl'
            ];

        $displayAttributes = [];
        foreach ($display AS $attrib) {
            $displayAttributes[$attrib] = $this->$attrib;
        }
        return __CLASS__ . '[' .
                Util::attributesToString($displayAttributes) .']';
    }
}
class_alias('Braintree\AccountUpdaterDailyReport', 'Braintree_AccountUpdaterDailyReport');
