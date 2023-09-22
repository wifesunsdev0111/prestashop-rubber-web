<?php
/*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

require (dirname(__FILE__).'/StEasyContentClass.php');
require (dirname(__FILE__).'/StEasyContentFontClass.php');

class StEasyContent extends Module
{
    public  $fields_list;
    public  $fields_value;
    public  $fields_form;
	private $_html = '';
    private $spacer_size = '5';
    public static $location = array(
        36 => array('id' =>36 , 'name' => 'Full width top boxed',     'hook' => 'FullWidthTop', 'full_width' => 1),
        98 => array('id' =>98 , 'name' => 'Full width top',     'hook' => 'FullWidthTop', 'stretched' => 1, 'full_width' => 1),
        86 => array('id' =>86 , 'name' => 'Full width top 2 boxed',     'hook' => 'FullWidthTop2', 'full_width' => 1),
        87 => array('id' =>87 , 'name' => 'Full width top 2',     'hook' => 'FullWidthTop2', 'stretched' => 1, 'full_width' => 1),
        35 => array('id' =>35 , 'name' => 'Top column',         'hook' => 'TopColumn'),
        16 => array('id' =>16 , 'name' => 'Homepage top',       'hook' => 'HomeTop'),
        1 => array('id' =>1   , 'name' => 'Homepage',           'hook' => 'Home'),
        17 => array('id' =>17 , 'name' => 'Homepage bottom',    'hook' => 'HomeBottom'),
        14 => array('id' =>14 , 'name' => 'Homepage secondary left' , 'hook' => 'HomeSecondaryLeft'),
        15 => array('id' =>15 , 'name' => 'Homepage secondary right', 'hook' => 'HomeSecondaryRight'),
        29 => array('id' =>29 , 'name' => 'Homepage tertiary left'  , 'hook' => 'HomeTertiaryLeft'),
        30 => array('id' =>30 , 'name' => 'Homepage tertiaryRight'  , 'hook' => 'HomeTertiaryRight'),
        53 => array('id' =>53 , 'name' => 'Homepage first quarter'  , 'hook' => 'HomeFirstQuarter'),
        54 => array('id' =>54 , 'name' => 'Homepage second quarter' , 'hook' => 'HomeSecondQuarter'),
        58 => array('id' =>58 , 'name' => 'Homepage third quarter'  , 'hook' => 'HomeThirdQuarter'),
        59 => array('id' =>59 , 'name' => 'Homepage fourth quarter' , 'hook' => 'HomeFourthQuarter'),
        28 => array('id' =>28 , 'name' => 'Bottom column'           , 'hook' => 'BottomColumn'),
        37 => array('id' =>37 , 'name' => 'Full width Bottom boxed'       , 'hook' => 'FullWidthBottom', 'full_width' => 1),
        99 => array('id' =>99 , 'name' => 'Full width Bottom', 'hook' => 'FullWidthBottom', 'stretched' => 1, 'full_width' => 1),
        2 => array('id' =>2   , 'name' => 'Left column'             , 'hook' => 'LeftColumn', 'column'=>1),
        10 => array('id' =>10 , 'name' => 'Right column'            , 'hook' => 'RightColumn', 'column'=>1),

        13 => array('id' =>13 , 'name' => 'Footer primary (3/12 wide)'  , 'hook' => 'FooterPrimary'),
        38 => array('id' =>38 , 'name' => 'Footer primary (2/12 wide)'  , 'hook' => 'FooterPrimary'),
        55 => array('id' =>55 , 'name' => 'Footer primary (2.4/12 wide)', 'hook' => 'FooterPrimary'),
        39 => array('id' =>39 , 'name' => 'Footer primary (4/12 wide)'  , 'hook' => 'FooterPrimary'),
        40 => array('id' =>40 , 'name' => 'Footer primary (5/12 wide)'  , 'hook' => 'FooterPrimary'),
        41 => array('id' =>41 , 'name' => 'Footer primary (6/12 wide)'  , 'hook' => 'FooterPrimary'),
        71 => array('id' =>71 , 'name' => 'Footer primary (7/12 wide)'  , 'hook' => 'FooterPrimary'),
        72 => array('id' =>72 , 'name' => 'Footer primary (8/12 wide)'  , 'hook' => 'FooterPrimary'),
        73 => array('id' =>73 , 'name' => 'Footer primary (9/12 wide)'  , 'hook' => 'FooterPrimary'),
        74 => array('id' =>74 , 'name' => 'Footer primary (10/12 wide)' , 'hook' => 'FooterPrimary'),
        42 => array('id' =>42 , 'name' => 'Footer primary (12/12 wide)' , 'hook' => 'FooterPrimary'),

        3  => array('id' =>3 , 'name' => 'Footer secondary (3/12 wide)'     , 'hook' => 'Footer'),
        43 => array('id' =>43 , 'name' => 'Footer secondary (2/12 wide)'    , 'hook' => 'Footer'),
        56 => array('id' =>56 , 'name' => 'Footer secondary (2.4/12 wide)'  , 'hook' => 'Footer'),
        44 => array('id' =>44 , 'name' => 'Footer secondary (4/12 wide)'    , 'hook' => 'Footer'),
        45 => array('id' =>45 , 'name' => 'Footer secondary (5/12 wide)'    , 'hook' => 'Footer'),
        46 => array('id' =>46 , 'name' => 'Footer secondary (6/12 wide)'    , 'hook' => 'Footer'),
        81 => array('id' =>81 , 'name' => 'Footer secondary (7/12 wide)'    , 'hook' => 'Footer'),
        82 => array('id' =>82 , 'name' => 'Footer secondary (8/12 wide)'    , 'hook' => 'Footer'),
        83 => array('id' =>83 , 'name' => 'Footer secondary (9/12 wide)'    , 'hook' => 'Footer'),
        84 => array('id' =>84 , 'name' => 'Footer secondary (10/12 wide)'   , 'hook' => 'Footer'),
        47 => array('id' =>47 , 'name' => 'Footer secondary (12/12 wide)'   , 'hook' => 'Footer'),

        12 => array('id' =>12 , 'name' => 'Footer tertiary (3/12 wide)'     , 'hook' => 'FooterTertiary'),
        48 => array('id' =>48 , 'name' => 'Footer tertiary (2/12 wide)'     , 'hook' => 'FooterTertiary'),
        57 => array('id' =>57 , 'name' => 'Footer tertiary (2.4/12 wide)'   , 'hook' => 'FooterTertiary'),
        49 => array('id' =>49 , 'name' => 'Footer tertiary (4/12 wide)'     , 'hook' => 'FooterTertiary'),
        50 => array('id' =>50 , 'name' => 'Footer tertiary (5/12 wide)'     , 'hook' => 'FooterTertiary'),
        51 => array('id' =>51 , 'name' => 'Footer tertiary (6/12 wide)'     , 'hook' => 'FooterTertiary'),
        91 => array('id' =>91 , 'name' => 'Footer tertiary (7/12 wide)'     , 'hook' => 'FooterTertiary'),
        92 => array('id' =>92 , 'name' => 'Footer tertiary (8/12 wide)'     , 'hook' => 'FooterTertiary'),
        93 => array('id' =>93 , 'name' => 'Footer tertiary (9/12 wide)'     , 'hook' => 'FooterTertiary'),
        94 => array('id' =>94 , 'name' => 'Footer tertiary (10/12 wide)'    , 'hook' => 'FooterTertiary'),
        52 => array('id' =>52 , 'name' => 'Footer tertiary (12/12 wide)'    , 'hook' => 'FooterTertiary'),

        96 => array('id' =>96 , 'name' => 'Above contact us form'),
        95 => array('id' =>95 , 'name' => 'Below contact us form'),
        4 => array('id' =>4 , 'name' => 'Product secondary column'    , 'hook' => 'ProductSecondaryColumn'),
        5 => array('id' =>5 , 'name' => 'Category no products'),
        6 => array('id' =>6 , 'name' => '404 page not found'),
        9 => array('id' =>9 , 'name' => 'Website maintenance'         , 'hook' => 'Maintenance'),
        11 => array('id' =>11 , 'name' => 'Shopping cart is empty'),
        97 => array('id' =>97 , 'name' => 'Shopping cart footer', 'hook' => 'ShoppingCartFooter'),
        19 => array('id' =>19 , 'name' => 'Blog homepage'             , 'hook' => 'StBlogHome'),
        20 => array('id' =>20 , 'name' => 'Blog homepage top'         , 'hook' => 'StBlogHomeTop'),
        21 => array('id' =>21 , 'name' => 'Blog homepage bottom'      , 'hook' => 'StBlogHomeBottom'),
        22 => array('id' =>22 , 'name' => 'Blog left column'          , 'hook' => 'StBlogLeftColumn', 'column'=>1),
        23 => array('id' =>23 , 'name' => 'Blog right column'         , 'hook' => 'StBlogRightColumn', 'column'=>1),
        24 => array('id' =>24 , 'name' => 'Footer product'            , 'hook' => 'FooterProduct'),
        25 => array('id' =>25 , 'name' => 'Header Category'           , 'hook' => 'CategoryHeader'),
        26 => array('id' =>26 , 'name' => 'Footer Category'           , 'hook' => 'CategoryFooter'),
        27 => array('id' =>27 , 'name' => 'Header left'               , 'hook' => 'HeaderLeft'),

        60 => array('id' =>60 , 'name' => 'Header top'                , 'hook' => 'Top'),
        61 => array('id' =>61 , 'name' => 'Header top bottom'         , 'hook' => 'HeaderBottom'),
        62 => array('id' =>62 , 'name' => 'Header top left'         , 'hook' => 'HeaderLeft'),

        31 => array('id' =>31 , 'name' => 'Product page actions'      , 'hook' => 'ProductButtons'),
        32 => array('id' =>32 , 'name' => 'Right column product(displayRightColumnProduct)' , 'hook' => 'RightColumnProduct'),
        33 => array('id' =>33 , 'name' => 'Left column product(displayLeftColumnProduct)'   , 'hook' => 'LeftColumnProduct'),
        34 => array('id' =>34 , 'name' => 'Most top of the page'      , 'hook' => 'Banner'),
        300 => array('id' =>300 , 'name' => 'Top of Prices drop page'      , 'hook' => 'CmnPricesDropTop'), /* Custom hook on page Prices drop */ /* @author Comm.On */
    );
    
    private $googleFonts;
    
    public static $span_map = array(
        13 => '3',
        38 => '2',
        55 => '2-4',
        39 => '4',
        40 => '5',
        41 => '6',
        71 => '7',
        72 => '8',
        73 => '9',
        74 => '10',
        42 => '12',

        3  => '3',
        43 => '2',
        56 => '2-4',
        44 => '4',
        45 => '5',
        46 => '6',
        81 => '7',
        82 => '8',
        83 => '9',
        84 => '10',
        47 => '12',

        12 => '3',
        48 => '2',
        57 => '2-4',
        49 => '4',
        50 => '5',
        51 => '6',
        91 => '7',
        92 => '8',
        93 => '9',
        94 => '10',
        52 => '12',
    );
    
	function __construct()
	{
		$this->name          = 'steasycontent';
		$this->tab           = 'front_office_features';
		$this->version       = '1.6.4';
		$this->author        = 'SUNNYTOO.COM';
		$this->need_instance = 0;
        $this->bootstrap     = true;
        
		parent::__construct();
        
        $this->googleFonts = include_once(dirname(__FILE__).'/googlefonts.php');

		$this->displayName = $this->l('Custom Content Block');
		$this->description = $this->l('Create content blocks and place them everywhere in your shop.');
	}
    
	function install()
	{
		$res = parent::install() &&
			$this->installDB() &&
            $this->registerHook('displayHeader') &&
			$this->registerHook('displayAnywhere') &&
            $this->registerHook('actionShopDataDuplication');
			
		if ($res)
			foreach(Shop::getShops(false) as $shop)
				$res &= $this->sampleData($shop['id_shop']);
        $this->prepareHooks();
        $this->clearEasyContentCache();
        return $res;
	}

	public function installDB()
	{
		$return = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'st_easy_content` (
				`id_st_easy_content` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `location` int(10) unsigned NOT NULL DEFAULT 0, 
                `hide_on_mobile` tinyint(1) unsigned NOT NULL DEFAULT 0, 
                `active` tinyint(1) unsigned NOT NULL DEFAULT 1, 
                `position` int(10) unsigned NOT NULL DEFAULT 0,
                `id_category` int(10) unsigned NOT NULL DEFAULT 0,
                `id_manufacturer` int(10) unsigned NOT NULL DEFAULT 0,
                `text_color` varchar(7) DEFAULT NULL,
                `link_color` varchar(7) DEFAULT NULL,
                `link_hover` varchar(7) DEFAULT NULL,
                `text_bg` varchar(7) DEFAULT NULL,
                `text_align` tinyint(1) unsigned NOT NULL DEFAULT 1,
                `margin_top` int(10) unsigned NOT NULL DEFAULT 0,
                `margin_bottom` int(10) unsigned NOT NULL DEFAULT 0,
                `width` tinyint(2) unsigned NOT NULL DEFAULT 0,
                `btn_color` varchar(7) DEFAULT NULL,
                `btn_bg` varchar(7) DEFAULT NULL,
                `btn_hover_color` varchar(7) DEFAULT NULL,
                `btn_hover_bg` varchar(7) DEFAULT NULL,
                `top_spacing` varchar(10) DEFAULT NULL,
                `bottom_spacing` varchar(10) DEFAULT NULL,
				PRIMARY KEY (`id_st_easy_content`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
		
		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'st_easy_content_lang` (
				`id_st_easy_content` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`id_lang` int(10) unsigned NOT NULL ,
                `title` varchar(255) DEFAULT NULL,
    			`url` varchar(255) DEFAULT NULL,
				`text` text NOT NULL,
				PRIMARY KEY (`id_st_easy_content`, `id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
		
		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'st_easy_content_shop` (
				`id_st_easy_content` int(10) UNSIGNED NOT NULL,
                `id_shop` int(11) NOT NULL,      
                PRIMARY KEY (`id_st_easy_content`,`id_shop`),    
                KEY `id_shop` (`id_shop`)   
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
            
        $return &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'st_easy_content_font` (
                `id_st_easy_content` int(10) unsigned NOT NULL,
                `font_name` varchar(255) NOT NULL
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;');
		
		return $return;
	}
    public function sampleData($id_shop)
    {
        $return = true;
        $path = _MODULE_DIR_.$this->name;
		$samples = array(
            array('text' => '<p class="color_444 fs_lg">Premium Prestashop Theme</p><h4 class="color_444 font_weight_blod" style="font-family:Vollkorn;">WELCOME TO PANDA</h4><div class="icon_line_wrap"><div class="icon_line_gray">I I I I I</div></div><div class="fs_md color_444">Panda theme is a modern, clean and professional Prestashop theme, it comes with a lot of useful features. Panda theme is fully responsive, it looks stunning on all types of screens and devices.</div>', 'title' => '', 'url' => '', 'location' => 36, 'active'=>1, 'hide_on_mobile'=>0, 'text_align'=>2, 'width'=>80),
			array('text' => '<div class="mar_b2 mar_t1 color_444"><div class="easycontent_s4 mar_b6 clearfix"><em class="icon-mobile icon-2x easy_icon"><span class="unvisible">&nbsp;</span></em><p style="font-family:Vollkorn;" class="color_444 fs_lg mar_t4">FULLY RESPONSIVE</p></div><div class="color_999">Panda theme is a premium pretashop theme with flexible theme options, it looks stunning on all types of screens and devices.</div></div><div class="mar_b2 color_444"><div class="easycontent_s4 mar_b6 clearfix"><em class="icon-edit icon-2x easy_icon"><span class="unvisible">&nbsp;</span></em><p style="font-family:Vollkorn;" class="color_444 fs_lg mar_t4">CUSTOMIZABLE</p></div><div class="color_999">Panda theme is a premium pretashop theme with flexible theme options, it looks stunning on all types of screens and devices.</div></div><div class="mar_b2 color_444"><div class="easycontent_s4 mar_b6 clearfix"><em class="icon-magic icon-2x easy_icon"><span class="unvisible">&nbsp;</span></em><p style="font-family:Vollkorn;" class="color_444 fs_lg mar_t4">UNLIMITED COLORS</p></div><div class="color_999">Panda theme is a premium pretashop theme with flexible theme options, it looks stunning on all types of screens and devices.</div></div>', 'title' => '', 'url' => '', 'location' => 14, 'active'=>1, 'hide_on_mobile'=>0, 'text_align'=>1, 'width'=>0),
            array('text' => '<h5 class="color_444" style="font-family:Vollkorn;">PANDA THEME</h5><p>Panda theme is a modern, clean and professional Prestashop theme, it comes with a lot of useful features.</p><p>This is a custom block edited from admin panel.You can insert any content here.</p><p>Any orders placed through this store will not be honored or fulfilled.</p><p><a class="go" title="Buy this theme" href="#" target="_blank">BUY THIS THEME</a></p>', 'title' => '', 'url' => '', 'location' => 3, 'active'=>1, 'hide_on_mobile'=>0, 'text_align'=>1, 'width'=>0),
            array('text' => '<div class="clearfix mar_b6 easycontent_s3"><em class="easy_icon icon-location-2 icon-large"><span class="unvisible">&nbsp;</span></em> PO Box 16122 Collins Street West Victoria 8007 Australia</div><div class="clearfix mar_b6 easycontent_s3"><em class="easy_icon icon-at icon-large"><span class="unvisible">&nbsp;</span></em> support@support.com</div><div class="clearfix mar_b6 easycontent_s3"><em class="easy_icon icon-phone icon-large"><span class="unvisible">&nbsp;</span></em> +61 3 1234 4567</div>', 'title' => 'Contact us', 'url' => '', 'location' => 57, 'active'=>1, 'hide_on_mobile'=>0, 'text_align'=>1, 'width'=>0),
            array('text' => '<div class="easycontent_s9 clearfix mar_b2"><em class="icon-credit-card easy_icon"><span class="unvisible">&nbsp;</span></em><div class="color_444 fs_md" style="font-family:Vollkorn;">PAYMENT</div><div>We accept Visa, MasterCard and American Express.</div></div><div class="easycontent_s9 clearfix mar_b2"><em class="icon-truck easy_icon"><span class="unvisible">&nbsp;</span></em><div class="color_444 fs_md" style="font-family:Vollkorn;">FREE SHIPPING</div><div>All orders over $100 free super fast delivery.</div></div><div class="easycontent_s9 clearfix"><em class="icon-trophy easy_icon"><span class="unvisible">&nbsp;</span></em><div class="color_444 fs_md" style="font-family:Vollkorn;">BEST PRIEC GUARANTEE</div><div>The best choice for high quality at good prices.</div></div>', 'title' => '', 'url' => '', 'location' => 4, 'active'=>1, 'hide_on_mobile'=>0, 'text_align'=>1, 'width'=>0),
		);
		
		foreach($samples as $k=>$sample)
		{
			$module = new StEasyContentClass();
			foreach (Language::getLanguages(false) as $lang)
            {
				$module->text[$lang['id_lang']] = $sample['text'];
				$module->title[$lang['id_lang']] = $sample['title'];
				$module->url[$lang['id_lang']] = $sample['url'];
            }
            $module->location       = $sample['location'];
            $module->active         = $sample['active'];
            $module->hide_on_mobile = $sample['hide_on_mobile'];
            $module->text_align     = $sample['text_align'];
            $module->width          = $sample['width'];
            $module->position       = $k;
			$return &= $module->add();
            if($return && $module->id)
            {
    			Db::getInstance()->insert('st_easy_content_shop', array(
    				'id_st_easy_content' => (int)$module->id,
    				'id_shop' => (int)$id_shop,
    			));
            }
		}
		return $return;
    }

	public function uninstall()
	{
	    $this->clearEasyContentCache();
		// Delete configuration
		return $this->uninstallDB() && parent::uninstall();
	}

	public function uninstallDB()
	{
		return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'st_easy_content`,`'._DB_PREFIX_.'st_easy_content_lang`,`'._DB_PREFIX_.'st_easy_content_shop`,`'._DB_PREFIX_.'st_easy_content_font`');
	}
    
	public function getContent()
	{
		$this->context->controller->addJS($this->_path. 'views/js/admin.js');
        $this->context->controller->addCss($this->_path.'views/css/admin.css');
        $this->_html .= '<script type="text/javascript">var googleFontsString=\''.Tools::jsonEncode($this->googleFonts).'\';</script>';
		$id_st_easy_content = (int)Tools::getValue('id_st_easy_content');
		if (isset($_POST['savesteasycontent']) || isset($_POST['savesteasycontentAndStay']))
		{
			if ($id_st_easy_content)
				$easy_content = new StEasyContentClass((int)$id_st_easy_content);
			else
				$easy_content = new StEasyContentClass();
                
			$easy_content->copyFromPost();
                            
            $easy_content->id_category = 0;
            $easy_content->id_manufacturer = 0;
            $filter = '';
            $location = Tools::getValue('location');
            if ($location == 4)
                $filter = Tools::getValue('filter');
            elseif($location == 25 || $location == 26)
                $filter = Tools::getValue('filter2');
            if ($filter)
            {
                list($in, $id) = explode('_', $filter);
                if ($in > 0 && $id > 0)
                    if ($in == 1)
                        $easy_content->id_category = $id;
                    elseif($in == 2)
                        $easy_content->id_manufacturer = $id;
            }
            
            $error = array();
            $defaultLanguage = new Language((int)(Configuration::get('PS_LANG_DEFAULT')));
            if(!$easy_content->text[$defaultLanguage->id])
                $error[] = $this->displayError($this->l('The field "Content" is required at least in '.$defaultLanguage->name));

			if (!count($error) && $easy_content->validateFields(false) && $easy_content->validateFieldsLang(false))
            {
                if($easy_content->save())
                {
                    Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'st_easy_content_shop WHERE id_st_easy_content='.(int)$easy_content->id);
                    if (!Shop::isFeatureActive())
            		{
            			Db::getInstance()->insert('st_easy_content_shop', array(
            				'id_st_easy_content' => (int)$easy_content->id,
            				'id_shop' => (int)Context::getContext()->shop->id,
            			));
            		}
            		else
            		{
            			$assos_shop = Tools::getValue('checkBoxShopAsso_st_easy_content');
            			if (empty($assos_shop))
            				$assos_shop[(int)Context::getContext()->shop->id] = Context::getContext()->shop->id;
            			foreach ($assos_shop as $id_shop => $row)
            				Db::getInstance()->insert('st_easy_content_shop', array(
            					'id_st_easy_content' => (int)$easy_content->id,
            					'id_shop' => (int)$id_shop,
            				));
            		}
                    
                    $jon = trim(Tools::getValue('google_font_name'),'¤');
                    StEasyContentFontClass::deleteByContent($easy_content->id);
                    $jon_arr = array_unique(explode('¤', $jon));
                    if (count($jon_arr))
                        StEasyContentFontClass::changeContentFont($easy_content->id, $jon_arr);
                    
                    $this->prepareHooks();
                    $this->clearEasyContentCache();
                    if(isset($_POST['savesteasycontentAndStay']))
                        Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&id_st_easy_content='.$easy_content->id.'&conf='.($id_st_easy_content?4:3).'&update'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));  
                    else
                        $this->_html .= $this->displayConfirmation($this->l('Easy Content').' '.($id_st_easy_content ? $this->l('updated') : $this->l('added')));
                }
                else
                    $this->_html .= $this->displayError($this->l('An error occurred during easy Content').' '.($id_st_easy_content ? $this->l('updating') : $this->l('creation')));
            }
			else
                $this->_html .= count($error) ? implode('',$error) : $this->displayError($this->l('Invalid value for field(s).'));
		}
	    if ((Tools::isSubmit('statussteasycontent')))
        {
            $easy_content = new StEasyContentClass((int)$id_st_easy_content);
            if($easy_content->id && $easy_content->toggleStatus())
            {
                $this->clearEasyContentCache();
                //$this->_html .= $this->displayConfirmation($this->l('The status has been updated successfully.')); 
			    Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
            } 
            else
                $this->_html .= $this->displayError($this->l('An error occurred while updating the status.'));
        }
		
		if (Tools::isSubmit('updatesteasycontent') || Tools::isSubmit('addsteasycontent'))
		{
			$helper = $this->initForm();
			return $this->_html.$helper->generateForm($this->fields_form);
		}
		else if (Tools::isSubmit('deletesteasycontent'))
		{
			$easy_content = new StEasyContentClass((int)$id_st_easy_content);
			if ($easy_content->id)
                $easy_content->delete();
            $this->prepareHooks();
            $this->clearEasyContentCache();
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else
		{
			$helper = $this->initList();
			return $this->_html.$helper->generateList(StEasyContentClass::getListContent((int)$this->context->language->id), $this->fields_list);
		}
	}

	protected function initForm()
	{
        $id_st_easy_content = (int)Tools::getValue('id_st_easy_content');
		$easy_content = new StEasyContentClass($id_st_easy_content);
        
	    $google_font_name_html = $google_font_name =  $google_font_link = '';
        if(Validate::isLoadedObject($easy_content)){
            $jon_arr = StEasyContentFontClass::getByContent($easy_content->id);
            if(is_array($jon_arr) && count($jon_arr))
                foreach ($jon_arr as $key => $value) {
                    $google_font_name_html .= '<li id="#'.str_replace(' ', '_', strtolower($value['font_name'])).'_li" class="form-control-static"><button type="button" class="delGoogleFont btn btn-default" name="'.$value['font_name'].'"><i class="icon-remove text-danger"></i></button>&nbsp;<span style="'.$this->fontstyles($value['font_name']).'">style="'.$this->fontstyles($value['font_name']).'"</span></li>';

                    $google_font_name .= $value['font_name'].'¤';

                    $google_font_link .= '<link id="'.str_replace(' ', '_', strtolower($value['font_name'])).'_link" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $value['font_name']).'" />';
                }
        }
        
		$this->fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->displayName,
                'icon' => 'icon-cogs'                
			),
			'input' => array(
				array(
					'type' => 'select',
					'label' => $this->l('Show on:'),
					'name' => 'location',
					'id' => 'easy_content_location',
                    'required' => true,
					'onchange' => 'checkEasyContetHookInto(this.value);',
					'options' => array(
						'query' => self::$location,
        				'id' => 'id',
        				'name' => 'name',
						'default' => array(
							'value' => 0,
							'label' => $this->l('--')
						),
					),
                    'desc' => '<div class="alert alert-info"><a href="javascript:;" onclick="$(\'#des_page_layout\').toggle();return false;">'.$this->l('Click here to see hook position').'</a>'.
                        '<div id="des_page_layout" style="display:none;"><img src="'._MODULE_DIR_.'stthemeeditor/img/hook_into_hint.jpg" /></div></div>',
				),
                array(
					'type' => 'select',
        			'label' => $this->l('Specify a category or a manufacturer:'),
        			'name' => 'filter',
                    'options' => array(
                        'optiongroup' => array (
							'query' => $this->createLinks(),
							'label' => 'name'
						),
						'options' => array (
							'query' => 'query',
							'id' => 'id',
							'name' => 'name'
						),
						'default' => array(
							'value' => '',
							'label' => $this->l('All')
						),
        			),
                    'desc' => $this->l('Only for Prodcut secondary column.'),
				),
                array(
					'type' => 'select',
					'label' => $this->l('Specify a category:'),
					'name' => 'filter2',
					'options' => array(
						'query' => $this->createLinks(true),
        				'id' => 'id',
        				'name' => 'name',
						'default' => array(
							'value' => '',
							'label' => $this->l('All')
						)
					),
                    'desc' => $this->l('Only for Header Category, Footer Category'),
				),
                array(
					'type' => 'text',
					'label' => $this->l('Title:'),
					'name' => 'title',
					'lang' => true,
					'size' => 64,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link:'),
					'name' => 'url',
					'lang' => true,
					'size' => 64,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content:'),
					'lang' => true,
					'name' => 'text',
					'cols' => 40,
					'rows' => 10,
					'autoload_rte' => true,
                    'required' => true,
                    'desc' => '<p>Format your entry with some basic HTML. Click <span style="color:#ff8230;">Flash</span> button to use predefined templates.</p>
                    <strong>Headings</strong>
                    <p>Headings are defined with the &lt;h1&gt; to &lt;h6&gt; tags.</p>
                    <ul>
                        <li>&lt;h2&gt;Big Heading 1&lt;/h2&gt;</li>
                        <li>&lt;h5&gt;Samll Heading 1&lt;/h5&gt;</li>
                    </ul>
                    <strong>Buttons</strong>
                    <p>You can click the <span style="color:#ff8230;">Flash</span> button in the toolbar of text editor to add buttons.</p>
                    <ul>
                        <li>&lt;a href="#" class="btn btn-small"&gt;Small Button&lt;/a&gt;</li>
                        <li>&lt;a href="#" class="btn btn-default"&gt;Button&lt;/a&gt;</li>
                        <li>&lt;a href="#" class="btn btn-medium"&gt;Medium Button&lt;/a&gt;</li>
                        <li>&lt;a href="#" class="btn btn-large"&gt;Large Button&lt;/a&gt;</li>
                    </ul>
                    <strong>Usefull class names</strong>
                    <ul>
                    <li>closer: &lt;h2 class="closer"&gt;Sample&lt;/h2&gt;</li>
                    <li>spacer: &lt;div class="spacer"&gt;Sample&lt;/div&gt;</li>
                    <li>width_50 to width_90: &lt;div class="width_70"&gt;Sample&lt;/div&gt;</li>
                    <li>center_width_50 to center_width_90: &lt;div class="center_width_80"&gt;Sample&lt;/div&gt;</li>
                    <li>fs_sm fs_md fs_lg fs_xl fs_xxl fs_xxxl fs_xxxxl: &lt;p class="fs_lg"&gt;Sample&lt;/p&gt;</li>
                    <li>icon_line: &lt;div class="icon_line_wrap"&gt;&lt;div class="icon_line"&gt;Sample&lt;/div&gt;&lt;/div&gt;</li>
                    <li>line, line_white, line_black: &lt;p class="line_white"&gt;Sample&lt;/p&gt;</li>
                    <li>&lt;p class="uppercase"&gt;SAMPLE&lt;/p&gt;</li>
                    <li>color_000,color_333,color_444,color_666,color_999,color_ccc,color_fff: <span style="color:#999">&lt;p class="color_999"&gt;Sample&lt;/p&gt;</span></li>
                    </ul>
                    <div class="alert alert-info"><a href="javascript:;" onclick="$(\'#how_to_use_gf\').toggle();return false;">'.$this->l('How to use google fonts? Click here.').'</a>'.
                        '<div id="how_to_use_gf" style="display:none;"><img src="'.$this->_path.'views/img/how_to_use_gf.jpg" /></div></div>',
				),
                array(
                    'type' => 'fontello',
                    'label' => $this->l('Click here to see all available icons:'),
                    'name' => 'icon_class',
                    'values' => $this->get_fontello(),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Google fonts:'),
                    'name' => 'google_font_select',
                    'onchange' => 'handle_font_change(this);',
                    'class' => 'fontOptions',
                    'options' => array(
                        'query' => $this->fontOptions(),
                        'id' => 'id',
                        'name' => 'name',
                        'default' => array(
                            'value' => 0,
                            'label' => $this->l('Use default'),
                        ),
                    ),
                ),
                'font_text'=>array(
                    'type' => 'select',
                    'label' => $this->l('Font weight:'),
                    'onchange' => 'handle_font_style(this);',
                    'class' => 'fontOptions',
                    'name' => 'google_font_weight',
                    'options' => array(
                        'query' => array(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'validation' => 'isAnything',
                    'desc' => '<p>'.$this->l('Once a font has been added, you can use it everywhere without adding it again.').'</p><a id="add_google_font" class="btn btn-default btn-block fixed-width-md" href="javascript:;">Add</a><br/><p id="google_font_example" class="fontshow">Example Title</p><ul id="curr_google_font_name">'.$google_font_name_html.'</ul>'.$google_font_link,
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'google_font_name',
                    'default_value' => '',
                ),
                array(
					'type' => 'radio',
					'label' => $this->l('Hide on mobile:'),
					'name' => 'hide_on_mobile',
                    'default_value' => 0,
					'values' => array(
						array(
							'id' => 'hide_on_mobile_0',
							'value' => 0,
							'label' => $this->l('No')),
						array(
							'id' => 'hide_on_mobile_1',
							'value' => 1,
							'label' => $this->l('Hide on mobile (screen width < 768px)')),
                        array(
							'id' => 'hide_on_mobile_2',
							'value' => 2,
							'label' => $this->l('Hide on PC (screen width > 768px)')),
					),
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Status:'),
					'name' => 'active',
					'is_bool' => true,
                    'default_value' => 1,
					'values' => array(
						array(
							'id' => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id' => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					),
				),
                array(
					'type' => 'text',
					'label' => $this->l('Position:'),
					'name' => 'position',
                    'default_value' => 0,
                    'class' => 'fixed-width-sm'                    
				),
			),
            'buttons' => array(
                array(
                    'type' => 'submit',
                    'title'=> $this->l(' Save '),
                    'icon' => 'process-icon-save',
                    'class'=> 'pull-right'
                ),
            ),
			'submit' => array(
				'title' => $this->l('Save and stay'),
                'stay' => true
			),
		);

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Advanced settings'),
                'icon' => 'icon-cogs'                
            ),
            'input' => array(
                array(
                    'type' => 'color',
                    'label' => $this->l('Text color:'),
                    'name' => 'text_color',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Link color:'),
                    'name' => 'link_color',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Link hover color:'),
                    'name' => 'link_hover',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Background color:'),
                    'name' => 'text_bg',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Button color:'),
                    'name' => 'btn_color',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Button background color:'),
                    'name' => 'btn_bg',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Button hover color:'),
                    'name' => 'btn_hover_color',
                    'size' => 33,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Button hover background color:'),
                    'name' => 'btn_hover_bg',
                    'size' => 33,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Top padding:'),
                    'name' => 'margin_top',
                    'default_value' => 0,
                    'class' => 'fixed-width-sm',  
                    'suffix' => 'px'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Bottom padding:'),
                    'name' => 'margin_bottom',
                    'default_value' => 0,
                    'class' => 'fixed-width-sm',  
                    'suffix' => 'px'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Top spacing:'),
                    'name' => 'top_spacing',
                    'default_value' => '',
                    'prefix' => 'px',
                    'class' => 'fixed-width-lg',
                    'desc' => $this->l('Leave it empty to use the default value.'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Bottom spacing:'),
                    'name' => 'bottom_spacing',
                    'default_value' => '',
                    'prefix' => 'px',
                    'class' => 'fixed-width-lg',
                    'desc' => $this->l('Leave it empty to use the default value.'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Width:'),
                    'name' => 'width',
                    'options' => array(
                        'query' => array(
                                array('id' => 10, 'name'=>'10%'),
                                array('id' => 20, 'name'=>'20%'),
                                array('id' => 30, 'name'=>'30%'),
                                array('id' => 50, 'name'=>'50%'),
                                array('id' => 60, 'name'=>'60%'),
                                array('id' => 70, 'name'=>'70%'),
                                array('id' => 80, 'name'=>'80%'),
                                array('id' => 90, 'name'=>'90%'),
                            ),
                        'id' => 'id',
                        'name' => 'name',
                        'default' => array(
                            'value' => '0',
                            'label' => $this->l('100%')
                        )
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Alignment:'),
                    'name' => 'text_align',
                    'default_value' => 1,
                    'values' => array(
                        array(
                            'id' => 'text_align_left',
                            'value' => 1,
                            'label' => $this->l('Left')),
                        array(
                            'id' => 'text_align_center',
                            'value' => 2,
                            'label' => $this->l('Center')),
                        array(
                            'id' => 'text_align_right',
                            'value' => 3,
                            'label' => $this->l('Right')),
                    ),
                ),
            ),
            'buttons' => array(
                array(
                    'type' => 'submit',
                    'title'=> $this->l(' Save '),
                    'icon' => 'process-icon-save',
                    'class'=> 'pull-right'
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true
            ),
        );


		if (Shop::isFeatureActive())
		{
			$this->fields_form[0]['form']['input'][] = array(
				'type' => 'shop',
				'label' => $this->l('Shop association:'),
				'name' => 'checkBoxShopAsso',
			);
		}
        $this->fields_form[0]['form']['input'][] = $this->fields_form[1]['form']['input'][] = array(
			'type' => 'html',
            'id' => 'a_cancel',
			'label' => '',
			'name' => '<a class="btn btn-default btn-block fixed-width-md" href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'"><i class="icon-arrow-left"></i> Back to list</a>',                  
		);
        
        
        if($easy_content->id)
        {
            $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_st_easy_content');
        }

        $helper = new HelperForm();
		$helper->show_toolbar = false;
        $helper->id = (int)$id_st_easy_content;
        $helper->module = $this;
		$helper->table =  'st_easy_content';        
		$helper->identifier = 'id_st_easy_content';
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;

		$helper->submit_action = 'save'.$this->name;
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getFieldsValueSt($easy_content),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
        
        if ($easy_content->id)
            if ($easy_content->location == 4)
            $helper->tpl_vars['fields_value']['filter'] = $easy_content->id_category ? '1_'.$easy_content->id_category : '2_'.$easy_content->id_manufacturer;
            elseif($easy_content->location == 25 || $easy_content->location == 26)
                $helper->tpl_vars['fields_value']['filter2'] = '1_'.$easy_content->id_category;
        else
            $helper->tpl_vars['fields_value']['filter'] = '';
            
        $helper->tpl_vars['fields_value']['google_font_name'] = $google_font_name;
        
		return $helper;
	}
    
    public function createLinks($category_only=false)
    {
        $id_lang = $this->context->language->id;
        $category_arr = array();
		$this->getCategoryOption($category_arr, Category::getRootCategory()->id, (int)$id_lang, (int)Shop::getContextShopID(),true);
        
        if ($category_only)
            return $category_arr;
            
        $manufacturer_arr = array();
		$manufacturers = Manufacturer::getManufacturers(false, $id_lang);
		foreach ($manufacturers as $manufacturer)
            $manufacturer_arr[] = array('id'=>'2_'.$manufacturer['id_manufacturer'],'name'=>$manufacturer['name']);
        
        $links = array(
            array('name'=>$this->l('Category'),'query'=>$category_arr),
            array('name'=>$this->l('Manufacturer'),'query'=>$manufacturer_arr)
        );
        return $links;
    }
    
    private function getCategoryOption(&$category_arr, $id_category = 1, $id_lang = false, $id_shop = false, $recursive = true)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang, (int)$id_shop);

		if (is_null($category->id))
			return;

		if ($recursive)
		{
			$children = Category::getChildren((int)$id_category, (int)$id_lang, true, (int)$id_shop);
			$spacer = str_repeat('&nbsp;', $this->spacer_size * (int)$category->level_depth);
		}

		$shop = (object) Shop::getShop((int)$category->getShopID());
		$category_arr[] = array('id'=>'1_'.(int)$category->id,'name'=>(isset($spacer) ? $spacer : '').$category->name.' ('.$shop->name.')');

		if (isset($children) && is_array($children) && count($children))
			foreach ($children as $child)
			{
				$this->getCategoryOption($category_arr, (int)$child['id_category'], (int)$id_lang, (int)$child['id_shop'],$recursive);
			}
	}

    
    public static function displayLocation($value, $tr)
    {
        if(isset(self::$location[$value]))
           $result =  self::$location[$value]['name'];
        else
        {
            $module = new StEasyContent();
            $result = $module->l('--');
        }
        return $result;
    }
    public static function displayContent($value, $tr)
	{	    
        return Tools::truncateString(strip_tags(stripslashes($value)), 80);
	}
	
	protected function initList()
	{
		$this->fields_list = array(
			'id_st_easy_content' => array(
				'title' => $this->l('Id'),
				'width' => 120,
				'type' => 'text',
                'search' => false,
                'orderby' => false
			),
            'title' => array(
                'title' => $this->l('Title'),
                'width' => 140,
                'type' => 'text',
                'search' => false,
                'orderby' => false
            ),
            'text' => array(
                'title' => $this->l('Content'),
                'width' => 200,
                'type' => 'text',
                'callback' => 'displayContent',
                'callback_object' => 'StEasyContent',
                'search' => false,
                'orderby' => false
            ),
			'location' => array(
				'title' => $this->l('Show on'),
				'width' => 140,
				'type' => 'text',
				'callback' => 'displayLocation',
				'callback_object' => 'StEasyContent',
                'search' => false,
                'orderby' => false
			),
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 40,
                'position' => 'position',
                'align' => 'center',
                'search' => false,
                'orderby' => false
            ),
            'active' => array(
				'title' => $this->l('Status'),
				'align' => 'center',
				'active' => 'status',
				'type' => 'bool',
				'width' => 25,
                'search' => false,
                'orderby' => false
            ),
		);

		if (Shop::isFeatureActive())
			$this->fields_list['id_shop'] = array(
                'title' => $this->l('ID Shop'), 
                'align' => 'center', 
                'width' => 25, 
                'type' => 'int',
                'search' => false,
                'orderby' => false
            );

		$helper = new HelperList();
		$helper->shopLinkType = '';
		$helper->simple_header = false;
		$helper->identifier = 'id_st_easy_content';
		$helper->actions = array('edit', 'delete');
		$helper->show_toolbar = true;
		$helper->toolbar_btn['new'] =  array(
			'href' => AdminController::$currentIndex.'&configure='.$this->name.'&add'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
			'desc' => $this->l('Add new')
		);

		$helper->title = $this->displayName;
		$helper->table = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		return $helper;
	}
    
    private function _prepareHook($location)
    {
        $easy_content = StEasyContentClass::getListContent($this->context->language->id,$location,1);
        if(!$easy_content)
            return false;

        foreach ($easy_content as &$value) {
            $value['span'] = array_key_exists($value['location'], self::$span_map) ? self::$span_map[$value['location']] : 0;
            $value['stretched'] = isset(self::$location[$value['location']]['stretched']);
            $value['is_full_width'] = isset(self::$location[$value['location']]['full_width']);
        }

		$this->smarty->assign(
            array(
                'easy_content' => $easy_content,
                'is_column' => is_array($location) ? false : isset(self::$location[$location]['column']),
            )
        );
        return true;
    }

    public function hookDisplayHeader($params)
    {
        if (!$this->isCached('header.tpl', $this->getCacheId()))
        {
            $custom_css_arr = StEasyContentClass::getCustomCss();
            if (is_array($custom_css_arr) && count($custom_css_arr)) {
                $custom_css = '';
                foreach ($custom_css_arr as $v) {
                    $classname = (isset(self::$location[$v['location']]['full_width']) ? '#easycontent_container_'.$v['id_st_easy_content'].' ' : '#easycontent_'.$v['id_st_easy_content'].' ');
                    $v['text_bg'] && $custom_css .= $classname.'{background-color:'.$v['text_bg'].';}';

                    $v['text_color'] && $custom_css .= $classname.'.style_content,
                    '.$classname.'.style_content a{color:'.$v['text_color'].';}
                    '.$classname.'.icon_line:after, '.$classname.'.icon_line:before{background-color:'.$v['text_color'].';}
                    '.$classname.'.line{border-color:'.$v['text_color'].';}';

                    $v['link_color'] && $custom_css .= $classname.'.style_content a{color:'.$v['link_color'].';}';
                    
                    $v['link_hover'] && $custom_css .= $classname.'.style_content a:hover{color:'.$v['link_hover'].';}';
                    $v['margin_top'] && $custom_css .= $classname.'{padding-top:'.$v['margin_top'].'px;}';
                    $v['margin_bottom'] && $custom_css .= $classname.'{padding-bottom:'.$v['margin_bottom'].'px;}';

                    if(isset($v['top_spacing']) && ($v['top_spacing'] || $v['top_spacing']==='0'))
                        $custom_css .= $classname.'{margin-top:'.(int)$v['top_spacing'].'px;}';
                    if(isset($v['bottom_spacing']) && ($v['bottom_spacing'] || $v['bottom_spacing']==='0'))
                        $custom_css .= $classname.'{margin-bottom:'.(int)$v['bottom_spacing'].'px;}';

                    if($v['btn_color'])
                        $custom_css .= $classname.'.style_content .btn{color:'.$v['btn_color'].';}';
                    if($v['btn_color'] && !$v['btn_bg'])
                        $custom_css .= $classname.'.style_content .btn{border-color:'.$v['btn_color'].';}';
                    if($v['btn_bg'])
                        $custom_css .= $classname.'.style_content .btn{background-color:'.$v['btn_bg'].';border-color:'.$v['btn_bg'].';}';
                    if($v['btn_hover_color'])
                        $custom_css .= $classname.'.style_content .btn:hover{color:'.$v['btn_hover_color'].';}';
                    if ($v['btn_hover_bg']) {
                        $custom_css .= $classname.'.style_content .btn:hover{border-color:'.$v['btn_hover_bg'].';}';
                        $btn_fill_animation = (int)Configuration::get('STSN_BTN_FILL_ANIMATION');
                        switch ($btn_fill_animation) {
                            case 1:
                                $custom_css .= $classname.'.style_content .btn:hover{-webkit-box-shadow: inset 0 100px 0 0 '.$v['btn_hover_bg'].'; box-shadow: inset 0 100px 0 0 '.$v['btn_hover_bg'].';background-color:transparent;}';
                                break;
                            case 2:
                                $custom_css .= $classname.'.style_content .btn:hover{-webkit-box-shadow: inset 0 -100px 0 0 '.$v['btn_hover_bg'].'; box-shadow: inset 0 -100px 0 0 '.$v['btn_hover_bg'].';background-color:transparent;}';
                                break;
                            case 3:
                                $custom_css .= $classname.'.style_content .btn:hover{-webkit-box-shadow: inset 300px 0 0 0 '.$v['btn_hover_bg'].'; box-shadow: inset 300px 0 0 0 '.$v['btn_hover_bg'].';background-color:transparent;}';
                                break;
                            case 4:
                                $custom_css .= $classname.'.style_content .btn:hover{-webkit-box-shadow: inset -300px 0 0 0 '.$v['btn_hover_bg'].'; box-shadow: inset -300px 0 0 0 '.$v['btn_hover_bg'].';background-color:transparent;}';
                                break;
                            default:
                                $custom_css .= $classname.'.style_content .btn:hover{-webkit-box-shadow: none; box-shadow: none;background-color: '.$v['btn_hover_bg'].';}';
                                break;
                        }
                    }
                }
                if($custom_css)
                    $this->smarty->assign('custom_css', preg_replace('/\s\s+/', ' ', $custom_css));
            }
        }
        
        $data = StEasyContentFontClass::getAll(1);
        if(is_array($data) && count($data))
        {
            $content_font = array();
            foreach ($data as $value) {
                $content_font[] = $value['font_name'];
            }

            $content_font = array_unique($content_font); 
            $font_latin_support = Configuration::get('STSN_FONT_LATIN_SUPPORT');
            $font_cyrillic_support = Configuration::get('STSN_FONT_CYRILLIC_SUPPORT');
            $font_vietnamese = Configuration::get('STSN_FONT_VIETNAMESE');
            $font_greek_support = Configuration::get('STSN_FONT_GREEK_SUPPORT');
            $font_support = ($font_latin_support || $font_cyrillic_support || $font_vietnamese || $font_greek_support) ? '&subset=' : '';
            $font_latin_support && $font_support .= 'latin,latin-ext,';
            $font_cyrillic_support && $font_support .= 'cyrillic,cyrillic-ext,';
            $font_vietnamese && $font_support .= 'vietnamese,';
            $font_greek_support && $font_support .= 'greek,greek-ext,';
            if(is_array($content_font) && count($content_font))
                foreach($content_font as $x)
                {
                    if(!$x)
                        continue;
                    $this->context->controller->addCSS($this->context->link->protocol_content."fonts.googleapis.com/css?family=".str_replace(' ', '+', $x).($font_support ? rtrim($font_support,',') : ''));
                }
        }
        
        return $this->display(__FILE__, 'header.tpl', $this->getCacheId());
    }
	/**
	* Returns module content for left column
	*
	* @param array $params Parameters
	* @return string Content
	*
	*/
	public function hookDisplayLeftColumn($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(2)))
    		if(!$this->_prepareHook(2))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(2));
	}
    
	public function hookDisplayRightColumn($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(10)))
    		if(!$this->_prepareHook(10))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(10));
	}

	public function hookDisplayFooterPrimary($params)
	{
		if (!$this->isCached('steasycontent-footer.tpl', $this->stGetCacheId(13)))
    		if(!$this->_prepareHook(array(13, 38, 39, 40, 41,71,72,73,74, 42,55)))
                return false;
		return $this->display(__FILE__, 'steasycontent-footer.tpl', $this->stGetCacheId(13));
	}

	public function hookDisplayFooter($params)
	{
		if (!$this->isCached('steasycontent-footer.tpl', $this->stGetCacheId(3)))
    		if(!$this->_prepareHook(array(3, 43, 44, 45, 46,81,82,83,84, 47,56)))
                return false;
		return $this->display(__FILE__, 'steasycontent-footer.tpl', $this->stGetCacheId(3));
	}

	public function hookDisplayFooterTertiary($params)
	{
		if (!$this->isCached('steasycontent-footer.tpl', $this->stGetCacheId(12)))
    		if(!$this->_prepareHook(array(12, 48, 49, 50, 51,91,92,93,94, 52,57)))
                return false;
		return $this->display(__FILE__, 'steasycontent-footer.tpl', $this->stGetCacheId(12));
	}
    
	public function hookDisplayHome($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(1)))
    		if(!$this->_prepareHook(1))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(1));
	}
    
	public function hookDisplayHomeTop($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(16)))
    		if(!$this->_prepareHook(16))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(16));
	}
    
	public function hookDisplayHomeBottom($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(17)))
    		if(!$this->_prepareHook(17))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(17));
	}

    public function hookDisplayBottomColumn($params)
    {
        if(Dispatcher::getInstance()->getController()!='index')
            return false;

        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(28)))
            if(!$this->_prepareHook(28))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(28));
    }

    public function hookDisplayTopColumn($params)
    {
        if(Dispatcher::getInstance()->getController()!='index')
            return false;

        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(35)))
            if(!$this->_prepareHook(35))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(35));
    }

    public function hookDisplayFullWidthTop($params)
    {
        if(Dispatcher::getInstance()->getController()!='index')
            return false;
        
        if(!$this->_prepareHook(array(36,98),1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayFullWidthTop2($params)
    {
        if(Dispatcher::getInstance()->getController()!='index')
            return false;
        
        if(!$this->_prepareHook(array(86,87),1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayFullWidthBottom($params)
    {
        if(Dispatcher::getInstance()->getController()!='index')
            return false;
        
        if(!$this->_prepareHook(array(37,99),1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    
	public function hookDisplayHomeSecondaryLeft($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(14)))
    		if(!$this->_prepareHook(14))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(14));
	}

    public function hookDisplayHomeSecondaryRight($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(15)))
            if(!$this->_prepareHook(15))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(15));
    }

    public function hookDisplayHomeTertiaryLeft($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(29)))
            if(!$this->_prepareHook(29))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(29));
    }

	public function hookDisplayHomeTertiaryRight($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(30)))
    		if(!$this->_prepareHook(30))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(30));
	}

    public function hookDisplayHomeFirstQuarter($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(53)))
            if(!$this->_prepareHook(53))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(53));
    }
    public function hookDisplayHomeSecondQuarter($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(54)))
            if(!$this->_prepareHook(54))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(54));
    }

    public function hookDisplayHomeThirdQuarter($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(58)))
            if(!$this->_prepareHook(58))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(58));
    }
    public function hookDisplayHomeFourthQuarter($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(59)))
            if(!$this->_prepareHook(59))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(59));
    }

    public function hookDisplayProductSecondaryColumn($params)
    {
		if(!$this->_prepareHook(4))
            return false;
		return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayFooterProduct($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(24)))
            if(!$this->_prepareHook(24,1))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(24));
    }
    public function hookDisplayCategoryHeader($params)
    {
        if(!$this->_prepareHook(25,1))
            return false;
		return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayCategoryFooter($params)
    {
        if(!$this->_prepareHook(26,1))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl');
    }
    
    public function hookDisplayHeaderLeft($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(27)))
            if(!$this->_prepareHook(27,1))
                return false;
        $this->smarty->assign('is_inline_content',true);
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(27));
    }

    public function hookDisplayTop($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(60)))
            if(!$this->_prepareHook(60,1))
                return false;
        $this->smarty->assign('is_inline_content',true);
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(60));
    }
    
    public function hookDisplayHeaderTopLeft($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(62)))
            if(!$this->_prepareHook(62,1))
                return false;
        $this->smarty->assign('is_inline_content',true);
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(62));
    }
    
    public function hookDisplayHeaderBottom($params)
    {
        if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(61)))
            if(!$this->_prepareHook(61,1))
                return false;
        $this->smarty->assign('is_inline_content',true);
        return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(61));
    }
    
    public function hookDisplayMaintenance($params)
    {
        if(!$this->_prepareHook(9,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    
    public function hookDisplayProductButtons($params)
    {
        if(!$this->_prepareHook(31,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayRightColumnProduct($params)
    {
        if(!$this->_prepareHook(32,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayLeftColumnProduct($params)
    {
        if(!$this->_prepareHook(33,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayBanner($params)
    {
        if(!$this->_prepareHook(34,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    public function hookDisplayShoppingCartFooter($params)
    {
        if(!$this->_prepareHook(97,1))
                return false;
        return $this->display(__FILE__, 'steasycontent.tpl');
    }
    
    public function hookDisplayAnywhere($params)
    {
	    if(!isset($params['caller']) || $params['caller']!=$this->name)
            return false;
        if(isset($params['identify']) && Validate::isInt($params['identify']))
        {
    		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId($params['identify'],'id')))
            {
                $easy_content = StEasyContentClass::getById($this->context->language->id,$params['identify']);
                if(!$easy_content)
                    return false;
        		$this->smarty->assign(array('easy_content' => $easy_content));
            }
		    return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId($params['identify'],'id'));
        }
        elseif(isset($params['location']) && array_key_exists($params['location'],self::$location))
        {
    		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId($params['location'])))
        		if(!$this->_prepareHook($params['location']))
                    return false;
		    return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId($params['location']));
        }
        else
            return false;
    }
	public function hookDisplayStBlogHome($params)
	{
	    if(!Module::isInstalled('stblog') || !Module::isEnabled('stblog'))
            return false;
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(19)))
    		if(!$this->_prepareHook(19))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(19));
	}
    
	public function hookDisplayStBlogHomeTop($params)
	{
	    if(!Module::isInstalled('stblog') || !Module::isEnabled('stblog'))
            return false;
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(20)))
    		if(!$this->_prepareHook(20))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(20));
	}
    
	public function hookDisplayStBlogHomeBottom($params)
	{
	    if(!Module::isInstalled('stblog') || !Module::isEnabled('stblog'))
            return false;
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(21)))
    		if(!$this->_prepareHook(21))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(21));
	}

	public function hookDisplayStBlogLeftColumn($params)
	{
	    if(!Module::isInstalled('stblog') || !Module::isEnabled('stblog'))
            return false;
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(22)))
    		if(!$this->_prepareHook(22))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(22));
	}
	public function hookDisplayStBlogRightColumn($params)
	{
	    if(!Module::isInstalled('stblog') || !Module::isEnabled('stblog'))
            return false;
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(23)))
    		if(!$this->_prepareHook(23))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(23));
	}
        
        /**
         * Returns module content for Prices Drop page
         * @author Comm.On
	 * @param array $params Parameters
	 * @return string Content
         */
        public function hookDisplayCmnPricesDropTop($params)
	{
		if (!$this->isCached('steasycontent.tpl', $this->stGetCacheId(300)))
    		if(!$this->_prepareHook(300))
                return false;
		return $this->display(__FILE__, 'steasycontent.tpl', $this->stGetCacheId(300));
	}        
    
	public function hookActionShopDataDuplication($params)
	{
        Db::getInstance()->execute('
        INSERT IGNORE INTO '._DB_PREFIX_.'st_easy_content_shop (id_st_easy_content, id_shop)
        SELECT id_st_easy_content, '.(int)$params['new_id_shop'].'
        FROM '._DB_PREFIX_.'st_easy_content_shop
        WHERE id_shop = '.(int)$params['old_id_shop']);
        $this->clearEasyContentCache();
    }
	protected function stGetCacheId($key,$type='location',$name = null)
	{
		$cache_id = parent::getCacheId($name);
		return $cache_id.'_'.$key.'_'.$type;
	}
	private function clearEasyContentCache()
	{
        $this->_clearCache('*');
	}
	/**
	 * Return the list of fields value
	 *
	 * @param object $obj Object
	 * @return array
	 */
	public function getFieldsValueSt($obj,$fields_form="fields_form")
	{
		foreach ($this->$fields_form as $fieldset)
			if (isset($fieldset['form']['input']))
				foreach ($fieldset['form']['input'] as $input)
					if (!isset($this->fields_value[$input['name']]))
						if (isset($input['type']) && $input['type'] == 'shop')
						{
							if ($obj->id)
							{
								$result = Shop::getShopById((int)$obj->id, $this->identifier, $this->table);
								foreach ($result as $row)
									$this->fields_value['shop'][$row['id_'.$input['type']]][] = $row['id_shop'];
							}
						}
						elseif (isset($input['lang']) && $input['lang'])
							foreach (Language::getLanguages(false) as $language)
							{
								$fieldValue = $this->getFieldValueSt($obj, $input['name'], $language['id_lang']);
								if (empty($fieldValue))
								{
									if (isset($input['default_value']) && is_array($input['default_value']) && isset($input['default_value'][$language['id_lang']]))
										$fieldValue = $input['default_value'][$language['id_lang']];
									elseif (isset($input['default_value']))
										$fieldValue = $input['default_value'];
								}
								$this->fields_value[$input['name']][$language['id_lang']] = $fieldValue;
							}
						else
						{
							$fieldValue = $this->getFieldValueSt($obj, $input['name']);
							if ($fieldValue===false && isset($input['default_value']))
								$fieldValue = $input['default_value'];
							$this->fields_value[$input['name']] = $fieldValue;
						}

		return $this->fields_value;
	}
    
	/**
	 * Return field value if possible (both classical and multilingual fields)
	 *
	 * Case 1 : Return value if present in $_POST / $_GET
	 * Case 2 : Return object value
	 *
	 * @param object $obj Object
	 * @param string $key Field name
	 * @param integer $id_lang Language id (optional)
	 * @return string
	 */
	public function getFieldValueSt($obj, $key, $id_lang = null)
	{
		if ($id_lang)
			$default_value = ($obj->id && isset($obj->{$key}[$id_lang])) ? $obj->{$key}[$id_lang] : false;
		else
			$default_value = isset($obj->{$key}) ? $obj->{$key} : false;

		return Tools::getValue($key.($id_lang ? '_'.$id_lang : ''), $default_value);
	}
    public function get_fontello()
    {
        $res= array(
            'css' => '',
            'theme_name' => '',
            'module_name' => $this->_path,
            'classes' => array(),
        );

        $theme_path = _PS_THEME_DIR_;

        $shop = new Shop((int)Context::getContext()->shop->id);
        $theme_name = $shop->getTheme();
        $res['theme_name'] = $theme_name;

        if (_THEME_NAME_ != $theme_name)
            $theme_path = _PS_ROOT_DIR_.'/themes/'.$theme_name.'/';

        if (file_exists($theme_path.'font/config.json'))
        {
            $icons = Tools::jsonDecode(Tools::file_get_contents($theme_path.'font/config.json'));
            if($icons && is_array($icons->glyphs))
                foreach ($icons->glyphs as $icon) {
                    $res['classes'][] = 'icon-'.$icon->css;
                }
        }
        if (file_exists($theme_path.'sass/font-fontello/_icons.scss'))
        {
            $res['css'] .= Tools::file_get_contents($theme_path.'sass/font-fontello/_icons.scss');
        }

        return $res;
    }
    
    public function fontOptions() {
        $google = array();
        foreach($this->googleFonts as $v)
            $google[] = array('id'=>$v['family'],'name'=>$v['family']);
        return $google;
    }
    
    public function fontstyles($font_name = null)
    {
        $style = '';
        if (!$font_name)
            return $style;
        
        $name = $variant = '';
        if (strpos($font_name, ':') !== false)
            list($name, $variant) = explode(':', $font_name);
        else
            $name = $font_name;
        
        $style .= 'font-family:\''.$name.'\';';
        
        if ($variant == 'regular')
        {
            //$style .= 'font-weight:400;';
        }
        elseif ($variant)
        {
            if (preg_match('/(\d+)/iS', $variant, $math))
            {
                if (!isset($math[1]))
                    $math[1] = '400';
                $style .= 'font-weight:'.$math[1].';';
            }
            if (preg_match('/([^\d]+)/iS', $variant, $math))
            {
                if (!isset($math[1]))
                    $math[1] = 'normal';
                $style .= 'font-style:'.$math[1].';';
            }
        }
        return $style;
    }
    
    public function prepareHooks()
    {
        $location = array();
        foreach(Db::getInstance()->executeS('SELECT location FROM `'._DB_PREFIX_.'st_easy_content` GROUP BY location') AS $value)
            if (key_exists($value['location'], self::$location) && isset(self::$location[$value['location']]['hook']))
                $location[$value['location']] = self::$location[$value['location']]['hook'];
        
        foreach(self::$location AS $local)
        {
            if (!isset($local['hook']))
                continue;
            $hook = 'display'.ucfirst($local['hook']);
            $id_hook = Hook::getIdByName($hook);
            if (count($location) && in_array($local['hook'], $location))
            {
                if ($id_hook && Hook::getModulesFromHook($id_hook, $this->id))
                    continue;
                if (!$this->isHookableOn($hook))
                    $this->validation_errors[] = $this->l('This module cannot be transplanted to '.$hook.'.');
                else
                    $this->registerHook($hook, Shop::getContextListShopID());
            }
            else
            {
                if($id_hook && Hook::getModulesFromHook($id_hook, $this->id))
                {
                    $this->unregisterHook($id_hook, Shop::getContextListShopID());
                    $this->unregisterExceptions($id_hook, Shop::getContextListShopID());
                } 
            }   
        }
        Cache::clean('hook_module_list');
        return true;
    }
}