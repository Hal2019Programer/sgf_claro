<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$var_zona=$var_seri=$var_ndoc=$var_fech="";
$ambito_busqueda="Normal";
$cadsql="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Reporte de Transferencias",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte de Transferencias");?></head>
	<body>
		<div>
			<?php //cabecera02("Reporte de Transferencias"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Reporte de Transferencias"); menu02(); sl(1);?>
				<!--<center><h1>Reporte de Transferencias</h1><hr></center>-->
				<?php
				$sql_transferencias= mysqli_query ($Conexion,"SELECT * FROM transfprod ORDER BY `fech_trs` ASC, `znaorig_trs` ASC, `sergr_trs` ASC, `numgr_trs` ASC") or die ("Error al traer los datos de transferencias");
				//--------------------------------------- Seleccionar fechas sin repetir ---------------------------------------
				$vfch=array(); $m=1;
				$sql_prod_ord_fech= mysqli_query ($Conexion,"SELECT fech_trs FROM transfprod ORDER BY `fech_trs` ASC") or die ("Error al traer los datos de fecha de transferencias");
				mysqli_data_seek($sql_prod_ord_fech, 0);
				$r=mysqli_fetch_array($sql_prod_ord_fech, MYSQLI_ASSOC);//lee primer registro
				$vfch[$m]=invFech($r["fech_trs"],"-");
				while($r=mysqli_fetch_array($sql_prod_ord_fech, MYSQLI_ASSOC))//Empieza a leer el segundo registro
				{
					$clv_busq=0;
					$n=1;
					while ($n<=$m)//Recorrer el arreglo
					{
						if ($vfch[$n]==invFech($r["fech_trs"],"-")) $clv_busq=1;
						$n++;
					}
					if ($clv_busq==0)
					{
						$m++;
						$vfch[$m]=invFech($r["fech_trs"],"-");
					}
				}
				//------------------------------------------------------- BOTONES -------------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					//------------------------------------------------------- Filtrar -------------------------------------------------------
					if($btn=="Filtrar")
					{
						$zona=$_POST["cmbzna"];$var_zona=$zona;//Zona
						$seri=$_POST["txtser"];$var_seri=$seri;//Serie
						$ndoc=$_POST["txtndc"];$var_ndoc=$ndoc;//Numero de documento
						$fech=invFech($_POST["cmbfch"],"-");$var_fech=invFech($fech,"-");//Fecha
						$sql_where="";
						if (!empty($zona)) $sql_where=$sql_where."(znaorig_trs='$zona') AND ";
						if (!empty($seri)) $sql_where=$sql_where."(sergr_trs='$seri') AND ";
						if (!empty($ndoc)) $sql_where=$sql_where."(numgr_trs='$ndoc') AND ";
						if (!empty($fech)) $sql_where=$sql_where."(fech_trs='$fech') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
						if (!empty($sql_where))
						{
							$sql_where="SELECT * FROM transfprod WHERE ".$sql_where." ORDER BY `fech_trs` ASC, `znaorig_trs` ASC, `sergr_trs` ASC, `numgr_trs` ASC";
							$cadsql=$sql_where; //Contiene la cadena de consulta final
							$sql_transferencias= mysqli_query ($Conexion,$sql_where) or die ("Error al traer los datos de productos de filtro");
							$ambito_busqueda="Todo";
						}
					}
					//------------------------------------------------------- Imprimir -------------------------------------------------------
					if($btn=="Imprimir")
					{
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						$ncf=conversion_de_consulta($ccf);
						echo "<script> window.open('../admin/reporte04imp.php?cadconsulta=$ncf', '_blank', 'width=962, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
					}
					//------------------------------------------------------- Actualizar -------------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'reporte04.php'; </script>";
					}
				}
				?>
				<!------------------------------------------------------- FORMULARIO ------------------------------------------------------->
				<form name="usuario" action="" method="post">
					<?php txtoculto("txtcadsql",$cadsql);?>
					<span id="etq5">Zona:</span>
					<?php 
					//cmbnormal("cmbzna", $var_zona, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
					cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona,"","nomb_zna"); 
					?>
					<span id="etq5">Guía Remisión: Serie =</span><?php echo " "; txtvalstl("txtser",$var_seri,2,"width:20px;"); echo " - "; txtvalstl("txtndc",$var_ndoc,6,"width:50px;");?>
					<span id="etq5">Fecha:</span> <?php cmbarray("cmbfch", $var_fech, $vfch, $m);?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir")) { btnnormal("btnGrl", "Imprimir"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?><br>
					<hr>	
				</form>
				<!-------------------------------------------------- Inicio de listado de datos de usuario -------------------------------------------------->
			
				<?php
				tblanchovariable($Conexion,"margin-left:0px;","height:320px;width:100%",$sql_transferencias,"tblnormal",$ambito_busqueda,"ID:id_trs:60:N","Fecha:fech_trs:110:invFech|","Usuario:id_usr:120:valfield|usuarios|nomb_usr|id_usr","IDP:id_pro:50:N","Producto:abrv_pro:300:N","Ser.:sergr_trs:40:N","Num.:numgr_trs:50:N","Monto:montotransf_trs:80:N","Zona Origen:znaorig_trs:100:N","Zona Destino:znadest_trs:100:N","Grupo:tipo_cat:80:N","Tipo:clase_cat:110:N");
				?>	
				
			<!-------------------------------------------------- Fin de listado de datos de usuario -------------------------------------------------->
			</div><!--Fin de main-col-->
			<?php scroll_doble("div1", "div2"); ?>
			<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>