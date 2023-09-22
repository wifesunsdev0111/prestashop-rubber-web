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
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
class Ets_ttn_review extends ObjectModel
{
    protected static $instance;
    public $id_product;
    public $id_shop;
    public $additional;
    public $avatar;
    public $rate;
    public $testimonial;
    public $license;
    public $enabled;
    public $position;
    public $date_add;
    public $date_upd;
    public static $definition = array(
		'table' => 'ets_ttn_review',
		'primary' => 'id_ets_ttn_review',
		'multilang' => true,
		'fields' => array(
			'id_product' => array('type' => self::TYPE_INT),
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'avatar' => array('type'=>self::TYPE_STRING),
            'additional' => array('type'=>self::TYPE_STRING),
            'rate' => array('type' => self::TYPE_FLOAT),
            'license' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'enabled' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
            'testimonial' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','lang'=>true),            
        )
	);
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Ets_ttn_review();
        }
        return self::$instance;
    }
    public static function getReviews($filter='',$start=0,$limit=12,$order_by='',$total=false)
    {
        if($total)
            $sql = 'SELECT COUNT(DISTINCT r.id_ets_ttn_review)';
        else
            $sql ='SELECT r.*,rl.testimonial,pl.name as product_name';
        $sql .= ' FROM `'._DB_PREFIX_.'ets_ttn_review` r
        LEFT JOIN `'._DB_PREFIX_.'ets_ttn_review_lang` rl ON (r.id_ets_ttn_review = rl.id_ets_ttn_review AND rl.id_lang="'.(int)Context::getContext()->language->id.'")
        LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.id_product= r.id_product)
        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.id_product= p.id_product AND pl.id_lang="'.(int)Context::getContext()->language->id.'")
        WHERE r.id_shop="'.(int)Context::getContext()->shop->id.'"'.($filter ? $filter:'');
        if(!$total)
        {
            $sql .=' GROUP BY r.id_ets_ttn_review ';
            $sql .= ($order_by ? ' ORDER By '.$order_by :'');
            if($limit!==false)
                $sql .= ' LIMIT '.(int)$start.','.(int)$limit;
        }
        if($total)
            return Db::getInstance()->getValue($sql);
        else
        {
            return Db::getInstance()->executeS($sql);
        }
    }
    public static function isExists($id_review)
    {
        return (int)Db::getInstance()->getValue('SELECT id_ets_ttn_review FROM '._DB_PREFIX_.'ets_ttn_review WHERE id_ets_ttn_review="'.(int)$id_review.'" AND id_shop='.(int)Context::getContext()->shop->id);
    }
    public function renderForm()
    {
        $module = Module::getInstanceByName('ets_testimonial');
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->id ? $this->l('Edit testimonial'): $this->l('Add testimonial'),
                    'icon' =>'icon-review',				
				),
				'input' => array(
                    array(
                        'type'=>'hidden',
                        'name' => 'id_ets_ttn_review',
                    ),
                    array(
						'type' => 'rate',
						'label' => $this->l('Rate'),
						'name' => 'rate',
                        'col'=>3, 
                        'required' => true, 					                    
					),
                    array(
                        'type' =>'textarea',
                        'label' => $this->l('Testimonial'),
                        'name' => 'testimonial',
                        'lang' => true,
                        'cols'=>6,
                        'rows' => '',
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
						'label' => $this->l('Author'),
                        'name' => 'license',
                    ),   
                    array(
                        'type'=>'hidden',
                        'name' => 'id_product',
                    ),					
					array(
						'type' => 'text',
						'label' => $this->l('Product name'),
						'name' => 'product_name', 
                        'placeholder'=> $this->l('Search ID, product name, ref'),
                        'suffix' => Module::getInstanceByName('ets_testimonial')->displayText('','i','fa fa-search'),
                        'col'=>3,
                        'form_group_class' => 'form_search_product',				                     
					),
                    array(	
                        'type' => 'file',
						'label' => $this->l('Alternative product image'),
						'name' => 'additional',
                        'delete_url' => Module::getInstanceByName('ets_testimonial')->baseLink.'&editttn_reviews=1&delAdditional&id_ets_ttn_review='.$this->id,
                        'image' =>$this->additional ? Module::getInstanceByName('ets_testimonial')->displayText('','img','ets_ttn_additional','','','',$module->getBaseLink().'/img/'.$module->name.'/additional/'.$this->additional):false,
                        'desc' => sprintf($this->l('If the selected product does not have product image, the uploaded alternative product image will be displayed. Recommended size: 80x80px. Accepted formats: jpg, png, gif, webp. Limit: %sMb'),Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
					),       
                    array(	
                        'type' => 'file',
						'label' => $this->l('Avatar'),
						'name' => 'avatar',
                        'delete_url' => Module::getInstanceByName('ets_testimonial')->baseLink.'&editttn_reviews=1&delAvatar&id_ets_ttn_review='.$this->id,
                        'image' =>$this->avatar ? Module::getInstanceByName('ets_testimonial')->displayText('','img','ets_ttn_avatar','','','',$module->getBaseLink().'/img/'.$module->name.'/avatars/'.$this->avatar):false,
                        'desc' => sprintf($this->l('Avatar image for author. Recommended size: 150x150px. Accepted formats: jpg, png, gif,webp. Limit: %sMb'),Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
					),
                    array(
                        'type' =>'switch',
                        'label' => $this->l('Enabled'),
                        'name' => 'enabled',
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
                    ),
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				),
                'buttons' => array(
                    array(
                        'href' =>$module->baseLink,
                        'icon'=>'process-icon-cancel',
                        'title' => $this->l('Cancel'),
                    )
                ),
            ),
		);
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = 'ps_ets_ttn_review';
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $module;
		$helper->identifier = 'id_ps_ets_ttn_review';
		$helper->submit_action = 'saveReview';
		$helper->currentIndex = $module->baseLink.($this->id ? '&editttn_reviews=1&id_ets_ttn_review='.$this->id :'&addnewreview=1');
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $context = Context::getContext();
		$helper->tpl_vars = array(
			'base_url' => $context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
			'fields_value' => $this->getReviewFieldsValues(),
			'languages' => $context->controller->getLanguages(),
			'id_language' => $context->language->id,
			'image_baseurl' => '',
            'link' => $context->link,
            'is15' => version_compare(_PS_VERSION_, '1.6', '<') ? true: false,
            'cancel_url' => $module->baseLink,
		);            
        return $helper->generateForm(array($fields_form));
    }
    public function getReviewFieldsValues()
    {
        $languages = Language::getLanguages(true);
        $testimonials = array();
        if($languages)
        {
            foreach($languages as $language)
            {
                $id_lang = $language['id_lang'];
                $testimonials[$id_lang] = Tools::getValue('testimonial_'.$id_lang,$this->testimonial[$id_lang]);
            } 
        }
        $fields = array(
            'id_ets_ttn_review' => $this->id,
            'product_name' => ($id_product = (int)Tools::getValue('id_product',$this->id_product)) && ($product = new Product($id_product)) ?  ( ($image = Ets_ttn_review::getImageProduct($product->id,'small')) ? Module::getInstanceByName('ets_testimonial')->displayText('','img',null,null,null,null,$image):'').$product->name[Context::getContext()->language->id].' ('.$product->reference.')':'',
            'id_product'=> Tools::getValue('id_product',$this->id_product),
            'rate' => Tools::getValue('rate',$this->id ? $this->rate:5),
            'license' => Tools::getValue('license',$this->license),
            'testimonial' => $testimonials,
            'enabled' => (int)Tools::getValue('enabled',$this->id ? $this->enabled :1)
        );
        return $fields;
    }
    public static function getImageProduct($id_product,$type='cart')
    {
        if(($product = new Product($id_product,false,Context::getContext()->language->id)) && Validate::isLoadedObject($product))
        {
            if(!($id_image = (int)Db::getInstance()->getValue('SELECT id_image FROM '._DB_PREFIX_.'image WHERE id_product='.(int)$id_product.' AND cover=1')))
                $id_image = (int)Db::getInstance()->getValue('SELECT id_image FROM '._DB_PREFIX_.'image WHERE id_product='.(int)$id_product);
            if($id_image)
            {
                if(version_compare(_PS_VERSION_, '1.7', '>='))
                    $type_image= ImageType::getFormattedName($type);
                else
                    $type_image= ImageType::getFormatedName($type);
                return Context::getContext()->link->getImageLink($product->link_rewrite,$id_image,$type_image);
            }
        }
        return '';
    }
    public function l($string)
    {
        return Translate::getModuleTranslation('ets_testimonial', $string, pathinfo(__FILE__, PATHINFO_FILENAME));
    }
    public function add($auto_date=true,$null_values=false)
    {
        $max_posistion = Db::getInstance()->getValue('SELECT max(position) FROM '._DB_PREFIX_.'ets_ttn_review');
        $this->position = $max_posistion+1;
        return parent::add($auto_date,$null_values);
    }
    public function delete()
    {
        if(parent::delete())
        {
            if($this->avatar)
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$this->avatar);
            if($this->additional)
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$this->additional);
            return true;
        }
    }
    public function updatePostion($reviews)
    {
        $limit = (int)Tools::getValue('limit',20);
        $page = (int)Tools::getValue('page',1);
        if($reviews)
        {
            foreach($reviews as $key=> $id)
            {
                $position = ($page-1)*$limit +$key+1;
                Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_ttn_review SET position ="'.(int)$position.'" WHERE id_ets_ttn_review='.(int)$id);
            }
            die(
                Tools::jsonEncode(
                    array(
                        'success' => $this->l('Updated successfully'),
                        'page'=>$page
                    )
                )
            );
        }
    }
    public function duplicate()
    {
        if($this->additional)
        {
            $additional_old = $this->additional;
            $type = Tools::strtolower(Tools::substr(strrchr($additional_old, '.'), 1));
            $additional = Tools::strtolower(Tools::passwdGen(12,'NO_NUMERIC')).'.'.$type;
            Tools::copy(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional_old,_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional);
            $this->additional= $additional;
        }
        if($this->avatar)
        {
            $avatar_old = $this->avatar;
            $type = Tools::strtolower(Tools::substr(strrchr($avatar_old, '.'), 1));
            $avatar = Tools::strtolower(Tools::passwdGen(12,'NO_NUMERIC')).'.'.$type;
            Tools::copy(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar_old,_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar);
            $this->avatar = $avatar;
        }
        unset($this->id);
        if($this->add())
        {
            return true;
        }
        else
        {
            if(isset($additional) && $additional)
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'additional/'.$additional);
            if(isset($avatar) && $avatar)
                @unlink(_PS_TESTIMONIAL_IMG_DIR_.'avatars/'.$avatar);
        }
    }
}