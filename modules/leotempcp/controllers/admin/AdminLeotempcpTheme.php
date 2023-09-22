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
require_once(_PS_MODULE_DIR_.'leotempcp/libs/helper.php');

class AdminLeotempcpThemeController extends ModuleAdminControllerCore
{
    /**
     * @var String $name
     *
     * @access protected
     */
    public $name = 'LiveThemeEditor';
    /**
     * @var String $name
     *
     * @access public
     */
    public $themeName = '';
    /**
     * @var String $themeCustomizePath
     *
     * @access public 
     */
    public $themeCustomizePath = '';
    /**
     * @var String $customizeFolderURL
     *
     * @access public 
     */
    public $customizeFolderURL = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->table = 'leohook';
        $this->className = 'LeotempcpPanel';
        $this->bootstrap = true;
        $this->lang = true;
        $this->context = Context::getContext();
        parent::__construct();
        $this->display_key = (int)Tools::getValue('show_modules');

        $this->ownPositions = array(
            'displayHeaderRight',
            'displaySlideshow',
            'topNavigation',
            'displayBottom'
        );
        $this->hookspos = array(
            'displayTop',
            'displayHeaderRight',
            'displaySlideshow',
            'topNavigation',
            'displayTopColumn',
            'displayRightColumn',
            'displayLeftColumn',
            'displayHome',
            'displayFooter',
            'displayBottom',
            'displayContentBottom',
            'displayFootNav'
        );
        $this->themeName = Context::getContext()->shop->getTheme();
        $this->themeCustomizePath = _PS_ALL_THEMES_DIR_.$this->themeName.'/css/customize/';
        $this->themeCustomizeURL = $this->context->shop->getBaseURL().'/themes/'.$this->themeName.'/css/customize/';
    }

    /**
     * Build List linked Icons Toolbar
     */
    public function initToolbarTitle()
    {
        parent::initToolbarTitle();
        $this->toolbar_title = $this->l('LeoTheme Positions Control: ').$this->themeName;
        $this->toolbar_btn['save'] = array(
            'href' => 'index.php?tab=AdminLeotempcpPanel&token='.Tools::getAdminTokenLite('AdminLeotempcpPanel').'&action=savepos',
            'id' => 'savepos',
            'desc' => $this->l('Save Positions')
        );

        $this->toolbar_btn['controlpanel'] = array(
            'href' => 'index.php?controller=adminmodules&configure=leotempcp&token='.Tools::getAdminTokenLite('AdminModules').'&tab_module=Home&module_name=leotempcp',
            'id' => 'controlpanel',
            'desc' => $this->l('Theme Control Panel')
        );
        $admin_dir = basename(_PS_ADMIN_DIR_);
        $live_edit_params = array(
            'live_edit' => true,
            'ad' => $admin_dir,
            'liveToken' => Tools::getAdminTokenLite('AdminModulesPositions'),
            'id_employee' => (int)$this->context->employee->id
        );

        $this->toolbar_btn['liveedit'] = array(
            'href' => $this->getLiveEditUrl($live_edit_params),
            'id' => 'liveedit',
            'desc' => $this->l('Live Edit')
        );
        $helpURL = __PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/help/help.pdf';

        $this->toolbar_btn['help'] = array(
            'href' => $helpURL,
            'id' => 'help',
            'jsddd' => 'showHelp(\''.$helpURL.'\')',
            'desc' => $this->l('Help')
        );
    }

    /**
     * get live Edit URL
     */
    public function getLiveEditUrl($live_edit_params)
    {
        $url = $this->context->shop->getBaseURL().Dispatcher::getInstance()->createUrl('index', (int)$this->context->language->id, $live_edit_params);
        if (Configuration::get('PS_REWRITING_SETTINGS')) {
            $url = str_replace('index.php', '', $url);
        }
        return $url;
    }

    /**
     * add toolbar icons
     */
    public function initToolbar()
    {
        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
        $this->context->smarty->assign('title', $this->toolbar_title);
    }

    /**
     * Process posting data
     */
    public function postProcess()
    {
        if (Tools::getValue('action') && Tools::getValue('action') == 'savedata' && Tools::getValue('customize')) {
            $data = LeoFrameworkHelper::getPost(array('action-mode', 'saved_file', 'newfile', 'customize', 'customize_match'), 0);
            $selectors = $data['customize'];
            $matches = $data['customize_match'];

            $output = '';

            $cache = array();
            foreach ($selectors as $match => $customizes) {
                $output .= "\r\n/* customize for $match */ \r\n";
                foreach ($customizes as $key => $customize) {
                    if (isset($matches[$match]) && isset($matches[$match][$key])) {
                        $tmp = explode('|', $matches[$match][$key]);
                        $attribute = Tools::strtolower(trim($tmp[1]));
                        if (trim($customize)) {
                            $output .= $tmp[0].' { ';
                            if ($attribute == 'background-image') {
                                $output .= $attribute.':url('.$customize.')';
                            } elseif ($attribute == 'font-size') {
                                $output .= $attribute.':'.$customize.'px';
                            } else if (strpos($attribute, 'color') !== false) {
                                $output .= $attribute.':#'.$customize;
                            } else if ($attribute == 'background') {
                                $output .= $attribute.':#'.$customize;
                            } else {
                                $output .= $attribute.':'.$customize;
                            }

                            $output .= "} \r\n";
                        }
                        $cache[$match][] = array('val' => $customize, 'selector' => $tmp[0], 'attr' => $tmp[1]);
                    }
                }
            }
            if (!empty($data['saved_file'])) {
                if ($data['saved_file'] && file_exists($this->themeCustomizePath.$data['saved_file'].'.css')) {
                    unlink($this->themeCustomizePath.$data['saved_file'].'.css');
                }
                if ($data['saved_file'] && file_exists($this->themeCustomizePath.$data['saved_file'].'.json')) {
                    unlink($this->themeCustomizePath.$data['saved_file'].'.json');
                }
            }

            if (empty($data['newfile'])) {
                $nameFile = $data['saved_file'] ? $data['saved_file'] : 'profile-'.time();
            } else {
                $nameFile = preg_replace('#\s+#', '-', trim($data['newfile']));
            }

            if ($data['action-mode'] != 'save-delete') {
                if (!is_dir($this->themeCustomizePath)) {
                    mkdir($this->themeCustomizePath, 0755);
                }

                if (!empty($output)) {
                    LeoFrameworkHelper::writeToCache($this->themeCustomizePath, $nameFile, $output);
                }
                if (!empty($cache)) {
                    LeoFrameworkHelper::writeToCache($this->themeCustomizePath, $nameFile, Tools::jsonEncode($cache), 'json');
                }
            }
            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
        }
    }

    /**
     * get list of files inside folder path.
     */
    private function getFileList($path, $e = null, $nameOnly = false)
    {
        $output = array();
        $directories = glob($path.'*'.$e);
        if ($directories) {
            foreach ($directories as $dir) {
                $dir = basename($dir);
                if ($nameOnly) {
                    $dir = str_replace($e, '', $dir);
                }
                $output[$dir] = $dir;
            }
        }
        return $output;
    }

    /**
     * render list of modules following positions in the layout editor.
     */
    public function renderList()
    {
        $filePath = _PS_ALL_THEMES_DIR_.$this->themeName.'';
        $xml = simplexml_load_file($filePath.'/config.xml');

        if (!isset($xml->theme_key) || empty($xml->theme_key)) {
            return '<div class="panel"><div class="panel-content"><div class="alert alert-danger">'.$this->l('This function is only avariable using for theme From <b>leotheme.com</b> or using theme built-in <b>Leo Framework</b>').'</div></div></div>';
        }

        $tpl = $this->createTemplate('themeeditor.tpl');
        $this->context->controller->addCss(__PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/assets/admin/themeeditor.css', 'all');
        $this->context->controller->addCss(__PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/assets/admin/colorpicker/css/colorpicker.css', 'all');
        $this->context->controller->addJs(__PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/assets/admin/themeeditor.js', 'all');
        $this->context->controller->addJs(__PS_BASE_URI__.str_replace('//', '/', 'modules/leotempcp').'/assets/admin/colorpicker/js/colorpicker.js', 'all');
        $this->context->controller->addCss(__PS_BASE_URI__.'themes/'.$this->themeName.'/css/paneltool.css');

        $output = LeoFrameworkHelper::renderEdtiorThemeForm($this->themeName);

        /*         * */
        $profiles = $this->getFileList($this->themeCustomizePath, '.css', true);
        $patterns = $this->getFileList(_PS_ALL_THEMES_DIR_.$this->themeName.'/img/patterns/', '.png');
        $patternsjpg = $this->getFileList(_PS_ALL_THEMES_DIR_.$this->themeName.'/img/patterns/', '.jpg');

        $patterns = array_merge($patterns, $patternsjpg);
        $backGroundValue = array(
            'attachment' => array('scroll', 'fixed', 'local', 'initial', 'inherit'),
            'repeat' => array('repeat', 'repeat-x', 'repeat-y', 'no-repeat', 'initial', 'inherit'),
            'position' => array('left top', 'left center', 'left bottom', 'right top', 'right center', 'right bottom', 'center top', 'center center', 'center bottom')
        );
        $siteURL = $this->context->shop->getBaseURL();
        $imgLink = Context::getContext()->link->getAdminLink('AdminLeotempcpImages');
        $backgroundImageURL = $this->context->shop->getBaseURL().'/themes/'.$this->themeName.'/img/patterns/';

        $ssl_enable = Configuration::get('PS_SSL_ENABLED');
        if ($ssl_enable) {
            $siteURL = str_replace('http:', 'https:', $siteURL);
            $imgLink = str_replace('http:', 'https:', $imgLink);
            $backgroundImageURL = str_replace('http:', 'https:', $backgroundImageURL);
        }

        $tpl->assign(array(
            'actionURL' => 'index.php?tab=AdminLeotempcpTheme&token='.Tools::getAdminTokenLite('AdminLeotempcpTheme').'&action=savedata',
            'text_layout' => $this->l('Layout'),
            'text_elements' => $this->l('Elements'),
            'profiles' => $profiles,
            'xmlselectors' => $output,
            'themeName' => $this->themeName,
            'patterns' => $patterns,
            'backgroundImageURL' => $backgroundImageURL,
            'siteURL' => $siteURL,
            'customizeFolderURL' => $this->themeCustomizeURL,
            'backLink' => 'index.php?tab=AdminLeotempcpModule&token='.Tools::getAdminTokenLite('AdminLeotempcpModule').'&action=back',
            'imgLink' => $imgLink,
            'backGroundValue' => $backGroundValue
        ));

        return $tpl->fetch();
    }
}
