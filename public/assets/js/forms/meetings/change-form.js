const htmlForm = async (type) => { // função para trocar o html
    contentList = document.querySelector("#different-data");

    const data = await fetch(getUriRoute(`${getInstitute()}/cadastro/eventos/forms?type=${type}`));
    const html = await data.text();
    contentList.innerHTML = html;

    if (type != "eventForm") {
        daysMonth();
        enableSwitch();
        startTimeUnique();
    } else {
        datepicker();
    }
}