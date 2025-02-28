<?php 
    $this->extend('App\Views\contents\warnings\render-sections\warning.php');
    
    $this->section('img-warning'); 
?>

<div class="img-warning">
    <img src="<?= base_url("assets/img/warnings/" . $warning['banner'])?> " alt="aviso">
</div>

<?php $this->endSection();?>  

<?php 
    $this->extend('App\Views\contents\warnings\render-sections\warning.php');
    
    $this->section('content-warning'); 
?>

<div class="content-warning">
    
    <div>
        <!-- titulo -->
        <div class="title">
            <img class="icon-warning megaphone" src=" <?= base_url('assets/img/warnings/magaphone.png') ?> ">
            <h1><?php echo strtoupper($warning['title']) ?></h1>
        </div>
    
        <div class="content">
            <!-- icon -->
            <i class="fa-solid fa-triangle-exclamation icon-warning"></i>
        
            <!-- conteúdo do aviso -->
            <p><?php echo ucfirst($warning['content']) ?></p>
        </div>
    </div>

</div>

<?php $this->endSection();?>  