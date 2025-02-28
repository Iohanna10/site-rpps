<?php

namespace App\Models\Ajax;

use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class PollsModel extends Model {

    protected $table = 'avaliacoes';

    // continuar a contextualizar funções daqui
    
    public function totalVotesPoll($data) { # pegar o total de votos de uma determinada coluna no banco de dados
        $params = [
            'institute' => $data['id_institute'], // instituto
            'column' => $this->getColumn($data['id_poll']), // coluna
        ];

        $dataDB = [
            'excellent' => $this->query($this->selectVotesQuery($params['column'], 4), $params)->getResult('array')[0]['numVotes'],
            'good' => $this->query($this->selectVotesQuery($params['column'], 3), $params)->getResult('array')[0]['numVotes'],
            'regular' => $this->query($this->selectVotesQuery($params['column'], 2), $params)->getResult('array')[0]['numVotes'],
            'bad' => $this->query($this->selectVotesQuery($params['column'], 1), $params)->getResult('array')[0]['numVotes'],
            'tooBad' => $this->query($this->selectVotesQuery($params['column'], 0), $params)->getResult('array')[0]['numVotes'],
        ];

        return $dataDB;
    }

    private function selectVotesQuery($column, $rating) { # alterar a variavel "coluna"  e o valor da nota da string
        return str_replace("@column", $column, "SELECT COUNT(id) AS numVotes FROM avaliacoes WHERE id_instituto = :institute: AND @column = $rating");
    }

    public function registerNotePoll($data){ # registrar nota
        if(session()->get('type') === "user"){
            $params = [
                'column' => $this->getColumn($data['id_poll']),
                'note' => $data['note'],
                'idInstitute' => session()->get('idAffiliate'),
                'idUser' => session()->get('idUser')
            ];

            if($this->query($this->insertVoteQuery($params['column']),$params)){
                return true;
            } else {
                return [false, 'msg' => 'Não foi possível registrar seu voto, tente novamente.'];
            }
        } else if(session()->get('type') === "institute") {
            return [false, 'msg' => 'Somente beneficiados podem participar da votação.'];
        } else {
            return  [false, 'msg' => 'Você deve estar cadastrado para poder votar.'];
        }
    }

    public function registerFeedback($data){ # registrar feedback
        // configurações data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        if(session()->get('type') === "user"){
            $params = [
                'feedback' => (new Functions)->changeQuotes(trim($data['feedback'])),
                'idInstitute' => session()->get('idAffiliate'),
                'idUser' => session()->get('idUser'),
                'date' => (new DateTime)->format('Y-n-d H:i:s')
            ];

            if(strlen($params['feedback']) === 0){
                $params['feedback'] = null;
            }

            if($this->query("UPDATE avaliacoes SET depoimento = :feedback: WHERE id_beneficiado = :idUser: AND id_instituto = :idInstitute:", $params)){
                if($params['feedback'] == null){
                    return [true, 'msg' => 'Seu feedback foi removido.'];
                }
                return [true, 'msg' => 'Seu feedback foi enviado.'];
            } else {
                return [false, 'msg' => 'Não foi possível registrar seu feedback, tente novamente.'];
            }
        } else if(session()->get('type') === "institute") {
            return [false, 'msg' => 'Somente beneficiados podem enviar feedback.'];
        } else {
            return  [false, 'msg' => 'Você deve estar cadastrado para poder enviar um feedback.'];
        }
    }

    public function getRatings($id) { # pegar avaliações da enquete e retornar a porcentagem de aprovação de cada um dos tópicos 
        $ratings = [
            'atendimento' => 0,
            'cordialidade' => 0,
            'eficiencia' => 0,
            'espera_atendimento' => 0,
            'clareza' => 0,
            'comunicacao' => 0,
            'acoes_desenvolvidas' => 0,
            'transparencia' => 0,
            'satisfacao' => 0,
            'acessibilidade' => 0,
            'conforto' => 0,
            'horario_atendimento' => 0,
        ];

        foreach ($ratings as $key => $ratingArr) {
            $query = "SELECT " . $key . " FROM avaliacoes WHERE id_instituto = " . $id . " AND ". $key ." IS NOT NULL";
            
            $db_ratings = $this->query($query)->getResult('array');
            // var_dump($this->getLastQuery()->getQuery());

            if(count($db_ratings) > 0){
                $totalRatings = 0;

                foreach ($db_ratings as $key_bd => $rating) {
                    $totalRatings += intval($rating[$key]);
                }

                // porcentagem: somar todos os valores, dividir pela quantidade e arredondar para um número inteiro
                $totalRatings = round((($totalRatings/count($db_ratings))*100)/4);

                $ratings[$key] = $totalRatings;
            }
            else {
                $ratings[$key] = NULL;
            }
        }

        return $ratings;
    }

    public function getFeedbacks($pg, $filters, $institute) { # pegar feedbacks/depoimentos dos beneficiados pelo instituto
        $qntResultPgs = 3; // quantidade max de registros do db por página

        $params = [
            'institute' => $institute,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        if($filters['onlyComments'] == 'true'){
            $dbData = $this->filterRating($this->query("SELECT id_beneficiado, atendimento, cordialidade, eficiencia, espera_atendimento, clareza, comunicacao, acoes_desenvolvidas, transparencia, satisfacao, acessibilidade, conforto, horario_atendimento, depoimento FROM avaliacoes WHERE id_instituto = :institute: AND depoimento IS NOT NULL ORDER BY data DESC", $params)->getResult('array'), $filters);
        } else {
            $dbData = $this->filterRating($this->query("SELECT id_beneficiado, atendimento, cordialidade, eficiencia, espera_atendimento, clareza, comunicacao, acoes_desenvolvidas, transparencia, satisfacao, acessibilidade, conforto, horario_atendimento, depoimento FROM avaliacoes WHERE id_instituto = :institute: ORDER BY data DESC", $params)->getResult('array'), $filters);
        }

        // nº total de registros
        $qntPg = ceil(count($dbData) / $qntResultPgs); // qunatidade de páginas para a paginação 
        $dbData = array_slice($dbData, $params['start'], $qntResultPgs);  // limitar quantidade de resultados por pg
    
        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg,
            'rating' => $filters['rating'],
            'onlyComments' => $filters['onlyComments']
        ];

        return $dataArray;
    }

    private function filterRating($data, $filters){ # filtrar apenas registros com a nota selecionada 
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
    
                if($filters['rating'] != 'false' && $filters['rating'] != 'null'){ // com nota especifica
                    if($filters['rating'] == 3){
                        if(($totalRating / 12) >= $filters['rating'] && ($totalRating / 12) < ($filters['rating'] + 1)){ // notas sem o próprio número
                            array_push($filterData, ['beneficiary' => $beneficiary, 'feedback' => $register['depoimento'], 'rating' => round((($totalRating/12)*100)/4)]);
                        }
                    }
                    else { 
                        if(($totalRating / 12) >= $filters['rating'] && ($totalRating / 12) <= ($filters['rating'] + 1)){ // notas contando o próprio número
                            array_push($filterData, ['beneficiary' => $beneficiary, 'feedback' => $register['depoimento'], 'rating' => round((($totalRating/12)*100)/4)]);
                        }
                    }
                } 
                elseif($filters['rating'] == 'null'){ // sem nota especifica
                    if(($totalRating / 12) == 0){
                        array_push($filterData, ['beneficiary' => $beneficiary, 'feedback' => $register['depoimento'], 'rating' => null]);
                    }
                }
                else {
                    array_push($filterData, ['beneficiary' => $beneficiary, 'feedback' => $register['depoimento'], 'rating' => round((($totalRating/12)*100)/4)]);
                }
            }
        }

        return $filterData;
    }

    private function insertVoteQuery($column) { # alterar a variavel "coluna" da string
        return str_replace("@column", $column, "UPDATE avaliacoes SET @column = :note: WHERE id_beneficiado = :idUser: AND id_instituto = :idInstitute:");
    }

    private function getColumn($id){ # retornar nome da coluna pelo id dela
        $columns = ['atendimento', 'cordialidade', 'eficiencia', 'espera_atendimento', 'clareza', 'comunicacao', 'acoes_desenvolvidas', 'transparencia', 'satisfacao', 'acessibilidade', 'conforto', 'horario_atendimento']; 
        
        return $columns[$id];
    }
}