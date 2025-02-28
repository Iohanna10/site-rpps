function activeInputChange(){
    document.getElementById("team").addEventListener("change", () => {
        listMembers(1)
    })
}

const listMembers = async (pg) => {
    contentList = document.querySelector("#team-list");
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/equipe/dados-lista?pg=${pg}&&team=${document.getElementById("team").value}`));
    const html = await data.text();
    contentList.innerHTML = html;

    dragDrop_team();
}

const addMember = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/membros`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Equipes > Adicionar integrante';

    cadMembers();
    resetTinyMCE_members()
}

const editMember = async (id) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/edit/membros?id=${id}`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Equipes > Editar informações do integrante';

    activeEditMember();
    resetTinyMCE_members();
}

function resetTinyMCE_members(){
    resetTinyMCE()

    tinymce.init({
        selector: 'textarea.editor-c',
        plugins: 'link',
        menubar: false,
        toolbar: 'bold | link | removeformat',
        tinycomments_author: 'false',
        language: 'pt_BR',
        height: 200,
        resize: true,
        branding: false,
        elementpath: false, 
        entity_encoding: 'row',
        license_key: 'gpl',
        promotion: false
    });
}