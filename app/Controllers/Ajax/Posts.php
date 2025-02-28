<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\PostModel;
use App\Models\Functions\Functions;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Publicações`
*/

class Posts extends BaseController
{
    /** Retornar informações da publicação */
    public function post() { # buscar dados post 
        $data = [
            'id_post' => $this->request->getPost('id_post'),
        ];

        return $this->response->setJSON((new PostModel)->posts($data)); // retorna os dados da publicação
    }

    /** Retornar imagem principal da publicação */
    public function getFeatured() { # pegar imagem principal da publicação
        $data = [
            'id_post' => $this->request->getPost('id_post'),
        ];

        return $this->response->setJSON((new PostModel)->getFeatured($data)); // retorna a imagem principal
    }

    /** Enviar dados ao model para registrar a publicação */
    public function insertPost() { # enviar dados da publicação para serem inseridos no banco de dados
        $data = [
            'category' => $this->request->getPost('category'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'main_content' => $this->request->getPost('main_content'),
            'carousel_media' => $this->request->getPost('carousel_url_videos'),
        ];

        return $this->response->setJSON((new PostModel)->insertPost($data)); // retorna booleano confirmando se foi inserido
    }

    /** Upload de mídias das publicações */
    public function uploadFiles() { # inserir mídias no diretório do instituto
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            $Date = new DateTime;

            // dados
            $institute = strtolower(session()->get("name"));
            $type = (new Functions)->getType($_GET['type']);
            
            $newNames = [];
            $path = '';

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) {
                
                // verificar extensões e criar caminho para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/posts/" . $Date->format('Y/n/');
                } 
                else { // vídeos
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/video/posts/" . $Date->format('Y/n/');
                }
                    
                if (!is_dir($path)) {// criar diretório para o arquivo caso não existir
                    mkdir($path, 0755, true);
                }

                // novo nome do arquivo
                $newName = (new Functions)->newName($file['name']);

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // upload de imagem
                    try {
                        \Config\Services::image('gd')
                        ->withFile($file['tmp_name'])
                        ->resize(680, 460, true) // redimencionar 
                        ->save($path.$newName, 100); // salvar com 80% da qualidade 
                    }
                    catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                        return $this->response->setJSON(false);
                    }
                } else { // upload de outros arquivos
                    if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){
                        return $this->response->setJSON(false);
                    }
                }

                array_push($newNames, $newName);
            }

            if($_GET['urls'] !== '' && $_GET['urls'] != 'undefined'){ // se existir urls, também adiciona-las as mídias
                $allMediasName = implode(', ', $newNames) . ', ' . $_GET['urls'];
            }
            else {
                $allMediasName = implode(', ', $newNames);
            }

            if((new PostModel)->UpFiles(['names' => $allMediasName, 'column' => $type])){ // tentar inserir nome das mídias no banco de dados
                return $this->response->setJSON(true);
            }  

            (new Functions)->deleteFiles($newNames, $path); // caso não dê, excluír mídias 
        }
        return $this->response->setJSON(false);
    }

    /** Upload de mídias no corpo das publicações */
    public function uploadFilesMainPost() { # inserir mídias no diretório do instituto
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            // extensões 
            $videosExtension = ["ogm", "wmv", "mpg", "webm", "ogv", "mov", "asx", "mpeg", "mp4", "m4v", "avi"]; // extensão de vídeos
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos
            $pdfExtension = ['pdf']; // extensão de pdf's

            if(isset($_GET['type_file'])){
                $accept = $_GET['type_file'];
            }
            else {
                $accept = 'image';
            }

            // dados
            $Date = new DateTime;
            $institute = strtolower(session()->get("name"));

            $temp_file = $_FILES['file']['tmp_name'];
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $name = uniqid() . '.' . $extension;

            if(in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $imgsExtension) && $accept === 'image'){ // imagens
                $file_path_dest = "dynamic-page-content/$institute/assets/uploads/img/posts/" . $Date->format('Y/n/');
            } 
            elseif(in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $pdfExtension) && $accept === 'file') { // pdfs
                $file_path_dest = "dynamic-page-content/$institute/assets/uploads/pdf/posts/" . $Date->format('Y/n/');
            }
            elseif(in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $videosExtension) && $accept === 'media') { // vídeos
                $file_path_dest = "dynamic-page-content/$institute/assets/uploads/video/posts/" . $Date->format('Y/n/');
            }
            else {
                return $this->response->setJSON(['msg' => "Aceita somente " . $this->mimeTypes($accept)]);
            }

            if (!is_dir($file_path_dest)) {
                mkdir($file_path_dest, 0755, true);
            }
            $file_path_dest = $file_path_dest . $name;

            if(in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $imgsExtension)){ // upload de imagem
                try {
                    \Config\Services::image('gd')
                    ->withFile($temp_file)
                    ->resize(800, 800, true) // redimencionar 
                    ->save(FCPATH . $file_path_dest, 100); // salvar com 100% da qualidade 
                }
                catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                    return $this->response->setJSON(['msg' => "Erro ao tentar fazer upload do arquivo."]);
                }
            } else { // upload de outros arquivos
                if(!move_uploaded_file($temp_file, $file_path_dest)){
                    return $this->response->setJSON(['msg' => "Erro ao tentar fazer upload do arquivo."]);
                }
            }

            return $this->response->setJSON(['location' => base_url("$file_path_dest")]); // retorna o caminho da imagem 
        }

        return $this->response->setJSON(['msg' => 'Faça login para poder fazer upload de arquivos']);
    }

    /** Upload de novas mídias das publicações */
    public function uploadNewFiles() { # fazer upload de novos arquivos
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            // dados
            $Date = new DateTime((new PostModel)->getDataUpFiles($_GET['id_post'])['data']); // data de publicação
            $institute = strtolower(session()->get("name"));
            $type = (new Functions)->getType($_GET['type']);
            $newNames = [];
            $path = '';
            $errPath = ['video' => '', 'img' => '']; // caso houver erros, excluir mídias novas

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/posts/" . $Date->format('Y/n/');
                    $errPath['img'] = $path;
                }
                else { // vídeos
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/video/posts/" . $Date->format('Y/n/');
                    $errPath['video'] = $path;
                }
                    
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }

                // novo nome do arquivo
                $newName = (new Functions)->newName($file['name']);

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // upload de imagem
                    try {
                        \Config\Services::image('gd')
                        ->withFile($file['tmp_name'])
                        ->resize(800, 800, true) // redimencionar 
                        ->save($path.$newName, 100); // salvar com 100% da qualidade 
                    }
                    catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                        return $this->response->setJSON(false);
                    }
                } else { // upload de outros arquivos
                    if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){
                        return $this->response->setJSON(false);
                    }
                }

                array_push($newNames, $newName);
            }

            if($type == 'imagem_principal') {
                $oldFile = (new PostModel)->getDataUpFiles($_GET['id_post'])['imagem_principal']; // pegar imagem principal da publicação
                if($oldFile !== NULL){
                    $this->errUpMedias([$oldFile], [$errPath['img']]); // excluir 
                }
            }

            if((new PostModel)->uploadNewFiles(['newNames' => implode(', ', $newNames), 'type' => $type, 'id_post' => $_GET['id_post']])){ // tentar alterar o nome da imagem principal no banco de dados
                return $this->response->setJSON(true);
            }
            return $this->response->setJSON($this->errUpMedias($newNames, $errPath));
        }
        return $this->response->setJSON(false);
    }

    /** Enviar URL's de vídeos do carrossel para o model para registrar no banco de dados */
    public function uploadUrls() { # adicionar novas urls ao carrossel de imagens
        $data = [
            'newNames' => implode(", ", $this->request->getPost('urls')),
            'type' => 'midias',
            'id_post' => $this->request->getPost('id')
        ];

        return $this->response->setJSON((new PostModel)->uploadNewFiles($data));
    }

    /** Enviar dados de likes para o model para serem registrados no banco de dados */
    public function insertLikes() { # inserir registro de like         
        $data = [
            'id' => $this->request->getPost('id'),
            'type' => $this->request->getPost('type'),
        ];

        return $this->response->setJSON((new PostModel)->likePost($data));
    }

    /** Remover publicação */
    public function removePost() { # remover publicação
        $data = [
            'id' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new PostModel)->removePost($data)); // retorna booleano confirmando se deu certo
    }

    /** Remover mídias */
    public function removeFiles() { # remover mídias 
        // configurações data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        // dados recebidos pelo ajax
        $data = [
            'medias' => $this->request->getPost('medias'),
            'id_post' => $this->request->getPost('id_post'),
            'type' => $this->request->getPost('type'),
        ];

        if($data['type'] === 'midias'){
            $response = (new PostModel)->removeFiles($data); // retorna booleano
            if(!$response){
                return $this->response->setJSON(false);
            }
        } 
        elseif($data['type'] === 'principal') {
            $response = (new PostModel)->removeFeaturedMedias($data); // retorna o booleano e o tipo
            if(!$response['bool']){
                return $this->response->setJSON(false);
            }
        }

        // dados do bd
        $dataPost = (new PostModel)->getDataUpFiles($data['id_post']); // dados da publicação
        $Data = new DateTime($dataPost['data']); // data de publicação

        // dados de sessão
        $institute = strtolower(session()->get("name"));

        // caminhos de arquivo
        $paths = [
            'imgs' => FCPATH . "dynamic-page-content/$institute/assets/uploads/img/posts/" . $Data->format('Y/n/'),
            'videos' => FCPATH . "dynamic-page-content/$institute/assets/uploads/video/posts/" . $Data->format('Y/n/'),
        ];

        $this->errUpMedias($data['medias'], $paths); // remover itens

        return $this->response->setJSON($response);
    }

    /** Remover like da publicação */
    public function deleteLikes() { # excluir registro de like 
        $data = [
            'id' => $this->request->getPost('id'),
            'type' => $this->request->getPost('type'),
        ];

        return $this->response->setJSON((new PostModel)->dislikePost($data)); // retorna booleano
    }

    /** Alterar a ordem de visualização das mídias do carrossel */
    public function updateOrder() { # alterar a ordem de visualização das mídias do carrossel
        $data = [
            'current_order' => $this->request->getPost('current_order'),
            'id_post' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new PostModel)->updateOrder($data)); // retorna booleano 
    }

    /** Alterar dados da publicação */
    public function updatePost() { # alterar informações da publicação
        $data = [
            'id_post' => $this->request->getPost('id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];
        
        if($this->request->getPost('main_content') != ''){
            $data['main_content'] = $this->request->getPost('main_content');
        } else {
            $data['main_content'] = NULL;
        }

        return $this->response->setJSON((new PostModel)->updatePost($data)); // retorna booleano
    }

    /** Adicionar/Remover destaque de publicação */
    public function highlight() { # adicionar/remover destaque da publicação
       $data = [
            'id' => $this->request->getPost('id'),
            'highlight' => $this->request->getPost('highlight'),
        ];

        return $this->response->setJSON((new PostModel)->highlight($data)); // retorna booleano
    }

    /** Remover mídias com falhas de registro no banco de dados */
    private function errUpMedias($newNames, $paths) { # percorrer caminho dos arquivos para remover as mídias
        foreach ($paths as $key => $path) {
            (new Functions)->deleteFiles($newNames, $path);
        }
        return false;
    }

    /** Retornar tipo de erro de mídia */
    private function mimeTypes($accept) { # retornar extensões permitidas de acordo com o tipo do input
        switch ($accept) {
            case 'image':
                return 'imagens com extensões do tipo: png, jpg e jpeg.';
                
            case 'media':
                return "vídeos com extensões do tipo: ogm, wmv, mpg, webm, ogv, mov, asx, mpeg, mp4, m4v e avi.";

            case 'file':
                return 'arquivos com extensões do tipo: pdf.';
        }
    }
}
