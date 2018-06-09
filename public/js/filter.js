(function(){

  let url = $(this).attr('location').href.split('/');

  let lead_name = (url[4][url[4].length - 1] == "#") ? url[4].substr(0, url[4].length - 1) : url[4];

  let query = {};

  let padding = (date) => {
    if (date < 10)
      return ("0" + date);
    return (date);
  }

  let get_all_query = (arr) => {
    let ret = new Array();

    Object.getOwnPropertyNames(arr).forEach(
      (value) => {
        ret.push(value + '=' + query[value]);
      }
    );
    let rex = (String(ret).match(/(date)=.+/));
    if (String(ret).match(/(date_start)=.+/) == null)
    {
      let hier = new Date();
      hier.setTime(hier.getTime() - 86400000);
      ret.push((rex == null) ? "date="+ hier.getUTCFullYear() + "-" + padding(hier.getMonth() + 1) + "-" + padding(hier.getDate()) : "");
      ret = ret.filter((n) => { return n != ""; });
    }
    ret = ret.join('&');
    return ((ret.length) ? encodeURIComponent(ret) : "_");
  };

  let convert_to_html = (json) => {
    let ret = "";

    for (let i = 0; i < json.length; i++)
    {
      ret = ret + "<tr>";
      ret = ret + '<td><i class="poubelle fa fa-trash-o fa-2x" id_client="' + json[i][0] + '" aria-hidden="true"></i></td>';
      ret = (parseInt(json[i]['disponible'], 10)) ? ret + '<td><i class="fa fa-check fa-2x disp_check" style="color: #34C925;" aria-hidden="true"></i></td>' :  ret + '<td><i class="fa fa-times fa-2x disp_check" style="color: #E21616;" aria-hidden="true"></i></td>';
      ret = ret + '<td class="situation">' + json[i]['situation'] + '</td>';
      ret = ret + '<td class="projet">' + json[i]['projet'] + '</td>';
      ret = ret + '<td class="bien">' + json[i]['bien'] + '</td>';
      ret = ret + '<td class="revenue">' + json[i]['revenue'] + '</td>';
      ret = ret + '<td class="profession">' + json[i]['profession'] + '</td>';
      ret = ret + '<td class="code_postaux">' + json[i]['code_postal'] + '</td>';
      ret = ret + '<td>' + json[i]['telephone'] + '</td>';
      ret = ret + '<td>' + json[i][1] + '</td>'; //Le nom
      ret = ret + '<td>' + json[i][2] + '</td>'; //Le prénom
      ret = ret + '<td>' + json[i][3] + '</td>'; // l'email
      ret = ret + '<td>' + json[i]['created_at'] + '</td>';
      ret = ret + '<input type="hidden" value="' + json[i]['id'] + '" name="id"/>';
      ret = ret + "</tr>";
    }
    $('.nbr_leads_tab').text(json.length);
    return (ret);
  }

  // Function for update the filter bar & update if column is hide / show
  let update_filter = () => {
    let filter = decodeURIComponent(get_all_query(query)).split('&');
    let text = "";
    $(filter).each((k, v) => {
      if (v != "_")
        text = text + "<span class='log_filter'>" + v.split('=')[1] + "<i class='fa fa-times icon-filter' aria-hidden='true'></i></span>";
    });
    $(".ret_filter").html(text);
    $('.column-hidde').children().each((k, v) => {
      if ($($(v).children('i')[0]).hasClass("fa-eye-slash"))
        $('.' + $(v).children('span').text().toLowerCase()).css('display', 'none');
    });
  };

  let update_postal_code = (json) => {
    let cps = new Array();
    let txt = "";
    let tmp;

    for (let cp in json)
    {
      tmp = json[cp].code_postal.substr(0, 2);
      if (!cps.includes(tmp))
        cps.push(tmp);
    }
    cps.sort();
    for (let i = 0; i < cps.length; i++)
    {
      txt = txt + "<label for='" + cps[i] + "' class='label-cp'>";
      txt = txt + "<input type='checkbox' id='" + cps[i] + "' class='input-cp' name='code_postaux' value='" + cps[i] + "'> " + cps[i] + "</label>";
    }
    $('.container-hidden').html(txt);
    $('.container-hidden input').each((k, v) => {
      $(v).on('click', {}, send_query);
    })
  }

  let remove_filter = (event) => {
    let tar = ($(event.target).prop("tagName") == "I") ? $(event.target).parent() : $(event.target);
    let val = tar.text();
    Object.keys(query).forEach((key) => {
      if (query[key] == val)
      {
        delete query[key];
        let find = false;
        $('.multiselect').each((k, v) => {
          $($($(v).children("#checkboxes")).children()).children().each((a, b) => {
            if ($(b).val() == val)
            {
              $($(b)[0]).prop('checked', false);
              find = true;
            }
          });
        });
        if (!find)
          $($($('.container-hidden').children("label")).children("input")).each((a, b) => {
            if ($(b).val() == val)
              $($(b)[0]).prop('checked', false);
          });
        $.ajax({
          url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
          method: "GET",
          success: (e) => {
            let json = JSON.parse(e);
            $('#tableContent').html(convert_to_html(json));
            update_filter();
            update_postal_code(json);
          },
          error: (e) => {
            console.error(e);
          }
        });
      }
    });
  };

  let send_query = (event) => {
    let rex = new RegExp($(event.target).attr('name') + "[0-9]+", "ig");

    for (let q in query)
      if (q.match(rex))
        delete query[q];
    $(event.target).parent().parent().children().each((k,v) => {
      let a = $(v).children("input[type='checkbox']:checked");
      if (a.val())
        query[a.attr('name') + k] = a.val();
    });
    $.ajax({
      url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
      method: "GET",
      success: (e) => {
        let json = JSON.parse(e);
        $('#tableContent').html(convert_to_html(json));
        update_filter();
      },
      error: (e) => {
        console.error(e);
      }
    });
  }

  $('.ret_filter').on('click', '.log_filter', {},  remove_filter);
  $('.ret_filter').on('click', '.icon-filter', {}, remove_filter);

  //Gestion des disponibilite des leads
  $('#tableContent').on('click', '.disp_check', (e) => {
    let tar = $(e.target);
    let val = (tar.attr('class').split(' ')[1] == "fa-check") ? 0 : 1;
    let id = tar.parent().parent().find("input").val();
    $.ajax({
      url: "/leads/update_disponibilite",
      method: "POST",
      data: {
        value: val, id: id
      },
      success: (e) => {
        if (!val)
          tar.attr('class', "fa fa-times fa-2x disp_check").css('color', '#E21616');
        else
          tar.attr('class', "fa fa-check fa-2x disp_check").css('color', '#34C925');
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  //Filter by cp
  $('input[name="cp"]').keyup((e) => {
    let value = $(e.target).val();
    let rex = /code_postaux[0-9]+/ig;

    for (let q in query)
      if (q.match(rex) != null)
        delete query[q];
    if (value.indexOf(',') > 0)
    {
      value = value.split(',').filter((x) => {
        return (x != "" && x.length == 2);
      });
      for (let i = 0; i < value.length; i++)
        query['code_postaux' + i] = value[i];
      $.ajax({
        url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
        method: "GET",
        success: (e) => {
          $('#tableContent').html(convert_to_html(JSON.parse(e)));
        },
        error: (e) => {
          console.error(e);
        }
      });
    }
    else
      $.ajax({
        url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
        method: "GET",
        success: (e) => {
          $('#tableContent').html(convert_to_html(e));
        },
        error: (e) => {
          console.error(e);
        }
      });
  });

  // Add event to show all postal code
  $('input[name="cp"]').focus((e) => {
    $($(e.target).parent().children()[1]).css('display', 'block')
  });

  // Hidde / Show columns
  $('.column-name').click((e) => {
    let tar = $(e.target);
    let col;
    let eye;

    if (tar.prop("tagName") == "I")
    {
      col = $(tar.parent().children("span")).text().toLowerCase();
      eye = tar;
    }
    else
    {
      col = tar.text().toLowerCase();
      eye = tar.parent().children('i');
    }
    col = $('.' + col)
    if (col.css('display') == "table-cell")
    {
      col.css('display', 'none');
      eye.attr('class', 'fa fa-eye-slash');
    }
    else
    {
      col.css('display', 'table-cell');
      eye.attr('class', 'fa fa-eye');
    }
  });

  // Add event to hidde postal code list
  $(document).click((e) => {

    let tar = $($(e.target).parent()).attr('class');
    if (tar != 'container-cp code_postaux' && tar != 'label-cp' && tar != 'container-hidden' && tar)
      $(".container-hidden").css('display', 'none');
  });

  // Add event on "disponible" leads
  $('.filter').on('change', (e) => {
    query['disponible'] = $(e.target).val();
    if (query['disponible'] == 'clean')
      delete query['disponible'];
    $.ajax({
      url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
      method: "GET",
      success: (e) => {
        $('#tableContent').html(convert_to_html(JSON.parse(e)));
        update_filter();
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  //Filter by date
  $('.date_filter').click((e) => {
    let date_picker = $('input[name="date_picker"]').val();
    let date_range_start = $('input[name="date_range_start"]').val();
    let date_range_end = $('input[name="date_range_end"]').val();

    delete query['date'];
    delete query['date_start'];
    delete query['date_end'];

    if (date_picker != "")
    {
      query['date'] = date_picker;
      $('input[name="date_range_start"]')[0].value = "";
      $('input[name="date_range_end"]')[0].value = "";
    }
    else if (date_range_start != "" && date_range_end != "")
    {
      query['date_start'] = date_range_start;
      query['date_end'] = date_range_end;
      $('input[name="date_picker"]')[0].value = "";
    }
    $.ajax({
      url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
      method: "GET",
      success: (e) => {
        let json = JSON.parse(e);
        $('#tableContent').html(convert_to_html(json));
        update_filter();
        update_postal_code(json);
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  // Limite le nbr d'export entre [0; <input utilisateur>]
  $('#nbr_export').keyup((e) => {
    let val = parseInt($(e.target).val(), 10);

    delete query['limit'];
    if (val > 0)
      query['limit'] = val;
    $.ajax({
      url: "http://" + url[2] + "/leads/" + lead_name + "/" + get_all_query(query),
      method: "GET",
      success: (e) => {
        $('#tableContent').html(convert_to_html(JSON.parse(e)));
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  //Filter by select
  $('input[type="checkbox"]').on('click', {}, send_query);

  //Gestion de la suppression des leads
  $("#tableContent").on('click', '.poubelle', (e) => {
    let bean = $(e.target);
    let id_client = bean.attr('id_client');

    $.ajax({
      url: "/leads/" + lead_name + "/" + id_client + "/delete",
      method: "GET",
      success: (e) => {
        bean.parent().parent().css('background','red').fadeOut();
      },
      errror: (e) => {
        console.error(e);
      }
    });
  });

  // Delete all filter
  $('.fa-ban').click((e) => {
    location.reload();
  });

  $('.nbr_leads_tab').text($('#tableContent tr').length - 1);

  // Animation des champs de selection filter
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

})();
