
<?php 

if(!isset($data['blocked'])){
    require("config/content-config.php");

    function getCommittee($committee){
        switch ($committee) {
            case '1':
                return 'investment';
            
            case '2':
              return 'fiscal';
            
            case '3':
                return 'deliberative';
            
            default:
                return 'team';
        }
    }

    $committee = getCommittee($data['member']['equipe']);
?>
<head>
    <title>Editar Dados do Integrante</title>
</head>
    <div class="container-form contents">
        <form class="form-cad" method="POST" enctype="multipart/form-data" data-id="<?php echo $_GET['id'] ?>" data-council="<?php echo $data['member']['equipe'] ?>" data-path-variation="<?php echo "team/committee/$committee/" ?>">
            
            <div>
                <label for="img_perfil" style="text-align: center;"><p>Foto do integrante<span class="error"></span></p></label>
                <label for="img">
                    <div class="preview profile" title="Clique para escolher foto do integrante"><div class="preview-img-container" data-id-media="<?php echo $data['member']['foto'] ?>">
                        <img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/team/committee/$committee/") . $data['member']['foto'] ?>" alt="Foto de perfil">
                    </div>
                        <div class="container-icon" style="display: none!important;">
                            <i class="fa-solid fa-camera"></i>
                            <p>Adicionar foto do integrante</p>
                        </div>
                    </div>

                    <span class="error"></span>
                </label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg(this)" data-img = "<?php echo $data['member']['foto'] ?>" required>
            </div>

            <div>
                <label for="name">Nome completo:<span class="error"></span></label>
                <input id="name" type="text" name="name" value="<?php echo $data['member']['nome'] ?>" placeholder="Nome" required>
            </div>

            <div class="cpf-div">
                <label for="cpf">CPF:<span class="error"></span></label>
                <input type="text" id="cpf" name="cpf" oninput="mascara(this)" value="<?php echo $data['member']['cpf'] ?>" placeholder="CPF" required>
                <div class="status">
                    <i class="fa-solid fa-xmark-large error"></i>
                    <i class="fa-solid fa-check ok"></i>
                </div>
            </div>
            
            <div>
                <label for="member_position">Área de atuação:<span class="error"></span></label>
                <input type="text" name="member_position" id="member_position" placeholder="Ex: Contador, Advogado, Agente Administrativo..." value="<?php echo $data['member']['area_de_atuacao'] ?>" required>
            </div>

            <div class="two-inputs">
                <div class="biggest">
                    <label for="member_location">Local em que está atuando:<span class="error"></span></label>
                    <input type="text" name="member_location" id="member_location" placeholder="Ex: Secretaria de Planejamento, Secretaria de Saúde..." value="<?php echo $data['member']['local_atuacao'] ?>">
                </div>
                <div class="smallest">
                    <label for="holder">É títular?</label>
                    <select name="holder" id="holder" title="Selecione se o membro é ou não efetivado em seu cargo" required>
                        <option value="0" <?php if($data['member']['titular'] == 0){echo 'selected';}?>>Não</option>
                        <option value="1" <?php if($data['member']['titular'] == 1){echo 'selected';}?>>Sim</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="certificate">Certificação e validade da certificação:</label>
                <textarea id="certificate" class="editor-c" type="text" name="certificate" data-value="<?php echo str_replace('"', "'", $data['member']['certificacao']); ?>" placeholder="Ex: certificação APIMEC CGRPPS nº 443, com validade até 20/08/2025."></textarea>
            </div>

            <div>
                <label for="email">E-mail para contato com a equipe em que o membro atua:<span class="error"></span></label>
                <input type="email" name="email" id="email" value="<?php echo $data['member']['email'] ?>" placeholder="E-mail">
            </div>

            <div>
                <label for="tel">Número de telefone para contato com a equipe em que o membro atua:<span class="error"></span></label>
                <input type="tel" id="tel" name="tel" onkeypress="mask(this, mphone)" value="<?php echo $data['member']['numero'] ?>" placeholder="Nº de telefone" />
            </div>

            <div>
                <button id="btnChange" type="button">Alterar</button>
            </div>
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1><i class="success fa-sharp fa-solid fa-check"></i></h1>
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
        </div>
    </div>
<?php 
}
else {
    echo '
        <div class="warning">
            <span>Algo deu errado, tente novamente mais tarde.</span>
        </div>
    ';
}
?>