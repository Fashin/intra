(function(){

  let url = window.location.href.split('/')[2];

  let padding = (date) => {
     return (date < 10) ? "0" + date : date;
  };

  // Only for hide/show column of "type de chauffage"
  $(".selectBox").click((e) => {
    let checkboxes = $(e.target).parent().parent().children()[1];

    if (checkboxes.style.display == "none"  || checkboxes.style.display == "") {
      checkboxes.style.display = "block";
      $(checkboxes).animate({
        height: $(checkboxes).children().length * 34,
      }, 200);
    } else {
      $(checkboxes).animate({
        height: "-=150",
      }, 200, () => {
        checkboxes.style.display = "none";
      });
    }
  });

  $(document).click((e) => {
    let tar = $(e.target);
    if (tar.prop('tagName') == "DIV")
    {
      $('.pop_up').children().remove();
      $('.pop_up').hide(500);
    }
  })

  let display_calendar = (info) => {
    let agenda = new Agenda($('.pop_up'), "http://" + url + "/telepro/set_one_lead", "http://" + url + "/telepro");
    info.semaine = new Date().getWeek();
    $.ajax({
      url: "/telepro/get_agenda",
      method: "POST",
      data: {
        code_postal: parseInt($('.code_postal').val(), 10)
      },
      success: (e) => {
        let json = JSON.parse(e);
        agenda.draw(json, info);
        $('.pop_up').show(500);
        window.scrollTo(0, 0);
      },
      error: (e) => {
        console.error(e);
      }
    });
  };

  let cant_continue = (info, title) => {
    let stat = 0;
    switch (title) {
      case "Pas intéresser":
        stat = 1;
        break;
      case "Non financeable":
        stat = 2;
        break;
      case "Hors critères":
        stat = 3;
        break;
      case "Fausse annonce":
        stat = 4;
        break;
    }
    $.ajax({
      url: "http://" + url + "/telepro/statistiques/cant_continue",
      method: "POST",
      data: {
        id_lead : info.id_lead,
        id_telepro: info.id_telepro,
        statut: stat
      },
      success: (e) => {
        window.location.href = "/telepro"
      },
      error: (e) => {
        alert("L'erreur suivante est intervenue", e);
      }
    });
  }

  let set_rappel = (info) => {
    let date = new Date();
    let now = date.getUTCFullYear() + "-" + padding(date.getMonth() + 1) + "-" + padding(date.getDate()) + "T" + parseInt(date.getHours() + 2) + ":" + padding(date.getMinutes());
    let text = "<div class='date-container'>";
    text = text + "<span class='text'>Selectionner la date du rappel</span><br><br>";
    text = text + "<input type='datetime-local' class='time' value=" + now + "><br><br>";
    text = text + "<input type='submit' class='recall' value='Rappeler plus tard'>";
    text = text + "</div>";
    $('.pop_up').append(text);
    $('.pop_up').css("display", "block");
    window.scrollTo(0, 0);
    $('.recall').click((e) => {
      let time = $('.time').val();
      if (!time)
      {
        alert("Vous devez specifier une date et une heure");
        return (false);
      }
      let rappel = JSON.parse(localStorage.getItem('rappel'));
      ret = (rappel != null) ? rappel : [];
      if (ret.length > 0)
        for (let i in ret)
          if (ret[i] && ret[i].id_lead == info.id_lead)
            delete ret[i];
      ret.push({
        id_lead: info.id_lead,
        time: time,
        display: 1,
        content: JSON.stringify(info)
      });
      ret = ret.filter(val => val != null);
      localStorage.clear();
      localStorage.setItem('rappel', JSON.stringify(ret));
      window.location.href = "/telepro";
    });
  }

  let action = {
    "Pas décrocher": set_rappel,
    "Fausse annonce": cant_continue,
    "Rappeller plus tard": set_rappel,
    "Pas intéresser": cant_continue,
    "Non financeable": cant_continue,
    "Hors critères": cant_continue,
    "Rendez-vous": display_calendar
  };

  $('input[name="send"]').click((e) => {
    e.preventDefault();
    let info = {
      id_lead: $('.id_lead').val(),
      id_telepro: $('.id_telepro').val(),
      prenom: $('#prenom').val(),
      adresse: $('#adresse').val(),
      ville: $('#ville').val(),
      entretien: $('#entretien').val(),
      type_de_bien: $('#type_de_bien').val(),
      situation: $('#situation').val(),
      monsieur: {
        age: $('.age_monsieur').val(),
        activite: $('#activite_mr').val(),
        revenue: $('.revenue_mr').val()
      },
      madame: {
        age: $('.age_madame').val(),
        activite: $('#activite_mme').val(),
        revenue: $('.revenue_mme').val()
      },
      credit: $('#credit').val(),
      montant: $('#montant').val(),
      travaux: $('.travaux_en_cours').val(),
      semaine: $('input[name="actual_week"]').val(),
      enfant: $('.enfant_a_charge').val(),
      nbr_enfant: $('.nbr_enfant_a_charge').val(),
      chauffage: undefined,
      facture: $('#facture_mensuel').val(),
      commentaire: $('#commentaire').val(),
      superficie: $('#superficie').val(),
      portable: $("#portable").val()
    };

    let tar = $(e.target).val();
    let tmp = [];

    $('#checkboxes-larges').children().children().each((k,v) => {
      if ($(v).is(':checked'))
        tmp.push($(v).val());
    });
    info.chauffage = tmp.join(';');
    // console.log(info);
    action[tar](info, tar);
  });
})();
