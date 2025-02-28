const urlParams = new URLSearchParams(window.location.search);
const data = {};
data.key = urlParams.get("key") // chave
data.institute = getInstitute() // instituto

$(document).ready(() =>{
    $.ajax({
        method: "POST", 
        url: getUriRoute(`${getInstitute()}/validar-email`),
        data: data,
        success: function (response){  
            resultValidade(response)
        }
    })
})

function resultValidade(result) {
     if(result.bool){
        document.querySelector(".statusCheck img").src = `${getUriRoute()}assets/img/status_envelope_positive_done_success_checked_email.png`;
    } else {
        document.querySelector(".statusCheck img").src = `${getUriRoute()}assets/img/status_envelope_negative_error_email.png`;
    }
    document.querySelector(".msg").innerHTML = `${result.msg}`;
    document.querySelector("#redirect").innerHTML = 'Entrar';
    
    document.querySelector("#redirect").setAttribute('onclick', `redirect('${getUriRoute()}')`)
}

function redirect(path) {
    window.location.href = `${path}${getInstitute()}/login`
}