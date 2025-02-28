<head>
    <?php require("config/content-config.php"); ?>
    <title>Configurações de eventos</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/modal-infos.css") ?>">
</head>
<body>
    <div class="container-form contents">
        <form>
            <div class="add-item">
                <span>Clique para adicionar um novo evento:</span>
                <a onclick="addEvent()"><button type="button">Adicionar</button></a>
            </div>
        </form>
        <div class="container-filters">
            <div class="toggle-filter">
                <h1>Filtrar eventos</h1>
                <i class="fa-sharp fa-solid fa-arrow-up"></i>
            </div>
            <div class="filters active">
                <form id="form-filter">
                
                    <div class="two-inputs" id="type">
                        <div>
                            <label for="typeEvent">Tipo:</label>
                            <select name="typeEvent" id="typeEvent">
                                <option value="" selected>Todos</option>
                                <option value="evento">Evento</option>
                                <option value="reuniao">Reunião de conselho</option>
                            </select>
                        </div>
                    </div>  
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
                            <label for="end_date">Até:</label>
                            <input type="date" name="end_date" id="end_date">
                        </div>
                        <div class="order-view">
                            <label for="order">Ordem de visualização</label>
                            <select name="order" id="order">
                                <option value="DESC">Mais recente</option>
                                <option value="ASC">Menos recente</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn">
                        <button type="button" id="btnFilters" title="aplicar filtros">Aplicar</button>
                        <button type="button" id="btnRemoveFilters" title="remover filtros">Remover</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container-list" class="list-all">
            <div id="events-list"></div>
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

<script src="<?= base_url("assets/js/forms/meetings/remove.js") ?>"></script> 
