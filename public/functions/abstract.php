<?php

function abstractPost($text, $limit = 24){
    $abstract = array();
    $text = explode(' ', $text);

    if ($limit > count($text)) {
        $limit = count($text);  
    } else {
        $more = true; 
    }

    foreach ($text as $key => $word) {
                $abstract[] = $word;
            if ($key == $limit) {
                break;
        }
    }

    if(isset($more)){
        return implode(" ", $abstract) . ' <span class="excerpt-hellip">[...]</span>';
    }
    return implode(" ", $abstract);
}
