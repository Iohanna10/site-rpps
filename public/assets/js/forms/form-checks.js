// verificar se o campo está preenchido
function isFilled(content) {
    if (content.length > 0){
        return true;
    }
    else return false;
}

// pontuação do input cpf
function mascara(e) {
    x = e.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})/);
    e.value = !x[2] ? x[1] : x[1] + '.' + x[2] + (x[3] ? '.' : '') + x[3] + (x[4] ? '-' + x[4] : '');
}

function validaCPF(cpf) {
    var Soma = 0
    var Resto

    var strCPF = String(cpf).replace(/[^\d]/g, '')

    if (strCPF.length !== 11)
        return false

    if ([
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
    ].indexOf(strCPF) !== -1)
        return false

    for (i = 1; i <= 9; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);

    Resto = (Soma * 10) % 11

    if ((Resto == 10) || (Resto == 11))
        Resto = 0

    if (Resto != parseInt(strCPF.substring(9, 10)))
        return false

    Soma = 0

    for (i = 1; i <= 10; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i)

    Resto = (Soma * 10) % 11

    if ((Resto == 10) || (Resto == 11))
        Resto = 0

    if (Resto != parseInt(strCPF.substring(10, 11)))
        return false

    return true
}

// validar CNPJ 
function validaCNPJ(cnpj) {
    var b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
    var c = String(cnpj).replace(/[^\d]/g, '')

    if (c.length !== 14)
        return false

    if (/0{14}/.test(c))
        return false

    for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
    if (c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false

    for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
    if (c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false

    return true
}

// mascara CNPJ
function mCNPJ(v) {
    v = v.replace(/\D/g, "")

    v = v.substring(0, 14); // limita em 14 números
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")
    v = v.replace(/(\d{4})(\d)/, "$1-$2")

    return v;
}

// mascara CEP
function mCep(value) {
    if (!value) return "";
    value = value.replace(/\D/g,'');
    value = value.replace(/(\d{5})(\d)/,'$1-$2');
    return value;
}

// validações de nome e formatação
function verifyName(input) {
    var filter_name = /^[A-ZÀ-Ÿ][A-zÀ-ÿ']+\s([A-zÀ-ÿ']\s?)*[A-zÀ-ÿ][A-zÀ-ÿ']+$/;
    if (!filter_name.test(input.value.trim())) {
        return false;
    }
    return true;
}

function verifyNameInstitute(str) {
    var filter_name = /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/;
    if (!filter_name.test(str)) {
        return false;
    }
    return true;
}

function verifyNameObj(content) {
    var filter_name = /\b[A-Za-zÀ-ú][A-Za-zÀ-ú]+,?\s[A-Za-zÀ-ú][A-Za-zÀ-ú]{2,19}\b/gi;
    if (!filter_name.test(content)) {
        return false;
    }
    return true;
}

function formatName(name) {
    name = name.toLowerCase().replace(/(?:^|\s)\S/g, function (capitalize) { return capitalize.toUpperCase(); });

    var PreposUpper = [" Da ", " Do ", " De ", " Das ", " Dos ", " A ", " E ", " Na ", " No ", " Nas ", " Nos "];
    var prepos = [" da ", " do ", " de ", " das ", " dos ", " a ", " e ", " na ", " no ", " nas ", " nos "];

    for (var i = PreposUpper.length - 1; i >= 0; i--) {
        name = name.replace(RegExp("\\b" + PreposUpper[i].replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + "\\b", "g"), prepos[i]);
    }

    return name.trim();
}

// verificar se é uma imagem 
function isImg(media) {

    if ((allowedFilesI.includes(getFileExtension(media.name)) && allowedTypesI.includes(getFileExtension(media.type)))) {
        dataImg = [];

        dataImg.push([media.name])
        dataImg.push([media])

        return dataImg;
    }
    return false
}

// validar email
function verifyEmail(field) {
    user = field.value.substring(0, field.value.indexOf("@"));
    domain = field.value.substring(field.value.indexOf("@") + 1, field.value.length);

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

function verifyEmailObj(field) {
    user = field.substring(0, field.indexOf("@"));
    domain = field.substring(field.indexOf("@") + 1, field.length);

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

// validar telefone 

function verifyTel(tel) { // verificar se tem no min 8 dígitos e no max 9
    tel = tel.replace(/[^0-9]/g, '')

    if ((tel.length == 10) || (tel.length == 11))
        return true
    return false
}

function mask(o, f) {
    setTimeout(function () {
        var v = f(o.value);
        if (v != o.value) {
            o.value = v;
        }
    }, 1);
}

function mphone(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if(r.length !== 0){
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
    }
    return r;
}

// visualizar ou não a senha
$(document).ready(() => {
    if (document.querySelector("label[for=password] > .view-pass") != null) {
        document.querySelector("label[for=password] > .view-pass").addEventListener("click", () => {
            if (document.querySelector("input#password").type == "password") {
                document.querySelector("input#password").type = "text"
                document.querySelector("label[for=password] > .view-pass").innerHTML = '<i class="fa-regular fa-eye-slash" title="ocultar senha"></i>'
            } else {
                document.querySelector("input#password").type = "password"
                document.querySelector("label[for=password] > .view-pass").innerHTML = '<i class="fa-regular fa-eye" title="visualizar senha"></i>'
            }
        })
    }
})

// adicionar valores aos selects de data
$(document).ready(() => {
    if (document.querySelector("select[name=day]") != null) {
        document.querySelector("select[name=day]").innerHTML = getDays();

        // selecionar data de nascimento 
        if (document.querySelector("select[name=day][data-date]")) {
            changeDate(document.querySelector("#day"));
        }
    }

    if (document.querySelector("select[name=month]") != null) {
        document.querySelector("select[name=month]").innerHTML = getMonths();

        // selecionar data de nascimento 
        if (document.querySelector("select[name=month][data-date]")) {
            changeDate(document.querySelector("#month"));
        }
    }

    if (document.querySelector("select[name=year]") != null) {
        document.querySelector("select[name=year]").innerHTML = getYears();

        // selecionar data de nascimento 
        if (document.querySelector("select[name=year][data-date]")) {
            changeDate(document.querySelector("#year"));
        }
    }
})

// adicionar dias
function getDays() {

    var html = '';
    for (let day = 1; day <= 31; day++) {
        if (day == (newDate = new Date()).getDate())
            html += `<option value='${day}' selected>${day}</option>`;
        else html += `<option value='${day}'>${day}</option>`;
    }

    return html;
}

// adicionar meses
function getMonths() {
    var html = '';
    for (let month = 0; month <= 11; month++) {
        if (month == (newDate = new Date()).getMonth())
            html += `<option value='${month + 1}' selected>${addMonths(month)}</option>`;
        else html += `<option value='${month + 1}'>${addMonths(month)}</option>`;
    }

    return html;
}

function addMonths(months) {
    const newDate = new Date(`Jan 1 2024`);
    const currentMonth = newDate.getMonth();
    const newMonth = currentMonth + months;
    newDate.setMonth(newMonth);

    return newDate.toLocaleDateString('pt-BR', { month: "long" });
}

// adicionar ano
function getYears() {
    var html = '';
    for (let year = 0; year <= 120; year++) {
        html += `<option value='${addYears(year)}'>${addYears(year)}</option>`;
    }

    return html;
}

function addYears(Years) {
    const newDate = new Date();
    const currentYear = newDate.getFullYear();
    const newYear = currentYear - Years;
    newDate.setFullYear(newYear);

    return newDate.getFullYear();
}

// alterar para data já selecionada
function changeDate(select) {
    for (let index = 0; index < select.options.length; index++) {
        if (select.options[index].value == parseInt(select.dataset.date)) {
            select.options.selectedIndex = `${index}`;
        }
    }
}

// senha
function verifyPass(password) {
    let filter_pass = /^(?=(?:.*?[A-Z]){1})(?=(?:.*?[0-9]){1})(?=(?:.*?[!@#$%*()_+^&}{:;?.]))(?!.*\s)[0-9a-zA-Z!@#$%;*(){}_+^&]*$/

    if (!filter_pass.test(password)) {
        return false;
    }
    return true;
}

function verifyData(data) {
    var errors = false;
    var acceptData = {};
    var files = {}

    // ======================= categoria ======================= //

    if (data.category != undefined) {
        acceptData.category = parseInt(data.category);
    }

    acceptData.institute = data.institute;

    // ========================================================= //

    // ======== validar conteúdo de campos obrigatórios ======== //

    if (requiredFields(data)) { /* verifica se os campos "título" e "descrição" estão preenchidos */
        acceptData.title = data.title
        acceptData.description = data.description;
        
        if(acceptData.description == undefined) { // para reuniões
            acceptData.description = data.description_link;
        }
    } else errors = true;

    // ========================================================= //

    // ================ validações de imagens ================== //

    if (data.img.length > 0) {
        if (verifyImgs(data.img, 'img') != false) { /* verificar imagem principal */
            files.img = verifyImgs(data.img, 'img')[1];
            acceptData.img = verifyImgs(data.img, 'img')[0];
        } else errors = true
    }

    if (data.carousel_media != undefined) {
        if (data.carousel_media.length > 0) {
            if (verifyImgs(data.carousel_media, 'carousel_media') != false) { /* verificar mídias do carrossel */
                files.carousel_media = verifyImgs(data.carousel_media, 'carousel_media')[1]
                acceptData.carousel_media = verifyImgs(data.carousel_media, 'carousel_media')[0]
            } else errors = true
        }
    }

    // ========================================================= //

    // ================= validações de url's =================== //

    if (data.carousel_url_videos != null && data.carousel_url_videos != '' && data.carousel_url_videos != undefined) {
        if (verifyUrls(data.carousel_url_videos, 'carousel_url_videos') != false) {
            acceptData.carousel_url_videos = verifyUrls(data.carousel_url_videos, 'carousel_url_videos').join(', ');
        } else errors = true
    }

    // ========================================================= //

    // ================== conteúdo principal =================== //

    if (data.main_content != null && data.main_content != '' && data.main_content != undefined) {
        acceptData.main_content = data.main_content
    }

    // ========================================================= //

    // =================== infos das imagens =================== //

    acceptData.infos = [];
    let stringInfos = '';

    if (data.infos_img != undefined) {
        stringInfos += data.infos_img.join(';<separator>;');
    }

    if (data.infos_url != undefined) {
        if (stringInfos != '') {
            stringInfos += ';<separator>;'
        }
        stringInfos += data.infos_url.join(';<separator>;');
    }

    acceptData.infos = stringInfos;

    // ========================================================= //

    // ==================== datas de evento =================== //

    if (data.start_meeting != undefined && data.start_time != undefined && data.end_meeting != undefined && data.end_time != undefined) {
        acceptData.start_meeting = `${data.start_meeting} ${data.start_time}:00`
        acceptData.end_meeting = `${data.end_meeting} ${data.end_time}:00`
    }

    // ========================================================= //

    // ==================== datas de evento =================== //

    if (data.meetings) {
        acceptData.meetings = data.meetings;
    }

    // ========================================================= //

    // ======================= observações ===================== //

    if (data.obs != undefined) {
        acceptData.obs = data.obs;
    }

    // ========================================================= //

    // ========================= tipo ========================== //

    if (data.type_post != undefined) {
        acceptData.type_post = data.type_post;
    }

    // ========================================================= //

    // ========================= comitê ========================== //

    if (data.committee != undefined) {
        acceptData.committee = data.committee;
    }

    // ========================================================= //

    if (errors == true) {
        return false
    } else {
        return [acceptData, files];
    }
}

function removeSpecialCharacters(str) {
    let normalized = str.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    return normalized.replace(/[^a-zA-Z ]/g, '');
}

function requiredFields(data) {

    // ======== validar conteúdo de campos obrigatórios ======== //
    // título
    if (removeSpecialCharacters(data.title.trim()).length < 3 || data.title.length > 255) {
        error.title = "<div><span>Erro: O título é obrigatório e deve conter mais de 3 letras e no máximo 255 caracteres.</span></div>"
        getError(error, "title")
    }

    // descrição
    if(data.description != undefined){
        if (removeSpecialCharacters(data.description.trim()).length < 3 || data.description.length > 350) {
            error.description = "<div><span>Erro: A descrição é obrigatória, deve conter mais de 3 letras e no máximo 350 caracteres.</span></div>"
            getError(error, "description")
        }
    }

    // descrição evento
    if(data.description_link != undefined){
        if (removeSpecialCharacters(data.description_link.trim()).length < 3 || tinymce.activeEditor.plugins.wordcount.body.getCharacterCount() > 350) {
            error.description = "<div><span>Erro: A descrição é obrigatória, deve conter mais de 3 letras e no máximo 350 caracteres.</span></div>"
            getError(error, "description")
        }
    }

    // data de evento
    if (data.start_meeting != undefined && data.start_time != undefined && data.end_meeting != undefined && data.end_time != undefined) {
        if (data.start_meeting.length < 3) {
            error.start_meeting = "<div><span>Erro: As informações de horário do evento são obrigatórias.</span></div>"
            getError(error, "start_meeting")
        }
    }

    // data de reunião
    if (data.meetings != undefined) {
        if (data.meetings.length < 3) {
            error.meetings = "<div><span>Erro: As informações de data e horário das reuniões são obrigatórias.</span></div>"

            getErrorMeeting(error, errArea())
        }
    }

    // ========================================================= //

    if (Object.keys(error) == 0) {
        return true
    }

    delete error.description;
    delete error.title;
    delete error.start_meeting;
    delete error.meetings;

    return false;
}

function errArea() {
    var val = '';

    document.querySelectorAll("input[name=time]").forEach(input => {
        if (input.value == '' && val == '') {
            val = input.id;
        }
    })

    return val;
}

function verifyImgs(media, areaError) {

    accept = [];
    files = [];

    for (var i = 0; i < media.length; i++) {

        // verificar fotos
        if ((allowedFilesI.includes(getFileExtension(media[i].name)) && allowedTypesI.includes(getFileExtension(media[i].type)))) {
            files.push(media[i])
            accept.push(media[i].name)
        }

        // verificar vídeos
        else if ((allowedFilesV.includes(getFileExtension(media[i].name)) && allowedTypesV.includes(getFileExtension(media[i].type)) && (areaError != 'img'))) {

            maxSize = 1024 * 1024 * 4000; // tamanho máximo 4 GB 


            if (media[i].size <= maxSize) {
                files.push(media[i])
                accept.push(media[i].name)
            } else {
                wrongVideos.push(media[i].name)

                if (wrongVideos.length > 1) {
                    error.wrongVideo = `<div><span>Erro: Os vídeos "${wrongVideos.join(", ")}" excedem o tamanho máximo de 2.5GB.</span></div>`;
                } else {
                    error.wrongVideo = `<div><span>Erro: O vídeo "${wrongVideos.join(", ")}" excede o tamanho máximo de 50MB.</span></div>`;
                }

            }
        }

        // caso não for foto/vídeo
        else {
            error.type = `<div><span>Erro: "${media[i].name}" não é um tipo de arquivo aceito. São aceitas somente imagens e/ou vídeos.</span></div>`;

            break
        }
    }

    // mostrar erro ao usúario
    if (Object.keys(error) != 0) {
        for (var key in error) {
            if (error.hasOwnProperty(key)) {

                document.querySelector(`label[for=${areaError}] ~ .error .${key}`).innerHTML = error[key];
                document.getElementById(areaError).focus();

            }
        }
    }

    else {
        return [accept, files];
    }


    wrongVideos = [];
    wrongImgs = [];

    delete error.wrongImg;
    delete error.wrongVideo;
    delete error.type;

    return false;
}

function verifyPdfs(pdfs) {
    accept = [];
    files = [];

    areaError = 'pdf';

    for (var i = 0; i < pdfs.length; i++) {

        // verificar se o tipo de arquivo é pdf
        if (getFileExtension(pdfs[i].name) == 'pdf') {

            maxSize = 1024 * 1024 * 50; // tamanho máximo 50 MB

            if (pdfs[i].size <= maxSize) {
                accept.push(pdfs[i].name)
                files.push(pdfs[i])
            } else {
                wrongPdfs.push(pdfs[i].name);

                if (wrongPdfs.length > 1) {
                    error.wrongPdf = `<div><span>Erro: Os pdf's "${wrongPdfs.join(", ")}" excedem o tamanho máximo de 50MB.</span></div>`;
                } else {
                    error.wrongPdf = `<div><span>Erro: O pdf "${wrongPdfs.join(", ")}" excede o tamanho máximo de 50MB.</span></div>`;
                }
            }
        }

        // caso não seja pdf
        else {
            error.type = `<div><span>Erro: "${pdfs[i].name}" não é um tipo de arquivo aceito. São aceitos somente pdf's.</span></div>`;

            break
        }
    }

    // mostrar erro ao usúario
    if (Object.keys(error) != 0) {
        for (var key in error) {
            if (error.hasOwnProperty(key)) {
                document.querySelector(`label[for=${areaError}] ~ .error .${key}`).innerHTML = error[key];
                document.getElementById(areaError).focus();
            }
        }
    }

    else {
        return [accept, files];
    }

    wrongPdfs = [];

    delete error.type;
    delete error.wrongPdf;

    return false;
}

function verifyUrls(urls, areaError) {

    var acceptUrls = [];
    var fail = false;

    // ===================== validar urls ====================== //

    if (typeof urls == 'object') {
        arrUrls = urls[0].split(',');
    } else {
        arrUrls = urls.split(',');
    }

    arrUrls.forEach(url => {

        if (url.replace(/\s/g, '') != '') {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);

            if (match != null && match && match[2].replace(/\s/g, '').length === 11) {

                if (!(acceptUrls.includes(match[2].replace(/\s/g, '')))) {
                    acceptUrls.push(match[2].replace(/\s/g, ''));
                }
            } else {
                if (areaError != null) {
                    error.wrongUrl = `<div><span>Erro: "${url}" é uma url inválida.</span></div>`;
                    getError(error, areaError)

                    delete error.wrongUrl;
                }


                fail = true;
                return
            }
        }

    });

    if (fail == true && areaError == null) {
        return false;
    }

    return acceptUrls;

    // ========================================================= //
}

// pegar extensão do arquivo
function getFileExtension(filename) {
    return filename.split('.').pop();
}

// exibir erro
function getError(error, areaError) {
    for (var key in error) {
        if (error.hasOwnProperty(key)) {
            if (document.querySelector(`label[for=${areaError}] ~ .error .${key}`) != null) {
                document.querySelector(`label[for=${areaError}] ~ .error .${key}`).innerHTML = error[key];
                document.getElementById(areaError).focus();
            }
        }
    }
}

function getErrorMeeting(error, areaError) {
    for (var key in error) {
        if (error.hasOwnProperty(key)) {
            if (document.querySelector(`.err_meetings > div`) != null) {
                document.querySelector(`.err_meetings > div`).innerHTML = error[key];
                document.getElementById(areaError).focus();
            }
        }
    }
}

// limpar erros
function clearErrors() {
    divErrors = ['carousel_media', 'img', 'pdf', 'description', 'title', 'carousel_url_videos', 'start_meeting'];

    divErrors.forEach(divError => {
        document.querySelectorAll(`label[for=${divError}] ~ .error div`).forEach(div => {
            div.innerHTML = '';
        });
    });

    if (document.querySelector(`.err_meetings > div`) != undefined) {
        document.querySelector(`.err_meetings > div`).innerHTML = '';
    }
}

async function checkUrl(sameOriginURL) {
    bool = false;
    
    await fetch(sameOriginURL, {
        method: 'HEAD',
        mode: 'no-cors',
      }).then((response) => {
        if (response.ok ||response.type == 'opaque') {
            bool = true;
        } 
      }).catch((error) => {
        bool = false;
      });

    return bool;
}