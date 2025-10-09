<?php
/* REPORTE 01. ---------------------------------------------------------------------------------------
regventas: 				Prepago: 				Postpago: 				Servicios: 
id_rvi, 				id_rvi, 				id_rvi, 				id_rvi, 
id_cli, 				fechaven_rvi, 			fechaven_rvi, 			fechaven_rvi, 
id_pro, 				id_cli.ruc, 			id_cli.ruc, 			id_cli.ruc, 
tipopla_rvi, 			id_cli.dni, 			id_cli.dni, 			id_cli.dni, 
id_pla, 				id_cli.nombres, 		id_cli.nombres, 		id_cli.nombres, 
fechaemi_rvi, 			numcel_rvi, 			numcont_rvi, 			numcel_rvi, 
fechaven_rvi, 			id_pro.icc, 			numcel_rvi, 			id_pla.nombre_plan, 
tipodoccp_rvi, 			id_pro.imei, 			id_pro.icc, 			importetot_rvi, 
seriecp_rvi, 			id_pro.codigo, 			id_pro.imei, 			id_usr.nombre, 
numcp_rvi, 				id_pro.modelo, 			id_pro.codigo, 			zona_rvi, 
descrip_rvi, 			importetot_rvi, 		id_pro.modelo, 			tipopla_rvi
formapago_rvi, 			id_usr.nombre, 			importetot_rvi,
baseimpopgrv_rvi, 		zona_rvi, 				id_pla.nombre,
baseimpopngrv_rvi, 		tipopla_rvi				id_pla.tiempo_contrato,
isc_rvi, igv_rvi, 		id_pla.costo_plan,
importetot_rvi, 		id_usr.nombre,
id_usr, 				id_cli.telf_contacto,
numcont_rvi, 			id_pro.clase_cat,
numcel_rvi, 			zona_rvi,
codpqt_rvi, 			tipopla_rvi
codcpg_rvi,
rgpag_rvc,
zona_rvi
imprecef
-------------------------------------------------------------------------------------------------------*/
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$var_zona=$var_tvta=$var_usua=$valfecha=$fechact=$varfac=$var_tdoc="";
$fechi=$var_fchdyi=$var_fchmsi=$var_fchani="";
$fechf=$var_fchdyf=$var_fchmsf=$var_fchanf="";
$cadsql=$cadsql_pagosdiv="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Reporte de Ventas",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte 01");?></head>
	<body>
		<div>
			<?php //cabecera02("Reporte 01 (VENTAS)"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Reporte de Ventas"); menu02(); sl(1);?>
				<?php
				//---------------------------------------------- Carga fecha actual ----------------------------------------------
				date_default_timezone_set("America/Lima");
				$varfac=date("Y-m-d");
				$fechact=explode("-", $varfac);
				$var_fchdyf=$fechact[2];
				$var_fchmsf=fech_num_nom($fechact[1]);
				$var_fchanf=$fechact[0];
				//---------------------------------------------- Consulta datos principales ----------------------------------------------
				$sql=mysqli_query($Conexion,"SELECT * FROM regventas WHERE fechaven_rvi='$varfac' AND estado_rvc IS NULL") or die ("Error al consultar los datos de regventas");
				$filas_regventas=mysqli_num_rows($sql);
				$sql_pagosdiv=mysqli_query($Conexion,"SELECT * FROM pagosdiv WHERE fechareg_rpg='$varfac'") or die ("Error al consultar los datos de pagosdiv");
				//---------------------------------------------- BOTONES ----------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					//---------------------------------------------- Filtrar ----------------------------------------------
					if($btn=="Filtrar")
					{
						//---------------------------------------------- Filtrar para regventas ----------------------------------------------
						$zona=$_POST["cmbzna"];$var_zona=$zona;//zona_rvi
						$tpla=$_POST["cmbtip"];$var_tvta=$tpla;//tipopla_rvi
						$idus=$_POST["cmbusr"];$var_usua=$idus;//id_usr
						$tdoc=$_POST["cmbtdc"];$var_tdoc=$tdoc;//tipodoccp_rvi
						// Variables de fecha inicial dia, mes y año
						$fdyi=$_POST["cmbfdyi"];$var_fchdyi=$fdyi;
						$fmsi=$_POST["cmbfmsi"];$var_fchmsi=$fmsi;
						$fani=$_POST["cmbfani"];$var_fchani=$fani;
						// Variables de fecha final dia, mes y año
						$fdyf=$_POST["cmbfdyf"];$var_fchdyf=$fdyf;
						$fmsf=$_POST["cmbfmsf"];$var_fchmsf=$fmsf;
						$fanf=$_POST["cmbfanf"];$var_fchanf=$fanf;
						//Verifica que la fecha inicial no este vacia para asignarlo
						if (empty($fdyi) OR empty($fmsi) OR empty($fani)) $fechi=""; else $fechi=$fani."-".fech_nom_num($fmsi)."-".$fdyi;
						//Verifica que la fecha final no este vacia para asignarlo
						if (empty($fdyf) OR empty($fmsf) OR empty($fanf)) $fechf=""; else $fechf=$fanf."-".fech_nom_num($fmsf)."-".$fdyf;
						//Genera cadena de fechas limitado por rangos inicial y final
						$valfecha=comp_y_gener_fechas("fechaven_rvi",$fechi,$fechf);
						$sql_where="";
						if (!empty($zona)) $sql_where=$sql_where."(zona_rvi='$zona') AND ";
						if (!empty($tpla)) $sql_where=$sql_where."(tipopla_rvi='$tpla') AND ";
						if (!empty($idus)) $sql_where=$sql_where."(id_usr='$idus') AND ";
						if (!empty($tdoc)) $sql_where=$sql_where."(tipodoccp_rvi='$tdoc') AND ";
						if (!empty($valfecha)) $sql_where=$sql_where.$valfecha;
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
						if (!empty($sql_where))
						{
							$sql_where="SELECT * FROM regventas WHERE estado_rvc IS NULL AND ".$sql_where;
							//echo $sql_where,"<br>";
							$cadsql=$sql_where; //Contiene la cadena de consulta final
							$sql= mysqli_query($Conexion,$sql_where) or die ("Error al traer los datos de regventas");
						}
						//---------------------------------------------- Filtrar para pagosdiv ----------------------------------------------
						$f_zona_rpg=$_POST["cmbzna"];
						$valfecha=comp_y_gener_fechas01($fechi,$fechf);
						$sql_where_pagosdiv="";
						if (!empty($f_zona_rpg)) $sql_where_pagosdiv=$sql_where_pagosdiv."(zona_rpg='$f_zona_rpg') AND ";
						if (!empty($valfecha)) $sql_where_pagosdiv=$sql_where_pagosdiv.$valfecha;
						$sql_where_pagosdiv=trim($sql_where_pagosdiv);
						$sql_where_pagosdiv=substr($sql_where_pagosdiv, 0, strlen($sql_where_pagosdiv)-4);
						if (!empty($sql_where_pagosdiv))
						{
							$sql_where_pagosdiv="SELECT * FROM pagosdiv WHERE ".$sql_where_pagosdiv;
							$cadsql_pagosdiv=$sql_where_pagosdiv; //Contiene la cadena de consulta final
							$sql_pagosdiv = mysqli_query ($Conexion,$sql_where_pagosdiv) or die ("Error al traer los datos de pagosdiv");
						}
					}
					if($btn=="Exportar")
					{
						$consulta_exportar="SELECT * FROM regventas WHERE fechaven_rvi='$varfac' AND estado_rvc IS NULL";
						$consulta_activa=$_POST["txtcadsql"];
						if (!empty($consulta_activa))
						{
							$sql=mysqli_query($Conexion,$consulta_activa) or die ("Error al traer los datos de regventas");
							$filas_regventas=mysqli_num_rows($sql);
							$consulta_exportar=$consulta_activa;
						}
						if ($filas_regventas<=0)
						{
							echo "<script> alert('No hay datos para mostrar');</script>";
						}
						else
						{
							exportar(conversion_de_consulta($consulta_exportar));
						}
					}
					//---------------------------------------------- Imprimir ----------------------------------------------
					if($btn=="Imprimir")
					{
						// Considerar en configuración de IE/Herramientas/Imprimir/Configurar páginas modificar los siguientes parámetros
						// para evitar que aparezcan el nombre de archivo, numero de página, URL y fecha:
						// Encabezado: Titulo y Personalizdo, escoger Vacío
						// Pié de página: URL y Fecha, escoger Vacío
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						if (!empty($ccf))
						{
							$znn=$_POST["cmbzna"];$var_zona=$znn;//zona
							$tip=$_POST["cmbtip"];$var_tvta=$tip;//grupo
							$ufn=$_POST["cmbusr"];$var_usua=$ufn;//usuario
							$fid=$_POST["cmbfdyi"];$var_fchdyi=$fid;//dia inicial
							$fim=$_POST["cmbfmsi"];$var_fchmsi=$fim;//mes inicial
							$fia=$_POST["cmbfani"];$var_fchani=$fia;//año inicial
							$ffd=$_POST["cmbfdyf"];$var_fchdyf=$ffd;//dia final
							$ffm=$_POST["cmbfmsf"];$var_fchmsf=$ffm;//mes final
							$ffa=$_POST["cmbfanf"];$var_fchanf=$ffa;//año final
							$fin=$fid."/".$fim."/".$fia;//fecha inicial
							$ffi=$ffd."/".$ffm."/".$ffa;//fecha final
							$sql= mysqli_query ($Conexion,$ccf) or die ("Error al traer los datos de regventas");
							$ncf=conversion_de_consulta($ccf);//convierta la cadena de consulta final para enviarlo a la siguiente ventana como parametro
							echo "<script> window.open('../admin/reporte01imp.php?cadconsulta=$ncf&vizona=$znn&vitip=$tip&viufn=$ufn&vifin=$fin&viffi=$ffi', '_blank', 'width=962, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
						}
						else
						{
							mensaje("No se puede imprimir sin ejecutado el botón Filtrar previamente.");
						}
					}
					//---------------------------------------------- Actualizar ----------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'reporte01.php'; </script>";
					}
				}
				//---------------------------------------------- Conteos de cantidades y valores en regventas ----------------------------------------------
				$tvppg=$tvprp=$trnor=$trpdv=$tvacc=$tvser=$tvotr=0; // Cantidades
				$mtppg=$mtprp=$mtrnor=$mtrpdv=$mtacc=$mtser=$mtotr=0; // Monto acumulado
				//Añadido por Juan para contar las ventas de juegos
				$canti_vtas_juego=$monto_vtas_juego=0;
				// Añadido para conteo de PortaPrePost, PortaPostPost, PortaPre, 1Play, 2Play, 3Play
				$cant_PortaPrePost=$cant_PortaPostPost=$cant_PortaPre=$cant_1Play=$cant_2Play=$cant_3Play = 0;
				$monto_PortaPrePost=$monto_PortaPostPost=$monto_PortaPre=$monto_1Play=$monto_2Play=$monto_3Play = 0;
				//-------------------------------------------------
				$mtrgv=0;
				//--------------------- Conteos en regventas ---------------------
				//Agregado por Juan (27-04-2019)----------------------------------
				$registro_x_zona=new conteo_zonas;
				$registro_x_zona->inicializar_lista($rz,$registro_x_zona->lista_zona);
				//----------------------------------------------------------------
				mysqli_data_seek($sql, 0); 
				while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
				{
					$im_tot=$resul["importetot_rvi"];
					$zn_rgv=$resul["zona_rvi"];
					$tp_pla=$resul["tipopla_rvi"];
					//Agregado por Juan (27-04-2019)----------------------------------
					$registro_x_zona->contar_a_lista($rz,$registro_x_zona->lista_zona,$zn_rgv,$im_tot);
					//-------------------------------------------------------------
					//Por tipo de venta
					if ($tp_pla=="Postpago") { $tvppg++; $mtppg=$mtppg+$im_tot; }
					if ($tp_pla=="Prepago") { $tvprp++; $mtprp=$mtprp+$im_tot; }
					if ($tp_pla=="Rec.Normal") { $trnor++; $mtrnor=$mtrnor+$im_tot; }
					if ($tp_pla=="Rec.PDV") { $trpdv++; $mtrpdv=$mtrpdv+$im_tot; }
					if ($tp_pla=="Accesorios") { $tvacc++; $mtacc=$mtacc+$im_tot; }
					if ($tp_pla=="Servicios") { $tvser++; $mtser=$mtser+$im_tot; }
					if ($tp_pla=="Otros") { $tvotr++; $mtotr=$mtotr+$im_tot; }
					if ($tp_pla=="Juego") { $canti_vtas_juego++; $monto_vtas_juego=$monto_vtas_juego+$im_tot; }
					// Añadido para calcular PortaPrePost, PortaPostPost, PortaPre, 1Play, 2Play, 3Play
					if ($tp_pla=="PortaPrePost") { $cant_PortaPrePost++; $monto_PortaPrePost=$monto_PortaPrePost+$im_tot; }
					if ($tp_pla=="PortaPostPost") { $cant_PortaPostPost++; $monto_PortaPostPost=$monto_PortaPostPost+$im_tot; }
					if ($tp_pla=="PortaPre") { $cant_PortaPre++; $monto_PortaPre=$monto_PortaPre+$im_tot; }
					if ($tp_pla=="1Play") { $cant_1Play++; $monto_1Play=$monto_1Play+$im_tot; }
					if ($tp_pla=="2Play") { $cant_2Play++; $monto_2Play=$monto_2Play+$im_tot; }
					if ($tp_pla=="3Play") { $cant_3Play++; $monto_3Play=$monto_3Play+$im_tot; }
					//Suma total
					$mtrgv=$mtrgv+$im_tot;
				}
				
				//--------------------- Conteos en pagosdiv ---------------------
				$suma_monto=0;
				$cant_pa=$cant_pm=0;$cant_PayJoy=0;
				$monto_pa=$monto_pm=0;$monto_PayJoy=0;
				// Monto total de conteo en pagosdiv
				$mtgrl=0;
				//Agregado por Juan (27-04-2019)----------------------------------
				$pagosdiv_x_zona=new conteo_zonas;
				$pagosdiv_x_zona->inicializar_lista($pz,$pagosdiv_x_zona->lista_zona);
				//----------------------------------------------------------------
				mysqli_data_seek($sql_pagosdiv, 0); 
				while($a=mysqli_fetch_array($sql_pagosdiv, MYSQLI_ASSOC))
				{
					$v_monto_rpg=$a["monto_rpg"];
					$v_tipo_rpg=$a["tipo_rpg"];
					$v_zona_rpg=$a["zona_rpg"];
					//Agregado por Juan (27-04-2019)----------------------------------
					$pagosdiv_x_zona->contar_a_lista($pz,$pagosdiv_x_zona->lista_zona,$v_zona_rpg,$v_monto_rpg);
					//-------------------------------------------------------------
					//Registros por tipo de pagos
					//if ($v_tipo_rpg=="Pag.Adel.") { $cant_pa++; $monto_pa=$monto_pa+$v_monto_rpg;}
					if ($v_tipo_rpg=="PayJoy") { $cant_PayJoy++; $monto_PayJoy=$monto_PayJoy+$v_monto_rpg;}
					if ($v_tipo_rpg=="Pag.Mens.") { $cant_pm++; $monto_pm=$monto_pm+$v_monto_rpg;}
					//Suma total
					$suma_monto=$suma_monto+$v_monto_rpg;
				}
				$mtgrl=$mtrgv+$suma_monto;
				?>
				<!---------------------------------------------- Formulario ---------------------------------------------->
				<form name="usuario" action="" method="post">
					<?php txtoculto("txtcadsql",$cadsql);?>
					<span id="etq5">Zona:</span><?php 
					cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona,"","nomb_zna"); ?>
					<span id="etq5"style="width:100px;">Tipo venta:</span><?php 
					cmbfieldJs_span("spn_select_tipVent","cmbtip",$Conexion,"SELECT * FROM tipoventa WHERE activo_vtv='S'",$var_tvta,"","descrip_vtv");	?>
					<span id="etq5"style="width:100px;">Usuario:</span><?php cmbfield("cmbusr", $Conexion, "SELECT * from usuarios WHERE (categ_usr='Vend') OR (categ_usr='Caja') OR (categ_usr='Cord') OR (categ_usr='Supr')", $var_usua, "id_usr","nomb_usr");?>
					<span id="etq5"style="width:100px;">Tipo Doc.:</span><?php cmbnormal("cmbtdc", $var_tdoc, "Boleta de venta", "Factura");?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }?>
					<?php if ($ident_usuario==77 OR $ident_usuario==35) btnnormal("btnGrl","Exportar"); ?>
					<br>
					<span id="etq5">Fecha Inicial:</span> <?php cmbday("cmbfdyi", $var_fchdyi);cmbmes("cmbfmsi", $var_fchmsi);cmbann("cmbfani", $var_fchani);?>
					<span id="etq5">Fecha Final:</span> <?php cmbday("cmbfdyf", $var_fchdyf);cmbmes("cmbfmsf", $var_fchmsf);cmbann("cmbfanf", $var_fchanf);?>
					<hr>
					<div class="formulario">
						<span id="etq5" class="color_items" style="width:100px;">ZONA:</span><?php
						$registro_x_zona->mostrar_lista($rz,$registro_x_zona->lista_zona); ?><br>
						<span id="etq5" class="color_items" style="width:100px;">TIPO DE VENTA:</span>
						<span id="etq4"style="width:70px;">Postpago =</span><?php echo " S/. ",$mtppg," (",$tvppg,")";?>
						<span id="etq4"style="width:100px;">Prepago =</span><?php echo " S/. ",$mtprp," (",$tvprp,")";?>
						<span id="etq4"style="width:100px;">Rec.Normal =</span><?php echo " S/. ",$mtrnor," (",$trnor,")";?>
						<span id="etq4"style="width:100px;">Rec.PDV =</span><?php echo " S/. ",$mtrpdv," (",$trpdv,")";?>
						<span id="etq5"style="width:100px;">Accesorios =</span><?php echo " S/. ",$mtacc," (",$tvacc,")";?>
						<span id="etq3"style="width:100px;">Servicios =</span><?php echo " S/. ",$mtser," (",$tvser,")";?>
						<span id="etq3"style="width:80px;">Otros =</span><?php echo " S/. ",$mtotr," (",$tvotr,")";?>
						<span id="etq3"style="width:80px;">Juego =</span><?php echo " S/. ",$monto_vtas_juego," (",$canti_vtas_juego,")";?>
						<span id="etq3"style="width:120px;">Porta Pre a Post =</span><?php echo " S/. ",$monto_PortaPrePost," (",$cant_PortaPrePost,")";?>
						<span id="etq3"style="width:120px;">Porta Post a Post =</span><?php echo " S/. ",$monto_PortaPostPost," (",$cant_PortaPostPost,")";?>
						<span id="etq3"style="width:120px;">Porta Pre =</span><?php echo " S/. ",$monto_PortaPre," (",$cant_PortaPre,")";?>
						<span id="etq3"style="width:120px;">1 Play =</span><?php echo " S/. ",$monto_1Play," (",$cant_1Play,")";?>
						<span id="etq3"style="width:120px;">2 Play =</span><?php echo " S/. ",$monto_2Play," (",$cant_2Play,")";?>
						<span id="etq3"style="width:120px;">3 Play =</span><?php echo " S/. ",$monto_3Play," (",$cant_3Play,")";?><br><hr>
						<span id="etq5" class="color_items" style="text-align:left;">TOTAL DE REGISTROS DE VENTA:</span><?php echo " S/. ",$mtrgv;?> <br><hr>
						<span id="etq5" class="color_items" style="width:120px;">PAGOS DIVERSOS:</span><?php
						$pagosdiv_x_zona->mostrar_lista($pz,$pagosdiv_x_zona->lista_zona); ?><br>
						<span id="etq8"style="width:242px;">PayJoy =</span><?php echo " S/. ",$monto_PayJoy," (",$cant_PayJoy,")";?>
						<span id="etq3"style="width:120px;">Pago Mensual =</span><?php echo " S/. ",$monto_pm," (",$cant_pm,")";?><br><hr>
						<span id="etq5" class="color_items" style="text-align:left;">TOTAL DE PAGOS DIVERSOS:</span><?php echo " S/. ",$suma_monto;?> <br><hr>
						<span id="etq5" class="color_items" style="text-align:left;">TOTAL DE VENTAS + PAGOS DIVERSOS:</span><span id="etq4"><?php echo "S/. ",$mtgrl;?></span>
					</div>
					<hr>	
				</form>
				<!---------------------------------------------- Inicio de listado de datos de usuario ---------------------------------------------->
				<?php 
				$c01=50;  $c02=85;  $c03=70; $c04=90; 
				$c05=180; $c06=100;  $c08=100; //$c07=125;
				$c09=200; $c10=60;  $c11=80; $c12=60; 
				$c13=70; $c15=105; //$c14=60; $c16=150; // Otros
				//$suma=$c01+$c02+$c03+$c04+$c05+$c06+$c07+$c08+$c09+$c10+$c11+$c12+$c13+$c14+$c15+$c16;
				$suma=$c01+$c02+$c03+$c04+$c05+$c06+$c08+$c09+$c10+$c11+$c12+$c13+$c15;//+$c07++$c14+$c16
				?>
				<div id="div1" style="width:100%; height:30px; overflow-x:hidden;border-color:#ffffff">
					<table border='0' cellspacing='0' cellpadding='0' class="tblreporte01" style="table-layout:fixed; width:<?php echo $suma;?>px;">
					<col width="<?php echo $c01;?>"><col width="<?php echo $c02;?>"><col width="<?php echo $c03;?>"><col width="<?php echo $c04;?>">
					<col width="<?php echo $c05;?>"><col width="<?php echo $c06;?>"><!--<col width="<?php //echo $c07;?>">--><col width="<?php echo $c08;?>">
					<col width="<?php echo $c09;?>"><col width="<?php echo $c10;?>"><col width="<?php echo $c11;?>"><col width="<?php echo $c12;?>">
					<col width="<?php echo $c13;?>"><!--<col width="<?php //echo $c14;?>">--><col width="<?php echo $c15;?>"><!--<col width="<?php //echo $c16;?>">-->
					<tr align="center">			<!-- colum 	regventas 		pagosdiv -->
						<th>ID</th>				<!-- $c01: 	id_rvi 			id_rpg -->
						<th>Zona</th>			<!-- $c02: 	zona_rvi 		zona_rpg -->
						<th>Tip.Vent.</th>		<!-- $c03: 	tipopla_rvi 	tipo_rpg -->
						<th>Fech.Vent.</th>	<!-- $c04: 	fechaven_rvi 	fechareg_rpg -->
						<th>Cliente</th>		<!-- $c05: 	id_cli 			id_cli -->
						<th>Nº Celular</th>		<!-- $c06: 	numcel_rvi 		numcel_rpg -->
						<!--<th>Nº Contrato</th>-->	<!-- $c07: 	numcont_rvi 	NULL -->
						<th>Plan</th>			<!-- $c08: 	id_pla 			NULL -->
						<th>Producto</th>		<!-- $c09: 	id_pro 			id_pro -->
						<th>Import.</th>		<!-- $c10: 	importetot_rvi 	monto_rpg -->
						<th>Usuario</th>		<!-- $c11: 	id_usr 			id_usr -->
						<th>Docum.</th>		<!-- $c12: 	tipodoccp_rvi 	"ticket" -->
						<th>N° Doc.</th>			<!-- $c13: 	seriecp_rvi 	seriedoc_rpg -->
						<!--<th>Num.</th>-->			<!-- $c14: 	numcp_rvi 		numdoc_rpg -->
						<th>Estado</th>			<!-- $c15: 	rgpag_rvc 		estado_rpg -->
						<!--<th>Descripción</th>-->	<!-- $c16:  descrip_rvi 	desc_rpg -->
					</tr>
					</table>
				</div>
				<div id="div2" style="width:100%; height:280px; overflow:auto;">
					<table border='0' cellspacing='0' cellpadding='0' class="tblreporte01" style="table-layout:fixed; width:<?php echo $suma;?>px;">
						<col width="<?php echo $c01;?>"><col width="<?php echo $c02;?>"><col width="<?php echo $c03;?>"><col width="<?php echo $c04;?>">
						<col width="<?php echo $c05;?>"><col width="<?php echo $c06;?>"><!--<col width="<?php //echo $c07;?>">--><col width="<?php echo $c08;?>">
						<col width="<?php echo $c09;?>"><col width="<?php echo $c10;?>"><col width="<?php echo $c11;?>"><col width="<?php echo $c12;?>">
						<col width="<?php echo $c13;?>"><!--<col width="<?php //echo $c14;?>">--><col width="<?php echo $c15;?>"><!--<col width="<?php //echo $c16;?>">-->
						<?php
						//Listado de datos de registro de ventas
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
						{
							$id_rgv=$resul["id_rvi"];
							$zn_rgv=$resul["zona_rvi"];
							$tp_pla=$resul["tipopla_rvi"];
							$fc_ven=$resul["fechaven_rvi"];
							$id_cln=$resul["id_cli"];
							$nm_cel=$resul["numcel_rvi"];
							//$nm_cnt=$resul["numcont_rvi"];
							$id_pln=$resul["id_pla"];
							$id_prd=$resul["id_pro"];
							$im_tot=$resul["importetot_rvi"];
							$id_usu=$resul["id_usr"];
							$cp_tdc=$resul["tipodoccp_rvi"];
							$cp_ser=$resul["seriecp_rvi"];
							$cp_num=$resul["numcp_rvi"];
							$numdoc=TRIM($cp_ser)."-".TRIM($cp_num);
							$rg_pag=$resul["rgpag_rvc"];
							$condic=$resul["estado_rvc"];
							//$ds_rgv=$resul["descrip_rvi"]; ?>
							<tr valign="top">
								<td><?php echo $id_rgv; ?></td>
								<td><?php echo $zn_rgv; ?></td>
								<td><?php echo $tp_pla ?></td>
								<td><?php echo $fc_ven ?></td>
								<td style="white-space:normal;"><?php echo $id_cln.":".valfldmul($Conexion,"clientes","id_cli",$id_cln,"nom_rzs_cli","dni_ruc_cli","tlfcel_cli"); ?></td>
								<td><?php echo $nm_cel ?></td>
								<!--<td><?php //echo $nm_cnt ?></td>-->
								<td><?php echo $id_pln.":".valfield($Conexion,"planes","abrv_pla","id_pla",$id_pln); ?></td>
								<td style="white-space:normal;"><?php echo $id_prd.":".valfldmul($Conexion,"productos","id_pro",$id_prd,"cod_pro","abrv_pro","imei_pro","icc_pro","clase_cat"); ?></td>
								<td style="text-align:right;"><?php echo $im_tot; ?></td>
								<td><?php echo $id_usu.":".valfield($Conexion,"usuarios","nomb_usr","id_usr",$id_usu); ?></td>
								<td><?php echo tipodoc($cp_tdc); ?></td>
								<td><?php echo $numdoc ?></td>
								<!--<td><?php //echo $cp_num ?></td>-->
								<td><?php echo $condic ?></td>
								<!--<td><?php //echo $ds_rgv ?></td>-->
							</tr><?php
						}
						//Listado de datos de pagos diversos
						mysqli_data_seek($sql_pagosdiv, 0); 
						while($resul = mysqli_fetch_array($sql_pagosdiv, MYSQLI_ASSOC))
						{
							$id_rgv=$resul["id_rpg"];
							$zn_rgv=$resul["zona_rpg"];
							$tp_pla=$resul["tipo_rpg"];
							$fc_ven=$resul["fechareg_rpg"];
							$id_cln=$resul["id_cli"];
							$nm_cel=$resul["numcel_rpg"];
							//$nm_cnt=NULL;
							$id_pln=NULL;
							$id_prd=$resul["id_pro"];
							$im_tot=$resul["monto_rpg"];
							$id_usu=$resul["id_usr"];
							$cp_tdc="Ticket";
							$cp_ser=$resul["seriedoc_rpg"];
							$cp_num=$resul["numdoc_rpg"];
							$rg_pag=$resul["estado_rpg"];
							$numdoc=TRIM($cp_ser)."-".TRIM($cp_num);
							$ds_rgv=$resul["desc_rpg"];
							$estado_rpg=$resul["estado_rpg"]; ?>
							<tr valign="top">
								<td><?php echo $id_rgv; ?></td>
								<td><?php echo $zn_rgv; ?></td>
								<td><?php echo $tp_pla ?></td>
								<td><?php echo $fc_ven ?></td>
								<td style="white-space:normal;"><?php echo $id_cln.":".valfldmul($Conexion,"clientes","id_cli",$id_cln,"nom_rzs_cli","dni_ruc_cli","tlfcel_cli"); ?></td>
								<td><?php echo $nm_cel ?></td>
								<!--<td><?php //echo $nm_cnt ?></td>-->
								<td><?php echo $id_pln ?></td>
								<td style="white-space:normal;"><?php echo $id_prd.":".valfldmul($Conexion,"productos","id_pro",$id_prd,"cod_pro","abrv_pro","imei_pro","icc_pro","clase_cat"); ?></td>
								<td style="text-align:right;"><?php echo $im_tot; ?></td>
								<td><?php echo $id_usu.":".valfield($Conexion,"usuarios","nomb_usr","id_usr",$id_usu); ?></td>
								<td><?php echo $cp_tdc ?></td>
								<td><?php echo $numdoc ?></td>
								<!--<td><?php //echo $cp_num ?></td>-->
								<td><?php echo $estado_rpg ?></td>
								<!--<td><?php //echo $ds_rgv ?></td>-->
							</tr> <?php
						}
						?>
					</table>
				</div>
				<!---------------------------------------------- Fin de listado de datos de usuario ---------------------------------------------->
				<?php scroll_doble("div1", "div2"); ?>
			</div><!--Fin de main-col-->
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function exportar($dato)
{?>
	<script type="text/javascript">
		cadena="<?php echo $dato;?>";
		window.open("regventas_e.php?v1="+cadena,"_blank");
	</script>
<?php
}
function tipodoc($td)
{
	if ($td=="Factura")
	{
		return "Fact."; 
	}
	else
	{
		if ($td=="Boleta de venta")
		{
			return "B.V.";
		}
		else
		{
			return "Otro";
		}
	}
}
?>