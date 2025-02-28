const getGalleries = async (pg) => {
    contentList = document.getElementById("galleries");
    
    const data = await fetch(getUriRoute(`${getInstitute()}/publicacoes/galerias/dados-lista?pg=${pg}`));
    const html = await data.text();

    contentList.innerHTML = html;

    prepareGalleries();
}

$(document).ready(() => {
    getGalleries(1);
})