
<?php if(!isset($alt)){ ?>
    <table style="width: 100%; max-width:800px; font-size: 14px; font-family:sans-serif; box-shadow: 1px 2px 5px 0px black; border-radius: 10px; padding: 40px; position:absolute;transform:translate(-50%, -50%); top: 50%; left: 50%;">
        <?php if(isset($institute)){ ?> <!-- para usuários  -->
            <thead>
                <tr>
                    <th>
                        <img src="cid:logo" alt="logo" style="width: 100%; max-width: 200px; height: auto;">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>   
                        <h1>Olá <?php echo $name[0] ?>,</h1>
                        <p>Sua senha do <?php echo strtoupper($institute) ?> pode ser redefinida clicando no botão abaixo. Se você não solicitou uma nova senha, ignore este email.</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="<?php echo base_url(strtolower($institute)."/alterar-senha?key=") ?><?php echo $key?>" style="cursor: pointer; border-radius: 5px; box-shadow: inset 0 0 8px 2px rgb(0 0 0 / 15%); transition: .8s; padding: 8px; font-size: 1.2rem; font-weight: 700; color: black;"><button type="button" style="border: 1px solid; padding: 10px; margin: auto; cursor: pointer; background-color: transparent;">Redefinir senha</button></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <hr style="width: 100%; border-color: rgba(128, 128, 128, 0.273); margin: 15px 0px;" />
                        <p>Precisa de ajuda? <a href="https://wa.me/+55<?php echo  $tel ?>?text=Olá">Nos envie uma mensagem por whatsapp</a>.</p>
                    </td>
                </tr>
            </tfoot>
        <?php } 
        else {?> <!-- para institutos  -->
            <tbody>
                <tr>
                    <td>   
                        <h1>Olá <?php echo strtoupper($name) ?>,</h1>
                        <p>Sua senha pode ser redefinida clicando no botão abaixo. Se você não solicitou uma nova senha, ignore este email.</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="<?php echo base_url(strtolower($name)."/alterar-senha?key=") ?><?php echo $key ?>" style="cursor: pointer; border-radius: 5px; box-shadow: inset 0 0 8px 2px rgb(0 0 0 / 15%); transition: .8s; padding: 8px; font-size: 1.2rem; font-weight: 700; color: black;"><button type="button" style="border: 1px solid; padding: 10px; margin: auto; cursor: pointer; background-color: transparent;">Redefinir senha</button></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <hr style="width: 100%; border-color: rgba(128, 128, 128, 0.273); margin: 15px 0px;"/>
                        <p>Precisa de ajuda? <a href="https://wa.me/+55<?php echo $tel ?>?text=Olá">Nos envie uma mensagem por whatsapp</a>.</p>
                    </td>
                </tr>
            </tfoot> 
        <?php }  ?>
    </table>
<?php }
// mail alt
else if($alt == true){
    if(isset($institute)){ // para usuários
        echo "Olá $name[0], \n";
        echo "Sua senha do " . strtoupper($institute) . ", pode ser redefinida colocando o link abaixo no navegador. Se você não solicitou uma nova senha, ignore este email. \n";
        echo base_url(strtolower($institute)."/alterar-senha?key=") . $key . "\n";
        echo "Precisa de ajuda? Nos envie uma mensagem por whatsapp +55 $tel.";
    } 
    else { // para institutos
        echo "Olá" . strtoupper($name) . ", \n";
        echo "Sua senha pode ser redefinida colocando o link abaixo no navegador. Se você não solicitou uma nova senha, ignore este email. \n";
        echo base_url(strtolower($name)."/alterar-senha?key=") . $key . "\n";
        echo "Precisa de ajuda? Nos envie uma mensagem por whatsapp +55 $tel.";
    }
}
