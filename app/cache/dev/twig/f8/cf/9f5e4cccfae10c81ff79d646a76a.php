<?php

/* MGDAdminBundle:PedidoEstados:show.html.twig */
class __TwigTemplate_f8cf9f5e4cccfae10c81ff79d646a76a extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.show.show", array("%entity%" => "PedidoEstados"), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
";
    }

    // line 7
    public function block_page($context, array $blocks = array())
    {
        // line 8
        echo "
<h1>PedidoEstados</h1>

<form class=\"form-horizontal\">
    <fieldset>        <div class=\"control-group\">
            <label class=\"control-label\">Id</label>
            <div class=\"controls\">                <span class=\"input-xlarge uneditable-input\">";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"), "html", null, true);
        echo "</span>            </div>
        </div>        <div class=\"control-group\">
            <label class=\"control-label\">Descripcion</label>
            <div class=\"controls\">                <span class=\"input-xlarge uneditable-input\">";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "descripcion"), "html", null, true);
        echo "</span>            </div>
        </div>        <div class=\"control-group\">
            <label class=\"control-label\">Fecha</label>
            <div class=\"controls\">                <span class=\"input-xlarge uneditable-input\">";
        // line 20
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "fecha"), "Y-m-d H:i:s"), "html", null, true);
        echo "</span>            </div>
        </div>    </fieldset>
</form>

<div>
    <div class=\"float-left\">
        <a class=\"btn\" href=\"";
        // line 26
        echo $this->env->getExtension('routing')->getPath("pedidoestados");
        echo "\">
            ";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.recordactions.backtothelist", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
        </a>
    </div>
    <div class=\"float-left\">
        <a class=\"btn btn-primary\" href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("pedidoestados_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
        echo "\">
            ";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.recordactions.edit", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
        </a>
    </div>
    <div class=\"float-left\">
        <form action=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("pedidoestados_delete", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
        echo "\" method=\"post\">
            <input type=\"hidden\" name=\"_method\" value=\"DELETE\" />
            ";
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'widget');
        echo "
            <button class=\"btn btn-danger\" type=\"submit\" onclick=\"return confirm('";
        // line 39
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.recordactions.confirm", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "');\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.recordactions.delete", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</button>
        </form>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle:PedidoEstados:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  103 => 39,  99 => 38,  94 => 36,  87 => 32,  83 => 31,  76 => 27,  72 => 26,  63 => 20,  57 => 17,  51 => 14,  43 => 8,  40 => 7,  32 => 4,  29 => 3,);
    }
}
