document.querySelector(".btn.account").addEventListener("click", () => {
    toggleAccount();
})

var divProfile = $('.invisible-itens')[0];
divProfile.addEventListener('mouseout', (e) => {
    if(document.querySelector(".min-profile").style.display == 'flex'){
        if(!(divProfile.matches(':hover'))){
            toggleAccount();
        }
    }
})
   
function toggleAccount() {
    var profile = document.querySelector(".min-profile");
    var menu = document.querySelector(".menu-section");
    var menuSupHeigth = document.querySelector('.nav-superior').offsetHeight;

    if(profile.style.display == "flex"){
        profile.style.display = "none";
        menu.style.height = 'auto';
    } else {
        profile.style.display = "flex"
        profile.style.top = (menuSupHeigth - 1) + "px";
        menu.style.height = profile.offsetHeight + menuSupHeigth + 10 + 'px';
    }
}
