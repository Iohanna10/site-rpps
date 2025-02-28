<head>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/modal-infos.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/forms.css") ?>">
</head>
<section class="contents">
    <div class="container">
        <div class="polls">
            <?php 
                // pegar a url
                require("config/content-config.php");

                $categories = ['Quanto ao atendimento do ' . strtoupper($url), 'Cordialidade / Tratamento', 'Precisão e Eficiência do Serviço', 'Tempo de espera para ser atendido', 'Clareza das informações', 'Quanto aos meios de comunicação com o segurado (telefone, site, informativo, etc.)', 'Quanto às ações desenvolvidas', 'Transparência', 'Satisfação', 'Ambiente físico / Acessibilidade', 'Conforto', 'Horário de atendimento'];
                
                $categoriesDB = ['atendimento', 'cordialidade', 'eficiencia', 'espera_atendimento', 'clareza', 'comunicacao', 'acoes_desenvolvidas', 'transparencia', 'satisfacao', 'acessibilidade', 'conforto', 'horario_atendimento'];

                if(isset($data['votes'])){
                    foreach ($categories as $num => $category) {
                        echo '<div class="poll">';
                            echo '<form method="post" class="polls-form" id="polls-form-'. $num .'">';
                
                                // header
                                echo '<div class="poll-header">';
                                    echo '<h1>'. $category .'</h1>';
                                echo '</div>';
                
                                // main 
                                echo '<div class="poll-main">';
                                    echo '<div class="poll-content">';
                                        echo '<ul>'; 
                                            // inputs
                                            for ($i=4; $i >= 0; $i--) {
                                                echo '<li>'; 
                                                    echo '<input type="radio" name="poll_response" id="poll_response-'. $num .'-'. ($i + 1) .'" value="'. $i .'"'; if($data['votes'][$categoriesDB[$num]] == $i && $data['votes'][$categoriesDB[$num]] != null){echo "data-voted=true data-id_poll=$num checked";} echo '>';
                                                    echo '<label for="poll_response-'. $num .'-'. ($i + 1) .'">';
                                                    
                                                    switch ($i) {
                                                        case '4':
                                                            echo 'Ótimo';
                                                            break;
                                                        
                                                        case '3':
                                                            echo 'Bom';
                                                            break;
                                                        
                                                        case '2':
                                                            echo 'Regular';
                                                            break;
                
                                                        case '1':
                                                            echo 'Ruim';
                                                            break;
                                                        case '0':
                                                            echo 'Péssimo';
                                                            break;
                                                    }
                                                    echo '</label>';
                                                echo '</li>';
                                            }
                                        echo '</ul>';
                
                                        // botão de votar
                                        echo '<div class="vote">';
                                            echo '<button type="button" title="Submeter voto" class="btn-vote" onclick="pollVote('. $num .')">Votar</button>';
                                        echo '</div>';
                
                                    echo '</div>';
                
                                    // respostas
                                    echo '<div class="poll-responses invisible"></div>';
                
                                echo '</div>';
                                
                                // fotter
                                echo '<div class="poll-footer">';
                                    echo '<p onclick="pollView('. $num .');" title="Veja resultados desta pesquisa">Ver resultados</p>';
                                echo '</div>';
                
                            echo '</form>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
        
        <div class="bg-modal">
            <div class="modal-info">
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>

        <div class="feedbacks">
            <div class="title"><h1>Feedback/Depoimento</h1></div>
            <form id="form-feedback">
                <textarea name="feedback" id="feedback" cols="30" rows="10" placeholder="Responda as enquetes para dar feedback/depoimento sobre o instituto..." disabled><?php if(isset($feedback)){echo $feedback;} ?></textarea>
                <button type="button" title="Enviar Depoimento" class="btn-feedback">Enviar</button>
            </form>
        </div>
    </div>
</section>  
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>