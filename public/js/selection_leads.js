(function(){

  let url = window.location.href;

  let select_active = false;
  let nbr_selected = 0;

  // Remplace les poubelles de suppression par des input type checkbox pour selectionner les leads a envoyer
  $('.send_nbr_selection').click((e) => {
    if (!select_active)
    {
      let value = $(e.target).parent().children("input[name='nbr_selection']").val();
      let tmp = 0;
      $('#dataTable tbody tr').each((k,v) => {
        let td = $(v).children();
        let first_row = $(td[0]);
        let check = (tmp < value ) ? "checked" : "";
        let dispo = ($(td[1]).children("I").hasClass('fa-check')) ? true : false;
        if (dispo && first_row.children().prop('tagName') == "I")
        {
          $(first_row).html("<input class='check_lead' type='checkbox' " + check + "/>");
          tmp++;
        }
      });
      select_active = true;
    }
    else
      alert("La selection de leads est deja active");
  });

  let send_ajax = (url, data) => {
    return new Promise ((resolve, reject) => {
      $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: (e) => {
          resolve(e)
        },
        error: (e) => {
          reject(e);
        }
      });
    });
  }

  $('#dataTable tbody').on('click', 'tr', (e) => {
    let tar = $(e.target);

    if (select_active)
    {
      tar = (tar.prop("tagName") == "TD") ? tar.parent() : tar;
      let check = $($(tar.children()[0]).children()[0]);
      if (check.is(':checked'))
        check.attr('checked', false);
      else
        check.attr('checked', true);
    }
  });

  // Petit reload pour clean les selections
  $('.clean_nbr_selection').click((e) => {
    $('#dataTable tbody tr').each((k,v) => {
      let td = $(v).children();
      let id = $(td[13]).val();
      $(td[0]).html("<i class='poubelle fa fa-trash-o fa-2x' aria-hidden='true' id_client='" + id + "'></i>");
    });
    $('#nbr_selection').val(0);
    select_active = false;
  });

  // Bind event pour envoyer les leads selectionner a un telepro
  $('.send_to_telepro').click((e) => {
    if (select_active)
    {
      let id_send = new Array();
      let send_to = $('#send_to').val();
      $('#dataTable tbody tr').each((k,v) => {
        let td = $(v).children();
        if ($(td[0]).children("input").is(":checked"))
        {
          id_send.push($(td[13]).val());
          nbr_selected++;
        }
      });
      send_ajax("http://" + url.split('/')[2] + "/telepro/" + send_to + "/new_lead", {id_lead: id_send.join(';')}).then((state) => {
        send_ajax("http://" + url.split('/')[2] + '/leads/update_mult_dispo', {id_lead: id_send.join(';')}).then((state) => {
          let nbr_deleted = 0;
          let go_to_check = false;
          $('#dataTable tbody tr').each((k,v) => {
            let td = $(v).children();
            if (!go_to_check && nbr_deleted < nbr_selected)
            {
              if ($(td[0]).children("input").is(":checked"))
              {
                $(v).css('background', 'red').hide(500, () => {
                  $(v).remove();
                });
                nbr_deleted++;
              }
            }
            else
            {
              go_to_check = true;
              if (nbr_deleted > 0)
              {
                $(td[0]).html("<input class='check_lead' type='checkbox' checked/>");
                nbr_deleted--;
              }
            }
          });
          id_send.splice(0, id_send.length);
          $('.nbr_leads_tab').text($('#dataTable tbody tr').length);
        });
      });
    }
    else
      alert("Veuillez activer la selection de leads");
  });

})();
