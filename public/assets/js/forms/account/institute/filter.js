function filtersThemes() {
    document.querySelector("#btnFilters").addEventListener("click", () => {
        getListsThemes();
    })

    document.getElementById("form-filter").addEventListener("submit",  () => {
        getListsThemes();
    })

    document.getElementById("form-filter").addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
          event.preventDefault();
        }
    })

    document.querySelector("#btnRemoveFilters").addEventListener("click", () => {
        document.querySelectorAll("#form-filter input").forEach((el) => {
            el.value = '';
        })
    
        getListsThemes();
    })

    document.querySelector(".toggle-filter").addEventListener("click", () => {
        document.querySelector(".filters").classList.toggle("active");
        toggleI();
    })
}

function toggleI() {
    document.querySelector(".toggle-filter i").removeAttribute("class");

    if(document.querySelector(".filters").hasClass('active')){
        document.querySelector(".toggle-filter i").setAttribute("class", "fa-sharp fa-solid fa-arrow-up");
    } 
    else {
        document.querySelector(".toggle-filter i").setAttribute("class", "fa-sharp fa-solid fa-arrow-down");
    }
}

function getListsThemes() {
    listUserThemes(1, getFilters_themes());
    listPresetThemes(1, getFilters_themes());
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