$(document).ready(() => {
    verifyPollResponses()

    document.querySelectorAll(".poll-content input[data-voted='true']").forEach((el) => {
        var id = parseInt(el.dataset.id_poll);
        changeView(`#polls-form-${id}`, id, el.value)
    })
})

function verifyPollResponses(){
    if(document.querySelectorAll(".poll-content input[data-voted='true']").length == 12){
        enableFeedback();
    }
}

function enableFeedback(){
    var feedback = document.querySelector("#feedback")

    feedback.removeAttribute("disabled")

    feedback.placeholder = "Digite o feedback/opinião sobre o instituto...";

    document.querySelector(".btn-feedback").addEventListener("click", () => {
        ajaxFeedback(document.querySelector("#feedback").value);
    })
}

function ajaxFeedback (data) {
    data = {
        feedback: data,
    }

    $.ajax({
        method: "POST", 
        url: getUriRoute("ajax/ajax-polls/registerFeedback"),
        data: data,
        success: function (response){  
            if(response){
                if(response[0] == true){
                    modal(response.msg)
                } else [
                    modal(response.msg)
                ]
            }
        }
    })
}