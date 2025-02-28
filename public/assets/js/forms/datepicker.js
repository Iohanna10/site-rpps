/**
 * ativar o datepicker
 */
function activeDatePicker() {
    var dates = $( "#initial_date, #final_date" ).datepicker({
        defaultDate: '2024/01/01',
        changeYear: true, 
		changeMonth: true,
		dateFormat: 'yy/mm/dd',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: '>',
        prevText: '<',
        beforeShow: function() { // adicionar uma classe antes de mostrar o seletor de data
            $('#ui-datepicker-div').addClass('disabled-year');
            hideKeyboard( this );
        },
		onSelect: function( selectedDate ) { // impedir a seleção de uma data inicial maior que a final e vice-versa
			var option = this.id == "initial_date" ? "minDate" : "maxDate", 
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date ); // atribuir filtro para seleção de data inicial/final

            document.querySelector(`#visual_${this.id}`).value = `${date.getDate().toString().padStart(2, "0")}/${(date.getMonth()+ 1).toString().padStart(2, "0")}`; // alterar valor do input visual
		},
	}).keydown(function(e) { // bloquear entradas via teclado
        e.preventDefault();
    })
}

/**
 * verificar se é uma data real
 * @param {HTMLElement} inp input de data
 * @returns boolean
 */
async function isRealDate (inp) {
    var 
    sDate = inp.value.split('/'), // data separada (formato dd/mm)
    strDay = sDate[0].length == 2 ? `${sDate[0]}` : `0${sDate[0]}`,
    strMonth = sDate[1].length == 2 ? `${sDate[1]}` : `0${sDate[1]}`,
    date = {
        day: parseInt(strDay),
        month: parseInt(strMonth)
    }
    months30d = [4, 6, 9, 11], // meses com 30 dias (abril, junho, setembro, novembro)
    maxDay = months30d.includes(date['month']) == true ? 30 : 31 // qnt de dias máx. 30 ou 31

    //  validar se os valores de entrada são dias e meses
    if(date['month'] >= 1 && date['month'] <= 12){
        if (date['month'] == 2 && (date['day'] >= 1 && date['day'] <= 29)){ // fevereiro
            return true;
        } 
        
        if(date['month'] != 2 && date['day'] >= 1 && date['day'] <= maxDay){
            return true;
        }
    }
    return false;
}

function hideKeyboard(element) {
    element.setAttribute('readonly', 'readonly'); // Force keyboard to hide on input field.
    element.setAttribute('disabled', 'true'); // Force keyboard to hide on textarea field.
    setTimeout(function() {
        element.blur();  // Actually close the keyboard
        // Remove readonly and disabled attributes after keyboard is hidden.
        element.removeAttribute('readonly');
        element.removeAttribute('disabled');
    }, 100);
}
