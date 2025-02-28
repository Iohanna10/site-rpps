function filtersEvents () {
    document.getElementById("form-filter").addEventListener("submit",  listEvents(1, getFilters_events()))

    document.getElementById("form-filter").addEventListener('keypress', function(event) { // remover evento de enviar do formulário
        if (event.key === 'Enter') {
          event.preventDefault();
        }
    })

    document.querySelector("#btnFilters").addEventListener("click", () => { // aplicar filtros
        listEvents(1, getFilters_events());
    })

    document.querySelector("#btnRemoveFilters").addEventListener("click", () => {
        document.querySelectorAll("#form-filter input").forEach((el) => {
            el.value = '';
        })

        document.querySelectorAll("#form-filter select").forEach((el) => {
            el.options.selectedIndex = 0;
        })

        chooseAdvice_event(false);
        listEvents(1, getFilters_events());
    })

    // abrir filtros 
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