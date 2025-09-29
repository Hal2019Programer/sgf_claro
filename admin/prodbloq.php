<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$v_id_pro=$v_cod_pro=$v_id_cat=$v_serie_pro=$v_imei_pro=$v_icc_pro=$v_numcel_pro=$v_precio_pro=$v_fechreg_pro=$v_activ_pro=$v_id_usr=$v_abrv_pro=$v_zona_pro=$v_tipo_cat=$v_clase_cat=$v_ultreg_pro="";
$v_preciodesc_pro=$v_id_prv=$v_precionormal_prv=$v_precioespecial_prv=null;
$v_cod_invariable=$v_num_inicial=$v_num_final="";
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Productos");?></head>
	<body>
		<div>
			<?php //cabecera02("Gestión de los productos de almacén");?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Agregar Productos en Bloque para ICC"); menu02(); sl(1);?>
				<!--<center><h1>Agregar Productos en Bloque para ICC</h1></center><hr>-->
				<?php
				if (empty($v_fechreg_pro)) $v_fechreg_pro=date("d-m-Y");
				$lista=array();
				//---------------------------------------------- BOTONES ----------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					if($btn=="Generar Lista")
					{
						obtener_datos($v_zona_pro,$v_fechreg_pro,$v_id_cat,$v_precio_pro,$v_preciodesc_pro,$v_id_prv,$v_precionormal_prv,$v_precioespecial_prv,$v_activ_pro,$v_cod_invariable,$v_num_inicial,$v_num_final);
						if (validar_datos($v_zona_pro,$v_fechreg_pro,$v_id_cat,$v_precio_pro,$v_preciodesc_pro,$v_id_prv,$v_precionormal_prv,$v_precioespecial_prv,$v_activ_pro,$v_cod_invariable,$v_num_inicial,$v_num_final))
						{
							genera_lista($v_num_inicial,$v_num_final,$v_cod_invariable,$lista);
						}
						else
						{
							echo "<script> alert('No se han cargado todos los datos necesarios para generar la lista.'); location.href = 'prodbloq.php'; </script>";
						}
					}
					if($btn=="Aceptar y Añadir")
					{
						obtener_datos($v_zona_pro,$v_fechreg_pro,$v_id_cat,$v_precio_pro,$v_preciodesc_pro,$v_id_prv,$v_precionormal_prv,$v_precioespecial_prv,$v_activ_pro,$v_cod_invariable,$v_num_inicial,$v_num_final);
						if (validar_datos($v_zona_pro,$v_fechreg_pro,$v_id_cat,$v_precio_pro,$v_preciodesc_pro,$v_id_prv,$v_precionormal_prv,$v_precioespecial_prv,$v_activ_pro,$v_cod_invariable,$v_num_inicial,$v_num_final))
						{
							genera_lista($v_num_inicial,$v_num_final,$v_cod_invariable,$lista);
							insertardatos($Conexion, $lista, $v_zona_pro, $v_fechreg_pro, $v_id_cat, $v_precio_pro, $v_preciodesc_pro, $v_id_prv, $v_precionormal_prv, $v_precioespecial_prv, $v_activ_pro, $ident_usuario);
							echo "<script> alert('Se esta registrando en bloque los productos en almacén...'); location.href = 'productos.php'; </script>";
						}
						else
						{
							echo "<script> alert('No se tienen todos los datos necesarios para proceder a registar la lista.'); location.href = 'prodbloq.php'; </script>";
						}
					}
					if($btn=="Cancelar")
					{
						echo "<script> alert('Se ha cancelado el ingreso de productos en bloque...'); location.href = 'productos.php'; </script>";
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'prodbloq.php'; </script>";
					}
				}
				?>
				<!------------------------------------------------ FORMULARIO ---------------------------------------------->
				<form name="usuario" action="" method="post">
					<span id="etq5">Zona:</span><?php cmbnormal("cmb_zona_pro", $v_zona_pro, "PDV_JXU4"); ?>
					<span id="etq5" style="width:50px;">Fecha:</span><?php txtronstl("txt_fechreg_pro",$v_fechreg_pro,"width:80px;");?>
					<span id="etq5" style="width:65px;">Catálogo:</span><?php cmbfield("cmb_id_cat",$Conexion,"SELECT * FROM catalogo WHERE activo_cat='S'",$v_id_cat,"id_cat","abrv_cat");?>
					<span id="etq5" style="width:115px;">Precio Norm. S/:</span><?php txtvalstl("txt_precio_pro",$v_precio_pro,10,"width:80px;");?>
					<span id="etq5" style="width:105px;">Precio Desc. S/:</span><?php txtvalstl("txt_preciodesc_pro",$v_preciodesc_pro,10,"width:80px;"); sl(1);?>
					<span id="etq5">Proveedor:</span><?php cmbfield("cmb_id_prv",$Conexion,"SELECT * FROM proveedores",$v_id_prv,"id_prv","nom_rzs_prv");?>
					<span id="etq5" style="width:105px;">Precio Prov. S/:</span><?php txtvalstl("txt_precionormal_prv",$v_precionormal_prv,10,"width:80px;");?>
					<span id="etq5" style="width:105px;">Precio Espe. S/:</span><?php txtvalstl("txt_precioespecial_prv",$v_precioespecial_prv,10,"width:80px;");?>
					<span id="etq5" style="width:80px;">Activo(S/N):</span><?php txtronstl("txt_activ_pro", 1, "width:80px;");?>
					<br>
					<?php
					lblnorm("Bloque de codigo invariable:","etq5"); txtvalstl("txt_bci",$v_cod_invariable,18,"width:200px;");
					lblnorm("Bloque de codigo variable:","etq8"); 
					lblnorm("Número inicial:","etq3");txtvalstl("txt_ni",$v_num_inicial,10,"width:100px;");
					lblnorm("Número final:","etq3");txtvalstl("txt_nf",$v_num_final,10,"width:100px;");
					?>
					<hr>
					<div>
						<?php
						btnnormal("btnGrl", "Generar Lista");
						btnnormal("btnGrl", "Cancelar");
						btnnormal("btnGrl", "Actualizar");
						?>
					</div>
					<hr>
					<?php
					if (count($lista)>0) 
					{
						mostrarlista($Conexion, $lista, $v_zona_pro, $v_fechreg_pro, $v_id_cat, $v_precio_pro, $v_activ_pro);
						btnnormal("btnGrl", "Aceptar y Añadir");
					}
					?>
				</form>
				<!---------------------------------------------- LSITADO DE DATOS EN TABLAS ---------------------------------------------->
				<?php
				//tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql,"tblnormal",$ambito_busqueda,"ID:id_pro:50:N","Cód.Prod.:cod_pro:70:N","Grupo:tipo_cat:80:N","Tipo:clase_cat:85:N","Catálogo de productos:id_cat:260:valfield|catalogo|abrv_cat|id_cat","Serie:serie_pro:115:N","Imei:imei_pro:115:N","Icc:icc_pro:150:N","Núm.Cel.:numcel_pro:100:N","Precio S/.:precio_pro:110:N","Fecha:fechreg_pro:80:invFech|","A.:activ_pro:30:N","Zona:zona_pro:70:N","Ult.Reg.Prec./Cant.:ultreg_pro:110:N");
				?>
			</div><!--Fin de main-col-->
			<?php scroll_doble("div1", "div2"); ?>
			<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function obtener_datos(&$zn,&$fc,&$ic,&$pr,&$preciodesc_pro,&$id_prv,&$precionormal_prv,&$precioespecial_prv,&$ac,&$bl,&$ni,&$nf)
{
	$zn=$_POST["cmb_zona_pro"];
	$fc=$_POST["txt_fechreg_pro"];
	$ic=$_POST["cmb_id_cat"];
	$pr=$_POST["txt_precio_pro"];
	$preciodesc_pro=$_POST["txt_preciodesc_pro"];
	$id_prv=$_POST["cmb_id_prv"];
	$precionormal_prv=$_POST["txt_precionormal_prv"];
	$precioespecial_prv=$_POST["txt_precioespecial_prv"];
	$ac=$_POST["txt_activ_pro"];
	$bl=$_POST["txt_bci"];
	$ni=$_POST["txt_ni"];
	$nf=$_POST["txt_nf"];
	//mensaje($zn."-".$fc."-".$ic."-".$pr."-".$preciodesc_pro."-".$id_prv."-".$precionormal_prv."-".$precioespecial_prv."-".$ac."-".$bl."-".$ni."-".$nf);
}
function validar_datos($zn,$fc,$ic,$pr,$preciodesc_pro,$id_prv,$precionormal_prv,$precioespecial_prv,$ac,$bl,$ni,$nf)
{
	//mensaje($zn." | ".$fc." | ".$ic." | ".$pr." | ".$preciodesc_pro." | ".$id_prv." | ".$precionormal_prv." | ".$precioespecial_prv." | ".$ac." | ".$bl." | ".$ni." | ".$nf);
	//var_dump($zn,$ic,$id_prv,$ac,$bl,$ni,$nf);sl(1);
	//if (!empty($zn) AND !empty($ic) AND !empty($id_prv) AND !empty($ac) AND !empty($bl) AND !empty($ni) AND !empty($nf))
	if (!empty($zn) AND !empty($ic) AND !empty($id_prv) AND !empty($ac) AND !empty($bl) AND is_numeric($ni) AND !empty($nf))
	{
		return True;
	}
	else
	{
		return False;
	}
}
function genera_lista($ni,$nf,$ci,&$lst)
{
	If ($ni<=$nf)
	{
		$c=$z="";
		$codfinal="";
		$i=1;
		$lg1=strlen($ni); $lg2=strlen($nf); $lg_dat=0;
		If ($lg1>=$lg2) $lg_dat=$lg1; Else $lg_dat=$lg2;
		For ($j=1; $j<=$lg_dat; $j++) $z=$z."0";
		for ($n=$ni; $n<=$nf; $n++)
		{
			$c=$z.$n; $c=substr($c,$lg_dat*-1);
			$codfinal=$ci.$c;
			$lst[$i]=$codfinal; $i++;
		}
	}
	Else
	{
		echo "<script> alert('Los valores de número inicial y final no son correctos.'); location.href = 'prodbloq.php'; </script>";
	}
}
function mostrarlista($conx,$lst,$zona,$fech,$idct,$prec,$acti)
{
	if (empty($prec)) $prec="0.00";
	$c="     |     "; $ln=strlen(count($lst));?>
	<pre><?php
	echo "LISTA DE SERIE/CODIGOS GENERADOS PARA ICC<br>";
	for ($i=1;$i<=count($lst);$i++)
	{
		echo substr("0000000".$i,$ln*-1),". ".$c,$zona,$c,$fech,$c,valfield($conx,"catalogo","abrv_cat","id_cat",$idct),$c,$prec,$c,$acti,$c,$lst[$i],"<br>";
	}?>
	</pre><?php
}
function insertardatos($conx,$lst,$zona,$fech,$idct,$prec,$v_preciodesc_pro,$v_id_prv,$v_precionormal_prv,$v_precioespecial_prv,$acti,$usua)
{
	if (empty($prec)) $prec="0.00";
	$tipo=valfield($conx,"catalogo","tipo_cat","id_cat",$idct);
	$clas=valfield($conx,"catalogo","clase_cat","id_cat",$idct);
	$marca_cat=valfield($conx,"catalogo","marca_cat","id_cat",$idct);
	$modelo_cat=valfield($conx,"catalogo","modelo_cat","id_cat",$idct);
	$abrv=$marca_cat." ".$modelo_cat;
	$fech=invFech($fech,"-");
	// Validación de precios
	if(empty($v_preciodesc_pro)) $v_preciodesc_pro=$prec;
	if(empty($v_precionormal_prv)) $v_precionormal_prv=$prec;
	if(empty($v_precioespecial_prv)) $v_precioespecial_prv=$prec;
	// $id_pro es null porque no se está actualizando un producto específico, sino insertando nuevos registros.
	$id_pro = null;
	for ($i=1;$i<=count($lst);$i++)
	{
		buscar_ultimos_precios($conx,$idct,$id_pro,$precio_anterior_pro,$fecha_anterior_pro,$id_anterior_prv,$precio_antes_anterior_pro,$fecha_antes_anterior_pro,$id_antes_anterior_prv);
		insertarsql($conx,"Error al insertar registro nuevo en productos.","productos",
		"id_cat",$idct,
		"icc_pro",$lst[$i],
		"precio_pro",$prec,
		"fechreg_pro",$fech,
		"activ_pro",$acti,
		"id_usr",$usua,
		"abrv_pro",$abrv,
		"zona_pro",$zona,
		"tipo_cat",$tipo,
		"clase_cat",$clas,
		"ultreg_pro",'0.00',
		"marca_cat",$marca_cat,
		"modelo_cat",$modelo_cat,
		"preciodesc_pro",$v_preciodesc_pro,
		"id_prv",$v_id_prv,
		"precionormal_prv",$v_precionormal_prv,
		"precioespecial_prv",$v_precioespecial_prv,
		"precio_anterior_pro",$precio_anterior_pro,
		"fecha_anterior_pro",$fecha_anterior_pro,
		"id_anterior_prv",$id_anterior_prv,
		"precio_antes_anterior_pro",$precio_antes_anterior_pro,
		"fecha_antes_anterior_pro",$fecha_antes_anterior_pro,
		"id_antes_anterior_prv",$id_antes_anterior_prv);
	}
}
function buscar_ultimos_precios($Conexion,$id_cat,$id_pro,&$precio_anterior_pro,&$fecha_anterior_pro,&$id_anterior_prv,&$precio_antes_anterior_pro,&$fecha_antes_anterior_pro,&$id_antes_anterior_prv)
{
	if (empty($id_pro)) {
		// Si no se ha proporcionado un id_pro, se genera la consulta sin usar id_pro
		$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$id_cat' GROUP BY precio_pro, fechreg_pro ORDER BY id_pro DESC LIMIT 2";
	} else {
		$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$id_cat' AND id_pro<'$id_pro' GROUP BY precio_pro, fechreg_pro ORDER BY id_pro DESC LIMIT 2";
	}
	//mensaje($cadena_buscar_ultimos_precios);
	$sql_ultimos_precios = mysqli_query($Conexion, $cadena_buscar_ultimos_precios) or die ("Error al consultar productos para obtener los ultimos precios");
	if (mysqli_num_rows($sql_ultimos_precios) == 0)
	{
		// Si no hay registros, se retorna un precio por defecto
		$precio_anterior_pro = 0;
		$fecha_anterior_pro = "";
		$id_anterior_prv = 0;
		$precio_antes_anterior_pro = 0;
		$fecha_antes_anterior_pro = "";
		$id_antes_anterior_prv = 0;
	}
	if (mysqli_num_rows($sql_ultimos_precios) == 1)
	{
		// Si solo hay un registro, se retorna el precio del único registro encontrado
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_anterior_prv = $ultimos_precios["id_prv"];
		// Se asigna un valor por defecto para el segundo precio
		$precio_antes_anterior_pro = 0;
		$fecha_antes_anterior_pro = "";
		$id_antes_anterior_prv = 0;
	}
	if (mysqli_num_rows($sql_ultimos_precios) == 2)
	{
		// Si hay dos registros, se retorna el precio de los dos ultimos precios
		// Ultimo precio
		mysqli_data_seek($sql_ultimos_precios, 0);
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_anterior_prv = $ultimos_precios["id_prv"];
		// Precio antes del ultimo precio
		mysqli_data_seek($sql_ultimos_precios, 1);
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_antes_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_antes_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_antes_anterior_prv = $ultimos_precios["id_prv"];
	}
}
?>
