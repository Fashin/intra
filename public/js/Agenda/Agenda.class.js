// Create an agenda, insert a table width id='table-agenda'
class Agenda
{
  constructor(div, url, redirect)
  {
    this.parent = div;
    this.url = url;
    this.redirect = redirect;
  }

  bind_event(info)
  {
    $('#table-agenda tbody tr td').click((e) => {
      let val = $(e.target).attr('value').split('-');
      let display = (val.length > 2) ? val[1] + "h" + val[2] : val[1] + "h00";
      val[1] = (val.length > 2) ? val[1] + "-" + val[2] : val[1];
      let save = confirm("Etes vous sur de vouloir mettre un rendez-vous pour " + val[0] + " à " + display + " ?");
      if (save)
      {
        let storage = JSON.parse(localStorage.getItem('rappel'));
        let id = parseInt(info.id_lead);

        if (storage != null)
          for (let i in storage)
            if (storage[i] && storage[i].id_lead == id)
              delete storage[i];
        localStorage.setItem('rappel', JSON.stringify(storage));
        info.semaine = $('input[name="actual_week"]').val();
        $.ajax({
          url: this.url,
          method: "POST",
          data: {
            info: info,
            horaire: val[0] + '-' + val[1]
          },
          success: (e) => {
            console.log(e);
            window.location.href = this.redirect;
          },
          error: (e) => {
            console.error(e);
          }
        });
      }
    });

    $('#table-agenda').on('click', '.btn-next', (e) => {
      $.ajax({
        url: "/telepro/get_agenda",
        method: "POST",
        data: {
          code_postal: parseInt($('.code_postal').val(), 10),
          semaine: parseInt($('input[name="actual_week"]').val()) + 1
        },
        success: (e) => {
          let json = JSON.parse(e);
          this.parent.children().remove();
          this.parent.fadeOut(300);
          this.draw(json, info);
          this.parent.fadeIn(300);
        },
        error: (e) => {
          console.error(e);
        }
      });
    });
  }

  insert_color_hours(data, label, heure)
  {
    // if (data[label][heure] <= 5)
    //   $('#table-agenda tbody #' + heure).append("<td style='background:green' value=" + label + "-" + heure + ">" + data[label][heure] + "</td>");
    // else if (data[label][heure] > 5 && data[label][heure] <= 10)
    //   $('#table-agenda tbody #' + heure).append("<td style='background:orange' value=" + label + "-" + heure + ">" + data[label][heure] + "</td>");
    // else if (data[label][heure] > 10)
    //   $('#table-agenda tbody #' + heure).append("<td style='background:red' value=" + label + "-" + heure + ">" + data[label][heure] + "</td>");
    // else
    //   $('#table-agenda tbody #' + heure).append("<td value=" + label + "-" + heure + ">" + data[label][heure] + "</td>");
    if (data[label][heure] > 0)
      if (data[label][heure] > 5 && data[label][heure] < 10)
        $('#table-agenda tbody #' + heure).append("<td style='background:orange' value=" + label + "-" + heure + "><b>" + data[label][heure] + "</b></td>");
      else if (data[label][heure] >= 10)
        $('#table-agenda tbody #' + heure).append("<td style='background:red' value=" + label + "-" + heure + "><b>" + data[label][heure] + "</b></td>");
      else
        $('#table-agenda tbody #' + heure).append("<td style='background:white' value=" + label + "-" + heure + "><b>" + data[label][heure] + "</b></td>");
    else
      $('#table-agenda tbody #' + heure).append("<td style='background:white' value=" + label + "-" + heure + "></td>");
  }

  // Returns an array of dates between the two dates
  getDates (startDate, endDate)
  {
    var dates = [],
        currentDate = startDate,
        addDays = function(days) {
          var date = new Date(this.valueOf());
          date.setDate(date.getDate() + days);
          return date;
        };
    while (currentDate <= endDate) {
      dates.push(currentDate);
      currentDate = addDays.call(currentDate, 1);
    }
    return dates;
  }

  draw(data, info)
  {
    let abscisse = true;
    this.parent.append("<table id='table-agenda'></table>");
    $('#table-agenda').append("<thead></thead><tbody></tbody>");
    $('#table-agenda thead').append('<tr><th class="empty">' + data.date + '</th></tr>');
    this.parent.append("<input type='hidden' name='actual_week' value='" + data.semaine + "'>");
    let date = data.date.split(' ');
    let year = new Date().getUTCFullYear();
    date.splice(1, 1);
    for (let i in date)
    {
      let tmp = date[i].split('/');
      date[i] = year + "/" + tmp[1] + "/" + tmp[0];
    }
    date = this.getDates(new Date(date[0]), new Date(date[1]));
    let date_count = 0;
    delete data.date;
    delete data.semaine;
    let val;
    for (let label in data)
    {
      let half = 6;
      let bool = true;
      $('#table-agenda thead tr').append("<th>" + label + " " + date[date_count].getDate() +"</th>");
      date_count++;
      for (let heure in data[label])
      {
          val = (bool) ? half : half + "-30";
          bool = (bool) ? false : true;
          half = (bool) ? half + 1 : half;
          if (abscisse)
          {
            let display = (val.length != undefined) ? val.split('-') : val + "h00";
            display = (display.length == 2) ? display[0] + "h" + display[1] : display;
            $('#table-agenda tbody').append("<tr id="+ val +"><td>" + display + "</td>");
            this.insert_color_hours(data, label, val);
            $('#table-agenda tbody').append('</tr>');
          }
          else
            this.insert_color_hours(data, label, val);
      }
      abscisse = false;
    }
    $('#table-agenda thead tr').append("<th class='th-btn'><i class='fa fa-arrow-circle-o-right fa-2x btn-next'></i></th>")
    this.bind_event(info);
  }
}
