allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
allowedTypesV = ["video/mp4", "video/x-ms-asf", "video/mpeg", "video/webm", "video/ogg", "video/quicktime", "video/mpeg", "video/x-m4v", "video/x-msvideo"]; // tipos permitidos: vídeo

var error = {};
var wrongImgs = [];
var wrongVideos = [];
var wrongPdfs = [];

function cadPost () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    var inputs = document.querySelectorAll(".form-cad input[id]");
    var textarea = document.querySelectorAll(".form-cad textarea[id]");
    var btnSubmit = document.querySelector("button[name=submit]"); 

    if(btnSubmit != null){
        
        btnSubmit.addEventListener('click', () => {
    
            clearErrors();

            var data = {};

            // =================== instituto e categoria de postagem ==================== //
                data['institute'] = getInstitute();
                data['category'] = document.getElementById("type-post").value;

            // ========================================================================= //

            // ========================== dados do formulário ========================== //

                for (let index = 0; index < textarea.length; index++) {
                    
                    if(tinymce.get(`${textarea[index].name}`)){
                        data[textarea[index].name] = tinymce.get(`${textarea[index].name}`).getContent();
                    } else {
                        data[textarea[index].name] = textarea[index].value;
                    }
                }
                
                for (let index = 0; index < inputs.length; index++) {
                    if(inputs[index].type == 'file'){
                            data[inputs[index].name] =  inputs[index].files;                    
                    } else {
                        data[inputs[index].name] = inputs[index].value;
                    }
                }

            // ========================================================================= //
            
            verify = verifyData(data);
            if(verify != false){

                document.querySelector("button[name=submit]").innerHTML = "Enviando...";
            
                var dataDB = verify[0];
                var dataUpFiles = verify[1];

                ajaxData_post(dataDB, dataUpFiles);
            } 
            
        })  
    }
}

function ajaxData_post(data, dataUpFiles){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-post/insertpostdata"),
        data: data,
        success: async function (response){ 
            if(response){ // sucesso no cadastro 
                vBreak = true; // váriavel de controle 
                for (var prop in dataUpFiles) { // percorrer todos os tipos de uploads 
                    if(!vBreak){ // sucesso no upload?
                        break; 
                    }
        
                    if(prop == 'carousel_media'){ // enviar urls também de videos caso forem as mídias do carrossel
                        vBreak =  await ajaxUpFiles_post(dataUpFiles[prop], prop, data.carousel_url_videos).then(result => {return result});
                    }
                    else { // enviar apenas os arquivos 
                        vBreak =  await ajaxUpFiles_post(dataUpFiles[prop], prop, '').then(result => {return result});
                    }
                }   
                
                if(vBreak) { // caso não houve erros no upload
                    modalSuccess('Registrado com sucesso.', vBreak);
                    clearAll();
                } else { // caso houve erros
                    modalSuccess('Erro ao tentar registrar.', vBreak);
                }

                document.querySelector("button[name=submit]").innerHTML = "Enviar";
            }
        }
    })
}

async function ajaxUpFiles_post(files, type, urls){
    return new Promise((resolve, reject) => { // função assíncrona para enviar os arquivos para upload 

        const API_ENDPOINT = getUriRoute(`ajax/ajax-post/uploadfiles?type=${type}&&urls=${urls}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
      
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                resolve(JSON.parse(request.response));
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
          formData.append(files[i].name, files[i])
        };
    
        request.send(formData);
    })
}