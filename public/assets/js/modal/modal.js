function modal(msg){
    document.querySelector(".modal-info p").innerHTML = msg;
    document.querySelector(".modal-info").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'flex';
    
    if (document.querySelector(".modal-info h1.success") != null) {
        document.querySelector(".modal-info h1.success").innerHTML = '';
    }
}

function confirmModal(msg, fName, fParams = ''){
    document.querySelector(".modal-confirm p").innerHTML = msg;
    document.querySelector(".modal-confirm").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'flex';

    // função completa
    f = `${fName}('${fParams}')`;

    if(fParams === ''){ // caso não houver parâmetros
        f = `${fName}()`; 
    }
    
    document.querySelector("#btnModalConfirm").setAttribute('onclick', `${f}; closeModal()`);
}

function modalSuccess(msg, success){
    if(success){
        document.querySelector(".modal-info h1").innerHTML = `<i class="success fa-sharp fa-solid fa-check"></i>`; // sucesso
    } 
    else {
        document.querySelector(".modal-info h1").innerHTML = `<i class="error fa-sharp fa-solid fa-xmark"></i>`; // erro
    }

    document.querySelector(".modal-info p").innerHTML = msg;
    document.querySelector(".modal-info").style.display = 'flex';
    document.querySelector(".bg-modal").style.display = 'flex';
}

function modalPreview() {
    document.querySelector(".bg-modal").style.display = 'flex';
    document.querySelector(".modal-preview").style.display = 'flex';
}

$(document).ready(function () {
    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => {
        el.addEventListener("click", () => {
            closeModal()
        })
    })
})

function closeModal(){
    if(document.querySelector(".modal-info") != undefined){
        document.querySelector(".modal-info").style.display = 'none'; // deixar aqui para não ter que trocar a classe em todos os arquivos que estão usando o modal
    } 

    if(document.querySelector(".modal") != undefined) {
        document.querySelector(".modal").style.display = 'none'; 
    }

    if(document.querySelector(".modal-preview") != undefined) {
        document.querySelector(".modal-preview").style.display = 'none'; 
    }

    document.querySelector(".bg-modal").style.display = 'none';
}