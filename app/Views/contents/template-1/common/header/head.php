<!DOCTYPE html>
<html lang="pt-br" id="html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-------------------------------------------------- CSS TEMPLATE -------------------------------------------------->
    
    <!-- html -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/common/resets.css"> <!-- configurações iniciais -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/pattern/content-layout.css"> <!-- configurações de tamanhos padrão padrão -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/pattern/pattern-colors.css"> <!-- configurações de cores padrão -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/warnings.css"> <!-- avisos -->
    <!--  -->

    <!-- header -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/header/menu.css"> <!-- CSS do menu -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/header/go-back.css"> <!-- CSS do menu -->
    <!--  -->

    <!-- footer -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/footer/logos.css"> <!-- CSS logos  -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/footer/footer-infos.css"> <!-- CSS footer infos  -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/footer/footer.css"> <!-- CSS footer  -->
    <!--  -->

    <!--------------- pegar a url --------------->
      <?php require("config/content-config.php"); ?>
    <!------------------------------------------->

    <!-- icon -->
    <link rel="shortcut icon" href="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/favicon/favicon.png")?>" type="image/x-icon">
    <!--  -->
    
    <!------------------------------------------------------------------------------------------------------------------->


    <!-- FONTE -->
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400&family=Lexend+Deca:wght@600&display=swap" rel="stylesheet">
    <!-- ICONS GOOGLE ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <!-- ICONS FONT-AWESOME -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">

    <script src="<?= base_url() ?>assets/js/uri/uri.js"></script>
</head>
