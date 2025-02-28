<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Editar Galeria</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
</head>
<body>
    <div class="container-form contents">
    <?php

    use App\Models\Functions\Functions;

    if(!isset($data['blocked'])){ ?> <!-- só exibir conteúdo se o id na url pertencer ao instituto -->
        <?php 
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            require("config/content-config.php");

            $pathVariation = "photo-gallery/thumb/" . (new DateTime($data['gallery']['data']))->format('Y/n/') . (new Functions)->nameDir($data['gallery']['nome']) . '/';
        ?>

            <form class="form-cad post-form" method="POST" enctype="multipart/form-data" id='formGallery' data-id="<?php echo $_GET['id'] ?>" data-name="<?php echo $data['gallery']['nome'] ?>" data-path-variation="<?php echo $pathVariation ?>">

                <!-- input de foto principal da notícia -->
                <div>
                    <div class="featured_video_edit">
                        <label for="carousel">Capa da galeria: </label>    
                        <?php if($data['gallery']['imagem_principal'] !== null){
                            echo '<div class="btn remove-all" id="img_remove" onclick="confirmModal(`Deseja mesmo excluir a imagem de capa?`, `ajaxRemoveFeatured_gallery`, `' . $data['gallery']['imagem_principal'] . '`)"><span>Remover imagem</span></div>';
                        } else {
                            echo '<div class="btn remove-all" id="img_remove" style="display:none;"><span>Remover imagem</span></div>';
                        } ?>
                    </div>
                    <label for="img">
                        <div class="preview" title="Clique para escolher a imagem de capa da galeria">
                            <div class="preview-img-container" data-id-media='<?php echo $data['gallery']['imagem_principal'] ?>'>
                                <?php if(isset($data['gallery']['imagem_principal'])){ ?>
                                    <img src="<?= base_url("dynamic-page-content/$url/assets/uploads/img/photo-gallery/thumb/") . (new DateTime($data['gallery']['data']))->format('Y/n/') . (new Functions)->nameDir($data['gallery']['nome'])  .'/' . $data['gallery']['imagem_principal'] ?>" alt="Capa da galeria">
                                <?php } ?>
                            </div>
                            <div class="container-icon" <?php if(isset($data['gallery']['imagem_principal'])) { echo  'style="display: none!important;"'; } ?>>
                                <i class="fa-solid fa-camera"></i>
                                <p>Adicionar foto principal</p>
                            </div>
                        </div>
                    </label>
                    <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>
                </div>
                <!-- fim input de foto principal da notícia -->

                <!-- título da galeria -->
                <div>
                    <label for="title">Título da galeria:</label>
                    <input type="text" name="title" id="title" placeholder="Título" value="<?php echo $data['gallery']['nome'] ?>">
                </div>
                <!-- fim título -->

                <!-- resumo -->
                <div>
                    <label for="description">Descrição da galeria:</label>
                    <textarea type="text" name="description" id="description" placeholder="Breve descrição do conteúdo..."><?php echo $data['gallery']['descricao_galeria'] ?></textarea>
                </div>
                <!-- fim resumo -->
        
                <!-- input de descrição de imagens do carrossel-->
                <div class="medias-list">
                </div>
                <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Clique e arraste a mídia para um novo local na tabela para alterar a ordem que são exibidos na galeria.</span>

                <!-- input para enviar os dados -->
                <div>
                    <button type="button" name="btn_change" id="btn_change">Alterar</button>
                </div>
                <!-- fim input para enviar os dados -->
            </form>        

                  
            <div class="bg-modal">
                <div class="modal-info">
                    <h1 class="success"></h1>
                    <p></p>
                    <button type="button" id="btnModal">Ok</button>
                </div>
                <div class="modal modal-confirm">
                    <p></p>
                    <button type="button" id="btnModalConfirm">Excluir</button>
                    <button type="button" id="btnModal">Não</button>
                </div>
            </div>
    <?php } else {
        echo '
            <div class="warning">
                <span>Algo deu errado, tente novamente mais tarde.</span>
            </div>';
    } ?>
    </div>
</body>
</html>