(function() {

  $('#tableContent').on('mouseenter', 'tr', (e) => {
    let tar;
    let a_tar = $(e.target);
    if (a_tar.prop("tagName") == "TD")
      tar = a_tar.parent();
    else if (a_tar.prop("tagName") == "I")
      tar = a_tar.parent().parent();
    if (tar)
      tar.css({
        "background": "#b1deef"
      });
  });

  $('#tableContent').on('mouseleave', 'tr', (e) => {
    let tar;
    let a_tar = $(e.target);
    if (a_tar.prop("tagName") == "TD")
      tar = a_tar.parent();
    else if (a_tar.prop("tagName") == "I")
      tar = a_tar.parent().parent();
    if (tar)
      tar.css({
        "background": "white"
      });
  });

})();
