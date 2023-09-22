<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2017 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class DirectLink
{

    const URL_TEST = 'https://secure.ogone.com/ncol/test/';
    const URL_PROD = 'https://secure.ogone.com/ncol/prod/';

    const ENDPOINT_ORDER = 'orderdirect.asp';
    const ENDPOINT_MAINTENANCE = 'maintenancedirect.asp';
    const ENDPOINT_QUERY = 'querydirect.asp';

    const REQUEST_ORDER = 'order';
    const REQUEST_MAINTENANCE = 'maintenance';
    const REQUEST_QUERY = 'query';

    /*
     * SAL: partial data capture (payment), leaving the transaction open for another potential data capture.
     * SAS: (last) partial or full data capture (payment), closing the transaction (for further data captures) after
     * RFD: partial refund (on a paid order), leaving the transaction open for another potential refund.
     * RFS: (last) partial or full refund (on a paid order), closing the transaction after this refund.
     * DEL: delete authorisation, leaving the transaction open for further potential maintenance operations.
     * DES: delete authorisation, closing the transaction after this operation.
     * PAU: Request for pre-authorisation:  You can use this operation code to temporarily reserve funds on a card.
     */
    const RENEWAL = 'REN';
    const DELETE = 'DEL';
    const DELETE_AND_CLOSE = 'DES';
    const CAPTURE = 'SAL';
    const CAPTURE_AND_CLOSE = 'SAS';
    const REFUND = 'RFD';
    const REFUND_AND_CLOSE = 'RFS';
    const PRE_AUTHORISATION = 'PAU';

    /**
     * @see https://payment-services.ingenico.com/int/en/ogone/support/guides/user%20guides/statuses-and-errors
     */
    const STATUS_INVALID = 0;
    const STATUS_CANCELLED = 1;
    const STATUS_REFUSED = 2;
    const STATUS_STORED = 4;
    const STATUS_STORED_WAITING_EXTERNAL = 40;
    const STATUS_STORED_WAITING_CLIENT = 41;
    const STATUS_WAITING_FOR_IDENTIFICATION = 46;
    const STATUS_AUTHORISED = 5;
    const STATUS_AUTHORISED_WAITING_EXTERNAL = 50;
    const STATUS_AUTHORISATION_WAITING = 51;
    const STATUS_AUTHORISATION_NOT_KNOWN = 52;
    const STATUS_STANDBY = 55;
    const STATUS_SCHEDULED_OK = 56;
    const STATUS_SCHEDULED_NOT_OK = 57;
    const STATUS_NEEDS_MANUAL_REQUEST = 59;
    const STATUS_AUTHORISED_AND_CANCELLED = 6;
    const STATUS_AUTHORISATION_DELETION_WAITING = 61;
    const STATUS_AUTHORISATION_DELETION_UNCERTAIN = 62;
    const STATUS_AUTHORISATION_DELETION_REFUSED = 63;
    const STATUS_AUTHORISED_AND_CANCELLED_INTERMEDIARY = 64;
    const STATUS_PAYMENT_DELETED = 7;
    const STATUS_PAYMENT_DELETION_PENDING = 71;
    const STATUS_PAYMENT_DELETION_UNCERTAIN = 72;
    const STATUS_PAYMENT_DELETION_REFUSED = 73;
    const STATUS_PAYMENT_DELETED_INTERMEDIARY = 74;
    const STATUS_PAYMENT_DELETION_HANDLED_BY_MERCHANT = 75;
    const STATUS_REFUND = 8;
    const STATUS_REFUND_PENDING = 81;
    const STATUS_REFUND_UNCERTAIN = 82;
    const STATUS_REFUND_REFUSED = 83;
    const STATUS_REFUND_INTERMEDIARY = 84;
    const STATUS_REFUND_HANDLED_BY_MERCHANT = 85;
    const STATUS_CAPTURED = 9;
    const STATUS_PAYMENT_PROCESSING = 91;
    const STATUS_PAYMENT_UNCERTAIN = 92;
    const STATUS_PAYMENT_REFUSED = 93;
    const STATUS_PAYMENT_DECLINED = 94;
    const STATUS_PAYMENT_HANDLED_BY_MERCHANT = 95;
    const STATUS_PAYMENT_REVERSED = 96;
    const STATUS_PAYMENT_BEING_PROCESSED = 99;

    /**
     * Merchant's PSPID
     * @var string
     */
    protected $pspid = '';

    /**
     * API base url (production or test)
     * @var string
     */
    protected $url = '';

    /**
     * User account with API activated
     * @var string
     */
    protected $userid = '';

    /**
     * User (not PSPID !) password
     * @var string
     */
    protected $password = '';

    /**
     * SHA-IN passphrase. Attention: DirectLink's and e-commerce's passphrases are differents
     * @var string
     */
    protected $shain = '';

    /**
     * SHA-OUT passphrase. Attention: DirectLink's and e-commerce's passphrases are differents
     * @var string
     */
    protected $shaout = '';

    /**
     * If true, debug mode is activated
     * @var bool
     */
    protected $debug = false;

    /**
     * Timeout
     * @var integer
     */
    protected $timeout = 0;

    /**
     * Default curl options
     * @var array
     */
    protected $curl_options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
    );

    public function setTimeout($timeout)
    {
        $this->timeout = max((int) $timeout, 0);
        return $this;
    }

    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = (string) $url;
        return $this;
    }

    public function setUserId($userid)
    {
        $this->userid = (string) $userid;
        return $this;
    }

    public function setPSPId($pspid)
    {
        $this->pspid = (string) $pspid;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }

    public function setCurlOptions(array $options)
    {
        $this->curl_options = $options;
        return $this;
    }

    public function setShaInPassphrase($shain)
    {
        $this->shain = (string) $shain;
        return $this;
    }

    public function setShaOutPassphrase($shaout)
    {
        $this->shaout = (string) $shaout;
        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getPSPId()
    {
        return $this->pspid;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCurlOptions()
    {
        return $this->curl_options;
    }

    public function getShaInPassphrase()
    {
        return $this->shain;
    }

    public function getShaOutPassphrase()
    {
        return $this->shaout;
    }

    public function test()
    {
        return $this->request(self::REQUEST_ORDER, array('ORDERID' => 0));
    }

    public function query($data)
    {
        if (!is_array($data) || (!(isset($data['ORDERID']) || isset($data['PAYID'])))) {
            throw new InvalidArgumentException('[DirectLink] Query request should have ORDERID or PAYID defined!');
        }

        return $this->request(self::REQUEST_QUERY, $data);
    }

    public function maintenance($data)
    {
        if (!is_array($data) ||
            !array_key_exists('AMOUNT', $data) ||
            !isset($data['OPERATION']) ||
            !(isset($data['ORDERID']) || isset($data['PAYID']))) {
            $present_keys = implode(', ', array_keys($data));
            $message = 'Maintenance request should have AMOUNT, OPERATION and ORDERID/PAYID defined, keys present: %s';
            $message = sprintf($message, $present_keys);
            throw new InvalidArgumentException($message);
        }
        return $this->request(self::REQUEST_MAINTENANCE, $data);
    }

    public function order($data)
    {
        return $this->request(self::REQUEST_ORDER, $data);
    }

    /**
     * Makes DirectLink request and returns parsed response
     * @param string $request Order, maintenance or query
     * @param array $data Request parameters
     * @return array Parsed resoponse
     */
    public function request($request, array $data)
    {
        if (!$this->isInitialized()) {
            throw new Exception('[DirectLink] Needed params : url, pspid, user, user pass, shain, shaout');
        }

        $url = $this->getUrl() . $this->getEndpoint($request);

        $data = $data + $this->getCredentials();

        $data['SHASIGN'] = DirectLink::getShaSign($data, $this->getShaInPassphrase());

        Module::getInstanceByName('ogone')->log(var_export($data, true));

        $response = $this->doCurlRequest($url, $data);

        Module::getInstanceByName('ogone')->log(var_export($response, true));

        $parsed_response = $this->parseResponse($response);

        return $parsed_response;
    }

    /**
     * Checks whether DirectLink can be used
     * @return boolean
     */
    public function checkPrerequisites()
    {
        return function_exists('curl_init') && function_exists('simplexml_load_string');
    }

    /**
     * Checks whether DirectLink is properly initialized
     * @return boolean
     */
    public function isInitialized()
    {
        return $this->getUrl() !== '' &&
        $this->getUserId() !== '' &&
        $this->getPSPId() !== '' &&
        $this->getPassword() !== '' &&
        $this->getShaInPassphrase() !== '' &&
        $this->getShaOutPassphrase() !== '';
    }

    /**
     * Generates SHA signature
     * @see https://payment-services.ingenico.com/int/en/ogone/support/guides/integration%20guides/e-commerce/
     * @param array $data
     * @param string $passphrase
     * @return string
     */
    public static function getShaSign(array $data, $passphrase)
    {
        if ($passphrase == '') {
            throw new Exception('Passphrase cannot be empty!');
        }

        $elements = array();
        /* All parameters have to be arranged alphabetically; */
        uksort($data, array('DirectLink', 'compareStringAsOgone'));
        foreach ($data as $key => $value) {
            /* Parameters that do not have a value should NOT be included in the string to hash */
            if ($value === null || $value === '') {
                continue;
            }
            if (!preg_match('!!u', $value)) {
                $value = utf8_encode($value);
            }

            /* All parameter names should be in UPPERCASE (to avoid any case confusion); */
            $key = Tools::strtoupper($key);

            $elements[] = sprintf('%s=%s', $key, $value);
        }

        /* To add passphrase at the end */
        $elements[] = '';

        $signature = implode((string) $passphrase, $elements);
        return Tools::strtoupper(sha1($signature));
    }

    /**
     * Generates unique alias in form of arg1_arg2_argn_<randomized_hash>
     * Alias has length limit of 50 characters on Ingenico side, we are cutting on 42 characters
     * @param $arg1,$arg2,... Arguments to include in alias
     * @return string
     */
    public function generateAlias()
    {
        $static_part = implode('_', array_map('strval', func_get_args()));
        $seed = sprintf('%d*%d*%s', time(), mt_rand(0, 1000000000), $this->getShaInPassphrase());
        return Tools::substr($static_part . '_' . sha1($seed), 0, 42);
    }

    /**
     * Returns endpoint in function of request type
     * @param string $request Order, maintenance or query
     * @return string Endpoint
     * @throws Exception
     */
    protected function getEndpoint($request)
    {
        switch ($request) {
            case self::REQUEST_ORDER:
                $result =  self::ENDPOINT_ORDER;
                break;
            case self::REQUEST_MAINTENANCE:
                $result =  self::ENDPOINT_MAINTENANCE;
                break;
            case self::REQUEST_QUERY:
                $result = self::ENDPOINT_QUERY;
                break;
            default:
                throw new Exception(sprintf('[DirectLink] Unknown request type %s', $request));
        }
        return $result;
    }

    /**
     * Making real request
     * @param string $url
     * @param array $data
     * @return string Request's raw result
     * @throws Exception
     */
    protected function doCurlRequest($url, array $data)
    {
        if ($this->getDebug()) {
            echo PHP_EOL . $url;
        }

        $handle = curl_init($url);
        if (!$handle) {
            throw new Exception('[DirectLink] curl error : unable initialize curl');
        }

        $error = null;
        curl_setopt_array($handle, $this->getCurlOptions());
        if ($this->getTimeout() > 0) {
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $this->getTimeout());
        }

        /* (Ingenico) Content-Type entity-header field in the POST needs to be "application/x-www-form-urlencoded".
            array in CURLOPT_POSTFIELDS set multipart/form-data,
            passing a URL-encoded string set application/x-www-form-urlencoded. */
        $request_string = http_build_query($data);
        if ($this->getDebug()) {
            echo PHP_EOL . PHP_EOL . $request_string . PHP_EOL;
        }

        curl_setopt($handle, CURLOPT_POSTFIELDS, $request_string);
        $result = curl_exec($handle);
        if ($this->getDebug()) {
            echo PHP_EOL . $result . PHP_EOL . PHP_EOL;
        }
        if (!$result) {
            $error = curl_error($handle);
        }

        curl_close($handle);
        if ($error !== null) {
            throw new Exception(sprintf('[DirectLink] curl error : %s', $error));
        }

        return $result;
    }

    /**
     * Return credentials that should be included in every request
     * @return array of string:string
     */
    protected function getCredentials()
    {
        $result = array(
            'PSPID' => $this->getPSPId(),
            'PSWD' => $this->getPassword(),
        );
        if ($this->getUserId()) {
            $result['USERID'] = $this->getUserId();
        }

        return $result;
    }

    /**
     * @param string $response
     * @throws Exception
     * @return array
     */
    protected function parseResponse($response)
    {
        if (empty($response)) {
            throw new Exception('[DirectLink] response cannot be empty');
        }

        libxml_use_internal_errors(true);
        if (!preg_match('!!u', $response)) {
            $response = utf8_encode($response);
        }
        $xml = simplexml_load_string($response);
        if ($xml === false) {
            $messages = array();
            foreach (libxml_get_errors() as $error) {
                $messages[] = sprintf('%d:%d %s', $error->line - 1, $error->column, $error->message);
            }

            libxml_clear_errors();
            throw new Exception(sprintf('[DirectLink] response xml parsing error %s', implode("\t\n", $messages)));
        }
        $encoded = Tools::jsonEncode($xml);
        if ($encoded === false) {
            $json_error = function_exists('json_last_error') ? json_last_error() : 'unspecified json error';
            throw new Exception(sprintf('[DirectLink] response conversion error (encoding) : %s', $json_error));
        }
        $decoded = Tools::jsonDecode($encoded, true);
        if ($decoded === false) {
            $json_error = function_exists('json_last_error') ? json_last_error() : 'unspecified json error';
            throw new Exception(sprintf('[DirectLink] response conversion error (decoding) : %s', $json_error));
        }
        if ($decoded && is_array($decoded) && isset($decoded['@attributes'])) {
            $result = $decoded['@attributes'];
            if (is_array($result)) {
                foreach ($decoded as $key => $value) {
                    if ($key !== '@attributes') {
                        $result[$key] = $value;
                    }
                }
                $result = array_change_key_case($result, CASE_UPPER);
                return $result;
            }
        }
        throw new Exception(sprintf('Unable to parse response %s', (string) $response));
    }

    /**
     * Ogone sorts SCO_CATEGORY before SCORING, PHP sorts in reverse order
     * BUT, surprise, surprise - SUBSCRIPTION_ID goes before SUB_AMOUNT
     * If not handled properly, can affect SHA Signature generation
     * @param unknown $a
     * @param unknown $b
     */
    public static function compareStringAsOgone($a, $b)
    {
        $temp_a = str_replace('_', '0', str_replace('SUB_', 'SUBZ', $a));
        $temp_b = str_replace('_', '0', str_replace('SUB_', 'SUBZ', $b));
        return strnatcmp($temp_a, $temp_b);
    }
}
