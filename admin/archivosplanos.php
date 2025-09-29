<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$v_id_rvc=$v_id_cli=$v_tipopla_rvi=$v_id_pla=$v_fechaemi_rvi=$v_fechaven_rvi=$v_codcpg_rvi=$v_tipodoccp_rvi="";
$v_seriecp_rvi=$v_numcp_rvi=$v_descrip_rvi=$v_formapago_rvi=$v_baseimpopgrv_rvi=$v_baseimpopngrv_rvi=$v_isc_rvi="";
$v_igv_rvi=$v_importetot_rvi=$v_id_usr=$v_rgpag_rvc=$v_zona_rvi=$v_estado_rvc=$v_fechapag_rvc=$v_id_usr_anula=$v_causanul_rvc="";
$ambito_busqueda="Normal";
$consulta_regvtacaja="
SELECT regvtacaja.id_rvc, regvtacaja.id_cli, regvtacaja.tipopla_rvi, regvtacaja.id_pla, regvtacaja.fechaemi_rvi, 
regvtacaja.fechaven_rvi, regvtacaja.codcpg_rvi, regvtacaja.tipodoccp_rvi, regvtacaja.seriecp_rvi, regvtacaja.numcp_rvi, 
regvtacaja.descrip_rvi, regvtacaja.formapago_rvi, regvtacaja.baseimpopgrv_rvi, regvtacaja.baseimpopngrv_rvi, regvtacaja.isc_rvi, 
regvtacaja.igv_rvi, regvtacaja.importetot_rvi, regvtacaja.id_usr, regvtacaja.rgpag_rvc, regvtacaja.zona_rvi, regvtacaja.estado_rvc, 
regvtacaja.fechapag_rvc, regvtacaja.id_usr_anula, regvtacaja.causanul_rvc, regvtacaja.cee_rvc, clientes.nom_rzs_cli, clientes.dni_ruc_cli, 
CONCAT(regvtacaja.id_cli,':',clientes.nom_rzs_cli) AS clie, clientes.nom_rzs_cli AS nombre_cliente, clientes.dni_ruc_cli AS dniruc_cliente, 
CONCAT(regvtacaja.id_pla,':',planes.abrv_pla) AS plan 
FROM regvtacaja 
LEFT JOIN clientes ON regvtacaja.id_cli=clientes.id_cli 
LEFT JOIN planes ON regvtacaja.id_pla=planes.id_pla 
WHERE 1";
$rc=new regvtacaja;
$consulta_busqueda=$consulta_filtro="";
$numreg=$v_cliente=$v_usuario=$v_usuario_anula=$v_cee_rvc="";
$clave_id_rvi=0; $clave_id_rvi_notfound=0;
$var_usua_ini=$var_usua_anl=$var_std=$var_canl=$var_zna="";

?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Comprobantes Electrónicos");?></head>
	<body>
		<div style="color:#0A2C4F" >
			<?php cabecera02("Anular comprobantes de pago"); menu02();?>
			<div id="main-col2" style="width: 1310px;padding: 15px;margin-left:5px">
				<center style="font-size:25px;"><b>Comprobantes Electrónicos</b></center><br>
				<?php
				$consulta_normal=$consulta_regvtacaja;
				$sql_regvtacaja=mysqli_query($Conexion,$consulta_normal) or die ("Error al traer los datos de regvtacaja"); 
				if (empty($v_fechaven_rvi)) $v_fechaven_rvi=date("d-m-Y");
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"]; 	$bus=$_POST["txtbus"];
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							//Busqueda de datos en regvtacaja
							//-------------------------------------------------------------------------------------------------------------------------------
							$rc->consulta_registro_regvtacaja($rc,$Conexion,$bus,$filas);
							if($filas>0)
							{
								$v_cliente=valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$rc->id_cli);
								$rc->fechaemi_rvi=invFech($rc->fechaemi_rvi,"-");
								$rc->fechaven_rvi=invFech($rc->fechaven_rvi,"-");
								$v_usuario=valfield($Conexion,"usuarios","nomb_usr","id_usr",$rc->id_usr);
								$v_usuario_anula=valfield($Conexion,"usuarios","nomb_usr","id_usr",$rc->id_usr_anula);
								if ($rc->cee_rvc==1) echo "<script> alert('El registro indica que ya se emitió un archivo electrónico.'); </script>";
								//Búsqueda de datos en regventas 
								//-------------------------------------------------------------------------------------------------------------------------------
								$sql_regventas=mysqli_query($Conexion,"SELECT * FROM regventas WHERE codcpg_rvi='$rc->codcpg_rvi' AND zona_rvi='$rc->zona_rvi' AND seriecp_rvi='$rc->seriecp_rvi' AND numcp_rvi='$rc->numcp_rvi'") or die ("Error al traer los datos de regvtacaja");
								if (mysqli_num_rows($sql_regventas)>0)
								{ $clave_id_rvi=1; mysqli_data_seek($sql_regventas, 0); }
								else
								{ $clave_id_rvi_notfound=1; echo "<script> alert('No se encuentran registros de ventas asociados al registro de ventas en caja'); </script>"; }
							}
							else
							{ echo "<script> alert('No se encuentra el registro'); </script>"; }
						}
						else
						{ echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'archivosplanos.php'; </script>"; }
					}
					if($btn=="Filtrar")
					{
						$cliente=$_POST["txtcli"]; $cliente=trim($cliente);
						$fechaini=$_POST["txtfchini"]; $fechaini=trim($fechaini); if ($fechaini<>"") $fechaini=invFech($fechaini,"-");
						$fechafin=$_POST["txtfchfin"]; $fechafin=trim($fechafin); if ($fechafin<>"") $fechafin=invFech($fechafin,"-");
						$documento=$_POST["txtdoc"]; $documento=trim($documento);
						$serienumero=$_POST["txtsnm"]; $serienumero=trim($serienumero);
						$estado_reg=$_POST["cmbstd"];
						$zona=$_POST["cmbzna"];
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
						if (empty($cliente) AND empty($fechaini) AND empty($fechafin) AND empty($documento) AND empty($serienumero) AND empty($estado_reg) AND empty($zona))
						{
							$cad_busca_cualquiera=" 1";
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
							if ($documento<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.tipodoccp_rvi LIKE '%$documento%') AND"; 
							}
							if (!empty($serie) AND !empty($numero))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.seriecp_rvi=$serie AND (regvtacaja.numcp_rvi LIKE '%$numero%')) AND";
							}
							if ($estado_reg<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.estado_rvc LIKE '%$estado_reg%') AND";
							}
							if ($zona<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (regvtacaja.zona_rvi='$zona') AND";
							}
							$cad_busca_cualquiera=substr($cad_busca_cualquiera,1,strlen($cad_busca_cualquiera)-4);
						}
						$ambito_busqueda="Todo";
						$consulta_filtro=$consulta_regvtacaja." AND ".$cad_busca_cualquiera;
						if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_regvtacaja." AND ".$cad_busca_cualquiera) or die ("Error al filtrar al cliente sin zona!"); }
						else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_regvtacaja." AND".$cad_busca_cualquiera) or die ("Error al filtrar al cliente con zona!"); }
					}
					//------------------------------------------------- Generar Archivo -------------------------------------------------
					if($btn=="Generar Archivo")
					{
						if (ruta_existe("../datasunat/"))
						{
							$id_rvc=$_POST["txt_id_rvc"];
							if (comprob_emitido($Conexion,$id_rvc)==0)
							{
								$resultado_generar_comprobelect=generar_archivos_sunat($Conexion,$id_rvc,$nombrearchivo);
								if ($resultado_generar_comprobelect=="1")
								{
									mysqli_query($Conexion,"UPDATE regvtacaja SET cee_rvc=1, nombarch_rvc='$nombrearchivo' WHERE id_rvc='$id_rvc'") or die("Error al actualizar cee_rvc y nombarch_rvc en regvatcaja");
								}
							}
							else
							{
								echo "<script> alert('Este comprobante ya se registro como Comprobante Electronico emitido. Verifique esta condición.'); </script>";
							}
						}
						else
						{
							echo "<script> alert('No se encontró la ruta del Facturador Electrónico. No se generó el comprobante electrónico. Revise la configuración del Facturador Electronico SFS.'); </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'archivosplanos.php'; </script>";
					}
				}
				?>
				<form name="comprobantelectronico" action="" method="post"><!-- Inicio de formulario -->
				<!-- Inicio de cuadros de texto para busqueda o filtro de datos -->
					<?php 
						lblnorm("Buscar ID:","etq4"); txtnrmstl("txtbus","width:50px;"); btnnormal("btnGrl", "Buscar");echo "<br>";
						lblnorm("Buscar cliente:","etq5"); txtnrmstl("txtcli","width:140px;");
						lblnorm("Fecha Ini.:","etq5"); txtvalstl("txtfchini",$v_fechaven_rvi,10,"width:85px;");?><input type="button" name=boton1 onclick=clear_textbox(this.form.txtfchini) value="X" style="border-radius:5px; height:17px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
						lblnorm("Fecha Fin.:","etq5"); txtvalstl("txtfchfin",$v_fechaven_rvi,10,"width:85px;");?><input type="button" name=boton2 onclick=clear_textbox(this.form.txtfchfin) value="X" style="border-radius:5px; height:17px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
						lblnorm("Docum.:","etq5"); txtnrmstl("txtdoc","width:110px;");
						lblnorm("Serie-numero:","etq5"); txtnrmstl("txtsnm","width:80px;");
						lblnorm("Estado:","etq5"); cmbnormal("cmbstd", $var_std, "anulado");
						lblnorm("Zona:","etq5"); cmbnormal("cmbzna", $var_zna, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
						btnnormal("btnGrl", "Filtrar");
					?>
					<br><hr>
					<!-- Presentación de datos encontrados luego de la busqueda o filtro de datos -->
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg; ?>"/>
					<input type="hidden" name="txt_sql_regvtacaja" value="<?php echo $consulta_filtro; ?>"/>
					<div>
						<?php echo "<b>REGISTRO DE CAJA</b><br><hr>"; ?>
						<?php lblnorm("ID:","etq14"); txtronstl("txt_id_rvc",$rc->id_rvc,"width:40px;");?>
						<?php lblnorm("Cliente:","etq14"); txtronstl("txt_v_id_cli",$rc->id_cli.":".$v_cliente,"width:220px;");?>
						<?php lblnorm("Fecha emisión:","etq14"); txtronstl("txt_v_fechaemi_rvi",$rc->fechaemi_rvi,"width:70px;");?>
						<?php lblnorm("Fecha venta:","etq14"); txtronstl("txt_v_fechaven_rvi",$rc->fechaven_rvi,"width:70px;");?>
						<?php lblnorm("Cód.Pago:","etq14"); txtronstl("txt_v_codcpg_rvi", $rc->codcpg_rvi, "width:70px;");?>
					</div><hr>
					<div>
					<div id="colizq2">
						<div>
							<?php lblnorm("Documento:","etq4"); txtronstl("txt_v_tipodoccp_rvi", $rc->tipodoccp_rvi, "width:110px;");?>
							<?php txtronstl("txt_v_seriecp_rvi", $rc->seriecp_rvi, "width:15px;"); echo "-";?>
							<?php txtronstl("txt_v_numcp_rvi", $rc->numcp_rvi, "width:50px;");?>
						</div>
						<div><?php lblnorm("Descripción:","etq4"); txtronstl("txt_v_descrip_rvi", $rc->descrip_rvi, "width:220px;");?></div>
						<div><?php lblnorm("Forma pago:","etq4"); txtronstl("txt_v_formapago_rvi", $rc->formapago_rvi, "width:50px;");?></div>
						<div><?php lblnorm("Estado pago:","etq4"); txtronstl("txt_v_estado_rvc", $rc->estado_rvc, "width:50px;");?></div>
						<div><?php lblnorm("Compr.Emitid.:","etq4"); txtronstl("txt_v_cee_rvc", $rc->cee_rvc, "width:50px;");?></div>
					</div>
					<div id="colcen2">
						<div><?php lblnorm("BIPG:","etq2"); txtronstl("txt_v_baseimpopgrv_rvi", $rc->baseimpopgrv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("BIPNG:","etq2"); txtronstl("txt_v_baseimpopngrv_rvi", $rc->baseimpopngrv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("ISC:","etq2"); txtronstl("txt_v_isc_rvi", $rc->isc_rvi, "width:60px;");?></div>
						<div><?php lblnorm("IGV:","etq2"); txtronstl("txt_v_igv_rvi", $rc->igv_rvi, "width:60px;");?></div>
						<div><?php lblnorm("Importe Total:","etq2"); txtronstl("txt_v_importetot_rvi", $rc->importetot_rvi, "width:60px;");?></div>
					</div>
					<div id="colder2">
						<div><?php lblnorm("Estado:","etq2"); txtronstl("txt_v_estado_rvc", $rc->estado_rvc, "width:50px;");?></div>
						<div><?php lblnorm("Usuario Inicial:","etq2"); txtronstl("txt_v_id_usr", $rc->id_usr.":".$v_usuario, "width:130px;");?></div>
						<div><?php lblnorm("Zona:","etq2"); txtronstl("txt_v_zona_rvi", $rc->zona_rvi, "width:65px;");?></div>
						<div><?php lblnorm("Usuario Anulad.:","etq2"); txtronstl("txt_v_id_usr_anula", $rc->id_usr_anula.":".$v_usuario_anula, "width:130px;");?></div>
						<div><?php lblnorm("Causa Anulac.:","etq2"); txtronstl("txt_v_causanul_rvc", $rc->causanul_rvc, "width:65px;");?></div>
						
					</div>
					</div>
					<div style="clear:both"></div>
					<hr>
					<input type="submit" name="btnGrl" value="Generar Archivo"/>
					<input type="submit" name="btnGrl" value="Actualizar"/>
					<br><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario en una tabla ajustada a la medida de los datos -->
				<?php
				if($clave_id_rvi==1)
				{
					//Lista de datos de registro de ventas cuando se encuentran asociados a los datos de registro de caja
					echo "<b>REGISTROS DE DETALLE DEL COMPROBANTE</b><br>";
					listar_detalle_comprobante($Conexion,$sql_regventas);
				}
				else
				{
					if ($clave_id_rvi_notfound==1)
					{
						echo "NO HAY REGISTRO DE DETALLE ASOCIADOS AL REGISTRO DE COMPROBANTE.<BR>";
					}
					else
					{
						if ($ambito_busqueda=="Normal")
						{
							//Lista de los ultimos 10 datos de registro de caja
							echo "<b>ULTIMOS 10 REGISTROS DE COMPROBANTES</b><br>";	
						}
						else
						{
							//Lista de registroS de caja
							$filas=mysqli_num_rows($sql_regvtacaja);
							echo "<b>LISTA DE REGISTROS DE COMPROBANTES FILTRADOS ($filas)</b><br>";	
						}
						listar_comprobantes($Conexion,$sql_regvtacaja,$ambito_busqueda);
					}					
				}
				scroll_doble("div1","div2"); // Usado para mover en simultaneo la cabecera y los datos de la lista de la tabla
				?>
				<!-- Fin de listado de datos de usuario -->
			</div><!--Fin de main-col-->
			<div class="clr"></div>
			<?php pie_pagina();?><!--Pie de página (footer)-->
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

//--------------------------------------------------------------------------------------------------------------
function listar_comprobantes($Conexion,$sql_regvtacaja,$ambito_busqueda)
{
	tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql_regvtacaja,"tblnormal",$ambito_busqueda,
	"ID:id_rvc:50:N",
	"Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
	"Fech.Vta.:fechaven_rvi:80:N",
	"Cód.Cpg.:codcpg_rvi:55:N",
	"TipoPago:formapago_rvi:65:N",
	"Estad.Pago:rgpag_rvc:70:N",
	"Docum.:tipodoccp_rvi:105:N",
	"Serie:seriecp_rvi:40:N",
	"Número:numcp_rvi:60:N",
	"Descripción:descrip_rvi:200:N",
	"Importe S/.:importetot_rvi:80:N",
	"Zona:zona_rvi:80:N",
	"Estado:estado_rvc:60:N",
	"Emit.CE.:cee_rvc:80:N");
}
function listar_detalle_comprobante($Conexion,$sql_regventas)
{
	tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql_regventas,"tblnormal","Todo",
	"ID:id_rvi:50:N",
	"Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
	"Productos:id_pro:200:valfield|productos|abrv_pro|id_pro",
	"Fech.Vta.:fechaven_rvi:80:N",
	"Cód.Cpg.:codcpg_rvi:55:N",
	"Docum.:tipodoccp_rvi:95:N",
	"Serie:seriecp_rvi:35:N",
	"Número:numcp_rvi:60:N",
	"Importe S/.:importetot_rvi:75:N",
	"Descripción:descrip_rvi:200:N",
	"Zona:zona_rvi:80:N",
	"Usuario:id_usr:100:valfield|usuarios|nomb_usr|id_usr");
}
?>