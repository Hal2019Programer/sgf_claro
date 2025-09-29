<?php
include("../library/funcionA.php");
include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$var_zona=$var_id_ccj=$var_zona_filtrar_ccj="";
$ambito_busqueda="Todo";
$btn="";
$sumar_total_regventas=$sumar_total_pagosdiv=$sumar_total_cajachica_e=$sumar_recnormal_regventas=$sumar_total_cajachica_i=0.00;
$sumar_recpdv_regventas=$sumar_otrosprod_regventas=0.00;
$fecha_deposito=$hora_deposito=$banco=$numero_operacion="";
$var_fechaini_filtrar=$var_fechafin_filtrar="";
$mostrar_registro_cuadrecaja=false;
$style_text_id="width:50px; border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;";
$style_date_01="border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;";
$style_text_monto="width:80px; border-radius:5px; height:18px; border: 1px solid #cccccc; text-align:center;";
$style_text_numoperac="width:100px; border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Cuadre de Caja",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<style>
	/*table 
	{	
		border-collapse: collapse;
		text-align: center;
	}
	table td /* fila de tabla (TableData)*/
	/*{
		white-space: nowrap;
		border: 1px solid var(--color-blanco);
		background: var(--color-gris-claro);
		color:black;
	}
	table th /* cabecera de tabla (TableHeader) */
	/*{
		background: var(--color-negro);
		border: 1px solid var(--color-blanco);
	}*/
</style>
<!DOCTYPE HTML>
<html>
	<style type="text/css">
		#estilo_cabecera {width:655px; text-align:center; background:var(--color-gris-claro); font-weight:bold;}
		#estilo_subtotal {width:655px; text-align:right; background:RGB(127,140,141); font-weight:bold;}
		/*#estilo_celda1 {background:transparent; padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse:collapse; width:550px; font-size:12px;}
		#estilo_celda2 {background:transparent; padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse:collapse; width:106px; font-size:12px;}*/
		#estilo_celda1 {padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse:collapse; width:550px; font-size:12px;}
		#estilo_celda2 {padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse:collapse; width:106px; font-size:12px;}
		#estilo_cabecera_id_ccj {width:920px; display:block; text-align:center; font-weight:bold;}
		#estilo_celda3 {width:200px; display:block; text-align:right; font-weight:bold; float:left;}
	</style>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Cuadre de Caja");?></head>
	<body>
		<div>
			<?php //cabecera02("Cuadre de Caja"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Cuadre de Caja"); menu02(); sl(1);?>
				<!--<center><h1>Cuadre de Caja</h1></center><hr>-->
				<?php
				//---------------------------------------------- Carga fecha actual ----------------------------------------------
				$fecha_actual=date("Y-m-d");
				//---------------------------------------------- Consulta cuadrecaja ----------------------------------------------
				if ($categ_usuario=="Prog" OR $categ_usuario=="Gern")
				{
					$consulta_cuadrecaja="SELECT * FROM cuadrecaja ORDER BY fecha_cuadre_ccj DESC LIMIT 20";
				}
				else
				{
					$consulta_cuadrecaja="SELECT * FROM cuadrecaja WHERE zona_ccj='$zona_usuario' ORDER BY fecha_cuadre_ccj DESC LIMIT 20";
				}
				$sql_cuadrecaja=mysqli_query($Conexion,$consulta_cuadrecaja) or die ("Error al consultar los datos de cuadrecaja");
				//---------------------------------------------- BOTONES ----------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					//---------------------------------------------------- BUSCAR ----------------------------------------------------
					if($btn=="Buscar")
					{
						if (!empty($_POST["txt_id_ccj"]))
						{
							$existe_cuadrecaja=busca_id_ccj($Conexion, $_POST["txt_id_ccj"], $id_ccj, $zona_ccj, $fecha_cuadre_ccj, $fecha_deposito_ccj,
							$hora_ccj, $monto_ccj, $banco_ccj, $cuenta_ccj, $numero_operacion_ccj, $imagen_ccj, $diasemana_ccj);
							if($existe_cuadrecaja)
							{	
								$mostrar_registro_cuadrecaja=true;
							}
							else
							{
								mensaje("No se encuentra el registro");
							}
						}
						else
						{
							mensaje("Falta el id para la búsqueda de registros."); echo "<script> location.href='cuadrecaja.php'; </script>";
						}
					}
					//---------------------------------------------- Filtrar ----------------------------------------------
					if($btn=="Filtrar" AND ($zona_usuario=="Total" OR $zona_usuario==$_POST["cmb_var_zona"]))
					{
						//---------------------------------------------- Generar para cuadrecaja ----------------------------------------------
						if (!empty($_POST["cmb_zona_filtrar_ccj"]) AND !empty($_POST["txt_fechaini_filtrar"]) AND !empty($_POST["txt_fechafin_filtrar"]))
						{
							
							$zona=$_POST["cmb_zona_filtrar_ccj"];	$var_zona_filtrar_ccj=$zona;
							$fechainicial=$_POST["txt_fechaini_filtrar"]; $var_fechaini_filtrar=$fechainicial;
							$fechafinal=$_POST["txt_fechafin_filtrar"]; $var_fechafin_filtrar=$fechafinal;
							$expresion_fecha=comp_y_gener_fechas02("fecha_cuadre_ccj", $fechainicial, $fechafinal);
							$sql_where="";
							if (!empty($zona)) $sql_where=$sql_where."(zona_ccj='$zona') AND ";
							if (!empty($expresion_fecha)) $sql_where=$sql_where.$expresion_fecha;
							$sql_where=trim($sql_where);
							$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
							if (!empty($sql_where))
							{
								if ($categ_usuario=="Prog" OR $categ_usuario=="Gern")
								{
									$sql_where="SELECT * FROM cuadrecaja WHERE 1 AND ".$sql_where." ORDER BY fecha_cuadre_ccj DESC";
								}
								else
								{
									$sql_where="SELECT * FROM cuadrecaja WHERE zona_ccj='$zona_usuario' AND ".$sql_where." ORDER BY fecha_cuadre_ccj DESC";
								}
								$sql_cuadrecaja=mysqli_query($Conexion,$sql_where) or die ("Error al consultar los datos de cuadrecaja en Filtrar.");
								if (crear_temporal_cuadrecaja($Conexion))
								{
									trasladar_cuadrecaja_a_temporal_cuadrecaja($Conexion,$sql_cuadrecaja);
									consultar_datos_temporal_cuadrecaja($Conexion,$sql_temporal_cuadrecaja);
									$sql_cuadrecaja=$sql_temporal_cuadrecaja;
								}
							}
						}
						else
						{
							mensaje("Los datos para el filtro no se han cargado o estan incompletos."); echo "<script> location.href='cuadrecaja.php'; </script>";
						}
					}
					//---------------------------------------------- Generar ----------------------------------------------
					if($btn=="Generar" AND ($zona_usuario=="Total" OR $zona_usuario==$_POST["cmb_var_zona"]))
					{
						//---------------------------------------------- Generar para regventas ----------------------------------------------
						if (!empty($_POST["cmb_var_zona"]) AND !empty($_POST["txt_fecha_actual"]))
						{
							$zona=$_POST["cmb_var_zona"];	$var_zona=$zona;
							$fech=$_POST["txt_fecha_actual"]; $fecha_actual=$fech;
							$sql_where="";
							if (!empty($zona)) $sql_where=$sql_where."(zona_rvi='$zona') AND ";
							if (!empty($fech)) $sql_where=$sql_where."(fechaven_rvi='$fech') AND ";
							$sql_where=trim($sql_where);
							$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
							$sumar_total_regventas=sumar_regventas($Conexion,$sql_where);
							$sumar_recnormal_regventas=sumar_recnormal($Conexion,$sql_where);
							$sumar_recpdv_regventas=sumar_recpdv($Conexion,$sql_where);
							$sumar_otrosprod_regventas=sumar_otrosprod($Conexion,$sql_where);
							if (!empty($sql_where))
							{
								$sql_where="SELECT 
								a.id_rvi, a.id_pro, a.tipopla_rvi, a.fechaven_rvi, a.tipodoccp_rvi, a.seriecp_rvi, a.numcp_rvi, 
								CONCAT(a.seriecp_rvi,'-',a.numcp_rvi) AS documento, a.importetot_rvi, a.zona_rvi, 
								b.tipo_cat, b.clase_cat, CONCAT(b.tipo_cat,' ',b.clase_cat) AS abre_pro 
								FROM regventas a 
								LEFT JOIN productos b ON a.id_pro=b.id_pro WHERE estado_rvc IS NULL AND ".$sql_where." ORDER BY a.numcp_rvi DESC";
								$sql_regventas=mysqli_query($Conexion,$sql_where) or die ("Error al traer los datos de regventas");
							}
							//---------------------------------------------- Generar para pagosdiv ----------------------------------------------
							$zona=$_POST["cmb_var_zona"];$var_zona=$zona;
							$fech=$_POST["txt_fecha_actual"];$fecha_actual=$fech;
							$sql_where="";
							if (!empty($zona)) $sql_where=$sql_where."(zona_rpg='$zona') AND ";
							if (!empty($fech)) $sql_where=$sql_where."(fechareg_rpg='$fech') AND ";
							$sql_where=trim($sql_where);
							$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
							$sumar_total_pagosdiv=sumar_pagosdiv($Conexion,$sql_where);
							$sumar_mensual_pagosdiv=sumar_mensual($Conexion,$sql_where);
							$sumar_adelanto_pagosdiv=sumar_adelanto($Conexion,$sql_where);
							if (!empty($sql_where))
							{
								$sql_where="SELECT 
								id_rpg, tipo_rpg, monto_rpg, seriedoc_rpg, numdoc_rpg, CONCAT(seriedoc_rpg,'-',numdoc_rpg) AS documento, 
								numcel_rpg, fechareg_rpg, zona_rpg 
								FROM pagosdiv 
								WHERE 1 AND ".$sql_where." ORDER BY numdoc_rpg DESC";
								$sql_pagosdiv=mysqli_query($Conexion,$sql_where) or die ("Error al traer los datos de pagosdiv");
							}
							//---------------------------------------------- Generar para cajachica (E) ----------------------------------------------
							$zona=$_POST["cmb_var_zona"];$var_zona=$zona;
							$fech=$_POST["txt_fecha_actual"];$fecha_actual=$fech;
							$sql_where="";
							if (!empty($zona)) $sql_where=$sql_where."(zona_usr='$zona') AND ";
							if (!empty($fech)) $sql_where=$sql_where."(fechareg_cch='$fech') AND ";
							$sql_where=trim($sql_where);
							$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
							$sumar_total_cajachica_e=sumar_cajachica_e($Conexion,$sql_where);
							if (!empty($sql_where))
							{
								$sql_where="SELECT 
								id_cch, tipodoccp_cch, seriedoc_cch, numerodoc_cch, CONCAT(seriedoc_cch,'-',numerodoc_cch) AS documento, 
								descrip_cch, monto_cch, fechareg_cch, zona_usr  
								FROM cajachica 
								WHERE tiporeg_cch='E' AND ".$sql_where." ORDER BY tipodoccp_cch ASC, numerodoc_cch DESC";
								$sql_cajachica_e=mysqli_query($Conexion,$sql_where) or die ("Error al traer los datos de pagosdiv");
							}
							//---------------------------------------------- Generar para cajachica (I) ----------------------------------------------
							$zona=$_POST["cmb_var_zona"];$var_zona=$zona;
							$fech=$_POST["txt_fecha_actual"];$fecha_actual=$fech;
							$sql_where="";
							if (!empty($zona)) $sql_where=$sql_where."(zona_usr='$zona') AND ";
							if (!empty($fech)) $sql_where=$sql_where."(fechareg_cch='$fech') AND ";
							$sql_where=trim($sql_where);
							$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
							$sumar_total_cajachica_i=sumar_cajachica_i($Conexion,$sql_where);
							if (!empty($sql_where))
							{
								$sql_where="SELECT 
								id_cch, tipodoccp_cch, seriedoc_cch, numerodoc_cch, CONCAT(seriedoc_cch,'-',numerodoc_cch) AS documento, 
								descrip_cch, monto_cch, fechareg_cch, zona_usr  
								FROM cajachica 
								WHERE tiporeg_cch='I' AND ".$sql_where." ORDER BY tipodoccp_cch ASC, numerodoc_cch DESC";
								$sql_cajachica_i=mysqli_query($Conexion,$sql_where) or die ("Error al traer los datos de pagosdiv");
							}
						}
						else
						{
							mensaje("Los datos para generar el cuadre de caja no se han cargado o estan incompletos."); echo "<script> location.href='cuadrecaja.php'; </script>";
						}
					}
					//---------------------------------------------- Actualizar ----------------------------------------------
					if($btn=="Actualizar")
					{
						$eliminar_temporal_cuadrecaja="DROP TEMPORARY TABLE IF EXISTS temporal_cuadrecaja";
						$resultado_eliminar_temporal_cuadrecaja=mysqli_query($Conexion,$eliminar_temporal_cuadrecaja) or die ("Error al eliminar temporal_cuadrecaja.");
						/*if($resultado_eliminar_temporal_cuadrecaja) { mensaje("Se elimino correctamente la tabla temporal_cuadrecaja."); }*/
						echo "<script> location.href = 'cuadrecaja.php'; </script>";
					}
					//---------------------------------------------- Guardar cuadre de caja ----------------------------------------------
					if($btn=="Guardar")
					{ 
						leer_datos_de_formulario($zona,$fcha,$mtto,$fchd,$hrde,$bnco,$nopr,$foto,$ruta);
						$destino="imagen_voucher/".$foto; //Ruta final para archivo imagen de carpeta temporal
						$diasemana=dia_semana($fcha);
						$comprobar_vacios=verifica_vacios_para_guardar($zona,$fcha,$mtto,$fchd,$hrde,$bnco,$nopr,$foto,$ruta);
						if ($comprobar_vacios)
						{
							$comprobar_registro_existente=comprobar_duplicado_registro($Conexion,$zona,$fcha,$mtto);
							if (!$comprobar_registro_existente)
							{
								if ($zona_usuario=="Total")
								{
									$comprobar_fecha_deposito=true;
								}
								else
								{
									$comprobar_fecha_deposito=verificar_limite_deposito($fcha,$fchd);
								}
								if ($comprobar_fecha_deposito)
								{
									registrar_insertar_en_cuadrecaja($Conexion,$zona,$fcha,$mtto,$fchd,$hrde,$bnco,$nopr,$ruta,$destino,$diasemana);
									mensaje("El registro y cierre del cuadre de caja se efectuó con éxito. ADVERTENCIA!. No se va a poder volver a registrar y cerrar el cuadre de caja nuevamente.");
								}
								else
								{
									mensaje("Ya no se puede cerrar la caja. La fecha del depósito es mayor a la del cierre de la caja.");
								}
							}
							else
							{
								mensaje("Ya existe un registro del cierre del cuadro de caja. Revise los datos antes de continuar con otro proceso.");
							}
						}
						else
						{
							mensaje("No existen datos o estan incompletos para el registro del Cuadre de Caja. ADVERTENCIA! Una vez registrado el cuadre de caja no se puede volver a realizarlo.");
						}
						echo "<script> location.href = 'cuadrecaja.php'; </script>";
					}
				}
				?>
				<!---------------------------------------------- Formulario ---------------------------------------------->
				<form name="cuadrecaja" action="" method="post" enctype="multipart/form-data"><?php 
					if ($btn<>"Generar")
					{ 
						lblnorm("Id:","etq5"); txtvalue01("txt_id_ccj",$var_id_ccj,6,"text",$style_text_id); 
						if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); } spc(3);
						lblnorm("Zona:","etq5"); 
						//cmbnormal("cmb_zona_filtrar_ccj", $var_zona_filtrar_ccj, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29"); 
						cmbfieldJs_span("spn_zona","cmb_zona_filtrar_ccj",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona_filtrar_ccj,"","nomb_zna");
						lblnorm("Fecha Inicial:","etq5"); txtvalue01("txt_fechaini_filtrar",$var_fechaini_filtrar,25,"date",$style_date_01);
						lblnorm("Fecha Final:","etq5"); txtvalue01("txt_fechafin_filtrar",$var_fechafin_filtrar,25,"date",$style_date_01); 
						if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
					}
					if (!$mostrar_registro_cuadrecaja)
					{
						if ($btn<>"Generar") sl(1);
						lblnorm("Zona:","etq5"); 
						//cmbnormal("cmb_var_zona", $var_zona, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29"); 
						cmbfieldJs_span("spn_zona","cmb_var_zona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona,"","nomb_zna"); 
						spc(3);
						lblnorm("Fecha de Cuadre Caja:","etq5"); txtvalue01("txt_fecha_actual",$fecha_actual,25,"date",$style_date_01);
						if (activar_boton($datos,$resultado_perfil_accesos,"Generar")) { if ($btn<>"Generar") btnnormal("btnGrl", "Generar"); }
					}
					if ($btn=="Generar" AND !empty($_POST["cmb_var_zona"]) AND !empty($_POST["txt_fecha_actual"]) AND ($zona_usuario=="Total" OR $zona_usuario==$_POST["cmb_var_zona"]))
					{ 
						lblnorm("Monto total:","etq5"); txtronstl01("txt_monto_total",$sumar_total_regventas+$sumar_total_pagosdiv-$sumar_total_cajachica_e+$sumar_total_cajachica_i,"text",$style_text_monto); sl(1);
						lblnorm("Fecha de depósito:","etq5"); txtvalue01("txt_fecha_deposito",$fecha_deposito,25,"date",$style_date_01); spc(5);
						lblnorm("Hora de depósito:","etq5"); txtvalue01("txt_hora_deposito",$hora_deposito,25,"time",$style_date_01); sl(1);
						lblnorm("Banco:","etq5"); cmbnormal("cmb_banco", $banco, "BCP:355-2345860-0-12", "CrediScotia:890-6623254"); spc(17);
						lblnorm("Número de operación:","etq5"); txtvalue01("txt_numero_operacion",$numero_operacion,25,"text",$style_text_numoperac); sl(1);
						lblnorm("Imagen Voucher:","etq5");?><input type="file" name="imagen" id="imagen"><?php
						spc(40); btnnormal("btnGrl", "Guardar");
					}
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Actualizar"); }
					ls();?>
				</form><?php
				//------------------------------------ Inicio para mostrar cuadre de caja (generado, lista y registro) ------------------------------------
				if ($btn=="Generar" AND !empty($_POST["cmb_var_zona"]) AND !empty($_POST["txt_fecha_actual"]) AND ($zona_usuario=="Total" OR $zona_usuario==$_POST["cmb_var_zona"]))
				{
					mostrar_cuadre_caja_generado($Conexion,$var_zona,$fecha_actual,$ambito_busqueda,$sql_regventas,$sumar_total_regventas,
					$sql_pagosdiv,$sumar_total_pagosdiv,$sql_cajachica_e,$sumar_total_cajachica_e,$sql_cajachica_i,$sumar_total_cajachica_i,
					$sumar_otrosprod_regventas,$sumar_recnormal_regventas,$sumar_recpdv_regventas);
				}
				else
				{
					if ($btn=="Buscar" AND $mostrar_registro_cuadrecaja)
					{ 
						listar_registro_cuadre_caja($id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$numero_operacion_ccj,$imagen_ccj,$diasemana_ccj);
					}
					else
					{
						listar_cuadre_caja($Conexion,$sql_cuadrecaja);
					}
				}?>
			</div>
			<!---------------------------------------------- Fin de listado de datos de usuario ---------------------------------------------->
		</div><!--Fin de main-col-->
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function sumar_regventas($Conexion,$sql_where)
{
	$sql_regventas_suma=mysqli_query($Conexion,"SELECT 
	SUM(importetot_rvi) AS suma FROM regventas 
	WHERE estado_rvc IS NULL AND ".$sql_where) or die ("Error al sumar los datos de regventas");
	$a=mysqli_fetch_array($sql_regventas_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_recnormal($Conexion,$sql_where)
{
	$sql_regventas_suma=mysqli_query($Conexion,"SELECT 
	SUM(importetot_rvi) AS suma FROM regventas 
	WHERE estado_rvc IS NULL AND tipopla_rvi='Rec.Normal' AND ".$sql_where) or die ("Error al sumar los datos de regventas para Rec.Normal");
	$a=mysqli_fetch_array($sql_regventas_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_recpdv($Conexion,$sql_where)
{
	$sql_regventas_suma=mysqli_query($Conexion,"SELECT 
	SUM(importetot_rvi) AS suma FROM regventas 
	WHERE estado_rvc IS NULL AND tipopla_rvi='Rec.PDV' AND ".$sql_where) or die ("Error al sumar los datos de regventas para Rec.PDV");
	$a=mysqli_fetch_array($sql_regventas_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_otrosprod($Conexion,$sql_where)
{
	$sql_regventas_suma=mysqli_query($Conexion,"SELECT 
	SUM(importetot_rvi) AS suma FROM regventas 
	WHERE estado_rvc IS NULL AND (tipopla_rvi<>'Rec.Normal' AND tipopla_rvi<>'Rec.PDV') AND ".$sql_where) or die ("Error al sumar los datos de regventas para otro productos");
	$a=mysqli_fetch_array($sql_regventas_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_pagosdiv($Conexion,$sql_where)
{
	$sql_pagosdiv_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_rpg) AS suma FROM pagosdiv 
	WHERE 1 AND ".$sql_where) or die ("Error al sumar los datos de pagosdiv");
	$a=mysqli_fetch_array($sql_pagosdiv_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_mensual($Conexion,$sql_where)
{
	$sql_pagosdiv_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_rpg) AS suma FROM pagosdiv 
	WHERE 1 AND tipo_rpg='Pag.Mens.' AND ".$sql_where) or die ("Error al sumar los datos de pagosdiv para pagos mensuales");
	$a=mysqli_fetch_array($sql_pagosdiv_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_adelanto($Conexion,$sql_where)
{
	$sql_pagosdiv_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_rpg) AS suma FROM pagosdiv 
	WHERE 1 AND tipo_rpg='Pag.Adel.' AND ".$sql_where) or die ("Error al sumar los datos de pagosdiv");
	$a=mysqli_fetch_array($sql_pagosdiv_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_Payjoy($Conexion,$sql_where)
{
	$sql_pagosdiv_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_rpg) AS suma FROM pagosdiv 
	WHERE 1 AND tipo_rpg='PayJoy' AND ".$sql_where) or die ("Error al sumar los datos de Payjoy de pagosdiv");
	$a=mysqli_fetch_array($sql_pagosdiv_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_cajachica_e($Conexion,$sql_where)
{
	$sql_cajachica_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_cch) AS suma FROM cajachica 
	WHERE tiporeg_cch='E' AND ".$sql_where) or die ("Error al sumar los datos de cajachica");
	$a=mysqli_fetch_array($sql_cajachica_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function sumar_cajachica_i($Conexion,$sql_where)
{
	$sql_cajachica_suma=mysqli_query($Conexion,"SELECT 
	SUM(monto_cch) AS suma FROM cajachica 
	WHERE tiporeg_cch='I' AND ".$sql_where) or die ("Error al sumar los datos de cajachica");
	$a=mysqli_fetch_array($sql_cajachica_suma,MYSQLI_ASSOC);
	$suma_total=$a["suma"];
	return $suma_total;
}
function cuadro_subtotales($texto1,$texto2)
{ ?>
	<table border='0' cellspacing='0' cellpadding='0' style="width:656px; border-collapse:collapse;">
		<tr>
			<td id="estilo_celda1"><?php echo $texto1;?> </td>
			<td id="estilo_celda2"><?php echo $texto2;?> </td>
		</tr>
	</table> <?php
}
function fila_subtotales($texto1,$texto2)
{ ?>
	<tr>
		<td id="estilo_celda1"><?php echo $texto1;?> </td>
		<td id="estilo_celda2"><?php echo $texto2;?> </td>
	</tr><?php
}
function leer_datos_de_formulario(&$zona,&$fcha,&$mtto,&$fchd,&$hrde,&$bnco,&$nopr,&$foto,&$ruta)
{
	$zona=$_POST["cmb_var_zona"];
	$fcha=$_POST["txt_fecha_actual"];
	$mtto=$_POST["txt_monto_total"];
	$fchd=$_POST["txt_fecha_deposito"];
	$hrde=$_POST["txt_hora_deposito"];
	$bnco=$_POST["cmb_banco"];
	$nopr=$_POST["txt_numero_operacion"];
	//Cargar datos de imagen que se sube a la carpeta
	$foto=$_FILES["imagen"]["name"];
	$ruta=$_FILES["imagen"]["tmp_name"];
}
function verifica_vacios_para_guardar($zona,$fecha_actual,$monto_total,$fecha_deposito,$hora_deposito,$banco,$numero_operacion,$imagen_voucher,$ruta_imagen)
{
	$valor_logico=false;
	$valor_logico=(!empty($zona) AND !empty($fecha_actual) AND !empty($monto_total) 
	AND !empty($fecha_deposito) AND !empty($hora_deposito) AND !empty($banco) 
	AND !empty($numero_operacion) AND !empty($imagen_voucher) AND !empty($ruta_imagen));
	return $valor_logico;
}
function comprobar_duplicado_registro($Conexion,$zona,$fcha,$mtto)
{
	$consulta_cuadrecaja="SELECT id_ccj FROM cuadrecaja WHERE (zona_ccj='$zona' AND fecha_cuadre_ccj='$fcha' AND monto_ccj=$mtto)";
	$sql_cuadrecaja=mysqli_query($Conexion,$consulta_cuadrecaja) or die ("Error al consultar datos en cuadrecaja.");
	$filas_cuadrecaja=mysqli_num_rows($sql_cuadrecaja);
	if ($filas_cuadrecaja>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function registrar_insertar_en_cuadrecaja($Conexion,$zona,$fcha,$mtto,$fchd,$hrde,$bnco,$nopr,$ruta,$destino,$diasemana)
{
	copy($ruta,$destino);
	insertarsql($Conexion,"Error al registrar datos en caja chica","cuadrecaja",
	"zona_ccj",$zona,
	"fecha_cuadre_ccj",$fcha,
	"fecha_deposito_ccj",$fchd,
	"hora_ccj",$hrde,
	"monto_ccj",$mtto,
	"banco_ccj",$bnco,
	"numero_operacion_ccj",$nopr,
	"imagen_ccj",$destino,
	"diasemana_ccj",$diasemana);
}
function busca_id_ccj($Conexion, $id, &$id_ccj, &$zona_ccj, &$fecha_cuadre_ccj, &$fecha_deposito_ccj, &$hora_ccj, 
&$monto_ccj, &$banco_ccj, &$cuenta_ccj, &$numero_operacion_ccj, &$imagen_ccj,&$diasemana_ccj)
{
	$consulta_cuadrecaja="SELECT * FROM cuadrecaja WHERE id_ccj='$id'";
	$sql_cuadrecaja=mysqli_query($Conexion,$consulta_cuadrecaja) or die ("Error al consultar datos en cuadrecaja para buscar Id.");
	$filas_cuadrecaja=mysqli_num_rows($sql_cuadrecaja);
	if ($filas_cuadrecaja>0)
	{
		$a=mysqli_fetch_array($sql_cuadrecaja,MYSQLI_ASSOC);
		$id_ccj=$a["id_ccj"];
		$zona_ccj=$a["zona_ccj"];
		$fecha_cuadre_ccj=$a["fecha_cuadre_ccj"];
		$fecha_deposito_ccj=$a["fecha_deposito_ccj"];
		$hora_ccj=$a["hora_ccj"];
		$monto_ccj=$a["monto_ccj"];
		$banco_ccj=$a["banco_ccj"];
		$cuenta_ccj=$a["cuenta_ccj"];
		$numero_operacion_ccj=$a["numero_operacion_ccj"];
		$imagen_ccj=$a["imagen_ccj"];
		$diasemana_ccj=$a["diasemana_ccj"];
		return true;
	}
	else
	{
		return false;
	}
}
function listar_cuadre_caja($Conexion,$sql_cuadrecaja)
{
	tblanchovariable_03($Conexion,"margin-left:0px;","height:220px;",$sql_cuadrecaja,"tblnormal",
	"ID:id_ccj:50:N",
	"Zona:zona_ccj:100:N",
	"Fech.CuadreCaja:fecha_cuadre_ccj:120:N",
	"Fech.Deposito:fecha_deposito_ccj:120:N",
	"Hora Deposito:hora_ccj:100:N",
	"Monto:monto_ccj:100:N",
	"Banco-Cuenta:banco_ccj:200:N",
	"Num.Operac.:numero_operacion_ccj:100:N",
	"Día:diasemana_ccj:100:N");
	scroll_doble("div1", "div2");
}
function listar_registro_cuadre_caja($id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$numero_operacion_ccj,$imagen_ccj,$diasemana_ccj)
{
	?>
	<span id="estilo_cabecera_id_ccj"><?php echo "REGISTRO DE CUADRE DE CAJA<br>";?></span>
	<table border='1' cellspacing='0' cellpadding='0' style='width:920px; border-collapse:collapse; border:RGB(200,200,200);'>
		<tr>
			<td style="width:50%;">
				<span id="estilo_celda3"><?php echo "Id:";?></span><?php spc(5);echo $id_ccj,"<br>";?>
				<span id="estilo_celda3"><?php echo "Zona:";?></span><?php spc(5);echo $zona_ccj,"<br>";?>
				<span id="estilo_celda3"><?php echo "Fecha de cuadre de caja:";?></span><?php spc(5);echo $fecha_cuadre_ccj,"(".$diasemana_ccj.")","<br>";?>
				<span id="estilo_celda3"><?php echo "Fecha de deposito de efectivo:";?></span><?php spc(5);echo $fecha_deposito_ccj,"<br>";?>
			</td>
			<td style="width:50%;">
				<span id="estilo_celda3"><?php echo "Hora de depósito de efectivo:";?></span><?php spc(5);echo $hora_ccj,"<br>";?>
				<span id="estilo_celda3"><?php echo "Monto de depósito:";?></span><?php spc(5);echo $monto_ccj,"<br>";?>
				<span id="estilo_celda3"><?php echo "Banco-Cuenta:";?></span><?php spc(5);echo $banco_ccj,"<br>";?>
				<span id="estilo_celda3"><?php echo "Num. de Operación:";?></span><?php spc(5);echo $numero_operacion_ccj,"<br>";?>
			</td>
		</tr>
		<tr style="text-align:center;">
			<td colspan="2"><img src="<?php echo $imagen_ccj;?>" width="920" heigth="920"><br></td>
		</tr>
	</table><?php
}
function mostrar_cuadre_caja_generado($Conexion,$var_zona,$fecha_actual,$ambito_busqueda,
$sql_regventas,$sumar_total_regventas,$sql_pagosdiv,$sumar_total_pagosdiv,
$sql_cajachica_e,$sumar_total_cajachica_e,$sql_cajachica_i,$sumar_total_cajachica_i,
$sumar_otrosprod_regventas,$sumar_recnormal_regventas,$sumar_recpdv_regventas)
{ 
	echo "<div id='estilo_cabecera'>";
		echo "CUADRO DE CAJA <br>";
		echo "ZONA:", $var_zona, " -  FECHA:", invFech($fecha_actual,"-"), "<br><hr>";
		echo "VENTA REGULAR";
	echo "</div>";
	tblanchovariable_04($Conexion,"margin-left:0px; font-size:12px; border-collapse:collapse;",$sql_regventas,$ambito_busqueda,
	"ID:id_rvi:50:N",
	"Doc.:documento:100:N",
	"TipoVenta:tipopla_rvi:100:N",
	"Prod.:abre_pro:200:N",
	"Monto:importetot_rvi:100:N");
	scroll_doble("div1", "div2");
	cuadro_subtotales("Total de Venta Regular:",$sumar_total_regventas);
	echo "<div id='estilo_cabecera'>";
		echo "<hr><br>PAGOS DIVERSOS";
	echo "</div>";
	tblanchovariable_04($Conexion,"margin-left:0px; font-size:12px; border-collapse:collapse;",$sql_pagosdiv,$ambito_busqueda,
	"ID:id_rpg:50:N",
	"Doc.:documento:100:N",
	"TipoVenta:tipo_rpg:100:N",
	"Cel.:numcel_rpg:200:N",
	"Monto:monto_rpg:100:N");
	scroll_doble("div1", "div2");
	cuadro_subtotales("Total de Pagos Diversos:",$sumar_total_pagosdiv);
	echo "<div id='estilo_cabecera'>";
		echo "<hr><br>EGRESOS DIVERSOS";
	echo "</div>";
	tblanchovariable_04($Conexion,"margin-left:0px; font-size:12px; border-collapse:collapse;",$sql_cajachica_e,$ambito_busqueda,
	"ID:id_cch:50:N",
	"Tipo Doc.:tipodoccp_cch:100:N",
	"Documento:documento:100:N",
	"Descripción:descrip_cch:200:N",
	"Monto:monto_cch:100:N");
	scroll_doble("div1", "div2");
	cuadro_subtotales("Total de Egresos Diversos:",$sumar_total_cajachica_e);
	echo "<div id='estilo_cabecera'>";
		echo "<hr><br>INGRESOS DIVERSOS";
	echo "</div>";
	tblanchovariable_04($Conexion,"margin-left:0px; font-size:12px; border-collapse:collapse;",$sql_cajachica_i,$ambito_busqueda,
	"ID:id_cch:50:N",
	"Tipo Doc.:tipodoccp_cch:100:N",
	"Documento:documento:100:N",
	"Descripción:descrip_cch:200:N",
	"Monto:monto_cch:100:N");
	scroll_doble("div1", "div2");
	cuadro_subtotales("Total de Egresos Diversos:",$sumar_total_cajachica_i);
	echo "<div id='estilo_cabecera'>";
		echo "RESUMEN DE CAJA<br>";
		echo "INGRESOS<br>";
	echo "</div>";
	echo "<table border='0' cellspacing='0' cellpadding='0' style='width:656px; border-collapse:collapse;'>";
		fila_subtotales("Equipo+Chips+Otros:",$sumar_otrosprod_regventas);
		fila_subtotales("Recargas a Cliente Final:",$sumar_recnormal_regventas);
		fila_subtotales("Transferencias a PDV:",$sumar_recpdv_regventas);
		fila_subtotales("Pagos Diversos:",$sumar_total_pagosdiv);
		fila_subtotales("Ingresos Diversos:",$sumar_total_cajachica_i);
		fila_subtotales("Total de Ingresos:",$sumar_total_regventas+$sumar_total_pagosdiv+$sumar_total_cajachica_i);
	echo "</table>";
	echo "<div id='estilo_cabecera'>";
		echo "EGRESOS<br>";
	echo "</div>";
	echo "<table border='0' cellspacing='0' cellpadding='0' style='width:656px; border-collapse:collapse;'>";
		fila_subtotales("Egresos Diversos:",$sumar_total_cajachica_e);
		fila_subtotales("Total de Egresos:",$sumar_total_cajachica_e);
	echo "</table>";
	echo "<div id='estilo_cabecera'>";
		echo "SALDO EFECTIVO<br>";
	echo "</div>";
	echo "<table border='0' cellspacing='0' cellpadding='0' style='width:656px; border-collapse:collapse;'>";
		fila_subtotales("Saldo Efectivo:",$sumar_total_regventas+$sumar_total_pagosdiv-$sumar_total_cajachica_e+$sumar_total_cajachica_i);
	echo "</table>"; 
}
function verificar_limite_deposito($fecha_cuadre_caja,$fecha_deposito)
{
	$fecha_inicial=$fecha_cuadre_caja;
	$fecha_final=date("Y-m-d",strtotime($fecha_cuadre_caja."+ 2 days"));
	if ((strtotime($fecha_deposito)>=strtotime($fecha_inicial)) AND (strtotime($fecha_deposito)<=strtotime($fecha_final)))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function crear_temporal_cuadrecaja($Conexion)
{
	$tabla_temporal="CREATE TEMPORARY TABLE temporal_cuadrecaja (
	`id_tcc` int(11) NOT NULL AUTO_INCREMENT, 
	`id_ccj` int(11) DEFAULT NULL, 
  `zona_ccj` char(9) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `fecha_cuadre_ccj` date DEFAULT NULL, 
  `fecha_deposito_ccj` date DEFAULT NULL, 
  `hora_ccj` time DEFAULT NULL, 
  `monto_ccj` decimal(10,2) DEFAULT NULL, 
  `banco_ccj` char(30) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `cuenta_ccj` char(16) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `numero_operacion_ccj` char(10) COLLATE utf8_unicode_ci DEFAULT NULL, 
  `imagen_ccj` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL, 
	`diasemana_ccj` char(9) COLLATE utf8_unicode_ci DEFAULT NULL, 
	PRIMARY KEY(`id_tcc`) 
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	$resultado=mysqli_query($Conexion,$tabla_temporal) or die ("Error al crear tabla temporal de cuadrecaja.");
	return $resultado;
}
function trasladar_cuadrecaja_a_temporal_cuadrecaja($Conexion,$sql_cuadrecaja)
{
	$filas_cuadrecaja=mysqli_num_rows($sql_cuadrecaja);
	if ($filas_cuadrecaja>0)
	{
		$fecha_cuadre="";
		while($a=mysqli_fetch_array($sql_cuadrecaja, MYSQLI_ASSOC))
		{
			leer_registro_cuadrecaja($a,$id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$cuenta_ccj,$numero_operacion_ccj,$imagen_ccj,$diasemana_ccj);
			if (empty($fecha_cuadre))
			{
				insertar_en_temporal_cuadrecaja($Conexion,$id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$numero_operacion_ccj,$imagen_ccj,$diasemana_ccj);
				$fecha_cuadre=date("Y-m-d",strtotime($fecha_cuadre_ccj."- 1 days"));
			}
			else
			{
				$verificar_ciclo=true;
				while($verificar_ciclo)
				{
					if (strtotime($fecha_cuadre)==strtotime($fecha_cuadre_ccj))
					{
						insertar_en_temporal_cuadrecaja($Conexion,$id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$numero_operacion_ccj,$imagen_ccj,$diasemana_ccj);
						$fecha_cuadre=date("Y-m-d",strtotime($fecha_cuadre_ccj."- 1 days"));
						$verificar_ciclo=false;
					}
					else
					{
						$dia_semana=dia_semana($fecha_cuadre);
						insertar_vacio_en_temporal_cuadrecaja($Conexion,$zona_ccj,$fecha_cuadre,$dia_semana);
						$fecha_cuadre=date("Y-m-d",strtotime($fecha_cuadre."- 1 days"));
						$verificar_ciclo=true;
					}
				}
			}
		}
	}
	else
	{
		mensaje("No se han encontrado registros luego de la consulta para trasladar a temporal_cuadrecaja.");
	}
}
function consultar_datos_temporal_cuadrecaja($Conexion,&$sql_temporal_cuadrecaja)
{
	$sql_where="SELECT * FROM temporal_cuadrecaja ORDER BY fecha_cuadre_ccj DESC";
	$sql_temporal_cuadrecaja=mysqli_query($Conexion,$sql_where) or die ("Error al consultar los datos de temporal_cuadrecaja en Filtrar.");
}
function leer_registro_cuadrecaja($a,&$id_ccj,&$zona_ccj,&$fecha_cuadre_ccj,&$fecha_deposito_ccj,&$hora_ccj,&$monto_ccj,&$banco_ccj,&$cuenta_ccj,&$numero_operacion_ccj,&$imagen_ccj,&$diasemana_ccj)
{
	$id_ccj=$a["id_ccj"];
	$zona_ccj=$a["zona_ccj"];
	$fecha_cuadre_ccj=$a["fecha_cuadre_ccj"];
	$fecha_deposito_ccj=$a["fecha_deposito_ccj"];
	$hora_ccj=$a["hora_ccj"];
	$monto_ccj=$a["monto_ccj"];
	$banco_ccj=$a["banco_ccj"];
	$cuenta_ccj=$a["cuenta_ccj"];
	$numero_operacion_ccj=$a["numero_operacion_ccj"];
	$imagen_ccj=$a["imagen_ccj"];
	$diasemana_ccj=$a["diasemana_ccj"];
}
function insertar_en_temporal_cuadrecaja($Conexion,$id_ccj,$zona_ccj,$fecha_cuadre_ccj,$fecha_deposito_ccj,$hora_ccj,$monto_ccj,$banco_ccj,$numero_operacion_ccj,$imagen_ccj,$dia_semana)
{
	insertarsql($Conexion,"Error al registrar datos en temporal_cuadrecaja","temporal_cuadrecaja",
	"id_ccj",$id_ccj,
	"zona_ccj",$zona_ccj,
	"fecha_cuadre_ccj",$fecha_cuadre_ccj,
	"fecha_deposito_ccj",$fecha_deposito_ccj,
	"hora_ccj",$hora_ccj,
	"monto_ccj",$monto_ccj,
	"banco_ccj",$banco_ccj,
	"numero_operacion_ccj",$numero_operacion_ccj,
	"imagen_ccj",$imagen_ccj,
	"diasemana_ccj",$dia_semana);
}
function insertar_vacio_en_temporal_cuadrecaja($Conexion,$zona_ccj,$fecha_cuadre_ccj,$dia_semana)
{
	insertarsql($Conexion,"Error al registrar datos incompletos en temporal_cuadrecaja","temporal_cuadrecaja",
	"zona_ccj",$zona_ccj,
	"fecha_cuadre_ccj",$fecha_cuadre_ccj,
	"diasemana_ccj",$dia_semana);
}
function dia_semana($fecha)
{
	$dias_de_la_semana = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
	$dia = $dias_de_la_semana[date("N", strtotime($fecha))-1];
	return $dia;
}
?>