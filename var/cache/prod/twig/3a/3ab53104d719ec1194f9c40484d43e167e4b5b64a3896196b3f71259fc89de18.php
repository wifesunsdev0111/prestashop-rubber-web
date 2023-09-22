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

/* @Product/ProductPage/Forms/form_combinations.html.twig */
class __TwigTemplate_0aa377bcbe260fd5a067697946261cb5721ba4d286cc16fd8557bf213b500639 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "<div class=\"row\" id=\"combinations\">
  <div class=\"col-md-9\">
    <h2>
      ";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Manage your product combinations", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
      <span
        class=\"help-box\"
        data-toggle=\"popover\"
        data-content=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations are the different variations of a product, with attributes like its size, weight or color taking different values. To create a combination, you need to create your product attributes first. Go to Catalog > Attributes & Features for this!", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\"
      ></span>
    </h2>
    <div id=\"attributes-generator\">
      <div class=\"alert alert-info\" role=\"alert\">
        <p class=\"alert-text\">
          ";
        // line 38
        echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("To add combinations, you first need to create proper attributes and values in [1]%attributes_and_features_label%[/1]. <br> When done, you may enter the wanted attributes (like \"size\" or \"color\") and their respective values (\"XS\", \"red\", \"all\", etc.) in the field below; or simply select them from the right column. Then click on \"%generate_label%\": it will automatically create all the combinations for you!", ["%attributes_and_features_label%" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Attributes & Features", [], "Admin.Navigation.Menu"), "%generate_label%" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Generate", [], "Admin.Actions")], "Admin.Catalog.Help"), ["[1]" => (("<a class=\"alert-link\" href=" . $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminAttributesGroups")) . " target=\"_blank\">"), "[/1]" => "</a>"]);
        echo "
        </p>
      </div>
      <div class=\"row\">
        <div class=\"col-xl-10 col-lg-9\">
          <fieldset class=\"form-group\">
            ";
        // line 44
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attributes", []), 'errors');
        echo "
            ";
        // line 45
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attributes", []), 'widget');
        echo "
          </fieldset>
        </div>
        <div class=\"col-xl-2 col-lg-3\">
          <button class=\"btn btn-outline-primary\" id=\"create-combinations\">
            Generate
          </button>
        </div>
      </div>
    </div>

    <div id=\"combinations-bulk-form\">
      <div class=\"row\">
        <div class=\"col-md-12\">
          <p
            class=\"form-control bulk-action\"
            data-toggle=\"collapse\"
            href=\"#bulk-combinations-container\"
            aria-expanded=\"false\"
            aria-controls=\"bulk-combinations-container\"
          >
            ";
        // line 67
        echo "            <strong>";
        echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Bulk actions ([1]/[2] combination(s) selected)", [], "Admin.Catalog.Feature"), ["[1]" => "<span class=\"js-bulk-combinations\">0</span>", "[2]" => (("<span id=\"js-bulk-combinations-total\">" . ($context["combinations_count"] ?? null)) . "</span>")]);
        echo "</strong>
            <i class=\"material-icons float-right\">keyboard_arrow_down</i>
          </p>
        </div>
        <div class=\"col-md-12 collapse js-collapse\" id=\"bulk-combinations-container\">
          <div class=\"border p-3\">
            ";
        // line 73
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_combinations_bulk.html.twig", ["form" => ($context["form_combination_bulk"] ?? null)]);
        echo "
          </div>
        </div>
      </div>
    </div>

    <div class=\"combinations-list\">
      <table class=\"table\">
        <thead class=\"thead-default\" id=\"combinations_thead\" ";
        // line 81
        if ( !($context["has_combinations"] ?? null)) {
            echo "style=\"display: none;\"";
        }
        echo ">
          <tr>
            <th>
              <input type=\"checkbox\" id=\"toggle-all-combinations\" >
            </th>
            <th></th>
            <th>";
        // line 87
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</th>
            <th>";
        // line 88
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Impact on price (tax excl.)", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</th>
            <th>";
        // line 89
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Final price (tax excl.)", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</th>
            ";
        // line 90
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 91
            echo "                <th>";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Quantity", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "</th>
            ";
        }
        // line 93
        echo "            <th colspan=\"3\" class=\"text-sm-right\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Default combination", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</th>
          </tr>
        </thead>
        <tbody class=\"js-combinations-list panel-group accordion\" id=\"accordion_combinations\" data-action-delete-all=\"";
        // line 96
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_delete_all_attributes", ["idProduct" => 1]);
        echo "\" data-weight-unit=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_WEIGHT_UNIT"), "html", null, true);
        echo "\" data-action-refresh-images=\"";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_get_form_images_combination", ["idProduct" => 1]);
        echo "\"  data-id-product= ";
        echo twig_escape_filter($this->env, ($context["id_product"] ?? null), "html", null, true);
        echo " data-ids-product-attribute=\"";
        echo twig_escape_filter($this->env, ($context["ids_product_attribute"] ?? null), "html", null, true);
        echo "\" data-combinations-url=\"";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_combination_generate_form", ["combinationIds" => ":numbers"]);
        echo "\">
          ";
        // line 97
        if (($context["has_combinations"] ?? null)) {
            // line 98
            echo "            <tr class=\"combination loading timeline-wrapper\" id=\"loading-attribute\">
              <td class=\"timeline-item\" width=\"1%\">
              </td>
              <td class=\"timeline-item img\">
                <div class=\"animated-background\"></div>
              </td>
              <td>
                <div class=\"animated-background\"></div>
              </td>
              <td class=\"attribute-price\">
                <div class=\"animated-background\"></div>
              </td>
              <td class=\"attribute-finalprice\">
                <div class=\"animated-background\"></div>
              </td>
              ";
            // line 113
            if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
                // line 114
                echo "                <td class=\"attribute-quantity\">
                  <div class=\"animated-background\"></div>
                </td>
              ";
            }
            // line 118
            echo "              <td colspan=\"6\"></td>
            </tr>
          ";
        }
        // line 121
        echo "        </tbody>
      </table>
    </div>
  </div>

  <div id=\"attributes-list\" class=\"col-md-3\">
    ";
        // line 127
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attribute_groups"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["attribute_group"]) {
            // line 128
            echo "      <div class=\"attribute-group\">
        <a
          class=\"attribute-group-name ";
            // line 130
            if ((($this->getAttribute($context["loop"], "index", []) > 3) || ($context["has_combinations"] ?? null))) {
                echo " collapsed ";
            }
            echo "\"
          data-toggle=\"collapse\"
          href=\"#attribute-group-";
            // line 132
            echo twig_escape_filter($this->env, $this->getAttribute($context["attribute_group"], "id", []), "html", null, true);
            echo "\"
          aria-expanded=\"";
            // line 133
            if ((($this->getAttribute($context["loop"], "index", []) <= 3) ||  !($context["has_combinations"] ?? null))) {
                echo "true";
            } else {
                echo "false";
            }
            echo "\"
        >
          ";
            // line 135
            echo twig_escape_filter($this->env, $this->getAttribute($context["attribute_group"], "name", []), "html", null, true);
            echo "
        </a>
        <div class=\"collapse ";
            // line 137
            if ((($this->getAttribute($context["loop"], "index", []) <= 3) &&  !($context["has_combinations"] ?? null))) {
                echo " show ";
            }
            echo " attributes \" id=\"attribute-group-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["attribute_group"], "id", []), "html", null, true);
            echo "\">
          <div class=\"attributes-overflow ";
            // line 138
            if ((twig_length_filter($this->env, $this->getAttribute($context["attribute_group"], "attributes", [])) > 7)) {
                echo " two-columns ";
            }
            echo "\">
            ";
            // line 139
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["attribute_group"], "attributes", []));
            foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
                // line 140
                echo "              <div class=\"attribute\">
                <input
                  class=\"js-attribute-checkbox\"
                  id=\"attribute-";
                // line 143
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "id", []), "html", null, true);
                echo "\"
                  data-label=\"";
                // line 144
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute_group"], "name", []), "html", null, true);
                echo " : ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "name", []), "html", null, true);
                echo "\"
                  data-value=\"";
                // line 145
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "id", []), "html", null, true);
                echo "\"
                  data-group-id=\"";
                // line 146
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute_group"], "id", []), "html", null, true);
                echo "\"
                  type=\"checkbox\"
                >
                <label class=\"attribute-label\" for=\"attribute-";
                // line 149
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "id", []), "html", null, true);
                echo "\">
                  <span
                    class=\"pretty-checkbox ";
                // line 151
                if ((twig_test_empty($this->getAttribute($context["attribute"], "color", [])) && twig_test_empty($this->getAttribute($context["attribute"], "texture", [])))) {
                    echo " not-color ";
                }
                echo "\"
                    ";
                // line 152
                if ( !twig_test_empty($this->getAttribute($context["attribute"], "texture", []))) {
                    echo " style=\"content: url(";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "texture", []), "html", null, true);
                    echo ")\"
                    ";
                } elseif ( !twig_test_empty($this->getAttribute(                // line 153
$context["attribute"], "color", []))) {
                    echo " style=\"background-color: ";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "color", []), "html", null, true);
                    echo "\"
                    ";
                }
                // line 155
                echo "                  >
                  </span>
                  ";
                // line 157
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "name", []), "html", null, true);
                echo "
                </label>
              </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 161
            echo "          </div>
        </div>
      </div>
    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 165
        echo "  </div>
</div>

<div class=\"form-group\">
  <div class=\"row\">

    <div class=\"col-md-12\">
      <h2>";
        // line 172
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Availability preferences", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
    </div>
    ";
        // line 174
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 175
            echo "      <div class=\"col-md-12\">
        <label class=\"form-control-label\">";
            // line 176
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Behavior when out of stock", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "</label>
        ";
            // line 177
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "out_of_stock", []), 'errors');
            echo "
        ";
            // line 178
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "out_of_stock", []), 'widget');
            echo "
      </div>

      <div class=\"col-md-4\">
        <label class=\"form-control-label\">";
            // line 182
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "available_now", []), "vars", []), "label", []), "html", null, true);
            echo "</label>
        ";
            // line 183
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_now", []), 'errors');
            echo "
        ";
            // line 184
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_now", []), 'widget');
            echo "
      </div>

      <div class=\"col-md-4 \">
        <label class=\"form-control-label\">";
            // line 188
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "available_later", []), "vars", []), "label", []), "html", null, true);
            echo "</label>
        ";
            // line 189
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_later", []), 'errors');
            echo "
        ";
            // line 190
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_later", []), 'widget');
            echo "
      </div>
    ";
        } else {
            // line 193
            echo "      <div class=\"col-md-12\">
        <h3>";
            // line 194
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Stock management is disabled", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "</h3>
      </div>
    ";
        }
        // line 197
        echo "
    ";
        // line 198
        if ( !($context["has_combinations"] ?? null)) {
            // line 199
            echo "    <div class=\"col-md-4 \">
      <label class=\"form-control-label\">";
            // line 200
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "available_date", []), "vars", []), "label", []), "html", null, true);
            echo "</label>
      ";
            // line 201
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_date", []), 'errors');
            echo "
      ";
            // line 202
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_date", []), 'widget');
            echo "
    </div>
    ";
        }
        // line 205
        echo "
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Forms/form_combinations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  439 => 205,  433 => 202,  429 => 201,  425 => 200,  422 => 199,  420 => 198,  417 => 197,  411 => 194,  408 => 193,  402 => 190,  398 => 189,  394 => 188,  387 => 184,  383 => 183,  379 => 182,  372 => 178,  368 => 177,  364 => 176,  361 => 175,  359 => 174,  354 => 172,  345 => 165,  328 => 161,  318 => 157,  314 => 155,  307 => 153,  301 => 152,  295 => 151,  290 => 149,  284 => 146,  280 => 145,  274 => 144,  270 => 143,  265 => 140,  261 => 139,  255 => 138,  247 => 137,  242 => 135,  233 => 133,  229 => 132,  222 => 130,  218 => 128,  201 => 127,  193 => 121,  188 => 118,  182 => 114,  180 => 113,  163 => 98,  161 => 97,  147 => 96,  140 => 93,  134 => 91,  132 => 90,  128 => 89,  124 => 88,  120 => 87,  109 => 81,  98 => 73,  88 => 67,  64 => 45,  60 => 44,  51 => 38,  42 => 32,  35 => 28,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Forms/form_combinations.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Forms/form_combinations.html.twig");
    }
}
