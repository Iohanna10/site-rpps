// menu lateral
const lateralMenu = document.querySelector(".container-menu");
// botão abrir menu
const btnMenu = document.querySelector(".menu-hamburger");
// botão fechar menu
const btnLateralMenu = document.querySelector(".close-menu div");
// corpo do html
const body = document.querySelector("body");
// corpo do html
const bgToggle = document.querySelector(".bg-toggle-menu");

// fechar e abrir menu com animação
function displayMenu() {
    // abre/fecha menu
    lateralMenu.classList.toggle("lateral-menu-on");
    lateralMenu.classList.toggle("lateral-menu-off");

    // remove display none
    lateralMenu.classList.remove("initial-menu");
}

function bodySlideOn() {
    // posição do body enqunto o menu estiver aberto
    body.classList.add("body-toggle-on");
    body.classList.remove("body-toggle-off");
    bgToggle.style.display = "block";
}

function bodySlideOff() {
    // posição do body enqunto o menu estiver fechado
    body.classList.remove("body-toggle-on");
    body.classList.add("body-toggle-off");
    bgToggle.style.display = "none";
}

// abrir menu lateral
btnMenu.addEventListener("click", () => {
    displayMenu();
    bodySlideOn();
});

// fechar menu lateral
[bgToggle, btnLateralMenu].forEach((el) => {
    el.addEventListener("click", () => {
        displayMenu();
        bodySlideOff();

        if(document.querySelector('.active-toggle') != null){
            document.querySelector('.active-toggle').parentElement.onclick();
        }
    });    
});