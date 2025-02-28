// Sub menus
const toggleMenu = document.querySelectorAll(".toggle");
const subMenu = document.querySelectorAll(".sub-menu");

// Sub menus do subMenu
const toggleMenu2 = document.querySelectorAll(".toggle-2");
const subMenu2 = document.querySelectorAll(".sub-menu-2");

if (window.innerWidth <= 1023){    
    addIdMenu(toggleMenu, subMenu);
    addIdMenu(toggleMenu2, subMenu2);
} else {
    document.querySelectorAll('.main-nav > li').forEach((el) => {
        el.addEventListener('mouseover', () => {
            document.querySelector('.menu-section').style.height = `calc(100vh - ${document.querySelector('.wrapper').offsetHeight}px)`;
            
            if(el.querySelector(".container-sub-menu") !== null){
                el.querySelector(".container-sub-menu").style.height = `calc(100vh - ${document.querySelector(".bg-sup").offsetHeight + document.querySelector(".bg-inf").offsetHeight}px)`
            }
        })
    })

    document.querySelectorAll('.main-nav > li').forEach((el) => {
        el.addEventListener('mouseout', () => {
            document.querySelector('.menu-section').style.height = 'auto'
        })
    })
}

// add id do menu
function addIdMenu(toggle, menu){
    var id = 0;
    toggle.forEach(() => {
        var hash = 'item-' + id;
        menu[id].classList.add(hash)
        toggle[id].classList.add(hash)
        toggle[id].textContent = "+";
        id = id + 1;
    })
}

// toggle do menu
function toggle(num){
    closeUnused(1, subMenu[num])
    subMenu[num].classList.toggle("active")
    toggleMenu[num].classList.toggle("active-toggle")
    textContentChange(toggleMenu[num])
    subMenu[num].parentElement.style.display = 'flex';
}

// toggle do submenu
function toggleSub(num){
    closeUnused(2, subMenu2[num])
    subMenu2[num].classList.toggle("active")
    toggleMenu2[num].classList.toggle("active-toggle-2")
    textContentChange(toggleMenu2[num])
}

// trocar conteúdo do span
function textContentChange(toggle){
    if (toggle.textContent == "+"){
        toggle.textContent = "-";
    } else{
        toggle.textContent = "+";
    }
}

// fechar lista não usada
function closeUnused(menu, num){
    switch(menu) {
        case 1:
            // menu active
            const menuUnused = document.querySelector(".sub-menu.active");
            const toggleActive = document.querySelector(".toggle.active-toggle");
            removeActive(menuUnused, num, toggleActive, 1)
            break;
        case 2:
            // submenu active
            const menuUnused2 = document.querySelector(".sub-menu-2.active");
            const toggleActive2 = document.querySelector(".toggle-2.active-toggle-2");
            removeActive(menuUnused2, num, toggleActive2, 2)
            break;
    }
}

// remover class active
function removeActive(menu, num, toggle, numCase){
    if((menu !== null) && (menu != num)){
        menu.classList.remove("active")
        
        switch(numCase){
            case 1:
                toggle.classList.remove("active-toggle");
                menu.parentElement.style.display = 'none';
                break;
            case 2:
                toggle.classList.remove("active-toggle-2");
                break;
        }
        textContentChange(toggle);
    }
}
