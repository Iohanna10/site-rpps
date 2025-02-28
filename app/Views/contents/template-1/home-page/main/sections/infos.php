<main>
    <!-- informações -->
    <section class="section_all">
        <div class="bg_overlay_cover_on" style="background-color: var(--cor-primaria);"></div>
        <div class="container max-width-container">
            <div class="row" id="counter">
                <?php 
                    // ativos
                    echo '<div class="col-lg-3">';
                        echo '<div class="text-center counter_box p-4 mt-3 bg-white rounded" style="cursor: default;">';
                            echo '<div class="counter_icon mb-3 text_custom">';
                                echo '<i class="mdi mdi-gauge" style="color: var(--cor-secundaria); font-size: 3.8rem;"></i>';
                            echo '</div>';
                            echo '<h1 class="counter_value mb-1" data-count="'. $infos['ativos'] .'">'. $infos['ativos'] .'</h1>';
                            echo '<p class="info_name mb-0 text-muted" style="font-size: 1.6rem;">Ativos</p>';
                        echo '</div>';
                    echo '</div>';
                    // aposentados
                    echo '<div class="col-lg-3">';
                        echo '<div class="text-center counter_box p-4 mt-3 bg-white rounded" style="cursor: default;">';
                            echo '<div class="counter_icon mb-3 text_custom">';
                                echo '<i class="fa-solid fa-person-cane" style="color: var(--cor-secundaria); font-size: 3.8rem;"></i>';
                            echo '</div>';
                            echo '<h1 class="counter_value mb-1" data-count="'. $infos['aposentados'] .'">'. $infos['aposentados'] .'</h1>';
                            echo '<p class="info_name mb-0 text-muted" style="font-size: 1.6rem;">Aposentados</p>';
                        echo '</div>';
                    echo '</div>';
                    // pensionistas
                    echo '<div class="col-lg-3">';
                        echo '<div class="text-center counter_box p-4 mt-3 bg-white rounded" style="cursor: default;">';
                            echo '<div class="counter_icon mb-3 text_custom">';
                                echo '<i class="mdi mdi-account" style="color: var(--cor-secundaria); font-size: 3.8rem;"></i>';
                            echo '</div>';
                            echo '<h1 class="counter_value mb-1" data-count="'. $infos['pensionistas'] .'">'. $infos['pensionistas'] .'</h1>';
                            echo '<p class="info_name mb-0 text-muted" style="font-size: 1.6rem;">Pensionistas</p>';
                        echo '</div>';
                    echo '</div>';
                    // dependentes
                    echo '<div class="col-lg-3">';
                        echo '<div class="text-center counter_box p-4 mt-3 bg-white rounded" style="cursor: default;">';
                            echo '<div class="counter_icon mb-3 text_custom">';
                                echo '<i class="fa-solid fa-baby" style="color: var(--cor-secundaria); font-size: 3.8rem;"></i>';
                            echo '</div>';
                            echo '<h1 class="counter_value mb-1" data-count="'. $infos['dependentes'] .'">'. $infos['dependentes'] .'</h1>';
                            echo '<p class="info_name mb-0 text-muted" style="font-size: 1.6rem;">Dependentes</p>';
                        echo '</div>';
                    echo '</div>';
                ?>
            </div>
        </div>
    </section>
</main>  