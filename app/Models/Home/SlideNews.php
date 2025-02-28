<?php

namespace App\Models\Home;

use CodeIgniter\Model;

class SlideNews extends Model {

    protected $table = 'posts';

    function NewsConstructor()
	{
		parent::Model();
	}

    // POSTS HISTÓRICO
    Public function slideNews($id) { # pegar informações dos eventos
        return ($this->query("
            SELECT id_post, data, titulo, descricao, imagem_principal, midias 
            FROM posts 
            WHERE id_instituto = ? AND destaque = 1",
            $id
        )->getResultObject());
    }
}