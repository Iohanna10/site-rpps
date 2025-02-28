<?php

namespace App\Models\Home;

use CodeIgniter\Model;
use DateTime;

class Events extends Model {

    protected $table = 'events';

    /**
     * Pegar todos os eventos/reuniões do mês atual do calendário.
     * @param int $id Id do instituto.
     * @param string $date Data atual do calendário.
    */
    Public function allEvents($id, $date){ 
        $params = [
            'id' => $id,
            'month'=> $date
        ];
        
        $data = [
            'events' => null,
            'month' => $date,
        ];

        $query = 'SELECT id, titulo, tipo, reunioes, comeco_evento, final_evento FROM reunioes_eventos WHERE id_instituto = :id:';

        $dbData = $this->query($query, $params)->getResult("array");
        $dbData = $this->eventsMonth($dbData, $date);

        if(count($dbData) > 0){
            $data['events'] = $dbData;
        }

        return $data;
    }

    /**
     * Pegar todos os eventos/reuniões e filtrar pela data.
     * @param array $data Dados para busca e filtragem no BD.
     * @param int $data['id'] ID do instituto.
     * @param string $data['date'] Data para filtrar eventos.
     * @return array Eventos do dia selecionado guardados no BD.
    */
    public function getAllEventsDay($data) {
        $params = [
            'institute' => $data['id'],
            'date' => $data['date']
        ];
        
        $query = 'SELECT id, titulo, tipo, reunioes, comeco_evento, final_evento FROM reunioes_eventos WHERE id_instituto = :institute:';

        $dbData = $this->query($query, $params)->getResult("array");
        $dbData = $this->filterDate($dbData, $data); // filtrar data 

        return $dbData;
    }

    /**
     * Pegar informações do evento/reunião selecionado ao clicar no modal.
     * @param array $data Dados para recuperar o evento no BD.
     * @param int $data['id_institute'] Id do Instituto.
     * @param int $data['id'] Id do evento.
     * @param string $data['date'] Data do evento.
     * 
    */
    public function getInfoEvent($data){ 
        $params = [
            'institute' => $data['id_institute'],
            'id' => $data['id'],
        ];

        if($this->query('SELECT COUNT(0) as event FROM reunioes_eventos WHERE id = :id: AND id_instituto = :institute:', $params)->getResult("array")[0]['event'] == 1){
            $dbData = $this->query('SELECT id_categoria, imagem_principal, titulo, descricao, tipo, reunioes, comeco_evento, final_evento, obs, data  FROM reunioes_eventos WHERE id = :id: AND id_instituto = :institute:', $params)->getResult("array")[0];

            if(isset($dbData['reunioes'])){
                foreach (explode(', ', $dbData['reunioes']) as $key => $meeting) {
                    $dateMeeting = (new DateTime($meeting))->format("Y-m-d");

                    if(strtotime($dateMeeting) == strtotime($data['date'])){
                        $dbData['comeco_evento'] = $meeting;
                        $dbData['num_reuniao'] = $key + 1;
                    }
                }
            }
        }

        return $dbData;
    }

    /** 
     * Filtrar eventos/reuniões pela data
     * @param array $events Eventos para serem filtrados 
     * @param array $filters Filtros: `date` - data de filtragem
     * @return array Eventos filtrados
    */
    private function filterDate($events, $filters) {  
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $fullyFiltered = []; // array de eventos totalmente filtrados

        $initial_date = strtotime((new DateTime($filters['date']))->format('Y/m/d')); // data inicial

        foreach ($events as $key => $event) { // percorrer array de eventos
            // caso for uma reunião
            if($event['tipo'] === 'reuniao'){ 
                $dates = explode(", ", $event['reunioes']);
                
                for ($i=0; $i < count($dates); $i++) { // percorrer todas as datas de reunião 
                    $date = strtotime((new DateTime($dates[$i]))->format('Y/m/d'));
                    
                    if($date == $initial_date){
                        array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo'], 'date' => date('Y-m-d', $initial_date)]);
                        break;
                    }
                }
            }
            // caso for um evento
            else {
                $startEv = strtotime((new DateTime($event['comeco_evento']))->format('Y/m/d'));
               
                if($startEv == $initial_date){
                    array_push($fullyFiltered, ['id' => $event['id'], 'titulo' => $event['titulo'], 'date' => date('Y-m-d', $initial_date)]);
                }
            }
        }

       return $fullyFiltered;
    }

    /** 
     * Filtrar eventos/reuniões pelo mês selecionado
     * @param array $events Eventos para serem filtrados 
     * @param array $filters Filtros: `date` - data de filtragem
     * @return array Eventos filtrados
    */
    private function eventsMonth($events, $date) { # filtrar eventos/reuniões do mês 
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $fullyFiltered = []; // array de eventos totalmente filtrados

        $initial_date = strtotime((new DateTime($date))->format('Y/m/d')); // data inicial
        $final_date = strtotime("+1 month", $initial_date); // data final

        foreach ($events as $key => $event) { // percorrer array de eventos
            // caso for uma reunião
            if($event['tipo'] === 'reuniao'){ 
                $dates = explode(", ", $event['reunioes']);
                
                for ($i=0; $i < count($dates); $i++) { // percorrer todas as datas de reunião 
                    $date = strtotime((new DateTime($dates[$i]))->format('Y/m/d'));
                    
               
                    if($date >= $initial_date && $date <= $final_date){
                        array_push($fullyFiltered, date('Y-m-d', $date));
                        break;
                    }
                }
            }
            // caso for um evento
            else {
                $startEv = strtotime((new DateTime($event['comeco_evento']))->format('Y/m/d'));

                if($startEv >= $initial_date && $startEv <= $final_date){
                    array_push($fullyFiltered, $event['comeco_evento']);
                }
            }
        }

        return $fullyFiltered;
    }
}