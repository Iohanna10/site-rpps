function changeHighlight(id, highlighted) {
    data = {
        id: id,
        highlight: highlighted,
    };

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-post/highlight"),
        data: data,
        success: async function (response){
            if(response){
                if(highlighted){
                    document.querySelector('#post-list table').dataset.highlighted++;
                }
                else {
                    document.querySelector('#post-list table').dataset.highlighted--;
                }
            }
            else {
                modal("Não foi possível destacar a publicação")
            }
        }
    })
}

function activeHighlight() {
    var MAX_SELECT = 4; // Máximo de 'input' selecionados
    var inputs = document.querySelectorAll('input.limited');
    
    inputs.forEach(el =>{
        el.addEventListener('change', function(el){
            
            if(!(el.target.checked) === false){
                if(document.querySelector('#post-list table').dataset.highlighted >= MAX_SELECT ){
                    this.checked = false;
                    modal("O limite de publicações destacadas é quatro, para poder adicioná-la remova o destaque de alguma outra publicação.")
                } else {
                    changeHighlight(this.dataset.id, true);
                }
            } else {
                changeHighlight(this.dataset.id, false);
            }
        });
    })
};