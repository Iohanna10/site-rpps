<?php

namespace App\Models\InnerPages;

use App\Models\Ajax\MeetingsModel;
use App\Models\Ajax\PostModel;
use CodeIgniter\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function searchPost($id, $pg, $search, $filters) { # pegar dados de pesquisa de publicações
        $qntResultPgs = 20; # quantidade max de registros do db por página

        $params = [
            'instituteId' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, # onde começa a contagem p/ pegar os registros do banco de dados
            'search' => '%' . $search . '%',
        ];

        // nº total de registros
        $totalRecordsPosts = $this->query($this->insertFilters("SELECT COUNT(id_post) AS num_records FROM posts WHERE id_instituto = :instituteId: AND (titulo like :search: OR descricao like :search:)", $filters, false), $params)->getResultObject(); # posts

        // var_dump($this->getLastQuery()->getQuery());
    
        $totalRecordsMeetings = $this->query($this->insertFilters("SELECT COUNT(id) AS num_records FROM reunioes_eventos WHERE id_instituto = :instituteId: AND (titulo like :search: OR descricao like :search:) AND tipo = 'reuniao'", $filters, false), $params)->getResultObject(); # reuniões
        
        $totalRecords = $totalRecordsPosts[0]->{'num_records'} + $totalRecordsMeetings[0]->{'num_records'};
        
        $qntPg = ceil($totalRecords / $qntResultPgs);  # qunatidade de páginas para a paginação

        // dados juntos (posts e reuniões) 
        $dbData = []; # array para juntar os dados 

        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id_post AS id, titulo, descricao, imagem_principal, data FROM posts WHERE id_instituto = :instituteId: AND (titulo like :search: OR descricao like :search:)", $filters, true), $params)->getResult('array'), $params, $filters['order'], 'posts'); # dados posts
        
        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id, titulo, descricao, imagem_principal, data, reunioes FROM reunioes_eventos WHERE id_instituto = :instituteId: AND (titulo like :search: OR descricao like :search:) AND tipo = 'reuniao'", $filters, true), $params)->getResult('array'), $params, $filters['order'], 'reunioes'); # dados reuniões

        $dbData = array_slice($dbData, $params['start'], $qntResultPgs); # limitar array com somente 20 registros por pg

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg,
            'totalRecords' => $totalRecords,
            'id_route' => $search, 
        ];

        return $dataArray;
    }
    
    
    public function getAllPosts($id, $pg, $filters) { # pegar dados de todas publicações
        $qntResultPgs = 20; # quantidade max de registros do db por página

        $params = [
            'instituteId' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, # onde começa a contagem p/ pegar os registros do banco de dados
        ];

        // nº total de registros
        $totalRecordsPosts = $this->query($this->insertFilters("SELECT COUNT(id_post) AS num_records FROM posts WHERE id_instituto = :instituteId:", $filters, true), $params)->getResultObject(); // posts

        $totalRecordsMeetings = $this->query($this->insertFilters("SELECT COUNT(id) AS num_records FROM reunioes_eventos WHERE id_instituto = :instituteId: AND tipo = 'reuniao'" , $filters, true), $params)->getResultObject(); // reuniões
        
        $totalRecords = $totalRecordsPosts[0]->{'num_records'} + $totalRecordsMeetings[0]->{'num_records'};
        
        $qntPg = ceil($totalRecords / $qntResultPgs);  # qunatidade de páginas para a paginação

        // fim nº total de registros

        // dados juntos (posts + reuniões) 
        $dbData = []; // juntar dados posts e reuniões       

        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id_post AS id, titulo, descricao, imagem_principal, data FROM posts WHERE id_instituto = :instituteId:", $filters, true), $params)->getResult('array'), $params, $filters['order'], 'posts');

        
        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id, titulo, descricao, imagem_principal, data, reunioes FROM reunioes_eventos WHERE id_instituto = :instituteId: AND tipo = 'reuniao'", $filters, true), $params)->getResult('array'), $params, $filters['order'], 'reunioes');

        // fim dados juntos

        // limitar array com somente 20 registros por pg
        $dbData = array_slice($dbData, $params['start'], $qntResultPgs);
        // fim limitar array

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }
    
    public function getPublicTenders($id, $pg, $filters) { # pegar dados das publicações de concursos
        $qntResultPgs = 20; # quantidade max de registros do db por página

        $params = [
            'instituteId' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, # onde começa a contagem p/ pegar os registros do banco de dados
        ];

        // nº total de registros
        $totalRecords = $this->query($this->insertFilters("SELECT COUNT(id_post) AS num_records FROM posts WHERE id_instituto = :instituteId: AND (id_categoria = 2 OR  id_categoria = 3)", $filters, false), $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs);  # qunatidade de páginas para a paginação

        $dbData = [];
        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id_post AS id, titulo, descricao, imagem_principal, data FROM posts WHERE id_instituto = :instituteId: AND (id_categoria = 2 OR id_categoria = 3)", $filters, true), $params)->getResult("array"), $params, $filters['order'], 'posts');

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    public function requireArea($routes) { 
        return $this->requireCategoryId($routes);
    }

    Public function getPosts($id, $pg, $id_route, $filters) { # pegar publicações de categoria especifica
        $qntResultPgs = 20; # quantidade max de registros do db por página

        $params = [
            'instituteId' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, # onde começa a contagem p/ pegar os registros do banco de dados
            'id_route' => $id_route
        ];

        // nº total de registros
        $totalRecords = $this->query($this->insertFilters("SELECT COUNT(id_post) AS num_records FROM posts WHERE id_instituto = :instituteId: AND id_categoria = :id_route:", $filters, false), $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); # qunatidade de páginas para a paginação

        $dbData = [];
        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id_post AS id, titulo, descricao, imagem_principal, data FROM posts WHERE id_instituto = :instituteId: AND id_categoria = :id_route:", $filters, true), $params)->getResult("array"), $params, $filters['order'], 'posts');

        $dataArray = [
            'id_route' => $id_route, 
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    public function calendarCommittee($id, $pg, $id_route, $filters) { // pegar publicacões dos comitês (publicações e reuniões)

        $qntResultPgs = 20; # quantidade max de registros do db por página 

        $params = [
            'instituteId' => $id,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, # onde começa a contagem p/ pegar os registros do banco de dados
            'id_route' => $id_route
        ];

        // nº total de registros
        $totalRecordsPosts = $this->query($this->insertFilters("SELECT COUNT(id_post) AS num_records FROM posts WHERE id_instituto = :instituteId: AND id_categoria = :id_route:", $filters, false), $params)->getResultObject(); # posts
       
        $totalRecordsMeetings = $this->query($this->insertFilters("SELECT COUNT(id) AS num_records FROM reunioes_eventos WHERE id_instituto = :instituteId: AND id_categoria = :id_route: AND tipo = 'reuniao'", $filters, false), $params)->getResultObject(); # reuniões
        
        $qntPg = ceil(($totalRecordsPosts[0]->{'num_records'} + $totalRecordsMeetings[0]->{'num_records'}) / $qntResultPgs); # qunatidade de páginas para a paginação

        //  juntar dados (posts e reuniões)   
        $dbData = []; # array para juntar dados 

        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id_post AS id, titulo, descricao, imagem_principal, data FROM posts WHERE id_instituto = :instituteId: AND id_categoria = :id_route:", $filters, false), $params)->getResult('array'), $params, $filters['order'], 'posts'); # dados posts

        $dbData = $this->dbData($dbData, $this->query($this->insertFilters("SELECT id, titulo, descricao, imagem_principal, data, reunioes FROM reunioes_eventos WHERE id_instituto = :instituteId: AND id_categoria = :id_route: AND tipo = 'reuniao'", $filters, false), $params)->getResult('array'), $params, $filters['order'], 'reunioes'); # dados reuniões
        
        $dbData = array_slice($dbData, $params['start'], $qntResultPgs); # limitar array com somente 20 registros por pg

        $dataArray = [
            'id_route' => $id_route, 
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }

    public function getPost($id) { # pegar dados de determinada publicação
        $params = [
            "id_post" => $id,
            "id_institute" => session()->get('id'),
            "array" => true
        ];

        if($this->query("SELECT COUNT(0) as validId FROM posts WHERE id_post = :id_post: AND id_instituto = :id_institute:", $params)->getResult('array')[0]['validId'] > 0){
            return (new PostModel)->posts($params);
        }  

        return false;
    }

    public function getEvent($id) { # pagar dados de determinado evento
        $params = [
            "id" => $id,
            "id_institute" => session()->get('id'),
        ];

        if($this->query("SELECT COUNT(0) as validId FROM reunioes_eventos WHERE id = :id: AND id_instituto = :id_institute:", $params)->getResult('array')[0]['validId'] > 0){
            return (new MeetingsModel)->getDataEvents($params);
        }  
        
        return false;
    }


    private function dbData($array, $data, $params, $order, $type) { # pegar dados do banco de dados 
        foreach ($data as $key => $register) {
            

            $register['htmlConstructorType'] = $type;
            $params['type'] = $type; // tipo de postagem
            $params['id'] = $register['id'];

            $register['avaliacoes'] =  $this->query("SELECT COUNT(id) as likes FROM avaliacoes_posts WHERE id_instituto = :instituteId: AND (id_postagem = :id: OR id_reuniao = :id:) AND tipo = :type:", $params)->getResult('array')[0]['likes'];

            $register['avaliadoBool'] = $this->reted($params); # verificar se está ou não com avaliação e adicionar bool ao array para mudar classe no html de acordo com ele

            array_push($array, $register);
        }

        return $this->sortData($array, $order);
    }

    private function reted($params) { # verificar se o post está avaliado 
        if(session()->get('type') !== null){

            if(session()->get('type') === 'institute'){ // like com user do tipo "instituto"

                if($this->query("SELECT COUNT(id) AS reted FROM avaliacoes_posts WHERE id_instituto = :instituteId: AND (id_postagem = :id: OR id_reuniao = :id:) AND id_beneficiado IS NULL AND tipo = :type:", $params)->getResult('array')[0]['reted'] >= 1){
                    return true;
                }

            }
            else if(session()->get('type') === 'user'){ // like com user do tipo "instituto"
                $params['user_id'] = session()->get('idUser');

                if($this->query("SELECT COUNT(id) AS reted FROM avaliacoes_posts WHERE id_instituto = :instituteId: AND (id_postagem = :id: OR id_reuniao = :id:) AND id_beneficiado = :user_id: AND tipo = :type:", $params)->getResult('array')[0]['reted'] >= 1){
                    return true;
                }
            }
        } 
        return false;
    }

    private function sortData($arr, $order) { # organizar ordem de visualização mais antigo/recente ingrando posts e reuniões
        if($order == 'DESC'){ // organizar do mais recente ao mais antigo
            array_multisort(array_map(function ($element){
                return $element['data'];
            }, $arr), SORT_DESC, $arr);
        } 
        else {
            array_multisort(array_map(function ($element){ // organizar do mais antigo ao mais recente 
                return $element['data'];
            }, $arr), SORT_ASC, $arr);
        }

        return $arr;
    }

    private function insertFilters($query, $filters, $boolLimit) { # inserir filtros na query
        if($filters['initial_date'] != ''){ // data inicial de busca para os posts
            $query .=  " AND DATE(data) >= '" . $filters['initial_date'] ."'";
        }
        if($filters['final_date'] != ''){ // data final de procura para os posts
            $query .=  " AND DATE(data) <= '" . $filters['final_date'] ."'";
        }

        // if($boolLimit){ // limite de itens?
        //     $query .= " LIMIT :start:, :qntResultPgs:";        
        // }

        return $query;
    }

    private function requireCategoryId($routes) { # encontrar id da categoria
        $count = 1;
        $route = [];

        foreach ($routes as $key => $sub) {
            if($key == 'sub' . strval($count)){
                array_push($route, $sub);
                $count++;
            } 
            elseif($key == 'current'){
                array_push($route, $sub);
            }

        }

        $route = implode('/', $route);

        # ocorrências 
        $occurrences = [
            'historico', /* id da categoria = 0 */
            'codigo-de-etica', /* id da categoria = 1 */
            'concursos', /* id da categoria = 2 */
            'concursos/processo-seletivo', /* id da categoria = 3 */
            'educacao-previdenciaria', /* id da categoria = 4 */
            'plano-de-acao', /* id da categoria = 5 */
            'gestao-e-controle-interno', /* id da categoria = 6 */
            'seguranca-da-informacao', /* id da categoria = 7 */
            'manual-de-procedimentos-de-beneficio', /* id da categoria = 8 */
            'manual-de-arrecadacao', /* id da categoria = 9 */
            'manual-de-procedimentos', /* id da categoria = 10 */
            'constituicao-federal', /* id da categoria = 11 */
            'instrucoes-normativas-mps', /* id da categoria = 12 */
            'leis-federais', /* id da categoria = 13 */
            'orientacoes-mps', /* id da categoria = 14 */
            'portarias-mps', /* id da categoria = 15 */
            'resolucoes-cmn', /* id da categoria = 16 */
            'leis-municipais', /* id da categoria = 17 */
            'portarias', /* id da categoria = 18 */
            'audiencia-publica', /* id da categoria = 19 */
            'balancete-anual', /* id da categoria = 20 */
            'balancete-mensal', /* id da categoria = 21 */
            'demonstrativos-financeiro', /* id da categoria = 22 */
            'demonstrativos-das-aplicacoes-e-investimentos-de-recursos', /* id da categoria = 23 */
            'demonstrativo-de-informacoes-previdenciarios-e-repasses', /* id da categoria = 24 */
            'parcelamentos', /* id da categoria = 25 */
            'politica-de-investimentos', /* id da categoria = 26 */
            'acordaos-de-tce', /* id da categoria = 27 */
            'certidoes-negativas', /* id da categoria = 28 */
            'cronogramas-de-pagamentos', /* id da categoria = 29 */
            'contratos-e-licitacoes', /* id da categoria = 30 */
            'comite-de-investimento/calendario-de-reunioes', /* id da categoria = 31 */
            'comite-de-investimento/atas-de-reunioes', /* id da categoria = 32 */
            'comite-de-investimento/resolucoes', /* id da categoria = 33 */
            'comite-de-investimento/regime-interno', /* id da categoria = 34 */
            'comite-de-investimento/composicao-da-carteira-e-investimentos', /* id da categoria = 35 */
            'comite-de-investimento/politica-de-investimento', /* id da categoria = 36 */
            'comite-de-investimento/credenciamento-das-instituicoes-financeiras', /* id da categoria = 37 */
            'comite-de-investimento/relatorio-mensal-de-investimentos', /* id da categoria = 38 */
            'comite-de-investimento/relatorio-anual-de-investimentos', /* id da categoria = 39 */
            'comite-de-investimento/aplicacoes-e-resgates', /* id da categoria = 40 */
            'comite-de-investimento/estudo-de-alm', /* id da categoria = 41 */
            'fiscal/calendario-de-reuniao', /* id da categoria = 42 */
            'fiscal/atas-das-reunioes', /* id da categoria = 43 */
            'fiscal/resolucoes', /* id da categoria = 44 */
            'fiscal/regime-interno', /* id da categoria = 45 */
            'deliberativo/calendario-de-reuniao', /* id da categoria = 46 */
            'deliberativo/atas-das-reunioes', /* id da categoria = 47 */
            'deliberativo/resolucoes', /* id da categoria = 48 */
            'deliberativo/regime-interno', /* id da categoria = 49 */
            'publicacoes/informativo-semestral', /* id da categoria = 50 */
            'segurados/solenidade', /* id da categoria = 51 */
            'segurados/cartilha-previdenciaria', /* id da categoria = 52 */
        ];

        for ($routeId = 0; $routeId < count($occurrences); $routeId++) { // id da rota
            if ($route == $occurrences[$routeId]) {
                return $routeId;
            }
        }

    }
}