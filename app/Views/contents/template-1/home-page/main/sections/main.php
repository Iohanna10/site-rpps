<?php require("config/content-config.php"); ?>
<main>
    <section class="main-content">
        <div class="background max-width-container">
            <div class="gray">
                <!-- portal do segurado -->
                <div class="insured-portal">
                    <div>
                        <span class="material-symbols-outlined icon">policy</span>
                        <h3>PORTAL DO SEGURADO</h3>
                    </div>

                    <form action="#" method="post">
                        <div class="access">
                            <div class="input">
                                <label for="identity">Beneficiário / Instituto<span class="err-login"></span></label>
                                <input type="text" id="identity" name="identity" placeholder="Usuário/CPF ou CNPJ">
                            </div>
                            <div class="input">
                                <label for="password">Senha<span class="err-login"></span><div class="status view-pass"><i class="fa-regular fa-eye" title="visualizar senha"></i></div></label>
                                <input type="password" id="password" name="password" placeholder="Senha" autocomplete="on">
                                <span class="info"><br></span>
                            </div>
                            <button type="button" id="btnSubmit">Entrar</button>
                        </div>
                    </form>

                    <div>
                        <a href="<?php echo base_url("$url/cadastro")?>">Cadastrar</a>
                        |
                        <a href="<?php echo base_url("$url/recuperar-conta")?>">Esqueceu sua Senha?</a>
                    </div>
                </div>
                    <!-- eventos -->
                <div class="events">    
                    <div class="events-grid">
                        <div>
                            <div>
                                <h3 class="title-calendar">CALENDÁRIO DE EVENTOS</h3>
                            </div>
                            <!-- calendário -->
                            <div class="calendar">
                            </div>
                        </div>
                    </div>   
                </div>     
            </div>
            <div class="color-change">
                <!-- links úteis -->
                <div class="useful-links">
                    <h3>LINKS ÚTEIS</h3>

                    <!-- cartões com os links -->
                    <div class="cards">
                        
                        <div class="card">
                            <a href="<?php if(isset($links['link_calendario_pagamentos'])){ echo $links['link_calendario_pagamentos'];}else {echo '#';} ?>">
                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>
                                <div>
                                    <h3>CALENDÁRIO DE PAGAMENTOS</h3>
                                    <p>Acompanhe a data do seu benefício e a janela de saque.</p>
                                </div>
                                
                                <p class="bold">Acompanhe</p>
                            </a>
                        </div>

                        <div class="card">
                            <a href="#">
                                <span class="material-symbols-outlined">
                                    ecg
                                </span>
                                <div>
                                    <h3>PROVA DE<br>VIDA</h3>
                                    <p>Você já fez sua prova de vida esse ano? Clique aqui e saiba como.</p>
                                </div>
                                <p class="bold">Agende aqui</p>
                            </a>
                        </div>
                        <div class="card">
                            <a href="<?php if(isset($links['link_legislacao_prev'])){echo $links['link_legislacao_prev'];}else {echo '#';} ?>">
                                <span class="material-symbols-outlined">
                                    gavel
                                </span>
                                <div>
                                    <h3>LEGISLAÇÃO PREVIDENCIÁRIA</h3>
                                    <p>Tudo que você precisa saber para exigir seus direitos.</p>
                                </div>                              
                                <p class="bold">Entenda</p>
                            </a>
                        </div>
                        <div class="card">
                            <a href="#">
                                <span class="material-symbols-outlined">
                                    workspace_premium
                                </span>
                                <div>
                                    <h3>EMISSÃO DE CERTIFICADOS</h3>
                                    <p>Valide seu histórico de contribuições e assegure seus direitos previdenciários de forma simples e eficaz.</p>
                                </div>
                                <p class="bold">Consulte aqui</p>
                            </a>
                        </div>
                        <div class="card">
                            <a href="<?php if(isset($links['link_folha_pagamento'])){ echo $links['link_folha_pagamento'];}else {echo '#';}  ?>">
                                <span class="material-symbols-outlined">
                                    receipt_long
                                </span>
                                <div>
                                    <h3>FOLHA DE PAGAMENTO</h3>
                                    <p>Acompanhe a distribuição dos benefícios e garantias previdenciárias com transparência e precisão.</p>
                                </div>                               
                                <p class="bold">Saiba mais</p>
                            </a>
                        </div>
                        <div class="card">
                            <a href="<?php if(isset($links['link_transparencia'])){ echo $links['link_transparencia'];}else {echo '#';} ?>">
                                <span class="material-symbols-outlined">
                                    quick_reference_all
                                </span>
                                <div>
                                    <h3>PORTAL DE TRANSPARÊNCIA</h3>
                                    <p>Acesse dados detalhados sobre receitas, despesas e ações do instituto, garantindo clareza e responsabilidade na administração pública.</p>
                                </div>
                                <p class="bold">Saiba mais</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-modal">
            <div class="container container-modal">
                <div class="modal-events max-width-container" id="modal-events"></div>
            </div>
        </div>
    </section>
</main>

<script src="<?= base_url() ?>assets/js/forms/account/login.js"></script>  <!-- js próprio -->
<script src="<?= base_url() ?>assets/js/calendar/show-events.js"></script>
<script src="<?= base_url() ?>assets/js/forms/form-checks.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/change-month.js"></script>
<script src="<?= base_url("assets/js/forms/clear-all.js") ?>"></script>

