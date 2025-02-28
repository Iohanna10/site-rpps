<?php require("config/content-config.php");?>

<head>
    <script src="<?= base_url() ?>assets/js/forms/account/change-password.js"></script>  <!-- js próprio -->
    <title><?php echo ucfirst(strtolower($url)) ?> - Alterar senha</title>
</head>

<section class="contents">
    <div class="container">
        <?php if($data['valid']){ ?> <!-- se a chave for válida -->
            <form class="recoverAcount" method="post">
                <div class="access">
                    <div class="title"><h1>Alterar senha</h1></div>
                    <div class="input">
                        <label for="password">Nova senha<span class="error"></span><div class="status view-pass"><i class="fa-regular fa-eye" title="visualizar senha"></i></div></label>
                        <input type="password" id="password" name="password" placeholder="Digite a nova senha">
                        <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Deve conter no mínimo 8 caracteres, um número, uma letra maiúscula e um caractere especial.</span>
                    </div>
                    <button type="button" id="btnChange">Continuar</button>
                </div>
            </form>
        <?php } else { ?>
            <form class="recoverAcount" method="post">
                <div class="access">
                    <div class="title"><h1>Solicite um novo link para redefinição da senha</h1></div>
                    <br><br>
                    <button type="button" id="btnError">Voltar</button>
                </div>
            </form>
        <?php } ?>

        <div class="bg-modal"></div>
        <div class="modal-info">
            <h1><i class="fa-sharp fa-solid fa-check"></i></h1>
            <p>Alteração realizada</p>
            <button type="button" id="btnModal">Ok</button>
        </div>
    </div>
</section>