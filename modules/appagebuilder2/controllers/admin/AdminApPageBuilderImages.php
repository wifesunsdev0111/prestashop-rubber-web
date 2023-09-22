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

require_once(_PS_MODULE_DIR_.'appagebuilder/classes/ApPageSetting.php');

class AdminApPageBuilderImagesController extends ModuleAdminControllerCore
{
    protected $max_image_size = null;
    public $theme_name;
    public $module_name = 'appagebuilder';
    public $img_path;
    public $folder_name;
    public $module_path;
    public $tpl_path;
    public $theme_dir;

    public function __construct()
    {
        parent::__construct();
        $this->theme_dir = _PS_ROOT_DIR_.'/themes/'.Context::getContext()->shop->getTheme().'/';
        $this->folder_name = Tools::getIsset('imgDir') ? Tools::getValue('imgDir') : 'images';
        $this->bootstrap = true;
        $this->max_image_size = (int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
        $this->theme_name = Context::getContext()->shop->getTheme();
        $this->img_path = _PS_ALL_THEMES_DIR_.$this->theme_name.'/img/modules/'.$this->module_name."/$this->folder_name/";
        $this->img_url = __PS_BASE_URI__.'themes/'.$this->theme_name.'/img/modules/'.$this->module_name."/$this->folder_name/";
        $this->className = 'ApPageBuilderImages';
        $this->context = Context::getContext();
        $this->module_path = __PS_BASE_URI__.'modules/'.$this->module_name.'/';
        $this->tpl_path = _PS_ROOT_DIR_.'/modules/'.$this->module_name.'/views/templates/admin';
    }

    public function setMedia()
    {
        $this->addCss(__PS_BASE_URI__.str_replace('//', '/', 'modules/'.$this->module_name).'/assets/admin/images.css', 'all');
        //$this->theme_dir
        return parent::setMedia();
    }

    /**
     * Process request post to this controller
     */
    public function postProcess()
    {
        if (($img_name = Tools::getValue('imgName', false)) !== false) {
            unlink($this->img_path.$img_name);
            $this->reloadAjax();
        }
        if (Tools::getIsset('ajax') && Tools::getValue('ajax')) {
            $action = Tools::getIsset('action') ? Tools::getValue('action') : '';
            if ($action == 'ajaxProcessAddImage') {
                $this->ajaxProcessAddImage();
            }
        }
        parent::postProcess();
    }

    public function renderList()
    {
        $is_ajax = (Tools::getIsset('is_ajax') && Tools::getValue('is_ajax')) ? 'ajax' : '';
        if ($is_ajax) {
            $this->renderListAjax();
            return;
        }
        $tpl = $this->createTemplate('imagemanager.tpl');
        $sort_by = Tools::getValue('sortBy');
        $reload_back = Tools::getValue('reloadBack');
        if ($reload_back) {
            $images = $this->getImageList($sort_by);
            $tpl->assign(array(
                'images' => $images,
                'reloadBack' => $reload_back
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }
        $reload_slider_image = Tools::getValue('reloadSliderImage');
        if ($reload_slider_image) {
            $images = $this->getImageList($sort_by);
            $tpl->assign(array(
                'images' => $images,
                'reloadSliderImage' => $reload_slider_image
            ));
            die(Tools::jsonEncode($tpl->fetch()));
        }
        $images = $this->getImageList($sort_by);
        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setSavePath($this->img_path);
        $image_uploader->setMultiple(true)->setUseAjax(true)->setUrl(
                //Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&ajax=1&action=addSliderImage');
                Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&ajax=1&action=ajaxProcessAddImage');
        $tpl->assign(array(
            'countImages' => count($images),
            'images' => $images,
            'max_image_size' => $this->max_image_size / 1024 / 1024,
            'image_uploader' => $image_uploader->render(),
            'imgManUrl' => Context::getContext()->link->getAdminLink('AdminApPageBuilderImages'),
            'token' => $this->token
        ));
        return $tpl->fetch();
    }

    public function renderListAjax()
    {
        //this code for select or upload IMG
        //$tpl = $this->createTemplate('imagemanager.tpl');
        $smarty = Context::getContext()->smarty;
        $sort_by = Tools::getValue('sortBy');
        $reload_back = Tools::getValue('reloadBack');
        if ($reload_back) {
            $images = $this->getImageList($sort_by);
            $smarty->assign(array(
                'images' => $images,
                'reloadBack' => $reload_back
            ));
            die(Tools::jsonEncode($this->renderTemplate('imagemanager.tpl')));
        }
        $reload_slider_image = Tools::getValue('reloadSliderImage');
        if ($reload_slider_image) {
            $images = $this->getImageList($sort_by);
            $smarty->assign(array(
                'images' => $images,
                'reloadSliderImage' => $reload_slider_image
            ));
            die(Tools::jsonEncode($this->renderTemplate('imagemanager.tpl')));
        }
        $images = $this->getImageList($sort_by);
        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setSavePath($this->img_path);
        $image_uploader->setTemplateDirectory($this->tpl_path.DS.'uploader');
        $image_uploader->setTemplate('ajax.tpl');
        $image_uploader->setMultiple(true)->setUseAjax(true)->setUrl(
                Context::getContext()->link->getAdminLink('AdminApPageBuilderImages').'&ajax=1&action=ajaxProcessAddImage&imgDir='.$this->folder_name);
        $upload_html = $image_uploader->render();
        //echo $upload_html;
        $smarty->assign(array(
            'countImages' => count($images),
            'images' => $images,
            'max_image_size' => $this->max_image_size / 1024 / 1024,
            'image_uploader' => $upload_html,
            'imgManUrl' => Context::getContext()->link->getAdminLink('AdminApPageBuilderImages'),
            'token' => $this->token
        ));
        die($this->renderTemplate('imagemanager.tpl'));
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

    public function ajaxProcessAddImage()
    {
        if (isset($_FILES['file'])) {
            try {
                $image_uploader = new HelperUploader('file');
                $image_uploader->setSavePath($this->img_path);
                $image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'))->setMaxSize($this->max_image_size);
                $total_errors = array();
                $this->checkFolderImage();
                $files = $image_uploader->process();
                //apPageHelper::log($this->img_path);
                foreach ($files as &$file) {
                    $errors = array();
                    // Evaluate the memory required to resize the image: ifit's too much, you can't resize it.
                    if (!ImageManager::checkImageMemoryLimit($file['save_path'])) {
                        $errors[] = Tools::displayError('Due to memory limit restrictions, this image cannot be loaded. 
								Please increase your memory_limit value via your server\'s configuration settings.');
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
                $this->reloadAjax();
            } catch (Exception $ex) {
                //apPageHelper::log($ex);
            }
        }
    }

    public function reloadAjax()
    {
        $images = $this->getImageList('date');
        $tpl = $this->createTemplate('imagemanager.tpl');
        $tpl->assign(array(
            'images' => $images,
            'reloadSliderImage' => 1,
            'link' => Context::getContext()->link
        ));
        die(Tools::jsonEncode($tpl->fetch()));
    }

    /**
     * Check existed or create new a folder into the default root path image (This path was set in the module config)
     * @param type $folder_name
     * @return type
     */
    public function checkFolderImage()
    {
        $name = str_replace('/', '', $this->folder_name);
        $name = str_replace('\\', '', $name);
        $root_page = Configuration::get('APPAGEBUILDER_IMGDIR');
        $root_page = $root_page ? _PS_ALL_THEMES_DIR_.$this->theme_name.DS.$root_page :
                _PS_ALL_THEMES_DIR_.$this->theme_name.DS.'img'.DS.'modules'.DS.$this->module_name;
        $root_page = $root_page.'/'.$name;
        // Remove last slash in last root_page
        $s = Tools::substr($root_page, Tools::strlen($root_page) - 1);
        $path_img = ($s != '/') ? $root_page : Tools::substr($root_page, 0, Tools::strlen($root_page) - 1);
        if (is_dir($path_img)) {
            return;
        }
        mkdir($path_img, 0755, true);
    }

    public function renderTemplate($tpl_name)
    {
        $path = '';
        if (file_exists($this->theme_dir.'modules/'.$this->module->name.'/views/templates/admin/'.$tpl_name) && $this->viewAccess()) {
            $path = $this->theme_dir.'modules/'.$this->module->name.'/views/templates/admin/'.$tpl_name;
        }
        elseif (file_exists($this->getTemplatePath().$this->override_folder.$tpl_name) && $this->viewAccess()) {
            $path = $this->getTemplatePath().$this->override_folder.$tpl_name;
        }
        $content = Context::getContext()->smarty->fetch($path);
        return $content;
    }
}
