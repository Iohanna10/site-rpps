let tabs;

function activeTabs(){
    tabs = document.querySelectorAll(".tabs");
    
    tabs.forEach(mainTab => {
        tabsBtns = mainTab.querySelectorAll(".tab-btn");

        tabsBtns.forEach(tabBtn => tabBtn.addEventListener('click', () => {
            tabClicked(tabBtn, mainTab);
        }));
    });
}

function tabClicked(tab, mainTab){
    mainTab.querySelectorAll(".tab-btn").forEach(content => content.classList.remove("active"));
    tab.classList.add('active');

    var contents = mainTab.querySelectorAll(`.tab-content`);
    contents.forEach(content => content.classList.remove("show"));

    var contentId = tab.getAttribute('content-id');
    var content = document.getElementById(contentId)

    content.classList.add('show')
}

Node.prototype.hasClass = function(value) { // verificar se o elemento possui a classe
    var
        has = true,
        names = String(value).trim().split(/\s+/);

    for(var i = 0, len = names.length; i < len; i++){
        if(!(this.className.search(new RegExp('(?:\\s+|^)' + names[i] + '(?:\\s+|$)', 'i')) > -1)) {
            has = false;
            break;
        }
    }
    return has;
};