<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Classe de controle dos templates do site.
 * Contém as funções de template para gerar o HTML completo das páginas.
*/

class Templates extends Controller
{   
    /**
     * Carrega os arquivos do template e retorna o HTML completo para a página inicial
     * @param array  $banner Banner da página.
     * @param array  $news Notícias destacadas.
     * @param array  $latestPb Publicações - `@var array 'latest'`: Últimas publicações e `@var int 'numPb'`: Número de publicações.
     * @param array  $links Links Úteis.
     * @param array  $feedbacks Feedbacks sobre o instituto dos beneficiados.
     * @param array  $infos Informações estatísticas do instituto.
     * @param string  $logos Logos de parceiros do instituto.
     * @return string O HTML completo da página, incluindo cabeçalho, conteúdo principal e rodapé.
    */
    public function home(array $banner = [], array $news = [], array $latestPb = [], array $links = [], array $feedbacks = [], array $infos = [], string $logos = '') {
        /** @var bool|\CodeIgniter\HTTP\RedirectResponse $verify */
        $verify = (new Session)->validInstitute($this);
        if($verify !== true) { // verificar se o instituto existe e se o usuário conectado pertence ao instituto
            return $verify;
        }; 

        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
    
        // head
        /** @var string $content O HTML completo da página. */
        $content  = view("contents/$template/common/header/head"); 
        $content .= view("contents/$template/home-page/header/head");
        $content .= view('contents/template-gentacz/header/head');

        // header
        $content .= view("contents/$template/common/header/menu", $this->getMenuData());

        // main
        $content .= view("contents/$template/home-page/main/sections/banner", ['banner' => $banner]);
        $content .= view("contents/$template/home-page/main/sections/slide-news", ['mainNews' => $news, 'tel' => $this->getFooterData()['contacts']['tel']]);
        $content .= view("contents/$template/home-page/main/sections/publications", ['latest' => $latestPb['latest'], 'numPb' => $latestPb['numPb']]);
        $content .= view("contents/$template/home-page/main/sections/main", ['links' => $links]);
        $content .= view("contents/$template/home-page/main/sections/comments", ['feedbacks' => $feedbacks]);
        $content .= view("contents/$template/home-page/main/sections/infos", ['infos' => $infos]);

        // footer
        $content .= view("contents/$template/common/footer/sections/logos", ["logos" => $logos]);
        $content .= view("contents/$template/common/footer/sections/infos", $this->getFooterData());
        $content .= view("contents/theme");

        return $content;
    }

    /**
     * Carrega o template do calendário com todos os eventos do mês selecionado e retorna o HTML.
     * @param array $events Todos os eventos do instituto para compor o calendário.
     * @return string O HTML do calendário.
    */
    public function homeCalendar($events) {
        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();

        return view("contents/$template/home-page/main/sections/calendar", ['events' => $events]);
    }

    /**
     * Carrega o template do modal com todos os eventos do dia selecionado e retorna o HTML.
     * @param array $eventsDay Eventos do dia selecionado no calendário.
     * @return string O HTML do modal.
    */
    public function homeCalendarEventsDay($eventsDay) {
        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
        
        return view("contents/$template/home-page/main/sections/calendar-modal-all", ['events' => $eventsDay]);
    }

    /**
     * Carrega o template do modal com as informações do evento selecionado e retorna o HTML.
     * @param array $eventInfo Informações do evento selecionado no modal.
     * @return string O HTML do modal de informações.
    */
    public function homeCalendarEventInfo($eventInfo) {
        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
        
        return view("contents/$template/home-page/main/sections/calendar-modal-infos", ['event' => $eventInfo]);
    }

    /**
     * Carrega os arquivos do template e retorna o HTML completo para uma página interna
     * @param string $page Nome do arquivo da página a ser carregada (sem extensão).
     * @param array $headerLinks Nomes atribuidos aos links das rotas no header.
     * @param array $vars Dados do conteúdo da página
     * @param false|string $goBack URL de redirecionamento ao clicar em voltar ou `false` para não incluir.
     * @param false|string $description Descrição da página ou `false` para não incluir.
     * @return string O HTML completo da página, incluindo cabeçalho, conteúdo principal e rodapé.
    */
    public function innerpages(string $page = '', array $headerLinks, array $vars = [], false|string $goBack = false, false|string $description = false)
    {
        /** @var bool|\CodeIgniter\HTTP\RedirectResponse $verify */
        $verify = (new Session)->validInstitute($this);
        if($verify !== true) { // verificar se o instituto existe e se o usuário conectado pertence ao instituto
            return $verify;
        }; 

        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
        
        // head
        /** @var string $content O HTML completo da página. */
        $content  = view("contents/$template/common/header/head"); 
        $content .= view("contents/$template/inner-pages/header/head");

        // header
        $content .= view("contents/$template/common/header/menu", $this->getMenuData());
        $content .= view("contents/$template/inner-pages/header/sections/header-links", ['headerLinks' => $headerLinks]); 
        $content .= ($goBack != false) ? view("contents/$template/common/header/go-back", ['goBack' => $goBack, 'jsFunc' => false]) : ''; // se for diferente de false adicionar view ao HTML 
        
        // main
        $content .= ($description != false) ? view("contents/$template/inner-pages/main/sections/description", ['description' => $description]) : ''; // se for diferente de false adicionar view ao HTML 
        $content .= view("contents/$template/inner-pages/main/sections/" . $page, ['data' => $vars]);

        // footer
        $content .= view("contents/$template/common/footer/sections/infos", $this->getFooterData());
        $content .= view("contents/theme");

        return $content;
    }

    /**
     * Carrega os arquivos do template e retorna o HTML completo de uma lista para uma página 
     * @param string $page Nome do arquivo da página a ser carregada (sem extensão).
     * @param string $listFor Caminho para o tipo de lista (`inner`, `registration` ou `config`)
     * @param array $vars Dados do conteúdo da página
     * @return string O HTML completo da página, incluindo cabeçalho, conteúdo principal e rodapé.
    */
    public function lists($page, $listFor, $vars) {
        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
    
        return view("contents/$template/$listFor-pages/lists/$page", ['data' => $vars]); 
    }

    /**
     * Carrega os arquivos do template e retorna o HTML completo para uma página de configuração
     * @param string $page Nome do arquivo da página a ser carregada (sem extensão).
     * @param array $vars Dados do conteúdo da página 
     * @param string $typePg Tipo de página a ser carregada, podendo ser: `config`, `registration` ou `edit`.
     * @param false|string $goBack URL de redirecionamento ao clicar em voltar ou `false` para não incluir.
     * @return string O HTML de uma página de configuração. 
    */
    public function configs(string $page, array $vars = [], string $typePg = 'config', false|string $goBack = false)
    {
        /** @var bool|\CodeIgniter\HTTP\RedirectResponse $verify */
        $verify = (new Session)->validInstitute($this, 'institute', true);
        if($verify !== true) { // verificar se o instituto existe e se o usuário conectado pertence ao instituto
            return $verify;
        }; 

        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
        
        // head
        /** @var string $content O HTML completo da página. */
        $content = '';
        if($page === 'home-config'){
            $content  = view("contents/$template/common/header/head"); 
            $content .= view("contents/$template/config-pages/header/head");
        }
        // header
        $content .= ($goBack != false) ? view("contents/$template/common/header/go-back", ['goBack' => $goBack, 'jsFunc' => true]) : ''; // se for diferente de false adicionar view ao HTML 
        
        // main
        $content .= view("contents/$template/$typePg-pages/" . $page, ['data' => $vars]);

        // footer
        $content .= view("contents/theme");

        return $content;
    }

    /**
     * Carrega os arquivos do template e retorna o HTML completo para uma página de configuração
     * @param string $page Nome do arquivo da página a ser carregada (sem extensão).
     * @param array $vars Dados do conteúdo da página 
     * @param false|string $goBack URL de redirecionamento ao clicar em voltar ou `false` para não incluir.
     * @return string O HTML de uma página de configuração. 
    */
    public function userConfigs(string $page, array $vars = [], false|string $goBack = false)
    {
        /** @var bool|\CodeIgniter\HTTP\RedirectResponse $verify */
        $verify = $page === 'user-config' ? (new Session)->validInstitute($this, 'user', true) : (new Session)->validInstitute($this);
        if($verify !== true) { // verificar se o instituto existe e se o usuário conectado pertence ao instituto
            return $verify;
        }; 

        /** @var string $template Número do template que será utilizado. */
        $template = "template-" . $this->getTemplate();
        
        // head
        /** @var string $content O HTML completo da página. */
        $content  = view("contents/$template/common/header/head"); 
        $content .= view("contents/$template/account/common/header/head");

        // header
        $content .= ($goBack != false) ? view("contents/$template/common/header/go-back", ['goBack' => $goBack, 'jsFunc' => false]) : ''; // se for diferente de false adicionar view ao HTML 
        
        // main
        $content .= view("contents/$template/account/$page", ['data' => $vars]);

        // footer
        $content .= view("contents/theme");

        return $content;
    }

    /**
     * Retorna o HTML de uma página de erro 
     * @param string $page Nome do arquivo a ser carregado no template 
     * @return string O HTML da página de erro
    */
    public function error($page) {
        return view("contents/errors/$page");
    }

    /**
     * retorna o template definido pelo instituto do banco de dados
     * @return int
    */
    private function getTemplate() {
        $template = (new Session)->dataInstitute(
            $this->getInstituteId(), // id do instituto
            ['instituto'], // tabela
            ['instituto' => ['template']] // coluna
        )['instituto'];
        return $template['template'];
    }

    /**
     * retorna os links do menu definidos pelo instituto do banco de dados
     * @return array
    */
    private function getMenuData() {
        $links = (new Session)->dataInstitute(
            $this->getInstituteId(), // instituto atual
            ['infos'], // tabela para pegar informações
            ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']] // colunas da tabela para retornar dados 
        )['infos'];

        return ['links' => $links];
    }

    /**
     * retorna as informações de funcionamento, endereço e contatos definidos pelo instituto do banco de dados
     * @return array
    */
    private function getFooterData () {
        $footerData = (new Session)->dataInstitute(
            $this->getInstituteId(), // instituto atual
            ['infos', 'contatos'], // tabelas 
            ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]  // retorna dados das colunas
        );
        return ['info' => $footerData['infos'], 'contacts' => $footerData['contatos']];
    }

    /**
     * Retorna o id do instituto ou `false` caso não exista no banco de dados. 
     * Caso não seja informado um valor para a variável `institute`, utiliza o nome do instituto informado na URL. 
     * @param string $institute Nome do instituto 
     * @return int  
    */
    protected function getInstituteId(string $institute = '')
    {
        return $institute === '' ? (new Session)->currentInstitute($this)['instituteId'] : (new Session)->getInstituteId($institute);
    }

    /**
     * Retorna as rotas da URL. 
     * Caso não seja informado um valor para a variável `institute`, utiliza o nome do instituto informado na URL. 
     * @param string $institute Nome do instituto 
     * @return array Rotas da URL atual
    */
    protected function getRoutes()
    {
        return (new Session)->currentInstitute($this);
    }
}
