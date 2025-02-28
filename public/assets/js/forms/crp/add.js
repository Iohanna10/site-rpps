function configCRPS() {
    document.querySelector("#btnPdf").addEventListener('click', () => { // upar relatórios
        var crp = document.querySelector("#pdf").files;
        var title = document.querySelector("#title").value;

        if(crp.length != 0 && title.length > 3){
            ajaxUpFiles_CRPS(crp, title)
            document.querySelector("#btnPdf").innerHTML = 'Adicionando...';
        } else {
            modal("Selecione um arquivo e digite um título para poder adicioná-lo.")
        }
    })
}

function refresh_CRPS(clearInput) {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listCrps(parseInt(document.querySelector(".page-link.current-pg").innerHTML))
    } else {
        listCrps(1)
    }

    if(clearInput){
        document.querySelector("#pdf").files = (new DataTransfer()).files; // remover arquivos do input
        document.querySelector(".name-pdf").innerHTML = "Clique aqui para adicionar um PDF:";
        document.querySelector("input#title").value = '';
    }
}