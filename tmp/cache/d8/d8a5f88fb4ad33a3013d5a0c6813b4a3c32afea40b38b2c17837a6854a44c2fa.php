<?php

/* header.twig */
class __TwigTemplate_9f2b44f6e6c82241b7001f494e9dbb7486d472a94457a2341a43b310e3eeef91 extends Twig_Template
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
          <a class=\"nav-link\" href=\"/dashboard\">
            <i class=\"fa fa-fw fa-dashboard\"></i>
            <span class=\"nav-link-text\">Tableau de bord</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Factures\">
          <a class=\"nav-link\" href=\"/factures\">
            <i class=\"fa fa-fw fa-table\"></i>
            <span class=\"nav-link-text\">Factures</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Commentaire\">
          <a class=\"nav-link\" href=\"/commentaire/show\">
            <i class=\"fa fa-fw fa-comment\"></i>
            <span class=\"nav-link-text\">Commentaires</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Statistiques\">
          <a class=\"nav-link\" href=\"/statistiques/show\">
            <i class=\"fa fa-fw fa-area-chart\"></i>
            <span class=\"nav-link-text\">Statistiques</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Parametres\">
          <a class=\"nav-link nav-link-collapse collapsed\" data-toggle=\"collapse\" href=\"#collapseTelepro\">
            <i class=\"fa fa-fw fa-phone\"></i>
            <span class=\"nav-link-text\">Téléprospecteur</span>
          </a>
          <ul class=\"sidenav-second-level collapse\" id=\"collapseTelepro\">
            <li>
              <a href=\"/telepro/statistiques\">Statistiques</a>
            </li>
            <li>
              <a href=\"/telepro/display_agenda\">Agenda</a>
            </li>
            <li>
              <a href=\"/telepro/scoreboard\">Scoreboard</a>
            </li>
            <li>
              <a href=\"/telepro/update_signature\">Signature</a>
            </li>
            <li>
              <a href=\"/telepro/display_current_leads\">Leads en traitement</a>
            </li>
          </ul>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Archives\">
          <a class=\"nav-link\" href=\"/archives\">
            <i class=\"fa fa-fw fa-archive\" aria-hidden=\"true\"></i>
            <span class=\"nav-link-text\">Archives</span>
          </a>
        </li>
        <li class=\"nav-item\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Telepro\">
          <a class=\"nav-link\" href=\"/parametres\">
            <i class=\"fa fa-fw fa-wrench\"></i>
            <span class=\"nav-link-text\">Paramètres</span>
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
        return "header.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "header.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/header.twig");
    }
}
