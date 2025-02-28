<head>
    <?php require("config/content-config.php"); ?>
    <title>Editar Equipes</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/team.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/modal-infos.css") ?>">
</head>
<body>
    <div class="container-form contents">
        <form>
            <div class="container-committee">
                <label for="team">Equipe:</label>
                <select name="team" id="team">
                    <option value="0">Instituto</option>
                    <option value="1">Comitê de Investimento</option>
                    <option value="2">Fiscal</option>
                    <option value="3">Deliberativo</option>
                </select>
            </div>
            <div class="add-member">
                <span>Clique para adicionar novos integrantes para uma equipe do instituto:</span>
                <a onclick="addMember()"><button type="button">Adicionar</button></a>
            </div>
        </form>
        <div class="container-list">
            <div id="team-list" class="list-all"></div>
            <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Clique e arraste o nome de um integrante para um novo local na tabela para alterar a ordem que são exibidos na página correspondente.</span>
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

