function activeThemesActivity() {
    var inputs = document.querySelectorAll('input[name=activity]');

    inputs.forEach(el =>{
        el.addEventListener('change', function(el){ 
            if(!(el.target.checked) === false)
                changeActivity(this.dataset.id, true);
            else
                changeActivity(this.dataset.id, false);
        });
    })
};

function changeActivity(id, activity) {
    data = {
        id: id,
        activity: activity,
    };

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-institute/themes/activity"),
        data: data,
        success: async function (response){
            if(!response){
                modal("Não foi possível alterar a atividade do tema, tente novamente mais tarde.")
            }

            getColors();
        }
    })
}
