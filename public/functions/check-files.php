<?php

function checkFiles($name, $date){
    
    // pegar a url
    require("config/content-config.php");
        
    if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/posts/$date/$name")){
        return '<div><img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/posts/$date/$name") .'"></div>';
    } 
    elseif(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/video/posts/$date/$name")){
        return '
        <video style="display: table; margin-left: auto; margin-right: auto;" controls="controls" width="600" height="300">
            <source src="'. base_url("dynamic-page-content/$url/assets/uploads/video/posts/$date/$name") .'" type="video/mp4" data-mce-fragment="1">
        </video>';
    }
    else {
        return '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'. $name .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
    }
}
?>