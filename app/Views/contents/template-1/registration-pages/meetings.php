<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Cadastro de Reuniões e Eventos</title>
</head>

<body>
    <div class="container-form contents">
        <form>
        <h1 class="title">Criar evento</h1>
            <div class="two-inputs" id="type">
                <div>
                    <label for="type_post">Tipo:</label>
                    <select name="type_post" id="type_post">
                        <option value="evento">Evento</option>
                        <option value="reuniao">Reunião de conselho</option>
                    </select>
                </div>
            </div>
        </form>

        <form class="form-cad post-form" method="POST" enctype="multipart/form-data" id='formMeeting'>
            <!-- input de foto principal da notícia -->
            <div>
                <label for="img">
                    <div class="preview" title="Clique para escolher foto principal da postagem">
                        <div class="preview-img-container">

                        </div>
                        <div class="container-icon">
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar foto principal</p>
                        </div>
                    </div>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" onchange="previewImg(this)" required>

                <!-- erros -->
                <div class="error">
                    <div class="wrongImg"></div>
                    <div class="type"></div>
                </div>
            </div>
            <!-- fim foto principal -->

            <!-- título -->
            <div>
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" placeholder="Título">

                <!-- erros -->
                <div class="error">
                    <div class="title"></div>
                </div>

            </div>
            <!-- fim título -->

            <!-- resumo -->
            <div>
                <label for="description">Descrição:</label>
                <textarea type="text" name="description" id="description" class="editor-description" placeholder="Breve descrição..."></textarea>

                <!-- erros -->
                <div class="error">
                    <div class="description"></div>
                </div>
            </div>
            <!-- fim resumo -->
            
            <!-- resumo -->
            <div>
                <label for="obs">Observações:</label>
                <textarea type="text" name="obs" id="obs" placeholder="Ex: O horário poderá receber alterações..."></textarea>

                <!-- erros -->
                <div class="error">
                    <div class="obs"></div>
                </div>
            </div>
            <!-- fim resumo -->

            <!-- dados alternativos do form -->
            <div id="different-data"></div>
            <!-- fim dados alternativos do form -->

            <!-- enviar os dados -->
            <div>
                <button type="button" name="btnCad" id="btnCad">Enviar</button>
            </div>
            <!-- fim enviar os dados -->
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success fa-sharp fa-solid fa-check"></i></h1>
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>
    </div>

</body>

</html>

<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>