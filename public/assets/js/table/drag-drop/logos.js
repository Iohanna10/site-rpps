function dragDrop() {
    $('.medias-list tbody').sortable({
        handle: ".handler_sortable",
        cursor: "grabbing",
        update: function() {
            
        var data = {
            current_order: $(this).sortable("toArray"),
        };

        $.ajax({
            method: "POST",
            url: getUriRoute("ajax/ajax-institute/order"),
            data: data,
            success: function (response) {
                if(!response){
                    modal("Não foi possível alterar a ordem de exibição das mídias, tente novamente.")
                }
            }
        })
        
    }})
}