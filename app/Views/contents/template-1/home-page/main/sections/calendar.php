<?php

// <!-- config inicial -->

// função calendário        
require_once("functions/calendar.php");
require("config/content-config.php");


date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, "pt_BR.Utf-8");

// para pegar o mês atual
$monthTime = strtotime($events['month']);
// var_dump($events['month']);

// para o exemplo com o mês de fevereiro de 2022
//$monthTime = strtotime("2022-2-1");

// formatar data para pt-br
$DataFormatada = formatMonth($monthTime);
// var_dump($DataFormatada);

// transformar em formato aceito como string
$url = "'$url'";
$prev = "'".prevMonth($monthTime)."'";
$next = "'".nextMonth($monthTime)."'";

// criar calendário
$html ='<div class="calendar-main">';
    $html .='<div class="header-calendar">';
        $html .= '<a onclick="calendar(' . $url . ', ' . $prev . ')"><i class="fa-solid fa-caret-left"></i></a>'; // mês anterior
        $html .='<h2>' . mb_strtoupper($mesPtBr->format($DataFormatada),'UTF-8') . '<span>' . date('Y', $monthTime) . '</span></h2>'; // mês por extenso
        $html .='<a onclick="calendar(' . $url . ', ' . $next . ')"><i class="fa-solid fa-caret-right"></i></a>'; // próximo mês
    $html .='</div>';
    $html .='<div class="body-calendar">';
    $html .='<table>
            <thead>
                <tr>
                    <td>DOM</td>
                    <td>SEG</td>
                    <td>TER</td>
                    <td>QUA</td>
                    <td>QUI</td>
                    <td>SEX</td>    
                    <td>SAB</td>
                </tr>
            </thead>
            <tbody>';
                // <!-- linhas do calendário -->

                $startDate = strtotime("last sunday", $monthTime); // último domingo

                // verificar se o ultimo domingo foi há 7 dias
                if(date('j', $monthTime - $startDate) == 7){
                    $startDate = strtotime("+7 day", $startDate);
                }
                
                $today = date("md"); // dia atual

                    for($row = 0; $row < 5; $row++){
                        $html .= "<tr>";
                        
                        // colunas do calendário
                        for($column = 0; $column < 7; $column++){

                            // dias que não pertencem ao mês atual
                            if (date('Y-m', $startDate) !== date('Y-m', $monthTime)) {
                                $html .= '<td class="other-month">';
                            } else {

                                // dias com eventos
                                // $arrayEvents => timestamp data dos eventos 
                                
                                // criar função foreach antes para transformar o array somente no formato dd/mm/YY
                                $arrayEvents = [];
                                
                                if($events['events'] != null){ // pegar eventos e colocar em um array de comparação para mostrar no calendário
                                    foreach ($events['events'] as $key => $event) {
                                        array_push($arrayEvents, date('Y/m/j', strtotime($event)));
                                    }
                                }

                                // @criar comparação das datas 
                                if(in_array(date('Y/m/j', $startDate), $arrayEvents)){
                                    $html .= "<td class='calendar-event' onclick='showEvents(`". date('Y-m-d', $startDate) ."`)'>";
                                    $html .= date('j', $startDate);
                                }

                                // dias sem eventos
                                else{
                                    $html .= "<td>";
                                    $html .= date('j', $startDate);
                                }
                            }
                            echo "</td>";
                            $startDate = strtotime("+1 day", $startDate);
                        }
                        $html .= "</tr>";
                    }
            $html .= '</tbody>  
        </table>
    </div>  
</div>';

echo $html;

?>