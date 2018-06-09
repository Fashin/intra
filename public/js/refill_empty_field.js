(function(){

  let refill_form = {
    adresse: (val => $('#adresse').val(val)),
    prenom: (val => $('#prenom').val(val)),
    entretien: (val => $('#entretien').val(val)),
    type_de_bien: (val => $('#type_de_bien').val(val)),
    situation: (val => $('#situation').val(val)),
    monsieur: (val) => {
      $('.age_monsieur').val(val.age);
      $('#activite_mr').val(val.activite);
      $('.revenue_mr').val(val.revenue)
    },
    madame: (val) => {
      $('.age_madame').val(val.age);
      $('#activite_mme').val(val.activite);
      $('.revenue_mme').val(val.revenue)
    },
    credit: (val => $('#credit').val(val)),
    montant: (val => $('#montant').val(val)),
    travaux: (val => $('.travaux_en_cours').val(val)),
    enfant: (val => $('.enfant_a_charge').val(val)),
    nbr_enfant: (val => $('.nbr_enfant_a_charge').val(val)),
    facture: (val => $('#facture_mensuel').val(val)),
    commentaire: (val => $('#commentaire').val(val)),
    superficie: (val => $('#superficie').val(val)),
    portable: (val => $('#portable').val(val)),
  };

  $.ajax({
    url: "https://vicopo.selfbuild.fr/cherche/" + $('.code_postal').val(),
    method: "GET",
    success: (e) => {
      $('#ville').val(e.cities[0].city);
    },
    error: (e) => {
      console.error(e);
    }
  });

  let storage = JSON.parse(localStorage.getItem('rappel'));

  if (storage != null)
  {
    let id_lead = $('.id_lead').val();
    let num_storage = -1;
    for (let i in storage)
      if (storage[i] && storage[i].id_lead == id_lead)
        num_storage = i;
    if (num_storage >= 0)
    {
      let cache = JSON.parse(storage[num_storage].content);
      for (let i in cache)
        if (refill_form.hasOwnProperty(i) && cache[i] != "" && cache[i] != "undefined")
          refill_form[i](cache[i]);
    }
  }

})();
