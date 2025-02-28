<!-- link js -->
<script src="<?= base_url() ?>assets\js\posts\slider-birthday.js"></script>

<section class="contents">
    <div class="container">
        <div class="post-carousel">
            <div class="carousel">
                <div class="slider">
                    <div class="slides">

                        <!-- radio buttons -->
                        <input type="radio" name="radio-btn" class="main-radio" id="main-radio1" checked="true">
                        <input type="radio" name="radio-btn" class="main-radio" id="main-radio2">
                        <input type="radio" name="radio-btn" class="main-radio" id="main-radio3">
                        <!-- fim radio buttons -->

                        <?php 
                            // pegar a url
                            require("config/content-config.php");
                            // meses
                            require_once("functions/calendar.php");
                            date_default_timezone_set('America/Sao_Paulo');
                            setlocale(LC_ALL, "pt_BR.Utf-8");

                            $monthsBirthdays = strtotime(date("Y-1-1"));
                            $DataBirthdays = formatMonth($monthsBirthdays);
                            $month = 0;

                            for ($i=0; $i < 3; $i++) { 
                                if($i == 0){
                                    echo '<div class="slide first-post">';
                                }  else {
                                    echo '<div class="slide">';
                                }  

                                for ($post=0; $post < 4; $post++) { 
                                    echo '<div class="birthdays-posts">';
                                            echo '<div class="date">';
                                            echo '<p>'. $diaMesAnoPtBr->format($DataBirthdays) .'</p>';
                                        echo '</div>';
                                        echo '<div class="img-cake">';
                                            echo '<a href="'. base_url() . $url . '/segurados/aniversario/lista?data='. date("Y-m-d", $monthsBirthdays) .'">';
                                                echo '<img src="' .base_url("assets/img/birthdaycake.png").'" alt="">';
                                            echo '</a>';
                                        echo '</div>';
                                        echo '<div class="title">';
                                            echo '<a href="'. base_url() . $url . '/segurados/aniversario/lista?data='. date("Y-m-d", $monthsBirthdays) .'">';
                                                echo '<h4>Aniversariantes do mês de '. ucfirst($mesPtBr->format($DataBirthdays)) .'</h4>';
                                            echo '</a>';
                                            echo '<div class="underlined">';
                                                echo '<span></span>';
                                            echo '</div>';
                                        echo ' </div>';
                                        echo '<div class="read-more">';
                                            echo '<a href="'. base_url() . $url . '/segurados/aniversario/lista?data='. date("Y-m-d", $monthsBirthdays) .'">';
                                                echo '<div class="btn">';
                                                    echo '<span class="icon"><i class="fa-sharp fa-regular fa-grid-horizontal"></i></span>';
                                                    echo '<span>Leia mais</span>';
                                                echo '</div>';
                                            echo '</a>';
                                        echo '</div>';
                                    echo '</div>';

                                    // formatar data para pt-br
                                    $monthsBirthdays = nextBirthdayMonth($monthsBirthdays);
                                    $DataBirthdays = formatMonth($monthsBirthdays);
                                }
                                echo '</div>';
                            }
                        ?>

                        <!-- navegação -->
                        <div class="navigation-auto">
                            <div class="auto-btn1"><div class="roof"></div></div>
                            <div class="auto-btn2"><div class="roof"></div></div>
                            <div class="auto-btn3"><div class="roof"></div></div>
                        </div>

                        <div class="manual-navigation">
                            <label onclick="findSlidePost(1)" for="main-radio1" class="manual-btn"></label>
                            <label onclick="findSlidePost(2)" for="main-radio2" class="manual-btn"></label>
                            <label onclick="findSlidePost(3)" for="main-radio3" class="manual-btn"></label>
                        </div>
                    </div>
                </div>
                <div class="change-content">
                    <button class="btn-prev" onclick="prevSlide()"><span class="material-symbols-outlined">arrow_back_ios_new</span></button>
                    <button class="btn-next" onclick="nextSlide()"><span class="material-symbols-outlined">arrow_forward_ios</span></button>
                </div>
            </div>   
        </div>
    </div>
</section>  

<?php
function nextBirthdayMonth($month)
{
    return strtotime("+1 month", $month);
    $month = $month + 1;
}