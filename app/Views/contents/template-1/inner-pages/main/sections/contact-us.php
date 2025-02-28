<!--------------- formatações --------------->
<?php

use Functions\Formatter\Formatter;

require_once("functions/formatter.php");
$formatter = new Formatter;
?>
<!------------------------------------------->

<head>
    <link rel="stylesheet" href="<?= base_url("assets/css/template-1/common/modal-infos.css") ?>">
</head>

<section class="contents links-contact">
    <div class="container">
        <div class="contacts">

            <div class="contact">
                <div class="contact-info">
                    <div>
                        <a href="<?php if(strlen($data['contatos']['tel']) > 0){echo "https://wa.me/+55" . $data['contatos']['tel'] . "?text=Olá";} else { echo "#";}?>" <?php if(strlen($data['contatos']['tel']) > 0){ ?> target="_blank" <?php }?> >
                            <div class="icon"><i class="fa-light fa-phone-volume"></i></div>
                            <div class="info">
                                <div class="title"><h4>Contato</h4></div>
                                <div class="phone">
                                    <p>Telefone:<span>
                                    <?php 
                                        if(strlen($data['contatos']['fix_tel']) > 0){
                                            echo $formatter->tel($data['contatos']['fix_tel']);
                                        } 
                                        else {
                                            echo 'Não informado';
                                        }
                                        
                                        ?>
                                    </span></p>
                                    <p>Whatsapp:<span>
                                        <?php if (strlen($data['contatos']['tel']) > 0) {
                                            echo $formatter->tel($data['contatos']['tel']);
                                        } 
                                        else {
                                            echo 'Não informado';
                                        } ?>
                                    </span></p>
                                </div>
                                <div class="email"><p>E-mail: <span><?php echo $data['contatos']['email'] ?></span></p></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="address-info">
                    <div>
                        <a href="<?php if(strlen(adress($data['infos'])) > 0){ echo 'https://www.google.com/maps/search/' . adress($data['infos']); } else { echo '#';}?>" <?php if(strlen(adress($data['infos'])) > 0){ ?> target="_blank" <?php } ?> >
                            <div class="icon"><i class="fa-light fa-location-dot"></i></div>  
                            <div class="info">
                                <div class="title"><h4>Localização</h4></div>
                                <div class="street-address"><p><?php echo $data['infos']['rua'] . ", " . $data['infos']['numero'] . ' ' . $data['infos']['bairro'] . " | " . $data['infos']['cidade'] . " – " . $data['infos']['estado'] . " | " . $data['infos']['cep'] ?></p></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="contents form">

    <div class="container">
        <div class="contacts">
            <div class="form-contact">
                
                <!-- formulário -->
                <form action="">
                    <div class="input">
                        <input type="text" name="name" id="name" placeholder="Nome Completo">
                        <span class="error"></span>
                    </div>
                    <div class="two-inputs">
                        <div class="input">
                            <input type="email" name="email" id="email" placeholder="E-mail">
                            <span class="error"></span>
                        </div>
                        <div class="input">
                            <input type="tel" name="tel" id="tel" placeholder="Telefone" onkeypress="mask(this, mphone);">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="two-inputs">
                        <div class="input">
                            <input type="text" name="company" id="company" placeholder="Empresa">
                            <span class="error"></span>
                        </div>
                        <div class="input">
                            <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" onpaste="mask(this, mCNPJ)" onkeypress="mask(this, mCNPJ)">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="input">
                        <input type="text" name="address" id="address" placeholder="Endereço">
                        <span class="error"></span>
                    </div>
                    <div class="two-inputs">
                        <div class="input">
                            <input type="text" name="city" id="city" placeholder="Cidade">
                            <span class="error"></span>
                        </div>
                        <div class="input">
                            <input type="text" name="state" id="state" placeholder="Estado">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="input">
                        <input type="text" name="subject" id="subject" placeholder="Assunto">
                        <span class="error"></span>
                    </div>
                    <div class="input">
                        <textarea type="text" name="message" id="message" placeholder="Mensagem" cols="40" rows="7"></textarea>
                        <span class="error"></span>
                    </div>
                    <div class="btn">
                        <button type="button" id="btnContact">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-modal">
        <div class="modal-info">
            <p></p>
            <button type="button" id="btnModal">Ok</button>
        </div>
    </div>
</section> 
<script src="<?= base_url("assets/js/forms/contact/form-data.js") ?>"></script>  <!-- js próprio -->
<script src="<?= base_url("assets/js/forms/form-checks.js") ?>"></script> 
<script src="<?= base_url("assets/js/modal/modal.js") ?>"></script>
<script src="<?= base_url("assets/js/forms/clear-all.js") ?>"></script>


<?php 

function adress($data){
    $adress =  "";
    
    foreach ($data as $key => $adressInf) {
        if(strlen($adressInf) > 0){
            if($key == 'rua'){
                $adress .= $adressInf;
                continue;
            }
            else if($key == 'estado'){
                $adress .= '+,+' . $adressInf;
                continue;
            }
            
            $adress .= '+-+' . $adressInf;
        }
    }

    return $adress;
}
?>