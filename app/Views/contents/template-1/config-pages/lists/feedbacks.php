<head>
    <?php require("config/content-config.php"); ?>
    <title>Avaliações e feedbacks</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/feedbacks.css") ?>"> 
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
</head>
<body>
    <h1>Avaliações completas e feedbacks</h1>

    <div class="container-filters">
        <form id="form-filter">
            <div class="two-inputs">
                <div>
                    <label for="rating-note">Nota:</label>
                    <select name="rating-note" id="rating-note">
                        <option value="false" <?php if($feedbacks['rating'] == 'false'){echo 'selected';} ?>>Todas</option>
                        <option value="null" <?php if($feedbacks['rating'] == 'null'){echo 'selected';} ?>>0</option>
                        <option value="0" <?php if($feedbacks['rating'] == '0'){echo 'selected';} ?>>1</option>
                        <option value="1" <?php if($feedbacks['rating'] == '1'){echo 'selected';} ?>>2</option>
                        <option value="2" <?php if($feedbacks['rating'] == '2'){echo 'selected';} ?>>3</option>
                        <option value="3" <?php if($feedbacks['rating'] == '3'){echo 'selected';} ?>>4</option>
                        <option value="4" <?php if($feedbacks['rating'] == '4'){echo 'selected';} ?>>5</option>
                    </select>
                </div>

                <div>
                    <label for="type-post">Somente avaliações com feedback:</label>
                    <select name="feedback-only" id="feedback-only">
                        <option value="false" <?php if($feedbacks['onlyComments'] == 'false'){echo 'selected';} ?>>Não</option>
                        <option value="true" <?php if($feedbacks['onlyComments'] == 'true'){echo 'selected';} ?>>Sim</option>
                    </select>
                </div>
            </div>
    
        </form>
    </div>

    <div class="feedbacks_container row mt-5 justify-content-center">
        <?php
            if(count($feedbacks['dbData']) > 0) {
                foreach ($feedbacks['dbData'] as $key => $feedback) {
                    echo '<div class="col-lg-4">';
                        echo '<div class="personal_testi_content text-center bg-light p-4 mt-3">';
                            echo '<div class="personal_testi_content_img">';
                                echo '<div class="container-img rounded-circle" style="max-width: 100px;">';

                                if ($feedback['beneficiary']['foto'] != null) { 
                                    echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/user_profile/"). $feedback['beneficiary']['foto'] .'" alt="foto do beneficiado" class="img-fluid d-block mx-auto" style="max-width: 100px;">';
                                } else {
                                    echo '<img src="'. base_url('assets/img/sem-foto.png') . '" alt="foto do beneficiado" class="img-fluid d-block mx-auto" style="max-width: 100px;">';
                                }

                                echo '</div>';
                            echo '</div>';

                            if($feedback['feedback'] != null && $feedback['feedback'] != ''){
                                echo '<p class="text-muted mt-3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><q>'. $feedback['feedback'] .'</q></font></font></p>';
                            }

                            echo '<div>';
                                echo '<ul class="list-unstyled mb-0">';
                                    echo '<li class="list-inline-item">';
                                        echo '<div class="rating__average">';
                                            echo '<div class="star-outer">';

                                                if(isset($feedback['rating'])){ // nota de porcentagem 
                                                    $porcent = $feedback['rating'];
                                                }
                                                else {
                                                    $porcent = 0;
                                                }

                                                echo '<div class="star-inner" style="--rating:' . $porcent .'%"></div>';
                                            echo'</div>';
                                        echo '</div>';
                                    echo '</li>';
                                echo '</ul>';
                            echo '</div>';

                            echo '<h6 class="mt-3 mb-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'.  $feedback['beneficiary']['nome'] .'</font></font></h6>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="warning">';
                    echo '<span>Ainda não há nada para ver aqui.</span>';
                echo '</div>';
            }
        ?>
    </div>
    <?php if($feedbacks['qntPg'] > 1){ // menu de navegação
        echo '<table style="border: none;">';
            echo '<tfoot>';
                echo '<tr>';
                    echo '<td colspan="4" style="background-color: transparent;">';
                        echo '<nav aria-label="navigation">';
                            echo "<ul class='pagination'>";

                                // variáveis
                                $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav

                                // primeira pg
                                echo "<li class='page-item'><a class='page-link' onclick='feedbacks(1, getFiltersFeedbacks()[0],  getFiltersFeedbacks()[1])'>Primeira</a></li>";

                                // páginas anteriores
                                for($prevPg = ($feedbacks['currentPg'] - $maxLinks); $prevPg <= ($feedbacks['currentPg'] - 1); $prevPg++){
                                    if($prevPg > 0){
                                        echo "<li class='page-item'><a class='page-link' onclick='feedbacks($prevPg,  getFiltersFeedbacks()[0],  getFiltersFeedbacks()[1])'>$prevPg</a></li>";
                                    }
                                }

                                // página atual
                                echo "<li class='page-item'><a class='page-link current-pg'>". $feedbacks['currentPg'] ."</a></li>";

                                // páginas posteriores
                                for($nextPg = ($feedbacks['currentPg'] + 1); $nextPg <= ($feedbacks['currentPg'] + $maxLinks); $nextPg++){
                                    if($nextPg <= $feedbacks['qntPg']){
                                        echo "<li class='page-item'><a class='page-link' onclick='feedbacks($nextPg,  getFiltersFeedbacks()[0],  getFiltersFeedbacks()[1])'>$nextPg</a></li>";
                                    }
                                }

                                // última página
                                echo "<li class='page-item'><a class='page-link' onclick='feedbacks(". $feedbacks['qntPg'] .",  getFiltersFeedbacks()[0],  getFiltersFeedbacks()[1])'>Última</a></li>";

                            echo '</ul>';
                        echo '</nav>';
                        
                    echo '</td>';
                echo '</tr>';
            echo '</tfoot>';
        echo '</table>';
    } ?>
</body>

