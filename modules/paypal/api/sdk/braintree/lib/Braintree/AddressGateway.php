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

use InvalidArgumentException;

/**
 * Braintree AddressGateway module
 * PHP Version 5
 * Creates and manages Braintree Addresses
 *
 * An Address belongs to a Customer. It can be associated to a
 * CreditCard as the billing address. It can also be used
 * as the shipping address when creating a Transaction.
 *
 * @package   Braintree
 * @copyright 2015 Braintree, a division of PayPal, Inc.
 */
class AddressGateway
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


    /* public class methods */
    /**
     *
     * @access public
     * @param  array  $attribs
     * @return Result\Successful|Result\Error
     */
    public function create($attribs)
    {
        Util::verifyKeys(self::createSignature(), $attribs);
        $customerId = isset($attribs['customerId']) ?
            $attribs['customerId'] :
            null;

        $this->_validateCustomerId($customerId);
        unset($attribs['customerId']);
        return $this->_doCreate(
            '/customers/' . $customerId . '/addresses',
            ['address' => $attribs]
        );
    }

    /**
     * attempts the create operation assuming all data will validate
     * returns a Address object instead of a Result
     *
     * @access public
     * @param  array $attribs
     * @return self
     * @throws Exception\ValidationError
     */
    public function createNoValidate($attribs)
    {
        $result = $this->create($attribs);
        return Util::returnObjectOrThrowException(__CLASS__, $result);

    }

    /**
     * delete an address by id
     *
     * @param mixed $customerOrId
     * @param string $addressId
     */
    public function delete($customerOrId = null, $addressId = null)
    {
        $this->_validateId($addressId);
        $customerId = $this->_determineCustomerId($customerOrId);
        $path = $this->_config->merchantPath() . '/customers/' . $customerId . '/addresses/' . $addressId;
        $this->_http->delete($path);
        return new Result\Successful();
    }

    /**
     * find an address by id
     *
     * Finds the address with the given <b>addressId</b> that is associated
     * to the given <b>customerOrId</b>.
     * If the address cannot be found, a NotFound exception will be thrown.
     *
     *
     * @access public
     * @param mixed $customerOrId
     * @param string $addressId
     * @return Address
     * @throws Exception\NotFound
     */
    public function find($customerOrId, $addressId)
    {

        $customerId = $this->_determineCustomerId($customerOrId);
        $this->_validateId($addressId);

        try {
            $path = $this->_config->merchantPath() . '/customers/' . $customerId . '/addresses/' . $addressId;
            $response = $this->_http->get($path);
            return Address::factory($response['address']);
        } catch (Exception\NotFound $e) {
            throw new Exception\NotFound(
            'address for customer ' . $customerId .
                ' with id ' . $addressId . ' not found.'
            );
        }

    }

    /**
     * updates the address record
     *
     * if calling this method in context,
     * customerOrId is the 2nd attribute, addressId 3rd.
     * customerOrId & addressId are not sent in object context.
     *
     *
     * @access public
     * @param array $attributes
     * @param mixed $customerOrId (only used in call)
     * @param string $addressId (only used in call)
     * @return Result\Successful|Result\Error
     */
    public function update($customerOrId, $addressId, $attributes)
    {
        $this->_validateId($addressId);
        $customerId = $this->_determineCustomerId($customerOrId);
        Util::verifyKeys(self::updateSignature(), $attributes);

        $path = $this->_config->merchantPath() . '/customers/' . $customerId . '/addresses/' . $addressId;
        $response = $this->_http->put($path, ['address' => $attributes]);

        return $this->_verifyGatewayResponse($response);

    }

    /**
     * update an address record, assuming validations will pass
     *
     * if calling this method in context,
     * customerOrId is the 2nd attribute, addressId 3rd.
     * customerOrId & addressId are not sent in object context.
     *
     * @access public
     * @param array $transactionAttribs
     * @param string $customerId
     * @return Transaction
     * @throws Exception\ValidationsFailed
     * @see Address::update()
     */
    public function updateNoValidate($customerOrId, $addressId, $attributes)
    {
        $result = $this->update($customerOrId, $addressId, $attributes);
        return Util::returnObjectOrThrowException(__CLASS__, $result);
    }

    /**
     * creates a full array signature of a valid create request
     * @return array gateway create request format
     */
    public static function createSignature()
    {
        return [
            'company', 'countryCodeAlpha2', 'countryCodeAlpha3', 'countryCodeNumeric',
            'countryName', 'customerId', 'extendedAddress', 'firstName',
            'lastName', 'locality', 'postalCode', 'region', 'streetAddress'
        ];
    }

    /**
     * creates a full array signature of a valid update request
     * @return array gateway update request format
     */
    public static function updateSignature()
    {
        // TODO: remove customerId from update signature
        return self::createSignature();

    }

    /**
     * verifies that a valid address id is being used
     * @ignore
     * @param string $id address id
     * @throws InvalidArgumentException
     */
    private function _validateId($id = null)
    {
        if (empty($id) || trim($id) == "") {
            throw new InvalidArgumentException(
            'expected address id to be set'
            );
        }
        if (!preg_match('/^[0-9A-Za-z_-]+$/', $id)) {
            throw new InvalidArgumentException(
            $id . ' is an invalid address id.'
            );
        }
    }

    /**
     * verifies that a valid customer id is being used
     * @ignore
     * @param string $id customer id
     * @throws InvalidArgumentException
     */
    private function _validateCustomerId($id = null)
    {
        if (empty($id) || trim($id) == "") {
            throw new InvalidArgumentException(
            'expected customer id to be set'
            );
        }
        if (!preg_match('/^[0-9A-Za-z_-]+$/', $id)) {
            throw new InvalidArgumentException(
            $id . ' is an invalid customer id.'
            );
        }

    }

    /**
     * determines if a string id or Customer object was passed
     * @ignore
     * @param mixed $customerOrId
     * @return string customerId
     */
    private function _determineCustomerId($customerOrId)
    {
        $customerId = ($customerOrId instanceof Customer) ? $customerOrId->id : $customerOrId;
        $this->_validateCustomerId($customerId);
        return $customerId;

    }

    /* private class methods */
    /**
     * sends the create request to the gateway
     * @ignore
     * @param string $subPath
     * @param array $params
     * @return Result\Successful|Result\Error
     */
    private function _doCreate($subPath, $params)
    {
        $fullPath = $this->_config->merchantPath() . $subPath;
        $response = $this->_http->post($fullPath, $params);

        return $this->_verifyGatewayResponse($response);

    }

    /**
     * generic method for validating incoming gateway responses
     *
     * creates a new Address object and encapsulates
     * it inside a Result\Successful object, or
     * encapsulates an Errors object inside a Result\Error
     * alternatively, throws an Unexpected exception if the response is invalid
     *
     * @ignore
     * @param array $response gateway response values
     * @return Result\Successful|Result\Error
     * @throws Exception\Unexpected
     */
    private function _verifyGatewayResponse($response)
    {
        if (isset($response['address'])) {
            // return a populated instance of Address
            return new Result\Successful(
                Address::factory($response['address'])
            );
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
            "Expected address or apiErrorResponse"
            );
        }

    }
}
class_alias('Braintree\AddressGateway', 'Braintree_AddressGateway');
