<?php
    // pegar endereço pela url

    $url = parse_url($_SERVER["REQUEST_URI"]);

    $dataGet = $_SERVER["QUERY_STRING"];
    $urlFull = str_replace(array("RPPS/", "public/", ".", "?", "rpps.com.br/", $dataGet), "", $url['path']);
    $urlFull = explode("/", $urlFull);
    $url = $urlFull;
    
    if(isset($url[1])){
        $url = $url[1];
    }