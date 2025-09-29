<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//Recoge variable con datos del formulario padre para usarlo en la impresión
$consultasql=$_GET['cadconsulta'];
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresion de Reporte de Transferencias");?></head>
	<body style="background-color:white; color:black;">
		<?php
		//---------------------------------------------- Calculo de tamaño de elementos x factor ----------------------------------------------
		$factor=1;
		$anch_id_trs=30*$factor;
		$anch_fech_trs=70*$factor;
		$anch_id_usr=80*$factor;
		$anch_id_pro=40*$factor;
		$anch_abrv_pro=230*$factor;
		$anch_sergr_trs=35*$factor;
		$anch_numgr_trs=45*$factor;
		$anch_mntrans_trs=80*$factor;
		$anch_znaorig_trs=80*$factor;
		$anch_znadest_trs=80*$factor;
		$anch_tipo_cat=80*$factor;
		$anch_clase_cat=90*$factor;
		$anchtabla = $anch_id_trs + $anch_fech_trs + $anch_id_usr + $anch_id_pro + $anch_abrv_pro + $anch_sergr_trs + $anch_numgr_trs +	$anch_znaorig_trs +	$anch_znadest_trs +	$anch_tipo_cat + $anch_clase_cat;
		$estilo_container="width:".($anchtabla+87)."px; padding:0px; margin:0px; float:center;";
		$estilo_maincol="width:".($anchtabla+87)."px; font-size:10px; padding:0px; margin:0px; font-family:Consolas;";
		$estilo_tabla="table-layout:fixed; width:".$anchtabla."px;";
		?>
		<div id="container" style="<?php echo $estilo_container; ?>">
			<div id="main-col2" style="<?php echo $estilo_maincol; ?>">
				<center><b><h1>Reporte de Transferencias</h1></b></center>
				<?php
				//---------------------------------------------- Consulta de productos con o sin filtro ----------------------------------------------
				if (!empty($consultasql))
				{
					$nuevo_consulta=conversion_a_consulta($consultasql);
					$sql= mysqli_query ($Conexion,$nuevo_consulta) or die ("Error al realizar la consulta filtrada");
				}
				else
				{
					$varfac=date("Y-m-d");
					$sql= mysqli_query ($Conexion,"SELECT * FROM transfprod ORDER BY `fech_trs` ASC, `znaorig_trs` ASC, `sergr_trs` ASC, `numgr_trs` ASC") or die ("Error al traer los datos de consulta de transferencia de productos");
				}
				?>
			<!---------------------------------------------- Inicio de listado de datos de usuario ---------------------------------------------->	
			<div style="width:100%; overflow:auto;">
				<table border='0' cellspacing='0' cellpadding='0' class="tblreporte02" style='<?php echo $estilo_tabla; ?>'>
					<col width="<?php echo $anch_id_trs; ?>">
					<col width="<?php echo $anch_fech_trs; ?>">
					<col width="<?php echo $anch_id_usr; ?>">
					<col width="<?php echo $anch_id_pro; ?>">
					<col width="<?php echo $anch_abrv_pro; ?>">
					<col width="<?php echo $anch_sergr_trs; ?>">
					<col width="<?php echo $anch_numgr_trs; ?>">
					<col width="<?php echo $anch_mntrans_trs; ?>">
					<col width="<?php echo $anch_znaorig_trs; ?>">
					<col width="<?php echo $anch_znadest_trs; ?>">
					<col width="<?php echo $anch_tipo_cat; ?>">
					<col width="<?php echo $anch_clase_cat; ?>">
					<tr align="center">
					<th>ID</th>
					<th>Fecha</th>
					<th>Usuario</th>
					<th>IDP</th>
					<th>Producto</th>
					<th>Ser.</th>
					<th>Numero</th>
					<th>Monto</th>
					<th>Zona origen</th>
					<th>Zona destino</th>
					<th>Grupo.</th>
					<th>Tipo</th>
					</tr>
					<?php
					mysqli_data_seek($sql, 0); 
					while($r = mysqli_fetch_array($sql, MYSQLI_ASSOC))
					{
						$vi_id_trs=$r["id_trs"];
						$vi_fech_trs=$r["fech_trs"];
						$vi_id_usr=$r["id_usr"];
						$vi_id_pro=$r["id_pro"];
						$vi_abrv_pro=$r["abrv_pro"];
						$vi_sergr_trs=$r["sergr_trs"];
						$vi_numgr_trs=$r["numgr_trs"];
						$vi_mntrans_trs=$r["montotransf_trs"];
						$vi_znaorig_trs=$r["znaorig_trs"];
						$vi_znadest_trs=$r["znadest_trs"];
						$vi_tipo_cat=$r["tipo_cat"];
						$vi_clase_cat=$r["clase_cat"];
					?>
						<tr valign="top">
						<td><?php echo $vi_id_trs; ?></td>
						<td><?php echo $vi_fech_trs; ?></td>
						<td><?php echo $vi_id_usr.":".valfield($Conexion,"usuarios","nomb_usr","id_usr",$vi_id_usr);?></td>
						<td><?php echo $vi_id_pro; ?></td>
						<td><?php echo $vi_abrv_pro ?></td>
						<td><?php echo $vi_sergr_trs ?></td>
						<td><?php echo $vi_numgr_trs ?></td>
						<td><?php echo $vi_mntrans_trs ?></td>
						<td><?php echo $vi_znaorig_trs ?></td>
						<td><?php echo $vi_znadest_trs ?></td>
						<td><?php echo $vi_tipo_cat ?></td>
						<td><?php echo $vi_clase_cat ?></td>
						</tr>
					<?php
					}
					?>
				</table>
			</div>	
			<!---------------------------------------------- Fin de listado de datos de usuario ---------------------------------------------->
			</div><!--Fin de main-col-->
			<div class="clr"></div>
			<div id="footer" style="<?php echo $estilo_container; ?>"><p><?php pie_pagina();?></p></div><!--Pie de página (footer)-->
		</div><!--Fin de container-->
	</body>
	<?php //echo "<script> window.print(); alert('Se está realizando la impresión...'); </script>"; ?>
</html>