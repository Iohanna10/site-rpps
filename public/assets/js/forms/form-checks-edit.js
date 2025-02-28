function verifyMediasEdit(medias) {
    files = [];
    wrongMedias = []

    for (var i = 0; i < medias.length; i++) {

        // verificar fotos
        if ((allowedFilesI.includes(getFileExtension(medias[i].name)) && allowedTypesI.includes(getFileExtension(medias[i].type)))) {
            files.push(medias[i])
        }

        // verificar vídeos
        else if ((allowedFilesV.includes(getFileExtension(medias[i].name)) && allowedTypesV.includes(getFileExtension(medias[i].type)))) {

            maxSize = 1024 * 1024 * 4000; // tamanho máximo 4 GB 


            if (medias[i].size <= maxSize) {
                files.push(medias[i])
            } else {
                wrongMedias.push(medias[i].name)
            }
        }

        // caso não for foto/vídeo
        else {
            return {files: medias[i].name, bool: false, err: 'type'}
        }
    }
    
    if(wrongMedias.length > 0){
        return {files: wrongMedias, bool: false, err: 'size'}
    }

    return {files: files, bool: true}
}

// ===================== validar urls ====================== //
function verifyUrlsEdit(url) {

    var acceptUrls = [];
    var wrongUrls = [];

    if (url.replace(/\s/g, '') != '') {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);

        if (match != null && match && match[2].replace(/\s/g, '').length === 11) {
            if (!(acceptUrls.includes(match[2].replace(/\s/g, '')))) {
                acceptUrls.push(match[2].replace(/\s/g, '').trim());
            }
        } else {
            wrongUrls.push(url.trim())
        }
    }

    if(wrongUrls.length > 0){
        return {allUrls: wrongUrls, bool: false}
    }

    return {allUrls: acceptUrls, bool: true};
}
// ========================================================= //

function verifyPdfsEdit(medias) { // verificar arquivos se são apenas imagens e vídeos
    files = [];
    wrongMedias = []

    for (var i = 0; i < medias.length; i++) {

        if (getFileExtension(medias[i].name) == 'pdf') {

            maxSize = 1024 * 1024 * 50; // tamanho máximo 50 MB 

            if (medias[i].size <= maxSize) {
                files.push(medias[i])
            } else {
                wrongMedias.push(medias[i].name)
            }
        }

        // caso não for foto/vídeo
        else {
            return {files: medias[i].name, bool: false, err: 'type'}
        }
    }
    
    if(wrongMedias.length > 0){
        return {files: wrongMedias, bool: false, err: 'size'}
    }

    return {files: files, bool: true}
}
