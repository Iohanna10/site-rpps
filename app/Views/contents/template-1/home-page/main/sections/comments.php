<!-- Outras notícias -->
<main>
    <section class="section_all" id="client">
        <div class="container max-width-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title_all text-center">
                        <div class="section_icons">
                            <i class="mbri-home" style="background-color: var(--cor-primaria)"></i>
                        </div>
                        <p class="section_subtitle mx-auto text-muted"><font style="vertical-align: inherit; cursor:default;"><font style="vertical-align: inherit;">Depoimentos dos nossos segurados</font></font></p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                <?php
                    require_once("functions/month-to-upper.php");
                    require("config/content-config.php");
                
                    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                    date_default_timezone_set('America/Sao_Paulo');
                
                    // pegar a url
                
                    if(count($feedbacks['dbData']) > 0) {
                        foreach ($feedbacks['dbData'] as $key => $feedback) {
                            echo '<div class="col-lg-4">';
                                echo '<div class="personal_testi_content text-center bg-light p-4 mt-3">';
                                    echo '<div class="personal_testi_content_img">';
                                        echo '<div class="container-img rounded-circle">';
                
                                        if ($feedback['beneficiary']['foto'] != null) { 
                                            echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/user_profile/"). $feedback['beneficiary']['foto'] .'" alt="foto do beneficiado" class="img-fluid d-block mx-auto">';
                                        } else {
                                            echo '<img src="'. base_url('assets/img/sem-foto.png') . '" alt="foto do beneficiado" class="img-fluid d-block mx-auto">';
                                        }
                
                                        echo '</div>';
                                    echo '</div>';
                
                                    if($feedback['feedback'] != null && $feedback['feedback'] != ''){
                                        echo '<p class="text-muted mt-3"><font style="vertical-align: inherit;"><q style="font-size: 1.5rem; cursor: default;">'. $feedback['feedback'] .'</q></font></p>';
                                    }
                
                                    echo '<div>';
                                        echo '<ul class="list-unstyled mb-0">';
                                            echo '<li class="list-inline-item">';
                                                echo '<div class="rating__average">';
                                                    echo '<div class="star-outer">';
                                                        echo '<div class="star-inner" style="--rating:'. $feedback['rating'] .'%"></div>';
                                                    echo'</div>';
                                                echo '</div>';
                                            echo '</li>';
                                        echo '</ul>';
                                    echo '</div>';
                
                                    echo '<h6 class="mt-3 mb-0"><font style="vertical-align: inherit; cursor: default;">'.  $feedback['beneficiary']['nome'] .'</font></h6>';
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
        </div>
    </section>
</main>