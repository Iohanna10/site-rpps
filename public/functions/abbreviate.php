<?php

function abbreviate($text, $limit = 3){

    // remover tudo depois de "-"
    $text = removeHyphen($text);
   
    $noAbbr = array(" da ", " de ", " do ", " das ", " dos ", " a ", " e ", " o ", ": ");
    $abbr = array(" ", " ", " ", " ", " ", " ", " ", " ", " : ");
    
    $abbreviate = [];
    
    if ($limit >= count(explode(' ', str_replace($noAbbr, $abbr, $text)))) {
        return $text;
    } 
    else {
        $text = explode(' ', str_replace($noAbbr, $abbr, $text));

        foreach ($text as $key => $word) {
            $firstLetter = str_split($word);
            if($firstLetter[0] == ":"){
                $abbreviate[] = $firstLetter[0] . " ";
            } else {
                $abbreviate[] = $firstLetter[0];
            }
        }

        return implode("", $abbreviate);
    }
}

function removeHyphen($text) {
    $text = explode(" ", $text);
    $textMain = [];
    
    foreach ($text as $key => $word) {
        if ($word == "-" || $word == "–") {
            break;
        }
        $textMain[] = $word;
    }


    return implode(' ', $textMain);
}

