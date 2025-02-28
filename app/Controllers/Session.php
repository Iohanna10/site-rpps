<?php

namespace App\Controllers;

use App\Models\Session\SessionModel;
use App\Models\Session\SessionUserModel;
use App\Controllers\BaseController;
use App\Controllers\Mails\SendMails;

/**
 * Classe de controle das funções de recuperação de dados do instituto
*/

class Session extends BaseController
{
    public function getInstituteId($institute){
        return (new SessionModel)->getInstituteId($institute);
    } 

    public function registeredAtTheInstitute($institute) {
        if($this->isLogged() || $this->isLoggedUser()){
            if(session()->get('type') == 'institute'){ // verificar se está logado como instituto em outro instituto
                if($institute != session()->get('id')){
                    $this->logout();
                    return false;
                }
            } 
            else if (session()->get('type') == 'user'){ // verificar se está logado como usuário de outro instituto
                if($institute != session()->get('idAffiliate')){
                    $this->logout();
                    return false;
                }
            }
        }

        return true;
    }

    public function isLogged(){
        if(session()->get('id') != null){
            return true;
        }
   
        return false;
    }

    public function isLoggedUser(){
        if(session()->get('idUser') != null){
            return true;
        }
   
        return false;
    }

    public function redirectTo(String $route){
        require("config/content-config.php"); 
        return redirect()->to(base_url("$url/$route"));
    }

    public function loginInstitute()
    {
        session()->destroy();

        $success = false;
        $dataSession = new SessionModel;
        
        $data = [
            'cnpj' => $this->request->getPost('id'),
        ];  

        $dbData = $dataSession->accessInstitute($data);
        
        if($dbData != null){
            
            $pass = ['password' => $this->request->getPost('pass')];
            $pass = implode('', $pass);
            
            if(password_verify($pass, $dbData->{'senha'})){

                session()->start();

                $session = [
                    'type' => 'institute',
                    'id' => $dbData->{'id'},
                    'name' => $dbData->{'nome'},
                ];

                session()->set($session);

                $success = true;
                return $this->response->setJSON(['success' => $success, 'msg' => NULL]);
            }
        } 

        return $this->response->setJSON(['success' => $success, 'msg' => NULL]);
    }

    public function loginBeneficiary()
    {
        session()->destroy();

        $success = false;
        $dataSession = new SessionUserModel;
        
        $data = [
            'cpf-name' => $this->request->getPost('id'),
            'institute' => $this->getInstituteId($this->request->getPost('institute')),
        ];

        $dbData = $dataSession->accessBeneficiary($data);

        if($dbData['bool'] == true){
            $pass = ['password' => $this->request->getPost('pass')];
            $pass = implode('', $pass);

            if(password_verify($pass, $dbData['data']->{'senha'})){
                $success = $this->setSessionUser($dbData['data']);

                return $this->response->setJSON(['success' => $success, 'msg' => NULL]);
            } 
        } 

        else if ($dbData['bool'] == false && $dbData['data'] != NULL){
            
            $params = [
                'institute' => $dbData['data']->{'id_instituto'}, // instituto
                'name' => $dbData['data']->{'nome'}, // nome
                'email' => $dbData['data']->{'email'}, // email
                'tel' => $dbData['data']->{'telefone'}, // tel
                'key' => $dbData['data']->{'codigos_verificacao'},
                'id' => $dbData['data']->{'id'},
                'cpf' => $dbData['data']->{'cpf'}
            ];
            
            $send = new SendMails;
            $isSend = $send->confirmEmail($params);
            
            if($isSend != false){
                $msg = "Este Email ainda não foi confirmado. Nós enviamos um link de confirmação para " .$params['email']. ", por favor verifique tanto sua caixa de entrada quanto spam.";
            } else {
                $msg = "Algo deu errado, tente novamente.";
            }

            return $this->response->setJSON(['success' => $success, 'msg' => $msg]);
        }
        
        return $this->response->setJSON(['success' => $success, 'msg' => NULL]);
    }

    public function setSessionUser($dbData) {
        session()->start();

        $session = [
            'type' => 'user',
            'idAffiliate' => $dbData->{'id_instituto'},
            'idUser' => $dbData->{'id'},
            'name' => $dbData->{'nome'},
            'photo' => $dbData->{'foto'},
            'date' => $dbData->{'data_nascimento'},
            'email' => $dbData->{'email'},
            'tel' => $dbData->{'telefone'},
        ];

        session()->set($session);
        
        return true;
    }

    public function setSessionInstitute($nome) {
        session()->start();

        $session = [
            'name' => $nome
        ];

        session()->set($session);
    }

    public function logout()
    {        
        session()->destroy();

        require("config/content-config.php");
        return redirect()->to(base_url($url));
    }

    // pegar rotas da url

    public function currentInstitute($currentpg){
        // pegar endereço pela url

        $currentInstitute = $currentpg->request->getUri();

        $routes = [
            // instituto
            'instituteId' => $this->getInstituteId(($currentInstitute->getSegment(1))),
            'institute' => $currentInstitute->getSegment(1),
        ];

        for ($i=2; $i <= $currentInstitute->getTotalSegments(); $i++) { 
            
            // rota principal
            if($i < $currentInstitute->getTotalSegments()) {
                $routes['sub' . ($i - 1)] = $currentInstitute->getSegment($i);
            }
            // rota atual
            if($i = $currentInstitute->getTotalSegments()) {
                $routes['current'] = $currentInstitute->getSegment($i);
            }

        }

        return $routes;
    }

    public function dataInstitute($id, $tables, $columns){
        $data = [
            'instituteId' => $id,
            'getInfos' => $tables,
            'columns' => $columns
        ];

        return (new SessionModel)->dataInstitute($data);
    }

    public function getIndexInstitute() {
        require("config/content-config.php");
        return $url;
    }

    public function ajaxIslogged() {
        return $this->response->setJSON($this->isLogged());
    }

    public function validInstitute($urlVerify, $connectedIn = 'institute', $beConnected = false) {
        if($this->currentInstitute($urlVerify)['instituteId'] === false){
            return $this->redirectTo("../instituto-sem-cadastro?url=" . $urlVerify->request->getUri());
        };

        if(!(new Session)->isLogged() && $beConnected && $connectedIn === 'institute'){
            return (new Session)->redirectTo("login");
        }

        if(!(new Session)->isLoggedUser() && $beConnected && $connectedIn === 'user'){
            return (new Session)->redirectTo("login");
        }

        if(!$this->registeredAtTheInstitute($this->currentInstitute($urlVerify)['instituteId'])){
            return $this->redirectTo("");
        };

        return true;
    }
}
