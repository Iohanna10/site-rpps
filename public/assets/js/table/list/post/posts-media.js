const listMedias_post = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/publicacoes/medias/dados-lista?id=${document.querySelector('.form-cad').dataset.id}`));
    const html = await data.text();
    document.querySelector(".medias-list").innerHTML = html;

    dragDrop_post();
    activeBtns_post();
}