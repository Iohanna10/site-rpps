<?php

namespace App\Models\Session;

use App\Models\Ajax\UserModel;
use CodeIgniter\Model;

class SessionUserModel extends Model {

    protected $table = 'beneficiados';

    public function accessBeneficiary($dataLogin) {

        $params = [
            'cpf-name' => $dataLogin['cpf-name'],
            'institute' => $dataLogin['institute'],
        ];

        if($this->query("SELECT COUNT('id') AS exist FROM beneficiados WHERE nome = :cpf-name: AND id_instituto = :institute: AND ativo = 1 OR cpf = :cpf-name: AND id_instituto = :institute: AND ativo = 1", $params)->getResultObject()[0]->{'exist'} == 1)
        {
            $data = $this->query("
                SELECT *
                FROM beneficiados 
                WHERE nome = :cpf-name: AND id_instituto = :institute: AND ativo = 1 OR cpf = :cpf-name: AND id_instituto = :institute: AND ativo = 1", $params
            )->getResultObject()[0];

            return ['bool' => true, 'data' => $data];
        } 
        else if($this->query("SELECT COUNT('id') AS exist FROM beneficiados WHERE nome = :cpf-name: AND id_instituto = :institute: AND ativo = 0 OR cpf = :cpf-name: AND id_instituto = :institute: AND ativo = 0", $params)->getResultObject()[0]->{'exist'} == 1) 
        {

            $data = $this->query("
                SELECT *
                FROM beneficiados 
                WHERE nome = :cpf-name: AND id_instituto = :institute: OR cpf = :cpf-name: AND id_instituto = :institute:", $params
            )->getResultObject()[0];

            return ['bool' => false, 'data' => $data];
        }

        return ['bool' => false, 'data' => NULL];
    }

    public function accessBeneficiaryForId($id) {

        $params = [
            $id,
        ];

        $data = $this->query("
            SELECT *
            FROM beneficiados 
            WHERE id = ?", $params
        )->getResultObject();

        return $data[0];
    }

    public function updateKey($data){
        $params = [
            'key' => (new UserModel)->hashPass($data['cpf']),
            'id' => $data['id']
        ];

        if($this->query("UPDATE beneficiados SET codigos_verificacao = :key: WHERE id=:id: LIMIT 1", $params)){
            return $params['key'];
        } 
        return false;
    }

    public function isValidKey($key) {
        $params = [
            'key' => $key
        ];

        return $this->query('SELECT COUNT(0) as exist_key FROM beneficiados WHERE codigos_verificacao = :key:', $params)->getResult('array')[0]['exist_key'] == 1;
    }
}