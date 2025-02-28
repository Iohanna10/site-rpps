<h1 class="title" style="margin-bottom: 20px!important;">CRPs</h1>

<?php 
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 80%;">PDF</th>';
                echo '<th style="width: 20%;">Excluir</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';
        
            if($data['dbData'] != null){
                foreach ($data['dbData'] as $key => $report) {
                    require("config/content-config.php");

                    echo '<tr>';
                        echo "<td><a href=". base_url("$url/uploads/pdfs?pdf=") . $report['nome'] ." target='blank'>" . $report['titulo'] . "</a></td>";
                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir esse certificado?`, `ajaxRemove_CRPS`, ". $report['id'] . ")'></i></td>";
                    echo '</tr>';
                } 
            } else {
                echo '<tr>';
                    echo '<td colspan="2">Ainda não há CRPs.</td>';
                echo '</tr>';
            }

        echo '</tbody>';
        
        if($data['qntPg'] > 1){ // menu de navegação
            echo '<tfoot>';
                echo '<tr>';
                    echo '<td colspan="2">';
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
                        
                    echo '</td>';
                echo '</tr>';
            echo '</tfoot>';
        }
    echo '</table>';
?>