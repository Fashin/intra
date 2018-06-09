(function(){

  var scoreboard = undefined;

  var avatar_displayed = false;

  var score_reach = {
    rdv_goal: new Array(),
    signature_goal: new Array()
  };

  let get_scoreboard = () => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: "http://" + window.location.href.split('/')[2] + "/telepro/get_scoreboard_information/true",
        method: "GET",
        success: (e) => {
          resolve(JSON.parse(e));
        },
        error: (e) => {
          reject(e);
        }
      });
    });
  };

  let refresh_data = (result) => {
    let myData = {
      labels: [],
      datasets: []
    };
    let background_color = [
      $('#color_scoreboard_rdv').val(), $('#color_scoreboard_signature').val()
    ];
    console.log(background_color);
    let pseudo = new Array();
    let nbr_rdv = new Array();
    let nbr_signature = new Array();
    let length = 0;

    for (let i in result)
    {
      if (Number.isInteger(parseInt(i)))
      {
        pseudo.push(result[i].pseudo);
        nbr_rdv.push(result[i].nbr_rdv);
        nbr_signature.push(result[i].nbr_signature);
        length++;
      }
    }

    myData.labels = pseudo;

    myData.datasets.push({
      label: "Nombre de rendez-vous",
      backgroundColor: Chart.helpers.color(background_color[0]).alpha(0.5).rgbString(),
      borderColor: background_color[0],
      data: nbr_rdv,
    });

    myData.datasets.push({
      label: "Nombre de signatures",
      backgroundColor: Chart.helpers.color(background_color[1]).alpha(0.5).rgbString(),
      borderColor: background_color[1],
      data: nbr_signature,
    });

    myData.datasets.push({
      label: "Objectif rendez-vous",
      data: new Array(length).fill(parseInt(result.score.rdv_goal)),
      type: "line",
      fill: false,
      borderWidth: 4,
      borderColor: '#828df2',
      pointRadius: 0,
    });

    myData.datasets.push({
      label: "Objectif signature",
      data: new Array(length).fill(parseInt(result.score.signature_goal)),
      type: "line",
      fill: false,
      borderWidth: 8,
      borderColor: '#ed44c0',
      pointRadius: 0,
    });

    return (myData);
  };

  get_scoreboard().then((result) => {
    scoreboard = new Chart($('#scoreboard'), {
      type: 'bar',
      data: refresh_data(result),
      options: {
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              min: 0,
              suggestedMax: (result.score.rdv_goal > result.score.signature_goal) ? result.score.rdv_goal : result.score.signature_goal
            }
          }]
        },
        result: result,
        showDatapoints: true,
        hover: {
          mode: 'nearest'
        }
      }
    });
  });

  let launch_goal_animation = (div, info) => {
    div.play();
    $(".animation-container").show().append("<img src='/" + info.avatar + "' class='avatar-animation'>");
    $('.animation-container').append("<div class='pseudo-animation'>" + info.pseudo + "</div>");
    score_reach[$(div).attr('id')].push(info.pseudo);
    setTimeout(() => {
      $('.avatar-animation').remove();
      $('.pseudo-animation').remove();
      $('.animation-container').hide();
    }, div.duration * 1000);
  };

  let check_max = (options, result) => {
    let max = {
      rdv_goal: parseInt(result.score.rdv_goal),
      signature_goal: parseInt(result.score.signature_goal)
    };
    let signature = 0;
    let rdv = 0;
    delete result.score;
    for (let i in result)
    {
      rdv = parseInt(result[i].nbr_rdv);
      signature = parseInt(result[i].nbr_signature);
      if (max.rdv_goal > 0 && rdv >= max.rdv_goal && score_reach[$('#rdv_goal').attr('id')].indexOf(result[i].pseudo) == -1)
        launch_goal_animation(document.getElementById("rdv_goal"), result[i]);
      else if (max.signature_goal > 0 && signature >= max.signature_goal && score_reach[$('#signature_goal').attr('id')].indexOf(result[i].pseudo) == -1)
        launch_goal_animation(document.getElementById("signature_goal"), result[i]);
    }
  };

  setInterval(() => {
    get_scoreboard().then((result) => {
      scoreboard.data = refresh_data(result);
      let nbr_rdv = scoreboard.data.datasets[0].data;
      let nbr_signature = scoreboard.data.datasets[1].data;
      check_max(scoreboard.config.options.result, result);
      scoreboard.update(0);
    });
  }, 1000);

  Chart.plugins.register({
    afterDraw: function(chartInstance) {
      if (chartInstance.config.options.showDatapoints) {
        let helpers = Chart.helpers;
        let ctx = chartInstance.chart.ctx;
        let fontColor = helpers.getValueOrDefault(chartInstance.config.options.showDatapoints.fontColor, chartInstance.config.options.defaultFontColor);
        let y = 0;

        ctx.font = Chart.helpers.fontString(20, 'normal', Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        ctx.fillStyle = fontColor;

        chartInstance.data.datasets.forEach(function (dataset) {
          for (var i = 0; i < dataset.data.length; i++) {
            let model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
            let scaleMax = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
            let yPos = (scaleMax - model.y) / scaleMax >= 0.93 ? model.y + 20 : model.y - 5;
            if (dataset.type != "line")
              ctx.fillText(dataset.data[i], model.x, yPos);
            if (!avatar_displayed)
            {
              let avatar = (config) => {
                let avatar = new Array();
                for (let i in config)
                  avatar.push(config[i].avatar);
                return (avatar);
              };
              $('.avatar-container').append("<img class='avatar avatar-" + i + "' src='/" + avatar(chartInstance.config.options.result)[i] + "'>");
              $('.avatar-container .avatar-' + i).css({
                left: model.x
              });
            }
          }
          avatar_displayed = true;
        });
      }
    }
  });

})();
