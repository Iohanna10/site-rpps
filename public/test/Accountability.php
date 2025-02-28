<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Session;
use CodeIgniter\Controller;
use App\Models\InnerPages\Accountability\Crp;
use App\Models\InnerPages\Accountability\Report;
use App\Models\InnerPages\Post;

class Accountability extends Controller
{

    public function getCurrentInstitute()
    {
        return (new Session)->currentInstitute($this);
    }

    public function audienciaPublica()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Audiência Pública"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //
    }

    public function balanceteAnual()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Balancete Anual"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
             // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function balanceteMensal()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Balancete Mensal"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function crp()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Certificado de Regularidade Previdenciária"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // relatórios
                $dataCrps = new Crp;
                $crps = $dataCrps->getCrps($this->getCurrentInstitute()['instituteId'], true);
            //

            echo view('contents/template-1/inner-pages/main/sections/crp', ['crps' => $crps]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function allCrps(){
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["CRP", "Certificados"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);    
            echo view('contents/template-1/common/header/go-back', ['link' => 'crps']);

            echo view('contents/template-1/inner-pages/main/render-sections/all-crps');
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //
    }

    public function calculoAtuarial()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Cálculo Atuarial"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);

            // relatórios
                $dataReports = new Report;
                $reports = $dataReports->getReports($this->getCurrentInstitute()['instituteId'], true);
            //             

            echo view('contents/template-1/inner-pages/main/sections/actuarial-calculation', ['data' => $reports]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function relatoriosCalc() // todos os relatórios calc atuarial
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Cálculo Atuarial", "Relatórios"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);    
            echo view('contents/template-1/common/header/go-back', ['link' => 'calculo-atuarial']);

            echo view('contents/template-1/inner-pages/main/render-sections/all-act-calc');
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function demonstrativosFinanceiro()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Demonstrativos Financeiros"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
             // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function dair()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Demonstrativo das Aplicações e Investimentos de Recursos"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);

            // description
                echo view('contents/template-1/inner-pages/main/sections/descriptions/dair', ['fixedDescription' => true]);
            //
            
             // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function dipr()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Demonstrativo de Informações Previdenciárias e Repasses"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            // description
                echo view('contents/template-1/inner-pages/main/sections/descriptions/dipr', ['fixedDescription' => true]);
            //

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function parcelamentos()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Parcelamentos"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function politicaInvestimentos()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Política de Investimentos"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            //  
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['politica_investimento']]);

            // description
                echo view('contents/template-1/inner-pages/main/render-sections/description', ['description' => $dataInstitute['infos']['politica_investimento']]);
            //

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function acordaosTce()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Acórdãos de TCE"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function certidoesNegativas()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Certidões Negativas"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
             // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function cronogramasPagamentos()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Cronograma de Pagamentos"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function contratosLicitacoes()
    {
        if($this->getCurrentInstitute()['instituteId'] == false){
            return (new Session)->redirectTo("../instituto-sem-cadastro?url=" . $this->request->getUri());
        };

        if((new Session)->registeredAtTheInstitute($this->getCurrentInstitute()['instituteId'])){return (new Session)->redirectTo("");};
        
        // ============================================ HEADER ============================================ //
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos'], ['infos' => ['link_transparencia', 'link_ouvidoria', 'link_diario_oficial', 'link_portal_gov']]);

            echo view('contents/template-1/common/header/head');
            echo view('contents/template-1/inner-pages/header/head');
            echo view('contents/template-1/common/header/menu', ['links' => $dataInstitute['infos']]);
        // ================================================================================================ //

        // ============================================= MAIN ============================================= //
            $route = ["Contratos e Licitações"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
             // posts
                $dataRouteId = new Post;
                $routeId = $dataRouteId->requireArea($this->getCurrentInstitute());
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //

                        
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }
}
