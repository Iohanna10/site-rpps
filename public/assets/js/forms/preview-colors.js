function addPreviewColors(){
    document.querySelectorAll("input[type=color]").forEach(input => input.addEventListener('change', () => {
        viewColors();
    }));
}

function getColorsPreview(id){
    return document.getElementById(id).value
}

function viewColors(doc = document.getElementById('preview-colors')){
    doc = doc.contentWindow.document.documentElement; // pegar corpo da preview

    doc.style.setProperty("--cor-primaria", getColorsPreview("primary"));
    doc.style.setProperty("--cor-secundaria", getColorsPreview("secundary"));
    doc.style.setProperty("--cor-highlight", getColorsPreview("highlight"));
}

/**
 * adicionar pré visualização nos iframes
 * @param {boolean} baseColors utilizar cores base?
 */
async function iframePreview(baseColors = false){
    var form = document.getElementById('formPost'),
    id = form.dataset.id !== undefined ? form.dataset.id : null;

    if(!baseColors)
        return applyThemePreview(id);
    return viewColors();
}