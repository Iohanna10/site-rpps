<?php require("config/content-config.php"); ?>
<head>
    <title><?php echo ucfirst(strtolower($url)) ?> - Acessar conta</title>
</head>

<section class="contents">
    <div class="container">
        <form class="login" method="post">
            <div class="access">
                <div class="title"><h1>Acessar conta</h1></div>
                <div class="input">
                    <label for="identity">Beneficiário/Instituto<span></span></label>
                    <input type="text" id="identity" name="identity" placeholder="Usuário/CPF ou CNPJ">
                </div>
                <div class="input">
                    <label for="password">Senha<span></span><div class="status view-pass"><i class="fa-regular fa-eye" title="visualizar senha"></i></div></label>
                    <input type="password" id="password" name="password" placeholder="Senha" autocomplete="yes">
                    <span class="info"><br></span>
                </div>
                <button type="button" id="btnSubmit">Entrar</button>
            </div>
            <div class="redirect">
                <a href="<?php echo base_url("$url/cadastro") ?>">Cadastrar</a>
                <a href="<?php echo base_url("$url/recuperar-conta") ?>">Esqueceu sua senha?</a>
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
<script src="<?= base_url("assets/js/forms/account/login.js") ?>"></script>  <!-- js próprio -->
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>  <!-- js próprio -->