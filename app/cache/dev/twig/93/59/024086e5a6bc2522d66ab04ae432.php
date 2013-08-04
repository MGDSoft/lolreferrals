<?php

/* MGDAdminBundle::menu_admin.html.twig */
class __TwigTemplate_9359024086e5a6bc2522d66ab04ae432 extends Twig_Template
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
        echo "
            <ul>
                <h3>Opciones de la página</h3>

                <li><a href=\"";
        // line 5
        echo $this->env->getExtension('routing')->getPath("noticia");
        echo "\">Noticias</a></li>
                <li><a href=\"";
        // line 6
        echo $this->env->getExtension('routing')->getPath("contacto");
        echo "\">Preguntas de clientes</a></li>
                <li><a href=\"";
        // line 7
        echo $this->env->getExtension('routing')->getPath("pedido");
        echo "\">Pedidos Realizados</a></li>
                <li><a href=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("pedidoestados");
        echo "\">Estado de pedidos</a></li>


                ";
        // line 11
        if ($this->env->getExtension('security')->isGranted("ROLE_SUPER_ADMIN")) {
            // line 12
            echo "                    <li><a href=\"";
            echo $this->env->getExtension('routing')->getPath("estado");
            echo "\">Estados</a></li>
                    <li><a href=\"";
            // line 13
            echo $this->env->getExtension('routing')->getPath("articulo");
            echo "\">Articulos en venta</a></li>
            </ul>
            <ul>
                    <h3>Opciones de Usuarios</h3>

                    <li><a href=\"";
            // line 18
            echo $this->env->getExtension('routing')->getPath("usuario");
            echo "\">Usuarios</a></li>
                    <li><a href=\"";
            // line 19
            echo $this->env->getExtension('routing')->getPath("rol");
            echo "\">Roles</a></li>

                ";
        }
        // line 22
        echo "            </ul>
            <ul>
                <h3>Otras Opciones</h3>

                <li><b>Usuario</b>: ";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user"), "username"), "html", null, true);
        echo "</li>
                <li>
                    <b>Rol</b>:
                    ";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user"), "getUserRoles", array(), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["rol"]) {
            // line 30
            echo "                        ";
            echo twig_escape_filter($this->env, (isset($context["rol"]) ? $context["rol"] : $this->getContext($context, "rol")), "html", null, true);
            echo "
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rol'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "                </li>
                <li style=\"margin-top: 20px\"><a href=\"";
        // line 33
        echo $this->env->getExtension('routing')->getPath("logout");
        echo "\">Salir / logout</a></li>

            </ul>



";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle::menu_admin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 33,  93 => 32,  84 => 30,  80 => 29,  74 => 26,  68 => 22,  62 => 19,  58 => 18,  50 => 13,  45 => 12,  43 => 11,  37 => 8,  33 => 7,  29 => 6,  25 => 5,  19 => 1,);
    }
}
