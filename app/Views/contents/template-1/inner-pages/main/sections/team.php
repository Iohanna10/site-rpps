<?php 
    use Functions\Formatter\Formatter;

    // pegar a url
    require("config/content-config.php");

    // formatação de dados
    require_once("functions/formatter.php");
    $formatter = new Formatter;
?>
<body>
    <section class="contents">
        <div class="container">
            <div class="team">
                <?php 
                    if(isset($data['members'])){
                        foreach ($data['members'] as $num => $member) {
                            echo '<div class="team-member">';
                                echo '<div class="member-img">';
                                    echo '<img src="'. base_url("dynamic-page-content/$url/assets/uploads/img/team/committee/" . $data['committee'] . "/". $member->{'foto'}) .'" alt="Membro da equipe">';
                                echo '</div>';
                                
                                echo '<div class="identification">';
                                    echo '<div class="name"><h4>'. $member->{'nome'} .'</h4></div>';
                                    echo '<div class="role"><p>'. $member->{'area_de_atuacao'} .'</p></div>';
                
                                    if($member->{'numero'} != null){
                                        echo '<div class="telephone">';
                                            echo '<a href="tel:'. $member->{'numero'} .'"><i class="fa-solid fa-phone-flip"></i><p>'. $formatter->tel($member->{'numero'}) .'</p></a>';
                                        echo '</div>';
                                    }
                
                                    echo '<span class="underline"></span>';
                                echo '</div>';
                
                                if($data['committee'] == 'investment'){
                                    echo '<div class="affiliate">';
                                        echo '<div class="committee">';
                                            echo '<p>MEMBRO COMITÊ DE INVESTIMENTO</p>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                
                                if($data['committee'] != 'investment' && $data['committee'] != 'team'){
                                    echo '<div class="desc">';
                                            echo '<p>'. $member->{'local_atuacao'} .'</p>';
                                            echo '<br>';
                                            if($member->{'titular'} == 1){
                                                echo '<p>Títular</p>';
                                            }
                                    echo '</div>';
                                }
                                
                                if($member->{'certificacao'} != null){
                                    echo '<div class="certification">';
                                        echo '<h5>'. $member->{'certificacao'} . '</h5>';
                                    echo '</div>';
                                }     
                                    
                                if($member->{'email'} != null){
                                    echo '<div class="contat">';
                                        echo '<div class="email">';
                                            echo '<a href="mailto:'. $member->{'email'} .'" class="icon_bar icon_bar_small">';
                                                echo '<div>';
                                                    echo '<span class="t"><i class="fa-sharp fa-solid fa-envelope"></i></span>';
                                                echo '</div>';
                                                echo '<div>';
                                                    echo '<span class="b"><i class="fa-sharp fa-solid fa-envelope"></i></span>';
                                                echo '</div>';
                                            echo '</a>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                    
                            echo '</div>';
                        }
                    } else {
                        echo '
                            <div class="warning">
                                <span>Ainda não há nada para ver aqui.</span>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </section> 
</body>