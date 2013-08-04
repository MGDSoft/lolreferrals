<?php

/* MGDAdminBundle:Noticia:index.html.twig */
class __TwigTemplate_b4c10dca6164729fa1302a2edb982575 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("MGDAdminBundle::layout_admin.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'page' => array($this, 'block_page'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "MGDAdminBundle::layout_admin.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        $this->displayParentBlock("title", $context, $blocks);
        echo " - ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.list", array("%entity%" => "Noticia"), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
";
    }

    // line 7
    public function block_page($context, array $blocks = array())
    {
        // line 8
        echo "
<div class=\"row\">

    <div class=\"span8\">
        <h1>";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.list", array("%entity%" => "Noticia"), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</h1>
    </div>
    <div class=\"span2\">
        ";
        // line 15
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), 'errors')) {
            // line 16
            echo "        <div class=\"alert alert-block alert-error fade in form-errors\">
            ";
            // line 17
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), 'errors');
            echo "
        </div>
        ";
        }
        // line 20
        echo "        &nbsp;
    </div>
    <div class=\"span2\">
        <div class=\"filters-right\">
            <a class=\"btn dropdown-toggle\" data-toggle=\"collapse\" data-target=\"#filters\">
                ";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.filters", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "
                <span class=\"caret\"></span>
            </a>
        </div>
    </div>

    <div class=\"span12\">
        <div id=\"filters\" class=\"collapse\">

            <form class=\"well\" action=\"";
        // line 34
        echo $this->env->getExtension('routing')->getPath("noticia");
        echo "\" method=\"get\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), 'enctype');
;
        echo ">
                ";
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), "id"), 'row');
        echo "
                ";
        // line 36
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), "titulo"), 'row');
        echo "
                ";
        // line 37
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), "noticia"), 'row');
        echo "
                ";
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), "fecha"), 'row');
        echo "
                ";
        // line 39
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), "slug"), 'row');
        echo "
                ";
        // line 40
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["filterForm"]) ? $context["filterForm"] : $this->getContext($context, "filterForm")), 'rest');
        echo "

                <p>
                    <button type=\"submit\" name=\"filter_action\" value=\"filter\">";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.filter", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</button>
                    <button type=\"submit\" name=\"filter_action\" value=\"reset\">";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.reset", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</button>
                </p>
            </form>
        </div>
    </div>

    <div class=\"span12\">

    <table class=\"table table-striped table-bordered table-condensed\">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Fecha</th>
            <th>Autor</th>
            <th>";
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.actions", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo "</th>
        </tr>
    </thead>
    <tbody>
    ";
        // line 63
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 64
            echo "        <tr>
            <td><a href=\"";
            // line 65
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("noticia_show", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"), "html", null, true);
            echo "</a></td>
            <td>";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "titulo"), "html", null, true);
            echo "</td>
            <td>";
            // line 67
            if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "fecha")) {
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "fecha"), "Y-m-d H:i:s"), "html", null, true);
            }
            echo "</td>
            <td>";
            // line 68
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "usuario"), "html", null, true);
            echo "</td>
            <td>
        <a class=\"btn btn-mini\" href=\"";
            // line 70
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("noticia_show", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\">
            ";
            // line 71
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.actions.show", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
            echo "
        </a>
        <a class=\"btn btn-mini\" href=\"";
            // line 73
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("noticia_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id"))), "html", null, true);
            echo "\">
            ";
            // line 74
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.actions.edit", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
            echo "
        </a>            </td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 78
        echo "    </tbody>
</table>
    </div>

    <div class=\"span4\">
    ";
        // line 83
        echo (isset($context["pagerHtml"]) ? $context["pagerHtml"] : $this->getContext($context, "pagerHtml"));
        echo "
    </div>

        <div class=\"span8\">
    <a class=\"btn btn-primary likepaginator\" href=\"";
        // line 87
        echo $this->env->getExtension('routing')->getPath("noticia_new");
        echo "\">
            ";
        // line 88
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("views.index.createnew", array(), "JordiLlonchCrudGeneratorBundle"), "html", null, true);
        echo " Noticia
        </a>
    </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "MGDAdminBundle:Noticia:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 88,  212 => 87,  205 => 83,  198 => 78,  188 => 74,  184 => 73,  179 => 71,  175 => 70,  170 => 68,  164 => 67,  160 => 66,  154 => 65,  151 => 64,  147 => 63,  140 => 59,  122 => 44,  118 => 43,  112 => 40,  108 => 39,  104 => 38,  100 => 37,  96 => 36,  92 => 35,  85 => 34,  73 => 25,  66 => 20,  60 => 17,  57 => 16,  55 => 15,  49 => 12,  43 => 8,  40 => 7,  32 => 4,  29 => 3,);
    }
}
