<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Session;
use App\Controllers\Templates;

/**
 * Classe de controle das páginas internas da área `Fale conosco`
 * @extends Posts|Templates
*/

class ContactUs extends Templates
{
    /** Retorna a página interna "Fale Conosco" */
    public function contatar() {   
        $pgData = [ // dados para o template
            'page' => 'contact-us',
            'headerLinks' => ["Fale Conosco"],
            'vars' => (new Session)->dataInstitute($this->getInstituteId(), ['infos', 'contatos'], ['infos' => ['endereco'], 'contatos' => ['telefones', 'email']])
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);
    }
}
