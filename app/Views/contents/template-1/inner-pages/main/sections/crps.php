<?php 
    require("config/content-config.php");
    require_once("functions/month-to-upper.php");

    $formatter = new IntlDateFormatter(
        'pt_BR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'America/Sao_Paulo',          
        IntlDateFormatter::GREGORIAN
    );
?>

<section class="contents">
    <div class="container">
        <div class="crp">
            
            <div class="what-is">
                <h1>O que é CRP?</h1>
                <p>O <b>Certificado de Regularidade Previdenciária - CRP</b> é um documento fornecido pela Secretaria de Políticas de Previdência Social – SPS, do Ministério da Previdência Social, que atesta o cumprimento dos critérios e exigências estabelecidos na Lei nº 9.717, de 27 de novembro de 1998, pelo regime próprio de previdência social de um Estado, do Distrito Federal ou de um Município, ou seja, atesta que o ente federativo segue normas de boa gestão, de forma a assegurar o pagamento dos benefícios previdenciários aos seus segurados.</p>
            </div>

            <div class="authenticity">
                <h1>Autenticidade</h1>
                <p>O CRP é disponibilizado por meio eletrônico, dispensada a assinatura manual ou aposição de carimbos, contém numeração única e tem validade de noventa dias a contar da data de sua emissão.</p>
            </div>

            <div class="certificates">
                
                <?php 
                    if(count($data['crps']) > 0){
                        echo '<div class="main-certificate">';
                            echo '<p><a href="'. base_url("$url/uploads/pdfs?pdf=") . $data['crps'][0]['nome'] .'" target="blank">Certificado de Regularidade Previdenciária</a></p>';
                        echo '</div>';
                    }
                ?>
                
                <div class="other-certificates">
                <div class="background"></div>
                <div class="latest-crps">
                    <div class="header-crps">
                        <h1>Últimos Certificados</h1>
                    </div>
                        
                    <?php if($data['crps'] != null) {
                        echo "<div class='main-crps'>";
            
                        foreach ($data['crps'] as $num => $crp) {
                            echo "<div class='crps'>";
                                echo "<div class='link'>";
                                echo  "<h6><a href='". base_url("$url/uploads/pdfs?pdf="). $crp['nome'] . "' target='blank'>". $crp['titulo'] ."</a></h6>";
                                echo "</div>";
                                echo "<div class='infos'>";
                                    echo "<div class='date'>";
                                        echo "<i class='fa-light fa-clock'></i>";
                                        echo '<span>'. upper($formatter->format(new DateTime($crp['data']))) .'</span>';
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
            
                        if($data['numCrps'] > 3){
                            echo '<div class="footer-crps">';
                                echo "<p><em><a href='" . base_url("$url/crps/certificados") . "'>(para cálculos mais antigos, clique aqui)</a></em></p>";
                            echo "</div>";
                        } 
            
                    } else {
                        echo '<p>Não há nenhum CRP disponível';
                    } ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>  