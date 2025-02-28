const tbody = document.querySelector(".reports");
    
const listReports = async (pg) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/calculo-atuarial/dados-lista?pg=${pg}&&register=false`));
    const html = await data.text();
    tbody.innerHTML = html;
}

listReports(1);