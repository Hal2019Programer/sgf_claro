<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ambito_busqueda="Todo";
$fecha_importada=conversion_a_consulta($_GET["v1"]);
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=archivo_validez.xls");
?>
<!DOCTYPE HTML>
<html>
	<head><?php	pestanna_01($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte de Ventas");?></head>
	<body>
		<div id="main-col2" style="padding:15px; margin-left:5px">
			<div style="font-size:10px"><?php nombre_comercial_empresa();?> : <?php echo gmdate("j F Y, g:i a",time()+3600*(-6+date("I")));?></div>
			<center><h2 style="color:#0A2C4F">Lista de comprobantes para validacion en SUNAT</h2></center> 
			<?php
			$consulta_exportar="SELECT a.id_rvc, CONCAT(
							'20602109225','|', 
							b.cod_tipcmp,'|',
							CONCAT(IF (b.cod_tipcmp='01','F',IF(b.cod_tipcmp='03','B','X')),RIGHT(CONCAT('000',a.seriecp_rvi),3)),'|',
							a.numcp_rvi,'|',
							date_format(a.fechaemi_rvi, '%d/%m/%Y'),'|',
							a.importetot_rvi) AS datConsul
							FROM regvtacaja a 
							LEFT JOIN tipocomprob b ON a.id_tipcmp=b.id_tipcmp";
			if (empty($fecha_importada)) 
			{ 
				mensaje("No hay datos que mostrar ya no se tiene la fecha de consulta");
			}
			else
			{
				$cadenasql=$consulta_exportar." WHERE ". $fecha_importada;
				$sql_catalogo= mysqli_query ($Conexion,$cadenasql) or die ("Error al traer los datos");
				tblanchovariable_sunat($Conexion,"margin-left:0px;",$sql_catalogo,$ambito_busqueda,
				"ID:id_rvc:50:N",
				"datConsul:datConsul:300:N");
			}
			?>
		</div>
	</body>
</html>