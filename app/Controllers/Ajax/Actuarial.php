<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\ActuarialModel;
use App\Models\Functions\Functions;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Cálculo Atuarial`
*/

class Actuarial extends BaseController
{   
    /** Alterar hipóteses */
    public function changeHypotheses() { # alterar hipóteses de cálculo
        $data = [
            'hypotheses' => $this->request->getPost('hypotheses'),
            'financial_regimes' => $this->request->getPost('financial_regimes'),
        ];

        $msg = (new ActuarialModel)->changeHypotheses($data);
        return $this->response->setJSON($msg);
    }

    /** Upload de PDF's de relatórios de cálculo atuarial */
    public function uploadFiles() { # upload de pdfs
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $Date = new DateTime;

            // extensões 
            $pdfExtension = ['pdf']; // extensões de arquivo

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $pdfExtension)){ // pdf
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/pdf/actuarial/" . $Date->format('Y/n/');
                } else {
                    return $this->response->setJSON(false);
                }
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true); // criar diretório caso não exista
                }
                
                $newName = (new Functions)->newName($file['name']); // novo nome do arquivo

                if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){
                    return $this->response->setJSON(false);
                }
            }

            if((new ActuarialModel)->insertReport(['name' => $newName, 'date' => $Date, 'title' => $_GET['title']])) { // verificar se foi possivel inserir no db 
                return $this->response->setJSON(true);
            }
            
            (new Functions)->deleteFiles([$newName], $path); // caso não, remover da pasta em que se encontra o arquivo upado 
        }

        return $this->response->setJSON(false);
    }

    /** Remover relatório */
    public function removeReport() { # remover relatório        
        $data = [
            'id_report' => $this->request->getPost('id_report'),
        ];

        $msg = (new ActuarialModel)->removeReport($data); // retorna mensagem se o arquivo foi ou não removido
        return $this->response->setJSON($msg);
    }
}
