<head>
    <title><?php echo 'Instituto sem cadastro' ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/common/resets.css"> <!-- configurações iniciais -->

    <!-- ICONS FONT-AWESOME -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
</head>

<body style="background-color: #e3e3e2;">
    <section style="width: 100%; height: auto; min-height: 100vh; display: flex; justify-content: center; background-color: #e3e3e2;">
        <div class="container" style="width: var(--afastamento-lateral); height: auto; margin: 25px 0px; display: flex; justify-content: center; align-items: center;">
            <div class="warning" style="background-color: white; padding: 15px; flex-direction:column; gap:10px; border-radius: 5px; display: flex; justify-content: center; align-items: center; min-height: 300px; font-size: 2rem;">
                <span style="text-align: center; font-size: 50px; color: #bf1111;"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <span>Este instituto não possui cadastro, verifique se digitou a url corretamente.</span>
                <span>Url: <?php echo $_GET['url'] ?></span>
            </div>
        </div>
    </section>
</body>