<?php 
    if(!isset($alt)){ ?>
        <table style="width: 100%; max-width:800px; font-size: 14px; font-family:sans-serif; box-shadow: 1px 2px 5px 0px black; border-radius: 10px; padding: 40px; position:absolute;transform:translate(-50%, -50%); top: 50%; left: 50%;">
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
                        <p>Para confirmar seu email de cadastro do <?php echo strtoupper($institute) ?>, basta clicar no botão abaixo.</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="<?php echo base_url(strtolower($institute) . "/confirmar-email?key=" . $key)?>" style="font-size: 1.2rem; color: black; text-decoration: none;"><button type="button" style="border: 1px solid; padding: 10px; margin: auto; background-color: transparent;">Confirmar cadastro</button></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <hr style="width: 100%; border-color: rgba(128, 128, 128, 0.273); margin: 15px 0px;" />
                        <p style="text-align: center;">Precisa de ajuda? <a href="https://wa.me/+55<?php echo  $tel ?>?text=Olá">Nos envie uma mensagem por whatsapp</a>.</p>
                    </td>
                </tr>
            </tfoot>
        </table>
<?php }

// mail alt
else if($alt == true){
    echo "Olá $name[0], \n";
    echo "Para confirmar seu Email de cadastro do " . strtoupper($institute) . ", basta colar o link abaixo no navegador.\n";
    echo base_url(strtolower($institute)."/confirmar-email?key=") . $key . "\n";
    echo "Precisa de ajuda? Nos envie uma mensagem por whatsapp +55 $tel.";
}