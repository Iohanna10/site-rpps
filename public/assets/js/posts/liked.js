var boolLike = false;
var span = '';
var icon = '';

Node.prototype.hasClass = function(value) { // verificar se o elemento possui a classe
    var
        has = true,
        names = String(value).trim().split(/\s+/);

    for(var i = 0, len = names.length; i < len; i++){
        if(!(this.className.search(new RegExp('(?:\\s+|^)' + names[i] + '(?:\\s+|$)', 'i')) > -1)) {
            has = false;
            break;
        }
    }
    return has;
};

async function liked(id, post){ // selecionar elementos do post
    span = document.querySelector(`#post-${id}[data-type=${post}] span`);

    await toggleRated(id, post);
    await changeStatus([id, post]);
}

async function changeStatus(data){ // veerificar se é like ou dislike no post
    if(icon[0].hasClass('not-rated'))
        like(parseInt(span.innerHTML), data);
    else 
        dislike(parseInt(span.innerHTML), data);
}

var like = async (numLikes, data) => { // registrar o like e trocar a quantidade de likes mostrada
    var data = { // dados para inserir no db
        'id': data[0],
        'type': data[1],
    }

    await $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-post/like"),
        data: data,
        success: function (response){  
            if(!response){
                modal("Faça login para poder avaliar.") 
                toggleRated(data.id, data.type);
            }
            boolLike = response;
        }
    })

    getLikes(numLikes, boolLike, '+');
}

var dislike = async (numLikes, data) => { // excluir registro do like e trocar a quantidade de likes mostrada
    var data = { // dados para inserir no db
        'id': data[0],
        'type': data[1],
    }

    await $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-post/dislike"),
        data: data,
        success: function (response){  
            if(!response){
                modal("Ocorreu um problema, tente novamente mais tarde.") 
                toggleRated(data.id, data.type);
            }
            boolLike = response;
        }
    })

    getLikes(numLikes, boolLike, '-');
}

function getLikes(currentVal, bool, operator){
    if(bool && operator == '+'){
        span.innerHTML = parseInt(currentVal) + 1;
    }
    else if(bool && operator == '-'){
        span.innerHTML = parseInt(currentVal) - 1;
    }
    else {
        span.innerHTML = parseInt(currentVal);
    }
}

async function toggleRated(id, post){
    icon = document.querySelectorAll(`#post-${id}[data-type=${post}] i`);

    icon.forEach(el => {
        el.classList.toggle("not-rated");
    });
}