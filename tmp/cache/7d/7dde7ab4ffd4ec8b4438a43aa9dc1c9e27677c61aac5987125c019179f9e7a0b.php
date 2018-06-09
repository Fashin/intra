<?php

/* pages/telepro_statistiques.twig */
class __TwigTemplate_c9691ab012825c7114cf77b8b2f27ec6985dc06dc727dd1758ebffbda022a212 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/telepro_statistiques.twig", 1);
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
  <link rel=\"stylesheet\" href=\"../css/telepro_statistiques.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        $this->loadTemplate("header.twig", "pages/telepro_statistiques.twig", 12)->display($context);
        // line 13
        echo "  <div class=\"filter\">
    <select id=\"telepro_name\">
      <option value=\"all\">Tous</option>
    ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["telepros"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["telepro"]) {
            // line 17
            echo "      ";
            if (($context["id"] != "total")) {
                // line 18
                echo "        <option value=\"";
                echo twig_escape_filter($this->env, $context["id"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "name", array()), "html", null, true);
                echo "</option>
      ";
            }
            // line 20
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['telepro'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </select>
    <label for=\"date_value\">
      Jour : <input type=\"date\" id=\"date_value\" name=\"date_value\">
    </label>
    <label for=\"date_start\">
      De : <input type=\"date\" id=\"date_start\" name=\"date_start\">
    </label>
    <label for=\"date_end\">
      A : <input type=\"date\" id=\"date_end\" name=\"date_end\">
    </label>
    <button type=\"button\" class=\"send_filter\">Trier</button>
  </div>
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Statistiques des téléprospecteur
    </div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered listStatistiques\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Pas interesser</th>
              <th>Non Financeable</th>
              <th>Hors Critere</th>
              <th>Fausse Annonce</th>
              <th>Rendez-vous</th>
              <th>Signatures</th>
              <th>Leads Envoyés</th>
              <th>Taux Rendez-vous</th>
              <th>Taux Signature</th>
              <!-- <th>Fiches</th> -->
            </tr>
          </thead>
          <tbody>
            ";
        // line 56
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["telepros"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["telepro"]) {
            // line 57
            echo "              ";
            if (($context["id"] != "total")) {
                // line 58
                echo "                <tr>
                  <td>";
                // line 59
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "name", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"1\">";
                // line 60
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "pas_interesser", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"2\">";
                // line 61
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "non_financeable", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"3\">";
                // line 62
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "hors_critere", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"4\">";
                // line 63
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "fausse_annonce", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"5\">";
                // line 64
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "rendez_vous", array()), "html", null, true);
                echo "</td>
                  <td data-type=\"6\">";
                // line 65
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "signature", array()), "html", null, true);
                echo "</td>
                  <td>";
                // line 66
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "total", array()), "html", null, true);
                echo "</td>
                  <td>";
                // line 67
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "transformation_rdv", array()), "html", null, true);
                echo " %</td>
                  <td>";
                // line 68
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "value", array()), "transformation_signature", array()), "html", null, true);
                echo " %</td>
                  <!-- <td><a href=\"/telepro/display_date/";
                // line 69
                echo twig_escape_filter($this->env, $context["id"], "html", null, true);
                echo "\">Voire</a></td> -->
                  <input type=\"hidden\" name=\"id_telepro\" value=\"";
                // line 70
                echo twig_escape_filter($this->env, $context["id"], "html", null, true);
                echo "\">
                </tr>
              ";
            }
            // line 73
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['telepro'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        echo "            <tr>
              <td>Total</td>
              <td>";
        // line 76
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "pas_interesser", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 77
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "non_financeable", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 78
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "hors_critere", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 79
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "fausse_annonce", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 80
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "rendez_vous", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 81
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "signature", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 82
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "total", array(), "array"), "html", null, true);
        echo "</td>
              <td>";
        // line 83
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "transformation_rdv", array(), "array"), "html", null, true);
        echo " %</td>
              <td>";
        // line 84
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["telepros"] ?? null), "total", array(), "array"), "transformation_signature", array(), "array"), "html", null, true);
        echo " %</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class=\"pop_up\">
    <div class=\"content\">
      <div class=\"telepro-selector\">
        <select class=\"telepro-name\">
          ";
        // line 95
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["telepros"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["telepro"]) {
            // line 96
            echo "            ";
            if (($context["id"] != "total")) {
                // line 97
                echo "              <option value=\"";
                echo twig_escape_filter($this->env, $context["id"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "name", array()), "html", null, true);
                echo "</option>
            ";
            }
            // line 99
            echo "          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['telepro'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 100
        echo "        </select>
        <i class=\"fa fa-telegram send_to_telepro\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"card mb-3\">
        <div class=\"card-header\">
          <i class=\"fa fa-table\"></i> Liste des leads
        </div>
        <div class=\"card-body\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered listLeads\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
              <thead>
                <tr>
                  <th></th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Téléphone</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  ";
        // line 126
        $this->loadTemplate("footer.twig", "pages/telepro_statistiques.twig", 126)->display($context);
    }

    // line 129
    public function block_script($context, array $blocks = array())
    {
        // line 130
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/telepro_statistiques.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/telepro_statistiques.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  283 => 130,  280 => 129,  276 => 126,  248 => 100,  242 => 99,  234 => 97,  231 => 96,  227 => 95,  213 => 84,  209 => 83,  205 => 82,  201 => 81,  197 => 80,  193 => 79,  189 => 78,  185 => 77,  181 => 76,  177 => 74,  171 => 73,  165 => 70,  161 => 69,  157 => 68,  153 => 67,  149 => 66,  145 => 65,  141 => 64,  137 => 63,  133 => 62,  129 => 61,  125 => 60,  121 => 59,  118 => 58,  115 => 57,  111 => 56,  74 => 21,  68 => 20,  60 => 18,  57 => 17,  53 => 16,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/telepro_statistiques.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/telepro_statistiques.twig");
    }
}
