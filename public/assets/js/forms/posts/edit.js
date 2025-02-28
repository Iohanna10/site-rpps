function configPostsEdit() {

    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })
}

// editar postagem 
async function ajaxUpdate_post(data){
    updateData = { // informações para atualizar no bd
        id: data.id,
        title: data.title,
        description: data.description,
        main_content: data.main_content,
    }

    updateMedias = { // arquivos para atualizar
        img: data.img,
    } 

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-post/update`),
        data: updateData,
        success: async function (response){
            boolUp = true;
            
            if(response && updateMedias.img.length != 0){ 
                if(updateMedias.img.length != 0){
                    if(!await ajaxUpNewFiles_post(updateMedias.img, {id: data.id, type: 'img'})){
                        boolUp = false;
                    }
                }
            }
            
            if(response && boolUp){
                modalSuccess("Alterações feitas com sucesso.", true);
                updateFuncRemove_post();
            }
            else {
                modalSuccess("Não foi possível realizar todas as alterações, tente novamente mais tarde.", response);
            }

            document.getElementById("btn_change").innerHTML = "Alterar";
        }
    })
}

// adicionar mais mídias a galeria da publicação
async function addMedia_post(el){
    if(el.target.files.length > 0 ){
        var data = {
            new_medias: verifyMediasEdit(el.target.files),
            id: document.getElementById("formPost").dataset.id
        };
    
        // adicionar mídias aos arquivos do site e em caso de sucesso adicionar as novas mídias ao bd
        dataPost = {
            id: data.id,
            type: 'carousel_media'
        };
    
        if(data.new_medias.bool === true){
            if(await ajaxUpNewFiles_post(data.new_medias.files, dataPost)){
                modalSuccess("Novas mídias adicionadas.", true);
                listMedias_post();
            }
            else {
                modalSuccess("Não foi possível adicionar novas mídias, tente novamente mais tarde.", false);
            }
        }
    
        else {
            if(data.new_medias.err === 'type')
                modal("São aceitas somente imagens e vídeos");
            else
                modal(`As mídias "${data.new_medias.files.join(", ")}" excedem o tamanho máximo permitido. <br><br> O tamanho máximo para vídeos é 2.5GB.`);
        }
    }
}

async function ajaxUpNewFiles_post(files, data){
    return await new Promise((resolve, reject) => {
        const API_ENDPOINT = getUriRoute(`ajax/ajax-post/new-files?id_post=${data.id}&&type=${data.type}`);
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

async function addUrlMedia_post(el){
    dataUrls = verifyUrlsEdit(el.value);

    if(dataUrls.bool !== true){
        modal(`"${dataUrls.allUrls.join(', ')}" não é uma url válida, verifique se a digitou corretamente.`);
        return 
    }

    var data = {
        urls: dataUrls.allUrls,
        id: document.getElementById("formPost").dataset.id,
    };

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-post/new-urls`),
        data: data,
        success: async function (response){
            if(response){
                modalSuccess("Nova mídia adicionada.", response);
                listMedias_post();
            }
            else {
                modalSuccess("Não foi possível adicionar a nova mídia, tente novamente mais tarde.", response);
            }
        }
    })
}

// remover mídias da galeria publicação
async function ajaxRemove_postEdit(medias){
    data = {
        medias: medias.split(','),
        id_post: document.getElementById("formPost").dataset.id,
        type: 'midias'
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-post/remove-files`),
        data: data,
        success: async function (response){
            if(response){
                modalSuccess("Mídias removidas.", response);
                listMedias_post();
            }
            else {
                modalSuccess("Não foi possível remover as mídias, tente novamente mais tarde.", response);
            }
        }
    })
}

async function ajaxRemoveFeatured_post(medias){
    data = {
        medias: medias.split(','),
        id_post: document.getElementById("formPost").dataset.id,
        type: 'principal'
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-post/remove-files`),
        data: data,
        success: async function (response){
            if(response.bool){
                modalSuccess("Mídia removida.", response.bool);
                organizePreview(response.type) // arrumar preview
            }
            else {
                modalSuccess("Não foi possível remover a mídia, tente novamente mais tarde.", response.bool);
            }
        }
    })
}

function activeBtns_post(){ // ativar botões
    document.getElementById("more_media").addEventListener('change', (el) =>{ // adicionar mais mídias ao carrossel
        addMedia_post(el)
    })

    document.getElementById("add_url").addEventListener('click', () =>{ // adicionar mídias a partir de url's
        el = document.getElementById("carousel_url_videos");
        if(el.value !== ''){
            addUrlMedia_post(el)
        }
    })

    document.getElementById("remove_all").addEventListener('click', () =>{ // remover todas as mídias ao carrossel
        mediasRemove = [];

        document.querySelectorAll(".medias-list tbody tr[id]").forEach(el => {
            mediasRemove.push(el.id)
        })

        confirmModal("Tem certeza que deseja excluir todas as mídias?", `ajaxRemove_postEdit`, mediasRemove);
    })

    document.getElementById("btn_change").addEventListener('click', (el) =>{
        el.target.innerHTML = "Alterando...";
        if(getData_post() !== false){
            ajaxUpdate_post(getData_post());
        }
        else {
            el.target.innerHTML = "Alterar";
        }
    })
}

function getData_post(){
    let inputs = document.querySelectorAll("input, select");
    let textareas = document.querySelectorAll(".form-cad textarea[id]");
    let data = {}; // objeto para armazenar os dados 
    data.id = document.querySelector('.form-cad').dataset.id;

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

    if(data.title == '' || removeSpecialCharacters(data.title.trim()).length < 3  || data.title.length > 255){
        modal("O título não pode ficar em branco, deve conter mais de 3 letras e no máximo 255 caracteres.")
        return false;
    }

    if(data.description == '' || removeSpecialCharacters(data.description.trim()).length < 3 || data.description.trim().length > 350){
        modal("A descrição não pode ficar em branco, deve conter mais de 3 letras e no máximo 350 caracteres.")
        return false;
    }

    if(data.img.length != 0){
        verify = verifyMediasEdit(data.img);
        if(verify.bool == false){
            if(verify.err === 'type')
                modal("São aceitos somente arquivos de imagem para adicionar como imagem principal");
        }
    }

    return data;
}

function updateFuncRemove_post(){
    data = {
        id_post: document.getElementById("formPost").dataset.id,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-post/get-featured`),
        data: data,
        success: async function (response){
            if(response.imagem_principal !== null){
                document.getElementById("img").value = '';
                btn = document.getElementById('img_remove')
                btn.style.display = 'flex';
                btn.setAttribute("onclick", `confirmModal("Deseja mesmo excluir a imagem principal?", "ajaxRemoveFeatured_post", "${response.imagem_principal}")`);
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