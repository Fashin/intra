<?php

/* footer.twig */
class __TwigTemplate_e02b793977c2525e86a86ff8d6c4e6390aba4afdee91f7fa7622e7e51125f51b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "</div>
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<footer class=\"sticky-footer\">
<div class=\"container\">
  <div class=\"text-center\">
    <small>Copyright © Objectif Solaire</small>
  </div>
</div>
</footer>
<!-- Scroll to Top Button-->
<a class=\"scroll-to-top rounded\" href=\"#page-top\">
<i class=\"fa fa-angle-up\"></i>
</a>
<!-- Logout Modal-->
<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
<div class=\"modal-dialog\" role=\"document\">
  <div class=\"modal-content\">
    <div class=\"modal-header\">
      <h5 class=\"modal-title\" id=\"exampleModalLabel\">Ready to Leave?</h5>
      <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
        <span aria-hidden=\"true\">×</span>
      </button>
    </div>
    <div class=\"modal-body\">Select \"Logout\" below if you are ready to end your current session.</div>
    <div class=\"modal-footer\">
      <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
      <a class=\"btn btn-primary\" href=\"login.html\">Logout</a>
    </div>
  </div>
</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "footer.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "footer.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/footer.twig");
    }
}
