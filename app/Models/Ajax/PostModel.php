<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use App\Models\Session\SessionModel;
use CodeIgniter\Model;
use Masterminds\HTML5;
use DateTime;

class PostModel extends Model {

    protected $table = 'posts';
    protected $primaryKey = 'id_post';
    protected $allowedFields = ['id_instituto', 'id_categoria', 'titulo', 'descricao', 'imagem_principal', 'midias', 'conteudo', 'destaque'];

    public function getAllContents() { # pegar todas as mídias para analisar se não estão em uso e remove-las através do cron job caso não esteja
        return $this->query("SELECT conteudo, imagem_principal, midias FROM posts")->getResult('array');
    }
    
    public function getPosts($pg, $filters) { # pegar posts do instituto
        $qntResultPgs = 10; // quantidade max de registros do db por página

        $params = [
            'institute' => session()->get('id'),
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
            'id_category' => $filters['id_category']  
        ];

        // nº total de registros
        $totalRecords = $this->query($this->getQuery($filters, 'count'), $params)->getResultObject();
        $qntPg = ceil($totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        $dbData = $this->query($this->getQuery($filters, 'data'), $params)->getResult("array");

        $queryHighlighted = "SELECT COUNT(0) as highlighted FROM posts WHERE destaque = '1' and id_instituto = '". session()->get('id'). "'";

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg,
            'qntHighlighted' => $this->query($queryHighlighted)->getResult('array')[0]['highlighted']
        ];

        return $dataArray;
    }
    
    public function posts($postId) { # selecionar publicação por id
        $params = [
            'id_post' => $postId['id_post'],
        ];

        $query = "SELECT id_instituto, data, titulo, descricao, imagem_principal, midias, conteudo FROM posts WHERE id_post = :id_post:";

        if(!isset($postId['array'])){ # se existir esse parâmetro então é para a edição de postagem, onde os dados são trabalhados em array
            $post = $this->query($query, $params)->getResultObject();
            if(count($post) === 0){
                return false;
            }
            $post = $post[0];
            $post->{'conteudo'} = $this->addInstituteToLocalPathMedia($post->{'conteudo'}, $post->{'id_instituto'});
        } else {
            $post = $this->query($query, $params)->getResult('array');
            if(count($post) === 0){
                return false;
            }
            $post = $post[0];
            $post['conteudo'] = $this->addInstituteToLocalPathMedia($post['conteudo'], $post['id_instituto']);
        }

        return $post;
    }

    public function getFeatured($data) { # pegar imagem principal
        $params = [
            'id_post' => $data['id_post'],
            'id_institute' => session()->get('id')
        ];
        
        return $this->query("SELECT imagem_principal FROM posts WHERE id_post = :id_post: AND id_instituto = :id_institute:", $params)->getResult('array')[0];
    }

    public function getMedias($id){ # pegar dados para listar as mídias
        $query = "SELECT midias, data FROM posts WHERE id_post = $id AND id_instituto = " . session()->get('id');
        
        $data = null;
        if(isset($this->query($query)->getResult('array')[0])){
            $data = $this->filterMedias($this->query($query)->getResult('array')[0]);
        }

        return $data;
    }

    public function insertPost($data){ # inserir dados da publicação
        if((new Session)->isLogged()){
            // data atual
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $Data = new DateTime;

            // dados para inserir na tabela
            $params = [
                'institute' => session()->get('id'), // instituto
                'category' => $data['category'], // categoria
                'title' => (new Functions)->changeQuotes($data['title']), // título
                'description' => (new Functions)->changeQuotes($data['description']), // descrição
                'main_content' => $this->changePaths($data['main_content']), // conteúdo principal
                'date' => $Data->format('Y-n-d H:i:s'),
                'carousel_media' => $data['carousel_media'], // mídias do carrossel (sempre vai ser alterado no upload das mídias, a não ser que seja apenas urls de vídeos no youtube)
                
                // obs: sempre cadastrados como "null". serão adicionados ao BD na função uploadFiles.
                'img' => null, // imagem principal
            ];
            
            if ($this->query("INSERT INTO posts VALUES(0, :institute:, :category:, :date:, :title:, :description:, :img:, :carousel_media:, :main_content:, 0)", $params)){
                return true;
            } 
        }

        return false;
    }

    public function getDataUpFiles($id) { # pegar data de publicação e mídia principal 
        $query = "SELECT data, imagem_principal FROM posts WHERE id_post = $id AND id_instituto = " . session()->get('id');
        
        if($this->query($query)->getResult('array')[0]){
            return $this->query($query)->getResult('array')[0];
        }

        return false;
    }

    public function uploadNewFiles($data){ # inserir novas mídias para a publicação
        if($data['type'] === "midias"){ // mídias do carrossel
            $params = [
                'id_institute' => session()->get('id'),
                'id_post' => $data['id_post']
            ];

            $otherMedias = $this->query("SELECT midias FROM posts WHERE id_post = :id_post: AND id_instituto = :id_institute:", $params)->getResult('array')[0];

            if($otherMedias['midias'] != NULL && $otherMedias['midias'] != ''){
                $params['medias'] = $otherMedias['midias'] . ", " . $data['newNames'];
            } else {
                $params['medias'] = $data['newNames'];
            }

            $query = "UPDATE posts SET midias = :medias: WHERE id_post = :id_post: AND id_instituto = :id_institute:";
        }

        elseif($data['type'] === 'imagem_principal') { // alterar imagem principal da publicação
            $params = [
                'id_institute' => session()->get('id'),
                'main_img' => $data['newNames'],
                'id_post' => $data['id_post']
            ];

            $query = "UPDATE posts SET imagem_principal = :main_img: WHERE id_post = :id_post: AND id_instituto = :id_institute:";
        }

        if(!$this->query($query, $params)){
            return false;
        };

        return true;
    }

    public function likePost($data) { # adicionar registro de like no db
        $params = [
            'id_post' => $data['id'],
            'type' => $data['type']
        ];

        if(session()->get('type') !== null){
            if(session()->get('type') === 'institute'){ // like com user do tipo "instituto"
                $params['id_instituto'] = session()->get('id');

                if($params['type'] == 'posts'){ // like post
                    if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, NULL, :id_post:, NULL, NULL, :type:)", $params)){
                        return true;
                    }
                }
                elseif($params['type'] == 'reunioes'){ // like reunião
                    if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, NULL, NULL, :id_post:, NULL, :type:)", $params)){
                        return true;
                    }
                }
                // like relatório
                if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, NULL, NULL, NULL, :id_post:, :type:)", $params)){
                    return true;
                }
            }
            else if(session()->get('type') === 'user'){ // like com user do tipo "usuário"
                $params['id_instituto'] = session()->get('idAffiliate');
                $params['id_user'] = session()->get('idUser');

                if($params['type'] == 'posts'){ // like post
                    if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, :id_user:, :id_post:, NULL, NULL, :type:)", $params)){
                        return true;
                    }
                }
                elseif($params['type'] == 'reunioes'){ // like reunião
                    if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, :id_user:, NULL, :id_post:, NULL, :type:)", $params)){
                        return true;
                    }
                }
                // like relatório
                if($this->query("INSERT INTO avaliacoes_posts VALUES(0, :id_instituto:, :id_user:, NULL, NULL, :id_post:, :type:)", $params)){
                    return true;
                }
            }
        } 

        return false;
    }

    public function dislikePost($data) { # remover registro de like no db
        $params = [
            'id_post' => $data['id'],
            'type' => $data['type']
        ];

        if(session()->get('type') === 'institute'){ // like com user do tipo "instituto"
            $params['id_instituto'] = session()->get('id');

            if($this->query("DELETE FROM avaliacoes_posts WHERE id_instituto = :id_instituto: AND id_beneficiado IS NULL AND (id_postagem = :id_post: OR id_reuniao = :id_post: OR id_relatorio = :id_post:) AND tipo = :type:", $params)){
                return true;
            }
        }
        else if(session()->get('type') === 'user'){ // like com user do tipo "usuário"
            $params['id_instituto'] = session()->get('idAffiliate');
            $params['id_user'] = session()->get('idUser');

            if($this->query("DELETE FROM avaliacoes_posts WHERE id_instituto = :id_instituto: AND id_beneficiado = :id_user: AND (id_postagem = :id_post: OR id_reuniao = :id_post: OR id_relatorio = :id_post:) AND tipo = :type:", $params)){
                return true;
            }
        }

        return false;
    }

    public function UpFiles($data){ # registrar mídias no db
        $id_query = "SELECT id_post FROM posts WHERE id_instituto = " . session()->get('id') . " ORDER BY data DESC LIMIT 1";

        $params = [
            'name' => $data['names'],
            'column' => $data['column'],
            'id' => $this->query($id_query)->getResult("array")[0]['id_post']
        ];

        $query = str_replace("@column", $params['column'], "UPDATE posts SET @column = :name: WHERE id_post = :id:");

        if($this->query($query, $params)){
            return true;
        } 
        
        // caso não conseguir fazer o upload dos arquivos, excluir o registro do BD
        $this->query("DELETE FROM posts WHERE id_post = :id:", $params);
        return false;
    }

    public function removePost($data) { # remover publicação
        if((new Session)->isLogged()){
            $params = [
                'id' => $data['id'],
                'id_institute' => session()->get('id')
            ];

            $dataDelete = $this->query("SELECT imagem_principal, midias, data FROM posts WHERE id_post = :id:", $params)->getResult('array')[0];

            $medias = '';
            foreach ($dataDelete as $key => $value) {
                if($key != 'data' && $value != null){
                    if($medias != ''){
                        $medias .= ', ';
                    }
                    $medias .= $value;
                }
            }

            $medias = explode(', ', $medias);
            $paths = [];

            foreach (['img', 'video'] as $key_main => $mainPath) {
                $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/$mainPath/posts/" . (new DateTime($dataDelete['data']))->format('Y/n/');
                array_push($paths, $path);
            }

            if ($this->query("DELETE FROM posts WHERE id_post = :id: AND id_instituto = :id_institute:", $params)){
                if($medias[0] != ''){
                    foreach ($paths as $key => $path) {
                        (new Functions)->deleteFiles($medias, $path);
                    }
                }
                return true;
            }
        }

        return false;
    }

    public function removeFiles($data){ # remover mídias do carrossel
        $query = "SELECT midias FROM posts WHERE id_post = " . $data['id_post'] . " AND id_instituto = " . session()->get('id');

        $medias = $this->query($query)->getResult('array')[0];

        $medias = $this->popMedias($medias['midias'], $data['medias']); // remover mídias do array
          
        if($medias['midias'] === ''){
            $medias['midias'] = NULL;
        }

        $params = [
            'medias' => $medias['midias'],
            'id_institute' => session()->get('id'),
            'id_post' => $data['id_post']
        ];

        if(!$this->query("UPDATE posts SET midias = :medias: WHERE id_post = :id_post: AND id_instituto = :id_institute:", $params)){ // inserir nova string de mídias no banco de dados sem as mídias removidas
            return false;
        };

        return true;
    }

    public function removeFeaturedMedias($data){ # remover mídia principal
        $params = [
            'id_institute' => session()->get('id'),
            'id_post' => $data['id_post']
        ];

        $query = "SELECT imagem_principal FROM posts WHERE id_post = :id_post: AND id_instituto = :id_institute:";
        $medias = $this->query($query, $params)->getResult('array')[0];

        if($medias['imagem_principal'] === $data['medias'][0]){
            $query = "UPDATE posts SET imagem_principal = NULL WHERE id_post = :id_post: AND id_instituto = :id_institute:";
            $type = 'img';
        } 
        else {
            return ['bool' => 'false'];
        }

        if(!$this->query($query, $params)){
            return ['bool' => 'false'];
        };

        return ['bool' => 'true', 'type' => $type];
    }

    public function updateOrder($data){ # trocar a ordem de exibição das mídias da publicação
        if((new Session)->isLogged()){
            $params = [
                'medias' => implode(', ', $data['current_order']),
                'id_post' => $data['id_post'],
                'id_institute' => session()->get('id')
            ];

            if($this->query("UPDATE posts SET midias = :medias: WHERE id_post = :id_post: AND id_instituto = :id_institute:", $params)){
                return true;
            };
        }
        return false;
    }

    public function updatePost($data){ # alterar dados da publicação
        if((new Session)->isLogged()){
            $params = [
                'id_institute' => session()->get('id'),
                'id_post' => $data['id_post'],
                'title' =>  (new Functions)->changeQuotes($data['title']),
                'description' => (new Functions)->changeQuotes($data['description']),
                'main_content' => $this->changePaths($data['main_content']),
            ];

            $query = 'UPDATE posts SET titulo = :title:, descricao = :description:, conteudo = :main_content:';

            $query .= ' WHERE id_post = :id_post: AND id_instituto = :id_institute:';

            if($this->query($query, $params)){
                return true;
            }
            
        }
        return false;
    }

    public function highlight($data){ # alterar destaque das publicações
        if((new Session)->isLogged()){
            $params = [
                'id_post' => $data['id'],
                'id_institute' => session()->get('id'),
                'highlight' => $data['highlight']
            ];

            if($data['highlight'] === true){
                $count = $this->query("SELECT COUNT(0) as highlights FROM posts WHERE id_instituto = :id_institute: AND destaque = true", $params)->getResult('array')[0]['highlights']; // contar quantidade de destaques

                if($count >= 4){
                    return false;
                }
            }

            $query = "UPDATE posts SET destaque = " . $params['highlight'] . " WHERE id_post = :id_post: AND id_instituto = :id_institute:";

            if($this->query($query, $params)){
                return true;
            }
        }

        return false;
    }

    private function getQuery($filters, $type){ # adicionar filtros na pesquisa
        if($type == 'data'){
            $query = 'SELECT id_post, titulo, data, destaque FROM posts WHERE id_instituto = :institute: ';
        } else {
            $query = 'SELECT COUNT(id_post) as num_records FROM posts WHERE id_instituto = :institute: ';
        }
        
        if($filters['initial_date'] !== ''){
            $query .= "AND data >= '" . $filters['initial_date'] . "' ";
        }
        
        if($filters['final_date'] !== ''){
            // add H:i:s
            $final = $filters['final_date'] . '23:59:59';
            $filters['final_date'] = (new DateTime($final))->format('Y-m-d H:i:s');

            $query .= "AND data <= '" . $filters['final_date'] . "' ";
        }

        if($filters['name'] !== ''){
            $query .= "AND titulo like '%". $filters['name'] ."%' ";
        }

        if($filters['id_category'] !== ''){     
            if($filters['id_category'] == '2'){
                $query .= "AND (id_categoria = '2' OR  id_categoria = '3')";
            } else {
                $query .= "AND id_categoria = '". $filters['id_category'] ."' ";
            }
        }

        if($filters['highlighted'] !== ''){
            $query .= "AND destaque = '" . $filters['highlighted'] . "'"; 
        }

        if($type == 'data'){
            $query .= "ORDER BY data ". $filters['order'] ." LIMIT :start:, :qntResultPgs:";
        }

        return $query;
    }

    private function filterMedias($data){ # filtrar tipos de mídia
        if($data['midias'] !== NULL && $data['midias'] !== ''){
            // transformar str midias em array 
            $allMedias = explode(',', $data['midias']);
            
            // definir array's
            $medias = [];
            
            // separar links dos videos e imagens
            foreach ($allMedias as $key => $media) {
                if(pathinfo(trim($media), PATHINFO_EXTENSION) === ""){
                    $type = 'url';
                }
                elseif(in_array(pathinfo(trim($media), PATHINFO_EXTENSION), ["png", "jpg", "jpeg"])){
                    $type = 'img';
                } 
                else {
                    $type = 'video';
                }
    
                array_push($medias, ['nome' => trim($media), 'tipo' => "$type"]);
            }
    
            // alterar arrayy de midias para um array sem url's 
            $data['midias'] = $medias;
        }

        return $data;
    }

    private function popMedias($data, $removeMedias){ # remover mídias do array
        $medias = explode(', ', $data);
        
        foreach ($removeMedias as $key => $remove) {
            $key = array_search($remove, $medias);
            if($key!==false){
                unset($medias[$key]);
            }
        }

        return['midias' => implode(', ', $medias)];
    }

    private function changePaths($mainContent){ # mudar os caminhos locais das mídias do conteúdo da publicação
        if(isset($mainContent)){
            $html5 = new HTML5();
            $dom = $html5->loadHTML($mainContent);
    
            \libxml_use_internal_errors(true);
            
            $tagNames = ['img', 'source', 'a']; // tags HTML que podem conter os caminhos locais 
            $srcRemove = [base_url(), '../', 'public/', '/' . strtolower(session()->get('name')) . '/'];
            $replace = ['', '', '', '/@institute@/'];
    
            foreach ($tagNames as $tag) { 
                foreach ($dom->getElementsByTagName($tag) as $mediaEl) { // elementos HTML selecionados pela tag 
                    if($mediaEl->getAttribute('src') ==! null){ // verifica se o conteúdo do atributo src das imagens e vídeos não está vazio 
                        $mediaEl->attributes->getNamedItem('src')->nodeValue = base_url(str_replace($srcRemove, $replace, $mediaEl->getAttribute('src')));
                    }
                    else if($mediaEl->getAttribute('href') ==! null){ // verifica se o conteúdo do atributo href dos links para pdf's não está vazio
                        $mediaEl->attributes->getNamedItem('href')->nodeValue = base_url(str_replace($srcRemove, $replace, $mediaEl->getAttribute('href')));
                    }
                }
            }
    
            \libxml_use_internal_errors(false);
    
            return $dom->saveHTML($dom->documentElement); // retornar novo html com os caminhos alterados
        }
        return null;
    }

    private function addInstituteToLocalPathMedia($content, $institute) { # adicionar ao caminho local das mídias o nome do instituto 
        return preg_replace( '/@institute@/', strtolower($this->getInstituteName($institute)), $content);
    }

    private function getInstituteName($id){
        return (new SessionModel)->getInstituteName($id);
    } 
}