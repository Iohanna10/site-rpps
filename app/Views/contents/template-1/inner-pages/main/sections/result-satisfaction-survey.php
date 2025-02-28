<head>
    <?php require("config/content-config.php"); ?>
    <title>Aprovação do instituto</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/feedbacks/feedbacks.css") ?>"> 
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/feedbacks/ratings.css") ?>"> 
</head>
<body>
    <div class="container-form contents" style="padding: 75px 0;">
        <section id="ratings">
            <h1>Aprovação do instituto</h1>
            <div class="ratings_container">
                <?php 
                    if(count($data['ratings']) > 0){

                        $attrPolls = ['Atendimento', 'Cordialidade', 'Eficiência', 'Tempo de espera', 'Clareza', 'Comunicação', 'Ações desenvolvidas', 'Transparência', 'Satisfação', 'Acessibilidade', 'Conforto', 'Horário de atendimento'];
    
                        $i = 0;
                        $color = '';
    
                        foreach ($data['ratings'] as $key => $rating) {
                            if($rating === null){
                                $color = 'rgba(0, 0, 0, 0.158)';
                            }
                            elseif($rating >= 70){
                                $color = 'green';
                            }
                            elseif ($rating >= 40 && $rating <= 69) {
                                $color = 'yellow';
                            }
                            elseif($rating === 0){
                                $color = 'transparent';
                            }
                            else {
                                $color = 'red';
                            }
    
                            echo '<div class="progress-card">';
                                echo '<h2>'. $attrPolls[$i] .'</h2>';
    
                                echo '<svg>';
                                    echo '<circle r="70" cx="75" cy="75"></circle>';
                                    echo '<circle class="circle-progress" r="70" cx="75" cy="75" style="stroke:'. $color .'; --progress:'. $rating .'"></circle>';
                                echo '</svg>';

                                if($rating !== null){
                                    echo '<h3>'. $rating .'<span>%</span></h3>';
                                } else {
                                    echo '<h3><span>Sem votos</span></h3>';
                                }
    
                            echo '</div>';
    
    
                            $i++;
                        }
                    } else {
                        echo '<div class="warning">';
                            echo '<span>Ainda não há avalições.</span>';
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
    </div>
</body>
<script src="<?= base_url("assets/js/table/pagination/feedbacks.js") ?>"></script>
<script> getFeedbacks(); </script>