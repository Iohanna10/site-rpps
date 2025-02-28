<?php require("config/content-config.php"); ?>
<head>
    <title><?php echo ucfirst(strtolower($url)) ?> - Cadastro</title>
</head>

<section class="contents">
    <div class="container">
        <form class="form-cad" action="<?php echo base_url("login-cnpj") ?>" method="post" enctype="multipart/form-data">
            <div class="access">
                <div class="title"><h1>Criar conta</h1></div>
                    <div class="input">
                        <label for="img">
                            <div class="preview profile" title="Clique para escolher foto">
                                <div class="preview-img-container"></div>
                                <div class="container-icon">
                                    <i class="fa-solid fa-camera"></i>
                                    <p>Adicionar foto</p>
                                </div>
                            </div>
                            <span class="error"></span>
                        </label>
                        <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg()" required="">
                    </div>
                    <div class="input">
                        <label for="name">Nome<span class="error"></span></label>
                        <input type="text" id="name" name="name" placeholder="Nome completo">
                    </div>
                    <div class="cpf-div">
                        <label for="cpf">CPF<span class="error"></span></label>
                        <input type="text" id="cpf" name="cpf" oninput="mascara(this)" placeholder="CPF">
                        <div class="status">
                            <i class="fa-solid fa-xmark-large error"></i>
                            <i class="fa-solid fa-check ok"></i>
                        </div>
                    </div>
                    <div class='input'>
                        <label for="day">Data de nascimento</label>
                        <div class="two-inputs">
                            <select name="day" id="day" title="dia"></select>
                            <select name="month" id="month" title="mês"></select>
                            <select name="year" id="year" title="ano"></select>
                        </div class="two-inputs">
                    </div>
                    <div class="input">
                        <label for="email">Email<span class="error"></span></label>
                        <input type="text" id="email" name="email" placeholder="exemplo@gmail.com">
                    </div>
                    <div class="input">
                        <label for="tel">Número de celular<span class="error"></span></label>
                        <input type="text" id="tel" name="tel" placeholder="Celular" onkeypress="mask(this, mphone);">
                    </div>
                    <div class="input">
                        <label for="password">Senha<span class="error"></span><div class="status view-pass"><i class="fa-regular fa-eye" title="visualizar senha"></i></div></label>
                        <input type="password" id="password" name="password" placeholder="Senha">
                        <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Deve conter no mínimo 8 caracteres, um número, uma letra maiúscula e um caractere especial.</span>
                    </div>
                    <button type="button" id="btnCad">Cadastrar</button>
                    <div class="redirect">
                        <a href="<?php echo base_url("$url/login") ?>">Já tem uma conta? Clique aqui.</a>
                    </div>
                </div>
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success fa-sharp fa-solid fa-check"></i></h1>
                <p>Cadastrado com sucesso.</p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/account/register.js") ?>"></script>  <!-- js próprio -->
<script src="<?= base_url("assets/js/forms/clear-all.js") ?>"></script>