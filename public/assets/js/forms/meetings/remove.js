function ajaxRemove_events(data) {
    data = {
        id: data,
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-meeting_event/removeEvent"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_events()
            } else {
                modal("Não foi possivel remover o evento, tente novemente.");
            }
        }
    })
}

function refresh_events() {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listEvents(parseInt(document.querySelector(".page-link.current-pg").innerHTML), getFilters_events())
    } else {
        listEvents(1, getFilters_events())
    }
}