<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
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
 * @author patworx multimedia GmbH <service@patworx.de>
 * @copyright  2018 patworx multimedia GmbH Sofort.
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

require_once dirname(__FILE__) . '/../../lib/sofortlib/autoload.php';

class SofortbankingPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $this->display_column_left = false;
        $this->display_column_right = false;
        
        $this->module = Module::getInstanceByName(Tools::getValue('module'));

        parent::initContent();

        if (!$this->isTokenValid()) {
            throw new \Exception(sprintf('%s Error: (Invalid token)', $this->module->displayName));
        }

        if (!$this->module->isPayment()) {
            throw new \Exception(sprintf('%s Error: (Inactive or incomplete module configuration)', $this->module->displayName));
        }

        $cart = $this->context->cart;
        $customer = new Customer((int) $cart->id_customer);
        $currency = $this->context->currency;
        $language = $this->context->language;

        if (!Validate::isLoadedObject($customer)
            || !Validate::isLoadedObject($currency)
            || !Validate::isLoadedObject($language)) {
            throw new \Exception(sprintf('%s Error: (Invalid customer, language or currency object)', $this->module->displayName));
        }

        $sofortueberweisung = new \Sofort\SofortLib\Sofortueberweisung(
            sprintf(
                '%s:%s:%s',
                Configuration::get('SOFORTBANKING_USER_ID'),
                Configuration::get('SOFORTBANKING_PROJECT_ID'),
                Configuration::get('SOFORTBANKING_API_KEY')
            )
        );

        $sofortueberweisung->setUserVariable(array(
            $cart->id,
            $customer->secure_key
        ));
        $sofortueberweisung->setAmount(number_format($cart->getOrderTotal(), 2, '.', ''));
        $sofortueberweisung->setCurrencyCode($currency->iso_code);
        $sofortueberweisung->setLanguageCode($language->iso_code);
        $sofortueberweisung->setReason(
            sprintf(
                '%09d - %s %s',
                $cart->id,
                $customer->firstname,
                Tools::ucfirst(Tools::strtolower($customer->lastname))
            )
        );

        $url = array(
            'notification' => $this->context->shop->getBaseURL(true) . 'modules/' . $this->module->name . '/notification.php',
            'success' => $this->context->shop->getBaseURL(true) . 'modules/' . $this->module->name . '/confirmation.php?transaction=-TRANSACTION-',
            'cancellation' => $this->context->shop->getBaseURL(true) . 'index.php?controller=order&step=3'
        );

        $sofortueberweisung->setSuccessUrl($url['success']);
        $sofortueberweisung->setAbortUrl($url['cancellation']);
        $sofortueberweisung->setNotificationUrl($url['notification'], 'untraceable,pending,received,loss,refunded');

        $sofortueberweisung->setVersion(sprintf('PrestaShop_%s/Module_%s', _PS_VERSION_, $this->module->version));

        $sofortueberweisung->sendRequest();
        if ($sofortueberweisung->isError()) {
            //echo $sofortueberweisung->getError(); die();
            $error_message_sofort = Translate::getModuleTranslation('sofortbanking', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.', 'payment');
            if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                $this->errors[] = $error_message_sofort;
                $this->redirectWithNotifications($this->context->shop->getBaseURL(true) . 'index.php?controller=order&step=3');
            } else {
                $this->context->cookie->sofort_error_message = $error_message_sofort;
                Tools::redirect($this->context->shop->getBaseURL(true) . 'index.php?controller=order&step=3');
            }
        } else {
            Tools::redirect($sofortueberweisung->getPaymentUrl());
        }
    }
}
