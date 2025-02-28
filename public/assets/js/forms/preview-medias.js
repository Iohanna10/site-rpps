
allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
allowedTypesV = ["video/mp4", "video/x-ms-asf", "video/mpeg", "video/webm", "video/ogg", "video/quicktime", "video/mpeg", "video/x-m4v", "video/x-msvideo"]; // tipo de arquivos permitidos: vídeo

// pré visualização da imagem
function previewImg(input) {
    preview = input.labels[0];
    preview.querySelector(".preview-img-container").innerHTML = "";

    for(const file of preview.querySelector("input[name=img]").files){
        
        if(allowedFilesI.includes(getFileExtension(file.name))){
            mediaHTML = `<img src="${URL.createObjectURL(file)}" alt="${file.name}" class="preview-img"></img>`;
            preview.querySelector(".preview-img-container").innerHTML = mediaHTML;
        }

        else {
            mediaHTML = `<i style="font-size: 15px; margin-right: 10px;" class="fa-solid fa-triangle-exclamation"></i><span>Tipo de mídia inválido</span>`
            preview.querySelector(".preview-img-container").innerHTML = mediaHTML;;
        }

    }

    resetPreview('img');

    // css icon/text div.conteiner-icon 
    photoIcon(preview.querySelector(".container-icon"), input.files.length);
}

// pré visualização das imagens do carrossel
$(document).ready(function () {
    const inputSliderImg = document.getElementById("carousel_media"); // input
    const previewContainer = document.querySelector(".preview-all-medias"); // container de pré visualização
    const icon = document.querySelector("label[for=carousel_media] .preview > .container-icon"); // icone e texto 
    const moreFiles = document.querySelector(".edit_media input[name=more_media]"); // input para adicionar novos arquivos
    const removeAllFiles = document.querySelector(".edit_media .btn.remove-all"); // remover todos os arquivos selecionados
    
    const infosArea = document.querySelector(".infos_area"); // área com inputs da descrição das mídias 

    if(inputSliderImg != null){

        inputSliderImg.addEventListener("change", function(e){

            // verificar se há arquivos selecionados no input principal para trocar o texto e o icone
            photoIcon(icon, inputSliderImg.files.length);
    
            getHTMLpreview(e.target.files, previewContainer);

            if(infosArea != null){
                getInfos(e.target.files, infosArea)
            }
            
        })

        moreFiles.addEventListener("change", function(){
            let data = new DataTransfer(); // objeto para receber os novos arquivos em um formato aceito pelo input
            var filesSelected = []; // nome dos arquivos já escolhidos 

            if(moreFiles.files.length > 0){
                // pegar valor dos arquivos já adicionados ao input principal
                for (let count = 0; count < inputSliderImg.files.length; count++) {
                    data.items.add(inputSliderImg.files[count]);
    
                    filesSelected.push(inputSliderImg.files[count].name) 
                };
    
                // adicionar os novos arquivos ao objeto
                for (let count = 0; count < moreFiles.files.length; count++) {
    
                        // verificar se arquivo já existe no fileList e adicionar somente os q não existem
                        if(filesSelected.includes(moreFiles.files[count].name) == false){
                            data.items.add(moreFiles.files[count]);
                        }
    
                    }
    
                // colocar os novos arquivos ao valor do input principal
                inputSliderImg.files = data.files;
    
                // adicionar preview 
                getHTMLpreview(inputSliderImg.files, previewContainer)
    
                if(infosArea != null){
                    getInfos(inputSliderImg.files, infosArea)
                }
    
                // limpar último item adicionado no morefiles
                moreFiles.files = new DataTransfer();
            }
        })

        removeAllFiles.addEventListener("click", function(){
            let data = new DataTransfer(); // objeto para receber os novos arquivos em um formato aceito pelo input

            // colocar valor vazio ao valor do input principal
            inputSliderImg.files = data.files;

            // alterar preview 
            getHTMLpreview(inputSliderImg.files, previewContainer)

            // verificar se há arquivos selecionados no input principal para trocar o texto e o icone
            photoIcon(icon, inputSliderImg.files.length);

            if(document.querySelector(`.infos_container [data-for]`) != null){
                removeAllinfo() // remover todas as informações dos arquivos de mídia
            }

        })

    }
    
})
// 

function remove(){
    var inputSliderImg = document.getElementById("carousel_media"); // input
    var removeMedia = document.querySelectorAll(".container-media"); // remover todos os arquivos selecionados
    var previewContainer = document.querySelector(".preview-all-medias"); // container de pré visualização


    removeMedia.forEach(media => {
        media.addEventListener("click", () => {
            
            let data = new DataTransfer(); // objeto para receber os novos arquivos em um formato aceito pelo input
            var filesSelected = [`${inputSliderImg.files[media.dataset.c].name}`]; // nome dos arquivos já escolhidos 
            
            // remover o input de descrição da mídia
            if(document.querySelector(`.infos_container [data-for]`) != null){
                removeInfos(inputSliderImg.files[media.dataset.c].name)
            }

            // pegar valor dos arquivos já adicionados ao input principal
            for (let count = 0; count < inputSliderImg.files.length; count++) {

                // verificar se arquivo já existe no fileList e adicionar somente os q não existem
                if(!(inputSliderImg.files[count].name == filesSelected)){
                    data.items.add(inputSliderImg.files[count]);
                }

            };
            
            // colocar os arquivos restantes ao valor do input principal
            inputSliderImg.files = data.files;
            
            // adicionar preview 
            getHTMLpreview(inputSliderImg.files, previewContainer)

            // add/remover icon
            photoIcon(document.querySelector("label[for=carousel_media] .preview > .container-icon"), inputSliderImg.files.length)
            
            if(document.querySelector(`.infos_container [data-for]`) != null){
                toggleDisplayInfos() // trocar display add infos 
            }
            
         })
    });
}  

function toggleDisplay(){
    if(document.getElementById("carousel_media").files.length > 0){
        document.querySelector("label[for=carousel_media] > .preview.multiple").classList.add("d-none");
        document.querySelector(".edit_media").classList.remove("d-none");
    } else {
        document.querySelector("label[for=carousel_media] > .preview.multiple").classList.remove("d-none");
        document.querySelector(".edit_media").classList.add("d-none");
    }
}

function toggleDisplayInfos(){
    if(document.querySelector(".infos_container [data-for]") != null){
        document.querySelector(".infos_container").classList.remove("d-none")
    }

    else {
        document.querySelector(".infos_container").classList.add("d-none");
    }
}

// pré visualizar mídias do carrossel
function getHTMLpreview(files, previewContainer){
    // limpar imgens do input ao trocar arquivos
    previewContainer.innerHTML = "";
    count = 0;

    // adicionar preview mídias
    for(const file of files){
        
        if(allowedFilesI.includes(getFileExtension(file.name))){
            mediaHTML = `<div class="container-media" data-c="${count}"><div class="remove-media" title="Clique para remover a imagem"><i class="fa-solid fa-trash"></i><span>Remover imagem</span></div><img src="${URL.createObjectURL(file)}" alt="${file.name}" class="preview-slider"></img></div>`
            previewContainer.insertAdjacentHTML("beforeend", mediaHTML);
        }

        else if (allowedFilesV.includes(getFileExtension(file.name))){
            mediaHTML = `<div class="container-media" data-c="${count}"><div class="remove-media" title="Clique para remover o vídeo"><i class="fa-solid fa-trash"></i><span>Remover vídeo</span></div><video width="100%" controls> <source src="${URL.createObjectURL(file)}" alt="${file.name}" class="preview-slider">Seu navegador não suporta vídeo HTML5.</video></div>`
            previewContainer.insertAdjacentHTML("beforeend", mediaHTML);
        } 

        else {
            mediaHTML = `<div class="container-media" data-c="${count}"><div class="remove-media" title="Clique para remover a imagem"><i class="fa-solid fa-trash"></i><span>Remover vídeo</span></div>Tipo de mídia inválido</div>`
            previewContainer.insertAdjacentHTML("beforeend", mediaHTML);
        }

        count++;
    }
    
    remove(); // terminar de criar função para remover um arquivo especifico do carrosel

    toggleDisplay() // trocar o display do label
}

// html para inserir informações para as mídias 
function getInfos(files, container) {

    // adicionar preview mídias
    for(const file of files){
        if(allowedFilesI.includes(getFileExtension(file.name)) && (document.querySelector(`[data-for="${file.name}"]`) == null)){
            infosHTML = 
            `<div data-for="${file.name}"> 
                <div class="img_container">
                    <img src="${URL.createObjectURL(file)}" alt="${file.name}">
                </div>
                <textarea type="text" name="infos_img" id="${file.name}" placeholder='Adicionar informações para a imagem'></textarea>
            </div>`;
            container.insertAdjacentHTML("beforeend", infosHTML);
        }

        else if (allowedFilesV.includes(getFileExtension(file.name)) && (document.querySelector(`[data-for="${file.name}"]`) == null)){
            infosHTML = 
            `<div data-for="${file.name}"> 
                <div class="img_container">
                    <video width="100%" controls> <source src="${URL.createObjectURL(file)}" alt="${file.name}" class="preview-slider">Seu navegador não suporta vídeo HTML5.</video>
                </div>
                <textarea type="text" name="infos_img" id="${file.name}" placeholder='Adicionar informações para o vídeo'></textarea>
            </div>`;
            container.insertAdjacentHTML("beforeend", infosHTML);
        } 
    }

    if(document.querySelector(`.infos_container [data-for]`) != null){
        toggleDisplayInfos() // trocar display add infos 
    }
}

// html para inserir informações para as url's

$(document).ready(function () {
    if(document.querySelector(".infos_container")){
        urls = document.querySelector("#carousel_url_videos");
        
        urls.addEventListener("change", () => {
            document.querySelector(".wrongUrl").innerHTML = '';
            var remove = [];
            
            document.querySelectorAll("[name=infos_url]").forEach(input => {
                remove.push(input.id)
            })

            var acceptUrls = verifyUrls(urls.value, 'carousel_url_videos');

            accept = acceptUrls.filter((n) => {
                return !remove.includes(n)
            });
            
            accept.forEach(url => {

                infosHTML = 
                `<div data-for="${url}"> 
                    <div class="img_container">
                        <iframe width="200" height="150" src="https://www.youtube.com/embed/${url}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <textarea type="text" name="infos_url" id="${url}" placeholder='Adicionar informações para o vídeo'></textarea>
                </div>`;
                document.querySelector(".infos_area").insertAdjacentHTML("beforeend", infosHTML);

            });

            remove = remove.filter((n) => {
                return !acceptUrls.includes(n)
            });

            remove.forEach(input => {
                removeInfos(input);
            });

            if(document.querySelector(`.infos_container [data-for]`) != null){
                toggleDisplayInfos() // trocar display add infos 
            }


        })
    }
})


function removeInfos(input){
    document.querySelector(`[data-for="${input}"]`).parentNode.removeChild(document.querySelector(`[data-for="${input}"]`))
    toggleDisplayInfos() // trocar display add infos 
}

function removeAllinfo(){
    document.querySelectorAll(`.infos_container [data-for]`).forEach((media) => {
        // caso não for uma url, remover add infos
        if(allowedFilesV.includes(getFileExtension(media.dataset.for)) || allowedFilesI.includes(getFileExtension(media.dataset.for))){
            // console.log(media)
            removeInfos(media.dataset.for);
        }
    })
}

// visualizar ou não o container com as informações das imagens
$(document).ready(function () {
    if(document.querySelector(".infos_container")){
        
        document.querySelector(".infos_container > label").addEventListener("click", () => {
            
            if(document.querySelector(".d-infos-none")){
                document.querySelector(".infos_container > label span").innerHTML = '<i class="fa-sharp fa-solid fa-arrow-up"></i>';
                document.querySelector(".infos_area").classList.remove("d-infos-none")
            } else {
                document.querySelector(".infos_container > label span").innerHTML = '<i class="fa-sharp fa-regular fa-arrow-down"></i>';
                document.querySelector(".infos_area").classList.add("d-infos-none")
            }

        })
    }
})

function changeVideo(video){
    previewContainer = document.querySelector(".preview-video"),  // div que recebe as preview's
    icon = document.querySelector(".preview-video ~ .container-icon") // div com o texto e icon

    // limpar imgens do input ao trocar arquivos
    previewContainer.innerHTML = '';
    videoHTML = '';

    if(typeof video === 'object'){
        // css icon/text div.conteiner-icon 
        photoIcon(icon, video.files.length);
    
        // adicionar preview das imagens
        for(const file of video.files){
            if (allowedFilesV.includes(getFileExtension(file.name))){
                videoHTML = `<div class="remove-video" title="Clique para remover o vídeo"></div>
                <video width="100%" controls> <source src="${URL.createObjectURL(file)}" alt="${file.name}">Seu navegador não suporta vídeo HTML5.</video>`
            }
            else {
                videoHTML = `<i style="font-size: 15px; margin-right: 10px;" class="fa-solid fa-triangle-exclamation"></i><span>Tipo de mídia inválido</span>`
            }
        }
    } else {
        photoIcon(icon, video.length);

        videoHTML = `<div class="remove-video" title="Clique para remover o vídeo"></div>
        <iframe width="100%" max-width="100%" height="100%" src="https://www.youtube.com/embed/${video}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`
    }

    previewContainer.insertAdjacentHTML("beforeend", videoHTML);
}

function organizePreview(type){
    if(type == 'img'){
        document.querySelector(".preview-img-container").dataset.idMedia = '';
        document.getElementById('img_remove').style.display = 'none';
        document.querySelector(".preview-img-container ~ .container-icon").style.display = 'flex'
        previewImg()
    }
}

async function resetPreview(type){
    // verificar se os inputs de video estão vazios, caso seja ele quem sofreu a mudança
    if(document.querySelector(".form-cad") != null){
        pathVariation = document.querySelector(".form-cad").dataset.pathVariation; // variação do caminho do arquivo

        
        // verificar se os input de imagem está vazio, caso seja ele quem sofreu a mudança
        if(type === 'img' && document.getElementById('img').files.length === 0) {
            idMedia = document.querySelector('.preview-img-container').dataset.idMedia; // pegar nome da imagem
    
            if(await checkUrl(`${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/${pathVariation}${idMedia}`)}`)){
                mediaHTML = `<img src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/${pathVariation}${idMedia}`)}" alt="${idMedia}" class="preview-img">`;
                document.querySelector(".preview-img-container").innerHTML = mediaHTML; // adicionar preview da imagem
    
                photoIcon(document.querySelector("label[for=img] .container-icon"), 1); // arrumar visualização da icon
            }

            else if(await checkUrl(`${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/favicon/${idMedia}`)}`)){
                mediaHTML = `<img src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/favicon/${idMedia}`)}" alt="${idMedia}" class="preview-img">`;
                document.querySelector(".preview-img-container").innerHTML = mediaHTML; // adicionar preview da imagem
    
                photoIcon(document.querySelector("label[for=img] .container-icon"), 1); // arrumar visualização da icon
            }
        }
    }
}

// alterar css icon 

function photoIcon(icon, numFiles){
    if(numFiles != 0){
        icon.classList.add("active-input");
    } else {
        icon.classList.remove("active-input");
    }
}

function allPdfs(files) {
    var namePdfs = "<b>Arquivo Selecionado:</b> ";

    // plural p/ mais de um arquivo
    if (files.length > 1) {
        namePdfs = "<b>Arquivos Selecionados:</b> ";
    }

    // sem arquivos
    if (files.length == 0) {
        namePdfs = "<b>Clique aqui para adicionar PDF's</b> ";
    }
    
    for (let index = 0; index < files.length; index++) {
        if (index < (files.length - 2)) {
            namePdfs += files[index].name + ", ";
        } 
        else if (index < (files.length - 1)) {
            namePdfs += files[index].name + " e ";
        }
        else {
            namePdfs += files[index].name;
        }
        
    }

    return namePdfs;
}