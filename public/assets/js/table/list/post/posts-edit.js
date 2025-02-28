const listPosts = async (pg, filters) => {
    contentList = document.getElementById("post-list");
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/publicacoes/dados-lista?pg=${pg}&&${filters}`));
    const html = await data.text();
    contentList.innerHTML = html;

    activeHighlight();
}

const  addPost = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/publicacoes`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Publicações > Criar publicação'

    cadPost();
    getDataSelect_post();
    resetTinyMCE_post();

    activePreview_carousel()
}

const  editPost = async (id) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/publicacao?id=${id}`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Publicações > Editar publicação'

    await listMedias_post();
    configPostsEdit();
    resetTinyMCE_post();

    activePreview_carousel()
}

let xhr; // requisição

function resetTinyMCE_post(){
    resetTinyMCE()

    tinymce.init({
        selector: 'textarea.editor',
        plugins: 'link lists table wordcount',
        toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        resize: true,
        branding: false,
        elementpath: false, 
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false
    });

    tinymce.init({
        selector: 'textarea.editor-c',
        plugins: 'link',
        menubar: false,
        toolbar: 'bold | link | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        height: 200,
        resize: true,
        branding: false,
        elementpath: false, 
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false
    });

    tinymce.init({
        selector: 'textarea.publication',

        plugins:[
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview', 'pagebreak', 'searchreplace', 'fullscreen', 'table', 'image', 'media', 'wordcount',
        ],   
        toolbar1: 'undo redo | bold italic underline strikethrough | blocks fontsize | forecolor | align lineheight',
        toolbar2: 'indent outdent | numlist bullist checklist | removeformat | image media link table',
        branding: false,
        elementpath: false, 
        tinycomments_author: 'false',
        language: 'pt_BR',
        resize: true,
        entity_encoding: 'raw',
        license_key: 'gpl',
        promotion: false,
        image_advtab: true,
        image_caption: true,
        image_title: true,

        automatic_uploads: true,
        images_reuse_filename: true,
		images_upload_url: getUriRoute('ajax/ajax-post/uploadmainfiles'),

		images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', getUriRoute('ajax/ajax-post/uploadmainfiles'));
            
            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };
            
            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'Erro HTTP: ' + xhr.status, remove: true});
                    return;
                }
            
                if (xhr.status < 200 || xhr.status >= 300) {
                    reject({message: 'Erro HTTP: ' + xhr.status, remove: true});
                    return;
                }
                
                const json = JSON.parse(xhr.responseText);
            
                if (!json || typeof json.location != 'string') {
                    reject({ message: 'JSON inválido: ' + xhr.responseText, remove: true});
                    return;
                }
            
                resolve(json.location);
            };
            
            xhr.onerror = () => {
                reject({ message: 'O upload da imagem falhou devido a um erro de transporte XHR. código: ' + xhr.status,  remove: true});
            };
            
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            
            xhr.send(formData);
        }),

        file_picker_types: 'file image media',  

        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');

            if(meta.filetype == 'image')
                input.setAttribute('accept', '.png, .jpg, .jpeg'); // imagens
            else if(meta.filetype == 'media')
                input.setAttribute('accept', '.ogm, .wmv, .mpg, .webm, .ogv, .mov, .asx, .mpeg, .mp4, .m4v, .avi'); // vídeos
            else if(meta.filetype == 'file')
                input.setAttribute('accept', '.pdf'); // pdf's

            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();

                // verificar se o tamanho do arquivo é permitido
                if(validateSize(file.size, meta.filetype) !== true){
                    tinymce.activeEditor.notificationManager.open({
                        text: validateSize(file.size, meta.filetype),
                        timeout: 5000,
                        type: 'error'
                    });
                    tinymce.activeEditor.windowManager.close();

                    return
                }
                                
                // FormData
                var fd = new FormData();
                var files = file;
                fd.append('filetype', meta.filetype);
                fd.append("file", files);
        
                var filename = "";

                // progress
                if(xhr != null){
                    xhr.abort();
                }
        
                // AJAX
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', getUriRoute(`ajax/ajax-post/uploadmainfiles?type_file=${meta.filetype}`));

                dv = document.createElement("div")
                dv.classList.add('progress')
                dv.innerHTML = `<p style='display: flex; align-items: center; gap: 10px;'><span class='progress-bar' style='width: 75%; border-radius: 5px; height: 5px; display: block; background: linear-gradient(to right, var(--cor-primaria) 0%, gray 0%);'></span><span class='progress-porcent'>0%</span></p>`
                document.querySelector(".tox-label").insertAdjacentElement('afterend', dv)

                xhr.upload.onprogress = (e) => {
                    progress((e.loaded / e.total * 100).toFixed(1), dv);
                };
        
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        alert('Erro HTTP: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string' || typeof json.msg == 'string') {
                        if (json.msg != undefined){
                            tinymce.activeEditor.notificationManager.open({
                                text: json.msg,
                                timeout: 5000,
                                type: 'error'
                            });
                            tinymce.activeEditor.windowManager.close();
                        }
                        else{
                            tinymce.activeEditor.notificationManager.open({
                                text: 'JSON inválido: ' + xhr.responseText,
                                timeout: 5000,
                                type: 'error'
                            });
                            tinymce.activeEditor.windowManager.close();
                        }
    
                        return;
                    }

                    filename = json.location;

                    reader.onload = function(e) {
                        cb(filename);
                        dv.remove();
                    };
                    reader.readAsDataURL(file);
                };
                xhr.send(fd);
                return
            };
        
            input.click();
        }, 
    });
}

function validateSize(size, type){
    switch (type) {
        case 'file':
            var max_size = 50;
            break;

        case 'media':
            var max_size = 4000;
            break;
    }

    if(typeof max_size !== 'undefined' && size >= (1024 * 1024 * max_size)){ // verifica se arquivos diferentess de imagens são menores que o tamanho máximo
        return `O tamanho máximo permitido do arquivo é ${max_size}MB`;
    }

    return true;
}

function getFilters_post(){
    data = {
        start_date: document.getElementById("start_date").value,
        end_date: document.getElementById("end_date").value,
        order: document.getElementById("order").value,
        name: document.getElementById("name").value,
        type_post: document.getElementById("type-post").value,
        highlighted: document.getElementById("highlighted").value,
    }

    return `initial_date=${data.start_date}&&final_date=${data.end_date}&&order=${data.order}&&name=${data.name}&&id_category=${data.type_post}&&highlighted=${data.highlighted}`;
}

function progress(porcent, dv){
    dv.querySelector(".progress-porcent").innerHTML = `${porcent}%`;
    dv.querySelector(".progress-bar").style.background = `linear-gradient(to right, var(--cor-primaria) ${porcent}%, gray 0%)`;

    if(porcent == 100){
        dv.innerHTML = "<p style='font-size: 12px; color: rgba(34, 47, 62, .7); padding: 5px 8px 0 0; text-transform: none; white-space: nowrap;'>Adicionando a url...</p>";
    }
}