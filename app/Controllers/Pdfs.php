<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pdfs extends Controller
{
    public function index()
    {       
        // ============================================ PDF ============================================ //
            echo view('contents/template-1/uploads/sections/pdfs.php');
        // ================================================================================================ //
    }
}