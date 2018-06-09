(function(){

  let complete_url = window.location.href.split('/');

  let url = complete_url[2];

  let check_page = () => {
    let my_url = complete_url[4];

    if (my_url == "display_agenda" || my_url == "display_agenda#")
      return (true);
    return (false);
  }

  let to_fr = (date) => {
    if (date !== undefined)
    {
      date = date.split('-');
      return (date[2] + "/" + date[1] + "/" + date[0]);
    }
    return (date);
  }

  $('#dataTable tr td a').click((e) => {
    let tr =  $(e.target).parent().parent();
    let id = tr.children('input').val();

    $.ajax({
      url: "http://" + url + '/telepro/get_one_lead_id',
      method: 'POST',
      data : {id: id},
      success: (e) => {
        let data = JSON.parse(e);
        console.log(data);
        let prenom = (data.prenom != undefined) ? data.prenom : data.content.prenom;
        let text = "<div class='content'>";
        text += "<span class='lead_title'>Rendez-vous prit par : </span>" + data.pseudo + "<br><br>";
        // text += "<span class='lead_title'>Lead remplissant le formulaire de : </span>" + data.site + "<br><br>";
        text += "<span class='lead_center'>" + data.nom + " " + prenom + "</span><br>";
        text += "<span class='lead_center'>" + data.content.adresse + " " + data.code_postal + " " + data.content.ville + "</span><br>";
        text += "<span class='lead_center'>" +data.telephone + " " + data.email + "</span><br>";
        text += "<span class='lead_center'>" + data.content.portable + "</span><br>";
        text += "<span class='lead_title'>Rendez-vous prit pour le : </span>" + to_fr(data.content.date) + " a " + data.content.horaire + "h<br><br>";
        text += "<span class='lead_title'>Rendez-vous prit avec : </span>" + data.content.entretien + "<br><br>";
        text += "<span class='lead_title'>Situation : </span>" + data.situation + "<br><br>"
        text += "<span class='lead_title'>Profession : </span>" + data.profession + "<br><br>"
        text += "<span class='lead_title'>Revenue : </span>" + data.revenue + "<br><br>"
        text += "<span class='lead_title'>Projet : </span>" + data.projet + "<br><br>"
        text += "<span class='lead_title'>Bien : </span>" + data.bien + "<br><br>"
        text += "<span class='lead_title'>Type de chauffage : </span>" + data.content.chauffage + "<br><br>";
        text += "<span class='lead_title'>Crédit : </span>" + data.content.credit + "<br><br>";
        text += "<span class='lead_title'>Montant : </span>" + data.content.montant + "<br><br>";
        text += "<span class='lead_title'>Madame : </span><br>";
        text += "<div class='sub-content'>";
        text += "<span class='lead_left'><b>Age : </b>" + data.content.madame.age + "</span>";
        text += "<span class='lead_middle'><b>Activite : </b>" + data.content.madame.activite + "</span>";
        text += "<span class='lead_right'><b>Revenue : </b>" + data.content.madame.revenue + "</span>";
        text += "</div><br>";
        text += "<span class='lead_title'>Monsieur : </span><br>";
        text += "<div class='sub-content'>";
        text += "<span class='lead_left'><b>Age : </b>" + data.content.monsieur.age + "</span>";
        text += "<span class='lead_middle'><b>Activite : </b>" + data.content.monsieur.activite + "</span>";
        text += "<span class='lead_right'><b>Revenue : </b>" + data.content.monsieur.revenue + "</span>";
        text += "</div><br>";
        text += "<span class='lead_title'>Situation de(s) la/les personne(s) : </span>" + data.content.situation + "<br><br>";
        text += "<span class='lead_title'>Nombres d'enfants : </span>" + data.content.nbr_enfant + "<br><br>";
        text += "<span class='lead_title'>Type de bien : </span>" + data.content.type_de_bien + "<br><br>";
        text += "<span class='lead_title'>Travaux en cours sur l'habitat : </span>" + data.content.travaux + "<br><br>";
        text += "<span class='lead_title'>Superficie de la maison : </span>" + data.content.superficie + "<br><br>";
        text += "<span class='lead_title'>Commentaire : </span><br><div class='comment'>" + data.content.commentaire + "</div><br>";
        text += "<div class='btn-ret'><button class='btn-lead btn-confirm'>Confirmation</button>";
        text += (check_page()) ? "<button class='btn-lead btn-archive'>Archives</button>" : "<button class='btn-lead btn-traitement'>Traiter</button></div>";
        text += "<input type='hidden' class='actuel_lead' value='" + data.id_lead + "'>";
        text += "</div>";
        $('.pop_up .text').html(text);
        $('.pop_up').show(500);
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  $('.pop_up').on('click', '.btn-confirm', (e) => {
    let id = parseInt($('.actuel_lead').val());
    $.ajax({
      url: "http://" + url + "/telepro/confirm_rdv",
      method: "POST",
      data: {
        id: id
      },
      success: (e) => {
        if (e == "1")
        {
          $('#dataTable tbody tr').each((k,v) => {
            if ($(v).children('input').val() == id)
              $(v).children('td').children('a').addClass('green');
          })
          $('.pop_up').hide(500);
        }
        else
          alert(e);
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  $('.pop_up').on('click', '.btn-traitement', (e) => {
    let tr =  $(e.target).parent().parent();
    let id = tr.children('input').val();

    $.ajax({
      url: "http://" + url + "/telepro/traitement_lead",
      method: "POST",
      data: {
        id_lead: id
      },
      success: (e) => {
        if (e == "1")
        {
          $('.pop_up').hide(500);
          $('#dataTable tbody tr').each((k,v) => {
            if ($(v).children('input').val() == id)
              $(v).children('td').hide(200);
          })
        }
        else
          alert(e);
      },
      error: (e) =>{
        console.error(e);
      }
    });
  });

  $('.pop_up').on('click', '.btn-archive', (e) => {
    let id = $('.actuel_lead').val();
    console.log(id);
    $.ajax({
      url: "http://" + url + "/telepro/archive_lead",
      method: "POST",
      data: {
        id_lead: id
      },
      success: (e) => {
        console.log(e);
        $('.pop_up').hide(500);
        $('#dataTable tbody tr').each((k,v) => {
          if ($(v).children('input').val() == id)
            $(v).children('td').hide(200);
        })
      },
      error: (e) =>{
        console.error(e);
      }
    });
  });

  $(document).click((e) => {
    if ($(e.target).hasClass('pop_up'))
      $('.pop_up').hide(500);
  });

})();
