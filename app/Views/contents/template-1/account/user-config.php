<?php require("config/content-config.php"); 

    $date = strtotime(session()->{'date'});
?>
<head>
    <title><?php echo ucfirst(strtolower($url)) ?> - Configurar conta</title>
</head>

<section class="contents">
    <div class="container">
        <form class="form-cad" method="post" enctype="multipart/form-data" data-path-variation="<?php echo 'user_profile/' ?>">
            <div class="access">
                <div class="goBack" title="voltar para a página inicial"><a href="<?= base_url("$url") ?>"><i class="fa-regular fa-arrow-left"></i></a></div>
                <div class="title"><h1>Alterar informações</h1></div>
                    <div class="input">
                        <label for="img">
                            <div class="preview profile" title="Clique para escolher foto">
                                <div class="preview-img-container" data-id-media='<?php echo session()->get('photo') ?>'><img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/user_profile/") . session()->get('photo') ?>" alt="Sua foto de perfil"></div>
                                <div class="container-icon" <?php if(session()->get('photo') != null){ echo 'style="display: none!important;"'; } ?>>
                                    <i class="fa-solid fa-camera"></i>
                                    <p>Foto de perfil</p>
                                </div>
                            </div>
                            <span class="error"></span>
                        </label>
                        <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg()" data-delete="<?php echo session()->get('photo') ?>">
                    </div>
                    <div class="input">
                        <label for="name">Nome<span class="error"></span></label>
                        <input type="text" id="name" name="name" placeholder="Nome completo" value="<?php echo session()->get('name') ?>" data-id="<?php echo session()->get('idUser') ?>">
                    </div>
                    <div class='input'>
                        <label for="day">Data de nascimento</label>
                        <div class="two-inputs">
                            <select name="day" id="day" title="dia" data-date="<?php echo date('d', $date) ?>"></select>
                            <select name="month" id="month" title="mês" data-date="<?php echo date('m', $date) ?>"></select>
                            <select name="year" id="year" title="ano" data-date="<?php echo date('Y', $date) ?>"></select>
                        </div class="two-inputs">
                    </div>
                    <div class="input">
                        <label for="email">Email<span class="error"></span></label>
                        <input type="text" id="email" name="email" placeholder="exemplo@gmail.com" value="<?php echo session()->get('email') ?>">
                    </div>
                    <div class="input">
                        <label for="tel">Número de celular<span class="error"></span></label>
                        <input type="text" id="tel" name="tel" placeholder="Celular" onkeypress="mask(this, mphone);" value="<?php echo session()->get('tel') ?>">
                    </div>
                    <div class="input">
                        <label for="pass">Senha atual<span class="error"></span></label>
                        <input type="password" id="pass" name="pass" placeholder="Senha">
                    </div>
                    <div class="input">
                        <label for="new_pass">Nova senha<span class="error"></span></label>
                        <input type="password" id="new_pass" name="new_pass" placeholder="Senha">
                        <span class="info">*  deve conter no mínimo 8 caracteres, um número, uma letra maiúscula e um caractere especial</span>
                    </div>
                    <button type="button" id="btn">Alterar</button>
                    <button type="button" id="btnDelete" onclick='confirmModal(`Deseja mesmo excluir sua conta? Após isso você não poderá mais acessá-la.`, `deleteAccount`)'>Excluir conta</button>
                </div>
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success fa-sharp fa-solid fa-check"></i></h1>
                <p>Alterações realizadas.</p>
                <button type="button" id="btnModal">Ok</button>
            </div>
            <div class="modal modal-confirm">
                <p></p>
                <button type="button" id="btnModalConfirm">Excluir</button>
                <button type="button" id="btnModal">Não</button>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url() ?>assets/js/forms/account/change-info.js"></script>  <!-- js próprio -->
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>