<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* TABLA pagosdiv: id_rpg, id_cli, id_pro, id_rvi, id_rvc, tipo_rpg, desc_rpg, monto_rpg, seriedoc_rpg, numdoc_rpg, fechareg_rpg, zona_rpg, estado_rpg, idrpgh_reg, numcel_rpg, id_usr */
$v_id_rpg=$v_id_cli=$v_id_pro=$v_id_rvi=$v_id_rvc=$v_tipo_rpg=$v_desc_rpg=$v_monto_rpg=$v_seriedoc_rpg=$v_numdoc_rpg=$v_fechareg_rpg=$v_efectivo_rpg=$v_zona_rpg=$v_estado_rpg=$v_idrpgh_rpg=$v_numcel_rpg="";
$vzona=$vtipr=$vfcli=$numreg=$vbfch="";
$cad_busca_cualquiera=$cad_busca_cliente=$cad_busca_regvta=$cad_busca_regpgv=$cad_busca_regven="";
//$var_boton=0;
$ambito_busqueda="Normal";
$limitar_cliente1=" ORDER BY fechreg_cli DESC LIMIT 0,5";
$limitar_cliente2=" ORDER BY fechreg_cli DESC LIMIT 0,5";
$limitar_regventa=" ORDER BY fechaven_rvi DESC LIMIT 0,5";
$limitar_regvtacj=" ORDER BY fechaven_rvi DESC LIMIT 0,5";
$limitar_pagdiver=" ORDER BY fechareg_rpg DESC LIMIT 0,5";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Pagos Diversos",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Pagos Diversos");?></head>
	<body>
		<div>
			<?php //cabecera02("Pagos Diversos"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Gestión de Pagos Diversos"); menu02(); sl(1);?>
				<!--<center><h1>Gestión de Pagos Diversos</h1></center><hr>-->
				<?php
				if ($categ_usuario=="Prog" OR $categ_usuario=="Gern") //Arreglar la decisión de nivel de usuario
				{
					$sql_pagosdiv= mysqli_query ($Conexion,"SELECT * FROM pagosdiv ORDER BY id_rpg DESC LIMIT 10") or die ("Error al traer los datos de caja chica");
				}
				else
				{
					$sql_pagosdiv= mysqli_query ($Conexion,"SELECT * FROM pagosdiv WHERE zona_rpg='$zona_usuario' ORDER BY id_rpg DESC LIMIT 10") or die ("Error al traer los datos de caja chica");
				}
				$tabla=array(array()); obtener_matriz($sql_pagosdiv,$tabla,$filas);
				date_default_timezone_set("America/Lima");
				if (empty($v_fechareg_rpg)) $v_fechareg_rpg=date("d-m-Y");
				$v_numdoc_rpg=incrementoticket($Conexion,$zona_usuario);
				$v_seriedoc_rpg=num_serie_doc($zona_usuario);
				//---------------------------------------------------- BOTONES ----------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//---------------------------------------------------- BUSCAR ----------------------------------------------------
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							$buscar_pagosdiv = mysqli_query($Conexion,"SELECT * FROM pagosdiv WHERE id_rpg='$bus'");
							if (mysqli_num_rows($buscar_pagosdiv)>0)
							//if($numreg>=0)
							{	
								//mysqli_data_seek($sql_pagosdiv, $numreg); 
								//$r = mysqli_fetch_array($sql_pagosdiv,MYSQLI_ASSOC);
								$r = mysqli_fetch_array($buscar_pagosdiv,MYSQLI_ASSOC);
								$v_id_rpg=$r["id_rpg"];
								$v_id_cli=$r["id_cli"];
								$v_id_pro=$r["id_pro"];
								$v_id_rvi=$r["id_rvi"];
								$v_id_rvc=$r["id_rvc"];
								$v_tipo_rpg=$r["tipo_rpg"];
								$v_desc_rpg=$r["desc_rpg"];
								$v_monto_rpg=$r["monto_rpg"];
								$v_seriedoc_rpg=$r["seriedoc_rpg"];
								$v_numdoc_rpg=$r["numdoc_rpg"];
								$v_fechareg_rpg=$r["fechareg_rpg"];
								$v_fechareg_rpg=invFech($v_fechareg_rpg,"-");
								if (empty($v_fechareg_rpg)) $v_fechareg_rpg=date("d-m-Y");
								$v_efectivo_rpg=$r["zona_rpg"];
								$v_zona_rpg=$r["zona_rpg"];
								$v_estado_rpg=$r["estado_rpg"];
								$v_idrpgh_rpg=$r["idrpgh_rpg"];
								$v_numcel_rpg=$r["numcel_rpg"];
								$v_id_usr=$r["id_usr"];
								$v_efectivo_rpg=$r["efectivo_rpg"];
								//Genera cadena de busqueda para $cad_busca_cliente que filtra la lista de clientes
								$cad_busca_cliente = " WHERE id_cli='$v_id_cli'";
								$cad_busca_regvta = " WHERE id_cli='$v_id_cli'";
								$cad_busca_regpgv = " WHERE id_cli='$v_id_cli'";
								$cad_busca_regven = " WHERE id_cli='$v_id_cli'";
								//$var_boton=1;
								$ambito_busqueda="Todo";
								$limitar_cliente2="";
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'pagosdiv.php'; </script>";
						}
					}
					//---------------------------------------------------- AGREGAR ----------------------------------------------------
					if($btn=="Agregar")
					{
						datos($numreg,$id,$va_numcel_rpg,$va_tipo_rpg,$va_desc_rpg,$va_monto_rpg,$va_seriedoc_rpg,$va_numdoc_rpg,$va_fechareg_rpg,$va_efectivo_rpg);
						$va_zona_rpg=$zona_usuario; $va_id_usr=$ident_usuario;
						//if (!empty($va_numcel_rpg) && !empty($va_tipo_rpg) && !empty($va_desc_rpg) && !empty($va_monto_rpg))
						if (!empty($va_numcel_rpg) && !empty($va_tipo_rpg) && !empty($va_desc_rpg) && !empty($va_monto_rpg) && !empty($va_zona_rpg) && !empty($va_id_usr))
						{
							$cadena_sql="INSERT INTO pagosdiv (tipo_rpg, desc_rpg, monto_rpg, seriedoc_rpg, numdoc_rpg, fechareg_rpg, zona_rpg, numcel_rpg, id_usr, efectivo_rpg) 
							VALUES ('".$va_tipo_rpg."','".$va_desc_rpg."','".$va_monto_rpg."','".$va_seriedoc_rpg."','".$va_numdoc_rpg."','".$va_fechareg_rpg."','".$va_zona_rpg."','".$va_numcel_rpg."','".$va_id_usr."','".$va_efectivo_rpg."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al ingresar datos en pagosdiv.");
							$cadena_sql_ultimo_id="SELECT LAST_INSERT_ID() AS ultimo_id";
							$resultado_ultimo_id=mysqli_query ($Conexion,$cadena_sql_ultimo_id) or die("Error al obtener ultimo id en pagosdiv");
							$resultado=mysqli_fetch_array($resultado_ultimo_id,MYSQLI_ASSOC);
							$ultimo_id=$resultado["ultimo_id"];
							echo "<script> window.open('../admin/pagosdivimp.php?cadconsulta=$ultimo_id', '_blank', 'width=300, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
							echo "<script> alert('Se registró correctamente'); location.href = 'pagosdiv.php'; </script>";
							$va_numcel_rpg=$va_tipo_rpg=$va_desc_rpg=$va_monto_rpg=$va_seriedoc_rpg=$va_numdoc_rpg=$va_fechareg_rpg=$va_zona_rpg=$va_id_usr="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'pagosdiv.php'; </script>";
						}
					}
					//---------------------------------------------------- MODIFICAR ----------------------------------------------------
					if($btn=="Modificar")
					{
						datos($numreg,$id,$va_numcel_rpg,$va_tipo_rpg,$va_desc_rpg,$va_monto_rpg,$va_seriedoc_rpg,$va_numdoc_rpg,$va_fechareg_rpg,$va_efectivo_rpg);
						$va_zona_rpg=$zona_usuario; $va_id_usr=$ident_usuario;
						echo $va_numcel_rpg, $va_tipo_rpg, $va_desc_rpg, $va_monto_rpg;
						if (!empty($va_numcel_rpg) && !empty($va_tipo_rpg) && !empty($va_desc_rpg) && !empty($va_monto_rpg))
						{
							$cadena_sql="UPDATE pagosdiv SET tipo_rpg='$va_tipo_rpg', desc_rpg='$va_desc_rpg', monto_rpg='$va_monto_rpg', seriedoc_rpg='$va_seriedoc_rpg', numdoc_rpg='$va_numdoc_rpg', fechareg_rpg='$va_fechareg_rpg', zona_rpg='$va_zona_rpg', numcel_rpg='$va_numcel_rpg', id_usr='$va_id_usr', efectivo_rpg='$va_efectivo_rpg' WHERE id_rpg=$id";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al modificar datos en pagosdiv");
							echo "<script> alert('Se modificó correctamente'); location.href = 'pagosdiv.php'; </script>";
							$va_numcel_rpg=$va_tipo_rpg=$va_desc_rpg=$va_monto_rpg=$va_seriedoc_rpg=$va_numdoc_rpg=$va_fechareg_rpg=$va_zona_rpg=$va_id_usr="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar registros'); location.href = 'pagosdiv.php'; </script>";
						}
					}
					//---------------------------------------------------- ELIMINAR ----------------------------------------------------
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM pagosdiv WHERE id_rpg=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro de pagos diversos");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'pagosdiv.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * FROM pagosdiv LIMIT 10") or die ("Error al traer los datos de pagos diversos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'pagosdiv.php'; </script>";
						}
					}
					//---------------------------------------------------- ACTUALIZAR ----------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'pagosdiv.php'; </script>";
					}
					//---------------------------------------------------- BUSCAR CLIENTE ----------------------------------------------------
					if($btn=="Buscar Cliente")
					{
						$busca=$_POST["txtcli"];
						if ($busca<>"")
						{
							$cad_busca_cualquiera=" WHERE (nom_rzs_cli LIKE '%$busca%') OR (dni_ruc_cli LIKE '%$busca%')";
							$limitar_cliente1="";
						}
						else
						{
							$cad_busca_cualquiera="";
							$limitar_cliente1=" ORDER BY fechreg_cli DESC LIMIT 0,5";
						}
					}
					//---------------------------------------------------- FILTRAR ZONA/PRODUCTO/REGISTRO DE VENTA Y COMPRA ----------------------------------------------------
					if($btn=="Filtrar")
					{	
						$zna=$_POST["cmbzona"];$vzona=$zna;
						$trg=$_POST["cmbtrg"];$vtipr=$trg;
						$fch=$_POST["txtfch"];$vbfch=$fch;
						$sql_where="";
						if (!empty($zna)) $sql_where=$sql_where."(zona_rpg='$zna') AND ";
						if (!empty($trg)) $sql_where=$sql_where."(tipo_rpg='$trg') AND ";
						if (!empty($fch))
						{
							$fechaventa_pagosdiversos = invFech($fch,"-");
							$sql_where=$sql_where."(fechareg_rpg LIKE '%$fechaventa_pagosdiversos%') AND "; 
						}
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);						
						if (!empty($sql_where))
						{
							if ($categ_usuario=="Prog" OR $categ_usuario=="Gern")
							{
								$sql_where="SELECT * FROM pagosdiv WHERE ".$sql_where." ORDER BY id_rpg DESC LIMIT 100";
							}
							else
							{
								$sql_where="SELECT * FROM pagosdiv WHERE zona_rpg='$zona_usuario' AND ".$sql_where." ORDER BY id_rpg DESC LIMIT 100";
							}
							$sql_pagosdiv = mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Producto/Ventas/Compras");
						}
						$ambito_busqueda="Todo";
						$limitar_cliente2="";
						$limitar_regventa="";
						$limitar_regvtacj="";
						$limitar_pagdiver="";
					}
					//---------------------------------------------------- IMPRIMIR ----------------------------------------------------
					if($btn=="Imprimir")
					{	
						$id=$_POST["txtid"];
						//echo "<script> window.open('../admin/pagosdivimp.php?cadconsulta=$id', '_blank', 'width=420, height=260, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>"; medida original de ventana de impresión
						echo "<script> window.open('../admin/pagosdivimp.php?cadconsulta=$id', '_blank', 'width=300, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
					}
				}
				?>
				<!---------------------------------------------------- FORMULARIO ---------------------------------------------------->
				<form name="usuario" action="" method="post">
					<span id="etq5" style="width:75px;">Buscar ID:&nbsp;</span><?php txtnrmstl("txtbus","width:60px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); }?>
					<span id="etq5" style="width:75px;">Zona:&nbsp;</span>
					<?php 
					//cmbnormal("cmbzona", $vzona, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
					cmbfieldJs_span("spn_zona","cmbzona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vzona,"","nomb_zna"); 
					?>
					<!-- <span id="etq5" style="width:85px;">Tipo Reg.:</span> --><?php // cmbnormal("cmbtrg",$vtipr,"Pag.Adel.","Pag.Mens.");?>
					<span id="etq5" style="width:85px;">Tipo Reg.:&nbsp;</span><?php cmbnormal("cmbtrg",$vtipr,"PayJoy","Pag.Mens.","CuotaInicial");?>
					<span id="etq5" style=" width:90px;">Fecha Vta.:&nbsp;</span><?php txtvalstl("txtfch",$vbfch,10,"width:90px;");?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }?>
					<?php txtoculto("txtnumreg",$numreg);?><br><hr>
					<!---------------------------------------------------------------------------------------------------------------------------------->
					<div>
						<span id="etq5" style="width:70px;">ID:</span><?php txtronstl("txtid",$v_id_rpg,"width:50px;");?>
						<span id="etq5" style="width:75px;">Nº Celular:</span><?php txtvalstl("txtcel",$v_numcel_rpg,11,"width:100px;");?>
						<span id="etq5" style="width:40px;">Tipo:</span><?php cmbnormal("cmbtrp",$v_tipo_rpg,"PayJoy","Pag.Mens.","CuotaInicial");?>
						<span id="etq5" style="width:85px;">Descripción:</span><?php txtvalstl("txtdsc",$v_desc_rpg,50,"width:280px;");?>
						<span id="etq5" style="width:75px;">Monto S/.:</span><?php txtvalstl("txtmnt",$v_monto_rpg,8,"width:70px;");?>
						<span id="etq5" style="width:60px;">Efectivo:</span><?php txtvalstl("txterg",$v_efectivo_rpg,10,"width:70px;");?><br>
						<span id="etq5" style="width:70px;">Serie Doc.:</span><?php txtronstl("txtser",$v_seriedoc_rpg,"width:50px;background:rgb(222,228,255)");?>
						<span id="etq5" style="width:100px;">Numero Doc.:</span><?php  txtronstl("txtndc",$v_numdoc_rpg,"width:85px;background:rgb(222,228,255)");?>
						<span id="etq5" style="width:60px;">Fecha:</span><?php txtronstl("txtfrg",$v_fechareg_rpg,"width:70px;");?>
					</div><hr>
					<!---------------------------------------------------------------------------------------------------------------------------------->
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { btnnormal("btnGrl", "Agregar"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { btnnormal("btnGrl", "Modificar"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { btnnormal("btnGrl", "Eliminar"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }?>
					<br><hr>
				</form>
				<!---------------------------------------------------- LISTADO DE DATOS DE USUARIO ---------------------------------------------------->
				<?php
				tblanchovariable_02($Conexion,"margin-left:0px;","height:300px;",$sql_pagosdiv,"tblnormal",$ambito_busqueda,"ID:id_rpg:45:N","Reg.Div.:idrpgh_rpg:80:N","Celular:numcel_rpg:100:N","Tipo.Reg.:tipo_rpg:100:N","Descripción:desc_rpg:250:N","Monto S/.:monto_rpg:90:N","Serie:seriedoc_rpg:40:N","Nº Doc.:numdoc_rpg:60:N","Fecha:fechareg_rpg:80:N","Zona:zona_rpg:80:N","Usuario:id_usr:140:valfield|usuarios|nomb_usr|id_usr");
				scroll_doble("div1", "div2");
				?>
			</div><!--Fin de main-col-->
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function datos(&$nreg,&$idpg,&$ncel,&$trpg,&$desc,&$mnto,&$seri,&$ndoc,&$fchr,&$efct)
{
	$nreg=$_POST["txtnumreg"];
	$idpg=$_POST["txtid"];
	$ncel=$_POST["txtcel"];//celular
	$trpg=$_POST["cmbtrp"];//tipo de registro de pago: adelanto o mensualidad
	$desc=$_POST["txtdsc"];//descripcion
	$mnto=$_POST["txtmnt"];//monto
	$seri=$_POST["txtser"];//serie
	$ndoc=$_POST["txtndc"];//numero de documento
	$fchr=invFech($_POST["txtfrg"],"-");//fecha
	$efct=$_POST["txterg"];//efectivo
}
?>
<?php
function incrementoticket($conx,$zona)
{
	$numdoc="";
	if (!empty($zona))
	{
		$consultaultnum= mysqli_query ($conx,"SELECT numdoc_rpg FROM pagosdiv WHERE zona_rpg='$zona' ORDER BY numdoc_rpg DESC") or die ("Error al conseguir ");
		if (mysqli_num_rows($consultaultnum)>0)
		{
			mysqli_data_seek($consultaultnum, 0); 
			$r=mysqli_fetch_array($consultaultnum,MYSQLI_ASSOC);
			$numdoc=$r["numdoc_rpg"];
			$numdoc=$numdoc+1;
			return $numdoc;
		}
		else
		{
			return 1;
		}
	}
}
?>