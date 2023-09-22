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

class LeoWidgetManufacture extends LeoWidgetBase
{
    public $name = 'Manufacture';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Manufacture Logos'), 'explain' => 'Manufacture Logo');
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();
        $imagesTypes = ImageType::getImagesTypes('manufacturers');

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'limit',
                    'default' => 10,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Image:'),
                    'desc' => $this->l('Select type image for manufacture.'),
                    'name' => 'image',
                    'default' => 'small'.'_default',
                    'options' => array(
                        'query' => $imagesTypes,
                        'id' => 'name',
                        'name' => 'name'
                    )
                )
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
        $plimit = ($setting['limit']) ? (int)($setting['limit']) : 10;
        $image_type = ($setting['image']) ? ($setting['image']) : 'small'.'_default';
        $data = Manufacturer::getManufacturers(true, Context::getContext()->language->id, true, 1, $plimit, false);

        foreach ($data as &$item) {
            $id_images = (!file_exists(_PS_MANU_IMG_DIR_.'/'.$item['id_manufacturer'].'-'.$image_type.'.jpg')) ? Language::getIsoById(Context::getContext()->language->id).'-default' : $item['id_manufacturer'];
            $item['image'] = _THEME_MANU_DIR_.$id_images.'-'.$image_type.'.jpg';
        }

        $setting['manufacturers'] = $data;
        $output = array('type' => 'manufacture', 'data' => $setting);

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
                'limit',
                'image',
            );
        } elseif ($multi_lang == 1) {
            return array(
            );
        } elseif ($multi_lang == 2) {
            return array(
            );
        }
    }
}
