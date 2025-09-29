<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//Recoge variable con datos del formulario padre para usarlo en la impresión
$consultasql=$_GET['cadconsulta'];
$f=0.5;//factor de pixeles
$a=540;//ancho en pixeles
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Pagos Diversos");?></head>
	<body style="background-color:white; color:black;">
		<!--<div id="main-col3" style="width:370px; height:340px; font-size:<?php echo tf(24,$f);?>px; padding-left:20px;"> ------ Medida original de impresión ------->
		<div id="main-col3" style="width:270px; height:580px; font-size:<?php echo tf(24,$f);?>px; padding-left:10px; padding-right:10px;">
				<?php
				//-------------------------------------------------- Consultar --------------------------------------------------
				date_default_timezone_set('America/Lima');
				$sql= mysqli_query ($Conexion,"SELECT * FROM pagosdiv WHERE id_rpg='$consultasql'") or die ("Error al realizar la consulta en pagosdiv");
				$num_filas=mysqli_num_rows($sql);
				if($num_filas>0)
				{
					mysqli_data_seek($sql, 0); 
					$r=mysqli_fetch_array($sql, MYSQLI_ASSOC);
					$vi_id_rpg=$r["id_rpg"];
					$vi_id_cli=$r["id_cli"];
					$vi_id_pro=$r["id_pro"];
					$vi_id_rvi=$r["id_rvi"];
					$vi_id_rvc=$r["id_rvc"];
					$vi_tipo_rpg=$r["tipo_rpg"];
					$vi_desc_rpg=$r["desc_rpg"];
					$vi_monto_rpg=$r["monto_rpg"];
					$vi_seriedoc_rpg=$r["seriedoc_rpg"];
					$vi_numdoc_rpg=$r["numdoc_rpg"];
					$vi_fechareg_rpg=$r["fechareg_rpg"];
					$vi_zona_rpg=$r["zona_rpg"];
					$vi_estado_rpg=$r["estado_rpg"];
					$vi_idrpgh_rpg=$r["idrpgh_rpg"];
					$vi_numcel_rpg=$r["numcel_rpg"];
					$vi_id_usr=$r["id_usr"];
					$vi_efectivo_rpg=$r["efectivo_rpg"];
				}
				else
				{
					echo "<script> alert('No hay datos para imprimir en pagosdiv'); window.close(); </script>";
				}
				//-------------------------------------------------- BOTONES --------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{	
					//-------------------------------------------------- Imprimir --------------------------------------------------
					/*$btn=$_POST["btnGrl"];
					if($btn=="Imprimir")
					{
						// Considerar en configuración de IE/Herramientas/Imprimir/Configurar páginas modificar los siguientes parámetros
						// para evitar que aparezcan el nombre de archivo, numero de página, URL y fecha:
						// Encabezado: Titulo y Personalizdo, escoger Vacío
						// Pié de página: URL y Fecha, escoger Vacío
						echo "<script> window.print(); </script>";
					}*/
				}
				$nombre_empresa=valfield($Conexion,"empemisor","nomb_empe","id_empe",1);
				$direccion_empresa=valfield($Conexion,"empemisor","dir_empe","id_empe",1);
				$numero_documento=valfield($Conexion,"empemisor","ndoc_empe","id_empe",1);
				?>
				<!---------------------------------------------------- FORMULARIO -------------------------------------------------->
				<form name="usuario" action="" method="post">
					<div style="width:260px; height:52px; background-image:url('../imagenes/logo_cabecera_heli_impresion.png'); background-repeat:no-repeat; background-position:center;"></div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; font-family:Consolas; font-size:<?php echo tf(15,$f);?>px; font-weight:bold; height:25px;">
						<?php
						if ($vi_zona_rpg=="JUNCD12")
						{
						    echo "ECO SITI S.A.C.","<br>";
						    echo "Jr. Manuel Prado Nro. 383","<br>";
						}
						else
						{
    						echo $nombre_empresa, "<br>";
    						echo $direccion_empresa," - San Ramón","<br>";
						}
						?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; height:15px;">
						<?php
						    if ($vi_zona_rpg=="JUNCD12")
						    {
						        echo "CENTRO DE ATENCION AL CLIENTE Y VENTAS";
						    }
						    else
						    {
							    echo "DISTRIBUIDOR AUTORIZADO";
						    }
						?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; font-family:Consolas; font-size:<?php echo tf(30,$f);?>px; font-weight:bold; height:<?php echo tf(40,$f);?>px;">
						<?php echo "RUC: ",$numero_documento,"<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; height:35px;">
						<?php echo "<b>TICKET DE RECAUDACIÓN:</b><br>",substr("0000".(string)$vi_seriedoc_rpg,-4);?>
						<?php echo "<b>-</b>",substr("0000".(string)$vi_numdoc_rpg,-6);?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; height:70px;">
						<?php
							echo "<b>RPD (Sistema): </b>",substr("00000".(string)$vi_id_rpg,-6),"<br>";
							echo "<b>USUARIO: </b>",substr("00".(string)$vi_id_usr,-2),"-",$names_usuario,"<br>";
							echo "<b>FECHA EMISIÓN: </b>",invFech($vi_fechareg_rpg,"-"),"<br>";
							echo "<b>HORA EMISIÓN: </b>",date("g:i:s a", time()),"<br>";
						?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br><br>";?>
					</div>
					<div style="font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; height:30px; text-align:center; ">
						<?php echo "<b>CELULAR : </b>",$vi_numcel_rpg;?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------";?>
					</div>
					<div style="font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; Height:40px; display:table-cell; vertical-align:middle;">
						<?php echo "<b>CONCEPTO: </b>",$vi_desc_rpg,"<br>";?>
						<?php echo "<b>PAGO TOTAL : </b>"," S/.",$vi_monto_rpg;?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br>";?>
					</div>
					<div style="font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; Height:30px; display:table-cell; vertical-align:middle;">
						<?php echo "<b>SON: </b>",numtoletras($vi_monto_rpg),"<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br>";?>
					</div>
					<div style="font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; Height:50px; display:table-cell; vertical-align:middle;">
						<?php echo "<b>EFECTIVO: </b> S/.",$vi_efectivo_rpg,"<br>";?>
						<?php echo "<b>VUELTO: </b> S/.",form_num2dec($vi_efectivo_rpg-$vi_monto_rpg),"<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; height:80px; text-align:center; display:table-cell; vertical-align:middle;">
						<?php echo razon_social_rubro,"<br>";?>
						<?php echo "GRACIAS POR SU PREFERENCIA <br><br>";?>
					</div>
				</form>
				<!---------------------------------------------------- Fin de formulario -------------------------------------------------->
		</div><!--Fin de main-col-->
	</body>
	<?php //echo "<script> window.print(); alert('Se está realizando la impresión...'); </script>"; ?>
</html>