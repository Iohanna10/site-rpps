allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
allowedTypesV = ["video/mp4", "video/x-ms-asf", "video/mpeg", "video/webm", "video/ogg", "video/quicktime", "video/mpeg", "video/x-m4v", "video/x-msvideo"]; // tipos permitidos: vídeo

function cadGallery() {
    error = {};
    wrongImgs = [];
    wrongVideos = [];
    wrongPdfs = [];

    const inputs = document.querySelectorAll(".form-cad input[id]");
    const btnSubmit = document.querySelector("button[name=submit]"); 

    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    if(btnSubmit != null){
        
        btnSubmit.addEventListener('click', () => {
    
            clearErrors();

            var data = {};

            // =================== instituto e categoria de postagem ==================== //

                data['institute'] = getInstitute();
                data['infos_img'] = [];
                data['infos_url'] = [];

            // ========================================================================= //

            // ========================== dados do formulário ========================== //

                var textarea = document.querySelectorAll("textarea")

                for (let index = 0; index < textarea.length; index++) {
                        
                    if(tinymce.get(`${textarea[index].name}`)){
                        data[textarea[index].name] = tinymce.get(`${textarea[index].name}`).getContent();
                    } 
                    else if (textarea[index].name == 'infos_img') {
                        data['infos_img'].push(textarea[index].value);
                    }
                    else if(textarea[index].name == 'infos_url'){
                        data['infos_url'].push(textarea[index].value);
                    }
                    else {
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
            
            dataCheck = verifyData(data);
            if(dataCheck != false){
                var dataDB = dataCheck[0];
                var dataUpFiles = dataCheck[1];

                document.querySelector("button[name=submit]").innerHTML = "Enviando...";


                ajaxData_gallery(dataDB, dataUpFiles);
            } 
        })  
    }
}

function ajaxData_gallery(data, dataUpFiles){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-gallery/insertdata"),
        data: data,
        success: async function (response){  
            if(response.bool === true){
                vBreak = true;
                
                for (var prop in dataUpFiles) {

                    if(!vBreak){
                        break
                    }

                    if(prop == 'img'){
                        vBreak =  await ajaxUpFiles_gallery(dataUpFiles[prop], 'thumb', data.title, prop, '').then(result => {return result});
                    } 
                    else if (prop == 'carousel_media') {
                        vBreak =  await ajaxUpFiles_gallery(dataUpFiles[prop], 'all-images', data.title, prop, data.carousel_url_videos).then(result => {return result});
                    }
                    
                }   
                
                if(vBreak) {
                    modalSuccess('Registrado com sucesso.', vBreak);
                    clearAll();
                } else {
                    modalSuccess('Erro ao tentar registrar.', vBreak);
                }
            }
            else {
                if(typeof response.msg !== 'undefined')
                    modalSuccess(response.msg, response.bool);
                else
                    modalSuccess("Erro ao tentar registrar a galeria.", false);
            }

            document.querySelector("button[name=submit]").innerHTML = "Enviar";
        }
    })
}

function ajaxUpFiles_gallery(files, folder, name_gallery, type, urls){
    return new Promise((resolve, reject) => {

        name_gallery = name_gallery.replace('#', ''); // remover "#" para não dar erro nos dados passados pela url

        const API_ENDPOINT = getUriRoute(`ajax/ajax-gallery/uploadfiles?folder=${folder}&&name_gallery=${name_gallery}&&type=${type}&&urls=${urls}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                resolve(JSON.parse(request.response));
                // console.log(request.responseText)
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i])
        }
    
        request.send(formData);
    })
}