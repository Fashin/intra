let now =  new Date();
let last_week = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 6);
let padding = (date) => {
     return (date < 10) ? "0" + date : date;
};
let query = {
  campagnes: [],
  type: "visiteur",
  date: {
    start: last_week.getUTCFullYear() + "-" + padding(parseInt(last_week.getMonth() + 1)) + "-" + padding(last_week.getDate()),
    end: now.getUTCFullYear() + "-" + padding(parseInt(now.getMonth() + 1)) + "-" + padding(now.getDate())
  },
  send: () => {
    let ret = "";

    if (query.campagnes.length > 0)
      ret = query.campagnes.join('|');
    ret = ret + "_" + query.type + "_";
    for (let i in query.date)
      ret = ret + query.date[i] + '@';
    return (ret);
  }
};

let url = window.location.href.split('/')[2];

var stat = new Statistiques(document.getElementById('curve'), {}, $('.curve_response'), [
    $('.curve_label'), $('.curve_row')
]);

stat.draw_curve();

$(".selectBox").click((e) => {
  let checkboxes = $(e.target).parent().parent().children()[1];

  if (checkboxes.style.display == "none" || checkboxes.style.display == "") {
    checkboxes.style.display = "block";
    $(checkboxes).animate({
      height: $(checkboxes).children().length * 34,
    }, 200, () => {
    });
  } else {
    $(checkboxes).animate({
      height: "-=150",
    }, 100, () => {
      checkboxes.style.display = "none";
    });
  }
});

$('select[name="type"]').change((e) => {
  query.type = $(e.target).val();
  $.ajax({
    url: "http://" + url + "/statistiques/filter/" + query.send(),
    method: "GET",
    success: (e) => {
      new Statistiques(document.getElementById('curve'), JSON.parse(e), $('.curve_response'), [
          $('.curve_label'), $('.curve_row')
      ]).draw_curve();
    },
    error: (e) => {
      console.error(e);
    }
  });
})

$("input[type='checkbox']").click((e) => {
  query.campagnes = [];

  $(e.target).parent().parent().children().each((k,v) => {
    let a = $(v).children("input[type='checkbox']:checked");
    let val = a.val();
    if (val && ($.inArray(val, query.campagnes) == -1))
      query.campagnes.push(val);
  });
  $.ajax({
    url: "http://" + url + "/statistiques/filter/" + query.send(),
    method: "GET",
    success: (e) => {
      new Statistiques(document.getElementById('curve'), JSON.parse(e), $('.curve_response'), [
          $('.curve_label'), $('.curve_row')
      ]).draw_curve();
    },
    error: (e) => {
      console.error(e);
    }
  });
});

$('.sort_date').click((e) => {
  e.preventDefault();
  query.date.start = last_week.getUTCFullYear() + "-" + padding(parseInt(last_week.getMonth() + 1)) + "-" + padding(last_week.getDate()),
  query.date.end = now.getUTCFullYear() + "-" + padding(parseInt(now.getMonth() + 1)) + "-" + padding(now.getDate())
  $('input[type="date"]').each((k,v) => {
    let val = $(v).val();
    if (val != "")
      query.date[$(v).attr('name')] = val;
  });
  $.ajax({
    url: "http://" + url + "/statistiques/filter/" + query.send(),
    method: "GET",
    success: (e) => {
      new Statistiques(document.getElementById('curve'), JSON.parse(e), $('.curve_response'), [
          $('.curve_label'), $('.curve_row')
      ]).draw_curve();
    },
    error: (e) => {
      console.error(e);
    }
  })
});
