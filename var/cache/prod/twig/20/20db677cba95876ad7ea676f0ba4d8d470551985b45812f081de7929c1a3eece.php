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

/* @Product/ProductPage/Blocks/footer.html.twig */
class __TwigTemplate_18ac4d0831ff9df363fb2159841f21735fe607bebdd37d3ac62a8ef2b175f466 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'product_footer' => [$this, 'block_product_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        $this->displayBlock('product_footer', $context, $blocks);
    }

    public function block_product_footer($context, array $blocks = [])
    {
        // line 26
        echo "  <div class=\"product-footer justify-content-md-center\">
    <div class=\"col-lg-4\">
      <a
        href=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_unit_action", ["action" => "delete", "id" => ($context["productId"] ?? null)]), "html", null, true);
        echo "\"
        class=\"tooltip-link btn btn-lg delete\"
        data-toggle=\"pstooltip\"
        id=\"product_form_delete_btn\"
        title=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Permanently delete this product.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
        data-placement=\"left\"
        data-original-title=\"Delete\"
      >
        <i class=\"material-icons\">delete</i>
      </a>
      <a
        href=\"\"
        data-seo-url=\"";
        // line 41
        echo twig_escape_filter($this->env, ($context["seo_link"] ?? null), "html", null, true);
        echo "\"
        data-redirect=\"";
        // line 42
        echo twig_escape_filter($this->env, ($context["preview_link"] ?? null), "html", null, true);
        echo "\"
        data-url-deactive=\"";
        // line 43
        echo twig_escape_filter($this->env, ($context["preview_link_deactivate"] ?? null), "html", null, true);
        echo "\"
        target=\"_blank\"
        class=\"btn btn-secondary preview\"
        data-toggle=\"pstooltip\"
        id=\"product_form_preview_btn\"
        title=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("See how your product sheet will look online: ALT+SHIFT+V", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
      >
        ";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Preview", [], "Admin.Actions"), "html", null, true);
        echo "
      </a>
      ";
        // line 52
        if (($context["editable"] ?? null)) {
            // line 53
            echo "        <h2 class=\"for-switch online-title\" ";
            if ( !($context["is_active"] ?? null)) {
                echo "style=\"display:none;\"";
            }
            echo " data-toggle=\"pstooltip\"
          title=\"";
            // line 54
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable or disable the product on your shop: ALT+SHIFT+O", [], "Admin.Catalog.Help"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Online", [], "Admin.Global"), "html", null, true);
            echo "</h2>
        <h2 class=\"for-switch offline-title\" ";
            // line 55
            if (($context["is_active"] ?? null)) {
                echo "style=\"display:none;\"";
            }
            echo " data-toggle=\"pstooltip\"
          title=\"";
            // line 56
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable or disable the product on your shop: ALT+SHIFT+O", [], "Admin.Catalog.Help"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Offline", [], "Admin.Global"), "html", null, true);
            echo "</h2>
        <input
          class=\"switch-input-lg\"
          id=\"form_step1_active\"
          data-toggle=\"switch\"
          type=\"checkbox\"
          name=\"form[step1][active]\"
          value=\"1\"
          ";
            // line 64
            echo ((($context["is_active"] ?? null)) ? ("checked=\"checked\"") : (""));
            echo "
        />
      ";
        }
        // line 67
        echo "    </div>
    <div class=\"col-sm-5 col-lg-7 text-right\">
      <input
        id=\"submit\"
        type=\"submit\"
        class=\"btn btn-primary save uppercase ml-3\"
        value=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "\"
        data-toggle=\"pstooltip\"
        title=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save the product and stay on the current page: ALT+SHIFT+S", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
      />
      ";
        // line 77
        if (($context["is_shop_context"] ?? null)) {
            // line 78
            echo "        <button
          type=\"button\"
          class=\"btn btn-outline-secondary btn-submit hidden-xs uppercase duplicate ml-3\"
          id=\"product_form_save_duplicate_btn\"
          data-redirect=\"";
            // line 82
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_unit_action", ["action" => "duplicate", "id" => ($context["productId"] ?? null)]), "html", null, true);
            echo "\"
          data-toggle=\"pstooltip\"
          title=\"";
            // line 84
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save and duplicate this product, then go to the new product: ALT+SHIFT+D", [], "Admin.Catalog.Help"), "html", null, true);
            echo "\"
        >
          ";
            // line 86
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Duplicate", [], "Admin.Actions");
            echo "
        </button>
      ";
        }
        // line 89
        echo "      <button
        type=\"button\"
        class=\"btn btn-outline-secondary btn-submit hidden-xs uppercase go-catalog ml-3\"
        id=\"product_form_save_go_to_catalog_btn\"
        data-redirect=\"";
        // line 93
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_catalog", ["offset" => "last", "limit" => "last"]), "html", null, true);
        echo "\"
        data-toggle=\"pstooltip\"
        title=\"";
        // line 95
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save and go back to the catalog: ALT+SHIFT+Q", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
      >
        ";
        // line 97
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Go to catalog", [], "Admin.Catalog.Feature");
        echo "
      </button>
      <button
        type=\"button\"
        class=\"btn btn-outline-secondary btn-submit hidden-xs uppercase new-product ml-3\"
        id=\"product_form_save_new_btn\"
        data-redirect=\"";
        // line 103
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_new");
        echo "\"
        data-toggle=\"pstooltip\"
        title=\"";
        // line 105
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save and create a new product: ALT+SHIFT+P", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
      >
        ";
        // line 107
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Add new product", [], "Admin.Catalog.Feature");
        echo "
      </button>
      ";
        // line 109
        if (((($context["isProductPageV2Enabled"] ?? null) == true) && (($context["isCreationMode"] ?? null) === true))) {
            // line 110
            echo "        <a
          class=\"btn btn-outline-primary ml-3\"
          href=\"";
            // line 112
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_products_v2_create");
            echo "\"
        >
          ";
            // line 114
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("New product on experimental page", [], "Admin.Catalog.Feature");
            echo "
        </a>
      ";
        }
        // line 117
        echo "      ";
        if (((($context["isProductPageV2Enabled"] ?? null) == true) && (($context["isCreationMode"] ?? null) === false))) {
            // line 118
            echo "        <a
          class=\"btn btn-outline-primary ml-3\"
          href=\"";
            // line 120
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_products_v2_edit", ["productId" => ($context["productId"] ?? null)]), "html", null, true);
            echo "\"
        >
          ";
            // line 122
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Edit on experimental page", [], "Admin.Catalog.Feature");
            echo "
        </a>
      ";
        }
        // line 125
        echo "
      <div class=\"js-spinner spinner hide btn-primary-reverse onclick mr-1 btn\"></div>
      <div class=\"btn-group hide dropdown\">
        <button
          class=\"btn btn-primary js-btn-save ml-3\"
          type=\"submit\"
        >
          <span>";
        // line 132
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</span>
        </button><button
                   class=\"btn btn-primary dropdown-toggle dropdown-toggle-split\"
                   type=\"button\"
                   id=\"dropdownMenu\"
                   data-toggle=\"dropdown\"
                   aria-expanded=\"false\"
                 >
          <span class=\"sr-only\">Toggle Dropdown</span>
        </button>
        <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu\">
          ";
        // line 143
        if (($context["is_shop_context"] ?? null)) {
            // line 144
            echo "            <a
              class=\"dropdown-item duplicate js-btn-save\"
              href=\"";
            // line 146
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_unit_action", ["action" => "duplicate", "id" => ($context["productId"] ?? null)]), "html", null, true);
            echo "\"
            >
              ";
            // line 148
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Duplicate", [], "Admin.Actions");
            echo "
            </a>
          ";
        }
        // line 151
        echo "          <a
            class=\"dropdown-item go-catalog js-btn-save\"
            href=\"";
        // line 153
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_catalog", ["offset" => "last", "limit" => "last"]), "html", null, true);
        echo "\"
          >
            ";
        // line 155
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Go to catalog", [], "Admin.Catalog.Feature");
        echo "
          </a>
          <a
            class=\"dropdown-item new-product js-btn-save\"
            href=\"";
        // line 159
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_new");
        echo "\"
          >
            ";
        // line 161
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Add new product", [], "Admin.Catalog.Feature");
        echo "
          </a>
        </div>
      </div>
    </div>
  </div>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Blocks/footer.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  304 => 161,  299 => 159,  292 => 155,  287 => 153,  283 => 151,  277 => 148,  272 => 146,  268 => 144,  266 => 143,  252 => 132,  243 => 125,  237 => 122,  232 => 120,  228 => 118,  225 => 117,  219 => 114,  214 => 112,  210 => 110,  208 => 109,  203 => 107,  198 => 105,  193 => 103,  184 => 97,  179 => 95,  174 => 93,  168 => 89,  162 => 86,  157 => 84,  152 => 82,  146 => 78,  144 => 77,  139 => 75,  134 => 73,  126 => 67,  120 => 64,  107 => 56,  101 => 55,  95 => 54,  88 => 53,  86 => 52,  81 => 50,  76 => 48,  68 => 43,  64 => 42,  60 => 41,  49 => 33,  42 => 29,  37 => 26,  31 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Blocks/footer.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Blocks/footer.html.twig");
    }
}
