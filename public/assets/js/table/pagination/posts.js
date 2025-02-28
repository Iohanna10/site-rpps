// tabela de posts
const tbody = document.querySelector(".list-posts");
var routeId = document.querySelector(".list-posts").dataset.route_id;
var search = document.querySelector(".list-posts").dataset.search;

// preparar tipo de requisição
if (routeId == "concursos") { // requisição concursos
    var posts = async (pg, route_id, filters) => {
        const data = await fetch(`${getUriRoute(getInstitute())}/posts/dados-lista-concurso?pg=${pg}&&${filters}`);
        const html = await data.text();
        tbody.innerHTML = html;
    
        if(tbody.innerHTML != ''){
            readyMore();
        }
    }
}

else if (routeId == "noticias") { // requisição notícias
    var posts = async (pg, route_id, filters) => {
        const data = await fetch(`${getUriRoute(getInstitute())}/posts/dados-lista-noticias?pg=${pg}&&${filters}`);
        const html = await data.text();
        tbody.innerHTML = html;
    
        if(tbody.innerHTML != ''){
            readyMore();
        }
    }
}

else if (
    routeId == "31" ||
    routeId == "42" ||
    routeId == "46"
) {  
    var posts = async (pg, route_id, filters) => { // requisição de posts e reuniões dos comitês   
        const data = await fetch(`${getUriRoute(getInstitute())}/posts/dados-lista-reunioes?pg=${pg}&&route_id=${route_id}&&${filters}`);
        const html = await data.text();
        tbody.innerHTML = html;
    
        if(tbody.innerHTML != ''){
            readyMore();
        }
    }
}

else if (search != null) { // requisição de pesquisa
    var posts = async (pg, search, filters) => {
        const data = await fetch(`${getUriRoute(getInstitute())}/posts/dados-lista-pesquisa?pg=${pg}&&search=${search}&&${filters}`);
        const html = await data.text();
        tbody.innerHTML = html;

        if(tbody.innerHTML != ''){
           readyMore();
           showNumResults();
        }
    }
}

else {
    var posts = async (pg, route_id, filters) => { // requisição de posts de uma categoria de específica
        const data = await fetch(`${getUriRoute(getInstitute())}/posts/dados-lista?pg=${pg}&&route_id=${route_id}&&${filters}`);
        const html = await data.text();
        tbody.innerHTML = html;
    
        if(tbody.innerHTML != ''){
            readyMore();
        }
    }
}

function getFilters(){
    data = {
        start_date: document.getElementById("start_date").value,
        end_date: document.getElementById("end_date").value,
        order: document.getElementById("order").value,
    }

    filters = `initial_date=${data.start_date}&&final_date=${data.end_date}&&order=${data.order}`;

    if(document.getElementById('type-post') != null){
        data.type_post = document.getElementById("type-post").value;
        filters += `&&type_post=${data.type_post}`;
    } 

    return filters;
}

function showNumResults(){
    num = document.querySelector("#totalResults").dataset['num_results']; // número de resultados

    document.querySelector(".category").innerHTML = `${num} resultados para: ${document.querySelector(".list-posts").dataset.search}`
}

if (search != null){
    posts(1, search, getFilters());
}
else {
    posts(1, routeId, getFilters());
}