<?php
/**
 *               
 * @license   GNU General Public License version 2
 */

include_once(_PS_MODULE_DIR_.'psblog/loader.php');
require_once(_PS_MODULE_DIR_.'psblog/classes/comment.php');

class AdminPsblogCommentsController extends ModuleAdminController
{
    protected $max_image_size = 1048576;
    protected $position_identifier = 'id_psblog_blog';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'psblog_comment';
//		$this->list_id = 'id_comment';		// must be set same value $this->table to delete multi rows
        $this->identifier = 'id_comment';
        $this->className = 'PsBlogComment';
        $this->lang = false;

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        if (Tools::getValue('id_psblog_blog')) {
            # validate module
            $this->_where = ' AND id_psblog_blog='.(int)Tools::getValue('id_psblog_blog');
        }
        parent::__construct();
		
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?'), 'icon' => 'icon-trash'));

        $this->fields_list = array(
            'id_comment' => array('title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'),
            'id_psblog_blog' => array('title' => $this->l('Blog ID'), 'align' => 'center', 'class' => 'fixed-width-xs'),
            'user' => array('title' => $this->l('User')),
            'comment' => array('title' => $this->l('Comment'), 'filter_key' => 'b!Comment'),
            'date_add' => array('title' => $this->l('Date Added'), 'filter_key' => 'b!data_add'),
            'active' => array('title' => $this->l('Displayed'), 'align' => 'center', 'active' => 'status', 'class' => 'fixed-width-sm', 'type' => 'bool', 'orderby' => false)
        );
    }

    public function initPageHeaderToolbar()
    {
        $link = $this->context->link;

        if (Tools::getValue('id_psblog_blog')) {
            $this->page_header_toolbar_btn['back-blog'] = array(
                'href' => $link->getAdminLink('AdminPsblogBlogs').'&updatepsblog_blog&id_psblog_blog='.Tools::getValue('id_psblog_blog'),
                'desc' => $this->l('Back To The Blog'),
                'icon' => 'icon-blog icon-3x process-icon-blog'
            );
        }
        if (Tools::getValue('id_comment')) {
            $this->page_header_toolbar_btn['save-and-stay'] = array(
                'short' => 'SaveAndStay',
                'href' => '#',
                'desc' => $this->l('Save and stay'),
            );
        }
        return parent::initPageHeaderToolbar();
    }

    public function renderForm()
    {
        if (!$this->loadObject(true)) {
            if (Validate::isLoadedObject($this->object)) {
                $this->display = 'edit';
            } else {
                $this->display = 'add';
            }
        }
        $this->initToolbar();
        $this->initPageHeaderToolbar();

        //$id_psblogcat = (int) (Tools::getValue('id_psblogcat'));
        //$obj           = new psblogcat($id_psblogcat);
        //$tree          = $obj->getTree();
        //$menus         = $obj->getDropdown(null, $obj->id_parent);

        $blog = new PsBlogBlog($this->object->id_psblog_blog, $this->context->language->id);

        $this->multiple_fieldsets = true;
        $this->object->blog_title = $blog->meta_title;

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Blog Form'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Comment ID'),
                    'name' => 'id_comment',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Blog Title'),
                    'name' => 'blog_title',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('User'),
                    'name' => 'user',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Email'),
                    'name' => 'email',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Blog Content'),
                    'name' => 'comment',
                    'rows' => 5,
                    'cols' => 40,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Displayed:'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
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
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default'
            )
        );

        $this->tpl_form_vars = array(
            'active' => $this->object->active,
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')
        );
        $html = '
					<script type="text/javascript">
						var PS_ALLOW_ACCENTED_CHARS_URL = '.(int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL').';
					</script>
			';
        return $html.parent::renderForm();
    }

    public function renderList()
    {
        $this->toolbar_title = $this->l('Comments Management');
        $this->toolbar_btn['new'] = null;

        return parent::renderList();
    }

    public function displayList($token = null)
    {
        /* Display list header (filtering, pagination and column names) */
        $this->displayListHeader($token);

        if (!count($this->_list)) {
            echo '<tr><td class="center" colspan="'.(count($this->fields_list) + 2).'">'.$this->l('No items found').'</td></tr>';
        }

        /* Show the content of the table */
        $this->displayListContent($token);

        /* Close list table and submit button */
        $this->displayListFooter($token);
    }
}
