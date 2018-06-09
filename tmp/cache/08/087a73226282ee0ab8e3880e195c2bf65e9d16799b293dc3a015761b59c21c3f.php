<?php

/* pages/display_agenda.twig */
class __TwigTemplate_6a35ce5c47d1ca907c2d4f46f95c4fb1eb39fde02d354ccb29f1210043579231 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/display_agenda.twig", 1);
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
        $this->loadTemplate("header.twig", "pages/display_agenda.twig", 12)->display($context);
        // line 13
        echo "  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Signature a valide : <span class=\"nbr_leads_tab\"></span>
    </div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Date de creation</th>
            </tr>
          </thead>
          <tbody>
            ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["leads"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lead"]) {
            // line 28
            echo "            <tr>
              ";
            // line 29
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "statut", array()) == 5)) {
                // line 30
                echo "                <td><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
                echo "</a></td>
                <td><a href=\"#\">";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "created_at", array()), "html", null, true);
                echo "</a></td>
                <input type=\"hidden\" name=\"id_lead\" value=\"";
                // line 32
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
              ";
            } elseif (((twig_get_attribute($this->env, $this->getSourceContext(),             // line 33
$context["lead"], "statut", array()) == 6) || (twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "statut", array()) == 7))) {
                // line 34
                echo "                <td><a href=\"#\" class=\"green\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
                echo "</a></td>
                <td><a href=\"#\" class=\"green\">";
                // line 35
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "created_at", array()), "html", null, true);
                echo "</a></td>
                <input type=\"hidden\" name=\"id_lead\" value=\"";
                // line 36
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id", array()), "html", null, true);
                echo "\">
              ";
            }
            // line 38
            echo "            </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['lead'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "          </tbody>
        </table>
      </div>
    </div>
    <div class=\"card-footer small text-muted\">Mise à jour en live</div>
  </div>
  <div class=\"pop_up\">
    <div class=\"text\">

    </div>
  </div>
  ";
        // line 51
        $this->loadTemplate("footer.twig", "pages/display_agenda.twig", 51)->display($context);
    }

    // line 54
    public function block_script($context, array $blocks = array())
    {
        // line 55
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/display_lead_agenda.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/display_agenda.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 55,  126 => 54,  122 => 51,  109 => 40,  102 => 38,  97 => 36,  93 => 35,  88 => 34,  86 => 33,  82 => 32,  78 => 31,  73 => 30,  71 => 29,  68 => 28,  64 => 27,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/display_agenda.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/display_agenda.twig");
    }
}
