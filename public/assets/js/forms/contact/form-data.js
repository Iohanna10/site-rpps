$(document).ready(() => {
    document.querySelector("#btnContact").addEventListener("click", () => {
        checksContact();
    })
})

// tem erros?
var err = false;

function checksContact(){
    data = {}; // array dados

    spanErrorClear(); // limpar erros

    data.institute = getInstitute();

    document.querySelectorAll(".form-contact input, .form-contact textarea").forEach(input => {
        if(isFilled(input.value)){
            // nome
            if(input.id == "name"){
                if(!verifyName(input)){
                    spanError(input)
                } else data.name = formatName(input.value);
            }

            // email 
            else if(input.id == "email"){
                if(!verifyEmail(input)){
                    spanError(input)
                } else data.email = input.value;
            }

            // telefone 
            else if(input.id == "tel"){
                if(!verifyTel(input.value)){
                    spanError(input)
                } else data.tel = input.value.replace(/[^0-9]/g,'');
            }

            // cnpj 
            else if(input.id == "cnpj"){
                if(!validaCNPJ(input.value)){
                    spanError(input)
                } else data.cnpj = input.value.replace(/[^0-9]/g,'');
            }

            // empresa 
            else if(input.id == "company"){
                data.company = formatName(input.value);
            }

            // endereço
            else if(input.id == "address") {
                data.address = formatName(input.value);
            }

            // cidade
            else if(input.id == "city") {
                data.city = formatName(input.value);
            }

            // Estado
            else if(input.id == "state") {
                data.state = formatName(input.value);
            } 
            
            else if(input.id == "subject") {
                data.subject = input.value;
            }
             
            else if(input.id == "message") {
                data.message = input.value;
            }
            
        } else spanError(input)
    }) 

    if(err == false){
        document.getElementById('btnContact').innerHTML = "Enviando...";
        ajaxContact(data)
    }
}

// entregar dados via ajax para serem gravados no db
function ajaxContact(data){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/contact"),
        data: data,
        success: function (response){  
            document.getElementById('btnContact').innerHTML = "Enviar";
            modal(response);
            clearAll();
        }
    })
}

function spanError(input) {
    input.style.border = '2px solid #ed3b2e';

    if(input.type != 'textarea'){
        document.querySelector(`input[id=${input.id}] ~ span.error`).style.display = "flex";
    } else document.querySelector(`textarea[id=${input.id}] ~ span.error`).style.display = "flex";

    err = true;
}

function spanErrorClear(){
    document.querySelectorAll("span.error").forEach((span) => {
        span.style.display = "none";
        err = false;
    })

    document.querySelectorAll(".form-contact input, .form-contact textarea").forEach(input => {
        input.style.border = "0px solid transparent";
    });
}