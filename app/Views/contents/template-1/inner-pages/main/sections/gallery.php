<!-- script js -->
<script src="<?= base_url() ?>assets\js\table\pagination\gallery.js"></script>
<script src="<?= base_url() ?>assets\js\gallery\gallery.js"></script>
<script src="<?= base_url() ?>assets\js\gallery\slide-control.js"></script>

<section class="contents" style="position: relative">
    <div class="container">
        
        <div class="gallery-posts" id="galleries">
        </div>
        
        <div class="modal-gallery hidden">
            <div class="back">
                <div>
                    <i class="fa-regular fa-arrow-left"></i>
                    <span>Voltar</span>
                </div>
            </div>
            <div class="gallery">

            </div>
        </div>

        <div class="loader">
            <div style="background-image: url('<?= base_url("assets/gifs/loading.gif") ?>')"></div>
        </div>

        <div class="gallery-carousel hidden">
            <div class="carousel">
                <div class="slider">
                    <div class="slides"></div>
                </div>

                <div class="close-slider" onclick="btnFullScreenClose()" title="Fechar slide de fotos">
                    <span><i class="fa-duotone fa-xmark"></i></span>
                </div>

                <div class="change-content">
                    <button class="btn-prev"><span class="material-symbols-outlined">arrow_back_ios_new</span></button>
                    <button class="btn-next"><span class="material-symbols-outlined">arrow_forward_ios</span></button>
                </div>

                <div class="control-buttons">
                    <div class="media-info hidden"></div>
                    
                    <div>
                        <div class="toggle-ctrl">
                            <span onclick="toggleBtns()"><i class="fa-solid fa-caret-up"></i></span>
                        </div>
                        <div class="ctrl">
                            <div class="toggle-midia-slider">
                                <span class="play"><i class="fa-solid fa-play" title="Play"></i></span>
                                <span class="pause hidden"><i class="fa-solid fa-pause" title="Pausa"></i></span>
                            </div>
                            <div class="full-screen">
                                <span class="on" onclick="btnFullScreenOpen()"><i class="fa-regular fa-up-right-and-down-left-from-center" title="Tela Cheia"></i></span>
                                <span class="off hidden" onclick="btnFullScreenClose()"><i class="fa-regular fa-down-left-and-up-right-to-center" title="Sair da Tela Cheia"></i></span>
                            </div>
                            <div class="info" onclick="btnInfo()">
                                <span><i class="fa-sharp fa-regular fa-circle-info" title="Mostrar Info"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>   
        </div>
    </div>
</section>  