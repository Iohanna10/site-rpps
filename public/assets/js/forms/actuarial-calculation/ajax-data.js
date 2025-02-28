function ajaxData_hypotheses(data) {
    data = {
        hypotheses: data.calc_actuarial,
        financial_regimes: data.financial_regimes
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-actuarial/changeHypotheses"),
        data: data,
        success: function (response) {
            if(response == true){
                modal("Alterações salvas com sucesso.");
            } else {
                modal("Não foi possivel salvar as alterações.");
            }
            document.querySelector("#btnChange").innerHTML = 'Alterar';
        }
    })
}

function ajaxUpFiles_reports(files, title) {
    const API_ENDPOINT = getUriRoute(`ajax/ajax-actuarial/uploadfiles?title=${title}`);
    const request = new XMLHttpRequest();
    const formData = new FormData();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            // console.log(request.response)
            if(request.response == 'true'){
                refresh_reports(true);
            }
            else {
                modal("Não foi possível registrar o relatório, tente novamente.")
            }
            document.querySelector("#btnPdf").innerHTML = 'Adicionar';
        }
    };

    // inserir mídias 
    for (let i = 0; i < files.length; i++) {
        formData.append(files[i].name, files[i])
    }

    request.send(formData);
}

function ajaxRemove_reports(data) {
    data = {
        id_report: data
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-actuarial/removeReport"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_reports(false)
            } else {
                modal("Não foi possivel excluir relatório.");
            }
        }
    })
}