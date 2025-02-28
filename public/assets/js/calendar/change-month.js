// área calendário
const tbody = document.querySelector(".calendar");

// trocar dados do calendário
var calendar = async (institute, date) => {
    const url = getUriRoute(`${getInstitute()}/calendar`);
    const calendar = await fetch(url, {
        method: 'POST',
        body: new URLSearchParams({
            month: date,
            institute: institute
        })
    });

    const html = await calendar.text();
    tbody.innerHTML = html;
}

var date = new Date();

calendar(getInstitute(), `${date.getFullYear()}-${date.getMonth() + 1}-01`);

