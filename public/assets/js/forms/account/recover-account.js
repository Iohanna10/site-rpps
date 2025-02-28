$(document).ready(function () {
    // pegar dados para tratamento
    if(document.querySelector("#btnRecover") != null){
        document.querySelector("#btnRecover").addEventListener("click", () => {

            var hasErrors = clear() // limpar erros

            var data = {
                institute: getInstitute(),
            };
    
            // verificar se está preenchido
            if(isFilled(document.querySelector("input#email").value)){

                // validar campo email
                if(!verifyEmail(document.querySelector("input#email")))
                    hasErrors = errors(document.querySelector("input#email"), 'Email inválido')
                else data.email = document.querySelector("input#email").value;

            } else hasErrors = errors(document.querySelector("input#email"), 'necessário')
            

            // enviar dados via ajax
            if(!hasErrors){
                ajaxRecover(data)
            }
        })
    }
})

// entregar dados via ajax para serem gravados no db
function ajaxRecover(data){
    // status do cadastro
    document.querySelector("#btnRecover").innerHTML = "Enviando...";

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/recover"),
        data: data,
        success: function (response){ 
            if(response[0] === 'instructions'){
                modal(response)
            } else{
                errors(document.querySelector(`input#${response[0]}`), response[1])
            }
            document.querySelector("#btnRecover").innerHTML = "Continuar";
        }
    })
}

function modal(data){
    document.querySelector(".modal-info p").innerHTML = data[1];
    document.querySelector(".modal-info").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'block';
}

$(document).ready(function () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
            window.location.href = getUriRoute(`${getInstitute()}/login`);
        })
    })
})

function closeModal(){
    document.querySelector(".modal-info").style.display = 'none';
    document.querySelector(".bg-modal").style.display = 'none';
}

// verificar se o campo está preenchido
function isFilled(content){
    if(content.length > 0)
        return true
    else return false
}

// mostrar erros
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