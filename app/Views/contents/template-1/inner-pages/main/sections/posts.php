<head>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/modal-infos.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/forms.css">
</head>
<section class="contents">
    <div class="container" style="position: relative;">

        <div class="container-filters">
            <div class="toggle-filter" onclick="toggleFilter()">
                <h1>Filtrar</h1>
                <i class="fa-sharp fa-solid fa-arrow-down"></i>
            </div>
            <div class="filters">
                <form method="post" id="form-filter">
                    <div class="two-inputs">
                        <div>
                            <label for="start_date">A partir de:</label>
                            <input type="date" name="start_date" id="start_date">
                        </div>
                        <div>
                            <label for="end_date">Até:</label>
                            <input type="date" name="end_date" id="end_date">
                        </div>
                        <div>
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

        <div class="list-posts" data-route_id="<?php echo $data['routeId'] ?>" <?php if (isset($data['search'])) echo "data-search='" . $data['search'] . "'" ?>>
        </div>

        <div class="loader">
            <div style="background-image: url('<?= base_url("assets/gifs/loading.gif") ?>')"></div>
        </div>

        <div class="full-post hidden">
        </div>

        <div class="bg-modal">
            <div class="modal-info">
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>

    </div>
</section>
<script src="<?= base_url() ?>assets/js/modal/modal.js"></script>
<script src="<?= base_url() ?>assets/js/posts/data-post.js"></script>
<script src="<?= base_url() ?>assets/js/gallery/slide-control.js"></script>
<script src="<?= base_url() ?>assets/js/posts/gallery-slider-post.js"></script>
<script src="<?= base_url() ?>assets/js/posts/slider-posts.js"></script>
<script src="<?= base_url() ?>assets/js/table/pagination/posts.js"></script>
<script src="<?= base_url() ?>assets/js/forms/posts/filter.js"></script>
