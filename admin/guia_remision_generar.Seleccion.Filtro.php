<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$datos = $_POST['id'];
//Realiza las operaciones de asignacion o separacion de datos de la variable $datos recibido desde id
$resul = explode(":", $datos);
$desc=$resul[0];
$imei=$resul[1];
$icc=$resul[2];
$zona=$resul[3];
$tipo=$resul[4];
$clase=$resul[5];
$cond_sql="";
if (!empty($desc)) $cond_sql="(abrv_pro LIKE '%$desc%') AND ";
if (!empty($imei)) $cond_sql=$cond_sql."(imei_pro LIKE '%$imei%') AND ";
if (!empty($icc)) $cond_sql=$cond_sql."(icc_pro LIKE '%$icc%') AND ";
if (!empty($zona)) $cond_sql=$cond_sql."(zona_pro LIKE '%$zona%') AND ";
if (!empty($tipo)) $cond_sql=$cond_sql."(tipo_cat LIKE '%$tipo%') AND ";
if (!empty($clase)) $cond_sql=$cond_sql."(clase_cat LIKE '%$clase%') AND ";
$cond_sql=substr($cond_sql,0,strlen($cond_sql)-5);
if (empty($cond_sql)) $cond_sql="1";

if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) 
{
	$sql=mysqli_query($Conexion,"SELECT * FROM productos WHERE ".$cond_sql." ORDER BY id_pro DESC"." LIMIT 10");
}
else
{
	$sql=mysqli_query($Conexion,"SELECT * FROM productos WHERE ".$cond_sql." AND (zona_pro='$zona_usuario') ORDER BY id_pro DESC"." LIMIT 10");
}
tblanchovariable_06($Conexion,"margin-left:0px;","height:315px;",$sql,"tblreporte01","guia_remision_tmp.busca_producto.php",
	"ID:id_pro:50:idLink|",
	"Descripción:abrv_pro:196:N",
	"Imei:imei_pro:145:N",
	"Icc:icc_pro:145:N",
	"Zona Origen:zona_pro:100:N",
	"Tipo:tipo_cat:80:N",
	"Clase:clase_cat:90:N",
	"Fecha:fechreg_pro:80:invFech|",
	"Activo:activ_pro:60:N",
	"Precio:precio_pro:100:N",
	"Monto Actual:ultreg_pro:100:N");
?>