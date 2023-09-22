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

/* @PrestaShop/Admin/Exception/error.html.twig */
class __TwigTemplate_7857a383a3eace9a488435b5c1004e7c4f10f4616180c82854a56a9a864c799a extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 26
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("::base.html.twig", "@PrestaShop/Admin/Exception/error.html.twig", 26);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 28
    public function block_stylesheets($context, array $blocks = [])
    {
        // line 29
        echo "  <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/theme.css"), "html", null, true);
        echo "\" />
";
    }

    // line 32
    public function block_title($context, array $blocks = [])
    {
        // line 33
        echo "  ";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Oops... looks like an unexpected error occurred", [], "Admin.Notifications.Error"), "html", null, true);
        echo "
";
    }

    // line 36
    public function block_body($context, array $blocks = [])
    {
        // line 37
        echo "  <div class=\"container\">
    <div class=\"row mt-5\">
      <div class=\"col\">
        <div class=\"card\">
          <div class=\"card-body text-center\">
            <img class=\"img-responsive\"
                 src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/img/error/500.svg"), "html", null, true);
        echo "\"
                 alt=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Oops... looks like an unexpected error occurred", [], "Admin.Notifications.Error"), "html", null, true);
        echo "\"
            >

            <div class=\"mt-3\">
              <p class=\"error-header\">
                ";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Oops... looks like an unexpected error occurred", [], "Admin.Notifications.Error"), "html", null, true);
        echo "
              </p>

              ";
        // line 52
        if (($context["exception"] ?? null)) {
            // line 53
            echo "                <div class=\"mx-auto\">
                  <p class=\"mb-0\">";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute(($context["exception"] ?? null), "message", []), "html", null, true);
            echo "</p>
                  <p class=\"mb-0\">[";
            // line 55
            echo twig_escape_filter($this->env, $this->getAttribute(($context["exception"] ?? null), "class", []), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["exception"] ?? null), "code", []), "html", null, true);
            echo "]</p>
                </div>
              ";
        }
        // line 58
        echo "
              <div class=\"mt-4\">
                <form action=\"";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_errors_enable_debug_mode");
        echo "\" method=\"post\" class=\"d-inline\">
                  <input type=\"hidden\" name=\"_redirect_url\" value=\"";
        // line 61
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", []), "requestUri", []), "html", null, true);
        echo "\">

                  <button class=\"btn btn-outline-secondary\" type=\"submit\">
                    ";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable debug mode", [], "Admin.Actions"), "html", null, true);
        echo "
                  </button>
                </form>
                <button class=\"btn btn-primary js-go-back-btn ml-3\" type=\"button\">
                  ";
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Back to previous page", [], "Admin.Actions"), "html", null, true);
        echo "
                </button>
              </div>

              <p class=\"mt-3\">
                <a href=\"";
        // line 73
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('documentation_link')->getCallable(), ["debug_mode"]), "html", null, true);
        echo "\" target=\"_blank\">
                  ";
        // line 74
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Learn more about debug mode", [], "Admin.Actions"), "html", null, true);
        echo "
                  <i class=\"material-icons\">arrow_right_alt</i>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
";
    }

    // line 86
    public function block_javascripts($context, array $blocks = [])
    {
        // line 87
        echo "  <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/error.bundle.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Exception/error.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 87,  156 => 86,  141 => 74,  137 => 73,  129 => 68,  122 => 64,  116 => 61,  112 => 60,  108 => 58,  100 => 55,  96 => 54,  93 => 53,  91 => 52,  85 => 49,  77 => 44,  73 => 43,  65 => 37,  62 => 36,  55 => 33,  52 => 32,  45 => 29,  42 => 28,  32 => 26,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Exception/error.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Exception/error.html.twig");
    }
}
