<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$contenido=$_GET["va"];
$downloadfile="nombre.txt";
/*
header("Content-disposition: attachment; filename=$downloadfile");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".strlen($contenido));
header("Pragma: no-cache");
header("Expires: 0");
echo $contenido;
*/
/*
    1.- Creamos la variable que contiene el archivo que tenemos que crear.
    2.- preguntamos si existe el archivo, si el archivo existe "se ha modificado" en caso contrario el archivo se ha creado.
    3.- Con fopen abrimos un archivo o url, en este caso vamos a abrir un archivo pasando como parámetro la variable $nombre_archivo que es la que contiene 
        nuestro archivo y como segundo parámetro como lo vamos a abrir, en este caso "a" que nos abre el fichero en solo lectura y sitúa el puntero al final
		del fichero y en el caso de que no exista lo crea.
    4.-Con el fwrite escribimos dentro del archivo la fecha con la hora de Creación o modificación, según el caso, con la variable $mensaje, 
*/
    $nombre_archivo = "D:/RaizPHP/Sunat/".$downloadfile; 
    if(file_exists($nombre_archivo))
    {
		$mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
    else
    {
        $mensaje = "El Archivo $nombre_archivo se ha creado";
    }
    if($archivo = fopen($nombre_archivo, "w"))
    {
        if(fwrite($archivo, date("d m Y H:m:s")."\n". $contenido."\n"))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }
        fclose($archivo);
    }
?>