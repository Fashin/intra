let url = window.location.href.split('/')[2];

const get_color = () => {
  if ($('.id_user').length > 0)
  {
    return new Promise(resolve => {
      $.ajax({
        url: "http://" + url + "/user/get_color/" + $('.id_user').val(),
        method: "GET",
        success: (e) => { resolve(JSON.parse(e)) },
        error: (e) => { reject(e) }
      });
    });
  }
  else
    console.log("Don't miss to setup an input hidden with user id");
};

const get_scoreboard_color = () => {
  return new Promise(resolve => {
    $.ajax({
      url: "http://" + url + "/user/get_color_scoreboard",
      method: "GET",
      success: (e) => { resolve(JSON.parse(e)) },
      error: (e) => { reject(e) }
    });
  });
}

const send_data = (urls, methods, datas) => {
  return new Promise (resolve => {
    $.ajax({
      url: urls,
      method: methods,
      data: datas,
      success: (e) => { resolve(e) },
      error: (e) => { reject(e) }
    })
  });
}

if ($('.color_save').length)
{
  $('#lead_selection').on('change', (e) => {
    send_data("http://" + url + "/user/set_color", "POST", {
      row: "lead_selection",
      value: $(e.target).val()
    }).then(result => {
      console.log(result);
    });
  });
  $('#lead_color').on('change', (e) => {
    send_data("http://" + url + "/user/set_color", "POST", {
      row: "lead_color",
      value: $(e.target).val()
    }).then(result => {
      console.log(result);
    });
  });
  $('#lead_rappel').on('change', (e) => {
    send_data("http://" + url + "/user/set_color", "POST", {
      row: "lead_rappel",
      value: $(e.target).val()
    }).then(result => {
      console.log(result);
    });
  });
  $("#color_scoreboard_rdv").on('change', (e) => {
    send_data("http://" + url + "/user/set_color_scoreboard", "POST", {
      color_scoreboard_rdv: $(e.target).val(),
    }).then(result => {
      console.log(result);
    });
  });
  $("#color_scoreboard_signature").on('change', (e) => {
    send_data("http://" + url + "/user/set_color_scoreboard", "POST", {
      color_scoreboard_signature: $(e.target).val(),
    }).then(result => {
      console.log(result);
    });
  });
}
