$(document).ready(function () {
    var query = location.search.slice(1); // pegar todos os parâmetros
    var parts = query.split('&'); // separar parametros (caso tenha mais de um)
    var data = {}; // criar objeto para receber os dados 
    
    parts.forEach(function (parte) { 
        var keyValue = parte.split('='); // separar chave e valor
        var key = keyValue[0]; // pegar a chave
        var value = keyValue[1]; // pegar valor
        data[key] = value; // add ao objeto 
    });

    ajaxFindKey(data);
})

// entregar dados via ajax para serem gravados no db
function ajaxFindKey(data){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/find-key"),
        data: data,
        success: function (response){  
            if(response[0] !== 'link'){
                document.querySelector("#btnChange").addEventListener("click", () => {
                    
                    var hasErrors = clear() // limpar erros

                    // validar senha
                    if(!verifyPass(document.querySelector("input[id=password]").value))
                        hasErrors = errors(document.querySelector("input[id=password]"), 'utilize todos os caracteres obrigatórios')

                    // enviar dados via ajax
                    if(!hasErrors){
                        ajaxChangePass(response)
                    }
                })
            }
        }
    })
}

function ajaxChangePass(response) {
    data = {
        id: response[0]['id'],
        table: response[1],
        new_pass: document.querySelector("input[id=password]").value
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/change-pass"),
        data: data,
        success: function (response){  
            if(response[0] === "true"){
                modal(response[1], true)
            }
            else {
                modal(response[1], false)
            }
        }
    })
}

function errors(input, error){
    document.querySelector(`label[for=${input.name}] span`).innerHTML = ` - <i class='error'>${error}</i>`;
    return true;
}

// limpar erros
function clear(){
    document.querySelectorAll("label span.error").forEach((span) => {
        span.innerHTML = '';
    });

    return false;
}

function modal(msg, success){
    if(success){
        document.querySelector(".modal-info h1").innerHTML = `<i class="success fa-sharp fa-solid fa-check"></i>`; // sucesso
    } 
    else {
        document.querySelector(".modal-info h1").innerHTML = `<i class="error fa-sharp fa-solid fa-xmark"></i>`; // erro
    }

    document.querySelector(".modal-info p").innerHTML = msg;
    document.querySelector(".modal-info").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'block';
}

$(document).ready(function () {
    document.querySelectorAll("#btnModal, .bg-modal, #btnError").forEach((el) => {
        el.addEventListener("click", () => {
            window.location.replace(getUriRoute(`${getInstitute()}/login`));
            closeModal()
        })
    })
})

function closeModal(){
    document.querySelector(".modal-info").style.display = 'none';
    document.querySelector(".bg-modal").style.display = 'none';
}