<?php

namespace App\Controllers\InnerPages;

use App\Controllers\Ajax\AjaxPolls;
use App\Controllers\Session;
use App\Models\InnerPages\Reviews;
use App\Models\InnerPages\Post;
use CodeIgniter\Controller;

class Publications extends Controller
{

    public function getCurrentInstitute()
    {
        return (new Session)->currentInstitute($this);
    }

    public function noticias()
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
            $route = ["Publicações", "Notícias"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            
            // posts
                $routeId = "noticias";
            // 

            echo view('contents/template-1/inner-pages/main/render-sections/posts', ['routeId' => $routeId]);
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function informativoSemestral()
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
            $route = ["Publicações", "Informativo Semestral"];
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

    public function galeriaFotos()
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
            $route = ["Publicações", "Galerias"];

            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
            echo view('contents/template-1/inner-pages/main/render-sections/gallery');
        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function pesquisaSatisfacao()
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
            $route = ["Publicações", "Pesquisa de Satisfação"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);
           
            // posts
                $votes = (new Reviews)->reviews($this->getCurrentInstitute()['instituteId']);
                $feedback = (new Reviews)->getFeedback($this->getCurrentInstitute()['instituteId']);
            //

            echo view('contents/template-1/inner-pages/main/sections/satisfaction-survey', ['votes' => $votes, 'feedback' => $feedback]);

        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }

    public function resultadoPesquisa()
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
            $route = ["Resultado da Pesquisa"];
            echo view('contents/template-1/inner-pages/header/sections/header-links', ['rota' => $route]);

            $data = (new AjaxPolls)->getRatings($this->getCurrentInstitute()['instituteId']);

            echo view('contents/template-1/config-pages/pages/ratings', ['ratings' => $data]);
            echo view('contents/template-1/inner-pages/main/sections/result-satisfaction-survey');

        // ================================================================================================ //
            
        // ============================================ FOOTER ============================================ //
            
            $dataInstitute = (new Session)->dataInstitute($this->getCurrentInstitute()['instituteId'], ['infos', 'contatos'], ['infos' => ['sobre', 'endereco', 'horario_func'], 'contatos' => ['*']]);

            echo view('contents/template-1/common/footer/sections/infos', ['contacts' => $dataInstitute['contatos'], 'info' => $dataInstitute['infos']]);
            echo view('contents/template-1/common/footer/theme');
        // ================================================================================================ //

    }
}
