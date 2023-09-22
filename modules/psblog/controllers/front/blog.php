<?php
/**
 * @license   GNU General Public License version 2
 */

include_once(_PS_MODULE_DIR_.'psblog/loader.php');

class PsblogblogModuleFrontController extends ModuleFrontController
{
    public $php_self;
    protected $template_path = '';

    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
        $this->template_path = _PS_MODULE_DIR_.'psblog/views/templates/front/';
    }

    public function captcha()
    {
        include_once(_PS_MODULE_DIR_.'psblog/classes/captcha.php');
        $captcha = new PsCaptcha();
        $this->context->cookie->pscaptch = $captcha->getCode();
        $captcha->showImage();
    }

    /**
     * @param object &$object Object
     * @param string $table Object table
     * @ DONE
     */
    protected function copyFromPost(&$object, $table, $post = array())
    {
        /* Classical fields */
        foreach ($post as $key => $value) {
            if (key_exists($key, $object) && $key != 'id_'.$table) {
                /* Do not take care of password field if empty */
                if ($key == 'passwd' && Tools::getValue('id_'.$table) && empty($value)) {
                    continue;
                }
                if ($key == 'passwd' && !empty($value)) {
                    /* Automatically encrypt password in MD5 */
                    $value = Tools::encrypt($value);
                }
                $object->{$key} = $value;
            }
        }
        
        /* Multilingual fields */
        $rules = call_user_func(array(get_class($object), 'getValidationRules'), get_class($object));
        if (count($rules['validateLang'])) {
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                foreach (array_keys($rules['validateLang']) as $field) {
                    $field_name = $field.'_'.(int)($language['id_lang']);
                    $value = Tools::getValue($field_name);
                    if (isset($value)) {
                        # validate module
                        $object->{$field}[(int)($language['id_lang'])] = $value;
                    }
                }
            }
        }
    }

    /**
     * Save user comment
     */
    protected function comment()
    {
        $post = array();
        $post['user'] = Tools::getValue('user');
        $post['email'] = Tools::getValue('email');
        $post['comment'] = Tools::getValue('comment');
        $post['captcha'] = Tools::getValue('captcha');
        $post['id_psblog_blog'] = Tools::getValue('id_psblog_blog');
        $post['submitcomment'] = Tools::getValue('submitcomment');

        if (!empty($post)) {
            $comment = new PsBlogComment();
            $captcha = Tools::getValue('captcha');
            $this->copyFromPost($comment, 'comment', $post);

            $error = new stdClass();
            $error->error = true;

            if (isset($this->context->cookie->pscaptch) && $captcha && $captcha == $this->context->cookie->pscaptch) {
                if ($comment->validateFields(false) && $comment->validateFieldsLang(false)) {
                    $comment->save();
                    $error->message = $this->l('Thanks for your comment, it will be published soon!!!');
                    $error->error = false;
                } else {
                    # validate module
                    $error->message = $this->l('An error occurred while sending the comment. Please recorrect data in fields!!!');
                }
            } else {
                # validate module
                $error->message = $this->l('An error with captcha code, please try to recorrect!!!');
            }

            die(Tools::jsonEncode($error));
        }
    }

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $this->php_self = 'module-psblog-blog';
        
        if (Tools::getValue('captchaimage')) {
            $this->captcha();
            exit();
        }
        $config = PsBlogConfig::getInstance();

        /* Load Css and JS File */
        PsBlogHelper::loadMedia($this->context, $this);

        parent::initContent();

        if (Tools::isSubmit('submitcomment')) {
            # validate module
            $this->comment();
        }

        $helper = PsBlogHelper::getInstance();
        if( $config->get('url_use_id', 1))
        {
            // URL HAVE ID
            $blog = new PsBlogBlog(Tools::getValue('id'), $this->context->language->id);
        }else{
            // REMOVE ID FROM URL
            $url_rewrite = explode('/', $_SERVER['REQUEST_URI']) ;
            $url_last_item = count($url_rewrite) - 1;
            $url_rewrite = rtrim($url_rewrite[$url_last_item],'.html');
            $blog = PsBlogBlog::findByRewrite(array('link_rewrite'=>$url_rewrite));
        }

        if (!$blog->id_psblog_blog) {
            $full_path = '<a href="'.$helper->getFontBlogLink().'">'.htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8').'</a>';
            $vars = array(
                'error' => true,
                'path' => $full_path
            );
            $this->context->smarty->assign($vars);

            return $this->setTemplate($config->get('template', 'default').'/blog.tpl');
        }

        $category = new psblogcat($blog->id_psblogcat, $this->context->language->id);


        $image_w = $config->get('item_img_width', 690);
        $image_h = $config->get('item_img_height', 300);

        $template = !empty($category->template) ? $category->template : 'default'; // have to have a value ( not empty )
        $this->template_path .= $template.'/';
        $module_tpl = $this->template_path;

        $url = _PS_BASE_URL_;
        if (Tools::usingSecureMode()) {
            # validate module
            $url = _PS_BASE_URL_SSL_;
        }

        $blog->preview_url = '';
        if ($blog->image) {
            $blog->image_url = $url._PsBLOG_BLOG_IMG_URI_.'b/'.$blog->image;
            if (ImageManager::resize(_PsBLOG_BLOG_IMG_DIR_.'b/'.$blog->image, _PsBLOG_CACHE_IMG_DIR_.'b/lg-'.$blog->image, $image_w, $image_h)) {
                # validate module
                $blog->preview_url = $url._PsBLOG_CACHE_IMG_URI_.'b/lg-'.$blog->image;
            }
        }

        $captcha_image = $helper->getBlogLink(get_object_vars($blog), array('captchaimage' => 1));
        $blog_link = $helper->getBlogLink(get_object_vars($blog));

        $params = array(
            'rewrite' => $category->link_rewrite,
            'id' => $category->id_psblogcat
        );

        $blog->category_link = $helper->getBlogCatLink($params);
        $blog->category_title = $category->title;

        $employee = new Employee($blog->id_employee);

        $blog->author = $employee->firstname.' '.$employee->lastname;
        $blog->author_link = $helper->getBlogAuthorLink($employee->id);

        $tags = array();
        if ($blog->tags && $tmp = explode(',', $blog->tags)) {
            foreach ($tmp as $tag) {
                $tags[] = array(
                    'tag' => $tag,
                    'link' => $helper->getBlogTagLink($tag)
                );
            }
        }

        $blog->hits = $blog->hits + 1;
        //$blog->save();
        $blog->updateField($blog->id, array('hits' => $blog->hits));

        /* breadscrumb */
        $params = array(
            'rewrite' => $category->link_rewrite,
            'id' => $category->id_psblogcat
        );

        $category_link = $helper->getBlogCatLink($params);
        $full_path = '<a href="'.$helper->getFontBlogLink().'">'.htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8')
                .'</a><span class="navigation-pipe">'.Configuration::get('PS_NAVIGATION_PIPE').'</span>';
        $full_path .= '<a href="'.Tools::safeOutput($category_link).'">'.htmlentities($category->title, ENT_NOQUOTES, 'UTF-8').'</a><span class="navigation-pipe">'.Configuration::get('PS_NAVIGATION_PIPE').'</span>'.$blog->meta_title;
        $limit = 5;

        $samecats = PsBlogBlog::getListBlogs($category->id_psblogcat, $this->context->language->id, 0, $limit, 'date_add', 'DESC', array('type' => 'samecat', 'id_psblog_blog' => $blog->id_psblog_blog), true);
        foreach ($samecats as $key => $sblog) {
            $sblog['link'] = $helper->getBlogLink($sblog);
            $samecats[$key] = $sblog;
        }

        $tagrelated = array();

        if ($blog->tags) {
            $tagrelated = PsBlogBlog::getListBlogs($category->id_psblogcat, $this->context->language->id, 0, $limit, 'id_psblog_blog', 'DESC', array('type' => 'tag', 'tag' => $blog->tags), true);
            foreach ($tagrelated as $key => $tblog) {
                $tblog['link'] = $helper->getBlogLink($tblog);
                $tagrelated[$key] = $tblog;
            }
        }

        /* Comments */
        $evars = array();
        if ($config->get('item_comment_engine', 'local') == 'local') {
            $count_comment = 0;
            if ($config->get('comment_engine', 'local') == 'local') {
                # validate module
                $count_comment = PsBlogComment::countComments($blog->id_psblog_blog, true);
            }

            $blog_link = $helper->getBlogLink(get_object_vars($blog));
            $limit = (int)$config->get('item_limit_comments', 10);
            $n = $limit;
            $p = abs((int)(Tools::getValue('p', 1)));

            $comment = new PsBlogComment();
            $comments = $comment->getList($blog->id_psblog_blog, $this->context->language->id, $p, $limit);

            $nb_blogs = $count_comment;
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

            $evars = array('pages_nb' => $pages_nb,
                'nb_items' => $count_comment,
                'p' => (int)$p,
                'n' => (int)$n,
                'requestPage' => $blog_link,
                'requestNb' => $blog_link,
                'start' => $start,
                'comments' => $comments,
                'range' => $range,
                'blog_count_comment' => $count_comment,
                'stop' => $stop);
        }
        if ((bool)Module::isEnabled('smartshortcode')) {
            if (context::getcontext()->controller->controller_type == 'front') {
                $smartshortcode = Module::getInstanceByName('smartshortcode');
                $blog->content = $smartshortcode->parse($blog->content);
            }
        }

        $vars = array(
            'tags' => $tags,
            'meta_title' => Tools::ucfirst($blog->meta_title).' - '.Configuration::get('PS_SHOP_NAME'),
            'meta_keywords' => $blog->meta_keywords,
            'meta_description' => $blog->meta_description,
            'blog' => $blog,
            'samecats' => $samecats,
            'tagrelated' => $tagrelated,
            'path' => $full_path,
            'config' => $config,
            'id_psblog_blog' => $blog->id_psblog_blog,
            'is_active' => $blog->active,
            'productrelated' => array(),
            'module_tpl' => $module_tpl,
            'captcha_image' => $captcha_image,
            'blog_link' => $blog_link,
        );

        $vars = array_merge($vars, $evars);

        $this->context->smarty->assign($vars);

        // $this->setTemplate($template.'/blog.tpl');
        $this->setTemplate('module:psblog/views/templates/front/'.$template.'/blog.tpl');
    }
}
