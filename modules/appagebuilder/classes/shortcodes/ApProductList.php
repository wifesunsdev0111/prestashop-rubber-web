<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @Module Name: AP Page Builder
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

if (!defined('_PS_VERSION_')) {
    # module validation
    exit;
}

require_once( _PS_MODULE_DIR_.'appagebuilder/classes/ApPageBuilderProductsModel.php');

class ApProductList extends ApShortCodeBase
{
    public $name = 'ApProductList';
    public $for_module = 'manage';

    public function getInfo()
    {
        return array('label' => $this->l('Product List'),
            'position' => 7,
            'desc' => $this->l('Create Product List'),
            'icon_class' => 'icon icon-th',
            'tag' => 'content');
    }

    public function getAdditionConfig()
    {
        return array(
            array(
                'type' => '',
                'name' => 'select_by_categories',
                'default' => '0'
            ),
            array(
                'type' => '',
                'name' => 'select_by_product_type',
                'default' => '0'
            ),
            array(
                'type' => '',
                'name' => 'select_by_manufacture',
                'default' => '0'
            ),
            array(
                'type' => '',
                'name' => 'select_by_supplier',
                'default' => '0'
            ),
            array(
                'type' => '',
                'name' => 'select_by_product_id',
                'default' => '0'
            ),
            array(
                'type' => '',
                'name' => 'select_by_tags',
                'default' => '0'
            )
        );
    }

    public function getConfigList()
    {
        $selected_categories = array();
        if (Tools::getIsset('categorybox')) {
            $category_box = Tools::getValue('categorybox');
            $selected_categories = explode(',', $category_box);
        }
        //get all manufacture
        $manufacturers = Manufacturer::getManufacturers(false, 0, true, false, false, false, true);
        $suppliers = Supplier::getSuppliers();
//		$product_active = ApPageBuilderProductsModel::getActive();
//		$product_class = $product_active['class'];
        $profile = new ApPageBuilderProductsModel();
        $profile_list = $profile->getAllProductProfileByShop();
        //echo '<pre>';print_r($profile_list);die;
        array_unshift($profile_list, array('plist_key' => 'default', 'name' => $this->l('Use Default')));
        $id_root_category = Context::getContext()->shop->getCategory();
        $input = array(
            array(
                'type' => 'text',
                'name' => 'title',
                'label' => $this->l('Title'),
                'desc' => $this->l('Auto hide if leave it blank'), 'lang' => 'true',
                'default' => ''
            ),
            array(
                'type' => 'text',
                'name' => 'class',
                'label' => $this->l('Class'),
                'desc' => $this->l('css class'),
                'default' => ''
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 1: Product Filter').'</div>',
            ),
            array(
                'type' => 'checkbox',
                'name' => 'select_by',
                'label' => $this->l('Select By'),
                'class' => 'checkbox-group',
                'desc' => $this->l('Select Product Condition'),
                'values' => array(
                    'query' => array(
                        array(
                            'id' => 'categories',
                            'name' => $this->l('Categories'),
                            'val' => '1'
                        ),
                        array(
                            'id' => 'product_type',
                            'name' => $this->l('Product Type'),
                            'val' => '1'
                        ),
                        array(
                            'id' => 'manufacture',
                            'name' => $this->l('Manufacture'),
                            'val' => '1'
                        ),
                        array(
                            'id' => 'supplier',
                            'name' => $this->l('Supplier'),
                            'val' => '1'
                        ),
                        array(
                            'id' => 'product_id',
                            'name' => $this->l('Product Ids'),
                            'val' => '1'
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'categories',
                'label' => $this->l('Select Category'),
                'name' => 'categorybox',
                'desc' => $this->l('You can select one or more, if not select we will not search by category'),
                'tree' => array(
                    'root_category' => $id_root_category,
                    'use_search' => false,
                    'id' => 'categorybox',
                    'use_checkbox' => true,
                    'selected_categories' => $selected_categories,
                ),
                'form_group_class' => 'select_by_categories',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Product of Category'),
                'name' => 'category_type',
                'options' => array(
                    'query' => array(
                        array('id' => 'all', 'name' => $this->l('Get All Product of Category')),
                        array('id' => 'default', 'name' => $this->l('Get Product if category is default category of product'))),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'select_by_categories',
                'default' => 'all'
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="sperator"></div>',
                'form_group_class' => 'select_by_categories',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Product Type'),
                'name' => 'product_type',
                'options' => array(
                    'query' => array(
                        array(
                            'id' => 'all',
                            'name' => $this->l('All Product'),
                        ),
                        array(
                            'id' => 'new_product',
                            'name' => $this->l('New Product'),
                        ),
                        array(
                            'id' => 'best_sellers',
                            'name' => $this->l('Best sellers'),
                        ),
                        array(
                            'id' => 'price_drop',
                            'name' => $this->l('Special'),
                        ),
                        array(
                            'id' => 'home_featured',
                            'name' => $this->l('Home Featured'),
                        )
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'select_by_product_type',
                'default' => 'all',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="sperator"></div>',
                'form_group_class' => 'select_by_product_type',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Manufacture'),
                'name' => 'manufacture[]',
                'multiple' => true,
                'options' => array(
                    'query' => $manufacturers,
                    'id' => 'id_manufacturer',
                    'name' => 'name'
                ),
                'form_group_class' => 'aprow_exceptions',
                'default' => 'all',
                'form_group_class' => 'select_by_manufacture',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="sperator"></div>',
                'form_group_class' => 'select_by_manufacture',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Supplier'),
                'name' => 'supplier[]',
                'multiple' => true,
                'options' => array(
                    'query' => $suppliers,
                    'id' => 'id_supplier',
                    'name' => 'name'
                ),
                'form_group_class' => 'select_by_supplier',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="sperator"></div>',
                'form_group_class' => 'select_by_supplier',
            ),
            array(
                'type' => 'text',
                'name' => 'product_id',
                'label' => $this->l('Product Ids'),
                'desc' => $this->l('Show product follow product id. Ex 1 or 1,2,3,4 '),
                'default' => '',
                'form_group_class' => 'select_by_product_id',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="sperator"></div>',
                'form_group_class' => 'select_by_product_id',
            ),
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 2: Product Order And Limit').'</div>',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Order Way'),
                'class' => 'form-action',
                'name' => 'order_way',
                'options' => array(
                    'query' => array(
                        array('id' => 'asc', 'name' => $this->l('Asc')),
                        array('id' => 'desc', 'name' => $this->l('Desc')),
                        array('id' => 'random', 'name' => $this->l('Random'))),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => 'all'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Order By'),
                'name' => 'order_by',
                'options' => array(
                    'query' => ApPageSetting::getOrderBy(),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'order_type_sub order_type-asc order_type-desc',
                'default' => 'all'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Columns'),
                'name' => 'columns',
                'options' => array('query' => array(
                        array('id' => '1', 'name' => $this->l('1 Column')),
                        array('id' => '2', 'name' => $this->l('2 Columns')),
                        array('id' => '3', 'name' => $this->l('3 Columns')),
                        array('id' => '4', 'name' => $this->l('4 Columns')),
                        array('id' => '5', 'name' => $this->l('5 Columns')),
                        array('id' => '6', 'name' => $this->l('6 Columns')),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => '4',
            ),
            array(
                'type' => 'text',
                'name' => 'nb_products',
                'label' => $this->l('Limit'),
                'default' => '10',
            ),
            //boostrap carousel end
            array(
                'type' => 'html',
                'name' => 'default_html',
                'html_content' => '<div class="alert alert-info">'.$this->l('Step 3: Product Template').'</div>',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Product Template'),
                'name' => 'profile',
                'options' => array(
                    'query' => $profile_list,
                    'id' => 'plist_key',
                    'name' => 'name'
                ),
                'default' => 'all'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Use Show More button'),
                'name' => 'use_showmore',
                'desc' => $this->l('Show button to load more product or hidden this function'),
                'values' => ApPageSetting::returnYesNo(),
                'default' => '1'
            )
        );
        return $input;
    }

    public function prepareFontContent($assign, $module = null)
    {
        // validate module
        unset($module);
        $form_atts = $assign['formAtts'];
        $n = (int)isset($form_atts['nb_products']) ? $form_atts['nb_products'] : '10';
        $p = (int)Tools::getIsset('p') ? Tools::getValue('p') : '1';
        $form_atts['page_number'] = $p;
        $form_atts['get_total'] = true;
        $module_temp = new APPageBuilder();
        $total = $module_temp->getProductsFont($form_atts);
        $total = (is_array($total) && count($total) > 0) ? count($total) : 0;
        $total_page = (int)$total / $n + ($total % $n == 0 ? 0 : 1);

        $is_more = $p < $total_page ? 'more' : '';
        $products = array();
        if ($p <= $total_page) {
            $form_atts['get_total'] = false;
            $products = $module_temp->getProductsFont($form_atts);
        }
        $assign['profile'] = (isset($form_atts['profile']) && $form_atts['profile'] != 'default') ? $form_atts['profile'] : '';
        $assign['scolumn'] = $form_atts['columns'];
        $assign['products'] = $products;
        $assign['is_more'] = $is_more;
        $assign['p'] = $p + 1;
        $assign['apPConfig'] = Tools::jsonEncode($form_atts);
        $assign['productClassWidget'] = $this->getProductClassByPListKey($assign['profile']);

        //auto copy when install
        $assign['product_item_path'] = $this->getDirOfFile('sub/product-item/', 'product-item.tpl', 'views/templates/front/product-item/');

        return $assign;
    }

    public function ajaxProcessRender($module)
    {
        $hooks_tpl_path = _PS_MODULE_DIR_.'appagebuilder/views/templates/hook/';
        $assign = array();
        $params = array();
        $input = Tools::jsonDecode(Tools::getValue('config'));
        $n = (int)isset($input->nb_products) ? $input->nb_products : '10';
        $p = (int)Tools::getIsset('p') ? Tools::getValue('p') : '1';
        $params['select_by_categories'] = isset($input->select_by_categories) ? $input->select_by_categories : '0';
        $params['select_by_product_type'] = isset($input->select_by_product_type) ? $input->select_by_product_type : '0';
        $params['select_by_manufacture'] = isset($input->select_by_manufacture) ? $input->select_by_manufacture : '0';
        $params['select_by_supplier'] = isset($input->select_by_supplier) ? $input->select_by_supplier : '0';
        $params['categorybox'] = isset($input->categorybox) ? $input->categorybox : '';
        $params['category_type'] = isset($input->category_type) ? $input->category_type : '';
        $params['product_type'] = isset($input->product_type) ? $input->product_type : '';
        $params['manufacture'] = isset($input->manufacture) ? $input->manufacture : '';
        $params['supplier'] = isset($input->supplier) ? $input->supplier : '';
        $params['nb_products'] = $n;
        $params['page_number'] = $p;
        $params['order_by'] = isset($input->order_by) ? $input->order_by : '';
        $params['order_way'] = isset($input->order_way) ? $input->order_way : '';
        $params['get_total'] = true;
        $total = $module->getProductsFont($params);
        $total = (is_array($total) && count($total) > 0) ? count($total) : 0;
        $total_page = ceil(($total / $n));
        $is_more = ($p < $total_page) ? 'more' : '';
        $products = array();
        if ($p <= $total_page) {
            $params['get_total'] = false;
            $products = $module->getProductsFont($params);
        }
        $assign['profile'] = (isset($input->profile) && $input->profile != 'default') ? $input->profile : '';
        $assign['products'] = $products;
        $assign['apAjax'] = 1;
        $assign['scolumn'] = $input->columns;
        $assign['product_item_path'] = $this->getDirOfFile('sub/product-item/', 'product-item.tpl', 'views/templates/front/product-item/');
        $html = $module->ajaxProccessFetch($assign, $hooks_tpl_path.'ApProductList.tpl');
        return array('html' => $html, 'is_more' => $is_more);
    }
}
