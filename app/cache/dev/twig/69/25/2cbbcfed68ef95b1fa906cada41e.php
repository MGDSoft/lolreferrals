<?php

/* MGDBasicBundle:Seguimiento:index.html.twig */
class __TwigTemplate_69252cbbcfed68ef95b1fa906cada41e extends Twig_Template
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
        <header>
            <h1>";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("seguimiento.principal.titulo"), "html", null, true);
        echo "</h1>
            <p>
                ";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("seguimiento.principal.texto"), "html", null, true);
        echo "
            </p>

        </header>
        <section>
            <br>
            <form id=\"contacto\" action=\"";
        // line 18
        echo $this->env->getExtension('routing')->getPath(("seguimiento_" . $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request"), "locale")));
        echo "\" method=\"post\">
                ";
        // line 19
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["seguimiento_form"]) ? $context["seguimiento_form"] : $this->getContext($context, "seguimiento_form")), 'widget');
        echo "

                <input type=\"submit\" class=\"btn btn-primary\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.seguimiento.submit"), "html", null, true);
        echo "\">

            </form>

                ";
        // line 25
        if ((isset($context["seguimientos"]) ? $context["seguimientos"] : $this->getContext($context, "seguimientos"))) {
            // line 26
            echo "                    <br>
                    <h4>";
            // line 27
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.seguimiento.seguimiento"), "html", null, true);
            echo ": ";
            echo twig_escape_filter($this->env, (isset($context["seguimientoId"]) ? $context["seguimientoId"] : $this->getContext($context, "seguimientoId")), "html", null, true);
            echo "</h4>

                    <table id=\"seguimiento\">
                    <tr>
                        <th>";
            // line 31
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.seguimiento.estado"), "html", null, true);
            echo "</th>
                        <th>";
            // line 32
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.seguimiento.fecha"), "html", null, true);
            echo "</th>
                        <th>";
            // line 33
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("formularios.seguimiento.descripcion"), "html", null, true);
            echo "</th>
                    </tr>

                    ";
            // line 36
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["seguimientos"]) ? $context["seguimientos"] : $this->getContext($context, "seguimientos")));
            foreach ($context['_seq'] as $context["_key"] => $context["seguimiento"]) {
                // line 37
                echo "                        <tr>
                            <td>";
                // line 38
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["seguimiento"]) ? $context["seguimiento"] : $this->getContext($context, "seguimiento")), "estado"), "html", null, true);
                echo "</td>
                            <td>";
                // line 39
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["seguimiento"]) ? $context["seguimiento"] : $this->getContext($context, "seguimiento")), "fecha"), "Y-m-d H:i:s"), "html", null, true);
                echo "</td>
                            <td>";
                // line 40
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["seguimiento"]) ? $context["seguimiento"] : $this->getContext($context, "seguimiento")), "descripcion"), "html", null, true);
                echo "</td>
                        </tr>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['seguimiento'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "                </table>

                ";
        }
        // line 46
        echo "        </section>
    </article>

";
    }

    // line 51
    public function block_aside_principal($context, array $blocks = array())
    {
        // line 52
        echo "
    <h3>";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("contacto.aside.titulo"), "html", null, true);
        echo "</h3>
    <p>";
        // line 54
        echo $this->env->getExtension('translator')->trans("contacto.aside.texto");
        echo "</p>
    <br>

";
    }

    public function getTemplateName()
    {
        return "MGDBasicBundle:Seguimiento:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  155 => 54,  151 => 53,  148 => 52,  145 => 51,  138 => 46,  133 => 43,  124 => 40,  120 => 39,  116 => 38,  113 => 37,  109 => 36,  103 => 33,  99 => 32,  95 => 31,  86 => 27,  83 => 26,  81 => 25,  74 => 21,  69 => 19,  65 => 18,  56 => 12,  51 => 10,  46 => 7,  43 => 6,  37 => 4,  31 => 3,);
    }
}
