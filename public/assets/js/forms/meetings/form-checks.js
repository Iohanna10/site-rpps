var months30d = ['april', 'june', 'september', 'november']; // array de meses com 30 dias

function datepicker() { // mudar configurações do input de data
    const calendarStart = document.getElementById("start_meeting");
    const hourStart = document.getElementById("start_time");
    const calendarEnd = document.getElementById("end_meeting");
    const hourEnd = document.getElementById("end_time");


    const calendars = [calendarStart, calendarEnd, hourStart, hourEnd];

    var currentDate = ISOStandart(new Date().getTime()); // data atual

    // console.log(currentDate)

    calendars.forEach(calendar => {
        calendar.min = currentDate.split("T")[0]; // impossibilitar escolher uma data que já passou

        calendar.addEventListener('focusout', () => {
            currentDate = ISOStandart(new Date().getTime()); // atualizar data atual

            // calendário //

            // calendário: inicial // 
            if (calendarStart.value < currentDate.split("T")[0]) { // não deixar adicionar evento em data que já passou
                calendarStart.value = currentDate.split("T")[0];
            }

            // calendário: inicial // 
            calendarEnd.min = new Date(calendarStart.value).toISOString().split("T")[0]; // definir data de término para o mesmo dia de início 

            if (calendarStart.value > calendarEnd.value) { // impossibilitar colocar uma data menor que a inicial para o fim do evento
                calendarEnd.value = new Date(calendarStart.value).toISOString().split("T")[0]; // 
            }

            // horário

            // horário: inicial // 
            if (hourStart.value == '') { // adicionar horário inicial automaticamente caso o mesmo ainda não esteja setado
                hourStart.value = `${splitHour(currentDate.split("T")[1])[0]}:${splitHour(currentDate.split("T")[1])[1]}`;
            }
            else if (new Date() > new Date(ISOStandart(new Date(`${calendarStart.value}T${hourStart.value}:00`).getTime()))) { // caso já estiver setado, verificar (caso seja o dia atual) se é um horário que ainda não passou 

                hourStart.value = `${splitHour(currentDate.split("T")[1])[0]}:${splitHour(currentDate.split("T")[1])[1]}`;
                hourStart.min = `${splitHour(currentDate.split("T")[1])[0]}:${splitHour(currentDate.split("T")[1])[1]}`;
            }

            // horário: final // 
            if (hourEnd.value == '') { // adicionar horário final automaticamente caso o mesmo ainda não esteja setado
                hourEnd.value = `${splitHour(currentDate.split("T")[1])[0]}:${splitHour(currentDate.split("T")[1])[1]}`;
            }
            else if (new Date(ISOStandart(new Date(`${calendarStart.value}T${hourStart.value}:00`).getTime())) > new Date(ISOStandart(new Date(`${calendarEnd.value}T${hourEnd.value}:00`).getTime()))) { // verificar se é maior que o horário inicial (caso seja o mesmo dia)
                hourEnd.value = hourStart.value
            }
        })
    });

}

function splitHour(hour) {
    return hour.split(":")
}

function ISOStandart(time) {
    let data = new Date(time); // data com fuso horário

    let standart = new Date(data.valueOf() - data.getTimezoneOffset() * 60000); // data sem fuso horário
    return standart.toISOString().replace(/\.\d{3}Z$/, '');
}

function daysMonth() { // selecionar a quantidade de dias q cada mês possui
    document.querySelectorAll(".days-meetings select").forEach(month => {
        if (month.name === 'february') // fevereiro
            if (leapYear()) // se for ano bissexto
                getDaysM(month, 29)
            else // não for ano bissexto
                getDaysM(month, 28)
        else if (months30d.includes(month.name)) // meses com 30 dias
            getDaysM(month, 30)
        else // meses com 31 dias
            getDaysM(month, 31)
    })
}

function getDaysM(select, days) { //  colocar dias nos selects de data de reunião
    for (let day = 1; day <= days; day++) {
        const optionsHTML = `<option value="${day}">${day}</option>`;
        select.insertAdjacentHTML("beforeend", optionsHTML);
    }
}

function leapYear() { // verificar se é ano bissexto

    const year = new Date().getFullYear();

    if (year % 400 == 0) // é divisivel por 400?
        return true
    else
        if (year % 4 == 0 && year % 100 != 0) // é divisivel por 4 e por 100?
            return true
        else
            return false
}

function enableSwitch() {
    document.querySelector(".switch__container").addEventListener("click", () => {
        if (document.querySelector("#switch-shadow").checked == true) {
            document.querySelector("#switch-shadow").checked = false;
        } else {
            document.querySelector("#switch-shadow").checked = true;
        }
    })
}

function startTimeUnique() {
    document.querySelectorAll("input[name='time']").forEach((inputTime) => {
        inputTime.addEventListener('change', (el) => {
            if (document.querySelector("#switch-shadow").checked == true) {
                changeUniqueVal(el.target.value);
            }
        })
    })
}

function changeUniqueVal(hour) {
    document.querySelectorAll("input[name='time']").forEach((inputTime) => {
        if(inputTime.disabled === false){
            inputTime.value = hour;
        }
    })
}

function selectDays(){
    document.querySelectorAll(".days-meetings select").forEach(select => {
        select.selectedIndex = (select.dataset.value - 1);
    })
}