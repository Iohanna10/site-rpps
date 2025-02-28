$(document).ready(() => {
    // alterar visibilidade do formulário de pesquisa pela lupa no menu-sup
    document.querySelector(".search").addEventListener("click", () => {
        toggleSearch()
    })

    // alterar visibilidade do formulário de pesquisa pelo X do form de pesquisa
    document.querySelector(".close-search").addEventListener("click", () => {
        toggleSearch()
     })

})

function toggleSearch(){
    var srcArea = document.querySelector(".search-area");
    if(srcArea.offsetHeight == "0"){
        // mostar campo de pesquisa
        srcArea.style.height = (document.querySelector('.bg-inf').offsetHeight + document.querySelector('.bg-sup').offsetHeight) + "px";
        // colocar foco no input
        srcArea.querySelector("input#search").focus()
    } else {
        // esconder campo de pesquisa
        srcArea.style.height = "0px";
        // remover foco no input
        srcArea.querySelector("input#search").blur()
    }
}

$('[name=search-form]').keypress(function (e) {
    if(e.key === 'Enter' && e.target.value.length === 0) {
        e.preventDefault();
        toggleSearch();
    }
})