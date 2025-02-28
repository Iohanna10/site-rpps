<?php require("config/content-config.php");?>

<head>
    <script src="<?= base_url() ?>assets/js/account/confirm-mail.js"></script>  <!-- js próprio -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/account/mail-validade.css">
    <title><?php echo ucfirst(strtolower($url)) ?> - Confirmar Email</title>
</head>

<section class="contents">
    <div class="container">
        <div class="mail-validate">
            <div class="statusCheck">
                <img src="<?= base_url("assets/img/mail-icon.png") ?>" alt="Verificando Email">
            </div>
            <h1 class="msg">Validando link de verificação do email.</h1>
            <button id="redirect">Verificando...</button>
        </div>
    </div>
</section>