// ------------- variaveis ------------- //
let stop;
var count = 1;
var first = true;
let haveSlider = false;
var htmlConstructor = '';
const allowedFilesI = ["png", "jpg", "jpeg"]; // tipo de arquivos permitidos: imagem
const allowedFilesV = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // tipo de arquivos permitidos: vídeo
var goBack = document.referrer;

// ------------------------------------- //
function readyMore() {
    var query = location.search.slice(1);
    var partes = query.split('&');
    var hrefPost = {};
    
    partes.forEach(function (parte) {
        var chaveValor = parte.split('=');
        var chave = chaveValor[0];
        var valor = chaveValor[1];
        hrefPost[chave] = valor;
    });

    if(hrefPost.idPost !== undefined){
        dataAjax(hrefPost.idPost);
    }

    // evento de click nos posts p/ abrir a notícia completa
    document.querySelectorAll('.post a[data-post-id]').forEach(el => {
        el.addEventListener("click", () => {
            if(el.dataset.type == 'posts'){
                dataAjax(el.dataset.postId);
            } else if (el.dataset.type == 'reunioes') {
                dataAjaxMeeting(el.dataset.postId);
            }
        })
    });
}

// ============================= buscar info do post/reunião ============================= //
function dataAjax(el_id){
    // dados para a pesquisa no db
    var data = {
        'id_post': el_id,
    }

    loader(); // trocar a tela: gif loader ativo (até receber a resposta do ajax)

    // ajax para entregar os dados ao model (AjaxPhotosModel) e retornar os dados
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-post/getdatapost"),
        data: data,
        success: function (response){  
            if(response === false){
                loader();
                return modal("Publicação não encontrada.");
            }
            // trocar os dados das rotas (título principal / outras rotas)
            screenChange = setTimeout(function(){
                changeLinksHeader(response)
            }, 1000);
            
            // post completo
            fullPost(response);
            
            if(document.querySelector(".description_contents") !== null){
                document.querySelector(".description_contents").style.display = "none";
            }
            
            // loader + mostrar div com conteúdo do post
            screenChange = setTimeout(function(){
                    loader(), showPost() /* parar gif loader */
            }, 1000);
        }
    })
}

function dataAjaxMeeting(el_id){
    // dados para a pesquisa no db
    var data = {
        'id_meetings': el_id,
    }

    // trocar a tela: gif loader ativo (até receber a resposta do ajax)

    loader();

    // ajax para entregar os dados ao model (AjaxPhotosModel) e retornar os dados
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-meeting/getdataMeeting"),
        data: data,
        success: function (response){  
            // trocar os dados das rotas (título principal / outras rotas)
            screenChange = setTimeout(function(){
                changeLinksHeader(response)
            }, 1000);
            
            // post completo
            fullTable(response);
            
            // loader + mostrar div com conteúdo do post
            screenChange = setTimeout(function(){
                    loader(), showPost() /* parar gif loader */
            }, 1000);
        }
    })
}

// =============================================================================== //

// :::::::::::::::::::::::::::: alterar o header links ::::::::::::::::::::::::::: //

    // ==================== trocar html da div ====================== //
    function changeLinksHeader(post){
        // trocar o título para o do post
        document.querySelector(".header-routes .category").innerHTML = post.titulo;

        // trocar rotas
        document.querySelector(".header-routes .route-links").innerHTML = routeHTML(post.titulo, getUriRoute(`${getInstitute()}`));

    }
    // ============================================================= //

    // ================== preparar html das rotas ================== //
    function routeHTML(titlePost, url){
        var routeNames = getRouteNames(titlePost); // pegar o nome das rotas
        var count = 0; // controle p/ o for
        var htmlRoute = '';

        // link voltar ao início 
        htmlRoute += `<a href="${url}">Início</a>`;
        htmlRoute += "<span> <i class='fa-light fa-chevron-right'></i> </span>";

        // outros links
        var routes = window.location.pathname.split(`/${getInstitute()}/`)[1].split('/');
        routes.push(titlePost);

        routes.forEach(rota => {

            url += `/${rota}`;

            if(count < (routes.length - 1)){
                htmlRoute += `<a href="${url}">${routeNames[count + 1]}</a>`;
                htmlRoute += "<span> <i class='fa-light fa-chevron-right'></i> </span>";

                count += 1;
            } else {
                if(routes.length == 1){
                    htmlRoute += `<a href="${window.location.href}">${routeNames[count + 1]}</a>`

                    htmlRoute += "<span> <i class='fa-light fa-chevron-right'></i> </span>";
                    htmlRoute += `<a>${routeNames[2]}</a>`
                } else {
                    htmlRoute += `<a>${routeNames[count + 1]}</a>`
                }
            }
        });

        return htmlRoute;
    }
    // ============================================================= //

    // =================== pegar rotas do post ===================== //
    function getRouteNames(titlePost){
        var routeNames = [];
        document.querySelectorAll(".header-routes a").forEach(routeName => {
            routeNames.push(routeName.innerHTML);
        })

        routeNames.push(titlePost);

        return routeNames;
    }
    // ============================================================= //

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// ============================ preparar html das posts ============================ //

    // :::::::::::::: montar html do conteúdo do post :::::::::::::: //

    function fullPost(post){
        var html = '<section id="goBack">';
            html += '<div class="container-go-back max-width-container">';
                if(window.location.search === ''){
                    html += '<p><a onclick="window.location.replace(window.location.pathname);"><span><i class="fa-solid fa-arrow-left"></i></span> Voltar</a></p>';
                } else {
                    html += `<p><a onclick="window.location.replace('${goBack}')"><span><i class="fa-solid fa-arrow-left"></i></span> Voltar</a></p>`;
                }
            html += '</div>';
        html += '</section>';

        if(post.conteudo != '' || post.midias != null){
            // conteúdo principal do post
            if(post.conteudo != ''){
                html += post.conteudo;
            }
    
            // galeria de midias
            if(post.midias != null){
                html += mainSlider(post.midias.split(', '), post.data);
                haveSlider = true;
            }
        }
        else {
            html += 
            `<div class="warning">
                <span>Ainda não há nada para ver aqui.</span>
            </div>`;
        }

        document.querySelector(".full-post").insertAdjacentHTML("beforeend", html);
        document.querySelector(`.list-posts`).parentNode.removeChild(document.querySelector(`.list-posts`))
        document.querySelector(`.container-filters`).parentNode.removeChild(document.querySelector(`.container-filters`))
    }

    // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

    function mainSlider(images, date){
        var html = 
        `<div class="slider-photos"> 

            <div class="loader">
                <div style="background-image: url('${getUriRoute()}/assets/gifs/loading.gif')"></div>
            </div>


            <div class="gallery">
                <div class="post-carousel">
                    <div class="carousel">
                        <div class="slider">
                            <div class="slides">`

                            html += mainSliderMedias(images, date);

                        html += 
                            `</div>
                        </div>

                        <div class="change-content">
                        <div class="btns left">
                            <button class="btn-first" onclick="firstSlide()" title="Ir para primeira foto"><i class="fa-regular fa-chevrons-left fa-flip-vertical"></i></button>
                            <button class="btn-prev" onclick="prevSlide()" title="Voltar para foto anterior"><span class="material-symbols-outlined">arrow_back_ios_new</span></button>
                        </div>

                        <div class="count-current"><input title="Digite o número da foto" type="number" class="current" value="1"></input>
                            <p> de <span class="total">5</span></p>
                        </div>

                        <div class="btns right">
                            <button class="btn-next" onclick="nextSlide()" title="Ir para próxima foto"><span class="material-symbols-outlined">arrow_forward_ios</span></button>
                            <button class="btn-last" onclick="lastSlide()" title="Ir para última foto"><i class="fa-regular fa-chevrons-right"></i></button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="gallery-carousel hidden">
            <div class="carousel">
                <div class="slider">
                    <div class="slides">`

                    html += gallerySliderMedias(images, date);

                    html +=    
                        `</div>

                    </div>

                    <div class="close-slider" onclick='closeSlides()' title="Fechar slide de fotos">
                        <span><i class="fa-duotone fa-xmark"></i></span>
                    </div>

                    <div class="change-content">
                        <button class="gallery-btn btn-prev" onclick='prevSlideGallery()'><span class="material-symbols-outlined">arrow_back_ios_new</span></button>
                        <button class="gallery-btn btn-next" onclick='nextSlideGallery()'><span class="material-symbols-outlined">arrow_forward_ios</span></button>
                    </div>

                    <div class="control-buttons">
                        <div class="media-info hidden"></div>

                        <div>
                            <div class="toggle-ctrl" onclick='toggleBtns()'>
                                <span><i class="fa-solid fa-caret-up"></i></span>
                            </div>
                            <div class="ctrl">

                                <div class="toggle-midia-slider">
                                    <span class="play" onclick='playSlider()'><i class="fa-solid fa-play" title="Play"></i></span>
                                    <span class="pause hidden" onclick='pauseSlider()'><i class="fa-solid fa-pause" title="Pausa"></i></span>
                                </div>

                                <div class="full-screen">
                                    <span class="off hidden" onclick='btnFullScreenClose()'><i class="fa-regular fa-down-left-and-up-right-to-center" title="Sair da Tela Cheia"></i></span>
                                    <span class="on" onclick='btnFullScreenOpen()'><i class="fa-regular fa-up-right-and-down-left-from-center" title="Tela Cheia"></i></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;

        return html;
    }

    function mainSliderMedias(images, date) {
        num = 1;
        var html = '';

            images.forEach(midia => {

                // primeiro slide
                if(first == true){

                    // slide de foto 
                        html += `<div class="slide first-post">`;
                            html += `<div class="subtitle"><span>Mídia</span></div>`;
                            html += `<div class="delimit-image">`;
                                html += `<div class="photo-gallery" data-img-num="${num}">`;
                                    html += `<a class="open-slider" title="Abrir slides">`;
                                        html += typeMidia(midia, date);
                                    html += `</a>`;
                                html += `</div>`;
                            html += `</div>`;
                        html += `</div>`;
                    

                    first = false; // desabilitar condição de primeiro slide
                } else {

                   // outros slides
                        html += `<div class="slide">`;
                            html += `<div class="subtitle"><span>Mídia</span></div>`;
                            html += `<div class="delimit-image">`;
                                html += `<div class="photo-gallery" data-img-num="${num}"`;
                                    html += `<a class="open-slider" title="Abrir slides">`;
                                        html += typeMidia(midia, date);
                                    html += `</a>`;
                                html += `</div>`;
                            html += `</div>`;
                        html += `</div>`;
                }
                num += 1;
            })
        return html;
    }

function gallerySliderMedias(images, date) {
    num = 1;
    var html = '';

    images.forEach(midia => {
        // primeiro slide
        if(first == true){

            // slide first
                html += `<div class="slide first">`;
                    html += typeMidia(midia, date);
                html += `</div>`;

            first = false; // desabilitar condição de primeiro slide
        } else {
            // outros slides
                html += `<div class="slide">`;
                    html += typeMidia(midia, date); 
                html += `</div>`;
        }
    })
        
    return html;
}

function typeMidia(name, date){
    var date = new Date(date); 
    var path = getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads`);
    
    if(allowedFilesI.includes(getFileExtension(name))){
        return `<img src="${path}/img/posts/${date.getFullYear()}/${(date.getMonth() + 1)}/${name}"></img>`;
    }

    else if(allowedFilesV.includes(getFileExtension(name))){
        return `<video class="video" title="video player" controls>
            <source src="${path}/video/posts/${date.getFullYear()}/${(date.getMonth() + 1)}/${name}">
        </video>
        <div></div>`
    }

    else {
        return `<iframe class="video" src="https://www.youtube.com/embed/${name}" style="width: 600px; max-width: 100%;" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><div></div>`;
    }

    // obs: verificar se dessa forma a responsividade funciona corretamente para os iframes da galeria dos posts
}

// =========================== preparar html das reuniões =========================== //

    function fullTable(meetings){
        var html = ``;
        
        html = '<section id="goBack">';
            html += '<div class="container-go-back max-width-container">';
                html += '<p><a onclick="window.location.reload();"><span><i class="fa-solid fa-arrow-left"></i></span> Voltar</a></p>';
            html += '</div>';
        html += '</section>';
        
        html += `<table class="birthday-list meetings">`;
            html += `<thead>`;
                html += `<tr>`;
                    html += `<th>`;
                        html += `<h1>${meetings.titulo}</h1>`;
                    html += `</th>`;
                html += `</tr>`;
            html += ` </thead>`;
            html += ` <tbody>`;
                html += `<tr>`;
                    html += `<td>`;
                        html += `<table class="main-list birthday-list">`;

                            // head da tabela
                            html += `<thead>`;
                                html += `<tr>`;
                                    html += `<th>`;
                                        html += `<h5>Mês</h5>`;
                                    html += `</th>`;
                                    html += `<th>`;
                                        html += `<h5>Dia</h5>`;
                                    html += `</th>`;
                                    html += `<th>`;
                                        html += `<h5>Horário</h5>`;
                                    html += `</th>`;
                                html += `</tr>`;
                            html += `</thead>`;

                            // body da tabela
                            html += `<tbody class="list-users">`;
                            
                                // informativo datas
                                meetings.reunioes.split(", ").forEach((meeting) => {
                                    var date = new Date(meeting)

                                    html += `<tr>`
                                        html += `<td>${date.toLocaleString('default', { month: 'long' })[0].toUpperCase()}${date.toLocaleString('default', { month: 'long' }).substring(1)}</td>`
                                        html += `<td>${date.getDate()}</td>`
                                        html += `<td>${date.getHours()}:${date.getMinutes()}`; if(date.getMinutes() < 10){html += `0`}; html += `</td>`;
                                    html += `</tr>`
                                })
                            
                            html += `</tbody>`;
                        html += `</table>`;
                    html += `</td>`;
                html += `</tr>`;
            html += `</tbody>`;
                // obs
                if(meetings.obs != null && meetings.obs != ''){
                    html += `<tfoot>`;
                        html += `<tr>`;
                            html += `<th colspan="3">`;
                                html += `<h5>Observação: ${meetings.obs}</h5>`;
                            html += `</th>`;
                        html += `</tr>`;
                    html += `</tfoot>`;
                }
        html += `</table>`;    

        document.querySelector(`.list-posts`).parentNode.removeChild(document.querySelector(`.list-posts`))
        document.querySelector(`.container-filters`).parentNode.removeChild(document.querySelector(`.container-filters`))
        document.querySelector(".full-post").innerHTML = html;
    }

// =================================================================================== //


// :::::::::::::::::::::::: Mostrar div com post completo :::::::::::::::::::::::::: //


    // ============== trocar tela para o post completo ============== //

    function showPost() {
        document.querySelector(".full-post").classList.toggle("hidden");
       
        if (haveSlider == true) {
            adjustSlides()
            valueCurrentPg()
            closeSlider()
            activeSliderGallery()
        }
    }

    // ============================================================= //

    // ================== tela de carregamento ===================== //

    function loader(){
        document.querySelector(".loader").classList.toggle("loader-on"); // loader gif
    }

    // ============================================================= //


// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// pegar extensão do arquivo
function getFileExtension(filename){
    return filename.split('.').pop();
}