<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* regventas: id_rvi, id_cli, id_pro, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, numcont_rvi, numcel_rvi, codpqt_rvi, codcpg_rvi, rgpag_rvc, zona_rvi
Prepago: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcel_rvi, id_pro.icc, id_pro.imei, id_pro.codigo, id_pro.modelo, importetot_rvi, id_usr.nombre, zona_rvi, tipopla_rvi
Postpago: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcont_rvi, numcel_rvi, id_pro.icc, id_pro.imei, id_pro.codigo, id_pro.modelo, importetot_rvi, id_pla.nombre, id_pla.tiempo_contrato, id_pla.costo_plan, id_usr.nombre, id_cli.telf_contacto, id_pro.clase_cat, zona_rvi, tipopla_rvi
Servicios: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcel_rvi, id_pla.nombre_plan, importetot_rvi, id_usr.nombre, zona_rvi, tipopla_rvi */
$var_zona=$var_tvta=$var_usua=$valfecha=$fechact=$varfac="";
$fechi=$var_fchdyi=$var_fchmsi=$var_fchani="";
$fechf=$var_fchdyf=$var_fchmsf=$var_fchanf="";
//Recoge variable con datos del formulario padre para usarlo en la impresión
$consultasql=$_GET['cadconsulta'];
$zona=$_GET['vizona'];if (empty($zona)) $zona="";
$tipo=$_GET['vitip'];if (empty($tipo)) $tipo="";
$usua=$_GET['viufn'];
if (empty($usua))
{
	$usua="";
	$nmus="";
}
else
{
	$nmus=valfield($Conexion,"usuarios","nomb_usr","id_usr",$usua);
}
$fchi=$_GET['vifin'];if (empty($fchi)) $fchi="";
$fchf=$_GET['viffi'];if (empty($fchf)) $fchf="";
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresion de reporte 01");?></head>
	<body style="background-color:white; color:black;">
		<?php
		$factor=1;
		$a01=30*$factor;
		$a02=45*$factor;
		$a03=60*$factor;
		$a04=75*$factor;
		$a05=150*$factor;
		$a06=75*$factor;
		$a07=80*$factor;
		$a08=85*$factor;
		$a09=200*$factor;
		$a10=60*$factor;
		$a11=60*$factor;
		$anchtabla=912*$factor;
		$estilo_container="width:".($anchtabla+20)."px; padding:0px; margin:0px; float:center;";
		$estilo_maincol="width:".($anchtabla+10)."px; font-size:10px; padding:0px; margin:0px;";
		$estilo_tabla="table-layout:fixed; width:".$anchtabla."px;";
		?>
		<div id="container" style="<?php echo $estilo_container; ?>">
			<div id="main-col2" style="<?php echo $estilo_maincol; ?>"><?php
				// Realiza la consulta recibida de reporte01.php
				realizar_consulta($sql);
				// Inicia conteos
				$registro_x_zona=new conteo_zonas;
				conteos_y_sumas($sql,
				$cant_postpago,$cant_prepago,$cant_recargas,$cant_recarga_PDV,$cant_accesorios,$cant_servicios,$cant_otros,$cant_vtas_juego,$cant_portaprepost,$cant_portapostpost,$cant_portapre,$cant_1play,$cant_2play,$cant_3play,
				$monto_postpago,$monto_prepago,$monto_recargas,$monto_recarga_PDV,$monto_accesorios,$monto_servicios,$monto_otros,$monto_vtas_juego,$monto_portaprepost,$monto_portapostpost,$monto_portapre,$monto_1play,$monto_2play,$monto_3play,
				$monto_total_ventas,$registro_x_zona,$rz);?>
				<form name="usuario" action="" method="post">
					<center><h3>Reporte de Ventas</h3></center><hr>
					<span id="etq4">ZONA:</span><?php echo $zona;?><span id="etq4">TIPO=</span><?php echo $tipo;?><span id="etq4">USUARIO=</span><?php echo $nmus;?><span id="etq4">FechaIni:</span><?php echo $fchi;?><span id="etq4">FechaFin:</span><?php echo $fchf;?><br><hr>
					<span id="etq3">ZONA:</span><?php $registro_x_zona->mostrar_lista($rz,$registro_x_zona->lista_zona);?><br>
					<span id="etq3">TIPO DE VENTA:</span>
					<span id="etq3">Postpago=</span><?php echo pvmc($monto_postpago,$cant_postpago);?>
					<span id="etq3">Prepago=</span><?php echo pvmc($monto_prepago,$cant_prepago);?>
					<span id="etq3">Rec.Normal=</span><?php echo pvmc($monto_recargas,$cant_recargas);?>
					<span id="etq3">Rec.PDV=</span><?php echo pvmc($monto_recarga_PDV,$cant_recarga_PDV);?>
					<span id="etq3">Accesorios=</span><?php echo pvmc($monto_accesorios,$cant_accesorios);?>
					<span id="etq3">Servicios=</span><?php echo pvmc($monto_servicios,$cant_servicios);?>
					<span id="etq3">Otros=</span><?php echo pvmc($monto_otros,$cant_otros);?>
					<span id="etq3">Juego=</span><?php echo pvmc($monto_vtas_juego,$cant_vtas_juego);?>
					<span id="etq3">Porta Pre a Post=</span><?php echo pvmc($monto_portaprepost,$cant_portaprepost);?>
					<span id="etq3">Porta Post a Post=</span><?php echo pvmc($monto_portapostpost,$cant_portapostpost);?>
					<span id="etq3">Porta Pre=</span><?php echo pvmc($monto_portapre,$cant_portapre);?>
					<span id="etq3">1 Play=</span><?php echo pvmc($monto_1play,$cant_1play);?>
					<span id="etq3">2 Play=</span><?php echo pvmc($monto_2play,$cant_2play);?>
					<span id="etq3">3 Play=</span><?php echo pvmc($monto_3play,$cant_3play);?><br>
					<span id="etq3">TOTAL DE VENTAS:</span><span id="etq3"><?php echo "S/. ",$monto_total_ventas;?></span>
					<hr>	
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->	
				<div style="width:100%; overflow:auto;">
					<table border='0' cellspacing='0' cellpadding='0' style='<?php echo $estilo_tabla; ?>'>
						<col width="<?php echo $a01; ?>">
						<col width="<?php echo $a02; ?>">
						<col width="<?php echo $a03; ?>">
						<col width="<?php echo $a04; ?>">
						<col width="<?php echo $a05; ?>">
						<col width="<?php echo $a06; ?>">
						<col width="<?php echo $a07; ?>">
						<col width="<?php echo $a08; ?>">
						<col width="<?php echo $a09; ?>">
						<col width="<?php echo $a10; ?>">
						<col width="<?php echo $a11; ?>">
						<tr align="center">
						<th>ID</th>
						<th>Zona</th>
						<th>Tipo Venta</th>
						<th>Fech. Venta</th>
						<th>Cliente</th>
						<th>Nº Celular</th>
						<th>Nº Contrato</th>
						<th>Plan</th>
						<th>Producto</th>
						<th>Importe</th>
						<th>Usr.</th>
						</tr>
						<?php
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
						{
							// Prepago: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcel_rvi, id_pro.icc, id_pro.imei, id_pro.codigo, id_pro.modelo, importetot_rvi, id_usr.nombre, zona_rvi, tipopla_rvi
							// Postpago: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcont_rvi, numcel_rvi, id_pro.icc, id_pro.imei, id_pro.codigo, id_pro.modelo, importetot_rvi, id_pla.nombre, id_pla.tiempo_contrato, id_pla.costo_plan, id_usr.nombre, id_cli.telf_contacto, id_pro.clase_cat, zona_rvi, tipopla_rvi
							// Servicios: id_rvi, fechaven_rvi, id_cli.ruc, id_cli.dni, id_cli.nombres, numcel_rvi, id_pla.nombre_plan, importetot_rvi, id_usr.nombre, zona_rvi, tipopla_rvi
							// Datos para Prepago
							$id_rgv=$resul["id_rvi"];
							$fc_ven=$resul["fechaven_rvi"];
							$id_cln=$resul["id_cli"]; // + RUC/DNI + Nombres + TelefonoContacto(postpago)
							$nm_cel=$resul["numcel_rvi"];
							$id_prd=$resul["id_pro"]; // + ICC/IMEI + Codigo + Modelo + clase_cat(postpago)
							$im_tot=$resul["importetot_rvi"];
							$id_usu=$resul["id_usr"]; // + Nombre
							$zn_rgv=$resul["zona_rvi"];
							$tp_pla=$resul["tipopla_rvi"];
							// Datos para Postpago
							$nm_cnt=$resul["numcont_rvi"];
							$id_pln=$resul["id_pla"]; // + Nombre + Tiempo + Costo
							// Datos para Servicio = Prepago
						?>
							<tr valign="top">
							<!--<td style="overflow:hidden; white-space:normal; text-overflow:ellipsis;">Este es una columna especialisima</td>-->
							<td><?php echo $id_rgv; ?></td>
							<td><?php echo $zn_rgv; ?></td>
							<td><?php echo $tp_pla ?></td>
							<td><?php echo $fc_ven ?></td>
							<td style="white-space:normal;"><?php echo $id_cln.":".valfldmul($Conexion,"clientes","id_cli",$id_cln,"nom_rzs_cli","dni_ruc_cli","tlfcel_cli"); ?></td>
							<td><?php echo $nm_cel ?></td>
							<td><?php echo $nm_cnt ?></td>
							<td><?php echo $id_pln.":".valfield($Conexion,"planes","abrv_pla","id_pla",$id_pln); ?></td>
							<td style="white-space:normal;"><?php echo $id_prd.":".valfldmul($Conexion,"productos","id_pro",$id_prd,"cod_pro","abrv_pro","imei_pro","icc_pro","clase_cat"); ?></td>
							<td style="text-align:right;"><?php echo $im_tot; ?>&nbsp;&nbsp;&nbsp;</td>
							<td><?php echo $id_usu.":".valfield($Conexion,"usuarios","nomb_usr","id_usr",$id_usu); ?></td>
							</tr>
						<?php
						}
						?>
					</table>
				</div>	
			<!-- Fin de listado de datos de usuario -->
			</div>
			<div class="clr"></div>
			<div id="footer" style="<?php echo $estilo_container; ?>"><p><?php pie_pagina();?></p></div>
		</div>
	</body>
	<?php echo "<script> window.print(); alert('Se está realizando la impresión...'); </script>"; ?>
</html>
<?php
function realizar_consulta(&$sql)
{
	global $Conexion;
	global $consultasql;
	if (!empty($consultasql))
	{
		$nuevo_consulta=conversion_a_consulta($consultasql);
		$sql= mysqli_query ($Conexion,$nuevo_consulta) or die ("Error al realizar la consulta filtrada en regventas para la impresión.");
	}
	else
	{
		$varfac=date("Y-m-d");
		$sql= mysqli_query ($Conexion,"SELECT * FROM regventas WHERE fechaven_rvi='$varfac' AND estado_rvc IS NULL") or die ("Error al traer los datos de regventas para la impresión.");
	}
}
function conteos_y_sumas($sql,
	&$cant_postpago,&$cant_prepago,&$cant_recargas,&$cant_recarga_PDV,&$cant_accesorios,&$cant_servicios,&$cant_otros,&$cant_vtas_juego,&$cant_portaprepost,&$cant_portapostpost,&$cant_portapre,&$cant_1play,&$cant_2play,&$cant_3play,
	&$monto_postpago,&$monto_prepago,&$monto_recargas,&$monto_recarga_PDV,&$monto_accesorios,&$monto_servicios,&$monto_otros,&$monto_vtas_juego,&$monto_portaprepost,&$monto_portapostpost,&$monto_portapre,&$monto_1play,&$monto_2play,&$monto_3play,
	&$monto_total_ventas,$registro_x_zona,&$rz)
{
	// Declarar variables de cantidad
	$cant_postpago=$cant_prepago=$cant_recargas=$cant_recarga_PDV=$cant_accesorios=$cant_servicios=$cant_otros=$cant_vtas_juego=$cant_portaprepost=$cant_portapostpost=$cant_portapre=$cant_1play=$cant_2play=$cant_3play=0;
	// Declarar variables de montos
	$monto_postpago=$monto_prepago=$monto_recargas=$monto_recarga_PDV=$monto_accesorios=$monto_servicios=$monto_otros=$monto_vtas_juego=$monto_portaprepost=$monto_portapostpost=$monto_portapre=$monto_1play=$monto_2play=$monto_3play=0;
	$monto_total_ventas=0;
	$registro_x_zona->inicializar_lista($rz,$registro_x_zona->lista_zona);
	mysqli_data_seek($sql, 0); 
	while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
	{
		$im_tot=$resul["importetot_rvi"];
		$zn_rgv=$resul["zona_rvi"];
		$tp_pla=$resul["tipopla_rvi"];
		// Conteo por zonas
		$registro_x_zona->contar_a_lista($rz,$registro_x_zona->lista_zona,$zn_rgv,$im_tot);
		// Conteno por tipo de venta
		if ($tp_pla=="Postpago") { $cant_postpago++; $monto_postpago+=$im_tot; }
		if ($tp_pla=="Prepago") { $cant_prepago++; $monto_prepago+=$im_tot; }
		if ($tp_pla=="Rec.Normal") { $cant_recargas++; $monto_recargas+=$im_tot; }
		if ($tp_pla=="Rec.PDV") { $cant_recarga_PDV++; $monto_recarga_PDV+=$im_tot; }
		if ($tp_pla=="Accesorios") { $cant_accesorios++; $monto_accesorios+=$im_tot; }
		if ($tp_pla=="Servicios") { $cant_servicios++; $monto_servicios+=$im_tot; }
		if ($tp_pla=="Otros") { $cant_otros++; $monto_otros+=$im_tot; }
		if ($tp_pla=="Juego") { $cant_vtas_juego++; $monto_vtas_juego+=$im_tot; }
		if ($tp_pla=="PortaPrePost") { $cant_portaprepost++; $monto_portaprepost+=$im_tot; }
		if ($tp_pla=="PortaPostPost") { $cant_portapostpost++; $monto_portapostpost+=$im_tot; }
		if ($tp_pla=="PortaPre") { $cant_portapre++; $monto_portapre+=$im_tot; }
		if ($tp_pla=="1Play") { $cant_1play++; $monto_1play+=$im_tot; }
		if ($tp_pla=="2Play") { $cant_2play++; $monto_2play+=$im_tot; }
		if ($tp_pla=="3Play") { $cant_3play++; $monto_3play+=$im_tot; }
		//Suma total
		$monto_total_ventas+=$im_tot;
	}
}
function pvmc($monto,$conteo)
{ // Preparar vista monto y conteo
	return "S/ ".$monto."(".$conteo.")";
}
?>