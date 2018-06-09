(function(){

  let url = window.location.href.split('/')[2];

  let date = "_";

  let transform_to_html = (json) => {
    let ret = "";
    for (let i in json)
    {
      if (i != "total")
      {
        ret += "<tr>";
        ret += "<td>" + json[i].name + "</td>";
        ret += "<td data-type='1'>" + json[i].value.pas_interesser + "</td>";
        ret += "<td data-type='2'>" + json[i].value.non_financeable + "</td>";
        ret += "<td data-type='3'>" + json[i].value.hors_critere + "</td>";
        ret += "<td data-type='4'>" + json[i].value.fausse_annonce + "</td>";
        ret += "<td data-type='5'>" + json[i].value.rendez_vous + "</td>";
        ret += "<td data-type='6'>" + json[i].value.signature + "</td>";
        ret += "<td>" + json[i].value.total + "</td>";
        ret += "<td>" + json[i].value.transformation_rdv + " % </td>";
        ret += "<td>" + json[i].value.transformation_signature + " % </td>";
        ret += "<input type='hidden' name='id_telepro' value=" + i + ">";
        ret += "</tr>";
      }
    }
    ret += "<tr>";
    ret += "<td>Total</td>";
    ret += "<td>" + json['total'].pas_interesser + "</td>";
    ret += "<td>" + json['total'].non_financeable + "</td>";
    ret += "<td>" + json['total'].hors_critere + "</td>";
    ret += "<td>" + json['total'].fausse_annonce + "</td>";
    ret += "<td>" + json['total'].rendez_vous + "</td>";
    ret += "<td>" + json['total'].signature + "</td>";
    ret += "<td>" + json['total'].total + "</td>";
    ret += "<td>" + json['total'].transformation_rdv + " % </td>";
    ret += "<td>" + json['total'].transformation_signature + " % </td>";
    ret += "</tr>";
    $("#dataTable tbody").children().remove();
    $('#dataTable tbody').append(ret);
  };

  let send_ajax = (my_url, my_method, my_data) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: my_url,
        method: my_method,
        data: my_data,
        success: (e) => {resolve(e)},
        error: (e) => {reject(e)}
      });
    })
  }

  let get_statistiques = (name, date) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: "http://" + url + "/telepro/get_statistiques/" + name + "/" + date,
        method: "GET",
        success: (e) => { resolve(e); },
        error: (e) => { reject(e); }
      })
    });
  }

  $('.send_filter').click((e) => {
    let telepro = $('#telepro_name').val();
    let date_value = $('#date_value').val();
    let date_start = $('#date_start').val();
    let date_end = $('#date_end').val();

    if (date_value != "")
      date = date_value;
    else if (date_start != "" && date_end != "")
      date = date_start + "|" + date_end;
    else
      window.location.reload();
    get_statistiques(telepro, date).then((ret) => {
      transform_to_html(JSON.parse(ret));
    })
  });

  $('#dataTable').on('click', 'td', (e) => {
    let td = $($(e.target)[0]);
    let id = td.parent().children('input').val();
    let type = td.attr('data-type');

    if (type != undefined && id != undefined && parseInt(td.text()) > 0)
      $.ajax({
        url: "http://" + url + "/telepro/import_leads",
        method: "POST",
        data: {
          id: id, type: type, date: date
        },
        success: (e) => {
          let ret_send = JSON.parse(e);
          $('.pop_up').fadeIn(500);
          let text = "";
          for (let i in ret_send)
          {
            text = "<tr>";
            text += "<td><input type='checkbox' value='" + ret_send[i].id_lead + "'></td>";
            text += "<td>" + ret_send[i].nom + "</td>";
            text += "<td>" + ret_send[i].prenom + "</td>";
            text += "<td>" + ret_send[i].telephone + "</td>";
            text += "</tr>";
            $('.listLeads tbody').append(text);
          }
        },
        error: (e) => {
          console.error(e);
        }
      });
  });

  $('.listLeads').on('click', 'tr', (e) => {
    let tar = $(e.target);
    if (tar.is("td"))
      tar = tar.parent();
    else
      return (false);
    tar = tar.children().children('input[type="checkbox"]');
    if (tar.attr('checked'))
      tar.attr('checked', false);
    else
      tar.attr('checked', true);
  });

  $('.send_to_telepro').click((e) => {
    let id_telepro = $(e.target).parent().children('.telepro-name').val();
    let id_leads = new Array();
    let hide_tr = new Array();

    $('.listLeads tbody tr').each((k,v) => {
      let input = $(v).children().children('input[type="checkbox"]');
      if (input.attr('checked'))
      {
        id_leads.push(input.val());
        hide_tr.push(input.parent().parent());
      }
    });

    send_ajax("http://" + url + "/telepro/" + id_telepro +"/new_lead", "POST", { id_lead: id_leads.join(';') }).then((resultat) =>{
      send_ajax("http://" + url + "/telepro/reinject_lead", "POST", {id_lead: id_leads.join(';')}).then((result) => {
        for (let i in hide_tr)
          $(hide_tr[i][0]).css('background', 'red').fadeOut(500);
      });
    });
  });

  $(document).on('click', '.pop_up', (e) => {
    if ($(e.target).hasClass('pop_up'))
    {
      $('.listLeads').children("tbody").children().remove();
      $('.pop_up').fadeOut(500);
    }
  });

  // $('#dataTable').on('click', 'tr', (e) => {
  //   console.log($(e.target));
  // });

})();
