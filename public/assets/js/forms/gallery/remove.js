function ajaxRemove_gallery(data) {
    data = {
        id: data,
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-gallery/removeGallery"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_gallery()
            } else {
                modal("Não foi possivel remover a galeria, tente novemente.");
            }
        }
    })
}

function refresh_gallery() {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listGallery(parseInt(document.querySelector(".page-link.current-pg").innerHTML), getFilters_gallery())
    } else {
        listGallery(1, getFilters_gallery());
    }
}