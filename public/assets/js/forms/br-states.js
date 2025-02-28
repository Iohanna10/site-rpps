function optionsStates(){
    let url = "https://raw.githubusercontent.com/wgenial/br-cidades-estados-json/master/estados.json";
    
    let req = new XMLHttpRequest();
    req.open("GET", url);
    req.send();

    // tratar a resposta da requisição
    req.onload = function () {
        if(req.status === 200){
            let html = '<option value="NULL">Selecioinar Estado</option>';
            let states = JSON.parse(req.response);

            states.estados.forEach(state => {
                if (document.getElementById("state").dataset.selected === state.id) 
                    html += `<option value="${state.id}" selected>${state.estado}</option>`;
                else  
                    html += `<option value="${state.id}">${state.estado}</option>`; 
            });

            document.getElementById("state").innerHTML = html;
        }
        else {
            alert("erro na requisição")
        }
    }
}