allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo

function configEditEvents() {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    document.getElementById("btn_change").addEventListener('click', (el) =>{
        el.target.innerHTML = "Alterando...";

        verify = getData_event();
        if(verify !== false){
            ajaxUpdate_event(verify);
        }
        else {
            el.target.innerHTML = "Alterar";
        }
    })

    resetTinyMCE();

    tinymce.init({
        selector: 'textarea.editor-description',
        plugins: 'link wordcount',
        menubar: false,
        toolbar: 'bold | link | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        height: 300,
        resize: true,
        branding: false,
        elementpath: false, 
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false,
    });
}

function getData_event(){
    var inputs = inputsFilter(); // remover inputs de horarios
    var inputsTime = document.querySelectorAll("input[name='time']"); // remover inputs de horarios
    var txtAreas = document.querySelectorAll("textarea");
    var selectsDates = document.querySelectorAll("#different-data select");
    var data = {};
    // ========================== dados do formulário ========================== //

    if (selectsDates.length > 0) {
        data.meetings = arrayMonths(selectsDates, inputsTime);
    }

    data.id = document.getElementById("formMeeting").dataset.id // id
    if(document.getElementById("committee") != null){
        data.committee = document.getElementById("committee").value
    }

    txtAreas.forEach(txtArea => {
        if(tinymce.get(`${txtArea.name}`)){
            data[txtArea.name] = tinymce.get(`${txtArea.name}`).getContent();
        } else {
            data[txtArea.name] = txtArea.value;
        }
    });

    inputs.forEach(input => {
        if (input.type == 'file') {
            data[input.name] = input.files;
        } else {
            data[input.name] = input.value;
        }
    });

    if(data.title == '' || removeSpecialCharacters(data.title.trim()).length < 3 || data.title.length > 255){
        modal("O título não pode ficar em branco e deve conter mais que 3 letras e no máximo 255 caracteres.")
        return false;
    }

    if(removeSpecialCharacters(data.description.trim()).length < 3 || tinymce.activeEditor.plugins.wordcount.body.getCharacterCount() > 350){
        modal("A descrição não pode ficar em branco e deve conter mais que 3 letras e no máximo 350 caracteres.")
        return false;
    }

    if(data.img.length > 0){
        verify = verifyMedias(data.img);
        if(verify.bool == false){
            if(verify.err === 'type')
                modal("São aceitos somente arquivos de imagem para adicionar como imagem principal");
            else
                modal(`A imagem "${verify.files.join(", ")}" excede o tamanho máximo permitido. <br><br> O tamanho máximo para imagens é 5MB.`);
                return false
        }
    }

    if(typeof data.start_meeting != undefined && typeof data.end_meeting != 'undefined'){
        data.start_meeting = `${data.start_meeting} ${data.start_time}:00`;
        data.end_meeting = `${data.end_meeting} ${data.end_time}:00`;
    }

    return data;
}

async function ajaxUpdate_event(data){
    dataEvent = {
        id: data.id, 
        type: getType()
    }
    
    fileMedia = data.img;

    data.img = '';
    
    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-meeting_event/update`),
        data: data,
        success: async function (response){
            if(response && fileMedia.length != 0){ 
                if(await ajaxUpNewFiles_event(fileMedia, dataEvent)){
                    modalSuccess("Alterações feitas com sucesso.", true);
                    updateFuncRemove_event();
                }            
                else {
                    modalSuccess("Não foi possível alterar a imagem principal, tente novamente mais tarde.", false);
                }
            }
            else if(response){
                modalSuccess("Alterações feitas com sucesso.", true);
            }
            else {
                modalSuccess("Não foi possível fazer as alterações, tente novamente mais tarde.", response);
                document.querySelector('.form-cad').dataset.name = data.last_name;
            }

            document.getElementById("btn_change").innerHTML = "Alterar";
        }
    })
}

async function ajaxUpNewFiles_event(files, data){ // uplode das mídias
    return await new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-meeting_event/new-files?id=${data.id}&&type=${data.type}`);
        const request = new XMLHttpRequest();
        const formData = new FormData();
    
        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                resolve(JSON.parse(request.response));
                // console.log(request.responseText)
            }
        };
    
        // inserir mídias 
        for (let i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i])
        }
    
        request.send(formData);
    })
}

function updateFuncRemove_event(){
    data = {
        id: document.getElementById("formMeeting").dataset.id,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-meeting_event/get-featured`),
        data: data,
        success: async function (response){
            if(response.imagem_principal !== null){
                document.getElementById("img").value = '';
                btn = document.getElementById('img_remove')
                btn.style.display = 'flex';
                btn.setAttribute("onclick", `confirmModal("Deseja mesmo excluir a imagem principal?", "ajaxRemove_eventImg", "${response.imagem_principal}")`);
                document.querySelector('.preview-img-container').dataset.idMedia = response.imagem_principal;
            }
        }
    })
}

async function ajaxRemove_eventImg(medias){
    data = {
        medias: medias.split(','),
        id: document.getElementById("formMeeting").dataset.id,
        type: getType()
        
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute(`ajax/ajax-meeting_event/remove-files`),
        data: data,
        success: async function (response){
            if(response.bool){
                modalSuccess("Imagem removida.", response.bool);
                organizePreview(response.type) // arrumar preview
            }
            else {
                modalSuccess("Não foi possível remover a imagem, tente novamente mais tarde.", response.bool);
            }
        }
    })
}

function verifyMedias(medias) { // verificar arquivos se são apenas imagens e vídeos
    files = [];
    wrongMedias = []

    for (var i = 0; i < medias.length; i++) {

        // verificar fotos
        if ((allowedFilesI.includes(getFileExtension(medias[i].name)) && allowedTypesI.includes(getFileExtension(medias[i].type)))) {
            medias[i].name = medias[i].name;
            files.push(medias[i])
        }

        // caso não for
        else {
            return {files: medias[i].name, bool: false, err: 'type'}
        }
    }

    return {files: files, bool: true}
}

function arrayMonths(daysMeeting, hourMeeting) {
    var arr = [];
    indexId = 0;

    daysMeeting.forEach((day) => {
        if(day.value != '' && hourMeeting[indexId].value != ''){
            arr.push(`${new Date().getFullYear()}-${day.dataset.month}-${day.value} ${hourMeeting[indexId].value}:00`);
    
            indexId += 1;
        } else {
            arr = [];
        }
    });

    return arr.join(', ');
}

function inputsFilter() {
    if (document.querySelectorAll("input[name='time']") != undefined) {

        let inputsTimeId = [];
        document.querySelectorAll("input[name='time']").forEach((el) => { inputsTimeId.push(el.id) });

        let inputsId = [];
        document.querySelectorAll(".form-cad input[id]").forEach((el) => { inputsId.push(el.id) })

        filterInputs = [];

        indexId = 0;

        inputsId.forEach((input) => {

            if (!inputsTimeId.includes(input)) {
                filterInputs.push(document.querySelectorAll(".form-cad input[id]")[indexId])
            }

            indexId += 1;
        })

        return filterInputs;
    } else {
        return document.querySelectorAll(".form-cad input[id]");
    }
}

function getType(){
    if(document.getElementById("formMeeting").dataset.type == 'reuniao'){
        return 'meetings';
    }
    return 'events';
}