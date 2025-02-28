var allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
var allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem

function configInfos() {
    tinymce.init({
        selector: 'textarea.editor',
        plugins: 'lists wordcount',
        toolbar: 'undo redo | bold italic | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        resize: true,
        branding: false,
        elementpath: false,
        entity_encoding: 'row',
        menubar: false,
        height: '300',
        width: '100%',
        license_key: 'gpl',
        promotion: false
    });

    tinymce.init({
        selector: 'textarea.editor-links',
        plugins: 'lists wordcount link table',
        toolbar: 'undo redo | bold italic underline strikethrough | link table | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        resize: true,
        branding: false,
        elementpath: false,
        entity_encoding: 'row',
        menubar: false,
        height: '300',
        width: '100%',
        license_key: 'gpl',
        promotion: false
    });
    
    let selectWDays = [document.querySelector("#start_day"), document.querySelector("#end_day")];
    selectWDays.forEach((el) => {
        days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        html = '';
        for (let index = 0; index < days.length; index++) {
            if (el.dataset.selected === days[index].toLowerCase()) 
                html += `<option value="${days[index].toLowerCase()}" selected>${days[index]}</option>`;
            else  
                html += `<option value="${days[index].toLowerCase()}">${days[index]}</option>`;
        }
        el.innerHTML = html;
    }) 

    let tels = [document.querySelector("#tel"), document.querySelector("#fix_tel")];
    tels.forEach((input) => {
        mask(input, mphone); // mascara de telefone
    })

    mask(document.getElementById("cep"), mCep);

    // pegar informações
    document.querySelector("#btnChange").addEventListener('click', () => {
        clear() // limpar erros

        if(verifyErr_infos(getData_infos())){
            ajaxData_infos(getData_infos());
            document.querySelector("#btnChange").innerHTML = "Alterando...";
        }
    })
}

// verificar se é uma imagem 
function isImg_infos(medias){
    files = [];
    wrongMedias = []

    if(medias.length < 20){
        for (var i = 0; i < medias.length; i++) {
            if ((allowedFilesI.includes(getFileExtension(medias[i].name)) && allowedTypesI.includes(getFileExtension(medias[i].type)))) { // verificar fotos
                medias[i].name = medias[i].name;
                files.push(medias[i])
            }
            else {
                return {files: medias[i].name, bool: false, err: 'type'} // caso não for foto/vídeo
            }
        }
    }
    else {
        return {length: medias.length, bool: false, err: 'length'} // caso ultrapassar 20 uploads por vez
    }

    return {files: files, bool: true}
}

function getData_infos(){
    let inputs = document.querySelectorAll("input, select");
    let textareas = document.querySelectorAll(".form-cad textarea[id]");
    let data = {}; // objeto para armazenar os dados 

    data.institute = getInstitute();

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

    return data;
}

// entregar dados via ajax para serem gravados no db
async function ajaxData_infos(data){
    let dataImg = {img: data.img};
    data.img = "";
    data.more_media = "";
    
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-institute/changeInfos"),
        data: data,
        dataType: 'json',
        success: async function (response){ 
            if(response.bool == true){ 
                var msg = "Alterado com sucesso.";

                if(dataImg.img.length > 0){
                    response.bool = await ajaxUpFiles_infos(dataImg.img, 'own');
                    if(!response.bool)
                        msg = "Erro ao tentar alterar as informações.";
                }

            }
            else if(response.msg[0] !== 'bd'){
                errors(response.msg[0], response.msg[1]);
            }
            
            if(!msg){
                msg = 'Erro ao tentar alterar as informações'
            }
            
            modalSuccess(msg, response.bool); 
            redirect(data);
            
            document.querySelector("#btnChange").innerHTML = "Alterar";
        }
    })
}

// entregar foto via XHTML REQUEST para serem gravados em um diretório 
async function ajaxUpFiles_infos(files, type){
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-institute/upNewFiles?type=${type}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);

        // progress
        dv = document.createElement("div")
        dv.classList.add('modal-info')
        dv.style.display = 'flex';
        dv.style.justifyContent = 'center';
        dv.innerHTML = `<p>Fazendo uploads...</p><p style='display: flex; align-items: center; gap: 10px;'><span class='progress-bar' style='width: 75%; border-radius: 5px; height: 5px; display: block; background: linear-gradient(to right, var(--cor-primaria) 0%, gray 0%);'></span><span class='progress-porcent'>0%</span></p>`
        document.querySelector(".modal-info").insertAdjacentElement('afterend', dv)

        request.upload.onprogress = (e) => {
            progress_carousel((e.loaded / e.total * 100).toFixed(1), dv);
        };

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                dv.remove();
                document.querySelector(".bg-modal").style.display = 'none';
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

// remover mídias da galeria publicação
async function ajaxRemove_infos(logos){
    data = {
        logos: logos.split(','),
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-institute/remove-files`),
        data: data,
        success: async function (response){
            if(response){
                modalSuccess("Logos removidas.", response);
                listLogos();
            }
            else {
                modalSuccess("Houve algum erro, tente novamente mais tarde.", response);
            }
        }
    })
}

async function addLogos(logos){
    if(logos.length > 0){
        var data = {
            new_medias: isImg_infos(logos)
        };
    
        if(data.new_medias.bool === true){
            if(await ajaxUpFiles_infos(data.new_medias.files, 'partners')){
                modalSuccess("Novas logos adicionadas.", true);
                listLogos();
            }
            else {
                modalSuccess("Não foi possível adicionar novas logos, tente novamente mais tarde.", false);
            }
        }
    
        else {
            if(data.new_medias.err === 'type')
                modal("São aceitas somente imagens");
            else if(data.new_medias.err === 'length') {
                modal(`Foram selecionados ${data.new_medias.length} arquivos e são permitidos no máximo 20 uploads por vez.`)
            }
        }
    }
}

function activeBtns() { // ativar botões de adicionar/remover logos
    document.getElementById("more_media").addEventListener("change", async (el) => {
        addLogos(el.target.files)
    })

    document.getElementById("remove_all").addEventListener('click', () =>{ // remover todas as mídias ao carrossel
        mediasRemove = [];

        document.querySelectorAll(".reports-list tr").forEach(el => {
            if(el.id !== ''){
                mediasRemove.push(el.id)
            }
        })

        if(mediasRemove.length > 0){
            confirmModal("Tem certeza que deseja excluir todas as logos?", `ajaxRemove_infos`, mediasRemove);
        }
        else {
            modal("Não há mídias para serem removidas.")
        }

    })
}

function verifyErr_infos(data){

    if(isFilled(data.new_pass)){ // senha
        if(data.pass.length === 0){
            errors('pass', 'você deve inserir a senha atual para poder trocar-lá');
            return false;
        } 
        else if(!verifyPass(data.new_pass)) {
            errors('new_pass', 'utilize todos os caracteres obrigatórios');
            return false;
        }
    }

    if(isFilled(data.img)){
        if(!isImg_infos(data.img).bool){
            errors('img_error', 'são permitidas apenas imagens');
            return false;
        } 
    }

    if(!isFilled(data.name)){
        errors('name', 'este campo deve estar preenchido');
        return false;
    }

    if(!verifyNameInstitute(data.name)){
        errors('name', 'são permitidas apenas letras');
        return false;
    }

    if(!isFilled(data.email)){
        errors('email', 'este campo deve estar preenchido');
        return false;
    } 
    else if(!verifyEmail(data.email)){
        errors('email', 'insira um email válido');
        return false;
    }

    if(!isFilled(data.tel)){
        errors('tel', 'este campo deve estar preenchido')
        return false;
    }
    else if (!verifyTel_edit(data.tel, 11)){
        errors('tel', 'insira um Nº de celular válido');
        return false;
    }

    if (!verifyTel_edit(data.fix_tel, 10)){
        errors('fix_tel', 'insira um Nº de telefone válido');
        return false;
    }
    
    if(!isFilled(data.about)){
        errors('about', 'o campo "sobre" deve estar preenchido');
        document.getElementById('government_portal').scrollIntoView({
            behavior: 'smooth'
        });
        return false;
    }

    if(!isFilled(data.cep)){
        errors('cep', 'insira um CEP')
        return false;
    }
    
    if(!isFilled(data.street)){
        errors('street', 'insira uma rua')
        return false;
    }

    if(!isFilled(data.num)){
        errors('num', 'insira um número')
        return false;
    }
    
    if(!isFilled(data.neighborhood)){
        errors('neighborhood', 'insira um bairro')
        return false;
    }
    
    if(!isFilled(data.city)){
        errors('city', 'insira uma cidade')
        return false;
    }
    
    return true;
}

function errors(input, error){
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
}

// verificar se está preenchido
function isFilled(input){
    if(input.length > 0)
        return true
    else return false
}

function redirect(data) {
    if(data.name.toLowerCase() !== getInstitute()){
        window.location.href = getUriRoute(`${data.name.toLowerCase()}/configuracoes-instituto`);
    }
}

function verifyEmail(email) {
    user = email.substring(0, email.indexOf("@"));
    domain = email.substring(email.indexOf("@") + 1, email.length);

    if ((user.length >= 1) &&
        (domain.length >= 3) &&
        (user.search("@") == -1) &&
        (domain.search("@") == -1) &&
        (user.search(" ") == -1) &&
        (domain.search(" ") == -1) &&
        (domain.search(".") != -1) &&
        (domain.indexOf(".") >= 1) &&
        (domain.lastIndexOf(".") < domain.length - 1)) {
        return true
    }
    else {
        return false
    }
}

function verifyTel_edit(tel, nLength) { // verificar se tem no min 10 dígitos e no max 11
    tel = tel.replace(/[^0-9]/g, '')

    if ((tel.length === nLength) || (tel.length === 0))
        return true
    return false
}

function progress_carousel(porcent, dv){
    document.querySelector(".bg-modal").style.display = 'flex';
    dv.querySelector(".progress-porcent").innerHTML = `${porcent}%`;
    dv.querySelector(".progress-bar").style.background = `linear-gradient(to right, var(--cor-primaria) ${porcent}%, gray 0%)`;

    if(porcent == 100){
        dv.innerHTML = "<p>Adicionando pré-visualizações...</p>";
    }
}