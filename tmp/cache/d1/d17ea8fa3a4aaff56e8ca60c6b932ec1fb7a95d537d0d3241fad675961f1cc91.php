<?php

/* pages/telepro-one-lead.twig */
class __TwigTemplate_9fe648377a31e88610bbb969a771ec0e8e9c82daed6bcb7c05a1a6ca0917864d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/telepro-one-lead.twig", 1);
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
        echo "  <link href=\"../../template/vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">
  <link href=\"../../template/vendor/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">
  <link href=\"../../template/vendor/datatables/dataTables.bootstrap4.css\" rel=\"stylesheet\">
  <link href=\"../../template/css/sb-admin.css\" rel=\"stylesheet\">
  <link rel=\"stylesheet\" href=\"../../css/agenda.css\">
  <link rel=\"stylesheet\" href=\"../../css/telepro-one-lead.css\">
  <link rel=\"stylesheet\" href=\"../../css/drop_down_multi_select.css\">
";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "  ";
        $this->loadTemplate("header-telepro.twig", "pages/telepro-one-lead.twig", 14)->display($context);
        // line 15
        echo "    <form class=\"form_telepro\" action=\"#\" method=\"post\">
      <span class=\"nom_lead lead_title\" >Nom : </span><input class=\"right medium-input input\" type=\"text\" name=\"nom\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["lead"] ?? null), "nom", array()), "html", null, true);
        echo "\"><br><br>
      <span class=\"prenom_lead lead_title\" >Prenom : </span><input class=\"right medium-input input\" type=\"text\" id=\"prenom\" value=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["lead"] ?? null), "prenom", array()), "html", null, true);
        echo "\"><br><br><br>
      <span class=\"telephone_lead lead_title\" >Téléphone : </span><b><span class=\"right\">";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["lead"] ?? null), "telephone", array()), "html", null, true);
        echo "</span></b> <br><br>
      <span class=\"telephone_lead lead_title\"> Numéro de portable : </span> <input type=\"text\" id=\"portable\" class=\"right medium-input input\" name=\"portable\" placeholder=\"Numero de portable\"> <br><br> <br>
      <input type=\"hidden\" class=\"id_lead\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["id"] ?? null), "lead", array()), "html", null, true);
        echo "\">
      <input type=\"hidden\" class=\"id_telepro\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["id"] ?? null), "telepro", array()), "html", null, true);
        echo "\">
      <label for=\"adresse\">
        <input type=\"text\" name=\"adresse\" id=\"adresse\" class=\"long-input input\" placeholder=\"Adresse\">
      </label> <br><br>
      <label for=\"ville\">
        <input type=\"text\" name=\"ville\" id=\"ville\" class=\"medium-input input\" placeholder=\"Ville\">
      </label>
      <label for=\"cp\">
        <input type=\"text\" name=\"code_postal\" class=\"code_postal medium-input input\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["lead"] ?? null), "code_postal", array()), "html", null, true);
        echo "\" placeholder=\"Code Postal\">
      </label>
      <label class=\"form_block\" for=\"entretien\"> <br>
        <span class=\"lead_title\">Entretien eu avec :</span>
        <select id=\"entretien\" class=\"right\">
          <option value=\"monsieur\">Monsieur</option>
          <option value=\"madame\">Madame</option>
        </select>
      </label> <br>
      <label class=\"form_block\" for=\"type_de_bien\">
        <span class=\"lead_title\">Propriétaire d'une maison :</span>
        <select id=\"type_de_bien\" class=\"right\">
          <option value=\"individuelle\">Individuelle</option>
          <option value=\"mitoyenne\">Mitoyenne</option>
          <option value=\"copropriete\">Copropriété</option>
        </select>
      </label><br>
      <label class=\"form_block\" for=\"superficie\">
        <input type=\"text\" class=\"large-input input\" name=\"superficie\" id=\"superficie\" placeholder=\"Superficie de la maison (préciser unité)\">
      </label> <br>
      <label  class=\"form_block\" for=\"situation\">
        <span class=\"lead_title\">Situation :</span>
        <select id=\"situation\" class=\"right\">
          <option value=\"marie\">Marié</option>
          <option value=\"pacse\">Pacsé</option>
          <option value=\"concubinage\">Concubinage</option>
          <option value=\"celibatairel\">Célibataire</option>
        </select>
      </label> <br>
      <input type=\"number\" name=\"age_monsieur\" class=\"age_monsieur\" placeholder=\"Age de Monsieur\">
      <input type=\"number\" name=\"age_madame\" class=\"age_madame right\" placeholder=\"Age de Madame\">
      <br> <br>
      <label class=\"form_block\" for=\"activite_mr\">
        <span class=\"lead_title\">Situation de Monsieur :</span>
        <br><br>
        <select id=\"activite_mr\" class=\"select-large\">
          <option value=\"cdi\">CDI</option>
          <option value=\"cdd\">CDD</option>
          <option value=\"a_son_compte\">A son compte</option>
          <option value=\"retraite\">Retraite</option>
          <option value=\"chomage\">Chomage</option>
          <option value=\"invaliditee\">Invaliditée</option>
        </select>
        <input type=\"number\" name=\"revenue_mr\" class=\"revenue_mr right medium-input\" placeholder=\"Revenue mensuel Mr\">
      </label>
      <br>
      <label class=\"form_block\" for=\"activite_mme\">
        <span class=\"lead_title\">Situation de Madame :</span>
        <br><br>
        <select id=\"activite_mme\" class=\"select-large\">
          <option value=\"cdi\">CDI</option>
          <option value=\"cdd\">CDD</option>
          <option value=\"a_son_compte\">A son compte</option>
          <option value=\"retraite\">Retraite</option>
          <option value=\"chomage\">Chomage</option>
          <option value=\"invaliditee\">Invaliditée</option>
        </select>
        <input type=\"number\" name=\"revenue_mme\" class=\"revenue_mme right medium-input\" placeholder=\"Revenue mensuel Mme\">
      </label><br>
      <label  class=\"form_block\" for=\"credit\">
        <span class=\"lead_title\">Crédit en cours :</span>
        <select id=\"credit\" class=\"right\">
          <option value=\"non\">Non</option>
          <option value=\"oui\">Oui</option>
        </select>
      </label> <br>
      <label for=\"montant\">
        <input type=\"number\" name=\"montant\" id=\"montant\" class=\"long-input input\" placeholder=\"Montant du crédit\">
      </label> <br><br>
      <input class=\"form_block travaux_en_cours large-input\" type=\"text\" placeholder=\"Activité en cours sur l'habitat\"> <br>
      <label for=\"enfant_a_charge\" class=\"form_block\">
        <span class=\"lead_title\">Avez-vous des enfants a charge ?</span>
        <select id=\"enfant_a_charge\" class=\"enfant_a_charge right\">
          <option value=\"oui\">Oui</option>
          <option value=\"non\">Non</option>
        </select>
      </label>
      <input class=\"form_block nbr_enfant_a_charge large-input\" type=\"number\" placeholder=\"Combien ?\"> <br>
      <label class=\"form_block\" for=\"type_de_chauffage\">
        <div class=\"multiselect multiselect-larges\">
          <div class=\"selectBox\">
            <select>
              <option>Type de Chauffage</option>
            </select>
            <div class=\"overSelect\"></div>
          </div>
          <div id=\"checkboxes-larges\">
            <label for=\"gaz\">
              <input type=\"checkbox\" id=\"gaz\" name=\"situation\" value=\"gaz\"> gaz
            </label>
            <label for=\"electrique\">
              <input type=\"checkbox\" id=\"electrique\" name=\"situation\" value=\"electrique\"> electrique
            </label>
            <label for=\"pac\">
              <input type=\"checkbox\" id=\"pac\" name=\"situation\" value=\"pac\"> pac
            </label>
            <label for=\"fuel\">
              <input type=\"checkbox\" id=\"fuel\" name=\"situation\" value=\"fuel\"> fuel
            </label>
          </div>
        </div>
      </label> <br>
      <input type=\"number\" placeholder=\"Facture Mensuel\" id=\"facture_mensuel\" class=\"form_block facture_mensuel large-input\"> <br>
      <textarea name=\"commentaire\" class=\"comment-input\" id=\"commentaire\" placeholder=\"Commentaires\"></textarea>
      <input type=\"submit\" name=\"send\" value=\"Pas décrocher\" class=\"btn-submit\">
      <input type=\"submit\" name=\"send\" value=\"Fausse annonce\" class=\"btn-submit right\"><br>
      <input type=\"submit\" name=\"send\" value=\"Rappeller plus tard\" class=\"btn-submit\">
      <input type=\"submit\" name=\"send\" value=\"Pas intéresser\" class=\"btn-submit right\"><br>
      <input type=\"submit\" name=\"send\" value=\"Non financeable\" class=\"btn-submit\">
      <input type=\"submit\" name=\"send\" value=\"Hors critères\" class=\"btn-submit right\"><br>
      <input type=\"submit\"  name=\"send\" value=\"Rendez-vous\" class=\"btn-submit\">
    </form>
    <div class=\"pop_up\">
    </div>
  ";
        // line 143
        $this->loadTemplate("footer.twig", "pages/telepro-one-lead.twig", 143)->display($context);
    }

    // line 146
    public function block_script($context, array $blocks = array())
    {
        // line 147
        echo "  <script src=\"../../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../../template/js/sb-admin.min.js\"></script>
  <script src=\"../../js/new_date.js\" charset=\"utf-8\"></script>
  <script src=\"../../js/Agenda/Agenda.class.js\" charset=\"utf-8\"></script>
  <script src=\"../../js/refill_empty_field.js\" charset=\"utf-8\"></script>
  <script src=\"../../js/send_formulaire_telepro.js\" charset=\"utf-8\"></script>
  <script src=\"../../js/rappel_telepro.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/telepro-one-lead.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  205 => 147,  202 => 146,  198 => 143,  81 => 29,  70 => 21,  66 => 20,  61 => 18,  57 => 17,  53 => 16,  50 => 15,  47 => 14,  44 => 13,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/telepro-one-lead.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/telepro-one-lead.twig");
    }
}
