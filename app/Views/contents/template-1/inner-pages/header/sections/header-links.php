<?php
    // funções 
    require_once("functions/abbreviate.php");
    require("config/content-config.php");

    if(isset($_GET['post'])){
        array_push($headerLinks, $_GET['post']);
    }
?>
<head><title><?php echo ucfirst($url) . " - " . $headerLinks[count($headerLinks) - 1]; ?></title></head>
<section class="header-routes">
    <div class="container">
        <div class="category">
            <?php echo $headerLinks[count($headerLinks) - 1]; ?>
        </div>
        <div class="route-links">
            <?php echo routes($headerLinks); ?> 
        </div>
    </div>
</section>

<?php

function routes($headerLinks) {
    require("config/content-config.php");

    $html = ''; // contém o html das rotas

    // Voltar ao inicio 
    $html .= "<a href='" . base_url("/$url") ."'>Início</a>";
    $html .= "<span> <i class='fa-light fa-chevron-right'></i> </span>";
    // 

    // outras rotas 
    /*
        $i = contador
        $t = rotas que serão usadas da url completa (começa em dois pois as outras são ["", "{instituto}"])
        $linkRoute = rota
        $headerLinks = array de rotas definidas no controller
    */

    for ($i = 0, $t = 2, $linkRoute = ""; $i < count($headerLinks); $i++, $t++) {  
        if(isset($urlFull[$t])){
            $linkRoute = $linkRoute . "/$urlFull[$t]";
            
            if($i != (count($headerLinks) - 1)){
                $html .= "<a href='" . base_url("/$url/$linkRoute") ."'>". abbreviate($headerLinks[$i]) ."</a>";
                $html .= "<span> <i class='fa-light fa-chevron-right'></i> </span>";
            } else {
                $html .= "<a href='" . base_url("/$url/$linkRoute") ."'>". $headerLinks[$i] ."</a>";
            }

        } else {
            $html .= "<a>". $headerLinks[$i] ."</a>";
        }
    }
    return  $html;
}