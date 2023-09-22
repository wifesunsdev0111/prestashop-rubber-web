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

/* @PrestaShop/Admin/Configure/AdvancedParameters/performance.html.twig */
class __TwigTemplate_50240fe1241611550da25413dc94c8ea91e3151fcbb48854a4efd56a22de8551 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'perfs_form_smarty_cache' => [$this, 'block_perfs_form_smarty_cache'],
            'perfs_form_smarty_cache_form' => [$this, 'block_perfs_form_smarty_cache_form'],
            'perfs_form_debug_mode' => [$this, 'block_perfs_form_debug_mode'],
            'perfs_form_debug_mode_form' => [$this, 'block_perfs_form_debug_mode_form'],
            'perfs_form_optional_features' => [$this, 'block_perfs_form_optional_features'],
            'perfs_form_optional_features_form' => [$this, 'block_perfs_form_optional_features_form'],
            'perfs_form_ccc' => [$this, 'block_perfs_form_ccc'],
            'perfs_form_ccc_form' => [$this, 'block_perfs_form_ccc_form'],
            'perfs_form_media_servers' => [$this, 'block_perfs_form_media_servers'],
            'perfs_form_media_servers_form' => [$this, 'block_perfs_form_media_servers_form'],
            'perfs_form_caching' => [$this, 'block_perfs_form_caching'],
            'perfs_form_caching_form' => [$this, 'block_perfs_form_caching_form'],
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
        // line 27
        $context["ps"] = $this->loadTemplate("@PrestaShop/Admin/macros.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/performance.html.twig", 27)->unwrap();
        // line 28
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["smartyForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 29
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["debugModeForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 30
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["optionalFeaturesForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 31
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["combineCompressCacheForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 32
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["mediaServersForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 33
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["cachingForm"] ?? null), [0 => "PrestaShopBundle:Admin/TwigTemplateForm:prestashop_ui_kit.html.twig"], true);
        // line 25
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/layout.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/performance.html.twig", 25);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 35
    public function block_content($context, array $blocks = [])
    {
        // line 36
        echo "  ";
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["smartyForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_smarty_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 38
        $this->displayBlock('perfs_form_smarty_cache', $context, $blocks);
        // line 59
        echo "    </div>
  ";
        // line 60
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["smartyForm"] ?? null), 'form_end');
        echo "

  ";
        // line 62
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["debugModeForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_debug_mode_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 64
        $this->displayBlock('perfs_form_debug_mode', $context, $blocks);
        // line 85
        echo "    </div>
  ";
        // line 86
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["debugModeForm"] ?? null), 'form_end');
        echo "

  ";
        // line 88
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["optionalFeaturesForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_optional_features_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 90
        $this->displayBlock('perfs_form_optional_features', $context, $blocks);
        // line 122
        echo "    </div>
  ";
        // line 123
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["optionalFeaturesForm"] ?? null), 'form_end');
        echo "

  ";
        // line 125
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["combineCompressCacheForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_combine_compress_cache_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 127
        $this->displayBlock('perfs_form_ccc', $context, $blocks);
        // line 160
        echo "    </div>
  ";
        // line 161
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["combineCompressCacheForm"] ?? null), 'form_end');
        echo "

  ";
        // line 163
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["mediaServersForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_media_servers_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 165
        $this->displayBlock('perfs_form_media_servers', $context, $blocks);
        // line 197
        echo "    </div>
  ";
        // line 198
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["mediaServersForm"] ?? null), 'form_end');
        echo "

  ";
        // line 200
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["cachingForm"] ?? null), 'form_start', ["attr" => ["class" => "form"], "action" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_performance_caching_save")]);
        echo "
    <div class=\"row justify-content-center\">
      ";
        // line 202
        $this->displayBlock('perfs_form_caching', $context, $blocks);
        // line 225
        echo "    </div>
  ";
        // line 226
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["cachingForm"] ?? null), 'form_end');
        echo "
";
    }

    // line 38
    public function block_perfs_form_smarty_cache($context, array $blocks = [])
    {
        // line 39
        echo "        <div class=\"col\">
          <div class=\"card\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">business_center</i> ";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Smarty", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 46
        $this->displayBlock('perfs_form_smarty_cache_form', $context, $blocks);
        // line 49
        echo "              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 46
    public function block_perfs_form_smarty_cache_form($context, array $blocks = [])
    {
        // line 47
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["smartyForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 64
    public function block_perfs_form_debug_mode($context, array $blocks = [])
    {
        // line 65
        echo "        <div class=\"col\">
          <div class=\"card\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">bug_report</i> ";
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Debug mode", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 72
        $this->displayBlock('perfs_form_debug_mode_form', $context, $blocks);
        // line 75
        echo "              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 79
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 72
    public function block_perfs_form_debug_mode_form($context, array $blocks = [])
    {
        // line 73
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["debugModeForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 90
    public function block_perfs_form_optional_features($context, array $blocks = [])
    {
        // line 91
        echo "        <div class=\"col\">
          <div class=\"card\" id=\"optional_features\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">extension</i> ";
        // line 94
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Optional features", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "

              <span
                class=\"help-box\"
                data-container=\"body\"
                data-toggle=\"popover\"
                data-trigger=\"hover\"
                data-placement=\"right\"
                data-content=\"";
        // line 102
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Some features can be disabled in order to improve performance.", [], "Admin.Advparameters.Help"), "html", null, true);
        echo "\"
                title=\"\"
              >
              </span>
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 109
        $this->displayBlock('perfs_form_optional_features_form', $context, $blocks);
        // line 112
        echo "              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 116
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 109
    public function block_perfs_form_optional_features_form($context, array $blocks = [])
    {
        // line 110
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["optionalFeaturesForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 127
    public function block_perfs_form_ccc($context, array $blocks = [])
    {
        // line 128
        echo "        <div class=\"col\">
          <div class=\"card\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">zoom_out_map</i> ";
        // line 131
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("CCC (Combine, Compress and Cache)", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "


            <span
              class=\"help-box\"
              data-container=\"body\"
              data-toggle=\"popover\"
              data-trigger=\"hover\"
              data-placement=\"right\"
              data-content=\"";
        // line 140
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("CCC allows you to reduce the loading time of your page. With these settings you will gain performance without even touching the code of your theme. Make sure, however, that your theme is compatible with PrestaShop 1.7+. Otherwise, CCC will cause problems.", [], "Admin.Advparameters.Help"), "html", null, true);
        echo "\"
              title=\"\"
            >
            </span>
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 147
        $this->displayBlock('perfs_form_ccc_form', $context, $blocks);
        // line 150
        echo "              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 154
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 147
    public function block_perfs_form_ccc_form($context, array $blocks = [])
    {
        // line 148
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["combineCompressCacheForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 165
    public function block_perfs_form_media_servers($context, array $blocks = [])
    {
        // line 166
        echo "        <div class=\"col\">
          <div class=\"card\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">link</i> ";
        // line 169
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Media servers (use only with CCC)", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "

              <span
                class=\"help-box\"
                data-container=\"body\"
                data-toggle=\"popover\"
                data-trigger=\"hover\"
                data-placement=\"right\"
                data-content=\"";
        // line 177
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("You must enter another domain, or subdomain, in order to use cookieless static content.", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "\"
                title=\"\"
              >
              </span>
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 184
        $this->displayBlock('perfs_form_media_servers_form', $context, $blocks);
        // line 187
        echo "              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 191
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 184
    public function block_perfs_form_media_servers_form($context, array $blocks = [])
    {
        // line 185
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["mediaServersForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 202
    public function block_perfs_form_caching($context, array $blocks = [])
    {
        // line 203
        echo "        <div class=\"col\">
          <div class=\"card\">
            <h3 class=\"card-header\">
              <i class=\"material-icons\">link</i> ";
        // line 206
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Caching", [], "Admin.Advparameters.Feature"), "html", null, true);
        echo "
            </h3>
            <div class=\"card-block row\">
              <div class=\"card-text\">
                ";
        // line 210
        $this->displayBlock('perfs_form_caching_form', $context, $blocks);
        // line 213
        echo "
                ";
        // line 214
        echo twig_include($this->env, $context, "@AdvancedParameters/memcache_servers.html.twig", ["form" => ($context["memcacheForm"] ?? null)]);
        echo "
              </div>
            </div>
            <div class=\"card-footer\">
              <div class=\"d-flex justify-content-end\">
                <button class=\"btn btn-primary\">";
        // line 219
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", [], "Admin.Actions"), "html", null, true);
        echo "</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    // line 210
    public function block_perfs_form_caching_form($context, array $blocks = [])
    {
        // line 211
        echo "                  ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["cachingForm"] ?? null), 'widget');
        echo "
                ";
    }

    // line 229
    public function block_javascripts($context, array $blocks = [])
    {
        // line 230
        echo "  ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
  <script src=\"";
        // line 231
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/admin_parameters/performancePage.js"), "html", null, true);
        echo "\"></script>
  <script>
    var configuration = {
      'addServerUrl': '";
        // line 234
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getUrl("admin_servers_add"), "js"), "html", null, true);
        echo "',
      'removeServerUrl': '";
        // line 235
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getUrl("admin_servers_delete"), "js"), "html", null, true);
        echo "',
      'testServerUrl': '";
        // line 236
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getUrl("admin_servers_test"), "js"), "html", null, true);
        echo "'
    };
    var app = new PerformancePage(
      configuration.addServerUrl,
      configuration.removeServerUrl,
      configuration.testServerUrl
    );

    window.addEventListener('load', function() {
      var addServerBtn = document.getElementById('add-server-btn');
      var testServerBtn = document.getElementById('test-server-btn');

      addServerBtn.addEventListener('click', function(event) {
        event.preventDefault();
        app.addServer();
      });

      testServerBtn.addEventListener('click', function(event) {
        event.preventDefault();
        app.testServer();
      });
    });
  </script>

  <script src=\"";
        // line 260
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/admin_parameters/performancePageUI.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Configure/AdvancedParameters/performance.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  517 => 260,  490 => 236,  486 => 235,  482 => 234,  476 => 231,  471 => 230,  468 => 229,  461 => 211,  458 => 210,  448 => 219,  440 => 214,  437 => 213,  435 => 210,  428 => 206,  423 => 203,  420 => 202,  413 => 185,  410 => 184,  400 => 191,  394 => 187,  392 => 184,  382 => 177,  371 => 169,  366 => 166,  363 => 165,  356 => 148,  353 => 147,  343 => 154,  337 => 150,  335 => 147,  325 => 140,  313 => 131,  308 => 128,  305 => 127,  298 => 110,  295 => 109,  285 => 116,  279 => 112,  277 => 109,  267 => 102,  256 => 94,  251 => 91,  248 => 90,  241 => 73,  238 => 72,  228 => 79,  222 => 75,  220 => 72,  213 => 68,  208 => 65,  205 => 64,  198 => 47,  195 => 46,  185 => 53,  179 => 49,  177 => 46,  170 => 42,  165 => 39,  162 => 38,  156 => 226,  153 => 225,  151 => 202,  146 => 200,  141 => 198,  138 => 197,  136 => 165,  131 => 163,  126 => 161,  123 => 160,  121 => 127,  116 => 125,  111 => 123,  108 => 122,  106 => 90,  101 => 88,  96 => 86,  93 => 85,  91 => 64,  86 => 62,  81 => 60,  78 => 59,  76 => 38,  70 => 36,  67 => 35,  62 => 25,  60 => 33,  58 => 32,  56 => 31,  54 => 30,  52 => 29,  50 => 28,  48 => 27,  42 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@PrestaShop/Admin/Configure/AdvancedParameters/performance.html.twig", "/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/src/PrestaShopBundle/Resources/views/Admin/Configure/AdvancedParameters/performance.html.twig");
    }
}
