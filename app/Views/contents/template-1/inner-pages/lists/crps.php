<?php

$formatter = new IntlDateFormatter(
    'pt_BR',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'America/Sao_Paulo',          
    IntlDateFormatter::GREGORIAN
);

require('config/content-config.php'); // pegar a url 
    
foreach ($data['dbData'] as $key => $report) {
    echo '<div class="report">';
        echo '<div class="date"><span>' . $formatter->format((new DateTime($report['data']))) . '</span></div>';
        echo '<div class="report-desc">';
            echo '<div class="report-header">';
                echo '<h2>'. $report['titulo'] .'</h2>';
            echo '</div>';
            echo '<div class="report-main">';
                echo '<span>'. $report['nome'] .'</span>';
            echo '</div>';
            echo '<div class="report-footer">';
                echo '<div class="read-more" style="border-left: none;"><i class="fa-regular fa-align-justify"></i><a href="' . base_url("$url/uploads/pdfs?pdf=") . $report['nome'] . '">Leia mais</a></div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}

if($data['qntPg'] > 1){ // menu de navegação
    echo '<nav aria-label="navigation">';
        echo "<ul class='pagination'>";

            // variáveis
            $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

            // primeira pg
            echo "<li class='page-item'><a class='page-link' onclick='listReports(1)'>Primeira</a></li>";

            // páginas anteriores
            for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                if($prevPg > 0){
                    echo "<li class='page-item'><a class='page-link' onclick='listReports($prevPg)'>$prevPg</a></li>";
                }
            }

            // página atual
            echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

            // páginas posteriores
            for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                if($nextPg <= $data['qntPg']){
                    echo "<li class='page-item'><a class='page-link' onclick='listReports($nextPg)'>$nextPg</a></li>";
                }
            }

            // última página
            echo "<li class='page-item'><a class='page-link' onclick='listReports(". $data['qntPg'] .")'>Última</a></li>";

        echo '</ul>';
    echo '</nav>';
}

?>
