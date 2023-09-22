<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__bbf6e61e67546da5a46a80332ff2aba0ef06886f90b53da9fcf494ab82ec1e50 */
class __TwigTemplate_da742cea2fb67f9e24a3e53c8623b2faabda2882d715c06ac46cc7e37c5faf0d extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'extra_stylesheets' => [$this, 'block_extra_stylesheets'],
            'content_header' => [$this, 'block_content_header'],
            'content' => [$this, 'block_content'],
            'content_footer' => [$this, 'block_content_footer'],
            'sidebar_right' => [$this, 'block_sidebar_right'],
            'javascripts' => [$this, 'block_javascripts'],
            'extra_javascripts' => [$this, 'block_extra_javascripts'],
            'translate_javascripts' => [$this, 'block_translate_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>Products • Rubberfun</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminProducts';
    var iso_user = 'en';
    var lang_is_rtl = '0';
    var full_language_code = 'en-US';
    var full_cldr_language_code = 'en-US';
    var country_iso_code = 'NL';
    var _PS_VERSION_ = '1.7.8.8';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'A new order has been placed on your shop.';
    var order_number_msg = 'Order number: ';
    var total_msg = 'Total: ';
    var from_msg = 'From: ';
    var see_order_msg = 'View this order';
    var new_customer_msg = 'A new customer registered on your shop.';
    var customer_name_msg = 'Customer name: ';
    var new_msg = 'A new message was posted on your shop.';
    var see_msg = 'Read this message';
    var token = '1b48fa58a15eac2e6ac9820b50b7fc8e';
    var token_admin_orders = tokenAdminOrders = 'c31590a705e2508385050a4446ad6415';
    var token_admin_customers = '897e1690aa2d9d15230ced8270ee2820';
    var token_admin_customer_threads = tokenAdminCustomerThreads = '665afc3accc4570c9077ecf4789464f6';
    var currentIndex = 'index.php?controller=AdminProducts';
    var employee_token = '0136065e35974d9ff10a59fb127b3b48';
    var choose_language_translate = 'Choose language:';
    var default_language = '1';
    var admin_modules_link = '/Backoffice/index.php/improve/modules/catalog/recommended?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y';
    var admin_notification_get_link = '/Backoffice/index.php/common/notifications?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y';
    var admin_notification_push_link =";
        // line 43
        echo " adminNotificationPushLink = '/Backoffice/index.php/common/notifications/ack?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y';
    var tab_modules_list = '';
    var update_success_msg = 'Update successful';
    var errorLogin = 'PrestaShop was unable to log in to Addons. Please check your credentials and your Internet connection.';
    var search_product_msg = 'Search for a product';
  </script>

      <link href=\"/Backoffice/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/blockwishlist/public/backoffice.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/appagebuilder/views/css/admin/style.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/psblog/views/css/admin/blogmenu.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ets_htmlbox/views/css/admin_all.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/hipay_enterprise/views/css/bootstrap-duallistbox.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/hipay_enterprise/views/css/bootstrap-multiselect.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/hipay_enterprise/views/css/back.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/Backoffice\\/\";
var baseDir = \"\\/\";
var changeFormLanguageUrl = \"\\/Backoffice\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":null};
var currency_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"EUR\",\"currencySymbol\":\"\\u20ac\",\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"]";
        // line 66
        echo ",\"positivePattern\":\"\\u00a4#,##0.00\",\"negativePattern\":\"-\\u00a4#,##0.00\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":false};
var show_new_customers = \"1\";
var show_new_messages = \"1\";
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/Backoffice/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/js/admin.js?v=1.7.8.8\"></script>
<script type=\"text/javascript\" src=\"/Backoffice/themes/new-theme/public/cldr.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/tools.js?v=1.7.8.8\"></script>
<script type=\"text/javascript\" src=\"/modules/blockwishlist/public/vendors.js\"></script>
<script type=\"text/javascript\" src=\"/modules/appagebuilder/views/js/admin/setting.js\"></script>
<script type=\"text/javascript\" src=\"/modules/hipay_enterprise/views/js/form-input-control.js\"></script>
<script type=\"text/javascript\" src=\"/modules/hipay_enterprise/views/js/md5.js\"></script>

  <script>
            var admin_gamification_ajax_url = \"https:\\/\\/demo.rubberfun.nl\\/Backoffice\\/index.php?controller=AdminGamification&token=648b2d6170dbfbb3c7799ed525c16ba0\";
            var current_id_tab = 145;
        </script>

";
        // line 90
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>";
        echo "

<body
  class=\"lang-en adminproducts\"
  data-base-url=\"/Backoffice/index.php\"  data-token=\"PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\">

  <header id=\"header\" class=\"d-print-none\">

    <nav id=\"header_infos\" class=\"main-header\">
      <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

            <i class=\"material-icons js-mobile-menu\">menu</i>
      <a id=\"header_logo\" class=\"logo float-left\" href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminDashboard&amp;token=a42795761ab1ddab66ff4a21ca6f88b7\"></a>
      <span id=\"shop_version\">1.7.8.8</span>

      <div class=\"component\" id=\"quick-access-container\">
        <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Quick Access
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminProducts&amp;submitFilterproduct=1&amp;token=1b48fa58a15eac2e6ac9820b50b7fc8e\"
                 data-item=\"55\"
      >55</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=69d20624871b602c9d40f66f3dba34aa\"
                 data-item=\"Catalog evaluation\"
      >Catalog evaluation</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCustomerThreads&amp;token=665afc3accc4570c9077ecf4789464f6\"
                 data-item=\"Customer Service > List\"
      >Customer Service > List</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCategories&amp;addcategory&amp;token=2b3c8bf44179abbc2ec60291e154cd2a\"
                 data-item=\"New category\"
      >New category</a>";
        // line 126
        echo "
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php/sell/catalog/products/new?token=f39707bed10fecace9d358e853645a8b\"
                 data-item=\"New product\"
      >New product</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=e681eb5c588d36afeb5a8d2bba840186\"
                 data-item=\"New voucher\"
      >New voucher</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminOrders&amp;token=c31590a705e2508385050a4446ad6415\"
                 data-item=\"Orders > List\"
      >Orders > List</a>
        <div class=\"dropdown-divider\"></div>
          <a id=\"quick-add-link\"
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"119\"
        data-icon=\"icon-AdminCatalog\"
        data-method=\"add\"
        data-url=\"index.php/sell/catalog/products\"
        data-post-link=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminQuickAccesses&token=f98e0f6c903867277fd0584b4d90f5d3\"
        data-prompt-text=\"Please name this shortcut:\"
        data-link=\"Products - List\"
      >
        <i class=\"material-icons\">add_circle</i>
        Add current page to Quick Access
      </a>
        <a id=\"quick-manage-link\" class=\"dropdown-item\" href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminQuickAccesses&token=f98e0f6c903867277fd0584b4d90f5d3\">
      <i class=\"material-icons\">settings</i>
      Manage your quick accesses
    </a>
  </div>
</div>
      </div>
      <div class=\"component\" id=\"header-search-container\">
        <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/Backoffice/index.php?controller=AdminSearch&amp;token=3852c2e2bd7c09afd8ec9f4a8bd8cc87\"
      role=\"search\">
  <input type=\"hidden\" name";
        // line 167
        echo "=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Search (e.g.: product reference, customer name…)\" aria-label=\"Searchbar\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Everywhere
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Everywhere\" href=\"#\" data-value=\"0\" data-placeholder=\"What are you looking for?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Everywhere</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalog\" href=\"#\" data-value=\"1\" data-placeholder=\"Product name, reference, etc.\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalog</a>
        <a class=\"dropdown-item\" data-item=\"Customers by name\" href=\"#\" data-value=\"2\" data-placeholder=\"Name\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Customers by name</a>
        <a class=\"dropdown-item\" data-item=\"Customers by ip address\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Customers by IP address</a>
        <a class=\"dropdown-item\" data-item=\"Orders\" href=\"#\" data-value=\"3\" data-placeholder=\"Order ID\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Orders</a>
        <a class=\"dropdown-item\" data-item=\"Invoices\" href=\"#\" data-value=\"4\" data-placeholder=\"Invoice number\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i> Invoices</a>
        <a class=\"dropdown-item\" data-item=\"Carts\" href=\"#\" data-value=\"5\" data-placeholder=\"Cart ID\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carts</a>
       ";
        // line 183
        echo " <a class=\"dropdown-item\" data-item=\"Modules\" href=\"#\" data-value=\"7\" data-placeholder=\"Module name\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Modules</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">SEARCH</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

      
      
              <div class=\"component\" id=\"header-shop-list-container\">
            <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"https://demo.rubberfun.nl/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      <span>View my shop</span>
    </a>
  </div>
        </div>
                    <div class=\"component header-right-component\" id=\"header-notifications-container\">
          <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Orders<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"";
        // line 235
        echo "
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Customers<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
              href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messages<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new order for now :(<br>
              Have you checked your <strong><a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=f250eac215f359493f71083642884532\">abandoned carts</a></strong>?<br>Your next order could be hiding there!
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new customer for now :(<br>
              Are you active on social media these days?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new message for now.<br>
              Seems like all your customers are happy :)
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a";
        // line 285
        echo " class=\"notif\" href='order_url'>
      #_id_order_ -
      from <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registered <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
        </div>
      
      <div class=\"component\" id=\"header-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">

      <span class=\"employee-avatar\"><img class=\"avatar rounded-circle\" src=\"https://demo.rubberfun.nl/img/pr/default.jpg\" /></span>
      <span class=\"employee_profile\">Welcome back Nitin</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/Backoffice/index.php/configure/advanced/employees/12/edit?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\">
      <i class=\"material-icons\">edit</i>
      <span>Your profile</span>
    </a>
    </div>

    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">book</i> Resources</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=ba";
        // line 326
        echo "ck-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">school</i> Training</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">person_pin_circle</i> Find an Expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">extension</i> PrestaShop Marketplace</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">help</i> Help Center</a>
    <p class=\"divider\"></p>
    <a class=\"dropdown-item employee-link text-center\" id=\"header_logout\" href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminLogin&amp;logout=1&amp;token=4130f2c9c83da9dd001992ebf5359dab\">
      <i class=\"material-icons d-lg-none\">power_settings_new</i>
      <span>Sign out</span>
    </a>
  </div>
</div>
      </div>
          </nav>
  </header>

  <nav class=\"nav-bar d-none d-print-none d-md-block\">
  <span class=\"menu-collapse\" data-toggle-url=\"/Backoffice/index.php/configure/advanced/employees/toggle-navigation?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <div class=\"nav-bar-overflow\">
      <ul class=\"main-menu\">
              
                    
                    
          
            <li class=\"link-levelone\" data-submenu=\"136\" id=\"tab-AdminDashboard\">
              <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminD";
        // line 354
        echo "ashboard&amp;token=a42795761ab1ddab66ff4a21ca6f88b7\" class=\"link\" >
                <i class=\"material-icons\">trending_up</i> <span>Dashboard</span>
              </a>
            </li>

          
                      
                                          
                    
          
            <li class=\"category-title link-active\" data-submenu=\"137\" id=\"tab-SELL\">
                <span class=\"title\">Sell</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"138\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/Backoffice/index.php/sell/orders/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                      <span>
                      Orders
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-138\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"139\" id=\"subtab-AdminOrders\">
                                <a href=\"/Backoffice/index.php/sell/orders/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Orders
                                </a>
                              </li>

                                                                                  
                              
                                     ";
        // line 393
        echo "                       
                              <li class=\"link-leveltwo\" data-submenu=\"140\" id=\"subtab-AdminInvoices\">
                                <a href=\"/Backoffice/index.php/sell/orders/invoices/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Invoices
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"141\" id=\"subtab-AdminSlip\">
                                <a href=\"/Backoffice/index.php/sell/orders/credit-slips/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Credit Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"142\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/Backoffice/index.php/sell/orders/delivery-slips/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Delivery Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"143\" id=\"subtab-AdminCarts\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCarts&amp;token=f250eac215f359493f71083642884532\" class=\"link\"> Shopping Carts
                                </a>
                              </li>

                                                                   ";
        // line 423
        echo "           </ul>
                                        </li>
                                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu link-active open ul-open\" data-submenu=\"144\" id=\"subtab-AdminCatalog\">
                    <a href=\"/Backoffice/index.php/sell/catalog/products?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-store\">store</i>
                      <span>
                      Catalog
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-144\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo link-active\" data-submenu=\"145\" id=\"subtab-AdminProducts\">
                                <a href=\"/Backoffice/index.php/sell/catalog/products?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Products
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"146\" id=\"subtab-AdminCategories\">
                                <a href=\"/Backoffice/index.php/sell/catalog/categories?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Categories
    ";
        // line 453
        echo "                            </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"147\" id=\"subtab-AdminTracking\">
                                <a href=\"/Backoffice/index.php/sell/catalog/monitoring/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Monitoring
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"148\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminAttributesGroups&amp;token=d1177e2445f53573de0d62fde0c8e7cd\" class=\"link\"> Attributes &amp; Features
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"151\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/Backoffice/index.php/sell/catalog/brands/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Brands &amp; Suppliers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"154\" id=\"subtab-AdminAttachments\">
                             ";
        // line 484
        echo "   <a href=\"/Backoffice/index.php/sell/attachments/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Files
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"155\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCartRules&amp;token=e681eb5c588d36afeb5a8d2bba840186\" class=\"link\"> Discounts
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"158\" id=\"subtab-AdminStockManagement\">
                                <a href=\"/Backoffice/index.php/sell/stocks/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Stocks
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"159\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/Backoffice/index.php/sell/customers/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-account_circle\">account_circle</i>
                      <span>
                      Customers
                      </span>
                                                    <i class=\"materi";
        // line 516
        echo "al-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-159\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"160\" id=\"subtab-AdminCustomers\">
                                <a href=\"/Backoffice/index.php/sell/customers/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Customers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"161\" id=\"subtab-AdminAddresses\">
                                <a href=\"/Backoffice/index.php/sell/addresses/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Addresses
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"163\" id=\"subtab-AdminParentCustomerThreads\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCustomerThreads&amp;token=665afc3accc4570c9077ecf4789464f6\" class=\"link\">
                      <i class=\"material-icons mi-chat\">chat</i>
                ";
        // line 546
        echo "      <span>
                      Customer Service
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-163\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"164\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCustomerThreads&amp;token=665afc3accc4570c9077ecf4789464f6\" class=\"link\"> Customer Service
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"165\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/Backoffice/index.php/sell/customer-service/order-messages/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Order Messages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"166\" id=\"subtab-AdminReturn\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminReturn&amp;token=fdbba2b078ba7d4aa0dc318c0e74e8ab\" class=\"link\"> Merchandise Retu";
        // line 574
        echo "rns
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"167\" id=\"subtab-AdminStats\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminStats&amp;token=69d20624871b602c9d40f66f3dba34aa\" class=\"link\">
                      <i class=\"material-icons mi-assessment\">assessment</i>
                      <span>
                      Stats
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                                            
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"177\" id=\"tab-IMPROVE\">
                <span class=\"title\">Improve</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"178\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/Backoffice/index.php/improve/modules/manage?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                  ";
        // line 615
        echo "  <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-178\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"179\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/Backoffice/index.php/improve/modules/manage?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Module Manager
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"183\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/Backoffice/index.php/improve/modules/catalog?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Module Catalog
                                </a>
                              </li>

                                                                                                                                                                                          </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"187\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/Backoffice/index.php/improve/design/themes/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
        ";
        // line 644
        echo "              <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                      Design
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-187\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"188\" id=\"subtab-AdminThemes\">
                                <a href=\"/Backoffice/index.php/improve/design/themes/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Theme &amp; Logo
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"189\" id=\"subtab-AdminThemesCatalog\">
                                <a href=\"/Backoffice/index.php/improve/design/themes-catalog/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Theme Catalog
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"190\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/Backoffice/index.php/improve/design/mail_theme/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\"";
        // line 673
        echo " class=\"link\"> Email Theme
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"192\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/Backoffice/index.php/improve/design/cms-pages/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"193\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/Backoffice/index.php/improve/design/modules/positions/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"194\" id=\"subtab-AdminImages\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminImages&amp;token=41f139adc46863ff7ea963630dd23d96\" class=\"link\"> Image Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"261\" id=\"subtab-AdminLinkWidget\">
                                <a href=\"";
        // line 705
        echo "/Backoffice/index.php/modules/link-widget/list?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Link List
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"195\" id=\"subtab-AdminParentShipping\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCarriers&amp;token=0ef2da933a9956ca973b2d2009e4e790\" class=\"link\">
                      <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                      <span>
                      Shipping
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-195\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"196\" id=\"subtab-AdminCarriers\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminCarriers&amp;token=0ef2da933a9956ca973b2d2009e4e790\" class=\"link\"> Carriers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                 ";
        // line 737
        echo "             <li class=\"link-leveltwo\" data-submenu=\"197\" id=\"subtab-AdminShipping\">
                                <a href=\"/Backoffice/index.php/improve/shipping/preferences/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"322\" id=\"subtab-AdminSendcloud\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminSendcloud&amp;token=f77776b4632e83f7ed5dec825c11ca45\" class=\"link\"> Sendcloud
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"198\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/Backoffice/index.php/improve/payment/payment_methods?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-payment\">payment</i>
                      <span>
                      Payment
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-198\" class=\"submenu panel-collapse\">
                                                      ";
        // line 767
        echo "
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"199\" id=\"subtab-AdminPayment\">
                                <a href=\"/Backoffice/index.php/improve/payment/payment_methods?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Payment Methods
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"200\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/Backoffice/index.php/improve/payment/preferences?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"201\" id=\"subtab-AdminInternational\">
                    <a href=\"/Backoffice/index.php/improve/international/localization/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                               ";
        // line 799
        echo "               <ul id=\"collapse-201\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"202\" id=\"subtab-AdminParentLocalization\">
                                <a href=\"/Backoffice/index.php/improve/international/localization/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Localization
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"207\" id=\"subtab-AdminParentCountries\">
                                <a href=\"/Backoffice/index.php/improve/international/zones/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Locations
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"211\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/Backoffice/index.php/improve/international/taxes/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"214\" id=\"subtab-AdminTranslations\">
                                <a href=\"/Backoffice/index.php/improve/international/translatio";
        // line 828
        echo "ns/settings?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Translations
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"215\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configure</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"216\" id=\"subtab-ShopParameters\">
                    <a href=\"/Backoffice/index.php/configure/shop/preferences/preferences?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-settings\">settings</i>
                      <span>
                      Shop Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-216\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"217\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/Backoffice/index.php/configure/shop/preferences/preferences?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> General
                                ";
        // line 864
        echo "</a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"220\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/Backoffice/index.php/configure/shop/order-preferences/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Order Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"223\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/Backoffice/index.php/configure/shop/product-preferences/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Product Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"224\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/Backoffice/index.php/configure/shop/customer-preferences/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Customer Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"228\" id=\"subtab-AdminParentStores\">
                                <a href=\"/Bac";
        // line 895
        echo "koffice/index.php/configure/shop/contacts/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"231\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/Backoffice/index.php/configure/shop/seo-urls/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Traffic &amp; SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"235\" id=\"subtab-AdminParentSearchConf\">
                                <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminSearchConf&amp;token=91b17e8901c4d6a49c8f3ae3d2175372\" class=\"link\"> Search
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"238\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/Backoffice/index.php/configure/advanced/system-information/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Advanced Parameters
                      </span>
       ";
        // line 927
        echo "                                             <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-238\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"239\" id=\"subtab-AdminInformation\">
                                <a href=\"/Backoffice/index.php/configure/advanced/system-information/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Information
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"240\" id=\"subtab-AdminPerformance\">
                                <a href=\"/Backoffice/index.php/configure/advanced/performance/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Performance
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"241\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/Backoffice/index.php/configure/advanced/administration/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Administration
                                </a>
                              </li>

                                        ";
        // line 956
        echo "                                          
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"242\" id=\"subtab-AdminEmails\">
                                <a href=\"/Backoffice/index.php/configure/advanced/emails/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> E-mail
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"243\" id=\"subtab-AdminImport\">
                                <a href=\"/Backoffice/index.php/configure/advanced/import/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Import
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"244\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/Backoffice/index.php/configure/advanced/employees/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Team
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"248\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/Backoffice/index.php/configure/advanced/sql-requests/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Database
                                </a>
 ";
        // line 986
        echo "                             </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"251\" id=\"subtab-AdminLogs\">
                                <a href=\"/Backoffice/index.php/configure/advanced/logs/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Logs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"252\" id=\"subtab-AdminWebservice\">
                                <a href=\"/Backoffice/index.php/configure/advanced/webservice-keys/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                              
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"255\" id=\"subtab-AdminFeatureFlag\">
                                <a href=\"/Backoffice/index.php/configure/advanced/feature-flags/?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" class=\"link\"> Experimental Features
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            ";
        // line 1020
        echo "<li class=\"category-title\" data-submenu=\"119\" id=\"tab-AdminApPageBuilder\">
                <span class=\"title\">Ap PageBuilder</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"120\" id=\"subtab-AdminApPageBuilderProfiles\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminApPageBuilderProfiles&amp;token=afd48e16f4dd43fef3066105a51f1282\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Ap Profiles Manage
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"121\" id=\"subtab-AdminApPageBuilderPositions\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminApPageBuilderPositions&amp;token=8cb855f13cb81e433003f6f6b7d7bae1\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Ap Positions Manage
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </l";
        // line 1053
        echo "i>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"123\" id=\"subtab-AdminApPageBuilderProducts\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminApPageBuilderProducts&amp;token=bc94220ffcea80f5b20520c6c3149ed0\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Ap Products List Builder
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"124\" id=\"subtab-AdminApPageBuilderModule\">
                    <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminApPageBuilderModule&amp;token=7dc112037ddb84943c13c37e0f2e6720\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Ap Page Builder Configuration
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                  </ul>
  </div>
  
</nav>


<div class=\"header-toolbar d-prin";
        // line 1092
        echo "t-none\">
    
  <div class=\"container-fluid\">

    
      <nav aria-label=\"Breadcrumb\">
        <ol class=\"breadcrumb\">
                      <li class=\"breadcrumb-item\">Catalog</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/Backoffice/index.php/sell/catalog/products?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\" aria-current=\"page\">Products</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            Products          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                          <a
                  class=\"btn btn-primary pointer\"                  id=\"page-header-desc-configuration-add\"
                  href=\"/Backoffice/index.php/sell/catalog/products/new?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\"                  title=\"Create a new product: CTRL+P\"                  data-toggle=\"pstooltip\"
                  data-placement=\"bottom\"                >
                  <i class=\"material-icons\">add_circle_outline</i>                  New product
                </a>
                                      
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Help\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/Backoffice/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminProducts%253Fversion%253D1.7.8.8%2526country%253Den/Help?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\"
                   id=\"product_form_open_help\"
                >
                  Help
                </a>
                                    </div>
        </div>

      
    </div>
  </div>

  
  
  <div class=\"btn-floating\">
    <button class=\"btn btn-primary c";
        // line 1145
        echo "ollapsed\" data-toggle=\"collapse\" data-target=\".btn-floating-container\" aria-expanded=\"false\">
      <i class=\"material-icons\">add</i>
    </button>
    <div class=\"btn-floating-container collapse\">
      <div class=\"btn-floating-menu\">
        
                              <a
              class=\"btn btn-floating-item  pointer\"              id=\"page-header-desc-floating-configuration-add\"
              href=\"/Backoffice/index.php/sell/catalog/products/new?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\"              title=\"Create a new product: CTRL+P\"              data-toggle=\"pstooltip\"
              data-placement=\"bottom\"            >
              New product
              <i class=\"material-icons\">add_circle_outline</i>            </a>
                  
                              <a class=\"btn btn-floating-item btn-help btn-sidebar\" href=\"#\"
               title=\"Help\"
               data-toggle=\"sidebar\"
               data-target=\"#right-sidebar\"
               data-url=\"/Backoffice/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminProducts%253Fversion%253D1.7.8.8%2526country%253Den/Help?_token=PCUyDSegFoIIBt5Uw_i_W5TwlI_ewJ3SkWjpUZB1_7Y\"
            >
              Help
            </a>
                        </div>
    </div>
  </div>
  
</div>

<div id=\"main-div\">
          
      <div class=\"content-div  \">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1184
        $this->displayBlock('content_header', $context, $blocks);
        $this->displayBlock('content', $context, $blocks);
        $this->displayBlock('content_footer', $context, $blocks);
        $this->displayBlock('sidebar_right', $context, $blocks);
        echo "

            
          </div>
        </div>

      </div>
    </div>

  <div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh no!</h1>
  <p class=\"mt-3\">
    The mobile version of this page is not available yet.
  </p>
  <p class=\"mt-2\">
    Please use a desktop computer to access this page, until is adapted to mobile.
  </p>
  <p class=\"mt-2\">
    Thank you.
  </p>
  <a href=\"https://demo.rubberfun.nl/Backoffice/index.php?controller=AdminDashboard&amp;token=a42795761ab1ddab66ff4a21ca6f88b7\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Back
  </a>
</div>
  <div class=\"mobile-layer\"></div>

      <div id=\"footer\" class=\"bootstrap\">
    
</div>
  

      <div class=\"bootstrap\">
      <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-EN&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/en/login?email=fortecsolutionwork%40gmail.com&amp;firstname=Nitin&amp;lastname=Gohal&amp;website=http%3A%2F%2Fdemo.rubberfun.nl%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/Backoffice/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Connect your shop to PrestaShop's marketplace in order to automatically import all your Addons purchases.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col";
        // line 1234
        echo "-md-6\">
\t\t\t\t\t\t<h4>Don't have an account?</h4>
\t\t\t\t\t\t<p class='text-justify'>Discover the Power of PrestaShop Addons! Explore the PrestaShop Official Marketplace and find over 3 500 innovative modules and themes that optimize conversion rates, increase traffic, build customer loyalty and maximize your productivity</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Connect to PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/en/forgot-your-password\">I forgot my password</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/en/login?email=fortecsolutionwork%40gmail.com&amp;firstname=Nitin&amp;lastname=Gohal&amp;website=http%3A%2F%2Fdemo.rubberfun.nl%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCreate an Account
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i cla";
        // line 1273
        echo "ss=\"icon-unlock\"></i> Sign in
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

    </div>
  
";
        // line 1292
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>";
        echo "
</html>";
    }

    // line 90
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
    }

    // line 1184
    public function block_content_header($context, array $blocks = [])
    {
    }

    public function block_content($context, array $blocks = [])
    {
    }

    public function block_content_footer($context, array $blocks = [])
    {
    }

    public function block_sidebar_right($context, array $blocks = [])
    {
    }

    // line 1292
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "__string_template__bbf6e61e67546da5a46a80332ff2aba0ef06886f90b53da9fcf494ab82ec1e50";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1448 => 1292,  1431 => 1184,  1422 => 90,  1413 => 1292,  1392 => 1273,  1351 => 1234,  1295 => 1184,  1254 => 1145,  1199 => 1092,  1158 => 1053,  1123 => 1020,  1087 => 986,  1055 => 956,  1024 => 927,  990 => 895,  957 => 864,  919 => 828,  888 => 799,  854 => 767,  822 => 737,  788 => 705,  754 => 673,  723 => 644,  692 => 615,  649 => 574,  619 => 546,  587 => 516,  553 => 484,  520 => 453,  488 => 423,  456 => 393,  415 => 354,  385 => 326,  342 => 285,  290 => 235,  236 => 183,  218 => 167,  175 => 126,  134 => 90,  108 => 66,  83 => 43,  39 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__bbf6e61e67546da5a46a80332ff2aba0ef06886f90b53da9fcf494ab82ec1e50", "");
    }
}
