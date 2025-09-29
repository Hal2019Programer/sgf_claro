<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
//Librerias necesarias para la consulta de comprobantes de SUNAT
require_once './class/vendor/autoload.php';
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
// Datos necesarios para la consulta de comprobantes de SUNAT
$validez_consulta_estadoCDR=$codigo_estadoCDR=$mensaje_estadoCDR="";
$codigo_respuesta_CDR=$aceptado_respuesta_CDR=$descripcion_respuesta_CDR=$nombre_documento_respuesta_CDR="";
$notas_respuesta_CDR=array();
$codigo_resultado_error=$mensaje_resultado_error=$mensaje_busquedaCDR="";
$estado_de_consulta="existe";
$rucEmisor="20602109225";
//--------------------------------------------------------------
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ambito_busqueda="Normal";
$consulta_regvtacaja="
SELECT a.id_rvc, a.id_cli, a.fechaven_rvi, a.codcpg_rvi, a.formapago_rvi, a.rgpag_rvc, 
a.tipodoccp_rvi, a.seriecp_rvi, a.numcp_rvi,  a.importetot_rvi, a.zona_rvi, a.estado_rvc, 
a.cee_rvc, a.nombarch_rvc, a.ticketsunat_rvc, a.codigocdr_rvc, a.mensajecdr_rvc, 
IF(a.tipodoccp_rvi='Factura', 'Fact', 'B.V.') AS docum, 
CONCAT(a.seriecp_rvi,'-',a.numcp_rvi) AS numdoc, 
a.id_ncred, a.desc_ncred, a.codcdr_ncred, a.mensjcdr_ncred, a.numcorr_ncred, 
a.id_ndeb, a.desc_ndeb, a.codcdr_ndeb, a.mensjcdr_ndeb, a.numcorr_ndeb, 
b.nom_rzs_cli, b.dni_ruc_cli, CONCAT(a.id_cli,':',b.nom_rzs_cli) AS clie 
FROM regvtacaja a 
LEFT JOIN clientes b ON a.id_cli=b.id_cli 
WHERE 1";
$rc=new regvtacaja;
$consulta_filtro="";
$numreg=$v_cliente=$v_usuario=$v_usuario_anula=$dni_ruc_cliente=$id_tipdoc=$desc_tipdoc="";
$clave_id_rvi=0; $clave_id_rvi_notfound=0;
$var_std=$var_doc=$var_zna=$var_cee_rvc="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Comprobantes electrónicos",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
//Datos para cargar id de registro y buscar automaticamente
$variable_idLink="";
cargar_id_busqueda($variable_idLink);
//Datos para consulta de validez de comprobante
$mensaje=$mensaje_estadoCp=$mensaje_estadoRUC=$mensaje_condDomiRuc="";
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Comprobantes Electrónicos XML");?></head>
	<body>
		<div>
			<?php //cabecera02("Comprobantes Electrónicos XML"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Gestión de Comprobantes Electrónicos"); menu02(); sl(1);?>
				<!--<center><h1>Comprobantes Electrónicos XML</h1></center><hr>-->
				<?php
				$consulta_normal=$consulta_regvtacaja." ORDER BY a.id_rvc DESC LIMIT 100";
				$sql_regvtacaja=mysqli_query($Conexion,$consulta_normal) or die ("Error al traer los datos de regvtacaja.");
				date_default_timezone_set("America/Lima");
				if (empty($v_fechaven_rvi)) $v_fechaven_rvi=date("Y-m-d");
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"]; $bus=$_POST["txtbus"];
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							//Busqueda de datos en regvtacaja
							//-------------------------------------------------------------------------------------------------------------------------------
							$rc->consulta_registro_regvtacaja($rc,$Conexion,$bus,$filas);
							if($filas>0)
							{
								buscar_datos_cliente($Conexion, $rc->id_cli, $v_cliente, $dni_ruc_cliente, $desc_tipdoc);
								$rc->fechaemi_rvi=invFech($rc->fechaemi_rvi,"-");
								$rc->fechaven_rvi=invFech($rc->fechaven_rvi,"-");
								$v_usuario=valfield($Conexion,"usuarios","nomb_usr","id_usr",$rc->id_usr);
								$v_usuario_anula=valfield($Conexion,"usuarios","nomb_usr","id_usr",$rc->id_usr_anula);
								if ($rc->cee_rvc==1) echo "<script> alert('El registro indica que ya se emitió un archivo electrónico.'); </script>";
								// Consulta en servidor de SUNAT
								$tipoDocumento = $rc->tipodoccp_rvi;
								$serie = $rc->seriecp_rvi;
								$correlativo = $rc->numcp_rvi;
								convertir_serie_a_formato_SUNAT($tipoDocumento,$serie);
								if (!empty($tipoDocumento) AND !empty($serie) AND !empty($correlativo))
								{
									//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
									// consultar_CE_enviado_a_SUNAT($rucEmisor,$tipoDocumento,$serie,$correlativo, $validez_consulta_estadoCDR,$codigo_estadoCDR,$mensaje_estadoCDR,$codigo_respuesta_CDR,$aceptado_respuesta_CDR,$descripcion_respuesta_CDR,$nombre_documento_respuesta_CDR,$notas_respuesta_CDR, $codigo_resultado_error,$mensaje_resultado_error,$mensaje_busquedaCDR,$estado_de_consulta);
									
									$datos_comprobante=datos_de_comprobante($tipoDocumento,$serie,$correlativo,$rc->fechaemi_rvi,$rc->importetot_rvi);
									consulta_validez(obtener_token(),$datos_comprobante,$mensaje,$mensaje_estadoCp,$mensaje_estadoRUC,$mensaje_condDomiRuc);
								}
								else
								{
									mensaje("No existe los datos completos del comprobante electrónico para hacer la consulta.");
								}
								//Búsqueda de datos en regventas 
								//-------------------------------------------------------------------------------------------------------------------------------
								$sql_regventas=mysqli_query($Conexion,"SELECT * FROM regventas WHERE codcpg_rvi='$rc->codcpg_rvi' AND zona_rvi='$rc->zona_rvi' AND seriecp_rvi='$rc->seriecp_rvi' AND numcp_rvi='$rc->numcp_rvi'") or die ("Error al traer los datos de regventas.");
								if (mysqli_num_rows($sql_regventas)>0)
								{ $clave_id_rvi=1; mysqli_data_seek($sql_regventas, 0); }
								else
								{ $clave_id_rvi_notfound=1; echo "<script> alert('No se encuentran registros de ventas asociados al registro de ventas en caja'); </script>"; }
							}
							else
							{ echo "<script> alert('No se encuentra el registro'); </script>"; }
						}
						else
						{ echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'archivosXML.php'; </script>"; }
					}
					if($btn=="Filtrar")
					{
						$fechaini=$_POST["txtfchini"]; $fechaini=trim($fechaini);
						$fechafin=$_POST["txtfchfin"]; $fechafin=trim($fechafin); if (empty($fechaini)) { $v_fechaven_rvi=$fechafin; } else { $v_fechaven_rvi=$fechaini; }
						$documento=$_POST["cmbdoc"]; $documento=trim($documento);
						$serienumero=$_POST["txtsnm"]; $serienumero=trim($serienumero);
						$estado_reg=$_POST["cmbstd"];
						$emitido=$_POST["cmb_cee_rvc"];
						$zona=$_POST["cmbzna"];
						if (!empty($serienumero))
						{ 
							$divsernum=explode("-",$serienumero); 
							$serie=$divsernum[0]; 
							$numero=$divsernum[1];
						}
						else
						{ 
							$serie=$numero=""; 
						}
						$cad_busca_cualquiera="";
						if (empty($fechaini) AND empty($fechafin) AND empty($documento) AND empty($serienumero) AND empty($estado_reg) AND empty($emitido) AND empty($zona))
						{
							$consulta_filtro=$consulta_regvtacaja." ORDER BY a.id_rvc DESC LIMIT 100";
						}
						else
						{
							//Filtro de fechas: $fechaini y $fechafin
							if ($fechaini<>"" OR $fechafin<>"")
							{
								$var_fecha_ini_fin=comp_y_gener_fechas("fechaven_rvi",$fechaini,$fechafin); 
								//$var_fecha_ini_fin=substr($var_fecha_ini_fin,0,strlen($var_fecha_ini_fin)-1);
								$cad_busca_cualquiera=$cad_busca_cualquiera." ".$var_fecha_ini_fin; 
							}
							//Filtro de tipo de documentos: $documento
							if ($documento<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (a.tipodoccp_rvi LIKE '%$documento%') AND"; 
							}
							//Filtro de numero de documento: $serienumero = $serie y $numero
							if (!empty($serie) AND !empty($numero))
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (a.seriecp_rvi='$serie' AND a.numcp_rvi='$numero') AND";
							}
							//Filtro de estado de comprobante: $estado_reg (NULL/anulado)
							if ($estado_reg<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (a.estado_rvc LIKE '%$estado_reg%') AND";
							}
							//Filtro de comprobante emitido: $cee_rvc (0/1)
							if ($emitido<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (a.cee_rvc='$emitido') AND";
							}
							//Filtro de zona de comprobante: $zona
							if ($zona<>"")
							{
								$cad_busca_cualquiera=$cad_busca_cualquiera." (a.zona_rvi='$zona') AND";
							}
							$cad_busca_cualquiera=substr($cad_busca_cualquiera,1,strlen($cad_busca_cualquiera)-4);
							$consulta_filtro=$consulta_regvtacaja." AND ".$cad_busca_cualquiera;
						}
						$ambito_busqueda="Todo";
						if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente sin zona!"); }
						else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente con zona!"); }
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'archivosXML.php'; </script>";
					}
					//MODIFICADO POR JUAN (09-06-2019) PARA INCLUIR COMPROBANTE ELECTRONICO
					if($btn=="Enviar")
					{
						$id_rvc=$_POST["txt_id_rvc"];
						$tipoDocumento = $_POST["txt_v_tipodoccp_rvi"];
						$serie = $_POST["txt_v_seriecp_rvi"];
						$correlativo = $_POST["txt_v_numcp_rvi"];
						if (!empty($id_rvc))
						{
							$estado_de_cee_rvc = valfield($Conexion,"regvtacaja","cee_rvc","id_rvc",$id_rvc);
							if ($estado_de_cee_rvc<>'1')
							{
								//Verficar existencia de comprobante en SUNAT enviado anteriormente
								$existencia_de_comprobante_en_SUNAT = verificar_existencia_de_CDR_desde_SUNAT($rucEmisor, $tipoDocumento, $serie, $correlativo);
								if (empty($existencia_de_comprobante_en_SUNAT))
								{
									enviar_XML_manual_a_SUNAT($Conexion,$id_rvc);
								}
								else
								{
									mensaje("El comprobante ya se envío anteriormente y existe en el servidor de SUNAT. Si no esta registrado como emitido, use la opción 'Rehacer' para regenerar los registros de envío.");
								}
								//generar_PDF_manual($id_rvc);
							}
							else
							{
								mensaje("El comprobante electronico no se ha enviado porque ya existe el registro de haberse emitido anteriormente.");
							}
						}
						else
						{
							mensaje("No existen los datos completos del comprobante electrónico para enviarlo.");
						}
						echo "<script> location.href = 'archivosXML.php'; </script>";
					}
					if($btn=="Rehacer")
					{
						$id_rvc = $_POST["txt_id_rvc"];
						$tipoDocumento = $_POST["txt_v_tipodoccp_rvi"];
						$serie = $_POST["txt_v_seriecp_rvi"];
						$correlativo = $_POST["txt_v_numcp_rvi"];
						
						if (!empty($id_rvc) AND !empty($tipoDocumento) AND !empty($serie) AND !empty($correlativo))
						{
							$estado_de_cee_rvc = valfield($Conexion,"regvtacaja","cee_rvc","id_rvc",$id_rvc);
							if ($estado_de_cee_rvc<>'1')
							{
								$result = obtener_estado_de_CDR($rucEmisor, $tipoDocumento, $serie, $correlativo);
								if ($result->isSuccess())
								{
									$cdr = $result->getCdrResponse();
									if ($cdr === null)
									{
										$codigo_respuesta_CDR = "";
										$descripcion_respuesta_CDR = "CDR no encontrado, el comprobante no ha sido comunicado a SUNAT.";
										$nombre_documento_respuesta_CDR = "";
									}
									else
									{
										$codigo_respuesta_CDR = $cdr->getCode();
										$descripcion_respuesta_CDR = $cdr->getDescription();
										$nombre_documento_respuesta_CDR = $cdr->getId();
									}
									//Para guardar el CDR en un archivo se usa file_put_contents
									$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
									convertir_serie_a_formato_SUNAT($tipoDocumento, $serie);
									convertir_correlativo_a_formato_de_8_caracteres($correlativo);
									$nombrearchivo = $rucEmisor.'-'.$codigo_tipoDocumento.'-'.$serie.'-'.$correlativo;
									file_put_contents('../datasunat/'.'R-'.$rucEmisor.'-'.$codigo_tipoDocumento.'-'.$serie.'-'.$correlativo.'.zip', $result->getCdrZip());
									//Actualizar datos en la tabla regvtacaja
									$actualizar_regvtacaja="UPDATE regvtacaja SET cee_rvc=1, nombarch_rvc='$nombrearchivo', codigocdr_rvc='$codigo_respuesta_CDR', mensajecdr_rvc='$descripcion_respuesta_CDR' WHERE id_rvc='$id_rvc'";
									mysqli_query ($Conexion,$actualizar_regvtacaja) or die ("Error al actualizar tabla regvtacaja para datos de comprobantes emitidos a SUNAT.");
									echo "<script> alert('Se ha actualizado los registros de Ecositi con los datos del comprobante desde SUNAT.'); location.href = 'archivosXML.php'; </script>";
								}
								else
								{
									mensaje("No se pudo obtener el CDR desde el servidor de SUNAT. El comprobante no ha sido comunicado a SUNAT. Revíselo y envielo de nuevo para generar el CDR.");
								}
							}
							else
							{
								mensaje("El registro de comprobantes emitidos de Ecositi no se ha actualizado porque ya existe el registro.");
							}
						}
						else
						{
							echo "<script> alert('Los datos de tipo de documento, serie y numero están incompletos para el proceso de actualización de datos desde el servidor de SUNAT.'); location.href = 'archivosXML.php'; </script>";
						}
					}
				}
				?>
				<form name="comprobantelectronico" action="" method="post">
					<!-- Inicio de cuadros de texto para busqueda o filtro de datos --><?php
					busqueda_filtros_comprobante($v_fechaven_rvi,$var_doc,$var_std,$var_zna,$var_cee_rvc,$datos,$resultado_perfil_accesos,$Conexion); ?> <br><hr>
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg; ?>"/>
					<input type="hidden" name="txt_sql_regvtacaja" value="<?php echo $consulta_filtro; ?>"/>
					<!-- Presentación de datos encontrados del comprobante luego de la busqueda por Id -->
					<?php mostrar_reg_comprobante($rc,$v_cliente,$v_usuario,$v_usuario_anula,$datos,$resultado_perfil_accesos,$dni_ruc_cliente,$desc_tipdoc);
					//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
					// mostrar_resultado_consulta_CDR($rucEmisor, $validez_consulta_estadoCDR,$codigo_estadoCDR,$mensaje_estadoCDR,$codigo_respuesta_CDR,$aceptado_respuesta_CDR,$descripcion_respuesta_CDR,$nombre_documento_respuesta_CDR,$notas_respuesta_CDR, $codigo_resultado_error,$mensaje_resultado_error,$mensaje_busquedaCDR,$estado_de_consulta);
					mostrar_validez_de_consulta_de_comprobante($mensaje,$mensaje_estadoCp,$mensaje_estadoRUC,$mensaje_condDomiRuc);?>
					<div style="clear:both"></div><hr>
				</form>
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
							echo "<b>ULTIMOS 100 REGISTROS DE COMPROBANTES</b><br>";	
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
			</div>
			<div class="clr"></div>
			<div class="piepag"><?php pie_pagina();?></div>
		</div>
	</body>
</html>
<script language=JavaScript>
	function clear_textbox(objeto)
	{
		objeto.value = "";
	}
	function mostrar_datos_comprobante()
	{
		var tipodoccp_rvi = document.getElementsByName("txt_v_tipodoccp_rvi")[0].value;
		var desc_tipdoc = document.getElementsByName("txt_desc_tipdoc")[0].value;
		var datos_id_nombre_cliente = document.getElementsByName("txt_v_id_cli")[0].value;
		var datos_cliente = datos_id_nombre_cliente.split(":");
		var nomb_cliente = datos_cliente[1];
		var dni_ruc_cliente = document.getElementsByName("txt_dni_ruc_cliente")[0].value;
		var seriecp_rvi = document.getElementsByName("txt_v_seriecp_rvi")[0].value;
		var numcp_rvi = document.getElementsByName("txt_v_numcp_rvi")[0].value;
		var fechaemi_rvi = document.getElementsByName("txt_v_fechaemi_rvi")[0].value;
		var importetot_rvi = document.getElementsByName("txt_v_importetot_rvi")[0].value;
		if (tipodoccp_rvi=="Boleta de venta")
		{
			seriecp_rvi = "B"+ ("0000"+seriecp_rvi).substr(-3,3);
		}
		else
		{
			seriecp_rvi = "F"+ ("0000"+seriecp_rvi).substr(-3,3);
		}
		var cadena = "RUC del emisor: 20602109225 \n" + 
		"Tipo de comprobante: " + tipodoccp_rvi + "\n" + 
		"Nombre del receptor: " + nomb_cliente + "\n" +
		"Tipo de documento del receptor: " + desc_tipdoc + "\n" + 
		"Numero de documento del receptor: " + dni_ruc_cliente + "\n" + 
		"Numero del comprobante: " + seriecp_rvi + " - " + numcp_rvi + "\n" + 
		"Fecha de emision del comprobante: " + fechaemi_rvi + "\n" + 
		"Importe total del comprobante: " + importetot_rvi;
		alert(cadena);
	}
</script>
<?php

//--------------------------------------------------------------------------------------------------------------
function listar_comprobantes($Conexion,$sql_regvtacaja,$ambito_busqueda)
{
	tblanchovariable_03($Conexion,"margin-left:0px;","height:200px;",$sql_regvtacaja,"tblnormal",
	"ID:id_rvc:50:idLink|",
	"Fech.Vta.:fechaven_rvi:80:N",
	"Cód.Cpg.:codcpg_rvi:55:N",
	"Docs.:docum:40:N",
	"Num.Doc.:numdoc:70:N",
	"Impor.S/.:importetot_rvi:80:N",
	"Zona:zona_rvi:80:N",
	"Estado:estado_rvc:50:N",
	"Emitid.:cee_rvc:50:N",
	"Archiv.FE:nombarch_rvc:210:N",
	"Tck.SUNT:ticketsunat_rvc:60:N",
	"Cod.CDR:codigocdr_rvc:55:N",
	"Msg.CDR:mensajecdr_rvc:350:N",
	"Id.NC:id_ncred:35:N",
	"Desc.NC:desc_ncred:150:N",
	"Cod.CDR.NC:codcdr_ncred:75:N",
	"Msg.CDR.NC:mensjcdr_ncred:380:N",
	"Num.NC:numcorr_ncred:70:N");
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
function busqueda_filtros_comprobante($v_fechaven_rvi,$var_doc,$var_std,$var_zna,$var_cee_rvc,$datos,$resultado_perfil_accesos,$Conexion)
{
	lblnorm("Buscar ID:","etq5"); txtnrmstl("txtbus","width:50px;"); 
	if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); }
	if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } spc(5); sl(1);
	lblnorm("FECHAS:  Ini:","etq5"); txtvalue01("txtfchini",$v_fechaven_rvi,10,"date","width:100px;");
	// txtvalstl("txtfchini",$v_fechaven_rvi,10,"width:85px;");?>
	<input type="button" name=boton1 onclick=clear_textbox(this.form.txtfchini) value="X" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
	lblnorm("Fin:","etq5"); txtvalue01("txtfchfin",$v_fechaven_rvi,10,"date","width:100px;");
	// txtvalstl("txtfchfin",$v_fechaven_rvi,10,"width:85px;");?>
	<input type="button" name=boton2 onclick=clear_textbox(this.form.txtfchfin) value="X" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
	lblnorm("Docum.:","etq5"); cmbnormal("cmbdoc", $var_doc, "Boleta de venta", "Factura");
	lblnorm("Serie-numero:","etq5"); txtnrmstl("txtsnm","width:80px;");
	lblnorm("Estado:","etq5"); cmbnormal("cmbstd", $var_std, "anulado");
	lblnorm("Zona:","etq5"); 
	//cmbnormal("cmbzna", $var_zna, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
	cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zna,"","nomb_zna");
	lblnorm("Emitido:","etq5"); cmbnormal("cmb_cee_rvc", $var_cee_rvc, "1", "0");
	if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
}
function mostrar_reg_comprobante($rc,$v_cliente,$v_usuario,$v_usuario_anula,$datos,$resultado_perfil_accesos,$dni_ruc_cliente,$desc_tipdoc)
{ ?>
	<div>	<?php 
		echo "<b>REGISTRO DE COMPROBANTE</b>"; spc(16);
		lblnorm("ID:","etq14"); txtronstl("txt_id_rvc",$rc->id_rvc,"width:50px;");
		lblnorm("Cliente:","etq14"); txtronstl("txt_v_id_cli",$rc->id_cli.":".$v_cliente,"width:220px;"); txtoculto("txt_dni_ruc_cliente", $dni_ruc_cliente); txtoculto("txt_desc_tipdoc", $desc_tipdoc);
		lblnorm("Fecha emisión:","etq14"); txtronstl("txt_v_fechaemi_rvi",$rc->fechaemi_rvi,"width:75px;");
		lblnorm("Fecha venta:","etq14"); txtronstl("txt_v_fechaven_rvi",$rc->fechaven_rvi,"width:75px;");
		lblnorm("Cód.Pago:","etq14"); txtronstl("txt_v_codcpg_rvi", $rc->codcpg_rvi, "width:70px;");?>
		<input type="button" name=boton3 onclick=mostrar_datos_comprobante() value="CPE" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/>
	</div><hr>
	<div>
		<!--<div id="colizq2">-->
		<div style="float:left; width:26%;">
			<div> <?php 
				lblnorm("Documento:","etq4"); txtronstl("txt_v_tipodoccp_rvi", $rc->tipodoccp_rvi, "width:110px;");
				txtronstl("txt_v_seriecp_rvi", $rc->seriecp_rvi, "width:15px;"); echo "-";
				txtronstl("txt_v_numcp_rvi", $rc->numcp_rvi, "width:50px;");?>
			</div>
			<div><?php lblnorm("Descripción:","etq4"); txtronstl("txt_v_descrip_rvi", $rc->descrip_rvi, "width:220px;");?></div>
			<div><?php lblnorm("Forma pago:","etq4"); txtronstl("txt_v_formapago_rvi", $rc->formapago_rvi, "width:60px;");?></div>
			<div><?php lblnorm("Estado pago:","etq4"); txtronstl("txt_v_estado_rvc", $rc->rgpag_rvc, "width:50px;");?></div>
			<div><?php lblnorm("Zona:","etq4"); txtronstl("txt_v_zona_rvi", $rc->zona_rvi, "width:75px;");?></div>
		</div>
		<!--<div id="colcen2">-->
		<div style="float:left; width:13%;">
			<div><?php lblnorm("BIPG:","etq4"); txtronstl("txt_v_baseimpopgrv_rvi", $rc->baseimpopgrv_rvi, "width:60px;");?></div>
			<div><?php lblnorm("BIPNG:","etq4"); txtronstl("txt_v_baseimpopngrv_rvi", $rc->baseimpopngrv_rvi, "width:60px;");?></div>
			<div><?php lblnorm("ISC:","etq4"); txtronstl("txt_v_isc_rvi", $rc->isc_rvi, "width:60px;");?></div>
			<div><?php lblnorm("IGV:","etq4"); txtronstl("txt_v_igv_rvi", $rc->igv_rvi, "width:60px;");?></div>
			<div><?php lblnorm("Total:","etq4"); txtronstl("txt_v_importetot_rvi", $rc->importetot_rvi, "width:60px;");?></div>
		</div>
		<!--<div id="colder2">-->
		<div style="float:left; width:22%;">
			<div><?php lblnorm("Usuario Inicial:","etq2"); txtronstl("txt_v_id_usr", $rc->id_usr.":".$v_usuario, "width:130px;");?></div>
			<div><?php lblnorm("Estado:","etq2"); txtronstl("txt_v_estado_rvc", $rc->estado_rvc, "width:60px;");?></div>
			<div><?php lblnorm("Usuario Anulad.:","etq2"); txtronstl("txt_v_id_usr_anula", $rc->id_usr_anula.":".$v_usuario_anula, "width:130px;");?></div>
			<div><?php lblnorm("Causa Anulac.:","etq2"); txtronstl("txt_v_causanul_rvc", $rc->causanul_rvc, "width:75px;");?></div>
		</div>
		<!-- MODIFICADO POR JUAN (09-06-2019) PARA COMPROBANTE ELECTRONICO -->
		<div style="float:left; width:39%;">
			<div><?php lblnorm("Compr.Emitid.:","etq2"); txtronstl("txt_v_cee_rvc", $rc->cee_rvc, "width:50px;");?></div>
			<div><?php lblnorm("Archivo:","etq2"); txtronstl("txt_v_nombarch_rvc", $rc->nombarch_rvc, "width:230px;");?></div>
			<div><?php lblnorm("Codigo CDR:","etq2"); txtronstl("txt_v_codigocdr_rvc", $rc->codigocdr_rvc, "width:50px;");?></div>
			<div><?php lblnorm("Mensaje CDR:","etq2"); txtronstl("txt_v_mensajecdr_rvc", $rc->mensajecdr_rvc, "width:360px;");?></div>
			<div><?php lblnorm("Comprobante Electrónico:","etq5"); 
			if (activar_boton($datos,$resultado_perfil_accesos,"Enviar")) { btnnormal("btnGrl", "Enviar"); }
			//if (activar_boton($datos,$resultado_perfil_accesos,"Rehacer")) { btnnormal("btnGrl", "Rehacer"); } ?>
			</div>
		</div><div style="clear:both"></div><hr>
	</div> <?php
}
function mostrar_resultado_consulta_CDR($rucEmisor,$validez_consulta_estadoCDR,$codigo_estadoCDR,$mensaje_estadoCDR,$codigo_respuesta_CDR,$aceptado_respuesta_CDR,$descripcion_respuesta_CDR,$nombre_documento_respuesta_CDR,$notas_respuesta_CDR,
$codigo_resultado_error,$mensaje_resultado_error,$mensaje_busquedaCDR,$estado_de_consulta)
{
	if ($estado_de_consulta=="existe")
	{	
		verificar_nombre_documento_respuesta_CDR($rucEmisor,$nombre_documento_respuesta_CDR);?>
		<div style="float:left; width:22%;"> <?php
			echo "<b>Validez de consulta de estado de CDR: </b>".$validez_consulta_estadoCDR."<br>";
			echo "Codigo: ".$codigo_estadoCDR."<br>";
			echo "Descripcion: ".$mensaje_estadoCDR."<br>";?>
		</div>
		<div style="float:left; width:42%;"><?php
			echo "<b>Codigo de proceso de CDR: </b>".$codigo_respuesta_CDR."<br>";
			echo "Estado aceptado o no del CDR: ".$aceptado_respuesta_CDR."<br>";
			echo "Descripcion de respuesta de CDR: ".$descripcion_respuesta_CDR."<br>";?>
		</div>
		<div style="float:left; width:30%; background-color=RGB(100,100,50);"><?php
			echo "Nombre del documento de CDR: ".$nombre_documento_respuesta_CDR."<br>";
			echo "Notas de la respuesta del CDR: ".implode(" ", $notas_respuesta_CDR);?>
		</div> <?php
	}
	else
	{
		echo "<b>Error al consultar estado de CDR:</b>"." Codigo de error ".$codigo_resultado_error; sl(1);
		if ($codigo_resultado_error=="0127")
		{
			$mensaje_resultado_error="El ticket no existe.";
		}
		echo "Descripcion de error: ".$mensaje_resultado_error; sl(1);
		echo "Mensaje de error: ".$mensaje_busquedaCDR; sl(1);
		return;
	}
}
function consultar_CE_enviado_a_SUNAT($rucEmisor,$tipoDocumento,$serie,$correlativo,
&$validez_consulta_estadoCDR,&$codigo_estadoCDR,&$mensaje_estadoCDR,&$codigo_respuesta_CDR,&$aceptado_respuesta_CDR,&$descripcion_respuesta_CDR,&$nombre_documento_respuesta_CDR,&$notas_respuesta_CDR,
&$codigo_resultado_error,&$mensaje_resultado_error,&$mensaje_busquedaCDR,&$estado_de_consulta)
{
	if (!empty($tipoDocumento) AND !empty($serie) AND !empty($correlativo))
	{
		//RUC de Ecositi
		$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
		// URL CDR de Producción
		$wsdlUrl = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
		$soap = new SoapClient($wsdlUrl);
		$soap->setCredentials('10413437186USUARIO2', 'Heli2025');
		//Consulta al servicio de CDR
		$service = new ConsultCdrService(); //Crea la consulta del CDR
		$service->setClient($soap); //Establece el servicio SOAP
		//Obtiene el estado del CDR del comprobante
		$result = $service->getStatusCdr($rucEmisor, $codigo_tipoDocumento, $serie, $correlativo);
		//Si el resultado de la consulta es valido se continua el proceso, de lo contrario se muestra el error
		if ($result->isSuccess())
		{
			//Se carga los datos de la consulta de estado del CDR
			$validez_consulta_estadoCDR = $result->isSuccess();//true/false
			$codigo_estadoCDR = $result->getCode();
			$mensaje_estadoCDR = $result->getMessage();
			//Se obtiene los datos del CDR
			$cdr = $result->getCdrResponse();
			//Si el CDR existe se continua el proceso, sino se muestra el mensaje indicado
			if ($cdr === null)
			{
				//echo 'CDR no encontrado, el comprobante no ha sido comunicado a SUNAT.';
				//return;
				$codigo_respuesta_CDR = "";
				$aceptado_respuesta_CDR = "";
				$descripcion_respuesta_CDR = "CDR no encontrado, el comprobante no ha sido comunicado a SUNAT.";
				$nombre_documento_respuesta_CDR = "";
				$notas_respuesta_CDR = [];
			}
			else
			{
				//Se carga los datos de la consulta del archivo CDR
				$codigo_respuesta_CDR = $cdr->getCode(); //0 = Proceso correctamente, 98 = En proceso, 99 = Proceso con errores
				$aceptado_respuesta_CDR = $cdr->isAccepted();//true/false
				$descripcion_respuesta_CDR = $cdr->getDescription();
				$nombre_documento_respuesta_CDR = $cdr->getId();
				$notas_respuesta_CDR = $cdr->getNotes();//array	
			}
			$estado_de_consulta="existe";
		}
		else
		{
			$resultado_error=$result->getError();
			$codigo_resultado_error=$resultado_error->getCode();
			$mensaje_resultado_error=$resultado_error->getMessage();
			//var_dump($result->getError());
			//0127	El ticket no existe
			$resultado_de_error=true;
			$cdr = $result->getCdrResponse();
			//Si el CDR existe se continua el proceso, sino se muestra el mensaje indicado
			if ($cdr === null)
			{
				$mensaje_busquedaCDR = 'CDR no encontrado, el comprobante no ha sido comunicado a SUNAT.';
			}
			$estado_de_consulta="noExiste";
		}
	}
	else
	{
		echo "<script> alert('Los datos de tipo de documento, serie y numero están incompletos.'); location.href = 'regventas.php'; </script>";
	}
}
function convertir_correlativo_a_formato_de_8_caracteres(&$correlativo)
{
	$correlativo = substr("00000000".$correlativo, -8);
}
function verificar_nombre_documento_respuesta_CDR($rucEmisor,&$nombre_documento_respuesta_CDR)
{
	if (!empty($nombre_documento_respuesta_CDR))
	{ 
		$ruc_de_nombre_documento_respuesta_CDR = substr($nombre_documento_respuesta_CDR,0,11);
		if ($ruc_de_nombre_documento_respuesta_CDR!=$rucEmisor)
		{
			$nombre_documento_respuesta_CDR = $rucEmisor."-".$nombre_documento_respuesta_CDR; 
		}
	}
}
function verificar_existencia_de_CDR_desde_SUNAT($rucEmisor, $tipoDocumento, $serie, $correlativo)
{
	if (!empty($tipoDocumento) AND !empty($serie) AND !empty($correlativo))
	{
		$result = obtener_estado_de_CDR($rucEmisor, $tipoDocumento, $serie, $correlativo);
		if ($result->isSuccess())
		{
			$cdr = $result->getCdrResponse();
			if ($cdr === null)
			{
				$aceptado_respuesta_CDR = "";
			}
			else
			{
				$aceptado_respuesta_CDR = $cdr->isAccepted();
			}
		}
	}
	return $aceptado_respuesta_CDR;
}
function obtener_estado_de_CDR($rucEmisor, $tipoDocumento, $serie, $correlativo)
{
	$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
	convertir_serie_a_formato_SUNAT($tipoDocumento, $serie);
	$wsdlUrl = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
	$soap = new SoapClient($wsdlUrl);
	$soap->setCredentials('10413437186USUARIO2', 'Heli2025');
	$service = new ConsultCdrService();
	$service->setClient($soap);
	$result = $service->getStatusCdr($rucEmisor, $codigo_tipoDocumento, $serie, $correlativo);
	return $result;
}
function buscar_datos_cliente($Conexion, $id_cli, &$v_cliente, &$dni_ruc_cliente, &$desc_tipdoc)
{
	$consulta_datos_cliente = mysqli_query($Conexion,"SELECT a.id_cli, a.nom_rzs_cli, a.dni_ruc_cli, a.id_tipdoc, b.desc_tipdoc FROM clientes a LEFT JOIN tipodocident b ON a.id_tipdoc=b.id_tipdoc WHERE a.id_cli=$id_cli") or die ("Error al traer los datos de cliente y tipo de documento de cliente."); 
	mysqli_data_seek($consulta_datos_cliente, 0);
	$resultado = mysqli_fetch_array($consulta_datos_cliente, MYSQLI_ASSOC);
	$v_cliente = $resultado["nom_rzs_cli"];
	$dni_ruc_cliente = $resultado["dni_ruc_cli"];
	$desc_tipdoc = $resultado["desc_tipdoc"];
}
function cargar_id_busqueda(&$variable_idLink)
{
	if (isset($_GET["id"]))
	{ 
		$variable_idLink=$_GET["id"];
		if (!isset($_POST["btnGrl"]))
		{
			$_POST["btnGrl"]="Buscar";
			$_POST["txtbus"]=$variable_idLink;
		}
	} 
	else 
	{ 
		$variable_idLink="";
	}
}
function mostrar_validez_de_consulta_de_comprobante($mensaje,$mensaje_estadoCp,$mensaje_estadoRUC,$mensaje_condDomiRuc)
{ 
	$extension_msj_estadoCP=extension_msj_estadoCp($mensaje_estadoCp); ?>
	<div style="float:left; width:40%;"> <?php
		echo "<b>Validez de consulta de comprobante: </b><br>";
		echo "Operacion: ".$mensaje."<br>";
		echo "Estado del comprobante: ".$mensaje_estadoCp." (".$extension_msj_estadoCP.")<br>";?>
	</div>
	<div style="float:left; width:40%;"><?php
		echo "<br>";
		echo "Estado del contribuyente: ".$mensaje_estadoRUC."<br>";
		echo "Condicion del domicilio: ".$mensaje_condDomiRuc."<br>";?>
	</div> <?php
}
?>