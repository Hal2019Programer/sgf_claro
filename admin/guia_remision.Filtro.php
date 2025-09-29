<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$datos = $_POST['id'];
//Realiza las operaciones de asignacion o separacion de datos de la variable $datos recibido desde id
$resul = explode(":", $datos);
$ser_num=$resul[0];
$fecha=$resul[1];
$origen=$resul[2];
$destino=$resul[3];
$cadena_guia_remision="
SELECT a.id_gr, a.serie_gr, a.numero_gr, CONCAT(a.serie_gr,'-',a.numero_gr) AS serie_numero, a.fechtrasl_gr, 
a.znaorig_gr, a.znadest_gr, a.id_usr, a.motivo_trasl_gr, a.ruc_transp_gr, a.descrip_transp_gr, 
a.marca_placa_transp_gr, a.licen_conduc_transp_gr, a.montotransf_gr,
CONCAT(b.id_usr,':',b.nomb_usr) AS usuario 
FROM guia_remis a 
LEFT JOIN usuarios b ON a.id_usr=b.id_usr ";
$cond_sql="";
if (!empty($ser_num)) $cond_sql="(CONCAT(a.serie_gr,'-',a.numero_gr) LIKE '%$ser_num%') AND ";
if (!empty($fecha)) $cond_sql=$cond_sql."(fechtrasl_gr LIKE '%$fecha%') AND ";
if (!empty($origen)) $cond_sql=$cond_sql."(znaorig_gr LIKE '%$origen%') AND ";
if (!empty($destino)) $cond_sql=$cond_sql."(znadest_gr LIKE '%$destino%') AND ";
$cond_sql=substr($cond_sql,0,strlen($cond_sql)-5);
if (empty($cond_sql)) $cond_sql="1";
if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) 
{
	$sql=mysqli_query($Conexion,$cadena_guia_remision." WHERE ".$cond_sql." ORDER BY fechtrasl_gr DESC LIMIT 10");
}
else
{
	$sql=mysqli_query($Conexion,$cadena_guia_remision." WHERE ".$cond_sql." AND a.znaorig_gr='$zona_usuario'"." ORDER BY fechtrasl_gr DESC LIMIT 10");
}
tblanchovariable_05($Conexion,"margin-left:0px;","height:315px;",$sql,"tblnormal","guia_remision.php",
"ID:id_gr:50:idLink|",
"Ser-Num:serie_numero:60:N",
"Fech.Trasl.:fechtrasl_gr:80:invFech|",
"Origen:znaorig_gr:90:N",
"Destino:znadest_gr:90:N",
"Usuario:usuario:150:N",
"Motivo:motivo_trasl_gr:200:N",
"RUC Transp.:ruc_transp_gr:80:N",
"Desc.Transp.:descrip_transp_gr:200:N",
"Vehic.:marca_placa_transp_gr:150:N",
"Lic.Conduc.:licen_conduc_transp_gr:80:N"); 
?>