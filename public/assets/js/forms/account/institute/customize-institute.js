var allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
var allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem

function configCustomize() {
    // pegar informações
    document.querySelector("#btnChange").addEventListener('click', () => {
        clear() // limpar erros

        var dataDB = {};
        var dataUpFiles = {};
        let inputs = document.querySelectorAll("input");


        // ========================== dados do formulário ========================== //                
            inputs.forEach(input => {
                if(input.type == 'file'){
                    dataUpFiles[input.name] =  input.files;                    
                } else {
                    dataDB[input.name] = input.value;
                }
            })
        // ========================================================================= //
    
        document.querySelector("#btnChange").innerHTML = "Alterando...";

        if(verifyErr_customize(dataUpFiles)){
            ajaxData_customize(dataDB, dataUpFiles);
        }

        document.querySelector("#btnChange").innerHTML = "Alterar";
    })

    activeTabs();
}

// entregar dados via ajax para serem gravados no db
function ajaxData_customize(dataDB, dataUp){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-institute/customizeInstitute"),
        data: dataDB,
        success: async function (response){
            if(!response){ 
                return modalSuccess("Erro ao tentar alterar.", false);
            }

            if(dataUp.img.length > 0){ // alterar favicon
                if(!await ajaxUpFiles_customize(dataUp.img, 'changeFavicon'))
                    return modalSuccess("Erro ao tentar alterar o favicon.", false);
            }

            if(dataUp.banner_img.length > 0){ // alterar banner
                if(!await ajaxUpFiles_customize(dataUp.banner_img, 'changeBanner'))
                    return modalSuccess("Erro ao tentar alterar o banner.", false);
                updateBtnRemove();
            }

            applyThemePreview();
            getColors();
            modalSuccess("Alterado com sucesso.", true); 
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório 
async function ajaxUpFiles_customize(files, typeUpload){
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-institute/${typeUpload}`);
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
        }
    
        request.send(formData);
    })
}

function verifyErr_customize(data){
    if(isFilled(data.img)){
        if(!isImg_customize(data.img[0])){
            errors('img_error', 'são permitidas apenas imagens');
            return false;
        }
    }

    return true;
}

function errors(input, error){
    document.querySelector(`label[for=${input}] span`).innerHTML = ` - <i class='error'>${error}</i>`; // exibir erro 

    const inputFocus = document.getElementById(input);

    if(inputFocus !== null){
        inputFocus.focus();
    } else {
        document.querySelector(`label[for=${input.replace("_error", '')}`).scrollIntoView({ behavior: "smooth" });
    }

    return true;
}

// limpar erros
function clear(){
    document.querySelectorAll("label span.error").forEach((span) => {
        span.innerHTML = '';
    });
}

// verificar se está preenchido
function isFilled(input){
    if(input.length > 0)
        return true
    else return false
}

// verificar se é uma imagem 
function isImg_customize(media){
    if((allowedFilesI.includes(getFileExtension(media.name)) && allowedTypesI.includes(getFileExtension(media.type)))){
        dataImg = [];
        return true;
    } 
    return false
}