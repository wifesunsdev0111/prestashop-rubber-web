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

/* @Product/ProductPage/Panels/options.html.twig */
class __TwigTemplate_77246195277623570e1981686f1193e8bfb2ef2bf9e7fa253c4ccfb89025c63f extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            '__internal_e4f31e94c3e1c9f949343a7d0999b9661d96f2345b46c6cb35f1c226e2cc72ba' => [$this, 'block___internal_e4f31e94c3e1c9f949343a7d0999b9661d96f2345b46c6cb35f1c226e2cc72ba'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "<div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step6\">
  <div class=\"row\">
    <div class=\"col-md-12\">
      <div class=\"container-fluid\">
        <div class=\"row\">

          <div class=\"col-md-12\">

            ";
        // line 33
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsOptionsStepTop", ["id_product" => ($context["productId"] ?? null)]);
        echo "

            <div class=\"row\">
              <div class=\"col-md-12\">
                <h2>";
        // line 37
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Visibility", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
                <p class=\"subtitle\">";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Where do you want your product to appear?", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</p>
              </div>
            </div>

            <div class=\"row\">
              <div class=\"col-md-4 form-group\">
                ";
        // line 44
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "visibility", []), 'errors');
        echo "
                ";
        // line 45
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "visibility", []), 'widget');
        echo "
              </div>
            </div>

            <div class=\"row\">
              <div class=\"col-md-7 form-group\">
                  ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "display_options", []), 'errors');
        echo "
                  <div class=\"row\">
                    <div class=\"col-md-4 js-available-for-order\">
                      ";
        // line 54
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "display_options", []), "available_for_order", []), 'widget');
        echo "
                    </div>
                    <div class=\"col-md-3 js-show-price\">
                      ";
        // line 57
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "display_options", []), "show_price", []), 'widget');
        echo "
                    </div>
                    <div class=\"col-md-5\">
                      ";
        // line 60
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "display_options", []), "online_only", []), 'widget');
        echo "
                    </div>
                  </div>
              </div>
            </div>
            <div class=\"row form-group\">
              <div class=\"col-md-8\">
                <label class=\"form-control-label\">";
        // line 67
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tags", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</label>
                ";
        // line 68
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "tags", []), 'errors');
        echo "
                ";
        // line 69
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "tags", []), 'widget');
        echo "
                <div class=\"alert expandable-alert alert-info mt-3\" role=\"alert\">
                  <p class=\"alert-text\">";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tags are meant to help your customers find your products via the search bar.", [], "Admin.Catalog.Help");
        echo "</p>
                  <div class=\"alert-more collapse\" id=\"tagsInfo\">
                    <p>
                      ";
        // line 74
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Choose terms and keywords that your customers will use to search for this product and make sure you are consistent with the tags you may have already used.", [], "Admin.Catalog.Help");
        echo "<br>
                      ";
        // line 75
        echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("You can manage tag aliases in the [1]Search section[/1]. If you add new tags, you have to rebuild the index.", [], "Admin.Catalog.Help"), ["[1]" => (("<a href=\"" . $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminSearchConf")) . "\" target=\"_blank\">"), "[/1]" => "</a>"]);
        // line 80
        echo "
                    </p>
                  </div>
                 <div class=\"read-more-container\">
                   <button type=\"button\" class=\"read-more btn-link\" data-toggle=\"collapse\" data-target=\"#tagsInfo\" aria-expanded=\"false\" aria-controls=\"collapseDanger\">
                      ";
        // line 85
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Read more", [], "Admin.Actions");
        echo "
                    </button>
                 </div>
                </div>
              </div>
            </div>

            <div class=\"row\">
              <div class=\"col-md-12\">
                <h2>";
        // line 94
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Condition & References", [], "Admin.Catalog.Feature");
        echo "</h2>
              </div>
            </div>

            <div class=\"row\">
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">
                  ";
        // line 101
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "condition", []), "vars", []), "label", []), "html", null, true);
        echo "
                  <span class=\"help-box\" data-toggle=\"popover\"
                    data-content=\"";
        // line 103
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Not all shops sell new products. This option enables you to indicate the condition of the product. It can be required on some marketplaces.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                </label>
                ";
        // line 105
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "condition", []), 'errors');
        echo "
                ";
        // line 106
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "condition", []), 'widget');
        echo "
              </fieldset>
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">&nbsp;</label>
                ";
        // line 110
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "show_condition", []), 'widget');
        echo "
              </fieldset>
            </div>
            <div class=\"row\">
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">
                  ";
        // line 116
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "isbn", []), "vars", []), "label", []), "html", null, true);
        echo "
                  <span class=\"help-box\" data-toggle=\"popover\"
                    data-content=\"";
        // line 118
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("ISBN is used internationally to identify books and their various editions.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                </label>
                ";
        // line 120
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "isbn", []), 'errors');
        echo "
                ";
        // line 121
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "isbn", []), 'widget');
        echo "
              </fieldset>
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">
                  ";
        // line 125
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "ean13", []), "vars", []), "label", []), "html", null, true);
        echo "
                  <span class=\"help-box\" data-toggle=\"popover\"
                    data-content=\"";
        // line 127
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This type of product code is specific to Europe and Japan, but is widely used internationally. It is a superset of the UPC code: all products marked with an EAN will be accepted in North America.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                </label>
                ";
        // line 129
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "ean13", []), 'errors');
        echo "
                ";
        // line 130
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "ean13", []), 'widget');
        echo "
              </fieldset>
            </div>
            <div class=\"row\">
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">
                  ";
        // line 136
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "upc", []), "vars", []), "label", []), "html", null, true);
        echo "
                  <span class=\"help-box\" data-toggle=\"popover\"
                    data-content=\"";
        // line 138
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This type of product code is widely used in the United States, Canada, the United Kingdom, Australia, New Zealand and in other countries.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                </label>
                ";
        // line 140
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "upc", []), 'errors');
        echo "
                ";
        // line 141
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "upc", []), 'widget');
        echo "
              </fieldset>
              <fieldset class=\"col-md-4 form-group\">
                <label class=\"form-control-label\">
                  ";
        // line 145
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "mpn", []), "vars", []), "label", []), "html", null, true);
        echo "
                  <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 147
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("MPN is used internationally to identify the Manufacturer Part Number.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                </label>
                ";
        // line 149
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "mpn", []), 'errors');
        echo "
                ";
        // line 150
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "mpn", []), 'widget');
        echo "
              </fieldset>
            </div>

            <div class=\"row\">
              <div class=\"col-md-12\">
                <div id=\"custom_fields\" class=\"mt-3\">
                  <h2>";
        // line 157
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "custom_fields", []), "vars", []), "label", []), "html", null, true);
        echo "</h2>
                  <p class=\"subtitle\">";
        // line 158
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Customers can personalize the product by entering some text or by providing custom image files.", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</p>
                  ";
        // line 159
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "custom_fields", []), 'errors');
        echo "
                  <ul class=\"customFieldCollection nostyle\" data-prototype=\"
                              ";
        // line 161
        echo twig_escape_filter($this->env,         $this->renderBlock("__internal_e4f31e94c3e1c9f949343a7d0999b9661d96f2345b46c6cb35f1c226e2cc72ba", $context, $blocks));
        // line 163
        echo "\">
                    ";
        // line 164
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["optionsForm"] ?? null), "custom_fields", []));
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
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            // line 165
            echo "                      <li>
                        ";
            // line 166
            echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_custom_fields.html.twig", ["form" => $context["field"]]);
            echo "
                      </li>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 169
        echo "                  </ul>
                  <a href=\"#\" class=\"btn btn-outline-secondary add\">
                    <i class=\"material-icons\">add_circle</i>
                    ";
        // line 172
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Add a customization field", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                  </a>
                </div>
              </div>
            </div>

            <div class=\"row mt-4\">
              <div class=\"col-md-8\">
                <h2>";
        // line 180
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Attached files", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
                <p class=\"subtitle\">";
        // line 181
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Select the files (instructions, documentation, recipes, etc.) your customers can directly download on this product page.", [], "Admin.Catalog.Feature"), "html", null, true);
        echo " <br/> ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Need to browse all files? Go to [1]Catalog > Files[/1]", ["[1]" => (("<a href=\"" . $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminAttachments")) . "\">"), "[/1]" => "</a>"], "Admin.Catalog.Feature");
        echo " </p>
                ";
        // line 182
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "attachments", []), 'widget');
        echo "
              </div>
            </div>
            <div class=\"row mt-3\">
              <div class=\"col-md-8\">
                <a
                  class=\"btn btn-outline-secondary mb-3\"
                  href=\"#collapsedForm\"
                  data-toggle=\"collapse\"
                  aria-expanded=\"false\"
                  aria-controls=\"collapsedForm\"
                >
                  <i class=\"material-icons\">add_circle</i>
                  ";
        // line 195
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Attach a new file", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                </a>
                <fieldset class=\"form-group collapse\" id=\"collapsedForm\">
                  ";
        // line 198
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), 'errors');
        echo "
                  <div id=\"form_step6_attachment_product\" data-action=\"";
        // line 199
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "vars", []), "attr", []), "data-action", [], "array"), "html", null, true);
        echo "\">
                    <div class=\"form-group\">";
        // line 200
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "file", []), 'widget');
        echo "</div>
                    <div class=\"form-group\">";
        // line 201
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "name", []), 'widget');
        echo "</div>
                    <div class=\"form-group\">";
        // line 202
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "description", []), 'widget');
        echo "</div>
                    <div class=\"form-group\">
                      ";
        // line 204
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "add", []), 'widget');
        echo "
                      ";
        // line 205
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "attachment_product", []), "cancel", []), 'widget');
        echo "
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>

            <div class=\"row mt-3\">
              <div class=\"col-md-8\" id=\"supplier_collection\">
                ";
        // line 214
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_supplier_choice.html.twig", ["form" => ($context["optionsForm"] ?? null)]);
        echo "
              </div>
            </div>
            <div class=\"row\">
              <div id=\"supplier_combination_collection\" class=\"col-md-12\" data-url=\"";
        // line 218
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_supplier_refresh_product_supplier_combination_form", ["idProduct" => ($context["productId"] ?? null), "supplierIds" => 1]), "html", null, true);
        echo "\">
                ";
        // line 219
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_supplier_combination.html.twig", ["suppliers" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "suppliers", []), "vars", []), "value", []), "form" => ($context["optionsForm"] ?? null)]);
        echo "
              </div>
            </div>

            ";
        // line 223
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsOptionsStepBottom", ["id_product" => ($context["productId"] ?? null)]);
        echo "

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
    }

    // line 161
    public function block___internal_e4f31e94c3e1c9f949343a7d0999b9661d96f2345b46c6cb35f1c226e2cc72ba($context, array $blocks = [])
    {
        // line 162
        echo "                              ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_custom_fields.html.twig", ["form" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["optionsForm"] ?? null), "custom_fields", []), "vars", []), "prototype", [])]);
        echo "
                              ";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Panels/options.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  449 => 162,  446 => 161,  433 => 223,  426 => 219,  422 => 218,  415 => 214,  403 => 205,  399 => 204,  394 => 202,  390 => 201,  386 => 200,  382 => 199,  378 => 198,  372 => 195,  356 => 182,  350 => 181,  346 => 180,  335 => 172,  330 => 169,  313 => 166,  310 => 165,  293 => 164,  290 => 163,  288 => 161,  283 => 159,  279 => 158,  275 => 157,  265 => 150,  261 => 149,  256 => 147,  251 => 145,  244 => 141,  240 => 140,  235 => 138,  230 => 136,  221 => 130,  217 => 129,  212 => 127,  207 => 125,  200 => 121,  196 => 120,  191 => 118,  186 => 116,  177 => 110,  170 => 106,  166 => 105,  161 => 103,  156 => 101,  146 => 94,  134 => 85,  127 => 80,  125 => 75,  121 => 74,  115 => 71,  110 => 69,  106 => 68,  102 => 67,  92 => 60,  86 => 57,  80 => 54,  74 => 51,  65 => 45,  61 => 44,  52 => 38,  48 => 37,  41 => 33,  31 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Panels/options.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Panels/options.html.twig");
    }
}
