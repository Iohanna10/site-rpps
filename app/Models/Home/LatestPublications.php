<?php

namespace App\Models\Home;

use CodeIgniter\Model;

class LatestPublications extends Model {

    protected $table = 'posts';

    function latestPublicationsConstructor()
	{
		parent::Model();
	}

    // POSTS 
    Public function latestPublications($id) { # pegar últimas publicações 
        $publications = [
            'latest' => $this->query("SELECT id_post, data, titulo, descricao, imagem_principal FROM posts WHERE id_instituto = ? ORDER BY data DESC LIMIT 4", $id)->getResultObject(),
            'numPb' => $this->query("SELECT COUNT(id_post) as numTotal FROM posts WHERE id_instituto = ?", $id)->getResult('array')[0]['numTotal']
        ];
        return $publications;
    }
}