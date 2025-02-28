<?php

namespace App\Controllers\InnerPages;

/**
 * Classe de controle das páginas internas da área `Legislação`
 * @extends Posts|Templates
*/

class Legislation extends Posts
{
    /** Retorna a página interna "Constituição Federal" */
    public function constituicaoFederal() {
        return $this->pgWithPosts(["Constituição Federal"]);
    }

    /** Retorna a página interna "Instruções Normativas MPS" */
    public function instrucoesNormativasMps() {
        return $this->pgWithPosts(["Instruções Normativas MPS"]);
    }

    /** Retorna a página interna "Leis Federais" */
    public function leisFederais() {
        return $this->pgWithPosts(["Leis Federais"]);
    }

    /** Retorna a página interna "Orientações MPS" */
    public function orientacoesMps() {
        return $this->pgWithPosts(["Orientações MPS"]);
    }

    /** Retorna a página interna "Portarias MPS" */
    public function portariasMps() {
        return $this->pgWithPosts(["Portarias MPS"]);
    }

    /** Retorna a página interna "Resoluções CMN" */
    public function resolucoesCmn() {
        return $this->pgWithPosts(["Resoluções CMN"]);
    }

    /** Retorna a página interna "Leis Municipais" */
    public function leisMunicipais() {
        return $this->pgWithPosts(["Leis Municipais"]);
    }

    /** Retorna a página interna "Portarias" */
    public function portarias() {
        return $this->pgWithPosts(["Portarias " . strtoupper($this->getRoutes()['institute'])]);
    }
}
