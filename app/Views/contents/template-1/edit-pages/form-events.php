<?php 
    // data atual
    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
    date_default_timezone_set('America/Sao_Paulo');
    require("config/content-config.php");

    function itHappened($date){
        if(strtotime((new DateTime($date))->format('Y-m-d')) < strtotime((new DateTime)->format('Y-m-d'))){
            return 'disabled';
        }
        return;
    }
    
    if ($data['event']['tipo'] == 'evento') { ?>
    <!-- data inicial e final -->

    <div>
        <label for="start_meeting"></label>
        <div class="two-inputs">
            <div>
                <label for="start_meeting">Data de início:</label>
                <input type="date" name="start_meeting" id="start_meeting" value="<?php echo (new DateTime($data['event']['comeco_evento']))->format('Y-m-d') ?>" <?php echo itHappened($data['event']['comeco_evento']) ?>>
            </div>

            <div>
                <label for="start_time">Hora de início:</label>
                <input type="time" name="start_time" id="start_time" value="<?php echo (new DateTime($data['event']['comeco_evento']))->format('H:i') ?>" <?php echo itHappened($data['event']['comeco_evento']) ?>>
            </div>
        </div>

        <br>

        <div class="two-inputs">
            <div>
                <label for="end_meeting">Data de término:</label>
                <input type="date" name="end_meeting" id="end_meeting" value="<?php echo (new DateTime($data['event']['final_evento']))->format('Y-m-d') ?>" <?php echo itHappened($data['event']['final_evento']) ?>>
            </div>

            <div>
                <label for="end_time">Hora de término:</label>
                <input type="time" name="end_time" id="end_time" value="<?php echo (new DateTime($data['event']['final_evento']))->format('H:i') ?>" <?php echo itHappened($data['event']['final_evento']) ?>>
            </div>
        </div>

    </div>
    <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Só é possivel alterar a data de eventos que ainda não aconteceram.</span>


    <!-- fim data inicial e final -->

<?php } else { ?>

    <!-- data inicial e final -->
    <div style="text-align: center;">
        <h2>Dias e horário das reuniões</h2>
    </div>
    <!-- switch mesmo horário p/ reuniões -->
    <div class="switch__container">
        <span>Mesmo horário para todas as reuniões</span>
        <input id="switch-shadow" class="switch switch--shadow" type="checkbox" />
        <label for="switch-shadow"></label>
    </div>
    <!-- fim switch mesmo horário p/ reuniões -->

    </div>
    <!-- fim data inicial e final -->

    <?php
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
        require("config/content-config.php");

        $mesPtBr = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',          
            IntlDateFormatter::GREGORIAN, 'MMMM'
        );

        //próximo mês
        function nextMonth($time)
        {
            return date('Y-m-d', strtotime("+1 month", $time));
        }
        //
    
        $dates = explode(", ", $data['event']['reunioes']);

        for ($i=0, $count=0; $i < 6; $i++) { 
            echo '<div class="two-inputs days-meetings">';
            
            for ($j=0; $j < 2; $j++, $count++) { 
                $date = new DateTime($dates[$count]);
                echo '<div>';
                    echo '<label for="'. strtolower($date->format('F')) .'">'. ucfirst($mesPtBr->format($date)) .'</label>';
                    echo '<div class="two-inputs">';
                        echo '<select name="'. strtolower($date->format('F')) .'" id="'. strtolower($date->format('F')) .'" data-month="'. $date->format('n') .'" data-value="'. $date->format('d') .'" '.itHappened($date->format('Y-m-d')).'></select">';
                        echo '<input type="time" name="time" id="startTime'. $date->format('M') .'" value="'. $date->format('H:i') .'"'.itHappened($date->format('Y-m-d')).'>';
                    echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        }
    
    ?>

    <!-- fim data inicial e final -->
    <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Só é possivel alterar a data de reuniões que ainda não aconteceram.</span>

<?php } ?>