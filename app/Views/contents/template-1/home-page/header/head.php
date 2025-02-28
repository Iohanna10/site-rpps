<head>
    <!-- main -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/warnings.css"> <!-- avisos -->
        <link rel="stylesheet" href="<?= base_url('assets/css/template-1/common/banner.css') ?>">

        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/hero.css"> <!-- CSS hero  -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/latest-publications.css"> <!-- CSS outras notícias -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/main-content.css"> <!-- CSS main -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/comments.css"> <!-- CSS outras notícias -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/infos-content.css"> <!-- CSS infos -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/home-page/main/events.css"> <!-- CSS events  -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/modal-event.css"> <!-- CSS hero  -->

        <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/forms.css">
    <!-------------------------------------------------------------------------------------------------------->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?= base_url("assets/js/uri/uri.js") ?>"></script>
    <?php
        require("config/content-config.php");
    ?>
    
    <!-- Título nome do instituto -->
    <title><?php echo strtoupper($url) ?></title>
</head>