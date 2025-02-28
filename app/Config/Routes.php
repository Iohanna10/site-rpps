<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// 

// ======================= url dinâmica ======================= //
    include_once("config/content-config.php");
// ======================= /url dinâmica ====================== //

// =================== testes e informações =================== // 

// infos php
    $routes->get('/info', 'Info::infos');
    $routes->get("$url/test-template", 'InnerPages\Test::testTemplate');
//

// testes
    // $routes->get("/webprev_tela_site_construcao_bg_1", 'test\Home::test1');
    // $routes->get("/webprev_tela_site_construcao_bg_2", 'test\Home::test2');
    // $routes->get("/webprev_tela_site_construcao_bg_3", 'test\Home::test3');
// 

// ================== /testes e informações =================== // 

// cron job
    $routes->get("/delete_unused_files", 'Crons::deleteUnusedFiles');
// 

//  Mails
    $routes->post("/ajax/ajax-user/contact", 'Mails\SendMails::contact');
// 

// ====================================== direcionar para pegar dados da sessão ======================================= //

    $routes->post("/$url/login-institute", 'Session::loginInstitute');
    $routes->post("/$url/login-beneficiary", 'Session::loginBeneficiary');
    $routes->post("/login-beneficiary", 'Session::loginBeneficiary');
    $routes->get("/$url/login-logout", 'Session::logout');
    $routes->post("ajax/verify-session", 'Session::ajaxIsLogged');

// ====================================== /direcionar para pegar dados da sessão ===================================== //

// ====================================== conta ======================================= //

    $routes->get("/$url/login", 'Account::index');
    $routes->get("/$url/cadastro", 'Account::userRegister');
    $routes->get("/$url/recuperar-conta", 'Account::recoverAccount');
    $routes->get("/$url/alterar-senha", 'Account::changePassword');
    $routes->get("/$url/confirmar-email", 'Account::confirmEmail'); 
    $routes->post("/$url/validar-email", 'Account::validateEmail'); 
    $routes->get("/instituto-sem-cadastro", 'Account::instituteWithoutRegistration');


// ====================================== /conta ===================================== //

// =========================================== direcionar para home ============================================ //

    $routes->get('/', 'Home::index');
    $routes->get("/$url", 'Home::index');

    // calendário de eventos home //
    $routes->post("/$url/calendar", 'Home::calendar');
    $routes->get("/$url/calendar/events", 'Home::calendarModalEvents'); // lista de eventos 
    $routes->get("/$url/calendar/events-infos", 'Home::calendarModalInfos'); // lista de eventos 

// =========================================== /direcionar para home ============================================ //
 
// ====================================== direcionar para o sobre instituto ====================================== //

    $routes->get("/$url/historico", 'InnerPages\Institute::historico'); // histórico //
    $routes->get("/$url/principios", 'InnerPages\Institute::principios'); // princípios //
    $routes->get("/$url/codigo-de-etica", 'InnerPages\Institute::codigoDeEtica'); // código de ética //
    $routes->get("/$url/equipe", 'InnerPages\Institute::equipe'); // equipe //
    $routes->get("/$url/concursos", 'InnerPages\Institute::concursos'); // concursos //
        // === concursos sub === // 
            $routes->get("/$url/concursos/processo-seletivo", 'InnerPages\Institute::processoSeletivo'); // processo seletivo //
        // === /concursos sub === // 
    $routes->get("/$url/educacao-previdenciaria", 'InnerPages\Institute::educacaoPrevidenciaria'); // educação previdenciaria //
    $routes->get("/$url/plano-de-acao", 'InnerPages\Institute::planoDeAcao'); // plano de ação // 
    $routes->get("/$url/gestao-e-controle-interno", 'InnerPages\Institute::gestaoEControleInterno'); // gestão e controle da informação //
    $routes->get("/$url/seguranca-da-informacao", 'InnerPages\Institute::segurancaDaInformacao'); // segurança da informação //
    $routes->get("/$url/manual-de-procedimentos-de-beneficio", 'InnerPages\Institute::manualDeProcedimentosDeBeneficio'); // manual de procedimentos de beneficio //
    $routes->get("/$url/manual-de-arrecadacao", 'InnerPages\Institute::manualDeArrecadacao'); // manual de arrecadação //
    $routes->get("/$url/manual-de-procedimentos", 'InnerPages\Institute::manualDeProcedimentos'); // manual de arrecadação //

// ===================================== /direcionar para o sobre instituto ====================================== //
 
// ========================================= direcionar para a lesgilação ======================================== //

    $routes->get("/$url/constituicao-federal", 'InnerPages\Legislation::constituicaoFederal'); // constituicao federal //
    $routes->get("/$url/instrucoes-normativas-mps", 'InnerPages\Legislation::instrucoesNormativasMps'); // instruções normativas MPS //
    $routes->get("/$url/leis-federais", 'InnerPages\Legislation::leisFederais'); // leis federais //
    $routes->get("/$url/orientacoes-mps", 'InnerPages\Legislation::orientacoesMps'); // orientações MPS //
    $routes->get("/$url/portarias-mps", 'InnerPages\Legislation::portariasMps'); // portarias MPS //
    $routes->get("/$url/resolucoes-cmn", 'InnerPages\Legislation::resolucoesCmn'); // resoluções CMN // 
    $routes->get("/$url/leis-municipais", 'InnerPages\Legislation::leisMunicipais'); // leis municipais // 
    $routes->get("/$url/portarias", 'InnerPages\Legislation::portarias'); // portarias // 

    // ======================================== /direcionar para a lesgilação ======================================== //

    // ==================================== direcionar para a prestação de contas ==================================== //

    $routes->get("/$url/audiencia-publica", 'InnerPages\Accountability::audienciaPublica'); // Audiencia Públicaal //
    $routes->get("/$url/balancete-anual", 'InnerPages\Accountability::balanceteAnual'); // Balancete Anual //
    $routes->get("/$url/balancete-mensal", 'InnerPages\Accountability::balanceteMensal'); // Balancete Mensal //
    $routes->get("/$url/crps", 'InnerPages\Accountability::crp'); // CRP - Certificado de Regularidade Previdenciária //
    $routes->get("/$url/crps/certificados", 'InnerPages\Accountability::allCrps'); // CRP - Certificado de Regularidade Previdenciária //
    $routes->get("/$url/calculo-atuarial", 'InnerPages\Accountability::calculoAtuarial'); // Cálculo Atuarial // 
    $routes->get("/$url/calculo-atuarial/relatorios", 'InnerPages\Accountability::relatoriosCalc'); // Relatóros Cálculo Atuarial // 
    $routes->get("/$url/demonstrativos-financeiro", 'InnerPages\Accountability::demonstrativosFinanceiro'); // Demonstrativos Financeiro // 
    $routes->get("/$url/demonstrativos-das-aplicacoes-e-investimentos-de-recursos", 'InnerPages\Accountability::dair'); // DAIR - Demonstrativos das Aplicações e Investimentos de Recursos // 
    $routes->get("/$url/demonstrativo-de-informacoes-previdenciarios-e-repasses", 'InnerPages\Accountability::dipr'); // DIPR - Demonstrativo de informações Previdenciários e Repasses //
    $routes->get("/$url/parcelamentos", 'InnerPages\Accountability::parcelamentos'); // parcelamentos //
    $routes->get("/$url/politica-de-investimentos", 'InnerPages\Accountability::politicaInvestimentos'); // Política de Investimentos //
    $routes->get("/$url/acordaos-de-tce", 'InnerPages\Accountability::acordaosTce'); // Acórdãos de TCE // 
    $routes->get("/$url/certidoes-negativas", 'InnerPages\Accountability::certidoesNegativas'); // Certidões Negativas // 
    $routes->get("/$url/cronogramas-de-pagamentos", 'InnerPages\Accountability::cronogramasPagamentos'); // Cronogramas de Pagamentos // 
    $routes->get("/$url/contratos-e-licitacoes", 'InnerPages\Accountability::contratosLicitacoes'); // Contratos e Licitações //

    // ==================================== /direcionar para a prestação de contas ==================================== //

    // ====================================== direcionar para conselhos ====================================== //

    $routes->get("/$url/comite-de-investimento", 'InnerPages\Advices\InvestmentCommittee::membros'); // comitê de investimentos //
        // === comitê de investimentos sub === // 
            $routes->get("/$url/comite-de-investimento/membros", 'InnerPages\Advices\InvestmentCommittee::membros'); // membros //
            $routes->get("/$url/comite-de-investimento/calendario-de-reunioes", 'InnerPages\Advices\InvestmentCommittee::calendarioComiteInvestimentos'); // calendário //
            $routes->get("/$url/comite-de-investimento/atas-de-reunioes", 'InnerPages\Advices\InvestmentCommittee::atasReunioes'); // atas //
            $routes->get("/$url/comite-de-investimento/resolucoes", 'InnerPages\Advices\InvestmentCommittee::resolucoes'); // resoluções //
            $routes->get("/$url/comite-de-investimento/regime-interno", 'InnerPages\Advices\InvestmentCommittee::regimeInterno'); // regime interno //
            $routes->get("/$url/comite-de-investimento/composicao-da-carteira-e-investimentos", 'InnerPages\Advices\InvestmentCommittee::composicaoCarteiraInvestimentos'); // composição da carteira e investimento //
            $routes->get("/$url/comite-de-investimento/politica-de-investimento", 'InnerPages\Advices\InvestmentCommittee::politicaInvestimento'); // política de investimento //
            $routes->get("/$url/comite-de-investimento/credenciamento-das-instituicoes-financeiras", 'InnerPages\Advices\InvestmentCommittee::credenciamentoInstituicoes'); // credenciamento // 
            $routes->get("/$url/comite-de-investimento/relatorio-mensal-de-investimentos", 'InnerPages\Advices\InvestmentCommittee::relatorioMensalInvestimentos'); // relatório mensal //
            $routes->get("/$url/comite-de-investimento/relatorio-anual-de-investimentos", 'InnerPages\Advices\InvestmentCommittee::relatorioAnualInvestimentos'); // relatório anual //
            $routes->get("/$url/comite-de-investimento/aplicacoes-e-resgates", 'InnerPages\Advices\InvestmentCommittee::aplicacoesResgates'); // aplicações e resgates //
            $routes->get("/$url/comite-de-investimento/estudo-de-alm", 'InnerPages\Advices\InvestmentCommittee::estudoAlm'); // estudo de ALM //
        // === /comitê de investimentos sub === // 

    $routes->get("/$url/fiscal", 'InnerPages\Advices\Fiscal::membros'); // fiscal //
        // === fiscal sub === // 
            $routes->get("/$url/fiscal/membros", 'InnerPages\Advices\Fiscal::membros'); // membros //
            $routes->get("/$url/fiscal/calendario-de-reuniao", 'InnerPages\Advices\Fiscal::calendarioReunioes'); // calendário de reuniões //
            $routes->get("/$url/fiscal/atas-das-reunioes", 'InnerPages\Advices\Fiscal::atasReunioes'); // atas //
            $routes->get("/$url/fiscal/resolucoes", 'InnerPages\Advices\Fiscal::resolucoes'); // resoluções //
            $routes->get("/$url/fiscal/regime-interno", 'InnerPages\Advices\Fiscal::regimeInterno'); // regime interno //
        // === /fiscal sub === // 

    $routes->get("/$url/deliberativo", 'InnerPages\Advices\Deliberative::membros'); // deliberativo //
        // === deliberativo sub === // 
            $routes->get("/$url/deliberativo/membros", 'InnerPages\Advices\Deliberative::membros'); // membros //
            $routes->get("/$url/deliberativo/calendario-de-reuniao", 'InnerPages\Advices\Deliberative::calendarioReunioes'); // calendário de reuniões //
            $routes->get("/$url/deliberativo/atas-das-reunioes", 'InnerPages\Advices\Deliberative::atasReunioes'); // atas //
            $routes->get("/$url/deliberativo/resolucoes", 'InnerPages\Advices\Deliberative::resolucoes'); // resoluções //
            $routes->get("/$url/deliberativo/regime-interno", 'InnerPages\Advices\Deliberative::regimeInterno'); // regime interno //
        // === /deliberativo sub === // 

// ===================================== /direcionar para conselhos ====================================== //

// ==================================== direcionar para publicações ==================================== //
    $routes->get("/$url/publicacoes/noticias", 'InnerPages\Publications::noticias'); // notícias //
    $routes->get("/$url/publicacoes", 'InnerPages\Publications::noticias'); // publicações // 
    $routes->get("/$url/publicacoes/informativo-semestral", 'InnerPages\Publications::informativoSemestral'); // informativo semestral //
    $routes->get("/$url/publicacoes/galeria-de-fotos", 'InnerPages\Publications::galeriaFotos'); // galeria de fotos //
    $routes->get("/$url/publicacoes/galerias/dados-lista", 'Pagination::galleries'); // lista de galerias 
    $routes->get("/$url/publicacoes/pesquisa-de-satisfacao", 'InnerPages\Publications::pesquisaSatisfacao'); // pesquisa de satisfação //
    $routes->get("/$url/publicacoes/resultado-da-pesquisa", 'InnerPages\Publications::resultadoPesquisa'); // resultado pesquisa // 

// ==================================== /direcionar para publicações ==================================== //

// ==================================== direcionar para segurados ==================================== //

    $routes->get("/$url/segurados", 'InnerPages\Policyholders::segurados'); // segurados // 
    $routes->get("/$url/segurados/aniversario", 'InnerPages\Policyholders::aniversario'); // aniversário //
    $routes->get("/$url/segurados/aniversario/lista", 'InnerPages\Policyholders::listaAniversario'); // aniversário //
    $routes->get("/$url/segurados/aniversario/dados-lista", 'Pagination::birthdays'); // aniversário //
    $routes->get("/$url/segurados/solenidade", 'InnerPages\Policyholders::solenidade'); // solenidade //
    $routes->get("/$url/segurados/cartilha-previdenciaria", 'InnerPages\Policyholders::cartilhaPrevidenciaria'); // cartilha previdenciária //

// ==================================== /direcionar para segurados ==================================== //

// ==================================== direcionar para fale conosco ==================================== //
    
    $routes->get("/$url/fale-conosco", 'InnerPages\ContactUs::contatar'); // segurados // 

// ==================================== /direcionar para segurados ==================================== //

// ============================================ postagens ============================================= //
    $routes->get("/$url/historico/post", 'InnerPages\Post::postagens');
// ============================================ /postagens ============================================= //

// Uploads
    $routes->get("/$url/uploads/pdfs", 'Pdfs::index');
// 

// Pg inicial de configurações do instituto
    $routes->get("/$url/configuracoes-instituto", "ConfigInfos\Institute::index");
//

// comentários/avaliações do instituto
    $routes->get("/$url/configuracoes-instituto/avaliacoes", "ConfigInfos\Institute::ratings");
//

// Registrations
    $routes->get("/$url/cadastro/membros", 'Registrations::members');
    $routes->get("/$url/cadastro/publicacoes", 'Registrations::posts');
    $routes->get("/$url/cadastro/galerias", 'Registrations::gallery'); // galeria de fotos //
    $routes->get("/$url/cadastro/eventos", 'Registrations::events');
    $routes->get("/$url/cadastro/eventos/forms", 'Registrations::eventsForms');
    $routes->get("/$url/cadastro/calculo-atuarial", 'Registrations::actuarialCalc');
    $routes->get("/$url/cadastro/crps", 'Registrations::crps');
// 

// delete and edit infos
    // user
    $routes->get("/$url/configuracoes-perfil", 'ConfigInfos\User::userConfig'); // informações

    // institute
    $routes->get("/$url/configuracoes-instituto/getPage", 'ConfigInfos\Institute::getPage'); // informações
    $routes->get("/$url/configuracoes-instituto/informacoes", 'ConfigInfos\Institute::instituteConfig'); // informações
    $routes->get("/$url/configuracoes-instituto/personalizar", 'ConfigInfos\Institute::instituteCustomization'); // personalização
    $routes->get("/$url/configuracoes-instituto/preview", 'Home::index'); // pré-visualização do site
    $routes->get("/$url/configuracoes-instituto/logos/dados-lista", 'Pagination::logos'); // pré-visualização do site
    $routes->get("/$url/configuracoes-instituto/temas/user/dados-lista", 'Pagination::userThemes'); // lista de temas do usuário
    $routes->get("/$url/configuracoes-instituto/temas/preset/dados-lista", 'Pagination::presetThemes'); // lista de temas predefinidos
    $routes->get("/$url/cadastro/tema", 'Registrations::theme'); // cadastro tema
    $routes->get("/$url/configuracoes-instituto/tema", 'Editions::theme'); // editar tema

    // team
    $routes->get("/$url/configuracoes-instituto/equipe", 'ConfigInfos\Institute::team'); // editar informações dos membros
    $routes->get("/$url/configuracoes-instituto/equipe/dados-lista", 'Pagination::team'); // lista de membros para editar a ordem
    $routes->get("/$url/edit/membros", 'Editions::team');

    // gallery
    $routes->get("/$url/configuracoes-instituto/galerias", 'ConfigInfos\Institute::gallery'); // excluir e listar galeria
    $routes->get("/$url/configuracoes-instituto/galeria", 'Editions::gallery'); // galeria de fotos edição //
    $routes->get("/$url/configuracoes-instituto/galeria/dados-lista", 'Pagination::gallery'); // lista de galerias 
    $routes->get("/$url/configuracoes-instituto/galeria/medias/dados-lista", 'Pagination::galleryMedias'); // lista de mídias da galeria editar a ordem

    // post
    $routes->get("/$url/configuracoes-instituto/publicacao", 'Editions::posts'); // post edição //
    $routes->get("/$url/configuracoes-instituto/publicacoes", 'ConfigInfos\Institute::posts'); // excluir e listar post
    $routes->get("/$url/configuracoes-instituto/publicacoes/dados-lista", 'Pagination::posts'); // lista de posts 
    $routes->get("/$url/configuracoes-instituto/publicacoes/medias/dados-lista", 'Pagination::postsMedias'); // lista de mídias da galeria editar a ordem
    $routes->get("/$url/configuracoes-instituto/publicacoes/pdfs/dados-lista", 'Pagination::pdfs'); // pdfs

    // events
    $routes->get("/$url/configuracoes-instituto/eventos", 'ConfigInfos\Institute::events'); // eventos edição //
    $routes->get("/$url/configuracoes-instituto/eventos/dados-lista", 'Pagination::events'); // lista de eventos 
    $routes->get("/$url/configuracoes-instituto/evento", 'Editions::events'); // edição 
    $routes->get("/$url/configuracoes-instituto/eventos/forms", 'Editions::editPageEv');

// 

// Ajax routes

    // instituto -> trocar informações //
    $routes->post("/ajax/ajax-institute/changeInfos", 'Ajax\Institute::changeInfos');
    $routes->post("/ajax/ajax-institute/upNewFiles", 'Ajax\Institute::upNewFiles');
    $routes->post("/ajax/ajax-institute/remove-files", 'Ajax\Institute::removeFiles');
    $routes->post("/ajax/ajax-institute/order", 'Ajax\Institute::updateOrder');
    // instituto -> personalizar
    $routes->post("/ajax/ajax-institute/changeFavicon", 'Ajax\Themes::changeFavicon');
    $routes->post("/ajax/ajax-institute/changeBanner", 'Ajax\Themes::changeBanner');
    $routes->post("/ajax/ajax-institute/customizeInstitute", 'Ajax\Themes::customize');
    $routes->post("/ajax/ajax-institute/themes/activity", 'Ajax\Themes::changeActivity');
    $routes->post("/ajax/ajax-institute/themes/remove", 'Ajax\Themes::removeTheme');
    $routes->post("/ajax/ajax-institute/themes/removeBanner", 'Ajax\Themes::removeBanner');
    $routes->post("/ajax/ajax-institute/themes/register", 'Ajax\Themes::registerTheme');
    $routes->post("/ajax/ajax-institute/themes/update", 'Ajax\Themes::updateTheme');
    $routes->post("/ajax/ajax-institute/themes/upFiles", 'Ajax\Themes::setBanner');
    $routes->post("/ajax/ajax-institute/themes/preview", 'Ajax\Themes::getTheme');
    
    // galeria
    $routes->post("/ajax/ajax-gallery/insertdata", 'Ajax\Gallery::insertGallery');
    $routes->post("/ajax/ajax-gallery/getdata", 'Ajax\Gallery::getGallery');
    $routes->post("/ajax/ajax-gallery/uploadfiles", 'Ajax\Gallery::uploadFiles');
    $routes->post("/ajax/ajax-gallery/order", 'Ajax\Gallery::updateOrder');
    $routes->post("/ajax/ajax-gallery/new-files", 'Ajax\Gallery::uploadNewFiles');
    $routes->post("/ajax/ajax-gallery/new-urls", 'Ajax\Gallery::insertUrls');
    $routes->post("/ajax/ajax-gallery/remove-files", 'Ajax\Gallery::removeFiles');
    $routes->post("/ajax/ajax-gallery/update", 'Ajax\Gallery::updateGallery');
    $routes->post("ajax/ajax-gallery/removeGallery", 'Ajax\Gallery::removeGallery');
    $routes->post("/ajax/ajax-gallery/get-featured", 'Ajax\Gallery::getFeatured');

    // posts
    $routes->post("/ajax/ajax-post/getdatapost", 'Ajax\Posts::post');
    $routes->post("/ajax/ajax-post/insertpostdata", 'Ajax\Posts::insertPost');
    $routes->post("/ajax/ajax-post/uploadfiles", 'Ajax\Posts::uploadFiles');
    $routes->post("/ajax/ajax-post/uploadmainfiles", 'Ajax\Posts::uploadFilesMainPost');
    $routes->post("/ajax/ajax-post/uploadpdffiles", 'Ajax\Posts::uploadPdfFiles');
    $routes->post("/ajax/ajax-post/like", 'Ajax\Posts::insertLikes');
    $routes->post("/ajax/ajax-post/dislike", 'Ajax\Posts::deleteLikes');
    $routes->post("/ajax/ajax-post/applyFilters", 'Ajax\Posts::applyFilters');
    $routes->post("ajax/ajax-post/removePost", 'Ajax\Posts::removePost');
    $routes->post("ajax/ajax-post/highlight", 'Ajax\Posts::highlight');
    $routes->post("/ajax/ajax-post/new-files", 'Ajax\Posts::uploadNewFiles');
    $routes->post("/ajax/ajax-post/new-urls", 'Ajax\Posts::uploadUrls');
    $routes->post("/ajax/ajax-post/remove-files", 'Ajax\Posts::removeFiles');
    $routes->post("/ajax/ajax-post/order", 'Ajax\Posts::updateOrder');
    $routes->post("/ajax/ajax-post/update", 'Ajax\Posts::updatePost');
    $routes->post("/ajax/ajax-post/get-featured", 'Ajax\Posts::getFeatured');

    // posts -> buscar informações //
    $routes->get("/$url/posts/dados-lista", 'Pagination::innerPosts'); // por categoria especifica
    $routes->get("/$url/posts/dados-lista-concurso", 'Pagination::publicTenders'); // concursos
    $routes->get("/$url/posts/dados-lista-noticias", 'Pagination::news'); // todos os posts
    $routes->get("/$url/posts/dados-lista-pesquisa", 'Pagination::search'); // pesquisas
    $routes->get("/$url/posts/dados-lista-reunioes", 'Pagination::committeeCalendar'); // reuniões

    // users
    $routes->post("/ajax/ajax-user/register", 'Ajax\User::register');
    $routes->post("/ajax/ajax-user/deleteAccount", 'Ajax\User::deleteAccount');
    $routes->post("/ajax/ajax-user/uploadfiles", 'Ajax\User::uploadFiles');
   
    // users -> trocar informações //
    $routes->post("/ajax/ajax-user/changeInfos", 'Ajax\User::changeInfos');
    $routes->post("/ajax/ajax-user/changefiles", 'Ajax\User::changefiles');
    $routes->post("/ajax/ajax-user/getImg", 'Ajax\User::getImg');
   
    //  users -> recuperar conta //
    $routes->post("/ajax/ajax-user/recover", 'Ajax\User::recoverAccount');
    $routes->post("/ajax/ajax-user/find-key", 'Ajax\User::findKey');
    $routes->post("/ajax/ajax-user/change-pass", 'Ajax\User::changePass');
    
    // membros
    $routes->post("ajax/ajax-member/register", 'Ajax\Member::register');
    $routes->post("ajax/ajax-member/uploadfiles", 'Ajax\Member::uploadFiles');
    $routes->post("ajax/ajax-member/uploadfiles/changeInfos", 'Ajax\Member::updateFiles');
    $routes->post("ajax/ajax-member/order", 'Ajax\Member::updateOrder');
    $routes->post("ajax/ajax-member/changeInfos", 'Ajax\Member::changeInfos');
    $routes->post("ajax/ajax-member/removeMember", 'Ajax\Member::removeMember');
    $routes->post("ajax/ajax-member/getImg", 'Ajax\Member::getImg');
    

    // reuniões
    $routes->post("ajax/ajax-meeting_event/insertData", 'Ajax\Meetings::insertData');
    $routes->post("/ajax/ajax-meeting_event/uploadfiles", 'Ajax\Meetings::uploadFiles');
    $routes->post("ajax/ajax-meeting/getdataMeeting", 'Ajax\Meetings::getData');
    $routes->post("/ajax/ajax-meeting_event/removeEvent", 'Ajax\Meetings::removeEvent');
    $routes->post("/ajax/ajax-meeting_event/get-featured", 'Ajax\Meetings::getFeatured');
    $routes->post("/ajax/ajax-meeting_event/remove-files", 'Ajax\Meetings::removeFiles');
    $routes->post("/ajax/ajax-meeting_event/new-files", 'Ajax\Meetings::uploadNewFiles');
    $routes->post("/ajax/ajax-meeting_event/update", 'Ajax\Meetings::updateEvent');

    // Enquetes/Pesquisa de satisfação
    $routes->post("ajax/ajax-polls/totalVotes", 'Ajax\Polls::totalVotesPoll');
    $routes->post("ajax/ajax-polls/registerNote", 'Ajax\Polls::registerNotePoll');
    $routes->post("ajax/ajax-polls/registerFeedback", 'Ajax\Polls::registerFeedback');

    // Cálculo atuarial
    $routes->post("ajax/ajax-actuarial/changeHypotheses", 'Ajax\Actuarial::changeHypotheses');
    $routes->post("ajax/ajax-actuarial/uploadfiles", 'Ajax\Actuarial::uploadFiles');
    $routes->post("ajax/ajax-actuarial/removeReport", 'Ajax\Actuarial::removeReport');
    // Cálculo atuarial -> buscar informações //
    $routes->get("/$url/calculo-atuarial/dados-lista", 'Pagination::actuarialCalcPgs');

    // CRP
    $routes->post("ajax/ajax-crp/uploadfiles", 'Ajax\Crp::uploadFiles');
    $routes->post("ajax/ajax-crp/removeCrp", 'Ajax\Crp::removeCrp');
    // crp -> buscar informações //
    $routes->get("/$url/crps/certificados/dados-lista", 'Pagination::crpPgs');
    
    // Colors
        $routes->post("/$url/get-colors", 'Ajax\Themes::getColors');
    //

    // Feedbacks
        $routes->get("/$url/feedbacks/dados-lista", 'Pagination::feedbacks');
    // 
// 


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
