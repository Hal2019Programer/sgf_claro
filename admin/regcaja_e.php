<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ambito_busqueda="Todo";
$cadenasql=conversion_a_consulta($_GET["v1"]);
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=archivo.xls");
?>
<!DOCTYPE HTML>
<html>
	<head><?php	pestanna_01($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte de Ventas");?></head>
	<body>
		<div id="main-col2" style="padding:15px; margin-left:5px">
			<div style="font-size:10px"><?php nombre_comercial_empresa();?> : <?php echo gmdate("j F Y, g:i a",time()+3600*(-6+date("I")));?></div>
			<center><h2 style="color:#0A2C4F">Reporte de Registro de Caja</h2></center> 
			<?php
			$sql_catalogo= mysqli_query ($Conexion,$cadenasql) or die ("Error al traer los datos");
			tblanchovariable_01($Conexion,"margin-left:0px;",$sql_catalogo,$ambito_busqueda,
			"ID:id_rvc:50:N",
			"Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
			"Tipo:tipopla_rvi:100:N",
			"Plan:id_pla:100:valfield|planes|abrv_pla|id_pla",
			"Fecha:fechaemi_rvi:100:N",
			"Fecha:fechaven_rvi:100:N",
			"Cod.Comprobante:codcpg_rvi:100:N",
			"Documento:tipodoccp_rvi:100:N",
			"Serie:seriecp_rvi:50:N",
			"Numero:numcp_rvi:100:N",
			"Descripción:descrip_rvi:200:N",
			"Pago:formapago_rvi:100:N",
			"BaseImpProdGrav:baseimpopgrv_rvi:100:N",
			"BaseImpProdNoGrav:baseimpopngrv_rvi:100:N",
			"ISC:isc_rvi:100:N",
			"IGV:igv_rvi:100:N",
			"Importe:importetot_rvi:100:N",
			"Estad.Pago:rgpag_rvc:150:N",
			"Estad.Comp.:estado_rvc:150:N",
			"Usuar.Anul.:id_usr_anula:150:valfield|usuarios|nomb_usr|id_usr",
			"Causa Anul.:causanul_rvc:150:N",
			"Fech.Pag.Cred.:fechapag_rvc:100:N",
			"Usuario:id_usr:150:valfield|usuarios|nomb_usr|id_usr",
			"Zona:zona_rvi:150:N");
			scroll_doble("div1", "div2");
			?>
		</div>
	</body>
</html>