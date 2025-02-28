<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require("config/content-config.php");?>
    <title>Personalizar tema</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/datepicker.css") ?>">
</head>

<body>
    <div class="container-form contents">
        <form class="form-cad" method="POST" id='formPost'>
            <h1 class="title">Cadastrar tema</h1>

            <div class="input">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" placeholder="Inserir nome...">
            </div>

            <!-- previsualização do tema -->
            <iframe id="preview-colors" src="configuracoes-instituto/preview" onload="iframePreview(true)"></iframe>

            <div class="two-inputs">
                <div class="input">
                    <label for="primary">Cor principal</label>
                    <input type="color" name="primary" id="primary" value="#3e4147">
                </div>

                <div class="input">
                    <label for="secundary">Cor secundária</label>
                    <input type="color" name="secundary" id="secundary" value="#a4aaad">
                </div>

                <div class="input">
                    <label for="secundary">Cor ao deixar em foco</label>
                    <input type="color" name="hover" id="highlight" value="#6e7a91">
                </div>
            </div>
            
            <h1 class="title">Banner</h1>
            <div class="input">
                <label for="url_banner">Url de redirecionamento do banner:</label>
                <input type="text" name="url_banner" id="url_banner" class="editor-link-banner" placeholder="Inserir url...">
            </div>
            <div>
                <div class="featured_video_edit">
                    <label for="carousel">Imagem do banner: </label>    
                    <div class="btn remove-all" id="img_remove" style="display:none;"><span>Remover imagem</span></div>
                </div>
                <label for="banner_img">
                    <div class="preview" title="Clique para escolher uma imagem para o banner">
                        <div class="preview-img-container" data-id-media='' style="max-height: 300px;">
                        </div>
                        <div class="container-icon">
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar imagem para o banner</p>
                        </div>
                    </div>
                </label>
                <input type="file" name="banner_img" id="banner_img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>
            </div>
            
            <h1 class="title">Ativação do tema</h1>
            <div class="two-inputs">
                <div class="input">
                    <label for="initial_date">Data de início:</label>
                    <input type="text" id='visual_initial_date' onclick="$('#initial_date').focus()" placeholder="Clique para adicionar a data inicial..." autocomplete="off">
                    <input type="text" inputmode="none" name="initial_date" id="initial_date" class="datepicker display-n">
                </div>

                <div class="input">
                    <label for="final_date">Data final:</label>
                    <input type="text" id="visual_final_date" placeholder="Clique para adicionar a data final..." onclick="$('#final_date').focus()" autocomplete="off">
                    <input type="text" inputmode="none" name="final_date" id="final_date" class="datepicker display-n">
                </div>
            </div>

            <div>
                <button type="button" name="submit">Enviar</button>
            </div>

        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success"></i></h1>
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
</body>
</html>

<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script>
<script src="<?= base_url("assets/js/template/colors.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/preview-colors.js") ?>"></script>