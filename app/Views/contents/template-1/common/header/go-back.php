<?php require("config/content-config.php"); ?>
<section id="goBack">
    <div class="container-go-back max-width-container">
        <?php 
            if(!$jsFunc){
                echo "<p><a href=". base_url("$url/$goBack") ."><span><i class='fa-solid fa-arrow-left'></i></span> Voltar</a></p>";
            }
            else {
                echo "<p><a onclick='getPg(`$goBack`)'><span><i class='fa-solid fa-arrow-left'></i></span> Voltar</a></p>";
            }
        ?>
    </div>
</section>