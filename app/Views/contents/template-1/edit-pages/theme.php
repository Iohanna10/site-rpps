<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require("config/content-config.php");?>
    <title>Editar tema</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/datepicker.css") ?>">
</head>

<?php
    /*
    Argumentos:
        $url:    A URL a ser verificada
        $limite: Define o tempo limite. É opcional, o padrão é 25s
    Retorno:
        true:  Se a URL estiver disponível
        false: Se a URL estiver quebrada
    */
    function verifyLink($url, $limite = 25){ // verifica se existe a url
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);        // Inicia uma nova sessão do cURL
        curl_setopt($curl, CURLOPT_TIMEOUT, $limite); // Define um tempo limite da requisição
        curl_setopt($curl, CURLOPT_NOBODY, true);     // Define que iremos realizar uma requisição "HEAD"
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false); // Não exibir a saída no navegador
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Não verificar o certificado do site

        curl_exec($curl);  // Executa a sessão do cURL
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200; // Se a resposta for OK, a URL está ativa
        curl_close($curl); // Fecha a sessão do cURL

        return $status;
    }
?>

<body>
    <div class="container-form contents">
        <form class="form-cad" method="POST" id='formPost' data-id="<?php echo $_GET['id'] ?>" data-path-variation="banners/">
            <h1 class="title">Personalizar tema</h1>

            <div class="input">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="<?php echo $data['theme']['nome'] ?>">
            </div>

            <!-- previsualização do tema -->
            <iframe id="preview-colors" src="configuracoes-instituto/preview" onload="iframePreview()"></iframe>

            <div class="two-inputs">
                <div class="input">
                    <label for="primary">Cor principal</label>
                    <input type="color" name="primary" id="primary" value="<?php echo $data['theme']['cor_principal'] ?>" data-db_color="<?php echo $data['theme']['cor_principal'] ?>">
                </div>

                <div class="input">
                    <label for="secundary">Cor secundária</label>
                    <input type="color" name="secundary" id="secundary" value="<?php echo $data['theme']['cor_secundaria'] ?>" data-dbColor="<?php echo $data['theme']['cor_secundaria'] ?>">
                </div>

                <div class="input">
                    <label for="hover">Cor ao deixar em foco</label>
                    <input type="color" name="hover" id="highlight" value="<?php echo $data['theme']['cor_destaque'] ?>" data-dbColor="<?php echo $data['theme']['cor_destaque'] ?>">
                </div>
            </div>
            
            <h1 class="title">Banner</h1>
            <div class="input">
                <label for="url_banner">Url de redirecionamento do banner:</label>
                <input type="text" name="url_banner" id="url_banner" class="editor-link -banner" placeholder="Inserir url..." value="<?php echo $data['theme']['url_banner'] ?>">
            </div>
            <div>
                <div class="featured_video_edit">
                    <label for="carousel">Imagem do banner: </label>    
                    <?php if(isset($data['theme']['banner'])){
                        echo '<div class="btn remove-all" id="img_remove" onclick="confirmModal(`Deseja mesmo excluir a imagem?`, `ajaxRemove_themeBanner`,' . $data['theme']['id'] . ');"><span>Remover imagem</span></div>';
                    } else {
                        echo '<div class="btn remove-all" id="img_remove" style="display:none;"><span>Remover imagem</span></div>';
                    } ?>
                </div>
                <label for="banner_img">
                    <div class="preview" title="Clique para escolher uma imagem para o banner">
                        <div class="preview-img-container" data-id-media='<?php if(isset($data['theme']['banner'])){echo $data['theme']['banner'];} ?>' style="max-height: 300px;">
                            <?php if(isset($data['theme']['banner'])){
                                echo "<img src='" . base_url("dynamic-page-content/$url/assets/uploads/img/banners/") .  $data['theme']['banner'] ."' alt='banner' class='preview-img'>";
                            } ?>
                        </div>
                        <div class="container-icon" <?php if(isset($data['theme']['banner'])){ echo 'style="display: none;"'; } ?>>
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
                    <input type="text" id='visual_initial_date' onclick="$('#initial_date').focus()" placeholder="Clique para adicionar a data inicial..." autocomplete="off" value="<?php echo (new DateTime($data['theme']['data_inicio']))->format('d/m') ?>">
                    <input type="text" name="initial_date" id="initial_date" class="datepicker display-n" value="<?php echo (new DateTime($data['theme']['data_inicio']))->format('Y/m/d') ?>" inputmode="none">
                </div>

                <div class="input">
                    <label for="final_date">Data final:</label>
                    <input type="text" id="visual_final_date" placeholder="Clique para adicionar a data final..." onclick="$('#final_date').focus()" autocomplete="off" value="<?php echo (new DateTime($data['theme']['data_final']))->format('d/m') ?>">
                    <input type="text" name="final_date" id="final_date" class="datepicker display-n" value="<?php echo (new DateTime($data['theme']['data_final']))->format('Y/m/d') ?>" inputmode="none">
                </div>
            </div>

            <div>
                <button type="button" id="btnChange">Alterar</button>
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
</body>
</html>

<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script>
<script src="<?= base_url("assets/js/template/colors.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/preview-colors.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/account/institute/customize-institute.js") ?>"></script>  <!-- js próprio -->
