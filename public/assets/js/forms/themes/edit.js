/**
 * Carregar página do formulário edição dos temas
 * @param {number} id id do tema para edição
*/
const editTheme = async (id) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/tema?id=${id}&&data_ajax=false`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Personalizar > Editar tema';
    addPreviewColors();
    activeDatePicker();
    eventsEditTheme();
}

/**
 * Ativar eventos de clique da página para pegar dados de edição
 */
function eventsEditTheme () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    var inputs = document.querySelectorAll(".form-cad input[id]");
    var btnSubmit = document.getElementById("btnChange"); 

    btnSubmit.addEventListener('click', () => {
        var dataDB = {};
        var dataUpFiles = {};

        // ========================== dados do formulário ========================== //  
            dataDB.id = document.getElementById('formPost').dataset.id;
                          
            inputs.forEach(inp => {
                if(inp.type == 'file'){
                    dataUpFiles[inp.name] =  inp.files;                    
                } else {
                    dataDB[inp.name] = inp.value;
                }
            })
        // ========================================================================= //

        btnSubmit.innerHTML = "Alterando...";
        
        if(verify_themes(dataDB, dataUpFiles)){
            ajaxUpdate_theme(dataDB, dataUpFiles);
        }

        btnSubmit.innerHTML = "Alterar";
    })  
}

/**
 * Entregar dados via ajax para atualizar/alterar dados do tema no db
 * @param {[]} dataDB array de dados do tema
 * @param {[]} dataUpFiles array de mídias do tema 
 */
async function ajaxUpdate_theme(dataDB, dataUpFiles){
    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-institute/themes/update`),
        data: dataDB,
        success: async function (response){
            if(response){
                // upload da imagem do banner 
                var boolUp = dataUpFiles['banner_img'].length == 0 ? true : await ajaxUpFiles_theme(dataUpFiles['banner_img'], dataDB.id); // verificar se foi possível fazer o upload

                if(boolUp){ // caso sim, retornar aviso 
                    updateBtnRemove(dataDB.id);
                    applyThemePreview(dataDB.id);
                    return modalSuccess('Alteraçõe salvas com sucesso.', true);
                }
            }

            modalSuccess("Falha ao salvar alterações, tente novamente mais tarde.", false)
        }
    })
}