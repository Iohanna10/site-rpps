<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\MemberModel;
use App\Models\Functions\Functions;
use App\Models\Session\SessionModel;

/**
 * Classe de controle das funções de recuperação e registro de `Membros`
*/

class Member extends BaseController
{
    /** Retornar id do insituto */
    public function getInstituteId($institute) { # pegar id do instituto pelo nome
        return (new SessionModel)->getInstituteId($institute);
    }  

    /** Enviar dados ao model para registrar os integrantes dos conselhos */
    public function register() { # enviar dados de registro do usuário         
        $data = [
            'institute' => session()->get('id'),
            'name' => $this->request->getPost('name'),
            'cpf' => $this->request->getPost('cpf'),
            'email' => $this->request->getPost('email'),
            'tel' => $this->request->getPost('tel'),
            'certification' => $this->request->getPost('certification'),
            'council' => $this->request->getPost('council'),
            'member_position' => $this->request->getPost('member_position'),
            'member_location' => $this->request->getPost('member_location'),
            'holder' => $this->request->getPost('holder'),
        ];

        return $this->response->setJSON((new MemberModel)->insertMember($data)); // mensagem confirmando se foi possível ou não fazer o cadastro
    }

    /** Upload da foto de perfil */
    public function uploadFiles() { # fazer upload da foto de perfil 
        if((new Session)->isLogged()){

            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            $institute = strtolower(session()->get('name')); // instituto
            $council = $_GET['council']; // pegar instituto pela url

            // estensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) 
            {
                // verificar e criar diretórios para o arquivo

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    switch ($council) {
                        case '0':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/team/";
                            break;
                        case '1':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/investment/";
                            break;
                        case '2':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/fiscal/";
                            break;
                        case '3':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/deliberative/";
                            break;
                    }
                    
                    if (!is_dir($path)) {
                        mkdir($path, 0755, true); // caso não exista, criar diretório
                    }
                    
                    $newName = (new Functions)->newName($file['name']); // novo nome do arquivo
                    
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

            if(((new MemberModel)->UpFiles(['name' => $newName, 'council' => $council]))){
                return $this->response->setJSON(true);
            }
            
            (new Functions)->deleteFiles([$newName], $path);
        }
        
        return $this->response->setJSON(false);
    }

    /** Alterar da foto de perfil */
    public function updateFiles() { # alterar a foto de perfil
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            $institute = strtolower(session()->get('name')); // instituto
            $council = $_GET['council']; // pegar instituto pela url
            $name = $_GET['imgName'];

            // estensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) 
            {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    switch ($council) {
                        case '0':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/team/";
                            break;
                        case '1':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/investment/";
                            break;
                        case '2':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/fiscal/";
                            break;
                        case '3':
                            $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/team/committee/deliberative/";
                            break;
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
                }
            }

            if(!((new MemberModel)->updateFiles($newName, $_GET['id']))){
                (new Functions)->deleteFiles([$newName], $path);
                return $this->response->setJSON(false);
            }
                
            (new Functions)->deleteFiles([$name], $path); // excluir a foto de perfil anterior
            return $this->response->setJSON(true);
        }
        return $this->response->setJSON(false);
    }

    /** Alterar a ordem de visualização dos integrantes nas páginas internas correspondentes */
    function updateOrder(){ # alterar a ordem de visúalização dos membros     
        $data = [
            'current_order' => $this->request->getPost('current_order'),
            'team' => $this->request->getPost('team'),
        ];

        return $this->response->setJSON((new MemberModel)->updateOrder($data)); // retorna booleano confirmando se foi possível ou não alterar
    }

    /** Alterar informações dos integrantes */
    public function changeInfos() { # alterar informações dos membros 
        $data = [
            'id' => $this->request->getPost('id'),
            'council' => $this->request->getPost('council'),
            'name' => $this->request->getPost('name'),
            'cpf' => $this->request->getPost('cpf'),
            'email' => $this->request->getPost('email'),
            'tel' => $this->request->getPost('tel'),
            'certificate' => $this->request->getPost('certificate'),
            'member_position' => $this->request->getPost('member_position'),
            'member_location' => $this->request->getPost('member_location'),
            'holder' => $this->request->getPost('holder'),
        ];

        return $this->response->setJSON((new MemberModel)->changeInfos($data)); // retorna mensagem informando se foi possível ou não alterar informações
    }

    /** Remover integrantes */
    public function removeMember() { # remover membro   
        $data = [
            'id' => $this->request->getPost('id'),
            'council' => $this->request->getPost('council'),
        ];

        return $this->response->setJSON((new MemberModel)->removeMember($data)); // retorna mensagem booleana informando se foi possível ou não remover
    }

    /** Retornar foto do integrante */
    public function getImg() {
        return(new MemberModel)->getImg($this->request->getPost('id'));
    }
}
