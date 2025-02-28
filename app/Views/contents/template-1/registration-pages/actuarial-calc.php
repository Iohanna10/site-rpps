<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Ajustes Cálculo Atuarial</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/inner-pages/read-more/table.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
</head>
<body>
    <div class="container-form contents">
        <form class="form-cad" method="POST" enctype="multipart/form-data" id='formPost'>
            <h1 class="title">Hipóteses adotadas pelo instituto para o cálculo</h1>
            <div>
                <textarea class="editor" type="text" name="hypotheses" id="hypotheses" placeholder="Digite as hipóteses adotadas..."><?php if($data['calc_atuarial'] != null){echo $data['calc_atuarial'];}?></textarea>
            </div>

            <h1 class="title">Regimes Financeiros utilizados no cálculo pelo instituto</h1>
            <div>
                <textarea class="editor" type="text" name="financial_regimes" id="financial_regimes" placeholder="Digite os regimes utilizados..."><?php if($data['regimes_financeiros'] != null){echo $data['regimes_financeiros'];}?></textarea>
            </div>

            <div>
                <button type="button" id="btnChange">Alterar</button>
            </div>
        </form>

        <div class="reports container-form">
            <form class="form-cad">
                <h1 class="title">Adicionar relatório atuarial</h1>
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

<script src="<?= base_url() ?>assets/js/tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>assets/js/tinymce/langs/pt_BR.js"></script>

<script src="<?= base_url("assets/js/forms/actuarial-calculation/ajax-data.js") ?>"></script>
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/actuarial-calculation/add.js") ?>"></script>
<script src="<?= base_url("assets/js/table/list/actuarial-calc/actuarial-cal-register.js") ?>"></script>