// variáveis
let widthSlides; // tamanho da div slides
let widthSlide; // tamnho dos slides
let countPosts = 1; // contagem 
let margin = 0; // tamanho da margem
let slides;
let slide;
// 

// constantes
const btnNext = document.querySelectorAll(".btn-next span"); // btn próxima imagem
const btnPrev = document.querySelectorAll(".btn-prev span"); // btn imagem anterior 
// 

function findSlidePost(numInput){
    currentInputChecked(numInput);
    countPosts = numInput;
    margin = widthSlide * (numInput - 1);
    slide[0].style.marginLeft = "-" + margin + "%";
}

function adjustSlides() {
    slides = document.querySelector(".gallery .slides"); // seleciona a div slides
   
    slide = document.querySelectorAll(".gallery .slides .slide"); // seleiona os slides

    slidesWidth(slides, slide); // altera o tamanho da div slides

    isItATip(); // verificar se é uma das pontas do slider para desabilitar o btns
    totalPgs(); // verificar se é uma das pontas do slider para desabilitar o btns
}

function slidesWidth(slides, slide){
    widthSlides = slide.length; // tamanho ideal pela quantidade de imagens
   
    slides.style.width = widthSlides  + '00%';  // altera o tamanho da div slides

    slideWidth(slide, widthSlides); // altera o tamnho da div slide (que contém as imagens)
} 

function slideWidth(slide){
    widthSlide = 100/slide.length; // tamanho ideal para as imagens

    slide.forEach(el => {
        el.style.width = widthSlide + '%'; // altera o tamanho da div slides
    });
}

// primeiro slide manualmente 
function firstSlide(){ 
    slide[0].style.marginLeft = "0%";
    margin = 0;
    countPosts = 1;

    isItATip();
    countPostsPg();
    pauseVideos()
}

// slide anterior manualmente 
function prevSlide(){ 
    if(countPosts != 1){
        countPosts = parseInt(countPosts) - 1;
        console.log(countPosts)
    
        margin = margin - widthSlide;
        slide[0].style.marginLeft = "-" + margin + "%";

        isItATip();
        countPostsPg();
        pauseVideos()
    }
}

// próximo slide manualmente
function nextSlide(){
    if(countPosts < widthSlides){
        margin += widthSlide;
        slide[0].style.marginLeft = "-" + margin + "%";
        countPosts = parseInt(countPosts) + 1;
        // console.log(countPosts)

        isItATip();
        countPostsPg();
        pauseVideos()
    } 
}

// último slide manualmente 
function lastSlide(){ 
    countPosts = widthSlides;
    margin = widthSlide * (widthSlides - 1);
    slide[0].style.marginLeft = "-" + margin + "%";

    isItATip();
    countPostsPg();
    pauseVideos()
}

// verificar se é uma das pontas do slider para desabilitar o btns
function isItATip(){
    if(countPosts == 1){
        document.querySelector(".btns.left").classList.add("disabled");
    } else {
        document.querySelector(".btns.left").classList.remove("disabled");
    }

    if(countPosts == widthSlides){
        document.querySelector(".btns.right").classList.add("disabled");
    } else {
        document.querySelector(".btns.right").classList.remove("disabled");
    }
}

// inserir total de páginas ao span
function totalPgs(){
    document.querySelector(".total").innerHTML = widthSlides;
}

// inserir página atual ao valor do input
function countPostsPg(){
    document.querySelector(".current").value = countPosts;
}

// levar a página de acordo com o valor inserido manualmente no input
function valueCurrentPg (){
    document.querySelector('.current').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            inputValue = document.querySelector('.current').value;
            
            if(inputValue >= 1 && inputValue <= widthSlides){
                countPosts = inputValue;
                
                margin = widthSlide * (countPosts - 1);
                slide[0].style.marginLeft = "-" + margin + "%"; // alterar a margem para mostrar diretamente a foto clicada

                isItATip(); 
            } else {
                countPosts = 1;

                firstSlide();
            }
        }
    });
}

function closeSlider(){
    document.querySelector(".close-slider").addEventListener("click", () => {
        {
            countPosts = document.querySelector(".current").value;
            console.log(document.querySelector(".current").value)
            isItATip();
            pauseVideos()
        }
    });
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