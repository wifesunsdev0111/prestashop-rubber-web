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

/* @Product/ProductPage/Forms/form_combination.html.twig */
class __TwigTemplate_e8e4d938cd6977ce8af6828af608950bfd793ad4736663ea9590efb4f73563e3 extends \Twig\Template
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
        echo "<tr class=\"combination loaded\" id=\"attribute_";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" data=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" data-index=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\">
  <td width=\"1%\"><input class=\"js-combination\" type=\"checkbox\" data-id=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" data-index=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\"></td>
  <td class=\"img\"><div class=\"fake-img\"></div></td>
    <td>";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "name", []), "html", null, true);
        echo "</td>
    <td class=\"attribute-price\">
        <div class=\"input-group\">
            <div class=\"input-group-prepend\">
                <span class=\"input-group-text\">";
        // line 32
        echo twig_escape_filter($this->env, ($context["default_currency_symbol"] ?? null), "html", null, true);
        echo "</span>
            </div>
            <input type=\"text\" class=\"attribute_priceTE form-control text-sm-right\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "attribute_price", []), "html", null, true);
        echo "\">
        </div>
    </td>
    <td class=\"attribute-finalprice text-sm-right\">
      <div>
        <span class=\"final-price\" data-price=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price", []), "html", null, true);
        echo "\" data-uniqid=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price", []), "html", null, true);
        echo "</span> ";
        echo twig_escape_filter($this->env, ($context["default_currency_symbol"] ?? null), "html", null, true);
        echo "
      </div>
      ";
        // line 41
        if (($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_USE_ECOTAX") != 0)) {
            // line 42
            echo "        ";
            $context["attributeEcotax"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "attribute_ecotax", []);
            // line 43
            echo "        ";
            if ((($context["attributeEcotax"] ?? null) == 0)) {
                // line 44
                echo "          ";
                $context["attributeEcotax"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "product_ecotax", []);
                // line 45
                echo "        ";
            }
            // line 46
            echo "        <div class=\"attribute-ecotax-preview";
            if ((($context["attributeEcotax"] ?? null) == 0)) {
                echo " d-none";
            }
            echo "\">
          ";
            // line 47
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Ecotax", [], "Admin.Catalog.Feature"), "html", null, true);
            echo "
          <span class=\"attribute-ecotax\">";
            // line 48
            echo twig_escape_filter($this->env, twig_round(($context["attributeEcotax"] ?? null), 2), "html", null, true);
            echo "</span> ";
            echo twig_escape_filter($this->env, ($context["default_currency_symbol"] ?? null), "html", null, true);
            echo "
        </div>
      ";
        }
        // line 51
        echo "    </td>
    ";
        // line 52
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 53
            echo "      <td class=\"attribute-quantity\">
          <div>
              <input type=\"text\" value=\"";
            // line 55
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "attribute_quantity", []), "html", null, true);
            echo "\" class=\"form-control text-sm-right\">
          </div>
      </td>
    ";
        }
        // line 59
        echo "
    <td class=\"attribute-actions\">
        <div class=\"btn-group btn-group-sm\" role=\"group\">
            <a href=\"#combination_form_";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" class=\"btn btn-open tooltip-link btn-sm\"><i class=\"material-icons\">mode_edit</i></a>
        </div>
        <div id=\"combination_form_";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" data=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\" class=\"combination-form hide row\">
            <div class=\"col-sm-12 nav\">
                ";
        // line 67
        echo "                <a class=\"btn-sensitive prev\"><i class=\"material-icons\">keyboard_arrow_left</i> ";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Prev. combination", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</a>
                <a class=\"next btn-sensitive\">";
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Next combination", [], "Admin.Catalog.Feature"), "html", null, true);
        echo " <i class=\"material-icons\">keyboard_arrow_right</i></a>
            </div>
            <div class=\"panel col-md-12 p-2\">
                <div class=\"float-left\">
                    <button type=\"button\" class=\"back-to-product btn btn-outline-secondary btn-back\"><i class=\"material-icons\">arrow_back</i> ";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Back to product", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "</button>
                </div>
                <h2 class=\"title pt-2\">
                  ";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combination details", [], "Admin.Catalog.Feature"), "html", null, true);
        echo " -
                  ";
        // line 76
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "name", []), "html", null, true);
        echo "
                </h2>
                ";
        // line 78
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_default", []), 'widget');
        echo "
                <div class=\"row\">
                  ";
        // line 80
        if ($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_STOCK_MANAGEMENT")) {
            // line 81
            echo "                    <div class=\"col-md-2\">
                      <fieldset class=\"form-group\">
                          <label class=\"form-control-label\">
                            ";
            // line 84
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_quantity", []), "vars", []), "label", []), "html", null, true);
            echo "
                          </label>
                          ";
            // line 86
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_quantity", []), 'errors');
            echo "
                          ";
            // line 87
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_quantity", []), 'widget');
            echo "
                      </fieldset>
                    </div>
                  ";
        }
        // line 91
        echo "                    <div class=\"col-md-3\">
                      <fieldset class=\"form-group\">
                          <label class=\"form-control-label\">";
        // line 93
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "available_date_attribute", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                          ";
        // line 94
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_date_attribute", []), 'errors');
        echo "
                          ";
        // line 95
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "available_date_attribute", []), 'widget');
        echo "
                      </fieldset>
                    </div>
                    <div class=\"col-md-2\">
                      <fieldset class=\"form-group\">
                          <label class=\"form-control-label\">
                            ";
        // line 101
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_minimal_quantity", []), "vars", []), "label", []), "html", null, true);
        echo "
                            <span class=\"help-box\" data-toggle=\"popover\"
                              data-content=\"";
        // line 103
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The minimum quantity required to buy this product (set to 1 to disable this feature). E.g.: if set to 3, customers will be able to purchase the product only if they take at least 3 in quantity.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                          </label>
                          ";
        // line 105
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_minimal_quantity", []), 'errors');
        echo "
                          ";
        // line 106
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_minimal_quantity", []), 'widget');
        echo "
                      </fieldset>
                    </div>
                    <div class=\"col-md-4\">
                      <fieldset class=\"form-group\">
                          <label class=\"form-control-label\">";
        // line 111
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_reference", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                          ";
        // line 112
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_reference", []), 'errors');
        echo "
                          ";
        // line 113
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_reference", []), 'widget');
        echo "
                      </fieldset>
                    </div>
                </div>
                <h2 class=\"title\">
                  ";
        // line 118
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Stock", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                </h2>
                <div class=\"row\">
                  <div class=\"col-md-3\">
                    <fieldset class=\"form-group\">
                      <label class=\"form-control-label\">";
        // line 123
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_location", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                      ";
        // line 124
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_location", []), 'errors');
        echo "
                      ";
        // line 125
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_location", []), 'widget');
        echo "
                    </fieldset>
                  </div>
                  <div class=\"col-md-3\">
                    <fieldset class=\"form-group\">
                      <label class=\"form-control-label\">";
        // line 130
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_low_stock_threshold", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                      ";
        // line 131
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_low_stock_threshold", []), 'errors');
        echo "
                      ";
        // line 132
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_low_stock_threshold", []), 'widget');
        echo "
                    </fieldset>
                  </div>
                  <div class=\"col-md-9\">
                    <fieldset class=\"form-group widget-checkbox-inline\">
                      <label class=\"form-control-label\">&nbsp;</label>
                      <div class=\"widget-checkbox-inline\">
                        ";
        // line 139
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_low_stock_alert", []), 'errors');
        echo "
                        ";
        // line 140
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_low_stock_alert", []), 'widget');
        echo "
                        <span class=\"help-box\" data-toggle=\"popover\" data-html=\"true\" data-content=\"";
        // line 141
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The email will be sent to all the users who have the right to run the stock page. To modify the permissions, go to [1]Advanced Parameters > Team[/1]", ["[1]" => (("<a href=&quot;" . $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminEmployees")) . "&quot;>"), "[/1]" => "</a>"], "Admin.Catalog.Help");
        echo "\" ></span>
                      </div>
                    </fieldset>
                  </div>
                </div>
                <h2 class=\"title\">
                  ";
        // line 147
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Price and impact", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                </h2>
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 152
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_wholesale_price", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 153
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_wholesale_price", []), 'errors');
        echo "
                            ";
        // line 154
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_wholesale_price", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-3\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">
                              ";
        // line 160
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_price", []), "vars", []), "label", []), "html", null, true);
        echo "
                              <span class=\"help-box\" data-toggle=\"popover\"
                                data-content=\"";
        // line 162
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Does this combination have a different price? Is it cheaper or more expensive than the default retail price?", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                            </label>
                            ";
        // line 164
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_price", []), 'errors');
        echo "
                            ";
        // line 165
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_price", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-3\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 170
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_priceTI", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 171
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_priceTI", []), 'errors');
        echo "
                            ";
        // line 172
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_priceTI", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-3\">
                      <div class=\"form-control-label vcenter\">";
        // line 176
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Final retail price (tax excl.) will be", [], "Admin.Catalog.Feature"), "html", null, true);
        echo " <span class=\"final-price\" data-price=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price", []), "html", null, true);
        echo "\" data-uniqid=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price", []), "html", null, true);
        echo "</span> ";
        echo twig_escape_filter($this->env, ($context["default_currency_symbol"] ?? null), "html", null, true);
        echo "</div>
                      <div class=\"form-control-label vcenter\">";
        // line 177
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Final retail price (tax incl.) will be", [], "Admin.Catalog.Feature"), "html", null, true);
        echo " <span class=\"final-price-tax-included\" data-price=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price_tax_included", []), "html", null, true);
        echo "\" data-uniqid=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "final_price_tax_included", []), "html", null, true);
        echo "</span> ";
        echo twig_escape_filter($this->env, ($context["default_currency_symbol"] ?? null), "html", null, true);
        echo "</div>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"col-md-3 ";
        // line 181
        if (($this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_USE_ECOTAX") != 1)) {
            echo "hide";
        }
        echo "\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 183
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_ecotax", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 184
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_ecotax", []), 'errors');
        echo "
                            ";
        // line 185
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_ecotax", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-3\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">
                              ";
        // line 191
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_unity", []), "vars", []), "label", []), "html", null, true);
        echo "
                              <span class=\"help-box\" data-toggle=\"popover\"
                                data-content=\"";
        // line 193
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Does this combination have a different price per unit?", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "\" ></span>
                            </label>
                            ";
        // line 195
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_unity", []), 'errors');
        echo "
                            ";
        // line 196
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_unity", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-3\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 201
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_weight", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            <div class=\"input-group\">
                                <div class=\"input-group-prepend\">
                                    <span class=\"input-group-text\">";
        // line 204
        echo twig_escape_filter($this->env, $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getConfiguration("PS_WEIGHT_UNIT"), "html", null, true);
        echo "</span>
                                </div>
                                ";
        // line 206
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_weight", []), 'errors');
        echo "
                                ";
        // line 207
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_weight", []), 'widget');
        echo "
                            </div>
                        </fieldset>
                    </div>
                </div>
                <h2 class=\"title\">
                  ";
        // line 213
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Specific references", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                </h2>
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 218
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_isbn", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 219
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_isbn", []), 'errors');
        echo "
                            ";
        // line 220
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_isbn", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-4\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">
                              ";
        // line 226
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_ean13", []), "vars", []), "label", []), "html", null, true);
        echo "
                              <span class=\"help-box\" data-toggle=\"popover\"
                                data-content=\"";
        // line 228
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This type of product code is specific to Europe and Japan, but is widely used internationally. It is a superset of the UPC code: all products marked with an EAN will be accepted in North America.", [], "Admin.Catalog.Help"), "html", null, true);
        echo "\" ></span>
                            </label>
                            ";
        // line 230
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_ean13", []), 'errors');
        echo "
                            ";
        // line 231
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_ean13", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-4\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 236
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_upc", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 237
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_upc", []), 'errors');
        echo "
                            ";
        // line 238
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_upc", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                    <div class=\"col-md-4\">
                        <fieldset class=\"form-group\">
                            <label class=\"form-control-label\">";
        // line 243
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "attribute_mpn", []), "vars", []), "label", []), "html", null, true);
        echo "</label>
                            ";
        // line 244
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_mpn", []), 'errors');
        echo "
                            ";
        // line 245
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "attribute_mpn", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                </div>
                <h2 class=\"title\">
                  ";
        // line 250
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Images", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
                </h2>
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <fieldset class=\"form-group js-combination-images\">
                            <label>
                                <small class=\"form-control-label\">";
        // line 256
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "id_image_attr", []), "vars", []), "label", []), "html", null, true);
        echo "</small>
                                <small class=\"form-control-label number-of-images\"></small>
                            </label>
                            ";
        // line 259
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "id_image_attr", []), 'errors');
        echo "
                            ";
        // line 260
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "id_image_attr", []), 'widget');
        echo "
                        </fieldset>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
        // line 267
        echo $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHook("displayAdminProductsCombinationBottom", ["id_product" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product", []), "id_product_attribute" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", [])]);
        echo "
                    </div>
                </div>

                ";
        // line 271
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "id_product_attribute", []), 'widget');
        echo "
            </div>
        </div>
    </td>
    <td width=\"5%\">
      <a href=\"";
        // line 276
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_delete_attribute", ["idProduct" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product", [])]), "html", null, true);
        echo "\" class=\"btn tooltip-link btn-sm delete\" data=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\"><i class=\"material-icons\">delete</i></a>
    </td>
    <td>
      ";
        // line 279
        $context["checked"] = ((($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "attribute_default", []) == 1)) ? ("checked") : (""));
        // line 280
        echo "      <input class=\"attribute-default\" type=\"radio\" ";
        echo twig_escape_filter($this->env, ($context["checked"] ?? null), "html", null, true);
        echo " data-id=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", []), "value", []), "id_product_attribute", []), "html", null, true);
        echo "\">
    </td>
</tr>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Forms/form_combination.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  608 => 280,  606 => 279,  598 => 276,  590 => 271,  583 => 267,  573 => 260,  569 => 259,  563 => 256,  554 => 250,  546 => 245,  542 => 244,  538 => 243,  530 => 238,  526 => 237,  522 => 236,  514 => 231,  510 => 230,  505 => 228,  500 => 226,  491 => 220,  487 => 219,  483 => 218,  475 => 213,  466 => 207,  462 => 206,  457 => 204,  451 => 201,  443 => 196,  439 => 195,  434 => 193,  429 => 191,  420 => 185,  416 => 184,  412 => 183,  405 => 181,  390 => 177,  378 => 176,  371 => 172,  367 => 171,  363 => 170,  355 => 165,  351 => 164,  346 => 162,  341 => 160,  332 => 154,  328 => 153,  324 => 152,  316 => 147,  307 => 141,  303 => 140,  299 => 139,  289 => 132,  285 => 131,  281 => 130,  273 => 125,  269 => 124,  265 => 123,  257 => 118,  249 => 113,  245 => 112,  241 => 111,  233 => 106,  229 => 105,  224 => 103,  219 => 101,  210 => 95,  206 => 94,  202 => 93,  198 => 91,  191 => 87,  187 => 86,  182 => 84,  177 => 81,  175 => 80,  170 => 78,  165 => 76,  161 => 75,  155 => 72,  148 => 68,  143 => 67,  136 => 64,  131 => 62,  126 => 59,  119 => 55,  115 => 53,  113 => 52,  110 => 51,  102 => 48,  98 => 47,  91 => 46,  88 => 45,  85 => 44,  82 => 43,  79 => 42,  77 => 41,  66 => 39,  58 => 34,  53 => 32,  46 => 28,  39 => 26,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Forms/form_combination.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Forms/form_combination.html.twig");
    }
}
