allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
allowedTypesI = ["image/png", "image/jpg", "image/jpeg"]; // tipos permitidos: imagem
allowedTypesV = ["video/mp4", "video/x-ms-asf", "video/mpeg", "video/webm", "video/ogg", "video/quicktime", "video/mpeg", "video/x-m4v", "video/x-msvideo"]; // tipos permitidos: vídeo

var error = {};
var wrongImgs = [];
var wrongVideos = [];
var wrongPdfs = [];

function cadEvent(){
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
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
    
    btnSubmit = document.querySelector("#btnCad");
    btnSubmit.addEventListener('click', () => {
    
        var inputs = inputsFilter(); // remover inputs de horarios
        var inputsTime = document.querySelectorAll("input[name='time']"); // remover inputs de horarios
        var selects = document.querySelectorAll("#type select");
        var txtAreas = document.querySelectorAll("textarea");
        var selectsDates = document.querySelectorAll("#different-data select");
    
        clearErrors(); // limpar eeros do formulário
        var data = {};
    
        // =================== instituto e categoria de postagem ==================== //
    
        data['institute'] = getInstitute();
    
        // ========================================================================= //
    
        // ========================== dados do formulário ========================== //
    
        if (selectsDates.length > 0) {
            data.meetings = arrayMonths(selectsDates, inputsTime);
        }
    
        // pegar valores do formulario de reunião (eventos funcionando já) para depois criar as tabelas e gravar no db
    
        txtAreas.forEach(txtArea => {
            if(tinymce.get(`${txtArea.name}`)){
                data[txtArea.name] = tinymce.get(`${txtArea.name}`).getContent();
            } else {
                data[txtArea.name] = txtArea.value;
            }
        });
    
        selects.forEach(select => {
            data[select.name] = select.value;
        });
    
        inputs.forEach(input => {
            if (input.type == 'file') {
                data[input.name] = input.files;
            } else {
                data[input.name] = input.value;
            }
        });
    
        // ========================================================================= //
        if (verifyData(data) != false) {
            
            var dataDB = verifyData(data)[0];
            var dataUpFiles = verifyData(data)[1];
    
            document.querySelector("button#btnCad").innerHTML = "Enviando...";
    
            ajaxData_event(dataDB, dataUpFiles);
        }
    })
}

function ajaxData_event(data, dataUpFiles) {
    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-meeting_event/insertData"),
        data: data,
        success: async function (response) {
            
            if(response){

                vBreak = true;
                
                for (var prop in dataUpFiles) {

                    if(!vBreak){
                        break
                    }
        
                    vBreak =  await ajaxUpFiles_events(dataUpFiles[prop], data.type_post).then(result => {return result});
                }   
                
                if(vBreak) {
                    modalSuccess('Registrado com sucesso.', vBreak);
                    clearAll();
                } else {
                    modalSuccess('Erro ao tentar registrar.', vBreak);
                }

                document.querySelector("button#btnCad").innerHTML = "Enviar";
            }
        }
    })
}

async function ajaxUpFiles_events(files, type) {
    return new Promise((resolve, reject) => {

        const API_ENDPOINT = getUriRoute(`ajax/ajax-meeting_event/uploadfiles?type=${type}`);
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

// array de meses
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

    return arr.join(", ");
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