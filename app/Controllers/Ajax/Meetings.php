<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\MeetingsModel;
use App\Models\Functions\Functions;
use App\Models\Session\SessionModel;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Reuniões`
*/

class Meetings extends BaseController
{
    /** Retornar id do instituto */
    private function getInstituteId($institute) { # retorna o id do instituto
        return (new SessionModel)->getInstituteId($institute);
    }   

    /** Enviar dados ao Model para registrar galeria no banco de dados */
    public function insertData() { # enviar dados para serem inseridos no banco de dados    
        $data = [
            'institute' => $this->getInstituteId($this->request->getPost('institute')),
            'committee' => $this->request->getPost('committee'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'meetings' => $this->request->getPost('meetings'),
            'obs' => $this->request->getPost('obs'),
            'type' => $this->request->getPost('type_post'),
            'start_meeting' => $this->request->getPost('start_meeting'),
            'end_meeting' => $this->request->getPost('end_meeting'),
        ];

        if(isset($data['start_meeting']) && isset($data['end_meeting'])){
            $params['start_meeting'] = (new DateTime($data['start_meeting']))->format('Y-n-d H:i:s'); // início evento
            $params['end_meeting'] = (new DateTime($data['end_meeting']))->format('Y-n-d H:i:s');  // fim evento
        }

        return $this->response->setJSON((new MeetingsModel)->insertMeeting($data)); // retorna resposta booleana
    }

    /** Upload de mídias dos eventos/reuniões */
    public function uploadFiles() { # fazer upload da imagem principal dos eventos/reuniões
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            $Data = new DateTime;

            // instituto
            $institute = strtolower(session()->get('name'));
            $type = $_GET['type'];

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) {
                
                // verificar arquivos
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    if($type == 'evento') {
                        $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/meetings_event/events/" . $Data->format('Y/n/');
                    }
                    else if($type == 'reuniao') {
                        $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/meetings_event/meetings/" . $Data->format('Y/n/');
                    }
                    
                    if (!is_dir($path)) {
                        mkdir($path, 0755, true); // caso não exista, criar diretórios para os arquivos
                    }

                    // novo nome do arquivo
                    $newName = (new Functions)->newName($file['name'], $Data);

                    try {
                        \Config\Services::image('gd')
                        ->withFile($file['tmp_name'])
                        ->resize(800, 800, true) // redimencionar 
                        ->save($path.$newName, 100); // salvar com 100% da qualidade  
                    }
                    catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                        return $this->response->setJSON(false);
                    }    
                } 
                else {
                    return $this->response->setJSON(false);
                }
            }

            if((new MeetingsModel)->UpFiles(['name' => $newName, 'type' => $type])){
                return $this->response->setJSON(true);
            }
            (new Functions)->deleteFiles([$newName], $path);
        }
        
        return $this->response->setJSON(false);
    }

    /** Retorna dados dos eventos/reuniões */
    public function getData() { # pegar informações das reuniões para a tabela de horários das publicações
        $data = [
            'id_meetings' => $this->request->getPost('id_meetings'),
        ];

        $dataPost = (new MeetingsModel)->getMeeting($data);
        return $this->response->setJSON($dataPost);
    }

    /** remover eventos/reuniões */
    public function removeEvent() { # remover o evento/reunião
        $data = [
            'id' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new MeetingsModel)->removeEvent($data)); // retorna booleano informando se foi possivel ou não remover
    }

    /** Retornar imagem principal dos eventos/reuniões */
    public function getFeatured() { # selecionar imagem principal dos eventos/reuniões
        $data = [
            'id' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new MeetingsModel)->getFeatured($data));
    }

    /** Remover mídias dos eventos/reuniões */
    public function removeFiles() { # remover imagem principal
        // configurações data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        // dados recebidos pelo ajax
        $data = [
            'medias' => $this->request->getPost('medias'),
            'id' => $this->request->getPost('id'),
            'type' => $this->request->getPost('type'),
        ];

        $response = (new MeetingsModel)->removeFeaturedMedias($data); // retorna o booleano e o tipo
        if(!$response['bool']){
            return $this->response->setJSON(false);
        }

        // dados do bd
        $dataEvent = (new MeetingsModel)->getDataUpFiles($data['id']); // seleciona a data e a imagem principal que será excluida 
        $Data = new DateTime($dataEvent['data']); // data de publicação

        // dados de sessão
        $institute = strtolower(session()->get("name"));

        // caminhos de arquivo
        $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/meetings_event/" . $data['type'] . "/" . $Data->format('Y/n/');

        (new Functions)->deleteFiles($data['medias'], $path);

        return $this->response->setJSON($response);
    }

    /** Upload de novas mídias para as reuniões/eventos */
    public function uploadNewFiles(){ # adicinar nova imagem principal para as reuniões/eventos
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            // dados
            $Data = new DateTime((new MeetingsModel)->getDataUpFiles($_GET['id'])['data']); // data de publicação 
            $type = $_GET['type'];
            $newNames = [];

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get("name")) ."/assets/uploads/img/meetings_event/$type/" . $Data->format('Y/n/');
                } 
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true); // caso não exista, criar diretório
                }

                // novo nome do arquivo
                $newName = (new Functions)->newName($file['name']);

                try {
                    \Config\Services::image('gd')
                    ->withFile($file['tmp_name'])
                    ->resize(800, 800, true) // redimencionar 
                    ->save($path.$newName, 100); // salvar com 100% da qualidade  
                }
                catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                    return $this->response->setJSON(false);
                }    

                array_push($newNames, $newName);
            }

        
            $oldFile = (new MeetingsModel)->getDataUpFiles($_GET['id'])['imagem_principal']; // pegar imagem antiga para remover
            if($oldFile !== NULL) {
                (new Functions)->deleteFiles([$oldFile], $path); // deletar imagem antiga
            }

            if((new MeetingsModel)->uploadNewFiles(['newNames' => implode(', ', $newNames), 'type' => $type, 'id' => $_GET['id']])){
                return $this->response->setJSON(true);
            }
            
            (new Functions)->deleteFiles($newNames, $path);
        }
        return $this->response->setJSON(false);
    }

    /** Alterar informações de eventos/reuniões */
    public function updateEvent() { # alterar informações dos eventos/reuniões
        $data = [
            'id' => $this->request->getPost('id'),
            'committee' => $this->request->getPost('committee'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'meetings' => $this->request->getPost('meetings'),
            'obs' => $this->request->getPost('obs'),
            'start_meeting' => $this->request->getPost('start_meeting'),
            'end_meeting' => $this->request->getPost('end_meeting'),
        ];

        if(isset($data['start_meeting']) && isset($data['end_meeting'])){
            $params['start_meeting'] = (new DateTime($data['start_meeting']))->format('Y-n-d H:i:s'); // início evento
            $params['end_meeting'] = (new DateTime($data['end_meeting']))->format('Y-n-d H:i:s');  // fim evento
        }

        return $this->response->setJSON((new MeetingsModel)->updateEvent($data)); // retorna um booleano confirmando ou não a alteração
    }
}
