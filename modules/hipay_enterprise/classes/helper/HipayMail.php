<?php
/**
 * HiPay Enterprise SDK Prestashop
 *
 * 2017 HiPay
 *
 * NOTICE OF LICENSE
 *
 * @author    HiPay <support.tpp@hipay.com>
 * @copyright 2017 HiPay
 * @license   https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 */

/**
 * Helper to send emails for HiPay Module
 *
 * @author      HiPay <support.tpp@hipay.com>
 * @copyright   Copyright (c) 2017 - HiPay
 * @license     https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 * @link    https://github.com/hipay/hipay-enterprise-sdk-prestashop
 */
class HipayMail
{

    const PATH_EMAILS_HIPAY = _PS_MODULE_DIR_ . 'hipay_enterprise/mails/';

    /**
     * Send an email to website admin to notify an payment challenged
     *
     * @param $context
     * @param $module
     * @param $order
     */
    public static function sendMailPaymentFraud($context, $module, $order)
    {
        $emails = array();

        // === PREPARE EMAIL VARIABLES == ///
        $templateVars = array(
            '{id_order}' => $order->reference,
            '{order_name}' => $order->getUniqReference()
        );

        // === GET DEFAULT ADMIN INFORMATIONS === ///
        $emails[] = Configuration::get('PS_SHOP_EMAIL');
        $configuration = $module->hipayConfigTool->getConfigHipay();
        $emailBCC = $configuration['fraud']['send_payment_fraud_email_copy_to'] ?: null;
        $copyMethod = $configuration['fraud']['send_payment_fraud_email_copy_method'];

        // === CHECK IF ONE OR MULTIPLE MAIL === //
        if ($copyMethod == HipayForm::TYPE_EMAIL_SEPARATE) {
            $emails[] = $emailBCC;
            $emailBCC = null;
        }

        $subject = $module->l('A payment transaction is awaiting validation for the order %s');

        // === SEND EMAIL === //
        self::sendEmailHipay(
            'fraud',
            $subject,
            $emails,
            $emailBCC,
            $context,
            $module,
            $order,
            $templateVars,
            (int)$order->id_lang,
            Configuration::get('PS_LANG_DEFAULT')
        );
    }

    /**
     * Send an email to website admin to notify an DENY PAYMENT
     *
     * @param $context
     * @param $module
     * @param $order
     */
    public static function sendMailPaymentDeny($context, $module, $order)
    {
        // === GET DEFAULT ADMIN INFORMATIONS === ///
        $customer = new Customer((int)$order->id_customer);

        // === PREPARE EMAIL VARIABLES == ///
        $templateVars = array(
            '{id_order}' => $order->reference,
            '{order_name}' => $order->getUniqReference(),
            '{firstname}' => $customer->firstname,
            '{lastname}' => $customer->lastname,
        );

        $emails = array($customer->email);
        $subject = $module->l('Refused payment for order %s');


        // === SEND EMAIL === //
        self::sendEmailHipay(
            'payment_deny',
            $subject,
            $emails,
            null,
            $context,
            $module,
            $order,
            $templateVars,
            (int)$customer->id_lang
        );
    }


    /**
     *  Generic method to send email when order change of status
     *
     * @param $template string
     * @param $subject string
     * @param $emailsTo array
     * @param $emailBCC string
     * @param $context Prestahsop context
     * @param $module Hipay module instance
     * @param $order Order object
     * @param $templateVars array
     */
    private static function sendEmailHipay(
        $template,
        $subject,
        $emailsTo,
        $emailBCC,
        $context,
        $module,
        $order,
        $templateVars,
        $idLang
    ) {

        if (_PS_VERSION_ >= '1.7') {
            $subject = Context::getContext()->getTranslator()->trans(
                $subject,
                array($order->reference),
                'Emails.Subject',
                (int)$idLang
            );
        } else {
            $subject = sprintf(Mail::l($subject, (int)$idLang), $order->reference);
        }

        // === SEND EMAIL === ///
        foreach ($emailsTo as $email) {

            $mailSuccess = @Mail::Send(
                (int)$idLang,
                $template,
                $subject . " " . $idLang,
                $templateVars,
                $email,
                '',
                null,
                null,
                null,
                null,
                HipayMail::PATH_EMAILS_HIPAY,
                false,
                (int)$context->shop->id,
                $emailBCC
            );

            if (!$mailSuccess) {
                $module->getLogs()->logErrors('An error occured during email sending to ' . $email);
            } else {
                $module->getLogs()->logInfos("# Send Mail Payment deny to $email with $template");
            }
        }
    }
}
