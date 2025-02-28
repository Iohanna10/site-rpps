<?php

namespace App\Controllers\InnerPages;

/**
 * Classe de controle das páginas internas da área `Segurados`
 * @extends Posts|Templates
*/

class Policyholders extends Posts
{
    /** Retorna a página interna "Segurados" */
    public function segurados() {
        return $this->pgWithPosts(["Segurados"]);
    }

    /** Retorna a página interna "Aniversários" */
    public function aniversario() {   
        $pgData = [ // dados para o template
            'page' => 'birthdays',
            'headerLinks' => ["Segurados", "Aniversários"],
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks']);
    }

    /** Retorna a página interna "Lista de Aniversários" */
    public function listaAniversario() {   
        $pgData = [ // dados para o template
            'page' => 'birthdays-list',
            'headerLinks' => ["Segurados", "Aniversários", "Lista de Aniversários"],
            'vars' => [],
            'goBack' => 'segurados/aniversario',
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars'], $pgData['goBack']);
    }

    /** Retorna a página interna "Solenidade" */
    public function solenidade() {
        return $this->pgWithPosts(["Solenidade"]);
    }

    /** Retorna a página interna "Cartilha Previdenciária" */
    public function cartilhaPrevidenciaria() {
        return $this->pgWithPosts(["Segurados", "Cartilha Previdenciária"]);        
    }
}
