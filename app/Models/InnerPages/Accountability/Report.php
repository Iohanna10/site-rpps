<?php

namespace App\Models\InnerPages\Accountability;

use CodeIgniter\Model;

class Report extends Model {

    protected $table = 'relatorio_e_crps';

    Public function getReports($id, $calc_bool) { # pegar relatórios
        $params = [
            'institute' => $id,
        ];

        $queryReports = 'SELECT id, nome, titulo, data FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 0 ORDER BY data DESC';

        if($calc_bool){
            $dataDB['calc_atuarial'] = $this->query("SELECT calc_atuarial FROM instituto_infos WHERE id = :institute:", $params)->getResult('array')[0]['calc_atuarial'];

            $dataDB['regimes_financeiros'] = $this->query("SELECT regimes_financeiros FROM instituto_infos WHERE id = :institute:", $params)->getResult('array')[0]['regimes_financeiros'];
            
            $queryReports .= ' LIMIT 4';

            $dataDB['numReports'] = $this->query("SELECT COUNT(id) as num FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 0", $params)->getResult('array')[0]['num'];
        }    
        
        $dataDB['reports'] = $this->dbData([], $this->query($queryReports, $params)->getResult('array'), $params, 'relatorios');
        
        return $dataDB;
    }

    private function dbData($array, $data, $params, $type) { # constrir dados para serem enviados corretamente para a view 
        foreach ($data as $key => $register) {
            
            $register['htmlConstructorType'] = $type;
            $params['type'] = $type; // tipo de postagem
            $params['id'] = $register['id'];

            $register['avaliacoes'] =  $this->query("SELECT COUNT(id) as likes FROM avaliacoes_posts WHERE id_instituto = :institute: AND id_relatorio = :id: AND tipo = :type:", $params)->getResult('array')[0]['likes'];

            // verificar se está ou não com avaliação e adicionar bool ao array para mudar classe no html de acordo com ele
            $register['avaliadoBool'] = $this->reted($params);

            array_push($array, $register);
        }
        return $array;
    }

    private function reted($params){ # verificar se está avaliado      
        if(session()->get('type') !== null){

            if(session()->get('type') === 'institute'){ // like com user do tipo "instituto"

                if($this->query("SELECT COUNT(id) AS reted FROM avaliacoes_posts WHERE id_instituto = :institute: AND id_relatorio = :id: AND id_beneficiado IS NULL AND tipo = :type:", $params)->getResult('array')[0]['reted'] >= 1){
                    return true;
                }

            }
            else if(session()->get('type') === 'user'){ // like com user do tipo "instituto"
                $params['user_id'] = session()->get('idUser');

                if($this->query("SELECT COUNT(id) AS reted FROM avaliacoes_posts WHERE id_instituto = :institute: AND id_relatorio = :id: AND id_beneficiado = :user_id: AND tipo = :type:", $params)->getResult('array')[0]['reted'] >= 1){
                    return true;
                }
            }
        } 
        return false;
    }
}