<?php

/* MGDBasicBundle::layout.html.twig */
class __TwigTemplate_d2565bfdd4e7c76be8bc1dcce92133c5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'central' => array($this, 'block_central'),
            'javascript' => array($this, 'block_javascript'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 3
        echo "    ";
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "250002a_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_common_1.css");
            // line 7
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_contacto_2.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_elements_3.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_3"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_3") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_formularios_4.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_4"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_4") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_main_5.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_5"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_5") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_noticias_6.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_6"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_6") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_pedido_7.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_7"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_7") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_part_1_seguimiento_8.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_8"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_8") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_normalize.min_2.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
            // asset "250002a_9"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a_9") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a_bootstrap.min_3.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
        } else {
            // asset "250002a"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_250002a") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/250002a.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
        }
        unset($context["asset_url"]);
    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        // line 12
        echo "    <div class=\"header-container\">
        <header class=\"wrapper clearfix\">
            <div id=\"top\">

                <div id=\"language\">
                    <a href=\"";
        // line 17
        echo $this->env->getExtension('routing')->getPath("cambiar_lenguaje", array("_locale" => "es"));
        echo "\">
                        <img src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/mgdbasic/images/spain.png"), "html", null, true);
        echo "\"
                            ";
        // line 19
        if (("es" == $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale"))) {
            // line 20
            echo "                                class=\"selected\"
                            ";
        }
        // line 22
        echo "                                >
                    </a>
                    <a href=\"";
        // line 24
        echo $this->env->getExtension('routing')->getPath("cambiar_lenguaje", array("_locale" => "en"));
        echo "\">
                        <img src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/mgdbasic/images/unitedkingsom.png"), "html", null, true);
        echo "\"
                                ";
        // line 26
        if (("en" == $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale"))) {
            // line 27
            echo "                                    class=\"selected\"
                                ";
        }
        // line 29
        echo "                                >
                    </a>
                </div>

                <a href=\"";
        // line 33
        echo $this->env->getExtension('routing')->getPath("home");
        echo "\">
                    <img id=\"logo\" src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/logo.png"), "html", null, true);
        echo "\" title=\"Lol Referrals\" alt=\"Lol Referrals\">
                    <h1 class=\"title\">LolReferrals.com</h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href=\"";
        // line 40
        echo $this->env->getExtension('routing')->getPath("home");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.menu.inicio"), "html", null, true);
        echo "</a></li>
                    <li><a href=\"";
        // line 41
        echo $this->env->getExtension('routing')->getPath(("pedido_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.menu.encargar"), "html", null, true);
        echo "</a></li>
                    <li><a href=\"";
        // line 42
        echo $this->env->getExtension('routing')->getPath(("faq_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.menu.preguntas"), "html", null, true);
        echo "</a></li>
                    <li><a href=\"";
        // line 43
        echo $this->env->getExtension('routing')->getPath(("seguimiento_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.menu.seguimiento"), "html", null, true);
        echo "</a></li>
                    <li><a href=\"";
        // line 44
        echo $this->env->getExtension('routing')->getPath(("contacto_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.menu.contacto"), "html", null, true);
        echo "</a></li>
                </ul>
            </nav>
        </header>
    </div>

    <div class=\"main-container\">
        <div class=\"main wrapper clearfix\">
            ";
        // line 52
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "all", array(), "method"));
        foreach ($context['_seq'] as $context["type"] => $context["flashMessages"]) {
            // line 53
            echo "                ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["flashMessages"]) ? $context["flashMessages"] : $this->getContext($context, "flashMessages")));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 54
                echo "                    <div class=\"alert alert-";
                echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
                echo "\">
                        ";
                // line 55
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), array()), "html", null, true);
                echo "
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 58
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['flashMessages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "            <section id=\"body_principal\">
                ";
        // line 60
        $this->displayBlock("body_principal", $context, $blocks);
        echo "
            </section>
            <aside>
                ";
        // line 63
        $this->displayBlock("aside_principal", $context, $blocks);
        echo "
            </aside>
            ";
        // line 65
        $this->displayBlock('central', $context, $blocks);
        // line 67
        echo "        </div> <!-- #main -->
    </div> <!-- #main-container -->

    <div class=\"footer-container\">
        <footer class=\"wrapper\">
            <h3>";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("portal.footer"), "html", null, true);
        echo "</h3>
        </footer>
    </div>

";
    }

    // line 65
    public function block_central($context, array $blocks = array())
    {
        // line 66
        echo "            ";
    }

    // line 78
    public function block_javascript($context, array $blocks = array())
    {
        // line 79
        echo "    ";
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "73d8484_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_73d8484_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/73d8484_part_1_ga_1.js");
            // line 80
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
            // asset "73d8484_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_73d8484_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/73d8484_part_1_jquery.min_2.js");
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
            // asset "73d8484_2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_73d8484_2") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/73d8484_part_1_main_3.js");
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
            // asset "73d8484_3"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_73d8484_3") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/73d8484_part_1_modernizr-2.6.1-respond-1.1.0.min_4.js");
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        } else {
            // asset "73d8484"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_73d8484") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/73d8484.js");
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        }
        unset($context["asset_url"]);
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  283 => 80,  278 => 79,  275 => 78,  271 => 66,  268 => 65,  259 => 72,  252 => 67,  250 => 65,  245 => 63,  239 => 60,  236 => 59,  230 => 58,  221 => 55,  216 => 54,  211 => 53,  207 => 52,  194 => 44,  188 => 43,  182 => 42,  176 => 41,  170 => 40,  161 => 34,  157 => 33,  151 => 29,  147 => 27,  145 => 26,  141 => 25,  137 => 24,  133 => 22,  129 => 20,  127 => 19,  123 => 18,  119 => 17,  112 => 12,  109 => 11,  39 => 7,  34 => 3,  31 => 2,);
    }
}
