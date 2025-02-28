<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Session;
use App\Models\InnerPages\Accountability\Crp;
use App\Models\InnerPages\Accountability\Report;

/**
 * Classe de controle das páginas internas da área `Prestação de contas`
 * @extends Posts|Templates
*/

class Accountability extends Posts
{
    /** Retorna a página interna "Audiência Pública" */
    public function audienciaPublica() {
        return $this->pgWithPosts(["Audiência Pública"]);  
    }

    /** Retorna a página interna "Balancete Anual" */
    public function balanceteAnual() {
        return $this->pgWithPosts(["Balancete Anual"]);  
    }

    /** Retorna a página interna "Balancete Mensal" */
    public function balanceteMensal() {
        return $this->pgWithPosts(["Balancete Mensal"]);  
    }

    /** Retorna a página interna "Certificado de Regularidade Previdenciáriaal" */
    public function crp() {          
        $pgData = [ // dados para o template
            'page' => 'crps',
            'headerLinks' => ["Certificado de Regularidade Previdenciária"],
            'vars' => (new Crp)->getCrps($this->getInstituteId(), true),
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);
    }

    /** Retorna a página interna "Certificados" */
    public function allCrps() {   
        $pgData = [ // dados para o template
            'page' => 'all-crps',
            'headerLinks' => ["CRP", "Certificados"],
            'goBack' => 'crps',
            'vars' => [],
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars'], $pgData['goBack']);
    }

    /** Retorna a página interna "Cálculo Atuarial" */
    public function calculoAtuarial() {   
        $pgData = [ // dados para o template
            'page' => 'actuarial-calculation',
            'headerLinks' => ["Cálculo Atuarial"],
            'vars' => (new Report)->getReports($this->getInstituteId(), true)
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars']);
    }

    /** Retorna a página interna "Relatórios" */
    public function relatoriosCalc() { # todos os relatórios calc atuarial
        $pgData = [ // dados para o template
            'page' => 'all-act-calc',
            'headerLinks' => ["Cálculo Atuarial", "Relatórios"],
            'goBack' => 'calculo-atuarial',
            'vars' => [],
        ];

        return $this->innerpages($pgData['page'], $pgData['headerLinks'], $pgData['vars'], $pgData['goBack']);
    }

    /** Retorna a página interna "Demonstrativos Financeiros" */
    public function demonstrativosFinanceiro() {
        return $this->pgWithPosts(["Demonstrativos Financeiros"]);  
    }

    /** Retorna a página interna "Demonstrativo das Aplicações e Investimentos de Recursos" */
    public function dair() {
        $description = 'O Demonstrativo das Aplicações e Investimentos de Recursos (DAIR) é um documento que apresenta mensalmente as informações sobre as carteiras de investimentos do RPPS, além de dados cadastrais do ente federativo, da unidade gestora do RPPS e seus respectivos responsáveis, dos membros de colegiados (conselhos deliberativo e fiscal, e comitê de investimentos) com suas devidas certificações, do credenciamento de fundos e de instituições financeiras, formas de gestão, assim como o registro de todas as APRs ocorridas no mês de referência.';

        return $this->pgWithPosts(["Demonstrativo das Aplicações e Investimentos de Recursos"], NULL, $description);  
    }

    /** Retorna a página interna "Demonstrativo de Informações Previdenciárias e Repasses" */
    public function dipr() {
        $description = 'Trata-se de documento obrigatório, previsto na alínea “h” do inciso XVI do artigo 5º da Portaria MPS n° 204/2008, destinado a informações gerais dos Regimes Próprios de Previdência Social – RPPS, exigido desde o primeiro bimestre do ano de 2014. Referido Demonstrativo passou a ser exigido em substituição ao “Demonstrativo Previdenciário” e ao “Comprovante do Repasse”.';

        return $this->pgWithPosts(["Demonstrativo de Informações Previdenciárias e Repasses"], NULL, $description);  
    }

    /** Retorna a página interna "Parcelamentos" */
    public function parcelamentos() {
        return $this->pgWithPosts(["Parcelamentos"]);  
    }

    /** Retorna a página interna "Política de Investimentos" */
    public function politicaInvestimentos() {  
        $description = (new Session)->dataInstitute($this->getInstituteId(), ['infos'], ['infos' => ['politica_investimento']])['infos']['politica_investimento'];

        return $this->pgWithPosts(["Política de Investimentos"], NULL, $description);  
    }

    /** Retorna a página interna "Acórdãos de TCE" */
    public function acordaosTce() {
        return $this->pgWithPosts(["Acórdãos de TCE"]);  
    }

    /** Retorna a página interna "Certidões Negativas" */
    public function certidoesNegativas() {
        return $this->pgWithPosts(["Certidões Negativas"]);  
    }

    /** Retorna a página interna "Cronograma de Pagamentos" */
    public function cronogramasPagamentos() {
        return $this->pgWithPosts(["Cronograma de Pagamentos"]);  
    }

    /** Retorna a página interna "Contratos e Licitações" */
    public function contratosLicitacoes() {
        return $this->pgWithPosts(["Contratos e Licitações"]);  
    }
}
