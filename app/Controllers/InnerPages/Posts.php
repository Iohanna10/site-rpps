<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Templates;
use App\Models\InnerPages\Post;

/**
 * Classe de controle para retornar o HTML completo das páginas internas com publicações 
 * @extends Templates Monta o HTML completo
*/

class Posts extends Templates
{
    /**
     * Entregar dados a `Templates` para receber e retornar o HTML completo das páginas internas com publicações.
     * @param array $headerLinks Nomes atribuidos aos links das rotas no header.
     * @param int|string|null $routeId `int|string` para uma rota específica (sendo as strings aceitas `concursos` e `noticias`) e null para que a rota seja encontrada pela função `requireArea`.
     * @param string|false $description Descrição da página ou `false` para não incluir.
    */
    public function pgWithPosts (array $headerLinks, int|string|null $routeId = NULL, string|false $description = false) {       
        $pgData = [ // dados para o template
            'page' => 'posts',
            'headerLinks' => $headerLinks,
            'vars' => ['routeId' => $routeId == NULL ? (new Post)->requireArea($this->getRoutes()) : $routeId],
            'description' => $description
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars'], false, $pgData['description']);  
    }
}
