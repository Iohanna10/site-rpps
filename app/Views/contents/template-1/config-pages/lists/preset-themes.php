<?php 
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 50%;">Nome</th>';
                echo '<th style="width: 12.5%;">Ativo</th>';
                echo '<th style="width: 12.5%;">Visualizar</th>';
                // echo '<th style="width: 12.5%;">Editar</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';
        
            if($data['dbData'] != null){
                foreach ($data['dbData'] as $key => $theme) {
                    require("config/content-config.php");

                    echo '<tr id="'. $theme['id'] .'">';
                        echo "<td>" . $theme['nome'] . "</td>";
                        if($theme['ativo'] == '1'){
                            echo "<td><input type='checkbox' name='activity' data-id='". $theme['id'] ."' checked></td>";
                        } else {
                            echo "<td><input type='checkbox' name='activity' data-id='". $theme['id'] ."'></td>";
                        }
                        echo "<td><i class='fa-sharp fa-light fa-eye view' title='visusalizar' onclick='previewTheme(". $theme['id'] .")'></i></td>";
                        // echo "<td><a onclick='editTheme(`" . $theme['id'] . "`)'><i class='fa-sharp fa-thin fa-pen-to-square edit' title='editar'></i></td>";
                    echo '</tr>';
                } 
            } else {
                echo '<tr>';
                    echo '<td colspan="5">Ainda não há temas.</td>';
                echo '</tr>';
            }

        echo '</tbody>';
        
        if($data['qntPg'] > 1){ // menu de navegação
            echo '<tfoot>';
                echo '<tr>';
                    echo '<td colspan="3">';
                        echo '<nav aria-label="navigation">';
                            echo "<ul class='pagination'>";

                                // variáveis
                                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

                                // primeira pg
                                echo "<li class='page-item'><a class='page-link' onclick='listPresetThemes(1, getFilters())'>Primeira</a></li>";

                                // páginas anteriores
                                for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                                    if($prevPg > 0){
                                        echo "<li class='page-item'><a class='page-link' onclick='listPresetThemes($prevPg, getFilters())'>$prevPg</a></li>";
                                    }
                                }

                                // página atual
                                echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                                // páginas posteriores
                                for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                                    if($nextPg <= $data['qntPg']){
                                        echo "<li class='page-item'><a class='page-link' onclick='listPresetThemes($nextPg, getFilters())'>$nextPg</a></li>";
                                    }
                                }

                                // última página
                                echo "<li class='page-item'><a class='page-link' onclick='listPresetThemes(". $data['qntPg'] .", getFilters())'>Última</a></li>";

                            echo '</ul>';
                        echo '</nav>';
                        
                    echo '</td>';
                echo '</tr>';
            echo '</tfoot>';
        }
    echo '</table>';
?>