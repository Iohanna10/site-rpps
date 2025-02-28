<?php 
// pegar a url
require("config/content-config.php");

// preparar resumo
require_once("functions/abstract.php");
require("functions/post-routes.php");

if(isset($data['dbData'] ) && $data['dbData']  != null){
    echo '<div class="posts">';
        foreach ($data['dbData'] as $num => $post) {

                $Date = new DateTime($post['data']);
                
                // post header
                echo ' <div class="post">';
                echo '<div class="post-header">';
                    if($post['imagem_principal'] != ''){
                            echo '<div class="post-img">';

                                if($post['htmlConstructorType'] == 'posts'){
                                    echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/posts/" . $Date->format("Y/n/"). $post['imagem_principal']) .' ">';
                                } else {
                                    echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/meetings_event/meetings/" . $Date->format("Y/n/"). $post['imagem_principal']) .' ">';
                                }

                            echo '</div>';
                        }
                echo'</div>';
                    // post main 
                    echo '<div class="post-main">
                            <div class="title">
                            <h1> '. $post['titulo'] .' </h1>
                            </div>';
                            if($post['descricao'] != ''){
                                echo '<div class="excerpt">';
                                    echo '<p>' . abstractPost($post['descricao']);
                                echo '</div>';
                            }
                    echo '</div>';
                    // fim main 
    
                    // post footer 
                    echo '<div class="post-footer">';
                    echo '<div class="button-love">';
                    echo '<a id="post-'. $post['id'] .'" onclick="liked('. $post['id'] .', `'. $post['htmlConstructorType'] .'`)"' . 'data-type="'. $post['htmlConstructorType'] .'">';

                            if($post['avaliadoBool']){ // verificação para saber se o post foi avaliado 
                                echo '<i class="fa-light fa-heart not-rated"></i>';
                                echo '<i class="fa-solid fa-heart"></i>';
                            } else {
                                echo '<i class="fa-light fa-heart"></i>';
                                echo '<i class="fa-solid fa-heart not-rated"></i>';
                            }

                            echo '<span>'. $post['avaliacoes'] .'</span>';
                        echo '</a>';
                    echo '</div>';
                    echo '<div class="read-more">';
                        echo '<i class="fa-regular fa-align-justify"></i>';
                        echo '<a data-post-id="'. $post['id'] .'"data-type="'. $post['htmlConstructorType'] .'">Leia mais</a>';
                    echo '</div>';
                echo '</div>';
                // fim footer post

            echo '</div>';
        }
            
    echo '</div>'; // fim container posts
} else {
    echo '
        <div class="warning">
            <span>Ainda não há nada para ver aqui.</span>
        </div>
    ';
}

// menu de navegação
if($data['qntPg'] > 1){

    // paginação para para uma categoria de post
    if(isset($data['id_route'])){
        echo '<nav aria-label="navigation">';
            echo "<ul class='pagination'>";

                // variáveis
                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav
                $category = '"'.$data['id_route'].'"'; // categoria ou pesquisa 

                // primeira pg
                echo "<li class='page-item'><a class='page-link' onclick='posts(1, ". $category .", getFilters())'>Primeira</a></li>";

                // páginas anteriores
                for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                    if($prevPg > 0){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($prevPg, ". $category .", getFilters())'>$prevPg</a></li>";
                    }
                }

                // página atual
                echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                // páginas posteriores
                for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                    if($nextPg <= $data['qntPg']){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($nextPg, ". $category .", getFilters())'>$nextPg</a></li>";
                    }
                }

                // última página
                echo "<li class='page-item'><a class='page-link' onclick='posts(". $data['qntPg'] .", ". $category .", getFilters())'>Última</a></li>";

            echo '</ul>';
        echo '</nav>';
    }
    // páginação para mais de uma categoria de post
    else {
        echo '<nav aria-label="navigation">';
            echo "<ul class='pagination'>";

                // variáveis
                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

                // primeira pg
                echo "<li class='page-item'><a class='page-link' onclick='posts(1, null, getFilters())'>Primeira</a></li>";

                // páginas anteriores
                for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                    if($prevPg > 0){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($prevPg, null, getFilters())'>$prevPg</a></li>";
                    }
                }

                // página atual
                echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                // páginas posteriores
                for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                    if($nextPg <= $data['qntPg']){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($nextPg, null, getFilters())'>$nextPg</a></li>";
                    }
                }

                // última página
                echo "<li class='page-item'><a class='page-link' onclick='posts(". $data['qntPg'] .", null, getFilters())'>Última</a></li>";

            echo '</ul>';
        echo '</nav>';
    }
}

//  quantidade de registros encontrados 
if(isset($data['totalRecords'])){
    echo '<div id="totalResults" style="display: none;" data-num_results = '.$data['totalRecords'] .'></div>';
}
?>
