<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* regvtacaja
-----------------------------------------------------------------------------------------------------------
1. id_rvc			2. id_cli			3. tipopla_rvi				4. id_pla				5. fechaemi_rvi
6. fechaven_rvi		7. codcpg_rvi		8. tipodoccp_rvi			9. seriecp_rvi			10. numcp_rvi
11. descrip_rvi		12. formapago_rvi	13. baseimpopgrv_rvi		14. baseimpopngrv_rvi	15. isc_rvi
16. igv_rvi			17. importetot_rvi	18. id_usr					19. rgpag_rvc			20. zona_rvi
21. estado_rvc		22. fechapag_rvc	23. id_usr_anula			24. causanul_rvc		25. cee_rvc     
26. causamant_rvc */
//------------------------------ Variables usadas en busqueda de comporbante ------------------------------
$v_id_rvc=$v_id_cli=$v_tipopla_rvi=$v_id_pla=$v_fechaemi_rvi=$v_fechaven_rvi=$v_codcpg_rvi=$v_tipodoccp_rvi="";
$v_seriecp_rvi=$v_numcp_rvi=$v_descrip_rvi=$v_formapago_rvi=$v_baseimpopgrv_rvi=$v_baseimpopngrv_rvi=$v_isc_rvi="";
$v_igv_rvi=$v_importetot_rvi=$v_id_usr=$v_rgpag_rvc=$v_zona_rvi=$v_estado_rvc=$v_fechapag_rvc=$v_id_usr_anula="";
$v_causanul_rvc=$v_cee_rvc=$v_causamant_rvc="";
//--------------------------------- Variables usadas en filtro de datos  ----------------------------------
$v_fechaven_act=$v_tipodocumento=$v_usuario=$v_forma_pago=$v_estado_pago=$v_condicion=$v_zona_usr=$sel_ambito_busqueda="";
//--------------------------------- Variable usada en busqueda de cliente ---------------------------------
$v_bsc=""; 
$cad_busca_cliente="";
//--------------------------------- Otras variables usada en el modulo -- ---------------------------------
$limitar_cliente1=" ORDER BY id_cli DESC LIMIT 0,5";
$ambito_busqueda="Normal"; 
$consulta_inicial = 
"SELECT 
regvtacaja.id_rvc, regvtacaja.id_cli, regvtacaja.tipopla_rvi, regvtacaja.id_pla, regvtacaja.fechaemi_rvi,
regvtacaja.fechaven_rvi, regvtacaja.codcpg_rvi, regvtacaja.tipodoccp_rvi, regvtacaja.seriecp_rvi, regvtacaja.numcp_rvi,
regvtacaja.descrip_rvi, regvtacaja.formapago_rvi, regvtacaja.baseimpopgrv_rvi, regvtacaja.baseimpopngrv_rvi, regvtacaja.isc_rvi,
regvtacaja.igv_rvi, regvtacaja.importetot_rvi, regvtacaja.id_usr, regvtacaja.rgpag_rvc, regvtacaja.zona_rvi, 
regvtacaja.estado_rvc, regvtacaja.fechapag_rvc, regvtacaja.id_usr_anula, regvtacaja.causanul_rvc, regvtacaja.cee_rvc,
regvtacaja.causamant_rvc,
clientes.nom_rzs_cli, 
clientes.dni_ruc_cli, 
CONCAT(regvtacaja.id_cli,':',clientes.nom_rzs_cli) AS clie,
clientes.nom_rzs_cli AS nombre_cliente, 
clientes.dni_ruc_cli AS dniruc_cliente,
CONCAT(regvtacaja.id_pla,':',planes.abrv_pla) AS plan 
FROM regvtacaja 
LEFT JOIN clientes ON regvtacaja.id_cli=clientes.id_cli 
LEFT JOIN planes ON regvtacaja.id_pla=planes.id_pla
WHERE 1";
$orden=" ORDER BY regvtacaja.numcp_rvi DESC LIMIT 10";
$v_cliente=$v_usuario_anula="";
$clave_id_rvi=0; $clave_id_rvi_notfound=0;
$v_busqueda=0;
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Mantenimiento de comprobantes",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Mantenimiento de comprobantes de pago");?></head>
	<body>
		<div>
			<?php //cabecera02("Anular comprobantes de pago"); menu02();?>
			<div style="width:1310px;"><hr>
				<?php cabecera04(0,"Mantenimiento de Comprobantes"); menu02(); sl(1);?>
				<!--<center><h1>Mantenimiento de Comprobantes</h1></center><hr>-->
				<?php
				// Inicio de busqueda de registros en base de datos regvtacaja
				if ($zona_usuario=="Total") { 
					//Se considera consulta_normal cuando se incluye la condicion de anulado
					$consulta_normal=$consulta_inicial.$orden;
					$sql_regvtacaja= mysqli_query ($Conexion,$consulta_normal) or die ("Error al traer los datos de regvtacaja");
				}
				else { 
					$consulta_normal=$consulta_inicial." AND (zona_rvi='$zona_usuario')".$orden;
					$sql_regvtacaja= mysqli_query ($Conexion,$consulta_normal) or die ("Error al traer los datos regvtacaja"); 
				}
				$tabla=array(array()); obtener_matriz($sql_regvtacaja,$tabla,$filas); // Obtener_matriz traslada los datos de la consulta $sql_regvtacja a la matriz $tabla y obtiene la cantidad de $filas
				date_default_timezone_set("America/Lima");
				if (empty($v_fechaven_act)) $v_fechaven_act=date("d-m-Y"); // Carga en la variable $v_fechaven_rvi la fecha actual con formato d-m-y
				if(isset($_POST["btnGrl"])) // isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,	Eliminar) esta definido o tiene valor NULL
				{
					// Si btnGrl tiene datos almacena en $btn el nombre del boton y en $bus el valor de Buscar ID  para las siguientes acciones
					$btn=$_POST["btnGrl"];
					$bus=$_POST["txtbus"];
					// Obtiene los datos de Buscar ID y lo coloca en las cajas de texto
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							//------------------------------------------ Búsqueda de datos en regvtacaja ------------------------------------------
							$sql_regvtacaja=mysqli_query($Conexion,$consulta_inicial." AND id_rvc=$bus") or die ("Error al traer los datos de regvtacaja");
							if(mysqli_num_rows($sql_regvtacaja)>0)
							{
								$rs=mysqli_fetch_array($sql_regvtacaja, MYSQLI_ASSOC);
								datos_regvtacaja($rs, $v_id_rvc, $v_id_cli, $v_fechaemi_rvi, $v_fechaven_rvi, $v_codcpg_rvi, $v_tipodoccp_rvi, $v_seriecp_rvi, $v_numcp_rvi, $v_descrip_rvi, $v_formapago_rvi, $v_rgpag_rvc, $v_baseimpopgrv_rvi, $v_baseimpopngrv_rvi, $v_isc_rvi, $v_igv_rvi, $v_importetot_rvi, $v_estado_rvc, $v_id_usr, $v_zona_rvi, $v_fechapag_rvc, $v_id_usr_anula, $v_causanul_rvc, $v_cee_rvc, $v_causamant_rvc);
								$v_cliente=valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$v_id_cli);
								$v_fechaemi_rvi=invFech($v_fechaemi_rvi,"-"); $v_fechaven_rvi=invFech($v_fechaven_rvi,"-");
								$v_usuario=valfield($Conexion,"usuarios","nomb_usr","id_usr",$v_id_usr); 
								$v_id_usr_anula=$ident_usuario; $v_usuario_anula=valfield($Conexion,"usuarios","nomb_usr","id_usr",$v_id_usr_anula);
								$cad_busca_cliente=" WHERE id_cli= $v_id_cli"; 	$limitar_cliente1="";
								mysqli_data_seek($sql_regvtacaja, 0);
								//------------------------------------------ Búsqueda de datos en regventas ------------------------------------------
								$sql_regventas=mysqli_query($Conexion,"SELECT * FROM regventas WHERE codcpg_rvi='$v_codcpg_rvi' AND zona_rvi='$v_zona_rvi' AND seriecp_rvi='$v_seriecp_rvi' AND numcp_rvi='$v_numcp_rvi'") or die ("Error al traer los datos de regventas");
								if (mysqli_num_rows($sql_regventas)>0)
								{
									//$dat_id_rvi y $dat_id_pro almacenan en una lista los datos de los registros de ventas y de los productos asociados al comprobante de pago (B.V. o Fact.)
									$dat_id_rvi=array(); $dat_id_pro=array(); $contador_dat_id_rvi=0;
									alm_array_regventas($sql_regventas, $contador_dat_id_rvi, $dat_id_rvi, $dat_id_pro);
									$clave_id_rvi=1;
									mysqli_data_seek($sql_regventas, 0);
								}
								else
								{
									$clave_id_rvi_notfound=1;
									echo "<script> alert('No se encuentran detalles de venta asociados al comprobante de pago.'); </script>";
								}
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'mantcomp.php'; </script>";
						}
						$v_busqueda=1;
					}
					if($btn=="Filtrar")
					{
						$cliente=$_POST["txtcli"]; $cliente=trim($cliente);
						$fechaini=$_POST["txtfchini"]; $fechaini=trim($fechaini); if ($fechaini<>"") $fechaini=invFech($fechaini,"-");
						$fechafin=$_POST["txtfchfin"]; $fechafin=trim($fechafin); if ($fechafin<>"") $fechafin=invFech($fechafin,"-");
						$documento=$_POST["cmbdoc"];
						$serienumero=$_POST["txtsnm"]; $serienumero=trim($serienumero);
						$codigopago=$_POST["txtcpg"];
						$usuario=$_POST["cmbusrini"];
						$tipo_pago=$_POST["cmbtpg"];
						$estado_pago=$_POST["cmbepg"];
						$estado_reg=$_POST["cmbstd"];
						$zona_cp=$_POST["cmbzna"];
						$amb_busq=$_POST["cmbclt"]; $sel_ambito_busqueda=$amb_busq;
						if (!empty($serienumero))
						{ 
							$divsernum=explode("-", $serienumero); 
							$serie=$divsernum[0]; 
							$numero=$divsernum[1]; 
						}
						else
						{ 
							$serie=$numero=""; 
						}
						$cad_busca_cualquiera="";
						if (empty($cliente) AND empty($fechaini) AND empty($fechafin) AND empty($codigopago) AND empty($documento) AND empty($serienumero) AND empty($usuario) AND empty($tipo_pago) AND empty($estado_pago) AND empty($estado_reg) AND empty($zona_cp))
						{
							//$cad_busca_cualquiera=" 1";
							if ($zona_usuario=="Total") { 
								$consulta_filtro=$consulta_inicial.$orden; }
							else { 
								$consulta_filtro=$consulta_inicial." AND (zona_rvi='$zona_usuario')".$orden; }
						}
						else
						{
							if ($cliente<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." ((clientes.nom_rzs_cli LIKE '%$cliente%') OR (clientes.dni_ruc_cli LIKE '%$cliente%')) AND";
							}
							if ($fechaini<>"" OR $fechafin<>"")
							{
								$var_fecha_ini_fin=comp_y_gener_fechas("fechaven_rvi",$fechaini,$fechafin); 
								//$var_fecha_ini_fin=substr($var_fecha_ini_fin,0,strlen($var_fecha_ini_fin)-1);
								$cad_busca_cualquiera=$cad_busca_cualquiera." ".$var_fecha_ini_fin; 
							}
							if (!empty($codigopago))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.codcpg_rvi='$codigopago') AND"; 
							}
							if (!empty($documento))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.tipodoccp_rvi='$documento') AND"; 
							}
							if (!empty($serie) AND !empty($numero))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.seriecp_rvi=$serie AND (regvtacaja.numcp_rvi LIKE '%$numero%')) AND";
							}
							if (!empty($usuario))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.id_usr=$usuario) AND";
							}
							if (!empty($tipo_pago))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.formapago_rvi='$tipo_pago') AND";
							}
							if (!empty($estado_reg))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.estado_rvc='$estado_reg') AND";
							}
							if (!empty($estado_pago))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.rgpag_rvc='$estado_pago') AND";
							}
							if (!empty($zona_cp))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.zona_rvi='$zona_cp') AND";
							}
							$cad_busca_cualquiera=substr($cad_busca_cualquiera,1,strlen($cad_busca_cualquiera)-4);
							$consulta_filtro=$consulta_inicial." AND ".$cad_busca_cualquiera;
						}
						if ($amb_busq=="Todo")
						{
							$ambito_busqueda="Todo";
						}
						else
						{
							$ambito_busqueda="Normal";
						}
						if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente sin zona!"); }
						else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente con zona!"); }
					}
					if($btn=="Buscar Cliente")
					{
						busca_cliente($cad_busca_cliente, $limitar_cliente1);
					}
					if($btn=="Agregar")
					{
						agrega_regvtacaja($Conexion);
					}
					if($btn=="Modificar")
					{
						modifica_regvtacaja($Conexion);
					}					
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'mantcomp.php'; </script>";
					}
				}
				?>
				<form name="anularcp" action="" method="post"><!-- Inicio de formulario -->
				<!-- Inicio de cuadros de texto para busqueda o filtro de datos -->
					<?php 
						lblnorm("Buscar ID:","etq14"); txtnrmstl("txtbus","width:50px;");
						if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); lblspace(2); }
						//-------------------------------------------------------------- Datos para el filtro --------------------------------------------------------------------------
						lblnorm("Dato cliente:","etq14"); txtnrmstl("txtcli","width:100px;");lblspace(2);
						lblnorm("Fecha Ini.:","etq14"); txtvalstl("txtfchini",$v_fechaven_act,10,"width:72px;"); clr_boton("txtfchini"); lblspace(2);
						lblnorm("Fecha Fin.:","etq14"); txtvalstl("txtfchfin",$v_fechaven_act,10,"width:72px;"); clr_boton("txtfchfin"); lblspace(2);
						lblnorm("Docum:","etq14"); cmbfield("cmbdoc", $Conexion, "SELECT DISTINCT tipodoccp_rvi FROM regvtacaja", $v_tipodocumento, "tipodoccp_rvi"); lblspace(2);
						lblnorm("Serie-numero:","etq14"); txtnrmstl("txtsnm","width:60px;"); echo "<br>";
						lblnorm("Código Pago:","etq14"); txtnrmstl("txtcpg","width:50px;"); lblspace(2);
						lblnorm("Usuario:","etq14"); cmbfield("cmbusrini", $Conexion, "SELECT * FROM usuarios WHERE ((categ_usr='Vend') OR (categ_usr='Caja') OR (categ_usr='Almc') OR (categ_usr='Supr') OR (categ_usr='Gern'))", $v_usuario, "id_usr","nomb_usr"); lblspace(2);
						lblnorm("Forma pago:","etq14"); cmbnormal("cmbtpg", $v_forma_pago, "Contado"); lblspace(2);
						lblnorm("Estado pago:","etq14"); cmbnormal("cmbepg", $v_estado_pago, "Pagado", "NoPago"); lblspace(2);
						lblnorm("Condición:","etq14"); cmbnormal("cmbstd", $v_condicion, "anulado"); lblspace(2);
						lblnorm("Zona:","etq14"); 
						cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$v_zona_usr,"","nomb_zna"); sl(1);
						lblnorm("Cant.Lista:","etq14"); cmbnormal("cmbclt", $sel_ambito_busqueda, "Todo", "Normal"); lblspace(3);
						if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
					?>
					<br><hr>
					<!----------------------- Mostrar datos existentes desde registro / Cambiar datos para modificar / Añadir datos para nuevo registro  ------------------------------>
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
					<div>
						<?php 
						echo "<b>DATOS DE COMPROBANTE:</b>"; lblspace(15); 
						lblnorm("Id:","etq14"); txtronstl("txt_id_rvc",$v_id_rvc,"width:40px;"); lblspace(3); 
						lblnorm("Fecha emisión:","etq14"); txtvalstl("txt_v_fechaemi_rvi",$v_fechaemi_rvi,10,"width:70px;"); lblspace(3);
						lblnorm("Fecha venta:","etq14"); txtvalstl("txt_v_fechaven_rvi",$v_fechaven_rvi,10,"width:70px;"); lblspace(3);
						lblnorm("Cód.Pago:","etq14"); txtronstl("txt_v_codcpg_rvi", $v_codcpg_rvi, "width:70px;");
						lblnorm("Documento:","etq4"); cmbfield("cmb_v_tipodoccp_rvi", $Conexion, "SELECT DISTINCT tipodoccp_rvi FROM regvtacaja", $v_tipodoccp_rvi, "tipodoccp_rvi");
						txtvalstl("txt_v_seriecp_rvi", $v_seriecp_rvi, 1, "width:15px;"); echo "-";
						txtvalstl("txt_v_numcp_rvi", $v_numcp_rvi, 5, "width:50px;"); echo "<br><hr>";
						lblnorm("Buscar Cliente:","etq14"); txtvalstl("txtbsc",$v_bsc,13,"width:100px;"); 
						if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Cliente")) { btnnormal("btnGrl", "Buscar Cliente"); lblspace(3); }
						lblnorm("Cliente:","etq14"); cmbfield("cmb_v_id_cli", $Conexion, "SELECT * FROM clientes".$cad_busca_cliente.$limitar_cliente1, $v_id_cli, "id_cli", "nom_rzs_cli", "dni_ruc_cli", "direcc_cli", "lugar_cli"); echo "<br>";
						?>
					</div><hr>
					<div>
						<div id="colizq2" style="float:left; width:33%;">
							<?php 
							lblnorm("Descripción:","etq2"); txtvalstl("txt_v_descrip_rvi", $v_descrip_rvi, 30, "width:220px;"); echo "<br>";
							lblnorm("Forma pago:","etq2"); cmbnormal("cmb_v_formapago_rvi", $v_formapago_rvi, "Contado"); echo "<br>";
							lblnorm("Estado pago:","etq2"); cmbnormal("cmb_v_rgpag_rvc", $v_rgpag_rvc, "Pagado", "NoPago"); echo "<br>";
							lblnorm("Usuario:","etq2"); cmbfield("cmb_v_id_usr", $Conexion, "SELECT * FROM usuarios WHERE ((categ_usr='Vend') OR (categ_usr='Caja') OR (categ_usr='Almc') OR (categ_usr='Supr') OR (categ_usr='Gern'))", $v_id_usr, "id_usr","nomb_usr"); echo "<br>";
							if ($v_busqueda==1)
							{
								lblnorm("Zona:","etq2"); txtronstl("cmb_v_zona_rvi", $v_zona_rvi, "width:100px;");
							}
							else
							{
								lblnorm("Zona:","etq2"); 
								//cmbnormal("cmb_v_zona_rvi", $v_zona_rvi, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29"); 
								cmbfieldJs_span("spn_zona","cmb_v_zona_rvi",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$v_zona_rvi,"","nomb_zna");
								echo "<br>";
							}
							?>
						</div>
						<div id="colcen2" style="float:left; width:33%;">
							<?php
							lblnorm("BIPG:","etq2"); txtvalstl("txt_v_baseimpopgrv_rvi", $v_baseimpopgrv_rvi, 10, "width:60px;"); echo "<br>";
							lblnorm("BIPNG:","etq2"); txtvalstl("txt_v_baseimpopngrv_rvi", $v_baseimpopngrv_rvi, 10, "width:60px;"); echo "<br>";
							lblnorm("ISC:","etq2"); txtvalstl("txt_v_isc_rvi", $v_isc_rvi, 10, "width:60px;"); echo "<br>";
							lblnorm("IGV:","etq2"); txtvalstl("txt_v_igv_rvi", $v_igv_rvi, 10, "width:60px;"); echo "<br>";
							lblnorm("Importe Total:","etq2"); txtvalstl("txt_v_importetot_rvi", $v_importetot_rvi, 10, "width:60px;");
							?>
						</div>
						<div id="colder2" style="float:left; width:33%;">
							<?php
							lblnorm("Condición:","etq2"); cmbnormal("cmb_v_estado_rvc", $v_estado_rvc, "anulado"); echo "<br>";
							lblnorm("Usuario Anulad.:","etq2"); txtronstl("txt_v_id_usr_anula", $v_id_usr_anula.":".$v_usuario_anula, "width:130px;"); echo "<br>";
							lblnorm("Causa Anulac.:","etq2"); txtronstl("txt_v_causanul_rvc", $v_causanul_rvc, "width:100px;"); echo "<br>";
							lblnorm("Causa Manten.:","etq2"); cmbnormal("cmb_v_causamant_rvc", $v_causamant_rvc, "modif.n>siguiente", "modif.n<_o_dup.sig.", "añad.regist.elimin.", "añad.comprb.fallid.", "otros.cambios");
							?>
						</div>
					</div>
					<div style="clear:both"></div>
					<hr>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?> <input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?> <input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
					<br><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario en una tabla ajustada a la medida de los datos -->
				<?php
				if($clave_id_rvi==1)
				{
					//Lista de datos de registro de ventas cuando se encuentran asociados a los datos de registro de caja
					echo "<b>DETALLES DEL COMPROBANTE</b><br>";
					tblanchovariable($Conexion,"margin-left:0px;","height:325px;",$sql_regventas,"tblnormal","Todo","ID:id_rvi:50:N","Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli","Productos:id_pro:260:valfield|productos|abrv_pro|id_pro","Fech.Vta.:fechaven_rvi:80:N","Cód.Cpg.:codcpg_rvi:55:N","Docum.:tipodoccp_rvi:95:N","Serie:seriecp_rvi:35:N","Número:numcp_rvi:60:N","Importe S/.:importetot_rvi:75:N","Descripción:descrip_rvi:200:N","Zona:zona_rvi:80:N","Usuario:id_usr:100:valfield|usuarios|nomb_usr|id_usr");
				}
				else
				{
					if ($clave_id_rvi_notfound==1)
					{
						echo "NO HAY REGISTRO DE DETALLE ASOCIADOS AL COMPROBANTE.<BR>";
					}
					else
					{
						//Lista de los ultimos 10 datos de registro de caja
						echo "<b>ULTIMOS 10 REGISTROS DE COMPROBANTES</b><br>";
						tblanchovariable_02($Conexion,"margin-left:0px;","height:325px;",$sql_regvtacaja,"tblnormal",$ambito_busqueda,"ID:id_rvc:50:N","Cliente:clie:260:N","Fech.Vta.:fechaven_rvi:80:N","Cód.Cpg.:codcpg_rvi:55:N","TipoPago:formapago_rvi:65:N","Estad.Pago:rgpag_rvc:70:N","Fch.Pag.:fechapag_rvc:80:N","Docum.:tipodoccp_rvi:105:N","Serie:seriecp_rvi:40:N","Número:numcp_rvi:60:N","Descripción:descrip_rvi:200:N","Importe S/.:importetot_rvi:80:N","Tip.Vta.:tipopla_rvi:80:N","Plan:id_pla:170:valfield|planes|abrv_pla|id_pla","Zona:zona_rvi:80:N","Estado:estado_rvc:60:N","Usuario:id_usr:100:valfield|usuarios|nomb_usr|id_usr","Usr.Anula:id_usr_anula:100:valfield|usuarios|nomb_usr|id_usr","Causa.Anulac.:causanul_rvc:80:N");
					}					
				}
				scroll_doble("div1","div2"); // Usado para mover en simultaneo la cabecera y los datos de la lista de la tabla
				?>
				<!-- Fin de listado de datos de usuario -->
			</div><!--Fin de main-col-->
			<div class="clr"></div>
			<div class="piepag"><?php pie_pagina();?></div>
		</div><!--Fin de container-->
	</body>
</html>
<script language=JavaScript>
	function clear_textbox(objeto)
	{
		objeto.value = "";
	}
</script>
<?php
function clr_boton($nombreboton)
/* Genera un botón para limpiar un control cuadro de texto con nombre $nombreboton */
{ ?>
	<input type="button" name=boton1 onclick=clear_textbox(this.form.<?php echo $nombreboton;?>) value="X" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/>	
<?php
}
function datos_regvtacaja($rs, &$d1, &$d2, &$d3, &$d4, &$d5, &$d6, &$d7, &$d8, &$d9, &$d10, &$d11, &$d12, &$d13, &$d14, &$d15, &$d16, &$d17, &$d18, &$d19, &$d20, &$d21, &$d22, &$d23, &$d24)
/* Obtiene todos los datos del registro de regvtacaja*/
{
	$d1=$rs["id_rvc"];
	$d2=$rs["id_cli"];
	$d3=$rs["fechaemi_rvi"];
	$d4=$rs["fechaven_rvi"];
	$d5=$rs["codcpg_rvi"];
	$d6=$rs["tipodoccp_rvi"];
	$d7=$rs["seriecp_rvi"];
	$d8=$rs["numcp_rvi"];
	$d9=$rs["descrip_rvi"];
	$d10=$rs["formapago_rvi"];
	$d11=$rs["rgpag_rvc"];
	$d12=$rs["baseimpopgrv_rvi"];
	$d13=$rs["baseimpopngrv_rvi"];
	$d14=$rs["isc_rvi"];
	$d15=$rs["igv_rvi"];
	$d16=$rs["importetot_rvi"];
	$d17=$rs["estado_rvc"];
	$d18=$rs["id_usr"];
	$d19=$rs["zona_rvi"];
	$d20=$rs["fechapag_rvc"];
	$d21=$rs["id_usr_anula"];
	$d22=$rs["causanul_rvc"];
	$d23=$rs["cee_rvc"];
	$d24=$rs["causamant_rvc"];
}
function alm_array_regventas($consulta, &$contador, &$array_id_rvi, &$array_id_pro)
/* Obtiene todos los datos del registro de regvtacaja*/
{
	while($datos=mysqli_fetch_array($consulta, MYSQLI_ASSOC))
	{
		$contador++;
		$array_id_rvi[$contador]=$datos["id_rvi"];
		$array_id_pro[$contador]=$datos["id_pro"];
	}
}
function lblspace($espacios)
/* Genera espacios forzados en blanco según la cantidad indicada en $espacios */
{ ?>
	<span> <?php for ($x=1; $x<=$espacios; $x++) echo "&nbsp;"; ?> </span>
<?php
}
function busca_cliente(&$consulta_busca_cliente, &$lista_limite_cliente)
/* Genera cadena sql para buscar clientes por nombres o DNI */
{
	$busca=$_POST["txtbsc"];
	if ($busca<>"")
	{
		$consulta_busca_cliente=" WHERE (nom_rzs_cli LIKE '%$busca%') OR (dni_ruc_cli LIKE '%$busca%')";
		$lista_limite_cliente="";
	}
	else
	{
		$consulta_busca_cliente="";
		$lista_limite_cliente=" ORDER BY id_cli DESC LIMIT 0,5";
	}	
}
function modifica_regvtacaja($conex)
/* Carga datos para modificar un registro existente */
{
	$vm_id_rvc=$_POST["txt_id_rvc"];
	$vm_fechaemi_rvi=$_POST["txt_v_fechaemi_rvi"]; $vm_fechaemi_rvi=invFech($vm_fechaemi_rvi,"-");
	$vm_fechaven_rvi=$_POST["txt_v_fechaven_rvi"]; $vm_fechaven_rvi=invFech($vm_fechaven_rvi,"-");
	$vm_codcpg_rvi=$_POST["txt_v_codcpg_rvi"];
	$vm_tipodoccp_rvi=$_POST["cmb_v_tipodoccp_rvi"];
	$vm_seriecp_rvi=$_POST["txt_v_seriecp_rvi"];
	$vm_numcp_rvi=$_POST["txt_v_numcp_rvi"];
	$vm_id_cli=$_POST["cmb_v_id_cli"];
	$vm_descrip_rvi=$_POST["txt_v_descrip_rvi"];
	$vm_formapago_rvi=$_POST["cmb_v_formapago_rvi"];
	$v_rgpag_rvc=$_POST["cmb_v_rgpag_rvc"];
	$vm_id_usr=$_POST["cmb_v_id_usr"];
	$vm_zona_rvi=$_POST["cmb_v_zona_rvi"];
	$vm_baseimpopgrv_rvi=$_POST["txt_v_baseimpopgrv_rvi"];
	$vm_baseimpopngrv_rvi=$_POST["txt_v_baseimpopngrv_rvi"];
	$vm_isc_rvi=$_POST["txt_v_isc_rvi"];
	$vm_igv_rvi=$_POST["txt_v_igv_rvi"];
	$vm_importetot_rvi=$_POST["txt_v_importetot_rvi"];
	$vm_estado_rvc=$_POST["cmb_v_estado_rvc"];
	$vm_id_usr_anula=$_POST["txt_v_id_usr_anula"]; $viua=explode(":", $vm_id_usr_anula); $vm_id_usr_anula=$viua[0];
	$vm_causanul_rvc=$_POST["txt_v_causanul_rvc"];
	$vm_causamant_rvc=$_POST["cmb_v_causamant_rvc"];
	/*------------------------------------------------ Modificación de registros de tabla de regvtacaja ------------------------------------------------
	Campos que se pueden cambiar:
	fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, id_cli, 
	descrip_rvi, formapago_rvi, rgpag_rvc, id_usr, zona_rvi, baseimpopgrv_rvi
	baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, estado_rvc, causamant_rvc
	*/
	updatesql($conex,"UPDATE regvtacaja SET 
	fechaemi_rvi='$vm_fechaemi_rvi',
	fechaven_rvi='$vm_fechaven_rvi',
	codcpg_rvi='$vm_codcpg_rvi',
	tipodoccp_rvi='$vm_tipodoccp_rvi',
	seriecp_rvi='$vm_seriecp_rvi',
	numcp_rvi='$vm_numcp_rvi',
	id_cli='$vm_id_cli',
	descrip_rvi='$vm_descrip_rvi',
	formapago_rvi='$vm_formapago_rvi',
	rgpag_rvc='$v_rgpag_rvc',
	id_usr='$vm_id_usr',
	baseimpopgrv_rvi='$vm_baseimpopgrv_rvi',
	baseimpopngrv_rvi='$vm_baseimpopngrv_rvi',
	isc_rvi='$vm_isc_rvi',
	igv_rvi='$vm_igv_rvi',
	importetot_rvi='$vm_importetot_rvi',
	estado_rvc='$vm_estado_rvc',
	id_usr_anula='$vm_id_usr_anula',
	causanul_rvc='$vm_causanul_rvc',
	causamant_rvc='$vm_causamant_rvc'
	WHERE id_rvc=$vm_id_rvc","Error al modificar el registro regvtacaja para los comprobantes.");
	//------------------------------------------------ Modificación de registros de tabla de ventas asociados a regvtacaja ------------------------------------------------
	updatesql($conex,"UPDATE regventas SET 
	fechaemi_rvi='$vm_fechaemi_rvi',
	fechaven_rvi='$vm_fechaven_rvi',
	tipodoccp_rvi='$vm_tipodoccp_rvi',
	seriecp_rvi='$vm_seriecp_rvi',
	numcp_rvi='$vm_numcp_rvi',
	id_cli='$vm_id_cli',
	descrip_rvi='$vm_descrip_rvi',
	formapago_rvi='$vm_formapago_rvi',
	rgpag_rvc='$v_rgpag_rvc',
	id_usr='$vm_id_usr',
	estado_rvc='$vm_estado_rvc' 
	WHERE codcpg_rvi='$vm_codcpg_rvi' AND zona_rvi='$vm_zona_rvi'","Error al modificar el registro regventas para los comprobantes.");
	if ($vm_estado_rvc="anulado")
	{
		activa_productos($conex,$vm_codcpg_rvi,$vm_zona_rvi);
	}
	//---------------------------------------------------------------------------------------------------------------------------------------------------------------------
	echo "<script> alert('Se ha modificado el registro.'); location.href = 'mantcomp.php'; </script>";
}
function agrega_regvtacaja($conex)
/* Carga datos para agregar un registro a regvtacaja */
{
	$vm_id_rvc=$_POST["txt_id_rvc"];
	$vm_fechaemi_rvi=$_POST["txt_v_fechaemi_rvi"]; $vm_fechaemi_rvi=invFech($vm_fechaemi_rvi,"-");
	$vm_fechaven_rvi=$_POST["txt_v_fechaven_rvi"]; $vm_fechaven_rvi=invFech($vm_fechaven_rvi,"-");
	$vm_codcpg_rvi=$_POST["txt_v_codcpg_rvi"];
	$vm_tipodoccp_rvi=$_POST["cmb_v_tipodoccp_rvi"];
	$vm_seriecp_rvi=$_POST["txt_v_seriecp_rvi"];
	$vm_numcp_rvi=$_POST["txt_v_numcp_rvi"];
	$vm_id_cli=$_POST["cmb_v_id_cli"];
	$vm_descrip_rvi=$_POST["txt_v_descrip_rvi"];
	$vm_formapago_rvi=$_POST["cmb_v_formapago_rvi"];
	$v_rgpag_rvc=$_POST["cmb_v_rgpag_rvc"];
	$vm_id_usr=$_POST["cmb_v_id_usr"];
	$vm_zona_rvi=$_POST["cmb_v_zona_rvi"];
	$vm_baseimpopgrv_rvi=$_POST["txt_v_baseimpopgrv_rvi"];
	$vm_baseimpopngrv_rvi=$_POST["txt_v_baseimpopngrv_rvi"];
	$vm_isc_rvi=$_POST["txt_v_isc_rvi"];
	$vm_igv_rvi=$_POST["txt_v_igv_rvi"];
	$vm_importetot_rvi=$_POST["txt_v_importetot_rvi"];
	$vm_estado_rvc=$_POST["cmb_v_estado_rvc"];
	$vm_id_usr_anula=$_POST["txt_v_id_usr_anula"]; $viua=explode(":", $vm_id_usr_anula); $vm_id_usr_anula=$viua[0];
	$vm_causanul_rvc=$_POST["txt_v_causanul_rvc"];
	$vm_causamant_rvc=$_POST["cmb_v_causamant_rvc"];
	insertarsql($conex,"Error al insertar registro nuevo en regvtacaja.","regvtacaja",
	"fechaemi_rvi",$vm_fechaemi_rvi,
	"fechaven_rvi",$vm_fechaven_rvi,
	"codcpg_rvi",$vm_codcpg_rvi,
	"tipodoccp_rvi",$vm_tipodoccp_rvi,
	"seriecp_rvi",$vm_seriecp_rvi,
	"numcp_rvi",$vm_numcp_rvi,
	"id_cli",$vm_id_cli,
	"descrip_rvi",$vm_descrip_rvi,
	"formapago_rvi",$vm_formapago_rvi,
	"rgpag_rvc",$v_rgpag_rvc,
	"id_usr",$vm_id_usr,
	"zona_rvi",$vm_zona_rvi,
	"baseimpopgrv_rvi",$vm_baseimpopgrv_rvi,
	"baseimpopngrv_rvi",$vm_baseimpopngrv_rvi,
	"isc_rvi",$vm_isc_rvi,
	"igv_rvi",$vm_igv_rvi,
	"importetot_rvi",$vm_importetot_rvi,
	"estado_rvc",$vm_estado_rvc,
	"id_usr_anula",$vm_id_usr_anula,
	"causanul_rvc",$vm_causanul_rvc,
	"causamant_rvc",$vm_causamant_rvc);
	echo "<script> alert('Se ha añadido un registro nuevo.'); location.href = 'mantcomp.php'; </script>";	
}
function activa_productos($Conexion,$codcpg_rvi,$zona_rvi)
{
	$cadena_regventas="SELECT a.id_rvi, a.id_pro, b.tipo_cat FROM regventas a LEFT JOIN productos b ON a.id_pro=b.id_pro WHERE a.codcpg_rvi='$codcpg_rvi' AND a.zona_rvi='$zona_rvi'";
	$consulta_regventas=mysqli_query($Conexion,$cadena_regventas) or die ("Error al consultar regventas cuando se anula para activar productos.");
	$filas_consulta_regventas=mysqli_num_rows($consulta_regventas);
	if ($filas_consulta_regventas>0)
	{
		while($datos=mysqli_fetch_array($consulta_regventas,MYSQLI_ASSOC))
		{
			$id_pro=$datos["id_pro"];
			$tipo_producto=$datos["tipo_cat"];
			if ($tipo_producto<>"Servicios" AND $tipo_producto<>"Recarga")
			{
				mysqli_query($Conexion,"UPDATE productos SET activ_pro='1' WHERE id_pro=$id_pro") or die("Error al actualizar datos de productos de inactivo a activo.");
			}
		}
	}
	else
	{
		echo "<script> alert('No se encuentran registros de ventas asociados al registro de ventas en caja. Se procederá solo a anular el registro en caja.'); </script>";
	}
}
?>