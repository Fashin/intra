<?php

/* pages/connexion.twig */
class __TwigTemplate_c6870d7dc51ea84db8cee59de36af1d7661877a274bd2fefa9c2abecf7b64c22 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/connexion.twig", 1);
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
";
    }

    // line 10
    public function block_content($context, array $blocks = array())
    {
        // line 11
        echo "<body class=\"bg-dark\">
  <div class=\"container\">
    <div class=\"card card-login mx-auto mt-5\">
      <div class=\"card-header\">Login</div>
      <div class=\"card-body\">
        <form action=\"#\" method=\"post\">
          <div class=\"form-group\">
            <label for=\"exampleInputEmail1\">Login</label>
            <input class=\"form-control\" id=\"exampleInputEmail1\" type=\"text\" name=\"pseudo\" aria-describedby=\"emailHelp\" placeholder=\"Enter login\">
          </div>
          <div class=\"form-group\">
            <label for=\"exampleInputPassword1\">Password</label>
            <input class=\"form-control\" id=\"exampleInputPassword1\" name=\"password\" type=\"password\" placeholder=\"Password\">
          </div>
          <div class=\"form-group\">
            <div class=\"form-check\">
              <label class=\"form-check-label\">
                <input class=\"form-check-input\" type=\"checkbox\"> Remember Password</label>
            </div>
          </div>
          <input type=\"submit\" name=\"send\" class=\"btn btn-primary btn-block\" value=\"Login\">
          <!-- <a class=\"btn btn-primary btn-block\" href=\"/\">Login</a> -->
        </form>
      </div>
    </div>
  </div>
</body>
";
    }

    // line 40
    public function block_script($context, array $blocks = array())
    {
        // line 41
        echo "  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/connexion.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 41,  75 => 40,  44 => 11,  41 => 10,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/connexion.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/connexion.twig");
    }
}
