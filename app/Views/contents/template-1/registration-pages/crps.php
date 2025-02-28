<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Adicionar CRP</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/inner-pages/read-more/table.css") ?>">
</head>
<body>
    <div class="container-form contents">
        <div class="reports container-form">
            <form>
                <h1 class="title">Adicionar Certificado de Regularidade Previdenciária</h1>
                <div class="input">
                    <input type="text" name="title" id="title" placeholder="Título">
                </div>
                <div class="two-inputs">
                    <div class="biggest"> <!-- input PDF -->
                        <label for="pdf">
                            <div class="pdf">
                                <span class="name-pdf">Clique aqui para adicionar um PDF:</span>
                                <i class="fa-light fa-file-pdf"></i>
                            </div>
                        </label>
                        <input type="file" name="pdf" id="pdf" accept=".pdf">
                    </div> <!-- fim input PDF -->
                    
                    <div class="smallest"> <!-- input para enviar os dados -->
                        <button type="button" id="btnPdf">Adicionar</button>
                    </div> <!-- fim input para enviar os dados -->
                </div>
            </form>
    
            <div class="container-previous-reports container-list">
                  
            </div>
        </div>

        <!-- modal -->
        <div class="bg-modal">
            <div class="modal-info">
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
</body>
</html>

<script src="<?= base_url("assets/js/forms/crp/ajax-data.js") ?>"></script>
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/crp/add.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/crp/crp-register.js") ?>"></script>