(function() {

  let url = window.location.href.split('/')[2];

  $('.fa-power-off').click((e) => {
    let tar = $(e.target);
    let id = $(tar.parent().children()[0]).val();
    let value = (tar.attr('id') == "orange") ? 1 : 0;

    $.ajax({
      url: "http://" + url + "/commentaire/update",
      method: "POST",
      data: {
        id: id,
        value: value
      },
      success: (e) => {
        tar.attr("id", (value) ? "green" : "orange");
      },
      error: (e) => {
        console.error(e);
      }
    });
  })

})();
