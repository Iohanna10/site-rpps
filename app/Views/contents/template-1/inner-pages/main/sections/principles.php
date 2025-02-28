<?php   
     // pegar a url
    require("config/content-config.php");

    // preparar resumo
    require("functions/abstract.php");

    function title($attr){
        switch ($attr) {
            case 'missao':
                return "Missão";
            case 'visao':
                return "Visão";
            case 'valores':
                return "Valores";
        }
    }

?>  
  
<section class="contents">
    <div class="container">
        <div class="principles">
            <div class="main-title">
                <h1>Missão, Visão e Valores</h1>
                <h3>PRÍNCIPIOS/VALORES: ÉTICOS E ESTÉTICOS</h3>
            </div>

            <div class="values">
                <?php 
                    foreach ($data['infos'] as $num => $principle) {
                        echo '<div class="value">';
                            echo'<div class="logo">';
                                echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") .' ">';
                            echo '</div>';
                            echo '<div class="text-content">';
                                echo '<h2 class="subtitle">' . title($num) . '</h2>';
                                echo '<p>'. $principle .'</p>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>  