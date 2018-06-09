(function(){

  let url = window.location.href.split('/')[2];

  $('.suppr-lead').click((e) => {
    $.ajax({
      url: "http://" + url + "/telepro/update_current_lead",
      method: "POST",
      data: {
        id_lead : $(e.target).parent().children('input').val(),
        id_telepro: $(e.target).parent().parent().parent().children('input').val()
      },
      success: (e) => {
        console.log(e);
        $(e.target).parent().hide(500, () => { $(e.target).parent().remove(); });
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

})();
