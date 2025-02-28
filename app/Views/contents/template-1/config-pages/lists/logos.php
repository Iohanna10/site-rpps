<h2 class="title" style="margin-bottom: 20px!important;">Logo de parceiros</h2>

<div>
    <div class="edit_media">
        <!-- mais mídias -->
        <label for="more_media">
            <div class="btn more-medias"><span>Adicionar logos</span></div>
        </label>
        <input type="file" accept=".png, .jpg, .jpeg" name="more_media" id="more_media" multiple="multiple"></input>
        <!-- fim mais mídias  -->
        
        <!-- remover todads as mídias -->
        <div class="btn remove-all" id="remove_all"><span>Remover todas as logos</span></div>
        <!-- fim remover todas as mídias -->
    </div>
</div>

<?php 
    require("config/content-config.php");

    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 60%;">Logo</th>';
                echo '<th style="width: 40%;">Remover</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';

            if($data != null && $data != ''){
                
                foreach (explode(", ", $data) as $key => $logo) {
                    echo '<tr id="'. $logo .'">';
                        echo "<td class='handler_sortable'>";
                        
                            echo '<div class="img_container">';
                                echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/logos/partners/$logo") .'" alt="'. $logo .'">';
                            echo '</div>';
                        echo '</td>';

                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir essa logo?`, `ajaxRemove_infos`, `". $logo . "`)'></i></td>";
                    echo '</tr>';
                } 
            } 
            else {
                echo '<tr>';
                    echo '<td colspan="4">Ainda não há logo de parceiros.</td>';
                echo '</tr>';
            }

        echo '</tbody>';
    echo '</table>';
?>