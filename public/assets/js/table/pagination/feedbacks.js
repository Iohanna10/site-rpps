const feedbacks = async (pg, rating, comments) => {
    const data = await fetch(getUriRoute(`${getInstitute()}/feedbacks/dados-lista?pg=${pg}&&rating=${rating}&&onlyComments=${comments}`));
    const html = await data.text();
    
    var section = document.createElement("section");
    section.id = "feedbacks";
    section.innerHTML = html;
    section.style.display = "none";

    if(document.getElementById('feedbacks') !== null){
        contentList.children.feedbacks.remove();
    }
    contentList.appendChild(section);

    contentList.children.feedbacks.style.display = "flex";

    document.querySelectorAll("#form-filter select").forEach(el => {
        el.addEventListener('change', () => {
            feedbacks(1, document.getElementById('rating-note').value, document.getElementById('feedback-only').value)
        })
    });
}

function getFeedbacks(){
    contentList = document.querySelector(".contents")
    feedbacks(1, false, false);
}

function getFiltersFeedbacks(){
    return [document.getElementById('rating-note').value, document.getElementById('feedback-only').value]
}