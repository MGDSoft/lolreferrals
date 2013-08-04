<?php

/* MGDBasicBundle:Contacto:email.text.twig */
class __TwigTemplate_f908a36334cdbf351e76eb6e3c66a480 extends Twig_Template
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
        echo "Nombre:
    ";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "nombre"), "html", null, true);
        echo "

Email:
";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "email"), "html", null, true);
        echo "

Mensaje:
    ";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "mensaje"), "html", null, true);
        echo "

Pedido:
";
        // line 11
        if ($this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "pedido")) {
            // line 12
            echo "    ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["contacto"]) ? $context["contacto"] : $this->getContext($context, "contacto")), "pedido"), "html", null, true);
            echo "
";
        } else {
            // line 14
            echo "    No Declarado
";
        }
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Contacto:email.text.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 14,  42 => 12,  40 => 11,  34 => 8,  28 => 5,  22 => 2,  19 => 1,);
    }
}
