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

class LeoWidgetLinks extends LeoWidgetBase
{
    public $name = 'link';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Block Links'), 'explain' => 'Create List Block Links');
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
                    'label' => $this->l('Text Link 1'),
                    'name' => 'text_link_1',
                    'default' => 'link 1',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 1'),
                    'name' => 'link_1',
                    'default' => '#link1',
                    'desc' => $this->l('Enter Content Link 1'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 2'),
                    'name' => 'text_link_2',
                    'default' => 'link 2',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 2'),
                    'name' => 'link_2',
                    'default' => '#link2',
                    'desc' => $this->l('Enter Content Link 2'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 3'),
                    'name' => 'text_link_3',
                    'default' => 'link3',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 3'),
                    'name' => 'link_3',
                    'default' => '#link3',
                    'desc' => $this->l('Enter Content Link 3'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 4'),
                    'name' => 'text_link_4',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 4'),
                    'name' => 'link_4',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 4'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 5'),
                    'name' => 'text_link_5',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 5'),
                    'name' => 'link_5',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 5'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 6'),
                    'name' => 'text_link_6',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 6'),
                    'name' => 'link_6',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 6'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 7'),
                    'name' => 'text_link_7',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 7'),
                    'name' => 'link_7',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 7'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 8'),
                    'name' => 'text_link_8',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 8'),
                    'name' => 'link_8',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 8'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 9'),
                    'name' => 'text_link_9',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 9'),
                    'name' => 'link_9',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 9'),
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Text Link 10'),
                    'name' => 'text_link_10',
                    'default' => '',
                    'lang' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link 10'),
                    'name' => 'link_10',
                    'default' => '',
                    'desc' => $this->l('Enter Content Link 10'),
                    'lang' => true
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
            'name' => '',
            'html' => '',
        );

        $setting = array_merge($t, $setting);

        $ac = array();
        $languageID = Context::getContext()->language->id;
        $text_link = $link = '';

        for ($i = 1; $i <= 10; $i++) {
            if (isset($setting['text_link_'.$i.'_'.$languageID]) && trim($setting['text_link_'.$i.'_'.$languageID])) {
                $text_link = isset($setting['text_link_'.$i.'_'.$languageID]) ? html_entity_decode($setting['text_link_'.$i.'_'.$languageID], ENT_QUOTES, 'UTF-8') : 'No Link Title';

                if (isset($setting['link_'.$i.'_'.$languageID])) {
                    $link = trim($setting['link_'.$i.'_'.$languageID]);
                } else {
                    $link = trim($setting['link_'.$i]);
                }

                $ac[] = array('text' => Tools::stripslashes($text_link), 'link' => $link);
            }
        }

        $setting['id'] = rand();
        $setting['links'] = $ac;
        //echo '<pre>';print_r($setting);die;

        $output = array('type' => 'links', 'data' => $setting);

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
            $number_html = 10;
            $array = array();
            for ($i = 1; $i <= $number_html; $i++) {
                $array[] = 'text_link_'.$i;
                $array[] = 'link_'.$i;
            }
            return $array;
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
