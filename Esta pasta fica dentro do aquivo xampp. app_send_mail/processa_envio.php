<?php

	require "./bibliotecas/PHPMailer/Exception.php";
	require "./bibliotecas/PHPMailer/OAuth.php";
	require "./bibliotecas/PHPMailer/PHPMailer.php";
	require "./bibliotecas/PHPMailer/POP3.php";
	require "./bibliotecas/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//print_r($_POST);

	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
		public $status = array('codigo_status' => null, 'descricao_status' => '') 

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);

	//print_r($mensagem);

	if(!$mensagem->mensagemValida()) {
		echo 'Mensagem não é válida';
		die();
	}

	$mail = new PHPMailer(true);
	try {
			//Server settings
			$mail->SMTPDebug = false;                      //Enable verbose debug 
			$mail->isSMTP();                                            //
			$mail->Host       = 'smtp.gmail.com';                     //Set 
			$mail->SMTPAuth   = true;                                   //
			$mail->Username   = 'webcompleto2@gmail.com';                     
			$mail->Password   = '!@#$4321';                               //
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;                                    //TCP 

			//Recipients
			$mail->setFrom('webcompleto2@gmail.com', 'Web Completo Remetente');
			$mail->addAddress($mensagem->__get('para'));     //Add a recipient
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $mensagem->__get('assunto');
			$mail->Body    = $mensagem->__get('mensagem') 
			$mail->AltBody = 'E necessario utilizar um client que suporte HTML para ter acesso total ao conteudo dessa mensagem ';
			$mail->send();

			$mensagem->status['codigo_status'] = 1;
			$mensagem->status['descricao_status'] = 'E-mail enviado com sucesso';
	
	} catch (Exception $e) {

					$mensagem->status['codigo_status'] = 2;
			$mensagem->status['descricao_status'] = '"Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde.' . $mail-?'Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde.' . $mail->ErrorInfo;

?>

<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>
<body>

	<div class="container">
					<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<? if($mensagem->satatuo['codigo_satatus'] == 1) {?>

			<div class="container">
				<h1 class="display-4 text-success">Sucesso</h1>
				<p><?= $mensagem->status['descricao_status']?></p>
				<a href="index.php" class="btn btn-success btn-lg mt-5 text-white"> Voltar</a>
			</div></div>

		<? } ?>
					<? if($mensagem->satatuo['codigo_satatus'] == 2) {?>

			<div class="container">
				<h1 class="display-4 text-danger">Ops!</h1>
				<p><?= $mensagem->status['descricao_status']?></p>
				<a href="index.php" class="btn btn-success btn-lg mt-5 text-white"> Voltar</a>
			</div>

		<? } ?>

		</div>
	</div>


</body>
</html>





