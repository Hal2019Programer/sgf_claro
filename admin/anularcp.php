<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$Conexion->autocommit(FALSE);
$v_id_rvc=$v_id_cli=$v_tipopla_rvi=$v_id_pla=$v_fechaemi_rvi=$v_fechaven_rvi=$v_codcpg_rvi=$v_tipodoccp_rvi="";
$v_seriecp_rvi=$v_numcp_rvi=$v_descrip_rvi=$v_formapago_rvi=$v_baseimpopgrv_rvi=$v_baseimpopngrv_rvi=$v_isc_rvi="";
$v_igv_rvi=$v_importetot_rvi=$v_id_usr=$v_rgpag_rvc=$v_zona_rvi=$v_estado_rvc=$v_fechapag_rvc=$v_id_usr_anula=$v_causanul_rvc="";
$ambito_busqueda="Normal";
$consulta_inicial = 
"SELECT regvtacaja.id_rvc, regvtacaja.id_cli, regvtacaja.tipopla_rvi, regvtacaja.id_pla, regvtacaja.fechaemi_rvi,
regvtacaja.fechaven_rvi, regvtacaja.codcpg_rvi, regvtacaja.tipodoccp_rvi, regvtacaja.seriecp_rvi, regvtacaja.numcp_rvi,
regvtacaja.descrip_rvi, regvtacaja.formapago_rvi, regvtacaja.baseimpopgrv_rvi, regvtacaja.baseimpopngrv_rvi, regvtacaja.isc_rvi,
regvtacaja.igv_rvi, regvtacaja.importetot_rvi, regvtacaja.id_usr, regvtacaja.rgpag_rvc, regvtacaja.zona_rvi, regvtacaja.estado_rvc,
regvtacaja.fechapag_rvc, regvtacaja.id_usr_anula, regvtacaja.causanul_rvc, regvtacaja.cee_rvc, regvtacaja.codigocdr_rvc, 
regvtacaja.mensajecdr_rvc, clientes.nom_rzs_cli, clientes.dni_ruc_cli, 
CONCAT(regvtacaja.id_cli,':',clientes.nom_rzs_cli) AS clie, clientes.nom_rzs_cli AS nombre_cliente, clientes.dni_ruc_cli AS dniruc_cliente,
CONCAT(regvtacaja.id_pla,':',planes.abrv_pla) AS plan 
FROM regvtacaja 
LEFT JOIN clientes ON regvtacaja.id_cli=clientes.id_cli 
LEFT JOIN planes ON regvtacaja.id_pla=planes.id_pla
WHERE 1";
$consulta_busqueda="";
$v_cliente=$v_usuario=$v_usuario_anula="";
$clave_id_rvi=0; $clave_id_rvi_notfound=0;
$var_usua_ini=$var_usua_anl=$var_std=$var_canl="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos_perfil = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Anular Comprobantes",$resultado_perfil_accesos,$datos_perfil,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Anular comprobantes de pago");?></head>
	<body>
		<div>
			<?php //cabecera02("Anular comprobantes de pago"); menu02();?>
			<div style="width:1310px;"><hr>
				<?php cabecera04(0,"Comprobantes Anulados"); menu02(); sl(1);?>
				<!--<center><h1>Comprobantes anulados</h1></center><hr>-->
				<?php
				// Inicio de busqueda de registros en base de datos regvtacaja
				if ($zona_usuario=="Total") { 
					//Se considera consulta_normal cuando se incluye la condicion de anulado
					$consulta_normal=$consulta_inicial." AND regvtacaja.estado_rvc='anulado'"." ORDER BY regvtacaja.id_rvc DESC LIMIT 10";
					$sql_regvtacaja= mysqli_query ($Conexion,$consulta_normal) or die ("a.-Error al traer los datos de regvtacaja");
				}
				else { 
					$consulta_normal=$consulta_inicial." AND (zona_rvi='$zona_usuario' AND regvtacaja.estado_rvc='anulado')"." ORDER BY regvtacaja.id_rvc DESC LIMIT 10";
					$sql_regvtacaja= mysqli_query ($Conexion,$consulta_normal) or die ("Error al traer los datos regvtacaja"); 
				}
				$tabla=array(array()); obtener_matriz($sql_regvtacaja,$tabla,$filas); // Obtener_matriz traslada los datos de la consulta $sql_regvtacja a la matriz $tabla y obtiene la cantidad de $filas
				date_default_timezone_set("America/Lima");
				if (empty($v_fechaven_rvi)) $v_fechaven_rvi=date("d-m-Y"); // Carga en la variable $v_fechaven_rvi la fecha actual con formato d-m-y
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
							$sql_regvtacaja= mysqli_query ($Conexion,$consulta_inicial." AND id_rvc=$bus") or die ("b.-Error al traer los datos de regvtacaja");
							$filas=mysqli_num_rows($sql_regvtacaja);
							if($filas>0)
							{
								$rs=mysqli_fetch_array($sql_regvtacaja, MYSQLI_ASSOC);
								$v_id_rvc=$rs["id_rvc"];
								$v_id_cli=$rs["id_cli"];$v_cliente=valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$v_id_cli);
								$v_fechaemi_rvi=$rs["fechaemi_rvi"];$v_fechaemi_rvi=invFech($v_fechaemi_rvi,"-");
								$v_fechaven_rvi=$rs["fechaven_rvi"];$v_fechaven_rvi=invFech($v_fechaven_rvi,"-");
								$v_codcpg_rvi=$rs["codcpg_rvi"];
								$v_tipodoccp_rvi=$rs["tipodoccp_rvi"];
								$v_seriecp_rvi=$rs["seriecp_rvi"];
								$v_numcp_rvi=$rs["numcp_rvi"];
								$v_descrip_rvi=$rs["descrip_rvi"];
								$v_formapago_rvi=$rs["formapago_rvi"];
								$v_rgpag_rvc=$rs["rgpag_rvc"];
								$v_baseimpopgrv_rvi=$rs["baseimpopgrv_rvi"];
								$v_baseimpopngrv_rvi=$rs["baseimpopngrv_rvi"];
								$v_isc_rvi=$rs["isc_rvi"];
								$v_igv_rvi=$rs["igv_rvi"];
								$v_importetot_rvi=$rs["importetot_rvi"];
								$v_estado_rvc=$rs["estado_rvc"];
								$v_id_usr=$rs["id_usr"];$v_usuario=valfield($Conexion,"usuarios","nomb_usr","id_usr",$v_id_usr);
								$v_zona_rvi=$rs["zona_rvi"];
								$v_id_usr_anula=$rs["id_usr_anula"];$v_usuario_anula=valfield($Conexion,"usuarios","nomb_usr","id_usr",$v_id_usr_anula);
								$v_causanul_rvc=$rs["causanul_rvc"];
								mysqli_data_seek($sql_regvtacaja, 0);
								// Búsqueda de datos en regventas 
								// ---------------------------------
								$sql_regventas=mysqli_query($Conexion,"SELECT * FROM regventas WHERE codcpg_rvi='$v_codcpg_rvi' AND zona_rvi='$v_zona_rvi' AND seriecp_rvi='$v_seriecp_rvi' AND numcp_rvi='$v_numcp_rvi'") or die ("c.-Error al traer los datos de regvtacaja");
								//La variable $filas_sql_regventas se usa para saber si existen registros de ventas luego del filtro
								$filas_sql_regventas=mysqli_num_rows($sql_regventas);
								if ($v_estado_rvc=="anulado")
								{
									echo "<script> alert('Este registro ya está anulado!'); </script>";
								}
								if ($filas_sql_regventas>0)
								{
									//$dat_id_rvi y $dat_id_pro almacenan en una lista los datos de los registros de ventas y de los productos asociados al comprobante de pago (B.V. o Fact.)
									$dat_id_rvi=array(); $dat_id_pro=array(); $contador_dat_id_rvi=0;
									while($datos=mysqli_fetch_array($sql_regventas, MYSQLI_ASSOC))
									{
										$contador_dat_id_rvi++;
										$dat_id_rvi[$contador_dat_id_rvi]=$datos["id_rvi"];
										$dat_id_pro[$contador_dat_id_rvi]=$datos["id_pro"];
									}
									$clave_id_rvi=1;
									mysqli_data_seek($sql_regventas, 0);
								}
								else
								{
									$clave_id_rvi_notfound=1;
									echo "<script> alert('No se encuentran registros de ventas asociados al registro de ventas en caja'); </script>";
								}
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'anularcp.php'; </script>";
						}
					}
					if($btn=="Filtrar")
					{
						$cliente=$_POST["txtcli"]; $cliente=trim($cliente);
						$fechaini=$_POST["txtfchini"]; $fechaini=trim($fechaini); if ($fechaini<>"") $fechaini=invFech($fechaini,"-");
						$fechafin=$_POST["txtfchfin"]; $fechafin=trim($fechafin); if ($fechafin<>"") $fechafin=invFech($fechafin,"-");
						$documento=$_POST["txtdoc"]; $documento=trim($documento);
						$serienumero=$_POST["txtsnm"]; $serienumero=trim($serienumero);
						$usuario_inicial=$_POST["cmbusrini"];
						$usuario_anulac=$_POST["cmbusranl"];
						$estado_reg=$_POST["cmbstd"];
						$causa_anulac=$_POST["cmbcanl"];
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
						if (empty($cliente) AND empty($fechaini) AND empty($fechafin) AND empty($documento) AND empty($serienumero) AND empty($usuario_inicial) AND empty($usuario_anulac) AND empty($estado_reg) AND empty($causa_anulac))
						{
							//$cad_busca_cualquiera=" 1";
							if ($zona_usuario=="Total") { 
								$consulta_filtro=$consulta_inicial." AND regvtacaja.estado_rvc='anulado'"." ORDER BY regvtacaja.id_rvc DESC LIMIT 10"; }
							else { 
								$consulta_filtro=$consulta_inicial." AND (zona_rvi='$zona_usuario' AND regvtacaja.estado_rvc='anulado')"." ORDER BY regvtacaja.id_rvc DESC LIMIT 10"; }
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
								//$cad_busca_cualquiera=$cad_busca_cualquiera." ((regvtacaja.fechaemi_rvi LIKE '%$fechaini%') OR (regvtacaja.fechaven_rvi LIKE '%$fechaini%')) AND"; 
								$cad_busca_cualquiera=$cad_busca_cualquiera." ".$var_fecha_ini_fin; 
							}
							if ($documento<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.tipodoccp_rvi LIKE '%$documento%') AND"; 
							}
							if (!empty($serie) AND !empty($numero))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.seriecp_rvi=$serie AND (regvtacaja.numcp_rvi LIKE '%$numero%')) AND";
							}
							if (!empty($usuario_inicial))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.id_usr LIKE '%$usuario_inicial%') AND";
							}
							if (!empty($usuario_anulac))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.id_usr_anula LIKE '%$usuario_anulac%') AND";
							}
							if ($estado_reg<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.estado_rvc LIKE '%$estado_reg%') AND";
							}
							if ($causa_anulac<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.causanul_rvc LIKE '%$causa_anulac%') AND";
							}
							$cad_busca_cualquiera=substr($cad_busca_cualquiera,1,strlen($cad_busca_cualquiera)-4);
							$consulta_filtro=$consulta_inicial." AND ".$cad_busca_cualquiera;
						}
						$ambito_busqueda="Todo";
						if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente sin zona!"); }
						else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente con zona!"); }
					}
					if($btn=="Anular")
					{
						$var_anular_id_rvc=$_POST["txt_id_rvc"];
						$var_causanul_rvc=$_POST["cmb_causanul_rvc"];
						if (!empty($var_anular_id_rvc))
						{
							$sql_regvtacaja= mysqli_query ($Conexion,$consulta_inicial." AND id_rvc=$var_anular_id_rvc") or die ("d.-Error al traer los datos de regvtacaja");
							$rs=mysqli_fetch_array($sql_regvtacaja, MYSQLI_ASSOC);
							$var_id_rvc=$rs["id_rvc"];
							$var_estado_rvc=$rs["estado_rvc"];
							$var_codcpg_rvi=$rs["codcpg_rvi"];
							$var_zona_rvi=$rs["zona_rvi"];
							$var_seriecp_rvi=$rs["seriecp_rvi"];
							$var_numcp_rvi=$rs["numcp_rvi"];
							//MODIFICADO 12-06-2019
							$var_cee_rvc=$rs["cee_rvc"];
							$var_codigocdr_rvc=$rs["codigocdr_rvc"];
							$var_mensajecdr_rvc=$rs["mensajecdr_rvc"];
							//vard($var_cee_rvc,"error de cee_rvc");
							//vard($var_codigocdr_rvc,"error de codigocdr_rvc");
							//---------------------
							if ($var_estado_rvc=="anulado")
							{
								echo "<script> alert('Este registro ya está anulado, no se puede volver a anular!'); location.href = 'anularcp.php'; </script>";
							}
							else
							{
								if (!empty($var_causanul_rvc))
								{
									$sql_regventas=mysqli_query($Conexion,"SELECT * FROM regventas WHERE codcpg_rvi='$var_codcpg_rvi' AND zona_rvi='$var_zona_rvi' AND seriecp_rvi='$var_seriecp_rvi' AND numcp_rvi='$var_numcp_rvi' AND estado_rvc IS NULL") or die (sprintf("e.-Error al traer los datos de regvtacaja: %s", "SELECT * FROM regventas WHERE codcpg_rvi='$var_codcpg_rvi' AND zona_rvi='$var_zona_rvi' AND seriecp_rvi='$var_seriecp_rvi' AND numcp_rvi='$var_numcp_rvi' AND estado_rvc IS NULL"));
									$filas_sql_regventas=mysqli_num_rows($sql_regventas);
									if ($filas_sql_regventas>0)
									{
										$dat_id_rvi=array();
										$dat_id_pro=array();
										$contador_dat_id_rvi=0;
										while($datos=mysqli_fetch_array($sql_regventas, MYSQLI_ASSOC))
										{
											$contador_dat_id_rvi++;
											$dat_id_rvi[$contador_dat_id_rvi]=$datos["id_rvi"];
											$dat_id_pro[$contador_dat_id_rvi]=$datos["id_pro"];
										}
										//Inicio de operaciones de actualización en registros de productos (de 0(inactivo) a 1(activo)
										//--------------------------------------------------------------------------------------------
										$cantidad = count($dat_id_pro);
										for ($i=1; $i<=$cantidad; $i++)
										{
											$tipo_producto=valfield($Conexion, "productos", "tipo_cat", "id_pro", $dat_id_pro[$i]);
											if ($tipo_producto<>"Servicios" AND $tipo_producto<>"Recarga")
											{
												$sql_update_productos="UPDATE productos SET activ_pro='1' WHERE id_pro=$dat_id_pro[$i]";
												mysqli_query($Conexion, $sql_update_productos) or die("Error al actualizar datos de productos de inactivo a activo");	
											}
											else
											{
												//echo "<script> alert('Este registro de productos es un Servicio o una Recarga, no se va a modificar.'); location.href = 'anularcp.php'; </script>";
												echo "<script> alert('Este registro de productos es un Servicio o una Recarga, no se va a modificar.'); </script>";
											}
										}
										/*Inicio de operaciones de actualización y modificación en registros de kardex
										------------------------------------------------------------------------------
										No se hizo porque hay modificaciones pendientes para verificar el funcionamiento del kardex
										------------------------------------------------------------------------------*/
										
										//Inicio de operaciones de eliminación en registro de ventas
										//------------------------------------------------------------
										$cantidad = count($dat_id_rvi);
										for ($i=1; $i<=$cantidad; $i++)
										{
											//$sql_delete_regventas="DELETE FROM regventas WHERE id_rvi=$dat_id_rvi[$i]";
											$sql_delete_regventas="UPDATE regventas SET estado_rvc='anulado' WHERE id_rvi=$dat_id_rvi[$i]";
											mysqli_query($Conexion, $sql_delete_regventas) or die("Error al eliminar registros asociados de registro de ventas con registro de caja");
										}
									}
									else
									{
										echo "<script> alert('No se encuentran registros de ventas asociados al registro de ventas en caja. Se procederá solo a anular el registro en caja.'); </script>";
									}
									//Inicio de operaciones de actualización en registro de caja
									//----------------------------------------------------------
									//Enviar la nota de credito a la sunat
									if ($var_cee_rvc==1 AND $var_codigocdr_rvc==0)
									{
									    $id_ncred=(isset($_POST['cmbcodnotcred']))?$_POST['cmbcodnotcred']:NULL;
									    $desc_ncred=(isset($_POST['txtdescnc']) && !empty($_POST['txtdescnc']))?$_POST['txtdescnc']:NULL;
									    require_once './nota_credito.php';
									    $res_notacredito=sendXMLNotaCredito($var_id_rvc, $id_ncred, $desc_ncred);
									    if($res_notacredito['success'])
									    {
										    $sql_update_regvtacaja=sprintf("UPDATE regvtacaja SET estado_rvc='anulado', id_usr_anula='$ident_usuario', causanul_rvc='$var_causanul_rvc', id_ncred=$id_ncred, desc_ncred='$desc_ncred', codcdr_ncred=%d, mensjcdr_ncred='%s', numcorr_ncred=%d WHERE id_rvc=$var_id_rvc", $res_notacredito['codigo_cdr'], $res_notacredito['respuesta_cdr'], $res_notacredito['num_corr']);
										    mysqli_query($Conexion, $sql_update_regvtacaja) or die("Error al actualizar datos del registro de caja para el usuario y las causas de anulación");
										    $Conexion->commit();
										    echo "<script> alert('El registro de caja fue anulado!. Por favor verifique este cambio antes de continuar con los siguientes procesos.'); location.href = 'anularcp.php'; </script>";
										    //echo "<script> alert('El registro de caja fue anulado!. Por favor verifique este cambio antes de continuar con los siguientes procesos.'); </script>";
									    }
									    else
									    {
										    //echo "<script> alert('El registro de caja NO fue ANULADO!. Por favor verifique el comprobante.'); location.href = 'anularcp.php'; </script>";
										    echo "<script> alert('El registro de caja NO fue ANULADO!. Por favor verifique el comprobante.'); </script>";
									    }
									}
									else
									{
										echo "<script> alert('El registro de caja NO fue ANULADO!. No existe un comprobante enviado y aceptado correctamente por SUNAT. Verifique antes de volver a anular.'); location.href = 'anularcp.php'; </script>";
									}
								}
								else
								{
									echo "<script> alert('Este registro no se puede anular! Falta indicar la causa de anulación.'); location.href = 'anularcp.php'; </script>";
								}
							}
						}
						else
						{
							echo "<script> alert('No se ha indicado un id de registro de caja para anular!'); location.href = 'anularcp.php'; </script>";
						}
					}
					if($btn=="Imprimir")
					{
						$id_rvc=$_POST["txt_id_rvc"];
						if (!empty($id_rvc))
						{
							echo "<script> window.open('../admin/regvtacaja_imp_nc.php?id=$id_rvc', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						}
						else
						{
							echo "<script> alert('No se ha cargado datos de comprobante eliminado para imprimir la Nota de Credito.'); location.href = 'anularcp.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'anularcp.php'; </script>";
					}
				}
				?>
				<form name="anularcp" action="" method="post"><!-- Inicio de formulario -->
				<!-- Inicio de cuadros de texto para busqueda o filtro de datos -->
					<?php 
						lblnorm("Buscar ID:","etq4"); txtnrmstl("txtbus","width:50px;"); 
						if (activar_boton($datos_perfil,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); }
						if (activar_boton($datos_perfil,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); echo "<br>"; }
						lblnorm("Buscar cliente:","etq14"); txtnrmstl("txtcli","width:140px;");
						lblnorm("Fecha Ini.:","etq2"); txtvalstl("txtfchini",$v_fechaven_rvi,10,"width:135px;");
						lblnorm("Fecha Fin.:","etq2"); txtvalstl("txtfchfin",$v_fechaven_rvi,10,"width:90px;");
						lblnorm("Docum.:","etq2"); txtnrmstl("txtdoc","width:110px;");
						lblnorm("Serie-numero:","etq2"); txtnrmstl("txtsnm","width:80px;"); echo "<br>";
						lblnorm("Usuario Inicial:","etq14"); cmbfield("cmbusrini", $Conexion, "SELECT * FROM usuarios WHERE ((categ_usr='Vend') OR (categ_usr='Caja') OR (categ_usr='Almc') OR (categ_usr='Supr') OR (categ_usr='Gern')) AND (activ_usr='1')", $var_usua_ini, "id_usr","nomb_usr");
						lblnorm("Usuario Anulac.:","etq3"); cmbfield("cmbusranl", $Conexion, "SELECT * FROM usuarios WHERE ((categ_usr='Caja') OR (categ_usr='Supr') OR (categ_usr='Gern')) AND (activ_usr='1')", $var_usua_anl, "id_usr","nomb_usr");
						lblnorm("Estado:","etq2"); cmbnormal("cmbstd", $var_std, "anulado","width:60px;");
						lblnorm("Causa Anul.:","etq2"); cmbnormal("cmbcanl", $var_canl, "Impresion", "Devolucion", "Errordigitacion");
						if (activar_boton($datos_perfil,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
					?>
					<br><hr>
					<!-- Presentación de datos encontrados luego de la busqueda o filtro de datos -->
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
					<div>
						<?php echo "<b>REGISTRO DE CAJA</b><br><hr>"; ?>
						<?php lblnorm("ID:","etq14"); txtronstl("txt_id_rvc",$v_id_rvc,"width:40px;");?>
						<?php lblnorm("Cliente:","etq14"); txtronstl("txt_v_id_cli",$v_id_cli.":".$v_cliente,"width:220px;");?>
						<?php lblnorm("Fecha emisión:","etq14"); txtronstl("txt_v_fechaemi_rvi",$v_fechaemi_rvi,"width:85px;");?>
						<?php lblnorm("Fecha venta:","etq14"); txtronstl("txt_v_fechaven_rvi",$v_fechaven_rvi,"width:85px;");?>
						<?php lblnorm("Cód.Pago:","etq14"); txtronstl("txt_v_codcpg_rvi", $v_codcpg_rvi, "width:70px;");?>
					</div><hr>
					<div>
					<div id="colizq2" style="float:left; width:30%">
						<div>
							<?php lblnorm("Documento:","etq4"); txtronstl("txt_v_tipodoccp_rvi", $v_tipodoccp_rvi, "width:110px;");?>
							<?php txtronstl("txt_v_seriecp_rvi", $v_seriecp_rvi, "width:15px;"); echo "-";?>
							<?php txtronstl("txt_v_numcp_rvi", $v_numcp_rvi, "width:50px;");?>
						</div>
						<div><?php lblnorm("Descripción:","etq4"); txtronstl("txt_v_descrip_rvi", $v_descrip_rvi, "width:220px;");?></div>
						<div><?php lblnorm("Forma pago:","etq4"); txtronstl("txt_v_formapago_rvi", $v_formapago_rvi, "width:60px;");?></div>
						<div><?php lblnorm("Estado pago:","etq4"); txtronstl("txt_v_estado_rvc", $v_estado_rvc, "width:60px;");?></div>
					</div>
					<div id="colcen2" style="float:left; width:30%">
						<div><?php lblnorm("BIPG:","etq2"); txtronstl("txt_v_baseimpopgrv_rvi", $v_baseimpopgrv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("BIPNG:","etq2"); txtronstl("txt_v_baseimpopngrv_rvi", $v_baseimpopngrv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("ISC:","etq2"); txtronstl("txt_v_isc_rvi", $v_isc_rvi, "width:60px;");?></div>
						<div><?php lblnorm("IGV:","etq2"); txtronstl("txt_v_igv_rvi", $v_igv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("Importe Total:","etq2"); txtronstl("txt_v_importetot_rvi", $v_importetot_rvi, "width:60px;");?></div>
					</div>
					<div id="colder2" style="float:left; width:30%">
						<div><?php lblnorm("Estado:","etq2"); txtronstl("txt_v_estado_rvc", $v_estado_rvc, "width:60px;");?></div>
						<div><?php lblnorm("Usuario Inicial:","etq2"); txtronstl("txt_v_id_usr", $v_id_usr.":".$v_usuario, "width:130px;");?></div>
						<div><?php lblnorm("Zona:","etq2"); txtronstl("txt_v_zona_rvi", $v_zona_rvi, "width:70px;");?></div>
						<div><?php lblnorm("Usuario Anulad.:","etq2"); txtronstl("txt_v_id_usr_anula", $v_id_usr_anula.":".$v_usuario_anula, "width:130px;");?></div>
						<div><?php lblnorm("Causa Anulac.:","etq2"); txtronstl("txt_v_causanul_rvc", $v_causanul_rvc, "width:85px;");?></div>
					</div>
					</div>
					<div style="clear:both"></div>
					<hr>
					<?php 
					lblnorm("Causa de anulación:","etq14"); cmbnormal("cmb_causanul_rvc",$v_causanul_rvc, "Impresion", "Devolucion", "Errordigitacion");
					$var_codnotcred='';
					cmbfield("cmbcodnotcred", $Conexion, "SELECT * FROM codnotacred", $var_codnotcred, "id_ncred","desc_ncred");
					lblnorm("Desc. Nota Cred.:","etqdesc_nota");
					txtnrmstl("txtdescnc","width:150px;");
					?>
					<?php if (activar_boton($datos_perfil,$resultado_perfil_accesos,"Anular")) { ?> <input type="submit" name="btnGrl" value="Anular"/> <?php } ?>
					<?php if (activar_boton($datos_perfil,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
					<br><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario en una tabla ajustada a la medida de los datos -->
				<?php
				if($clave_id_rvi==1)
				{
					//Lista de datos de registro de ventas cuando se encuentran asociados a los datos de registro de caja
					echo "<b>REGISTROS DE VENTAS ASOCIADOS AL REGISTRO DE CAJA</b><br>";
					tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql_regventas,"tblnormal","Todo",
					"ID:id_rvi:50:N",
					"Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
					"Productos:id_pro:260:valfield|productos|abrv_pro|id_pro",
					"Fech.Vta.:fechaven_rvi:80:N",
					"Cód.Cpg.:codcpg_rvi:55:N",
					"Docum.:tipodoccp_rvi:95:N",
					"Serie:seriecp_rvi:35:N",
					"Número:numcp_rvi:60:N",
					"Imp.S/:importetot_rvi:75:N",
					"Descripción:descrip_rvi:150:N",
					"Zona:zona_rvi:80:N",
					"Usuario:id_usr:100:valfield|usuarios|nomb_usr|id_usr");
				}
				else
				{
					if ($clave_id_rvi_notfound==1)
					{
						echo "NO HAY REGISTRO DE VENTAS ASOCIADOS AL REGISTRO DE CAJA.<BR>";
					}
					else
					{
						//Lista de los ultimos 10 datos de registro de caja
						echo "<b>ULTIMOS 10 REGISTROS ANULADOS DE CAJA</b><br>";
						tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql_regvtacaja,"tblnormal",$ambito_busqueda,"ID:id_rvc:50:N","Cliente:id_cli:260:valfield|clientes|nom_rzs_cli|id_cli","Fech.Vta.:fechaven_rvi:80:N","Cód.Cpg.:codcpg_rvi:55:N","TipoPago:formapago_rvi:65:N","Estad.Pago:rgpag_rvc:70:N","Fch.Pag.:fechapag_rvc:80:N","Docum.:tipodoccp_rvi:105:N","Serie:seriecp_rvi:40:N","Número:numcp_rvi:60:N","Descripción:descrip_rvi:200:N","Importe S/.:importetot_rvi:80:N","Tip.Vta.:tipopla_rvi:80:N","Plan:id_pla:170:valfield|planes|abrv_pla|id_pla","Zona:zona_rvi:80:N","Estado:estado_rvc:60:N","Usuario:id_usr:100:valfield|usuarios|nomb_usr|id_usr","Usr.Anula:id_usr_anula:100:valfield|usuarios|nomb_usr|id_usr","Causa.Anulac.:causanul_rvc:80:N");
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