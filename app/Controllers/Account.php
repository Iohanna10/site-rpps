<?php

namespace App\Controllers;

use App\Models\Ajax\UserModel;
use App\Models\Session\SessionUserModel;

/**
 * Classe de controle das páginas relacionadas a conta 
 * @extends Templates
*/

class Account extends Templates
{
    /** Retorna a página de login */
    public function index() { # login
        return $this->userConfigs('login');
    }

    /** Retorna a página de registro de usuário */
    public function userRegister(){ # registro
        return $this->userConfigs('register');
    }

    /** Retorna a página de recuperação de conta */
    public function recoverAccount() { # recuperar tempo
        return $this->userConfigs('recover-account');
    }

    /** Retorna a página de alteração de senha */
    public function changePassword() { # mudar a senha 
        if($_GET['key'] != null && ($_GET['key'] == (new Session)->dataInstitute($this->getInstituteId(), ['instituto'], ['instituto' => ['codigos_verificacao']])['instituto']['codigos_verificacao'] || (new SessionUserModel)->isValidKey($_GET['key']))) { // verificar se a chave de alteração é válida
            return $this->userConfigs('change-password', ['valid' => true]);
        }
    
        // chave de alteração inválida
        return $this->userConfigs('change-password', ['valid' => false]);
    }

    /** Retorna a página de confirmação de email */
    public function confirmEmail() { # confirmar email
        return $this->userConfigs('confirm-mail');
    }

    /** Retorna a mensagem de confimação/negação de email para o modal, após fazer a validação do email. */
    public function validateEmail() { # validar email
        $data = [
            'key' => $_POST['key'],
            'institute' => $this->getInstituteId()
        ];

        $data = (new UserModel)->confirmEmail($data);
        return $this->response->setJSON($data);
    }

    /** Retorna a página do erro "instituto não cadastrado" */
    public function instituteWithoutRegistration() { # instituto sem cadastro
        return $this->error("without-registration");
    }
}
