<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Ajax\PostModel;

/**
 * Classe de controle da função de limpeza dos arquivos inutilizados da criação de publicações 
*/

class Crons extends BaseController
{
    /** Executar limpeza periódica dos arquivos inutilizados da criação de publicações (Exec. no domingo às 3 hrs da manhã) */
    public function deleteUnusedFiles() {
        // pegar conteúdo de todas as publicações e mídias
        $allPosts = (new PostModel)->getAllContents();
        
        echo view('crons/delete-unused-files', ['allPosts' => $allPosts]);
    }
}

