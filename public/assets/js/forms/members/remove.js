function ajaxRemove_member(data) {
    data = {
        id: data,
        council: document.getElementById('team').value,
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-member/removeMember"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_members()
            } else {
                modal("Não foi possivel remover o integrante, tente novemente.");
            }
        }
    })
}

function refresh_members() {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listMembers(parseInt(document.querySelector(".page-link.current-pg").innerHTML))
    } else {
        listMembers(1)
    }
}