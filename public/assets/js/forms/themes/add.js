/**
 * Carregar página de cadastro do tema
*/
const addTheme = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/tema`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Personalizar > Criar tema'
    addPreviewColors();
    activeDatePicker();
    eventsAddTheme();
}

/**
 * Ativar eventos de clique para pegar dados de cadastro 
*/
function eventsAddTheme () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    var inputs = document.querySelectorAll(".form-cad input[id]");
    var btnSubmit = document.querySelector("button[name=submit]"); 

    btnSubmit.addEventListener('click', () => {
        var dataDB = {};
        var dataUpFiles = {};

        // ========================== dados do formulário ========================== //                
            for (let index = 0; index < inputs.length; index++) {
                if(inputs[index].type == 'file'){
                    dataUpFiles[inputs[index].name] =  inputs[index].files;                    
                } else {
                    dataDB[inputs[index].name] = inputs[index].value;
                }
            }
        // ========================================================================= //

        document.querySelector("button[name=submit]").innerHTML = "Enviando...";
        
        if(verify_themes(dataDB, dataUpFiles)){
            ajaxData_theme(dataDB, dataUpFiles);
        }

        document.querySelector("button[name=submit]").innerHTML = "Enviar";
    })  
}

/**
 * Gravar dados do tema e suas mídias no BD
 * @param {[]} dataDB array de dados do tema
 * @param {[]} dataUpFiles array de mídias
*/
function ajaxData_theme(dataDB, dataUpFiles) {
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-institute/themes/register"),
        data: dataDB,
        success: async function (response){
            // upload da imagem do banner 
            if(response.bool){
                var boolUp = dataUpFiles['banner_img'].length == 0 ? true : await ajaxUpFiles_theme(dataUpFiles['banner_img'], response.id); // verificar se foi possível fazer o upload

                if(boolUp){ // caso sim, retornar aviso e limpar cadastro
                    clearAll(); // limpar inputs
                    resetInputColors();
                    return modalSuccess("Tema cadastrado com sucesso.", true);
                }
                else { // caso não, excluir o registro do BD
                    ajaxRemove_theme(response.id, false);
                }
            }

            modalSuccess("Não foi possível cadastrar o tema, tente novamente mais tarde.", false)
        }
    })
}

/**
 * Upload das mídias do tema
 * @param {[file]} files array de arquivos
 * @param {number} id id do tema
*/
async function ajaxUpFiles_theme(files, id){
    return new Promise((resolve, reject) => { // função assíncrona para enviar os arquivos para upload 
        const API_ENDPOINT = getUriRoute(`ajax/ajax-institute/themes/upFiles?id_theme=${id}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
      
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                resolve(JSON.parse(request.response));
                // console.log(request.response)
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
          formData.append(files[i].name, files[i])
        };
    
        request.send(formData);
    })
}

/**
 * Verificar dados do tema e suas mídias
 * @param {[]} theme array de dados do tema
 * @param {[]} medias array de mídias
 * @returns 
 */
function verify_themes(theme, medias) {
    if(removeSpecialCharacters(theme['name'].trim()).length < 3){
        modal('O campo "Nome" deve estar preenchido e conter mais que três letras.');
        focus_err('name');
        
        return false;
    }

    if(medias['banner_img'].length > 0 && !isImg(medias['banner_img'][0])){
        modal('O campo "Imagem do banner" deve receber somente imagens.')
        focus_err('banner_img');

        return false;
    }

    if(!isFilled(theme['initial_date'])){
        modal('O campo "Data inicial" deve estar preenchido.')
        focus_err('initial_date');

        return false;
    }

    if(!isFilled(theme['final_date'])){
        modal('O campo "Data final" deve estar preenchido.')
        focus_err('final_date');

        return false;
    }

    var iDate = new Date(theme['initial_date']),
        fDate = new Date(theme['final_date'])

    if(iDate > fDate) {
        modal('O campo "Data inicial" deve conter um valor menor que o campo "Data final".')
        focus_err('initial_date');

        return false;
    }

    return true;
}

/**
 * Colocar input que gerou erro em foco
 * @param {string} name 
*/
function focus_err(name) {
    document.querySelector(`#${name}`).focus();
}

/**
 * Resetar nas cores dos inputs para cores padrão
*/
function resetInputColors () {
    inpColors = document.querySelectorAll("input[type=color]");
    colors = ['#3e4147', '#a4aaad', '#6e7a91'];

    for (let i = 0; i < inpColors.length; i++) {
        inpColors[i].value = colors[i];
    }

    inpColors[0].dispatchEvent(new Event('change'));
}