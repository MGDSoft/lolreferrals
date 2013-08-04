<?php

/* MGDBasicBundle:Default:index.html.twig */
class __TwigTemplate_3404e0e26385ce14cd1c65eb9203e2fd extends Twig_Template
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

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.metas.title"), "html", null, true);
    }

    // line 4
    public function block_description($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.metas.description"), "html", null, true);
    }

    // line 6
    public function block_body_principal($context, array $blocks = array())
    {
        // line 7
        echo "
    ";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["noticias"]) ? $context["noticias"] : $this->getContext($context, "noticias")));
        foreach ($context['_seq'] as $context["_key"] => $context["noticia"]) {
            // line 9
            echo "        <article>
            <header>
                <h2>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : $this->getContext($context, "noticia")), "titulo"), "html", null, true);
            echo "</h2>

                <time datetime=\"";
            // line 13
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : $this->getContext($context, "noticia")), "fecha"), "Y-m-d"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : $this->getContext($context, "noticia")), "fecha"), "M jS,Y H:i"), "html", null, true);
            echo "</time>

                <p>
                    ";
            // line 16
            echo $this->getAttribute((isset($context["noticia"]) ? $context["noticia"] : $this->getContext($context, "noticia")), "noticia");
            echo "
                </p>
            </header>
        </article>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['noticia'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "
";
    }

    // line 24
    public function block_aside_principal($context, array $blocks = array())
    {
        // line 25
        echo "
    <h3>";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.titulo"), "html", null, true);
        echo "</h3>
    <ul>
        <li>";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.slot_1"), "html", null, true);
        echo "</li>
        <li>";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.slot_2"), "html", null, true);
        echo "</li>
        <li>";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.slot_3"), "html", null, true);
        echo "</li>
        <li>";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.slot_4"), "html", null, true);
        echo "</li>
        <li>";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("inicio.aside.slot_5"), "html", null, true);
        echo "</li>
    </ul>
    <br>

";
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 32,  109 => 31,  105 => 30,  101 => 29,  97 => 28,  92 => 26,  89 => 25,  86 => 24,  81 => 21,  70 => 16,  62 => 13,  57 => 11,  53 => 9,  49 => 8,  46 => 7,  43 => 6,  37 => 4,  31 => 3,);
    }
}
