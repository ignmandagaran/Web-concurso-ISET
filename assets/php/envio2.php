<?php
    //guarda en la carpeta uploads las imagenes enviadas. la carpeta debe tener permiso de escritura o 0777 en unix

	if (!isset($_FILES["file-3"])) { // no subio el archivo
        return;
    }

    if (!isset($_REQUEST["nombre"]) || !isset($_REQUEST["correo"])) { // faltan datos
        return;
    }

    $nombre_archivo_subido = basename($_FILES["file-3"]["name"]); 
    $extension_archivo_aubido = pathinfo($_FILES["file-3"]["tmp_name"], PATHINFO_EXTENSION);

    $nombre_archivo = "uploads/".$nombre_archivo_subido."_".date("Ymdhis").".".$extension_archivo_aubido;

    if (!copy($_FILES["file-3"]["tmp_name"], $nombre_archivo)) { // no copio
        return 
    }

    $contenido_archivo  = $_REQUEST["nombre"]."\r\n";
    $contenido_archivo .= $_REQUEST["correo"]."\r\n";
    $contenido_archivo .= $_REQUEST["detalle"]."\r\n";
    $contenido_archivo .= $nombre_archivo."\r\n";
    
    if (!file_put_contents("uploads/".$nombre_archivo_aubido.".txt")) {
        return;
    }

    print "OK";

/*
PARA VISUALIZAR

recorrer todo el dir uploads
filtrar solo txt
cargar info del txt e imagen en un div
*/