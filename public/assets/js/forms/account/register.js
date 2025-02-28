const allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
const allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
var registered = true;

$(document).ready(() => {
    if(document.querySelector("#btnCad") != null){
        document.querySelector("#btnCad").addEventListener('click', () => {
            registered = true;
            
            var hasErrors = clear() // limpar erros

            var data = {} // objeto para armazenar os dados 
            var dataImg = {} // objeto para armazenar a foto 
            
            document.querySelectorAll("input, select").forEach((input) => {
                // verificar se os inputs estão preenchidos
                if(isFilled(input.value)){
                    // pegar id do instituto 
                    data['institute'] = getInstitute();
                    
                    // verificação img
                    if(input.id === "img"){
                        if(!(isImg(input.files[0])))
                            hasErrors = errors(input, 'Aceita somente imagens de extensões png, jpg e jpeg')
                        else data.imgPerfil = isImg(input.files[0])[0]; dataImg.imgPerfil = isImg(input.files[0])[1]
                    }

                    // verificação nome
                    if(input.id === "name"){
                        if(!verifyName(input))
                            hasErrors = errors(input, 'São permitidas apenas letras, deve ser composto por nome e sobrenomes e possuir mais que três caracteres')
                        else data.name = formatName(input.value);
                    } 

                    // validar cpf
                    if(input.id === "cpf"){
                        if(!validaCPF(input.value))
                            hasErrors = errors(input, 'CPF inválido')
                        else data.cpf = input.value;
                    }

                    // pegar dia
                    if(input.id == "day")
                    data.birthday_day = input.value;

                    // pegar mês
                    if(input.id == "month")
                        data.birthday_month = input.value;

                    // pegar ano (talvez verificar se é maior de idade)
                    if(input.id == "year")
                        data.birthday_year = input.value;

                    // validar email
                    if(input.id === "email"){
                        if(!verifyEmail(input))
                            hasErrors = errors(input, 'Email inválido')
                        else data.email = input.value;
                    }

                    // validar telefone
                     if(input.id === "tel"){
                        if(!verifyTel(input.value))
                            hasErrors = errors(input, 'Telefone inválido')
                        else data.tel = input.value.replace(/[^0-9]/g,'');
                    }

                    // validar senha
                    if(input.id === "password"){
                        if(!verifyPass(input.value))
                            hasErrors = errors(input, 'a senha deve conter no mínimo 8 caracteres, um número e uma letra maiúscula')
                        else data.pass = input.value;
                    }

                } else if(input) {
                    hasErrors = errors(input, 'necessário')
                }
            })
            // enviar dados via ajax
            if(!hasErrors){
                document.querySelector("#btnCad").innerHTML = "Cadastrando...";
                ajaxData(data, dataImg)
            }
        })
    }
})

// verificar se o campo está preenchido
function isFilled(content){
    if(content.length > 0)
        return true
    else return false
}

// verificar se é uma imagem 
function isImg(media){
    if((allowedFilesI.includes(getFileExtension(media.name)) && allowedTypesI.includes(getFileExtension(media.type)))){
        dataImg = [];
    
        dataImg.push([media.name])
        dataImg.push([media])

        return dataImg;
    }
}

// erro ao tentar cadastrar
function errorDB(errDB){
    errDB.forEach(error => {
        errors(document.querySelector(`input#${error[0]}`), error[1])
        registered = false;
    });
}

// mostrar erros
function errors(input, error){
    if(input.id === "img")
        document.querySelector(`label[for=${input.name}] span.error`).innerHTML = `<i class='error'>${error}</i>`;
    else
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

// entregar dados via ajax para serem gravados no db
function ajaxData(data, dataImg){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/register"),
        data: data,
        success: async function (response){  
            if(response.bool == true){
                await ajaxUpFiles(dataImg.imgPerfil);
                modalSuccess("Enviamos um email de confirmação de cadastro, verifique tanto sua caixa de entrada quanto de spam.", true);
                clearAll()
            }
            else {
                errorDB(response.msg);
            }

            document.querySelector("#btnCad").innerHTML = "Cadastrar";
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório 
async function ajaxUpFiles(files){
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-user/uploadfiles?institute=${getInstitute()}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                resolve(JSON.parse(request.response));
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i])
        }
    
        request.send(formData);
    })
}

function modal(msg){
    document.querySelector(".modal-info p").innerHTML = msg;
    document.querySelector(".modal-info").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'block';
}

$(document).ready(function () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
            window.location.replace(getUriRoute(`${getInstitute()}/login`));
        })
    })
})

function closeModal(){
    document.querySelector(".modal-info").style.display = 'none';
    document.querySelector(".bg-modal").style.display = 'none';
}
