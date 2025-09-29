<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$cadena = $_POST['id'];
$datos=explode(":", $cadena);
$id_usuario=$datos[0];
$zona=$datos[1];
$tipo_registro_stock=$datos[02];
$cadena_consulta_to_where="";
//Filtrar los datos de la tabla stock_juego
if (!empty($id_usuario)) $cadena_consulta_to_where=$cadena_consulta_to_where." a.id_usr='".$id_usuario."' AND ";
if (!empty($zona)) $cadena_consulta_to_where=$cadena_consulta_to_where." a.zona_stkjg='".$zona."' AND ";
if (!empty($tipo_registro_stock)) $cadena_consulta_to_where=$cadena_consulta_to_where." a.proces_stkjg='".$tipo_registro_stock."' AND ";
$cadena_consulta_to_where=substr(trim($cadena_consulta_to_where),0,strlen($cadena_consulta_to_where)-5);
//Generar cadena de lista de datos de stock
$consulta_inicial="
SELECT a.id_stkjg, a.saldo_stkjg, a.egreso_stkjg, a.ingreso_stkjg, a.id_pro, a.id_rvc, a.fecha_stkjg, a.hora_stkjg, a.id_usr, a.min_stkjg, a.proces_stkjg, a.zona_stkjg ,
b.tipo_cat, b.clase_cat, b.abrv_pro, CONCAT(a.id_pro,':',b.tipo_cat,':',b.clase_cat,':',b.abrv_pro) AS producto, 
c.tipodoccp_rvi, c.seriecp_rvi, c.numcp_rvi, CONCAT(a.id_rvc,':',c.tipodoccp_rvi,' ',c.seriecp_rvi,'-',c.numcp_rvi) AS comprobante, 
d.nomb_usr, CONCAT(a.id_usr,':',d.nomb_usr) AS nomb_usuario 
FROM stock_juego a 
LEFT JOIN productos b ON a.id_pro=b.id_pro 
LEFT JOIN regvtacaja c ON a.id_rvc=c.id_rvc 
LEFT JOIN usuarios d ON a.id_usr=d.id_usr ";
$consulta_order_limit="
ORDER BY a.id_stkjg DESC 
LIMIT 7";
$consulta_stock_juego= mysqli_query ($Conexion,$consulta_inicial." WHERE ".$cadena_consulta_to_where.$consulta_order_limit) or die ("Error al traer los datos de stock_juego al filtrar.");
//echo $consulta_stock_juego."<br>";
tblanchovariable_05($Conexion,"margin-left:0px;","height:220px;",$consulta_stock_juego,"tblnormal","gestion_stock_juego.php",
"ID:id_stkjg:60:idLink|",
"Saldo:saldo_stkjg:70:N",
"Ingreso:ingreso_stkjg:70:N",
"Egreso:egreso_stkjg:70:N",
"Producto:producto:250:N",
"Comprobante:comprobante:150:N",
"Fecha:fecha_stkjg:80:N",
"Usuario:nomb_usuario:100:N",
"Zona:zona_stkjg:80:N",
"T.Reg.:proces_stkjg:40:N");
?>