<?php 
// pegar a url
require("config/content-config.php");

// preparar resumo
require("functions/abstract.php");
require("functions/post-routes.php");

if(isset($posts['dbData'] ) && $posts['dbData'] != null){
    echo '<div class="posts">';
        foreach ($posts['dbData'] as $num => $post) {
            
            $Data = new DateTime($post->{'data'});
            
            // post header
            echo ' <div class="post">';
            echo '<div class="post-header">';
                if($post->{'imagem_principal'} != ''){
                        echo '<div class="post-img">';
                            echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/posts/" . $Data->format("Y/n/"). $post->{'imagem_principal'}) .' ">';
                        echo '</div>';
                    }
            echo'</div>';
                // post main 
                echo '<div class="post-main">
                        <div class="title">
                        <h1> '. $post->{'titulo'} .' </h1>
                        </div>';
                        if($post->{'descricao'} != ''){
                            echo '<div class="excerpt">';
                                echo '<p>' . abstractPost($post->{'descricao'});
                            echo '</div>';
                        }
                echo '</div>';
                // fim main 

                // post footer 
                echo '<div class="post-footer">';
                    echo '<div class="button-love">';
                        echo '<a id="post-'. $post->{'id_post'} .'" onclick="liked('. $post->{'id_post'} .')">';
                            echo '<i class="fa-light fa-heart"></i>';
                            echo '<i class="fa-solid fa-heart not-rated"></i>';
                            echo '<span>'. $post->{'avaliacoes'} .'</span>';
                        echo '</a>';
                    echo '</div>';
                    echo '<div class="read-more">';
                        echo '<i class="fa-regular fa-align-justify"></i>';
                        echo '<a data-post-id='. $post->{'id_post'} .' data-type="post">Leia mais</a>';
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
if($posts['qntPg'] > 1){

    // paginação para para uma categoria de post
    if(isset($posts['id_route'])){
        echo '<nav aria-label="navigation">';
            echo "<ul class='pagination'>";

                // variáveis
                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav
                $category = '"'.$posts['id_route'].'"'; // categoria ou pesquisa 

                // primeira pg
                echo "<li class='page-item'><a class='page-link' onclick='posts(1, ". $category .")'>Primeira</a></li>";

                // páginas anteriores
                for($prevPg = ($posts['currentPg'] - $maxLinks); $prevPg <= ($posts['currentPg'] - 1); $prevPg++){
                    if($prevPg > 0){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($prevPg, ". $category .")'>$prevPg</a></li>";
                    }
                }

                // página atual
                echo "<li class='page-item'><a class='page-link current-pg'>". $posts['currentPg'] ."</a></li>";

                // páginas posteriores
                for($nextPg = ($posts['currentPg'] + 1); $nextPg <= ($posts['currentPg'] + $maxLinks); $nextPg++){
                    if($nextPg <= $posts['qntPg']){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($nextPg, ". $category .")'>$nextPg</a></li>";
                    }
                }

                // última página
                echo "<li class='page-item'><a class='page-link' onclick='posts(". $posts['qntPg'] .", ". $category .")'>Última</a></li>";

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
                echo "<li class='page-item'><a class='page-link' onclick='posts(1)'>Primeira</a></li>";

                // páginas anteriores
                for($prevPg = ($posts['currentPg'] - $maxLinks); $prevPg <= ($posts['currentPg'] - 1); $prevPg++){
                    if($prevPg > 0){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($prevPg)'>$prevPg</a></li>";
                    }
                }

                // página atual
                echo "<li class='page-item'><a class='page-link current-pg'>". $posts['currentPg'] ."</a></li>";

                // páginas posteriores
                for($nextPg = ($posts['currentPg'] + 1); $nextPg <= ($posts['currentPg'] + $maxLinks); $nextPg++){
                    if($nextPg <= $posts['qntPg']){
                        echo "<li class='page-item'><a class='page-link' onclick='posts($nextPg)'>$nextPg</a></li>";
                    }
                }

                // última página
                echo "<li class='page-item'><a class='page-link' onclick='posts(". $posts['qntPg'] .")'>Última</a></li>";

            echo '</ul>';
        echo '</nav>';
    }
}

//  quantidade de registros encontrados 
if(isset($posts['totalRecords'])){
    echo '<div id="totalResults" style="display: none;" data-num_results = '.$posts['totalRecords'] .'></div>';
}