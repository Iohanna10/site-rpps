<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class GalleryModel extends Model {

    protected $table = 'galerias';

    /** Inserir galeria */
    public function insertGallery($data) { # inserir galeria no banco de dados
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $Data = new DateTime;

            // dados para inserir na tabela
            $params = [
                'institute' => session()->get('id'), // instituto
                'name_gallery' => (new Functions)->changeQuotes($data['name_gallery']), // título
                'description' => (new Functions)->changeQuotes($data['description']), // descrição
                'infos' => (new Functions)->changeQuotes($data['infos']), // infos das mídias
                'date' => $Data->format('Y-n-d H:i:s'),

                // obs: sempre cadastrados como "null". serão adicionados ao BD na função uploadFiles.
                'main_img' => null, // imagem principal
                'carousel_media' => null, // mídias do carrossel
            ];

            // verificar se já esxiste uma galeria com o nome no instituto
            if($this->query("SELECT COUNT(id) AS num_galleries FROM galeria WHERE nome = :name_gallery: AND id_instituto = :institute:", $params)->getResult('array')[0]['num_galleries'] > 0){
                return ['bool' => false, 'msg' => 'O instituto já possui uma galeria com este nome.'];
            }

            if($data['carousel_url_videos'] !== '' && $data['carousel_url_videos'] !== null){
                $params['carousel_media'] = $data['carousel_url_videos'];
            }

            if ($this->query("INSERT INTO galeria VALUES(0, :institute:, :name_gallery:, :description:, :main_img:, :carousel_media:, :infos:, :date:)", $params)){
                return ['bool' => true];
            } 
        }

        return ['bool' => false];
    }

    /** Inserir mídias da galeria no banco de dados */
    public function UpFiles($data){ # adicionar imagens da galeria no banco de dados
        if((new Session)->isLogged()){
            $params = [
                'name' => $data['names'],
                'column' => $data['column'], // (pode ser a coluna 'imagem_principal' ou 'midias')
                'id_gallery' => $this->query("SELECT id FROM galeria WHERE id_instituto = " . session()->get('id') . " ORDER BY data DESC LIMIT 1")->getResult("array")[0]['id']
            ];

            $query = str_replace("@column", $params['column'], "UPDATE galeria SET @column = :name: WHERE id = :id_gallery:"); // 

            if($this->query($query, $params)){
                return true;
            } 
            
            // caso não conseguir fazer o upload dos arquivos, excluir o registro do BD
            $this->query("DELETE FROM galeria WHERE id = :id_gallery:", $params);
        }

        return false;
    }

    /** Retornar galeria */
    public function getGallery($data){ # pegar informações da galeria
        $params = [
            'id' => $data['id_institute'],
            'id_gallery' => $data['id_gallery'],
        ];

        if(!($this->query("SELECT COUNT(0) as validId FROM galeria WHERE id_instituto = :id: AND id = :id_gallery:", $params)->getResult('array')[0]['validId'] > 0)){
            return false;
        }

        $dbData = $this->query("SELECT nome, descricao_galeria, imagem_principal, midias, descricao_midias, data FROM galeria WHERE id_instituto = :id: AND id = :id_gallery:", $params)->getResult('array')[0];
        
        if($data['path_name'] == true){
            $dbData['nome'] = (new Functions)->nameDir($dbData['nome']);
        }

        return $dbData;
    }

    /** Alterar informações da galeria */
    public function updateGallery($data) { # alterar informações da galeria
        if((new Session)->isLogged()){
            $params = [
                'id_institute' => session()->get('id'),
                'id_gallery' => $data['id_gallery'],
                'description' => (new Functions)->changeQuotes($data['description']),
                'infos' => (new Functions)->changeQuotes($data['infos_img']),
                'name' => (new Functions)->changeQuotes($data['title']),
            ];

            // verificar se já esxiste uma galeria com o nome no instituto
            if($this->query("SELECT COUNT(id) AS num_galleries FROM galeria WHERE nome = :name: AND id_instituto = :id_institute: AND id != :id_gallery:", $params)->getResult('array')[0]['num_galleries'] > 0){
                return ['bool' => false, 'msg' => 'O instituto já possui uma galeria com este nome.'];
            }

            if($this->query("UPDATE galeria SET nome = :name:, descricao_galeria = :description:, descricao_midias = :infos: WHERE id = :id_gallery: AND id_instituto = :id_institute:", $params)){
                $this->updateDirName($this->infoForUpNewFiles($data['id_gallery']), $data, ['thumb' => 'thumb', 'all' => 'all-images']);
                return ['bool' => true];
            };
        }

        return ['bool' => false];
    }

    /** Inserir informações das mídias da galeria */
    public function infoForUpNewFiles($id_gallery){
        $params = [
            'id_institute' => session()->get('id'),
            'id_gallery' => $id_gallery,
        ];

        return ($this->query("SELECT nome, imagem_principal, data FROM galeria WHERE id_instituto = :id_institute: AND id = :id_gallery:", $params)->getResult('array')[0]);
    }

    /** Retornar galerias para a lista */
    public function getGalleriesList($pg, $filters) { 
        $qntResultPgs = 10; // quantidade max de registros do db por página

        $params = [
            'institute' => session()->get('id'),
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM galeria WHERE id_instituto = :institute:", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        $dbData = $this->query($this->getQuery($filters), $params)->getResult("array");

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    /** Retornar galerias  */
    public function getGalleries($pg, $institute) { 
        $qntResultPgs = 10; // quantidade max de registros do db por página

        $params = [
            'institute' => $institute,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM galeria WHERE id_instituto = :institute:", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        $dbData = $this->query("SELECT id, nome, descricao_galeria, imagem_principal, data FROM galeria WHERE id_instituto = :institute: ORDER BY data DESC LIMIT :start:, :qntResultPgs:", $params)->getResult("array");

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    /** Retornar mídias da galeria */
    public function getMedias($id) { # pegar mídias 
        $query = "SELECT nome, midias, descricao_midias, data FROM galeria WHERE id = $id AND id_instituto = " . session()->get('id');
        
        $data = null;
        if(isset($this->query($query)->getResult('array')[0])){
            $data = $this->filterMedias($this->query($query)->getResult('array')[0]);
        }

        return $data;
    }

    /** Alterar a ordem de exibição das mídias */
    public function updateOrder($data) { # alterar a ordem de exibição das mídias
        if((new Session)->isLogged()){
            $params = [
                'medias' => implode(', ', $data['order']),
                'infos' => implode(';<separator>;', $data['infos']),
                'id_gallery' => $data['id_gallery'],
                'id_institute' => session()->get('id')
            ];

            if($this->query("UPDATE galeria SET midias = :medias:, descricao_midias = :infos: WHERE id = :id_gallery: AND id_instituto = :id_institute:", $params)){
                return true;
            };
        }

        return false;
    }

    /** Adicionar novas mídias para a galeria  */
    public function uploadNewFiles($data) { # adicionar novas mídias para a galeria 
        if($data['type'] === "midias"){
            $query = "SELECT midias, descricao_midias FROM galeria WHERE id = " . $data['id_gallery'] . " AND id_instituto = " . session()->get('id');
            $otherMedias = $this->query($query)->getResult('array')[0];

            $params = [
                'id_institute' => session()->get('id'),
                'id_gallery' => $data['id_gallery']
            ];

            if($otherMedias['midias'] != NULL && $otherMedias['midias'] != ''){ // caso já tenham mídias na galeria
                $params['medias'] = $otherMedias['midias'] . ", " . $data['new_names']; // adiciona o nome das novas mídias junto as antigas
                $params['infos'] = $otherMedias['descricao_midias'] . $this->getNullDescription(count(explode(',', $data['new_names']))); // adiciona a descrição das novas mídias junto as antigas
            } else {
                $params['medias'] = $data['new_names']; // adiciona o nome das mídias
                $params['infos'] =  $this->getNullDescription(count(explode(',', $data['new_names'])) - 1); // adiciona descrição para as mídias 
            }

            $query = "UPDATE galeria SET midias = :medias:, descricao_midias = :infos: WHERE id = :id_gallery: AND id_instituto = :id_institute:";
        }
        elseif($data['type'] === 'imagem_principal') {
            $params = [
                'id_institute' => session()->get('id'),
                'main_img' => $data['new_names'],
                'id_gallery' => $data['id_gallery']
            ];

            $query = "UPDATE galeria SET imagem_principal = :main_img: WHERE id = :id_gallery: AND id_instituto = :id_institute:";
        }

        if(!$this->query($query, $params)){
            return false;
        };

        return true;
    }

    /** Remover mídias */
    public function removeFiles($data){
        if((new Session)->isLogged()){
            $query = "SELECT midias, descricao_midias FROM galeria WHERE id = " . $data['id_gallery'] . " AND id_instituto = " . session()->get('id');
            $medias = $this->query($query)->getResult('array')[0];

            $medias = $this->popMedias($medias, $data['medias']);
            // var_dump($this->popMedias($medias, $data['medias']));

            if($medias['midias'] == ''){
                $medias['midias'] = NULL;
            }

            $params = [
                'medias' => $medias['midias'],
                'infos' => $medias['descricao_midias'],
                'id_institute' => session()->get('id'),
                'id_gallery' => $data['id_gallery']
            ];

            $query = "UPDATE galeria SET midias = :medias:, descricao_midias = :infos: WHERE id = :id_gallery: AND id_instituto = :id_institute:";

            if($this->query($query, $params)){
                return true;
            }
        }
        return false;
    }

    /** Remover imagem principal */
    public function removeFeaturedMedias($data){
        if((new Session)->isLogged()){
            $params = [
                'id_institute' => session()->get('id'),
                'id_gallery' => $data['id_gallery']
            ];

            $query = "SELECT imagem_principal FROM galeria WHERE id = :id_gallery: AND id_instituto = :id_institute:";
            $medias = $this->query($query, $params)->getResult('array')[0];

            if($medias['imagem_principal'] === $data['medias'][0]){
                $query = "UPDATE galeria SET imagem_principal = NULL WHERE id = :id_gallery: AND id_instituto = :id_institute:";
                $type = 'img';
            } 
            else {
                return ['bool' => 'false'];
            }

            if($this->query($query, $params)){
                return ['bool' => 'true', 'type' => $type];
            };
        }
        
        return ['bool' => 'false'];
    }
    
    /** Remover galeria */
    public function removeGallery($data) {
        if((new Session)->isLogged()){
            $params = [
                'id_gallery' => $data['id_gallery']
            ];

            $dataDelete = $this->query("SELECT nome, data, midias FROM galeria WHERE id = :id_gallery:", $params)->getResult('array')[0];

            $paths = [];

            foreach (['img', 'video'] as $key_main => $mainPath) {
                foreach (['thumb', 'all-images'] as $key_type => $type) {
                    $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/$mainPath/photo-gallery/$type/" . (new DateTime($dataDelete['data']))->format('Y/n/') . (new Functions)->nameDir($dataDelete['nome']). '/';

                    array_push($paths, $path);
                }
            }

            if ($this->query("DELETE FROM galeria WHERE id = :id_gallery:", $params)){
                foreach ($paths as $key => $path) {
                    if(is_dir($path)){
                        (new Functions)->deleteFiles(explode(', ', $dataDelete['midias']), $path);
                    }
                }
                return true;
            }
        }

        return false;
    }

    /** Retornar imagem principal */
    public function getFeatured($data){
        $params = [
            'id_gallery' => $data['id_gallery'],
            'id_institute' => session()->get('id')
        ];
        
        return $this->query("SELECT imagem_principal FROM galeria WHERE id = :id_gallery: AND id_instituto = :id_institute:", $params)->getResult('array')[0];
    }

    private function popMedias($data, $removeMedias){
        $medias = explode(', ', $data['midias']);
        $description = explode(';<separator>;', $data['descricao_midias']);
        
        foreach ($removeMedias as $key => $remove) {
            $key = array_search($remove, $medias);
            if($key!==false){
                unset($medias[$key]);
                unset($description[$key]);
            }
        }

        return['midias' => implode(', ', $medias), 'descricao_midias' => implode(';<separator>;', $description)];
    }

    /** Adicionar filtros na Query do banco de dados */
    private function getQuery($filters){ // adicionar filtros na pesquisa
        $query = 'SELECT id, nome, data FROM galeria WHERE id_instituto = :institute: ';
        
        if($filters['initial_date']  !== ''){
            $query .= "AND data >= '" . $filters['initial_date'] . "' ";
        }
        
        if($filters['final_date']  !== ''){
            // add H:i:s
            $final = $filters['final_date'] . '23:59:59';
            $filters['final_date'] = (new DateTime($final))->format('Y-m-d H:i:s');

            $query .= "AND data <= '" . $filters['final_date'] . "' ";
            
            $query .= "AND data <= '" . $filters['final_date'] . "' ";
        }

        if($filters['name']  !== ''){
            $query .= "AND nome like '%". $filters['name'] ."%' ";
        }
        
        $query .= "ORDER BY data ". $filters['order'] ." LIMIT :start:, :qntResultPgs:";

        return $query;
    }

    /** Filtrar os tipos de mídias */
    private function filterMedias($data){ // filtrar tipos de midia
        if($data['midias'] !== NULL && $data['midias'] !== ''){
            // transformar str midias em array 
            $allMedias = explode(',', $data['midias']);
            
            // definir array's
            $medias = [];
            
            // separar links dos videos e imagens
            foreach ($allMedias as $key => $media) {
                $description = explode(';<separator>;', $data['descricao_midias'])[$key]; // pegar infos da imagem
    
                if(pathinfo(trim($media), PATHINFO_EXTENSION) === ""){
                    $type = 'url';
                }
                elseif(in_array(pathinfo(trim($media), PATHINFO_EXTENSION), ["png", "jpg", "jpeg"])){
                    $type = 'img';
                } 
                else {
                    $type = 'video';
                }
    
                array_push($medias, ['nome' => trim($media), 'tipo' => "$type", 'info' => trim($description)]);
            }
    
            // alterar arrayy de midias para um array sem url's 
            $data['midias'] = $medias;
        }

        return $data;
    }

    /** Adicionar descrição nula para as mídias da galeria */
    private function getNullDescription($count){
        $infosMedia = '';
        
        for ($i=0; $i < $count; $i++) { 
            $infosMedia .= ';<separator>;';
        }

        return $infosMedia;
    }

    /** Alterar nome do diretório em que se encontram as mídias da galeria */
    private function updateDirName($gallery_info, $data, $folders){
        if($data['last_name'] !== $data['title']){
            foreach ($folders as $key => $folder) {
               
                $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/photo-gallery/$folder/" . (new DateTime($gallery_info['data']))->format('Y/n/');
                
                $dir = $path . (new Functions)->nameDir($data['last_name']);
                $newDir = $path . (new Functions)->nameDir($data['title']);

                if(is_dir($dir)){
                    rename($dir, $newDir);
                }
            }

            $replace = ["/img/photo-gallery", "thumb"];
            $str = ["/video/photo-gallery", "all-images"];

            if(is_dir(str_replace($replace, $str, $dir))){
                rename(str_replace($replace, $str, $dir), str_replace($replace, $str, $newDir)); // alterar diretório de videos
            }
        }
    }
}