<div class="bg-toggle-menu"></div>
<header id="home">
    <!--------------- pegar a url --------------->
    <?php
    

    use App\Controllers\Session;

    require("config/content-config.php"); ?>
    <!------------------------------------------->

    <!--------------- funções --------------->
     <?php require_once("functions/replece-hyphen.php"); ?>
    <!------------------------------------------->

    <div class="container">
        <div class="bg-sup" style="height: calc(3.6rem + 2px);"></div>
        <div class="bg-inf" style="height: calc(4.8rem + 2px);"></div>
        <div class="wrapper">
            <div></div>
        </div>
        <div class="menu-section">
            <div class="logo">
                <?php 
                if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ ?>
                    <img src="<?= base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") ?>" alt="Foto de perfil">
                <?php } else { ?>
                        <img src="<?= base_url("assets/img/sem-imagem.png") ?>" alt="Foto de perfil">
                <?php }; ?>
            </div>

            <!--  menu de navegação superior  -->
            <nav class="nav-superior">
                <ul>
                    <li><a href="<?php echo $links['link_transparencia'] ?>">Transparência</a></li>  
                    <li><a href="<?php echo $links['link_ouvidoria'] ?>">Ouvidoria</a></li>  
                    <li><a href="<?php echo $links['link_diario_oficial'] ?>">Diário Oficial</a></li>  
                    <li><a href="<?php echo $links['link_portal_gov'] ?>">Portal do governo do Estado</a></li>  
                    <li><a href="https://cadprev.previdencia.gov.br/Cadprev/faces/pages/index.xhtml">Secretaria de Previdência</a></li>  
                    <li><a class="increase-font">A+</a></li> 
                    <li><a class="decrease-font">A-</a></li> 
                    <li class="invisible-itens">
                        <a>
                            <div class="btn account">
                                <span class="material-symbols-outlined" style="font-size: 2.4rem;">person</span>
                                <span style="line-height: normal;">conta</span>
                            </div>
                        </a>
                        <div class="min-profile">
                            <div class="caret-up"></div>
                            <div class="container-profile">
                                <?php  if(session()->get('name') != null){?>
                                    <div class="id">
                                        <?php  if(session()->get('type') == 'user'){?>
                                            <div class="img-profile">
                                                <img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/user_profile/") . session()->get('photo') ?>" alt="Foto de perfil">
                                        <?php } 
                                        elseif(session()->get('type') == 'institute'){?>
                                                <div class="img-logo">
                                                    <?php if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ ?>
                                                        <img src="<?= base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") ?>" alt="Foto de perfil">
                                                    <?php } else { ?>
                                                            <img src="<?= base_url("assets/img/sem-imagem.png") ?>" alt="Foto de perfil">
                                                    <?php } ?>
                                                    <?php } else { ?>
                                            <div class="img-profile">
                                                <img src="<?= base_url("assets/img/sem-foto.png") ?>" alt="Foto de perfil">
                                        <?php } ?>
                                        </div>
                                        <div class="name">
                                            <span><?php echo session()->get('name') ?></span>
                                        </div>
                                    </div>

                                    <hr style="background-color: white;">
        
                                    <div class="actions">
                                        <ul>
                                            <?php  if(session()->get('type') == 'user'){?>
                                                <li><a href="<?= base_url("$url/configuracoes-perfil")?>">configurações</a></li> 
                                            <?php } 
                                            elseif(session()->get('type') == 'institute'){?>
                                                <li><a href="<?= base_url("$url/configuracoes-instituto")?>">configurações</a></li>
                                            <?php } ?>
                                            <li><a href="<?= base_url("$url/login-logout")?>">sair</a></li>
                                        </ul>
                                    </div>
                                <?php } else { ?>
    
                                    <div class="actions">
                                        <ul>
                                            <li><a href="<?= base_url("$url/login")?>">Acessar conta</a></li>
                                        </ul>
                                    </div>

                                <?php } ?>
                            </div>
                                   
                        </div>

                    </li>
                    <li class="btn-search invisible-itens">
                        <div class="container-btn">
                            <div class="search">
                                <span class="material-symbols-outlined" style="font-size: 2.4rem;">search</span>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- formulário de pesquisa -->
                <div class="search-form-mobile">
                    <form  method="get" action="<?php echo base_url($url) ?>">
                        <label for="search" id="labelSearch"><i class="fa-solid fa-magnifying-glass"></i><p>Buscar</p></label>
                        <input type="text" name="search" id="search_mb">
                    </form>
                </div>
                <script src="<?= base_url() ?>assets/js/menu/placeholder.js"></script>
            </nav>
            <!-- menu de navegação inferior  -->
            <nav class="nav-inferior">
                <div class="container-menu lateral-menu-off initial-menu">
                        <div class="close-menu">
                            <div>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                    <ul class="secondary-nav">  
                        <?php  if(session()->get('name') != null){?>
                        
                            <div class="id">
                                <?php  if(session()->get('type') == 'user'){?>
                                    <div class="img-profile">
                                        <img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/user_profile/") . session()->get('photo') ?>" alt="Foto de perfil">
                                <?php } 
                                elseif(session()->get('type') == 'institute'){?>
                                        <div class="img-logo">
                                        <?php if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ ?>
                                            <img src="<?= base_url("dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png") ?>" alt="Foto de perfil">
                                        <?php } else { ?>
                                            <img src="<?= base_url("assets/img/sem-imagem.png") ?>" alt="Foto de perfil">   
                                        <?php }
                                } else { ?>
                                    <div class="img-profile">
                                        <img src="<?= base_url("assets/img/sem-foto.png") ?>" alt="Foto de perfil">
                                <?php } ?>
                                </div>
                                <div class="name">
                                    <span><?php echo session()->get('name') ?></span>
                                </div>
                            </div>
                      
        
                            <div class="actions">
                                <ul>
                                    <?php  if(session()->get('type') == 'user'){?>
                                        <li>
                                            <div class="btn">
                                                <a href="<?= base_url("$url/configuracoes-perfil")?>">
                                                    <span class="material-symbols-outlined" style="font-size: 2.4rem;">person</span>
                                                    <span>conta</span>
                                                </a>
                                            </div>
                                        </li>
                                    <?php } 
                                    elseif(session()->get('type') == 'institute'){?>
                                         <li>
                                             <div class="btn">
                                                <a href="<?= base_url("$url/configuracoes-instituto")?>">
                                                    <span class="material-symbols-outlined" style="font-size: 2.4rem;">person</span>
                                                    <span>conta</span>
                                                </a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <div class="btn">
                                            <a href="<?= base_url("$url/login-logout")?>">
                                                <span>sair</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        <?php } else { ?>

                            <li>
                                <div class="btn">
                                    <a href="<?= base_url("$url/login")?>">
                                        <span class="material-symbols-outlined" style="font-size: 2.4rem;">person</span>
                                        <span>acessar conta</span>
                                    </a>
                                </div>
                            </li>

                        <?php } ?>
                        <div>
                            <li><a class="increase-font">A+</a></li> 
                            <li><a class="decrease-font">A-</a></li> 
                        </div>
                    </ul>
                    <ul class="main-nav">
                        <li class="no-icon">
                            <a href="<?php echo base_url("/$url") ?>">Início</a>
                        </li>
                        <li>
                        <div class="content-links-menu">
                            <a><?php echo ucwords($url) ?></a><div class="icon"  onclick="toggle(0)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                        </div>
                        <div class="container-sub-menu">
                            <ul class="sub-menu" onmouseover="widthSubMenu(this)">
                                <li class="main-item"><a href="<?php echo base_url("/$url/historico")?>">Histórico</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/principios")?>">Princípios</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/codigo-de-etica")?>">Código de Ética</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/equipe")?>">Equipe</a></li>
                                <li class="main-item" onmouseover="repositionSM(this)">
                                    <div class="content-links-menu">
                                        <a href="<?php echo base_url("/$url/concursos")?>">Concurso</a><div class="icon" onclick="toggleSub(0)"><span class="toggle-2"><i class="fa-light fa-chevron-right regular-menu"></i></span></div>
                                    </div>
                                    <ul class="sub-menu-2">
                                        <li><a href="<?php echo base_url("/$url/concursos/processo-seletivo")?>">Processo Seletivo</a></li>
                                    </ul>
                                </li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/educacao-previdenciaria")?>">Educação Previdenciária</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/plano-de-acao")?>">Plano de Ação</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/gestao-e-controle-interno")?>">Gestão e Controle Interno</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/seguranca-da-informacao")?>">Segurança da Informação</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/manual-de-procedimentos-de-beneficio")?>">Manual de Procedimentos de Benefícios</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/manual-de-arrecadacao")?>">Manual de Arrecadação</a></li>
                                <li class="main-item"><a href="<?php echo base_url("/$url/manual-de-procedimentos")?>">Manual de Procedimentos: Gestão de Investimentos</a></li>
                            </ul>
                        </div>

                        </li>
                        <li>
                            <div class="content-links-menu">
                                <a>Legislação</a><div class="icon" onclick="toggle(1)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                            </div>
                            <div class="container-sub-menu">
                                <ul class="sub-menu" onmouseover="widthSubMenu(this)">
                                    <li class="main-item"><a href="<?php echo base_url("/$url/constituicao-federal")?>">Constituição Federal</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/instrucoes-normativas-mps")?>">Instruções Normativas MPS</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/leis-federais")?>">Leis Federais</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/orientacoes-mps")?>">Orientações MPS</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/portarias-mps")?>">Portarias MPS</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/resolucoes-cmn")?>">Resoluções CMN</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/leis-municipais")?>">Leis Municipais</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/portarias")?>">Portarias <?php echo ucwords($url) ?></a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="content-links-menu">
                                <a>Prestação de contas</a><div class="icon" onclick="toggle(2)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                            </div>
                            <div class="container-sub-menu">
                                <ul class="sub-menu" onmouseover="widthSubMenu(this)">
                                    <li class="main-item"><a href="<?php echo base_url("/$url/audiencia-publica")?>">Audiencia Pública</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/balancete-anual")?>">Balancete Anual</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/balancete-mensal")?>">Balancete Mensal</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/crps")?>">CRP - Certificado de Regularidade Previdenciária</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/calculo-atuarial")?>">Cálculo Atuarial</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/demonstrativos-financeiro")?>">Demonstrativos Financeiro</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/demonstrativos-das-aplicacoes-e-investimentos-de-recursos")?>">DAIR - Demonstrativos das Aplicações e Investimentos de Recursos</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/demonstrativo-de-informacoes-previdenciarios-e-repasses")?>">DIPR - Demonstrativo de informações Previdenciárias e Repasses</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/parcelamentos")?>">Parcelamentos</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/politica-de-investimentos")?>">Política de Investimentos</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/acordaos-de-tce")?>">Acórdãos de TCE</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/certidoes-negativas")?>">Certidões Negativas</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/cronogramas-de-pagamentos")?>">Cronogramas de Pagamentos</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/contratos-e-licitacoes")?>">Contratos e Licitações</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="content-links-menu">
                                <a>Conselhos</a><div class="icon" onclick="toggle(3)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                            </div>
                            <div class="container-sub-menu">
                                <ul class="sub-menu">
                                    <li class="main-item" onmouseover="repositionSM(this)">
                                        <div class="content-links-menu">
                                            <a>Comitê de Investimento</a><div class="icon" onclick="toggleSub(1)"><span class="toggle-2"><i class="fa-light fa-chevron-right regular-menu"></i></span></div>
                                        </div>
                                   
                                            <ul class="sub-menu-2">
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/membros")?>">Membros</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/calendario-de-reunioes")?>">Calendários de Reuniões - Comitê de Investimentos</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/atas-de-reunioes")?>">Atas de Reuniões</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/resolucoes")?>">Resoluções</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/regime-interno")?>">Regimento Interno</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/composicao-da-carteira-e-investimentos")?>">Composição da Carteira e Investimentos</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/politica-de-investimento")?>">Política de Investimentos</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/credenciamento-das-instituicoes-financeiras")?>">Credenciamento das Instituições Financeiras</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/relatorio-mensal-de-investimentos")?>">Relatório Mensal de Investimentos</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/relatorio-anual-de-investimentos")?>">Relatório Anual de Investimentos</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/aplicacoes-e-resgates")?>">Aplicações e Resgates - APRs</a></li>
                                                <li><a href="<?php echo base_url("/$url/comite-de-investimento/estudo-de-alm")?>">Estudo de ALM</a></li>    
                                            </ul>

                                    </li>
                                    <li class="main-item" onmouseover="repositionSM(this)">
                                        <div class="content-links-menu">
                                            <a>Fiscal</a><div class="icon" onclick="toggleSub(2)"><span class="toggle-2"><i class="fa-light fa-chevron-right regular-menu"></i></span></div>
                                        </div>
                                            <ul class="sub-menu-2">
                                                <li><a href="<?php echo base_url("/$url/fiscal/membros")?>">Membros</a></li>
                                                <li><a href="<?php echo base_url("/$url/fiscal/calendario-de-reuniao")?>">Calendários de Reuniões</a></li>
                                                <li><a href="<?php echo base_url("/$url/fiscal/atas-das-reunioes")?>">Atas das Reuniões</a></li>
                                                <li><a href="<?php echo base_url("/$url/fiscal/resolucoes")?>">Resoluções</a></li>
                                                <li><a href="<?php echo base_url("/$url/fiscal/regime-interno")?>">Regimento Interno</a></li>
                                            </ul>
                                    </li>
                                    <li class="main-item" onmouseover="repositionSM(this)">
                                        <div class="content-links-menu">
                                            <a>Deliberativo</a><div class="icon" onclick="toggleSub(3)"><span class="toggle-2"><i class="fa-light fa-chevron-right regular-menu"></i></span></div>
                                        </div>
                                            <ul class="sub-menu-2">
                                                <li><a href="<?php echo base_url("/$url/deliberativo/membros")?>">Membros</a></li>
                                                <li><a href="<?php echo base_url("/$url/deliberativo/calendario-de-reuniao")?>">Calendários de Reuniões</a></li>
                                                <li><a href="<?php echo base_url("/$url/deliberativo/atas-das-reunioes")?>">Atas das Reuniões</a></li>
                                                <li><a href="<?php echo base_url("/$url/deliberativo/resolucoes")?>">Resoluções</a></li>
                                                <li><a href="<?php echo base_url("/$url/deliberativo/regime-interno")?>">Regimento Interno</a></li>
                                            </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="content-links-menu">
                                <a href="<?php echo base_url("/$url/publicacoes")?>">Publicações</a><div class="icon" onclick="toggle(4)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                            </div>
                            <div class="container-sub-menu">
                                <ul class="sub-menu" onmouseover="widthSubMenu(this)">
                                    <li class="main-item"><a href="<?php echo base_url("/$url/publicacoes/noticias")?>">Notícias</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/publicacoes/informativo-semestral")?>">Informativo Semestral</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/publicacoes/galeria-de-fotos")?>">Galeria de Fotos</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/publicacoes/pesquisa-de-satisfacao")?>">Pesquisa de Satisfação</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/publicacoes/resultado-da-pesquisa")?>">Resultado da Pesquisa</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="content-links-menu">
                                <a>Segurados</a><div class="icon" onclick="toggle(5)"><span class="toggle"><i class="fa-solid fa-caret-down regular-menu"></i></span></div>
                            </div>
                            <div class="container-sub-menu">
                                <ul class="sub-menu" onmouseover="widthSubMenu(this)">
                                    <li class="main-item"><a href="<?php echo base_url("/$url/segurados/aniversario")?>">Aniversários</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/segurados/solenidade")?>">Solenidade</a></li>
                                    <li class="main-item"><a href="https://meurpps.com.br/meurpps/login_requerimento/">Meu RPPS</a></li>
                                    <li class="main-item"><a href="<?php echo base_url("/$url/segurados/cartilha-previdenciaria")?>">Cartilha Previdenciária</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="no-icon">
                            <a href="<?php echo base_url("/$url/fale-conosco")?>">Fale Conosco</a>
                        </li>
                    </ul>
                    <ul class="footer-nav-list">
                        <li><a href="<?php echo $links['link_transparencia'] ?>">Transparência</a></li>
                        <span>|</span> 
                        <li><a href="<?php echo $links['link_ouvidoria'] ?>">Ouvidoria</a></li>  
                        <span>|</span>
                        <li><a href="<?php echo $links['link_diario_oficial'] ?>">Diário Oficial</a></li>  
                        <span>|</span>
                        <li><a href="<?php echo $links['link_portal_gov'] ?>">Portal do governo do Estado</a></li> 
                        <span>|</span> 
                        <li><a href="https://cadprev.previdencia.gov.br/Cadprev/faces/pages/index.xhtml">Secretaria de Previdência</a></li>  
                    </ul>
                </div> 
                <!-- menu hamburguer  -->   
                <div class="menu-hamburger">
                    <div class="menu-lines">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </div>
            </nav>
        </div>

        <!-- caixa de pesquisa -->
        <div class="search-area">
            <form id="search-form" name="search-form" method="get" action="<?php echo base_url($url) ?>">
                <label for="search" id="labelSearch"><i class="fa-solid fa-magnifying-glass"></i></label>
                <input type="text" name="search" id="search" placeholder="Digite sua pesquisa...">
                <div class="close-search">
                    <i class="fa-regular fa-xmark"></i>
                </div>
            </form>
        </div>
        
    </div>
    <script src="<?= base_url() ?>assets/js/menu/toggle-menu.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/lateral-menu.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/toggle-search.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/toggle-account.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/resize.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/scroll-top.js"></script>
    <script src="<?= base_url() ?>assets/js/menu/font-size.js"></script>
</header>
<body>