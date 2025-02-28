function filtersPost() { // adicionar funções
    document.querySelector("#btnFilters").addEventListener("click", () => { // inserir filtros
        listPosts(1, getFilters_post());
    })
    document.getElementById("form-filter").addEventListener("submit",  listPosts(1, getFilters_post()))
    
    document.getElementById("form-filter").addEventListener('keypress', function(event) { 
        if (event.key === 'Enter') {
          event.preventDefault();
        }
    })

    document.querySelector("#btnRemoveFilters").addEventListener("click", () => { // remover filtros da pesquisa
        document.querySelectorAll("#form-filter input").forEach((el) => {
            el.value = '';
        })

        document.querySelectorAll("#form-filter select").forEach((el) => {
            el.options.selectedIndex = 0;
        })

        changeOptions('NULL')
        listPosts(1, getFilters_post());
    })

    document.querySelector(".toggle-filter").addEventListener("click", () => { // abrir/fechar filtros 
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