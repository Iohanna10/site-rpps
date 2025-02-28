/* ================ variáveis ================ */
var marginGallery = 0; // tamanho da margem para mover o slider
let slidesGallery;
let slideGallery;
var widthSlidesGallery; // tamanho da div slides
var widthSlideGallery; // tamnho dos slides
var count = 1;
/* =========================================== */

// ------------------------- ajustar dimensões do slider --------------------------- //

function activeSliderGallery() {
    photosEvent();
    adjustSlidesGallery();
}

function adjustSlidesGallery() {
    slidesGallery = document.querySelector(".gallery-carousel .slides"); // seleciona a div slides
    slideGallery = document.querySelectorAll(".gallery-carousel .slides .slide"); // seleiona os slides

    slidesWidthGallery(slidesGallery, slideGallery); // altera o tamanho da div slides
    slideWidthGallery(slideGallery); // altera o tamnho da div slide (que contém as imagens)
}

// --------------------------------------------------------------------------------- //

// :::::::::::::::::::::::::::::: tamanho do slider  ::::::::::::::::::::::::::::::: //

function slidesWidthGallery(slidesGallery, slideGallery){
    widthSlidesGallery = slideGallery.length; // tamanho ideal pela quantidade de imagens

    slidesGallery.style.width = widthSlidesGallery + '00%';  // altera o tamanho da div slides
} 

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// ------------------------------ tamanho dos slides ------------------------------- //

function slideWidthGallery(slide){
    widthSlideGallery = 100/slideGallery.length; // tamanho ideal para as imagens
    
    slideGallery.forEach(el => {
        el.style.width = widthSlideGallery + '%'; // altera o tamanho da div slides
    });
}

// --------------------------------------------------------------------------------- //

// ------------------ criar html para inserir na div "media-info" ------------------ //

    function contentsInfoMedia(infos){
        
        var html = ''; // conteúdo que será inserido na div 

        html += `<h3 class="title">${infos[0]}</h3><span class="info">${infos[1]}</span>`;

        document.querySelector(".media-info").innerHTML = html;
    }

// --------------------------------------------------------------------------------- //

// ::::::::::: adicionar evento de click as mídias para abrir o slider  ::::::::::: //

function photosEvent(){
    document.querySelectorAll('.photo-gallery').forEach(el => {
        el.addEventListener("click", () => {
            count = parseInt(el.dataset.imgNum);
            
            marginGallery = widthSlideGallery * (count - 1);
            slideGallery[0].style.marginLeft = "-" + marginGallery + "%"; // alterar a margem para mostrar diretamente a foto clicada

            toggleSlider(); // função que altera a visibilidade das div's para mostrar conteúdos
        })
    });
}

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// --------------------------------- fechar slider --------------------------------- //

function closeSlides(){
    closeFullscreen();
    toggleSlider();
    pauseVideos();

    if(document.querySelector(".ctrl .play.hidden")){
        toggleIconPlay()
    
        // parar de ir para o próximo slide
        clearInterval(changeSlide); 
    }
}

// --------------------------------------------------------------------------------- //

// ::::::::::::::::::::::::::::::::: abrir slider :::::::::::::::::::::::::::::::::: //

function toggleSlider() {
    document.querySelector('.gallery-carousel').classList.toggle("hidden");
    document.body.classList.toggle("overflow-y");
}

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// --------------------------------- slide anterior -------------------------------- //

// função 
function prevSlideGallery(){ 
    if(count > 1 && count <= widthSlidesGallery){
        count = parseInt(count) - 1;
        marginGallery = widthSlideGallery * (count - 1);
        slideGallery[0].style.marginLeft = "-" + marginGallery + "%";
    } else {
        count = widthSlidesGallery;
        marginGallery = widthSlideGallery * (widthSlidesGallery - 1);
        slideGallery[0].style.marginLeft = "-" + marginGallery + "%";
    }
    
    moveOtherSlider(); // move o outro slider junto com o da galeria
    pauseVideos()
    
    // console.log("-" + marginGallery + "%", count);
}

// --------------------------------------------------------------------------------- //

// ::::::::::::::::::::::::::::::::: próximo slide :::::::::::::::::::::::::::::::::: //

//função
function nextSlideGallery(){
    if(count < widthSlidesGallery){
        count = parseInt(count) + 1;
        marginGallery = widthSlideGallery * (count - 1);
        slideGallery[0].style.marginLeft = "-" + marginGallery + "%";
    } else {
        count = 1;
        slideGallery[0].style.marginLeft = "0%";
        marginGallery = 0;
    }
    
    moveOtherSlider(); // move o outro slider junto com o da galeria
    pauseVideos()
    
    // console.log("-" + marginGallery + "%", count);
}

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// ------------------------- mudar slides automáticamente  ------------------------- //

function playSlider() {
    toggleIconPlay()
    
    // timer para ir para o próximo slide
    changeSlide = setInterval(function(){
        nextSlideGallery()
    }, 2000);
}

function pauseSlider() {
    toggleIconPlay()
    
    // parar de ir para o próximo slide
    clearInterval(changeSlide); 
}

function toggleIconPlay(){
    document.querySelector('.ctrl .play').classList.toggle("hidden");
    document.querySelector('.ctrl .pause').classList.toggle("hidden");
}

// --------------------------------------------------------------------------------- //

// ----------------------- mudar slides do slider principal ------------------------ //

function moveOtherSlider () {
    margin = widthSlide * (count - 1);

    document.querySelector(".gallery .slides .slide.first-post").style.marginLeft = "-" + margin + "%"; 
    document.querySelector(".current").value = count;
}

function toggleBtns(){
    document.querySelector(".control-buttons").classList.toggle("toggle-on");

    icon = setTimeout(function(){
        iconToggle(); // função trocar icon 
    }, 600);
}

// --------------------------------------------------------------------------------- //
