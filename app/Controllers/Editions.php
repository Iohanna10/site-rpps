<?php

namespace App\Controllers;

use App\Controllers\Ajax\Themes;
use App\Controllers\Templates;
use App\Models\Ajax\GalleryModel;
use App\Models\InnerPages\Post;
use App\Models\InnerPages\Team;

/**
 * Classe de controle das páginas relacionadas a edição 
 * @extends Templates
*/

class Editions extends Templates
{
    /** Retorna galeria para edição */
    public function gallery() { # recuperar galeria para editar
        $data = [
            'id_gallery' => $_GET['id'], 
            'id_institute' => $this->getInstituteId(), 
            'path_name' => false
        ];
      
        if(!isset($_GET['id']) || !(new GalleryModel)->getGallery($data)){
            return $this->configs('gallery', ['blocked' => true], 'edit', 'galerias');     
        }
        return $this->configs('gallery', ['gallery' => (new GalleryModel)->getGallery($data)], 'edit', 'galerias'); 
    }

    /** Retorna integrante de um conselho para edição */
    public function team () { # recuperar integrante 
        return $this->configs('member', ['member' => (new Team)->getMember($_GET['id'])], 'edit', 'equipe'); 
    }

    /** Retorna publicação para edição */
    public function posts() { # recuperar publicação para editar
        if(!isset($_GET['id']) || !(new Post)->getPost($_GET['id'])){
            return $this->configs('post', ['blocked' => true], 'edit', 'publicacoes');     
        }
        return $this->configs('post', ['post' => (new Post)->getPost($_GET['id'])], 'edit', 'publicacoes'); 
    }

    /** Retorna evento/reunião para edição */
    public function events() { # recuperar evento para editar
        if(!isset($_GET['id']) || !(new Post)->getEvent($_GET['id'])){
            return $this->configs('event', ['blocked' => true], 'edit', 'eventos');     
        }
        return $this->configs('event', ['event' => (new Post)->getEvent($_GET['id'])], 'edit', 'eventos'); 
    }

    /** Retorna o HTML do formulário de eventos ou de reuniões do instituto para a edição */
    public function editPageEv() {
        $data = (new Post)->getEvent($_GET['id']);
        return $this->configs('form-events', ['type' => $_GET['type'], 'event' => $data], 'edit');
    }

    /** Retorna o tema para edição */
    public function theme() {
        $data = (new Themes)->getTheme($_GET['id']);
        return $this->configs('theme', ['theme' => $data], 'edit', 'personalizar');
    }
}