function configReports (){
    tinymce.init({
        selector: 'textarea.editor',
        plugins: 'lists wordcount',
        toolbar: 'undo redo | bold italic underline strikethrough | numlist bullist | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        resize: true,
        branding: false,
        elementpath: false,
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false,
        menubar: false,

    });

    document.querySelector("#btnChange").addEventListener('click', () => { // alterar hipóteses do cálculo atuarial
        data = {
            calc_actuarial: tinymce.get(`hypotheses`).getContent(),
            financial_regimes: tinymce.get(`financial_regimes`).getContent()
        }
        
        ajaxData_hypotheses(data)
        document.querySelector("#btnChange").innerHTML = 'Alterando...';
    })

    document.querySelector("#btnPdf").addEventListener('click', () => { // upar relatórios
        var report = document.querySelector("#pdf").files;
        var title = document.querySelector("#title").value;

        if(report.length != 0 && title.length > 3){
            ajaxUpFiles_reports(report, title)
            document.querySelector("#btnPdf").innerHTML = 'Adicionando...';
        } else {
            modal("Selecione um arquivo e digite um título para poder adicioná-lo.")
        }
    })
}

function refresh_reports(clearInput) {
    if(document.querySelector(".page-link.current-pg") != undefined){
        listReports(parseInt(document.querySelector(".page-link.current-pg").innerHTML))
    } else {
        listReports(1)
    }

    if(clearInput){
        document.querySelector("#pdf").files = (new DataTransfer()).files; // remover arquivos do input
        document.querySelector(".name-pdf").innerHTML = "Clique aqui para adicionar um PDF:";
        document.querySelector("input#title").value = '';
    }

}

function clearUrl(url) {
    // Criando um objeto URL a partir da URL fornecida
    const urlObj = new URL(url);
    // Removendo os parâmetros de pesquisa da URL
    urlObj.search = '';
    // retornando URL
    return urlObj.href;
}