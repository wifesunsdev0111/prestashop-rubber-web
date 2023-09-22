<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

define('_Ps_BLOG_PREFIX_', 'PsBLG_');
require_once(_PS_MODULE_DIR_.'psblog/classes/config.php');

$config = PsBlogConfig::getInstance();


define('_PsBLOG_BLOG_IMG_DIR_', _PS_MODULE_DIR_.'psblog/views/img/');
define('_PsBLOG_BLOG_IMG_URI_', __PS_BASE_URI__.'modules/psblog/views/img/');


define('_PsBLOG_CATEGORY_IMG_URI_', _PS_MODULE_DIR_.'psblog/views/img/');
define('_PsBLOG_CATEGORY_IMG_DIR_', __PS_BASE_URI__.'modules/psblog/views/img/');

define('_PsBLOG_CACHE_IMG_DIR_', _PS_IMG_DIR_.'psblog/');
define('_PsBLOG_CACHE_IMG_URI_', _PS_IMG_.'psblog/');

$link_rewrite = 'link_rewrite'.'_'.Context::getContext()->language->id;
define('_Ps_BLOG_REWRITE_ROUTE_', $config->get($link_rewrite, 'blog'));

if (!is_dir(_PsBLOG_BLOG_IMG_DIR_.'c')) {
    # validate module
    mkdir(_PsBLOG_BLOG_IMG_DIR_.'c', 0777, true);
}

if (!is_dir(_PsBLOG_BLOG_IMG_DIR_.'b')) {
    # validate module
    mkdir(_PsBLOG_BLOG_IMG_DIR_.'b', 0777, true);
}

if (!is_dir(_PsBLOG_CACHE_IMG_DIR_)) {
    # validate module
    mkdir(_PsBLOG_CACHE_IMG_DIR_, 0777, true);
}
if (!is_dir(_PsBLOG_CACHE_IMG_DIR_.'c')) {
    # validate module
    mkdir(_PsBLOG_CACHE_IMG_DIR_.'c', 0777, true);
}
if (!is_dir(_PsBLOG_CACHE_IMG_DIR_.'b')) {
    # validate module
    mkdir(_PsBLOG_CACHE_IMG_DIR_.'b', 0777, true);
}

require_once(_PS_MODULE_DIR_.'psblog/libs/Helper.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/psblogcat.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/blog.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/link.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/comment.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/PsblogOwlCarousel.php');
