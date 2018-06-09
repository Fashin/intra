<?php

/* pages/factures.twig */
class __TwigTemplate_9c53b06af3d6206c2982693fd1ed2eb8adc989673ad39735dd01754cecde5a65 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/factures.twig", 1);
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
  <link rel=\"stylesheet\" href=\"css/factures.css\">
  <link rel=\"stylesheet\" href=\"font-awesome/css/font-awesome.css\">
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        echo "  ";
        $this->loadTemplate("header.twig", "pages/factures.twig", 13)->display($context);
        // line 14
        echo "  <a href=\"/user/option_entreprise\"><i class=\"fa fa-cog fa-2x option_entreprise\"></i></a>
  <form class=\"new_entreprise\" action=\"#\" method=\"post\">
    <input type=\"text\" name=\"nom\" placeholder=\"Nom de l'entreprise\">
    <input type=\"mail\" name=\"email-0\" placeholder=\"Email\">
    <i class=\"fa fa-plus-circle fa-2x add-email\" aria-hidden=\"true\"></i>
    <input type=\"text\" name=\"rue\" placeholder=\"Rue de l'entreprise\">
    <input type=\"text\" name=\"ville\" placeholder=\"Ville de l'entreprise\">
    <input type=\"text\" name=\"code_postal\" placeholder=\"Code postal\">
    <input type=\"submit\" name=\"send\" value=\"Enregistrer\">
  </form>
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Liste des entreprises</div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Nombres de leads envoyé dans le mois</th>
              <th>Nom de leads envoyé au total</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nom</th>
              <th>Nombres de factures envoyé dans le mois</th>
              <th>Nom de factures envoyé au total</th>
            </tr>
          </tfoot>
          <tbody id=\"tableContent\">
            ";
        // line 45
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["entreprises"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["entreprise"]) {
            // line 46
            echo "              <tr>
                <td><a href=\"/factures/";
            // line 47
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["entreprise"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "</a></td>
                <td>";
            // line 48
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["entreprise"], "month", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 49
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["entreprise"], "total", array()), "html", null, true);
            echo "</td>
              </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['entreprise'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "          </tbody>
        </table>
      </div>
    </div>
    <div class=\"card-footer small text-muted\">Updated yesterday at 11:59 PM</div>
  </div>
</div>
  ";
        // line 59
        $this->loadTemplate("footer.twig", "pages/factures.twig", 59)->display($context);
    }

    // line 62
    public function block_script($context, array $blocks = array())
    {
        // line 63
        echo "  <script src=\"template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"template/js/sb-admin.min.js\"></script>
  <script charset=\"utf-8\">
    \$('.add-email').click((e) => {
      \$(e.target).after(\"<input type='mail' class='new-input-mail' name='email-\" + \$('input[type=\"mail\"]').length + \"' placeholder='Email'>\");
    })
  </script>
";
    }

    public function getTemplateName()
    {
        return "pages/factures.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 63,  121 => 62,  117 => 59,  108 => 52,  99 => 49,  95 => 48,  89 => 47,  86 => 46,  82 => 45,  49 => 14,  46 => 13,  43 => 12,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/factures.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/factures.twig");
    }
}
