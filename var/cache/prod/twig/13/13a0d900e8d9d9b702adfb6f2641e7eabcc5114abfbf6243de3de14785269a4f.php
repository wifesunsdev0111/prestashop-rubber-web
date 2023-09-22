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

/* @Product/ProductPage/Forms/form_edit_specific_price_modal.html.twig */
class __TwigTemplate_2b8fc7862e6a3c422ec6168ba452b93e5ee7aeab3f153f1f4f35dfac095f4f2b extends \Twig\Template
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
        echo "<div class=\"modal fade\" id=\"edit-specific-price-modal\" tabindex=\"1\" role=\"dialog\" aria-hidden=\"true\">

  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">

      <div class=\"modal-header\">
        <h5 class=\"modal-title\">
          ";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Edit a specific price", [], "Admin.Catalog.Feature"), "html", null, true);
        echo "
        </h5>
        <button type=\"button\" class=\"close\" id=\"form_modal_close\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>

      <div id=\"edit-specific-price-modal-form\" class=\"modal-body\" data-action=\"";
        // line 39
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_specific_price_update");
        echo "\" data-specific-price-id=\"0\">
      </div>
    </div>
  </div>

</div>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Forms/form_edit_specific_price_modal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 39,  39 => 32,  30 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@Product/ProductPage/Forms/form_edit_specific_price_modal.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Product/ProductPage/Forms/form_edit_specific_price_modal.html.twig");
    }
}
