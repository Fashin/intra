(function(){

  let id_entreprise = $(this).attr('location').href.split('/')[4];
    let logo = "data:image/jpeg;base64,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";

  function pad(num, size)
  {
    var s = num + "";
    while (s.length < size) s = "0" + s;
    return (s);
  }

  $('#generate').click((e) => {

    let file = $('input[type=file]')[0].files[0];
    let entreprise = {
      nom: $('.entreprise input[name=nom]').val(),
      rue: $('.entreprise input[name=rue]').val(),
      code_postal: $('.entreprise input[name=code_postal]').val(),
      ville: $('.entreprise input[name=ville]').val(),
      prix_unitaire: $('.entreprise input[name=prix_unitaire]').val(),
      offre: $('.entreprise input[name=offre]').val(),
      num_facture: $('input[name="num_facture"]').val()
    };
    let entreprise_envoie = {
      nom: $('input[name="envoie_nom_entreprise"]').val(),
      rue: $('input[name="envoie_adresse_entreprise"]').val(),
      code_postal: $('input[name="envoie_code_postal_entreprise"]').val(),
      ville: $('input[name="envoie_ville_entreprise"]').val(),
      siret: $('input[name="envoie_numero_siret"]').val()
    };
    let zip = new JSZip();
    let pdf = new jsPDF();
    let date = new Date();

    zip.loadAsync(file).then((zip) => {
      let quantite = (parseInt(Object.keys(zip.files).length - 2, 10) - entreprise.offre);
      let total_hors_taxe = quantite * entreprise.prix_unitaire;
      let montant_tva = Math.round((quantite * entreprise.prix_unitaire) * 0.2, 2);
      let prix_total_tva = Math.round((quantite * entreprise.prix_unitaire) * 1.2, 2);

      let id = decrypt(String.fromCharCode.apply(null, zip.files['.os_data']._data.compressedContent)).split('-');

      pdf.addFont('Champagne_Limousines.ttf', 'champagne', 'normal');
      pdf.setFont('champagne');
      pdf.addImage(logo, 'JPEG', 8, 5, 50, 20);
      //setup du text de l'entreprise qui envoie
      pdf.setTextColor(74, 71, 71);
      pdf.setFontSize(12);
      pdf.setFontType('bold');
      pdf.text(10, 35, entreprise_envoie.nom);
      pdf.setFontType('normal');
      pdf.text(10, 40, entreprise_envoie.rue);
      pdf.text(10, 45, entreprise_envoie.code_postal + " " + entreprise_envoie.ville);
      pdf.text(10, 50, "SIRET : " + entreprise_envoie.siret);
      //setup du text de l'entreprise qui reçoit
      pdf.setFontSize(12);
      pdf.setFontType('bold');
      pdf.text(150, 60, entreprise.nom);
      pdf.setFontType('normal');
      pdf.text(150, 65, entreprise.rue);
      pdf.text(150, 70, (entreprise.code_postal + " " + entreprise.ville));
      //Numéro de facture
      pdf.setFontType('bold');
      pdf.text(10, 80, "FACTURE " + pad(entreprise.num_facture, 5));
      pdf.setDrawColor(74, 71, 71);
      pdf.line(10, 82, 45, 82);
      //Affichage de la date
      pdf.setFontType('normal');
      pdf.text(150, 90, "DATE : " + date.getDate() + "/" + parseInt(date.getMonth() + 1, 10) + "/" + date.getUTCFullYear());
      //Line de separation encadrer de presentation et encadrer facture
      pdf.setLineWidth(1);
      pdf.setDrawColor(35, 137, 197);
      pdf.line(0, 110, 210, 110);
      //Rectangle de la facture
      pdf.setLineWidth(0);
      pdf.setDrawColor(255, 255, 255);
      pdf.setFillColor(233, 241, 250);
      pdf.rect(0, 111, 210, 10, 'FD');
      //Text d'en tete de la facture
      pdf.setFontSize(10);
      pdf.setFontType('bold');
      pdf.text(12, 117, "Désignation");
      pdf.text(98, 117, "Qté");
      pdf.text(132, 117, "P.U HT");
      pdf.text(162, 117, "TVA");
      pdf.text(178, 117, "Montant");
      pdf.rect(10, 140, 190, 74);
      //Text du contenu de la facture
      pdf.setFontSize(10);
      pdf.setFontType('normal');
      pdf.text(12, 125, "Qualification de lead marketing");
      pdf.text(12, 130, "dans le domaine du panneaux solaire");
      // Quantite depuis le fichier zip
      pdf.text(100, 125, quantite.toString());//Ici le nombre de leads enovoyé
      // Prix récupérer depuis le formulaire
      pdf.text(135, 125, entreprise.prix_unitaire + "€");
      // Taux de la TVA toujours fixer a 20%
      pdf.text(162, 125, "20%");
      // Multiplication basique des deux soustrait du nombre de leads offert
      pdf.text(180, 125, (total_hors_taxe).toString() + "€");
      // Affichage du cadre de total
      pdf.text(140, 150, "Sous-total");
      pdf.text(170, 150, (total_hors_taxe).toString() + "€")
      // Affichage du montant de la TVA
      pdf.text(140, 155, "TVA 20 %");
      pdf.text(170, 155, (montant_tva).toString() + "€");
      // Affichage du total avec TVA
      pdf.text(140, 160, "Total T.T.C");
      pdf.text(170, 160, (prix_total_tva).toString() + "€");
      // On mets le nombre de leads offert ici
      pdf.setLineWidth(1);
      pdf.setDrawColor(35, 137, 197);
      pdf.line(100, 170, 250, 170);
      // Affichage du text de total
      pdf.setFontSize(12);
      pdf.setFontType('bold');
      pdf.setTextColor(35, 137, 197);
      pdf.text(130, 180, "NET À PAYER :");
      pdf.setTextColor(74, 71, 71);
      pdf.text(170, 180, (prix_total_tva).toString() + "€");
      //Text des conditions de paiements
      pdf.setFontSize(10);
      pdf.text(10, 280, "Conditions de paiement : paiement a effectuer a reception de la facture, pas d'escompte,");
      pdf.text(10, 285, "Si retard de paiement, penalites fixees a 1,5x le taux d'interet legal");

      $('#generate').after("<input type='hidden' value='" + entreprise.prix_unitaire + "' name='prix_unitaire'>");
      $('#generate').after("<input type='hidden' value='" + total_hors_taxe + "' name='prix_total_hors_taxe'>");
      $('#generate').after("<input type='hidden' value='" + montant_tva + "' name='montant_tva'>");
      $('#generate').after("<input type='hidden' value='" + prix_total_tva + "' name='prix_total_tva'>");
      $('#generate').after("<input type='hidden' value='" + quantite + "' name='nbr_lead_envoye'>");
      $('#generate').after("<input type='hidden' value='" + btoa(pdf.output()) + "' name='facture'>");
      $('#generate').after("<input type='hidden' value='" + entreprise.offre + "' name='offre'>");
      for (let i = 0; i < id.length; i++)
        $('#generate').after("<input type='hidden' value='" + id[i] + "' name='id_" + i + "'/>")
      if ($('.send_generate').length == 0)
        $('#generate').after("<input class='send_generate' type='submit' value='Valider la facture'>");

      var iframe = "<iframe width='100%' height='100%' src='" + pdf.output('datauristring') + "'></iframe>";
      var x = window.open();
      x.document.open();
      x.document.write(iframe);
      x.document.close();
    });
  });
})();
