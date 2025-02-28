<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\ThemesModel;
use App\Models\Functions\Functions;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Temas/Customizações`
*/

class Themes extends BaseController
{ 
    /** Retornar id do instituto */
    private function getCurrentInstitute() { # retornar informações do instituto
        return (new Session)->currentInstitute($this);
    }

    /** Retornar customizações do período atualdo instituto */
    public function getColors() { # retornar customizações do período atualdo instituto
        $colors = (new ThemesModel)->getCustomizations($this->getCurrentInstitute()['instituteId']);

        return $this->response->setJSON($colors);
    }

    /** Retornar tema para edição/previsualização */
    public function getTheme() { # retornar tema para edição/previsualização
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // requisições via post    
            
            $id = $this->request->getPost('id');

            if($id !== null && $id !== ''){ // se o id não for nulo, retornar tema referente a ele
                return $this->response->setJSON((new ThemesModel)->getTheme($id));
            }

            return $this->response->setJSON($this->getDefaultTheme(session()->get('id'))); // se o id for nulo, retornar tema padrão
        }
        
        return (new ThemesModel)->getTheme($_GET['id']); // requisições via get
    }

    /** Alterar tema padrão do site */
    public function customize() {   
        $data = [
            'id_theme' => (new ThemesModel)->getDefaultTheme(session()->get('id'))['id'],
            'primary' => $this->request->getPost('primary'),
            'secundary' => $this->request->getPost('secundary'),
            'hover' => $this->request->getPost('hover'),
            'url_banner' => $this->request->getPost('url_banner'),
        ];

        if($data['url_banner'] === ''){
            $data['url_banner'] = NULL;
        }

        return $this->response->setJSON((new ThemesModel)->updateTheme($data));
    }

    /** Alterar favicon */
    public function changeFavicon() {
        if((new Session)->isLogged()){
            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) 
            {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/favicon/";
                } 
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

                (new Functions)->deleteFiles(["favicon.png"], $path);

                // novo nome do arquivo
                $newName = 'favicon.png';

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
            
            return $this->response->setJSON(true);
        }
        return $this->response->setJSON(false);
    }

    /** Alterar banner da página inicial */
    public function changeBanner() {
        if((new Session)->isLogged()){
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) 
            {
                // verificar o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/banners/";
                } 
                    
                if (!is_dir($path)) { // criar diretório para o arquivo
                    mkdir($path, 0755, true);
                }

                // novo nome do arquivo
                $newName = (new Functions)->newName($file['name']);

                try {
                    \Config\Services::image('gd')
                    ->withFile($file['tmp_name'])
                    ->resize(1440, 1440, true) // redimencionar 
                    ->save($path.$newName, 100); // salvar com 100% da qualidade 
                }
                catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                    return $this->response->setJSON(false);
                }
            }

            // pegar o id do tema principal
            $idTheme = (new ThemesModel)->getDefaultTheme(session()->get('id'))['id'];

            if((new ThemesModel)->setBanner($newName, $idTheme, $path)){ // caso ocorrer tudo certo no BD
                return $this->response->setJSON(true);
            }

            // caso ocorrer algum erro no BD
            (new Functions)->deleteFiles([$newName], $path); 
        }
        
        return $this->response->setJSON(false);
    }

    /** Retornar tema padrão do site */
    public function getDefaultTheme($institute) { # retornar tema padrão do site
        return (new ThemesModel)->getDefaultTheme($institute);
    }

    /** Ativar/desastivar atividade de um tema */
    public function changeActivity() { # ativar/desastivar atividade de um tema 
        $data = [
            'id' => $this->request->getPost('id'),
            'activity' => $this->request->getPost('activity'),
        ];

        return $this->response->setJSON((new ThemesModel)->changeActivity($data));
    }

    /** Remover tema */
    public function removeTheme() { # deletar tema
        $data = [
            'id' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new ThemesModel)->removeTheme($data));
    }

    /** Enviar dados para o model para registrar tema */
    public function registerTheme() { # adicionar tema
        $data = [
            'id_institute' => session()->get('id'),
            'name' => $this->request->getPost('name'),
            'primary' => $this->request->getPost('primary'),
            'secundary' => $this->request->getPost('secundary'),
            'hover' => $this->request->getPost('hover'),
            'url_banner' => $this->request->getPost('url_banner'),
            'initial_date' => $this->request->getPost('initial_date'),
            'final_date' => $this->request->getPost('final_date'),
            'effects' => NULL // alterar quando existir efeitos para serem aplicados 
        ];

        return $this->response->setJSON((new ThemesModel)->registerTheme($data));
    }

    /** Alterar dados do tema */
    public function updateTheme() {
        $data = [
            'id_theme' => $this->request->getPost('id'),
            'name' => $this->request->getPost('name'),
            'primary' => $this->request->getPost('primary'),
            'secundary' => $this->request->getPost('secundary'),
            'hover' => $this->request->getPost('hover'),
            'url_banner' => $this->request->getPost('url_banner'),
            'initial_date' => (new DateTime($this->request->getPost('initial_date')))->format("Y-n-d"),
            'final_date' => (new DateTime($this->request->getPost('final_date')))->format("Y-n-d"),
            'effects' => NULL // alterar quando existir efeitos para serem aplicados 
        ];

        if($data['url_banner'] === ''){
            $data['url_banner'] = NULL;
        }

        return $this->response->setJSON((new ThemesModel)->updateTheme($data, false));
    }

    /** Alterar banner */
    public function setBanner() { # adicionar banner e remover o último utilizado (caso tenha)
        if((new Session)->isLogged()){
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos
            $idTheme = $_GET['id_theme'];

            foreach ($_FILES as $key => $file) 
            {
                // verificar o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/banners/";
                } 
                    
                if (!is_dir($path)) { // criar diretório para o arquivo
                    mkdir($path, 0755, true);
                }

                // novo nome do arquivo
                $newName = (new Functions)->newName($file['name']);

                try {
                    \Config\Services::image('gd')
                    ->withFile($file['tmp_name'])
                    ->resize(1440, 1440, true) // redimencionar 
                    ->save($path.$newName, 100); // salvar com 100% da qualidade 
                }
                catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                    return $this->response->setJSON(false);
                }
            }


            if((new ThemesModel)->setBanner($newName, $idTheme, $path)){ // caso ocorrer tudo certo no BD
                return $this->response->setJSON(true);
            }

            // caso ocorrer algum erro no BD
            (new Functions)->deleteFiles([$newName], $path); 
        }
        
        return $this->response->setJSON(false);
    }

    /** Remover banner */
    public function removeBanner() {
        $data = [
            'id' => $this->request->getPost('id')
        ];

        if(!isset($data['id'])){
            $data['id'] = (new ThemesModel)->getDefaultTheme(session()->get('id'))['id'];
        }

        $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/banners/";

        return $this->response->setJSON((new ThemesModel)->setBanner(NULL, $data['id'], $path));
    }
}
