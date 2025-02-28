<?php

namespace App\Controllers\InnerPages\Advices;

use App\Controllers\InnerPages\Posts;
use App\Controllers\Session;
use App\Models\InnerPages\Team;

/**
 * Classe de controle das páginas internas da área `Conselhos - Comitê de Investimentos`
 * @extends Posts|Templates
*/

class InvestmentCommittee extends Posts
{
    /** Retorna a página interna "Membros do Comitê" */
    public function membros() {           
        $pgData = [ // dados para o template
            'page' => 'team',
            'headerLinks' => ["Comitê de Investimento", "Membros do Comitê"],
            'vars' => ['members' => (new Team)->team($this->getRoutes(), 1), 'committee' => 'investment'],
            'description' => (new Session)->dataInstitute($this->getInstituteId(), ['infos'], ['infos' => ['comite_investimento']])['infos']['comite_investimento']
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars'], false, $pgData['description']);
    }

    /** Retorna a página interna "Calendário de Reuniões" */
    public function calendarioComiteInvestimentos() {
        return $this->pgWithPosts(["Comitê de Investimento", "Calendário de Reuniões - Comitê de Investimento"]);
    }

    /** Retorna a página interna "Atas de Reuniõe" */
    public function atasReunioes() {
        return $this->pgWithPosts(["Comitê de Investimento", "Atas de Reuniões – Comitê de Investimento"]);
    }

    /** Retorna a página interna "Resoluções" */
    public function resolucoes() {
        return $this->pgWithPosts(["Comitê de Investimento","Resoluções – Comitê de Investimento"]);
    }

    /** Retorna a página interna "Regimento Interno" */
    public function regimeInterno() {
        return $this->pgWithPosts(["Comitê de Investimento", "Regimento Interno – Comitê de Investimento"]);
    }

    /** Retorna a página interna "Composição da Carteira e Investimentos" */
    public function composicaoCarteiraInvestimentos() {
        return $this->pgWithPosts(["Comitê de Investimento", "Composição da Carteira e Investimentos"]);
    }

    /** Retorna a página interna "Política de Investimentos" */
    public function politicaInvestimento() {
        return $this->pgWithPosts(["Comitê de Investimento", "Política de Investimentos"]);
    }

    /** Retorna a página interna "Credenciamento das Instituições Financeiras" */
    public function credenciamentoInstituicoes() {
        return $this->pgWithPosts(["Comitê de Investimento", "Credenciamento das Instituições Financeiras"]);
    }

    /** Retorna a página interna "Relatório Mensal de Investimentos" */
    public function relatorioMensalInvestimentos() {
        return $this->pgWithPosts(["Comitê de Investimento", "Relatório Mensal de Investimentos"]);
    }

    /** Retorna a página interna "Relatório Anual de Investimentos" */
    public function relatorioAnualInvestimentos() {
        return $this->pgWithPosts(["Comitê de Investimento", "Relatório Anual de Investimentos"]);
    }

    /** Retorna a página interna "Aplicações e Resgates" */
    public function aplicacoesResgates() {
        $description = "Autorizações de Aplicações e Resgates";
        return $this->pgWithPosts(["Comitê de Investimento", "Aplicações e Resgates - APRs"], NULL, $description);
    }

    /** Retorna a página interna "Estudo de ALM" */
    public function estudoAlm() {
        $description = (new Session)->dataInstitute($this->getInstituteId(), ['infos'], ['infos' => ['descricao_alm']])['infos']['descricao_alm'];
        return $this->pgWithPosts(["Comitê de Investimento", "Estudo de ALM"], NULL, $description);
    }

}
