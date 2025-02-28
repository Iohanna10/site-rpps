const listGallery = async (pg, filters) => {
    contentList = document.getElementById("gallery-list");
    
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/galeria/dados-lista?pg=${pg}&&${filters}`));
    const html = await data.text();
    contentList.innerHTML = html;
}

const addGallery = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/galerias`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Galerias > Criar galeria'

    cadGallery();
    activePreview_carousel()
    activePreview_infos();
    activePreview_infosURL();
}

const editGallery = async (id) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/galeria?id=${id}`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Galerias > Editar galeria'

    configGalleryEdit();
    await listMedias_gallery();
}

function getFilters_gallery(){
    data = {
        start_date: document.getElementById("start_date").value,
        end_date: document.getElementById("end_date").value,
        order: document.getElementById("order").value,
        name: document.getElementById("name").value,
    }

    return `initial_date=${data.start_date}&&final_date=${data.end_date}&&order=${data.order}&&name=${data.name}`;
}