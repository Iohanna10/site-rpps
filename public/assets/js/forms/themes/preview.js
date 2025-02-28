async function previewTheme(id) {
    var 
    iframe = await refreshIframe(document.getElementById('preview-themes'));
    
    iframe.onload = () => {
        toggleLoader('on'); // ligar loader

        setTimeout(async () => {
            await applyThemePreview(id, iframe); // adicionar as cores e efeitos no iframe do modal de visualização
        }, 150);

        toggleLoader('off'); // desligar loader
    }

    // abrir modal de visualização
    modalPreview();
}

async function applyThemePreview(id = null, iframe = document.getElementById('preview-colors')) {
    var data = {
        id: id,
        data_ajax: true,
    };

    $.ajax({
        method: "POST",
        url: getUriRoute("ajax/ajax-institute/themes/preview"),
        data: data,
        success: async function (response) {
            // atualizar iframe
            var doc = iframe.contentWindow.document, // pegar corpo da preview
            html = doc.documentElement // elemento <html>

            // alterar variáveis de cor 
            html.style.setProperty("--cor-primaria", response['cor_principal']); // principal
            html.style.setProperty("--cor-secundaria", response['cor_secundaria']); // secundária
            html.style.setProperty("--cor-highlight", response['cor_destaque']); // destaque
            
            // alterar imagem do banner
            await addBannerHtml(html, response);
        }
    })
    
}

async function refreshIframe(iframe) {
    await toggleLoader('on');

    // recarregamento do src do iframe
    iframe.src = iframe.src;
    return iframe;
}

/**
 * @param {string} toggle - deve ser definido somente como 'on' ou 'off'.
*/
async function toggleLoader(toggle) {
    var 
    loader = document.querySelector('.loader'), 
    iframe = document.querySelector('#preview-themes'); 

    if (toggle === 'on') {
        loader.style.display = 'flex'; // visualizar div de carregamento    
        iframe.style.zIndex = '-10'; // impedir visualização do iframe
    }

    else if(toggle === 'off') {
        loader.style.display = 'none'; // remover visualização da div de carregamento
        iframe.style.zIndex = '1'; // permitir visualização do iframe
    }
}

async function addBannerHtml(html, response) {
    var bannerSection = html.querySelector('#banners'); // pegar banner 
    
    if(bannerSection !== null) {
        bannerSection.parentNode.removeChild(bannerSection); // remover do html 
    }

    bannerSection = document.createElement("section"); // criar novo elemento
    bannerSection.setAttribute('id', 'banners');
    
    if(response['banner'] != null) {
        var newSectionBanner = ``;

        if(response['url_banner'])
            newSectionBanner += `<a href="${response['url_banner']}" class="link-banner" target="_blank">`

        newSectionBanner +=
            `<div class="full-banner">
                <div class="img-banner max-width-container">`

                if(parseInt(response['predefinido']) == true)
                    newSectionBanner += `<img src="${getUriRoute(`assets/img/banners/${response['banner']}`)}" alt="banner">`
                else
                    newSectionBanner += `<img src="${getUriRoute(`dynamic-page-content/${getInstitute()}/assets/uploads/img/banners/${response['banner']}`)}" alt="banner">`

        newSectionBanner +=
                `</div>
            </div>`

        if(response['url_banner'] != null)
            newSectionBanner += `</a>`

        newSectionBanner += `</section>`

        bannerSection.innerHTML = newSectionBanner;
        html.querySelector(".hero").insertAdjacentElement('beforebegin', bannerSection);
    }
}
