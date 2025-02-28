const listPdfs_post = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/publicacoes/pdfs/dados-lista?id=${document.querySelector('.form-cad').dataset.id}`));
    const html = await data.text();
    document.querySelector(".container-previous-reports").innerHTML = html;
}
