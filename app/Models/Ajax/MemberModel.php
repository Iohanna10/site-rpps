<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use App\Models\Functions\Functions;
use CodeIgniter\Model;

class MemberModel extends Model {

    protected $table = 'membros';
    protected $primaryKey = 'id_post';
    protected $allowedFields = ['id_instituto', 'id_categoria', 'titulo', 'descricao', 'imagem_principal', 'imagens', 'conteudo', 'destaque'];

    /** Inserir integrante */
    public function insertMember($data) { # inserir dados do integrante no banco de dados
        if((new Session)->isLogged()){
            // qntd de membros já registrados 
            $count = $this->query("SELECT COUNT(id) FROM membros WHERE id_instituto = :institute: AND equipe = :council:", $data)->getResultObject();

            // dados para inserir na tabela
            $params = [
                'institute' => $data['institute'], // instituto
                'cpf' => $data['cpf'], // cpf
                'name' => $data['name'], // nome
                'tel' => $data['tel'], // tel
                'email' => $data['email'], // email
                'member_position' => $data['member_position'], // área de atuação
                'member_location' => $data['member_location'], // local de atuação
                'holder' => $data['holder'], // titular
                'certification' => $data['certification'], // certificado
                'council' => $data['council'], // conselho
                'order' => intval($count[0]->{'COUNT(id)'}),

                // obs: sempre cadastrados como "null". serão adicionados ao BD na função uploadFiles.
                'img' => null, // imagem principal
            ];

            if($this->verifyRegistered($params) == false){
            
                if ($this->query("INSERT INTO membros VALUES(0, :institute:, :cpf:, :name:, :tel:, :email:, :member_position:, :member_location:, :holder:, :certification:, :council:, :img:, :order:, 1)", $params)){
                    return ['msg' => 'Cadastro realizado com sucesso.', 'bool' => true];
                }
            } else {
                return ['msg' => $this->verifyRegistered($params), 'bool' => false];
            }
        }
        
        return ['msg' => ['db', "Erro ao tentar criar o cadastro."], 'bool' => false];
    }

    /** Verificar se o integrante já está cadastrado */
    private function verifyRegistered($data) { # verificar se já está registrado 
        $params = [
            'id' => $data['institute'],
            'cpf' => $data['cpf'],
            'council' => $data['council'],
        ];
        
        if($this->query("SELECT id FROM membros WHERE cpf = :cpf: AND id_instituto = :id: AND equipe = :council:",$params)->getResultObject() != null)
        {
            return ['cpf', 'este CPF já está cadastrado neste conselho!'];
        }

        return false;
    }

    /** Inserir foto de perfil */
    public function UpFiles($data){ # adicionar nome da foto de perfil ao banco de dados
        $id_query = "SELECT id FROM membros WHERE id_instituto = " . session()->get('id') . " AND equipe = " . $data['council'] . " ORDER BY id DESC LIMIT 1";

        $params = [
            'name' => $data['name'],
            'id' => $this->query($id_query)->getResult("array")[0]['id']
        ];
        
        if($this->query("UPDATE membros SET foto = :name: WHERE id = :id:", $params)){
            return true;
        }

        return false;
    }

    /** Inserir foto de perfil */
    public function updateFiles($name, $id){ # alterar nome da foto de perfil ao banco de dados
        $params = [
            'name' => $name,
            'id' => $id
        ];

        if($this->query("UPDATE membros SET foto = :name: WHERE id = :id:", $params)){
            return true;
        }

        return false;
    }    

    /** Alterar ordem de exibição dos integrantes da equipe */
    public function updateOrder($data) { # alterar ordem de exibição dos integrantes da equipe
        if((new Session)->isLogged()){
            $params = [
                'team' => $data['team']
            ];

            foreach ($data['current_order'] as $order => $id) {
                $query = "UPDATE membros SET ordem = $order WHERE id = $id AND equipe = :team:";

                if(!$this->query($query, $params)){
                    return false;
                }
            }

            return true;
        }
    }

    /** Alterar informação do integrante */
    public function changeInfos($data) { # alterar informações dos membros
        if((new Session)->isLogged()){
            $params = [
                'id' => $data['id'],
                'council' => $data['council'],
                'nome' => $data['name'],
                'cpf' => $data['cpf'],
                'email' => $data['email'],
                'numero' => $data['tel'],
                'certificacao' => $data['certificate'],
                'area_de_atuacao' => $data['member_position'],
                'local_atuacao' => $data['member_location'],
                'titular' => $data['holder'],
            ];

            $check = $this->query("SELECT COUNT(0) as checkCpf FROM membros WHERE cpf = :cpf: AND id != :id: AND equipe = :council:", $params)->getResult('array')[0]['checkCpf'];
            if($check > 0){
                return ['msg' => 'cpf_error', 'bool' => false];
            }

            if($this->query($this->createQuery($params, $data))){
                return true;
            }
        }
        return  ['msg' => '', 'bool' => false];;
    }

    /** Remover integrante */
    public function removeMember($data) { # remover membro
        if((new Session)->isLogged()){

            $params = [
                'id' => $data['id']
            ];

            $dataDelete = $this->query("SELECT foto FROM membros WHERE id = :id:", $params)->getResult('array')[0];

            switch ($data['council']) {
                case '0':
                    $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/img/team/committee/team/";
                    break;
                case '1':
                    $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/img/team/committee/investment/";
                    break;
                case '2':
                    $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/img/team/committee/fiscal/";
                    break;
                case '3':
                    $path = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name')) . "/assets/uploads/img/team/committee/deliberative/";
                    break;
            } 

            if ($this->query("DELETE FROM membros WHERE id = :id:", $params)){
                (new Functions)->deleteFiles([$dataDelete['foto']], $path);
                return true;
            }
        }

        return false;
    }

    /** Retornar imagem principal */
    public function getImg($id) { # pegar imagem principal/foto do integrante
        return $this->query("SELECT foto FROM membros WHERE id = ?", $id)->getResult('array')[0]['foto'];
    }

    /** Retornar uma query para o banco de dados */
    private function createQuery($params, $data) { # criar query para o banco de dados
        $query = 'UPDATE membros SET ';

        foreach ($params as $key => $value) {
            if($value ==! null && $value ==! '' && $key != 'id' && $key != 'council'){
                $query .= "$key = '$value', ";
            }
            elseif($key != 'id' && $key != 'council') {
                $query .= "$key = NULL, ";
            }
        }

        $query = rtrim($query, ", ");
        $query .= " WHERE id_instituto = '" . session()->get('id') . "' AND id = '". $data['id'] ."'";
        return $query;
    }

    /** Retornar integrantes do instituto */
    public function getTeam($id, $pg, $team){
        $qntResultPgs = 30; // quantidade max de registros do db por página

        $params = [
            'institute' => $id,
            'team' => $team,
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM membros WHERE id_instituto = :institute: AND equipe = :team:", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação 
        
        $dbData = $this->query("SELECT id, nome FROM membros WHERE id_instituto = :institute: AND equipe = :team: ORDER BY ordem ASC LIMIT :start:, :qntResultPgs:", $params)->getResult("array");

        $dataArray = [
            'dbData' => $dbData,
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }
}