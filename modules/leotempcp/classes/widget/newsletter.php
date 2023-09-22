<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class LeoWidgetNewsletter extends LeoWidgetBase
{
    public $name = 'newsletter';
    public $for_module = 'all';
    const GUEST_NOT_REGISTERED = -1;
    const CUSTOMER_NOT_REGISTERED = 0;
    const GUEST_REGISTERED = 1;
    const CUSTOMER_REGISTERED = 2;
    public $error = false;

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Newsletter Form'), 'explain' => 'Create Newsletter Form Working With Newsletter Block Of Prestashop.');
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Css Class'),
                    'name' => 'class',
                    'default' => 'leo-newsletter',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Information'),
                    'name' => 'information',
                    'cols' => 20,
                    'rows' => 10,
                    'value' => true,
                    'lang' => true,
                    'default' => 'Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!',
                    'autoload_rte' => true,
                ),
            ),
            'buttons' => array(
                array(
                    'title' => $this->l('Save And Stay'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right',
                    'type' => 'submit',
                    'name' => 'saveandstayleotempcp'
                ),
                array(
                    'title' => $this->l('Save'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right',
                    'type' => 'submit',
                    'name' => 'saveleotempcp'
                ),
            )
        );

        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues($data),
            'languages' => Context::getContext()->controller->getLanguages(),
            'id_language' => $default_lang
        );

        return $helper->generateForm($this->fields_form);
    }

    public function renderContent($args, $setting)
    {
        # validate module
        unset($args);
        $t = array(
            'class' => 'leo-newsletter',
        );
        $setting = array_merge($t, $setting);


        $languageID = Context::getContext()->language->id;
        $setting['information'] = isset($setting['information_'.$languageID]) ? html_entity_decode($setting['information_'.$languageID], ENT_QUOTES, 'UTF-8') : '';
        if (Tools::isSubmit('leoNewsletter')) {
            $setting = $this->getNewsletter($setting);
        }
        $output = array('type' => 'newsletter', 'data' => $setting);

        return $output;
    }

    private function getNewsletter($setting)
    {
        $this->newsletterRegistration();
        if ($this->error) {
            $setting['msg'] = $this->error;
            $setting['nw_value'] = Tools::getIsset('email') ? pSQL(Tools::getValue('email')) : false;
            $setting['nw_error'] = true;
            $setting['action'] = Tools::getValue('action');
        } else if ($this->valid) {
            $setting['msg'] = $this->valid;
            $setting['nw_error'] = false;
        }
        return $setting;
    }

    private function newsletterRegistration()
    {
        $this->context = Context::getContext();
        $email = Tools::getValue('email');
        $action = Tools::getValue('action');

        if (empty($email) || !Validate::isEmail($email)) {
            return $this->error = $this->l('Invalid email address');
        } else if ($action) {
            /* Unsubscription */
            $register_status = $this->isNewsletterRegistered($email);
            if ($register_status < 1) {
                return $this->error = $this->l('This email address is not registered.');
            } else if ($register_status == self::GUEST_REGISTERED) {
                if (!Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'newsletter WHERE `email` = \''.pSQL($email).'\' AND id_shop = '.(int)$this->context->shop->id)) {
                    return $this->error = $this->l('An error occurred while attempting to unsubscribe.');
                }
                return $this->valid = $this->l('Unsubscription successful');
            } else if ($register_status == self::CUSTOMER_REGISTERED) {
                if (!Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'customer SET `newsletter` = 0 WHERE `email` = \''.pSQL($email).'\' AND id_shop = '.(int)$this->context->shop->id)) {
                    return $this->error = $this->l('An error occurred while attempting to unsubscribe.');
                }
                return $this->valid = $this->l('Unsubscription successful');
            }
        } else if ($action == '0') {
            /* Subscription */
            $register_status = $this->isNewsletterRegistered($email);
            if ($register_status > 0) {
                return $this->error = $this->l('This email address is already registered.');
            }

            $email = pSQL($email);
            if (!$this->isRegistered($register_status)) {
                if (Configuration::get('NW_VERIFICATION_EMAIL')) {
                    // create an unactive entry in the newsletter database
                    if ($register_status == self::GUEST_NOT_REGISTERED) {
                        $this->registerGuest($email, false);
                    }

                    if (!$token = $this->getToken($email, $register_status)) {
                        return $this->error = $this->l('An error occurred during the subscription process.');
                    }

                    $this->sendVerificationEmail($email, $token);

                    return $this->valid = $this->l('A verification email has been sent. Please check your inbox.');
                } else {
                    if ($this->register($email, $register_status)) {
                        $this->valid = $this->l('You have successfully subscribed to this newsletter.');
                    } else {
                        return $this->error = $this->l('An error occurred during the subscription process.');
                    }

                    if ($code = Configuration::get('NW_VOUCHER_CODE')) {
                        $this->sendVoucher($email, $code);
                    }

                    if (Configuration::get('NW_CONFIRMATION_EMAIL')) {
                        $this->sendConfirmationEmail($email);
                    }
                }
            }
        }
    }

    protected function getToken($email, $register_status)
    {
        if (in_array($register_status, array(self::GUEST_NOT_REGISTERED, self::GUEST_REGISTERED))) {
            $sql = 'SELECT MD5(CONCAT( `email` , `newsletter_date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\')) as token
					FROM `'._DB_PREFIX_.'newsletter`
					WHERE `active` = 0
					AND `email` = \''.pSQL($email).'\'';
        } else if ($register_status == self::CUSTOMER_NOT_REGISTERED) {
            $sql = 'SELECT MD5(CONCAT( `email` , `date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\' )) as token
					FROM `'._DB_PREFIX_.'customer`
					WHERE `newsletter` = 0
					AND `email` = \''.pSQL($email).'\'';
        }

        return Db::getInstance()->getValue($sql);
    }

    protected function sendVerificationEmail($email, $token)
    {
        if (class_exists('LeoNewLetterMod')) {
            $myNewLetter = new LeoNewLetterMod();
            $myNewLetter->sendVerificationEmail($email, $token);
        }
    }

    protected function isRegistered($register_status)
    {
        return in_array($register_status, array(self::GUEST_REGISTERED, self::CUSTOMER_REGISTERED));
    }

    protected function register($email, $register_status)
    {
        # validate module
        unset($email);
        if ($register_status == self::GUEST_NOT_REGISTERED) {
            if (!$this->registerGuest(Tools::getValue('email'))) {
                return false;
            }
        } else if ($register_status == self::CUSTOMER_NOT_REGISTERED) {
            if (!$this->registerUser(Tools::getValue('email'))) {
                return false;
            }
        }

        return true;
    }

    protected function registerUser($email)
    {
        $this->context = Context::getContext();
        $sql = 'UPDATE '._DB_PREFIX_.'customer
				SET `newsletter` = 1, newsletter_date_add = NOW(), `ip_registration_newsletter` = \''.pSQL(Tools::getRemoteAddr()).'\'
				WHERE `email` = \''.pSQL($email).'\'
				AND id_shop = '.(int)$this->context->shop->id;

        return Db::getInstance()->execute($sql);
    }

    protected function registerGuest($email, $active = true)
    {
        $sql = 'INSERT INTO '._DB_PREFIX_.'newsletter (id_shop, id_shop_group, email, newsletter_date_add, ip_registration_newsletter, http_referer, active)
				VALUES
				('.(int)Context::getContext()->shop->id.',
				'.(int)Context::getContext()->shop->id_shop_group.',
				\''.pSQL($email).'\',
				NOW(),
				\''.pSQL(Tools::getRemoteAddr()).'\',
				(
					SELECT c.http_referer
					FROM '._DB_PREFIX_.'connections c
					WHERE c.id_guest = '.(int)Context::getContext()->customer->id.'
					ORDER BY c.date_add DESC LIMIT 1
				),
				'.(int)$active.'
				)';

        return Db::getInstance()->execute($sql);
    }

    public function activateGuest($email)
    {
        $sql = 'UPDATE `'._DB_PREFIX_.'newsletter`
                SET `active` = 1
                WHERE `email` = \''.pSQL($email).'\'';
        return Db::getInstance()->execute($sql);
    }

    protected function getGuestEmailByToken($token)
    {
        $sql = 'SELECT `email`
				FROM `'._DB_PREFIX_.'newsletter`
				WHERE MD5(CONCAT( `email` , `newsletter_date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\')) = \''.pSQL($token).'\'
				AND `active` = 0';

        return Db::getInstance()->getValue($sql);
    }

    private function isNewsletterRegistered($customer_email)
    {
        $sql = 'SELECT `email`
				FROM '._DB_PREFIX_.'newsletter
				WHERE `email` = \''.pSQL($customer_email).'\'
				AND id_shop = '.(int)Context::getContext()->shop->id;

        if (Db::getInstance()->getRow($sql)) {
            return self::GUEST_REGISTERED;
        }

        $sql = 'SELECT `newsletter`
				FROM '._DB_PREFIX_.'customer
				WHERE `email` = \''.pSQL($customer_email).'\'
				AND id_shop = '.(int)Context::getContext()->shop->id;

        if (!$registered = Db::getInstance()->getRow($sql)) {
            return self::GUEST_NOT_REGISTERED;
        }

        if ($registered['newsletter'] == '1') {
            return self::CUSTOMER_REGISTERED;
        }

        return self::CUSTOMER_NOT_REGISTERED;
    }

    /**
     * 0 no multi_lang
     * 1 multi_lang follow id_lang
     * 2 multi_lnag follow code_lang
     */
    public function getConfigKey($multi_lang = 0)
    {
        if ($multi_lang == 0) {
            return array(
                'class',
            );
        } elseif ($multi_lang == 1) {
            return array(
                'information',
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}

if (is_file(_PS_MODULE_DIR_.'blocknewsletter/blocknewsletter.php')) {
    require_once(_PS_MODULE_DIR_.'blocknewsletter/blocknewsletter.php');

    class LeoNewLetterMod extends Blocknewsletter
    {

        public function sendVerificationEmail($email, $token)
        {
            parent::sendVerificationEmail($email, $token);
        }
    }

}
