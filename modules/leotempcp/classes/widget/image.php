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

class LeoWidgetImage extends LeoWidgetBase
{
    public $name = 'image';
    public $for_module = 'all';

    public function getWidgetInfo()
    {
        return array('label' => $this->l('Images Gallery Folder'), 'explain' => 'Create Images Mini Gallery From Folder');
    }

    public function renderForm($args, $data)
    {
        # validate module
        unset($args);
        $helper = $this->getFormHelper();
//		$soption = array(
//			array(
//				'id' => 'active_on',
//				'value' => 1,
//				'label' => $this->l('Enabled')
//			),
//			array(
//				'id' => 'active_off',
//				'value' => 0,
//				'label' => $this->l('Disabled')
//			)
//		);

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Form.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Image Folder Path'),
                    'name' => 'image_folder_path',
                    'default' => '',
                    'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Width'),
                    'name' => 'width',
                    'desc' => 'Enter a number',
                    'default' => '',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Limit'),
                    'name' => 'limit',
                    'default' => '12',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Columns'),
                    'name' => 'columns',
                    'options' => array('query' => array(
                            array('id' => '1', 'name' => $this->l('1 Column')),
                            array('id' => '2', 'name' => $this->l('2 Columns')),
                            array('id' => '3', 'name' => $this->l('3 Columns')),
                            array('id' => '4', 'name' => $this->l('4 Columns')),
                            array('id' => '5', 'name' => $this->l('5 Columns')),
                        ),
                        'id' => 'id',
                        'name' => 'name'),
                    'default' => '4',
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
            'image_folder_path' => '',
            'limit' => 12,
            'columns' => 4,
        );

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);


        $setting = array_merge($t, $setting);
        $oimages = array();
        if ($setting['image_folder_path']) {
            $path = _PS_ROOT_DIR_.'/'.trim($setting['image_folder_path']).'/';
            $path = str_replace('//', '/', $path);
            if (is_dir($path)) {
                $images = glob($path.'*.*');
                $exts = array('jpg', 'gif', 'png');

                foreach ($images as $cnt => $image) {
                    $ext = Tools::substr($image, Tools::strlen($image) - 3, Tools::strlen($image));

                    if (in_array(Tools::strtolower($ext), $exts)) {

                        if ($cnt < (int)$setting['limit']) {
                            $i = str_replace('\\', '/', ''.$setting['image_folder_path'].'/'.basename($image));
                            $i = str_replace('//', '/', $i);

                            $oimages[] = $url.$i;
                        }
                    }
                }
            }
        }

        $images = array();
        $setting['images'] = $oimages;
        $output = array('type' => 'image', 'data' => $setting);
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
                'image_folder_path',
                'width',
                'limit',
                'columns',
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
