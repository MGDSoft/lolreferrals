<?php

/* MGDBasicBundle:Pedido:index.html.twig */
class __TwigTemplate_d70df199e5d794868929f901520760e5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("MGDBasicBundle::layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'description' => array($this, 'block_description'),
            'body_principal' => array($this, 'block_body_principal'),
            'central' => array($this, 'block_central'),
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
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("pedido.metas.title"), "html", null, true);
    }

    // line 4
    public function block_description($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("pedido.metas.description"), "html", null, true);
    }

    // line 6
    public function block_body_principal($context, array $blocks = array())
    {
        // line 7
        echo "
    <article>
        <header style=\"margin-bottom: 20px\">
            <h1>";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("pedido.principal.titulo"), "html", null, true);
        echo "</h1>
            <p>";
        // line 11
        echo $this->env->getExtension('translator')->trans("pedido.principal.texto");
        echo "</p>
        </header>
        <img src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/paypal.png"), "html", null, true);
        echo "\">
    </article>

";
    }

    // line 18
    public function block_central($context, array $blocks = array())
    {
        // line 19
        echo "    <section id=\"contenedor-articulos\">

        <header>
            <h2>";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("pedido.principal.packs"), "html", null, true);
        echo "</h2>
        </header>
        <br>
        ";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["articulos"]) ? $context["articulos"] : $this->getContext($context, "articulos")));
        foreach ($context['_seq'] as $context["_key"] => $context["articulo"]) {
            // line 26
            echo "            <article class=\"articulo\">
                <img src=\"";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["articulo"]) ? $context["articulo"] : $this->getContext($context, "articulo")), "imagenPath"), "html", null, true);
            echo "\">
                <div class=\"paypal\">
                    <div class=\"precio\">";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["articulo"]) ? $context["articulo"] : $this->getContext($context, "articulo")), "precio"), "html", null, true);
            echo twig_escape_filter($this->env, (isset($context["moneda"]) ? $context["moneda"] : $this->getContext($context, "moneda")), "html", null, true);
            echo "</div>
                    ";
            // line 30
            echo $this->getAttribute((isset($context["articulo"]) ? $context["articulo"] : $this->getContext($context, "articulo")), "paypalHtml");
            echo "
                </div>
            </article>

        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['articulo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "    </section>
";
    }

    // line 38
    public function block_aside_principal($context, array $blocks = array())
    {
        // line 39
        echo "
    <h3>";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("pedido.aside.titulo"), "html", null, true);
        echo "</h3>
    <p>";
        // line 41
        echo $this->env->getExtension('translator')->trans("pedido.aside.texto");
        echo "</p>
    <br>
    <a href=\"http://feedback.ebay.com/ws/eBayISAPI.dll?ViewFeedback2&userid=donq18&ftab=AllFeedback&myworld=true\" target=\"_blank\">
        <img src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/ebay_2.jpg"), "html", null, true);
        echo "\">
    </a>
    <br><br>

";
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Pedido:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 44,  126 => 41,  122 => 40,  119 => 39,  116 => 38,  111 => 35,  100 => 30,  95 => 29,  90 => 27,  87 => 26,  83 => 25,  77 => 22,  72 => 19,  69 => 18,  61 => 13,  56 => 11,  52 => 10,  47 => 7,  44 => 6,  38 => 4,  32 => 3,);
    }
}
