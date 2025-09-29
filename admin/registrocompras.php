<?php
/* archivo de funciones */
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda
id_cmp, fechaemision_cmp, tipodoccp_cmp, seriecp_cmp, numerocp_cmp, id_prv, baseimpopgrv_cmp, baseimpopngrv_cmp, isc_cmp, igv_cmp, numconstdepdet_cmp, fechaemincde_cmp, importetot_cmp, formapago_cmp, id_usr */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14="";
?>
<!DOCTYPE HTML>
<html> <!-- HTML inicia el contenido de toda la página -->
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Compras");?></head>
	<body> <!-- Cuerpo de página -->
		<div  style="color:#0A2C4F">
		<?php cabecera02("Gestión de Registro de Compras"); menu02();?>
			<div id="main-col2">
			<center><h2>Lista de Registro de compras</h2></center>
			<?php
			/* Inicio de busqueda de registros en base de datos */
			$sql= mysqli_query ($Conexion,"SELECT * from regcompregr")	or die ("Error al traer los datos");
			$tabla=array(array());obtener_matriz($sql,$tabla,$filas);
			/* isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,
			Eliminar) esta definido o tiene valor NULL */
			if(isset($_POST["btnGrl"]))
			{
				/* Si btnGrl tiene datos almacena en $btn el nombre del boton
				y en $bus el valor de Buscar ID  para las siguientes acciones */
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
							$var0=$resul[0];//id_cmp
							$var1=$resul[1];//fechaemision_cmp
							$var2=$resul[2];//tipodoccp_cmp
							$var3=$resul[3];//seriecp_cmp
							$var4=$resul[4];//numerocp_cmp
							$var5=$resul[5];//id_prv
							$var6=$resul[6];//baseimpopgrv_cmp
							$var7=$resul[7];//baseimpopngrv_cmp
							$var8=$resul[8];//isc_cmp
							$var9=$resul[9];//igv_cmp
							$var10=$resul[10];//numconstdepdet_cmp
							$var11=$resul[11];//fechaemincde_cmp
							$var12=$resul[12];//importetot_cmp
							$var13=$resul[13];//formapago_cmp
							$var14=$resul[14];//id_usr
						}
						else
						{
							echo "<script> alert('No se encuentra el registro'); </script>";
						}
					}
					else
					{
						echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'reg_compregr.php'; </script>";
					}
				}
				if($btn=="Agregar")
				{
					$id=$_POST["txtIdcmp"];
					$fechaemision=$_POST["txtFechaemision"];
					$tipodoccp=$_POST["txtTipodoccp"];
					$seriecp=$_POST["txtSeriecp"];
					$numerocp=$_POST["txtNumerocp"];
					$idprv=$_POST["txtIdprv"];
					$baseimpopgrv=$_POST["txtBaseimpopgrv"];
					$isc=$_POST["txtIsc"];
					$igv=$_POST["txtIgv"];
					$baseimpopngrv=$_POST["txtBaseimpopngrv"];
					$numconstdepdet=$_POST["txtNumconstdepdet"];
					$fechemincde=$_POST["txtFechemincde"];
					$importetot=$_POST["txtImportetot"];
					$formapago=$_POST["txtFormapago"];
					$cadena="INSERT INTO regcompregr (fechaemision_cmp, tipodoccp_cmp, seriecp_cmp, numerocp_cmp, id_prv, baseimpopgrv_cmp, baseimpopngrv_cmp, isc_cmp, igv_cmp, numconstdepdet_cmp, fechaemincde_cmp, importetot_cmp, formapago_cmp, id_usr) VALUES ('".$fechaemision."','".$tipodoccp."','".$seriecp."','".$numerocp."','".$idprv."','".$baseimpopgrv."','".$baseimpopngrv."','".$isc."','".$igv."','".$numconstdepdet."','".$fechemincde."','".$importetot."','".$formapago."','".$ident_usuario."')";
					if ($fechaemision<>"" && $tipodoccp<>"" && $seriecp<>"" && $numerocp<>"" && $idprv<>"" && $baseimpopgrv<>"" && $isc<>"" && $igv<>"" && $baseimpopngrv<>"" && $numconstdepdet<>"" && $fechemincde<>"" && $importetot<>"" && $formapago<>"")
					{
						mysqli_query ($Conexion, $cadena) or die("Error al agregar datos");
						echo "<script> alert('Se insertó correctamente'); location.href = 'registrocompras.php'; </script>";
						$id=$fechaemision=$tipodoccp=$seriecp=$numerocp=$idprv=$baseimpopgrv=$isc=$igv=$baseimpopngrv=$numconstdepdet=$fechemincde=$importetot=$formapago="";
					}
					else
					{
						echo "<script> alert('No hay datos para agregar registros'); location.href = 'usuarios.php'; </script>";
					}
				}
		if ($btn=="Modificar")
		{
			$Id=$_POST["txtIdcmp"];//Id_cmp
			$Fechaemision=$_POST["txtFechaemision"];//Fechaemision_cmp
			$Tipodoccp=$_POST["txtTipodoccp"];
			$Seriecp=$_POST["txtSeriecp"];
			$Numerocp=$_POST["txtNumerocp"];
			$Id=$_POST["txtIdprv"];
			$Baseimpopgrv=$_POST["txtBaseimpopgrv"];
			$Isc=$_POST["txtIsc"];
		    $Igv=$_POST["txtIgv"];
			$Baseimpopngrv=$_POST["txtBaseimpopngrv"];
			$Numconstdepdet=$_POST["txtNumconstdepdet"];
			$Fechemincde=$_POST["txtFechemincde"];
			$Importetot=$_POST["txtImportetot"];
			$Formapago=$_POST["txtFormapago"];
			$Id=$_POST["txtIdusr"];
			
			$cadena_sql =  "UPDATE reg_compregr SET Fechaemision_cmp='$Fechaemision', Tipodoccp_cmp='$Tipodoccp', Seriecp_cmp='$Seriecp', Numerocp_cmp='$Numerocp', Id_prv='$Id' , Baseimpopgrv_cmp='$Baseimpopgrv' , Numconstdepdet_cmp='$Numconstdepdet' , Fechemincde_cmp='$Fechemincde ' , Importetot_cmp='$Importetot' , Formapago_cmp='$Formapago' , Id_usr='$Id'   WHERE Id_cmp=$Id";
			if ($Fechaemision<>"" && $Tipodoccp<>"" && $Seriecp<>"" && $Numerocp<>"" && $Id<>"" && $Baseimpopgrv<>"" && $Isc<>"" && $Igv<>"" && $Baseimpopngrv<>"" && $Numconstdepdet<>"" && $Fechemincde<>""&& $Importetot<>""&& $Formapago<>""&& $Id<>"")
			{
				mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
				echo "<script> alert('Se modificó correctamente los datos'); location.href = 'reg_compregr.php'; </script>";
				$Id="";
				$Fechaemision="";
				$Tipodoccp="";
				$Seriecp="";
				$Numerocp="";
				$Id="";
				$Baseimpopgrv="";
				$Isc="";
				$Igv="";
				$Baseimpopngrv="";
				$Numconstdepdet="";
				$Fechemincde="";
				$Importetot="";
				$Formapago="";
				$Id="";
			}
			else
			{
				echo "<script> alert('No hay datos para modificar'); location.href = 'reg_compregr.php'; </script>";
			}
		}
		if($btn=="Eliminar")
		{
			$nrg=$_POST["txtnumreg"];
			$Id=$_POST["txtIdcmp"];
			if ($nrg<>"" && $id<>"")
			{
				$cadena_sql = "DELETE FROM reg_compregr WHERE Id_cmp=$Id";
				$rsb = mysqli_query($Conexion, $cadena_sql);
				echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'reg_compregr.php'; </script>";
				$sql = mysqli_query ($Conexion,"SELECT * from reg_compregr")
				or die ("Error al traer los datos");
				$tabla=array(array());
				obtener_matriz($sql,$tabla,$filas);
			}
			else
			{
				echo "<script> alert('No hay datos de registro para borrar'); location.href = 'reg_compregr.php'; </script>";
			}
		}
		if($btn=="Actualizar")
		{
			echo "<script> location.href = 'reg_compregr.php'; </script>";
		}
	}
	?>
	<!-- Inicio de formulario -->
	<form name="usuario" action="" method="post">
		<span id="etq1">Buscar ID:</span><input type="text" name="txtbus"/><input type="submit" name="btnGrl"  value="Buscar"/>
		<br><hr> <!-- Salto de linea y linea de división -->
		<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
	<div id="colizq">
		<div>
			<span id="etq1">ID:</span><input type="text" name="txtIdcmp" style="background:rgb(220,220,255);" readonly="readonly" value="<?php echo $var0?>"/>
		</div>
		<div>
			<span id="etq1">Fecha de emision:</span><input type="text" name="txtFechaemision"  value="<?php echo $var1?>"/>
		</div>
		<div>
			<span id="etq1">Tipo:</span><input type="text" name="txtTipodoccp"  value="<?php echo $var2?>"/>
		</div>
		<div>
			<span id="etq1">Serie:</span><input type="text" name="txtSeriecp"  value="<?php echo $var3?>"/>
		</div>
		<div>
		<span id="etq1">Numero:</span><input type="text" name="txtNumerocp"  value="<?php echo $var4?>"/>
		</div>
		<div>
		<span id="etq1">Id:</span><input type="text" name="txtIdprv"  value="<?php echo $var5?>"/>
		</div>
		<div>
		<span id="etq1">Base:</span><input type="text" name="txtBaseimpopgrv"  value="<?php echo $var6?>"/>
		</div>
	</div>
	<div id="colder">
		<div>
		<span id="etq1">Isc:</span><input type="text" name="txtIsc"  value="<?php echo $var7?>"/>
		</div>
		<div>
		<span id="etq1">Igv:</span><input type="text" name="txtIgv"  value="<?php echo $var8?>"/>
		</div>
		<div>
		<span id="etq1">Base:</span><input type="text" name="txtBaseimpopngrv"  value="<?php echo $var9?>"/>
		</div>
		<div>
		<span id="etq1">Num:</span><input type="text" name="txtNumconstdepdet"  value="<?php echo $var10?>"/>
		</div>
		<div>
		<span id="etq1">Feche:</span><input type="text" name="txtFechemincde"  value="<?php echo $var11?>"/>
		</div>
		<div>
		<span id="etq1">Importe:</span><input type="text" name="txtImportetot"  value="<?php echo $var11?>"/>
		</div>
		<div>
		<span id="etq1">Forma de pago:</span><input type="text" name="txtFormapago"  value="<?php echo $var11?>"/>
		</div>
		<div>
		<span id="etq1">Id:</span><input type="text" name="txtIdusr"  value="<?php echo $var11?>"/>
		</div>
	</div>
		<br>&nbsp;<hr>
		<input type="submit" name="btnGrl" value="Agregar"/>
		<input type="submit" name="btnGrl" value="Modificar"/>
		<input type="submit" name="btnGrl" value="Eliminar"/>
		<input type="submit" name="btnGrl" value="Actualizar"/>
		<br><hr>
	</form> <!-- Fin de formulario -->
	
	<!-- Inicio de listado de datos de usuario -->	
	<center>
		<table border='0' cellspacing='0' cellpadding='0'>
			<caption><h1>Lista</h1></caption><tr>
			<th>ID</th>
			<th>Fecha</th>
			<th>Tipo</th>
			<th>Serie</th>
			<th>Numero</th>
			<th>Id</th>
			<th>Base</th>
			</tr>
			<?php
			mysqli_data_seek($sql, 0); 
			while($resul = mysqli_fetch_array($sql))
			{
				$var0=$resul[0];
				$var1=$resul[1];
				$var2=$resul[2];
				$var3=$resul[3];
				$var4=$resul[4];
				$var5=$resul[5];
				$var6=$resul[6];
			?>
				<tr align='center'>
		       <td><?php echo $var0 ?></td>
				<td><?php echo $var1 ?></td>
				<td><?php echo $var2 ?></td>
				<td><?php echo $var3 ?></td>
				<td><?php echo $var4 ?></td>
				<td><?php echo $var5?></td>
				<td><?php echo $var6?></td>
				
				</tr>
			<?php
			}
			?>
		</table>
	</center> <!-- Fin de listado de datos de usuario -->
</div><!--Fin de main-col-->
      <div class="clr"></div>
      <?php pie_pagina();?>
    </div><!--Fin de container-->
  </body>
</html>
