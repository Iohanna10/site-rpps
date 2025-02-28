<?php

namespace App\Controllers\InnerPages\Advices;

use App\Controllers\InnerPages\Posts;
use App\Models\InnerPages\Team;

/**
 * Classe de controle das páginas internas da área `Conselhos - Fiscal`
 * @extends Posts|Templates
*/

class Fiscal extends Posts
{
    /** Retorna a página interna "Membros Conselho Fiscal" */
    public function membros() {    
        $pgData = [ // dados para o template
            'page' => 'team',
            'headerLinks' => ["Fiscal", "Membros Conselho Fiscal"],
            'vars' => ['members' => (new Team)->team($this->getRoutes(), 2), 'committee' => 'fiscal']
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']); 
    }

    /** Retorna a página interna "Calendário de Reuniões" */
    public function calendarioReunioes() {
        return $this->pgWithPosts(["Fiscal", "Calendário de Reuniões - Conselho Fiscal"]);
    }

    /** Retorna a página interna "Atas das Reuniões" */
    public function atasReunioes() {
        return $this->pgWithPosts(["Fiscal", "Atas das Reuniões – Conselho Fiscal"]);
    }

    /** Retorna a página interna "Resoluções" */
    public function resolucoes() {
        return $this->pgWithPosts(["Fiscal", "Resoluções – Conselho Fiscal"]);
    }

    /** Retorna a página interna "Regimento Interno" */
    public function regimeInterno() {
        return $this->pgWithPosts(["Fiscal", "Regimento Interno – Conselho Fiscal"]);
    }
}
