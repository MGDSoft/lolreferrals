<?php

/* JordiLlonchCrudGeneratorBundle::layout.html.twig */
class __TwigTemplate_07ad36e97a7b1144f61014a32eeb2296 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'menu' => array($this, 'block_menu'),
            'page' => array($this, 'block_page'),
            'javascript' => array($this, 'block_javascript'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">

    <!-- Le styles -->
    <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/css/bootstrap.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/css/bootstrap-responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/css/crud.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel=\"shortcut icon\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/images/favicon.ico"), "html", null, true);
        echo "\">
    ";
        // line 27
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 28
        echo "</head>

<body>

<div class=\"container\">
    ";
        // line 33
        $this->displayBlock('menu', $context, $blocks);
        // line 34
        echo "
    ";
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "all", array(), "method"));
        foreach ($context['_seq'] as $context["type"] => $context["flashMessages"]) {
            // line 36
            echo "        ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["flashMessages"]) ? $context["flashMessages"] : $this->getContext($context, "flashMessages")));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 37
                echo "            <div class=\"alert alert-";
                echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
                echo "\">
                ";
                // line 38
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
                echo "
            </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 41
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['flashMessages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "
    ";
        // line 43
        $this->displayBlock('page', $context, $blocks);
        // line 44
        echo "
</div>


<script src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/js/jquery.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/jordillonchcrudgenerator/js/bootstrap.js"), "html", null, true);
        echo "\"></script>

";
        // line 51
        $this->displayBlock('javascript', $context, $blocks);
        // line 52
        echo "</body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.layout.bannersadmin", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
    }

    // line 27
    public function block_stylesheet($context, array $blocks = array())
    {
    }

    // line 33
    public function block_menu($context, array $blocks = array())
    {
    }

    // line 43
    public function block_page($context, array $blocks = array())
    {
    }

    // line 51
    public function block_javascript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "JordiLlonchCrudGeneratorBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  158 => 51,  153 => 43,  148 => 33,  143 => 27,  137 => 5,  132 => 52,  130 => 51,  125 => 49,  121 => 48,  115 => 44,  113 => 43,  110 => 42,  104 => 41,  95 => 38,  90 => 37,  85 => 36,  81 => 35,  78 => 34,  76 => 33,  69 => 28,  67 => 27,  63 => 26,  52 => 18,  48 => 17,  39 => 11,  30 => 5,  24 => 1,  51 => 12,  46 => 10,  43 => 9,  37 => 6,  34 => 5,  31 => 4,  28 => 3,);
    }
}
