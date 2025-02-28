function ajaxRemove_post(data) {
    data = {
        id: data,
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-post/removePost"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_posts()
            } else {
                modal("Não foi possivel remover a publicação, tente novemente.");
            }
        }
    })
}

function refresh_posts() {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listPosts(parseInt(document.querySelector(".page-link.current-pg").innerHTML), getFilters_post())
    } else {
        listPosts(1, getFilters_post())
    }
}