function dragDrop_post() {
    $('.medias-list tbody').sortable({
        handle: ".handler_sortable",
        cursor: "grabbing",
        update: function() {
    
        var data = {
            current_order: $(this).sortable("toArray"),
            id: document.getElementById("formPost").dataset.id
        };

        $.ajax({
            method: "POST",
            url: getUriRoute("ajax/ajax-post/order"),
            data: data,
            success: function (response) {
                if(!response){
                    modal("Não foi possível alterar a ordem de exibição das mídias, tente novamente.")
                }
            }
        })
        
    }})
}