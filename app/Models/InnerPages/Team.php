<?php

namespace App\Models\InnerPages;

use CodeIgniter\Model;

class Team extends Model {

    protected $table = 'membros';
    

    function TeamContructor()
	{
		parent::Model();
	}

    public function team(array $routes, int $team){

        $params = [
            $routes['instituteId'],
            $team,
        ];

        return $this->query("
            SELECT nome, numero, email, area_de_atuacao, local_atuacao, titular, certificacao, equipe, foto, ordem
            FROM membros 
            WHERE id_instituto = ? 
            AND equipe = ? 
            AND ativo = 1
            ORDER BY ordem ASC", $params
        )->getResultObject();
    }

    public function getMember($id){
        $params = [
            'id' => $id,
        ];

        $query = "SELECT nome, cpf, numero, email, area_de_atuacao, local_atuacao, titular, certificacao, equipe, foto, ordem FROM membros WHERE id = :id: AND id_instituto =" . session()->get('id');
        return $this->query($query, $params)->getResult('array')[0];
    }
}