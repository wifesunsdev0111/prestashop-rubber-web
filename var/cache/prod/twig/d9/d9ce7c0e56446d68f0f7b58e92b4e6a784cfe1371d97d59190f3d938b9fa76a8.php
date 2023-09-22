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

/* @Product/ProductPage/Panels/essentials.html.twig */
class __TwigTemplate_2e8a7ef1f7d47c5ecb03dae39bc2a9dac56daeb4255d9f7dd00b2bcd2db1b799 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            '__internal_3a4e78afea0330a3e0353a10393f75bc6d628f2038d33b83b20fc94f4057cabc' => [$this, 'block___internal_3a4e78afea0330a3e0353a10393f75bc6d628f2038d33b83b20fc94f4057cabc'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "<div role=\"tabpanel\" class=\"form-contenttab tab-pane active\" id=\"step1\">
  <div class=\"row\">
    <div class=\"col-md-12\">
      <div class=\"container-fluid\">
        <div class=\"row\">

          ";
        // line 32
        echo "          <div class=\"col-md-9 left-column\">

            <div id=\"js_form_step1_inputPackItems\">
              ";
        // line 35
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPackItems"] ?? null), 'errors');
        echo "
              ";
        // line 36
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPackItems"] ?? null), 'widget');
        echo "
            </div>

            <div id=\"product-images-container\" class=\"mb-4\">
              <div id=\"product-images-dropzone\" class=\"panel dropzone ui-sortable col-md-12\"
                  url-upload=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_image_upload", ["idProduct" => ($context["productId"] ?? null)]), "html", null, true);
        echo "\"
                  url-position=\"";
        // line 42
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_image_positions");
        echo "\"
                  data-max-size=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_LIMIT_UPLOAD_IMAGE_VALUE"), "html", null, true);
        echo "\"
              >
                <div id=\"product-images-dropzone-error\" class=\"text-danger\"></div>
                <div class=\"dz-default dz-message openfilemanager\">
                    <i class=\"material-icons\">add_a_photo</i><br/>
                    ";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute(($context["js_translatable"] ?? null), "Drop images here", [], "array"), "html", null, true);
        echo "<br/>
                    <a>";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute(($context["js_translatable"] ?? null), "or select files", [], "array"), "html", null, true);
        echo "</a><br/>
                    <small>
                        ";
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute(($context["js_translatable"] ?? null), "files recommandations", [], "array"), "html", null, true);
        echo "<br/>
                        ";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute(($context["js_translatable"] ?? null), "files recommandations2", [], "array"), "html", null, true);
        echo "
                    </small>
                </div>
                ";
        // line 55
        if (array_key_exists("images", $context)) {
            // line 56
            echo "                    ";
            if (($context["editable"] ?? null)) {
                // line 57
                echo "                        <div class=\"dz-preview disabled openfilemanager\">
                            <div><span>+</span></div>
                        </div>
                    ";
            }
            // line 61
            echo "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["images"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                // line 62
                echo "                    <div class=\"dz-preview dz-processing dz-image-preview dz-complete ui-sortable-handle\"
                        data-id=\"";
                // line 63
                echo twig_escape_filter($this->env, $this->getAttribute($context["image"], "id", []), "html", null, true);
                echo "\"
                        url-delete=\"";
                // line 64
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_image_delete", ["idImage" => $this->getAttribute($context["image"], "id", [])]), "html", null, true);
                echo "\"
                        url-update=\"";
                // line 65
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_product_image_form", ["idImage" => $this->getAttribute($context["image"], "id", [])]), "html", null, true);
                echo "\"
                    >
                      <div class=\"dz-image bg\" style=\"background-image: url('";
                // line 67
                echo twig_escape_filter($this->env, $this->getAttribute($context["image"], "base_image_url", []), "html", null, true);
                echo "-home_default.";
                echo twig_escape_filter($this->env, $this->getAttribute($context["image"], "format", []), "html", null, true);
                echo "');\"></div>
                      <div class=\"dz-details\">
                        <div class=\"dz-size\"><span data-dz-size=\"\"></span></div>
                        <div class=\"dz-filename\"><span data-dz-name=\"\"></span></div>
                      </div>
                      <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress=\"\" style=\"width: 100%;\"></span></div>
                      <div class=\"dz-error-message\"><span data-dz-errormessage=\"\"></span></div>
                      <div class=\"dz-success-mark\"></div>
                      <div class=\"dz-error-mark\"></div>
                      ";
                // line 76
                if ($this->getAttribute($context["image"], "cover", [])) {
                    // line 77
                    echo "                        <div class=\"iscover\">";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Cover", [], "Admin.Catalog.Feature"), "html", null, true);
                    echo "</div>
                      ";
                }
                // line 79
                echo "                    </div>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 81
            echo "                ";
        }
        // line 82
        echo "              </div>
              <div id=\"product-images-form-container\" class=\"col-md-4\">
                <div id=\"product-images-form\"></div>
              </div>
              <div class=\"dropzone-expander text-sm-center col-md-12\">
                <span class=\"expand\">";
        // line 87
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("View all images", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</span>
                <span class=\"compress\">";
        // line 88
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("View less", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</span>
              </div>

            </div>

            <div class=\"summary-description-container\">
              <h2>";
        // line 94
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Summary", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
              <div id=\"description_short\" class=\"mb-3\">
                ";
        // line 96
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formShortDescription"] ?? null), 'widget');
        echo "
              </div>

              <h2>";
        // line 99
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Description", [], "Admin.Global"), "html", null, true);
        echo "</h2>
              <div id=\"description\" class=\"mb-3\">
                ";
        // line 101
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formDescription"] ?? null), 'widget');
        echo "
              </div>
            </div>

            ";
        // line 105
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsMainStepLeftColumnMiddle", ["id_product" => ($context["productId"] ?? null)]);
        echo "

            <div id=\"features\" class=\"mb-3\">
              <div id=\"features-content\" class=\"content ";
        // line 108
        echo (((twig_length_filter($this->env, ($context["formFeatures"] ?? null)) == 0)) ? ("hide") : (""));
        echo "\">
                <h2>";
        // line 109
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Features", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
                ";
        // line 110
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formFeatures"] ?? null), 'errors');
        echo "
                <div
                  class=\"feature-collection nostyle\"
                  data-prototype=\"";
        // line 113
        echo twig_escape_filter($this->env,         $this->renderBlock("__internal_3a4e78afea0330a3e0353a10393f75bc6d628f2038d33b83b20fc94f4057cabc", $context, $blocks));
        // line 115
        echo "\"
                >
                  ";
        // line 117
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["formFeatures"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["feature"]) {
            // line 118
            echo "                    ";
            echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_feature.html.twig", ["form" => $context["feature"]]);
            echo "
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['feature'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 120
        echo "                </div>
              </div>
              <div class=\"row\">
                <div class=\"col-md-4\">
                  <button type=\"button\" class=\"btn btn-outline-primary sensitive add\" id=\"add_feature_button\"><i class=\"material-icons\">add_circle</i> ";
        // line 124
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Add a feature", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</button>
                </div>
              </div>
            </div>

            <div id=\"manufacturer\" class=\"mb-3\">
              ";
        // line 130
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_manufacturer.html.twig", ["form" => ($context["formManufacturer"] ?? null)]);
        echo "
            </div>

            <div id=\"related-product\" class=\"mb-3\">
              ";
        // line 134
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_related_products.html.twig", ["form" => ($context["formRelatedProducts"] ?? null)]);
        echo "
            </div>

            ";
        // line 137
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsMainStepLeftColumnBottom", ["id_product" => ($context["productId"] ?? null)]);
        echo "

          </div>

          ";
        // line 142
        echo "          <div class=\"col-md-3 right-column\">

              <div class=\"row\">
                <div class=\"col-md-12\">

                  ";
        // line 147
        if (($context["is_combination_active"] ?? null)) {
            // line 148
            echo "                    <div class=\"form-group mb-3\" id=\"show_variations_selector\">
                      <h2>
                        ";
            // line 150
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "
                        <span class=\"help-box\" data-toggle=\"popover\"
                          data-content=\"";
            // line 152
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations are the different variations of a product, with attributes like its size, weight or color taking different values. Does your product require combinations?", [], "Admin.Catalog.Help"), "html", null, true);
            echo "\" ></span>
                      </h2>
                      <div class=\"radio\">
                        <label>
                          <input type=\"radio\" name=\"show_variations\" value=\"0\" ";
            // line 156
            if ( !($context["has_combinations"] ?? null)) {
                echo "checked=\"checked\"";
            }
            echo ">
                          ";
            // line 157
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Simple product", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "
                        </label>
                      </div>
                      <div class=\"radio\">
                        <label>
                          <input type=\"radio\" name=\"show_variations\" value=\"1\" ";
            // line 162
            if (($context["has_combinations"] ?? null)) {
                echo "checked=\"checked\"";
            }
            echo ">
                          ";
            // line 163
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Product with combinations", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "
                        </label>
                        <div id=\"product_type_combinations_shortcut\">
                          <span class=\"small font-secondary\">
                            ";
            // line 168
            echo "                            ";
            echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Advanced settings in [1][2]Combinations[/1]", [], "Admin.Catalog.Help"), ["[1]" => "<a href=\"#tab-step3\" onclick=\"\$('a[href=\\'#step3\\']').click();\" class=\"btn sensitive px-0\">", "[/1]" => "</a>", "[2]" => "<i class=\"material-icons\">open_in_new</i>"]);
            echo "
                          </span>
                        </div>
                      </div>
                    </div>
                  ";
        }
        // line 174
        echo "
                  <div class=\"form-group mb-4\">
                    <h2>
                      ";
        // line 177
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Reference", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 179
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Your reference code for this product. Allowed special characters: .-_#.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </h2>
                    ";
        // line 181
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formReference"] ?? null), 'errors');
        echo "
                    <div class=\"row\">
                      <div class=\"col-xl-12 col-lg-12\" id=\"product_reference_field\">
                          ";
        // line 184
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formReference"] ?? null), 'widget');
        echo "
                      </div>
                    </div>
                  </div>

                  ";
        // line 189
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 190
            echo "                    <div class=\"form-group mb-4\" id=\"product_qty_0_shortcut_div\">
                      <h2>
                        ";
            // line 192
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Quantity", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "
                        <span class=\"help-box\" data-toggle=\"popover\"
                          data-content=\"";
            // line 194
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("How many products should be available for sale?", [], "Admin.Catalog.Help"), "html", null, true);
            echo "\" ></span>
                      </h2>
                      ";
            // line 196
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formQuantityShortcut"] ?? null), 'errors');
            echo "
                      <div class=\"row\">
                        <div class=\"col-xl-6 col-lg-12\">
                          ";
            // line 199
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formQuantityShortcut"] ?? null), 'widget');
            echo "
                        </div>
                      </div>
                      <span class=\"small font-secondary\">
                        ";
            // line 204
            echo "                        ";
            echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Advanced settings in [1][2]Quantities[/1]", [], "Admin.Catalog.Help"), ["[1]" => "<a href=\"#tab-step3\" onclick=\"\$('a[href=\\'#step3\\']').click();\" class=\"btn sensitive px-0\">", "[/1]" => "</a>", "[2]" => "<i class=\"material-icons\">open_in_new</i>"]);
            echo "
                      </span>
                    </div>
                  ";
        }
        // line 208
        echo "
                  <div class=\"form-group mb-4\">
                    <h2>
                      ";
        // line 211
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Price", [], "Admin.Global"), "html", null, true);
        echo "
                      <span class=\"help-box\" data-toggle=\"popover\"
                        data-content=\"";
        // line 213
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This is the retail price at which you intend to sell this product to your customers. The tax included price will change according to the tax rule you select.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                    </h2>
                    <div class=\"row\">
                      <div class=\"col-md-6\">
                        <label class=\"form-control-label\">";
        // line 217
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tax excluded", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</label>
                        ";
        // line 218
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPriceShortcut"] ?? null), 'widget');
        echo "
                        ";
        // line 219
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPriceShortcut"] ?? null), 'errors');
        echo "
                      </div>
                      <div class=\"col-md-6 col-offset-md-1\">
                        <label class=\"form-control-label\">";
        // line 222
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tax included", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</label>
                        ";
        // line 223
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPriceShortcutTTC"] ?? null), 'widget');
        echo "
                        ";
        // line 224
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["formPriceShortcutTTC"] ?? null), 'errors');
        echo "
                      </div>
                      <div class=\"col-md-12 mt-1\">
                        <label class=\"form-control-label\">";
        // line 227
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tax rule", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</label>
                        ";
        // line 228
        echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment(Symfony\Bridge\Twig\Extension\HttpKernelExtension::controller("PrestaShopBundle:Admin/Common:renderField", ["formName" => "step2", "formType" => "PrestaShopBundle\\Form\\Admin\\Product\\ProductPrice", "fieldName" => "id_tax_rules_group", "fieldData" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 233
($context["form"] ?? null), "step2", []), "id_tax_rules_group", []), "vars", []), "value", [])]));
        // line 237
        echo "
                      </div>
                      <div class=\"col-md-12\">
                        <span class=\"small font-secondary\">
                          ";
        // line 242
        echo "                          ";
        echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Advanced settings in [1][2]Pricing[/1]", [], "Admin.Catalog.Help"), ["[1]" => "<a href=\"#tab-step2\" onclick=\"\$('a[href=\\'#step2\\']').click();\" class=\"btn sensitive px-0\">", "[/1]" => "</a>", "[2]" => "<i class=\"material-icons\">open_in_new</i>"]);
        echo "
                        </span>
                      </div>
                    </div>
                    <div class=\"row hide\">
                      <div class=\"col-md-12\">
                        <label>";
        // line 248
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tax rule", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</label>
                      </div>
                      <div class=\"clearfix\"></div>
                      <div class=\"col-md-11\" id=\"tax_rule_shortcut\">
                      </div>
                      <a href=\"#\" onclick=\"\$(this).parent().hide()\">&times;</a>
                    </div>
                  </div>

                  <div class=\"form-group mb-4\" id=\"categories\">
                    ";
        // line 258
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_categories.html.twig", ["form" => ($context["formCategories"] ?? null), "productId" => ($context["productId"] ?? null)]);
        echo "
                  </div>

                  ";
        // line 261
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsMainStepRightColumnBottom", ["id_product" => ($context["productId"] ?? null)]);
        echo "

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
    }

    // line 113
    public function block___internal_3a4e78afea0330a3e0353a10393f75bc6d628f2038d33b83b20fc94f4057cabc($context, array $blocks = [])
    {
        // line 114
        echo "                    ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_feature.html.twig", ["form" => $this->getAttribute($this->getAttribute(($context["formFeatures"] ?? null), "vars", []), "prototype", [])]);
        echo "
                  ";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Panels/essentials.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  526 => 114,  523 => 113,  508 => 261,  502 => 258,  489 => 248,  479 => 242,  473 => 237,  471 => 233,  470 => 228,  466 => 227,  460 => 224,  456 => 223,  452 => 222,  446 => 219,  442 => 218,  438 => 217,  431 => 213,  426 => 211,  421 => 208,  413 => 204,  406 => 199,  400 => 196,  395 => 194,  390 => 192,  386 => 190,  384 => 189,  376 => 184,  370 => 181,  365 => 179,  360 => 177,  355 => 174,  345 => 168,  338 => 163,  332 => 162,  324 => 157,  318 => 156,  311 => 152,  306 => 150,  302 => 148,  300 => 147,  293 => 142,  286 => 137,  280 => 134,  273 => 130,  264 => 124,  258 => 120,  241 => 118,  224 => 117,  220 => 115,  218 => 113,  212 => 110,  208 => 109,  204 => 108,  198 => 105,  191 => 101,  186 => 99,  180 => 96,  175 => 94,  166 => 88,  162 => 87,  155 => 82,  152 => 81,  145 => 79,  139 => 77,  137 => 76,  123 => 67,  118 => 65,  114 => 64,  110 => 63,  107 => 62,  102 => 61,  96 => 57,  93 => 56,  91 => 55,  85 => 52,  81 => 51,  76 => 49,  72 => 48,  64 => 43,  60 => 42,  56 => 41,  48 => 36,  44 => 35,  39 => 32,  31 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Panels/essentials.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Panels/essentials.html.twig");
    }
}
