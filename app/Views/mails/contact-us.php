<?php if(!isset($alt)){ ?>
    <table style="width: 100%; max-width:800px; font-size: 14px; font-family:sans-serif; box-shadow: 1px 2px 5px 0px black; border-radius: 10px; padding: 40px; position:absolute;transform:translate(-50%, -50%); top: 50%; left: 50%;">
            <tbody>
                <tr>
                    <td>
                        <h1> <?php echo $data['subject'] ?> </h1>
                        <p> <?php  echo $data['message'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Dados do remetente:</h3>
                        <p>                          
                            <b>Nome da empresa: </b> <?php echo $data['company'] ?> <br> 
                            <b>Endereço: </b><?php echo $data['state'] . ', ' . $data['city'] . ', ' . $data['address'] ?><br> 
                            <b>CNPJ: </b><?php echo $data['cnpj'] ?> <br> 
                            <b>Email: </b><?php echo $data['email'] ?><br>
                            <b>Telefone: </b><?php echo $data['tel'] ?><br>
                        </p>                          
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <hr style="width: 100%; border-color: rgba(128, 128, 128, 0.273); margin: 15px 0px;" />
                        <p>Entrar em contato: <a href="https://wa.me/+55<?php echo $data['tel'] ?>?text=Olá">enviar mensagem por whatsapp</a>.</p>
                    </td>
                </tr>
            </tfoot>
    </table>
<?php } 
else {
    echo $data['subject'] . "\n\n"; 
    echo $data['message'] . "\n";
    echo "Dados do remetente: \n\n";
    echo "Nome da empresa: " . $data['company'] . "\n"; 
    echo "Endereço: " . $data['state'] . ', ' . $data['city'] . ', ' . $data['address'] . "\n"; 
    echo "CNPJ: " . $data['cnpj'] . "\n"; 
    echo "Email: " . $data['email'] . "\n";
    echo "Telefone: " . $data['tel'] . "\n";
}
?>