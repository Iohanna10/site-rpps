const htmlFormEdit = async (type, id) => { // função para trocar o html
    contentList = document.querySelector("#different-data")

    const data = await fetch(getUriRoute(`${getInstitute()}/configuracoes-instituto/eventos/forms?type=${type}&&id=${id}`));
    const html = await data.text();
    contentList.innerHTML = html;

    if (type != "evento") {
        daysMonth()
        enableSwitch()
        startTimeUnique()
        selectDays()
    } else {
        datepicker()
    }
}