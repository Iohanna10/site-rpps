// variáveis
let widthSlides; // tamanho da div slides
let widthSlide; // tamnho dos slides
let count = 1; // contagem 
let margin = 0; // tamanho da margem
let slides;
let slide;
// 

// constantes
const btnNext = document.querySelectorAll(".btn-next span"); // btn próxima imagem
const btnPrev = document.querySelectorAll(".btn-prev span"); // btn imagem anterior 
let currentInput;
// 

function findSlidePost(numInput){
    currentInputChecked(numInput);
    count = numInput;
    margin = widthSlide * (numInput - 1);
    slide[0].style.marginLeft = "-" + margin + "%";
}

function currentInputChecked(numInput){
    currentInput = "#main-radio" + numInput;
    currentInput = document.querySelector(currentInput);
}

function adjustSlides() {
    slides = document.querySelector(".slides"); // seleciona a div slides
   
    slide = document.querySelectorAll(".slides .slide"); // seleiona os slides

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
}

// slide anterior manualmente 
function prevSlide(){ 
    if(count != 1){
        count -= 1;
        margin = margin - widthSlide;
        slide[0].style.marginLeft = "-" + margin + "%";
    } else {
        count = widthSlides;
        margin = widthSlide * (widthSlides - 1);
        slide[0].style.marginLeft = "-" + margin + "%";
    }

    currentInputChecked(count);
    currentInput.checked = true;
}

// próximo slide manualmente
function nextSlide(){
    if(count < widthSlides){
        margin += widthSlide;
        slide[0].style.marginLeft = "-" + margin + "%";
        count += 1;
    } else {
        slide[0].style.marginLeft = "0%";
        margin = 0;
        count = 1;
    }

    currentInputChecked(count);
    currentInput.checked = true;
}

window.onload = function () { adjustSlides() } 