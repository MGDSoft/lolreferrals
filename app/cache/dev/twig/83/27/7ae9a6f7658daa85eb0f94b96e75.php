<?php

/* ::base.html.twig */
class __TwigTemplate_83277ae9a6f7658daa85eb0f94b96e75 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock("title", $context, $blocks);
        echo "</title>
        <meta name=\"description\" content=\"";
        // line 6
        $this->displayBlock("description", $context, $blocks);
        echo "\">

        <meta property=\"og:title\" content=\"";
        // line 8
        $this->displayBlock("title", $context, $blocks);
        echo "\" />
        <meta property=\"og:description\" content=\"";
        // line 9
        $this->displayBlock("description", $context, $blocks);
        echo "\" />
        <meta property=\"og:image\" content=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/logo.png"), "html", null, true);
        echo "\"/>

        ";
        // line 12
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 16
        $this->displayBlock('body', $context, $blocks);
        // line 17
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 18
        echo "    </body>
</html>
";
    }

    // line 12
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 16
    public function block_body($context, array $blocks = array())
    {
    }

    // line 17
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 17,  75 => 16,  70 => 12,  64 => 18,  61 => 17,  59 => 16,  52 => 13,  50 => 12,  45 => 10,  41 => 9,  37 => 8,  32 => 6,  28 => 5,  22 => 1,);
    }
}
