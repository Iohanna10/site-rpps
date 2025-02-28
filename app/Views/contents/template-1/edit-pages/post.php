<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Editar Publicação</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
</head>
<body>
    <?php if(!isset($data['blocked'])){ ?> <!-- só exibir conteúdo se o id na url pertencer ao instituto -->
    <?php 
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
        require("config/content-config.php");
    ?>
       
    <div class="container-form contents">
       <form class="form-cad post-form" method="POST" enctype="multipart/form-data" id='formPost' data-id="<?php echo $_GET['id'] ?>" data-path-variation="<?php echo 'posts/' . (new DateTime($data['post']['data']))->format('Y/n/') ?>">

            <!-- input de foto principal da notícia -->
            <div>
                <div class="featured_video_edit">
                    <label for="carousel">Imagem principal: </label>    
                    <?php if($data['post']['imagem_principal'] !== null){
                        echo '<div class="btn remove-all" id="img_remove" onclick="confirmModal(`Deseja mesmo excluir a imagem principal?`, `ajaxRemoveFeatured_post`, `' . $data['post']['imagem_principal'] . '`)"><span>Remover imagem</span></div>';
                    } else {
                        echo '<div class="btn remove-all" id="img_remove" style="display:none;"><span>Remover imagem</span></div>';
                    } ?>
                </div>
                <label for="img">
                    <div class="preview" title="Clique para escolher foto principal da publicação">
                        <div class="preview-img-container" data-id-media="<?php echo $data['post']['imagem_principal'] ?>">
                            <?php if($data['post']['imagem_principal'] !== null){
                                echo '<img src="' . base_url("dynamic-page-content/$url/assets/uploads/img/posts/") . (new DateTime($data['post']['data']))->format('Y/n/') . $data['post']['imagem_principal'] . '" alt="Imagem principal da publicação">';

                                echo '</div>';

                                echo '<div class="container-icon" style="display: none;">';
                                    echo '<i class="fa-solid fa-camera"></i>';
                                    echo '<p>Adicionar foto principal</p>';
                                echo '</div>';
                            } else {
                                echo '</div>';

                                echo '<div class="container-icon">';
                                    echo '<i class="fa-solid fa-camera"></i>';
                                    echo '<p>Adicionar foto principal</p>';
                                echo '</div>';
                            }?>
                    </div>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>
            </div>
            <!-- fim input de foto principal da notícia -->

            <!-- título do post -->
            <div>
                <label for="title">Título da publicação:</label>
                <input type="text" name="title" id="title" placeholder="Título" value="<?php echo $data['post']['titulo'] ?>">
            </div>
            <!-- fim título do post -->

            <!-- resumo do post -->
            <div>
                <label for="description">Descrição da publicação:</label>
                <textarea type="text" name="description" id="description" placeholder="Breve descrição..."><?php echo $data['post']['descricao'] ?></textarea>
            </div>
            <!-- fim resumo do post -->

            <!-- conteúdo principal do post -->
            <div>
                <label for="main_content">Conteúdo principal:</label>
                <textarea class="publication" type="text" name="main_content" id="main_content" placeholder="Digite o conteúdo principal da publicação...">
                    <?php 
                        if($data['post']['conteudo'] !== null){
                            echo $data['post']['conteudo'];
                        } 
                    ?>
                </textarea>
            </div>
            <!-- fim conteúdo principal do post -->

            <!-- ordem de visualização -->
            <div class="medias-list">
            </div>
            <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Clique e arraste a mídia para um novo local na tabela para alterar a ordem que são exibidos na galeria.</span>
            <!-- fim ordem de visualização -->

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
    </div>

    <?php } 
    
    else {
        echo '
            <div class="warning">
                <span>Algo deu errado, tente novamente mais tarde.</span>
            </div>
        ';
    }

    ?>

</body>
</html>