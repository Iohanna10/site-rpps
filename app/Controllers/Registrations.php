<?php

namespace App\Controllers;

use App\Controllers\Templates;
use App\Models\Ajax\ActuarialModel;

/**
 * Classe de controle das páginas de cadastro  
 * @extends Templates
*/

class Registrations extends Templates
{
    /** Retorna página de registro de integrantes dos conselhos */ 
    public function members() { # cadastro de membros
        return $this->configs('member', [], 'registration', 'equipe');
    }

    /** Retorna página de registro de publicações */ 
    public function posts() { # cadastro das publicações
        return $this->configs('posts', [], 'registration', 'publicacoes');
    }

    /** Retorna página de registro de galerias */ 
    public function gallery() { # cadastro de galerias     
        return $this->configs('gallery', [], 'registration', 'galerias');
    }

    /** Retorna página de registro de eventos */    
    public function events() { # cadastro de reuniões
        return $this->configs('meetings', [], 'registration', 'eventos');
    }

    /** Retorna o HTML do formulário do tipo de evento selecionado para registro */    
    public function eventsForms() { # formulários de registro        
        $type = $_GET['type'];
        return $this->configs('form-meetings', ['type' => $type], 'registration');
    }

    /** Retorna página de registro de cálculos atuariais e alteração das hipóteses */    
    public function actuarialCalc() { # cadastro de relatórios de cálculo atuarial
        $data = (new ActuarialModel)->getHypotheses($this->getInstituteId());
        return $this->configs('actuarial-calc', $data, 'registration');
    }

    /** Retorna página de registro de certificados de regularidade previdenciária */    
    public function crps() { # cadastro de relatórios de gestão atuarial
        return $this->configs('crps', [], 'registration');
    }

    /** Retorna página de registro de temas */    
    public function theme() {
        return $this->configs('themes', [], 'registration', 'personalizar');
    }
}
