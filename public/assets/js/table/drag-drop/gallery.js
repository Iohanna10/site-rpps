function dragDrop_gallery() {
    $('.medias-list tbody').sortable({
        handle: ".handler_sortable",
        cursor: "grabbing",
        update: function() {
            
        var infos = [];
        document.querySelectorAll('textarea[name=infos_img]').forEach(el => {
            infos.push(el.value);
        });
    
        var data = {
            current_order: $(this).sortable("toArray"),
            infos: infos,
            id: document.getElementById("formGallery").dataset.id
        };

        $.ajax({
            method: "POST",
            url: getUriRoute("ajax/ajax-gallery/order"),
            data: data,
            success: function (response) {
                if(!response){
                    modal("Não foi possível alterar a ordem de exibição das mídias, tente novamente.")
                }
            }
        })
        
    }}
    )
}