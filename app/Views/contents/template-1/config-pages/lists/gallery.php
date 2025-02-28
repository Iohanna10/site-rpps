<h1 class="title" style="margin-bottom: 20px!important;">Galerias</h1>
<?php 
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 60%;">Nome</th>';
                echo '<th style="width: 20%;">Editar</th>';
                echo '<th style="width: 20%;">Remover</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';
        
            if($data['dbData'] != null){
                foreach ($data['dbData'] as $key => $gallery) {
                    require("config/content-config.php");

                    echo '<tr id="'. $gallery['id'] .'">';
                        echo "<td>" . $gallery['nome'] . "</td>";
                        echo "<td><a onclick='editGallery(`" . $gallery['id'] . "`)'><i class='fa-sharp fa-thin fa-pen-to-square edit' title='editar'></i></td>";
                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir essa galeria?`, `ajaxRemove_gallery`, ". $gallery['id'] . ")'></i></td>";
                    echo '</tr>';
                } 
            } else {
                echo '<tr>';
                    echo '<td colspan="4">Ainda não há galerias.</td>';
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
                                echo "<li class='page-item'><a class='page-link' onclick='listGallery(1, getFilters())'>Primeira</a></li>";

                                // páginas anteriores
                                for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                                    if($prevPg > 0){
                                        echo "<li class='page-item'><a class='page-link' onclick='listGallery($prevPg, getFilters())'>$prevPg</a></li>";
                                    }
                                }

                                // página atual
                                echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                                // páginas posteriores
                                for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                                    if($nextPg <= $data['qntPg']){
                                        echo "<li class='page-item'><a class='page-link' onclick='listGallery($nextPg, getFilters())'>$nextPg</a></li>";
                                    }
                                }

                                // última página
                                echo "<li class='page-item'><a class='page-link' onclick='listGallery(". $data['qntPg'] .", getFilters())'>Última</a></li>";

                            echo '</ul>';
                        echo '</nav>';
                        
                    echo '</td>';
                echo '</tr>';
            echo '</tfoot>';
        }
    echo '</table>';
?>