<table class="birthday-list">
    <thead>
        <tr>
            <th>
                <h1>ANIVERSARIANTES DE <?php echo mb_strtoupper($data['date']['month'], 'UTF-8') ?></h1>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <table class="main-list birthday-list">
                    <!-- head da tabela -->
                    <thead>
                        <tr>
                            <th>
                                <h5>Dia</h5>
                            </th>
                            <th>
                                <h5>Nome</h5>
                            </th>
                        </tr>
                        </thead>

                    <!-- body da tabela -->
                    <tbody class="list-users">
                
                    <?php if($data['dbData'] != null){
                        foreach ($data['dbData'] as $key => $birthday) { ?>
                                <tr>
                                    <td><?php echo $birthday->{'dia'} ?></td>
                                    <td><?php echo $birthday->{'nome'} ?></td>
                                </tr>
                        <?php }
                    } else { ?>
                            <tr>
                                <td colspan="2">Ainda não há aniversariantes neste mês.</td>
                            </tr>
                    <?php } ?>

                    </tbody>
                </table>

                <!-- menu de navegação -->
                <?php if($data['qntPg'] > 1){ ?>
                    <nav aria-label="navigation">
                        <ul class='pagination'>

                            <?php
                            // variáveis
                            $maxLinks = 2; // nº max de links antes/depois da pg atual no menu de nav
                            $date = date_format($data['date']['full'], 'Y-m-d'); // data para pesquisar os aniversários

                            // primeira pg
                            echo "<li class='page-item'><a class='page-link' onclick='listUsers(1, $date)'>Primeira</a></li>";

                            // paginás anteriores
                            for($prevPg = ($data['currentPg'] - $maxLinks); $prevPg <= ($data['currentPg'] - 1); $prevPg++){
                                if($prevPg > 0){
                                    echo "<li class='page-item'><a class='page-link' onclick='listUsers($prevPg, $date)'>$prevPg</a></li>";
                                }
                            }

                            // página atual
                            echo "<li class='page-item'><a class='page-link current-pg'>". $data['currentPg'] ."</a></li>";

                            // paginás posteriores
                            for($nextPg = ($data['currentPg'] + 1); $nextPg <= ($data['currentPg'] + $maxLinks); $nextPg++){
                                if($nextPg <= $data['qntPg']){
                                    echo "<li class='page-item'><a class='page-link' onclick='listUsers($nextPg, $date)'>$nextPg</a></li>";
                                }
                            }

                            // última página
                            echo "<li class='page-item'><a class='page-link' onclick='listUsers(". $data['qntPg'] .", $date)'>Última</a></li>";

                            ?>

                        </ul>
                    </nav>
                <?php } ?>
            </td>
        </tr>
    </tbody>
</table> 