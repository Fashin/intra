<?php

/* pages/scoreboard.twig */
class __TwigTemplate_d4c14a20c3c94eac6d3e338ab84e20018019bb8ab9a025c26e79151f55ea8e42 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/scoreboard.twig", 1);
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
  <link rel=\"stylesheet\" href=\"../css/scoreboard.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  <!-- -->
  <div class=\"chart-container\" style=\"position:relative; height: 90vh; width: 95vw\" >
    <canvas id=\"scoreboard\"></canvas>
  </div>
  <div class=\"avatar-container\"></div>
  <div class=\"animation-container\">
    <img src=\"../img/avatar/giphy.webp\" class=\"firework-animation\" alt=\"\">
  </div>
  <audio src=\"../music/tada.mp3\" id=\"tada\"></audio>
  <audio src=\"../music/succes_queen.mp3\" id=\"signature_goal\"></audio>
  <audio src=\"../music/succes_mario.mp3\" id=\"rdv_goal\"></audio>
  <input type=\"hidden\" name=\"color_scoreboard_rdv\" id=\"color_scoreboard_rdv\" value=\"";
        // line 23
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["scoreboard"] ?? null), "color", array()), "rdv", array()), "html", null, true);
        echo "\">
  <input type=\"hidden\" name=\"color_scoreboard_signature\" id=\"color_scoreboard_signature\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["scoreboard"] ?? null), "color", array()), "signature", array()), "html", null, true);
        echo "\">

";
    }

    // line 28
    public function block_script($context, array $blocks = array())
    {
        // line 29
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js\" charset=\"utf-8\"></script>
  <script src=\"../js/User.class.js\" charset=\"utf-8\"></script>
  <script src=\"../js/display_scoreboard.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/scoreboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 29,  69 => 28,  62 => 24,  58 => 23,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/scoreboard.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/scoreboard.twig");
    }
}
