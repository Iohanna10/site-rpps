function searchCep(){
    let cep = document.getElementById("cep").value;
    
    if(cep !== '') {
        let url = "https://brasilapi.com.br/api/cep/v1/" + cep;
        
        let req = new XMLHttpRequest();
        req.open("GET", url);
        req.send();

        // tratar a resposta da requisição
        req.onload = function () {
            if(req.status === 200){
                let endereco = JSON.parse(req.response);

                document.getElementById("street").value = endereco.street;
                document.getElementById("neighborhood").value = endereco.neighborhood;
                document.getElementById("city").value = endereco.city;
                document.getElementById("state").value = endereco.state;
            }
            else {
                modal("Não encontramos este CEP, verifique se o inseriu corretamente. <br><br> Caso o CEP esteja correto, insira os dados manualmente.")
            }
        }
    }
}

function cep() {
    let cepInp = document.getElementById("cep")
    cepInp.addEventListener("keyup", () => {
        cepInp.value = mCep(cepInp.value);
    })
}