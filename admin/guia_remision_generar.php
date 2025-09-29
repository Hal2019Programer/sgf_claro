<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
if ($zona_usuario=="Total") $punto_partida = "Jr. Progreso 256 - San Ramon - Chanchamayo"; else obtener_direccion_origen($Conexion,$zona_usuario,$punto_partida);
$fecha_inicio = date("Y-m-d");
$consulta_empresa = mysqli_query($Conexion, "SELECT nomb_empe, ndoc_empe AS ruc_empe, CONCAT (dir_empe, ' - ', dist_empe, ' - ' , region_empe) AS direcc_empe FROM empemisor");
$empresa = mysqli_fetch_assoc($consulta_empresa);
$consulta_usuario = mysqli_query($Conexion, "SELECT CONCAT ('(', id_usr, ') ', nomb_usr, ' ', apel_usr, ', ' , dni_usr) AS datos_usr FROM usuarios WHERE id_usr=$ident_usuario");
if (mysqli_num_rows($consulta_usuario)<1) { $datos_usr="Ninguno"; }
else { $datos_usr = mysqli_fetch_assoc($consulta_usuario)["datos_usr"]; }
$st01="font-weight:bold;";
$consulta_guia_remis_detalle_tmp="SELECT a.id_gr_tmp, a.serie_gr, a.numero_gr, a.fechtrasl_gr, a.znaorig_gr, a.znadest_gr, 
a.id_usr, 
a.motivo_trasl_gr, a.ruc_transp_gr, a.descrip_transp_gr, a.marca_placa_transp_gr, a.licen_conduc_transp_gr, 
a.id_pro, a.cant_pro_gr, 
zna_o.serie_zna AS serie_zna_o, zna_o.nomb_zna AS nomb_zna_o, zna_o.direc_zna AS direc_zna_o, 
zna_d.nomb_zna AS nomb_zna_d, zna_d.direc_zna AS direc_zna_d, 
c.nomb_usr, c.apel_usr, c.dni_usr, 
d.abrv_pro, d.tipo_cat AS unidad, d.clase_cat AS modelo 
FROM guia_remis_detalle_tmp a 
LEFT JOIN zona zna_o ON a.znaorig_gr=zna_o.id_zna 
LEFT JOIN zona zna_d ON a.znadest_gr=zna_d.id_zna 
LEFT JOIN usuarios c ON a.id_usr=c.id_usr 
LEFT JOIN productos d ON a.id_pro=d.id_pro";
muestraDatos_x_innerHTML_Js();
carga_ventana_tipo01();
cargaDatos_x_value_Js();
?>
<script>
	var estado_submit = true;
	function actualz_dat_zna_dest(valor_combobox)
	{
		var id_zna = document.getElementById(valor_combobox).value;
		//cargaDatos_x_value("txt_punto_llegada,txt_ruc_transportista,txt_denominacion_nom_ape", id_zna, "guia_remision_tmp.punto_llegada_zna.php");
		cargaDatos_x_value("txt_punto_llegada", id_zna, "guia_remision_tmp.punto_llegada_zna.php");
	}
	function verificar_datos()
	{
		if (estado_submit)
		{
			var zona_destino=document.getElementById("cmb_zona_destino").value;
			var motivo=document.getElementById("cmb_Motivo").value;
			var ruc_transportista=document.getElementById("txt_ruc_transportista").value;
			var denominacion_nom_ape=document.getElementById("txt_denominacion_nom_ape").value;
			if (vacio_nulo(zona_destino) || vacio_nulo(motivo) || vacio_nulo(ruc_transportista) || vacio_nulo(denominacion_nom_ape))
			{
				alert("Los datos de destion, motivo de traslado, ruc de transportista o nombre de transportista están incompletos. No se puede ejecutar el registro de la Guía de Remisión.");
				return false;
			}
			else
				return true;
		}
		else
		{
			return true;
		}
	}
	function vacio_nulo(variable)
	{
		if (variable===null) return true;
		else
			if (variable.trim()==="") return true;
			else return false;
	}
</script>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Transferencias");?>	</head>
	<body>
		<?php //cabecera02("Transferencia de productos"); menu02(); ls(); ?>
		<?php cabecera04(0,"Gestión de Remisión"); menu02();?>
		<!--center><h1>Guía de Remisión</h1></center><hr>--><?php
		if(isset($_POST["btnGrl"]))
		{
			$btn=$_POST["btnGrl"];
			if($btn=="Aceptar")
			{
				$buscar_zona_de_almacen=buscar_zona($Conexion,$zona_usuario);
				if ($buscar_zona_de_almacen)
				{
				//Cargar todos los datos a todos los registros de la guia a tabla guia_remis_detalle_tmp
				$serie_gr=dato("txt_serie");
				$numero_gr=dato("txt_numero");
				$txt_fecha_inicio_traslado=dato("txt_fecha_inicio_traslado");
				$txt_zona_origen=dato("txt_zona_origen");
				$cmb_zona_destino=dato("cmb_zona_destino"); $cmb_zona_destino=valfield($Conexion,"zona","nomb_zna","id_zna","'".$cmb_zona_destino."'");
				$id_usr=$ident_usuario;
				$cmb_Motivo=dato("cmb_Motivo");
				$txt_ruc_transportista=dato("txt_ruc_transportista");
				$txt_denominacion_nom_ape=dato("txt_denominacion_nom_ape");
				$txt_vehiculo_marca_placa=dato("txt_vehiculo_marca_placa");
				$txt_licencia_conducir=dato("txt_licencia_conducir");
				$estado_seleccion_productos=verificar_datos_guia_remis_detalle_tmp($Conexion,$serie_gr,$numero_gr,$id_usr);
				if ($estado_seleccion_productos)
				{
					$cargar_datos="UPDATE guia_remis_detalle_tmp SET 
					fechtrasl_gr='$txt_fecha_inicio_traslado',
					znaorig_gr='$txt_zona_origen',
					znadest_gr='$cmb_zona_destino',
					motivo_trasl_gr='$cmb_Motivo',
					ruc_transp_gr='$txt_ruc_transportista',
					descrip_transp_gr='$txt_denominacion_nom_ape',
					marca_placa_transp_gr='$txt_vehiculo_marca_placa',
					licen_conduc_transp_gr='$txt_licencia_conducir' 
					WHERE serie_gr='$serie_gr' AND numero_gr='$numero_gr' AND id_usr='$id_usr'";
					$actualizar_guia_remis_detalle_tmp=mysqli_query($Conexion,$cargar_datos);
					//Insertar un registro con todos los datos de la guia a la tabla guia_remis
					$cadena_insertar_gr="INSERT INTO guia_remis SET serie_gr='$serie_gr', numero_gr='$numero_gr', fechtrasl_gr='$txt_fecha_inicio_traslado', znaorig_gr='$txt_zona_origen', znadest_gr='$cmb_zona_destino', id_usr='$id_usr', motivo_trasl_gr='$cmb_Motivo', ruc_transp_gr='$txt_ruc_transportista', descrip_transp_gr='$txt_denominacion_nom_ape', marca_placa_transp_gr='$txt_vehiculo_marca_placa', licen_conduc_transp_gr='$txt_licencia_conducir', montotransf_gr=0";
					$insertar_guia_remision=mysqli_query($Conexion,$cadena_insertar_gr);
					$ultimo_id = mysqli_insert_id($Conexion);
					//Trasladar todos los registros de la tabla guia_remis_detalle_tmp a la tabla guia_remis_detalle
					$trasladar_tmp_a_detalle=mysqli_query($Conexion,"INSERT INTO guia_remis_detalle(id_gr, id_pro, cant_pro_gr, serie_gr, numero_gr, znaorig_gr, znadest_gr) SELECT '$ultimo_id', id_pro, cant_pro_gr, '$serie_gr', '$numero_gr', '$txt_zona_origen', '$cmb_zona_destino'  FROM guia_remis_detalle_tmp WHERE serie_gr='$serie_gr' AND numero_gr='$numero_gr' AND id_usr='$id_usr'");
					//Actualizar uso_sn de guia_remis_serie_numero a S (usado) en vez de N (no usado)
					$actualizar_guia_remis_serie_numero=mysqli_query($Conexion,"UPDATE guia_remis_serie_numero SET uso_sn='S' WHERE serie_gr='$serie_gr' AND numero_gr='$numero_gr' AND id_usr='$id_usr'");
					//Actualizar los productos trasladados en la guia de remision de la zona origen al destino
					actualizar_traslado_productos_de_origen_a_destino($Conexion,$txt_zona_origen,$cmb_zona_destino,$ultimo_id);
					echo "<script> window.open('../admin/guia_remision_imprimir.php?id=$ultimo_id', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
					echo "<script> location.href = 'guia_remision.php'; </script>"; 
				}
				else
				{
					mensaje("No se ha seleccionado ningun producto. No se puede registrar la Guía de Remisión");
					echo "<script> location.href = 'guia_remision.php'; </script>"; 
				}
				}
				else
				{
					mensaje("El usuario pertenece a un nivel distinto de acceso al sistema, y no cuenta con un almacen de productos registrados. No puede efectuar operaciones regulares con los productos del almacén.");
					redireccion("guia_remision.php");
				}
			}
			if($btn=="Cancelar")
			{
				echo "<script> location.href = 'guia_remision.php'; </script>"; 
			}
		}
		else
		{
			//Generar serie y numero de guia de remision si no hay boton Aceptar
			generar_serie_numero_gr($Conexion,$ident_usuario,$zona_usuario,$serie,$numero);
			guardar_guia_remis_serie_numero_tmp($Conexion,$ident_usuario,$serie,$numero);
			$serie_0000=substr("0000".$serie,-4);
			$numero_000000=substr("000000".$numero,-6);
			//Borra toda la tabla guia_remis_detalle_tmp
			mysqli_query($Conexion, "TRUNCATE TABLE guia_remis_detalle_tmp");
		}
		?>
		<div id="main-col2" style="width: 1310px;padding: 15px;margin-left:5px">
			<form name="usuario" action="" method="post" onsubmit="return verificar_datos();">
				<table border=1 style="width:80%; border-collapse:collapse; border-color:RGB(200,200,240);">
					<tr>
						<th style="width:50%;"> <?php 
							lblnorm($empresa["nomb_empe"],"");sl(0);
							lblnorm($empresa["direcc_empe"],""); ?>
						</th>
						<th style="width:50%;"> <?php 
							lblnorm("RUC N° ".$empresa["ruc_empe"],"");sl(0);
							lblnorm("GUIA DE REMISION","");sl(0);
							lblnorm($zona_usuario,""); sl(0);
							lblnorm($serie_0000." - ".$numero_000000,""); 
							txtoculto("txt_serie",$serie); txtoculto("txt_numero",$numero);?>
						</th>
					</tr>
					<tr>
						<td style="padding-left:5px;"><?php 
							lblnormExt("Fecha de inicio de traslado:","","",$st01);  txtvalue01("txt_fecha_inicio_traslado", $fecha_inicio, "", "date", "width:100px; height:20px;"); sl(0); 
							lblnormExt("Origen:","","",$st01); txtronstl("txt_zona_origen", $zona_usuario,"width:150px; height:20px;"); spc(3);
							lblnormExt("Destino:","","",$st01); cmbfieldJs("div_cmb_zona_destino","cmb_zona_destino",$Conexion,"SELECT id_zna, nomb_zna FROM zona WHERE activo_zna='S'","","onchange=\"actualz_dat_zna_dest('cmb_zona_destino')\";","id_zna","nomb_zna"); sl(0); 
							lblnormExt("Usuario: ","","",$st01); lblnorm($datos_usr,""); sl(0); ?>
						</td>
						<td style="padding-left:5px;"><?php
							lblnormExt("Punto de partida:","","",$st01); txtronstl("txt_punto_partida", $punto_partida, "width:325px; height:20px;"); sl(0);
							lblnormExt("Punto de llegada:","","",$st01); txtNrStJs("txt_punto_llegada","","text","","width:325px; height:20px;",""); sl(0);
							lblnormExt("Motivo del traslado:","","",$st01);
							cmbnormal("cmb_Motivo", "", "Traslado entre establecimiento de la misma empresa", "Devolucion"); sl(0); ?>
						</td>
					</tr>
				</table>
				
				<input type="button" value="Seleccionar producto" onclick="ventana_tipo01('guia_remision_generar.Seleccion.php','ventana1',80,60);"/>
				<input type="submit" name="btnGrl" value="Aceptar" />
				<input type="submit" name="btnGrl" value="Cancelar" onclick="estado_submit=false"/>
				<hr style="width:80%;" align="left"/>
				Datos de los productos transportados
				<div style="width:80%;" id="lista">
				</div>
				Datos del transportista
				<table border=1 class="tblreporte01" style="width:80%; border-collapse:collapse; border-color:RGB(200,200,240);">
					<tr>
						<th>RUC</th>
						<th>Denominacion/Apellidos y nombres</th>
						<th>Marca y placa</th>
						<th>Licencia conducir</th>
					</tr>
					<tr>
						<td><?php txtNrStJs("txt_ruc_transportista","","text","","width:100%; height:20px;",""); ?></td>
						<td><?php txtNrStJs("txt_denominacion_nom_ape","","text","","width:100%; height:20px;",""); ?></td>
						<td><?php txtNrStJs("txt_vehiculo_marca_placa","","text","","width:100%; height:20px;",""); ?></td>
						<td><?php txtNrStJs("txt_licencia_conducir","","text","","width:100%; height:20px;",""); ?></td>
					</tr>
				</table>
			</form>
		</div><br>
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function generar_serie_numero_gr($Conexion,$id_usuario,$zona_usuario,&$serie,&$numero)
{
	$consulta_serie_numero="SELECT serie_gr, numero_gr, id_usr, uso_sn FROM guia_remis_serie_numero WHERE id_usr='$id_usuario' ORDER BY serie_gr, numero_gr DESC LIMIT 1";
	$resultado_serie_numero=mysqli_query($Conexion,$consulta_serie_numero);
	if (mysqli_num_rows($resultado_serie_numero)>0)
	{
		$serie=valfield($Conexion,"zona","serie_zna","nomb_zna","'".$zona_usuario."'");
		$rs=mysqli_fetch_array($resultado_serie_numero,MYSQLI_ASSOC);
		$uso_sn=$rs["uso_sn"];
		$numero=$rs["numero_gr"];
		if ($uso_sn=="S")
		{
			$nuevo_numero=$numero+1;
			$insertar_serie_numero=mysqli_query($Conexion,"INSERT INTO guia_remis_serie_numero SET serie_gr='$serie', numero_gr='$nuevo_numero', id_usr='$id_usuario'");
			$numero=$nuevo_numero;
		}
	}
	else
	{
		$serie=valfield($Conexion,"zona","serie_zna","nomb_zna","'".$zona_usuario."'");
		$nuevo_numero=1;
		$insertar_serie_numero=mysqli_query($Conexion,"INSERT INTO guia_remis_serie_numero SET serie_gr='$serie', numero_gr='$nuevo_numero', id_usr='$id_usuario'");
		$numero=$nuevo_numero;
	}
}
function obtener_direccion_origen($Conexion,$zona_usuario,&$direccion_origen)
{
	$direccion_origen=valfield($Conexion,"zona","direc_zna","nomb_zna","'".$zona_usuario."'");
}
function guardar_guia_remis_serie_numero_tmp($Conexion,$id_usuario,$serie,$numero)
{
	$eliminar_registro=mysqli_query($Conexion,"DELETE FROM guia_remis_serie_numero_tmp WHERE id_usr='$id_usuario'");
	$insertar_registro=mysqli_query($Conexion,"INSERT INTO guia_remis_serie_numero_tmp SET serie_gr='$serie', numero_gr='$numero', id_usr='$id_usuario'");
}
function dato($dato)
{
	if (isset($_POST[$dato]))
		return $_POST[$dato];
	else
		return null;
}
function actualizar_traslado_productos_de_origen_a_destino($Conexion,$txt_zona_origen,$cmb_zona_destino,$ultimo_id)
{
	$consultar_guia_remis_detalle=mysqli_query($Conexion,"SELECT id_pro FROM guia_remis_detalle WHERE id_gr='$ultimo_id'");
	if (mysqli_num_rows($consultar_guia_remis_detalle)>0)
	{
		while($rs=mysqli_fetch_array($consultar_guia_remis_detalle,MYSQLI_ASSOC))
		{
			$id_pro=$rs["id_pro"];
			$actualizar_productos_con_datos_de_destino=mysqli_query($Conexion,"UPDATE productos SET zona_pro='$cmb_zona_destino' WHERE id_pro='$id_pro'");
			//echo "UPDATE productos SET zona_pro='$cmb_zona_destino' WHERE id_pro='$id_pro'"."<br>";
		}
	}
	else
	{
		mensaje("No se puede actualizar la lista de productos seleccionados con los datos del destino. Pongase en contacto con el Administrador del sistema para revisar esta situación.");
	}
}
function verificar_datos_guia_remis_detalle_tmp($Conexion,$serie_gr,$numero_gr,$id_usr)
{
	$consulta=mysqli_query($Conexion,"SELECT id_gr_tmp FROM guia_remis_detalle_tmp WHERE serie_gr='$serie_gr' AND numero_gr='$numero_gr' AND id_usr='$id_usr'");
	if (mysqli_num_rows($consulta)==0)
		return false;
	else
		return true;
}
function buscar_zona($Conexion,$zona)
{
	$buscar=mysqli_query($Conexion,"SELECT nomb_zna FROM zona WHERE nomb_zna='$zona'");
	if (mysqli_num_rows($buscar)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>