<?php

/* pages/dashboard.twig */
class __TwigTemplate_0c42be9a81c26bce552d5ef0e04da1a5ea6cf1a2b5bd6428c9ec9b7f18d1345a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/dashboard.twig", 1);
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
        echo "  <link href=\"template/vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">
  <link href=\"template/vendor/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">
  <link href=\"template/vendor/datatables/dataTables.bootstrap4.css\" rel=\"stylesheet\">
  <link href=\"template/css/sb-admin.css\" rel=\"stylesheet\">
  <link rel=\"stylesheet\" href=\"css/dashboard.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        $this->loadTemplate("header.twig", "pages/dashboard.twig", 12)->display($context);
        // line 13
        echo "  <div class=\"hidden_statistiques_dashboard\" style=\"display:none\">
    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["statistiques"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["statistique"]) {
            // line 15
            echo "      ";
            echo twig_escape_filter($this->env, $context["statistique"], "html", null, true);
            echo "
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['statistique'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "  </div>
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-area-chart\"></i> Statistiques de la semaine</div>
    <div class=\"card-body\">
      <canvas id=\"myAreaChart\" width=\"100%\" height=\"30\"></canvas>
    </div>
    <div class=\"card-footer small text-muted\">Mise à jour en live</div>
  </div>
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Liste des campages
    </div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Lien</th>
              <th>Formulaire</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nom</th>
              <th>Lien</th>
              <th>Formulaire</th>
            </tr>
          </tfoot>
          <tbody>
          ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["sites"] ?? null));
        foreach ($context['_seq'] as $context["k"] => $context["site"]) {
            // line 49
            echo "            ";
            if (($context["k"] == 0)) {
                // line 50
                echo "              <tr>
                <td>Toutes les campagnes</td>
                <td><a href=\"/leads/all\">Toutes les campagnes</a></td>
                <td>
                  <a href=\"http://leads.objectifsolaire.com\" target=\"_blank\">
                    <button type=\"button\" name=\"button\" class=\"btn-form\">Vers le Hub</button>
                  </a>
                </td>
              </tr>
            ";
            }
            // line 60
            echo "            <tr>
              <td>";
            // line 61
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["site"], "name", array()), "html", null, true);
            echo "</td>
              <td><a href=\"/leads/";
            // line 62
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["site"], "name", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["site"], "name", array()), "html", null, true);
            echo "</a></td>
              <td>
                <a href=\"";
            // line 64
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["site"], "link", array()), "html", null, true);
            echo "\" target=\"_blank\">
                  <button type=\"button\" class=\"btn-form\">";
            // line 65
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["site"], "name", array()), "html", null, true);
            echo "</button>
                </a>
              </td>
            </tr>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['k'], $context['site'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 70
        echo "          </tbody>
        </table>
      </div>
    </div>
    <div class=\"card-footer small text-muted\">Mise à jour en live</div>
  </div>
</div>
  ";
        // line 77
        $this->loadTemplate("footer.twig", "pages/dashboard.twig", 77)->display($context);
    }

    // line 80
    public function block_script($context, array $blocks = array())
    {
        // line 81
        echo "  <script src=\"template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"template/vendor/jquery-easing/jquery.easing.min.js\"></script>
  <script src=\"template/vendor/chart.js/Chart.min.js\"></script>
  <script src=\"template/vendor/datatables/jquery.dataTables.js\"></script>
  <script src=\"template/vendor/datatables/dataTables.bootstrap4.js\"></script>
  <script src=\"template/js/sb-admin.min.js\"></script>
  <script src=\"template/js/sb-admin-datatables.min.js\"></script>
  <script src=\"template/js/sb-admin-charts.js\"></script>

";
    }

    public function getTemplateName()
    {
        return "pages/dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  161 => 81,  158 => 80,  154 => 77,  145 => 70,  134 => 65,  130 => 64,  123 => 62,  119 => 61,  116 => 60,  104 => 50,  101 => 49,  97 => 48,  64 => 17,  55 => 15,  51 => 14,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/dashboard.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/dashboard.twig");
    }
}
