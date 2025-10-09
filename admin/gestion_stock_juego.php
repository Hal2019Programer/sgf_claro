<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($id_usr, $nick_usr, $nombre_usr, $apellido_usr, $nivel_usr, $zona_usr, $categ_usr);
conexiondb($Conexion);
inicializa_funcion_busca_datos_Ajax();
inicializa_ventana_busqueda();
$id_stkjg=$saldo_stkjg=$ingreso_stkjg=$egreso_stkjg=$zona_stkjg=$id_pro=$id_rvc=$proces_stkjg=$producto=$comprobante="";
date_default_timezone_set("America/Lima");
$fecha_stkjg=date("Y-m-d");
$zona=$vzona=$vbzn=$zona_usr;
$vgrupo=$vbgr="";
$vtipo=$vbtp="";
$vactv="";
$vbac="";
$datos="";
$resultado_perfil_accesos="";
$ambito_busqueda="Normal";
$numreg="";

$consulta_inicial="
SELECT a.id_stkjg, a.saldo_stkjg, a.egreso_stkjg, a.ingreso_stkjg, a.id_pro, a.id_rvc, a.fecha_stkjg, a.hora_stkjg, a.id_usr, a.min_stkjg, a.proces_stkjg, a.zona_stkjg ,
b.tipo_cat, b.clase_cat, b.abrv_pro, CONCAT(a.id_pro,':',b.tipo_cat,':',b.clase_cat,':',b.abrv_pro) AS producto, 
c.tipodoccp_rvi, c.seriecp_rvi, c.numcp_rvi, CONCAT(a.id_rvc,':',c.tipodoccp_rvi,' ',c.seriecp_rvi,'-',c.numcp_rvi) AS comprobante, 
d.nomb_usr, CONCAT(a.id_usr,':',d.nomb_usr) AS nomb_usuario 
FROM stock_juego a 
LEFT JOIN productos b ON a.id_pro=b.id_pro 
LEFT JOIN regvtacaja c ON a.id_rvc=c.id_rvc 
LEFT JOIN usuarios d ON a.id_usr=d.id_usr ";
$consulta_order_limit="
ORDER BY a.id_stkjg DESC 
LIMIT 7";
$variable_idLink="";
cargar_id_busqueda($variable_idLink);
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$id_usr,"Saldo Juegos",$resultado_perfil_accesos,$datos,$categ_usr,$nivel_usr,$zona_usr);
verificar_procesos_de_boton($resultado_perfil_accesos);
muestraDatos_x_innerHTML_Js() ?>
<script>
	function filtra_lista_stock_juego()
	{
		var cmb_usuario = document.getElementById("cmb_usuario").value;
		var cmb_zona = document.getElementById("cmb_zona").value;
		var cmb_trg = document.getElementById("cmb_trg").value;
		var cadena = cmb_usuario+":"+cmb_zona+":"+cmb_trg;
		//alert(cmb_usuario + ":" + cmb_zona + ":" + cmb_trg);
		muestraDatos_x_innerHTML("tabla_lista_stock_juego", cadena, "gestion_stock_juego.obtener_lista_filtrada.php");
	}
</script>


<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nick_usr, $nivel_usr, $id_usr, $zona_usr, $categ_usr, "Juego");?></head>
	<body>
		<?php //cabecera02("Gestión de saldo de Juego"); menu02();?>
		<div style="float:none; width:99%; box-sizing:border-box; padding:1px; margin:1% auto;">
			<?php cabecera04(0,"Gestión de Saldo de Juego"); menu02(); sl(1);?>
			<!--<center><h1>Gestión de saldo de Juego</h1></center><hr>-->
			<?php
			$consulta_stock_juego= mysqli_query ($Conexion,$consulta_inicial.$consulta_order_limit) or die ("Error al traer los datos de stock_juego");
			if (empty($var8)) $var8=date("d-m-Y");
			//---------------------------------------------- BOTONES ----------------------------------------------
			if(isset($_POST["btnGrl"]))
			{
				$btn=$_POST["btnGrl"];
				$id_stkjg=$_POST["txt_id_stkjg_busqueda"];
				//---------------------------------------------- Buscar ID  ----------------------------------------------------------
				if($btn=="Buscar ID")
				{
					if (!empty($id_stkjg))
					{
						$consulta_where=" WHERE id_stkjg=".$id_stkjg;
						$consulta_stock_juego_x_id= mysqli_query ($Conexion,$consulta_inicial.$consulta_where) or die ("Error al traer los datos de stock_juego por Id.");
						if (mysqli_num_rows($consulta_stock_juego_x_id)>0)
						{
							$resStkId=mysqli_fetch_array($consulta_stock_juego_x_id,MYSQLI_ASSOC);
							$id_stkjg=$resStkId["id_stkjg"];
							$saldo_stkjg=$resStkId["saldo_stkjg"];
							$egreso_stkjg=$resStkId["egreso_stkjg"];
							$ingreso_stkjg=$resStkId["ingreso_stkjg"];
							$producto=$resStkId["producto"];
							$comprobante=$resStkId["comprobante"];
							$fecha_stkjg=$resStkId["fecha_stkjg"];
							$nomb_usuario=$resStkId["nomb_usuario"];
							$proces_stkjg=$resStkId["proces_stkjg"];
							$zona_stkjg=$resStkId["zona_stkjg"];
							
						}
						else
						{
							mensaje("No se encuentra el registro");
						}
					}
					else
					{
						mensaje ("Falta el Id para la busqueda del registro"); //redireccion("gestion_stock_juego.php");
					}
				}
				//---------------------------------------------- AGREGAR ----------------------------------------------
				if($btn=="Agregar saldo")
				{
					$ingreso_stkjg=$_POST["txt_ingreso_stkjg"];
					$fecha_stkjg=$_POST["txt_fecha_stkjg"];
					$zona_stkjg=$_POST["cmb_zona_stkjg"];
					if (!empty($ingreso_stkjg) AND !empty($fecha_stkjg) AND !empty($zona_stkjg))
					{
						$resul_saldo_stkjg=mysqli_query($Conexion,"SELECT saldo_stkjg FROM stock_juego WHERE zona_stkjg='$zona_stkjg' ORDER BY id_stkjg DESC LIMIT 1");
						if (mysqli_num_rows($resul_saldo_stkjg)==0)
						{
							$saldo_stkjg=0;
						}
						else
						{
							$saldo_stkjg=mysqli_fetch_array($resul_saldo_stkjg,MYSQLI_ASSOC)["saldo_stkjg"];
						}
						$saldo_stkjg=$saldo_stkjg+$ingreso_stkjg;
						$resultado_insertar=insertarsql($Conexion,"Error al insertar registro en stock_juego","stock_juego",
						"saldo_stkjg",$saldo_stkjg,
						"egreso_stkjg",0,
						"ingreso_stkjg",$ingreso_stkjg,
						"id_pro",0,
						"id_rvc",0,
						"fecha_stkjg",date("Y-m-d"),
						"hora_stkjg",date("H:i:s"),
						"id_usr",$id_usr,
						"min_stkjg","N",
						"proces_stkjg","I",
						"zona_stkjg",$zona_stkjg);
						echo "<script> alert('Se insertó correctamente'); </script>";
						$ingreso_stkjg="";
						$fecha_stkjg=$fecha_stkjg=date("Y-m-d");
						$zona_stkjg="";
						$saldo_stkjg="";
						$consulta_stock_juego= mysqli_query ($Conexion,$consulta_inicial) or die ("Error al traer los datos de stock_juego");
					}
					else
					{
						echo "<script> alert('Faltan datos para agregar el saldo'); location.href = 'gestion_stock_juego.php'; </script>";
					}
				}
				//---------------------------------------------- ACTUALIZAR ----------------------------------------------
				if($btn=="Actualizar")
				{
					echo "<script> location.href = 'gestion_stock_juego.php'; </script>";
				}
			}
			?>
			<!------------------------------------------------ FORMULARIO ---------------------------------------------->
			<form name="usuario" action="" method="post">
				<?php
				lblnorm("ID:","etq5"); txtnrmstl("txt_id_stkjg_busqueda","width:80px;"); if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ID")) { btnnormal("btnGrl", "Buscar ID"); }
				lblnorm("Usuario:","etq5"); cmbfieldJs_span("spn_usuario","cmb_usuario",$Conexion,"SELECT id_usr, nomb_usr FROM usuarios WHERE activ_usr='1'","","onchange=\"filtra_lista_stock_juego()\";","id_usr","nomb_usr");
				lblnorm("Zona:","etq5"); cmbfieldJs_span("spn_zona","cmb_zona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'","","onchange=\"filtra_lista_stock_juego()\";","nomb_zna");
				lblnorm("Tipo Registro:","etq5"); cmbNormJs_span("spn_trg","cmb_trg","","onchange=\"filtra_lista_stock_juego()\";","I","E");
				if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar");} ?>
				<br><hr>
				<?php txtoculto("txtnumreg",$numreg);?>
				<div class="formulario">
					<div id="colizq" style=" float:left; width:33%;">
						<span id="etq2" style="width:90px;">ID:</span><?php txtrdonly("txt_id_stkjg",$id_stkjg);?><br>
						<span id="etq2" style="width:90px;">Saldo:</span><?php txtrdonly("txt_saldo_stkjg",$saldo_stkjg);?><br>
						<span id="etq2" style="width:90px;">Ingreso S/ :</span><?php txtvalue("txt_ingreso_stkjg",$ingreso_stkjg,25);?><br>
						<span id="etq2" style="width:90px;">Egreso S/ :</span><?php txtrdonly("txt_egreso_stkjg",$egreso_stkjg);?><br>
					</div>
					<div id="colder" style=" float:left; width:33%;">	
						<span id="etq2" style="width:90px;">Fecha:</span><?php txtvalue01("txt_fecha_stkjg", $fecha_stkjg, "", "date", "");?><br>
						<span id="etq2" style="width:90px;">Zona:</span><?php cmbfield("cmb_zona_stkjg", $Conexion, "SELECT * FROM zona WHERE activo_zna='S'", $zona_stkjg,"nomb_zna");?><br>
						<span id="etq2" style="width:90px;">Usuario:</span><?php txtrdonly("txt_id_usr",$id_usr.":".$nick_usr);?><br>
						<span id="etq5" style="width:100px;">Producto:</span><?php txtronstl("txt_id_pro",$producto,"width:230px;");?>
					</div>
					<div id="colders"  style=" float:left; width:34%;">		
						<span id="etq5" style="width:100px;">Comprobante:</span><?php txtronstl("txt_id_rvc",$comprobante,"width:220px;");?><br>
						<span id="etq5" style="width:100px;">Tipo registro:</span><?php txtronstl("txt_proces_stkjg",$proces_stkjg,"width:30px;");?><br>
						<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar saldo"))  { btnnormal("btnGrl", "Agregar saldo"); } ?>
					</div><div style="clear:both"></div>
				</div>
				<hr>
			</form>
			<!---------------------------------------------- LSITADO DE DATOS EN TABLAS ---------------------------------------------->
			<div id="tabla_lista_stock_juego"> <?php
				tblanchovariable_05($Conexion,"margin-left:0px;","height:220px;",$consulta_stock_juego,"tblnormal","gestion_stock_juego.php",
				"ID:id_stkjg:60:idLink|",
				"Saldo:saldo_stkjg:70:N",
				"Ingreso:ingreso_stkjg:70:N",
				"Egreso:egreso_stkjg:70:N",
				"Producto:producto:250:N",
				"Comprobante:comprobante:150:N",
				"Fecha:fecha_stkjg:80:N",
				"Usuario:nomb_usuario:100:N",
				"Zona:zona_stkjg:80:N",
				"T.Reg.:proces_stkjg:40:N"); ?>
			</div>
		</div>
		<?php scroll_doble("div1", "div2"); ?>
		<div style="clear:both"></div>
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function cargar_id_busqueda(&$variable_idLink)
{
	if (isset($_GET["id"]))
	{ 
		$variable_idLink=$_GET["id"];
		if (!isset($_POST["btnGrl"]))
		{
			$_POST["btnGrl"]="Buscar ID";
			$_POST["txt_id_stkjg_busqueda"]=$variable_idLink;
		}
	} 
	else 
	{ 
		$variable_idLink="";
	}
}
?>