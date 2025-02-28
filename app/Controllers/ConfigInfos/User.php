<?php

namespace App\Controllers\ConfigInfos;

use App\Controllers\Templates;

/**
 * Classe de controle das páginas relacionadas a `Configurações do Usuário`
 * @extends Templates
*/

class User extends Templates
{
    /** Retorna página de configurações do usuário */
    public function userConfig() {
        return $this->userConfigs('user-config');
    }
}