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

namespace Braintree\Exception;

use Braintree\Exception;

/**
 * Raised when authorization fails
 * Raised when the API key being used is not authorized to perform
 * the attempted action according to the roles assigned to the user
 * who owns the API key.
 *
 * @package    Braintree
 * @subpackage Exception
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */
class Authorization extends Exception
{

}
class_alias('Braintree\Exception\Authorization', 'Braintree_Exception_Authorization');
