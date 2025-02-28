function clearAll(){
    document.querySelectorAll("input,textarea").forEach(inp => {
        if(typeof tinymce !== 'undefined'){
            if(tinymce.get(`${inp.id}`)){
                tinymce.get(`${inp.id}`).setContent('');
            }
        }

        inp.value = '';
    })

    document.querySelectorAll("input[type=file]").forEach(inp => {
        inp.files = (new DataTransfer()).files;
        inp.dispatchEvent(new Event('change'));
    })

    if(document.querySelector(".infos_container .infos_area") != undefined){
        removeAllinfo();
    }
}