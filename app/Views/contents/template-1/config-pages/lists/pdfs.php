<?php 
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th style="width: 80%;">PDF</th>';
                echo '<th style="width: 20%;">Excluir</th>';
            echo '</tr>';
        echo '</thead>';
        echo'<tbody class="reports-list">';
        
            if($data['pdfs'] != null){
                foreach ($data['pdfs'] as $key => $pdf) {
                    require("config/content-config.php");

                    echo '<tr>';
                        echo "<td><a href=". base_url("$url/uploads/pdfs?pdf=") . $pdf ." target='blank'>" . $pdf . "</a></td>";
                        echo "<td><i class='fa-light fa-trash-can remove' title='excluir' onclick='confirmModal(`Deseja mesmo excluir esse pdf?`, `ajaxRemove_pdfPost`, `". $pdf . "`)'></i></td>";
                    echo '</tr>';
                } 
            } else {
                echo '<tr>';
                    echo "<td colspan='4'>Ainda não há pdf's.</td>";
                echo '</tr>';
            }

        echo '</tbody>';
    echo '</table>';
?>