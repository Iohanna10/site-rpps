<?php 
    require("config/content-config.php");

    if($event['tipo'] == 'reuniao'){
        // título + adicional ao título
        echo '<h1 class="title">' . ucfirst($event['titulo']) . ': ' . $event['num_reuniao'] . 'ª reunião</h1>';
        
        // imagem
        if(isset($event['imagem_principal']) && $event['imagem_principal'] !== ''){
            echo '<div class="img-event"><img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/meetings_event/meetings/") . (new DateTime($event['data']))->format("Y/n/") . $event['imagem_principal'] .'"></div>';
        }

        // nome do conselho
        switch ($event['id_categoria']) {
            case '31':
                $event['conselho'] = 'Comitê de investimento';
                break;
            
            case '42':
                $event['conselho'] = 'Fiscal';
                break;

            case '46':
                $event['conselho'] = 'Deliberativo';
                break;    
        }
    ?>

    <ul class="infos">
        <li class="text-description"><?php echo ucfirst($event['descricao']) ?></li>
        <li class="start-time"><span><i class="fa-sharp fa-regular fa-clock"></i> Início: </span><?php echo ucfirst((new DateTime($event['comeco_evento']))->format("H:i")) ?></li>
        <li class="council"><span>Conselho: </span><?php echo $event['conselho'] ?></li>
        <?php if($event['obs'] !== ''){
            echo '<li class="text-obs">';
                echo '<span>Observações: </span>';
                echo ucfirst($event['obs']);
            } 
            echo '</li>';
        ?>
    </ul>

    <?php }
    else { ?>
        <h1 class="title"><?php echo ucfirst($event['titulo']); ?></h1>;

        <?php if(isset($event['imagem_principal']) && $event['imagem_principal'] !== ''){
            echo '<div class="img-event"><img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/meetings_event/events/") . (new DateTime($event['data']))->format("Y/n/") . $event['imagem_principal'] .'"></div>';
        } ?>

        <ul class="infos">
            <li class="text-description"><?php echo ucfirst($event['descricao']) ?></li>
            <li class="start-time"><span><i class="fa-sharp fa-regular fa-clock"></i> Início: </span><?php echo ucfirst((new DateTime($event['comeco_evento']))->format("d/m/Y")) . " às " . ucfirst((new DateTime($event['comeco_evento']))->format("H:i")) . " horas." ?></li>
            <li class="end-time"><span><i class="fa-sharp fa-regular fa-clock"></i> Final: </span><?php echo ucfirst((new DateTime($event['final_evento']))->format("d/m/Y")) . ' às ' . ucfirst((new DateTime($event['final_evento']))->format("H:i")) . " horas." ?></li>
            <?php if($event['obs'] !== ''){
                echo '<li class="text-obs">';
                    echo '<span>Observações: </span>';
                    echo ucfirst($event['obs']);
                } 
                echo '</li>';
            ?>
        </ul>

<?php } ?>