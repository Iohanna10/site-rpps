function getUriRoute(vUri = '') {
    // verificar se possui o diretório 'public' na url e adicionar caso não exista
    vUri = getPublicRoute(vUri);
    // conta todos os parâmetros após o instituto e adiciona '../' para sair desses diretórios para chegar no caminho principal 
    for (let index = 0; index < (window.location.pathname.split(`/${getInstitute()}`)[1].split('/').length + 1); index++) { 
        vUri = '../' + vUri;
    }
    return clearUrl(window.location.href) + vUri;
}

function getInstitute() {
    var institute = window.location.pathname.slice(1);
    if(institute.indexOf("public/") !== -1){
        institute = institute.split("public/")[1]
    }
    institute = institute.split('/')[0];

    return institute;
}

function clearUrl(url = '') {
    // Criando um objeto URL a partir da URL fornecida
    const urlObj = new URL(url);
    // Removendo os parâmetros de pesquisa da URL e parâmetros de id
    urlObj.search = '';
    urlObj.hash = '';
    // retornando URL
    return urlObj.href;
}

function getPublicRoute(vUri = ''){
    var publicRoute = window.location.pathname.slice(1);
    if(publicRoute.indexOf("public/") === -1){
        return 'public/' + vUri;
    }

    return vUri;
}

function friendlyUrl(){
    var newUrl = window.location.pathname.slice(1);
    if((newUrl.indexOf("public/") !== -1 && newUrl.split('public/')[0].length === 0)){
        window.history.pushState(null, null, window.location.href.replace('public/', ''))
    }
}

$(document).ready(() => {
    friendlyUrl();
})