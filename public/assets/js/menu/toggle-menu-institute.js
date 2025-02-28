$(document).ready(() => {
    document.querySelectorAll("[data-main-list]").forEach((el) =>{
        el.addEventListener('click', (e) => {
            toggleSubList(el)
        })
    })

    document.querySelector(".toggle-menu").addEventListener('click', () => {
        toggleMenu();
    })

    document.querySelector(".btn-close").addEventListener('click', () => {
        toggleMenu();
    })
})

function toggleSubList(list){
    subList = document.querySelector(`[data-for=${list.dataset.mainList}]`);
    caret = document.querySelector(`[data-main-list=${list.dataset.mainList}] .caret`);
    
    if(!subList.hasClass('active')){
        subList.classList.add("active");
        caret.innerHTML = '<i class="fa-sharp fa-solid fa-caret-down"></i>';
        return
    }
    subList.classList.remove("active");
    caret.innerHTML = '<i class="fa-sharp fa-solid fa-caret-left"></i>';
}

function toggleMenu(){
    menu = document.querySelector(".nav-menu");
    if(!menu.hasClass('active')){
        menu.classList.add("active");
        return
    }
    menu.classList.remove("active");
}

Node.prototype.hasClass = function(value) { // verificar se o elemento possui a classe
    var
        has = true,
        names = String(value).trim().split(/\s+/);

    for(var i = 0, len = names.length; i < len; i++){
        if(!(this.className.search(new RegExp('(?:\\s+|^)' + names[i] + '(?:\\s+|$)', 'i')) > -1)) {
            has = false;
            break;
        }
    }
    return has;
};