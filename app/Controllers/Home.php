<?php

namespace App\Controllers;

use App\Controllers\InnerPages\Posts;
use App\Models\Ajax\InstituteModel;
use App\Models\Ajax\ThemesModel;
use App\Models\Home\Comments;
use App\Models\Home\Events;
use App\Models\Home\LatestPublications;
use App\Models\Home\SlideNews; 

class Home extends Posts
{
    /** Carrega o HTML da `página principal`|`pesquisa` */
    public function index() {
        $instituteId = $this->getInstituteId();

        if($instituteId){ // o ID foi encontrado?
            
            # pesquisa por publicação
            if(isset($_GET['search'])){ // foi feita alguma pesquisa no campo de busca?
                return $this->innerpages("posts", ["Resultados para: " . $_GET['search']], ["routeId" => "pesquisa", "search" => $_GET['search']]); 
            } 
    
            # página inicial
            $vars = [ // dados da página inicial
                'banner'    => (new ThemesModel)->getCustomizations($instituteId),
                'news'      => (new SlideNews)->slideNews($instituteId),
                'latestPb'  => (new LatestPublications)->latestPublications($instituteId),
                'links'     => $this->getLinks(),
                'feedbacks' => (new Comments)->comments($instituteId),
                'infos'     => $this->getInfos(),
                'logos'     => (new InstituteModel)->getLogos($instituteId)['logos']
            ];
    
            return $this->home($vars['banner'], $vars['news'], $vars['latestPb'], $vars['links'], $vars['feedbacks'], $vars['infos'], $vars['logos']); 
        }

        return $this->home(); // se o instituto não possuir cadastro
    }

    /** Retorna calendário com todos os eventos do mês */
    public function calendar() { # calendário de eventos
        $events = (new Events)->allEvents($this->getInstituteId($_POST['institute']), $_POST['month']);
        return $this->homeCalendar($events); 
    }

    /** (Ao clicar no calendário) Retorna o modal com os eventos do dia. */
    public function calendarModalEvents() { # modal de eventos 
        $data = [
            'id'   => $this->getInstituteId(),
            'date' => $_GET['date']
        ];
        $events = (new Events)->getAllEventsDay($data);

        return $this->homeCalendarEventsDay($events); 
    }

    /** (Ao clicar no evento do modal) Retorna informações do evento selecionado no modal */
    public function calendarModalInfos() { # modal de informações do evento
        $data = [
            'id_institute' => $this->getInstituteId(),
            'id'           => $_GET['id'],
            'date'         => $_GET['date']
        ];
        $eventInfo = (new Events)->getInfoEvent($data);

        return $this->homeCalendarEventInfo($eventInfo);         
    }

    /** Retorna links úteis do instituto do banco de dados */
    private function getLinks() { # pegar links úteis 
        return (new Session)->dataInstitute(
            $this->getInstituteId(), // id do instituto
            ['infos'], // tabela
            ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov', 'link_calendario_pagamentos', 'link_legislacao_prev', 'link_folha_pagamento']] // colunas da tabela
        )['infos']; // dados do array que deve retornar
    }

    /** Retorna dados estatísticos do instituto do banco de dados */
    private function getInfos() { # pegar dados estatísticos
        return (new Session)->dataInstitute(
            $this->getInstituteId(), // id do instituto
            ['infos'], // tabela
            ['infos' => ['ativos', 'aposentados', 'pensionistas', 'dependentes']] // colunas
            )['infos']; // dados do array que deve retornar 
    }
}
