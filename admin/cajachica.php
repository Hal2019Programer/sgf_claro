<?php
include("../library/funcionA.php");
include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* TABLA cajachica: id_cch, montototal_cch, id_prv, tipodoccp_cch, seriedoc_cch, numerodoc_cch, descrip_cch, monto_cch,	fechareg_cch, montoactual_cch, id_usr, zona_usr, activo_cch, tiporeg_cch */
$v_id_cch=$v_montototal_cch=$v_id_prv=$v_tipodoccp_cch=$v_seriedoc_cch=$v_numerodoc_cch=$v_descrip_cch=$v_monto_cch="";
$v_fechareg_cch=$v_montoactual_cch=$v_id_usr=$v_zona_usr=$v_activo_cch=$v_tiporeg_cch=$numreg=$numero_operacion_cch="";
$vzona=$vtipr=$vacti="";
$ambito_busqueda="Normal";
$fechareg_cch="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Caja Chica",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Egresos/Ingresos");?></head>
	<body>
		<div>
			<?php //cabecera02("Caja Chica"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Gestión de Egresos/Ingresos"); menu02(); sl(1);?>
				<!--<center><h1>Gestión de Egresos/Ingresos</h1></center><hr>-->
				<?php
				if ($categ_usuario=="Prog" OR $categ_usuario=="Gern")
				{
					$sql_cajachica= mysqli_query ($Conexion,"SELECT * FROM cajachica ORDER BY id_cch DESC LIMIT 10") or die ("Error al traer los datos de caja chica");
				}
				else
				{
					$sql_cajachica= mysqli_query ($Conexion,"SELECT * FROM cajachica WHERE zona_usr='$zona_usuario' ORDER BY id_cch DESC LIMIT 10") or die ("Error al traer los datos de caja chica");
				}
				$tabla=array(array()); obtener_matriz($sql_cajachica,$tabla,$filas);
				if (empty($v_fechareg_cch)) $v_fechareg_cch=date("d-m-Y");
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
							if($numreg>=0)
							{	
								mysqli_data_seek($sql_cajachica, $numreg); 
								$r = mysqli_fetch_array($sql_cajachica,MYSQLI_ASSOC);
								$v_id_cch=$r["id_cch"];
								$v_montototal_cch=$r["montototal_cch"];
								$v_id_prv=$r["id_prv"];
								$v_tipodoccp_cch=$r["tipodoccp_cch"];
								$v_seriedoc_cch=$r["seriedoc_cch"];
								$v_numerodoc_cch=$r["numerodoc_cch"];
								$v_descrip_cch=$r["descrip_cch"];
								$v_monto_cch=$r["monto_cch"];
								$v_fechareg_cch=$r["fechareg_cch"];
								$v_fechareg_cch=invFech($v_fechareg_cch,"-");
								if (empty($v_fechareg_cch)) $v_fechareg_cch=date("d-m-Y");
								$v_montoactual_cch=$r["montoactual_cch"];
								$v_id_usr=$r["id_usr"];
								$v_zona_usr=$r["zona_usr"];
								$v_activo_cch=$r["activo_cch"];
								$v_tiporeg_cch=$r["tiporeg_cch"];
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'cajachica.php'; </script>";
						}
					}
					//---------------------------------------------------- CARGAR MONTO ----------------------------------------------------
					/*if($btn=="Cargar Monto")
					{
						//Captura datos del formulario
						$v_monto_inicial_cch=$_POST["txtmi"];
						$v_fechareg_mi_cch=invFech($_POST["txtfri"],"-");
						$v_id_usr=$ident_usuario;
						$v_zona_usr=$_POST["cmbznai"];
						$v_id_prv=0;
						//Obtiene id_cch del ultimo registros E, I que esta activo como 1
						$filas_ultreg_E = consultaregs1($Conexion, $sql_cajachica_ultreg_E, "SELECT id_cch, montoactual_cch, tiporeg_cch FROM cajachica WHERE activo_cch=1 AND tiporeg_cch='E' AND zona_usr='$v_zona_usr'", "Error al consultar datos en caja chica para registros E");
						$filas_ultreg_I = consultaregs1($Conexion, $sql_cajachica_ultreg_I, "SELECT id_cch, montoactual_cch, tiporeg_cch FROM cajachica WHERE activo_cch=1 AND tiporeg_cch='I' AND zona_usr='$v_zona_usr'", "Error al consultar datos en caja chica para registros I");
						if ($filas_ultreg_E<>0)
						{	$r = mysqli_fetch_array($sql_cajachica_ultreg_E,MYSQLI_ASSOC);	}
						else
						{	$r = mysqli_fetch_array($sql_cajachica_ultreg_I,MYSQLI_ASSOC);	}
						$id_cch_ultreg = $r["id_cch"]; $montoactual_cch_ultreg = $r["montoactual_cch"]; $tiporeg_cch_ultreg = $r["tiporeg_cch"];
						//Calcula monto actual
						$v_montoactual_cch = $montoactual_cch_ultreg + $v_monto_inicial_cch;
						//Procesa registro activo
						$v_activo_cch=1; $v_tiporeg_cch="I";
						//Ingresa registro nuevo
						if ($v_monto_inicial_cch<>"" && $v_fechareg_mi_cch<>"")
						{
							$cadena_sql="INSERT INTO cajachica (montototal_cch, fechareg_cch, montoactual_cch, id_usr, zona_usr, activo_cch, tiporeg_cch, id_prv) VALUES ('".$v_monto_inicial_cch."','".$v_fechareg_mi_cch."','".$v_montoactual_cch."','".$v_id_usr."','".$v_zona_usr."','".$v_activo_cch."','".$v_tiporeg_cch."','".$v_id_prv."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al registrar monto inicial en caja chica");
							if (!empty($id_cch_ultreg))
							{
								if ($filas_ultreg_E==1)
								{
									mysqli_data_seek($sql_cajachica_ultreg_E, 0);
									$r = mysqli_fetch_array($sql_cajachica_ultreg_E,MYSQLI_ASSOC);
									$id_cch_ultreg = $r["id_cch"];
									$cadena_sql="UPDATE cajachica SET activo_cch=0 WHERE id_cch=$id_cch_ultreg";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al actualizar penultimo registro E en caja chica");
								}
								if ($filas_ultreg_I==1)
								{
									mysqli_data_seek($sql_cajachica_ultreg_I, 0);
									$r = mysqli_fetch_array($sql_cajachica_ultreg_I,MYSQLI_ASSOC);
									$id_cch_ultreg = $r["id_cch"];
									$cadena_sql="UPDATE cajachica SET activo_cch=0 WHERE id_cch=$id_cch_ultreg";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al actualizar penultimo registro I en caja chica");
								}
							}
							echo "<script> alert('Se registró el monto inicial correctamente'); location.href = 'cajachica.php'; </script>";
							$v_monto_inicial_cch=$v_fechareg_cch=$v_montoactual_cch=$v_id_usr=$v_zona_usr=$v_activo_cch=$v_tiporeg_cch="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'cajachica.php'; </script>";
						}
					}*/
					//---------------------------------------------------- GUARDAR EGRESO/INGRESO ----------------------------------------------------
					if($btn=="Guardar Egreso/Ingreso")
					{
						$v_id_prv=$_POST["cmbidp"]; 
						$v_tipodoccp_cch=$_POST["cmbtdc"]; 
						$v_seriedoc_cch=$_POST["txtser"]; 
						$v_numerodoc_cch=$_POST["txtndc"]; 
						$v_descrip_cch=$_POST["txtdes"]; 
						$v_monto_cch=$_POST["txtmnt"]; 
						$v_fechareg_cch=$_POST["txtfrg"]; 
						$v_tiporeg_cch=$_POST["cmbtrg"];
						$v_numero_operacion_cch=$_POST["txtnop"];
						$v_id_usr=$ident_usuario;
						$v_zona_usr=$zona_usuario;
						/*
						//Obtiene id_cch del ultimo registro E que esta activo (1)
						$cadena_sql = "SELECT id_cch, montoactual_cch, tiporeg_cch FROM cajachica WHERE activo_cch=1 AND tiporeg_cch='E' AND zona_usr='$v_zona_usr'";
						$sql_cajachica_ultreg =mysqli_query ($Conexion,$cadena_sql) or die("Error al consultar datos en caja chica");
						//En caso de no existir un registro tiporeg_cch=E activo_cch=1 busca en tiporeg_cch=I
						if (mysqli_num_rows($sql_cajachica_ultreg)==0)
						{	$cadena_sql = "SELECT id_cch, montoactual_cch, tiporeg_cch FROM cajachica WHERE activo_cch=1 AND tiporeg_cch='I' AND zona_usr='$v_zona_usr'";
							$sql_cajachica_ultreg =mysqli_query ($Conexion,$cadena_sql) or die("Error al consultar datos en caja chica");	}
						$r = mysqli_fetch_array($sql_cajachica_ultreg,MYSQLI_ASSOC);
						$id_cch_ultreg=$r["id_cch"]; $montoactual_cch_ultreg=$r["montoactual_cch"]; $tiporeg_cch_ultreg=$r["tiporeg_cch"];
						//Calcula monto actual
						$v_montoactual_cch=$montoactual_cch_ultreg-$v_monto_cch;
						//Procesa registro activo para gastos
						$v_activo_cch=1;
						$v_tiporeg_cch="E";*/
						//Ingresa registro nuevo
						if (!empty($v_id_prv) && !empty($v_tipodoccp_cch) && !empty($v_seriedoc_cch) && !empty($v_numerodoc_cch)
						&& !empty($v_descrip_cch) && !empty($v_monto_cch) && !empty($v_fechareg_cch) && !empty($v_tiporeg_cch))
						{
							/*$cadena_sql="INSERT INTO cajachica (id_prv, tipodoccp_cch, seriedoc_cch, numerodoc_cch, descrip_cch, monto_cch, 
							fechareg_cch, montoactual_cch, id_usr, zona_usr, activo_cch, tiporeg_cch) VALUES ('".$v_id_prv."','".$v_tipodoccp_cch."','".$v_seriedoc_cch."','".$v_numerodoc_cch."','".$v_descrip_cch."','".$v_monto_cch."','".$v_fechareg_cch."','".$v_montoactual_cch."','".$v_id_usr."','".$v_zona_usr."','".$v_activo_cch."','".$v_tiporeg_cch."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al registrar datos en caja chica");*/
							insertarsql($Conexion,"Error al registrar datos en caja chica","cajachica",
							"id_prv",$v_id_prv,
							"tipodoccp_cch",$v_tipodoccp_cch,
							"seriedoc_cch",$v_seriedoc_cch,
							"numerodoc_cch",$v_numerodoc_cch,
							"descrip_cch",$v_descrip_cch,
							"monto_cch",$v_monto_cch,
							"fechareg_cch",$v_fechareg_cch,
							"id_usr",$v_id_usr,
							"zona_usr",$v_zona_usr,
							"tiporeg_cch",$v_tiporeg_cch,
							"numero_operacion_cch",$v_numero_operacion_cch);
							/*if (!empty($id_cch_ultreg))
							{
								if ($tiporeg_cch_ultreg=="E")
								{
									$cadena_sql="UPDATE cajachica SET activo_cch=0 WHERE id_cch=$id_cch_ultreg";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al actualizar penultimo registro en caja chica");
								}
							}*/
							echo "<script> alert('Se registró correctamente'); location.href = 'cajachica.php'; </script>";
							$v_id_prv=$v_tipodoccp_cch=$v_seriedoc_cch=$v_numerodoc_cch=$v_descrip_cch=$v_monto_cch=$v_fechareg_cch="";
							$v_id_usr=$v_zona_usr=$v_montoactual_cch=$v_activo_cch=$v_tiporeg_cch="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'cajachica.php'; </script>";
						}
					}
					//---------------------------------------------------- ELIMINAR ----------------------------------------------------
					/*if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM cajachica WHERE id_cch=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro de caja chica");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'cajachica.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * FROM cajachica") or die ("Error al traer los datos de caja chica");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'cajachica.php'; </script>";
						}
					}*/
					//---------------------------------------------------- ACTUALIZAR ----------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'cajachica.php'; </script>";
					}
					//---------------------------------------------------- FILTRAR ZONA/PRODUCTO/REGISTRO DE VENTA Y COMPRA ----------------------------------------------------
					if($btn=="Filtrar")
					{	
						$zna=$_POST["cmbzona"];$vzona=$zna;//zona
						$frg=$_POST["txt_fechareg_cch"];$fechareg_cch=$frg;//fecha de registro
						$trg=$_POST["cmb_tiporeg_cch"];$vtipr=$trg;//tipo de registro E o I
						//$act=$_POST["cmbact"];$vacti=$act;//activo
						$sql_where="";
						if (!empty($zna)) $sql_where=$sql_where."(zona_usr='$zna') AND ";
						if (!empty($frg)) $sql_where=$sql_where."(fechareg_cch='$frg') AND ";
						if (!empty($trg)) $sql_where=$sql_where."(tiporeg_cch='$trg') AND ";
						//if (!empty($act)) $sql_where=$sql_where."(activo_cch='$act') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);						
						if (!empty($sql_where))
						{
							if ($categ_usuario=="Prog" OR $categ_usuario=="Gern")
							{
								$sql_where="SELECT * FROM cajachica WHERE ".$sql_where." ORDER BY id_cch DESC";
							}
							else
							{
								$sql_where="SELECT * FROM cajachica WHERE zona_usr='$zona_usuario' AND ".$sql_where." ORDER BY id_cch DESC";
							}
							$sql_cajachica = mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Producto/Ventas/Compras");
						}
						$ambito_busqueda="Todo";
					}
				}
				//----------------------------------------------------- Conteos -----------------------------------------------------
				?>
				<!---------------------------------------------------- FORMULARIO ---------------------------------------------------->
				<form name="usuario" action="" method="post">
					<span id="etq5">Buscar ID:</span>&nbsp;<?php txtnrmstl("txtbus","width:40px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); } spc(2); ?>
					<span id="etq5" style="width:48px;">Zona:</span>
					<?php cmbfieldJs_span("spn_zona","cmbzona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vzona,"","nomb_zna"); spc(2); ?>
					<span id="etq5" style="width:55px;">Fecha:</span><?php txtvalue01("txt_fechareg_cch",$fechareg_cch,10,"date","border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;"); spc(2);?>
					<span id="etq5" style="width:80px;">Tipo Reg.:</span><?php cmbnormal("cmb_tiporeg_cch", $vtipr, "E", "I"); spc(2);/*?>
					<span id="etq5" style="width:100px;">Activo:</span><?php cmbnormal("cmbact", $vacti, "1", "0");*/?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) {btnnormal("btnGrl", "Actualizar"); } ?>
					<?php txtoculto("txtnumreg",$numreg);?><br><hr>
					<?php
					//--------------------------------- Opciones solo disponible para el Gerente o Programador -------------------------------------
					//------------------------------------------------------------------------------------------------------------------------------ ?>
					<div >
						<span id="etq5">ID:</span><?php txtronstl("txtid",$v_id_cch,"width:50px;"); spc(2); ?>
						<span id="etq5" style="width:85px;">Proveedor:</span><?php cmbfield("cmbidp",$Conexion,"SELECT * FROM proveedores",$v_id_prv,"id_prv","nom_rzs_prv"); spc(2); ?>
						<span id="etq5" style="width:140px;">Tipo de documento:</span><?php cmbnormal("cmbtdc",$v_tipodoccp_cch, "Factura", "Boleta de venta", "Guía de Remis.", "Reporte de Inv.", "Documento Bancario", "Comprobante de Ingreso", "Comprobante de Salida", "Movilidad Local", "Otros"); spc(2); ?>
						<span id="etq5" style="width:50px;">Serie:</span><?php txtvalstl("txtser",$v_seriedoc_cch,5,"width:50px;"); spc(2);?>
						<span id="etq5" style="width:130px;">Nº de documento:</span><?php txtvalstl("txtndc",$v_numerodoc_cch,8,"width:50px;");?><br>
						<span id="etq5">N° Operac:</span><?php txtvalue01("txtnop",$numero_operacion_cch,20,"text","width:150px; border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;"); spc(2); ?>
						<span id="etq5"  style="width:85px;">Descripción:</span><?php txtvalstl("txtdes",$v_descrip_cch,50,"width:200px;"); spc(2);?>
						<span id="etq5" style="width:80px;">Monto S/.:</span><?php txtvalstl("txtmnt",$v_monto_cch,8,"width:70px;"); spc(2);?>
						<span id="etq5" style="width:55px;">Fecha:</span><?php txtvalue01("txtfrg",$fechareg_cch,10,"date","border-radius:5px; background:RGB(240,240,240); height:18px; border: 1px solid #cccccc; text-align:center;"); spc(2); ?>
						<span id="etq5" style="width:80px;">Tipo Reg.:</span><?php cmbnormal("cmbtrg",$vtipr,"E","I"); spc(2);?>
						<?php if (activar_boton($datos,$resultado_perfil_accesos,"Guardar Egreso/Ingreso")) { btnnormal("btnGrl", "Guardar Egreso/Ingreso"); } ?><br>
					</div>
					<hr>
				</form>
				<!---------------------------------------------------- LISTADO DE DATOS DE USUARIO ---------------------------------------------------->
				<?php
				tblanchovariable_03($Conexion,"margin-left:0px;","height:180px;",$sql_cajachica,"tblnormal",
				"ID:id_cch:45:N",
				"Proveedor:id_prv:200:valfield|proveedores|nom_rzs_prv|id_prv",
				"Tipo doc.:tipodoccp_cch:105:N",
				"Ser.:seriedoc_cch:30:N",
				"Núm.:numerodoc_cch:45:N",
				"N° Oper.:numero_operacion_cch:100:N",
				"Descripción:descrip_cch:200:N",
				"Monto S/.:monto_cch:100:N",
				"Fecha:fechareg_cch:90:N",
				"Usuario:id_usr:80:valfield|usuarios|nomb_usr|id_usr",
				"Zona:zona_usr:85:N",
				"Tip.Reg.:tiporeg_cch:50:N");
				scroll_doble("div1", "div2");
				?>
			</div><!--Fin de main-col-->
				<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>