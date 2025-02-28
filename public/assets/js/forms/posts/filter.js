$(document).ready(() => {
    document.querySelector("#btnFilters").addEventListener("click", () => {
        selectValuesQuery();
    })
}) 

$(document).ready(() => {
    document.querySelector("#btnRemoveFilters").addEventListener("click", () => {
        document.querySelectorAll("#form-filter input").forEach((el) => {
            el.value = '';
        })

        document.querySelector("#order").selectedIndex = 0;

        selectValuesQuery()
    })
})

function selectValuesQuery() {
    if (document.querySelector(".list-posts").dataset.search != null){
        if(document.querySelector(".page-link.current-pg") != null){
            posts(document.querySelector(".page-link.current-pg").innerHTML, document.querySelector(".list-posts").dataset.search, getFilters())
        } else {
            posts(1, document.querySelector(".list-posts").dataset.search, getFilters())
        }
    }

    else {
        if(document.querySelector(".page-link.current-pg") != null){
            posts(document.querySelector(".page-link.current-pg").innerHTML, document.querySelector(".list-posts").dataset.route_id, getFilters())
        } else {
            posts(1, document.querySelector(".list-posts").dataset.route_id, getFilters())
        }
    }
}

function toggleFilter() {
    document.querySelector(".filters").classList.toggle("active");

    toggleI();
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