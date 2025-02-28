<?php

namespace App\Models\InnerPages;

use CodeIgniter\Model;

class Reviews extends Model {

    protected $table = 'avaliacoes';

    Public function reviews($institute){
        if(session()->get("type") == "user"){
            $params = [
                $institute,
                session()->get("idUser")
            ];

             // todos os votos das enquetes 
             $data = [
                'votos' => ($this->query("
                    SELECT atendimento, cordialidade, eficiencia, espera_atendimento, clareza, comunicacao, acoes_desenvolvidas, transparencia, satisfacao, acessibilidade, conforto, horario_atendimento, depoimento
                    FROM avaliacoes 
                    WHERE id_instituto = ? AND id_beneficiado = ?",
                    $params
                )->getResult('array'))
            ];

            return $data['votos'][0];
        }
        return ['atendimento' => NULL, 'cordialidade' => NULL, 'eficiencia' => NULL, 'espera_atendimento' => NULL, 'clareza' => NULL, 'comunicacao' => NULL, 'acoes_desenvolvidas' => NULL, 'transparencia' => NULL, 'satisfacao' => NULL, 'acessibilidade' => NULL, 'conforto' => NULL, 'horario_atendimento' => NULL];
    }

    public function getFeedback($institute){
        if(session()->get("type") == "user"){
            $params = [
                $institute,
                session()->get("idUser")
            ];

             $data = $this->query("
                    SELECT depoimento
                    FROM avaliacoes 
                    WHERE id_instituto = ? AND id_beneficiado = ?",
                    $params
                )->getResult('array')[0]['depoimento'];

            return $data;
        }
        return null;
    }

    public function beneficiaryData($beneficiaries, $routes){
        $data = [];

        foreach ($beneficiaries as $key => $beneficiary) {
            $params = [
                $routes['instituteId'],
                $beneficiary['id_beneficiado']
            ];
    
            // dados da pessoa que deu o depoimento
            $queryBeneficiary = ($this->query("
                SELECT nome, foto
                FROM beneficiados 
                WHERE id_instituto = ? AND 	id = ?",
                $params
            )->getResultObject());

            array_push($data, $queryBeneficiary);
        }

        return $data[0];
    }
}