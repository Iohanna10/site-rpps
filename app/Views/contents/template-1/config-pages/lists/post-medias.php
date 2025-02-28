<h1 class="title" style="margin-bottom: 20px!important;">Mídias da galeria da publicação</h1>

<label for="carousel_url_videos">Url de vídeos no Youtube para a galeria:</label>
<div class="two-inputs" style="margin-bottom: 20px!important;">
    <div class="biggest">
        <input type="text" name="carousel_url_videos" id="carousel_url_videos" placeholder="https://www.youtube.com/watch?v=exemplo">
    </div>
    <div class="smallest">
        <button id="add_url" type="button">Adicionar</button>
    </div>
</div>

<div>
    <div class="edit_media">
        <!-- mais mídias -->
        <label for="more_media">
            <div class="btn more-medias"><span>Adicionar mídias</span></div>
        </label>
        <input type="file" accept=".png, .jpg, .jpeg, video/*" name="more_media" id="more_media" multiple="multiple"></input>
        <!-- fim mais mídias  -->
        
        <!-- remover todads as mídias -->
        <div class="btn remove-all" id="remove_all"><span>Remover todas as mídias</span></div>
        <!-- fim remover todas as mídias -->

    </div>
</div>

<?php 
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 60%;">Mídia</th>';
                echo '<th style="width: 40%;">Remover</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';

            if($data['midias'] != null){
                foreach ($data['midias'] as $key => $media) {
                    require("config/content-config.php");

                    echo '<tr id="'. $media['nome'] .'">';
                        echo "<td class='handler_sortable'>";
                        
                            echo '<div class="img_container">';

                            if($media['tipo'] !== 'url'){
                                // caminho do arquivo 
                                $path = base_url() . "dynamic-page-content/$url/assets/uploads/". $media['tipo'] . "/posts/" . (new DateTime($data['data']))->format('Y/n/') . $media['nome'];
                            
                                if($media['tipo'] == 'img'){
                                    echo '<img src="'. $path .'" alt="'. $media['nome'] .'">';
                                } else {
                                    echo '<video width="100%" height="120px" controls=""> <source src="'. $path .'" alt="'. $media['nome'] .'" class="preview-slider">Seu navegador não suporta vídeo HTML5.</video>';
                                }
                            } else {
                                echo '<iframe width="100%" height="120" src="https://www.youtube.com/embed/'. $media['nome'] .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>';
                            }

                            echo '</div>';
                        echo '</td>';

                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir essa mídia da galeria?`, `ajaxRemove_postEdit`, `". $media['nome'] . "`)'></i></td>";
                    echo '</tr>';
                } 
            } 
            else {
                echo '<tr>';
                    echo '<td colspan="4">Ainda não há mídias nesta galeria.</td>';
                echo '</tr>';
            }

        echo '</tbody>';
    echo '</table>';
?>