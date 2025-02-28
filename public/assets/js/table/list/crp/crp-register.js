const listCrps = async (pg) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/crps/certificados/dados-lista?pg=${pg}&&register=true`));
    const html = await data.text();
    contentList.innerHTML = html;
}

function getListCRPS(){
    contentList = document.querySelector(".container-previous-reports");
    listCrps(1);
}
