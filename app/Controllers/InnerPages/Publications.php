<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Ajax\Polls;
use App\Models\InnerPages\Reviews;

/**
 * Classe de controle das páginas internas da área `Publicações`
 * @extends Posts|Templates
*/

class Publications extends Posts
{
    /** Retorna a página interna "Notícias" */
    public function noticias() {
        return $this->pgWithPosts(["Publicações", "Notícias"], "noticias"); 
    }

    /** Retorna a página interna "Informativo Semestral" */
    public function informativoSemestral() {
        return $this->pgWithPosts(["Publicações", "Informativo Semestral"]);  
    }

    /** Retorna a página interna "Galerias" */
    public function galeriaFotos() {
        $pgData = [ // dados para o template
            'page' => 'gallery',
            'headerLinks' => ["Publicações", "Galerias"],
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks']);    
    }

    /** Retorna a página interna "Pesquisa de Satisfação" */
    public function pesquisaSatisfacao() {
        $pgData = [ // dados para o template
            'page' => 'satisfaction-survey',
            'headerLinks' => ["Publicações", "Pesquisa de Satisfação"],
            'vars' => ['votes' => (new Reviews)->reviews($this->getInstituteId()), 'feedback' => (new Reviews)->getFeedback($this->getInstituteId())]
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);   
    }

    /** Retorna a página interna "Resultado da Pesquisa" */
    public function resultadoPesquisa() {
        $pgData = [ // dados para o template
            'page' => 'result-satisfaction-survey',
            'headerLinks' => ["Resultado da Pesquisa"],
            'vars' => ['ratings' => (new Polls)->getRatings($this->getInstituteId())]
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);   
    }
}
