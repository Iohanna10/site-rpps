const allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
const allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem

$(document).ready(() => {
    // formatar telefone
    mask(document.querySelector("#tel"), mphone);

    if(document.querySelector("#btn") != null){
        document.querySelector("#btn").addEventListener('click', () => {
            registered = true;
            
            var hasErrors = clear() // limpar erros

            var data = {} // objeto para armazenar os dados 
            var dataImg = {} // objeto para armazenar a foto 
            
            document.querySelectorAll("input, select").forEach((input) => {                    
                // pegar id do instituto 
                data['institute'] = getInstitute();
                // pegar o id do usuário
                data['id'] = document.querySelector("[data-id]").dataset.id;
                
                // verificação img
                if(input.id === "img"){
                    if(isFilled(input.value)){
                        if(!(isImg(input.files[0])))
                            hasErrors = errors(input, 'São permitidas apenas imagens do tipo: jpg, jpeg e png.')
                        else data.imgPerfil = isImg(input.files[0])[0]; dataImg.imgPerfil = isImg(input.files[0])[1]; dataImg.delete = input.dataset.delete;
                    }
                }

                // verificação nome
                if(input.id === "name"){
                    if(!verifyName(input))
                        hasErrors = errors(input, 'São permitidas apenas letras, deve ser composto por nome e sobrenomes e possuir mais que três caracteres')
                    else data.name = formatName(input.value);
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
                    if(isFilled(input.value)){
                        if(!verifyEmail(input))
                            hasErrors = errors(input, 'Email inválido')
                        else data.email = input.value;
                    } else {
                        hasErrors = errors(input, 'Preencha este campo')
                    }
                }

                // validar telefone
                if(input.id === "tel"){
                    if(isFilled(input.value)){
                        if(!verifyTel(input.value))
                            hasErrors = errors(input, 'Telefone inválido')
                        else data.tel = input.value.replace(/[^0-9]/g,'');
                    } else {
                        hasErrors = errors(input, 'Preencha este campo')
                    }
                }

                 // validar senha
                 if(input.id === "pass"){
                    if(isFilled(input.value)){
                        data.pass = input.value;
                    }
                }

                // validar senha
                if(input.id === "new_pass"){
                    if(isFilled(input.value)){
                        if(!verifyPass(input.value))
                            hasErrors = errors(input, 'utilize todos os pré-requisitos da senha!')
                        else data.new_pass = input.value;
                    }
                }
            })

            // enviar dados via ajax
            if(!hasErrors){
                document.querySelector("#btn").innerHTML = "Alterendo...";
                
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
        return [[media.name], [media]];
    } 
    return false
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
    console.log(error, input)
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

// entregar dados via ajax para serem alterados no db
function ajaxData(data, dataImg){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/changeInfos"),
        data: data,
        success: async function (response){  
            if(response.bool){
                vBreak = true;

                // console.log(dataImg.imgPerfil)
                if(dataImg.imgPerfil !== undefined){
                    vBreak = await ajaxUpFiles(dataImg.imgPerfil).then(result => {return result});  
                }
                
                if(vBreak) {
                    modalSuccess('Alterado com sucesso.', vBreak);
                } else {
                    modalSuccess('Erro ao tentar alterar.', vBreak);
                }
            }
            else {
                errorDB(response.msg);
            }
            
            document.querySelector("#btn").innerHTML = "Alterar";
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório 
async function ajaxUpFiles(files){
    idUser = document.querySelector("[data-id]").dataset.id;
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-user/changefiles?id=${idUser}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                setMainImg(idUser)
                resolve(JSON.parse(request.response));
                // console.log(request.response)
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i])
        }
    
        request.send(formData);
    })
}

function setMainImg(id) {
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/getImg"),
        data: {id: id},
        success: async function (response) {
            document.querySelector('.preview-img-container').dataset.idMedia = response;
        }
    })
}

function deleteAccount() {
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-user/deleteAccount"),
        success: async function (response) {
            if(response)
                window.location.href = getUriRoute(`${getInstitute()}/login-logout`);
            else
            modalSuccess('Erro ao tentar excluir.', response);
        }
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
        })
    })
})

function closeModal(){
    document.querySelector(".modal-info").style.display = 'none';
    document.querySelector(".bg-modal").style.display = 'none';
}