var labelFormSearch = document.querySelector("#labelSearch");
var inputFormSearch = document.querySelector("#search_mb");

inputFormSearch.addEventListener("focus", () => {
    labelFormSearch.classList.add("inactive");
});

inputFormSearch.addEventListener("blur", () => {
    if(!inputFormSearch.value.length > 0){
        labelFormSearch.classList.remove("inactive");
    }
});
