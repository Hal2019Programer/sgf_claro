<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda de rgvtatmp: id_rvi, id_cli, id_pro, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, numcont_rvi, numcel_rvi, codpqt_rvi, codcpg_rvi, rgpag_rvc, zona_rvi */
$var0=$var1=$var2=$var3="";
$comprobante_pago=$_GET['comprobante'];
$seriecp_rvi=$_GET['serie'];
$numcp_rvi=$_GET['numero'];
$id_rvc=$_GET['id_regvtacaja'];
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Ventas(TMP)");?></head>
	<body>
		<div id="container1">
			<!-- <div id="main-col3" style="background-image: url('../imagenes/BoletaVentaCetic_8.jpg'); font-size:22px;"> -->
			<div id="main-col3" style="font-size:22px;">
				<?php
				$sql_regventas="SELECT 
				a.id_cli, a.fechaven_rvi, a.tipodoccp_rvi, a.seriecp_rvi, a.numcp_rvi, a.descrip_rvi, a.codcpg_rvi, a.formapago_rvi, 
				a.id_pro, a.id_pla, a.importetot_rvi, 
				b.id_rvc 
				FROM regventas a LEFT JOIN regvtacaja b ON a.codcpg_rvi=b.codcpg_rvi 
				WHERE a.seriecp_rvi='$seriecp_rvi' AND a.numcp_rvi='$numcp_rvi' AND a.codcpg_rvi='$comprobante_pago'";
				$sql= mysqli_query ($Conexion,$sql_regventas) or die ("Error al traer los datos de regventas para impresión de la boleta de venta.");
				$num_filas=mysqli_num_rows($sql);
				if($num_filas>0)
				{
					mysqli_data_seek($sql, 0); 
					$resul=mysqli_fetch_array($sql, MYSQLI_ASSOC);
					$id_rvc=$resul["id_rvc"];
					$idc=$resul["id_cli"];
					$fvt=$resul["fechaven_rvi"];
					$tdc=$resul["tipodoccp_rvi"];
					$ser=$resul["seriecp_rvi"];
					$ncp=$resul["numcp_rvi"];
					$dsc=$resul["descrip_rvi"];
					$cpg=$resul["codcpg_rvi"];
					$fpg=$resul["formapago_rvi"];
					$direccion_cliente=valfield($Conexion,"clientes","direcc_cli","id_cli",$idc);
					$numerodoc_cliente=valfield($Conexion,"clientes","dni_ruc_cli","id_cli",$idc);
					// Sumar todos los datos de la tabla rgvtatmp del total de los productos
					$sql_suma=mysqli_query($Conexion,"SELECT SUM(importetot_rvi) AS total FROM regventas WHERE codcpg_rvi='$cpg' AND seriecp_rvi='$ser' AND numcp_rvi='$ncp'");	
					$dato = mysqli_fetch_array($sql_suma, MYSQLI_ASSOC);
					$mntt=$dato["total"];
					$ntl=numtoletras($mntt);
					// Calculos para boleta
						$bipg=$mntt;
						$bpng=0;
						$iscc=0;
						$igvv=0;
				}
				else
				{
					echo "<script> alert('No hay datos para imprimir'); window.close(); </script>";
				}
				if(isset($_POST["btnGrl"]))
				{	
					$btn=$_POST["btnGrl"];
					if($btn=="Imprimir")
					{
						// Considerar en configuración de IE/Herramientas/Imprimir/Configurar páginas modificar los siguientes parámetros
						// para evitar que aparezcan el nombre de archivo, numero de página, URL y fecha:
						// Encabezado: Titulo y Personalizdo, escoger Vacío
						// Pié de página: URL y Fecha, escoger Vacío
						echo "<script> window.print(); </script>";
					}
				}
				?>
				<form name="usuario" action="" method="post" style="font-family:Consolas;">
					<br>
						<?php //btnnormal("btnGrl", "Imprimir");?>
					<br><br><br>
					<div style="font-size:111px;"><br></div> <!-- Espacio de separación entre linea -->
					<div>
						<span id="prn1" style="width:875px;"></span> <!-- Espacio inicial -->
						<span id="prn1" style="width:100px;"><?php echo substr("0000".(string)$ser,-4);?></span> <!-- Serie -->
						<span id="prn1" style="width:235px;"><?php echo substr("0000".(string)$ncp,-6);?></span> <!-- Numero de comprobante de pago -->
					</div>
					<div style="font-size:68px"><br></div> <!-- Espacio de separación entre linea -->
					<div>
						<span id="prn1" style="width:160px;"></span> <!-- Espacio inicial -->
						<span id="prn2" style="width:600px;"><?php echo valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$idc);?></span><!-- Nombre del cliente -->
					</div>
					<div style="font-size:13px"><br></div> <!-- Espacio de separación entre linea -->
					<div>
						<span id="prn1" style="width:182px;"></span> <!-- Espacio inicial -->
						<span id="prn2" style="width:600px;"><?php 
						if ($direccion_cliente="-")
						{
							echo "&nbsp;";
						}
						else
						{
							echo valfield($Conexion,"clientes","direcc_cli","id_cli",$idc), " - ", valfield($Conexion,"clientes","lugar_cli","id_cli",$idc);
						}?>
						</span><!-- Dirección y lugar del cliente -->
						<span id="prn1" style="width:145px;"></span> <!-- Espacio entre direccion del cliente y fecha -->
						<span id="prn2" style="width:300px;"><?php echo $fvt;?></span> <!-- Fecha de venta -->
					</div> 
					<div style="font-size:17px"><br></div> <!-- Espacio de separación entre linea -->
					<div>
						<span id="prn1" style="width:232px;"></span> <!-- Espacio inicial -->
						<span id="prn2" style="width:200px;"><?php 
						if ($numerodoc_cliente="00000000")
						{
							echo "&nbsp;";
						}
						else
						{
							echo valfield($Conexion,"clientes","dni_ruc_cli","id_cli",$idc);
						}
						?>
						</span> <!-- DNI del cliente -->
						<span id="prn1" style="width:600px;"></span> <!-- Espacio entre DNI de cliente y condición de pago -->
						<span id="prn2" style="width:210px;"><?php echo " ",$fpg." - CP:".$cpg;?></span> <!-- Condición de pago -->
					</div>
					<div style="font-size:60px"><br></div>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de productos -->	
				<div style="width:100%; overflow:auto;">
				<table border='0' cellspacing='0' cellpadding='0'>
					<?php
					mysqli_data_seek($sql, 0); 
					$contador=0;
					while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
					{
						$id_rvc=$resul["id_rvc"];
						$idp=$resul["id_pro"];
						$cpr=valfield($Conexion,"productos","cod_pro","id_pro",$idp);
						$ict=valfield($Conexion,"productos","id_cat","id_pro",$idp);$abp=valfield($Conexion,"catalogo","abrv_cat","id_cat",$ict);
						$spr=valfield($Conexion,"productos","serie_pro","id_pro",$idp);
						$ime=valfield($Conexion,"productos","imei_pro","id_pro",$idp);
						$icc=valfield($Conexion,"productos","icc_pro","id_pro",$idp);
						$ipl=$resul["id_pla"];
						$apl=valfield($Conexion,"planes","abrv_pla","id_pla",$ipl);
						$imp=$resul["importetot_rvi"];
						$contador=$contador+1;
						?>
						<tr align='left' border='0px hidden'>
							<td><span id="prn1" style="width:40px;">&nbsp;</span></td> <!-- Espacio inicial -->
							<td><span id="prn3" style="width:64px;"><?php echo 1;?></span></td> <!-- Cantidad -->
							<td><span id="prn2" style="width:855px;"><?php echo $cpr, " ", $abp, " ", $apl; if(!empty($spr)) echo "  Serie:",$spr; if(!empty($ime)) echo "  Imei:",$ime; if(!empty($icc)) echo "  ICC:",$icc; ?></span></td> <!-- Código de producto, Nombre de producto, Nombre del plan, Serie, Imei o ICC -->
							<td><span id="prn3" style="width:83px;"><?php echo $imp;?></span></td> <!-- Importe P.Unit. -->
							<td><span id="prn3" style="width:125px;"><?php echo " ",$imp;?></span></td> <!-- Importe final -->
						</tr>
						<?php
					}
					while ($contador<6)
					{
						$contador=$contador+1;
						?>
						<tr align='left' border='0px hidden'>
							<td><span id="prn1" style="width:50px;"></td>
						</tr>
						<?php
					}
					?>
				</table>
				</div>	
				<!-- Fin de listado de datos de productos -->
				<div style="font-size:43px"><br></div> <!-- Espacio de separación entre linea -->
				<div>
					<span id="prn1" style="width:180px;"></span> <!-- Espacio inicial -->
					<span id="prn2" style="width:850px;">SON:<?php echo $ntl;?></span><!-- Importe en letras -->
				</div>
					<div style="font-size:24px"><br></div> <!-- Espacio de separación entre linea -->
				<div>
					<span id="prn1" style="width:1120px;"></span> <!-- Espacio inicial -->
					<span id="prn3" style="width:157px;"><?php echo $mntt;?></span> <!-- Importe total en números -->
				</div>		
			</div><!--Fin de main-col-->
		</div><!--Fin de container-->
	</body>
	<?php //echo "<script> window.print(); alert('Se está realizando la impresión...'); </script>"; ?>
</html>