(function(){

  let url = window.location.href.split('/')[2];

  $('.fa-minus-circle, .fa-plus-circle').click((e) => {
    let tar = $(e.target);
    let val = 0;
    let signature = tar.parent().children('.nbr_signature');
    if (tar.hasClass('fa-minus-circle'))
      val = (signature.text().length > 0) ? parseInt(signature.text()) - 1 : 1;
    else
      val = (signature.text().length > 0) ? parseInt(signature.text()) + 1 : 1;
    $.ajax({
      url: "http://" + url + "/telepro/update_signature",
      method: "POST",
      data: { val : val, pseudo: tar.parent().parent().children('.pseudo').text() },
      success: (e) => {
        console.log(e);
        tar.parent().children('.nbr_signature').text(val);
      },
      error: (e) => {
        console.error(e);
      }
    });
  });

  $('.update-max').click((e) => {
    let tar = $(e.target);
    let input = tar.parent().children().children().children('input');
    let val = {
      signature: ($(input[0]).val() == "") ? 0 : parseInt($(input[0]).val()),
      rdv: ($(input[1]).val() == "") ? 0 : parseInt($(input[1]).val())
    };

    $.ajax({
      url: "http://" + url + "/telepro/update_max",
      method: "POST",
      data: {
        value: val
      },
      sucess: (e) => {
        console.log(e);
      },
      error: (e) => {
        console.error(e);
      }
    })
  });
})();
