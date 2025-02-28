<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require("config/content-config.php"); ?>
    <title>Configurar informações do instituto</title>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/common/common.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/configs-pages/institute.css") ?>">
</head>
<body>
    <div class="container-form">
        <form class="form-cad" method="POST" id='formPost' data-path-variation="<?php echo 'logos/own/' ?>">
            <h1 class="title">Alterar informações do instituto</h1>
            <!-- nome -->
            <div class="input">
                <label for="img">
                    <div class="preview profile institute" title="Clique para escolher a logo">
                        <div class="preview-img-container" data-id-media='logo.png'>
                            <?php        
                            if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ ?>
                                <img src="<?= base_url("/dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")?>" alt="Sua logo">
                            <?php } ?>
                        </div>
                        <div class="container-icon" <?php if(file_exists(FCPATH . "dynamic-page-content/$url/assets/uploads/img/logos/own/logo.png")){ echo 'style="display: none!important;"'; } ?>>
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                </label>
                <label for="img_error">Logo do instituto <span class="error" style="margin-left: 5px;"></span></label>
                <input type="file" name="img" id="img" accept=".png, .jpg, .jpeg" style="display: none;" onchange="previewImg(this)">
            </div>
            <div class="input">
                <label for="name">Nome <span class="error"></span></label>
                <input type="text" value="<?php echo session()->get('name') ?>" name="name" id="name" placeholder="Nome">
            </div>

            <!-- endereço -->
            <h2 class="title">Endereço</h2>
            <div>

                <div class="two-inputs">
                    <div class="input">
                        <label for="cep">CEP <span class="error"></span></label>
                        <input type="text" name="cep" id="cep" placeholder="CEP" onblur="searchCep()" maxlength="9" value="<?php echo $data['info']['cep'] ?>">
                    </div>
                    <div class="input">
                        <label for="street">Rua <span class="error"></span></label>
                        <input type="text" name="street" id="street" placeholder="Rua" value="<?php echo $data['info']['rua'] ?>">
                    </div>
                </div>
    
                <div class="two-inputs">
                    <div class="input">
                        <label for="num">Nº <span class="error"></span></label>
                        <input type="text" name="num" id="num" placeholder="Número" value="<?php echo $data['info']['numero'] ?>">
                    </div>
                    <div class="input">
                        <label for="neighborhood">Bairro <span class="error"></span></label>
                        <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro"  value="<?php echo $data['info']['bairro'] ?>">
                    </div>
                </div>
    
                <div class="two-inputs">
                    <div class="input">
                        <label for="city">Cidade <span class="error"></span></label>
                        <input type="text" name="city" id="city" placeholder="Cidade"  value="<?php echo $data['info']['cidade'] ?>" >
                    </div>

                    <div class="input">
                        <label for="state">Estado <span class="error"></span></label>
                        <select name="state" id="state" data-selected="<?php echo $data['info']['estado'] ?>" ></select>
                    </div>  
                </div>
            </div>

            <!-- horário -->
            <h2 class="title">Horário de funcionamento</h2>
            <div>
                <div class="two-inputs">
                    <div class="input">
                        <label for="opening_hours">Horário de início</label>
                        <input type="time" name="opening_hours" id="opening_hours" value="<?php echo $data['info']['hr_inicio'] ?>">
                    </div>
                    <div class="input">
                        <label for="closing_time">Horário de encerramento</label>
                        <input type="time" name="closing_time" id="closing_time" value="<?php echo $data['info']['hr_fim'] ?>">
                    </div>
                </div>
                <div class="two-inputs">
                    <div class="input">
                        <label for="start_day">Dia de início</label>
                        <select name="start_day" id="start_day" data-selected="<?php echo $data['info']['dia_inicio'] ?>"></select>
                    </div>
                    <div class="input">
                        <label for="end_day">Dia de encerramento</label>
                        <select name="end_day" id="end_day" data-selected="<?php echo $data['info']['dia_fim'] ?>"></select>
                    </div>
                </div>
            </div>

            <!-- redes sociais -->
            <h2 class="title">Contatos</h2>
            <div>
                <div class="two-inputs">
                    <!-- instagram -->
                    <div class="input">
                        <label for="instagram">Instagram</label>
                        <input type="text" value="<?php echo $data['contacts']['instagram'] ?>" name="instagram" id="instagram" placeholder="Instagram">
                    </div>

                    <!-- facebook -->
                    <div class="input">
                        <label for="facebook">Facebook</label>
                        <input type="text" value="<?php echo $data['contacts']['facebook'] ?>" name="facebook" id="facebook" placeholder="Facebook">
                    </div>
                </div>
                <div class="two-inputs">
                    <!-- youtube -->
                    <div class="input">
                        <label for="youtube">Youtube</label>
                        <input type="text" value="<?php echo $data['contacts']['youtube'] ?>" name="youtube" id="youtube" placeholder="Youtube">
                    </div>

                    <!-- twitter / X -->
                    <div class="input">
                        <label for="twitter">Twitter / X</label>
                        <input type="text" value="<?php echo $data['contacts']['twitter'] ?>" name="twitter" id="twitter" placeholder="Twitter / X">
                    </div>
                </div>
                <!-- telefones -->
                <div class="two-inputs">
                    <!-- telefone / whatsapp -->
                    <div class="input">
                        <label for="tel">Celular / Whatsapp <span class="error"></span></label>
                        <input type="text" value="<?php echo $data['contacts']['tel'] ?>" name="tel" id="tel" placeholder="Telefone" onkeypress="mask(this, mphone);">
                    </div>

                    <!-- Telefone fixo -->
                    <div class="input">
                        <label for="fix_tel">Telefone fixo <span class="error"></span></label>
                        <input type="text" value="<?php echo $data['contacts']['fix_tel'] ?>" name="fix_tel" id="fix_tel" placeholder="Telefone fixo" onkeypress="mask(this, mphone);">
                    </div>
                </div>

                <div class="input">
                    <label for="email">Email <span class="error"></span></label>
                    <input type="text" name="email" id="email" value="<?php echo $data['contacts']['email'] ?>">
                </div>
            </div>

            <!-- redes sociais -->
            <h2 class="title">Links Úteis</h2>
            <div>
                <!-- Transparência -->
                <div class="input">
                    <label for="transparency">Transparência</label>
                    <input type="text" value="<?php echo $data['info']['link_transparencia'] ?>" name="transparency" id="transparency" placeholder="Link Transparência">
                </div>

                <!-- Ouvidoria -->
                <div class="input">
                    <label for="ombudsman">Ouvidoria</label>
                    <input type="text" value="<?php echo $data['info']['link_ouvidoria'] ?>" name="ombudsman" id="ombudsman" placeholder="Link Ouvidoria">
                </div>
            
            
                <!-- Diário Oficial -->
                <div class="input">
                    <label for="officialDiary">Diário Oficial</label>
                    <input type="text" value="<?php echo $data['info']['link_diario_oficial'] ?>" name="official_diary" id="official_diary" placeholder="Link Diário Oficial">
                </div>

                <!-- Portal do Governo do Estado -->
                <div class="input">
                    <label for="government_portal">Portal do Governo do Estado</label>
                    <input type="text" value="<?php echo $data['info']['link_portal_gov'] ?>" name="government_portal" id="government_portal" placeholder="Link Portal do Governo do Estado">
                </div>

                <!-- Calendário de pagamentos -->
                <div class="input">
                    <label for="payment_schedule">Calendário de Pagamentos</label>
                    <input type="text" value="<?php echo $data['info']['link_calendario_pagamentos'] ?>" name="payment_schedule" id="payment_schedule" placeholder="Link Calendário de Pagamentos">
                </div>

                <!-- Legislação previdenciária -->
                <div class="input">
                    <label for="social_security_legislation">Legislação Previdenciária</label>
                    <input type="text" value="<?php echo $data['info']['link_legislacao_prev'] ?>" name="social_security_legislation" id="social_security_legislation" placeholder="Link Legislação Previdenciária">
                </div>

                <!-- Folha de Pagamentos -->
                <div class="input">
                    <label for="payroll">Folha de Pagamentos</label>
                    <input type="text" value="<?php echo $data['info']['link_folha_pagamento'] ?>" name="payroll" id="payroll" placeholder="Link Folha de Pagamentos">
                </div>
            </div>
   
            <!-- sobre -->
            <h2 class="title">Princípios <label for="about"><span class="error"></span></label></h2>
            <div class="tabs" id="mainTab_principles">
                <div class="tab-buttons">
                    <button type="button" class="tab-btn active" content-id="sobre">Sobre</button>
                    <button type="button" class="tab-btn" content-id="missao">Missão</button>
                    <button type="button" class="tab-btn" content-id="visao">Visão</button>
                    <button type="button" class="tab-btn" content-id="valores">Valores</button>
                </div>
                <div class="tab-contents">
                    <div class="tab-content show" id="sobre">
                        <textarea class="editor" type="text" name="about" id="about" placeholder="Sobre do instituto...">
                            <?php 
                                if($data['info']['sobre'] !== null){
                                    echo $data['info']['sobre'];
                                } else {
                                    echo "Ainda não há nada sobre o instituto";
                                }
                            ?>
                        </textarea>
                    </div>

                    <!-- missão -->
                    <div class="tab-content" id="missao">
                        <textarea class="editor" type="text" name="mission" id="mission" placeholder="Missão do instituto...">
                            <?php 
                                if($data['info']['missao'] !== null){
                                    echo $data['info']['missao'];
                                } else {
                                    echo "Ainda não há nada sobre a missão do instituto";
                                }
                            ?>
                        </textarea>
                    </div>

                    <!-- visão -->
                    <div class="tab-content" id="visao">
                        <textarea class="editor" type="text" name="vision" id="vision" placeholder="Visão do instituto...">
                            <?php 
                                if($data['info']['visao'] !== null){
                                    echo $data['info']['visao'];
                                } else {
                                    echo "Ainda não há nada sobre a visão do instituto";
                                }
                            ?>
                        </textarea>
                    </div>

                    <!-- valores -->
                    <div class="tab-content" id="valores">
                        <textarea class="editor" type="text" name="values" id="values" placeholder="Visão do instituto...">
                            <?php 
                                if($data['info']['valores'] !== null){
                                    echo $data['info']['valores'];
                                } else {
                                    echo "Ainda não há nada sobre os valores do instituto";
                                }
                            ?>
                        </textarea>
                    </div>
                </div>
            </div>

            <h2 class="title">Descrição/informações</h2>
            <div class="tabs" id="mainTab_descriptions">
                <div class="tab-buttons">
                    <button type="button" class="tab-btn active" content-id="politica_investimento">Política de investimento</button>
                    <button type="button" class="tab-btn" content-id="comite_investimento">Comitê de investiemnto</button>
                    <button type="button" class="tab-btn" content-id="estudo_alm">Estudo de ALM</button>
                </div>
                <div class="tab-contents">
                    <!-- política de investimento -->
                    <div class="tab-content show" id="politica_investimento">
                        <textarea class="editor-links" type="text" name="investment_policy" id="investment_policy" placeholder="Sobre a política de investimento...">
                            <?php 
                                if($data['info']['politica_investimento'] !== null){
                                    echo $data['info']['politica_investimento'];
                                }
                            ?>
                        </textarea>
                    </div>

                    <!-- comitê de investimento -->
                    <div class="tab-content" id="comite_investimento">
                        <textarea class="editor-links" type="text" name="investment_committee" id="investment_committee" placeholder="Sobre o comitê de investimento...">
                            <?php 
                                if($data['info']['comite_investimento'] !== null){
                                    echo $data['info']['comite_investimento'];
                                }
                            ?>
                        </textarea>
                    </div>

                    <!-- estudo de ALM -->
                    <div class="tab-content" id="estudo_alm">
                        <textarea class="editor-links" type="text" name="alm" id="alm" placeholder="Sobre o estudo de ALM...">
                            <?php 
                                if($data['info']['descricao_alm'] !== null){
                                    echo $data['info']['descricao_alm'];
                                }
                            ?>
                        </textarea>
                    </div>
                </div>
            </div>

            <!-- logos de parceiros -->
            <div class="medias-list"></div>
            <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Clique e arraste a logo para um novo local na tabela para alterar a ordem que são exibidas.</span>

            <!-- senha -->
            <h2 class="title">Senha</h2>
            <div>
                <div class="input">
                    <label for="pass">Senha atual<span class="error"></span></label>
                    <input type="password" id="pass" name="pass" placeholder="Digite a senha" autocomplete="off">
                </div>
    
                <div class="input">
                    <label for="new_pass">Nova senha<span class="error"></span></label>
                    <input type="password" id="new_pass" name="new_pass" placeholder="Digite a senha" autocomplete="off">
                </div>
            </div>
            
            <!-- infos senha -->
            <div>
                <span class="important-info"><i class="fa-regular fa-circle-exclamation"></i>Deve conter no mínimo 8 caracteres, um número, uma letra maiúscula e um caractere especial.</span>
            </div>

            <div>
                <button type="button" id="btnChange">Alterar</button>
            </div>
            
        </form>
        <div class="bg-modal">
            <div class="modal-info">
                <h1 class="success"></h1>
                <p></p>
                <button type="button" id="btnModal">Ok</button>
            </div>
           
            <div class="modal modal-confirm">
                <p></p>
                <button type="button" id="btnModalConfirm">Excluir</button>
                <button type="button" id="btnModal">Não</button>
            </div>
        </div>

    </div>
</body>
</html>

<script src="<?= base_url() ?>assets/js/tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>assets/js/tinymce/langs/pt_BR.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js"></script>
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/account/institute/change-infos-institute.js") ?>"></script>  <!-- js próprio -->
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/cep.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/br-states.js") ?>"></script>
<script src="<?= base_url("assets/js/tab/tab.js") ?>"></script>
<script src="<?= base_url("assets/js/table/pagination/logos-media.js") ?>"></script>
<script src="<?= base_url("assets/js/table/drag-drop/logos.js") ?>"></script>