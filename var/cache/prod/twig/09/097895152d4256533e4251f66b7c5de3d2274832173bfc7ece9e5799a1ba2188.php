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

/* @PrestaShop/Admin/Product/ProductPage/product.html.twig */
class __TwigTemplate_5c272700768e8d5928579ecaf64a66772fa1de05b62b445c2b54cbea96304817 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'content' => [$this, 'block_content'],
            'product_header' => [$this, 'block_product_header'],
            'product_tabs_container' => [$this, 'block_product_tabs_container'],
            'product_panel_essentials' => [$this, 'block_product_panel_essentials'],
            'product_panel_combinations' => [$this, 'block_product_panel_combinations'],
            'product_panel_shipping' => [$this, 'block_product_panel_shipping'],
            'product_panel_pricing' => [$this, 'block_product_panel_pricing'],
            'product_panel_seo' => [$this, 'block_product_panel_seo'],
            'product_panel_options' => [$this, 'block_product_panel_options'],
            'product_panel_modules' => [$this, 'block_product_panel_modules'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 25
        return "@PrestaShop/Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 338
        $context["js_translatable"] = twig_array_merge(["Are you sure to disable variations ? they will all be deleted" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This will delete all the combinations. Do you wish to proceed?", [], "Admin.Catalog.Notification")],         // line 340
($context["js_translatable"] ?? null));
        // line 342
        $context["js_translatable"] = twig_array_merge(["Form update success" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Settings updated.", [], "Admin.Notifications.Success"), "Form update errors" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Unable to update settings.", [], "Admin.Notifications.Error"), "Delete" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete", [], "Admin.Actions"), "ToLargeFile" => twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The file is too large. Maximum size allowed is: [1] MB. The file you are trying to upload is [2] MB.", [], "Admin.Notifications.Error"), ["[1]" => "{{maxFilesize}}", "[2]" => "{{filesize}}"]), "Drop images here" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Drop images here", [], "Admin.Catalog.Feature"), "or select files" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("or select files", [], "Admin.Catalog.Feature"), "files recommandations" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Recommended size 800 x 800px for default theme.", [], "Admin.Catalog.Feature"), "files recommandations2" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("JPG, GIF or PNG format.", [], "Admin.Catalog.Feature"), "Cover" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Cover", [], "Admin.Catalog.Feature"), "Are you sure you want to delete this item?" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Are you sure you want to delete this item?", [], "Admin.Notifications.Warning"), "Quantities" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Quantities", [], "Admin.Catalog.Feature"), "Combinations" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations", [], "Admin.Catalog.Feature"), "Virtual product" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Virtual product", [], "Admin.Catalog.Feature"), "tax incl." => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("tax incl.", [], "Admin.Catalog.Feature"), "tax excl." => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("tax excl.", [], "Admin.Catalog.Feature"), "You can't create pack product with variations. Are you sure to disable variations ? they will all be deleted." => (($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("A pack of products can't have combinations.", [], "Admin.Catalog.Notification") . " ") . $this->getAttribute(        // line 358
($context["js_translatable"] ?? null), "Are you sure to disable variations ? they will all be deleted", [], "array")), "You can't create virtual product with variations. Are you sure to disable variations ? they will all be deleted." => (($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("A virtual product can't have combinations.", [], "Admin.Catalog.Notification") . " ") . $this->getAttribute(        // line 359
($context["js_translatable"] ?? null), "Are you sure to disable variations ? they will all be deleted", [], "array")), "Are you sure you want to delete the selected item(s)?" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Are you sure you want to delete the selected item(s)?", [], "Admin.Global")],         // line 361
($context["js_translatable"] ?? null));
        // line 25
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/layout.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 25);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 27
    public function block_stylesheets($context, array $blocks = [])
    {
        // line 28
        echo "  <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/product.css"), "html", null, true);
        echo "\" type=\"text/css\" media=\"all\">
";
    }

    // line 31
    public function block_content($context, array $blocks = [])
    {
        // line 32
        echo "  ";
        $context["hooks"] = $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHooksArray("displayAdminProductsExtra", ["id_product" => ($context["id_product"] ?? null)]);
        // line 33
        echo "  <div class=\"header-toolbar d-print-none\">
    ";
        // line 34
        echo $this->env->getExtension('PrestaShopBundle\Twig\Extension\MultistoreHeaderExtension')->getMultistoreHeader();
        echo "
  </div>
  <form name=\"form\" id=\"form\" method=\"post\" class=\"form-horizontal product-page row justify-content-md-center\" novalidate=\"novalidate\">

    ";
        // line 38
        if ( !($context["editable"] ?? null)) {
            echo " <fieldset disabled id=\"field-disabled\"> ";
        }
        // line 39
        echo "    ";
        // line 40
        echo "    ";
        $this->displayBlock('product_header', $context, $blocks);
        // line 52
        echo "
    <div class=\"col-md-10\">
      <div id=\"form_bubbling_errors\">
        ";
        // line 55
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        echo "
      </div>
    </div>

    <div id=\"form-loading\" class=\"col-xxl-10\">
      ";
        // line 61
        echo "      ";
        $this->displayBlock('product_tabs_container', $context, $blocks);
        // line 64
        echo "      <div id=\"form_content\" class=\"tab-content\">

        ";
        // line 67
        echo "        ";
        $this->displayBlock('product_panel_essentials', $context, $blocks);
        // line 88
        echo "
        ";
        // line 90
        echo "        ";
        $this->displayBlock('product_panel_combinations', $context, $blocks);
        // line 112
        echo "
        ";
        // line 114
        echo "        ";
        $this->displayBlock('product_panel_shipping', $context, $blocks);
        // line 133
        echo "
        ";
        // line 135
        echo "        ";
        $this->displayBlock('product_panel_pricing', $context, $blocks);
        // line 142
        echo "
        ";
        // line 144
        echo "        ";
        $this->displayBlock('product_panel_seo', $context, $blocks);
        // line 150
        echo "
        ";
        // line 152
        echo "        ";
        $this->displayBlock('product_panel_options', $context, $blocks);
        // line 158
        echo "
        ";
        // line 160
        echo "        ";
        $this->displayBlock('product_panel_modules', $context, $blocks);
        // line 254
        echo "      </div>

      ";
        // line 256
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "id_product", []), 'widget');
        echo "
      ";
        // line 257
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", []), 'widget');
        echo "

    </div>
    ";
        // line 261
        echo "    ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/footer.html.twig", ["preview_link" =>         // line 262
($context["preview_link"] ?? null), "preview_link_deactivate" =>         // line 263
($context["preview_link_deactivate"] ?? null), "is_shop_context" =>         // line 264
($context["is_shop_context"] ?? null), "editable" =>         // line 265
($context["editable"] ?? null), "is_active" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 266
($context["form"] ?? null), "step1", []), "vars", []), "value", []), "active", []), "productId" =>         // line 267
($context["id_product"] ?? null)]);
        // line 268
        echo "
    ";
        // line 269
        if ( !($context["editable"] ?? null)) {
            echo " </fieldset> ";
        }
        // line 270
        echo "  </form>


  ";
        // line 273
        $this->loadTemplate("@PrestaShop/Admin/Product/ProductPage/product.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 273, "1214027901")->display(twig_array_merge($context, ["id" => "confirmation_modal", "title" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Warning", [], "Admin.Notifications.Warning"), "closable" => false, "actions" => [0 => ["type" => "button", "label" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No", [], "Admin.Global"), "class" => "btn btn-outline-secondary btn-lg cancel"], 1 => ["type" => "button", "label" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Yes", [], "Admin.Global"), "class" => "btn btn-primary btn-lg continue"]]]));
        // line 294
        echo "
";
    }

    // line 40
    public function block_product_header($context, array $blocks = [])
    {
        // line 41
        echo "      ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/header.html.twig", ["formName" => $this->getAttribute($this->getAttribute(        // line 42
($context["form"] ?? null), "step1", []), "name", []), "formType" => $this->getAttribute($this->getAttribute(        // line 43
($context["form"] ?? null), "step1", []), "type_product", []), "is_multishop_context" =>         // line 44
($context["is_multishop_context"] ?? null), "languages" =>         // line 45
($context["languages"] ?? null), "help_link" =>         // line 46
($context["help_link"] ?? null), "stats_link" =>         // line 47
($context["stats_link"] ?? null), "isCreationMode" =>         // line 48
($context["isCreationMode"] ?? null)]);
        // line 50
        echo "
    ";
    }

    // line 61
    public function block_product_tabs_container($context, array $blocks = [])
    {
        // line 62
        echo "        ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/tabs.html.twig", ["hooks" => ($context["hooks"] ?? null)]);
        echo "
      ";
    }

    // line 67
    public function block_product_panel_essentials($context, array $blocks = [])
    {
        // line 68
        echo "          ";
        $context["formQuantityShortcut"] = (($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step1", [], "any", false, true), "qty_0_shortcut", [], "any", true, true)) ? ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step1", []), "qty_0_shortcut", [])) : (null));
        // line 69
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/essentials.html.twig", ["formPackItems" => $this->getAttribute($this->getAttribute(        // line 70
($context["form"] ?? null), "step1", []), "inputPackItems", []), "productId" =>         // line 71
($context["id_product"] ?? null), "images" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 72
($context["form"] ?? null), "step1", []), "vars", []), "value", []), "images", []), "formShortDescription" => $this->getAttribute($this->getAttribute(        // line 73
($context["form"] ?? null), "step1", []), "description_short", []), "formDescription" => $this->getAttribute($this->getAttribute(        // line 74
($context["form"] ?? null), "step1", []), "description", []), "formFeatures" => $this->getAttribute($this->getAttribute(        // line 75
($context["form"] ?? null), "step1", []), "features", []), "formManufacturer" => $this->getAttribute($this->getAttribute(        // line 76
($context["form"] ?? null), "step1", []), "id_manufacturer", []), "formRelatedProducts" => $this->getAttribute($this->getAttribute(        // line 77
($context["form"] ?? null), "step1", []), "related_products", []), "is_combination_active" =>         // line 78
($context["is_combination_active"] ?? null), "has_combinations" =>         // line 79
($context["has_combinations"] ?? null), "formReference" => $this->getAttribute($this->getAttribute(        // line 80
($context["form"] ?? null), "step6", []), "reference", []), "formQuantityShortcut" =>         // line 81
($context["formQuantityShortcut"] ?? null), "formPriceShortcut" => $this->getAttribute($this->getAttribute(        // line 82
($context["form"] ?? null), "step1", []), "price_shortcut", []), "formPriceShortcutTTC" => $this->getAttribute($this->getAttribute(        // line 83
($context["form"] ?? null), "step1", []), "price_ttc_shortcut", []), "formCategories" => $this->getAttribute(        // line 84
($context["form"] ?? null), "step1", [])]);
        // line 86
        echo "
        ";
    }

    // line 90
    public function block_product_panel_combinations($context, array $blocks = [])
    {
        // line 91
        echo "          ";
        $context["formStockQuantity"] = (($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step3", [], "any", false, true), "qty_0", [], "any", true, true)) ? ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step3", []), "qty_0", [])) : (null));
        // line 92
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/combinations.html.twig", ["formDependsOnStocks" => $this->getAttribute($this->getAttribute(        // line 93
($context["form"] ?? null), "step3", []), "depends_on_stock", []), "productId" =>         // line 94
($context["id_product"] ?? null), "formStockQuantity" =>         // line 95
($context["formStockQuantity"] ?? null), "formStockMinimalQuantity" => $this->getAttribute($this->getAttribute(        // line 96
($context["form"] ?? null), "step3", []), "minimal_quantity", []), "formLowStockThreshold" => $this->getAttribute($this->getAttribute(        // line 97
($context["form"] ?? null), "step3", []), "low_stock_threshold", []), "formLocation" => $this->getAttribute($this->getAttribute(        // line 98
($context["form"] ?? null), "step3", []), "location", []), "formLowStockAlert" => $this->getAttribute($this->getAttribute(        // line 99
($context["form"] ?? null), "step3", []), "low_stock_alert", []), "formVirtualProduct" => $this->getAttribute($this->getAttribute(        // line 100
($context["form"] ?? null), "step3", []), "virtual_product", []), "asm_globally_activated" =>         // line 101
($context["asm_globally_activated"] ?? null), "formType" => $this->getAttribute($this->getAttribute(        // line 102
($context["form"] ?? null), "step1", []), "type_product", []), "formAdvancedStockManagement" => $this->getAttribute($this->getAttribute(        // line 103
($context["form"] ?? null), "step3", []), "advanced_stock_management", []), "formPackStockType" => $this->getAttribute($this->getAttribute(        // line 104
($context["form"] ?? null), "step3", []), "pack_stock_type", []), "formStep3" => $this->getAttribute(        // line 105
($context["form"] ?? null), "step3", []), "formCombinations" =>         // line 106
($context["formCombinations"] ?? null), "has_combinations" =>         // line 107
($context["has_combinations"] ?? null), "max_upload_size" =>         // line 108
($context["max_upload_size"] ?? null)]);
        // line 110
        echo "
        ";
    }

    // line 114
    public function block_product_panel_shipping($context, array $blocks = [])
    {
        // line 115
        echo "          <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step4\">
            <div class=\"row\">
              <div class=\"col-md-12\">
                <div class=\"container-fluid\">
                  <div class=\"row\">
                    ";
        // line 120
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_shipping.html.twig", ["form" => $this->getAttribute(        // line 121
($context["form"] ?? null), "step4", []), "asm_globally_activated" =>         // line 122
($context["asm_globally_activated"] ?? null), "isNotVirtual" => ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 123
($context["form"] ?? null), "step1", []), "type_product", []), "vars", []), "value", []) != "2"), "isChecked" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 124
($context["form"] ?? null), "step3", []), "advanced_stock_management", []), "vars", []), "checked", []), "warehouses" =>         // line 125
($context["warehouses"] ?? null)]);
        // line 126
        echo "
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
    }

    // line 135
    public function block_product_panel_pricing($context, array $blocks = [])
    {
        // line 136
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/pricing.html.twig", ["pricingForm" => $this->getAttribute(        // line 137
($context["form"] ?? null), "step2", []), "is_multishop_context" =>         // line 138
($context["is_multishop_context"] ?? null), "productId" =>         // line 139
($context["id_product"] ?? null)]);
        // line 140
        echo "
        ";
    }

    // line 144
    public function block_product_panel_seo($context, array $blocks = [])
    {
        // line 145
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/seo.html.twig", ["seoForm" => $this->getAttribute(        // line 146
($context["form"] ?? null), "step5", []), "productId" =>         // line 147
($context["id_product"] ?? null)]);
        // line 148
        echo "
        ";
    }

    // line 152
    public function block_product_panel_options($context, array $blocks = [])
    {
        // line 153
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/options.html.twig", ["optionsForm" => $this->getAttribute(        // line 154
($context["form"] ?? null), "step6", []), "productId" =>         // line 155
($context["id_product"] ?? null)]);
        // line 156
        echo "
        ";
    }

    // line 160
    public function block_product_panel_modules($context, array $blocks = [])
    {
        // line 161
        echo "          ";
        if ( !twig_test_empty($this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->hooksArrayContent(($context["hooks"] ?? null)))) {
            // line 162
            echo "            <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"hooks\">
              <div class=\"row\">
                <div class=\"col-md-12\">
                  <div class=\"container-fluid\">
                    <div class=\"row\">

                      ";
            // line 169
            echo "                      <div class=\"col-md-12\">
                        <div class=\"row module-selection\" style=\"display: none;\">
                          <div class=\"col-md-12 col-lg-7\">
                            ";
            // line 172
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 173
                echo "                              <div class=\"module-render-container module-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "name", []), "html", null, true);
                echo "\">
                                <div>
                                  <img class=\"top-logo\" src=\"";
                // line 175
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "img", []), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "displayName", []), "html", null, true);
                echo "\">
                                  <h2 class=\"text-ellipsis module-name-grid\">
                                    ";
                // line 177
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "displayName", []), "html", null, true);
                echo "
                                  </h2>
                                  <div class=\"text-ellipsis small-text module-version\">
                                    ";
                // line 180
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "version", []), "html", null, true);
                echo " by ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "author", []), "html", null, true);
                echo "
                                  </div>
                                </div>
                                <div class=\"small no-padding\">
                                  ";
                // line 184
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "description", []), "html", null, true);
                echo "
                                </div>
                              </div>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 188
            echo "                          </div>
                          <div class=\"col-md-12 col-lg-5\">
                            <h2>";
            // line 190
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Module to configure", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "</h2>
                            <select class=\"modules-list-select\" data-toggle=\"select2\">
                              ";
            // line 192
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 193
                echo "                                <option value=\"module-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "name", []), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "displayName", []), "html", null, true);
                echo "</option>
                              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 195
            echo "                            </select>
                          </div>
                        </div>

                        <div class=\"module-render-container all-modules\">
                          <p>
                            <h2>";
            // line 201
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Choose a module to configure", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "</h2>
                            ";
            // line 202
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("These modules are relative to the product page of your shop.", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "<br />
                            ";
            // line 203
            echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("To manage all your modules go to the [1]Installed module page[/1]", [], "Admin.Catalog.Feature"), ["[1]" => (("<a href=\"" . $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_module_manage")) . "\">"), "[/1]" => "</a>"]);
            echo "
                          </p>
                          <div class=\"row\">
                            ";
            // line 206
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 207
                echo "                              <div class=\"col-md-12 col-lg-6 col-xl-4\">
                                <div class=\"module-item-wrapper-grid\">
                                  <div class=\"module-item-heading-grid\">
                                    <img class=\"module-logo-thumb-grid\" src=\"";
                // line 210
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "img", []), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "displayName", []), "html", null, true);
                echo "\">
                                    <h3 class=\"text-ellipsis module-name-grid\">
                                      ";
                // line 212
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "displayName", []), "html", null, true);
                echo "
                                    </h3>
                                    <div class=\"text-ellipsis small-text module-version-author-grid\">
                                      ";
                // line 215
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "version", []), "html", null, true);
                echo " by ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "author", []), "html", null, true);
                echo "
                                    </div>
                                  </div>
                                  <div class=\"module-quick-description-grid small no-padding\">
                                    ";
                // line 219
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "description", []), "html", null, true);
                echo "
                                  </div>
                                  <div class=\"module-container\">
                                    <div class=\"module-quick-action-grid clearfix\">
                                      <button class=\"modules-list-button btn btn-outline-primary pull-xs-right\" data-target=\"module-";
                // line 223
                echo twig_escape_filter($this->env, $this->getAttribute($context["module"], "id", []), "html", null, true);
                echo "\">
                                        ";
                // line 224
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Configure", [], "Admin.Actions"), "html", null, true);
                echo "
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 231
            echo "                          </div>
                        </div>

                        ";
            // line 234
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 235
                echo "                          <div
                            id=\"module_";
                // line 236
                echo twig_escape_filter($this->env, $this->getAttribute($context["module"], "id", []), "html", null, true);
                echo "\"
                            class=\"module-render-container module-";
                // line 237
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", []), "name", []), "html", null, true);
                echo "\"
                            style=\"display: none;\"
                          >
                            <div>
                              ";
                // line 241
                echo $this->getAttribute($context["module"], "content", []);
                echo "
                            </div>
                          </div>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 245
            echo "                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
        // line 253
        echo "        ";
    }

    // line 297
    public function block_javascripts($context, array $blocks = [])
    {
        // line 298
        echo "  ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "

  <script src=\"";
        // line 300
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/catalog_product.bundle.js"), "html", null, true);
        echo "\"></script>

  <script src=\"";
        // line 302
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-manufacturer.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 303
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-related.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 304
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-category-tags.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 305
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/default-category.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 306
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-combinations.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 307
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/category-tree.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 308
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/modal-confirmation.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 309
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/product_page.bundle.js"), "html", null, true);
        echo "\"></script>

  <script src=\"";
        // line 311
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/form.js"), "html", null, true);
        echo "\"></script>

  <script src=\"";
        // line 313
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/tiny_mce/tiny_mce.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 314
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/admin/tinymce.inc.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 315
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/admin/tinymce_loader.js"), "html", null, true);
        echo "\"></script>

  <script>
      \$(function() {
        var editable = '";
        // line 319
        echo twig_escape_filter($this->env, ($context["editable"] ?? null), "html", null, true);
        echo "';

        if (editable !== '1'){
          \$('#field-disabled').find(\"select\").each(function() {
            \$(this).removeClass('select2-hidden-accessible');
          });
          \$('#field-disabled').find(\"span.select2\").each(function() {
            \$(this).hide();
          });
          \$('#field-disabled').find(\"a.pstaggerClosingCross\").each(function() {
            \$(this).attr(\"disabled\", \"disabled\").on(\"click\", function() {
              return false;
            });
          });
        }
      });
  </script>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Product/ProductPage/product.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  625 => 319,  618 => 315,  614 => 314,  610 => 313,  605 => 311,  600 => 309,  596 => 308,  592 => 307,  588 => 306,  584 => 305,  580 => 304,  576 => 303,  572 => 302,  567 => 300,  561 => 298,  558 => 297,  554 => 253,  544 => 245,  534 => 241,  527 => 237,  523 => 236,  520 => 235,  516 => 234,  511 => 231,  498 => 224,  494 => 223,  487 => 219,  478 => 215,  472 => 212,  465 => 210,  460 => 207,  456 => 206,  450 => 203,  446 => 202,  442 => 201,  434 => 195,  423 => 193,  419 => 192,  414 => 190,  410 => 188,  400 => 184,  391 => 180,  385 => 177,  378 => 175,  372 => 173,  368 => 172,  363 => 169,  355 => 162,  352 => 161,  349 => 160,  344 => 156,  342 => 155,  341 => 154,  339 => 153,  336 => 152,  331 => 148,  329 => 147,  328 => 146,  326 => 145,  323 => 144,  318 => 140,  316 => 139,  315 => 138,  314 => 137,  312 => 136,  309 => 135,  299 => 126,  297 => 125,  296 => 124,  295 => 123,  294 => 122,  293 => 121,  292 => 120,  285 => 115,  282 => 114,  277 => 110,  275 => 108,  274 => 107,  273 => 106,  272 => 105,  271 => 104,  270 => 103,  269 => 102,  268 => 101,  267 => 100,  266 => 99,  265 => 98,  264 => 97,  263 => 96,  262 => 95,  261 => 94,  260 => 93,  258 => 92,  255 => 91,  252 => 90,  247 => 86,  245 => 84,  244 => 83,  243 => 82,  242 => 81,  241 => 80,  240 => 79,  239 => 78,  238 => 77,  237 => 76,  236 => 75,  235 => 74,  234 => 73,  233 => 72,  232 => 71,  231 => 70,  229 => 69,  226 => 68,  223 => 67,  216 => 62,  213 => 61,  208 => 50,  206 => 48,  205 => 47,  204 => 46,  203 => 45,  202 => 44,  201 => 43,  200 => 42,  198 => 41,  195 => 40,  190 => 294,  188 => 273,  183 => 270,  179 => 269,  176 => 268,  174 => 267,  173 => 266,  172 => 265,  171 => 264,  170 => 263,  169 => 262,  167 => 261,  161 => 257,  157 => 256,  153 => 254,  150 => 160,  147 => 158,  144 => 152,  141 => 150,  138 => 144,  135 => 142,  132 => 135,  129 => 133,  126 => 114,  123 => 112,  120 => 90,  117 => 88,  114 => 67,  110 => 64,  107 => 61,  99 => 55,  94 => 52,  91 => 40,  89 => 39,  85 => 38,  78 => 34,  75 => 33,  72 => 32,  69 => 31,  62 => 28,  59 => 27,  54 => 25,  52 => 361,  51 => 359,  50 => 358,  49 => 342,  47 => 340,  46 => 338,  40 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/product.html.twig");
    }
}


/* @PrestaShop/Admin/Product/ProductPage/product.html.twig */
class __TwigTemplate_5c272700768e8d5928579ecaf64a66772fa1de05b62b445c2b54cbea96304817___1214027901 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 273
        return "@PrestaShop/Admin/Helpers/bootstrap_popup.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/Helpers/bootstrap_popup.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 273);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 290
    public function block_content($context, array $blocks = [])
    {
        // line 291
        echo "      <div class=\"modal-body\"></div>
    ";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Product/ProductPage/product.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  704 => 291,  701 => 290,  691 => 273,  625 => 319,  618 => 315,  614 => 314,  610 => 313,  605 => 311,  600 => 309,  596 => 308,  592 => 307,  588 => 306,  584 => 305,  580 => 304,  576 => 303,  572 => 302,  567 => 300,  561 => 298,  558 => 297,  554 => 253,  544 => 245,  534 => 241,  527 => 237,  523 => 236,  520 => 235,  516 => 234,  511 => 231,  498 => 224,  494 => 223,  487 => 219,  478 => 215,  472 => 212,  465 => 210,  460 => 207,  456 => 206,  450 => 203,  446 => 202,  442 => 201,  434 => 195,  423 => 193,  419 => 192,  414 => 190,  410 => 188,  400 => 184,  391 => 180,  385 => 177,  378 => 175,  372 => 173,  368 => 172,  363 => 169,  355 => 162,  352 => 161,  349 => 160,  344 => 156,  342 => 155,  341 => 154,  339 => 153,  336 => 152,  331 => 148,  329 => 147,  328 => 146,  326 => 145,  323 => 144,  318 => 140,  316 => 139,  315 => 138,  314 => 137,  312 => 136,  309 => 135,  299 => 126,  297 => 125,  296 => 124,  295 => 123,  294 => 122,  293 => 121,  292 => 120,  285 => 115,  282 => 114,  277 => 110,  275 => 108,  274 => 107,  273 => 106,  272 => 105,  271 => 104,  270 => 103,  269 => 102,  268 => 101,  267 => 100,  266 => 99,  265 => 98,  264 => 97,  263 => 96,  262 => 95,  261 => 94,  260 => 93,  258 => 92,  255 => 91,  252 => 90,  247 => 86,  245 => 84,  244 => 83,  243 => 82,  242 => 81,  241 => 80,  240 => 79,  239 => 78,  238 => 77,  237 => 76,  236 => 75,  235 => 74,  234 => 73,  233 => 72,  232 => 71,  231 => 70,  229 => 69,  226 => 68,  223 => 67,  216 => 62,  213 => 61,  208 => 50,  206 => 48,  205 => 47,  204 => 46,  203 => 45,  202 => 44,  201 => 43,  200 => 42,  198 => 41,  195 => 40,  190 => 294,  188 => 273,  183 => 270,  179 => 269,  176 => 268,  174 => 267,  173 => 266,  172 => 265,  171 => 264,  170 => 263,  169 => 262,  167 => 261,  161 => 257,  157 => 256,  153 => 254,  150 => 160,  147 => 158,  144 => 152,  141 => 150,  138 => 144,  135 => 142,  132 => 135,  129 => 133,  126 => 114,  123 => 112,  120 => 90,  117 => 88,  114 => 67,  110 => 64,  107 => 61,  99 => 55,  94 => 52,  91 => 40,  89 => 39,  85 => 38,  78 => 34,  75 => 33,  72 => 32,  69 => 31,  62 => 28,  59 => 27,  54 => 25,  52 => 361,  51 => 359,  50 => 358,  49 => 342,  47 => 340,  46 => 338,  40 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/product.html.twig");
    }
}
