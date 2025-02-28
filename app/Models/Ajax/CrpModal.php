<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class CrpModal extends Model {

    protected $table = 'relatorio_e_crps';

    /** Inserir certificado de regularidade previdenciária  */
    public function insertCrp($data) {
        if((new Session)->isLogged()){
        // dados para inserir na tabela
            $params = [
                'name' => $data['name'],
                'id' => session()->get('id'),
                'date' => $data['date']->format('Y-n-d H:i:s'),
                'title' => (new Functions)->changeQuotes($data['title'])
            ];

            if ($this->query("INSERT INTO relatorio_e_crps VALUES(0, :id:, :title:, :name:, :date:, 1)", $params)){
                return true;
            }
        }

        return false;
    }

    /** Remover certificado de regularidade previdenciária  */
    function removeCrp($data) {
        if((new Session)->isLogged()){
            $params = [
                'id_report' => $data['id_report']
            ];

            $dataDelete = $this->query("SELECT nome, data FROM relatorio_e_crps WHERE id = :id_report:", $params)->getResult('array')[0];
            $Date = new DateTime($dataDelete['data']);

            $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/pdf/crp/". $Date->format("Y/n/");

            if ($this->query("DELETE FROM relatorio_e_crps WHERE id = :id_report:", $params)){
                (new Functions)->deleteFiles([$dataDelete['nome']], $path);
                return true;
            }
        }

        return false;
    }

    /** Retornar certificados de regularidade previdenciária  */
    public function getCrpData($id, $pg){
        $qntResultPgs = 10; // quantidade max de registros do db por página

        $params = [
            'institute' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 1", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        $dbData = $this->query("SELECT id, titulo, nome, data FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 1 ORDER BY data DESC LIMIT :start:, :qntResultPgs:", $params)->getResult("array");

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }
}