const tbody = document.getElementById("pg-config");
let contentList; // declarar variavel que irá receber o html das listas 

const getPg = async (pg) => {
    if(pg != 'crps' && pg != 'calculo-atuarial'){
        var data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/${pg}`));
    }
    else {
        var data = await fetch(getUriRoute(`${getInstitute()}/cadastro/${pg}`));
    }

    const html = await data.text();
    tbody.innerHTML = html;

    activeFunctions(pg);
    changeTitle(pg);

    document.querySelectorAll("#btnModal, .bg-modal").forEach((el) => { // ativar o close modal
        el.addEventListener("click", () => {
            closeModal()
        })
    })

    document.querySelectorAll("#pg-config button").forEach(btn => { // ativar a verificação de sessão antes de enviar dados para serem alterados 
        btn.addEventListener('click', () => {
            verifySession();
        })
    })

    if(window.screen.width <= 768 && document.querySelector(".nav-menu").hasClass('active')){
        toggleMenu();
        document.querySelector(".nav-menu").style.display = 'flex';
    }
}

getPg('informacoes');

$(document).ready(() => {
    document.querySelectorAll('.link').forEach((el) => {
        el.addEventListener('click', () => {
            verifySession();

            if(el.dataset.pg != undefined){      
                getPg(el.dataset.pg)
                resetTinyMCE()
            }
        })
    })
})

function activeFunctions(pg){
    switch (pg) {
        case 'informacoes':
            optionsStates();
            cep();
            getListLogos();
            activeTabs();
            configInfos();
            break;

        case 'personalizar':
            configCustomize();
            addPreviewColors();
            getListsThemes();
            filtersThemes() ;
            break;
    
        case 'avaliacoes':
            getFeedbacks();
            break;
        
        case 'galerias':
            filtersGallery();
            listGallery(1, getFilters_gallery());
            break;

        case 'publicacoes':
            filtersPost();
            listPosts(1, getFilters_post());
            getDataSelect_post();
            break;
        
        case 'equipe':
            listMembers(1);
            activeInputChange();
            break;
        
        case 'eventos':
            configEvents();
            filtersEvents();
            typeForm();
            break;
        
        case 'calculo-atuarial':
            configReports();
            getListReports();
            activePreview_PDF();
            break;
            
        case 'crps':
            configCRPS();
            getListCRPS();
            activePreview_PDF();
            break;
    }
}

function changeTitle(pg) {
    if(pg == 'crps'){
        document.querySelector('.infos-menu .current-page h2').innerHTML = "Certificados de Regularidade Previdenciária";
        return 
    }
    document.querySelector('.infos-menu .current-page h2').innerHTML = document.querySelector(`.link[data-pg=${pg}] p`).innerHTML
}

function resetTinyMCE(){
    tinyMCE.remove();
}

function verifySession() {
    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/verify-session"),
        success: function (response){  
            if(!response){ // caso não conectado
                window.location.href = getUriRoute(`${getInstitute()}/login`);
            }
        }
    })
}