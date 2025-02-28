<?php

namespace App\Models\Ajax;

use App\Controllers\Session;
use CodeIgniter\Model;

class InstituteModel extends Model
{
    protected $table = 'instituto';

    /** Retornar dados do instituto */
    public function instituteData($id) {
        $params = [
            'institute' => $id, // instituto
        ];

        $dataDB = $this->query("SELECT email, nome, senha FROM instituto WHERE id = :institute:", $params)->getResultObject();

        return $dataDB[0];
    }

    /** Retornar logos de parceiros do instituto */
    public function getLogos($id) {
        $params = ['institute' => $id];
        return $this->query("SELECT logo_parceiros AS logos FROM instituto_infos WHERE id_instituto = :institute:", $params)->getResult('array')[0];
    }

    /** Inserir logos de parceiros do instituto */
    public function upNewFiles($data) {
        $params = [
            'id_institute' => session()->get('id'),
        ];

        $otherLogos = $this->getLogos($params['id_institute']);;


        if($otherLogos['logos'] != NULL && $otherLogos['logos'] != ''){
            $params['logos'] = $otherLogos['logos'] . ", " . $data['newNames'];
        } else {
            $params['logos'] = $data['newNames'];
        }
       
        if(!$this->query("UPDATE instituto_infos SET logo_parceiros = :logos: WHERE id_instituto = :id_institute:", $params)){
            return false;
        };

        return true;
    }

    /** Alterar ordem de visualização das logos */
    public function updateOrder($data) {
        if((new Session)->isLogged()){
            $params = [
                'logos' => implode(', ', $data['order']),
                'id_institute' => session()->get('id')
            ];

            if($this->query("UPDATE instituto_infos SET logo_parceiros = :logos: WHERE id_instituto = :id_institute:", $params)){
                return true;
            };
            
        }
        return false;
    }

    /** Remover logos */
    public function removeFiles($data){
        if((new Session)->isLogged()){
            $medias = $this->getLogos(session()->get('id'));

            if($medias !== NULL){
                $medias = $this->popMedias($medias['logos'], $data['logos']);
            }

            if($medias['logos'] === ''){
                $medias['logos'] = NULL;
            }
            
            $params = [
                'logos' => $medias['logos'],
                'id_institute' => session()->get('id'),
            ];

            if($this->query("UPDATE instituto_infos SET logo_parceiros = :logos: WHERE id_instituto = :id_institute:", $params)){
                return true;
            };
            
        }
        return false;
    }

    /** Alterar dados do instituto */
    public function updateInfos($data){
        if((new Session)->isLogged()){
            $params['instituto'] = [
                'id' => session()->get('id'),
                'nome' => $data['name'],
            ];

            $params['infos'] = [
                'id' => session()->get('id'),
                'cep' => $data['cep'],
                'rua' => $data['street'],
                'numero' => $data['num'],
                'bairro' => $data['neighborhood'],
                'cidade' => $data['city'],
                'estado' => $data['state'],
                'dia_inicio' => $data['start_day'],
                'dia_fim' => $data['end_day'],
                'hr_inicio' => $data['opening_hours'],
                'hr_fim' => $data['closing_time'],
                'sobre' => $data['about'],
                'missao' => $data['mission'],
                'visao' => $data['vision'],
                'valores' => $data['values'],
                'politica_investimento' => $data['investment_policy'],
                'comite_investimento' => $data['investment_committee'],
                'descricao_alm' => $data['alm'],
                'link_transparencia' => $data['transparency'],
                'link_ouvidoria' => $data['ombudsman'],
                'link_diario_oficial' => $data['official_diary'],
                'link_portal_gov' => $data['government_portal'],
                'link_calendario_pagamentos' => $data['payment_schedule'],
                'link_legislacao_prev' => $data['social_security_legislation'],
                'link_folha_pagamento' => $data['payroll'],
            ];

            $params['contatos'] = [
                'id' => session()->get('id'),
                'instagram' => $data['instagram'],
                'facebook' => $data['facebook'],
                'youtube' => $data['youtube'],
                'twitter' => $data['twitter'],
                'telefones' => $data['tel'].", " . $data['fix_tel'],
                'email' => $data['email'],
            ];

            if($data['pass'] != "" && $data['new_pass'] != ""){
                if($this->verifyPass($data) === true){
                    $params['instituto']['senha'] = $this->hashPass($data['new_pass']); // codificar senha
                } else {
                    return $this->verifyPass($data);
                }
            }

            if(!$this->verifyMail($data['email'])){
                return  ['bool' => false, 'msg' => ['email', 'email já cadastrado']];
            }

            if(!$this->verifyTel($data['tel'])) {
                return ['bool' => false, 'msg' => ['tel', 'Nº de celular já cadastrado']];
            }

            if(!$this->verifyTel($data['fix_tel'])){
                return ['bool' => false, 'msg' => ['fix_tel', 'Nº de telefone já cadastrado']];
            }

            $querys = [
                'instituto' => $this->getQuery('UPDATE instituto SET ', $params['instituto']), // criar string para update de dados (tabela: insitituto)
                'infos' => $this->getQuery('UPDATE instituto_infos SET ', $params['infos']), // criar string para update de dados (tabela: instituto_infos)
                'contatos' => $this->getQuery('UPDATE instituto_contatos SET ', $params['contatos']) // criar string para update de dados (tabela: instituto_infos)
            ];

            $msg = $this->updateData($querys, $params);

            if($msg['bool'] === true){ // alterar os dados da sessão
                (new Session)->setSessionInstitute($params['instituto']['nome']);
                $this->updateDirName($data['last_name_institute']);
            }

            return $msg;
        }
        return ['bool' => false, 'msg' => ['bd', 'Faça login para fazer alterações']];
    }

    /** Construir a query para o banco de dados */
    private function getQuery($table, $attrs){
        $moreUps = false; // add ',' quando há mais q uma alteração
        $query = $table;

        foreach ($attrs as $key => $attr) {
            if($attr != '' && $key != 'id'){
                if($moreUps) $query .= ', ';
                $query .= "$key = :$key:";
                $moreUps = true; 
            } elseif ($key != 'senha' && $key != 'id') {
                if($moreUps) $query .= ', ';
                $query .= "$key = null";
                $moreUps = true; 
            }
        }
        $query .= ' WHERE id = :id:';

        return $query;
    }

    /** Executar as querys no banco de dados */
    private function updateData($querys, $params) {
        foreach ($querys as $key => $queryStr) {
            if(!$this->query($queryStr, $params[$key])){
                return ['bool' => false, 'msg' => ['bd', 'Erro ao tentar alterar as informações.']];
            }
        }
        return ['bool' => true, 'msg' => ['bd', 'Informações alteradas com sucesso.']];
    }

    /** Verificações de senha */
    private function verifyPass($data) {

        $params = [
            'senha' => $data['pass'],
            'nova_senha' => $data['new_pass']
        ];

        $dbData = (new Session)->dataInstitute(session()->get('id'), ['instituto'], ['instituto' => ['senha']]);

        if(password_verify($params['senha'], $dbData['instituto']['senha'])){

            if($params['senha'] == $params['nova_senha']){
                return ['bool' => false, 'msg' => ['new_pass', 'a nova senha deve ser diferente da senha atual']];
            }
        } else {
            return ['bool' => false, 'msg' => ['pass', 'senha incorreta']];
        }

        return true;
    }

    /** Criar hash para senha */
    private function hashPass($password) {
        $passString = strval($password);
        return password_hash($passString, PASSWORD_DEFAULT);
    }

    /** Alterar nome do diretório em que se encontram as mídias das publicações */
    private function updateDirName($lastName) {
        if($lastName !== session()->get('name')){
            if(is_dir(FCPATH . "dynamic-page-content/". $lastName)){
                $dir = FCPATH . "dynamic-page-content/". $lastName;
                $newDir = FCPATH . "dynamic-page-content/" . strtolower(session()->get('name'));
                rename($dir, $newDir);
            }
        }
    }

    /** Remover mídias da publicação */
    private function popMedias($data, $removeMedias){
        $medias = explode(', ', $data);
        
        foreach ($removeMedias as $key => $remove) {
            $key = array_search($remove, $medias);
            if($key!==false){
                unset($medias[$key]);
            }
        }

        return['logos' => implode(', ', $medias)];
    }

    /** Verificações de email */
    private function verifyMail($mail){
        $params = [
            'mail' => $mail,
            'id' => session()->get('id'),
        ]; 
        
        if($this->query("SELECT id FROM instituto_contatos WHERE id_instituto != :id: AND email = :mail:", $params)->getResultObject() != null || 
        $this->query("SELECT id FROM beneficiados WHERE email = :mail:", $params)->getResultObject() != null){
            return  false;
        }

        return true;
    }

    /** Verificações de telefone */
    private function verifyTel($tel) {
        $params = [
            'id' => session()->get('id'),
            'tel' => $tel
        ]; 

        if(strlen($params['tel']) === 0){ // caso o telefone fixo for vázio 
            return true;
        }
        elseif(strlen($params['tel']) === 10) { // se for um num de telefone fixo, pegar telefone após a virgula
            $params['tel'] = ', ' . $params['tel'];
        }

        if($this->query("SELECT id FROM beneficiados WHERE telefone = :tel:", $params)->getResultObject() != null || 
        $this->query("SELECT id FROM instituto_contatos WHERE id_instituto != :id: AND telefones like '%" . $params['tel'] . "%'", $params)->getResultObject() != null){
            return false;
        }

        return true;
    }
}