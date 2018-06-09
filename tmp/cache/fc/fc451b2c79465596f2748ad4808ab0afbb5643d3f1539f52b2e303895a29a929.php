<?php

/* pages/leads.twig */
class __TwigTemplate_6855807e0b8700d2b897cf6b0f557d0e67f0f89290ca1f478e1e9dce1cadaf37 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "pages/leads.twig", 1);
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
  <link rel=\"stylesheet\" href=\"../css/leads.css\">
  <link rel=\"stylesheet\" href=\"../css/drop_down_multi_select.css\">
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        echo "  ";
        $this->loadTemplate("header.twig", "pages/leads.twig", 13)->display($context);
        // line 14
        echo "  <div class=\"ajax_gif_loader\">
    <img src=\"../img/loader/loader.gif\" alt=\"\">
    <div class=\"loader-message\"></div>
  </div>
  <div class=\"leads_options\">
    <button type=\"button\" name=\"button\" class=\"leads_export_csv send\">Export to csv</button>
    <button type=\"button\" name=\"button\" class=\"leads_export_zip send\">Export to pdf</button>
    <input type=\"file\" name=\"import_from_csv\" class=\"leads_import_csv send send-large\" accept=\".xlsx\">
    <br><br>
    <label for=\"nbr_export\">Nombre d'export : <input type=\"number\" name=\"nbr_export\" id=\"nbr_export\"></label><br><br>
    <label for=\"nbr_selection\" class=\"nbr_selection\">
      Nombre de selections :
      <input type=\"number\" id=\"nbr_selection\" name=\"nbr_selection\" value=\"0\">
      <i class=\"fa fa-window-close fa-2x clean_nbr_selection\" aria-hidden=\"true\"></i>
      <i class=\"fa fa-check-square fa-2x send_nbr_selection\" aria-hidden=\"true\"></i>
    </label>
    <label for=\"send_to\" class=\"container_send\">
      Envoyer à :
      <select class=\"send_to\" name=\"send_to\" id=\"send_to\">
        ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["telepros"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["telepro"]) {
            // line 34
            echo "          <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["telepro"], "pseudo", array()), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['telepro'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "      </select>
      <i class=\"fa fa-telegram fa-2x send_to_telepro\" aria-hidden=\"true\"></i>
    </label>
    <label for=\"date_range_picker\">
      De : <input type=\"date\" name=\"date_range_start\" value=\"\">
      à <input type=\"date\" name=\"date_range_end\" value=\"\">
    </label><br><br>
    <label for=\"date_picker_day\">
      Jour : <input type=\"date\" name=\"date_picker\" value=\"\">
    </label>
    <button type=\"button\" name=\"button\" class=\"date_filter send\">Trier</button> <br><br>
    <div class=\"ret_filter\" type=\"text\" name=\"ret_filter\" value=\"\"></div>
    <i class=\"fa fa-ban fa-2x\" aria-hidden=\"true\"></i>
    <div class=\"column-hidde\">
      <div class=\"column-name\">
        <span class=\"text\">Situation</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"column-name\">
        <span class=\"text\">Projet</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"column-name\">
        <span class=\"text\">Bien</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"column-name\">
        <span class=\"text\">Revenue</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"column-name\">
        <span class=\"text\">Profession</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
      <div class=\"column-name\">
        <span class=\"text\">Code_Postaux</span><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>
      </div>
    </div>
  </div>
  <div class=\"card mb-3\">
    <div class=\"card-header\">
      <i class=\"fa fa-table\"></i> Nombres de leads : <span class=\"nbr_leads_tab\"></span>
    </div>
    <div class=\"card-body\">
      <div class=\"table-responsive\">
        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
          <thead>
            <tr>
              <th>Supprimer</th>
              <th>
                <select class=\"filter\" id=\"disponible\">
                  <option value=\"clean\" selected>Indifferent</option>
                  <option value=\"1\">Disponible</option>
                  <option value=\"0\">Indisponible</option>
                </select>
              </th>
              <th class=\"situation\">
                <div class=\"multiselect\">
                  <div class=\"selectBox\">
                    <select>
                      <option>Situation</option>
                    </select>
                    <div class=\"overSelect\"></div>
                  </div>
                  <div id=\"checkboxes\">
                    <label for=\"proprietaire\">
                      <input type=\"checkbox\" id=\"proprietaire\" name=\"situation\" value=\"proprietaire\"> Propriétaire
                    </label>
                    <label for=\"locataire\">
                      <input type=\"checkbox\" id=\"locataire\" name=\"situation\" value=\"locataire\"> Locataire
                    </label>
                    <label for=\"locataire_mandate\">
                      <input type=\"checkbox\" id=\"locataire_mandate\" name=\"situation\" value=\"locataire_mandate\"> Locataire Mandate
                    </label>
                    <label for=\"futur_proprietaire\">
                      <input type=\"checkbox\" id=\"futur_proprietaire\" name=\"situation\" value=\"futur_proprietaire\"> Futur Proprietaire
                    </label>
                    <label for=\"syndic_propriete\">
                      <input type=\"checkbox\" id=\"syndic_propriete\" name=\"situation\" value=\"syndic_propriete\"> Syndic_propriete
                    </label>
                  </div>
                </div>
              </th>
              <th class=\"projet\">
                <div class=\"multiselect\">
                  <div class=\"selectBox\">
                    <select>
                      <option>Projet</option>
                    </select>
                    <div class=\"overSelect\"></div>
                  </div>
                  <div id=\"checkboxes\">
                    <label for=\"maison\">
                      <input type=\"checkbox\" id=\"maison\" name=\"projet\" value=\"maison\"> Maison
                    </label>
                    <label for=\"appartement\">
                      <input type=\"checkbox\" id=\"appartement\" name=\"projet\" value=\"appartement\"> Appartement
                    </label>
                    <label for=\"appartement_plus\">
                      <input type=\"checkbox\" id=\"appartement_plus\" name=\"projet\" value=\"appartement_plus\"> appartement_plus
                    </label>
                    <label for=\"immeuble\">
                      <input type=\"checkbox\" id=\"immeuble\" name=\"projet\" value=\"immeuble\"> Immeuble
                    </label>
                    <label for=\"local_commercial\">
                      <input type=\"checkbox\" id=\"local_commercial\" name=\"projet\" value=\"local_commercial\"> Local_commercial
                    </label>
                  </div>
                </div>
              </th>
              <th class=\"bien\">
                <div class=\"multiselect\">
                  <div class=\"selectBox\">
                    <select>
                      <option>Bien</option>
                    </select>
                    <div class=\"overSelect\"></div>
                  </div>
                  <div id=\"checkboxes\">
                    <label for=\"acheve\">
                      <input type=\"checkbox\" id=\"acheve\" name=\"bien\" value=\"acheve\"> Achevé
                    </label>
                    <label for=\"en_cours\">
                      <input type=\"checkbox\" id=\"en_cours\" name=\"bien\" value=\"en_cours\"> En cours
                    </label>
                  </div>
                </div>
              </th>
              <th class=\"revenue\">
                <div class=\"multiselect\">
                  <div class=\"selectBox\">
                    <select>
                      <option>Revenue</option>
                    </select>
                    <div class=\"overSelect\"></div>
                  </div>
                  <div id=\"checkboxes\">
                    <label for=\"-2000\">
                      <input type=\"checkbox\" id=\"-2000\" name=\"revenue\" value=\"-2000\"> -2000
                    </label>
                    <label for=\"+2000\">
                      <input type=\"checkbox\" id=\"+2000\" name=\"revenue\" value=\"+2000\"> +2000
                    </label>
                  </div>
                </div>
              </th>
              <th class=\"profession\">
                <div class=\"multiselect\">
                  <div class=\"selectBox\">
                    <select>
                      <option>Profession</option>
                    </select>
                    <div class=\"overSelect\"></div>
                  </div>
                  <div id=\"checkboxes\">
                    <label for=\"salarie\">
                      <input type=\"checkbox\" id=\"salarie\" name=\"profession\" value=\"salarie\"> Salarie
                    </label>
                    <label for=\"cadre\">
                      <input type=\"checkbox\" id=\"cadre\" name=\"profession\" value=\"cadre\"> Cadre
                    </label>
                    <label for=\"ouvrier\">
                      <input type=\"checkbox\" id=\"ouvrier\" name=\"profession\" value=\"ouvrier\"> Ouvrier
                    </label>
                    <label for=\"sans_emploi\">
                      <input type=\"checkbox\" id=\"sans_emploi\" name=\"profession\" value=\"sans_emploi\"> Sans_emploi
                    </label>
                    <label for=\"dirigeant_entreprise\">
                      <input type=\"checkbox\" id=\"dirigeant_entreprise\" name=\"profession\" value=\"dirigeant_entreprise\"> Dirigeant_entreprise
                    </label>
                    <label for=\"profession_liberale\">
                      <input type=\"checkbox\" id=\"profession_liberale\" name=\"profession\" value=\"profession_liberale\"> Profession_liberale
                    </label>
                  </div>
                </div>
              </th>
              <th class=\"container-cp code_postaux\">
                <input type=\"text\" name=\"cp\">
                <div class=\"container-hidden\">
                  ";
        // line 210
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["cps"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["cp"]) {
            // line 211
            echo "                    <label for=\"";
            echo twig_escape_filter($this->env, $context["cp"], "html", null, true);
            echo "\" class=\"label-cp\">
                      <input type=\"checkbox\" id=\"";
            // line 212
            echo twig_escape_filter($this->env, $context["cp"], "html", null, true);
            echo "\" class=\"input-cp\" name=\"code_postaux\" value=\"";
            echo twig_escape_filter($this->env, $context["cp"], "html", null, true);
            echo "\"> ";
            echo twig_escape_filter($this->env, $context["cp"], "html", null, true);
            echo "
                    </label>
                  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cp'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 215
        echo "                </div>
              </th>
              <th>Telephone</th>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Email</th>
              <th>Date de creation</th>
            </tr>
          </thead>
          <tbody id=\"tableContent\">
            ";
        // line 225
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["leads"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lead"]) {
            // line 226
            echo "              <tr>
                <td>
                  <i class=\"poubelle fa fa-trash-o fa-2x\" aria-hidden=\"true\" id_client=\"";
            // line 228
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "id_client", array()), "html", null, true);
            echo "\"></i>
                </td>
                <td>
                  ";
            // line 231
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "disponible", array()) == "1")) {
                // line 232
                echo "                    <i class=\"fa fa-check fa-2x disp_check\" style=\"color: #34C925;\" aria-hidden=\"true\"></i>
                  ";
            } else {
                // line 234
                echo "                    <i class=\"fa fa-times fa-2x disp_check\" style=\"color: #E21616;\" aria-hidden=\"true\"></i>
                  ";
            }
            // line 236
            echo "                </td>
                <td class=\"situation\">";
            // line 237
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "situation", array()), "html", null, true);
            echo "</td>
                <td class=\"projet\">";
            // line 238
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "projet", array()), "html", null, true);
            echo "</td>
                <td class=\"bien\">";
            // line 239
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "bien", array()), "html", null, true);
            echo "</td>
                <td class=\"revenue\">";
            // line 240
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "revenue", array()), "html", null, true);
            echo "</td>
                <td class=\"profession\">";
            // line 241
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "profession", array()), "html", null, true);
            echo "</td>
                <td class=\"code_postaux\">";
            // line 242
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "code_postal", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 243
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "telephone", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 244
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "nom", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 245
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "prenom", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 246
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "email", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 247
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], "created_at", array()), "html", null, true);
            echo "</td>
                <input type=\"hidden\" name=\"id\" value=\"";
            // line 248
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["lead"], 0, array(), "array"), "html", null, true);
            echo "\">
              </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['lead'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 251
        echo "          </tbody>
        </table>
      </div>
    </div>
    <div class=\"card-footer small text-muted\">Mise à jour en live</div>
  </div>
</div>
  ";
        // line 258
        $this->loadTemplate("footer.twig", "pages/leads.twig", 258)->display($context);
    }

    // line 261
    public function block_script($context, array $blocks = array())
    {
        // line 262
        echo "  <script src=\"https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.8/xlsx.full.min.js\"></script>
  <script src=\"../template/vendor/jquery/jquery.min.js\"></script>
  <script src=\"../template/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <script src=\"../template/js/sb-admin.min.js\"></script>
  <script src=\"../js/i_m_the_boss.js\" charset=\"utf-8\"></script>
  <script src=\"../js/jszip.min.js\" charset=\"utf-8\"></script>
  <script src=\"../js/fileSaver.js\" charset=\"utf-8\"></script>
  <script src=\"../js/jsPDF/dist/jspdf.debug.js\" charset=\"utf-8\"></script>
  <script src=\"../js/export_csv_zip.js\" charset=\"utf-8\"></script>
  <script src=\"../js/page_leads.js\" charset=\"utf-8\"></script>
  <script src=\"../js/selection_leads.js\" charset=\"utf-8\"></script>
  <script src=\"../js/filter.js\" charset=\"utf-8\"></script>
";
    }

    public function getTemplateName()
    {
        return "pages/leads.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  391 => 262,  388 => 261,  384 => 258,  375 => 251,  366 => 248,  362 => 247,  358 => 246,  354 => 245,  350 => 244,  346 => 243,  342 => 242,  338 => 241,  334 => 240,  330 => 239,  326 => 238,  322 => 237,  319 => 236,  315 => 234,  311 => 232,  309 => 231,  303 => 228,  299 => 226,  295 => 225,  283 => 215,  270 => 212,  265 => 211,  261 => 210,  85 => 36,  74 => 34,  70 => 33,  49 => 14,  46 => 13,  43 => 12,  33 => 4,  30 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pages/leads.twig", "/homepages/15/d709001877/htdocs/intra/dev/app/views/pages/leads.twig");
    }
}
