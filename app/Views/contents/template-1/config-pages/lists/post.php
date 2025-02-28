<h1 class="title" style="margin-bottom: 20px!important;">Publicações</h1>
<div style="margin-bottom: 10px!important;">
    <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Escolher até quatro publicações com destaque.</span>
</div>
<?php 
    echo '<table data-highlighted="'. $data['qntHighlighted'] .'">';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 60%;">Nome</th>';
                echo '<th style="width: 10%;">Destaque</th>';
                echo '<th style="width: 10%;">Editar</th>';
                echo '<th style="width: 10%;">Remover</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';
        
            if($data['dbData'] != null){
                foreach ($data['dbData'] as $key => $post) {
                    require("config/content-config.php");

                    echo '<tr id="'. $post['id_post'] .'">';
                        echo "<td>" . $post['titulo'] . "</td>";

                        if($post['destaque'] == 1){
                            echo "<td><input type='checkbox' name='highlighted' class='limited' data-id='". $post['id_post'] ."' checked></td>";
                        } else {
                            echo "<td><input type='checkbox' name='highlighted' class='limited' data-id='". $post['id_post'] ."'></td>";
                        }

                        echo "<td><a onclick='editPost(`" .$post['id_post'] ."`)'><i class='fa-sharp fa-thin fa-pen-to-square edit' title='editar'></i></td>";
                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir essa publicação?`, `ajaxRemove_post`, ". $post['id_post'] . ")'></i></td>";
                    echo '</tr>';
                } 
            } else {
                echo '<tr>';
                    echo '<td colspan="4">Ainda não há publicações.</td>';
                echo '</tr>';
            }

        echo '</tbody>';
        
        if($data['qntPg'] > 1){ // menu de navegação
            echo '<tfoot>';
                echo '<tr>';
                    echo '<td colspan="4">';
                        echo '<nav aria-label="navigation">';
                            echo "<ul class='pagination'>";

                                // variáveis
                                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

                                // primeira pg
                                echo "<li class='page-item'><a class='page-link' onclick='listPosts(1, getFilters_post())'>Primeira</a></li>";

                                // páginas anteriores
                                for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                                    if($prevPg > 0){
                                        echo "<li class='page-item'><a class='page-link' onclick='listPosts($prevPg, getFilters_post())'>$prevPg</a></li>";
                                    }
                                }

                                // página atual
                                echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                                // páginas posteriores
                                for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                                    if($nextPg <= $data['qntPg']){
                                        echo "<li class='page-item'><a class='page-link' onclick='listPosts($nextPg, getFilters_post())'>$nextPg</a></li>";
                                    }
                                }

                                // última página
                                echo "<li class='page-item'><a class='page-link' onclick='listPosts(". $data['qntPg'] .", getFilters_post())'>Última</a></li>";

                            echo '</ul>';
                        echo '</nav>';
                        
                    echo '</td>';
                echo '</tr>';
            echo '</tfoot>';
        }
    echo '</table>';
?>