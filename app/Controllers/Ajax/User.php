<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Mails\SendMails;
use App\Models\Ajax\RecoverModel;
use App\Models\Ajax\UserModel;
use App\Models\Functions\Functions;
use App\Models\Session\SessionModel;

/**
 * Classe de controle das funções de recuperação e registro de `Usuários`
*/

class User extends BaseController
{
    /** Retornar id do instituto */
    private function getInstituteId($institute){ # pegar id do instituto pelo nome
        return (new SessionModel)->getInstituteId($institute);
    }  

    /** Retornar nome do instituto */
    private function getInstituteName($id){ # pegar nome do instituto pelo id
        return (new SessionModel)->getInstituteName($id);
    }  

    /** Enviar dados para o model para registrar o usuário */
    public function register() { # enviar dados de registro do usuário 
        $insertData = new UserModel;
        
        $data = [
            'institute' => $this->getInstituteId($this->request->getPost('institute')),
            'name' => $this->request->getPost('name'),
            'cpf' => $this->request->getPost('cpf'),
            'email' => $this->request->getPost('email'),
            'tel' => $this->request->getPost('tel'),
            'pass' => $this->request->getPost('pass'),
            'birthday' => ['day' => $this->request->getPost('birthday_day'), 'month' => $this->request->getPost('birthday_month'), 'year' => $this->request->getPost('birthday_year')],
            'key' => $insertData->hashPass($this->request->getPost('cpf'))
        ];

        $msg = $insertData->insertUser($data); // retorna uma string e um booleano

        if($msg['bool'] == true){
            
            $data['id'] = $msg['id'];

            // enviar email para a confirmação 
            if((new SendMails)->confirmEmail($data)){
                $msg = ['bool' => true];
            } else {
                $msg = ['msg' => ['bd', 'não foi possivel enviar o email de confirmação'], 'bool' => false];
            }
        }

        return $this->response->setJSON($msg);
    }

    /** Deletar conta do usuário */
    public function deleteAccount() {
        if((new UserModel)->deleteAccount()){
            return $this->response->setJSON(true);
        }
        return $this->response->setJSON(false);
    }

    /** Upload de imagem de perfil */
    public function uploadFiles() { # fazer upload da imagem de perfil
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        // instituto
        $institute = strtolower($_GET['institute']); // pegar instituto pela url

        // estensões 
        $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

        foreach ($_FILES as $key => $file) 
        {
            // verificar e criar diretórios para o arquivo
            if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/user_profile/";
            } 
                
            if (!is_dir($path)) {
                mkdir($path, 0755, true); // caso não existir, criar diretório
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

        if(!((new UserModel)->UpFiles(['name' => $newName, 'id' => $this->getInstituteId($institute)]))){ // inserir nomes no banco de dados
            (new Functions)->deleteFiles([$newName], $path);
            return $this->response->setJSON(false);
        }
        
        return $this->response->setJSON(true);
    }

    /** Alterar imagem de perfil */
    public function changeFiles() { # alterar a foto principal
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        // instituto
        $institute =  strtolower($this->getInstituteName((session()->get('idAffiliate'))));
        $idUser = $_GET['id'];

        // extensões 
        $imgsExtension = ['png', 'jpg', 'jpeg', 'webp']; // extensões de fotos

        
        foreach ($_FILES as $key => $file) 
        {
            // verificar e criar diretórios para o arquivo
            if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/user_profile/";
            } 

            if (!is_dir($path)) {
                mkdir($path, 0755, true); // caso não existir, criar diretório
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

        if(!((new UserModel)->UpFilesChange(['name' => $newName, 'id' => $idUser, 'path' => $path]))){ // inserir nova foto principal 
            (new Functions)->deleteFiles([$newName], $path);
            return $this->response->setJSON(false);
        }
        
        return $this->response->setJSON(true);
    }
 
    /** Alterar informações */
    public function changeInfos() { # pegar novos dados do usuário
        $data = [
            'institute' => $this->getInstituteId($this->request->getPost('institute')),
            'id' => $this->request->getPost('id'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'tel' => $this->request->getPost('tel'),
            'birthday' => ['day' => $this->request->getPost('birthday_day'), 'month' => $this->request->getPost('birthday_month'), 'year' => $this->request->getPost('birthday_year')],
            'pass' => $this->request->getPost('pass'),
            'new_pass' => $this->request->getPost('new_pass'),
        ];

        return $this->response->setJSON((new UserModel)->updateInfos($data));
    }

    /** Recuperar conta */
    public function recoverAccount() { # recuperar conta        
        $data = [
            'institute' => $this->getInstituteId($this->request->getPost('institute')),
            'email' => $this->request->getPost('email'),
        ];

        return $this->response->setJSON((new RecoverModel)->recover($data)); // retorna array de dados
    }

    /** Recuperar o id do usuário que possui a chave indicada */
    public function findKey() { # pegar id do usúario/instituto que possui essa chave
        $data = [
            'key' => $this->request->getPost('key'),
        ];
        return $this->response->setJSON((new RecoverModel)->findKey($data));
    }

    /** Alterar senha */
    public function changePass() { # alterar senha  
        $data = [
            'id' => $this->request->getPost('id'),
            'table' => $this->request->getPost('table'),
            'new_pass' => $this->request->getPost('new_pass'),
        ];
        return $this->response->setJSON((new RecoverModel)->changePass($data)); // retorna booleano e string
    }

    /** Retornar imagem de perfiol do usuário */
    public function getImg() {
        return(new UserModel)->getImg($this->request->getPost('id'));
    }
}
