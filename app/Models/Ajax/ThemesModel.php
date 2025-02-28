<?php

namespace App\Models\Ajax;

use App\Models\Functions\Functions;
use CodeIgniter\Model;
use DateTime;

class ThemesModel extends Model
{
    protected $table = 'instituto';

    public function getDefaultTheme($id) { # retornar tema padrão
        $params = [
            'id' => $id
        ];

        return $this->query("SELECT id, nome, cor_principal, cor_secundaria, cor_destaque, efeitos_visuais, banner, url_banner, predefinido FROM instituto_temas WHERE id_instituto = :id: AND padrao = 1", $params)->getResult('array')[0];
    }

    public function getTheme($id) { # retornar tema específico
        $params = [     
            'id' => $id
        ];

        return $this->query("SELECT id, nome, cor_principal, cor_secundaria, cor_destaque, efeitos_visuais, banner, url_banner, data_inicio, data_final, predefinido FROM instituto_temas WHERE id = :id:", $params)->getResult('array')[0];
    }

    public function getThemes($pg, $filters, $type) { # retornar todos os temas
        $qntResultPgs = 10; // quantidade max de registros do bd por página

        $params = [
            'institute' => session()->get('id'),
            'qntResultPgs' => $qntResultPgs, 
            'type' => 0,
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        if($type === 'preset') {
            $params['type'] = 1;
        }
        
        $dbData = $this->query($this->getQueryFilters($filters, ''), $params)->getResult("array");
        $dbData = $this->filterDate($dbData, $filters);

        // nº total de registros
        $totalRecords = count($dbData);
        $qntPg = ceil($totalRecords / $qntResultPgs); // qunatidade de páginas para a paginação 

        $dbData = array_slice($dbData, $params['start'], $qntResultPgs);  // limitar quantidade de resultados por pg

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg,
        ];

        return $dataArray;
    }

    public function getCustomizations($institute) {
        
        $params = [
            'institute' => $institute
        ];

        $data = $this->query("SELECT cor_principal, cor_secundaria, cor_destaque, efeitos_visuais, banner, url_banner, data_inicio, data_final, predefinido FROM instituto_temas WHERE id_instituto = :institute: AND ativo = 1 AND DATE_FORMAT(data_inicio, '%m-%d') <= DATE_FORMAT(NOW(), '%m-%d') AND DATE_FORMAT(data_final, '%m-%d') >= DATE_FORMAT(NOW(), '%m-%d')", $params)->getResult("array");

        return $this->filterCustomizations($data);
    }

    public function changeActivity($data) {
        $params = [
            'id' => $data['id'],
            'activity' => 1,
        ];

        if($data['activity'] == 'false'){
            $params['activity'] = 0;
        }

        if(!$this->query("UPDATE instituto_temas SET ativo = :activity: WHERE id = :id:", $params)){
            return false;
        }
        return true;
    }

    public function removeTheme($data) {
        $params = [
            'id' => $data['id'],
        ];

        $banner = $this->isBannerSet($params['id']);
        if($banner !== false){
            $path = FCPATH . "dynamic-page-content/". strtolower(session()->get('name')) ."/assets/uploads/img/banners/";
            (new Functions)->deleteFiles([$banner], $path);
        }

        if(!$this->query("DELETE FROM instituto_temas WHERE id = :id:", $params)){
            return false;
        }
        return true;
    }

    public function registerTheme($data) { # registrar tema no DB
        $params = [
            'id_institute' => $data['id_institute'],
            'name' => $data['name'],
            'primary' => $data['primary'],
            'secundary' => $data['secundary'],
            'hover' => $data['hover'],
            'url_banner' => $data['url_banner'],
            'initial_date' => (new DateTime($data['initial_date']))->format("Y-n-d"),
            'final_date' => (new DateTime($data['final_date']))->format("Y-n-d"),
            'effects' => $data['effects']
        ];
        
        if($this->query("INSERT INTO instituto_temas VALUES(0, :id_institute:, :name:, :primary:, :secundary:, :hover:, NULL, :url_banner:, :initial_date:, :final_date:, :effects:, 0, 0, 0)", $params)){
            return ['bool' => true, 'id' => $this->db->insertID()];
        };

        return ['bool' => false];
    }

    public function setBanner($banner, $id, $path) {
        // verificar no BD se já existe algum banner associado 
        $currentBanner = $this->isBannerSet($id);

        if($this->db->table('instituto_temas')->update(['banner' => $banner], ['id' => $id])){ // foi possível alterar o banner no BD? 
            if($currentBanner !== false) { // excluir banner anterior (caso existir)
                (new Functions)->deleteFiles([$currentBanner], $path);
            }
            return true;
        }

        return false;
    }

    public function updateTheme($data, $default = true) {
        if($default){ // tema padrão
            if($this->db->table('instituto_temas')->update(
                [ // set
                    'cor_principal' => $data['primary'],
                    'cor_secundaria' => $data['secundary'],
                    'cor_destaque' => $data['hover'],
                    'url_banner' => $data['url_banner']
                ], 
                [ // where
                    'id' => $data['id_theme']
                ])
            ){
                return true;
            }
        }

        else { // meus temas
            if($this->db->table('instituto_temas')->update(
                [ // set
                    'nome' => $data['name'],
                    'cor_principal' => $data['primary'],
                    'cor_secundaria' => $data['secundary'],
                    'cor_destaque' => $data['hover'],
                    'url_banner' => $data['url_banner'],
                    'data_inicio' => $data['initial_date'],
                    'data_final' => $data['final_date'],
                    'efeitos_visuais' => $data['effects']
                ], 
                [ // where
                    'id' => $data['id_theme']
                ])
            ){
                return true;
            }
        }

        return false;
    }

    private function isBannerSet($id) { # já está setado um banner?
        // buscar dados do db
        $banner = $this->db->table('instituto_temas')->select('banner')->where(['id' => $id])->get(1)->getResult('array');

        if(count($banner) === 1){
            return $banner[0]['banner']; // retorna o único item do array
        }

        return false;
    }

    private function getQueryFilters($filters, $type){ # adicionar filtros na pesquisa
        if($type == 'data'){
            $query = 'SELECT id, nome, cor_principal, cor_secundaria, cor_destaque, banner, data_inicio, data_final, efeitos_visuais, ativo FROM instituto_temas WHERE id_instituto = :institute:';
        }
        else {
            $query = 'SELECT id, nome, ativo, data_inicio, data_final FROM instituto_temas WHERE id_instituto = :institute: AND predefinido = :type: AND padrao <> 1 ';
        }

        if($filters['name'] !== ''){
            $query .= "AND nome like '%". $filters['name'] ."%' ";
        }

        $query .= "ORDER BY MONTH(data_inicio), DAY(data_inicio) ASC ";

        if($type == 'data'){
            $query .= " LIMIT :start:, :qntResultPgs:";
        }

        return $query;
    }

    private function filterCustomizations($themes) {
        $initialDate = strtotime((new DateTime($themes[0]['data_inicio']))->format('m/d')); // data inicial do tema
        $finalDate = strtotime((new DateTime($themes[0]['data_final']))->format('m/d')); // data final do tema
        $customization = $themes[0]; // customizações
        
        foreach ($themes as $key => $theme) { # pegar data mais especifica entre um intervalo de dois pontos

            $currentInitial = strtotime((new DateTime($theme['data_inicio']))->format('m/d')); // início corrente de comparação
            $currentFinal = strtotime((new DateTime($theme['data_final']))->format('m/d')); // final corrente de comparação

            if($currentInitial > $initialDate) { 
                $customization = $theme;
            }
            elseif ($currentInitial == $initialDate && $currentFinal < $finalDate) {
                $customization = $theme;
            }
            else {
                continue;
            }

            $initialDate = $currentInitial;
            $finalDate = $currentFinal;
            
        }

        return $customization;
    }

    private function filterDate($themes, $filters) { # filtar reuniões e eventos pela data
        // data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $fullyFiltered = []; // array de eventos totalmente filtrados

        $initial_date = strtotime((new DateTime($filters['initial_date']))->format('m/d')); // data inicial
        $final_date = strtotime((new DateTime($filters['final_date']))->format('m/d')); // data final

        foreach ($themes as $key => $theme) { 
            $startTheme = strtotime((new DateTime($theme['data_inicio']))->format('m/d'));
            $endTheme = strtotime((new DateTime($theme['data_final']))->format('m/d'));

            if($filters['initial_date'] !== '' && $filters['final_date'] !== ''){
                if($startTheme >= $initial_date && $endTheme <= $final_date){
                    array_push($fullyFiltered, ['id' => $theme['id'], 'nome' => $theme['nome'], 'ativo' => $theme['ativo']]);
                }
            }
            elseif($filters['initial_date'] !== ''){
                if($startTheme >= $initial_date){
                    array_push($fullyFiltered, ['id' => $theme['id'], 'nome' => $theme['nome'], 'ativo' => $theme['ativo']]);
                }
            }
            elseif ($filters['final_date'] !== '') {
                if($endTheme <= $final_date){
                    array_push($fullyFiltered, ['id' => $theme['id'], 'nome' => $theme['nome'], 'ativo' => $theme['ativo']]);
                }
            }
            else {
                array_push($fullyFiltered, ['id' => $theme['id'], 'nome' => $theme['nome'], 'ativo' => $theme['ativo']]);
            }
        }

       return $fullyFiltered;
    }
}