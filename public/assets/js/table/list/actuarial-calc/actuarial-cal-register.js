const listReports = async (pg) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/calculo-atuarial/dados-lista?pg=${pg}&&register=true`));
    const html = await data.text();
    contentList.innerHTML = html;
}

function getListReports(){
    contentList = document.querySelector(".container-previous-reports");
    listReports(1)
}