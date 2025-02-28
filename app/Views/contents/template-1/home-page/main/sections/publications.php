<main>
    <!--------------- pegar funções e configurações --------------->
    <?php 
        require("config/content-config.php"); 
        require_once("functions/month-to-upper.php");
        require_once("functions/abstract.php");
    
    
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
        
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',          
            IntlDateFormatter::GREGORIAN
        );
    ?>
    <!-------------------------------------------------------------->
    <!-- Outras notícias -->
    <section class="publications">
        <div class="container max-width-container">
            <div>
                <h3>Últimas publicações</h3>
            </div>
            <div class="latest-publications">
                <?php                     
                    if(count($latest) >= 1 ){
                        foreach ($latest as $num => $news){
                                
                            $DataEspecifica = new DateTime($news->{'data'});
                           
                            echo "<div class='publication'>";       
                            echo '<a href="'. base_url("$url/publicacoes/noticias?idPost=") . $news->{'id_post'} .'">';
                                echo " <h6>" . upper($formatter->format($DataEspecifica)) . "</h6>";  // data da notícia // 
                                echo "<h4>" . $news->{'titulo'} . "</h4>"; // título //
                                
                                // conteúdo
                                if($news->{'imagem_principal'} != null){
                                    echo '<div class="media"><img src=' . base_url("dynamic-page-content/$url/assets/uploads/img/posts/") . $DataEspecifica->format("Y/n/") . $news->{'imagem_principal'} . '></div>';
                                }
                                elseif($news->{'descricao'} != null){
                                    echo '
                                        <div class="media" style="display: flex; align-items: center; justify-content: center;">
                                            <p> '. abstractPost($news->{'descricao'}, 50) .'</p>
                                        </div>
                                    ';
                                }
                            echo "</a></div>";
                        }
                    } else {
                        echo '
                        <div class="warning">
                            <span>Ainda não há nada para ver aqui.</span>
                        </div>
                        ';
                    }
                ?>
            </div>
            <?php 
                if($numPb > 4){
                    echo '<div class="more-publications">
                        <a href="' . base_url("$url/publicacoes/noticias").'">Ver todas >></a>
                    </div>';
                }
            ?>
        </div>    
    </section>
</main>