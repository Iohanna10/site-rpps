</body>
<footer>
    <!--------------- pegar a url --------------->
    <?php

    use Functions\Formatter\Formatter;

    require("config/content-config.php"); ?>
    <!------------------------------------------->

    <!--------------- formatações --------------->
    <?php
    require_once("functions/formatter.php");
    $formatter = new Formatter;

    ?>
    <!------------------------------------------->

    <!-- footer principal -->
    <section class="about-us">
        <div class="grid-main-footer container max-width-container">
            <!-- voltar para o inicio -->
            <div class="outset">
                <button class="btn"><a href="#home"><span class="material-symbols-outlined">arrow_forward_ios</span></a></button>
            </div>
            
            <div class="grid">
                <!-- sobre -->
                <div class="flex-about">
                    <div class="about">
                        <!-- logo -->
                        <?php if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){
                            echo '<img src="' . base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") . '">';
                        } ?>
                        <!-- sobre -->
                        <p><?php echo $info['sobre'] ?></p>
                    </div>
                </div>
    
                <!-- horários e local -->
                <div class="flex-local">
                    <div>
                        <h3>VENHA FAZER UMA VISITA</h3>
                        <?php if(isset($info['cep'])){ ?>
                        <p><?php 
                            if(isset($info['rua'])){echo $info['rua'] . ", ";}; 
                            if(isset($info['numero'])){echo $info['numero'] . ' ';};
                            if(isset($info['bairro'])){echo $info['bairro'] . " | ";};
                            if(isset($info['cidade'])){echo $info['cidade'] . " – ";}; 
                            if(isset($info['estado'])){echo $info['estado'] . " | ";}; 
                            echo $info['cep']; 
                        }
                        else {
                            echo "<p>Localização não informada.</p>";
                        }
                        ?></p>
                    </div>
                    <div>
                        <h3>HORÁRIOS DE FUNCIONAMENTO</h3>
                        <?php if(isset($info['hr_inicio'])){ ?>
                        <p><?php if(isset($info['hr_inicio'])){echo (new DateTime($info['hr_inicio']))->format('H') . 'h às ';}; if(isset($info['hr_fim'])){ echo (new DateTime($info['hr_fim']))->format('H') . 'h de ';} if(isset($info['dia_inicio'])){echo $info['dia_inicio'] . ' a ';} if(isset($info['dia_fim'])){echo $info['dia_fim'];}; ?></p>
                        <?php } 
                        else {
                            echo "<p>Horário de funcionamento não informado.</p>";
                        }
                        ?>
                    </div>
                </div>
    
                <!-- contacts -->
                <div class="flex-contacts">
                    <?php if(isset($contacts['fix_tel']) && $contacts['fix_tel'] != ''){ ?>
                        <div>
                            <h3>LIGUE PARA NÓS</h3>
                            <!-- telefone fixo -->
                            <div class="line-up">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="tel">
                                    <path d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z"  fill="#ffff" />
                                </svg>
                                <p><?php echo $formatter->tel($contacts['fix_tel']) ?></p>
                            </div>
                        </div>
                    <?php } ?>
    
                    <div>
                        <h3>TEM UMA PERGUNTA?</h3>

                        <!-- telefone -->
                        <?php if(isset($contacts['tel']) && $contacts['tel'] != ''){ ?>
                            <div class="line-up">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" fill="#ffff"/>
                                </svg>
                                <p><?php echo $formatter->tel($contacts['tel']) ?></p>
                            </div>
                        <?php } ?>

                        <!-- email (obrigatório) -->
                        <div class="line-up">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" fill="#ffff"/>
                            </svg>
                            <p><?php echo $contacts['email'] ?></p>
                        </div>

                    </div>
    
                    <?php if($contacts['instagram'] != null || $contacts['facebook'] != null  || $contacts['youtube'] != null || $contacts['twitter'] != null){ ?>
                        <div>
                            <h3>ACOMPANHE AS NOVIDADES</h3>
                            
                            <!-- instagram -->
                            <?php if($contacts['instagram'] != null){ ?>
                                <div class="line-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="#ffff"/>
                                    </svg>
                                    <p><?php echo $contacts['instagram'] ?></p>
                                </div>
                            <?php } ?>

                            <!-- facebook -->
                            <?php if($contacts['facebook'] != null){ ?>
                                <div class="line-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z" fill="#ffff"/>
                                    </svg>
                                    <p><?php echo $contacts['facebook'] ?></p>
                                </div>
                            <?php } ?>

                            <!-- youtube -->
                            <?php if($contacts['youtube'] != null){ ?>
                                <div class="line-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" fill="#ffff"/>
                                    </svg>
                                    <p><?php echo $contacts['youtube'] ?></p>
                                </div>
                            <?php } ?>

                            <!-- twitter -->
                            <?php if($contacts['twitter'] != null){ ?>
                                <div class="line-up">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" fill="#ffff"/></svg>
                                    <p><?php echo $contacts['twitter'] ?></p>
                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
                <div class="prevent-img">
                    <img src="<?= base_url() ?>assets\img/programa_nacional_de_prevenção_a_corrupção.png" alt="Prevenção à corrupção" class="prevent">
                </div>
            </div>
            <!-- DIRETRIZES -->
            <div class="guidelines">
                <div>
                    <p>© 2020 <?php echo strtoupper($url) ?> // Desenvolvido por: WebPrev.</p>
                </div>
            </div>
        </div>
    </section>
</footer>