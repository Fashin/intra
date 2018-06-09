(function(){

  let select_active = false;

  window.onload = () => {
    select_active = $('#dataTable tbody tr').eq(localStorage.getItem('position'))[0];
    get_color().then(result => $(select_active).css('background', result.lead_selection));
  }

  // Delete rappel only when telepro click on the trash, don't reload the page :p
  $('#dataTable').on('click', '.delete-rappel', (e) => {
    let tr = $(e.target).parent().parent()[0];
    let id = parseInt($($(tr).children().children('a')[0]).attr('href').split('/')[3]);
    let storage = JSON.parse(localStorage.getItem('rappel'));

    if (storage == null)
      return (false);
    for (let i in storage)
      if (storage[i] && storage[i].id_lead == id)
        delete storage[i];
    localStorage.setItem('rappel', JSON.stringify(storage));
    $(e.target).parent().empty();
  });

  let storage = JSON.parse(localStorage.getItem('rappel'));

  if (storage != null)
  {
    for (let i in storage)
    {
      if (storage[i] && storage[i].display)
      {
        let time = storage[i].time.split('T');
        $('#dataTable tbody tr').each((k,v) => {
          if ($(v).children('input').val() == storage[i].id_lead)
          {
            $($(v).children('td')[4]).html(time[0] + " à " + time[1] + "<i class='fa fa-trash delete-rappel' aria-hidden='true'></i>");
            get_color().then(result => $($(v)).css("background", result.lead_rappel));
          }
        })
      }
    }
  }

  $('#dataTable tbody').on('click', 'tr', (e) => {
    let tr = $(e.target).parent();
    if (select_active)
      $(select_active).css('background', 'white');
    get_color().then(result => tr.css('background', result.lead_selection));
    select_active = tr;
  });

  $(window).on('keydown', (event) => {
    let key = event.keyCode;
    let rappel = null;

    if ($($(select_active).children()[4]).text().length > 0)
      rappel = select_active;
    $(select_active).css('background', 'white');
    if (key == 38 || key == 40)
      event.preventDefault();
    if (key == 38)
      select_active = (!select_active) ? $("#dataTable tbody tr:first") : $(select_active).prev();
    else if (key == 40)
      select_active = (!select_active) ? $("#dataTable tbody tr:first") : $(select_active).next();
    select_active = (select_active.length == 0) ? (key == 38) ? $("#dataTable tbody tr:first") : $('#dataTable tbody tr:last') : select_active;
    if (select_active)
    {
      $(window).scrollTop(select_active.position().top - 100);
      localStorage.setItem('position', $(select_active).index());
      get_color().then(result => {
        $(select_active).css('background', result.lead_selection)
        if (rappel)
        {
          $(rappel).css('background', result.lead_rappel);
          rappel = null;
        }
      });

    }
  });

})();
