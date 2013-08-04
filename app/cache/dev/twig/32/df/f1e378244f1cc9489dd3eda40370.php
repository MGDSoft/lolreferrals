<?php

/* MGDAdminBundle::layout_admin.html.twig */
class __TwigTemplate_32dff1e378244f1cc9489dd3eda40370 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("JordiLlonchCrudGeneratorBundle::layout.html.twig");

        $this->blocks = array(
            'stylesheet' => array($this, 'block_stylesheet'),
            'base' => array($this, 'block_base'),
            'menu' => array($this, 'block_menu'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "JordiLlonchCrudGeneratorBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_stylesheet($context, array $blocks = array())
    {
        // line 5
        echo "    ";
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "487d396_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_487d396_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/487d396_part_1_menu_1.css");
            // line 6
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
        } else {
            // asset "487d396"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_487d396") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/487d396.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" rel=\"stylesheet\" media=\"screen\" />
    ";
        }
        unset($context["asset_url"]);
    }

    // line 10
    public function block_base($context, array $blocks = array())
    {
        // line 11
        echo "    ";
        $this->displayBlock("page", $context, $blocks);
        echo "
";
    }

    // line 14
    public function block_menu($context, array $blocks = array())
    {
        // line 15
        echo "    <div id=\"menu\">
        ";
        // line 16
        $this->env->loadTemplate("MGDAdminBundle::menu_admin.html.twig")->display($context);
        // line 17
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle::layout_admin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 17,  70 => 16,  67 => 15,  64 => 14,  54 => 10,  38 => 6,  33 => 5,  30 => 4,  250 => 103,  243 => 99,  239 => 98,  236 => 97,  234 => 96,  229 => 94,  222 => 89,  214 => 86,  207 => 82,  203 => 81,  198 => 79,  193 => 78,  191 => 77,  186 => 75,  180 => 74,  176 => 73,  172 => 72,  168 => 71,  164 => 70,  160 => 69,  154 => 68,  151 => 67,  147 => 66,  140 => 62,  118 => 43,  114 => 42,  108 => 39,  104 => 38,  100 => 37,  96 => 36,  92 => 35,  85 => 34,  73 => 25,  66 => 20,  60 => 17,  57 => 11,  55 => 15,  49 => 12,  43 => 8,  40 => 7,  32 => 4,  29 => 3,);
    }
}
