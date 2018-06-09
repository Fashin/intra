(function(){

  $('input[name=paiement]').click((e) => {
    let tar = e.target;
    let form = $(tar).parent();
    let check = parseInt($("input[name=paiement]:checked", form).val(), 10);
    let id_entreprise = $("input[name=id_entreprise]", form).val();
    let id_historique = $("input[name=id_historique]", form).val();

    $.ajax({
      url: "http://127.0.0.1:8080/factures/" + id_entreprise + "/" + id_historique,
      method: "POST",
      data: {
        is_check: check
      }
    });
  });

  $("#dataTable").on('click', '.poubelle', (e) => {
    let bean = $(e.target);
    let id_historique = bean.attr('id_historique');
    let id_entreprise = bean.attr('id_entreprise');

    $.ajax({
      url: "/factures/delete_historique/" + id_entreprise,
      method: "DELETE",
      data: {
        id_historique: id_historique,
      },
      success: (e) => {
        bean.parent().parent().css('background','red').fadeOut();
      },
      errror: (e) => {
        console.error(e);
      }
    });
  });

})();
