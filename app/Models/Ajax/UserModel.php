<?php

namespace App\Models\Ajax;

use App\Controllers\Ajax\Posts;
use App\Controllers\Session;
use App\Models\Functions\Functions;
use App\Models\Session\SessionUserModel;
use CodeIgniter\Model;
use DateTime;

class UserModel extends Model {

    protected $table = 'beneficiados';
    protected $primaryKey = 'id_post';
    protected $allowedFields = ['id_instituto', 'id_categoria', 'titulo', 'descricao', 'imagem_principal', 'imagens', 'conteudo', 'destaque'];

    function AjaxConstructor()
	{
		parent::Model();
	}

    public function insertUser($data) { # inserir os dados do usúario no banco de dados
        // dados para inserir na tabela
        $params = [
            'institute' => $data['institute'], // instituto
            'cpf' => $data['cpf'], // cpf
            'name' => $data['name'], // nome
            'date' => $this->dateBirthday($data['birthday']), // aniversário
            'email' => $data['email'], // email
            'tel' => $data['tel'], // tel
            'password' => $this->hashPass($data['pass']), // senha
            'key' => $data['key'],
            'currentDate' => (new DateTime)->format("Y-n-d H:i:s"),

            // obs: sempre cadastrados como "null". serão adicionados ao BD na função uploadFiles.
            'img' => null, // imagem de perfil
        ];

        if($this->verifyRegistered($params) == false){ // verificar se algum dos dados já está registrado
            if ($this->query("INSERT INTO beneficiados VALUES(0, :institute:, :cpf:, :name:, :date:, :email:, :tel:, :img:, :password:, :key:, 0, :currentDate:)", $params)){
                
                $msg = ['id' => $this->query("SELECT id FROM beneficiados WHERE cpf = :cpf: AND id_instituto = :institute:", $params)->getResultObject()[0]->{'id'}, 'bool' => true];

                if(!$this->registerToVote($params['institute'], $msg['id'])) { // criar cadastro de votação (para poder votar na pesquisa de satisfação)
                    $msg = ['msg' => ['db', "Erro ao tentar criar o cadastro."], 'bool' => false];
                }
            } else {
                $msg = ['msg' => ['db', "Erro ao tentar criar o cadastro."], 'bool' => false];
            }
    
        } else {
            $msg = ['msg' => $this->verifyRegistered($params), 'bool' => false];
        }

        return $msg;
    }

    public function confirmEmail($data) { # confirmar email

        if(!($data['key'] == NULL)){
            $params = [
                'key' => $data['key'],
                'institute' => $data['institute'],
            ];
    
            if($this->query("SELECT COUNT('id') AS exist_id FROM beneficiados WHERE codigos_verificacao = :key: AND id_instituto = :institute:", $params)->getResultObject()[0]->{'exist_id'} == 1){
                
                $params['id'] = $this->query("SELECT id FROM beneficiados WHERE codigos_verificacao = :key:  AND id_instituto = :institute:", $params)->getResultObject()[0]->{'id'};

                if($this->query('UPDATE beneficiados SET codigos_verificacao = NULL, ativo = 1 WHERE id = :id:', $params)){
                    return ['bool' => true, 'msg' => 'Email confirmado com sucesso!  <br> <span> Você já pode acessar sua conta. </span>'];
                }
            }
        }
        
        return ['bool' => false, 'msg' => 'O link de verificação do email expirou. <br> <span> Tente acessar sua conta para receber um novo link. </span>'];
    }

    public function registerToVote($institute, $user) { # registrar para votação
        // configurações data atual
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
  
        $params = [
            'idUser' => $user,
            'institute' => $institute,
            'date' => (new DateTime)->format('Y-n-d H:i:s')
        ];

        if (!$this->query("INSERT INTO avaliacoes VALUES(0, :idUser:, :institute:, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, :date:)", $params)){
            return false;
        }

        return true;
    }

    public function updateInfos($data) { # alterar informações do usúario
        // dados para inserir na tabela
        $params = [
            'id' => $data['id'],
            'institute' => $data['institute'], // instituto
            'name' => $data['name'], // nome
            'date' => $this->dateBirthday($data['birthday']), // aniversário
            'email' => $data['email'], // email
            'tel' => $data['tel'], // tel
            'pass' => $data['pass'], // senha atual
            'new_pass' => $data['new_pass'], // nova senha
        ];

        // add ',' quando há mais q uma alteração
        $moreUps = false;
        // criar string para update de dados 
        $query = 'UPDATE beneficiados SET ';

        if($params['name'] != null){
            $query .= 'nome = :name:';
            $moreUps = true;
        }

        if($params['date'] != null){
            if($moreUps) $query .= ', ';
            $query .= 'data_nascimento = :date:';
        }

        if($params['email'] != null){
            if($moreUps) $query .= ', ';
            $query .= 'email = :email:';
        }

        if($params['tel'] != null){
            if($moreUps) $query .= ', ';
            $query .= 'telefone = :tel:';
        }

        if($params['pass'] != null && $params['new_pass'] != null){
            if($this->verifyPass($params) == false){

                $params['new_pass'] = $this->hashPass($params['new_pass']); // codificar senha

                if($moreUps) $query .= ', ';
                $query .= 'senha = :new_pass:';
            } else {
                return $this->verifyPass($params);
            }
        } 

        else if ($params['pass'] != null && $params['new_pass'] == null){ // caso somente o campo da senha esteja preenchido
            return ['msg' => [['new_pass', 'preencha esse campo para poder alterar a senha.']], 'bool' => false];
        }
        else if ($params['pass'] == null && $params['new_pass'] != null){ // caso somente o campo da nova senha esteja preenchido
            return ['msg' => [['pass', 'preencha esse campo para poder alterar a senha.']], 'bool' => false];
        }

        $query .= ' WHERE id = :id:';

        if($this->verifyUpdate($params) == false){
            if ($this->query($query, $params)){
                $msg =  ['msg' => ['db', "Alterado com sucesso"], 'bool' => true];
            } else {
                $msg = ['msg' => ['db', "Erro ao tentar alterar as informações."], 'bool' => false];
            }

            // pegar dados da sessão
            $dbData = (new SessionUserModel)->accessBeneficiaryForId($params['id']);
            // alterar os dados da sessão
            (new Session)->setSessionUser($dbData);

        } else {
            $msg = ['msg' => $this->verifyUpdate($params)];
        }

        return $msg;
    }

    public function getImg($id) { # pegar imagem principal/foto do integrante
        return $this->query("SELECT foto FROM beneficiados WHERE id = ?", $id)->getResult('array')[0]['foto'];
    }

    private function verifyRegistered($data) { # verificar se já está registrado no banco de dados 

        $params = [
            'institute' => $data['institute'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'tel' => $data['tel']
        ];

        $dataRegistered = [];
        
        if($data['cpf'] != null && count($this->query("SELECT id FROM beneficiados WHERE cpf = :cpf: AND id_instituto = :institute:", $params)->getResult('array')) != 0)
        {
            array_push($dataRegistered, ['cpf', 'este CPF já está cadastrado!']);
        }

        if($data['email'] != null && (count($this->query("SELECT id FROM beneficiados WHERE email = :email: AND id_instituto = :institute:",$params)->getResult('array')) != 0 || $this->query("SELECT id FROM instituto_contatos WHERE email = :email:", $params)->getResultObject() != null)) {
            array_push($dataRegistered, ['email', 'este Email já está cadastrado!']);
        }

        if($data['tel'] != null && (count($this->query("SELECT id FROM beneficiados WHERE telefone = :tel: AND id_instituto = :institute:",$params)->getResult('array')) != 0 || $this->query("SELECT id FROM instituto_contatos WHERE telefones like '%" . $params['tel'] . "%'")->getResultObject() != null)) {
            array_push($dataRegistered, ['tel', 'este número de telefone já está cadastrado!']);
        }

        if($dataRegistered != null){
            return $dataRegistered;
        }

        return false;
    }

    private function verifyUpdate($data) { // verificar se já está cadastrado no banco de dados
        $params = [
            'institute' => $data['institute'],
            'id' => $data['id'],
            'email' => $data['email'],
            'tel' => $data['tel']
        ];

        $dataRegistered = [];

        if($data['email'] != null && ($this->query("SELECT id FROM beneficiados WHERE id_instituto = :institute: AND email = :email: AND id <> :id:", $params)->getResultObject() != null || $this->query("SELECT id FROM instituto_contatos WHERE email = :email:", $params)->getResultObject() != null))
        {
            array_push($dataRegistered, ['email', 'este email já está cadastrado!']);
        }

        if($data['tel'] != null && ($this->query("SELECT id FROM beneficiados WHERE id_instituto = :institute: AND telefone = :tel: AND id <> :id:", $params)->getResultObject() != null || $this->query("SELECT id FROM instituto_contatos WHERE telefones like '%" . $params['tel'] . "%'")->getResultObject() != null))
        {
            array_push($dataRegistered, ['tel', 'este número de telefone já está cadastrado!']);
        }

        if($dataRegistered != null){
            return $dataRegistered;
        }

        return false;
    }

    private function verifyPass($data) { # verificar credências da senha

        $params = [
            'id' => $data['id'],
            'pass' => $data['pass'],
            'new-pass' => $data['new_pass']
        ];

        $dbData = (new SessionUserModel)->accessBeneficiaryForId($params['id']);

        if(password_verify($params['pass'], $dbData->{'senha'})){
            if($params['pass'] == $params['new-pass']){
                return ['msg' => [['new_pass', 'a nova senha deve ser diferente da senha atual!']]];
            }

        } else {
            return ['msg' => [['pass', 'senha incorreta!']]];
        }

        return false;
    }

    private function dateBirthday($date) { # data de aniversário
        // data configs
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $dateString = $date['day'] . "-" . $date['month'] . "-" . $date['year'];

        $date = (new DateTime($dateString))->format('Y-n-d H:i:s'); 
        return ($date);
    }

    public function hashPass($password) { # retornar hash da senha
        $passString = strval($password);
        return password_hash($passString, PASSWORD_DEFAULT);
    }

    public function UpFiles($data) { # inserir nome da imagem principal no banco de dados
        $id_query = "SELECT id FROM beneficiados WHERE id_instituto = " . $data['id'] . " ORDER BY data DESC LIMIT 1";

        $params = [
            'name' => $data['name'],
            'id' => $this->query($id_query)->getResult("array")[0]['id']
        ];
        
        if($this->query("UPDATE beneficiados SET foto = :name: WHERE id = :id:", $params)){
            return true;
        }

        return false;
    }

    public function UpFilesChange($data) { # alterar foto de perfil
        $params = [
            'name' => $data['name'],
            'id' =>  $data['id'],
        ];

        // alterar os dados da sessão
        if($this->query("UPDATE beneficiados SET foto = :name: WHERE id = :id:", $params)){ // alterar dados da sessão
            // pegar dados da sessão e alterar os dados para o correto
            (new Functions)->deleteFiles([session()->get('photo')], $data['path']); // excluir foto anterior
            (new Session)->setSessionUser((new SessionUserModel)->accessBeneficiaryForId($params['id']));
            return true;
        } 

        return false;
    }

    public function deleteAccount() {
        $params = [
            'id' => session()->get('idUser'),
        ]; 

        if($this->query("DELETE FROM beneficiados WHERE id = :id:", $params)){ // alterar dados da sessão
            return true;
        } 
        return false;
    }
}