<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//Recoge variable con datos del formulario padre para usarlo en la impresión
$consultasql=$_GET['cadconsulta'];
$where_as = $order_by = "";
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresion de reporte 03");?></head>
	<body style="background-color:white; color:black;">
		<?php
		//---------------------------------------------- Calculo de tamaño de elementos x factor ----------------------------------------------
		$factor=1;
		$anch_id_pro=45*$factor;
		$anch_tipo_cat=65*$factor;
		$anch_clase_cat=75*$factor;
		$anch_id_cat=230*$factor;
		$anch_serie_pro=105*$factor;
		$anch_imei_pro=95*$factor;
		$anch_icc_pro=120*$factor;
		$anch_precio_pro=60*$factor;
		$anch_fechreg_pro=70*$factor;
		$anch_activ_pro=35*$factor;
		$anch_zona_pro=70*$factor;
		$anch_nom_rzs_prv=110*$factor;
		$anch_precionormal_prv=60*$factor;
		$anch_precio_anterior_pro=60*$factor;
		$anch_precio_antes_anterior_pro=60*$factor;
		$anchtabla=$anch_id_pro+$anch_tipo_cat+$anch_clase_cat+$anch_id_cat+$anch_serie_pro+$anch_imei_pro+$anch_icc_pro+$anch_precio_pro+$anch_fechreg_pro+$anch_activ_pro+$anch_zona_pro+$anch_nom_rzs_prv+$anch_precionormal_prv+$anch_precio_anterior_pro+$anch_precio_antes_anterior_pro;
		$estilo_container="width:".($anchtabla+10)."px; padding:0px; margin:0px; float:center;";
		$estilo_maincol="width:".($anchtabla+10)."px; font-size:10px; padding:0px; margin:0px; font-family:Consolas;";
		$estilo_tabla="table-layout:fixed; width:".$anchtabla."px;";
		?>
		<div id="container" style="<?php echo $estilo_container; ?>">
			<div id="main-col2" style="<?php echo $estilo_maincol; ?>">
				<?php
				//---------------------------------------------- Consulta de productos con o sin filtro ----------------------------------------------
				if (!empty($consultasql))
				{
					$nuevo_consulta=conversion_a_consulta($consultasql);
					obtener_where_y_orderBy($nuevo_consulta, $where_as, $order_by);
					$sql= mysqli_query ($Conexion,$nuevo_consulta) or die ("Error al realizar la consulta filtrada");
				}
				else
				{
					$varfac=date("Y-m-d");
					$sql= mysqli_query ($Conexion,"SELECT p.*, pr.* FROM productos p LEFT JOIN proveedores pr ON p.id_prv=pr.id_prv ORDER BY p.tipo_cat ASC, p.clase_cat ASC, p.marca_cat ASC, p.modelo_cat ASC, p.imei_pro ASC, p.icc_pro ASC, p.fechreg_pro DESC LIMIT 1000") or die ("Error al traer los datos de consulta de productos");
				}
				//---------------------------------------------- Calculo de conteos ----------------------------------------------
				//conteo de zonas
				$ct_act=$ct_nac=0;//conteo de activos y no activos
				$ct_equ=$ct_mod=$ct_chp=$ct_rec=$ct_tab=$ct_srv=$ct_acc=$ct_otr=0;//conteo de grupos
				$ct_hnd=$ct_sph=$ct_mdm=$ct_pck=$ct_smb=$ct_bsm=$ct_bfr=$ct_bcm=$ct_uni=$ct_rou=$ct_rtj=$ct_rvr=$ct_tbl=$ct_sdc=$ct_aur=$ct_crs=$ct_cst=$ct_prp=$ct_mgr=$ct_cmp=$ct_bjl=$ct_dsb=$ct_rcf=$ct_ots=0;//conteo de tipos
				// Conteos de zonas, activos, tipos y clases
				contar_cant_en_campo($Conexion, "zona_pro", "productos", $array_valor_de_zonas, $resultado_contar_zonas, $where_as, $order_by);
				contar_cant_en_campo($Conexion, "activ_pro", "productos", $array_valor_de_activos, $resultado_contar_activos, $where_as, $order_by);
				contar_cant_en_campo($Conexion, "tipo_cat", "productos", $array_valor_de_tipoCategoria, $resultado_contar_tipos, $where_as, $order_by);
				contar_cant_en_campo($Conexion, "clase_cat", "productos", $array_valor_de_claseCategoria, $resultado_contar_clases, $where_as, $order_by);
				cargar_en_variables_de_tipo_resultados_conteo($array_valor_de_tipoCategoria, $resultado_contar_tipos, 
				$ct_equ, $ct_mod, $ct_chp, $ct_rec, $ct_tab, $ct_srv, $ct_acc, $ct_otr);
				cargar_en_variables_de_clase_resultados_conteo($array_valor_de_claseCategoria, $resultado_contar_clases,
				$ct_hnd, $ct_sph, $ct_mdm, $ct_pck, $ct_smb, $ct_bsm, $ct_bfr, $ct_bcm, $ct_uni, $ct_rou, $ct_rtj, $ct_rvr, $ct_tbl, $ct_sdc, 
				$ct_aur, $ct_crs, $ct_cst, $ct_prp, $ct_mgr, $ct_cmp, $ct_bjl, $ct_dsb, $ct_rcf, $ct_kbv, $ct_kbf, $ct_kbd, $ct_kbu, $ct_ots)
				?>
			<!---------------------------------------------- FORMULARIO ---------------------------------------------->
			<form name="usuario" action="" method="post">
				<center><h3>Reporte de Almacén</h3></center>
				<br>
					<hr>
					<div style="width:20%; float:left;">
					<span id="etq1">ZONA:</span><br>
					<?php mostrar_resultados_conteo($array_valor_de_zonas, $resultado_contar_zonas);?><br>
						<br>
					<span id="etq1">EXISTENCIAS:</span><br>
						<?php mostrar_resultados_conteo_activos($array_valor_de_activos, $resultado_contar_activos);?>
					</div>
					<div style="width:15%; float:left;">
					<span id="etq1">GRUPO:</span><br>
						<span id="etq4">Equipo=</span><?php echo $ct_equ;?><br>
						<span id="etq4">Modem=</span><?php echo $ct_mod;?><br>
						<span id="etq4">Chip=</span><?php echo $ct_chp;?><br>
						<span id="etq4">Recarga=</span><?php echo $ct_rec;?><br>
						<span id="etq4">Tableta=</span><?php echo $ct_tab;?><br>
						<span id="etq4">Servicios=</span><?php echo $ct_srv;?><br>
						<span id="etq4">Accesorios=</span><?php echo $ct_acc;?><br>
						<span id="etq4">Otros=</span><?php echo $ct_otr;?><br>
						<br>
					</div>
					<div style="width:65%; float:left;">
					<span id="etq5">TIPO:</span><br>
						<span id="etq5">Handset=</span><?php echo $ct_hnd;?>
						<span id="etq5" style="width:110px;">Smartphone=</span><?php echo $ct_sph;?><br>
						<span id="etq5">Modem=</span><?php echo $ct_mdm;?>
						<span id="etq5" style="width:90px;">Router=</span><?php echo $ct_rou;?><br>
						<span id="etq5">PackConnect=</span><?php echo $ct_pck;?>
						<span id="etq5" style="width:100px;">SIM Mobile=</span><?php echo $ct_smb;?>
						<span id="etq5" style="width:80px;">BSmart=</span><?php echo $ct_bsm;?>
						<span id="etq5" style="width:80px;">BFree=</span><?php echo $ct_bfr;?>
						<span id="etq5" style="width:80px;">BCombo=</span><?php echo $ct_bcm;?>
						<span id="etq5" style="width:50px;">Uni=</span><?php echo $ct_uni;?><br>
						<span id="etq5">Rec.Tarjeta=</span><?php echo $ct_rtj;?>
						<span id="etq5" style="width:100px;">Rec.Virtual=</span><?php echo $ct_rvr;?><br>
						<span id="etq5">Tablet=</span><?php echo $ct_tbl;?><br>
						<span id="etq5">Migracion=</span><?php echo $ct_mgr;?>
						<span id="etq5" style="width:105px;">CambioPlan=</span><?php echo $ct_cmp;?>
						<span id="etq5" style="width:105px;">BajaLinea=</span><?php echo $ct_bjl;?>
						<span id="etq5" style="width:120px;">Desbloqueo=</span><?php echo $ct_dsb;?>
						<span id="etq5" style="width:110px;">Reconfigur=</span><?php echo $ct_rcf;?><br>
						<span id="etq5">SD Card=</span><?php echo $ct_sdc;?>
						<span id="etq5" style="width:100px;">Auricular=</span><?php echo $ct_aur;?>
						<span id="etq5" style="width:105px;">CarcasaSmpl=</span><?php echo $ct_crs;?>
						<span id="etq5" style="width:105px;">CarcasaTapa=</span><?php echo $ct_cst;?>
						<span id="etq5" style="width:105px;">ProtectPant=</span><?php echo $ct_prp;?><br>
						<span id="etq5">Otros=</span><?php echo $ct_ots;?><br>
					</div>
					<div style="clear:both"></div>
					<hr>	
			</form>
			<!---------------------------------------------- Inicio de listado de datos de usuario ---------------------------------------------->	
			<div style="width:100%; overflow:auto;">
				<table border='0' cellspacing='0' cellpadding='0' class="tblreporte02" style='<?php echo $estilo_tabla; ?>'>
					<col width="<?php echo $anch_id_pro; ?>">
					<col width="<?php echo $anch_tipo_cat; ?>">
					<col width="<?php echo $anch_clase_cat; ?>">
					<col width="<?php echo $anch_id_cat; ?>">
					<col width="<?php echo $anch_imei_pro; ?>">
					<col width="<?php echo $anch_icc_pro; ?>">
					<col width="<?php echo $anch_precio_pro; ?>">
					<col width="<?php echo $anch_fechreg_pro; ?>">
					<col width="<?php echo $anch_activ_pro; ?>">
					<col width="<?php echo $anch_zona_pro; ?>">
					<col width="<?php echo $anch_nom_rzs_prv; ?>">
					<col width="<?php echo $anch_precionormal_prv; ?>">
					<col width="<?php echo $anch_precio_anterior_pro; ?>">
					<col width="<?php echo $anch_precio_antes_anterior_pro; ?>">
					<tr align="center">
					<th>ID</th>
					<th>Grupo</th>
					<th>Tipo</th>
					<th>Catálogo</th>
					<th>IMEI</th>
					<th>ICC</th>
					<th>Precio</th>
					<th>Fech.Reg.</th>
					<th>Act.</th>
					<th>Zona</th>
					<th>Prov.</th>
					<th>Pre.Prv.</th>
					<th>Prec.1</th>
					<th>Prec.2</th>
					</tr>
					<?php
					mysqli_data_seek($sql, 0); 
					while($r = mysqli_fetch_array($sql, MYSQLI_ASSOC))
					{
						$vi_id_pro=$r["id_pro"];
						$vi_tipo_cat=$r["tipo_cat"];
						$vi_clase_cat=$r["clase_cat"];
						$vi_abrv_cat=$r["abrv_pro"];
						$vi_imei_pro=$r["imei_pro"];
						$vi_icc_pro=$r["icc_pro"];
						$vi_precio_pro=$r["precio_pro"];
						$vi_fechreg_pro=$r["fechreg_pro"];
						$vi_activ_pro=$r["activ_pro"];
						$vi_zona_pro=$r["zona_pro"];
						$vi_nom_rzs_prv=$r["nom_rzs_prv"];
						$vi_precionormal_prv=$r["precionormal_prv"];
						$vi_precio_anterior_pro=$r["precio_anterior_pro"];
						$vi_precio_antes_anterior_pro=$r["precio_antes_anterior_pro"];
					?>
						<tr valign="top" style="padding-top: 0px; padding-bottom: 0px; height: 5px;">
						<td><?php echo $vi_id_pro; ?></td>
						<td><?php echo $vi_tipo_cat ?></td>
						<td><?php echo $vi_clase_cat ?></td>
						<td><?php echo $vi_abrv_cat ?></td>
						<td><?php echo $vi_imei_pro ?></td>
						<td><?php echo $vi_icc_pro ?></td>
						<td><?php echo $vi_precio_pro ?></td>
						<td><?php echo $vi_fechreg_pro ?></td>
						<td><?php echo $vi_activ_pro ?></td>
						<td><?php echo $vi_zona_pro ?></td>
						<td><?php echo $vi_nom_rzs_prv ?></td>
						<td><?php echo $vi_precionormal_prv ?></td>
						<td><?php echo $vi_precio_anterior_pro ?></td>
						<td><?php echo $vi_precio_antes_anterior_pro ?></td>
						</tr>
					<?php
					}
					?>
				</table>
			</div>	
			<!---------------------------------------------- Fin de listado de datos de usuario ---------------------------------------------->
			</div>
			<div class="clr"></div>
			<div id="footer" style="<?php echo $estilo_container; ?>"><p><?php pie_pagina();?></p></div>
		</div>
	</body>
	<?php //echo "<script> window.print(); alert('Se está realizando la impresión...'); </script>"; ?>
</html>
<?php
function cargar_en_variables_de_clase_resultados_conteo($array_valor_de_campos, $resultado_de_conteos,
&$ct_hnd, &$ct_sph, &$ct_mdm, &$ct_pck, &$ct_smb, &$ct_bsm, &$ct_bfr, &$ct_bcm, &$ct_uni, &$ct_rou, &$ct_rtj, &$ct_rvr, &$ct_tbl, &$ct_sdc, 
&$ct_aur, &$ct_crs, &$ct_cst, &$ct_prp, &$ct_mgr, &$ct_cmp, &$ct_bjl, &$ct_dsb, &$ct_rcf, &$ct_kbv, &$ct_kbf, &$ct_kbd, &$ct_kbu, &$ct_ots)
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		$ct_hnd=$fila["_Handset"];
		$ct_sph=$fila["_Smartphone"];
		$ct_mdm=$fila["_Modem"];
		$ct_pck=$fila["_PackConnect"];
		$ct_smb=$fila["_SIMMobile"];
		// $ct_bsm=$fila["_BSmart"];//*
		$ct_bfr=$fila["_BFree"];
		// $ct_bcm=$fila["_BCombo"];//*
		// $ct_uni=$fila["_Uni"];//*
		$ct_rou=$fila["_Router"];
		// $ct_rtj=$fila["_Rec_Tarjeta"];//*
		$ct_rvr=$fila["_Rec_Virtual"];
		$ct_tbl=$fila["_Tablet"];
		$ct_sdc=$fila["_SDCard"];
		$ct_aur=$fila["_Auricular"];
		$ct_crs=$fila["_CarcasaSmpl"];
		$ct_cst=$fila["_CarcasaTapa"];
		$ct_prp=$fila["_ProtectPant"];
		$ct_mgr=$fila["_Migracion"];
		// $ct_cmp=$fila["_CambioPlan"];//*
		$ct_bjl=$fila["_BajaLinea"];
		$ct_dsb=$fila["_Desbloqueo"];
		$ct_rcf=$fila["_Reconfigur_"];
		$ct_kbv=$fila["_KitBVoz"];
		// $ct_kbf=$fila["_KitBFono"];//*
		$ct_kbd=$fila["_KitBData"];
		$ct_kbu=$fila["_KitBitelUN"];
		$ct_ots=$fila["_Otros"];
	}
}
function cargar_en_variables_de_tipo_resultados_conteo($array_valor_de_campos, $resultado_de_conteos,
&$ct_equ, &$ct_mod, &$ct_chp, &$ct_rec, &$ct_tab, &$ct_srv, &$ct_acc, &$ct_otr) 
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		$ct_equ=$fila["_Equipo"];
		$ct_mod=$fila["_Modem"];
		$ct_chp=$fila["_Chip"];
		$ct_rec=$fila["_Recarga"];
		$ct_tab=$fila["_Tableta"];
		$ct_srv=$fila["_Servicios"];
		$ct_acc=$fila["_Accesorios"];
		$ct_otr=$fila["_Otros"];
	}
}
function obtener_where_y_orderBy($nuevo_consulta, &$where_as, &$order_by)
{
	$posicion_where = strpos($nuevo_consulta, "WHERE");
	$posicion_order = strpos($nuevo_consulta, "ORDER BY");
	if ($posicion_where === false)
	{
		$where_as="";
	} 
	else 
	{
		$where_as = " ".trim(substr($nuevo_consulta, $posicion_where, $posicion_order-$posicion_where));
	}
	if ($posicion_order === false)
	{
		$order_by="";
	} 
	else 
	{
		$order_by = " ".trim(substr($nuevo_consulta, $posicion_order, strlen($nuevo_consulta)));
	}
}
?>
