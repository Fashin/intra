(function(){

  let url = window.location.href.split('/')[2];

  $("input[type=submit]").click((e) => {
    // e.preventDefault();
    let name = $(e.target).attr('name');
    let parent = $(e.target).parent().parent();
    let id = parent.children('input[name=id]').val();

    if (name == "update")
      $.ajax({
        url: "http://" + url + "/admin/" + id + "/modify",
        method: "POST",
        data: {
          pseudo: $(parent.children()[1]).children('input').val(),
          type: $('.type-' + id + ' option:selected').text(),
          email: $(parent.children()[2]).children('input').val()
        },
        success: (e) => {
          window.location.href = "/admin";
        },
        error: (e) => {
          console.error(e);
        }
      });
    else if (name == "reset")
      $.ajax({
        url: "http://" + url + "/admin/" + id + "/reset",
        method: "POST",
        success: (e) => {
          window.location.href = "/admin";
        },
        error: (e) => {
          console.error(e);
        }
      });
    else if (name == "delete")
      $.ajax({
        url: "http://" + url + "/admin/" + id + "/delete",
        method: "POST",
        success: (e) => {
          window.location.href = "/admin";
        },
        error: (e) => {
          console.error(e);
        }
      });
    else if (name == "update_site")
      $.ajax({
        url: "http://" + url + "/admin/" + id + "/update_site",
        method: "POST",
        data: {
          site_name: $(parent.children()[1]).children('input').val(),
          site_url: $(parent.children()[2]).children('input').val()
        },
        success: (e) => {
          window.location.href = "/admin";
        },
        error: (e) => {
          console.error(e);
        }
      });
    else if (name == "delete_site")
      $.ajax({
        url: "http://" + url + "/admin/" + id + "/delete_site",
        method: "POST",
        success: (e) => {
          window.location.href = "/admin";
        },
        error: (e) => {
          console.error(e);
        }
      });
  });
})();
