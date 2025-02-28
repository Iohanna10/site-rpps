// variáveis
let widthSlides; // tamanho da div slides
let widthSlide; // tamnho dos slides
let count = 1; // contagem 
let margin = 0; // tamanho da margem
let changeSlide; // timer da função de trocar os slides 
// 

// variáveis
var btnNext = document.querySelectorAll(".btn-next span"); // btn próxima imagem
var btnPrev = document.querySelectorAll(".btn-prev span"); // btn imagem anterior 
var img = document.querySelectorAll(".first-img"); // primeiras imagens dos slider's
// 

function findSlideImg(id) {
    document.querySelector(`[name=radio-btn]:checked`).removeAttribute('checked');
    document.getElementById(`main-radio${id}`).setAttribute('checked', true);

    let slider = ".slider-" + id;  // div slider 
    let slides = slider + " .slides"; // div slides
    let slide = slides + " .slide";  // div slide

    slides = document.querySelector(slides); // seleciona a div slides
   
    slide = document.querySelectorAll(slide); // seleiona os slides

    slidesWidth(slides, slide); // altera o tamanho da div slides
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

    // reset btns
    nextSlide(widthSlide, widthSlides, widthSlide);

    // reiniciar timer antes de recomeçar a trocar os slides automaticamente
    clearInterval(changeSlide); 

    // timer alteração slides 
    changeSlide = setInterval(function(){
        nextImage(widthSlide, widthSlides);
    }, 5000);
}

// alteração automatica dos slides
function nextImage(widthSlide, qntdImg){
    count++;
    if(count > qntdImg){
        count = 1;
        margin = 0;
    }

    if(qntdImg > 1){
        img.forEach((el) => {
            el.style.marginLeft = "-" + margin + "%"; 
        });
    }
    
    margin = margin + widthSlide;
}

// reiniciar timer ao trocar de slide manualmente 
function restartChangeSlide(){
    changeSlide = setInterval(function(){
        nextImage(widthSlide, widthSlides);
    }, 5000)
}

// slide anterior manualmente 
function prevSlide(currentSlide, qntdImg, slideImg){    
    count = currentSlide - 1;
    if(count == 0){
        count = qntdImg;
        margin = slideImg * (qntdImg - 1);
    } else {
        margin = margin - slideImg;
    }

    img.forEach((el) => {
        el.style.marginLeft = "-" + margin + "%"; 
    });

    clearInterval(changeSlide);
    restartChangeSlide();
}

// próximo slide manualmente
function nextSlide(currentSlide, qntdImg, slideImg){
    count = currentSlide + 1;
    if(count > qntdImg){
        count = 1;
        margin = 0;
    } else {
        margin = margin + slideImg;
    }
    
    img.forEach((el) => {
        el.style.marginLeft = "-" + margin + "%"; 
    });

    clearInterval(changeSlide);
    restartChangeSlide();
}

btnNext.forEach((el) =>{
    el.addEventListener("click", () => {
        nextSlide(count, widthSlides, widthSlide);
    });
});

btnPrev.forEach((el) =>{
    el.addEventListener("click", () => {
        prevSlide(count, widthSlides, widthSlide);
    });
});

$(document).ready(() => {
    if(document.querySelector(".main-slide .warning") === null){
        inputs = document.querySelectorAll("[name=radio-btn]"); // pegar todos os inputs de navegação do slide
    
        inputs.forEach(el => {
            if(el.checked === true){
                document.querySelector(`label[for=${el.id}]`).click()   
            }  
        });
    }
})