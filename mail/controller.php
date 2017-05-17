<?php

	if($_POST){

		
		$nombre = $_POST["nombre"];
		$apellido = $_POST["apellido"];
		$userName = $_POST["usuario"];
		$email = $_POST["email"];
		$urlSave = "http://localhost/";
		


		/*-----------------------------------------------*/
		//Generar contraseña aleatoria.
		$newPass = rand(10, 999);
		$newPass .= substr($nombre, rand(0, strlen($nombre) ) );
		$newPass .= rand(10, 999);
		$newPass .= substr($apellido, rand(0, strlen($apellido) ) );

		echo $newPass . "<br/><br/><br/>";
		/*-----------------------------------------------*/

		require 'phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;								// Enable verbose debug output
		$mail->isSMTP();									// Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';				// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;								// Enable SMTP authentication
		$mail->Username = 'infoincocredito@gmail.com';		// SMTP username
		$mail->Password = 'incocredito2015';				// SMTP password
		$mail->SMTPSecure = 'tls';							// Enable TLS encryption, 
		$mail->Port = 587;									// TCP port to connect to

		$mail->setFrom('infoincocredito@example.com', 'Info Save');
		$mail->addAddress($email, $nombre);     // Add a recipient


		/*--------------------------------------------------------------------------------*/
		$html = "<!DOCTYPE html>";
		$html .= "<html>";
		$html .= "<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">";
		$html .= "<meta content=\"width=device-width, initial-scale=1\" name=\"viewport\">";
		$html .= "<head>";
		$html .= "<link href=\"https://fonts.googleapis.com/css?family=Montserrat\" rel=\"stylesheet\" type=\"text/css\">";
		$html .= "</head>";
		$html .= "<body style=\"margin: 0 auto; width: 100%; font-family: 'Montserrat', sans-serif; margin: 0 auto;\">";
		$html .= "<table style=\"text-align: center; width: 650px; display:block;\">";
		$html .= "<tbody style=\"display:block;\">";
		$html .= "<tr style=\"height: 107px; line-height: 80px; background: #34495e; display:block;\">";
		$html .= "<td style=\"width:100%; display:block;\">";
		$html .= "<h1 style=\"font-size: 25px; font-weight: normal; background: none; color: #fff; display:block;\">";
		$html .= "Hola, bienvenido a ";
		$html .= "<a style=\"color: #fff; font-weight: 700; background: none; font-style: italic;\">";
		$html .= "Save";
		$html .= "</a>";
		$html .= "</h1>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr style=\"background: #2c3e50; height:10px; display:block;\">";
		$html .= "<td style=\"width:100%; display:block;\">";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr style=\"display:block; width:100%;\">";
		$html .= "<td style=\"text-align: justify; padding: 20px 120px; display:block;\">";
		$html .= "<p style=\"display:block;\">Hola ". $nombre ." te damos la bienvenida a la plataforma de Save, para poder ingresar a la aplicaci&oacute;n deber&aacute;s identificarte con los datos descritos en este correo. </p>";
		$html .= "<center>	";
		/*--------------------------------------------------------------------------------*/
		$html .= "<p>Usuario: <a style=\"color: #22A7F0; font-weight: 700;\">";
		$html .= $userName;		//NOMBRE USUARIO
		$html .= "</a> </p>";
		$html .= "<p>Contrase&ntilde;a: <a style=\"color: #22A7F0; font-weight: 700;\">";
		$html .= $newPass;		//CONTRASEÑA
		$html .= "</a> </p>";
		/*--------------------------------------------------------------------------------*/
		$html .= "<br />";
		$html .= "<a href=\"". $urlSave ."\" target=\"_blanc\" style=\"background: #3498db; padding: 10px; border-radius: 7px; text-align: center; border-bottom: 4px solid #34495e; text-decoration: none; color: #fff;\">Ir a la plataforma</a>";
		$html .= "</center>";
		$html .= "<br />";
		$html .= "<p style=\"font-style: italic;\">Si este correo no es para ti, haz caso omiso al mismo. </p>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr style=\"height: 70px; line-height: 70px; background-color: #555; color:#ccc; display:block; font-size: smaller;\">";
		$html .= "<td style=\"width:100%; display:block;\">";
		$html .= "<span style=\"background: none;\">Proyecto SAVE todos los derechos reservados</span>";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "<tr style=\"background: #333; height:5px; display:block;\">";
		$html .= "<td style=\"width:100%; display:block;\">";
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</body>";
		$html .= "</html>";
		/*--------------------------------------------------------------------------------*/
		$MensajeAlterno = "No se ha podido cargar el mensaje completo. Para acceder a la aplicacion por favor ingrese a http://www.proyectosave.com/ y ingrese sus datos. Su nueva contraseña es: ". $newPass . " Si tiene algun problema al iniciar, por favor contactese con el administrador.";
		/*--------------------------------------------------------------------------------*/

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = htmlspecialchars('Bienvenido '. $nombre .' a Save.com');
		$mail->Body    = $html; 
		$mail->AltBody = $MensajeAlterno;

		if(!$mail->send()) {
		    echo 'El correo no pudo ser enviado.';
		    echo 'PHPMailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Mensaje enviado correctamente.';
		}
	}else{
		echo "No hay petición";
	}

?>