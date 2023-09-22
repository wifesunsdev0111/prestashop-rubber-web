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

/* @Product/ProductPage/Panels/combinations.html.twig */
class __TwigTemplate_060e2e24eccd828a4bf2e3fcd743e0a4a47a8abb59d080dc85c98e24d5631369 extends \Twig\Template
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
        echo "<div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step3\">
  <div class=\"row\">
    <div class=\"col-md-12\">
      <div class=\"container-fluid\">
        <div class=\"row\">

          <div class=\"col-md-12\">

            <div id=\"quantities\" style=\"";
        // line 33
        if ((($context["has_combinations"] ?? null) || ($this->getAttribute($this->getAttribute(($context["formDependsOnStocks"] ?? null), "vars", []), "value", []) != "0"))) {
            echo "display: none;";
        }
        echo "\">
              <h2>";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Quantities", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
              <fieldset class=\"form-group\">
                <div class=\"row\">
                  ";
        // line 37
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 38
            echo "                    <div class=\"col-md-4\">
                      <label class=\"form-control-label\">";
            // line 39
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formStockQuantity"] ?? null), "vars", []), "label", []), "html", null, true);
            echo "</label>
                      ";
            // line 40
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formStockQuantity"] ?? null), 'errors');
            echo "
                      ";
            // line 41
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formStockQuantity"] ?? null), 'widget');
            echo "
                    </div>
                  ";
        }
        // line 44
        echo "                  <div class=\"col-md-4\">
                    <label class=\"form-control-label\">
                      ";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formStockMinimalQuantity"] ?? null), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The minimum quantity required to buy this product (set to 1 to disable this feature). E.g.: if set to 3, customers will be able to purchase the product only if they take at least 3 in quantity.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    ";
        // line 50
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formStockMinimalQuantity"] ?? null), 'errors');
        echo "
                    ";
        // line 51
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formStockMinimalQuantity"] ?? null), 'widget');
        echo "
                  </div>
                </div>
              </fieldset>

              <h2>";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Stock", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
              <fieldset class=\"form-group\">
                <div class=\"row\">
                  <div class=\"col-md-4\">
                    <label class=\"form-control-label\">";
        // line 60
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formLocation"] ?? null), "vars", []), "label", []), "html", null, true);
        echo "</label>
                    ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLocation"] ?? null), 'errors');
        echo "
                    ";
        // line 62
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLocation"] ?? null), 'widget');
        echo "
                  </div>
                </div>
                <div class=\"row\">
                  <div class=\"col-md-4\">
                    <label class=\"form-control-label\">";
        // line 67
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formLowStockThreshold"] ?? null), "vars", []), "label", []), "html", null, true);
        echo "</label>
                    ";
        // line 68
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLowStockThreshold"] ?? null), 'errors');
        echo "
                    ";
        // line 69
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLowStockThreshold"] ?? null), 'widget');
        echo "
                  </div>
                  <div class=\"col-md-8\">
                    <label class=\"form-control-label\">&nbsp;</label>
                    <div class=\"widget-checkbox-inline\">
                      ";
        // line 74
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLowStockAlert"] ?? null), 'errors');
        echo "
                      ";
        // line 75
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formLowStockAlert"] ?? null), 'widget');
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\" data-html=\"true\" data-content=\"";
        // line 76
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The email will be sent to all the users who have the right to run the stock page. To modify the permissions, go to [1]Advanced Parameters > Team[/1]", ["[1]" => (("<a href=&quot;" . $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminEmployees")) . "&quot;>"), "[/1]" => "</a>"], "Admin.Catalog.Help");
        echo "\" ></span>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div id=\"virtual_product\" data-action=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_virtual_save_action", ["idProduct" => ($context["productId"] ?? null)]), "html", null, true);
        echo "\" data-action-remove=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_virtual_remove_action", ["idProduct" => ($context["productId"] ?? null)]), "html", null, true);
        echo "\">

              <div class=\"row\">
                <div class=\"col-md-4\">
                  <h2>";
        // line 87
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "vars", []), "label", []), "html", null, true);
        echo "</h2>
                </div>
                <div class=\"col-md-8\">
                  <fieldset class=\"form-group\">
                    ";
        // line 91
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "is_virtual_file", []), 'widget');
        echo "
                  </fieldset>
                </div>
              </div>

              <div id=\"virtual_product_content\" class=\"row col-md-8\">
                ";
        // line 97
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formVirtualProduct"] ?? null), 'errors');
        echo "
                <div class=\"col-md-12\">
                  <fieldset class=\"form-group\">
                    <label class=\"form-control-label\">
                      ";
        // line 101
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "file", []), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 103
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Upload a file from your computer (%maxUploadSize% max.)", ["%maxUploadSize%" => ($context["max_upload_size"] ?? null)], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    <div id=\"form_step3_virtual_product_file_input\" class=\"";
        // line 105
        echo (($this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "vars", [], "any", false, true), "value", [], "any", false, true), "filename", [], "any", true, true)) ? ("hide") : ("show"));
        echo "\">
                      ";
        // line 106
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "file", []), 'widget');
        echo "
                    </div>
                    <div id=\"form_step3_virtual_product_file_details\" class=\"";
        // line 108
        echo (($this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "vars", [], "any", false, true), "value", [], "any", false, true), "filename", [], "any", true, true)) ? ("show") : ("hide"));
        echo "\">
                      <a href=\"";
        // line 109
        (($this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "vars", [], "any", false, true), "value", [], "any", false, true), "file_download_link", [], "any", true, true)) ? (print (twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "vars", []), "value", []), "file_download_link", []), "html", null, true))) : (print ("")));
        echo "\" class=\"btn btn-default btn-sm download\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Download file", [], "Admin.Actions"), "html", null, true);
        echo "</a>
                      <a href=\"";
        // line 110
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_virtual_remove_file_action", ["idProduct" => ($context["productId"] ?? null)]), "html", null, true);
        echo "\" class=\"btn btn-danger btn-sm delete\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete this file", [], "Admin.Actions"), "html", null, true);
        echo "</a>
                    </div>
                  </fieldset>
                </div>
                <div class=\"col-md-6\">
                  <fieldset class=\"form-group\">
                    <label class=\"form-control-label\">
                      ";
        // line 117
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "name", []), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 119
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The full filename with its extension (e.g. Book.pdf)", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    ";
        // line 121
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "name", []), 'errors');
        echo "
                    ";
        // line 122
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "name", []), 'widget');
        echo "
                  </fieldset>
                </div>
                <div class=\"col-md-6\">
                  <fieldset class=\"form-group\">
                    <label class=\"form-control-label\">
                      ";
        // line 128
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_downloadable", []), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 130
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Number of downloads allowed per customer. Set to 0 for unlimited downloads.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    ";
        // line 132
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_downloadable", []), 'errors');
        echo "
                    ";
        // line 133
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_downloadable", []), 'widget');
        echo "
                  </fieldset>
                </div>
                <div class=\"col-md-6\">
                  <fieldset class=\"form-group\">
                    <label class=\"form-control-label\">
                      ";
        // line 139
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "expiration_date", []), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 141
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("If set, the file will not be downloadable after this date. Leave blank if you do not wish to attach an expiration date.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    ";
        // line 143
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "expiration_date", []), 'errors');
        echo "
                    ";
        // line 144
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "expiration_date", []), 'widget');
        echo "
                  </fieldset>
                </div>
                <div class=\"col-md-6\">
                  <fieldset class=\"form-group\">
                    <label class=\"form-control-label\">
                      ";
        // line 150
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_days", []), "vars", []), "label", []), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 152
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Number of days this file can be accessed by customers. Set to zero for unlimited access.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </label>
                    ";
        // line 154
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_days", []), 'errors');
        echo "
                    ";
        // line 155
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "nb_days", []), 'widget');
        echo "
                  </fieldset>
                </div>
                <div class=\"col-md-12\">
                  ";
        // line 159
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["formVirtualProduct"] ?? null), "save", []), 'widget');
        echo "
                </div>
              </div>
            </div>

            ";
        // line 164
        if ((($context["asm_globally_activated"] ?? null) && ($this->getAttribute($this->getAttribute(($context["formType"] ?? null), "vars", []), "value", []) != "2"))) {
            // line 165
            echo "              <div class=\"form-group\" id=\"asm_quantity_management\">
                <label class=\"col-sm-2 control-label\" for=\"form_step3_advanced_stock_management\"></label>
                <div class=\"col-sm-10\">
                  ";
            // line 168
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formAdvancedStockManagement"] ?? null), 'errors');
            echo "
                  ";
            // line 169
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formAdvancedStockManagement"] ?? null), 'widget');
            echo "
                  ";
            // line 170
            if (($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step1", []), "type_product", []), "vars", []), "value", []) == "1")) {
                // line 171
                echo "                    ";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("When enabling advanced stock management for a pack, please make sure it is also enabled for its product(s) – if you choose to decrement product quantities.", [], "Admin.Catalog.Notification"), "html", null, true);
                echo "
                  ";
            }
            // line 173
            echo "                </div>
              </div>
              <div class=\"form-group\" id=\"depends_on_stock_div\" style=\"";
            // line 175
            if ( !$this->getAttribute($this->getAttribute(($context["formAdvancedStockManagement"] ?? null), "vars", []), "checked", [])) {
                echo "display: none;";
            }
            echo "\">
                <label class=\"col-sm-2 control-label\" for=\"form_step3_depends_on_stock\"></label>
                <div class=\"col-sm-10\">
                  ";
            // line 178
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formDependsOnStocks"] ?? null), 'errors');
            echo "
                  ";
            // line 179
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formDependsOnStocks"] ?? null), 'widget');
            echo "
                </div>
              </div>
            ";
        }
        // line 183
        echo "            ";
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 184
            echo "              <div id=\"pack_stock_type\">
                <h2>";
            // line 185
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["formPackStockType"] ?? null), "vars", []), "label", []), "html", null, true);
            echo "</h2>
                <div class=\"row col-md-4\">
                  <fieldset class=\"form-group\">
                    ";
            // line 188
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPackStockType"] ?? null), 'errors');
            echo "
                    ";
            // line 189
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPackStockType"] ?? null), 'widget');
            echo "
                  </fieldset>
                </div>
              </div>
            ";
        }
        // line 194
        echo "            ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_combinations.html.twig", ["form" => ($context["formStep3"] ?? null), "form_combination_bulk" => ($context["formCombinations"] ?? null)]);
        echo "

            ";
        // line 196
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsQuantitiesStepBottom", ["id_product" => ($context["productId"] ?? null)]);
        echo "

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Panels/combinations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  401 => 196,  395 => 194,  387 => 189,  383 => 188,  377 => 185,  374 => 184,  371 => 183,  364 => 179,  360 => 178,  352 => 175,  348 => 173,  342 => 171,  340 => 170,  336 => 169,  332 => 168,  327 => 165,  325 => 164,  317 => 159,  310 => 155,  306 => 154,  301 => 152,  296 => 150,  287 => 144,  283 => 143,  278 => 141,  273 => 139,  264 => 133,  260 => 132,  255 => 130,  250 => 128,  241 => 122,  237 => 121,  232 => 119,  227 => 117,  215 => 110,  209 => 109,  205 => 108,  200 => 106,  196 => 105,  191 => 103,  186 => 101,  179 => 97,  170 => 91,  163 => 87,  154 => 83,  144 => 76,  140 => 75,  136 => 74,  128 => 69,  124 => 68,  120 => 67,  112 => 62,  108 => 61,  104 => 60,  97 => 56,  89 => 51,  85 => 50,  80 => 48,  75 => 46,  71 => 44,  65 => 41,  61 => 40,  57 => 39,  54 => 38,  52 => 37,  46 => 34,  40 => 33,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Panels/combinations.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Panels/combinations.html.twig");
    }
}
