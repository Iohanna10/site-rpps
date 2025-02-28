<?php

namespace App\Controllers\ConfigInfos;

use App\Controllers\Ajax\Polls;
use App\Controllers\Ajax\Themes;
use App\Controllers\Session;
use App\Controllers\Templates;

/**
 * Classe de controle das páginas relacionadas a `Configurações do Instituto`
 * @extends Templates
*/

class Institute extends Templates
{ 
    /** Retorna a página de configurações do instituto */
    public function index() { 
        return $this->configs('home-config');
    }

    /** Retorna a página de configurações dos dados do instituto */
    public function instituteConfig() {
        $dataInstitute = (new Session)->dataInstitute(session()->get('id'), ['infos', 'contatos'], ['infos' => ['sobre', 'missao', 'visao', 'valores', 'politica_investimento', 'comite_investimento', 'descricao_alm', 'endereco', 'horario_func', 'link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov', 'link_calendario_pagamentos', 'link_legislacao_prev', 'link_folha_pagamento'], 'contatos' => ['*']]);

        return $this->configs('config', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
    }

    /** Retorna a página de configurações dos temas/customizações do instituto */
    public function instituteCustomization() {
        $data = (new Themes)->getDefaultTheme($this->getInstituteId());
        return $this->configs('customization', ['defaultTheme' => $data]);
    }

    /** Retorna a página de configurações dos integrantes dos conselhos do instituto */
    public function team() {
        return $this->configs('team');
    }

    /** Retorna a página de configurações das galerias do instituto */
    public function gallery() {
        return $this->configs('gallery');
    }

    /** Retorna a página de configurações de publicações do instituto */
    public function posts() {
        return $this->configs('posts');
    }

    /** Retorna a página de configurações de eventos do instituto */
    public function events() {
        return $this->configs('events');
    }

    /** Retorna a página de feedbacks */
    public function ratings() {
        $data = (new Polls)->getRatings($this->getInstituteId());
        return $this->configs('ratings', ['ratings' => $data]);
    }
}