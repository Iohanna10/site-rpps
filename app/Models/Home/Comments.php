<?php

namespace App\Models\Home;

use CodeIgniter\Model;

class Comments extends Model {

    protected $table = 'avaliacoes';

    Public function comments($id) { # pegar notas e comentário/depoimento do beneficiado
        // comentários
        $dbData = $this->getBeneficiary($this->query("SELECT id_beneficiado, atendimento, cordialidade, eficiencia, espera_atendimento, clareza, comunicacao, acoes_desenvolvidas, transparencia, satisfacao, acessibilidade, conforto, horario_atendimento, depoimento FROM avaliacoes WHERE id_instituto = ? AND depoimento IS NOT NULL ORDER BY data DESC LIMIT 3", $id)->getResult('array'));

        // todos os dados 
        $data = [
            'dbData' => $dbData,
        ];

        return $data;
    }

    public function beneficiaryData($beneficiaries, $routes) { #pegar foto e nome 
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

        return $data;
    }

    private function getBeneficiary($data){ # pegar foto e nome somente se a nota for igual a nota selecionada 
        $filterData = [];

        // verificar e atribuir aos registros selecionados somente os que possuem a nota selecionada 
        foreach ($data as $keyRegisters => $register) {
            $totalRating = 0;
            $fullVotes = true;

            foreach ($register as $key => $rating) { // somar e pegar média de avaliação
                if($key != 'id_beneficiado' && $key != 'depoimento'){
                    if($rating == null || $fullVotes == false){
                        $fullVotes = false;
                        break;
                    }

                    $totalRating += intval($rating);
                }
            }

            if($fullVotes){
                $query = "SELECT nome, foto FROM beneficiados WHERE id = " . $register['id_beneficiado'];
                $beneficiary = $this->query($query)->getResult('array')[0];
    
                array_push($filterData, ['beneficiary' => $beneficiary, 'feedback' => $register['depoimento'], 'rating' => round((($totalRating/12)*100)/4)]);
            }
        }

        return $filterData;
    }
}