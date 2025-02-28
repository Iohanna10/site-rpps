const modalEvents = document.getElementById("modal-events");
    
const showEvents = async (date) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/calendar/events?date=${date}&&institute=${getInstitute()}`));
    const html = await data.text();
    modalEvents.innerHTML = html;

    showModal();
    closeModalBtn();
}

const infosEvent = async (id, date) => {
    var infoEvents = document.querySelector(".events-info");

    const data = await fetch(getUriRoute(`${getInstitute()}/calendar/events-infos?id=${id}&&institute=${getInstitute()}&&date=${date}`));
    const html = await data.text();
    infoEvents.innerHTML = html;
}

function showModal(){
    modal = document.getElementById("modal-events");
    bgModal = document.querySelector(".bg-modal");

    bgModal.style.display = 'flex';
    modal.style.display = 'block';
}

function closeModalBtn(){
    document.getElementById("close-modal").addEventListener('click', () => {
        document.querySelector(".bg-modal").style.display = 'none';
    })

    document.querySelector(".container-modal").addEventListener('click', (e) => {
        if(e.target == document.querySelector(".container-modal")){
            document.querySelector(".bg-modal").style.display = 'none';
        }
    })
}