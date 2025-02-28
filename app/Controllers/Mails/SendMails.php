<?php

namespace App\Controllers\Mails;

use App\Controllers\BaseController;
use App\Controllers\Session;
use App\Models\Session\SessionModel;
use App\Models\Session\SessionUserModel;

use PHPMailer\PHPMailer\PHPMailer;

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

require '../vendor/autoload.php';
define('WEBPREV_TEL', '47988486119');

/**
 * Classe de controle do envio de emails
*/

class SendMails extends BaseController
{   
    private $mail;

    public function __construct() {
        $this->mail = (new PHPMailer(true));
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.rpps.com.br';
        $this->mail->Port = '587';
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mail->Username = 'sistema@rpps.com.br';
        $this->mail->Password = '@W3bpr3vMails@';
        $this->mail->SMTPAuth = true;
        $this->mail->isHTML(true);
        $this->mail->setLanguage('br');
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    private function getInstituteId($institute){
        return (new SessionModel)->getInstituteId($institute);
    }  

    public function confirmEmail($data) {

        $data['key'] = (new SessionUserModel)->updateKey($data);

        if($data['key'] != false){
            
            // pegar dados do instituto pelo id
            $institute = (new Session)->dataInstitute($data['institute'], ['contatos', 'instituto'], ['contatos' => ['telefones', 'email'], 'instituto' => ['nome']]); 
            
            // template html email
            $template = view("mails/verify-mail", ['name' => explode(" ", $data['name']), 'institute' => $institute['instituto']['nome'], 'key' => $data['key'], 'tel' => $institute['contatos']['tel']]);
            
            // template alt email
            $templateAlt = view("mails/verify-mail", ['name' => explode(" ", $data['name']), 'institute' => $institute['instituto']['nome'], 'key' => $data['key'], 'tel' => $institute['contatos']['tel'], 'alt' => true]);
            
            $this->mail->addReplyTo($institute['contatos']['email'], $institute['instituto']['nome']); // responder para
            $this->mail->setFrom('sistema@rpps.com.br', strtoupper($institute['instituto']['nome'])); // de
            $this->mail->addAddress($data['email'], $data['name']); // para            

            $subject = "Confirmação de email de cadastro no " . strtoupper($institute['instituto']['nome']); // título
            $this->mail->Subject = $subject;
            
            // img
            $path = FCPATH . 'dynamic-page-content/'. strtolower($institute['instituto']['nome']) .'/assets/uploads/img/logos/own/logo.png';
            $this->mail->addEmbeddedImage($path, 'logo', 'logo.png', 'base64', 'image/png');

            $this->mail->Body = $template;
            $this->mail->AltBody = $templateAlt;           

            if(!$this->mail->send()){
                return false;
            }
            return true;
        }

        return false;
    }

    public function sendEmail($data, $dataInstitute, $key){
        // carrega o template do email
        if($dataInstitute != false){
            // template email
            $template = view("mails/recover-account", ['name' => explode(" ", $data["nome"]), 'institute' => $dataInstitute['instituto']['nome'], 'key' => $key, 'tel' => $dataInstitute['contatos']['tel']]);
            
            // template email alt
            $templateAlt = view("mails/recover-account", ['name' => explode(" ", $data["nome"]), 'institute' => $dataInstitute['instituto']['nome'], 'key' => $key, 'tel' => $dataInstitute['contatos']['tel'], 'alt' => true]);


            $this->mail->addReplyTo($dataInstitute['contatos']['email'], strtoupper($dataInstitute['instituto']['nome'])); // responder para
            $this->mail->setFrom('sistema@rpps.com.br', strtoupper($dataInstitute['instituto']['nome'])); // de
            $this->mail->addAddress($data['email'], $data["nome"]); // para
    
            $subject = "Pedido de redefinição de senha do " . strtoupper($dataInstitute['instituto']['nome']); // título

            $path = FCPATH . 'dynamic-page-content/'. strtolower($dataInstitute['instituto']['nome']) .'/assets/uploads/img/logos/own/logo.png';
            $this->mail->addEmbeddedImage($path, 'logo', 'logo.png', 'base64', 'image/png'); // logo instituto
        } else {
            // template email
            $template = view("mails/recover-account", ['name' => $data['instituto']["nome"], 'key' => $key, 'tel' => WEBPREV_TEL]);
            // template email alt
            $templateAlt = view("mails/recover-account", ['name' => $data['instituto']["nome"], 'key' => $key, 'tel' => WEBPREV_TEL, 'alt' => true]);

            $this->mail->setFrom('sistema@rpps.com.br', 'Sistema RPPS'); // de
            $this->mail->addAddress($data['contatos']['email'], $data['instituto']['nome']); // para
    
            $subject = "Pedido de redefinição de senha do " . strtoupper($data['instituto']['nome']); // título
        }

        $this->mail->Subject = $subject;
        $this->mail->Body = $template;
        $this->mail->AltBody = $templateAlt;

        if(!$this->mail->send()){
            $this->mail->ErrorInfo;
        }
    }

    public function contact(){
        $data = [
            'name' => $this->request->getPost('name'),
            'cnpj' => $this->request->getPost('cnpj'),
            'company' => $this->request->getPost('company'),
            'email' => $this->request->getPost('email'),
            'tel' => $this->request->getPost('tel'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ];

        $institute = (new Session)->dataInstitute($this->getInstituteId($this->request->getPost('institute')), ['contatos', 'instituto'], ['contatos' => ['email'], 'instituto' => ['nome']]);

        // template email
        $template = view("mails/contact-us", ['data' => $data]);
        $templateAlt = view("mails/contact-us", ['data' => $data, 'alt' => true]);
        
        $this->mail->addReplyTo($data['email'], $data['name']); // responder para
        $this->mail->setFrom('sistema@rpps.com.br', $data['name']); // de
        $this->mail->addAddress($institute['contatos']['email'], $institute['instituto']['nome']); // para

        $subject = $this->request->getPost('subject'); // título
    
        $this->mail->Subject = $subject;
        $this->mail->Body = $template;
        $this->mail->AltBody = $templateAlt;

        if(!$this->mail->send()){
            $msg = "Falha ao enviar o email, tente novamente!";
        } else {
            $msg = "Email enviado com sucesso!";
        }

        return $msg;
    }
}
