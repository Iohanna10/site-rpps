<head>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/template-1/common/modal-infos.css">
    <?php require('config/content-config.php'); // pegar a url ?>
</head>
<section class="contents">
    <div class="container">
        <div class="actuarial-calculation">
            <div class="about-and-reports">
                <div class="latest-reports">
                    <div class="background"></div>
                    <div class="reports">
                        <div class="header-reports">
                            <h1>Últimos Relatórios</h1>
                        </div>
                        <div class="main-reports">  
                        <?php
                            require('config/content-config.php'); // pegar a url 
                            require_once("functions/month-to-upper.php");

                            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                            date_default_timezone_set('America/Sao_Paulo');

                            if($data['reports'] != null){
                                foreach ($data['reports'] as $num => $report) {

                                // ===================== formatar a data ===================== //

                                    $formatter = new IntlDateFormatter(
                                        'pt_BR',
                                            IntlDateFormatter::LONG,
                                            IntlDateFormatter::NONE,
                                            'America/Sao_Paulo',          
                                            IntlDateFormatter::GREGORIAN
                                    );

                                // =========================================================== //

                                    echo "<div class='report'>";
                                        echo "<div class='link'>";
                                        echo  "<h6><a href='". base_url("$url/uploads/pdfs?pdf="). $report['nome'] . "' target='blank'>". $report['titulo'] ."</a></h6>";
                                        echo "</div>";
                                        echo "<div class='infos'>";
                                            echo "<div class='date'>";
                                                echo "<i class='fa-light fa-clock'></i>";
                                                echo '<span>'. upper($formatter->format(new DateTime($report['data']))) .'</span>';
                                            echo "</div>";
                                            echo '<div class="button-love">';
                                                echo '<a id="post-'. $report['id'] .'" onclick="liked('. $report['id'] .', `relatorios`)" data-type="relatorios">';
                                                    
                                                    if($report['avaliadoBool']){ // verificação para saber se o post foi avaliado 
                                                        echo '<i class="fa-light fa-heart not-rated"></i>';
                                                        echo '<i class="fa-solid fa-heart"></i>';
                                                    } else {
                                                        echo '<i class="fa-light fa-heart"></i>';
                                                        echo '<i class="fa-solid fa-heart not-rated"></i>';
                                                    }

                                                    echo '<span>'. $report['avaliacoes'] .'</span>';
                                                echo '</a>';
                                            echo '</div>';
                                            //comentários
                                                // echo "<div class='coments'>";
                                                //     echo "<a href='". base_url("$url/uploads/pdfs?pdf="). $report['nome'] . "'>";
                                                //         echo "<i class='fa-light fa-comment'></i>";
                                                //     echo "</a>";
                                                // echo "</div>";
                                            // 

                                        echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo '<p>Não há nenhum relatório disponível';
                            }
                        ?>           

                        </div>
                        <?php if($data['numReports'] > 4){ ?>
                            <div class="footer-reports">
                                <p><em><a href="<?php echo base_url("$url/calculo-atuarial/relatorios") ?>">(para cálculos mais antigos, clique aqui)</a></em></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="about">
                    <div class="title">
                        <h1>Sobre o Cálculo Atuarial</h1>
                    </div>
                    <div class="about-content">
                        <div class="evaluation">
                            <h4>Avaliação do Cálculo Atuarial</h4>
                            <p>
                                É o processo pelo qual identificamos os compromissos da entidade e de seus participantes em relação ao que foi prometido em termos de benefícios - e quais os recursos necessários para garanti-los. Para tanto, são montados cenários, onde inúmeras variáveis são envolvidas. Esta, ao longo do tempo, pode se alterar - surgindo aí a necessidade de um acompanhamento contínuo por parte do Atuário.
                            </p>
                        </div>
                        <div class="financial-regimes-used">
                            <h4>Os Regimes Financeiros utilizados no cálculo atuarial do <?php echo strtoupper($url); ?> são:</h4>
                            <?php 
                                if(isset($data['regimes_financeiros'])){
                                    echo '<p>' . $data['regimes_financeiros'] . '</p>';
                                } else {
                                    echo '<p>Regimes ainda não descritos.';
                                }
                            ?>
                        </div>
                        <div class="actuarial-requirement">
                            <h4>Reservas Matemáticas ou Exigível Atuarial</h4>
                            <p>
                                É o valor determinado pelo processo matemático, que equilibra as responsabilidades futuras, num contato, entre a "Entidade" e o "Participante Servidor", ou seja: É a diferença entre os encargos da Entidade e do participante servidor, avaliado pela mesma tábua de mortalidade, taxa de juros e à mesma época. É o resultado da operação: Dividem-se em: - Benefícios Concedidos ; + Benefícios a Conceder - Reserva a Amortizar Benefícios a Conceder.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="plan-balance">
                <h4>Equilíbrio do Plano</h4>
                <p>
                    É quando a Entidade mantém em seus ativos os recursos necessários para a cobertura dos compromissos: - Do lado do Ativo, são discriminados todos os bens e direitos da Entidade (disponível, investimentos, realizável, permanente e outros): - Do lado do Passivo, são indicados o exigível não atuarial (contas a pagar e a receber) e o exigível atuarial (reservas matemáticas) ativo líquido = exigível atuarial Legislação regime próprio LEI nº 9.717, de 27/11/1998 - regras gerais para organização e funcionamento dos RPPS. EC nº 20, de 15/12/1998 - modifica o sistema de previdência social, estabelece normas de transição. PORTARIA MPAS nº 4.882, de 16/12/1998 - implementação do RPPS. PORTARIA MPAS nº 4.992, de 05/02/1999 - parâmetros e diretrizes gerais previstos Lei 9.717. LEI nº 9.796, de 05/05/1999 - compensação financeira entre o RGPS e o RPPS. PORTARIA MPAS nº 2.346, de 10/07/2001 - dispõe sobre a concessão do Certificado de Regularidade Previdênciaria Vinculação ao Regime Próprio: Quem Pode: Servidores com titulares de cargos efetivos Quem não Pode: Servidores ocupantes exclusivamente de cargo em comissão declarado em lei de livre nomeação e exoneração; Empregados públicos; Agentes políticos; Servidores cedidos de outras esferas como ocupantes de cargos em comissão; Aposentados que voltam a ativa no serviço público; Servidores com cargos ou função funções temporárias; Servidores públicos estáveis não ocupantes de cargos efetivos.
                </p>
            </div>

            <div class="retirement-profit">
                <h4>Proventos de Aposentadoria</h4>
                <p>
                    Calculado com base na totalidade da remuneração do servidor - vedada a inclusão de parcelas remuneratória pagas em decorrência de função de confiança, de cargo em comissão ou do local de trabalho.
                </p>
            </div>

            <div class="lists">
                <div class="main-list">
                    <div class="benefit">
                        <h4>Benefícios</h4>
                        <ul>
                            <h6>Quanto ao servidor:</h6>
                            <li>Aponsentadoria por invalidez;</li>
                            <li>Aposentadoria por idade;</li>
                            <li>Aposentadoria por tempo de contribuição;</li>
                            <li>Auxílio doença;</li>
                            <li>Aposentadoria compulsória;</li>
                            <li>Salário família;</li>
                            <li>Salário Maternidade.</li>
                        </ul>
                        <ul>
                            <h6>Quanto ao dependente:</h6>
                            <li>Pensão por morte;</li>
                            <li>Auxílio reclusão.</li>
                        </ul>
                    </div>
                    <div class="costing">
                        <h4>Custeio</h4>
                        <ul>
                            <h6>Contribuição:</h6>
                            <li>Ente público;</li>
                            <li>Ativos;</li>
                            <li>Inativos;</li>
                            <li>Pensionistas.</li>
                        </ul>
                        <ul>
                            <h6>Administrativo:</h6>
                            <li>Não poderá exceder a 2% da totalidade da folha de salários dos servidores.</li>
                        </ul>
                        <ul>
                            <h6>Limite de contribuição do ente público:</h6>
                            <li>Não poderá exceder o dobro da contribuição do segurado.</li>
                        </ul>
                    </div>
                    <div class="actuarial-balance">
                        <h4>Equilíbrio Atuarial</h4>
                        <ul>
                            <h6>Premissas:</h6>
                            <li>Cadastro bem estruturado;</li>
                            <li>Escolha de hipóteses Atuariais adequadas;</li>
                            <li>Obediência às hipóteses Atuariais;</li>
                            <li>Obtenção da melhor rentabilidade;</li>
                            <li>Repasse integral das contribuições;</li>
                            <li>Buscar a compensação financeira prevista no Cálculo Atuarial;</li>
                            <li>prevista no Cálculo Atuarial;</li>
                        </ul>
                    </div>
                    <div class="register">
                        <h4>Cadastro</h4>
                        <ul>
                            <h6>Dados críticos:</h6>
                            <li>Tempo de Serviço anterior;</li>
                            <li>Composição da remuneração;</li>
                            <li>Tempo no cargo;</li>
                            <li>Serviços Especiais;</li>
                            <li>Dependentes.</li>
                        </ul>
                    </div>
                </div>
                <div class="actuarial-assumptions">
                    <div class="hypotheses">
                        <h4>Hipóteses</h4>
                        <ul>
                            <h6>Variáveis envolvidas numa avaliação (hipóteses atuariais):</h6>
                            <li>Mortalidade;</li>
                            <li>Incidência de Invalidez;</li>
                            <li>Estimativa de rotatividade;</li>
                            <li>Crescimento real de salários;</li>
                            <li>Reestruturação dos quadros de cargos e salários;</li>
                            <li>Política econômica do país;</li>
                            <li>Taxa de juros;</li>
                            <li>Previdência Social.</li>
                        </ul>
                    </div>
                    <div class="institute-hypotheses">
                        <h4>Algumas hipóteses adotadas para o cálculo atuarial do <?php echo strtoupper($url); ?>:</h4>
                        <div id="hypotheses">
                            <?php 
                                if(isset($data['calc_atuarial'])){
                                    echo $data['calc_atuarial'];
                                } else {
                                    echo '<p>Hipóteses ainda não descritas.';
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="regimes">
                <div class="financial-regimes">
                    <h4>Regimes Financeiros</h4>
                    <p>
                        São modelos orçamentários operacionais, recomendáveis conforme a condição do fluxo de acumulação de recursos necessários para o cumprimento de um programa de compromissos. O atuário ao escolher um método de financiamento não está reduzindo ou elevando os custos reais de um plano. Estes dependem dos valores dos benefícios a serem concedidos e das definições das hipóteses atuariais - econômicas e biométricas - tais como:
                    </p>
                    <ul>
                        <li>Mortalidade;</li>
                        <li>Invalidez;</li>
                        <li>Rotatividade;</li>
                        <li>Taxa de juros, etc.</li>
                    </ul>
                    <p>
                        Assim o método de financiamentos determina de que forma irão ingressar as contribuições para o plano e como estas serão capitalizadas.
                    </p>
                </div>
            
                <div class="capitalization">
                    <h4>Regime Financeiro de Capitalização</h4>
                    <p>
                        Utilizado para financiar aposentadorias. Neste regime as contribuições pagas são suficientes para manter o compromisso total do plano de benefícios:
                    </p>
                    <ul>
                        <li>Crédito Unitário;</li>
                        <li>Crédito Unitário Projetado;</li>
                        <li>Entrada a Idade Normal;</li>
                        <li>Capitalização Ortodoxa (Prêmio Nivelado Individual);</li>
                        <li>Agregado;</li>
                        <li>Financiamento Inicial.</li>
                    </ul>
                </div>
            
                <div class="distribution-of-cover-capital">
                    <h4>Regime Financeiro de Repartição de Capitais de Cobertura</h4>
                    <p>
                        Utilizado para financiar as Pensões. Neste regime as contribuições arrecadas no exercício serão suficientes para cobrir todos os gastos com os benefícios no mesmo exercício.
                    </p>
                </div>
            
                <div class="simple-distribution">
                    <h4>Regime Financeiro de Repartição Simples</h4>
                    <p>
                        Utilizado para financiar auxílios. Neste regime as contribuições arrecadas no período correspondem às despesas geradas com os benefícios.
                    </p>
                </div>
            </div>
        
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
