const listMedias_gallery = async () => {
    contentList = document.querySelector(".medias-list");

    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/galeria/medias/dados-lista?id=${document.querySelector('.form-cad').dataset.id}`));
    const html = await data.text();
    contentList.innerHTML = html;

    dragDrop_gallery();
    activeBtns_gallery();
}