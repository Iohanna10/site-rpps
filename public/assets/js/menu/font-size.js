const btnIncreaseFont = document.querySelectorAll(".increase-font");
const btnDecreaseFont = document.querySelectorAll(".decrease-font");
let resizeTimeout;

if (!window.ResizeObserver) {
    const script = document.createElement('script');
    script.src = "https://unpkg.com/resize-observer-polyfill@1.5.1/dist/ResizeObserver.global.js";
    document.head.appendChild(script);
}

$('document').ready(() => {
    if(localStorage.getItem('font-accessibility') !== null){
        resizeFont(localStorage.getItem('font-accessibility'));
    }
    else {
        resizeFont();
    }
})

function resizeFont(fSize = 62.5){
    document.getElementById("html").style.fontSize = parseFloat(fSize) + '%';

    if(fSize >= 80)
        document.querySelector("body").style.wordBreak = "break-word";
    else
        document.querySelector("body").style.wordBreak = "normal";

    observer.observe(document.getElementById("html"))
}

const observer = new ResizeObserver(() => {
    clearTimeout(resizeTimeout); // limpar timeout
 
    resizeTimeout = setTimeout(() => { // adicionar um timeout para executar a função
        resize();
    }, 200);  
});

btnIncreaseFont.forEach((el) => { // Incrementar tamanho da fonte
    el.addEventListener("click", () => {
        localStorage.setItem('font-accessibility', parseFloat(document.getElementById("html").style.fontSize) + 1);
        resizeFont(localStorage.getItem('font-accessibility'))
    })
})

btnDecreaseFont.forEach((el) => { // Decrementar tamanho da fonte
    el.addEventListener("click", () => {
        localStorage.setItem('font-accessibility', parseFloat(document.getElementById("html").style.fontSize) - 1);
        resizeFont(localStorage.getItem('font-accessibility'))
    })
})