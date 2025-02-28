<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\InstituteModel;
use App\Models\Functions\Functions;

/**
 * Classe de controle das funções de recuperação e registro do `Instituto`
*/

class Institute extends BaseController
{ 
    /** Upload de arquivos (logo do instituto, logo de parceiros)  */
    public function upNewFiles() {
        if((new Session)->isLogged()){
            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos
            $type = $_GET['type'];
            $newNames = [];

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)) { // imagens
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/logos/$type/";
                } 
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

                if($type === 'own') {
                    if(file_exists($path . "logo.png")){
                        (new Functions)->deleteFiles(["logo.png"], $path);
                    }

                    // novo nome do arquivo
                    $newName = 'logo.png';
                
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
                    // novo nome do arquivo
                    $newName = (new Functions)->newName($file['name']);

                    try {
                        \Config\Services::image('gd')
                        ->withFile($file['tmp_name'])
                        ->resize(800, 800, true) // redimencionar 
                        ->save($path.$newName, 100); // salvar com 100% da qualidade 
                    }
                    catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                        (new Functions)->deleteFiles($newNames, $path);
                        return $this->response->setJSON(false);
                    }  

                    array_push($newNames, $newName);
                }
            }

            if($type === 'partners') {
                if(!(new InstituteModel)->upNewFiles(['newNames' => implode(', ', $newNames)])){
                    (new Functions)->deleteFiles($newNames, $path);
                    return $this->response->setJSON(false);
                }
            }
            return $this->response->setJSON(true);
        }
        
        return $this->response->setJSON(false);
    }

    /** Alterar a ordem de visualização das logos de parceiros */
    public function updateOrder() {
        $data = [
            'order' => $this->request->getPost('current_order')
        ];

        $data = (new InstituteModel)->updateOrder($data);
        return $this->response->setJSON($data);
    }

    /** Remover arquivos */
    public function removeFiles() {
        // dados recebidos pelo ajax
        $data = [
            'logos' => $this->request->getPost('logos'),
        ];

        if(!(new InstituteModel())->removeFiles($data)){
            return $this->response->setJSON(false);
        }

        // caminhos de arquivo
        $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get("name")) . "/assets/uploads/img/logos/partners/";
        (new Functions)->deleteFiles($data['logos'], $path); // remover itens

        return $this->response->setJSON(true);
    }

    /** Alterar informações do instituto */
    public function changeInfos() { // pegar novos dados  do instituto 
        $data = [
            'last_name_institute' => $this->request->getPost('institute'),
            'name' => $this->request->getPost('name'),
            'cep' => $this->request->getPost('cep'),
            'street' => $this->request->getPost('street'),
            'num' => $this->request->getPost('num'),
            'neighborhood' => $this->request->getPost('neighborhood'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'start_day' => $this->request->getPost('start_day'),
            'end_day' => $this->request->getPost('end_day'),
            'opening_hours' => $this->request->getPost('opening_hours'),
            'closing_time' => $this->request->getPost('closing_time'),
            'instagram' => $this->request->getPost('instagram'),
            'facebook' => $this->request->getPost('facebook'),
            'youtube' => $this->request->getPost('youtube'),
            'twitter' => $this->request->getPost('twitter'),
            'tel' => preg_replace("/[^0-9]/", "", $this->request->getPost('tel')),
            'fix_tel' => preg_replace("/[^0-9]/", "", $this->request->getPost('fix_tel')),
            'about' => $this->request->getPost('about'),
            'email' => $this->request->getPost('email'),
            'mission' => $this->request->getPost('mission'),
            'vision' => $this->request->getPost('vision'),
            'values' => $this->request->getPost('values'),
            'investment_policy' => $this->request->getPost('investment_policy'),
            'investment_committee' => $this->request->getPost('investment_committee'),
            'alm' => $this->request->getPost('alm'),
            'transparency' => $this->request->getPost('transparency'),
            'ombudsman' => $this->request->getPost('ombudsman'),
            'official_diary' => $this->request->getPost('official_diary'),
            'government_portal' => $this->request->getPost('government_portal'),
            'payment_schedule' => $this->request->getPost('payment_schedule'),
            'social_security_legislation' => $this->request->getPost('social_security_legislation'),
            'payroll' => $this->request->getPost('payroll'),
            'pass' => $this->request->getPost('pass'),
            'new_pass' => $this->request->getPost('new_pass'),
        ];

        return $this->response->setJSON((new InstituteModel)->updateInfos($data)); // retornar resposta 
    }
}
