<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$var_zona=$var_catg=$var_tdoc=$var_acti=$var_fech=$var_inv="";
$ambito_busqueda="Todo";
$cadsql="";
$where_as="";
$v_id_cat="";
//SELECT a.id_pro, a.id_cat, a.imei_pro, a.icc_pro, a.precio_pro, a.ultreg_pro, a.fechreg_pro, a.activ_pro, a.id_usr, a.zona_pro, a.tipo_cat, a.clase_cat, a.marca_cat, a.modelo_cat, b.abrv_cat FROM productos a LEFT JOIN catalogo b ON a.id_cat=b.id_cat WHERE (a.id_cat='14') ORDER BY a.tipo_cat ASC, a.clase_cat ASC, a.marca_cat ASC, a.modelo_cat ASC, a.imei_pro ASC, a.icc_pro ASC, a.fechreg_pro DESC
$consulta_productos="SELECT p.id_pro, p.id_cat, p.imei_pro, p.icc_pro, p.precio_pro, p.ultreg_pro, p.fechreg_pro, p.activ_pro, p.id_usr, p.zona_pro, p.tipo_cat, p.clase_cat, p.marca_cat, p.modelo_cat, CONCAT(p.clase_cat,' ', p.marca_cat, ' ', p.modelo_cat) AS abrv_pro, p.id_prv, p.precionormal_prv, p.precioespecial_prv, p.precio_anterior_pro, p.fecha_anterior_pro, p.id_anterior_prv, p.precio_antes_anterior_pro, p.fecha_antes_anterior_pro, p.id_antes_anterior_prv, pr.nom_rzs_prv FROM productos p LEFT JOIN proveedores pr ON p.id_prv=pr.id_prv ";
$order_by = " ORDER BY p.id_pro DESC, p.fechreg_pro ASC, p.tipo_cat ASC, p.clase_cat ASC, p.marca_cat ASC, p.modelo_cat ASC, p.imei_pro ASC, p.icc_pro ASC";
$order_by_contar = " ORDER BY id_pro DESC, fechreg_pro ASC, tipo_cat ASC, clase_cat ASC, marca_cat ASC, modelo_cat ASC, imei_pro ASC, icc_pro ASC";
inicializa_funcion_busca_datos_Ajax();
inicializa_ventana_busqueda();
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Reporte de Productos",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte 03");?></head>
	<body>
		<div>
			<?php //cabecera02("Reporte 03"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Reporte de Productos"); menu02(); sl(1);?>
				<!--<center><h1>Reporte de Productos</h1></center><hr>--><?php
				//echo $consulta_productos.$order_by." LIMIT 100"; sl(1);
				$sql_productos= mysqli_query($Conexion,$consulta_productos.$order_by." LIMIT 100") or die ("Error al traer los datos de productos para el reporte.");
				//------------------------------------------------------- BOTONES -------------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					//------------------------------------------------------- Filtrar -------------------------------------------------------
					if($btn=="Filtrar")
					{
						filtrar_datos($Conexion, $consulta_productos, $order_by, $where_as, $cadsql, $sql_productos, $ambito_busqueda, $var_zona, $var_catg, $var_tdoc, $var_acti, $var_fech, $var_inv, $v_id_cat);
					}
					//------------------------------------------------------- Imprimir -------------------------------------------------------
					if($btn=="Imprimir")
					{
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						$ncf=conversion_de_consulta($ccf);
						echo "<script> window.open('../admin/reporte03imp.php?cadconsulta=$ncf', '_blank', 'width=962, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
					}
					//------------------------------------------------------- Actualizar -------------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'reporte03.php'; </script>";
					}
					if($btn=="PDF")
					{
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						$ncf=conversion_de_consulta($ccf);
						echo "<script> window.open('../admin/reporte03pdf.php?cadconsulta=$ncf', '_blank', 'width=962, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
					}
					if($btn=="Excel")
					{
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						$ncf=conversion_de_consulta($ccf);
						echo "<script> window.open('../admin/reporte03_descargar_excel.php?cadconsulta=$ncf', '_blank'); </script>";
					}
				}
				//------------------------------------------------------- Conteos -------------------------------------------------------
				//Declarar variables para tipos y clases (grupos y tipos)
				$ct_equ=$ct_mod=$ct_chp=$ct_rec=$ct_tab=$ct_srv=$ct_acc=$ct_otr=0;//conteo de grupos
				$ct_hnd=$ct_sph=$ct_mdm=$ct_pck=$ct_smb=$ct_bsm=$ct_bfr=$ct_bcm=$ct_uni=$ct_rou=$ct_rtj=$ct_rvr=$ct_tbl=$ct_sdc=$ct_aur=$ct_crs=$ct_cst=$ct_prp=$ct_mgr=$ct_cmp=$ct_bjl=$ct_dsb=$ct_rcf=$ct_kbv=$ct_kbf=$ct_kbd=$ct_kbu=$ct_ots=0;//conteo de tipos
				// Conteos de zonas, activos, tipos y clases
				contar_cant_en_campo($Conexion, "zona_pro", "productos", $array_valor_de_zonas, $resultado_contar_zonas, $where_as, $order_by_contar);
				contar_cant_en_campo($Conexion, "activ_pro", "productos", $array_valor_de_activos, $resultado_contar_activos, $where_as, $order_by_contar);
				contar_cant_en_campo($Conexion, "tipo_cat", "productos", $array_valor_de_tipoCategoria, $resultado_contar_tipos, $where_as, $order_by_contar);
				contar_cant_en_campo($Conexion, "clase_cat", "productos", $array_valor_de_claseCategoria, $resultado_contar_clases, $where_as, $order_by_contar);
				cargar_en_variables_de_tipo_resultados_conteo($array_valor_de_tipoCategoria, $resultado_contar_tipos, 
				$ct_equ, $ct_mod, $ct_chp, $ct_rec, $ct_tab, $ct_srv, $ct_acc, $ct_otr);
				cargar_en_variables_de_clase_resultados_conteo($array_valor_de_claseCategoria, $resultado_contar_clases,
				$ct_hnd, $ct_sph, $ct_mdm, $ct_pck, $ct_smb, $ct_bsm, $ct_bfr, $ct_bcm, $ct_uni, $ct_rou, $ct_rtj, $ct_rvr, $ct_tbl, $ct_sdc, 
				$ct_aur, $ct_crs, $ct_cst, $ct_prp, $ct_mgr, $ct_cmp, $ct_bjl, $ct_dsb, $ct_rcf, $ct_kbv, $ct_kbf, $ct_kbd, $ct_kbu, $ct_ots)
				?>
				<!------------------------------------------------------- FORMULARIO -------------------------------------------------------->
				<form name="usuario" action="" method="post">
					<?php txtoculto("txtcadsql",$cadsql);?>
					<span id="etq5">Zona:</span>
					<?php 
					cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona,"","nomb_zna"); 
					?>
					<span id="etq5">Categoría:</span><?php 
					//cmbnormal("cmbcat", $var_catg, "Equipo", "Modem", "Chip", "Recarga", "Tableta", "Servicios", "Accesorios", "Otros");
					cmbfieldJs("div_select_grupo","cmbcat",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$var_catg,"","desc_tipo_prosrv");
					?>
					<span id="etq5">Tipo:</span><?php 
					//cmbnormal("cmbtip", $var_tdoc, "Handset", "Smartphone", "Modem", "PackConnect", "SIM Mobile", "BSmart", "BFree", "BCombo", "Uni","Kit BVoz","Kit BData","Kit BitelUNIV", "Kit Bfono", "Router", "Rec.Tarjeta", "Rec.Virtual", "Tablet", "SD Card", "Auricular", "CarcasaSmpl", "CarcasaTapa", "ProtectPant", "Migracion", "CambioPlan", "BajaLinea", "Desbloqueo", "Reconfigura", "Otros");
					cmbfieldJs("div_select_tipo","cmbtip",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$var_tdoc,"","desc_clase_prosrv");
					?>
					<span id="etq5">Activo(S/N):</span><?php cmbnormal("cmbact", $var_acti, "1", "0");?>
					<span id="etq5">Fecha:</span> <?php cmbfield("cmbfch", $Conexion, "SELECT DISTINCT date_format(fechreg_pro, '%d-%m-%Y') as fechreg_pro_dmY, fechreg_pro FROM productos ORDER BY fechreg_pro DESC", $var_fech, "fechreg_pro_dmY"); cmbnormal("cmbinv", $var_inv, "C")?><br>
					<span id="etq5">Catálogo:</span><?php combo_select("div_catalogo","cmbctl",$Conexion,"SELECT * FROM catalogo",$v_id_cat,"id_cat","abrv_cat","activo_cat");
					boton_busqueda("div_catalogo", "reporte03.busca_catalogo.php"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"PDF")) { btnnormal("btnGrl", "PDF"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Excel")) { btnnormal("btnGrl", "Excel"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?><br>
					<hr>
					<div style="width:20%; float:left;">
						<span id="etq1" class="color_items">ZONA:</span><br>
						<?php mostrar_resultados_conteo($array_valor_de_zonas, $resultado_contar_zonas);?><br>
						<span id="etq1" class="color_items">EXISTENCIAS:</span><br>
						<?php mostrar_resultados_conteo_activos($array_valor_de_activos, $resultado_contar_activos);?>
					</div>
					<div style="width:15%; float:left;">
						<span id="etq1" class="color_items">GRUPO:</span><br>
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
						<span id="etq5" class="color_items">TIPO:</span><br>
						<span id="etq5">Handset=</span><?php echo $ct_hnd;?>
						<span id="etq5" style="width:110px;">Smartphone=</span><?php echo $ct_sph;?><br>
						<span id="etq5">Modem=</span><?php echo $ct_mdm;?>
						<span id="etq5" style="width:90px;">Router=</span><?php echo $ct_rou;?><br>
						<span id="etq5">PackConnect=</span><?php echo $ct_pck;?>
						<span id="etq5" style="width:100px;">SIM Mobile=</span><?php echo $ct_smb;?>
						<span id="etq5" style="width:65px;">BSmart=</span><?php echo $ct_bsm;?>
						<span id="etq5" style="width:60px;">BFree=</span><?php echo $ct_bfr;?>
						<span id="etq5" style="width:70px;">BCombo=</span><?php echo $ct_bcm;?>
						<span id="etq5" style="width:45px;">Uni=</span><?php echo $ct_uni;?><br>
						<span id="etq5">Kit BVoz=</span><?php echo $ct_kbv;?>
						<span id="etq5" style="width:100px;">Kit Bfono=</span><?php echo $ct_kbf;?>
						<span id="etq5" style="width:100px;">Kit BData=</span><?php echo $ct_kbd;?>
						<span id="etq5" style="width:105px;">Kit BitelUNIV=</span><?php echo $ct_kbu;?>
						<span id="etq5" style="width:105px;">Rec.Tarjeta=</span><?php echo $ct_rtj;?>
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
				<!-------------------------------------------------- Inicio de listado de datos de usuario -------------------------------------------------->
				<?php tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql_productos,"tblnormal",$ambito_busqueda,
				"ID:id_pro:50:N",
				"Grupo:tipo_cat:60:N",
				"Tipo:clase_cat:85:N",
				"Catálogo de productos:abrv_pro:200:N",
				"Imei:imei_pro:155:N",
				"Icc:icc_pro:155:N",
				"Prec.S/.:precio_pro:70:N",
				"Fecha:fechreg_pro:80:invFech|",
				"A.:activ_pro:30:N",
				"Zona:zona_pro:70:N",
				"Prov.:nom_rzs_prv:150:N",
				"Prec.Prv.:precionormal_prv:70:N"); ?>
			<!-------------------------------------------------- Fin de listado de datos de usuario -------------------------------------------------->
			</div>
			<?php scroll_doble("div1", "div2"); ?>
			<article class="piepag"><?php pie_pagina();?></article>
		</div>
	</body>
</html>
<?php
function filtrar_datos($Conexion, $consulta_productos, $order_by, &$where_as, &$cadsql, &$sql_productos, &$ambito_busqueda,
&$var_zona, &$var_catg, &$var_tdoc, &$var_acti, &$var_fech, &$var_inv, &$v_id_cat)
{
	$zona=$_POST["cmbzna"];$var_zona=$zona;//Zona
	$catg=$_POST["cmbcat"];$var_catg=$catg;//Categoria
	$tdoc=$_POST["cmbtip"];$var_tdoc=$tdoc;//Tipo de documento
	$acti=$_POST["cmbact"];$var_acti=$acti;//Actividad
	$fech=corregir_fecha($_POST["cmbfch"]); $var_fech=invFech($fech,"-");//Fecha
	$vinv=$_POST["cmbinv"];$var_inv=$vinv;//Complemento de fecha
	$vctl=$_POST["cmbctl"];$v_id_cat=$vctl;//Id_cat
	$sql_where="";
	if (!empty($zona)) $sql_where=$sql_where."(zona_pro='$zona') AND ";
	if (!empty($catg)) $sql_where=$sql_where."(tipo_cat='$catg') AND ";
	if (!empty($tdoc)) $sql_where=$sql_where."(clase_cat='$tdoc') AND ";
	if ($acti<>"") $sql_where=$sql_where."(activ_pro='$acti') AND ";
	if (!empty($vctl)) $sql_where=$sql_where."(id_cat='$vctl') AND ";
	if (!empty($fech))
	{
		if (!empty($vinv))
		{
			$sql_where=$sql_where."!(fechreg_pro='$fech') AND ";
		}
		else
		{
			$sql_where=$sql_where."(fechreg_pro='$fech') AND ";
		}
	}
	$sql_where=trim($sql_where);
	$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
	if(!empty($sql_where))
	{
		$where_as = "WHERE ".$sql_where;
	}
	$order_by = " ORDER BY tipo_cat ASC, clase_cat ASC, marca_cat ASC, modelo_cat ASC, imei_pro ASC, icc_pro ASC, fechreg_pro DESC";
	if (!empty($sql_where))
	{
		$sql_where=$consulta_productos." WHERE ".$sql_where.$order_by;
		$cadsql=$sql_where; //Contiene la cadena de consulta finaL
		$sql_productos= mysqli_query ($Conexion,$sql_where) or die ("Error al traer los datos de productos de filtro");
		$ambito_busqueda="Todo";
	}
}
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
// function ejecuta_busca_datos_Ajax($idTagHtml_a_cargar, $dato_a_buscar, $archivo_donde_buscar_datos)
// {
	// echo "muestraDatos('$idTagHtml_a_cargar','$dato_a_buscar','$archivo_donde_buscar_datos')";
// }
// function ejecuta_ventana_busqueda($idTagHtml_a_cargar, $archivo_donde_buscar_datos)
// {
	// echo "ventana_busqueda('$idTagHtml_a_cargar', '$archivo_donde_buscar_datos')";
// }
?>