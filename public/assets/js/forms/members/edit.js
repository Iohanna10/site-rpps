allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
var registered = true;

function activeEditMember () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    mask(document.getElementById('tel'), mphone)

    setTimeout(() => {
        tinyMCE.get('certificate').setContent(document.getElementById("certificate").dataset.value)
    }, 1000);

    document.querySelector('#btnChange').addEventListener("click", () =>{
        clear() // limpar erros

        if(verifyErr(getData())){
           ajaxData_memberEdit(getData());
           document.querySelector("#btnChange").innerHTML = "Alterando...";
        }
    })
}

function getData(){
    let inputs = document.querySelectorAll("input, select");
    let textareas = document.querySelectorAll(".form-cad textarea[id]");
    let data = {}; // objeto para armazenar os dados 

    data.institute = getInstitute();

    data.id = document.querySelector('.form-cad').dataset.id;
    data.council = document.querySelector('.form-cad').dataset.council;

    textareas.forEach( textarea => {
        if(tinymce.get(`${textarea.name}`)){
            data[textarea.name] = tinymce.get(`${textarea.name}`).getContent();
        } else {
            data[textarea.name] = textarea.value;
        }
    });

    inputs.forEach(input => {
        if(input.type == 'file'){
            data[input.name] =  input.files;              
        } 
        else {
            data[input.name] = input.value;
        }
    })

    if(isFilled(data.tel)){
        data.tel = data.tel.replace(/[^0-9]/g,'')
    }

    return data;
}

function verifyErr(data){
    if(isFilled(data.img)){
        if(!isImg(data.img[0])){
            errors_edit('img_perfil', 'são permitidas apenas imagens com um tamanho máximo de 5MB');
            return false;
        }
    }

    if (!verifyNameObj(data.name)){
        errors_edit('name', 'são permitidas apenas letras, deve ser composto por nome e sobrenomes e possuir mais que três caracteres');
        return false;
    }
    if(!isFilled(data.name)){
        errors_edit('name', 'preencha este campo')
        return false;
    }

    if(!validaCPF(data.cpf)){
        errors_edit('cpf', 'você deve inserir um CPF válido')
        return false;
    }
    if(!isFilled(data.cpf)){
        errors_edit('cpf', 'preencha este campo')
        return false;
    }

    if(isFilled(data.email) && !verifyEmail(data.email)){
        errors_edit('email', 'insira um email válido')
        return false;
    }

    if(isFilled(data.tel) && !verifyTel(data.tel)){
        errors_edit('tel', 'insira um número para contato válido')
        return false;
    }

    if(isFilled(data['member_position'])){
        data['member_position'] = formatName(data['member_position']);
    }
    else {
        errors_edit('member_position', 'preencha este campo')
        return false;
    }

    if(isFilled(data['member_location'])){
        data['member_location'] = formatName(data['member_location']);
    }

    return true;
}

// mostrar erros

function errors_edit(input, error){
    document.querySelector(`label[for=${input}] span`).innerHTML = ` - <i class='error'>${error}</i>`; // exibir erro 

    const inputFocus = document.getElementById(input);

    if(inputFocus !== null){
        inputFocus.focus();
    } else {
        document.querySelector(`label[for=${input.replace("_error", '')}`).scrollIntoView({ behavior: "smooth" });
    }

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
function ajaxData_memberEdit(data){
    dataImg = data.img;
    data.img = '';

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-member/changeInfos"),
        data: data,
        success: async function (response){
            if(response == true){
                if(dataImg.length){
                    infos = {
                        council: document.querySelector('.form-cad').dataset.council,
                        img: document.getElementById('img').dataset.img,
                        id: data.id
                    };
                
                    response = await ajaxUpFiles_memberEdit(dataImg, infos)
                }
                modalSuccess("Alterações feitas com sucesso.", response);
            } 
            else if(response.msg == 'cpf_error'){
                errors_edit('cpf', 'este CPF já está cadastrado')
            }
            else {
                modalSuccess("Não foi possível realizar as alterações, tente novamente mais tarde.", response.bool);
            }
        
            document.querySelector("#btnChange").innerHTML = "Alterar";
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório
async function ajaxUpFiles_memberEdit(files, infos){
    return new Promise((resolve, reject) => {
        const API_ENDPOINT = getUriRoute(`ajax/ajax-member/uploadfiles/changeInfos?council=${infos.council}&&imgName=${infos.img}&&id=${infos.id}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                setMainImg(infos.id)
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


// entregar dados via ajax para serem gravados no db
function ajaxData_memberEdit(data){
    dataImg = data.img;
    data.img = '';

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-member/changeInfos"),
        data: data,
        success: async function (response){
            if(response == true){
                if(dataImg.length){
                    infos = {
                        council: document.querySelector('.form-cad').dataset.council,
                        img: document.getElementById('img').dataset.img,
                        id: data.id
                    };
                
                    response = await ajaxUpFiles_memberEdit(dataImg, infos)
                }
                modalSuccess("Alterações feitas com sucesso.", response);
            } 
            else if(response.msg == 'cpf_error'){
                errors_edit('cpf', 'este CPF já está cadastrado')
            }
            else {
                modalSuccess("Não foi possível realizar as alterações, tente novamente mais tarde.", response.bool);
            }
        
            document.querySelector("#btnChange").innerHTML = "Alterar";
        }
    })
}

function setMainImg(id) {
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-member/getImg"),
        data: {id: id},
        success: async function (response) {
            document.querySelector('.preview-img-container').dataset.idMedia = response;
        }
    })
}