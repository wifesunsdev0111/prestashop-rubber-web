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

class LeoThemeSetting
{

    private function _displayGeneralForm()
    {
        $soption = array(
            array(
                'id' => 'active_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'active_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('General Setting'),
                    'icon' => 'icon-cogs'
                ),
                'description' => $this->l('General Setting For Current Theme:').' <strong>'.$this->themeName.'</strong>',
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Layout Width'),
                        'name' => $this->getConfigName('layout_width'),
                        'default' => 100,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Default Skin'),
                        'name' => $this->getConfigName('default_skin'),
                        'default' => 100,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Copyright'),
                        'name' => $this->getConfigName('enable_copyright'),
                        'values' => $soption,
                        'default' => '1',
                        'desc' => $this->l('Allow to display your copyright information at bottom of site.'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Copyright'),
                        'name' => $this->getConfigName('copyright'),
                        'default' => 'Copyright 2014 Powered by PrestaShop. All Rights Reserved.',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Panel Tool'),
                        'name' => $this->getConfigName('paneltool'),
                        'default' => 0,
                        'values' => $soption,
                        'desc' => $this->l('Whethere to display Panel Tool appearing on left of site.'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default')
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = true;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();

        $helper->toolbar_scroll = true;

        $helper->toolbar_btn = array(
            'save' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' =>
            array(
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ),
            'save2' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            ),
        );
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => self::getConfigFieldsValues($fields_form['form']['input']),
            'languages' => $languages,
            'id_language' => $id_language
        );
        return $helper->generateForm(array($fields_form));
    }
}

function getConfigFieldsValues($fields = array())
{
    $output = array();
    foreach ($fields as $field) {
        $d = Tools::getValue($field['name'], Configuration::get($field['name']));
        $output[$field['name']] = $d ? $d : $field['default'];
    }
    return $output;
}
