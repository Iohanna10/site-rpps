<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class ActuarialModel extends Model {

    protected $table = 'relatorio_e_crps';

    /** Alterar hipóteses */
    public function changeHypotheses($data) {
        if((new Session)->isLogged()){
            foreach ($data as $key => $content) { // caso não tenha nada
                if(trim($content) === ''){
                    $content = NULL;
                }
            }
    
            // dados para inserir na tabela
            $params = [
                'hypotheses' => (new Functions())->changeQuotes($data['hypotheses']),
                'financial_regimes' => (new Functions)->changeQuotes($data['financial_regimes']),
                'id' => session()->get('id')
            ];
    
            if ($this->query("UPDATE instituto_infos SET calc_atuarial = :hypotheses:, regimes_financeiros = :financial_regimes: WHERE id = :id:", $params)){
                return true;
            }
        } 

        return false;
    }

    /** Inserir relatório de cálculo atuarial */
    public function insertReport($data) {
        if((new Session)->isLogged()){
            // dados para inserir na tabela
            $params = [
                'name' => $data['name'],
                'id' => session()->get('id'),
                'date' => $data['date']->format('Y-n-d H:i:s'),
                'title' => (new Functions)->changeQuotes($data['title'])
            ];

            if ($this->query("INSERT INTO relatorio_e_crps VALUES(0, :id:, :title:, :name:, :date:, 0)", $params)){
                return true;
            }
        }

        return false;
    }

    /** Remover relatório de cálculo atuarial */
    function removeReport($data) {
        if((new Session)->isLogged()){
            $params = [
                'id_report' => $data['id_report']
            ];

            $dataDelete = $this->query("SELECT nome, data FROM relatorio_e_crps WHERE id = :id_report:", $params)->getResult('array')[0];
            $Date = new DateTime($dataDelete['data']);

            $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/pdf/actuarial/". $Date->format("Y/n/") . $dataDelete['nome'];

            if ($this->query("DELETE FROM relatorio_e_crps WHERE id = :id_report:", $params)){
                if(file_exists($path)){
                    unlink($path);
                    return true; 
                }
            }
        }

        return false;
    }

    /** Retornar relatórios de cálculo atuarial */
    public function getActuarialData($id, $pg, $fullData = true){
        $qntResultPgs = 10; // quantidade max de registros do db por página

        $params = [
            'institute' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 0", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        if($fullData){
            $dbData = $this->dbData([], $this->query("SELECT id, titulo, nome, data FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 0 ORDER BY data DESC LIMIT :start:, :qntResultPgs:", $params)->getResult("array"), $params, 'relatorios');
        } 
        else {
            $dbData = $this->query("SELECT id, titulo, nome, data FROM relatorio_e_crps WHERE id_instituto = :institute: AND tipo = 0 ORDER BY data DESC LIMIT :start:, :qntResultPgs:", $params)->getResult("array");
        }

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    /** Recebe as informações dos cálculos atuariais e complementa com as avaliações registradas  */
    private function dbData($array, $data, $params, $type) {
        foreach ($data as $key => $register) {
            
            $register['htmlConstructorType'] = $type;
            $params['type'] = $type; // tipo de postagem
            $params['id'] = $register['id'];

            $register['avaliacoes'] =  $this->query("SELECT COUNT(id) as likes FROM avaliacoes_posts WHERE id_instituto = :institute: AND (id_postagem = :id: OR id_reuniao = :id: OR id_relatorio = :id:) AND tipo = :type:", $params)->getResult('array')[0]['likes'];

            // verificar se está ou não com avaliação e adicionar bool ao array para mudar classe no html de acordo com ele
            $register['avaliadoBool'] = $this->rated($params);

            array_push($array, $register);
        }
        return $array;
    }

    /** Avaliar relatório  */
    private function rated($params){        
        if(session()->get('type') !== null){

            if(session()->get('type') === 'institute'){ // like com user do tipo "instituto"

                if($this->query("SELECT COUNT(id) AS rated FROM avaliacoes_posts WHERE id_instituto = :institute: AND (id_postagem = :id: OR id_reuniao = :id: OR id_relatorio = :id:) AND id_beneficiado IS NULL AND tipo = :type:", $params)->getResult('array')[0]['rated'] >= 1){
                    return true;
                }

            }
            else if(session()->get('type') === 'user'){ // like com user do tipo "instituto"
                $params['user_id'] = session()->get('idUser');

                if($this->query("SELECT COUNT(id) AS rated FROM avaliacoes_posts WHERE id_instituto = :institute: AND (id_postagem = :id: OR id_reuniao = :id: OR id_relatorio = :id:) AND id_beneficiado = :user_id: AND tipo = :type:", $params)->getResult('array')[0]['rated'] >= 1){
                    return true;
                }
            }
        } 
        return false;
    }

    /** Retornar hipóteses do insituto  */
    public function getHypotheses($id){
        $params = [
            'institute' => $id, // instituto
        ];

        $dataDB = [
            'calc_atuarial' => $this->query("SELECT calc_atuarial FROM instituto_infos WHERE id = :institute:", $params)->getResult('array')[0]['calc_atuarial'],
            'regimes_financeiros' => $this->query("SELECT regimes_financeiros FROM instituto_infos WHERE id = :institute:", $params)->getResult('array')[0]['regimes_financeiros'],
        ];

        return $dataDB;
    }
    
}