function dragDrop_team() {
    $('.reports-list').sortable({
        handle: ".handler_sortable",
        cursor: "grabbing",
        update: function() {
        
        var data = {
            current_order: $(this).sortable("toArray"),
            team: document.getElementById('team').value,
        };

        $.ajax({
            method: "POST",
            url: getUriRoute("ajax/ajax-member/order"),
            data: data,
            success: function (response) {
                if(!response){
                    modal("Não foi possível alterar a ordem de exibição, tente novamente.")
                }
            }
        })
        
    }})
}