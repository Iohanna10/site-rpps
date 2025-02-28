<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Models\Ajax\PollsModel;
use App\Models\Session\SessionModel;

/**
 * Classe de controle das funções de recuperação e registro de `Votos das enquetes e feedbacks`
*/

class Polls extends BaseController
{
    /** Retornar id do intituto */
    public function getInstituteId($institute) { # pegar id do instituto
        return (new SessionModel)->getInstituteId($institute);
    }  

    /** Retornar votos das enquetes */
    public function totalVotesPoll() { # pegar total de votos na enquete
        $data = [
            'id_poll' => $this->request->getPost('id_poll'),
            'id_institute' => $this->getInstituteId($this->request->getPost('id_institute')),
        ];

        return $this->response->setJSON((new PollsModel)->totalVotesPoll($data)); // retorna um array 
    }

    /** Enviar dados para registrar votos das enquetes no banco de dados */
    public function registerNotePoll() { # registrar nota da enquete  
        $data = [
            'id_poll' => $this->request->getPost('id_poll'),
            'note' => $this->request->getPost('note'),
        ];

        return $this->response->setJSON((new PollsModel)->registerNotePoll($data)); // retorna boleeano e uma string confirmando ou não se a nota foi registrada
    }

    /** Enviar dados para registrar feedbacks no banco de dados */
    public function registerFeedback() { # registrar o feedback/depoimento
        $data = [
            'feedback' => $this->request->getPost('feedback'),
        ];

        return $this->response->setJSON((new PollsModel)->registerFeedback($data));
    }

    /** Retornar feedbacks */
    public function getRatings($id){
        return (new PollsModel)->getRatings($id); // retorna as porcentagens de aprovação das enquetes
    }
}
