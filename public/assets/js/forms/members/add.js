allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
var registered = true;

function cadMembers() {

    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })
    
    tinymce.init({
        selector: 'textarea.editor-c',
        plugins: 'link',
        menubar: false,
        toolbar: 'bold | link | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        height: 200,
        resize: true,
        branding: false,
        elementpath: false, 
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false
    });

    document.querySelector('#submit').addEventListener("click", () =>{
        checksData();
    })
}

function checksData(){
    registered = true;

    var data = {} // objeto para armazenar os dados 
    var dataImg = {} // objeto para armazenar a foto 

    var hasErrors = clearErr() // limpar erros
    
    document.querySelectorAll("input, select").forEach(input => {
        data.institute = getInstitute();

        if(isFilled(input.value)){

            // verificação img
            if(input.id === "img"){
                if(!(isImg(input.files[0])))
                    hasErrors = errors_register(input, 'Somente imagens')
                else data.imgPerfil = isImg(input.files[0])[0]; dataImg.imgPerfil = isImg(input.files[0])[1]
            }
           
            // nome
            if(input.id == "name"){
                if(!verifyName(input))
                    hasErrors = errors_register(input, 'São permitidas apenas letras, deve ser composto por nome e sobrenomes e possuir mais que três caracteres')
                else data.name = formatName(input.value);
            }

            // validar cpf
            if(input.id === "cpf"){
                if(!validaCPF(input.value))
                    hasErrors = errors_register(input, 'CPF inválido')
                else data.cpf = input.value;
            }

            // validar email
            if(input.id === "email"){
                if(!verifyEmail(input.value))
                    hasErrors = errors_register(input, 'Email inválido')
                else data.email = input.value;
            }

            // validar telefone
            if(input.id === "tel"){
                if(!verifyTel(input.value))
                    hasErrors = errors_register(input, 'Telefone inválido')
                else data.tel = input.value.replace(/[^0-9]/g,'');
            }

            // área de atuação
            if(input.id == "member_position") {
                data.member_position = formatName(input.value);
            }

            // local em que atua
            if(input.id == "member_location") {
                data.member_location = formatName(input.value);
            }

            // conselho
            if(input.id == "council") {
                data.council = input.value;
                dataImg.council = input.value;
            }

            // é titular?
            if(input.id == "holder") {
                data.holder = input.value;
            }
            
        } else if (input.id != 'tel' && input.id != 'email' && input.id != 'member_location'){
            hasErrors = errors_register(input, 'necessário')
        }
        
    })

    document.querySelectorAll("textarea").forEach(textarea => {
        // certificado
        if(textarea.name == "certificate") {
            data.certification = tinymce.get(`${textarea.id}`).getContent();
        }
    })

    if(hasErrors == false){
        ajaxData_members(data, dataImg)  
        document.querySelector("#submit").innerHTML = "Cadastrando...";
    }
}

// mostrar erros
function errors_register(input, error){
    document.querySelector(`label[for=${input.id}] span.error`).innerHTML = `<i class='error'> ${error}</i>`;
    
    if(document.querySelector(`#${input.id}`) !== null){
        document.querySelector(`#${input.id}`).focus();
        document.querySelector(`label[for=${input.id}`).scrollIntoView({ behavior: "smooth" });
    }

    return true;
}

function errorDB(errDB){
    errDB.forEach(error => {
        errors_register(document.querySelector(`input#${error[0]}`), error[1])
        registered = false;
    });
}

// limpar erros
function clearErr(){
    document.querySelectorAll("label span.error").forEach((span) => {
        span.innerHTML = '';
    });

    return false;
}

// entregar dados via ajax para serem gravados no db
function ajaxData_members(data, dataImg){
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-member/register"),
        data: data,
        success: async function (response){
            if(response.bool == true){
                await ajaxUpFiles_members(dataImg.imgPerfil, dataImg.council);
                modalSuccess(response.msg, response.bool)
                clearAll()
            }
            else {
                errorDB(response.msg);
            }

            document.querySelector("#submit").innerHTML = "Cadastrar";
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório
async function ajaxUpFiles_members(files, council){
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-member/uploadfiles?council=${council}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
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