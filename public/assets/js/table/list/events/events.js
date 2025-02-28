const listEvents = async (pg, filters) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/eventos/dados-lista?pg=${pg}&&${filters}`));
    const html = await data.text();
    contentList.innerHTML = html;
}

const addEvent = async () => {
    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/eventos`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Eventos > Criar evento'

    htmlForm("eventForm");
    typeForm();
    cadEvent();
}

const editEvent = async (id) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/evento?id=${id}`));
    const html = await data.text();
    tbody.innerHTML = html;

    document.querySelector('.infos-menu .current-page h2').innerHTML = 'Eventos > Editar evento';

    htmlFormEdit(document.getElementById('formMeeting').dataset.type, document.getElementById('formMeeting').dataset.id);
    configEditEvents();
    typeForm();
}

function getFilters_events(){ // pegar valores do filtro 
    data = {
        start_date: document.getElementById("start_date").value,
        end_date: document.getElementById("end_date").value,
        order: document.getElementById("order").value,
        name: document.getElementById("name").value,
        event: document.getElementById("typeEvent").value,
    }

    if(document.getElementById("committee") != null){
        data.type_post = document.getElementById("committee").value;
    } else {
        data.type_post = null;
    }

    // retorna uma str de dados para serem enviados via GET
    return `initial_date=${data.start_date}&&final_date=${data.end_date}&&order=${data.order}&&name=${data.name}&&id_category=${data.type_post}&&event=${data.event}`;
}

function configEvents(){
    contentList = document.getElementById("events-list");
    listEvents(1, getFilters_events());
}