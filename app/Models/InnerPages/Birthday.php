<?php

namespace App\Models\InnerPages;

use CodeIgniter\Model;

class Birthday extends Model {

    protected $table = 'beneficiados';

    Public function birthdays($id, $pg, $date) { // pegar aniversários  
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, "pt_BR.Utf-8");
        require_once("functions/calendar.php");

        $qntResultPgs = 15; // quantidade max de registros do db por página

        $params = [
            'instituteId' => $id,
            'date' => date_format(formatMonth(strtotime($date)), 'm'),
            'qntResultPgs' => $qntResultPgs, 
            'start' => ($pg * $qntResultPgs) - $qntResultPgs, // onde começa a pegar os registros
        ];

        // nº total de registros
        $totalRecords = $this->query("SELECT COUNT(id) AS num_records FROM beneficiados WHERE id_instituto = :instituteId: AND MONTH(data_nascimento) = :date:", $params)->getResultObject();
        $qntPg = ceil( $totalRecords[0]->{'num_records'} / $qntResultPgs); // qunatidade de páginas para a paginação

        $dataArray = [
            'date' => ['month' => $mesPtBr->format(formatMonth(strtotime($date))), 'full' => formatMonth(strtotime($date))],
            'dbData' => $this->query("SELECT nome, DAY(data_nascimento) AS dia FROM beneficiados WHERE id_instituto = :instituteId: AND MONTH(data_nascimento) = :date: ORDER BY DAY(data_nascimento), nome ASC LIMIT :start:, :qntResultPgs: ", $params)->getResultObject(),
            'qntPg' => $qntPg, 
            'currentPg' => $pg
        ];

        return $dataArray;
    }
}   

?>