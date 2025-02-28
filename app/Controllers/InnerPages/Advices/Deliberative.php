<?php

namespace App\Controllers\InnerPages\Advices;

use App\Controllers\InnerPages\Posts;
use App\Models\InnerPages\Team;

/**
 * Classe de controle das páginas internas da área `Conselhos - Deliberativo`
 * @extends Posts|Templates
*/

class Deliberative extends Posts
{
    /** Retorna a página interna "Membros Conselho Deliberativo" */
    public function membros() {                  
        $pgData = [ // dados para o template
            'page' => 'team',
            'headerLinks' => ["Conselho Deliberativo", "Membros Conselho Deliberativo"],
            'vars' => ['members' => (new Team)->team($this->getRoutes(), 3), 'committee' => 'deliberative']
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);
    }

    /** Retorna a página interna "Calendário de Reuniões" */
    public function calendarioReunioes() {
        return $this->pgWithPosts(["Conselho Deliberativo", "Calendário de Reuniões - Conselho Deliberativo"]);
    }

    /** Retorna a página interna "Atas das Reuniões" */
    public function atasReunioes() {
        return $this->pgWithPosts(["Conselho Deliberativo", "Atas das Reuniões – Conselho Deliberativo"]);
    }

    /** Retorna a página interna "Resoluções" */
    public function resolucoes() {
        return $this->pgWithPosts(["Conselho Deliberativo", "Resoluções – Conselho Deliberativo"]);
    }

    /** Retorna a página interna "Regimento Interno" */
    public function regimeInterno() {
        return $this->pgWithPosts(["Conselho Deliberativo", "Regimento Interno – Conselho Deliberativo"]);
    }
}
