<?php

/* pages/personnal_options.twig */
class __TwigTemplate_34da0823822669bf49a7a0a433a0e3b6f4fa9a8e5b9cfe963954ebea74c1f013 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/personnal_options.twig", 1);
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
  <link rel=\"stylesheet\" href=\"css/user_options.css\">
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "  ";
        if ((($context["type"] ?? null) == "telemarketing")) {
            // line 13
            echo "    ";
            $this->loadTemplate("header-telepro.twig", "pages/personnal_options.twig", 13)->display($context);
            // line 14
            echo "  ";
        } else {
            // line 15
            echo "    ";
            $this->loadTemplate("header.twig", "pages/personnal_options.twig", 15)->display($context);
            // line 16
            echo "  ";
        }
        // line 17
        echo "    <input type=\"hidden\" name=\"id_user\" class=\"id_user\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "id", array()), "html", null, true);
        echo "\">
    <form class=\"params\" action=\"#\" method=\"post\">
      <input type=\"password\" name=\"new_password\" placeholder=\"Votre nouveau mot de passe\">
      <input type=\"password\" name=\"new_password_confirm\" placeholder=\"Confirmer votre nouveau mot de passe\">
      <input type=\"password\" name=\"old_password\" placeholder=\"Votre ancien mot de passe\">
      <input type=\"submit\" name=\"send\" value=\"Modifié\">
    </form>
    <form class=\"params params-avatar\" action=\"/user/update_avatar\" method=\"post\" enctype=\"multipart/form-data\">
      <label for=\"avatar\" class=\"avatar\">Changer votre avatar :
        <input type=\"file\" name=\"avatar\">
      </label>
      <input type=\"submit\" name=\"send\" value=\"Sauvegarder\">
    </form>
    ";
        // line 30
        if ((($context["type"] ?? null) == "telemarketing")) {
            // line 31
            echo "      <div class=\"color_save\">
        <label for=\"lead_selection\">
          <input type=\"color\" id=\"lead_selection\" name=\"lead_selection\" value=\"";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_selection", array()), "html", null, true);
            echo "\"> Couleur de sélection des leads
        </label> <br><br>
        <label for=\"lead_color\">
          <input type=\"color\" id=\"lead_color\" name=\"lead_color\" value=\"";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_color", array()), "html", null, true);
            echo "\"> Couleur des leads dans le tableau de bord
        </label> <br><br>
        <label for=\"lead_rappel\">
          <input type=\"color\" id=\"lead_rappel\" name=\"lead_rappel\" value=\"";
            // line 39
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "lead_rappel", array()), "html", null, true);
            echo "\"> Couleur des rappels dans le tableau de bord
        </label>
      </div>
    ";
        } else {
            // line 43
            echo "      <div class=\"color_save\">
        <label for=\"color_scoreboard_rdv\">
          <input type=\"color\" id=\"color_scoreboard_rdv\" name=\"color_scoreboard\" value=\"";
            // line 45
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["configuration"] ?? null), "scoreboard", array()), "rdv", array()), "html", null, true);
            echo "\"> Couleur des rendez (scoreboard)
        </label>
        <label for=\"color_scoreboard_signature\">
          <input type=\"color\" id=\"color_scoreboard_signature\" name=\"color_scoreboard_signature\" value=\"";
            // line 48
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["configuration"] ?? null), "scoreboard", array()), "signature", array()), "html", null, true);
            echo "\"> Couleur des signatures (scoreboard)
        </label>
      </div>
    ";
        }
        // line 52
        echo "  ";
        $this->loadTemplate("footer.twig", "pages/personnal_options.twig", 52)->display($context);
    }

    // line 55
    public function block_script($context, array $blocks = array())
    {
        // line 56
        echo "  <script src=\"template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"template/js/sb-admin.min.js\"></script>
  <script src=\"js/User.class.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/personnal_options.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 56,  124 => 55,  119 => 52,  112 => 48,  106 => 45,  102 => 43,  95 => 39,  89 => 36,  83 => 33,  79 => 31,  77 => 30,  60 => 17,  57 => 16,  54 => 15,  51 => 14,  48 => 13,  45 => 12,  42 => 11,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/personnal_options.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/personnal_options.twig");
    }
}
