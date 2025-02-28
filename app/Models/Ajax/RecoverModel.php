<?php

namespace App\Models\Ajax;

use App\Controllers\Mails\MailTest;
use App\Controllers\Mails\SendMails;
use App\Controllers\Session;
use App\Models\Session\SessionModel;
use CodeIgniter\Model;

class RecoverModel extends Model {

    protected $table = 'beneficiados';

    public function recover($data){
        // dados para inserir na tabela
        $params = [
            'institute' => $data['institute'], // instituto
            'email' => $data['email'], // email
        ];

        if($this->query("SELECT id FROM beneficiados WHERE email = :email: AND ativo = 1 AND id_instituto = :institute:", $params)->getResultObject() != null)
        {
            $dbData = $this->query("SELECT id, id_instituto, cpf, nome, email FROM beneficiados WHERE email = :email: AND ativo = 1 AND id_instituto = :institute:", $params)->getResult('array')[0];
            $dbDataInstitute = (new Session)->dataInstitute($data['institute'], ['contatos', 'instituto'], ['contatos' => ['telefones', 'email'], 'instituto' => ['nome']]);
            
            if(!($this->updateRecover($dbData, $dbDataInstitute, 'beneficiados'))){
                $registered = [['email', 'tente novamente.']];
            } else {
                $msg = "Nós enviamos as instruções para " .$params['email']. ", por favor verifique tanto sua caixa de entrada quanto spam.";
                $registered = [['instructions', $msg]];
            }
        }        

        elseif($this->query("SELECT id_instituto FROM instituto_contatos WHERE email = :email: AND id_instituto = :institute:", $params)->getResultObject() != null && $this->query("SELECT id FROM instituto WHERE sit_ativo = 1 AND id = :institute:",$params)->getResultObject() != null)
        {
            $dbData = (new Session)->dataInstitute($data['institute'], ['contatos', 'instituto'], ['contatos' => ['email'], 'instituto' => ['id', 'cnpj', 'nome']]);

            if(!($this->updateRecover($dbData, false, 'instituto'))){
                $registered = [['email', 'tente novamente.']];
            } else {
                $msg = "Nós enviamos as instruções para " . $params['email']. ", por favor verifique tanto sua caixa de entrada quanto spam.";
                $registered = [['instructions', $msg]];
            }
        }

        elseif($this->query("SELECT id FROM beneficiados WHERE email = :email: AND ativo = 0 AND id_instituto = :institute:", $params)->getResultObject() != null) { // reenviar email de confirmação

            $dbData = $this->query("SELECT id, cpf, id_instituto, nome, email, telefone, codigos_verificacao FROM beneficiados WHERE email = :email: AND id_instituto = :institute:", $params)->getResult('array')[0];

            $params = [
                'id' => $dbData['id'], // id
                'cpf' => $dbData['cpf'], // cpf
                'institute' => $dbData['id_instituto'], // instituto
                'name' => $dbData['nome'], // nome
                'email' => $dbData['email'], // email
                'tel' => $dbData['telefone'], // tel
                'key' => $dbData['codigos_verificacao']
            ];

            if(!(new SendMails)->confirmEmail($params)){
                $registered = [['email', 'tente novamente.']];
            }
            else {
                $msg = "Este email ainda não foi confirmado. Nós enviamos um link de confirmação para " . $params['email']. ", por favor verifique tanto sua caixa de entrada quanto spam.";
                $registered = [['instructions', $msg]];
            }

        }

        else {
            $registered = [['email', 'este email não está cadastrado.']];
        }

        return $registered[0];
    }

    private function key_recover_pass($cpf_cnpj){
        $idString = strval($cpf_cnpj);
        return password_hash($idString, PASSWORD_DEFAULT);
    }

    private function updateRecover($data, $dbDataInstitute, $table){
        if($table === 'beneficiados') {
            $params['key'] = $this->key_recover_pass($data['cpf']);
            $params['id'] = $data['id'];
        } else {
            $params['key'] = $this->key_recover_pass($data['instituto']['cnpj']);
            $params['id'] = $data['instituto']['id'];
        }
        
        if($this->query("UPDATE $table SET codigos_verificacao = :key: WHERE id=:id: LIMIT 1", $params)){
            (new SendMails)->sendEmail($data, $dbDataInstitute, $params['key']);
            return true;
        }
        return false;
    }

    public function findKey($data)
    {
        // dados para inserir na tabela
        $params = [
            'key' => $data['key'], // chave
        ];

        if($this->query("SELECT id FROM beneficiados WHERE codigos_verificacao = :key:", $params)->getResultObject() != null)
        {
            $dbData = $this->query("SELECT id FROM beneficiados WHERE codigos_verificacao = :key:", $params)->getResultObject();
            return [$dbData[0], 'beneficiados'];
        }

        elseif($this->query("SELECT id FROM instituto WHERE codigos_verificacao = :key:", $params)->getResultObject() != null)
        {
            $dbData = $this->query("SELECT id FROM instituto WHERE codigos_verificacao = :key:", $params)->getResultObject();
            return [$dbData[0], 'instituto'];
        }

        return ['link', 'Link para alteração da senha inválido, solicite um novo link!'];
    }

    public function changePass($data){ # alterar senha do instituto/usúario
        $registered = array();
       
        // dados para inserir na tabela
        $params = [
            'id' => $data['id'], // id
            'new_pass' => $this->key_recover_pass($data['new_pass'])
        ];

        // tabela do banco de dados
        $table = $data['table'];

        if($this->query("UPDATE $table SET codigos_verificacao = null, senha = :new_pass: WHERE id=:id:", $params)){
            array_push($registered, 'true', 'Senha alterada com sucesso!');
        }
        else {
            array_push($registered, 'false', 'Ocorreu um erro ao tentar alterar a senha, tente novamente!');
        }

        return $registered;
    }
}