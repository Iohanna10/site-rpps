<?php

require_once("functions/calendar.php");
require_once("config/content-config.php");


date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, "pt_BR.Utf-8");

?>
<button id="close-modal">
    <span class="bar"></span>
    <span class="bar"></span>
</button>
<div class="contents">
    <div class="month-events">
        <h1 class="title">Eventos de <?php echo (new DateTime($events[0]['date']))->format("j") . " de " . ucfirst($mesPtBr->format((new DateTime($events[0]['date']))));?></h1>
        <?php 
            echo '<ul class="list-events">';
                    foreach ($events as $key => $event) {
                        require("config/content-config.php");

                        echo '<li onclick="infosEvent(`' . $event['id'] . '`, `'. $event['date'] .'`)">';
                            echo "<h3 class='text-title'>" . ucfirst($event['titulo']) . "</h3>";
                            echo '<i class="fa-sharp fa-regular fa-eye"></i>';
                        echo '</li>';
                    } 
            echo '</ul>';
        ?>
    </div>
    <div class="events-info modal-info">
        <div class="await-infos">
            <h3>Clique em algum evento para visualizar as informações.</h3>
        </div>
    </div>
</div>