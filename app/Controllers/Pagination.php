<?php

namespace App\Controllers;

use App\Models\Ajax\ActuarialModel;
use App\Models\Ajax\CrpModal;
use App\Models\Ajax\GalleryModel;
use App\Models\Ajax\InstituteModel;
use App\Models\Ajax\MeetingsModel;
use App\Models\Ajax\MemberModel;
use App\Models\Ajax\PollsModel;
use App\Models\Ajax\PostModel;
use App\Models\Ajax\ThemesModel;
use App\Models\InnerPages\Birthday;
use App\Models\InnerPages\Post;

/**
 * Classe de controle de páginação das tabelas e listas
 * @extends Templates
*/

class Pagination extends Templates
{
    /** Retorna lista de publicações específicas das páginas internas */
    public function innerPosts() { # lista de publicações específicas das páginas internas
        $getData = [
            'institute' => $this->getInstituteId(),
            'pg' => $_GET['pg'],
            'routeId' => $_GET['route_id'],
            'filters' => $_GET
        ];

        $data = [
            'page' => 'meetings-and-posts',
            'listFor' => 'inner',
            'vars' => (new Post)->getPosts($getData['institute'], $getData['pg'], $getData['routeId'], $getData['filters'])
        ];

        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de publicações relacionadas a concursos públicos */
    public function publicTenders() { # lista de publicações de concursos públicos
        $getData = [
            'institute' => $this->getInstituteId(),
            'pg' => $_GET['pg'],
            'filters' => $_GET
        ];

        $data = [
            'page' => 'meetings-and-posts',
            'listFor' => 'inner',
            'vars' => (new Post)->getPublicTenders($getData['institute'], $getData['pg'], $getData['filters'])
        ];

        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de publicações */
    public function news() { # lista com todas as publicações das páginas internas 
        $getData = [
            'institute' => $this->getInstituteId(),
            'pg' => $_GET['pg'],
            'filters' => $_GET
        ];

        $data = [
            'page' => 'meetings-and-posts',
            'listFor' => 'inner',
            'vars' => (new Post)->getAllPosts($getData['institute'], $getData['pg'], $getData['filters'])
        ];

        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de publicações relativas a pesquisa */
    public function search() { # lista de publicações relativas a pesquisa
        $getData = [
            'institute' => $this->getInstituteId(),
            'pg' => $_GET['pg'],
            'search' => $_GET['search'],
            'filters' => $_GET
        ];

        $data = [
            'page' => 'meetings-and-posts',
            'listFor' => 'inner',
            'vars' => (new Post)->searchPost($getData['institute'], $getData['pg'], $getData['search'], $getData['filters'])
        ];

        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de publicações e reuniões do comitê */
    public function committeeCalendar() { # lista de publicações e reuniões do comitê
        $data = (new Post())->calendarCommittee($this->getInstituteId(), $_GET['pg'], $_GET['route_id'], $_GET);
        return $this->lists('meetings-and-posts', 'inner', $data);
    }

    /** Retorna lista de arquivos upados relacionados ao cálculo atuarial */
    public function actuarialCalcPgs() { # lista dos arquivos upados relativos ao cálculo atuarial   
        /**
         * @var boolean $isRegister Essa página é de registro? 
         * @var mixed $data dados para o template
        */
        $isRegister = filter_var($_GET['register'], FILTER_VALIDATE_BOOLEAN); 

        $data = [
            'page' => 'actuarial-calculation',
            'listFor' => $isRegister ? 'registration' : 'inner', // lista das páginas internas ou da página de registro?
            'vars' => (new ActuarialModel)->getActuarialData($this->getInstituteId(), $_GET['pg'], !$isRegister)
        ];
        
        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de arquivos upados relacionados aos certificados de regularidade previdenciária (CRPS) */
    public function crpPgs() { # lista de arquivos upados relacionados aos certificados de regularidade previdenciária
        /**
         * @var boolean $isRegister Essa página é de registro? 
         * @var mixed $data dados para o template
        */

        $isRegister = filter_var($_GET['register'], FILTER_VALIDATE_BOOLEAN); 

        $data = [
            'page' => 'crps',
            'listFor' => $isRegister ? 'registration' : 'inner', // lista das páginas internas ou da página de registro?
            'vars' => (new CrpModal)->getCrpData($this->getInstituteId(), $_GET['pg'])
        ];
        
        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de integrantes do conselho */
    public function team() { # lista de integrantes do conselho
        $data = (new MemberModel)->getTeam($this->getInstituteId(), $_GET['pg'], $_GET['team']);        
        return $this->lists('team', 'config', $data);
    }

    /** Retorna lista de galerias para as configurações */
    public function gallery() { # lista de galerias para as configurações
        $data = (new GalleryModel)->getGalleriesList($_GET['pg'], $_GET); 
        return $this->lists('gallery', 'config', $data);
    }

    /** Retorna lista de galerias para as páginas internas */
    public function galleries() { # lista de galerias para as páginas internas
        $data = [
            'page' => 'gallery',
            'listFor' => 'inner',
            'vars' => ['galleries' => (new GalleryModel)->getGalleries($_GET['pg'], $this->getInstituteId())]
        ];

        return $this->lists($data['page'], $data['listFor'], $data['vars']);
    }

    /** Retorna lista de mídias da galeria para as configurações */
    public function galleryMedias() { # lista de mídias da galeria para as configurações
        $data = (new GalleryModel)->getMedias($_GET['id']); 
        return $this->lists('gallery-medias', 'config', $data);
    }

    /** Retorna lista de publicações para a página de configurações */
    public function posts() { # lista de publicações para a página de configurações
        $data = (new PostModel)->getPosts($_GET['pg'], $_GET); 
        return $this->lists('post', 'config', $data);

    }

    /** Retorna lista de mídias das públicações para a página de configurações */
    public function postsMedias() { # lista de mídias das públicações para a página de configurações
        $data = (new PostModel)->getMedias($_GET['id']); 
        return $this->lists('post-medias', 'config', $data);
    }

    /** Retorna lista de aniversários */
    public function birthdays() { # lista de aniversários        
        $pgData = [ // dados para o template
            'page' => 'birthdays-list',
            'vars' => (new Birthday)->birthdays($this->getInstituteId(), $_GET['pg'], $_GET['date'])
        ];

        return $this->lists($pgData['page'], 'inner', $pgData['vars']);
    }

    /** Retorna lista de logos dos parceiros do instituto para a página de configurações */
    public function logos() { # lista de logos dos parceiros 
        $data = (new InstituteModel)->getLogos(session()->get('id')); 
        return $this->lists('logos', 'config', $data['logos']);
    }
    
    /** Retorna lista de eventos para a página de configurações */
    public function events() { # lista de eventos  
        $data = (new MeetingsModel)->getEvents($_GET['pg'], $_GET); 
        return $this->lists('events', 'config', ['event' => $data]);
    }

    /** Retorna lista de feedbacks */
    public function feedbacks() { # lista de feedbacks       
        $pgData = [ // dados para o template
            'page' => 'feedbacks',
            'vars' => ['feedbacks' => (new PollsModel)->getFeedbacks($_GET['pg'], ['rating' => $_GET['rating'], 'onlyComments' => $_GET['onlyComments']], $this->getInstituteId())]
        ];

        echo view('contents/template-gentacz/header/head');
        return $this->lists($pgData['page'], 'inner', $pgData['vars']);
    }

    /** Retorna lista de temas do instituto */
    public function userThemes() { # lista de temas do instituto
        $data = (new ThemesModel)->getThemes($_GET['pg'], $_GET, 'user'); 
        return $this->lists('user-themes', 'config', $data);
    }

    /** Retorna lista de temas predefinidos */
    public function presetThemes() { # lista de temas predefinidos 
        $data = (new ThemesModel)->getThemes($_GET['pg'], $_GET, 'preset'); 
        return $this->lists('preset-themes', 'config', $data);
    }
}
