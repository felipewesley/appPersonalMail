<?php

namespace App\Model;

use App\MailService;
use MiniFramework\Controller\Debug;
use MiniFramework\Model\Model;

// use PHPMailer\PHPMailer;
// use PHPMailer\Exception;
// use PHPMailer\SMTP;

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\SMTP;

use App\PHPMailer\PHPMailer;
use App\PHPMailer\Exception;
use App\PHPMailer\SMTP;

class ProcessaMail extends Model {

	private $data = [];

	public function setData($key, $data) {

		$this->data[$key] = $data;
	}

	public function getData() {

		return $this->data;
	}

	public function criaMensagem($destino, $assunto, $mensagem){

		if (!Mensagem::validarMensagem($destino, $assunto, $mensagem)) {
			return null;
		}
		$m = new Mensagem();

		$m->__set('destino', $destino);
		$m->__set('assunto', $assunto);
		$m->__set('mensagem', $mensagem);

		return $m;
	}

	public function criaEmail($mensagem, $preview = false) {

		if(is_null($mensagem)){
			return $mensagem;
		}

		$parms = MailService::getParms();

		$this->setData('parms', $parms['mail_service']);
		$this->setData('mensagem', $mensagem);

		if ($preview) {
			return $this->getData();
		}

		return $this->sendMail($this->getData());
	}

	private function sendMail($data) {

		if(is_null($data)) {
			// Debug::show('Um ou mais campos não foram preenchidos corretamente.');
			return 'nao passou nem do começo do negocio';
		}

		$mail = new PHPMailer(true);
		$msg = $data['mensagem'] ?? null;
		$user = $data['user'] ?? null;

		try {
			//Server settings
			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = $data['parms']['host'];                 // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = $user['user_username'];                 // SMTP username
			$mail->Password   = $user['user_password'];                 // SMTP password
			$mail->SMTPSecure = $data['parms']['SMTPSecure'];;          // SMTP secure default
			$mail->Port       = $data['parms']['port'];;                // TCP port to connect to

			//Recipients
			$mail->setFrom($user['user_username'], $user['user_idname']);
			$mail->addAddress($msg->__get('destino'));                  // Add a recipient
			// $mail->addAddress('ellen@example.com');                  // Name is optional
			// $mail->addReplyTo('info@example.com', 'Information');    // Set reply for this
			// $mail->addCC('cc@example.com');
			// $mail->addBCC('bcc@example.com');

			// Attachments
			// $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name

			// Content
			$mail->isHTML(true);                                        // Set email format to HTML
			$mail->Subject = empty($msg->__get('assunto')) ? '(sem assunto)':$msg->__get('assunto');
			$mail->Body    = $msg->__get('mensagem');
			$mail->AltBody = 'Impossível carregar e-mail. Solicite ao remetente utilizar um serviço de e-mail que suporte formato HTML.';

			// Send Email
			return $mail->send();

			return 'nao houve erros';

		} catch (Exception $e) {

			if(strpos($e, 'Could not authenticate')){
				return '
					#Erro: Houve um erro de autenticação com o serviço do Gmail.<br>
					#Erro: Usuário ou senha inválidos!
				';
			} elseif(strpos($e, 'Invalid address')){
				return '
					#Erro: Destinatário informado não corresponde a um endereço de e-mail válido.
				';
			} elseif(strpos($e, 'Message body empty')){
				return '
					#Erro: A mensagem do e-mail está vazia.<br>
					#Erro: Impossível enviar um e-mail sem corpo.
				';
			}

			return '#Erro: Sem mais informações :('.$e;

		} catch(\Exception $e) {

			return 'mensage invalidaaaaaaa';
		}

		return 'tem alguma coisa errado bro';

	}

}
