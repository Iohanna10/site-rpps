<?php require("config/content-config.php");?>

<head>
    <script src="<?= base_url() ?>assets/js/forms/account/recover-account.js"></script>  <!-- js próprio -->
    <title><?php echo ucfirst(strtolower($url)) ?> - Recuperar conta</title>
</head>

<section class="contents">
    <div class="container">
        <form class="recoverAcount" action="<?php echo base_url("login-cnpj") ?>" method="post">
            <div class="access">
                <div class="title"><h1>Recuperar conta</h1></div>
                    <div class="input">
                        <label for="email">Email cadastrado<span class="error"></span></label>
                        <input type="text" id="email" name="email" placeholder="exemplo@gmail.com" title="Informe o email cadastrado para receber as instruções de recuperação por email.">
                    </div>
                <button type="button" id="btnRecover">Continuar</button>
            </div>
            <div class="redirect">
                <a href="<?php echo base_url("$url/login") ?>">Voltar para o login</a>
            </div>
        </form>
        <div class="bg-modal"></div>
        <div class="modal-info">
            <h1>Instruções enviadas</h1>
            <p>Nós enviamos as instruções para {email}, por favor verifique tanto sua caixa de entrada quanto spam.</p>
            <button type="button" id="btnModal">Ok</button>
        </div>
    </div>
</section>