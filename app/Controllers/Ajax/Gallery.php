<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Ajax\GalleryModel;
use App\Models\Functions\Functions;
use App\Models\Session\SessionModel;
use DateTime;

/**
 * Classe de controle das funções de recuperação e registro de `Galerias`
*/

class Gallery extends BaseController
{
    protected $allowedFilds = [
        'id_gallery',
        'name_gallery'
    ];

    /** Retornar id do instituto */
    public function getInstituteId($institute) { # retornar id do instituto pelo nome
        return (new SessionModel)->getInstituteId($institute);
    }

    /** Inserir galeria no banco de dados */
    public function insertGallery() { # inserir galeria no banco de dados
        $data = [
            'name_gallery' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'main_img' => $this->request->getPost('img'),
            'carousel_media' => $this->request->getPost('carousel_media'),
            'carousel_url_videos' => $this->request->getPost('carousel_url_videos'),
            'infos' => $this->request->getPost('infos'),
        ];

        return $this->response->setJSON((new GalleryModel)->insertGallery($data));
    }

    /** Retornar dados da galeria */
    public function getGallery() { # pegar informações da galeria
        $data = [
            'id_institute' => $this->getInstituteId($this->request->getPost('institute')),
            'id_gallery' => $this->request->getPost('id_gallery'),
            'path_name' => $this->request->getPost('path_name')
        ];

        return $this->response->setJSON((new GalleryModel)->getGallery($data));
    }

    /** Alterar dados da galeria */
    public function updateGallery(){ # alterar informações da galeria
        $data = [
            'id_gallery' => $this->request->getPost('id'),
            'description' => $this->request->getPost('description'),
            'infos_img' => $this->request->getPost('infos_img'),
            'title' => $this->request->getPost('title'),
            'last_name' => $this->request->getPost('last_name'),
        ];

        return $this->response->setJSON((new GalleryModel)->updateGallery($data));
    }

    /** Fazer upload de mídias */
    public function uploadFiles() { # fazer upload de arquivos 
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $Data = new DateTime();

            // dados
            $institute = strtolower(session()->get("name"));
            $type = (new Functions)->getType($_GET['type']);
            $newNames = [];
            $path = '';

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos
            $folder = $_GET['folder'];
            $nameGallery = (new Functions)->nameDir($_GET['name_gallery']); 

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/photo-gallery/$folder/" . $Data->format('Y/n/') . "$nameGallery/";
                } 
                else { // vídeos
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/video/photo-gallery/$folder/" . $Data->format('Y/n/') . "$nameGallery/";
                }

                if (!is_dir($path)) {
                    mkdir($path, 0755, true); // caso não exista, criar diretório
                }

                $newName = (new Functions)->newName($file['name']); // novo nome do arquivo

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // upload de imagem
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
                } else { // upload de outros arquivos
                    if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){
                        (new Functions)->deleteFiles($newNames, $path);
                        return $this->response->setJSON(false);                
                    }
                }

                array_push($newNames, $newName);
            }

            if($_GET['urls'] !== '' && $_GET['urls'] != 'undefined'){
                $allMediasName = implode(', ', $newNames) . ', ' . $_GET['urls'];
            }
            else {
                $allMediasName = implode(', ', $newNames);
            }

            if(!((new GalleryModel)->UpFiles(['names' => $allMediasName, 'column' => $type]))){
                (new Functions)->deleteFiles($newNames, $path); // deletar arquivos upados caso os dados não sejam gravados no banco de dados
                return $this->response->setJSON(false);
            }
            
            return $this->response->setJSON(true);
        }

        return $this->response->setJSON(false);
    }

    /** Alterar ordem das mídias da galeria */
    public function updateOrder() { # alterar a ordem de exibição das mídias na galeria 
        $data = [
            'order' => $this->request->getPost('current_order'),
            'infos' => $this->request->getPost('infos'),
            'id_gallery' => $this->request->getPost('id'),
        ];

        return $this->response->setJSON((new GalleryModel)->updateOrder($data)); 
    }

    /** Fazer upload de novas mídias */
    public function uploadNewFiles() { # fazer upload de novos arquivos de mídia da galeria
        if((new Session)->isLogged()){
            // configurações data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');

            /** @params **/
                // $_GET['data']: recebe uma string com os valores "folder", "gallery_id" e "type" separados por vírgula.
                $folder = explode(',', $_GET['data'])[0]; // folder
                $idGallery = explode(',', $_GET['data'])[1]; // id da galeria
                $type = (new Functions)->getType(explode(',', $_GET['data'])[2]); // type
            /**/

            // dados
            $Gallery = (new GalleryModel)->infoForUpNewFiles($idGallery); // dados da galeria
            $Data = new DateTime($Gallery['data']); // data de publicação
            $newNames = [];

            // extensões 
            $imgsExtension = ['png', 'jpg', 'jpeg']; // extensões de fotos

            // para o caminho das mídias
            $path = '';
            $nameGallery = (new Functions)->nameDir($Gallery['nome']); 
            $institute = strtolower(session()->get("name"));
            $errPath = ['video' => '', 'img' => '']; // caso houver erros, excluir mídias novas

            foreach ($_FILES as $key => $file) {
                // verificar e criar diretórios para o arquivo
                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // imagens
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/img/photo-gallery/$folder/" . $Data->format('Y/n/') . "$nameGallery/";
                    $errPath['img'] = $path;
                } 
                else { // vídeos
                    $path = FCPATH . "dynamic-page-content/$institute/assets/uploads/video/photo-gallery/$folder/" . $Data->format('Y/n/') . "$nameGallery/";
                    $errPath['video'] = $path;
                }

                if (!is_dir($path)) {
                    mkdir($path, 0755, true); // caso não existir, cria o diretório 
                }

                $newName = (new Functions)->newName($file['name']); // novo nome do arquivo

                if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $imgsExtension)){ // upload de imagem
                    try {
                        \Config\Services::image('gd')
                        ->withFile($file['tmp_name'])
                        ->resize(800, 800, true) // redimencionar 
                        ->save($path.$newName, 100); // salvar com 100% da qualidade  
                    }
                    catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                        return $this->response->setJSON($this->errUpMedias($newNames, [$errPath['img'], $errPath['video']])); // remover todos os novos arquivos upados caso der erro em algum
                    }
                } else { // upload de outros arquivos
                    if(!(move_uploaded_file($file['tmp_name'], $path.$newName))){
                        return $this->response->setJSON($this->errUpMedias($newNames, [$errPath['img'], $errPath['video']]));
                    }
                }

                array_push($newNames, $newName);
            }

            if(!(new GalleryModel)->uploadNewFiles(['new_names' => implode(', ', $newNames), 'type' => $type, 'id_gallery' => $idGallery])){ // tenta inserir os dados no banco de dados
                return $this->response->setJSON($this->errUpMedias($newNames, [$errPath['img'], $errPath['video']])); // caso não for possível inserir, excluir arquivos upados 
            }

            if($type == 'imagem_principal') { 
                if(isset($Gallery['imagem_principal'])){  // verifica se já existia uma imagem principal anteriormente
                    $this->response->setJSON($this->errUpMedias([$Gallery['imagem_principal']], [$errPath['img']])); // remove a imagem principal anterior 
                }
            }

            return $this->response->setJSON(true);
        }

        return $this->response->setJSON(false);
    }

    /** Inserir URL's no banco de dados */
    public function insertUrls() { # inserir urls no banco de dados 
        $data = [
            'new_names' => implode(", ", $this->request->getPost('urls')),
            'type' => 'midias',
            'id_gallery' => $this->request->getPost('id')
        ];

        return $this->response->setJSON((new GalleryModel)->uploadNewFiles($data));
    }

    /** Remover galeria */
    public function removeGallery()
    {        
        $data = [
            'id_gallery' => $this->request->getPost('id'),
        ];

        $msg = (new GalleryModel)->removeGallery($data);
        return $this->response->setJSON($msg);
    }

    /** Remover mídias da galeria */
    public function removeFiles(){
        // configurações data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        // dados recebidos pelo ajax
        $data = [
            'medias' => $this->request->getPost('medias'),
            'folder' => $this->request->getPost('folder'),
            'id_gallery' => $this->request->getPost('id_gallery'),
        ];

        if($data['folder'] == 'all-images'){
            $rspDelete = (new GalleryModel)->removeFiles($data); // retorna o booleano indicando se os arquivos foram ou não removidos
            if(!$rspDelete){
                return $this->response->setJSON(false);
            }
        } 
        elseif($data['folder'] == 'thumb'){
            $rspDelete = (new GalleryModel)->removeFeaturedMedias($data); // retorna o booleano e o tipo
            if(!$rspDelete['bool']){
                return $this->response->setJSON(false);
            }
        }

        // dados do bd
        $Gallery = (new GalleryModel)->infoForUpNewFiles($data['id_gallery']); // dados da galeria
        $nameGallery = (new Functions)->nameDir($Gallery['nome']); 
        $Data = new DateTime($Gallery['data']); // data de publicação

        // dados de sessão
        $institute = strtolower(session()->get("name"));

        // caminhos de arquivo
        $paths = [
            'imgs' => FCPATH . "dynamic-page-content/$institute/assets/uploads/img/photo-gallery/". $data['folder'] . "/" . $Data->format('Y/n/') . "$nameGallery/",
            'videos' => FCPATH . "dynamic-page-content/$institute/assets/uploads/video/photo-gallery/". $data['folder'] . "/" . $Data->format('Y/n/') . "$nameGallery/"
        ];

        $this->errUpMedias($data['medias'], $paths); // remover itens

        return $this->response->setJSON($rspDelete); // retorna a resposta da função de deletar
    }

    /** Retornar imagem principal da galeria */
    public function getFeatured(){
        $data = [
            'id_gallery' => $this->request->getPost('id_gallery'),
        ];

        return $this->response->setJSON((new GalleryModel)->getFeatured($data));
    }

    /** Remover mídias com falhas no upload */
    private function errUpMedias($newNames, $paths){ // erro ao upar mídias 
        foreach ($paths as $key => $path) {
            (new Functions)->deleteFiles($newNames, $path);
        }
        
        return false;
    }
}
