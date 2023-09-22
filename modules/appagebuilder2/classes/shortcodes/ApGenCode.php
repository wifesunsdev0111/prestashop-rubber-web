<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class ApGenCode extends ApShortCodeBase
{
    public $name = 'ApGenCode';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Generate Code'),
            'position' => 8,
            'desc' => $this->l('Generate Code for tpl file. This function for web developer'),
            'icon_class' => 'icon-edit',
            'tag' => 'content');
    }

    public function getConfigList()
    {
        $inputs = array(
            array(
                'type' => 'hidden',
                'value' => 'abcd',
                'name' => 'id_gencode',
                'default' => uniqid('id_gencode_').'_'.time(),
            ),
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'lang' => 'true',
                'default' => '',
            ),
            array(
                'type' => 'textarea',
                'name' => 'content_html',
                'class' => 'ap_html_raw raw-'.time(),
                'rows' => '10',
                'label' => $this->l('Code'),
                'values' => '',
                'default' => '',
                'desc' => $this->l('Typing code for file tpl.'),
            ),
        );
        return $inputs;
    }

    public function prepareFontContent($assign, $module = null)
    {
        $this->generateFile($assign, $module);

        $file_name = $assign['formAtts']['id_gencode'].'.tpl';
        $profile_data = $module->getProfileData();
        $profile_folder = $profile_data['profile_key'];
        $file_url = $this->theme_dir.'profiles/'.$profile_folder.'/'.$file_name;
        // check file tồn tại
        if (file_exists($file_url)) {
            $assign['formAtts']['tpl_file'] = $file_url;
        } else {
            $title = $assign['formAtts']['title'];
            $assign['formAtts']['error_file'] = '1';
            $assign['formAtts']['error_message'] = "ERROR!!! Generate Code 
					'$title'. Physical file does not exist "._THEME_NAME_.'/'.$profile_folder.'/'.$file_name;
        }
        return $assign;
    }

    /**
     * Create code file in profile folder
     */
    public function generateFile($assign, $module = null)
    {
        $folder_profiles = $this->theme_dir.'profiles';
        if (!is_dir($folder_profiles)) {
            mkdir($folder_profiles, 0755);
        }

        $file = $assign['formAtts']['id_gencode'].'.tpl';
//		$profile_data = $module->getProfileData();
//		$profile_folder = $profile_data['profile_key'];
//		$file_url = $this->theme_dir.'profiles/'.$profile_folder.'/'.$file;

        $profile_data = $module->getProfileData();
        $folder = $this->theme_dir.'profiles/'.$profile_data['profile_key'];
        $value = isset($assign['formAtts']['content_html']) ? $assign['formAtts']['content_html'] : '';

        if (!is_dir($folder)) {
            mkdir($folder, 0755);
        }

        ApPageSetting::writeFile($folder, $file, $value);
    }
}
