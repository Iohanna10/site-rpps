
/* ================ variáveis ================ */
var margin = 0; // tamanho da margem para mover o slider
var slides;
var slide;
var widthSlides; // tamanho da div slides
var widthSlide; // tamnho dos slides
var count = 1;
var currentGallery = '';
var currentGalleryId = '';

const allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
const allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
/* =========================================== */

function prepareGalleries () {
    document.querySelectorAll('.open-gallery').forEach(el => { // evento de click nas fotos para abrir a galeria
        el.addEventListener("click", () => {
            openGallery(el);
        });
    });

     
    document.querySelector(".back").addEventListener("click", () => { // evento de click para voltar para publicações das galerias
        loader();
        changeScrean();
    })

    document.querySelector(".close-slider").addEventListener("click", () => { // evento de click para fechar slider
        toggleSlider();
        pauseVideos();
    })

    document.querySelector(".btn-prev").addEventListener("click", () => { // evento de clique slide anterior 
        prevSlide();
        pauseVideos();
    })

    document.querySelector(".btn-next").addEventListener("click", () => { // evento de clique próximo slide
        nextSlide();
        pauseVideos();
    })

    document.querySelector(".ctrl .play").addEventListener("click", () => { // evento de clique mudar slider automaticamente
        toggleIconPlay()
        
        // timer para ir para o próximo slide
        changeSlide = setInterval(function(){
            nextSlide();
        }, 2000);
    })

    document.querySelector(".ctrl .pause").addEventListener("click", () => { // evento de clique parar de mudar slides automaticamente
        toggleIconPlay()
        
        // parar de ir para o próximo slide
        clearInterval(changeSlide); 
    })
}

    // ::::::::::::::::::::::::::::::::: abrir galeria ::::::::::::::::::::::::::::::::: //

    function openGallery (el) {
        // dados para a pesquisa no db
        var data = {
            'id_gallery': el.dataset.galleryId,
            'institute': getInstitute(), 
            'path_name': false
        }

        currentGalleryId = el.dataset.galleryId; // id galeria atual

        // trocar a tela: gif loader ativo (até receber a resposta do ajax)
        loader();

        // ajax para entregar os dados ao model (AjaxPhotosModel) e retornar os dados
        $.ajax({
            method: "POST", 
            url: getUriRoute("ajax/ajax-gallery/getdata"),
            data: data,
            success: function (response){     
                currentGallery = response.nome; // galeria atual

                contentsGallery(response) /* função para trocar os dados */
                photosEvent() /* adicionar eventos onclick para as fotos */
                contentsSliderPhotos(response) /* criar o slider de fotos */

                // trocar tela
                changeScrean()
            }
        })
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ::::::::::::::::::::::::::: pegar extensão do arquivo ::::::::::::::::::::::::::: //

    function getFileExtension(filename){
        return filename.split('.').pop();
    }    

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //


    // ---------------- criar e mudar o código html das fotos do modal ----------------- //

    function contentsGallery(dataGallery){
        
        var html = ''; // conteúdos da div gallery
        var num = 0;

        var date = new Date(dataGallery.data); 
        var name_gallery = dataGallery.nome.replace(" ", "_").toLowerCase()
        
        if(dataGallery.midias != null){
            dataGallery.midias.split(', ').forEach(media => {
                if(allowedFilesI.includes(getFileExtension(media))){
                html += `<div class='photo' data-img-num="${num+1}" data-photo-id="${num}"><a class="open-slider">
                        <img src='${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}'>
                    </a></div>`;
                } else if(allowedFilesV.includes(getFileExtension(media))){
                    html += `<div class='photo' data-img-num="${num+1}" data-photo-id="${num}"><a class="open-slider">
                        <video class="video" width="320" height="240" controls>
                            <source src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/video/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}">
                        </video>
                        <div></div>
                    </div>`;
                } else {
                    html += 
                    `<div class="photo" data-img-num="${num+1}" data-photo-id="${num}">
                        <iframe class="video" width="100%" height="100%" src="https://www.youtube.com/embed/${media}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        <div></div>
                    </div>`;
                }
                num += 1;
            })
        } else {
            html += 
            `<div class="warning">
                <span>Ainda não há mídias nesta galeria.</span>
            </div>`;
        }
        
        document.querySelector(".gallery").innerHTML = html;
    }

    // --------------------------------------------------------------------------------- //

    // --------------------------------- mudar telas ----------------------------------- //

    function changeScrean(){
        screenChange = setTimeout(function(){
            loader() /* parar gif loader */, changeToGallery(); // função trocar para galeria
        }, 1000);
    }
    
    // trocar para a tela da galeria
    function changeToGallery(){
        document.querySelector(".gallery-posts").classList.toggle("hidden");
        document.querySelector(".modal-gallery").classList.toggle("hidden");
    }

    function loader(){
        document.querySelector(".loader").classList.toggle("loader-on"); // loader gif
    }

    // ---------------------------------------------------------------------------------- //

    // ::::::::::::::::::::: criar html para inserir na div slides :::::::::::::::::::::: //

    function contentsSliderPhotos(dataGallery){
        var html = ''; // conteúdo que será inserido na div slides
        var first = true; // verifica se é o primeiro slide

        var name_gallery = dataGallery.nome.replace(" ", "_").toLowerCase()

        var date = new Date(dataGallery.data); 
        
        if(dataGallery.midias != null){

            dataGallery.midias.split(', ').forEach(media => {

                // primeiro slide
                if(first == true){
                    // slide de foto
                    if(allowedFilesI.includes(getFileExtension(media))){
                        html += `<div class="slide first">`;
                            html += `<img src='${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}'>`
                        html += `</div>`;
                    } 
                    
                    else if(allowedFilesV.includes(getFileExtension(media))){
                        html += `<div class="slide first">`;
                        html += `<video class="video" controls>
                        <source src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/video/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}"></video>`
                        html += `</div>`;
                    }
                
                    // slide de vídeo url
                    else {
                        html += `<div class="slide first">`;
                        html += `<iframe class="video" src="https://www.youtube.com/embed/${media}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                        html += `</div>`;
                    }

                    first = false; // desabilitar condição de primeiro slide
                } 
                else {
                    if(allowedFilesI.includes(getFileExtension(media))){
                        html += `<div class="slide first">`;
                            html += `<img src='${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}'>`
                        html += `</div>`;
                    } 
                    
                    else if(allowedFilesV.includes(getFileExtension(media))){
                        html += `<div class="slide first">`;
                        html += `<video class="video" controls>
                        <source src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/video/photo-gallery/all-images/${date.getFullYear()}/${(date.getMonth() + 1)}/${name_gallery}/${media}`)}"></video>`
                        html += `</div>`;
                    }
                
                    // slide de vídeo url
                    else {
                        html += `<div class="slide first">`;
                        html += `<iframe class="video" src="https://www.youtube.com/embed/${media}" title="YouTube video player" frameborder="0" allow="enablejsapi=1; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                        html += `</div>`;
                    }
                }
            })
        }
        
        document.querySelector(".slides").innerHTML = html;

        // ajustes de tamanho para o slider
        adjustSlides();
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ------------------------- ajustar dimensões do slider --------------------------- //

    function adjustSlides() {
        slides = document.querySelector(".slides"); // seleciona a div slides
        slide = document.querySelectorAll(".slides .slide"); // seleiona os slides

        slidesWidth(slides, slide); // altera o tamanho da div slides
        slideWidth(slide); // altera o tamnho da div slide (que contém as imagens)
    }
    
    // --------------------------------------------------------------------------------- //
    
    // :::::::::::::::::::::::::::::: tamanho do slider  ::::::::::::::::::::::::::::::: //

    function slidesWidth(slides, slide){
        widthSlides = slide.length; // tamanho ideal pela quantidade de imagens

        slides.style.width = widthSlides + '00%';  // altera o tamanho da div slides
    } 

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ------------------------------ tamanho dos slides ------------------------------- //

    function slideWidth(slide){
        widthSlide = 100/slide.length; // tamanho ideal para as imagens
        
        slide.forEach(el => {
            el.style.width = widthSlide + '%'; // altera o tamanho da div slides
        });
    }

    // --------------------------------------------------------------------------------- //

    // ::::::::::::::::::::::::::::: buscar info da imagem ::::::::::::::::::::::::::::: //

    function  searchInfos(){

        var selectCurrentElement = `[data-img-num='${count}']`;

        // dados para a pesquisa no db
        var data = {
            'institute': getInstitute(),
            'name_gallery': currentGallery,
            'id_gallery': currentGalleryId,
            'path_name': true
        }

        var currentId = document.querySelector(selectCurrentElement).dataset.photoId; // id da foto atual

        // ajax para entregar os dados ao model (AjaxPhotosModel) e retornar os dados
        $.ajax({
            method: "POST", 
            url: getUriRoute("ajax/ajax-gallery/getdata?pathName=true"),
            data: data,
            success: function (response){

                // @media_desc: transformar a string do bd em um array, selecionar a descrição da mídia atual, remover espaços em branco no inicio
                var media_desc = response.descricao_midias.split(';<separator>;')[currentId].trim();
                
                // @nome: transformar a string do bd em um array, selecionar a descrição da mídia atual, remover espaços em branco no inicio e fim e remover a extensão
                var name = response.midias.split(',')[currentId].trim().replace(`.${getFileExtension(response.midias.split(',')[currentId])}`, ''); 
                
                // verifica se há informações sobre a mídia
                if(media_desc == ''){
                    document.querySelector(".ctrl .info").style.display = "none";
                    document.querySelector(".media-info").style.display = "none";
                } 
                else {
                    document.querySelector(".ctrl .info").style.display = "block";
                    document.querySelector(".media-info").style.display = "flex";
                    contentsInfoMedia(media_desc, name)
                }

            }
        })
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ------------------ criar html para inserir na div "media-info" ------------------ //

        function contentsInfoMedia(infos, name){
            
            var html = ''; // conteúdo que será inserido na div 

            html += `<h3 class="title">${name}</h3><span class="info">${infos}</span>`;

            document.querySelector(".media-info").innerHTML = html;
        }

    // --------------------------------------------------------------------------------- //

    // ::::::::::: adicionar evento de click as mídias para abrir o slider  ::::::::::: //

        function photosEvent(){
            document.querySelectorAll('.photo').forEach(el => {
                el.addEventListener("click", () => {

                    count = parseInt(el.dataset.imgNum);
                    searchInfos() // procurar infos da imagem
                    
                    margin = widthSlide * (count - 1);
                    slide[0].style.marginLeft = "-" + margin + "%"; // alterar a margem para mostrar diretamente a foto clicada

                    toggleSlider();
                })
            });
        }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ::::::::::::::::::::::::::::::::: abrir slider :::::::::::::::::::::::::::::::::: //

    function toggleSlider() {
        document.querySelector('.gallery-carousel').classList.toggle("hidden");
        document.querySelector('.modal-gallery').classList.toggle("hidden");
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // --------------------------------- slide anterior -------------------------------- //

    // função 
    function prevSlide(){ 
        if(count > 1 && count <= widthSlides){
            count -= 1;
            margin = widthSlide * (count - 1);
            slide[0].style.marginLeft = "-" + margin + "%";
        } else {
            count = widthSlides;
            margin = widthSlide * (widthSlides - 1);
            slide[0].style.marginLeft = "-" + margin + "%";
        }
        
        searchInfos() // procurar infos da imagem
    }

    // --------------------------------------------------------------------------------- //

    // ::::::::::::::::::::::::::::::::: próximo slide :::::::::::::::::::::::::::::::::: //

    //função
    function nextSlide(){
        if(count < widthSlides){
            count += 1;
            margin = widthSlide * (count - 1);
            slide[0].style.marginLeft = "-" + margin + "%";
        } else {
            count = 1;
            slide[0].style.marginLeft = "0%";
            margin = 0;
        }
        
        searchInfos() // procurar infos da imagem
        // console.log("-" + margin + "%", count);
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    // ------------------------- mudar slides automáticamente  ------------------------- //

    function toggleIconPlay(){
        document.querySelector('.ctrl .play').classList.toggle("hidden");
        document.querySelector('.ctrl .pause').classList.toggle("hidden");
    }

    // --------------------------------------------------------------------------------- //

    function pauseVideos(){
        
        document.querySelectorAll("video").forEach((video) => {
            // pausar videos 
            if(!video.paused){
                video.pause();
            }
        })

        document.querySelectorAll("iframe").forEach((iframe) => {
            // pausar/resetar url's
            iframe.setAttribute('src', iframe.getAttribute('src'));
        })
    }
