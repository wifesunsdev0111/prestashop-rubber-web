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

class LeoWidgetHtml extends LeoWidgetBase
{
    public $name = 'html';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('HTML'), 'explain' => 'Create HTML With multiple Language');
    }

    public function renderForm($args, $data)
    {
        #validate module
        unset($args);
        $helper = $this->getFormHelper();

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'htmlcontent',
                    'cols' => 40,
                    'rows' => 10,
                    'value' => true,
                    'lang' => true,
                    'default' => '',
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
        #validate module
        unset($args);
        $t = array(
            'name' => '',
            'html' => '',
        );
        $setting = array_merge($t, $setting);
        $languageID = Context::getContext()->language->id;
        $setting['html'] = isset($setting['htmlcontent_'.$languageID]) ? Tools::stripslashes($setting['htmlcontent_'.$languageID]) : '';

        $output = array('type' => 'html', 'data' => $setting);

        return $output;
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
            );
        } elseif ($multi_lang == 1) {
            return array(
                'htmlcontent',
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
