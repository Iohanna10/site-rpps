<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\CrpModal;
use App\Models\Functions\Functions;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Certificados de Regularidade Previdenciárias`
*/

class Crp extends BaseController
{
    /** Upload de certificados de regolaridade previdenciário */
    public function uploadFiles() { # upload de arquivos pdf
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $Data = new DateTime;

            // extensões 
            $pdfExtension = ['pdf']; // extensões de fotos

            foreach ($_FILES as $key => $file) 
            {

                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $pdfExtension)){ // pdfs
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/pdf/crp/" . $Data->format('Y/n/');
                } else {
                    return $this->response->setJSON(false);
                }
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true); // criar diretório caso não exista
                }

                $newName = (new Functions)->newName($file['name'], $Data); // novo nome do arquivo

                if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){ // fazer upload do pdf
                    return $this->response->setJSON(false);
                }

            }

            if(!((new CrpModal)->insertCrp(['name' => $newName, 'date' => $Data, 'title' => $_GET['title']]))){
                (new Functions)->deleteFiles([$newName], $path);
                return $this->response->setJSON(false);
            }
        
            return $this->response->setJSON(true);
        }

        return $this->response->setJSON(false);
    }

    /** Remover certificado de regularidade previdenciário */
    public function removeCrp() { # remover crp        
        $data = [
            'id_report' => $this->request->getPost('id_report'),
        ];

        $msg = (new CrpModal)->removeCrp($data); // retorna mensagem se foi possível ou não remover o CRP
        return $this->response->setJSON($msg);
    }
}
