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

class AdminLeotempcpImagesController extends ModuleAdminController
{
    protected $max_image_size = null;
    public $themeName;
    public $img_path;
    public $paramLink = '';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->max_image_size = (int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
        parent::__construct();
        $this->themeName = Context::getContext()->shop->getTheme();
        $imgDir = Tools::getValue('imgDir');
        if ($imgDir == 'slideImg') {
            $this->img_path = _PS_ALL_THEMES_DIR_.$this->themeName.'/img/modules/leotempcp/image/';
            $this->img_url = __PS_BASE_URI__.'themes/'.$this->themeName.'/img/modules/leotempcp/image/';
            $this->paramLink = '&imgDir='.$imgDir;
        } else if ($imgDir == 'slideThumb') {
            $this->img_path = _PS_ALL_THEMES_DIR_.$this->themeName.'/img/modules/leotempcp/thum/';
            $this->img_url = __PS_BASE_URI__.'themes/'.$this->themeName.'/img/modules/leotempcp/thum/';
            $this->paramLink = '&imgDir='.$imgDir;
        } else {
            $this->img_path = _PS_ALL_THEMES_DIR_.$this->themeName.'/img/patterns/';
            $this->img_url = __PS_BASE_URI__.'themes/'.$this->themeName.'/img/patterns/';
        }
    }

    public function setMedia()
    {
        $this->addCss(__PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/assets/admin/images.css', 'all');
        //_PS_THEME_DIR_
        return parent::setMedia();
    }

    public function postProcess()
    {
        if (($imgName = Tools::getValue('imgName', false)) !== false) {
            unlink($this->img_path.$imgName);
        }

        parent::postProcess();
    }

    /**
     * renderForm contains all necessary initialization needed for all tabs
     *
     * @return void
     */
    public function renderList()
    {
        //this code for select or upload IMG
        $tpl = $this->createTemplate('imagemanager.tpl');
        $sortBy = Tools::getValue('sortBy');
        $reloadBack = Tools::getValue('reloadBack');
        if ($reloadBack) {
            $images = $this->getImageList($sortBy);
            $tpl->assign(array(
                'images' => $images,
                'reloadBack' => $reloadBack,
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }

        $reloadSliderImage = Tools::getValue('reloadSliderImage');
        if ($reloadSliderImage) {
            $images = $this->getImageList($sortBy);
            $tpl->assign(array(
                'images' => $images,
                'reloadSliderImage' => $reloadSliderImage
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }
        $images = $this->getImageList($sortBy);
        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setSavePath($this->img_path);
        $url = Context::getContext()->link->getAdminLink('AdminLeotempcpImages').'&ajax=1&action=addSliderImage'.$this->paramLink;
        $image_uploader->setMultiple(true)->setUseAjax(true)->setUrl($url);

        $tpl->assign(array(
            'countImages' => count($images),
            'images' => $images,
            'max_image_size' => $this->max_image_size / 1024 / 1024,
            'image_uploader' => $image_uploader->render(),
            'imgManUrl' => Context::getContext()->link->getAdminLink('AdminLeotempcpImages').$this->paramLink,
            'token' => $this->token
        ));

        return $tpl->fetch();
    }

    public function getImageList($sortBy)
    {
        $path = $this->img_path;
        # CACH 1 : lay cac file anh
        $images = glob($path.'/{*.jpeg,*.JPEG,*.jpg,*.JPG,*.gif,*.GIF,*.png,*.PNG}', GLOB_BRACE);
        if ($images === null) {
            # CACH 2 : lay cac file anh
            $files = scandir($path);
            $files = array_diff($files, array('..', '.')); # insert code

            $images = array();
            foreach ($files as $key => $image) {
                # validate module
                unset($key);
                $ext = Tools::substr($image, strrpos($image, '.') + 1);
                if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'))) {
                    $images[] = $image;
                }
            }
        }

        if ($sortBy == 'name_desc') {
            rsort($images);
        }

        if ($sortBy == 'date' || $sortBy == 'date_desc') {
            ksort($images);
        }
        if ($sortBy == 'date_desc') {
            rsort($images);
        }

        $result = array();
        foreach ($images as &$file) {
            $fileInfo = pathinfo($file);
            $result[] = array('name' => $fileInfo['basename'], 'link' => $this->img_url.$fileInfo['basename']);
        }
        return $result;
    }

    public function ajaxProcessaddSliderImage()
    {
        if (isset($_FILES['file'])) {
            $image_uploader = new HelperUploader('file');
            $image_uploader->setSavePath($this->img_path);
            $image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'))->setMaxSize($this->max_image_size);
            $files = $image_uploader->process();
            $total_errors = array();

            foreach ($files as $key => &$file) {
                # validate module
                unset($key);
                $errors = array();
                // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
                if (!ImageManager::checkImageMemoryLimit($file['save_path'])) {
                    $errors[] = Tools::displayError('Due to memory limit restrictions, this image cannot be loaded. Please increase your memory_limit value via your server\'s configuration settings. ');
                }

                if (count($errors)) {
                    $total_errors = array_merge($total_errors, $errors);
                }

                //unlink($file['save_path']);
                //Necesary to prevent hacking
                unset($file['save_path']);

                //Add image preview and delete url
            }

            if (count($total_errors)) {
                $this->context->controller->errors = array_merge($this->context->controller->errors, $total_errors);
            }

            $images = $this->getImageList('date');
            $tpl = $this->createTemplate('imagemanager.tpl');
            $tpl->assign(array(
                'images' => $images,
                'reloadSliderImage' => 1,
                'link' => Context::getContext()->link
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }
    }
}
