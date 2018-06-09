<?php

/* pages/telepro.twig */
class __TwigTemplate_59e89ddff35599325fce5640b9adc5aa71a5519b10eff57c348f2f6875d5cb62 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/telepro.twig", 1);
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
  <link rel=\"stylesheet\" href=\"../css/telepro.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        $this->loadTemplate("header-telepro.twig", "pages/telepro.twig", 12)->display($context);
        // line 13
        echo "  <input type=\"hidden\" name=\"user_id\" class=\"id_user\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "id", array()), "html", null, true);
        echo "\">
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Liste des leads
    </div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Téléphone</th>
              <th>Date d'envoie</th>
              <th>Rappel</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Téléphone</th>
              <th>Date d'envoie</th>
              <th>Rappel</th>
            </tr>
          </tfoot>
          <tbody>
            ";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["current_leads"] ?? null));
        foreach ($context['_seq'] as $context["date"] => $context["dates"]) {
            // line 41
            echo "              ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["dates"]);
            foreach ($context['_seq'] as $context["_key"] => $context["lead"]) {
                // line 42
                echo "                <tr>
                  <td>
                    <a style=\"color:";
                // line 44
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_color", array()), "html", null, true);
                echo "\" href=\"/telepro/get_one_lead/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
                      ";
                // line 45
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
                echo "
                    </a>
                  </td>
                  <td>
                    <a style=\"color:";
                // line 49
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_color", array()), "html", null, true);
                echo "\" href=\"/telepro/get_one_lead/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
                      ";
                // line 50
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "prenom", array()), "html", null, true);
                echo "
                    </a>
                  </td>
                  <td>
                    <a style=\"color:";
                // line 54
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_color", array()), "html", null, true);
                echo "\" href=\"/telepro/get_one_lead/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
                      ";
                // line 55
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "telephone", array()), "html", null, true);
                echo "
                    </a>
                  </td>
                  <td>
                    ";
                // line 59
                echo twig_escape_filter($this->env, $context["date"], "html", null, true);
                echo "
                  </td>
                  <td></td>
                  <input type=\"hidden\" name=\"id_lead\" value=\"";
                // line 62
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
                </tr>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['lead'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 65
            echo "              <td colspan=\"5\" class=\"new_day\"></td>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['date'], $context['dates'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        echo "          </tbody>
        </table>
      </div>
    </div>
  </div>
  ";
        // line 72
        $this->loadTemplate("footer.twig", "pages/telepro.twig", 72)->display($context);
    }

    // line 75
    public function block_script($context, array $blocks = array())
    {
        // line 76
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/User.class.js\" charset=\"utf-8\"></script>
  <script src=\"../js/rappel_telepro.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/telepro.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  167 => 76,  164 => 75,  160 => 72,  153 => 67,  146 => 65,  137 => 62,  131 => 59,  124 => 55,  118 => 54,  111 => 50,  105 => 49,  98 => 45,  92 => 44,  88 => 42,  83 => 41,  79 => 40,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/telepro.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/telepro.twig");
    }
}
