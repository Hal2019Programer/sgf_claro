<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
//Librerias necesarias para la consulta de comprobantes de SUNAT
require_once './class/vendor/autoload.php';
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
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
b.nom_rzs_cli, b.dni_ruc_cli, CONCAT(a.id_cli,':',b.nom_rzs_cli) AS clie, 
CONCAT(a.tipodoccp_rvi,'-',a.seriecp_rvi,'-',a.numcp_rvi) AS comprobante 
FROM regvtacaja a 
LEFT JOIN clientes b ON a.id_cli=b.id_cli 
WHERE 1";
$rc=new regvtacaja;
$consulta_filtro="";
$numreg=$v_cliente="";
$clave_id_rvi=0; $clave_id_rvi_notfound=0;
$var_std=$var_doc=$var_zna=$var_cee_rvc="";
$validez_consulta=$codigo_estado=$mensaje_estado="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Comprobantes enviados a SUNAT",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Comprobantes Electrónicos XML");?></head>
	<body>
		<div>
			<?php //cabecera02("Comprobantes Electrónicos XML"); menu02();?>
			<div style="width:1310px;"><hr>
				<?php cabecera04(0,"Comprobantes Enviados a SUNAT Válidos/No Válidos"); menu02(); sl(1);?>
				<!--<center><h1>Comprobantes Electrónicos Válidos/No Válidos</h1></center><hr>-->
				<?php
				$consulta_normal=$consulta_regvtacaja." ORDER BY a.id_rvc DESC LIMIT 5";
				$sql_regvtacaja=mysqli_query($Conexion,$consulta_normal) or die ("Error al traer los datos de regvtacaja.");
				date_default_timezone_set("America/Lima");
				if (empty($v_fechaven_rvi)) $v_fechaven_rvi=date("d-m-Y");
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"]; $bus=$_POST["txtbus"];
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$rc->consulta_registro_regvtacaja($rc,$Conexion,$bus,$filas);
							if($filas>0)
							{
								$v_cliente=valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$rc->id_cli);
								$rc->fechaemi_rvi=invFech($rc->fechaemi_rvi,"-");
								$rc->fechaven_rvi=invFech($rc->fechaven_rvi,"-");
								// Consulta en servidor de SUNAT
								$tipoDocumento = $rc->tipodoccp_rvi;
								$serie = $rc->seriecp_rvi;
								$correlativo = $rc->numcp_rvi;
								if (!empty($tipoDocumento) AND !empty($serie) AND !empty($correlativo))
								{
									obtener_datos_de_estado_de_CDR($rucEmisor, $tipoDocumento, $serie, $correlativo, $validez_consulta, $codigo_estado, $mensaje_estado);
								}
								else
								{
									mensaje("No existe los datos completos del comprobante electrónico para hacer la consulta.");
								}
							}
							else
							{ echo "<script> alert('No se encuentra el registro'); </script>"; }
						}
						else
						{ echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'comprobantes_enviados_a_SUNAT.php'; </script>"; }
					}
					if($btn=="Filtrar")
					{
						$fechaini=$_POST["txtfchini"]; $fechaini=trim($fechaini); if ($fechaini<>"") $fechaini=invFech($fechaini,"-");
						$fechafin=$_POST["txtfchfin"]; $fechafin=trim($fechafin); if ($fechafin<>"") $fechafin=invFech($fechafin,"-");
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
							$consulta_filtro=$consulta_regvtacaja." ORDER BY a.id_rvc DESC LIMIT 5";
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
						//$consulta_filtro=$consulta_regvtacaja." AND ".$cad_busca_cualquiera;
						//if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_regvtacaja." AND ".$cad_busca_cualquiera) or die ("Error al filtrar al cliente sin zona!"); } 
						//else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_regvtacaja." AND".$cad_busca_cualquiera) or die ("Error al filtrar al cliente con zona!"); }
						if ($zona_usuario=="Total") { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente sin zona!"); } 
						else { $sql_regvtacaja= mysqli_query ($Conexion,$consulta_filtro) or die ("Error al filtrar al cliente con zona!"); }
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'comprobantes_enviados_a_SUNAT.php'; </script>";
					}
				}
				?>
				<form name="comprobantelectronico" action="" method="post">
					<!-- Inicio de cuadros de texto para busqueda o filtro de datos --><?php
					busqueda_filtros_comprobante($v_fechaven_rvi,$var_doc,$var_std,$var_zna,$var_cee_rvc,$datos,$resultado_perfil_accesos,$Conexion); ?> <br><hr>
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg; ?>"/>
					<input type="hidden" name="txt_sql_regvtacaja" value="<?php echo $consulta_filtro; ?>"/>
					<!-- Presentación de datos encontrados del comprobante luego de la busqueda por Id -->
					<?php mostrar_reg_comprobante($rc,$v_cliente);
					mostrar_resultado_consulta_CDR($validez_consulta,$codigo_estado,$mensaje_estado);?>
					<div style="clear:both"></div><hr>
				</form>
				<!-- Inicio de listado de datos de usuario en una tabla ajustada a la medida de los datos -->
				<?php
				if ($ambito_busqueda=="Normal")
				{
					//Lista de los ultimos 10 datos de registro de caja
					echo "<b>ULTIMOS 5 REGISTROS DE COMPROBANTES</b><br>";	
				}
				else
				{
					//Lista de registroS de caja
					$filas=mysqli_num_rows($sql_regvtacaja);
					echo "<b>LISTA DE REGISTROS DE COMPROBANTES FILTRADOS ($filas)</b><br>";	
				}
				listar_comprobantes($Conexion,$sql_regvtacaja,$ambito_busqueda);
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
</script>
<?php
function listar_comprobantes($Conexion,$sql_regvtacaja,$ambito_busqueda)
{
	$wsdlUrl = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
	$soap = new SoapClient($wsdlUrl);
	$service = new ConsultCdrService();
	tbl_lista_comprob_SUNAT($Conexion,"margin-left:0px;","height:170px;",$sql_regvtacaja,"tblnormal",$soap,$service,
	"ID:id_rvc:50:N",
	"Fech.Vta.:fechaven_rvi:75:N",
	"CódCpg.:codcpg_rvi:55:N",
	"Docs.:docum:40:N",
	"Num.Doc.:numdoc:70:N",
	"Impor.S/.:importetot_rvi:75:N",
	"Estado:estado_rvc:50:N",
	"Emit.:cee_rvc:40:N",
	"Msg.CDR:mensajecdr_rvc:320:N",
	"Msg.CDR.NC:mensjcdr_ncred:320:N",
	"Validez Comp.:comprobante:150:verifica_comprobante|");
}
function busqueda_filtros_comprobante($v_fechaven_rvi,$var_doc,$var_std,$var_zna,$var_cee_rvc,$datos,$resultado_perfil_accesos,$Conexion)
{
	lblnorm("Buscar ID:","etq5"); txtnrmstl("txtbus","width:50px;"); 
	if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); }
	if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }
	spc(5); sl(1);
	lblnorm("FECHAS:  Ini:","etq5"); txtvalstl("txtfchini",$v_fechaven_rvi,10,"width:85px;");?><input type="button" name=boton1 onclick=clear_textbox(this.form.txtfchini) value="X" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
	lblnorm("Fin:","etq5"); txtvalstl("txtfchfin",$v_fechaven_rvi,10,"width:85px;");?><input type="button" name=boton2 onclick=clear_textbox(this.form.txtfchfin) value="X" style="border-radius:5px; height:25px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/><?php
	lblnorm("Docum.:","etq5"); cmbnormal("cmbdoc", $var_doc, "Boleta de venta", "Factura");
	lblnorm("Serie-numero:","etq5"); txtnrmstl("txtsnm","width:80px;");
	lblnorm("Estado:","etq5"); cmbnormal("cmbstd", $var_std, "anulado");
	lblnorm("Zona:","etq5"); 
	//cmbnormal("cmbzna", $var_zna, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
	cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zna,"","nomb_zna");
	lblnorm("Emitido:","etq5"); cmbnormal("cmb_cee_rvc", $var_cee_rvc, "1", "0");
	if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }
}
function mostrar_reg_comprobante($rc,$v_cliente)
{ ?>
	<div>	<?php 
		echo "<b>REGISTRO DE COMPROBANTE</b>"; spc(16);
		lblnorm("ID:","etq14"); txtronstl("txt_id_rvc",$rc->id_rvc,"width:50px;");
		lblnorm("Cliente:","etq14"); txtronstl("txt_v_id_cli",$rc->id_cli.":".$v_cliente,"width:220px;");
		lblnorm("Fecha emisión:","etq14"); txtronstl("txt_v_fechaemi_rvi",$rc->fechaemi_rvi,"width:70px;");
		lblnorm("Fecha venta:","etq14"); txtronstl("txt_v_fechaven_rvi",$rc->fechaven_rvi,"width:70px;");
		lblnorm("Cód.Pago:","etq14"); txtronstl("txt_v_codcpg_rvi", $rc->codcpg_rvi, "width:70px;");?>
	</div><hr>
	<div>
		<!--<div id="colizq2">-->
		<div style="float:left; width:28%;">
			<div> <?php 
				lblnorm("Documento:","etq4"); txtronstl("txt_v_tipodoccp_rvi", $rc->tipodoccp_rvi, "width:110px;");
				txtronstl("txt_v_seriecp_rvi", $rc->seriecp_rvi, "width:15px;"); echo "-";
				txtronstl("txt_v_numcp_rvi", $rc->numcp_rvi, "width:50px;");?>
			</div>
			<div><?php lblnorm("Total:","etq4"); txtronstl("txt_v_importetot_rvi", $rc->importetot_rvi, "width:60px;");?></div>
		</div>
		<!--<div id="colcen2">-->
		<div style="float:left; width:13%;">
			<div><?php lblnorm("Estado:","etq4"); txtronstl("txt_v_estado_rvc", $rc->estado_rvc, "width:60px;");?></div>
			<div><?php lblnorm("Causa Anul.:","etq4"); txtronstl("txt_v_causanul_rvc", $rc->causanul_rvc, "width:65px;");?></div>
		</div>
		<!--<div id="colder2">-->
		<div style="float:left; width:26%;">
			<div><?php lblnorm("Compr.Emit.:","etq4"); txtronstl("txt_v_cee_rvc", $rc->cee_rvc, "width:50px;");?></div>
			<div><?php lblnorm("Archivo:","etq4"); txtronstl("txt_v_nombarch_rvc", $rc->nombarch_rvc, "width:230px;");?></div>
		</div>
		<!-- MODIFICADO POR JUAN (09-06-2019) PARA COMPROBANTE ELECTRONICO -->
		<div style="float:left; width:32%;">
			<div><?php lblnorm("Codigo CDR:","etq4"); txtronstl("txt_v_codigocdr_rvc", $rc->codigocdr_rvc, "width:50px;");?></div>
			<div><?php lblnorm("Mensaje CDR:","etq4"); txtronstl("txt_v_mensajecdr_rvc", $rc->mensajecdr_rvc, "width:340px;");?></div>
		</div>
	</div>
	<div style="clear:both"></div><hr><?php
}
function mostrar_resultado_consulta_CDR($validez_consulta,$codigo_estado,$mensaje_estado)
{ 
	if ($codigo_estado=="0004")
	{
		$mensaje_estado = $mensaje_estado.", el comprobante es válido.";
	}
	if ($codigo_estado=="0127")
	{
		$mensaje_estado = "El comprobante no ha sido informado a SUNAT, no es válido.";
	} ?>
	<div> <?php
		echo "<b>Validez de consulta: </b>".$validez_consulta; spc(15);
		echo "<b>Codigo de estado: </b>".$codigo_estado; spc(15);
		echo "<b>Descripcion de estado </b>: ".$mensaje_estado."<br>";?>
	</div><?php
}
function obtener_datos_de_estado_de_CDR($rucEmisor, $tipoDocumento, $serie, $correlativo,&$validez_consulta,&$codigo_estado,&$mensaje_estado)
{
	$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
	convertir_serie_a_formato_SUNAT($tipoDocumento, $serie);
	$wsdlUrl = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
	$soap = new SoapClient($wsdlUrl);
	$soap->setCredentials('10413437186USUARIO2', 'Heli2025');
	$service = new ConsultCdrService();
	$service->setClient($soap);
	$result = $service->getStatusCdr($rucEmisor, $codigo_tipoDocumento, $serie, $correlativo);
	$validez_consulta = $result->isSuccess() ? "1" : "0";
	$codigo_estado = $result->getCode();
	$mensaje_estado = $result->getMessage();
}
?>