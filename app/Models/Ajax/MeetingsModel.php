<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class MeetingsModel extends Model {

    protected $table = 'reunioes_eventos';

    /** Retornar eventos/reuniões */
    public function getEvents($pg, $filters) { # pegar todas as reuniões
        $qntResultPgs = 10; // quantidade max de registros do bd por página

        $params = [
            'institute' => session()->get('id'),
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
            'id_category' => $filters['id_category']  
        ];
        
        $dbData = $this->query($this->getQuery($filters, 'data'), $params)->getResult("array");
        $dbData = $this->filterDate($dbData, $filters);
        // var_dump($this->getLastQuery()->getQuery());

        // nº total de registros
        $totalRecords = count($dbData);
        $qntPg = ceil($totalRecords / $qntResultPgs); // qunatidade de páginas para a paginação 

        $dbData = array_slice($dbData, $params['start'], $qntResultPgs);  // limitar quantidade de resultados por pg

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg,
        ];

        return $dataArray;
    }

    /** Inserir eventos/reuniões */
    public function insertMeeting($data){ # inserir dados no banco de dados
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            // dados para inserir na tabela
            $params = [
                'institute' => session()->get('id'), // instituto
                'committee' => $data['committee'], // comitê
                'title' => (new Functions)->changeQuotes($data['title']), // título
                'description' => $data['description'], // descrição
                'meetings' => $data['meetings'], // reuniões
                'obs' => (new Functions)->changeQuotes($data['obs']), // observações
                'type' => $data['type'], // tipo
                'date_register' => (new DateTime(''))->format('Y-n-d H:i:s'), // date de registro do evento/reuniões
                'start_meeting' => $data['start_meeting'],
                'end_meeting' => $data['end_meeting'],

                // obs: sempre cadastrados como "null". serão adicionados ao BD na função uploadFiles.
                'img' => null, // imagem principal
            ];
            
            if ($this->query("INSERT INTO reunioes_eventos VALUES(0, :institute:, :committee:, :title:, :description:, :img:, :meetings:, :start_meeting:, :end_meeting:, :type:, :obs:, :date_register:)", $params)){
                return true;
            } 
        }

        return false;
    }

    /** Inserir mídias dos eventos/reuniões */
    public function UpFiles($data) { # inserir nome da imagem principal ao BD 
        $id_query = "SELECT id FROM reunioes_eventos WHERE id_instituto = " . session()->get('id') . " AND tipo = '". $data['type'] ."' ORDER BY data DESC LIMIT 1";

        $params = [
            'name' => $data['name'],
            'id' => $this->query($id_query)->getResult("array")[0]['id']
        ];

        if($this->query("UPDATE reunioes_eventos SET imagem_principal = :name: WHERE id = :id:", $params)){
            return true;
        } 

        // caso não conseguir fazer o upload dos arquivos, excluir o registro do BD
        $this->query("DELETE FROM reunioes_eventos WHERE id = :id:", $params);

        return false;
    }

    /** Retornar evento/reunião */
    public function getMeeting($id) { # pegar dados para tabela de reuniões
        $params = [
            $id['id_meetings'],
        ];

        return ($this->query("
            SELECT titulo, data, reunioes, obs
            FROM reunioes_eventos 
            WHERE id = ?",
            $params
        )->getResultObject()[0]);
    }

    /** Retornar informações dos eventos/reuniões */
    public function getDataEvents($data){ # pegar todos os dados dos eventos/reuniões
        $params = [
            $data['id'],
        ];

        return $this->query("SELECT id_categoria, titulo, descricao, imagem_principal, reunioes, comeco_evento, final_evento, tipo, obs, data FROM reunioes_eventos WHERE id = ?", $params)->getResult('array')[0];
    }

    /** Remover evento/reunião */
    public function removeEvent($data) { # remover evento/reunião
        if((new Session)->isLogged()){
            $params = [
                'id' => $data['id'],
                'id_institute' => session()->get('id')
            ];

            $dataDelete = $this->query("SELECT imagem_principal, data, tipo FROM reunioes_eventos WHERE id = :id:", $params)->getResult('array')[0];
            
            if($dataDelete['tipo'] == 'evento'){
                $type = 'events';
            }
            else {
                $type = 'meetings';
            }

            $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/img/meetings_event/$type/" . (new DateTime($dataDelete['data']))->format('Y/n/');

            if ($this->query("DELETE FROM reunioes_eventos WHERE id = :id: AND id_instituto = :id_institute:", $params)){
                if(!is_null($dataDelete['imagem_principal'])){
                    (new Functions)->deleteFiles([$dataDelete['imagem_principal']], $path);
                }
                return true;
            }
        }

        return false;
    }

    /** Retorna a data e a imagem principal que será excluida */
    public function getDataUpFiles($id){ # seleciona a data e a imagem principal que será excluida 
        $query = "SELECT data, imagem_principal FROM reunioes_eventos WHERE id = $id AND id_instituto = " . session()->get('id');
        
        if($this->query($query)->getResult('array')[0]){
            return $this->query($query)->getResult('array')[0];
        }

        return false;
    }

    /** upload de novas mídias de eventos/reuniões */
    public function uploadNewFiles($data){ # alterar imagem principal do evento/reunião
        $params = [
            'id_institute' => session()->get('id'),
            'main_img' => $data['newNames'],
            'id' => $data['id']
        ];

        $query = "UPDATE reunioes_eventos SET imagem_principal = :main_img: WHERE id = :id: AND id_instituto = :id_institute:";

        if(!$this->query($query, $params)){
            return false;
        };

        return true;
    }

    /** Retornar imagem principal */
    public function getFeatured($data){ # selecionar imagem principal dos eventos/reuniões
        $params = [
            'id' => $data['id'],
            'id_institute' => session()->get('id')
        ];
        
        return $this->query("SELECT imagem_principal FROM reunioes_eventos WHERE id = :id: AND id_instituto = :id_institute:", $params)->getResult('array')[0];
    }

    /** Remover imagem principal */
    public function removeFeaturedMedias($data){ # remover imagem principal
        if((new Session)->isLogged()){
            $params = [
                'id' => $data['id'],
                'id_institute' => session()->get('id')
            ];

            $medias = $this->getFeatured($params); // pegar imagem principal

            if($medias['imagem_principal'] === $data['medias'][0]){
                $query = "UPDATE reunioes_eventos SET imagem_principal = NULL WHERE id = :id: AND id_instituto = :id_institute:";
                $type = 'img';
                
                if($this->query($query, $params)){
                    return ['bool' => 'true', 'type' => $type];
                };
            } 
        }
        return ['bool' => 'false'];
    }

    /** Alterar informações do evento/reunião */
    public function updateEvent($data){ # altarar informações dos eventos/reuniões
        if((new Session)->isLogged()){
            $params = [
                'id' => $data['id'],
                'committee' => $data['committee'],
                'title' => (new Functions)->changeQuotes($data['title']),
                'description' => $data['description'],
                'meetings' => $data['meetings'],
                'obs' => (new Functions)->changeQuotes($data['obs']),
                'start_meeting' => $data['start_meeting'],
                'end_meeting' => $data['end_meeting'],
                'id_institute' => session()->get('id')
            ];

            $query = 'UPDATE reunioes_eventos SET id_categoria = :committee:, titulo = :title:, descricao = :description:, reunioes = :meetings:, comeco_evento = :start_meeting:, final_evento = :end_meeting:, obs = :obs:';

            $query .= ' WHERE id = :id: AND id_instituto = :id_institute:';

            if($this->query($query, $params)){
                return true;
            }
        }
        return false;
    }

    /** Construir a query para o banco de dados */
    private function getQuery($filters, $type){ # adicionar filtros na pesquisa
        $query = 'SELECT id, titulo, tipo, reunioes, comeco_evento, final_evento FROM reunioes_eventos WHERE id_instituto = :institute: ';

        if($filters['name'] !== ''){
            $query .= "AND titulo like '%". $filters['name'] ."%' ";
        }

        if($filters['event'] !== ''){     
            $query .= "AND tipo = '". $filters['event'] ."' ";

            if($filters['id_category'] !== 'null' && $filters['id_category'] !== ''){
                $query .= "AND id_categoria = ". $filters['id_category'] ." ";
            } 
            else if($filters['id_category'] == 'null') {
                $query .= "AND id_categoria IS ". $filters['id_category'] ." ";
            }
        }

        if($type == 'data'){
            $query .= "ORDER BY data ". $filters['order'] ." LIMIT :start:, :qntResultPgs:";
        }

        return $query;
    }

    /** Filtrar os eventos/reunioes pela data */
    private function filterDate($events, $filters) { # filtar reuniões e eventos pela data
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $fullyFiltered = []; // array de eventos totalmente filtrados

        $initial_date = strtotime((new DateTime($filters['initial_date']))->format('Y/m/d')); // data inicial
        $final_date = strtotime((new DateTime($filters['final_date']))->format('Y/m/d')); // data final

        foreach ($events as $key => $event) { // percorrer array de eventos
            // caso for uma reunião
            if($event['tipo'] === 'reuniao'){ 
                $dates = explode(", ", $event['reunioes']);
                
                for ($i=0; $i < count($dates); $i++) { // percorrer todas as datas de reunião 
                    $date = strtotime((new DateTime($dates[$i]))->format('Y/m/d'));
                    
                    if($filters['initial_date'] !== '' && $filters['final_date'] !== ''){
                        if($date >= $initial_date && $date <= $final_date){
                            array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                            break;
                        }
                    }
                    elseif($filters['initial_date'] !== ''){
                        if($date >= $initial_date){
                            array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                            break;
                        }
                    }
                    elseif ($filters['final_date'] !== '') {
                        if($date <= $final_date){
                            array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                            break;
                        }
                    }
                    else {
                        array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                        break;
                    }
                }
            }
            // caso for um evento
            else {
                $startEv = strtotime((new DateTime($event['comeco_evento']))->format('Y/m/d'));
                $endEv = strtotime((new DateTime($event['final_evento']))->format('Y/m/d'));

                if($filters['initial_date'] !== '' && $filters['final_date'] !== ''){
                    if($startEv >= $initial_date && $endEv <= $final_date){
                        array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                    }
                }
                elseif($filters['initial_date'] !== ''){
                    if($startEv >= $initial_date){
                        array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                    }
                }
                elseif ($filters['final_date'] !== '') {
                    if($endEv <= $final_date){
                        array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                    }
                }
                else {
                    array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo']]);
                }
            }
        }

       return $fullyFiltered;
    }

}