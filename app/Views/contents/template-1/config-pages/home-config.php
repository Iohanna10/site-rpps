<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Configurações do Instituto</title>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/template-1/header/menu-institute.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/template-1/configs-pages/home-config.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/template-1/inner-pages/read-more/table.css") ?>">
    <script src="https://drag-drop-touch-js.github.io/dragdroptouch/dist/drag-drop-touch.esm.min.js" type="module"></script>
</head>
    <?php require("config/content-config.php");?>
<body>
    <div class="container-contents">
        <div class="nav-menu active">
            <div class="close-menu-mobile">
                <div class="btn-close">
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
            <div>
                <div class="identification">
                    <div class="container-logo">
                        <?php
                            if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ ?>
                                <img src="<?= base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") ?>" alt="Foto de perfil">
                            <?php } else { ?>
                                    <img src="<?= base_url("assets/img/sem-imagem.png") ?>" alt="Foto de perfil">
                            <?php }; 
                        ?>
                    </div>
                    <div class="name">
                        <h3><?php echo mb_strtoupper(session()->get('name')) ?></h3>
                    </div>
                </div>
                
                <div class="links">
                    <ul class="links-list">
                        <a href="<?php echo base_url("$url") ?>"><li><i class="fa-light fa-house-chimney"></i> Início</li></a>
                        <li class="link" data-pg="informacoes"><i class="fa-sharp fa-light fa-circle-info"></i> <p>Informações</p></li>
                        <li class="link" data-pg="personalizar"><i class="fa-light fa-paintbrush-pencil"></i> <p>Personalizar</p></li>
                        <li class="link" data-pg="avaliacoes"><i class="fa-thin fa-comments"></i> <p>Avaliações e feedbacks</p></li>
                        <li class="link" data-main-list="configs">
                            <div>
                                <i class="fa-light fa-pen-to-square"></i> Criar/Editar
                            </div>
                            <span class="caret"><i class="fa-sharp fa-solid fa-caret-left"></i></span>
                        </li>
                        <div class="sub-list" data-for="configs">
                            <ul>
                                <li class="link" data-pg="galerias"><i class="fa-light fa-image"></i> <p>Galerias</p></li>
                                <li class="link" data-pg="publicacoes"><i class="fa-light fa-memo-pad"></i></i> <p>Publicações</p></li>
                                <li class="link" data-pg="eventos"><i class="fa-light fa-calendar-pen"></i></i> <p>Eventos</p></li>
                                <li class="link" data-pg="equipe"><i class="fa-regular fa-user-group"></i> <p>Equipes</p></li>
                                <li class="link" data-pg="crps"><i class="fa-light fa-file-certificate"></i> <p>CRPS</p></li>
                                <li class="link" data-pg="calculo-atuarial"><i class="fa-light fa-calculator"></i> <p>Cálculo atuarial</p></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="configs">
            <div class="infos-menu">
                <div class="infos">
                    <div class="toggle-menu">
                        <div class="menu-hamburger">
                            <div class="menu-lines">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="current-page">
                        <h2>Informações</h2>
                    </div>
                </div>
                <div class="logout">
                    <a href="<?php echo base_url("$url/login-logout") ?>"><i class="fa-light fa-right-from-bracket"></i> Sair</a>
                </div>
            </div>
            <div id="pg-config"></div>
        </div>
    </div>
</body>

<script src="<?= base_url("assets/js/tinymce/tinymce.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tinymce/langs/pt_BR.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/clear-all.js") ?>"></script>
<script src="<?= base_url("assets/js/uri/uri.js") ?>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js"></script>
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/form-checks-edit.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/preview-medias-configs.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/drag-drop-touch.esm.js") ?>" type="module"></script>
<script src="<?= base_url("assets/js/table/drag-drop/jquery.ui.touch-punch.js") ?>"></script>

<!-- infos js -->
<script src="<?= base_url("assets/js/forms/account/institute/change-infos-institute.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/cep.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/br-states.js") ?>"></script>
<script src="<?= base_url("assets/js/tab/tab.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/logos-media.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/logos.js") ?>"></script>

<!-- personalização js -->
<script src="<?= base_url("assets/js/forms/preview-colors.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/account/institute/customize-institute.js") ?>"></script>  
<script src="<?= base_url("assets/js/table/list/themes/user-themes.js") ?>"></script>  
<script src="<?= base_url("assets/js/table/list/themes/preset-themes.js") ?>"></script>  
<script src="<?= base_url("assets/js/forms/account/institute/filter.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/themes/add.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/themes/edit.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/themes/change-activity.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/themes/preview.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/themes/remove.js") ?>"></script>

<!-- avaliações -->
<script src="<?= base_url("assets/js/table/pagination/feedbacks.js") ?>"></script>

<!-- galeria -->
<script src="<?= base_url("assets/js/table/list/gallery/gallery.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/gallery/filter.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/gallery/remove.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/gallery/add.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/gallery/edit.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/gallery/gallery-edit.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/gallery.js") ?>"></script>

<!-- posts -->
<script src="<?= base_url("assets/js/table/list/post/posts-edit.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/posts/filter-edit.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/posts/get-data-select.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/posts/remove.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/posts/highlight.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/posts/add.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/posts/edit.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/post/posts-media.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/post.js") ?>"></script>

<!-- eventos e reuniões -->
<script src="<?= base_url("assets/js/forms/meetings/remove.js") ?>"></script> 
<script src="<?= base_url("assets/js/table/list/events/events.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/meetings/filter.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/type.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/edit.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/add.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/change-form.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/change-form-edit.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/meetings/form-checks.js") ?>"></script> 

<!-- equipe -->
<script src="<?= base_url("assets/js/table/list/team.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/team.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/members/remove.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/members/add.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/members/edit.js") ?>"></script> 

<!-- Cálculo atuarial -->
<script src="<?= base_url("assets/js/forms/actuarial-calculation/ajax-data.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/actuarial-calculation/add.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/actuarial-calc/actuarial-cal-register.js") ?>"></script>

<!-- CRPS -->
<script src="<?= base_url("assets/js/forms/crp/ajax-data.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/crp/add.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/crp/crp-register.js") ?>"></script>

<script src="<?= base_url("assets/js/forms/account/institute/get-pages.js") ?>"></script> 
<script src="<?= base_url("assets/js/forms/datepicker.js") ?>"></script>
<script src="<?= base_url("assets/js/menu/toggle-menu-institute.js") ?>"></script> 

