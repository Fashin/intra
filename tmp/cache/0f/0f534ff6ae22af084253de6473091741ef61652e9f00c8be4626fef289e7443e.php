<?php

/* pages/update_signature.twig */
class __TwigTemplate_fe8508d949bfb65864223fdb56e96224b44b4a02d99b574562f32d7a28a8f4bf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/update_signature.twig", 1);
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
  <link rel=\"stylesheet\" href=\"../css/update_signature.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        $this->loadTemplate("header.twig", "pages/update_signature.twig", 12)->display($context);
        // line 13
        echo "  <div class=\"setup-objectif\">
    <div class=\"signature-goal\">
      <label for=\"signature_goal\">
        Nombre de signatures du jour : <input type=\"number\" id=\"signature_goal\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["goal"] ?? null), "signature_goal", array()), "html", null, true);
        echo "\">
      </label>
    </div>
    <div class=\"rdv-goal\">
      <label for=\"rdv_goal\">
        Nombre de rendez-vous du jour : <input type=\"number\" id=\"signature_goal\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["goal"] ?? null), "rdv_goal", array()), "html", null, true);
        echo "\">
      </label>
    </div>
    <button type=\"button\" name=\"update\" class=\"update-max\">Mettre a jour</button>
  </div>
    ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["telepros"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["telepro"]) {
            // line 27
            echo "      <div class=\"telepro\">
        <div class=\"avatar\"><img src=\"../";
            // line 28
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "avatar", array()), "html", null, true);
            echo "\" alt=\"\"></div>
        <div class=\"pseudo\">";
            // line 29
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "pseudo", array()), "html", null, true);
            echo "</div>
        <div class=\"btn-update\">
          <i class=\"fa fa-minus-circle\" aria-hidden=\"true\"></i>
          <span class=\"nbr_signature\">";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "nbr_signature", array()), "html", null, true);
            echo "</span>
          <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i>
        </div>
      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['telepro'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "  ";
        $this->loadTemplate("footer.twig", "pages/update_signature.twig", 37)->display($context);
    }

    // line 40
    public function block_script($context, array $blocks = array())
    {
        // line 41
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/update_signature.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/update_signature.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 41,  102 => 40,  97 => 37,  86 => 32,  80 => 29,  76 => 28,  73 => 27,  69 => 26,  61 => 21,  53 => 16,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/update_signature.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/update_signature.twig");
    }
}
