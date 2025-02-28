var listUserThemes = async (pg, filters) => {
    userThemesList = document.getElementById("user_themes");

    const data = await fetch(`${getUriRoute(getInstitute())}/configuracoes-instituto/temas/user/dados-lista?pg=${pg}&&${filters}`);
    const html = await data.text();
    userThemesList.innerHTML = html;
    activeThemesActivity();
}

function getFilters_themes(){
    data = {
        start_date: document.getElementById("start_date").value,
        end_date: document.getElementById("end_date").value,
        name: document.getElementById("name").value,
    }

    return `initial_date=${data.start_date}&&final_date=${data.end_date}&&name=${data.name}`;
}
