<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

class PsBlogHelper
{
    public $bloglink = null;
    public $ssl;

    public static function getInstance()
    {
        static $instance = null;
        if (!$instance) {
            # validate module
            $instance = new PsBlogHelper();
        }

        return $instance;
    }

    public function __construct()
    {
        if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
            $this->ssl = true;
        }

        $protocol_link = (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) ? 'https://' : 'http://';
        $use_ssl = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
        $protocol_content = ($use_ssl) ? 'https://' : 'http://';
        $this->bloglink = new PsBlogLink($protocol_link, $protocol_content);
    }

    public static function loadMedia($context, $obj)
    {
        if (file_exists(_PS_THEME_DIR_.'css/modules/psblog/assets/psblog.css')) {
            $context->controller->addCss($obj->module->getPathUri().'assets/psblog.css');
        } else {
            $context->controller->addCss($obj->module->getPathUri().'views/css/psblog.css');
        }

        if (file_exists(_PS_THEME_DIR_.'js/modules/psblog/assets/psblog.js')) {
            $context->controller->addJs($obj->module->getPathUri().'assets/psblog.js');
        } else {
            $context->controller->addJs($obj->module->getPathUri().'views/js/psblog.js');
        }
    }

    public function getLinkObject()
    {
        return $this->bloglink;
    }

    public function getModuleLink($route_id, $controller, array $params = array(), $ssl = null, $id_lang = null, $id_shop = null)
    {
        return $this->getLinkObject()->getLink($route_id, $controller, $params, $ssl, $id_lang, $id_shop);
    }

    public function getFontBlogLink()
    {
        return $this->getModuleLink('module-psblog-list', 'list', array());
    }

    public function getPaginationLink($route_id, $controller, array $params = array(), $nb = false, $sort = false, $pagination = false, $array = true)
    {
        return $this->getLinkObject()->getPsPaginationLink('psblog', $route_id, $controller, $params, $nb, $sort, $pagination, $array);
    }

    public function getBlogLink($blog, $params1 = array())
    {
        $params = array(
            'id' => $blog['id_psblog_blog'],
            'rewrite' => $blog['link_rewrite'],
        );

        $params = array_merge($params, $params1);

        return $this->getModuleLink('module-psblog-blog', 'blog', $params);
    }

    public function getTagLink($tag)
    {
        $params = array(
            'tag' => $tag,
        );

        return $this->getModuleLink('blog_user_filter_rule', 'blog', $params);
    }

    public function getBlogCatLink($cparams)
    {
        $params = array(
            'id' => '',
            'rewrite' => ''
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-psblog-category', 'category', $params);
    }

    public function getBlogTagLink($tag, $cparams = array())
    {
        $params = array(
            'tag' => urlencode($tag),
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-psblog-list', 'list', $params);
    }

    public function getBlogAuthorLink($author, $cparams = array())
    {
        $params = array(
            'author' => $author,
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-psblog-list', 'list', $params);
    }

    public static function getTemplates()
    {
        $theme = _THEME_NAME_;
        $path = _PS_MODULE_DIR_.'psblog';
        $tpath = _PS_ALL_THEMES_DIR_.$theme.'modules/psblog/front';

        $output = array();

        $templates = glob($path.'/views/templates/front/*', GLOB_ONLYDIR);

        $ttemplates = glob($tpath, GLOB_ONLYDIR);
        if ($templates) {
            foreach ($templates as $t) {
                # validate module
                $output[basename($t)] = array('type' => 'module', 'template' => basename($t));
            }
        }
        if ($ttemplates) {
            foreach ($ttemplates as $t) {
                # validate module
                $output[basename($t)] = array('type' => 'module', 'template' => basename($t));
            }
        }

        return $output;
    }

    public static function buildBlog($helper, $blog, $image_w, $image_h, $config=false)
    {
        # module validation
        !is_null($image_w) ? true : $image_w = 0;
        !is_null($image_h) ? true : $image_h = 0;

        $url = _PS_BASE_URL_;
        if (Tools::usingSecureMode()) {
            # validate module
            $url = _PS_BASE_URL_SSL_;
        }

        $blog['preview_url'] = '';
        $blog['image_url'] = '';
        if ($blog['image']) {
            $blog['image_url'] = $url._PsBLOG_BLOG_IMG_URI_.'b/'.$blog['image'];
            if (!file_exists(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'])) {
                @mkdir(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'], 0777);
                @mkdir(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h, 0777);
                if (ImageManager::resize(_PsBLOG_BLOG_IMG_DIR_.'b/'.$blog['image'], _PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'], $image_w, $image_h)) {
                    # validate module
                    $blog['preview_url'] = _PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'];
                }
            }
            $blog['image_url'] = $url._PsBLOG_BLOG_IMG_URI_.'b/'.$blog['image'];
            $blog['preview_url'] = $url._PsBLOG_CACHE_IMG_URI_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'];
        }

        $blog['preview_thumb_url'] = '';
        $blog['thumb_url'] = '';
        if (isset($blog['thumb']) && $blog['thumb'] != '') {
            $blog['thumb_url'] = $url._PsBLOG_BLOG_IMG_URI_.'b/'.$blog['thumb'];
            if (!file_exists(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'])) {
                @mkdir(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'], 0777);
                @mkdir(_PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h, 0777);
                if (ImageManager::resize(_PsBLOG_BLOG_IMG_DIR_.'b/'.$blog['thumb'], _PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'], $image_w, $image_h)) {
                    # validate module
                    $blog['preview_thumb_url'] = _PsBLOG_CACHE_IMG_DIR_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'];
                }
            }
            $blog['thumb_url'] = $url._PsBLOG_BLOG_IMG_URI_.'b/'.$blog['thumb'];
            $blog['preview_thumb_url'] = $url._PsBLOG_CACHE_IMG_URI_.'b/'.$blog['id_psblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'];
        }
        $params = array(
            'rewrite' => $blog['category_link_rewrite'],
            'id' => $blog['id_psblogcat']
        );
        //	if( !$config->get( 'listing_show_counter' , 1)  ) {
        if ($config && $config->get('item_comment_engine', 'local') == 'local') {
            # validate module
            $blog['comment_count'] = PsBlogComment::countComments($blog['id_psblog_blog'], true, true);
        }
        //	}else {
        //	$blog['comment_count'] = 0;
        //	}
        $blog['category_link'] = $helper->getBlogCatLink($params);
        $blog['link'] = $helper->getBlogLink($blog);
        return $blog;
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir.'/'.$object) == 'dir') {
                        self::rrmdir($dir.'/'.$object);
                    } else {
                        unlink($dir.'/'.$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public static function getConfigKey($multi_lang = false)
    {
        if ($multi_lang == false) {
            return array(
                'saveConfiguration',
                'template',
                'indexation',
                'rss_limit_item',
                'rss_title_item',
                'listing_show_categoryinfo',
                'listing_show_subcategories',
                'listing_leading_column',
                'listing_leading_limit_items',
                'listing_leading_img_width',
                'listing_leading_img_height',
                'listing_secondary_column',
                'listing_secondary_limit_items',
                'listing_secondary_img_width',
                'listing_secondary_img_height',
                'listing_show_title',
                'listing_show_description',
                'listing_show_readmore',
                'listing_show_image',
                'listing_show_author',
                'listing_show_category',
                'listing_show_created',
                'listing_show_hit',
                'listing_show_counter',
                'item_img_width',
                'item_img_height',
                'item_show_description',
                'item_show_image',
                'item_show_author',
                'item_show_category',
                'item_show_created',
                'item_show_hit',
                'item_show_counter',
                'social_code',
                'item_comment_engine',
                'item_limit_comments',
                'item_diquis_account',
                'item_facebook_appid',
                'item_facebook_width',
                'url_use_id',
            );
        } else {
            return array(
                'blog_link_title',
                'link_rewrite',
                'category_rewrite',
                'detail_rewrite',
                'meta_title',
                'meta_description',
                'meta_keywords',
            );
        }
    }

    /**
     * @return day in month
     * 1st, 2nd, 3rd, 4th, ...
     */
    public function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number.'th';
        else
            return $number.$ends[$number % 10];
    }

    /**
     * @return day in month
     * st, nd, rd, th, ...
     */
    public function string_ordinal($number)
    {
        $number = (int) $number;
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return 'th';
        else
            return $ends[$number % 10];
    }
}
