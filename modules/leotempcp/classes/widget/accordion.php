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

class LeoWidgetAccordion extends LeoWidgetBase
{
    public $name = 'accordion';
    public $for_module = 'manage';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Accordion'), 'explain' => $this->l('Create Accordions List'));
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
                    'label' => $this->l('Header 1'),
                    'name' => 'header_1',
                    'default' => 'Sample Header 1',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 1'),
                    'name' => 'content_1',
                    'default' => 'Content Sample 1',
                    'cols' => 40,
                    'rows' => 10,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 1')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Header 2'),
                    'name' => 'header_2',
                    'default' => 'Sample Header 2',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 2'),
                    'name' => 'content_2',
                    'default' => 'Content Sample 2',
                    'cols' => 40,
                    'rows' => 9,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 2')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Header 3'),
                    'name' => 'header_3',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 3'),
                    'name' => 'content_3',
                    'default' => '',
                    'cols' => 40,
                    'rows' => 9,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 3')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Header 4'),
                    'name' => 'header_4',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 4'),
                    'name' => 'content_4',
                    'default' => '',
                    'cols' => 40,
                    'rows' => 9,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 4')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Header 5'),
                    'name' => 'header_5',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 5'),
                    'name' => 'content_5',
                    'default' => '',
                    'cols' => 40,
                    'rows' => 9,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 5')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Header 6'),
                    'name' => 'header_6',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content 6'),
                    'name' => 'content_6',
                    'default' => '',
                    'cols' => 40,
                    'rows' => 9,
                    'value' => true,
                    'lang' => true,
                    'autoload_rte' => true,
                    'desc' => $this->l('Enter Content 6')
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
        $header = '';
        $content = '';

        $ac = array();
        $languageID = Context::getContext()->language->id;

        for ($i = 1; $i <= 6; $i++) {
            $header = isset($setting['header_'.$i.'_'.$languageID]) ? Tools::stripslashes($setting['header_'.$i.'_'.$languageID]) : '';

            if (!empty($header)) {
                $content = isset($setting['content_'.$i.'_'.$languageID]) ? Tools::stripslashes($setting['content_'.$i.'_'.$languageID]) : '';
                $ac[] = array('header' => $header, 'content' => trim($content));
            }
        }
        $setting['accordions'] = $ac;
        $setting['id'] = rand() + count($ac);
        $output = array('type' => 'accordion', 'data' => $setting);

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
            $number_html = 6;
            $array = array();
            for ($i = 1; $i <= $number_html; $i++) {
                $array[] = 'header_'.$i;
                $array[] = 'content_'.$i;
            }
            return $array;
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
