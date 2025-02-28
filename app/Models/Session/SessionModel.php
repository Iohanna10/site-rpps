<?php

namespace App\Models\Session;

use CodeIgniter\Model;

class SessionModel extends Model {

    protected $table = 'instituto';

    public function getInstituteId($institute) { // retorna o id pelo nome do instituto
        if($this->query("SELECT `id` FROM instituto WHERE nome = ?", $institute)->getResult('array')){
            $id = $this->query("SELECT `id` FROM instituto WHERE nome = ?", $institute)->getResult('array')[0];
    
            if(count($id) > 0){
                return $id['id'];
            }
        }

        return false;
    }

    public function getInstituteName($institute) { // retorna o nome pelo id do instituto

        $id = $this->query("
            SELECT nome
            FROM instituto 
            WHERE id = ?", $institute
        )->getResultObject();

        return $id[0]->{'nome'};
    }

    public function accessInstitute($dataLogin) {

        $params = [
            $dataLogin['cnpj'],
        ];

        $data = $this->query("
            SELECT id, nome, senha
            FROM instituto 
            WHERE cnpj = ?", $params
        )->getResultObject();

        if($data != null){
            return $data[0];
        }

        return NULL;
    }

    public function accessInstituteForId($id){
        $data = $this->query("
            SELECT id, nome, senha
            FROM instituto 
            WHERE cnpj = ?", $id
        )->getResultObject();

        return $data[0];
    }
    
    public function dataInstitute($data) {
        $params = [
            'id' => $data['instituteId'],
        ];

        $arrData = [];

        foreach ($data['getInfos'] as $key => $table) {
            $dbData = $this->query($this->prepareQuery($table, $data['columns'][$table]), $params)->getResult("array")[0];
            $arrData[$table] = $dbData;
        }

        if(isset($arrData['contatos']['telefones'])){
            $tels = explode(', ', $arrData['contatos']['telefones']); // pega valores

            $arrData['contatos']['tel'] = $tels[0];
            $arrData['contatos']['fix_tel'] = $tels[1];

            unset($arrData['contatos']["telefones"]); // remove do array a junção dos telefones
        }
        
        return $arrData;
    }

    private function prepareQuery($table, $columns){
        $columns =  str_replace(['endereco', 'horario_func'], ['rua, numero, bairro, cidade, estado, cep', 'hr_inicio, hr_fim, dia_inicio, dia_fim'], implode(', ', $columns));

        if($table === 'instituto'){
            return str_replace(["@table", '@columns'], [$table, $columns], "SELECT @columns FROM @table WHERE id = :id:");
        } 
    
        return str_replace(["@table", '@columns'], [$table, $columns], "SELECT @columns FROM instituto_@table WHERE id = :id:");
    }
}