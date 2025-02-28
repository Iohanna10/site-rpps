<?php

// formatar mês
$mesPtBr = new IntlDateFormatter(
    'pt_BR',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'America/Sao_Paulo',          
    IntlDateFormatter::GREGORIAN, 'MMMM'
);

$diaMesAnoPtBr = new IntlDateFormatter(
    'pt_BR',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'America/Sao_Paulo',          
    IntlDateFormatter::GREGORIAN
);

//mês anterior
function prevMonth($time)
{
    return date('Y-m-d', strtotime("-1 month", $time));
}
//

//próximo mês
function nextMonth($time)
{
    return date('Y-m-d', strtotime("+1 month", $time));
}
//

//pegar dados da url
function get($x)
{
    return stripslashes(htmlentities($_GET[$x]));
}

function getMonthTime()
{

    $monthTime = strtotime(date("Y-m-1"));

    if (isset($_GET["month"])) {
        extract(date_parse_from_format("Y-m-d", get("month")));

        $monthTime = strtotime("{$year}-{$month}-1");
    }

    return $monthTime;
}

// dados formatar 
function formatMonth($monthTime){
    $data = date("Y-m-d", $monthTime);
    return new DateTime($data);
}