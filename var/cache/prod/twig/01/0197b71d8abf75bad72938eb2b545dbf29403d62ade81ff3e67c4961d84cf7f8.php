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

/* ::base.html.twig */
class __TwigTemplate_b501263ca98f9c84d588d6ea060b7eed8856d81af36da9d66e9f7608ff2ca9ba extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 25
        echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"UTF-8\" />
    <title>";
        // line 29
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 30
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 31
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
  </head>
  <body>
    ";
        // line 34
        $this->displayBlock('body', $context, $blocks);
        // line 35
        echo "    ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 36
        echo "  </body>
</html>
";
    }

    // line 29
    public function block_title($context, array $blocks = [])
    {
        echo "Welcome!";
    }

    // line 30
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    // line 34
    public function block_body($context, array $blocks = [])
    {
    }

    // line 35
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 35,  75 => 34,  70 => 30,  64 => 29,  58 => 36,  55 => 35,  53 => 34,  46 => 31,  44 => 30,  40 => 29,  34 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "::base.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/app/Resources/views/base.html.twig");
    }
}
