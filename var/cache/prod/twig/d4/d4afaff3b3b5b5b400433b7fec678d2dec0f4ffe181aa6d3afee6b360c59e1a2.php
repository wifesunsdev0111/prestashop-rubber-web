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

/* @PrestaShop/Admin/Security/compromised.html.twig */
class __TwigTemplate_e47f5a69f6554442bde1fe1fd3fe37c8fdbbce6572d45f2f97c394637bf76a23 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 25
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("::base.html.twig", "@PrestaShop/Admin/Security/compromised.html.twig", 25);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 27
    public function block_stylesheets($context, array $blocks = [])
    {
        // line 28
        echo "  <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/theme.css"), "html", null, true);
        echo "\" />
";
    }

    // line 31
    public function block_title($context, array $blocks = [])
    {
        // line 32
        echo "  ";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Invalid token", [], "Admin.Catalog.Help"), "html", null, true);
        echo "
";
    }

    // line 34
    public function block_body($context, array $blocks = [])
    {
        // line 35
        echo "  <div class=\"fluid-container\" id=\"security-compromised-page\" >
      <div id=\"csrf-white-container\" class=\"row justify-content-md-center\">
        <div class=\"col-md-8\">
          <div class=\"alert alert-danger\" role=\"alert\">
            <p class=\"alert-text\">
              ";
        // line 40
        echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("[1]Invalid token[/1]: direct access to this link may lead to a potential security breach.", [], "Admin.Catalog.Help"), ["[1]" => "<b>", "[/1]" => "</b>"]);
        echo "
            </p>
          </div>

          <h1 class=\"text-md-center\">";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Do you want to display this page?", [], "Admin.Catalog.Help"), "html", null, true);
        echo "</h1>
          <div class=\"text-md-center\">
            <a class=\"btn btn-lg btn-outline-danger mr-3\" href=\"";
        // line 46
        echo twig_escape_filter($this->env, ($context["requestUri"] ?? null), "html", null, true);
        echo "\">
              ";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Yes, I understand the risks", [], "Admin.Catalog.Help"), "html", null, true);
        echo "
            </a>
            <a class=\"btn btn-lg btn-primary ml-3\" href=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('PrestaShopBundle\Twig\LayoutExtension')->getAdminLink("AdminDashboard"), "html", null, true);
        echo "\">
              ";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Take me out of there!", [], "Admin.Catalog.Help"), "html", null, true);
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
        return "@PrestaShop/Admin/Security/compromised.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 50,  92 => 49,  87 => 47,  83 => 46,  78 => 44,  71 => 40,  64 => 35,  61 => 34,  54 => 32,  51 => 31,  44 => 28,  41 => 27,  31 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Security/compromised.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Security/compromised.html.twig");
    }
}
