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
 *
 * CredentialsParser registry
 *
 * @package    Braintree
 * @subpackage Utility
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */

class CredentialsParser
{
    private $_clientId;
    private $_clientSecret;
    private $_accessToken;
    private $_environment;
    private $_merchantId;

    public function __construct($attribs)
    {
        foreach ($attribs as $kind => $value) {
            if ($kind == 'clientId') {
                $this->_clientId = $value;
            }
            if ($kind == 'clientSecret') {
                $this->_clientSecret = $value;
            }
            if ($kind == 'accessToken') {
                $this->_accessToken = $value;
            }
        }
        $this->parse();
    }

    /**
     *
     * @access protected
     * @static
     * @var array valid environments, used for validation
     */
    private static $_validEnvironments = [
        'development',
        'integration',
        'sandbox',
        'production',
        'qa',
    ];


    public function parse()
    {
        $environments = [];
        if (!empty($this->_clientId)) {
            $environments[] = ['clientId', $this->_parseClientCredential('clientId', $this->_clientId, 'client_id')];
        }
        if (!empty($this->_clientSecret)) {
            $environments[] = ['clientSecret', $this->_parseClientCredential('clientSecret', $this->_clientSecret, 'client_secret')];
        }
        if (!empty($this->_accessToken)) {
            $environments[] = ['accessToken', $this->_parseAccessToken()];
        }

        $checkEnv = $environments[0];
        foreach ($environments as $env) {
            if ($env[1] !== $checkEnv[1]) {
                throw new Exception\Configuration(
                    'Mismatched credential environments: ' . $checkEnv[0] . ' environment is ' . $checkEnv[1] .
                    ' and ' . $env[0] . ' environment is ' . $env[1]);
            }
        }

        self::assertValidEnvironment($checkEnv[1]);
        $this->_environment = $checkEnv[1];
    }

    public static function assertValidEnvironment($environment) {
        if (!in_array($environment, self::$_validEnvironments)) {
            throw new Exception\Configuration('"' .
                                    $environment . '" is not a valid environment.');
        }
    }

    private function _parseClientCredential($credentialType, $value, $expectedValuePrefix)
    {
        $explodedCredential = explode('$', $value);
        if (sizeof($explodedCredential) != 3) {
            throw new Exception\Configuration('Incorrect ' . $credentialType . ' format. Expected: type$environment$token');
        }

        $gotValuePrefix = $explodedCredential[0];
        $environment = $explodedCredential[1];
        $token = $explodedCredential[2];

        if ($gotValuePrefix != $expectedValuePrefix) {
            throw new Exception\Configuration('Value passed for ' . $credentialType . ' is not a ' . $credentialType);
        }

        return $environment;
    }

    private function _parseAccessToken()
    {
        $accessTokenExploded = explode('$', $this->_accessToken);
        if (sizeof($accessTokenExploded) != 4) {
            throw new Exception\Configuration('Incorrect accessToken syntax. Expected: type$environment$merchant_id$token');
        }

        $gotValuePrefix = $accessTokenExploded[0];
        $environment = $accessTokenExploded[1];
        $merchantId = $accessTokenExploded[2];
        $token = $accessTokenExploded[3];

        if ($gotValuePrefix != 'access_token') {
            throw new Exception\Configuration('Value passed for accessToken is not an accessToken');
        }

        $this->_merchantId = $merchantId;
        return $environment;
    }

    public function getClientId()
    {
        return $this->_clientId;
    }

    public function getClientSecret()
    {
        return $this->_clientSecret;
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function getEnvironment()
    {
        return $this->_environment;
    }

    public function getMerchantId()
    {
        return $this->_merchantId;
    }
}
class_alias('Braintree\CredentialsParser', 'Braintree_CredentialsParser');
