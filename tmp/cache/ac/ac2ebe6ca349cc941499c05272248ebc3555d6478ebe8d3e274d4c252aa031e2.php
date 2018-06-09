<?php

/* header-telepro.twig */
class __TwigTemplate_08613a4b4133307150f4546cecdf72596ed1728d0f5e5ee96b74c1e5fbac3dc3 extends Twig_Template
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
        echo "<body class=\"fixed-nav sticky-footer bg-dark\" id=\"page-top\">
  <!-- Navigation-->
  <nav class=\"navbar navbar-expand-lg navbar-dark bg-dark fixed-top\" id=\"mainNav\">
    <a class=\"navbar-brand\" href=\"/dashboard\">Objectif Solaire - bêta</a>
    <button class=\"navbar-toggler navbar-toggler-right\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarResponsive\" aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
      <span class=\"navbar-toggler-icon\"></span>
    </button>
    <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">
      <ul class=\"navbar-nav navbar-sidenav\" id=\"exampleAccordion\">
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Dashboard\">
          <a class=\"nav-link\" href=\"/telepro\">
            <i class=\"fa fa-fw fa-dashboard\"></i>
            <span class=\"nav-link-text\">Tableau de bord</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Dashboard\">
          <a class=\"nav-link\" href=\"/telepro/validate_lead\">
            <i class=\"fa fa-database\" aria-hidden=\"true\"></i>
            <span class=\"nav-link-text\">Leads à valider</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Dashboard\">
          <a class=\"nav-link\" href=\"/parametres\">
            <i class=\"fa fa-fw fa-wrench\"></i>
            <span class=\"nav-link-text\">Parametres</span>
          </a>
        </li>
      </ul>
      <ul class=\"navbar-nav sidenav-toggler\">
        <li class=\"nav-item\">
          <a class=\"nav-link text-center\" id=\"sidenavToggler\">
            <i class=\"fa fa-fw fa-angle-left\"></i>
          </a>
        </li>
      </ul>
      <ul class=\"navbar-nav ml-auto\">
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"/logout\">
            <i class=\"fa fa-fw fa-sign-out\"></i>Déconnexion
           </a>
        </li>
      </ul>
    </div>
  </nav>
  <div class=\"content-wrapper\">
    <div class=\"container-fluid\">
";
    }

    public function getTemplateName()
    {
        return "header-telepro.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "header-telepro.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/header-telepro.twig");
    }
}
