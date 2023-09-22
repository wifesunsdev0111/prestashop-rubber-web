<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

include_once(_PS_MODULE_DIR_.'psblog/loader.php');

class PsblogcategoryModuleFrontController extends ModuleFrontController
{
    public $php_self;
    protected $template_path = '';

    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
        $this->template_path = _PS_MODULE_DIR_.'psblog/views/templates/front/';
    }

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $config = PsBlogConfig::getInstance();

        /* Load Css and JS File */
        PsBlogHelper::loadMedia($this->context, $this);

        // $this->php_self = 'category';

		$this->php_self = 'module-psblog-category';
		
        parent::initContent();

        $id_category = (int)Tools::getValue('id');

        $helper = PsBlogHelper::getInstance();

        $limit_leading_blogs = (int)$config->get('listing_leading_limit_items', 1);
        $limit_secondary_blogs = (int)$config->get('listing_secondary_limit_items', 6);

        $limit = (int)$limit_leading_blogs + (int)$limit_secondary_blogs;
        $n = $limit;
        $p = abs((int)(Tools::getValue('p', 1)));
        if( $config->get('url_use_id', 1))
        {
            // URL HAVE ID
            $category = new Psblogcat($id_category, $this->context->language->id);
        }else{
            // REMOVE ID FROM URL
            $url_rewrite = explode('/', $_SERVER['REQUEST_URI']) ;
            $url_last_item = count($url_rewrite) - 1;
            $url_rewrite = rtrim($url_rewrite[$url_last_item],'.html');
            $category = Psblogcat::findByRewrite(array('link_rewrite'=>$url_rewrite));
        }
        
        $template = isset($category->template) && $category->template ? $category->template : $config->get('template', 'default');

        if ($category->id_psblogcat && $category->active) {
//			$_GET['rewrite'] = $category->link_rewrite;
            $this->template_path .= $template.'/';

            if ($category->image) {
                # validate module
                $category->image = _PsBLOG_BLOG_IMG_URI_.'c/'.$category->image;
            }

            $blogs = PsBlogBlog::getListBlogs($category->id_psblogcat, $this->context->language->id, $p, $limit, 'id_psblog_blog', 'DESC', array(), true);
            $count = PsBlogBlog::countBlogs($category->id_psblogcat, $this->context->language->id, true);
            $authors = array();

            $leading_blogs = array();
            $secondary_blogs = array();
//			$links 	   =  array();

            if (count($blogs)) {
                $leading_blogs = array_slice($blogs, 0, $limit_leading_blogs);
                $secondary_blogs = array_splice($blogs, $limit_leading_blogs, count($blogs));
            }
            $image_w = (int)$config->get('listing_leading_img_width', 690);
            $image_h = (int)$config->get('listing_leading_img_height', 300);

            foreach ($leading_blogs as $key => $blog) {
                $blog = PsBlogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config);
                if ($blog['id_employee']) {
                    if (!isset($authors[$blog['id_employee']])) {
                        # validate module
                        $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
                    }

                    $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
                    $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
                } else {
                    $blog['author'] = '';
                    $blog['author_link'] = '';
                }

                $leading_blogs[$key] = $blog;
            }

            $image_w = (int)$config->get('listing_secondary_img_width', 390);
            $image_h = (int)$config->get('listing_secondary_img_height', 200);

            foreach ($secondary_blogs as $key => $blog) {
                $blog = PsBlogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config);
                if ($blog['id_employee']) {
                    if (!isset($authors[$blog['id_employee']])) {
                        # validate module
                        $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
                    }

                    $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
                    $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
                } else {
                    $blog['author'] = '';
                    $blog['author_link'] = '';
                }

                $secondary_blogs[$key] = $blog;
            }

            $nb_blogs = $count;
            $range = 2; /* how many pages around page selected */
            if ($p > (($nb_blogs / $n) + 1)) {
                Tools::redirect(preg_replace('/[&?]p=\d+/', '', $_SERVER['REQUEST_URI']));
            }
            $pages_nb = ceil($nb_blogs / (int)($n));
            $start = (int)($p - $range);
            if ($start < 1) {
                $start = 1;
            }
            $stop = (int)($p + $range);
            if ($stop > $pages_nb) {
                $stop = (int)($pages_nb);
            }

            $params = array(
                'rewrite' => $category->link_rewrite,
                'id' => $category->id_psblogcat
            );

            /* breadcrumb */
            $r = $helper->getPaginationLink('module-psblog-category', 'category', $params, false, true);
            $path = '';
            $all_cats = array();
            self::parentCategories($category, $all_cats);

            foreach ($all_cats as $key => $cat) {
                if ($cat->id == 1) {
                    # validate module
                    $path .= '<a href="'.$helper->getFontBlogLink().'">'.htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8').'</a><span class="navigation-pipe">'.Configuration::get('PS_NAVIGATION_PIPE').'</span>';
                } elseif ((count($all_cats) - 1) == $key) {
                    # validate module
                    $path .= $cat->title;
                } else {
                    $params = array(
                        'rewrite' => $cat->link_rewrite,
                        'id' => $cat->id
                    );
                    $path .= '<a href="'.$helper->getBlogCatLink($params).'">'.htmlentities($cat->title, ENT_NOQUOTES, 'UTF-8').'</a><span class="navigation-pipe">'.Configuration::get('PS_NAVIGATION_PIPE').'</span>';
                }
            }
            /* sub categories */
            $categories = $category->getChild($category->id_psblogcat, $this->context->language->id);

            $childrens = array();

            if ($categories) {
                foreach ($categories as $child) {
                    $params = array(
                        'rewrite' => $child['link_rewrite'],
                        'id' => $child['id_psblogcat']
                    );

                    $child['thumb'] = _PsBLOG_BLOG_IMG_URI_.'c/'.$child['image'];

                    $child['category_link'] = $helper->getBlogCatLink($params);
                    $childrens[] = $child;
                }
            }

            $this->context->smarty->assign(array(
                'leading_blogs' => $leading_blogs,
                'secondary_blogs' => $secondary_blogs,
                'listing_leading_column' => $config->get('listing_leading_column', 1),
                'listing_secondary_column' => $config->get('listing_secondary_column', 3),
                'module_tpl' => $this->template_path,
                'config' => $config,
                'range' => $range,
                'category' => $category,
                'start' => $start,
                'childrens' => $childrens,
                'stop' => $stop,
                'path' => $path,
                'pages_nb' => $pages_nb,
                'nb_items' => $count,
                'p' => (int)$p,
                'n' => (int)$n,
                'meta_title' => Tools::ucfirst($category->title).' - '.Configuration::get('PS_SHOP_NAME'),
                'meta_keywords' => $category->meta_keywords,
                'meta_description' => $category->meta_description,
                'requestPage' => $r['requestUrl'],
                'requestNb' => $r,
                'category' => $category
            ));
        } else {
            $path = '<a href="'.$helper->getFontBlogLink().'">'.htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8').'</a><span class="navigation-pipe">'.Configuration::get('PS_NAVIGATION_PIPE').'</span>';
            $this->context->smarty->assign(array(
                'active' => '0',
                'path' => $path,
                'leading_blogs' => array(),
                'secondary_blogs' => array(),
                'controller' => 'category',
                'category' => $category
            ));
        }


        // $this->setTemplate($template.'/category.tpl');
		$this->setTemplate('module:psblog/views/templates/front/'.$template.'/category.tpl');
    }

    public static function parentCategories($current, &$return)
    {
        if ($current->id_parent) {
            $obj = new Psblogcat($current->id_parent, Context::getContext()->language->id);
            self::parentCategories($obj, $return);
        }
        $return[] = $current;
    }
}
