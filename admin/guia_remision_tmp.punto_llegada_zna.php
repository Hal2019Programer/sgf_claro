<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$id_zna = $_POST['datos'];
//Datos del usuario que envia
$consulta_usuario=mysqli_query($Conexion,"SELECT nomb_usr, apel_usr, dni_usr FROM usuarios WHERE id_usr='$ident_usuario'");
if (mysqli_num_rows($consulta_usuario)>0)
{
	$rs=mysqli_fetch_array($consulta_usuario,MYSQLI_ASSOC);
	$ruc=$rs["dni_usr"];
	$nomb_y_apel=$rs["nomb_usr"]." ".$rs["apel_usr"];
}
else
{
	$ruc="56895859585";
	$nomb_y_apel="Carlos Aguirre";
}
//Realiza las operaciones con dato anterior
$consulta_zona=mysqli_query($Conexion,"SELECT direc_zna FROM zona WHERE id_zna='$id_zna'");
$resultado=mysqli_fetch_array($consulta_zona, MYSQLI_ASSOC);
//Devuelve el resultado mediante la presentación de datos, por ejemplo 'echo' de PHP
//echo "1=".$resultado["direc_zna"];
//echo "*=".$resultado["direc_zna"].":56895859585:Carlos Aguirre";
//echo "*=".$resultado["direc_zna"].":".$ruc.":".$nomb_y_apel;
echo "*=".$resultado["direc_zna"];
?>