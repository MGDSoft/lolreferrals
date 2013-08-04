<?php

/* MGDBasicBundle:Faq:index.html.twig */
class __TwigTemplate_163444e5dfc0a605dc4875e4c19c98c2 extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.metas.title"), "html", null, true);
    }

    // line 4
    public function block_description($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.metas.description"), "html", null, true);
    }

    // line 6
    public function block_body_principal($context, array $blocks = array())
    {
        // line 7
        echo "
    <article>
        <header>
            <h1 style=\"margin-bottom: 50px\">";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.titulo"), "html", null, true);
        echo "</h1>

        </header>
        <section>
            <h3>";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_1_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 15
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_1_texto");
        echo "</p>

            <h3>";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_2_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 18
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_2_texto");
        echo "</p>

            <h3>";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_3_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 21
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_3_texto");
        echo "</p>

            <h3>";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_4_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 24
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_4_texto");
        echo "</p>

            <h3>";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_5_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 27
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_5_texto");
        echo "</p>

            <h3>";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_6_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 30
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_6_texto");
        echo "</p>

            <h3>";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_7_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 33
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_7_texto");
        echo "</p>

            <h3>";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_8_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 36
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_8_texto");
        echo "</p>

            <h3>";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_9_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 39
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_10_texto");
        echo "</p>

            <h3>";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.principal.slot_11_title"), "html", null, true);
        echo "</h3>
            <p>";
        // line 42
        echo $this->env->getExtension('translator')->trans("faq.principal.slot_11_texto");
        echo "</p>


        </section>
    </article>

";
    }

    // line 50
    public function block_aside_principal($context, array $blocks = array())
    {
        // line 51
        echo "
    <h3>";
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.aside.titulo"), "html", null, true);
        echo "</h3>
    <p>";
        // line 53
        echo $this->env->getExtension('translator')->trans("faq.aside.texto");
        echo "
        <a style=\"color: white;font-weight: bold\" href=\"";
        // line 54
        echo $this->env->getExtension('routing')->getPath(("contacto_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("faq.aside.link"), "html", null, true);
        echo "</a>
    </p>
    <br>

";
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Faq:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  168 => 54,  164 => 53,  160 => 52,  157 => 51,  154 => 50,  143 => 42,  139 => 41,  134 => 39,  130 => 38,  125 => 36,  121 => 35,  116 => 33,  112 => 32,  107 => 30,  103 => 29,  98 => 27,  94 => 26,  89 => 24,  85 => 23,  80 => 21,  76 => 20,  71 => 18,  67 => 17,  62 => 15,  58 => 14,  51 => 10,  46 => 7,  43 => 6,  37 => 4,  31 => 3,);
    }
}
