<?php

/* layout.twig */
class __TwigTemplate_ad0bd1d2ac6073a162021b5ac45539ce75c4a9877534015355c2e4fe215feae3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'style' => array($this, 'block_style'),
            'content' => array($this, 'block_content'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">

<head>
  <meta charset=\"iso-8859-1\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
  <meta name=\"description\" content=\"\">
  <meta name=\"author\" content=\"\">
  <title>Intra Objectif Solaire</title>
  ";
        // line 11
        $this->displayBlock('style', $context, $blocks);
        // line 13
        echo "</head>
";
        // line 14
        $this->displayBlock('content', $context, $blocks);
        // line 16
        $this->displayBlock('script', $context, $blocks);
    }

    // line 11
    public function block_style($context, array $blocks = array())
    {
        // line 12
        echo "  ";
    }

    // line 14
    public function block_content($context, array $blocks = array())
    {
    }

    // line 16
    public function block_script($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function getDebugInfo()
    {
        return array (  57 => 16,  52 => 14,  48 => 12,  45 => 11,  41 => 16,  39 => 14,  36 => 13,  34 => 11,  22 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/layout.twig");
    }
}
