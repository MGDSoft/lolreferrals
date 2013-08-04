<?php

/* MGDAdminBundle:Security:login.html.twig */
class __TwigTemplate_28f9764bfca29557a5a1798cbe1dd483 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("JordiLlonchCrudGeneratorBundle::layout.html.twig");

        $this->blocks = array(
            'page' => array($this, 'block_page'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "JordiLlonchCrudGeneratorBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_page($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        if ((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error"))) {
            // line 5
            echo "        <div class=\"alert alert-error\">
            ";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "message"), "html", null, true);
            echo "
        </div>
    ";
        }
        // line 9
        echo "
    <form action=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("login_check");
        echo "\" method=\"post\">
        <label for=\"username\">Usuario:</label>
        <input id=\"username\" type=\"text\" name=\"_username\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["last_username"]) ? $context["last_username"] : $this->getContext($context, "last_username")), "html", null, true);
        echo "\" />
        <label for=\"password\">Contraseña:</label>
        <input id=\"password\" type=\"password\" name=\"_password\" />
        <br>

        <button class=\"btn btn-success\" type=\"submit\">login</button>
    </form>
";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 12,  46 => 10,  43 => 9,  37 => 6,  34 => 5,  31 => 4,  28 => 3,);
    }
}
