/**
 * Pegar dados do tema em uso no DB
 * @returns colors[]
 */
async function ajaxColors(){
    var data = new Promise((resolve, reject) => 
        $.ajax({
            method: "POST", 
            url: getUriRoute(`${getInstitute()}/get-colors`),
            success: function (response){ 
                let theme = {
                    primary: response['cor_principal'],
                    secundary: response['cor_secundaria'],
                    highlight: response['cor_destaque'],
                };
                
                resolve(theme);
            }
        })
    )

    return data;
}

/**
 * Alterar as cores do site ao carregar
 */
async function getColors() {
    var theme = await ajaxColors(),
    htmlDoc = document.documentElement;

    htmlDoc.style.setProperty("--cor-primaria", theme.primary);
    htmlDoc.style.setProperty("--cor-secundaria", theme.secundary);
    htmlDoc.style.setProperty("--cor-highlight", theme.highlight);
}

$(document).ready(() => {
    getColors();
})