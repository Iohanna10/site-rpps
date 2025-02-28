<?php
/**
    arquivo para executar limpeza dos arquivos inutilizados da criação de publicações
*/

// ============= selecionar todos as publicações do banco de dados ============= //
    # Esses dados já estão vindo do model pela variável $allPosts
// ==================================== // ===================================== //

// ======== pegar o nome dos arquivos locais atribuidos as publicações ========= //
    function getContentMedias($allMedias, $doc) {
        $tagNames = ['img', 'source', 'a']; // tags HTML que podem conter os caminhos locais 

        foreach ($tagNames as $tag) { 
            foreach ($doc->getElementsByTagName($tag) as $mediaEl) { // elementos HTML selecionados pela tag 
                if($mediaEl->getAttribute('src') ==! null){ // verifica se o conteúdo do atributo src das imagens e vídeos não está vazio 
                    $path = $mediaEl->getAttribute('src'); // pega o caminho do arquivo
                }
                else if($mediaEl->getAttribute('href') ==! null){ // verifica se o conteúdo do atributo href dos links para pdf's não está vazio
                    $path = $mediaEl->getAttribute('href');
                }

                // verificar se o o caminho para o arquivo está em uma pasta local com o nome do instituto
                if (strpos($path, "/assets/uploads/") !== false){
                    array_push($allMedias, basename($path));
                }
            }
        }
        
        return $allMedias;
    }
// ==================================== // ===================================== //

// ======= juntar as mídias de publicações diferentes em um mesmo array ======= //
    $allMedias = array(); // array que recebe todas as mídias

    foreach ($allPosts as $key => $post) {
        if(isset($post['conteudo'])){
            \libxml_use_internal_errors(true);
            
            $doc = (new DOMDocument);
            $doc->loadHTML($post['conteudo']);
    
            $allMedias = getContentMedias($allMedias, $doc);
    
            \libxml_use_internal_errors(false);
        }

        if(isset($post['imagem_principal'])){
            array_push($allMedias, $post['imagem_principal']);
        }

        if(isset($post['midias'])){
            foreach (explode(', ', $post['midias']) as $key => $media) {
                array_push($allMedias, $media);
            }
        }
    }
// ==================================== // ===================================== //

// ========= caso houver, remover as mídias com nomes iguais do array ========== //
    $allMedias = array_unique($allMedias);
// ==================================== // ===================================== //

// =============== pegar todas as mídias das pastas do servidor ================ //
    // Caminho das mídias das publicações 
    $path = FCPATH . 'dynamic-page-content/*/assets/uploads/{img,pdf,video}/posts/*/*/*.{png,jpg,jpeg,ogm,wmv,mpg,webm,ogv,mov,asx,mpeg,mp4,m4v,avi,pdf}';
    foreach (glob($path, GLOB_BRACE) as $media){
        // Verificar se as mídias das pastas NÃO estam em nenhuma publicação
        if (!in_array(basename($media), $allMedias)) {
            // caso não estiver, deleta a mídia
            unlink($media);
        }
    }
// ==================================== // ===================================== //