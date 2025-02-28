<?php

// Primeira letra maiúscula
function upper($month)
{
    $search = array("De ");
    $replace = array("de ");

    return str_replace($search, $replace, ucwords($month));
}
//

