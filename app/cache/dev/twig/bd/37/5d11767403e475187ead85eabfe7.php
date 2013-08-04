<?php

/* MGDAdminBundle:Pedido:new.html.twig */
class __TwigTemplate_bd375d11767403e475187ead85eabfe7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("MGDAdminBundle::layout_admin.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'page' => array($this, 'block_page'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "MGDAdminBundle::layout_admin.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        $this->displayParentBlock("title", $context, $blocks);
        echo " - ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.new.creation", array("%entity%" => "Pedido"), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
";
    }

    // line 7
    public function block_page($context, array $blocks = array())
    {
        // line 8
        echo "
<h1>";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.new.creation", array("%entity%" => "Pedido"), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</h1>

<form class=\"well\" action=\"";
        // line 11
        echo $this->env->getExtension('routing')->getPath("pedido_create");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'enctype');
;
        echo ">
    ";
        // line 12
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
    <p>
        <button type=\"submit\" class=\"btn btn-success\">";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.new.create", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</button>
    </p>
</form>

<div>
    <div class=\"float-left\">
        <a class=\"btn\" href=\"";
        // line 20
        echo $this->env->getExtension('routing')->getPath("pedido");
        echo "\">
            ";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.recordactions.backtothelist", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
        </a>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle:Pedido:new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 21,  72 => 20,  63 => 14,  58 => 12,  51 => 11,  46 => 9,  43 => 8,  40 => 7,  32 => 4,  29 => 3,);
    }
}
