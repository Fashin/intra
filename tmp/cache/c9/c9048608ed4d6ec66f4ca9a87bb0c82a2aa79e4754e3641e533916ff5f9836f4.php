<?php

/* pages/validate_lead.twig */
class __TwigTemplate_f6b563b84850b34f9553ca201cbcdb417f50e61bb1da5fc9cbaee0b3c79d8fea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/validate_lead.twig", 1);
        $this->blocks = array(
            'style' => array($this, 'block_style'),
            'content' => array($this, 'block_content'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_style($context, array $blocks = array())
    {
        // line 4
        echo "  <link href=\"../template/vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">
  <link href=\"../template/vendor/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">
  <link href=\"../template/vendor/datatables/dataTables.bootstrap4.css\" rel=\"stylesheet\">
  <link href=\"../template/css/sb-admin.css\" rel=\"stylesheet\">
  <link rel=\"stylesheet\" href=\"../css/display_agenda.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        $this->loadTemplate("header-telepro.twig", "pages/validate_lead.twig", 12)->display($context);
        // line 13
        echo "    <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Date de creation</th>
        </tr>
      </thead>
      <tbody>
        ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["leads"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lead"]) {
            // line 22
            echo "        <tr>
          ";
            // line 23
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "statut", array()) == 5)) {
                // line 24
                echo "            <td><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
                echo "</a></td>
            <td><a href=\"#\">";
                // line 25
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "created_at", array()), "html", null, true);
                echo "</a></td>
            <input type=\"hidden\" name=\"id_lead\" value=\"";
                // line 26
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
          ";
            } elseif ((twig_get_attribute($this->env, $this->getSourceContext(),             // line 27
$context["lead"], "statut", array()) == 6)) {
                // line 28
                echo "            <td><a href=\"#\" class=\"green\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
                echo "</a></td>
            <td><a href=\"#\" class=\"green\">";
                // line 29
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "created_at", array()), "html", null, true);
                echo "</a></td>
            <input type=\"hidden\" name=\"id_lead\" value=\"";
                // line 30
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
          ";
            }
            // line 32
            echo "        </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['lead'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "      </tbody>
    </table>
    <div class=\"pop_up\"><div class=\"text\"></div></div>
  ";
        // line 37
        $this->loadTemplate("footer.twig", "pages/validate_lead.twig", 37)->display($context);
    }

    // line 40
    public function block_script($context, array $blocks = array())
    {
        // line 41
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/display_lead_agenda.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/validate_lead.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 41,  112 => 40,  108 => 37,  103 => 34,  96 => 32,  91 => 30,  87 => 29,  82 => 28,  80 => 27,  76 => 26,  72 => 25,  67 => 24,  65 => 23,  62 => 22,  58 => 21,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/validate_lead.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/validate_lead.twig");
    }
}
