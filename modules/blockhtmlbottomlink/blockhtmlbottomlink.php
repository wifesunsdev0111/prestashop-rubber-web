<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 6844 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class blockhtmlbottomlink extends Module
{
	public function __construct()
	{
		$this->name = 'blockhtmlbottomlink';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'PrestaShop';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Bottom link html text');
		$this->description = $this->l('Bottom link html text.');
		$path = dirname(__FILE__);
		if (strpos(__FILE__, 'Module.php') !== false)
			$path .= '/../modules/'.$this->name;
		include_once $path.'/blockhtmlbottomlinkClass.php';
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('bottom') || !$this->registerHook('displayHeader'))
			return false;

		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockhtmlbottomlink` (
			`id_blockhtmlbottomlink` int(10) unsigned NOT NULL auto_increment,
			`id_shop` int(10) unsigned NOT NULL ,
			`body_home_logo_link` varchar(255) NOT NULL,
			PRIMARY KEY (`id_blockhtmlbottomlink`))
			ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');

		if ($res)
			$res &= Db::getInstance()->execute('
				CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockhtmlbottomlink_lang` (
				`id_blockhtmlbottomlink` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`body_title` varchar(255) NOT NULL,
				`body_subheading` varchar(255) NOT NULL,
				`body_paragraph` text NOT NULL,
				`body_logo_subheading` varchar(255) NOT NULL,
				PRIMARY KEY (`id_blockhtmlbottomlink`, `id_lang`))
				ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');


		if ($res)
			foreach
			(Shop::getShops(false) as $shop)
				$res &= $this->createExampleblockhtmlbottomlink($shop['id_shop']);

			if (!$res)
				$res &= $this->uninstall();

			return $res;
	}

	private function createExampleblockhtmlbottomlink($id_shop)
	{
		$blockhtmlbottomlink = new blockhtmlbottomlinkClass();
		$blockhtmlbottomlink->id_shop = (int)$id_shop;
		$blockhtmlbottomlink->body_home_logo_link = 'http://www.prestashop.com';
		foreach (Language::getLanguages(false) as $lang)
		{
			$blockhtmlbottomlink->body_title[$lang['id_lang']] = 'Lorem ipsum dolor sit amet';
			$blockhtmlbottomlink->body_subheading[$lang['id_lang']] = 'Excepteur sint occaecat cupidatat non proident';
			$blockhtmlbottomlink->body_paragraph[$lang['id_lang']] = '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>';
			$blockhtmlbottomlink->body_logo_subheading[$lang['id_lang']] = 'Lorem ipsum presta shop amet';
		}
		return $blockhtmlbottomlink->add();
	}

	public function uninstall()
	{
		$res = Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'blockhtmlbottomlink`');
		$res &= Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'blockhtmlbottomlink_lang`');

		if (!$res || !parent::uninstall())
			return false;

		return true;
	}

	private function initForm()
	{
		$languages = Language::getLanguages(false);
		foreach ($languages as $k => $language)
			$languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'blockhtmlbottomlink';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->languages = $languages;
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = true;
		$helper->toolbar_scroll = true;
		$helper->toolbar_btn = $this->initToolbar();
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitUpdateblockhtmlbottomlink';
		
		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->displayName,
				'image' => $this->_path.'logo.gif'
			),
			'submit' => array(
				'name' => 'submitUpdateblockhtmlbottomlink',
				'title' => $this->l('   Save   '),
				'class' => 'button'
			),
			'input' => array(
				
				array(
					'type' => 'textarea',
					'label' => $this->l('Footer text'),
					'name' => 'body_paragraph',
					'lang' => true,
					'autoload_rte' => true,
					'hint' => $this->l('Text of your choice; for example, explain your mission, highlight a new product, or describe a recent event.'),
					'cols' => 60,
					'rows' => 30
				),
				
			)
		);		
		return $helper;
	}

	private function initToolbar()
	{
		$this->toolbar_btn['save'] = array(
			'href' => '#',
			'desc' => $this->l('Save')
		);
		
		return $this->toolbar_btn;
	}

	public function getContent()
	{
		$this->_html = '';
		$this->postProcess();
		
		$helper = $this->initForm();
		
		$id_shop = (int)$this->context->shop->id;
		$blockhtmlbottomlink = blockhtmlbottomlinkClass::getByIdShop($id_shop);

		if (!$blockhtmlbottomlink) //if blockhtmlbottomlink ddo not exist for this shop => create a new example one
			$this->createExampleblockhtmlbottomlink($id_shop);
		
		foreach($this->fields_form[0]['form']['input'] as $input) //fill all form fields
			if ($input['name'] != 'body_homepage_logo')
				$helper->fields_value[$input['name']] = $blockhtmlbottomlink->{$input['name']};
		
		$helper->fields_value['image'] = (file_exists(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg') ? '<img src="'.$this->_path.'homepage_logo_'.(int)$id_shop.'.jpg">' : '');
		if ($helper->fields_value['image'])
			$helper->fields_value['size'] = filesize(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg') / 1000;
		
		$this->_html .= $helper->generateForm($this->fields_form);
		return $this->_html;
	}

	public function postProcess()
	{
		$errors = '';
		$id_shop = (int)$this->context->shop->id;
		// Delete logo image
		if (Tools::isSubmit('deleteImage'))
		{
			if (!file_exists(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg'))
				$errors .= $this->displayError($this->l('This action cannot be taken.'));
			else
			{
				unlink(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg');
				Configuration::updateValue('blockhtmlbottomlink_IMAGE_DISABLE', 1);
				Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.(int)(Tab::getIdFromClassName('AdminModules')).(int)$this->context->employee->id));
			}
			$this->_html .= $errors;
		}

		if (Tools::isSubmit('submitUpdateblockhtmlbottomlink'))
		{
			$id_shop = (int)$this->context->shop->id;
			$blockhtmlbottomlink = blockhtmlbottomlinkClass::getByIdShop($id_shop);
			$blockhtmlbottomlink->copyFromPost();
			$blockhtmlbottomlink->update();

			/* upload the image */
			if (isset($_FILES['body_homepage_logo']) && isset($_FILES['body_homepage_logo']['tmp_name']) && !empty($_FILES['body_homepage_logo']['tmp_name']))
			{
				Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
				if (file_exists(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg'))
					unlink(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg');
				if ($error = ImageManager::validateUpload($_FILES['body_homepage_logo']))
					$errors .= $error;
				elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['body_homepage_logo']['tmp_name'], $tmpName))
					return false;
				elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg'))
					$errors .= $this->displayError($this->l('An error occurred during the image upload.'));
				if (isset($tmpName))
					unlink($tmpName);
			}
			$this->_html .= $errors == '' ? $this->displayConfirmation($this->l('Settings updated successfully')) : $errors;
			if (file_exists(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg'))
			{
				list($width, $height, $type, $attr) = getimagesize(dirname(__FILE__).'/homepage_logo_'.(int)$id_shop.'.jpg');
				Configuration::updateValue('blockhtmlbottomlink_IMAGE_WIDTH', (int)round($width));
				Configuration::updateValue('blockhtmlbottomlink_IMAGE_HEIGHT', (int)round($height));
				Configuration::updateValue('blockhtmlbottomlink_IMAGE_DISABLE', 0);
			}
		}
	}

	public function hookDisplayHome($params)
	{
		$id_shop = (int)$this->context->shop->id;
		$blockhtmlbottomlink = blockhtmlbottomlinkClass::getByIdShop($id_shop);
		$blockhtmlbottomlink = new blockhtmlbottomlinkClass((int)$blockhtmlbottomlink->id, $this->context->language->id);

		$this->smarty->assign(array(
				'blockhtmlbottomlink' => $blockhtmlbottomlink,
				'default_lang' => (int)$this->context->language->id,
				'image_width' => Configuration::get('blockhtmlbottomlink_IMAGE_WIDTH'),
				'image_height' => Configuration::get('blockhtmlbottomlink_IMAGE_HEIGHT'),
				'id_lang' => $this->context->language->id,
				'homepage_logo' => !Configuration::get('blockhtmlbottomlink_IMAGE_DISABLE') && file_exists('modules/blockhtmlbottomlink/homepage_logo_'.(int)$id_shop.'.jpg'),
				'image_path' => $this->_path.'homepage_logo_'.(int)$id_shop.'.jpg'
			));
		return $this->display(__FILE__, 'blockhtmlbottomlink.tpl');
	}
	public function hookbottom($params)
	{
		$id_shop = (int)$this->context->shop->id;
		$blockhtmlbottomlink = blockhtmlbottomlinkClass::getByIdShop($id_shop);
		$blockhtmlbottomlink = new blockhtmlbottomlinkClass((int)$blockhtmlbottomlink->id, $this->context->language->id);

		$this->smarty->assign(array(
				'blockhtmlbottomlink' => $blockhtmlbottomlink,
				'default_lang' => (int)$this->context->language->id,
				'image_width' => Configuration::get('blockhtmlbottomlink_IMAGE_WIDTH'),
				'image_height' => Configuration::get('blockhtmlbottomlink_IMAGE_HEIGHT'),
				'id_lang' => $this->context->language->id,
				'homepage_logo' => !Configuration::get('blockhtmlbottomlink_IMAGE_DISABLE') && file_exists('modules/blockhtmlbottomlink/homepage_logo_'.(int)$id_shop.'.jpg'),
				'image_path' => $this->_path.'homepage_logo_'.(int)$id_shop.'.jpg'
			));
		return $this->display(__FILE__, 'blockhtmlbottomlink.tpl');
	}	
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS(($this->_path).'blockhtmlbottomlink.css', 'all');
	}

	public function hookFooter( $params ) //made by chabes
	{
		return $this->hookbottom( $params );
	}
}
