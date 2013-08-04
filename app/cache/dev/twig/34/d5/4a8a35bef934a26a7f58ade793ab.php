<?php

/* MGDBasicBundle:Contacto:index.html.twig */
class __TwigTemplate_34d54a8a35bef934a26a7f58ade793ab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("MGDBasicBundle::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'description' => array($this, 'block_description'),
            'body_principal' => array($this, 'block_body_principal'),
            'aside_principal' => array($this, 'block_aside_principal'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "MGDBasicBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.metas.title"), "html", null, true);
    }

    // line 3
    public function block_description($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.metas.description"), "html", null, true);
    }

    // line 6
    public function block_body_principal($context, array $blocks = array())
    {
        // line 7
        echo "
    <article>
        <header>
            <h1>";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.principal.titulo"), "html", null, true);
        echo "</h1>
            <p>
                ";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.principal.texto"), "html", null, true);
        echo "
            </p>

        </header>
        <section>

            <form id=\"contacto\" action=\"";
        // line 18
        echo $this->env->getExtension('routing')->getPath(("contacto_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\" method=\"post\">
                ";
        // line 19
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["contacto_form"]) ? $context["contacto_form"] : $this->getContext($context, "contacto_form")), 'widget');
        echo "
                <div class=\"text-right\">
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.contacto.submit"), "html", null, true);
        echo "\">
                </div>
            </form>


        </section>
    </article>

";
    }

    // line 31
    public function block_aside_principal($context, array $blocks = array())
    {
        // line 32
        echo "
    <h3>";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.aside.titulo"), "html", null, true);
        echo "</h3>
    <p>";
        // line 34
        echo $this->env->getExtension('translator')->trans("contacto.aside.texto");
        echo "</p>
    <br>
    <img src=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/contacto.jpg"), "html", null, true);
        echo "\">
    <br><br>

";
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Contacto:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 36,  97 => 34,  93 => 33,  90 => 32,  87 => 31,  74 => 21,  69 => 19,  65 => 18,  56 => 12,  51 => 10,  46 => 7,  43 => 6,  37 => 3,  31 => 2,);
    }
}
