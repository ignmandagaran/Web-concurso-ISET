<?php
	ini_set("SMTP","/usr/local/bin/sendmail");
	ini_set("smtp_port","localhost");
	ini_set('sendmail_from', 'concursoiset@gmail.com');

	//variables para los campos de texto
	$nombre = strip_tags($_POST["nombre"]);
	$mail = strip_tags($_POST["correo"]);
	$mensaje = strip_tags($_POST["comentario"]);

	//variables para los datos del archivo
	$nameFile = $_FILES['file-3']['name'];
	$sizeFile = $_FILES['file-3']['size'];
	$typeFile = $_FILES['file-3']['type'];
	$tempFile = $_FILES["file-3"]["tmp_name"];
	$fecha= time();
	$fechaFormato = date("j/n/Y",$fecha);

	$correoDestino = "concursoiset@gmail.com";
	
	//asunto del correo
	$asunto = "Enviado por " . $nombre;

 	
 	// -> mensaje en formato Multipart MIME
	$cabecera = "MIME-VERSION: 1.0\r\n";
	$cabecera .= "Content-type: multipart/mixed;";
	//$cabecera .="boundary='=P=A=L=A=B=R=A=Q=U=E=G=U=S=T=E=N='"
	$cabecera .="boundary=\'=C=T=E=C=\"\r\n'";
	$cabecera .= "From: {$mail}";

	//Primera parte del cuerpo del mensaje
	$cuerpo = "--=C=T=E=C=\r\n";
	$cuerpo .= "Content-type: text/plain";
	$cuerpo .= "charset=utf-8\r\n";
	$cuerpo .= "Content-Transfer-Encoding: 8bit\r\n";
	$cuerpo .= "\r\n"; // línea vacía
	$cuerpo .= "Correo enviado por: " . $nombre;
	$cuerpo .= " con fecha: " . $fechaFormato . "\r\n";
	$cuerpo .= "Email: " . $mail . "\r\n";
	$cuerpo .= "Mensaje: " . $mensaje . "\r\n";
	$cuerpo .= "\r\n";// línea vacía

 	// -> segunda parte del mensaje (archivo adjunto)
        //    -> encabezado de la parte
    $cuerpo .= "--=C=T=E=C=\r\n";
    $cuerpo .= "Content-Type: application/octet-stream; ";
    $cuerpo .= "name=" . $nameFile . "\r\n";
    $cuerpo .= "Content-Transfer-Encoding: base64\r\n";
    $cuerpo .= "Content-Disposition: attachment; ";
    $cuerpo .= "filename=" . $nameFile . "\r\n";
    $cuerpo .= "\r\n"; // línea vacía

    $fp = fopen($tempFile, "rb");
    $file = fread($fp, $sizeFile);
	$file = chunk_split(base64_encode($file));

    $cuerpo .= "$file\r\n";
    $cuerpo .= "\r\n"; // línea vacía
    // Delimitador de final del mensaje.
    $cuerpo .= "--=C=T=E=C=--\r\n"; 
    
	//Enviar el correo
	if(mail($correoDestino, $asunto, $cuerpo, $cabecera)){//mail(to,subject,message,headers,parameters)
		echo "Correo enviado";
	}else{
		echo "Error de envio";
	}

?>