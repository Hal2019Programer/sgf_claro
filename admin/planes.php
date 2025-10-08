<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda:
id_pla, nombre_pla, mensual_pla, mesescont_pla, fechreg_pla, activ_pla, id_usr, abrv_pla */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7="";
$numreg=null;
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Planes",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html> <!-- HTML inicia el contenido de toda la página -->
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Planes");?></head>
	<body> <!-- Cuerpo de página -->
		<div>
			<div style="width:900px;">
				<?php cabecera04(0,"Gestión de Planes"); menu02(); sl(1);?>
				<!--<center><h1 style="margin-block:auto;">Lista de planes</h1></center><hr>-->
				<?php
				/* Inicio de busqueda de registros en base de datos */
				$sql= mysqli_query ($Conexion,"SELECT * from planes")	or die ("Error al traer los datos");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas); // obtener_matriz traslada los datos de la consulta $sql a la matriz $tabla
				/* isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,	Eliminar) esta definido o tiene valor NULL */
				if (empty($var4)) $var4=date("d-m-Y");
				if(isset($_POST["btnGrl"]))
				{
					/* Si btnGrl tiene datos almacena en $btn el nombre del boton y en $bus el valor de Buscar ID  para las siguientes acciones */
					$btn=$_POST["btnGrl"];
					$bus=$_POST["txtbus"];
					/* Obtiene los datos de Buscar ID y lo coloca en las cajas de texto */
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); 
								$resul=mysqli_fetch_array($sql);
								$var0=$resul[0];//id_pla
								$var1=$resul[1];//nombre_pla
								$var2=$resul[2];//mensual_pla
								$var3=$resul[3];//mesescont_pla
								$var4=invFech($resul[4],"-");//fechreg_pla
								$var5=$resul[5];//activ_pla
								$var6=$resul[6];//id_usr
								$var7=$resul[7];//abrv_pla
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'planes.php'; </script>";
						}
					}
					if($btn=="Filtrar")
					{
						$filtrar=$_POST["txtfiltro"];
						if (!empty($filtrar))
						{
							$cadena_filtro="SELECT * FROM planes WHERE nombre_pla LIKE '%$filtrar%' OR mesescont_pla='$filtrar'";
							$sql= mysqli_query ($Conexion,$cadena_filtro) or die ("Error al traer los datos");
						}
					}
					if($btn=="Agregar")
					{
						$idp=$_POST["txtid"];
						$npl=$_POST["txtnpl"];//nombre_pla
						$msp=$_POST["txtmsp"];
						$mct=$_POST["txtmct"];//mesescont_pla
						$fch=invFech($_POST["txtfch"],"-");
						$acp=$_POST["cmbacp"];
						if ($npl<>"" && $msp<>"" && $mct<>"")
						{
							$cadena_sql="INSERT INTO planes (nombre_pla, mensual_pla, mesescont_pla, fechreg_pla, activ_pla, id_usr, abrv_pla) VALUES ('".$npl."','".$msp."','".$mct."','".$fch."',".$acp.",'".$ident_usuario."','".$npl."/".$mct."mes')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'planes.php'; </script>";
							$idp="";
							$npl="";
							$msp="";
							$mct="";
							$fch="";
							$acp="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'planes.php'; </script>";
						}
					}			
					if ($btn=="Modificar")
					{
						$idp=$_POST["txtid"];//id_pla
						$npl=$_POST["txtnpl"];//nombre_pla
						$msp=$_POST["txtmsp"];//mensual_pla
						$mct=$_POST["txtmct"];//mesescont_pla
						$fch=invFech($_POST["txtfch"],"-");//fechreg_pla
						$acp=$_POST["cmbacp"];//activ_pla
						
						if ($npl<>"" && $msp<>"" && $mct<>"")
						{
							$cadena_sql = "UPDATE planes SET nombre_pla='$npl', mensual_pla='$msp', mesescont_pla='$mct', fechreg_pla='$fch', activ_pla=$acp, id_usr='$ident_usuario', abrv_pla='$npl/$mct"."mes' WHERE id_pla=$idp";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos'); location.href = 'planes.php'; </script>";
							$idp="";
							$npl="";
							$msp="";
							$mct="";
							$fch="";
							$acp="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'planes.php'; </script>";
						}
					}
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];
						$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM planes WHERE id_pla=$id";
							$rsb = mysqli_query($Conexion, $cadena_sql);
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'planes.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from planes") or die ("Error al traer los datos");
							$tabla=array(array());
							obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'planes.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'planes.php'; </script>";
					}
				}
				?>
				<!-- Inicio de formulario -->
				<form name="usuario" action="" method="post">
					<span id="etq2">Buscar ID:&nbsp;</span><input type="text" name="txtbus"/>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { ?> <input type="submit" name="btnGrl"  value="Buscar"/> <?php } spc(1);?>
					<span id="etq2">Filtrar:&nbsp;</span><input type="text" name="txtfiltro"/>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { ?> <input type="submit" name="btnGrl"  value="Filtrar"/> <?php } ?>
					<br><hr> <!-- Salto de linea y linea de división -->
					<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
					<div class ="formulario">
						<div id="colizq" style="float:left; margin-left:1px;width:300px">
							<div><span id="etq2"style="width:130px;">ID:&nbsp;</span><input type="text" name="txtid" style="background:rgb(220,220,255); width:60px;" readonly="readonly" value="<?php echo $var0?>"/></div>
							<div><span id="etq2"style="width:130px;">Nombre de plan:&nbsp;</span><input style="width:150px;"type="text" name="txtnpl"  value="<?php echo $var1?>"/></div>
							</div>
						<div id="colder"style="float:left; margin-left:10px;width:300px">
							<div><span id="etq2"style="width:150px;">Costo Mensual:&nbsp;</span><input type="text" name="txtmsp" style="width:100px;" value="<?php echo $var2?>"/></div>
							<div><span id="etq2"style="width:150px;">Meses contrato:&nbsp;</span><input type="text" name="txtmct" style="width:100px;" value="<?php echo $var3?>"/></div>
						</div>
						<div id="colders"  style=" float:right; margin-right:10px;">	
							<div><span id="etq2"style="width:100px;">Fecha:&nbsp;</span><input type="text" name="txtfch"  value="<?php echo $var4?>"/></div>
							<div><span id="etq2"style="width:100px;">Activo(S/N):&nbsp;</span><?php cmbnormal("cmbacp", $var5, "1", "0");?></div>
						</div>
					</div>
					<hr>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?> <input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?> <input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { ?> <input type="submit" name="btnGrl" value="Eliminar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
					<br><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->	
					<table border='0' cellspacing='0' cellpadding='0' class="tblnormal" style="table-layout:fixed; width:calc(100% - 15px);">
						<caption><h1>Lista</h1></caption><tr>
						<th width="30">ID</th>
						<th width="130">Nombre del Plan</th>
						<th width="120">Costo Mensual</th>
						<th width="120">Meses contrato</th>
						<th width="100">Fecha</th>
						<th width="100">Activo(S/N)</th>
						<th width="160">Abreviado</th>
						</tr>
					</table>
					<div style="height:250px; width:100%; overflow:auto;">
					<table border='0' cellspacing='0' cellpadding='0' class="tblnormal" style="table-layout:fixed; width:100%;">
						<?php
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql))
						{
							$var0=$resul[0];
							$var1=$resul[1];//Nombre del plan
							$var2=$resul[2];
							$var3=$resul[3];//Meses de contrato
							$var4=$resul[4];
							$var5=$resul[5];
							$var7=$resul[7];
						?>
							<tr align='center'>
							<td width="30"><?php echo $var0 ?></td>
							<td width="130"><?php echo $var1 ?></td>
							<td width="120"><?php echo "S/. ".$var2 ?></td>
							<td width="120"><?php echo $var3 ?></td>
							<td width="100"><?php echo invFech($var4,"-"); ?></td>
							<td width="100"><?php echo $var5 ?></td>
							<td width="160"><?php echo $var7 ?></td>
							</tr>
						<?php
						}
						?>
					</table>
			</div><!--Fin de main-col-->
		<article class="piepag">
	<?php pie_pagina();?>
	<br><br>
	</article>
	</body>
</html>