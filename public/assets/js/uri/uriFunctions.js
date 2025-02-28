export function getUriRoute(vUri) {
    for (let index = 0; index < (window.location.pathname.split(`/${getInstitute()}`)[1].split('/').length + 1); index++) { 
        vUri = '../' + vUri;
    }

    return vUri;
}

export function getInstitute() {
    var institute = window.location.pathname.slice(1);
    if(institute.indexOf("public/") !== -1){
        institute = institute.split("public/")[1]
    }
    institute = institute.split('/')[0];

    return institute;
}