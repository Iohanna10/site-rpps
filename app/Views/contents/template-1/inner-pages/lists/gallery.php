<?php

    use App\Models\Functions\Functions;

    // pegar a url
    require("config/content-config.php");

    if(isset($data['galleries']['dbData']) && $data['galleries']['dbData'] != null){
        foreach ($data['galleries']['dbData'] as $key => $gallery) {
            $Data = new DateTime($gallery['data']);

            echo '<div class="photo-publication">';
                echo '<a class="open-gallery" data-gallery-id="'. $gallery['id'] .'" data-name-gallery="'.$gallery['nome'].'" data-institute="'. $url .'">';
                    echo '<input type="hidden" name="id_gallery" value="'. $gallery['id'] .'">';
                    echo '<div class="photo">';
                        if($gallery['imagem_principal'] != null){
                            echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/photo-gallery/thumb/") . $Data->format("Y/n/") . (new Functions)->nameDir($gallery['nome']) . '/' . $gallery['imagem_principal'] .'" alt="Miniatura de exemplo das fotos">';
                        } else {
                            echo '<img src="'. base_url("assets/img/sem-imagem.png").'" alt="Miniatura de exemplo das fotos">';
                        }
                    echo '</div>';
                    echo '<div class="info">';
                        echo '<div class="title"><h1>'. $gallery['nome'] .'</h1></div>';
                        echo ' <div class="description"><p>'. $gallery['descricao_galeria'] .'</p></div>';
                    echo '</div>';
                echo ' </a>';
            echo '</div>';
        }
    } else {
        echo '
            <div class="warning">
                <span>Ainda não há nada para ver aqui.</span>
            </div>
        ';
    }
    
    // menu de navegação
    if($data['galleries']['qntPg'] > 1){

        echo '<nav aria-label="navigation">';
            echo "<ul class='pagination'>";

                // variáveis
                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

                // primeira pg
                echo "<li class='page-item'><a class='page-link' onclick='getGalleries(1)'>Primeira</a></li>";

                // páginas anteriores
                for($prevPg = ($data['galleries']['currentPg'] - $maxLinks); $prevPg <= ($data['galleries']['currentPg'] - 1); $prevPg++){
                    if($prevPg > 0){
                        echo "<li class='page-item'><a class='page-link' onclick='getGalleries($prevPg)'>$prevPg</a></li>";
                    }
                }

                // página atual
                echo "<li class='page-item'><a class='page-link current-pg'>". $data['galleries']['currentPg'] ."</a></li>";

                // páginas posteriores
                for($nextPg = ($data['galleries']['currentPg'] + 1); $nextPg <= ($data['galleries']['currentPg'] + $maxLinks); $nextPg++){
                    if($nextPg <= $data['galleries']['qntPg']){
                        echo "<li class='page-item'><a class='page-link' onclick='getGalleries($nextPg)'>$nextPg</a></li>";
                    }
                }

                // última página
                echo "<li class='page-item'><a class='page-link' onclick='getGalleries(" . $data['galleries']['qntPg'] . ")'>Última</a></li>";

            echo '</ul>';
        echo '</nav>';
        
    }
?>          