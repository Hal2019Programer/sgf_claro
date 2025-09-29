<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda: id_fac, num_fac, id_cli, id_pro, id_kar, id_usr */
$var0=$var1=$var2=$var3=$var4=$var5=$numreg="";

?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Ficha de Activación");?></head>
	<body>
		<div id="container">
			<?php cabecera02("Ficha de activación"); menu02();?>
			<div id="main-col2">
				<center><h2>Registro de ficha de activación</h2></center> 
				<?php
				$sql= mysqli_query ($Conexion,"SELECT * from fichactiv") or die ("Error al traer los datos");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); 
								$resul=mysqli_fetch_array($sql);
								$var0=$resul[0];//id_fac
								$var1=$resul[1];//num_fac
								$var2=$resul[2];//id_cli
								$var3=$resul[3];//id_pro
								$var4=$resul[4];//id_kar
								$var5=$resul[5];//id_usr
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'fichactiv.php'; </script>";
						}
					}
		
					if($btn=="Agregar")
					{
						$idf=$_POST["txtid"];
						$nmf=$_POST["txtnmf"];
						$idc=$_POST["cmbidc"];
						$idp=$_POST["cmbidp"];
						$idk=$_POST["txtidk"];
						if ($nmf<>"" && $idc<>"" && $idp<>"" && $idk<>"")
						{
							$cadena_sql="INSERT INTO fichactiv (num_fac, id_cli, id_pro, id_kar, id_usr) VALUES ('".$nmf."','".$idc."','".$idp."','".$idk."','".$ident_usuario."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'fichactiv.php'; </script>";
							$idf=$nmf=$idc=$idp=$idk="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'fichactiv.php'; </script>";
						}
					}
								
					if ($btn=="Modificar")
					{
						$idf=$_POST["txtid"];
						$nmf=$_POST["txtnmf"];
						$idc=$_POST["cmbidc"];
						$idp=$_POST["cmbidp"];
						$idk=$_POST["txtidk"];
						if ($nmf<>"" && $idc<>"" && $idp<>"" && $idk<>"")
						{
							$cadena_sql = "UPDATE fichactiv SET num_fac='$nmf', id_cli='$idc', id_pro='$idp', id_kar='$idk', id_usr='$ident_usuario' WHERE id_fac=$idf";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos'); location.href = 'fichactiv.php'; </script>";
							$idf=$nmf=$idc=$idp=$idk="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'fichactiv.php'; </script>";
						}
					}
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM fichactiv WHERE id_fac=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'fichactiv.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from fichactiv") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'fichactiv.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'fichactiv.php'; </script>";
					}
				}
				?>
			<form name="usuario" action="" method="post">
				<span id="etq2">Buscar ID:</span><?php txtnormal("txtbus"); btnnormal("btnGrl", "Buscar");?><br><hr>
				<?php txtoculto("txtnumreg",$numreg);?>
					<div><span id="etq2">ID:</span><?php txtrdonly("txtid",$var0);?></div>
					<div><span id="etq2">Nº de ficha de activ.:</span><?php txtvalue("txtnmf", $var1,15);?></div>
					<div><span id="etq2">Cliente:</span><?php cmbfield("cmbidc", $Conexion, "SELECT * from clientes", $var2,"id_cli", "nom_rzs_cli", "dni_ruc_cli", "tlfcel_cli", "direcc_cli", "lugar_cli");?></div>
					<div><span id="etq2">Producto:</span><?php cmbfield("cmbidp",$Conexion,"SELECT * from productos",$var3,"id_pro","cod_pro", "id_cat", "precio_pro","fechreg_pro", "activ_pro");?></div>
					<div><span id="etq2">Kardex:</span><?php txtvalue("txtidk", $var4,5);?></div>
					<br>&nbsp;<hr>
				<?php btnnormal("btnGrl", "Agregar");?>
				<?php btnnormal("btnGrl", "Modificar");?>
				<?php btnnormal("btnGrl", "Eliminar");?>
				<?php btnnormal("btnGrl", "Actualizar");?>
				<br><hr>
			</form> <!-- Fin de formulario -->
	<!-- Inicio de listado de datos de usuario -->	
	<center>
		<table border='0' cellspacing='0' cellpadding='0'>
			<caption><h1>Lista</h1></caption><tr>
			<th>ID</th>
			<th>Número de ficha de activación</th>
			<th>Cliente</th>
			<th>Producto</th>
			<th>Kardex</th>
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
			?>
				<tr align='center'>
				<td><?php echo $var0 ?></td>
				<td><?php echo $var1 ?></td>
				<td><?php echo $var2 ?></td>
				<td><?php echo $var3 ?></td>
				<td><?php echo $var4 ?></td>
				</tr>
			<?php
			}
			?>
		</table>
	</center> <!-- Fin de listado de datos de usuario -->
</div><!--Fin de main-col-->
		<div class="clr"></div><?php pie_pagina();?><!--Pie de página (footer)-->
    </div><!--Fin de container-->
  </body>
</html>