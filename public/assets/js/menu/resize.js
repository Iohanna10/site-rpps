function resize() {
    widthScrollTopMenu();
    if(window.innerWidth >= 1023) {
        heightBGMenu();
    }
    else {
        document.getElementById('home').style.height = '8rem';
    }
}

function repositionSM(el) { // reposicionar SUB MENU 2
    if(window.innerWidth >= 1023) {
        var 
        positionTop = el.offsetTop,
        sm = el.children[1] // sub menu do elemento

        if(positionTop > 0){
            positionTop = positionTop - 2;
        }

        sm.style.top = positionTop + 'px'; // deslocamento do topo
        sm.style.right = '-' + el.offsetWidth + 'px'; // deslocamento a direita
        sm.style.maxHeight = `calc(100vh - ${positionTop}px - ${document.querySelector(".bg-sup").offsetHeight + document.querySelector(".bg-inf").offsetHeight}px)`; // tamanho máximo do container
    }
}

function widthSubMenu(el){
    if(window.innerWidth >= 1023) {
        subMenuWidth = el.querySelector('li').offsetWidth + 14;
        
        if(el.querySelector('.main-item:hover .sub-menu-2') != null){
            subMenuWidth = subMenuWidth + el.querySelector('.main-item:hover .sub-menu-2').offsetWidth;
        }

        el.parentElement.style.width = subMenuWidth + 'px';
    }
}

function heightBGMenu() {    
    var 
    scrollHeight = document.querySelector('.wrapper').getBoundingClientRect().height,
    bgSupHeight = `calc(3.6rem + ${scrollHeight}px)`,
    bgInfHeight = `4.8rem`

    document.querySelector('.bg-sup').style.height = bgSupHeight;
    document.querySelector('.bg-inf').style.top = bgSupHeight;
    document.querySelector('.bg-inf').style.height = `calc(${bgInfHeight})`;
    document.getElementById('home').style.height = `calc(${bgSupHeight} + ${bgInfHeight})`;
}

function widthScrollTopMenu() {
    var controlWrapper = document.querySelector('.wrapper > div');
    controlWrapper.style.width = document.querySelector('.nav-inferior').offsetWidth + 'px';
}

window.addEventListener('resize', function () {
   resize();
});