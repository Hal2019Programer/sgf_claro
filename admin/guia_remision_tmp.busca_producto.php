<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
obtener_serie_y_numero($Conexion,$serie,$numero,$ident_usuario);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$id_producto = $_POST['id'];
//Busca id_pro repetido en guia_remis_detalle_tmp
$busca_id_pro_guia_remis_detalle_tmp=mysqli_query($Conexion,"SELECT id_pro FROM guia_remis_detalle_tmp WHERE id_pro='$id_producto'");
if (mysqli_num_rows($busca_id_pro_guia_remis_detalle_tmp)==0)
{
	//Realiza las operaciones con dato anterior
	$insertar_registro=mysqli_query($Conexion,"INSERT INTO guia_remis_detalle_tmp (id_pro, cant_pro_gr, id_usr, serie_gr, numero_gr) SELECT id_pro, '1', '$ident_usuario', '$serie', '$numero' FROM productos WHERE id_pro=".$id_producto);
}
$sql_guia_remis_detalle_tmp=
"SELECT a.id_gr_tmp, a.serie_gr, a.numero_gr, a.fechtrasl_gr, a.znaorig_gr, a.znadest_gr, 
a.id_usr, 
a.motivo_trasl_gr, a.ruc_transp_gr, a.descrip_transp_gr, a.marca_placa_transp_gr, a.licen_conduc_transp_gr, 
a.id_pro, a.cant_pro_gr, 
zna_o.serie_zna AS serie_zna_o, zna_o.nomb_zna AS nomb_zna_o, zna_o.direc_zna AS direc_zna_o, 
zna_d.nomb_zna AS nomb_zna_d, zna_d.direc_zna AS direc_zna_d, 
c.nomb_usr, c.apel_usr, c.dni_usr, 
d.abrv_pro, d.tipo_cat AS unidad, d.clase_cat AS modelo, d.serie_pro, d.imei_pro, d.icc_pro 
FROM guia_remis_detalle_tmp a 
LEFT JOIN zona zna_o ON a.znaorig_gr=zna_o.id_zna 
LEFT JOIN zona zna_d ON a.znadest_gr=zna_d.id_zna 
LEFT JOIN usuarios c ON a.id_usr=c.id_usr 
LEFT JOIN productos d ON a.id_pro=d.id_pro";
$consulta_guia_remis_detalle_tmp=mysqli_query($Conexion,$sql_guia_remis_detalle_tmp);
//Devuelve el resultado mediante la presentación de datos, por ejemplo 'echos' de PHP
tblanchovariable($Conexion,"margin-left:0px;","height:250px;",$consulta_guia_remis_detalle_tmp,"tblnormal","All",
"ID:id_pro:60:N",
"Descripcion:abrv_pro:300:N",
"Serie:serie_pro:140:N",
"IMEI:imei_pro:140:N",
"ICC:icc_pro:140:N",
"Cant.:cant_pro_gr:40:N",
"Unidad:unidad:60:N",
"Modelo:modelo:100:N");
function obtener_serie_y_numero($Conexion,&$serie,&$numero,$ident_usuario)
{
	$resultados=mysqli_query($Conexion,"SELECT * FROM guia_remis_serie_numero_tmp WHERE id_usr='$ident_usuario'");
	if (mysqli_num_rows($resultados))
	{
		$rs=mysqli_fetch_array($resultados,MYSQLI_ASSOC);
		$serie=$rs["serie_gr"];
		$numero=$rs["numero_gr"];
	}
}
?>