<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Guía de Remisión",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
$id_gr=$serie_gr=$numero_gr=$fechtrasl_gr=$znaorig_gr=$znadest_gr=$id_usr=$motivo_trasl_gr=$ruc_transp_gr=$descrip_transp_gr=$marca_placa_transp_gr=$usuario=null;
$buscar=null;
$cadena_guia_remision="
SELECT a.id_gr, a.serie_gr, a.numero_gr, CONCAT(a.serie_gr,'-',a.numero_gr) AS serie_numero, a.fechtrasl_gr, 
a.znaorig_gr, a.znadest_gr, a.id_usr, a.motivo_trasl_gr, a.ruc_transp_gr, a.descrip_transp_gr, 
a.marca_placa_transp_gr, a.licen_conduc_transp_gr, a.montotransf_gr, a.estado_gr, 
CONCAT(b.id_usr,':',b.nomb_usr) AS usuario 
FROM guia_remis a 
LEFT JOIN usuarios b ON a.id_usr=b.id_usr";
$cadena_guia_remision_ultima_parte=" ORDER BY fechtrasl_gr DESC LIMIT 10";
if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) 
{
	$consulta_guia_remision=mysqli_query($Conexion,$cadena_guia_remision.$cadena_guia_remision_ultima_parte);
}
else
{
	$consulta_guia_remision=mysqli_query($Conexion,$cadena_guia_remision." WHERE a.znaorig_gr='$zona_usuario'".$cadena_guia_remision_ultima_parte);
}
if (isset($_GET['id']))
{
	$id_gr = $_GET['id'];
	if (!isset($_POST["btnGrl"]))
	{
		$_POST["btnGrl"]="Cargar ID";
		$_POST["txtbus"]=$id_gr;
	}
}
muestraDatos_x_innerHTML_Js();
?>
<script>
function filtrar_lista()
{
	var txt_busq_ser_num=document.getElementById("txt_busq_ser_num").value;
	var txt_busq_fecha=document.getElementById("txt_busq_fecha").value;
	var txt_busq_origen=document.getElementById("txt_busq_origen").value;
	var txt_busq_destino=document.getElementById("txt_busq_destino").value;
	var datos=txt_busq_ser_num+":"+txt_busq_fecha+":"+txt_busq_origen+":"+txt_busq_destino;
	var id="tabla_seleccionProductos";
	muestraDatos_x_innerHTML(id,datos,"guia_remision.Filtro.php")
}
</script>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Transferencias");?></head>
	<body>
		<div>
			<?php //cabecera02("Transferencia de productos"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Guía de Remisión"); menu02(); sl(1);?>
				<!--<center><h1>Guía de Remisión</h1></center><hr>-->
			<?php
			if(isset($_POST["btnGrl"]))
			{
				$btn=$_POST["btnGrl"]; $id_busqueda=$_POST["txtbus"];
				if($btn=="Cargar ID")
				{
					if ($id_busqueda<>"")
					{	
						$busca_registro_guia_remision=mysqli_query($Conexion,"SELECT a.*, CONCAT(u.nomb_usr, ' ', u.apel_usr) AS usuario FROM guia_remis a LEFT JOIN usuarios u ON a.id_usr=u.id_usr WHERE id_gr='$id_busqueda'");
						if (mysqli_num_rows($busca_registro_guia_remision)>0)
						{
							$r=mysqli_fetch_array($busca_registro_guia_remision,MYSQLI_ASSOC);
							$id_gr=$r["id_gr"];
							$serie_gr=$r["serie_gr"];
							$numero_gr=$r["numero_gr"];
							$fechtrasl_gr=$r["fechtrasl_gr"];
							$znaorig_gr=$r["znaorig_gr"];
							$znadest_gr=$r["znadest_gr"];
							$id_usr=$r["id_usr"];
							$usuario=$r["usuario"];
							$motivo_trasl_gr=$r["motivo_trasl_gr"];
							$ruc_transp_gr=$r["ruc_transp_gr"];
							$descrip_transp_gr=$r["descrip_transp_gr"];
							$marca_placa_transp_gr=$r["marca_placa_transp_gr"];
						}
						else
						{	
							echo "<script> alert('No se encuentra el registro para el ID buscado'); </script>";
						}
					}
					else
					{	
						echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'guia_remision.php'; </script>";
					}
				}
				if($btn=="Actualizar")
				{
					echo "<script> location.href = 'guia_remision.php'; </script>";
				}
				if($btn=="Generar Guia Remision")
				{					
					echo "<script> location.href = 'guia_remision_generar.php'; </script>";
				}
				if($btn=="Imprimir")
				{	
					$id_gr_imprimir=$_POST["txt_id_gr"];
					if (!empty($id_gr_imprimir))
					{
						echo "<script> window.open('../admin/guia_remision_imprimir.php?id=$id_gr_imprimir', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						redireccion("guia_remision.php");
					}
					else
					{
						mensaje("No se ha cargado datos de la guía para imprimir.");
						redireccion("guia_remision.php");
					}
				}
				if($btn=="Anular Guia Remision")
				{
					$id_gr_anular=$_POST["txt_id_gr"];
					if (!empty($id_gr_anular))
					{
						$resultado=anular_guia_remision($Conexion,$id_gr_anular);
						if ($resultado) mensaje("La guía de remisión fue anulada.");
						else mensaje("Hubo un error al anular la guía de remisión. Verificar antes de continuar con otros procesos.");
						//redireccion("guia_remision.php");
					}
					else
					{
						mensaje("No se ha cargado el id de la guía para realizar la anulación.");
						//redireccion("guia_remision.php");
					}
				}
			}
			$sty01="font-weight:bold;";
			?>
				<form name="usuario" action="" method="post">
					<?php
					lblnorm("ID:","etq5"); txtnrmstl("txtbus","width:50px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Cargar ID")) { btnnormal("btnGrl", "Cargar ID"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); } 
					spc(3); lblnormExt("Serie-Numero:","","",$sty01); txtNrStJs("txt_busq_ser_num",$buscar,"text",10,"width:80px;","onkeyup='filtrar_lista()';"); spc(3);
					lblnormExt("Fecha:","","",$sty01); txtNrStJs("txt_busq_fecha",$buscar,"date",10,"width:110px;","onchange='filtrar_lista()';"); spc(3);
					lblnormExt("Origen:","","",$sty01); txtNrStJs("txt_busq_origen",$buscar,"text",15,"width:100px;","onkeyup='filtrar_lista()';"); spc(3);
					lblnormExt("Destino:","","",$sty01); txtNrStJs("txt_busq_destino",$buscar,"text",15,"width:100px;","onkeyup='filtrar_lista()';"); spc(3);
					if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?>
					<br><hr>
					<div class="formulario"><?php
						lblnormExt("ID:","","",$sty01); txtronstl("txt_id_gr",$id_gr,"width:50px;"); spc(3);
						lblnormExt("Serie:","","",$sty01); txtronstl("txt_serie_gr",$serie_gr,"width:30px;"); spc(3);
						lblnormExt("Numero:","","",$sty01); txtronstl("txt_numero_gr",$numero_gr,"width:60px;"); spc(3);
						lblnormExt("Fecha de traslado:","","",$sty01); txtronstl("txt_fechtrasl_gr",$fechtrasl_gr,"width:80px;"); spc(3);
						lblnormExt("Zona origen:","","",$sty01); txtronstl("txt_znaorig_gr",$znaorig_gr,"width:80px;"); spc(3);
						lblnormExt("Zona destino:","","",$sty01); txtronstl("txt_znadest_gr",$znadest_gr,"width:80px;"); spc(3);
						lblnormExt("Usuario:","","",$sty01); txtronstl("txt_usuario",$usuario,"width:200px;"); ?><br><?php
						lblnormExt("Motivo de traslado:","","",$sty01); txtronstl("txt_motivo_trasl_gr", $motivo_trasl_gr,"width:250px;"); spc(3);
						lblnormExt("RUC de transportista:","","",$sty01); txtronstl("txt_ruc_transp_gr", $ruc_transp_gr,"width:110px;"); spc(3);
						lblnormExt("Nombre o Razon Social:","","",$sty01); txtronstl("txt_descrip_transp_gr", $descrip_transp_gr,"width:200px;"); spc(3);
						lblnormExt("Marca Vehic. y Placa:","","",$sty01); txtronstl("txt_marca_placa_transp_gr", $marca_placa_transp_gr,"width:90px;");	?>
						<br><hr><?php 
						if (activar_boton($datos,$resultado_perfil_accesos,"Generar Guia Remision")) { btnnormal("btnGrl", "Generar Guia Remision"); }
						if (activar_boton($datos,$resultado_perfil_accesos,"Anular Guia Remision")) { btnnormal("btnGrl", "Anular Guia Remision"); } ?><br>
					</div>
					<hr>
				</form>
				<div id="tabla_seleccionProductos">
				<?php 
				tblanchovariable_05($Conexion,"margin-left:0px;","height:315px;",$consulta_guia_remision,"tblnormal","guia_remision.php",
				"ID:id_gr:50:idLink|",
				"Ser-Num:serie_numero:60:N",
				"Fech.Trasl.:fechtrasl_gr:80:invFech|",
				"Origen:znaorig_gr:80:N",
				"Destino:znadest_gr:80:N",
				"Usuario:usuario:120:N",
				"Motivo:motivo_trasl_gr:200:N",
				"RUC Transp.:ruc_transp_gr:80:N",
				"Desc.Transp.:descrip_transp_gr:200:N",
				"Vehic.:marca_placa_transp_gr:150:N",
				"Lic.Conduc.:licen_conduc_transp_gr:80:N",
				"Estado:estado_gr:80:N"); ?>
				</div>
			</div>
			<?php scroll_doble("div1", "div2"); ?>
			<div style="clear:both"></div>
		</div>
		<div class="piepag"><?php pie_pagina();?></div>
	</body>
</html>
<?php
function anular_guia_remision($Conexion,$id_gr)
{
	//mensaje($id_gr);
	$leer_origen_y_destino_gr="SELECT znaorig_gr, znadest_gr FROM guia_remis WHERE id_gr='$id_gr'";
	$consulta_origen_destino=mysqli_query($Conexion,$leer_origen_y_destino_gr);
	if (mysqli_num_rows($consulta_origen_destino)>0)
	{
		$rs=mysqli_fetch_array($consulta_origen_destino,MYSQLI_ASSOC);
		$origen=$rs["znaorig_gr"];
		$destino=$rs["znadest_gr"];
	}
	else
	{//mensaje("Consulta_origen_destino");
	return false;}
	$lista_productos_a_devolver="SELECT id_pro FROM guia_remis_detalle WHERE id_gr='$id_gr'";
	$consultar_productos_a_devolver=mysqli_query($Conexion,$lista_productos_a_devolver);
	if (mysqli_num_rows($consultar_productos_a_devolver)>0)
	{
		while($rs=mysqli_fetch_array($consultar_productos_a_devolver,MYSQLI_ASSOC))
		{
			$id_pro=$rs["id_pro"];
			$devolver_productos_a_origen="UPDATE productos SET zona_pro='$origen' WHERE id_pro='$id_pro'";
			//echo "UPDATE productos SET zona_pro='$origen' WHERE id_pro='$id_pro'"."<br>";
			mysqli_query($Conexion,$devolver_productos_a_origen);
		}
	}
	else
	{//mensaje("Productos a devolver");
	return false;}
	$colocar_anulado_guia_remis=mysqli_query($Conexion,"UPDATE guia_remis SET estado_gr='anulado' WHERE id_gr='$id_gr'");
	//echo "UPDATE guia_remis SET estado_gr='anulado' WHERE id_gr='$id_gr'"."<br>";
	$colocar_anulado_guia_remis_detalle=mysqli_query($Conexion,"UPDATE guia_remis_detalle SET estado_gr='anulado' WHERE id_gr='$id_gr'");
	//echo "UPDATE guia_remis_detalle SET estado_gr='anulado' WHERE id_gr='$id_gr'"."<br>";
	return true;
}
?>