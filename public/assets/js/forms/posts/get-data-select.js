function getDataSelect_post() {
    var select = document.querySelector("select[name=area-post]"); 
    
    if(select != null){
        changeOptions(select.value);
    
        // evento ao mudar de opção do select
        select.addEventListener('change', function(){
            changeOptions(select.value);
        })
    }

    selectCommittee = document.querySelector("select[name=committee]");

    selectCommittee.addEventListener('change', () => {
        changeOptionsCommittee(selectCommittee.value);
    })
}

// trocar opções para as áreas possíveis de postar de acordo com a área principal selecionada

function changeOptions(areaSelect) {
    options = [];
    choose = false;

    switch (areaSelect) {
        case "NULL":
            options = ["Nenhum"]

            startCount = '';
            break;
        case "0":
            options = ["Histórico", "Código de Ética", "Concurso", "Processo Seletivo", "Educação previdenciária", "Plano de ação", "Gestão e Controle Interno", "Segurança da Informação", "Manual de Procedimentos de Benefícios", "Manual de Arrecadação", "Manual de Procedimentos: Gestão de Investimentos"]

            startCount = 0;
            break;

        case "1":
            options = ["Constituição Federal", "Instruções Normativas MPS", "Leis Federais", "Orientações MPS", "Portarias MPS", "Resoluções CMN", "Leis Municipais", "Portarias"];

            startCount = 11;
            break;

        case "2":
            options = ["Audiência Pública", "Balancete Anual", "Balancete Mensal", "Demonstrativos Financeiros", "DAIR", "DIPR", "Parcelamentos", "Política de Investimentos", "Acordãos TCE", "Certidões Negativas", "Cronograma de Pagamentos", "Contratos e Licitações"];
            
            startCount = 19;
            break;

        case "3":
            options = ["Calendário de Reuniões", "Atas das Reuniões", "Resoluções", "Regimento Interno", "Composição da Carteira de Investimentos", "Política de Investimentos", "Credenciamento das Instituições Financeiras", "Relatório Mensal de Investimentos", "Relatório Anual de Investimentos", "Aplicações e Resgates", "Estudo de ALM"];
            
            selectCommittee.options.selectedIndex = 0;

            choose = true;

            startCount = 31;
            break;  

        case "4":
            options = ["Informativo Semestral"];

            startCount = 50;
            break;
            
        case "5":
            options = ["Solenidade", "Cartilha Previdenciária"];

            startCount = 51;
            break; 
    }

   constructorHTML(options, startCount);
   chooseAdvice_post(choose);
}

function changeOptionsCommittee(areaSelect) {
    options = [];

    switch (areaSelect) {
        case "0":
            options = ["Calendário de Reuniões", "Atas das Reuniões", "Resoluções", "Regimento Interno", "Composição da Carteira de Investimentos", "Política de Investimentos", "Credenciamento das Instituições Financeiras", "Relatório Mensal de Investimentos", "Relatório Anual de Investimentos", "Aplicações e Resgates", "Estudo de ALM"];

            startCount = 31;
            break;

        case "1":
            options = ["Calendário de Reuniões", "Atas das Reuniões", "Resoluções", "Regimento Interno"];

            startCount = 42;
            break;

        case "2":
            options = ["Calendário de Reuniões", "Atas das Reuniões", "Resoluções", "Regimento Interno"];
            
            startCount = 46;
            break;
    }

   constructorHTML(options, startCount);
}

// construir HTML das opções 

function constructorHTML(options, startCount){
    var optionsSelect = document.querySelector("select[name=type-post]");

    optionsSelect.innerHTML = "";

    for (let index = 0, value = startCount; index < options.length; index++, value++) {
        var optionsHTML = `<option value="${value}">${options[index]}</option>`;
        optionsSelect.insertAdjacentHTML("beforeend", optionsHTML);
    };
}

function chooseAdvice_post(choose){
    if(choose == true){
        document.querySelector(".container-committee").style.display = "flex";
        choose = false;
    } else {
        document.querySelector(".container-committee").style.display = "none";
    }
}