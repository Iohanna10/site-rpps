function ajaxUpFiles_CRPS(files, title) {
    const API_ENDPOINT = getUriRoute(`ajax/ajax-crp/uploadfiles?title=${title}`);
    const request = new XMLHttpRequest();
    const formData = new FormData();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            // console.log(request.response)
            if(request.response == 'true'){
                refresh_CRPS(true);
            }
            else {
                modal("Não foi possível registrar o CRP, tente novamente.")
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

function ajaxRemove_CRPS(data) {
    data = {
        id_report: data
    }

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-crp/removeCrp"),
        data: data,
        success: function (response) {
            if(response == true){
                refresh_CRPS(false)
            } else {
                modal("Não foi possivel excluir relatório.");
            }
        }
    })
}