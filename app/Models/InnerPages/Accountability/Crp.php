<?php

namespace App\Models\InnerPages\Accountability;

use CodeIgniter\Model;

class Crp extends Model {

    protected $table = 'relatorio_e_crps';

    Public function getCrps($id, $limited) { # pegar CRPS
        $params = [
            'institute' => $id,
        ];

        $queryCrps = 'SELECT id, nome, titulo, data FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 1 ORDER BY data DESC'; 

        if($limited){
            $queryCrps .= ' LIMIT 4';
            $dataDB['numCrps'] = $this->query("SELECT COUNT(id) as num FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 1", $params)->getResult('array')[0]['num'];
        } 
        
        $dataDB['crps'] = $this->query($queryCrps, $params)->getResult('array');
        
        return $dataDB;
    }
}