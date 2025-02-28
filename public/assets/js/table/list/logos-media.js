const listLogos = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/logos/dados-lista`));
    const html = await data.text();
    contentList.innerHTML = html;
    
    dragDrop();
    activeBtns();
}

function getListLogos(){
    contentList = document.querySelector(".medias-list");
    listLogos();
}