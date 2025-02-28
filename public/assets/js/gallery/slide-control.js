var toggleOn = false;
// :::::::::::::::::::::::::::::: toggle controles :::::::::::::::::::::::::::::: //

function toggleBtns(){
    document.querySelector(".control-buttons").classList.toggle("toggle-on");

    icon = setTimeout(function(){
        iconToggle(); // função trocar icon 
    }, 600);
}

function iconToggle() {
    if(toggleOn == true){
        document.querySelector(".toggle-ctrl span").innerHTML = "<i class='fa-solid fa-caret-up'>";
        toggleOn = false;
    } else{
        document.querySelector(".toggle-ctrl span").innerHTML = "<i class='fa-sharp fa-solid fa-caret-down'></i>";
        toggleOn = true;
    }
}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

// -------------------------- abrir/fechar tela cheia --------------------------- //

var screen = document.documentElement; // selecionar html

function btnFullScreenOpen(){
    openFullscreen(); // abrir tela cheia
    toggleIconFullScreen(); // alterar icon
}

function btnFullScreenClose(){
    closeFullscreen(); // fechar tela cheia
}

// função abrir tela cheia
function openFullscreen() {
    if (screen.requestFullscreen) {
        screen.requestFullscreen();
    } else if (screen.mozRequestFullScreen) { // Firefox 
        screen.mozRequestFullScreen();
    } else if (screen.webkitRequestFullscreen) { // Chrome, Safari & Opera 
        screen.webkitRequestFullscreen();
    } else if (screen.msRequestFullscreen) { // IE/Edge 
        screen.msRequestFullscreen();
    }
}

// função fechar tela cheia
function closeFullscreen() {
    if(document.fullscreenElement != null){
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { // Firefox 
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { // Chrome, Safari & Opera 
            toggleIconFullScreen(); // alterar icon
        } else if (document.msExitFullscreen) { // IE/Edge 
            document.msExitFullscreen();
        }

        toggleIconFullScreen();
    }
}

// função alterar icon
function toggleIconFullScreen() {
    document.querySelector(".ctrl .full-screen .off").classList.toggle("hidden");
    document.querySelector(".ctrl .full-screen .on").classList.toggle("hidden");
}

// ------------------------------------------------------------------------------ //

// :::::::::::::::::::::::::::::: infos das mídias :::::::::::::::::::::::::::::: //

function btnInfo(){
    document.querySelector(".media-info").classList.toggle("hidden");
}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: //

