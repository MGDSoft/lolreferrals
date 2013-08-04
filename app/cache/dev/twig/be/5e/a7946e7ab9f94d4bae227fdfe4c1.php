<?php

/* MGDBasicBundle:Contacto:email.html.twig */
class __TwigTemplate_be5ea7946e7ab9f94d4bae227fdfe4c1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Nombre:<br>
    ";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "nombre"), "html", null, true);
        echo "<br><br>

Email:<br>
";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "email"), "html", null, true);
        echo "<br><br>

Mensaje:<br>
    ";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "mensaje"), "html", null, true);
        echo "<br><br>

Pedido:<br><br>
    ";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "pedido"), "html", null, true);
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Contacto:email.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 11,  34 => 8,  28 => 5,  22 => 2,  19 => 1,);
    }
}
