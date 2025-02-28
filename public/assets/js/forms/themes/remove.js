/**
 * Deletar/remover tema 
 * @param {number} id id do tema 
 * @param {boolean} refresh atualizar lista de temas?
 */
function ajaxRemove_theme(id, refresh = true){
    data = {
        id: id,
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-institute/themes/remove"),
        data: data,
        success: async function (response) {
            if(!response)
                return modal("Não foi possível remover o tema, tente novamente mais tarde.");
            
            if(refresh) 
                refresh_themes();
            getColors();
        }
    })
}

/**
 * Atualizar lista de temas
*/
function refresh_themes() {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listUserThemes(parseInt(document.querySelector(".page-link.current-pg").innerHTML), getFilters_themes());
    } else {
        listUserThemes(1, getFilters_themes());
    }
}

/**
 * remover banner
 * @param {number} [id=null] 
*/  
function ajaxRemove_themeBanner(id = null){
    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-institute/themes/removeBanner`),
        data: id,
        success: async function (response){
            if(!response){
                modalSuccess("Não foi possível o banner, tente novamente mais tarde.", false);
            }
            
            modalSuccess("Banner removido.", true);
            organizePreview(document.getElementById('banner_img'));
        }
    })
}

/**
 * Adicionar botão de remover imagem do banner ao adicionar-lá
 * @param {number} [id=null] id do tema 
*/
function updateBtnRemove(id){
    data = {
        id: id,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-institute/themes/preview`),
        data: data,
        success: async function (response){
            if(response.banner !== null){
                document.getElementById("banner_img").files = (new DataTransfer()).files;
                
                btn = document.getElementById('img_remove')
                btn.style.display = 'flex';
                btn.setAttribute("onclick", `confirmModal("Deseja mesmo excluir a imagem principal?", "ajaxRemove_themeBanner", "${response.id}")`);

                document.querySelector('.preview-img-container').dataset.idMedia = response.banner;
            }
        }
    })
}