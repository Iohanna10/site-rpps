// variáveis

// formulário
let selector; // Selecionador do main e do footer
let form; // formúlario

// valores
let input; // input selecionado para o voto
let valuesVotes; // array valor dos votos

// funcionalidade
let content = ""; // trocar conteúdo das divs
let idForm; // armazenar id do formulário

function pollView(id){ // mostrar resultados
    changeView(`#polls-form-${id}`, id, null);
}

function changeView(selectorForm, id, vote) { // adicionar valor as variáveis
    // id do formulário
    idForm = id;

    // Seleciona os inputs type hidden que possuem os valores dos votos
    ajaxTotalVotes(id, vote, selectorForm);
}

function ajaxTotalVotes (data, vote, selectorForm) {
    data = {
        id_poll: data,
        id_institute: getInstitute()
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-polls/totalVotes"),
        data: data,
        success: function (response){  
            valuesVotes = response;

            trocarTelaMain([valuesVotes.excellent, valuesVotes.good, valuesVotes.regular, valuesVotes.bad, valuesVotes.tooBad], vote, selectorForm)
            opacity(document.querySelector(`${selectorForm} .poll-content`), document.querySelector(`${selectorForm} .poll-responses`))
        }
    })
}

function pollVote(id) { // registrar voto no db
    
    data = {
        input: document.querySelector(`#polls-form-${id} input:checked`), // Selecionar o input
        id: id
    }

    if(isChecked(data.input)){
        ajaxRegisterVote(data)
    }
}

function ajaxRegisterVote (data) {
    data = {
        id_poll: data.id,
        note: data.input.value
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-polls/registerNote"),
        data: data,
        success: function (response){  
            if(response){
                if(response == true){
                    changeView(`#polls-form-${data.id_poll}`, data.id_poll, data.note);
                    setAttributeData(`#polls-form-${data.id_poll}`, data.note)
                    verifyPollResponses()
                } else [
                    modal(response.msg)
                ]
            }
        }
    })
}

function isChecked(input) { // verificar se o input está preenchido
    if (input != null) {
        return true;
    } else {
        modal("Por favor, escolha uma resposta válida.");
    }
}

function trocarTelaMain(values, voted, selectorForm) {
    total = totalVotes(values); // pegar número total de votos

    content = "";

    // número de votos e pocentagens da satisfação
    content += "<ul>"; // inicio da lista
    for (let index = 0; index < values.length; index++) {
        satisfaction(values[index], total, voted, index); // corpo da lista
    }

    content += "</ul>"; // fim da lista 
    // 

    content += "<div class='vote'><p>Total de paticipantes: <b>" + total + "</b></p></div>"; // total de votos

    document.querySelector(`${selectorForm} .poll-responses`).innerHTML = content; // trocar conteúdo do main

    trocarTelaFooter(voted, selectorForm);
}

function trocarTelaFooter(voted, selectorForm) {
    if (voted == null) {
        
        if (document.querySelector(`${selectorForm} .poll-content`).hasClass('invisible')) {
            content = `<p onclick='pollView("${idForm}")' title='Veja resultados desta pesquisa'>Ver resultados</p>`;
        } else {
            content = `<p onclick='pollView("${idForm}")' title='Votar'>Voto</p>`;
        }

        document.querySelector(`${selectorForm} .poll-footer`).innerHTML = content;
    }
    else {
        content = "";
        document.querySelector(`${selectorForm} .poll-footer`).innerHTML = content;
    }
}

function totalVotes(totalVotes) {
    var votes = 0;

    totalVotes.forEach(vote => {
        votes += parseInt(vote);
    });

    return votes;
}

function satisfaction(varVoteValue, totalVotes, voted, textSatisfaction) {
    content += "<li>";

    // opções de satisfação:
    switch (textSatisfaction) {
        case 0:
            if (voted == 4) {
                content += "<p class='voted'>Ótimo"
            } else {
                content += "<p>Ótimo";
            }
            break;
        case 1:
            if (voted == 3) {
                content += "<p class='voted'>Bom"
            } else {
                content += "<p>Bom";
            }
            break;
        case 2:
            if (voted == 2) {
                content += "<p class='voted'>Regular"
            } else {
                content += "<p>Regular";
            }
            break;
        case 3:
            if (voted == 1) {
                content += "<p class='voted'>Ruim"
            } else {
                content += "<p>Ruim";
            }
            break;
        case 4:
            if (voted == 0) {
                content += "<p class='voted'>Péssimo"
            } else {
                content += "<p>Péssimo";
            }
            break;
    }


    content += `<small> (${porcent(varVoteValue, totalVotes)}%, ${varVoteValue} votos)</small></p>
    </li>`;
}


// porcentagem de votos
function porcent(vote, totalVotes) {
    if(totalVotes == 0){
        return 0;
    }
    return Math.round((vote / totalVotes) * 100);
}

function opacity(poll, pollVotes) {
    poll.classList.toggle("invisible");
    pollVotes.classList.toggle("invisible");
}

function setAttributeData(form, value) {
    document.querySelectorAll(`${form} input[data-voted='true']`).forEach((el) => {
        el.removeAttribute("data-voted");
    }) // remover atributos dataset de outros inputs (para caso houver a opção de alterar voto)

    document.querySelector(`${form} input[value="${value}"]`).setAttribute("data-voted", "true"); // adicionar atributo ao elemento selecionado
}

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