<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Session;
use App\Models\InnerPages\Team;

/**
 * Classe de controle das páginas internas da área `Instituto`
 * @extends Posts|Templates
*/

class Institute extends Posts
{   
    /** Retorna a página interna "Histórico" */
    public function historico() {
        return $this->pgWithPosts(["Histórico"]);  
    }

    /** Retorna a página interna "Princípios" */
    public function principios() {
        $pgData = [ // dados para o template
            'page' => 'principles',
            'headerLinks' => ["Princípios"],
            'vars' => (new Session)->dataInstitute($this->getInstituteId(), ['infos'], ['infos' => ['missao', 'visao', 'valores']])
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);     
    }

    /** Retorna a página interna "Código de Ética" */
    public function codigoDeEtica() {
        return $this->pgWithPosts(["Código de Ética"]); 
    }

    /** Retorna a página interna "Equipe" */
    public function equipe() {
        $pgData = [ // dados para o template
            'page' => 'team',
            'headerLinks' => ["Equipe"],
            'vars' => ['members' => (new Team)->team($this->getRoutes(), 0), 'committee' => 'team']
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);
    }

    /** Retorna a página interna "Concurso" */
    public function concursos() {    
        return $this->pgWithPosts(["Concurso"], "concursos"); 
    }

    /** Retorna a página interna "Processo Seletivo" */
    public function processoSeletivo() {
        return $this->pgWithPosts(["Concurso", "Processo Seletivo"]);             
    }

    /** Retorna a página interna "Educação Previdenciária" */
    public function educacaoPrevidenciaria() {
        return $this->pgWithPosts(["Educação Previdenciária"]);             
    }

    /** Retorna a página interna "Plano de Ação" */
    public function planoDeAcao() {
        return $this->pgWithPosts(["Plano de Ação"]);             
    }

    /** Retorna a página interna "Gestão e Controle Interno" */
    public function gestaoEControleInterno() {
        return $this->pgWithPosts(["Gestão e Controle Interno"]);           
    }

    /** Retorna a página interna "Segurança da Informação" */
    public function segurancaDaInformacao() {
        return $this->pgWithPosts(["Segurança da Informação"]);
    }

    /** Retorna a página interna "Manual de Procedimentos de Benefícios" */
    public function manualDeProcedimentosDeBeneficio() {
        return $this->pgWithPosts(["Manual de Procedimentos de Benefícios"]);
    }

    /** Retorna a página interna "Manual de Arrecadação" */
    public function manualDeArrecadacao() {
        return $this->pgWithPosts(["Manual de Arrecadação"]);
    }

    /** Retorna a página interna "Manual de Procedimentos: Gestão de Investimentos" */
    public function manualDeProcedimentos() {
        return $this->pgWithPosts(["Manual de Procedimentos: Gestão de Investimentos"]);
    }
}
