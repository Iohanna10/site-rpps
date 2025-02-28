<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Editar Reuniões e Eventos</title>
</head>

<body>

<?php if(!isset($data['blocked'])){ ?> <!-- só exibir conteúdo se o id na url pertencer ao instituto -->
    <?php 
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
        require("config/content-config.php");

        $pathVariation = 'meetings_event/';
        if($data['event']['tipo'] == 'reuniao'){
            $pathVariation .= 'meetings/';
        }
        else {
            $pathVariation .= 'events/';
        }
        $pathVariation .= (new DateTime($data['event']['data']))->format('Y/n/');
    ?>

    <div class="container-form contents">
        <form class="form-cad post-form" method="POST" enctype="multipart/form-data" id='formMeeting' data-id="<?php echo $_GET['id'] ?>" data-type="<?php echo $data['event']['tipo'] ?>" data-path-variation="<?php echo $pathVariation ?>">
            <!-- input de foto principal -->
            <div>
                <div class="featured_video_edit">
                    <label for="carousel">Imagem principal: </label>    
                    <?php if(isset($data['event']['imagem_principal'])){
                        echo '<div class="btn remove-all" id="img_remove" onclick="confirmModal(`Deseja mesmo excluir a imagem?`, `ajaxRemove_eventImg`, `' . $data['event']['imagem_principal'] . '`)"><span>Remover imagem</span></div>';
                    } else {
                        echo '<div class="btn remove-all" id="img_remove" style="display:none;"><span>Remover imagem</span></div>';
                    } ?>
                </div>
                <label for="img">
                    <div class="preview" title="Clique para escolher foto principal do evento">
                        <div class="preview-img-container" data-id-media='<?php echo $data['event']['imagem_principal'] ?>'>
                            <?php if($data['event']['tipo'] === 'evento' && isset($data['event']['imagem_principal'])){
                                echo "<img src='" . base_url("dynamic-page-content/$url/assets/uploads/img/meetings_event/events/") . (new DateTime($data['event']['data']))->format('Y/n/') .  $data['event']['imagem_principal'] ."' alt='' class='preview-img'>";
                            } 
                            elseif ($data['event']['tipo'] === 'reuniao' && isset($data['event']['imagem_principal'])) {
                                echo "<img src='" . base_url("dynamic-page-content/$url/assets/uploads/img/meetings_event/meetings/") . (new DateTime($data['event']['data']))->format('Y/n/') .  $data['event']['imagem_principal'] ."' alt='' class='preview-img'>";
                            }
                            ?>
                        </div>
                        <div class="container-icon" <?php if(isset($data['event']['imagem_principal'])){ echo 'style="display: none;"'; } ?>>
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar foto principal</p>
                        </div>
                    </div>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>
            </div>
            <!-- fim foto principal -->

            <!-- título -->
            <div>
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" placeholder="Título" value="<?php echo $data['event']['titulo'] ?>">
            </div>
            <!-- fim título -->

            <!-- resumo -->
            <div>
                <label for="description">Descrição:</label>
                <textarea type="text" name="description" id="description" class="editor-description" placeholder="Breve descrição..."><?php echo $data['event']['descricao'] ?></textarea>
            </div>
            <!-- fim resumo -->

            
            <!-- resumo -->
            <div>
                <label for="obs">Observações:</label>
                <textarea type="text" name="obs" id="obs" placeholder="Ex: O horário poderá receber alterações..."><?php echo $data['event']['obs'] ?></textarea>
            </div>
            <!-- fim resumo -->

            <!-- dados alternativos do form -->
            <div id="different-data"></div>
            <!-- fim dados alternativos do form -->

            <?php if(isset($data['event']['id_categoria'])) { ?>
                <div class="container-committee">
                    <label for="committee">Conselho:</label>
                    <select name="committee" id="committee">
                        <option value="31" <?php if($data['event']['id_categoria'] == '31'){ echo 'selected'; } ?>>Comitê de Investimento</option>
                        <option value="42" <?php if($data['event']['id_categoria'] == '42'){ echo 'selected'; } ?>>Fiscal</option>
                        <option value="46" <?php if($data['event']['id_categoria'] == '46'){ echo 'selected'; } ?>>Deliberativo</option>
                    </select>
                </div>
            <?php } ?>
            <!-- enviar os dados -->
            <div>
                <button type="button" name="btn_change" id="btn_change">Alterar</button>
            </div>
            <!-- fim enviar os dados -->
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