<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require("config/content-config.php");?>
    <title>Personalizar instituto</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/modal-preview.css") ?>">
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
        <form class="form-cad" method="POST" id='formPost' data-path-variation="banners/">
            <h1 class="title">Personalizar instituto</h1>
            <!-- nome -->
            <div class="input">
                <label for="img">
                    <div class="preview profile favicon" title="Clique para escolher o favicon">
                        <div class="preview-img-container"  data-id-media='favicon.png'>
                            <?php if(verifyLink(base_url("/dynamic-page-content/$url/assets/uploads/img/favicon/favicon.png"))){ ?>
                                <img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/favicon/favicon.png")?>" alt="Sua foto de perfil">
                            <?php } ?>
                        </div>
                        <div class="container-icon" <?php if(verifyLink(base_url("/dynamic-page-content/$url/assets/uploads/img/favicon/favicon.png"))){ ?> style="display: none!important;" <?php } ?>>
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar favicon</p>
                        </div>
                    </div>
                </label>
                <label for="img_error">Favicon <span class="error"></span></label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg(this)">
            </div>

            <h2 class="title">Cores padrão</h2>

            <iframe id="preview-colors" src="configuracoes-instituto/preview" onload="iframePreview()"></iframe>

            <div class="two-inputs">
                <div class="input">
                    <label for="primary">Cor principal</label>
                    <input type="color" name="primary" id="primary" value="<?php echo $data['defaultTheme']['cor_principal'] ?>" data-db_color="<?php echo $data['defaultTheme']['cor_principal'] ?>">
                </div>

                <div class="input">
                    <label for="secundary">Cor secundária</label>
                    <input type="color" name="secundary" id="secundary" value="<?php echo $data['defaultTheme']['cor_secundaria'] ?>" data-dbColor="<?php echo $data['defaultTheme']['cor_secundaria'] ?>">
                </div>

                <div class="input">
                    <label for="secundary">Cor ao deixar em foco</label>
                    <input type="color" name="hover" id="highlight" value="<?php echo $data['defaultTheme']['cor_destaque'] ?>" data-dbColor="<?php echo $data['defaultTheme']['cor_destaque'] ?>">
                </div>
            </div>
            
            <h2 class="title">Banner padrão</h2>
            <div class="input">
                <label for="url_banner">Url de redirecionamento do banner:</label>
                <input type="text" name="url_banner" id="url_banner" class="editor-link-banner" placeholder="Inserir url..." value="<?php echo $data['defaultTheme']['url_banner'] ?>">
            </div>
            <div>
                <div class="featured_video_edit">
                    <label>Imagem do banner: </label>    
                    <?php if(isset($data['defaultTheme']['banner'])){
                        echo '<div class="btn remove-all" id="img_remove" onclick="confirmModal(`Deseja mesmo excluir o banner?`, `ajaxRemove_themeBanner`)" for="banner_img"><span>Remover imagem</span></div>';
                    } else {
                        echo '<div class="btn remove-all" id="img_remove" style="display:none;" for="banner_img"><span>Remover imagem</span></div>';
                    } ?>
                </div>
                <label for="banner_img">
                    <div class="preview" title="Clique para escolher uma imagem para o banner">
                        <div class="preview-img-container" data-id-media='<?php if(isset($data['defaultTheme']['banner'])){echo $data['defaultTheme']['banner'];} ?>' style="max-height: 300px;" >
                            <?php if(isset($data['defaultTheme']['banner'])){
                                echo "<img src='" . base_url("dynamic-page-content/$url/assets/uploads/img/banners/") . $data['defaultTheme']['banner'] ."' alt='banner' class='preview-img'>";
                            } ?>
                        </div>
                        <div class="container-icon" <?php if(isset($data['defaultTheme']['banner'])){ echo 'style="display: none;"'; } ?>>
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar imagem para o banner</p>
                        </div>
                    </div>
                </label>
                <input type="file" name="banner_img" id="banner_img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>
            </div>

            <div>
                <button type="button" id="btnChange">Alterar</button>
            </div>
        </form>

        <div class="container-previous">
            <h2 class="title">Temas comemorativos/alternativos</h2>     
            <form style="padding: 0;">
                <div class="add-item">
                    <span>Clique para adicionar um novo tema:</span>
                    <a onclick="addTheme()"><button type="button">Adicionar</button></a>
                </div>
            </form>            
            </form>
            <div style="width: 100%;">
                <div class="toggle-filter">
                    <h1>Filtrar temas</h1>
                    <i class="fa-sharp fa-solid fa-arrow-up"></i>
                </div>
                <div class="filters active">
                    <form id="form-filter">
                        <div class="input">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="two-inputs">
                            <div>
                                <label for="start_date">A partir de:</label>
                                <input type="date" name="start_date" id="start_date">
                            </div>
                            <div>
                                <label for="endDate">Até:</label>
                                <input type="date" name="end_date" id="end_date">
                            </div>
                        </div>
                        <div class="btn">
                            <button type="button" id="btnFilters" title="aplicar filtros">Aplicar</button>
                            <button type="button" id="btnRemoveFilters" title="remover filtros">Remover</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container-tabs">
                <div class="tabs" id="mainTab_themes">
                    <div class="tab-buttons">
                        <button type="button" class="tab-btn active" content-id="user_themes">Meus temas</button>
                        <button type="button" class="tab-btn" content-id="preset_themes">Temas predefinidos</button>
                    </div>
                    <div class="tab-contents">
                        <!-- política de investimento -->
                        <div class="tab-content show" id="user_themes">
                            <div class="container-list">
                                <div id="user_themes" class="list-all"></div>
                            </div>
                        </div>
        
                        <!-- comitê de investimento -->
                        <div class="tab-content" id="preset_themes">
                            <div class="container-list" class="list-all">
                                <div id="preset_themes"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

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
            <!-- modal de pré-visualização do tema -->
            <div class="modal-preview" id="modal-preview" style="display: none;"> 
                <div class="close-modal">
                    <div>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </div>
                <div class="loader"><img src="<?php echo base_url('assets/gifs/loading-gif.gif') ?>" alt="gif de carregamento"></div>
                <iframe id="preview-themes" src="configuracoes-instituto/preview"></iframe>
            </div>
        </div>
    </div>
</body>
</html>

<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script>
<script src="<?= base_url("assets/js/tab/tab.js") ?>"></script>
