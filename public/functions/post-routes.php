<?php

// Alterar titulo do post para rota
function namePost($nomePost){
    // deixar sem acentos e com "-" no lugar de espaço
    
    /* $comAcentos = array("á", "à", "ã", "â", "Á", "À", "Ã", "Â", "é", "è", "ê", "É", "È", "Ê", "í", "ì", "Í", "Ì", "ó", "ò", "õ", "ô", "Ó", "Ò", "Õ", "Ô", "ú", "ù", "Ú","Ù");
    $semAcentos = array("a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i",  "o", "o", "o", "o", "o", "o", "o", "o", "u", "u",  "u", "u");
    $comPontuacao = array(" ", "/", "ª", "º", ",", ".");
    $semPontucao = array("-", "-", "a", "o", "", "");

    return str_replace($comPontuacao, $semPontucao, str_replace($comAcentos, $semAcentos, $nomePost)); */

    return $nomePost;
}

// criar rota
function linkRoutePosts($urlFull, $nomePost) {
    $link = "";
    for ($i = 1; $i < count($urlFull); $i++) { 
        $link = $link . "/" . $urlFull[$i];
    }
    return $link . "?post=" . strtolower(namePost($nomePost));
}