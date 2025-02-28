<?php

namespace App\Controllers;

class Info extends BaseController
{
  public function infos() {
      // ================================================================================================ //
        // echo php_ini_loaded_file();
        echo phpinfo();
        // echo view('contents/info.php');
      // ================================================================================================ //
  }
}
