const tbody = document.querySelector(".list-users");

const listUsers = async (pg, date) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/segurados/aniversario/dados-lista?pg=${pg}&&date=${date}`));
    const html = await data.text();
    tbody.innerHTML = html;
}

listUsers(1, document.querySelector(".list-users").dataset.date);