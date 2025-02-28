allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
allowedTypesV = ["video/mp4", "video/x-ms-asf", "video/mpeg", "video/webm", "video/ogg", "video/quicktime", "video/mpeg", "video/x-m4v", "video/x-msvideo"]; // tipos permitidos: vídeo

function configGalleryEdit () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    document.getElementById("btn_change").addEventListener('click', (el) =>{
        el.target.innerHTML = "Alterando..."

        if(getData_galleryEdit() !== false){
            ajaxUpdate_gallery(getData_galleryEdit());
        }
        else {
            el.target.innerHTML = "Alterar"
        }
    })
}

async function ajaxUpdate_gallery(data){
    dataGallery = [
        'thumb',
        data.id,
        'img'
    ];

    fileMedia = data.img;

    data.img = ''; data.more_media = '';

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-gallery/update`),
        data: data,
        success: async function (response){
            document.querySelector('.form-cad').dataset.name = data.title;
            
            if(response.bool === true && fileMedia.length != 0){ 
                if(await ajaxUpNewFiles_gallery(fileMedia, dataGallery)){
                    modalSuccess("Alterações feitas com sucesso.", true);
                    updateFuncRemove_gallery();
                }
                else {
                    modalSuccess("Não foi possível alterar a imagem de capa, tente novamente mais tarde.", false);
                }
            }
            else if(response.bool === true){
                modalSuccess("Alterações feitas com sucesso.", true);
            }
            else {
                if(typeof response.msg !== 'undefined')
                    modalSuccess(response.msg, response.bool);
                else
                    modalSuccess("Não foi possível fazer as alterações, tente novamente mais tarde.", response);

                document.querySelector('.form-cad').dataset.name = data.last_name;
            }

            document.getElementById("btn_change").innerHTML = "Alterar";
        }
    })
}

function getData_galleryEdit(){
    let inputs = document.querySelectorAll("input, select");
    let textareas = document.querySelectorAll(".form-cad textarea[id]");
    let data = {}; // objeto para armazenar os dados 
    data.id = document.querySelector('.form-cad').dataset.id;
    data.last_name = document.querySelector('.form-cad').dataset.name;


    textareas.forEach( textarea => {
        if(tinymce.get(`${textarea.name}`)){
            data[textarea.name] = tinymce.get(`${textarea.name}`).getContent();
        } else {
            data[textarea.name] = textarea.value;
        }
    });

    inputs.forEach(input => {        
        if(input.type == 'file'){
            data[input.name] =  input.files;              
        } 
        else {
            data[input.name] = input.value;
        }
    })

    data.infos_img = []; // array de infos das mídias

    document.querySelectorAll("textarea[name=infos_img]").forEach((el) => {
        data.infos_img.push(el.value)
    })

    data.infos_img = data.infos_img.join(';<separator>;');

    if(data.title == '' || removeSpecialCharacters(data.title.trim()).length < 3 || data.title.length > 255){
        modal("O título não pode ficar em branco e deve conter mais que três letras e no máximo 255 caracteres.")
        return false;
    }

    if(data.description == '' || removeSpecialCharacters(data.description.trim()).length < 3 || data.description.length > 350){
        modal("A descrição não pode ficar em branco e deve conter mais que três letras e no máximo 350 caracteres.")
        return false;
    }

    if(data.img.length != 0){
        if(!verifyMediasEdit(data.img[0])){
            modal('São permitidas para capa da galeria apenas imagens');
            return false;
        }
    }

    return data;
}

function activeBtns_gallery(){
    document.getElementById("more_media").addEventListener('change', (el) =>{ // adicionar mídias
        addMedia_galllery(el)
    })

    document.getElementById("add_url").addEventListener('click', () =>{ // adicionar mídias a partir de url's
        el = document.getElementById("carousel_url_videos");
        if(el.value !== ''){
            addUrlMedia_gallery(el)
        }
    })

    document.getElementById("remove_all").addEventListener('click', () =>{ // remover mídias
        mediasRemove = [];

        document.querySelectorAll("textarea[name=infos_img").forEach(el => {
            mediasRemove.push(el.id)
        })

        confirmModal("Tem certeza que deseja excluir todas as mídias?", `ajaxRemove_galleryEdit`, mediasRemove);
    })
}

async function addMedia_galllery(el){
    if(el.target.files.length > 0 ){
        var data = {
            new_medias: verifyMediasEdit(el.target.files),
            id: document.getElementById("formGallery").dataset.id
        };

        // adicionar mídias aos arquivos do site e em caso de sucesso adicionar as novas mídias ao bd
        dataGallery = [
            'all-images',
            data.id,
            'carousel_media'
        ];

        if(data.new_medias.bool === true){
            if(await ajaxUpNewFiles_gallery(data.new_medias.files, dataGallery)){
                modalSuccess("Novas mídias adicionadas.", true);
                listMedias_gallery();
            }
            else {
                modalSuccess("Não foi possível adicionar novas mídias, tente novamente mais tarde.", false);
            }
        }

        else {
            if(data.new_medias.err === 'type')
                modal("São aceitas somente imagens e vídeos");
            else
                modal(`As mídias "${data.new_medias.files.join(", ")}" excedem o tamanho máximo permitido. <br><br> O tamanho máximo vídeos 2.5GB.`);
        }
    }
}

async function ajaxUpNewFiles_gallery(files, data){
    return await new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-gallery/new-files?data=${data}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);

        // progress
        dv = document.createElement("div")
        dv.classList.add('modal-info')
        dv.style.display = 'flex';
        dv.style.justifyContent = 'center';
        dv.innerHTML = `<p>Fazendo uploads...</p><p style='display: flex; align-items: center; gap: 10px;'><span class='progress-bar' style='width: 75%; border-radius: 5px; height: 5px; display: block; background: linear-gradient(to right, var(--cor-primaria) 0%, gray 0%);'></span><span class='progress-porcent'>0%</span></p>`
        document.querySelector(".modal-info").insertAdjacentElement('afterend', dv)

        request.upload.onprogress = (e) => {
            progress_carousel((e.loaded / e.total * 100).toFixed(1), dv);
        };
 
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                dv.remove();
                document.querySelector(".bg-modal").style.display = 'none';
                resolve(JSON.parse(request.response));
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i])
        }
    
        request.send(formData);
    })
}

async function addUrlMedia_gallery(el){
    dataUrls = verifyUrlsEdit(el.value);

    if(dataUrls.bool !== true){
        modal(`"${dataUrls.allUrls.join(', ')}" não é uma url válida, verifique se a digitou corretamente.`);
        return 
    }

    var data = {
        urls: dataUrls.allUrls,
        id: document.getElementById("formGallery").dataset.id
    };

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-gallery/new-urls`),
        data: data,
        success: async function (response){
            if(response){
                modalSuccess("Nova mídia adicionada.", response);
                listMedias_gallery();
            }
            else {
                modalSuccess("Não foi possível adicionar a nova mídia, tente novamente mais tarde.", response);
            }
        }
    })
}

async function ajaxRemove_galleryEdit(medias){
    if(medias.length > 0){
        data = {
            medias: medias.split(','),
            folder: 'all-images',
            id_gallery: document.getElementById("formGallery").dataset.id,
        }
    
        $.ajax({
            method: "POST", 
            url: getUriRoute(`ajax/ajax-gallery/remove-files`),
            data: data,
            success: async function (response){
                if(response){
                    modalSuccess("Mídias removidas.", response);
                    listMedias_gallery();
                }
                else {
                    modalSuccess("Não foi possível remover as mídias, tente novamente mais tarde.", response);
                }
            }
        })
    }
}

async function ajaxRemoveFeatured_gallery(medias){
    data = {
        medias: medias.split(','),
        folder: 'thumb',
        id_gallery: document.getElementById("formGallery").dataset.id,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-gallery/remove-files`),
        data: data,
        success: async function (response){
            if(response.bool){
                modalSuccess("Imagem removida.", response.bool);
                organizePreview() // arrumar preview
            }
            else {
                modalSuccess("Não foi possível remover a imagem, tente novamente mais tarde.", response.bool);
            }
        }
    })
}

function updateFuncRemove_gallery(){
    data = {
        id_gallery: document.getElementById("formGallery").dataset.id,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-gallery/get-featured`),
        data: data,
        success: async function (response){
            if(response.imagem_principal !== null){
                document.getElementById("img").value = '';
                btn = document.getElementById('img_remove')
                btn.style.display = 'flex';
                btn.setAttribute("onclick", `confirmModal("Deseja mesmo excluir a imagem de capa?", "ajaxRemoveFeatured_gallery", "${response.imagem_principal}")`);
                document.querySelector('.preview-img-container').dataset.idMedia = response.imagem_principal;
            }
        }
    })
}

function progress_carousel(porcent, dv){
    document.querySelector(".bg-modal").style.display = 'flex';
    dv.querySelector(".progress-porcent").innerHTML = `${porcent}%`;
    dv.querySelector(".progress-bar").style.background = `linear-gradient(to right, var(--cor-primaria) ${porcent}%, gray 0%)`;

    if(porcent == 100){
        dv.innerHTML = "<p>Adicionando pré-visualizações...</p>";
    }
}