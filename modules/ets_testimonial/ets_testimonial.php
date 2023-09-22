<?php
/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2022 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;
require_once(dirname(__FILE__) . '/classes/Ets_ttn_paggination_class.php');
require_once(dirname(__FILE__) . '/classes/review.php');
require_once(dirname(__FILE__) . '/classes/search.php');
require_once(dirname(__FILE__) . '/classes/ets_ttn_defines.php');
if (!defined('_PS_TESTIMONIAL_IMG_DIR_')) {
    define('_PS_TESTIMONIAL_IMG_DIR_', _PS_IMG_DIR_.'ets_testimonial/');
}
if (!defined('_PS_TESTIMONIAL_IMG_')) {
    define('_PS_TESTIMONIAL_IMG_', _PS_IMG_.'ets_testimonial/');
}
class Ets_testimonial extends Module
{
    public $_errors = array();
    public $is17 = false;
    public $baseLink;
    public $is15;
    public function __construct()
    {
        $this->name = 'ets_testimonial';
        $this->tab = 'front_office_features';
        $this->version = '1.0.5';
        $this->author = 'ETS-Soft';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
        $this->module_dir = $this->_path;
        $this->displayName = $this->l('Testimonial Slider');
        $this->description = $this->l('Easily display customer ratings and testimonials right on the home page of your PrestaShop store.');
$this->refs = 'https://prestahero.com/';
        $this->is15 = version_compare(_PS_VERSION_, '1.5.0.0', '>=') && version_compare(_PS_VERSION_, '1.6.0.0', '<') ? 1 : 0;
        if(defined('_PS_ADMIN_DIR_'))
            $this->baseLink = $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
    }
    public function install()
    {
        return parent::install()&& $this->_resgisterHooks() && Ets_ttn_defines::getInstance()->installDb() &&  $this->_installDefaultConfig();
    }
    public function unInstall()
    {
        return parent::unInstall() && $this->_unResgisterHooks() && Ets_ttn_defines::getInstance()->unInstallDb() && $this->_unInstallDefaultConfig()&& $this->rrmdir(_PS_TESTIMONIAL_IMG_DIR_);
    }
    public function _resgisterHooks()
    {
        return $this->registerHook('displayHome')
        && $this->registerHook('displayHeader')
        && $this->registerHook('displayBackOfficeHeader');
    }
    public function _unResgisterHooks()
    {
        return $this->unregisterHook('displayHome')
        && $this->unregisterHook('displayHeader')
        && $this->unregisterHook('displayBackOfficeHeader');
    }
    public function _installDefaultConfig()
    {
        $inputs = $this->getConfigInputs();
        $languages = Language::getLanguages(false);
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(isset($input['default']) && $input['default'])
                {
                    if(isset($input['lang']) && $input['lang'])
                    {
                        $values = array();
                        foreach($languages as $language)
                        {
                            $values[$language['id_lang']] = isset($input['default_lang']) && $input['default_lang'] ? $this->getTextLang($input['default_lang'],$language) : $input['default'];
                        }
                        Configuration::updateValue($input['name'],$values);
                    }
                    else
                        Configuration::updateValue($input['name'],$input['default']);
                }
            }
        }
        return true;
    }
    public function _unInstallDefaultConfig()
    {
        $inputs = $this->getConfigInputs();
        if($inputs)
        {
            foreach($inputs as $input)
            {
                Configuration::deleteByName($input['name']);
            }
        }
        return true;          
    }
    public function hookDisplayHeader()
    {
        $controller = Tools::getValue('controller');
        if($controller=='index')
        {
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
            $this->context->controller->addCSS($this->_path . 'views/css/front.css', 'all');
            $this->context->controller->addJS($this->_path . 'views/js/slick.min.js');
            $this->context->controller->addJS($this->_path . 'views/js/front.js');
            $this->context->smarty->assign(
                array(
                    'ETS_TTN_AUTOPLAY_SLIDESHOW' => Configuration::get('ETS_TTN_AUTOPLAY_SLIDESHOW'),
                    'ETS_TTN_TIME_SPEED_SLIDESHOW' => Configuration::get('ETS_TTN_TIME_SPEED_SLIDESHOW'),
                )
            );
            return $this->display(__FILE__,'head.tpl');
        }
    }
    public function hookDisplayHome()
    {
        $reviews = Ets_ttn_review::getReviews(' AND r.enabled=1',0,false,Configuration::get('ETS_TTN_SORT_ORDER_TYPE')=='default' ? 'r.position asc':' rand()',false);
        if($reviews)
        {
            foreach($reviews as &$review)
            {
                if($review['id_product'])
                {
                    $review['link_product'] = $this->context->link->getProductLink($review['id_product']);
                    $review['image'] = Ets_ttn_review::getImageProduct($review['id_product'],'small');
                }
            }
        }
        $this->context->smarty->assign(
            array(
                'reviews' => $reviews,
                'link_base' => $this->getBaseLink(),
                'paggination' => '',
                'path_default_img' => $this->_path . 'views/img/default_customer.png',
                'ETS_TTN_TITLE' => Configuration::get('ETS_TTN_TITLE',$this->context->language->id),
                'ETS_TTN_COLOR_BUTTON' => Configuration::get('ETS_TTN_COLOR_BUTTON',$this->context->language->id),
                'ETS_TTN_COLOR_TITLE' => Configuration::get('ETS_TTN_COLOR_TITLE',$this->context->language->id),
                'ETS_TTN_VARTICAL_TITLE' => Configuration::get('ETS_TTN_VARTICAL_TITLE',$this->context->language->id),
                'ETS_TTN_BACKGROUND' => Configuration::get('ETS_TTN_BACKGROUND',$this->context->language->id) ? : Configuration::get('ETS_TTN_BACKGROUND',Configuration::get('PS_LANG_DEFAULT')),
            )
        );
        return $this->display(__FILE__,'home_reviews.tpl');
    }
    public function hookDisplayBackOfficeHeader()
    {
        $module_name = Tools::getValue('configure');
        if($module_name == $this->name)
        {
            $this->context->controller->addCSS($this->_path . 'views/css/admin.css', 'all');
            if ( $this->is15 ){
                $this->context->controller->addCSS($this->_path . 'views/css/admin_15.css', 'all');
                $this->context->controller->addJqueryPlugin('jgrowl');
            }
            $this->context->controller->addJqueryUI('ui.sortable');
            
        }
    }
    public function getContent()
    {
        if(Tools::isSubmit('delAvatar') && ($id_ets_ttn_review = (int)Tools::getValue('id_ets_ttn_review')))
        {
            $review = new Ets_ttn_review($id_ets_ttn_review);
            $avatar = $review->avatar;
            if(Validate::isLoadedObject($review))
            {
                $review->avatar='';
                if($review->update())
                {
                    @unlink(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar);
                    Tools::redirectAdminAdmin($this->baseLink.'&editttn_reviews=1&id_ets_ttn_review='.$id_ets_ttn_review.'&conf=7');
                }
                else
                    $this->_errors[] = $this->l('An error occurred while updating the review');
            }
            else
               $this->_errors[] = $this->l('Review is not valid');     
        }
        if(Tools::isSubmit('delAdditional') && ($id_ets_ttn_review = (int)Tools::getValue('id_ets_ttn_review')))
        {
            $review = new Ets_ttn_review($id_ets_ttn_review);
            $additional = $review->additional;
            if(Validate::isLoadedObject($review))
            {
                $review->additional='';
                if($review->update())
                {
                    @unlink(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional);
                    Tools::redirectAdmin($this->baseLink.'&editttn_reviews=1&id_ets_ttn_review='.$id_ets_ttn_review.'&conf=7');
                }
                else
                    $this->_errors[] = $this->l('An error occurred while updating the review');
            }
            else
               $this->_errors[] = $this->l('Review is not valid');     
        }
        if(Tools::isSubmit('del') && ($id_ets_ttn_review = (int)Tools::getValue('id_ets_ttn_review')))
        {
            $review = new Ets_ttn_review($id_ets_ttn_review);
            if(Validate::isLoadedObject($review))
            {
                if($review->delete())
                {
                    Tools::redirectAdmin($this->baseLink.'&conf=2');
                }
                else
                    $this->_errors[] = $this->l('An error occurred while deleting the review');
            }
            else
                $this->_errors[] = $this->l('Review is not valid');
        }
        if(Tools::isSubmit('delImageConfig') && ($filed = Tools::getValue('field')) && Validate::isConfigName($filed))
        {
            $id_lang = (int)Tools::getValue('id_lang');
            if($id_lang)
                $filed_value = Configuration::get($filed,$id_lang);
            else
                $filed_value = Configuration::get($filed);
            if($filed_value && file_exists(_PS_TESTIMONIAL_IMG_DIR_.$filed_value))
            {
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.$filed_value);
            }
            Configuration::deleteByName($filed);
            Tools::redirectAdmin($this->baseLink.'&conf=7');    
        }
        if(Tools::isSubmit('change_enabled') && ($id_ets_ttn_review = Tools::getValue('id_ets_ttn_review')) && Validate::isUnsignedId($id_ets_ttn_review) && ($review = new Ets_ttn_review($id_ets_ttn_review)) && Validate::isLoadedObject($review))
        {
            $change_enabled = (int)Tools::getValue('change_enabled');
            $review->enabled = (int)$change_enabled;
            $review->update();
            if($change_enabled)
            {
                die(
                    Tools::jsonEncode(
                        array(
                            'href' => $this->baseLink.'&id_ets_ttn_review='.(int)$id_ets_ttn_review.'&change_enabled=0&field=enabled',
                            'title' => $this->l('Click to disable'),
                            'success' => $this->l('Updated successfully'),
                            'enabled' => 1,
                        )
                    )  
                );
            }
            else
            {
                die(
                    Tools::jsonEncode(
                        array(
                            'href' => $this->baseLink.'&id_ets_ttn_review='.(int)$id_ets_ttn_review.'&change_enabled=1&field=enabled',
                            'title' => $this->l('Click to enable'),
                            'success' => $this->l('Updated successfully'),
                            'enabled' => 0,
                        )
                    )  
                );
            }
        }
        if(Tools::isSubmit('duplicatettn_reviews') && ($id_ets_ttn_review=(int)Tools::getValue('id_ets_ttn_review')) && ($review = new Ets_ttn_review($id_ets_ttn_review)) && Validate::isLoadedObject($review))
        {
            if($review->duplicate())
            {
                Tools::redirectAdmin($this->baseLink.'&conf=19');
            }
            else
                $this->_errors[] = $this->_errors[] = $this->l('An error occurred while creating the review');
        }
        if(Tools::isSubmit('submitBulkActionReview'))
        {
            $this->submitBulkActionReview();
        }
        if(($action = Tools::getValue('action')) && $action=='updateReviewOrdering' && ($reviews = Tools::getValue('ttn_reviews')) && self::validateArray($reviews,'isInt'))
        {
            Ets_ttn_review::getInstance()->updatePostion($reviews);
        }
        $this->context->smarty->assign(
            array(
                'ets_ttn_module_dir' => $this->_path,
                'ets_link_search_product' => $this->context->link->getModuleLink($this->name,'search',array('search_product'=>1)),
            )
        );
        $this->_html = $this->display(__FILE__,'admin.tpl');
        if($this->_errors)
            $this->_html .= $this->displayError($this->_errors);
        if (Tools::isSubmit('btnSubmit')) {
            $this->postSubmitConfig();
        }
        if(Tools::isSubmit('saveReview'))
        {
            $this->submitSaveReview();
        }
        if(Tools::isSubmit('addnewreview') || (Tools::isSubmit('editttn_reviews') && ($id = (int)Tools::getValue('id_ets_ttn_review')) && Ets_ttn_review::isExists($id)))
        {
            if(Tools::isSubmit('addnewreview'))
                $review = new Ets_ttn_review();
            else
                $review = new Ets_ttn_review($id );
            $this->_html .= $review->renderForm();
        }
        else
        {
            $this->_html .= $this->renderFormConfig();
            $this->_html .= $this->renderListReviews();
        }
        $this->_html .= $this->displayIframe();
        return $this->_html;
    }
    public function submitSaveReview()
    {
        if($id = (int)Tools::getValue('id_ets_ttn_review'))
        {
            $review = new Ets_ttn_review($id);
        }
        else
        {
            $review = new Ets_ttn_review();
            $review->id_shop = $this->context->shop->id;
        }
        $id_product = Tools::getValue('id_product');
        $rate = Tools::getValue('rate');
        $license = Tools::getValue('license');
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $enabeld = (int)Tools::getValue('enabled');
        $review->enabled =$enabeld;
        if(!$rate)
            $this->_errors[] = $this->l('Rate is required');
        elseif($rate && !Validate::isUnsignedFloat($rate))
            $this->_errors[] = $this->l('Rate is not valid');
        elseif($rate<=0 || $rate >5)
            $this->_errors[] = $this->l('Rating must be greater than 0 and smaller than 5');
        else
            $review->rate = Tools::ps_round($rate,1);
        
        $testimonial_default = Tools::getValue('testimonial_'.$id_lang_default);
        if(!$testimonial_default)
            $this->_errors[] = $this->l('Testimonial is required');
        elseif($testimonial_default && !Validate::isCleanHtml($testimonial_default))
            $this->_errors[] = $this->l('Testimonial is not valid');
        else
            $review->testimonial[$id_lang_default] = $testimonial_default;
        $languages = Language::getLanguages(true);
        if($languages)
        {
            foreach($languages as $language)
            {
                $id_lang = (int)$language['id_lang'];
                if($id_lang != $id_lang_default)
                {
                    $testimonial = Tools::getValue('testimonial_'.$id_lang);
                    if($testimonial && !Validate::isCleanHtml($testimonial))
                    {
                        $this->_errors[] = sprintf($this->l('Testimonial is not valid in %s'),$language['iso_code']);
                    }
                    else
                    {
                        $review->testimonial[$id_lang] = $testimonial ? : $testimonial_default;
                    }
                }
                
            }
        }
        if($id_product && !Validate::isUnsignedId($id_product))
            $this->_errors[] = $this->l('Product is not valid');
        elseif($id_product  && ($product = new Product($id_product)) && !Validate::isLoadedObject($product))
            $this->_errors[] = $this->l('Product does not exist');
        else
            $review->id_product = $id_product;
        if($license && !Validate::isCleanHtml($license))
            $this->_errors[] = $this->l('Author is not valid');
        else
            $review->license = $license;
        if(isset($_FILES['avatar']) && isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] && isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name'])
        {
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['avatar']['name'], '.'), 1));    
            if(!Validate::isFileName(str_replace(array(' ','(',')','!','@','#','+'),'_',$_FILES['avatar']['name'])))
                $this->_errors[] = $this->l('Avatar filename is not valid');
            elseif(!in_array($type, array('jpg', 'gif', 'jpeg', 'png','webp')))
                $this->_errors[] = $this->l('Avatar file type is not valid');
            else{
                $max_file_size = Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024;			
				if ($_FILES['avatar']['size'] > $max_file_size)
					$this->_errors[] = sprintf($this->l('Avatar size is too large (%s Mb). Maximum size allowed: %s Mb'),Tools::ps_round((float)$_FILES['avatar']['size']/1048576,2), Tools::ps_round(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),2));
                else
                {
                    $avatar_old = $review->avatar;
                    $review->avatar = $this->uploadFile('avatar',$this->_errors,_PS_TESTIMONIAL_IMG_DIR_.'avatars/');
                    $avatar_name = $review->avatar;
                }
            }
        }
        if(isset($_FILES['additional']) && isset($_FILES['additional']['name']) && $_FILES['additional']['name'] && isset($_FILES['additional']['tmp_name']) && $_FILES['additional']['tmp_name'])
        {
            if(!is_dir(_PS_TESTIMONIAL_IMG_DIR_.'additional'))
                @mkdir(_PS_TESTIMONIAL_IMG_DIR_.'additional',0755,true);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['additional']['name'], '.'), 1));
            if(!Validate::isFileName(str_replace(array(' ','(',')','!','@','#','+'),'_',$_FILES['additional']['name'])))
                $this->_errors[] = $this->l('Alternative product image file name is not valid');
            elseif(!in_array($type, array('jpg', 'gif', 'jpeg', 'png','webp')))
                $this->_errors[] = $this->l('Alternative product image file type is not valid');
            else{
                $max_file_size = Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024; 				
				if ($_FILES['additional']['size'] > $max_file_size)
					$this->_errors[] = sprintf($this->l('Alternative product image file size is too large (%s Mb). Maximum size allowed: %s Mb'),Tools::ps_round((float)$_FILES['additional']['size']/1048576,2), Tools::ps_round(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),2));
                else
                {
                    $additional_old = $review->additional;
                    $review->additional = $this->uploadFile('additional',$this->_errors,_PS_TESTIMONIAL_IMG_DIR_.'additional/');
                    $additional_name = $review->additional;
                }
            }
        }
        if(!$this->_errors)
        {
            if($review->id)
            {
                if($review->update())
                {
                    if(isset($avatar_old) && $avatar_old && file_exists(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar_old))
                        @unlink(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar_old);
                    if(isset($additional_old) && $additional_old && file_exists(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional_old))
                        @unlink(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional_old);
                    Tools::redirectAdmin($this->baseLink.'&conf=4');
                }
                else
                    $this->_errors[] = $this->l('An error occurred while updating the review');
            }elseif($review->add())
                Tools::redirectAdmin($this->baseLink.'&conf=3');
            else
                $this->_errors[] = $this->l('An error occurred while creating the review');
        }
        if($this->_errors)
        {
            if(isset($avatar_name) && $avatar_name && file_exists(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar_name))
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar_name);
            if(isset($additional_name) && $additional_name && file_exists(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional_name))
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional_name);
            $this->_html .= $this->displayError($this->_errors);
        }
    }
    public function postSubmitConfig()
    {
        $this->_postValidation();
        if(!is_dir(_PS_TESTIMONIAL_IMG_DIR_))
            @mkdir(_PS_TESTIMONIAL_IMG_DIR_,0755,true);
        if (!count($this->_errors)) {
            $inputs = $this->getConfigInputs();
            $languages = Language::getLanguages(false);
            $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
            foreach($inputs as $input)
            {
                if(isset($input['lang']) && $input['lang'] && $input['type']!='file_lang')
                {
                    $values = array();
                    foreach($languages as $language)
                    {
                        $value_default = Tools::getValue($input['name'].'_'.$id_lang_default);
                        $value = Tools::getValue($input['name'].'_'.$language['id_lang']);
                        $values[$language['id_lang']] = ($value && Validate::isCleanHtml($value)) || !isset($input['required']) ? $value : (Validate::isCleanHtml($value_default) ? $value_default :'');
                    }
                    Configuration::updateValue($input['name'],$values);
                }
                elseif($input['type']=='file_lang')
                {
                    $values = array();
                    $old_images = array();
                    foreach($languages as $language)
                    {
                        $old_images[$language['id_lang']] = Configuration::get($input['name'],$language['id_lang']);
                        $values[$language['id_lang']] = $this->uploadFile($input['name'].'_'.$language['id_lang'],$this->_errors);
                    }
                    if(!$this->_errors)
                    {
                        foreach($languages as $language)
                        {
                            if(!$values[$language['id_lang']])
                            {
                                $values[$language['id_lang']] = $old_images[$language['id_lang']];
                                unset($old_images[$language['id_lang']]);
                            }
                        }
                        Configuration::updateValue($input['name'],$values);  
                        if($old_images)
                        {
                            foreach($old_images as $image)
                            {
                                if($image)
                                    @unlink(_PS_TESTIMONIAL_IMG_DIR_.$image);
                            }
                        }
                    }
                    elseif($values)
                    {
                        foreach($values as $image)
                        {
                            if($image)
                                    @unlink(_PS_TESTIMONIAL_IMG_DIR_.$image);
                        }
                    }
                }
                else
                {
                    $val = Tools::getValue($input['name']);
                    if(Validate::isCleanHtml($val))
                        Configuration::updateValue($input['name'],$val);
                }
            }
            if($this->_errors)
                $this->_html .= $this->displayError($this->_errors);
            else
                Tools::redirectAdmin($this->baseLink.'&conf=4');
        } else {
            $this->_html .= $this->displayError($this->_errors);
        }
    }
    public function _postValidation()
    {
        $languages = Language::getLanguages(false);
        $inputs = $this->getConfigInputs();
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        foreach($inputs as $input)
        {
            if(isset($input['lang']) && $input['lang'] && $input['type']!='file_lang')
            {
                if(isset($input['required']) && $input['required'])
                {
                    $val_default = Tools::getValue($input['name'].'_'.$id_lang_default);
                    if(!$val_default)
                    {
                        $this->_errors[] = sprintf($this->l('%s is required'),$input['label']);
                    }
                    elseif($val_default && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate) && !Validate::{$validate}($val_default))
                        $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                    elseif($val_default && !Validate::isCleanHtml($val_default))
                        $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                    else
                    {
                        foreach($languages as $language)
                        {
                            if(($value = Tools::getValue($input['name'].'_'.$language['id_lang'])) && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate)  && !Validate::{$validate}($value))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                            elseif($value && !Validate::isCleanHtml($value))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                        }
                    }
                }
                else
                {
                    foreach($languages as $language)
                    {
                        if(($value = Tools::getValue($input['name'].'_'.$language['id_lang'])) && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate)  && !Validate::{$validate}($value))
                            $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                        elseif($value && !Validate::isCleanHtml($value))
                            $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                    }
                }
            }
            elseif($input['type']=='file_lang')
            {
                foreach($languages as $language)
                {
                    if(isset($_FILES[$input['name'].'_'.$language['id_lang']]))
                    {
                        $file = $_FILES[$input['name'].'_'.$language['id_lang']];
                        if(isset($file['tmp_name']) && isset($file['name']) && $file['name'])
                        {
                            $type = Tools::strtolower(Tools::substr(strrchr($file['name'], '.'), 1));
                            if(!Validate::isFileName(str_replace(array(' ','(',')','!','@','#','+'),'_',$file['name'])))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                            elseif(!in_array($type, array('jpg', 'gif', 'jpeg', 'png','webp')))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                            else{
                                $max_file_size = Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024;				
                				if ($file['size'] > $max_file_size)
                					$this->_errors[] = sprintf($this->l('Image is too large (%s Mb). Maximum size allowed: %s Mb'),Tools::ps_round((float)$file['size']/1048576,2), Tools::ps_round(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),2));
                            }
                        } 
                    }
                    
                }
            }else
            {
                $val = Tools::getValue($input['name']);
                if($val===''&& isset($input['required']))
                {
                    $this->_errors[] = sprintf($this->l('%s is required'),$input['label']);
                }
                if($val!=='' && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate) && !Validate::{$validate}($val))
                {
                    $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                }
                elseif($val!==''&& !Validate::isCleanHtml($val))
                    $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
            }
        }
    }
    public function getConfigInputs()
    {
        return array(
            array(
                'type' => 'text',
                'name' => 'ETS_TTN_TITLE',
                'label' => $this->l('Title'),
                'lang' => true,
                'required' => true,
                'default' => $this->l('What do our Customers say?'),
                'default_lang' => 'What do our Customers say?',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'file_lang',
                'name' => 'ETS_TTN_BACKGROUND',
                'label' => $this->l('Background'),
                'lang' => true,
                'desc' => sprintf($this->l('Accepted formats: jpg, png, gif, webp. Limit: %dMb'),Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
            ),
            array(
                'type' =>'switch',
                'label' => $this->l('Auto-play slideshow'),
                'name' => 'ETS_TTN_AUTOPLAY_SLIDESHOW',
                'default'=>1,
                'values' => array(
    				array(
    					'id' => 'active_on',
    					'value' => 1,
    					'label' => $this->l('Yes')
    				),
    				array(
    					'id' => 'active_off',
    					'value' => 0,
    					'label' => $this->l('No')
    				)
    			),
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'text',
                'name' => 'ETS_TTN_TIME_SPEED_SLIDESHOW',
                'label' => $this->l('Slideshow delay time'),
                'suffix' => 'ms',
                'col'=>2,
                'default' => 5000,
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'color',
                'name' => 'ETS_TTN_COLOR_TITLE',
                'label' => $this->l('Title color'),
                'default' => '#ffffff',
                'size' => '',
                'validate' => 'isColor',
            ),
            array(
                'type' => 'color',
                'name' => 'ETS_TTN_COLOR_BUTTON',
                'label' => $this->l('Button color'),
                'default' => '#ffffff',
                'size' => '',
                'validate' => 'isColor',
            ),
            array(
                'type'=>'select',
                'name' => 'ETS_TTN_VARTICAL_TITLE',
                'label' => $this->l('Title alignment'),
                'options' => array(
        			 'query' => array(
                        array(
                            'id' => 'left',
                            'name' => $this->l('Left'),
                        ),
                        array(
                            'id' => 'center',
                            'name' => $this->l('Center'),
                        ),
                        array(
                            'id' => 'right',
                            'name' => $this->l('Right'),
                        )
                     ),                             
                     'id' => 'id',
        			 'name' => 'name'  
                ),    
                'default' => 'center',
                'validate' => 'isCleanHtml',
            ),
            array(
                'type' => 'radio',
                'name' => 'ETS_TTN_SORT_ORDER_TYPE',
                'label' => $this->l('Order by'),
                'default' => 'default',
                'values' => array(
                    array(
                        'value' => 'default',
                        'label' => $this->l('Default'),
                        'id'=> 'ETS_TTN_SORT_ORDER_TYPE_default',
                    ),
                    array(
                        'value' => 'random',
                        'label' => $this->l('Random'),
                        'id'=> 'ETS_TTN_SORT_ORDER_TYPE_random',
                    )
                ),
                'validate' => 'isCleanHtml',
            ),
        );
    }
    public function renderFormConfig()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration'),
                    'icon' => 'icon-cog'
                ),
                'input' => $this->getConfigInputs(),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->id = $this->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->baseLink;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $language->id;
        $helper->override_folder ='/';
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'link' => $this->context->link,
            'image_baseurl' => _PS_TESTIMONIAL_IMG_,
            'is15' => version_compare(_PS_VERSION_, '1.6', '<') ? true: false,
            'image_del_link' => $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&delImageConfig=1'
        );
        $this->fields_form = array();
        return $helper->generateForm(array($fields_form));
    }
    public function getConfigFieldsValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();
        $inputs = $this->getConfigInputs();
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(!isset($input['lang']))
                {
                    $fields[$input['name']] = Tools::getValue($input['name'],Configuration::get($input['name']));
                }
                else
                {
                    foreach($languages as $language)
                    {
                        if($input['type']=='file_lang')
                            $fields[$input['name']][$language['id_lang']] = Configuration::get($input['name'],$language['id_lang']);
                        else    
                            $fields[$input['name']][$language['id_lang']] = Tools::getValue($input['name'].'_'.$language['id_lang'],Configuration::get($input['name'],$language['id_lang']));
                    }
                }
            }
        }
        return $fields;
    }
    public function uploadFile($name,&$errors,$dirimg = '')
    {
        if(!$dirimg)
            $dirimg = _PS_TESTIMONIAL_IMG_DIR_;
        if(!is_dir($dirimg))
        {
            @mkdir($dirimg,0755,true);
        }
        if(isset($_FILES[$name]['tmp_name']) && isset($_FILES[$name]['name']) && $_FILES[$name]['name'])
        {
            if(!Validate::isFileName(str_replace(array(' ','(',')','!','@','#','+'),'_',$_FILES[$name]['name'])))
                $errors[] = '"'.$_FILES[$name]['name'].'" '.$this->l('file name is not valid');
            else
            {
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$name]['name'], '.'), 1));
                $file_name = str_replace(array(' ','(',')','!','@','#','+'),'_',$_FILES[$name]['name']); 
                if($type=='webp')
                    $file_name = str_replace('.webp','.jpg',$file_name);
                while(file_exists($dirimg.$file_name))
                {
                    $file_name = Tools::strtolower(Tools::passwdGen(4,'NO_NUMERIC')).$file_name;
                }
    			if (isset($_FILES[$name]) &&				
    				!empty($_FILES[$name]['tmp_name']) &&
    				in_array($type, array('jpg', 'gif', 'jpeg', 'png','webp'))
    			)
    			{   
                    $max_file_size = Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024;				
    				if ($_FILES[$name]['size'] > $max_file_size)
    					$errors[] = sprintf($this->l('Image is too large (%s Mb). Maximum size allowed: %s Mb'),Tools::ps_round((float)$_FILES[$name]['size']/1048576,2), Tools::ps_round(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),2));
    				elseif ( !move_uploaded_file($_FILES[$name]['tmp_name'], $dirimg.$file_name))
					   $errors[] = $this->l('Cannot upload the file');
                    if(!$errors)
                        return $file_name;		
    			}
                else
                {
                    $errors[] = $this->l('File is not valid');
                }
            }
                
        }
        return '';
    }
    public function renderList($listData)
    { 
        if(isset($listData['fields_list']) && $listData['fields_list'])
        {
            foreach($listData['fields_list'] as $key => &$val)
            {
                $value_key = (string)Tools::getValue($key);
                $value_key_max = (string)Tools::getValue($key.'_max');
                $value_key_min = (string)Tools::getValue($key.'_min');
                if(isset($val['filter']) && $val['filter'] && ($val['type']=='int' || $val['type']=='date'))
                {
                    if(Tools::isSubmit('ets_ttn_submit_'.$listData['name']))
                    {
                        $val['active']['max'] =  trim($value_key_max);   
                        $val['active']['min'] =  trim($value_key_min); 
                    }
                    else
                    {
                        $val['active']['max']='';
                        $val['active']['min']='';
                    }  
                }  
                elseif(!Tools::isSubmit('del') && Tools::isSubmit('ets_ttn_submit_'.$listData['name']))               
                    $val['active'] = trim($value_key);
                else
                    $val['active']='';
            }
        }  
        if(!isset($listData['class']))
            $listData['class']='';  
        $this->smarty->assign($listData);
        return $this->display(__FILE__, 'list_helper.tpl');
    }
    public function getFilterParams($field_list,$table='')
    {
        $params = '';        
        if($field_list)
        {
            if(Tools::isSubmit('ets_ttn_submit_'.$table))
                $params .='&ets_ttn_submit_'.$table.='=1';
            foreach($field_list as $key => $val)
            {
                $value_key = (string)Tools::getValue($key);
                $value_key_max = (string)Tools::getValue($key.'_max');
                $value_key_min = (string)Tools::getValue($key.'_min');
                if($value_key!='')
                {
                    $params .= '&'.$key.'='.urlencode($value_key);
                }
                if($value_key_max!='')
                {
                    $params .= '&'.$key.'_max='.urlencode($value_key_max);
                }
                if($value_key_min!='')
                {
                    $params .= '&'.$key.'_min='.urlencode($value_key_min);
                } 
            }
            unset($val);
        }
        return $params;
    }
    public function renderListReviews(){
        $fields_list = array(
            'id_ets_ttn_review' => array(
                'title' => $this->l('ID'),
                'width' => 40,
                'type' => 'text',
                'sort' => true,
                'filter' => true,
            ),
            'rate' => array(
                'title' => $this->l('Rate'),
                'type' => 'int',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,                
            ),
            'testimonial' => array(
                'title' => $this->l('Testimonial'),
                'type'=>'text',
                'sort'=>false,
                'filter'=>true,
                'strip_tag'=>true,
            ),
            'product_image' => array(
                'title' => $this->l('Product image'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'product_name' => array(
                'title' => $this->l('Product name'),
                'width' => 40,
                'type' => 'text',
                'sort' => true,
                'filter' => true,
            ),
            'avatar' => array(
                'title' => $this->l('Avatar'),
                'type' => 'text',
                'sort' => false,
                'filter' => false,
                'strip_tag' => false,
            ),
            'license' => array(
                'title' => $this->l('Author'),
                'type'=>'text',
                'sort'=>false,
                'filter'=>true,
                'strip_tag'=>false,
            ),
            'position' => array(
                'type' => 'text',
                'title' => $this->l('Position'),
                'update_position' => true,
                'sort' => true,
            ),
            'enabled' => array(
                'title' => $this->l('Enabled'),
                'type' => 'active',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
                'filter_list' => array(
                    'id_option' => 'active',
                    'value' => 'title',
                    'list' => array(
                        1 => array(
                            'active' => 1,
                            'title' => $this->l('Yes')
                        ),
                        0 => array(
                            'active' => 0,
                            'title' => $this->l('No')
                        )
                    )
                )
            ),
        );
        //Filter
        $show_resset = false;
        $filter = "";
        if(Tools::isSubmit('ets_ttn_submit_ttn_reviews'))
        {
            if(($id= Tools::getValue('id_ets_ttn_review'))!='' && Validate::isCleanHtml($id))
            {
                $filter .=' AND r.id_ets_ttn_review="'.(int)$id.'"';
                $show_resset = true;
            }
            if(($product_name= Tools::getValue('product_name'))!='' && Validate::isCleanHtml($product_name))
            {
                $filter .=' AND pl.name LIKE "%'.pSQL($product_name).'%"';
                $show_resset = true;
            }
            if(($rate_min= Tools::getValue('rate_min'))!='' && Validate::isCleanHtml($rate_min))
            {
                $filter .=' AND r.rate>= "'.(float)$rate_min.'"';
                $show_resset = true;
            }
            if(($rate_max = Tools::getValue('rate_max'))!='' && Validate::isCleanHtml($rate_max))
            {
                $filter .=' AND r.rate<="'.(float)$rate_max.'"';
                $show_resset = true;
            }
            if(($license = Tools::getValue('license'))!='' && Validate::isCleanHtml($license))
            {
                $filter .=' AND r.license LIKE "%'.pSQL($license).'%"';
                $show_resset = true;
            }
            if(($testimonial = Tools::getValue('testimonial'))!='' && Validate::isCleanHtml($testimonial))
            {
                $filter .=' AND rl.testimonial LIKE "%'.pSQL($testimonial).'%"';
                $show_resset = true;
            }
            if(($enabled = Tools::getValue('enabled'))!='' && Validate::isInt($enabled))
            {
                $filter .=' AND r.enabled="'.(int)$enabled.'"';
                $show_resset = true;
            }
        }
        //Sort
        $sort = "";
        $sort_type=Tools::getValue('sort_type','asc');
        $sort_value = Tools::getValue('sort','position');
        if($sort_value)
        {
            switch ($sort_value) {
                case 'id_ets_ttn_review':
                    $sort .='r.id_ets_ttn_review';
                    break;
                case 'product_name':
                    $sort .='pl.name';
                    break;
                case 'license':
                    $sort .='r.license';
                    break;
                case 'testimonial':
                    $sort .='rl.testimonial';
                    break;
                case 'rate':
                    $sort .='r.rate';
                    break;
                case 'enabled':
                    $sort .='r.enabled';
                    break;
                case 'position':
                    $sort .='r.position';
                    break;
            }
            if($sort && $sort_type && in_array($sort_type,array('asc','desc')))
                $sort .= ' '.trim($sort_type);  
        }
        //Paggination
        $page = (int)Tools::getValue('page');
        if($page<=0)
            $page = 1;
        $totalRecords = Ets_ttn_review::getReviews($filter,0,0,'',true);
        $paggination = new Ets_ttn_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->url = $this->baseLink.'&page=_page_'.$this->getFilterParams($fields_list,'ttn_reviews');
        $paggination->limit =  (int)Tools::getValue('paginator_review_select_limit',20);
        $paggination->name ='review';
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $reviews = Ets_ttn_review::getReviews($filter, $start,$paggination->limit,$sort,false);
        if($reviews)
        {
            foreach($reviews as &$review)
            {
                if($review['id_product'] && ($image = Ets_ttn_review::getImageProduct($review['id_product'],'small')))
                {
                    $review['product_image'] = $this->displayText('','img',null,null,null,null,$image);
                }
                if($review['avatar'])
                    $review['avatar'] = $this->displayText('','img',null,null,null,null,$this->context->link->getMediaLink(_PS_TESTIMONIAL_IMG_.'avatars/'.$review['avatar']));
            }
        }
        $paggination->text =  $this->l('Showing {start} to {end} of {total} ({pages} Pages)');
        $listData = array(
            'name' => 'ttn_reviews',
            'icon' => 'fa fa-review',
            'actions' => array('view','delete','duplicate'),
            'currentIndex' => $this->baseLink.($paggination->limit!=20 ? '&paginator_review_select_limit='.$paggination->limit:''),
            'postIndex' => $this->baseLink,
            'identifier' => 'id_ets_ttn_review',
            'show_toolbar' => true,
            'show_action' => true,
            'title' => $this->l('Testimonial'),
            'fields_list' => $fields_list,
            'field_values' => $reviews,
            'paggination' => $paggination->render(),
            'filter_params' => $this->getFilterParams($fields_list,'ttn_reviews'),
            'show_reset' =>$show_resset,
            'totalRecords' => $totalRecords,
            'sort'=> $sort_value,
            'show_add_new'=> true,
            'link_new' => $this->baseLink.'&addnewreview=1', 
            'sort_type' => $sort_type,
            'bulk_actions' => true,
        ); 
        return $this->renderList($listData);
    }   
    public function displayText($content=null,$tag,$class=null,$id=null,$href=null,$blank=false,$src = null,$name = null,$value = null,$type = null,$data_id_product = null,$rel = null,$attr_datas=null)
    {
        $this->smarty->assign(
            array(
                'content' =>$content,
                'tag' => $tag,
                'class'=> $class,
                'id' => $id,
                'href' => $href,
                'blank' => $blank,
                'src' => $src,
                'name' => $name,
                'value' => $value,
                'type' => $type,
                'data_id_product' => $data_id_product,
                'attr_datas' => $attr_datas,
                'rel' => $rel,
            )
        );
        return $this->display(__FILE__,'html.tpl');
    }
    public function displayPaggination($limit,$name)
    {
        $this->context->smarty->assign(
            array(
                'limit' => $limit,
                'pageName' => $name,
            )
        );
        return $this->display(__FILE__,'limit.tpl');
    }
    public function getBaseLink()
    {
        $url = (Configuration::get('PS_SSL_ENABLED_EVERYWHERE') && Configuration::get('PS_SSL_ENABLED') ?'https://':'http://').$this->context->shop->domain.$this->context->shop->getBaseURI();
        return trim($url,'/');
    }
    public function rrmdir($dir) {
        $dir = rtrim($dir,'/');
        if ($dir && is_dir($dir)) {
             if($objects = scandir($dir))
             {
                 foreach ($objects as $object) {
                       if ($object != "." && $object != "..") {
                         if (is_dir($dir."/".$object) && !is_link($dir."/".$object))
                           $this->rrmdir($dir."/".$object);
                         else
                           @unlink($dir."/".$object);
                       }
                 }
             }
             rmdir($dir);
       }
       return true;
    }
    public function submitBulkActionReview(){
        $reviews = Tools::getValue('ttn_reviews_readed');
        $bulk_action_ttn_reviews = Tools::getValue('bulk_action_ttn_reviews');
        if($reviews && is_array($reviews))
        {
            switch($bulk_action_ttn_reviews)
            {
                case 'delete_all':
                    foreach(array_keys($reviews) as $id)
                    {
                        if(Validate::isUnsignedId($id) && ($review = new Ets_ttn_review($id)) && Validate::isLoadedObject($review))
                            $review->delete();
                    }
                    Tools::redirectAdmin($this->baseLink.'&conf=2');
                break;
                case 'duplicate_all':
                    foreach(array_keys($reviews) as $id)
                    {
                        if(Validate::isUnsignedId($id) && ($review = new Ets_ttn_review($id)) && Validate::isLoadedObject($review))
                        {
                            $review->duplicate();
                        }
                    }
                    Tools::redirectAdmin($this->baseLink.'&conf=19');
                break;
                case 'active_all':
                    foreach(array_keys($reviews) as $id)
                    {
                        if(Validate::isUnsignedId($id) && ($review = new Ets_ttn_review($id)) && Validate::isLoadedObject($review))
                        {
                            $review->enabled=1;
                            $review->update();
                        }
                    }
                    Tools::redirectAdmin($this->baseLink.'&conf=5');
                break;
                case 'deactive_all':
                    foreach(array_keys($reviews) as $id)
                    {
                        if(Validate::isUnsignedId($id) && ($review = new Ets_ttn_review($id)) && Validate::isLoadedObject($review))
                        {
                            $review->enabled=0;
                            $review->update();
                        }
                    }
                    Tools::redirectAdmin($this->baseLink.'&conf=5');
                break;
            }
        }
    }
    public static function validateArray($array,$validate='isCleanHtml')
    {
        if(!is_array($array))
            return false;
        if(method_exists('Validate',$validate))
        {
            if($array && is_array($array))
            {
                $ok= true;
                foreach($array as $val)
                {
                    if(!is_array($val))
                    {
                        if($val && !Validate::$validate($val))
                        {
                            $ok= false;
                            break;
                        }
                    }
                    else
                        $ok = self::validateArray($val,$validate);
                }
                return $ok;
            }
        }
        return true;
    }
    public function displayError($error)
    {
        $this->context->smarty->assign(
            array(
                'module_errors' => $error,
            )
        );
        return $this->display(__FILE__,'errors.tpl');
    }
    public function getTextLang($text, $lang, $file = '')
    {
        $modulePath = rtrim(_PS_MODULE_DIR_, '/') . '/' . $this->name;
        $fileTransDir = $modulePath . '/translations/' . $lang['iso_code'] . '.' . 'php';
        if (!@file_exists($fileTransDir)) {
            return $text;
        }
        $fileContent = Tools::file_get_contents($fileTransDir);
        $strMd5 = md5($text);
        $keyMd5 = '<{' . $this->name . '}prestashop>' . ($file ?: $this->name) . '_' . $strMd5;
        preg_match('/(\$_MODULE\[\'' . preg_quote($keyMd5) . '\'\]\s*=\s*\')(.*)(\';)/', $fileContent, $matches);
        if ($matches && isset($matches[2])) {
            return $matches[2];
        }
        return $text;
    }
    public function displayIframe()
    {
        switch($this->context->language->iso_code) {
            case 'en':
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'it':
                $url = 'https://cdn.prestahero.com/it/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'fr':
                $url = 'https://cdn.prestahero.com/fr/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            case 'es':
                $url = 'https://cdn.prestahero.com/es/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
                break;
            default:
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
        }
        $this->smarty->assign(
            array(
                'url_iframe' => $url
            )
        );
        return $this->display(__FILE__,'iframe.tpl');
    }
}