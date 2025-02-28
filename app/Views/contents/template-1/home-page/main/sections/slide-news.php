<section class="hero">
    <!--------------- pegar a funções --------------->
    <?php 
        require("config/content-config.php"); 
        require_once("functions/month-to-upper.php");
        require_once("functions/check-files.php");

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
    <!------------------------------------------->
    <div class="latest-news max-width-container">
    <!-- carrossel de imagens -->
        <div class="main-carousel">
            <div class="slider slider-main">
                <div class="slides">
                    <!-- radio buttons -->
                    <input type="radio" name="radio-btn" id="main-radio1" checked="true">
                    <input type="radio" name="radio-btn" id="main-radio2">
                    <input type="radio" name="radio-btn" id="main-radio3">
                    <input type="radio" name="radio-btn" id="main-radio4">
                    <!-- fim radio buttons -->
                    
                    <!-- slide news section-->
                    <?php 
                        $numInputs = count($mainNews);

                        if(count($mainNews) >= 1){
                            foreach ($mainNews as $num => $news) {
                                if(isset($mainNews[$num])){
                                    $Data = new DateTime($news->{'data'});
                                    
                                    if($num == 0) {
                                        echo '<div class="main-slide first">';
                                    } else {
                                        echo '<div class="main-slide">';
                                    }
                        
                                    // conteúdo da notícia
                                    echo '<div class="content">';
                                        echo '<h2>'. $news->{'titulo'} .'</h2>';
                        
                                        echo '<div class="main-content">';
                                            echo '<h4>'. upper($formatter->format($Data)) .'</h4>';
                                            echo '<p>'. $news->{'descricao'} .'</p>';
                                        echo '</div>';
                        
                                        echo '<a href='.  base_url("$url/publicacoes/noticias?idPost=") . $news->{'id_post'} .'>Saiba mais.</a>';
                                    echo '</div>';
                        
                                    // carrossel de midias
                        
                                    echo '<div class="carousel">
                                            <div class="slider slider-'. $num + 1 .'">
                                                <div class="slides">
                                        ';
                        
                                        if($news->{'midias'} != null){
                                                // array com todas as midias
                                                $imgNames = explode(",", str_replace(' ', '', $news->{'midias'}));

                                                foreach ($imgNames as $num => $name) {
                                                    if($num == 0){
                                                        echo '<div class="slide first-img">';
                                                    } else {
                                                        echo '<div class="slide">';
                                                    }
                                                        echo checkFiles($name, $Data->format("Y/n"));
                                                    echo '</div>';
                                                }

                                                echo '</div>';
                                            echo '</div>';
                        
                                            if($imgNames > 1){
                                                echo '
                                                    <div class="change-content">
                                                        <button class="btn-prev"><span class="material-symbols-outlined">arrow_back_ios_new</span></button>
                                                        <button class="btn-next"><span class="material-symbols-outlined">arrow_forward_ios</span></button>
                                                    </div>
                                                ';
                                            }
                                        } else {
                                            if($news->{'imagem_principal'} != null){
                                                echo '<div class="slide first-img">';
                                                    echo checkFiles($news->{'imagem_principal'}, $Data->format("Y/n"));
                                                echo '</div>';
                                            } else {
                                                echo '<div class="slide first-img">';
                                                    echo'<div><img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")   .'"></div>';
                                                echo '</div>';
                                            }
                                            
                                            echo '</div>';
                                        echo '</div>';
                                    }
                        
                                    echo '</div>';
                        
                                    // fim slide-news
                                    echo '</div>';
                                }
                            }
                        } else {
                            echo '<div class="main-slide first">';
                                echo '
                                    <div class="warning">
                                        <span>Ainda não há nada para ver aqui.</span>
                                    </div>
                                ';
                            // fim slide-news
                            echo '</div>';
                        }
                    ?>
                    <!-- fim slide news section -->

                    <!-- menus de navegação -->

                        <!-- auto -->
                        <?php 
                            echo '<div class="navigation-auto">';
                                foreach ($mainNews as $num => $news) {
                                    echo '<div class="auto-btn'. $num + 1 .'"></div>';
                                }
                            echo '</div>';
                        ?>
                        <!-- fim auto -->

                        <!-- manual -->
                        <?php 
                            echo '<div class="manual-navigation">';
                                foreach ($mainNews as $num => $news) {
                                    echo '<label onclick="findSlideImg('. $num + 1 .')" for="main-radio'. $num + 1 .'" class="manual-btn"></label>';
                                }
                            echo '</div>';
                        ?>
                        <!-- fim manual -->

                    <!-- fim menus de navegação -->
                </div>
            </div>

            <!-- ajuda pelo zapzap -->
            <div class="help">
                <div class="help-text">
                    <div class="text">
                        <h3>POSSO TE<br>AJUDAR?</h3>
                        <p><a href="https://wa.me/+55<?php echo $tel; ?>?text=Olá" target="_blank">Clique aqui para obter ajuda via whatsapp.</a></p>
                    </div>
                    <!-- img atendente -->
                    <div class="help-img">
                        <img src="<?= base_url() ?>assets\img\atendente.png" alt="Atendente da ajuda via WhatsApp">
                    </div>
                    <div class="zap-logo">
                        <img src="<?= base_url() ?>assets\img\zapzap.png" alt="Atendente da ajuda via WhatsApp">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url() ?>assets\js\hero\detect-slider-news.js"></script>