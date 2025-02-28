function typeForm(){
    if(document.querySelector("#type_post") != null){
        document.querySelector("#type_post").addEventListener("change", select => { // chamar função para trocar o html
            if (select.target.value == 'evento') // chamar função para trocar o form
                htmlForm("eventForm"),
                chooseAdvice_event(false, 'register')
            else
                htmlForm("meetingForm"),
                chooseAdvice_event(true, 'register')
        })
    }
    
    if(document.querySelector("#typeEvent") != null){
        document.querySelector("#typeEvent").addEventListener("change", select => { // chamar função para trocar o html
            if (select.target.value == 'reuniao') // chamar função para trocar o form
                chooseAdvice_event(true, 'edit')
            else
            chooseAdvice_event(false, 'edit')
        })
    }
}


function chooseAdvice_event(choose, type) { // select conselho
    if (choose == true) {
            htmlSelect =
                `<div class="container-committee">
                <label for="committee">Conselho:</label>
                <select name="committee" id="committee">`;
                    
            if(type === 'edit'){
                htmlSelect += `<option value="" selected>Todos</option>`;
            }

            htmlSelect +=
                    `<option value="31">Comitê de Investimento</option>
                    <option value="42">Fiscal</option>
                    <option value="46">Deliberativo</option>
                </select>
            </div>`;

        document.querySelector("#type").insertAdjacentHTML("beforeend", htmlSelect)
    } else {
        if(document.querySelector(".container-committee") != null){
            document.querySelector(".container-committee").parentNode.removeChild(document.querySelector(".container-committee"));
        }
    }
}