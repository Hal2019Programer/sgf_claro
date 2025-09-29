<?php
CONST web_empresa="www.ecositi.com.pe";
CONST url_web_empresa="http://www.ecositi.com.pe/";
CONST correo1="helicellshop@gmail.com ";
CONST correo2="helicellshop@gmail.com ";
CONST correo3="helicellshop@gmail.com ";
CONST razon_social_empresa="HELI CELL SHOP";
CONST razon_social_rubro="HELI CELL SHOP";
CONST razon_social_year="HeliCell - 2025";
CONST nombre_comercial="HELI CELL SHOP";
CONST ruc_empresa="10413437186";
CONST ubigeo_empresa="120303";
CONST direccion_empresa="Jr. Progreso 256";
CONST distrito_empresa="San Ramon";
CONST provincia_empresa="Chanchamayo";
CONST region_empresa="Junin";
CONST base_datos_host="localhost";
CONST base_datos_usuario="root";
CONST base_datos_password="";
CONST base_datos="sgf_claro";

function sl($a)
/* Funcion sl se puede usar como un salto de linea o retorno evitando echo + <br>
el parametro $a permite indicar mas espacios */
{
	if ($a>1)
	{
		for ($c=1; $c<=$a; $c++)
		{
			echo "<br>";
		} 
	}
	else
	{
		echo "<br>";
	}
}
function ls()
/* Funcion ls genera una linea de separación, equivalente a <hr> */
{	echo "<hr>"; }
?>
<?php
function tabla01()
/* Funcion que crea tablas */
{
?>
		<table width="100%" border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="10">
			<tr> 
				<th>Encabezado 1</th><th>Encabezado 2</th><th>Encabezado 3</th>
			</tr>
			<tr> 
				<td rowspan="2" valign="middle" align="left">Este texto está alineado al centro verticalmente y a la izquierda horizontalmente</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr> 
				<td colspan="2">&nbsp;</td>
			</tr>
		</table>
<?php
}
?>
<?php
function tabla02($f,$c)
/* Funcion que crea tablas de acuerdo a los parámetros $f (filas)
y $c (columnas) */
{
?>
		<table width="100%" border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="10">
			<tr> 
				<?php for ($n=1; $n<=$c; $n++) { ?>
					<th>Encabezado <?php echo $n; ?> </th>
				<?php } ?>
			</tr>
			<?php for ($m=1; $m<=$f; $m++) { ?>
				<tr> 
					<?php for ($n=1; $n<=$c; $n++) { ?>
						<td><?php echo "Fila $m Col $n" ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
		</table>
<?php
}
?>
<?php
function obtener_matriz($conx,&$arreglo,&$rows)
/* Función que convierte un datarecord o consulta en un arreglo o matriz previamente definido.
Los parámetros son valores por referencia.
$conx	:     identificador de conexion con la consulta de la tabla (datarecord)
$arreglo :     arreglo o matriz definido vacío (para llenar con la consulta (datarecord))
$rows    :     variable que almacena la cantidad de filas que tiene la consulta (datarecord)
Solo almacena las tres primeras columnas (indice 0, 1, 2 y 3).*/
{
	$f=0;
	$c=0;
	mysqli_data_seek($conx, 0); 
	while($resul = mysqli_fetch_array($conx))
	{
		for($c=0;$c<=3;$c++)
		{
			$arreglo[$f][$c]=$resul[$c];
		}
		$f++;
	}
	$rows=mysqli_num_rows($conx);
	mysqli_data_seek($conx, 0); 
}
?>
<?php
function busca_id($arreglo,$rows,$d)
/* Funcion que busca el campo Id de una tabla o lista
de datos dentro de los datos del arreglo o matriz.
$arreglo :      arreglo o matriz con datos (obtenido con la función obtener_matriz)
$rows    :      cantidad de filas que tiene el arreglo o matriz
$id      :      variable que contiene el dato del id para buscar */
{
	$valor=-1;
	$f=0;
	for($f=0;$f<=$rows-1;$f++)
	{
		$dato=$arreglo[$f][0];
		if ($d==$dato)
		{
			$valor=$f;
			break;
		}
	}
	return $valor;
}
?>
<?php
function act_menu01($op_menu,$cat_usuario,$lvl_usuario,$categoria)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 1 categoria. */
{
	if ($cat_usuario==$categoria)
	{
		echo $op_menu;
	}
}
function act_menu02($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 2 categorias. */
{
	if ($cat_usuario==$categoria1 || $cat_usuario==$categoria2)
	{
		echo $op_menu;
	}
}
function act_menu02a($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 2 categorias. */
{
	if ($cat_usuario==$categoria1 || ($cat_usuario==$categoria2 AND $lvl_usuario=="sup"))
	{
		echo $op_menu;
	}
}
function act_menu03($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2,$categoria3)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 3 categorias. */
{
	if ($cat_usuario==$categoria1 || $cat_usuario==$categoria2 || $cat_usuario==$categoria3)
	{
		echo $op_menu;
	}
}
function act_menu03a($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2,$categoria3)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 3 categorias. */
{
	if ($cat_usuario==$categoria1 || $cat_usuario==$categoria2 || ($cat_usuario==$categoria3 AND $lvl_usuario=="sup"))
	{
		echo $op_menu;
	}
}
function act_menu04($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2,$categoria3,$categoria4)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 4 categorias. */
{
	if ($cat_usuario==$categoria1 || $cat_usuario==$categoria2 || $cat_usuario==$categoria3 || $cat_usuario==$categoria4)
	{
		echo $op_menu;
	}
}
function act_menu05($op_menu,$cat_usuario,$lvl_usuario,$categoria1,$categoria2,$categoria3,$categoria4,$categoria5)
/* Funcion que activa (muestra) la opción del menu que coincida o corresponde
al nivel de usuario para 5 categorias. */
{
	if ($cat_usuario==$categoria1 || $cat_usuario==$categoria2 || $cat_usuario==$categoria3 || $cat_usuario==$categoria4 || $cat_usuario==$categoria5)
	{
		echo $op_menu;
	}
}
?>
<?php
function menu02()
/* Función que presenta un menu básico consistente en dos opciones:
Inicio: que regresa a la pantalla de inicio principal, y,
Salir: que sale al formulario de acceso al sistema (login) */
{
?>
	<div>
		<ul class="nav">
			<li class="active"><a href="../admin/menugeneral.php" style="margin-top:10px; margin-left:10px; width:45px; text-align:center;">Inicio</a></li>
			<li><a href="../cerrar_sesion.php" style="margin-top:10px; width:45px; text-align:center;">Salir</a></li>
		</ul>
	</div>
<?php
}
?>
<?php
function sesion01(&$id_usuario, &$name_usuario, &$nomb_usuario, &$apel_usuario, &$level_usuario, &$zone_usuario, &$cate_usuario)
/* Detecta la existencia de sesión. Si ya hay una sesión continua, sino envía al usuario a la pagina de login.
Si hay sesión recupera las variables de SESSION existente para el uso en la página */
{
	session_start();
	If (!$_SESSION) header("Location: ../index.php");
	Else
	{
		$id_usuario=$_SESSION['iden_usr'];
		$name_usuario=$_SESSION['nomb_usr'];
		$nomb_usuario=$_SESSION['nmbr_usr'];
		$apel_usuario=$_SESSION['aplu_usr'];
		$level_usuario=$_SESSION['nivl_usr'];
		$zone_usuario=$_SESSION['zona_usr'];
		$cate_usuario=$_SESSION['catg_usr'];
	}
}
?>
<?php
function pestanna($nomusr, $nivusr, $idusr, $znusr, $catusr, $titulo)
/* Coloca datos en la pestaña de la página como el titulo de la página y datos de usuario, que son:
Codigo, nombre, nivel, categoria y zona de usuario. */
{
?>
	<meta http-equiv="Content-Type" content="test/html" charset="utf-8"/>
	<link rel="stylesheet" href="../estilos/estilo.css" type="text/css">
	<title><?php echo $titulo ?> (<?php echo $idusr,":",$nomusr,":",$nivusr,":",$catusr,":",$znusr;?>)</title>
<?php
}
?>
<?php
function pestanna_01($nomusr, $nivusr, $idusr, $znusr, $catusr, $titulo)
/* Coloca datos en la pestaña de la página como el titulo de la página y datos de usuario, que son:
Codigo, nombre, nivel, categoria y zona de usuario. */
{
?>
	<meta http-equiv="Content-Type" content="test/html" charset="utf-8"/>
	<title><?php echo $titulo ?> (<?php echo $idusr,":",$nomusr,":",$nivusr,":",$catusr,":",$znusr;?>)</title>
<?php
}
?>
<?php
function cabecera01($titul)
/* Función que presenta la cabecera de una página Web.
Incluye un fondo de imágen de 100px de alto y un texto que aparece en la derecha por el padding
que es de 650px.*/
{
?>

	<div id="header" style="height: 100px; background-image: url(''); padding:0px;">
		<div id="logo" style="padding-left:650px; padding-top:10px;"><h1><?php echo $titul ?></h1></div>
	</div>
		
<?php
}
?>
<?php
/* Función que presenta la cabecera de una página Web.
Incluye un fondo de imágen de 100px de alto y un texto que aparece en la izquierda.*/
function cabecera02($titul)
{ ?>
	<div>
		<article style="height:125px; background-color:white; padding:10px;"><img src="../imagenes/logo_heli(3).gif" style="height:125px;"></article>
		<!--<div id="logo" style="padding-left:1100px;color:#0A2C4F;margin-top:-3px;"><h1><?php echo $titul ?></h1></div>-->
	</div>
<?php
}
?>
<?php
function cabecera03($titul)
/* Función que presenta la cabecera de una página Web.
Incluye un fondo de imágen de 66px de alto y un texto en la cabecera.*/
{
?>
	<div id="header" style="height: 66px; background-image: url(''); padding:0px;">
		<div id="logo" style="height: 66px; padding-left:20px; padding-top:0px; font-size:12px;"><h1><?php echo $titul ?></h1></div>
	</div>
<?php
}
function cabecera04($niv=0,$titulo)
{ ?>
	<article style="height:120px; background-color:var(--color-rojo); border-radius:10px 10px 10px 10px; padding:5px;">
		<table style="width:100%;">
			<tr>
				<td style="width:120px;">
					<?php 
					if ($niv==1) { 
						echo "<img src='imagenes/logo_heli(3).gif' style='width:120px; height:120px; float:left;'>"; }
					else {
						echo "<img src='../imagenes/logo_heli(3).gif' style='width:120px; height:120px; float:left;'>"; } ?>
				</td>
				<td style="width:calc(100% - 120px); text-align:center; color:var(--color-blanco); font-size:xx-large; font-weight:bold;"><?php echo $titulo; ?></td>
			</tr>
		</table>
	</article> <?php
}


?>
<?php
function btnnormal($nombre, $valor)
/* Función que muestra el objeto boton de comando simple (necesita name y value) */
{
?>
	<input type="submit" name="<?php echo $nombre;?>" value="<?php echo $valor ?>"/>
<?php
}
?>
<?php
function txtnormal($nombre)
/* Función que muestra el objeto texto simple (solo necesita el name) */
{
?>
	<input type="text" name="<?php echo $nombre;?>"/>
<?php
}
?>
<?php
function txtnrmstl($nombre,$style)
/* Función que muestra el objeto texto simple (solo necesita el name y style) 
con comandos de estilo */
{
?><input type="text" name="<?php echo $nombre;?>" style="<?php echo $style; ?>"/><?php
}
?>
<?php
function txtoculto($nombre, $valor)
/* Función que muestra el objeto texto oculto (necesita name y value) */
{
?>
	<input type="hidden" name="<?php echo $nombre;?>" id="<?php echo $nombre;?>" value="<?php echo $valor; ?>"/>
<?php
}
?>
<?php
function txtrdonly($nombre, $valor)
/* Función que muestra el objeto texto de solo lectura (necesita name y value) */
{
?>
	<input type="text" name="<?php echo $nombre;?>" style="background:rgb(230,230,255);" readonly="readonly" value="<?php echo $valor ?>"/>
<?php
}
?>
<?php
function txtrdonly01($nombre, $valor)
/* Función que muestra el objeto texto de solo lectura (necesita name y value)
con un ancho máximo de 50px. */
{
?>
	<input type="text" name="<?php echo $nombre;?>" style="background:rgb(230,230,255); width:50px;" readonly="readonly" value="<?php echo $valor ?>"/>
<?php
}
?>
<?php
function txtronstl($nombre, $valor, $style)
/* Función que muestra el objeto texto de solo lectura (necesita name, value y style)
con comandos de estilos */
{
	$style="background:rgb(230,230,255); ".$style;
?>
	<input type="text" name="<?php echo $nombre;?>" style="<?php echo $style;?>" readonly="readonly" value="<?php echo $valor;?>"/>
<?php
}
function txtronstl01($nombre, $valor, $tipo, $style)
/* Función que muestra el objeto texto de solo lectura (necesita name, value y style)
con comandos de estilos */
{
	$style="background:rgb(230,230,255); ".$style;
?>
	<input type="<?php echo $tipo;?>" name="<?php echo $nombre;?>" style="<?php echo $style;?>" readonly="readonly" value="<?php echo $valor;?>"/>
<?php
}
?>
<?php
function txtvalue($nombre, $valor, $longitud)
/* Función que muestra el objeto texto con valor (necesita name y value).
El parámetro $longitud limita el ingreso de caracteres a una longitud máxima */
{
?>
	<input type="text" name="<?php echo $nombre;?>" value="<?php echo $valor ?>" maxlength="<?php echo $longitud ?>"/>
<?php
}
?>
<?php
function txtvalstl($nombre, $valor, $longitud, $style)
/* Función que muestra el objeto texto con valor (necesita name y value).
El parámetro $longitud limita el ingreso de caracteres a una longitud máxima */
{
?>
	<input type="text" name="<?php echo $nombre;?>" id="<?php echo $nombre;?>" value="<?php echo $valor; ?>" maxlength="<?php echo $longitud; ?>" style="<?php echo $style;?>"/>
<?php
}
function txtvalue01($nombre, $valor, $longitud, $tipo, $style)
/* Función que muestra el objeto texto con valor (necesita name y value).
El parámetro $longitud limita el ingreso de caracteres a una longitud máxima */
{
?>
	<input type="<?php echo $tipo;?>" name="<?php echo $nombre;?>" value="<?php echo $valor ?>" maxlength="<?php echo $longitud ?>" style="<?php echo $style;?>"/>
<?php
}
function txtNrStJs($nom_id,$valor,$tipo,$longMax,$style,$eventoJs)
/* Función que muestra el objeto <input>, por lo general usado como textBox. Requiere 6 parametros:
$nom_id   = Nombre del identificador del elemento HTML. Este valor se asigna al id y al name del objeto.
$valor    = Valor que aparece dentro del objeto <input>.
$tipo     = Tipo de objeto <input>. Estos valores pueden ser: text, date, button, etc.
$longMax  = Maximo de caracteres que el objeto recibe, si el <input> es tipo textBox
$style    = Estilos para el objuetos en formato CSS
$eventoJs = Evento y funcion JavaScript asignado al objeto */
{ ?>
	<input type="<?php echo $tipo;?>" id="<?php echo $nom_id;?>" name="<?php echo $nom_id;?>" value="<?php echo $valor ?>" maxlength="<?php echo $longMax ?>" style="<?php echo $style;?>" <?php echo $eventoJs;?>/> <?php
}
?>
<?php
function cmbnormal($nombre, $valor)
/* Función que carga el objeto select(combo box) con distintos valores.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan*/
{
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
?>
	<div id="fondo_select" style="display:inline-block;">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 2; $i < $cuentaparm; $i++)
			{
			?>
				<option value="<?php echo $arrayparam[$i];?>"<?php if($valor==$arrayparam[$i]) echo " selected='selected'";?>><?php echo $arrayparam[$i];?></option>
			<?php
			}
			?>
		</select>
	</div>
<?php
}
function cmbNormJs($id_div, $id_select, $valor, $evento)
/* Función que carga el objeto select(combo box) con distintos valores.
Ejemplo:
	cmbNormJs("div_select_grupo","cmbtpc",$var1,"onchange=\"CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact')\";", "Equipo", "Modem", "Chip", "Recarga", "Tableta", "Servicios", "Accesorios", "Otros");
Los parametros son:
$id_div : nombre o identificador del id div que envuelve al select
$id_select : nombre o identificador del select / options
$valor : valor o dato que se activa como selected cuando existe
$evento : cadena de la función o evento JavaScript que se activa con la acción del usuario

Los parámetros adicionales luego de $$id_div, $id_select, $valor, $evento son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan*/
{
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	?>
	<div id="<?php echo $id_div?>" class="fondo_select" style="display:inline-block;">
		<select name="<?php echo $id_select;?>" id="<?php echo $id_select;?>" <?php echo $evento;?>>
			<option value=""> </option>
			<?php
			for($i = 4; $i < $cuentaparm; $i++)
			{
			?>
				<option value="<?php echo $arrayparam[$i];?>"<?php if($valor==$arrayparam[$i]) echo " selected='selected'";?>><?php echo $arrayparam[$i];?></option>
			<?php
			}
			?>
		</select>
	</div>
	<?php
}
function cmbNormJs_span($id_span, $id_select, $valor, $evento)
{
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	?>
	<span id="<?php echo $id_span?>" class="fondo_select">
		<select name="<?php echo $id_select;?>" id="<?php echo $id_select;?>" <?php echo $evento;?>>
			<option value=""> </option>
			<?php
			for($i = 4; $i < $cuentaparm; $i++)
			{
			?>
				<option value="<?php echo $arrayparam[$i];?>"<?php if($valor==$arrayparam[$i]) echo " selected='selected'";?>><?php echo $arrayparam[$i];?></option>
			<?php
			}
			?>
		</select>
	</span>
	<?php
}




?>
<?php
function cmbnormal_onchg($nombre, $valor)
/* Función que carga el objeto select(combo box) con distintos valores.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan*/
{
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
?>
	<div id="fondo_select">
		<select name="<?php echo $nombre;?>" onchange="javascript:seleccionar_valor(this.value);">
			<option value=""> </option>
			<?php
			for($i = 2; $i < $cuentaparm; $i++)
			{
			?>
				<option value="<?php echo $arrayparam[$i];?>"<?php if($valor==$arrayparam[$i]) echo " selected='selected'";?>><?php echo $arrayparam[$i];?></option>
			<?php
			}
			?>
		</select>
	</div>
<?php
}
function cmbfieldJs($id_tag,$nomb_select,$Conexion,$cadena_sql,$campo_valor,$eventoJs)
/* Función que genera un objeto <select><option> (combobox) envuelto en un objeto
   <div> rellenado con datos de campos de una tabla.
	El combobox también tiene un evento JavaScript que se puede usar para cargar,
	modificar o reemplazar otros objetos o elementos HTML del DOM.
	El combobox se rellena de una consulta que se hace a una tabla usando los 
	comandos del MySql (SELECT). Los datos que se muestran en el combobox al
	desplegarse se insertan como parametros al final del combobox.
	Los parametros fijos son los siguientes:
	$nomb_select = nombre del objeto <select>
	$Conexion    = Conexion de la base de datos
	$cadena_sql  = Cadena con los comandos MySql (especificamente SELECT, pero
	               también podrían ser otros)
	$campo_valor = Esta variable contiene un valor que se compara con las opciones
	               de la lista del combobox para seleccionar o mostrarlo en caso
						coincidencia, usado por ejemplo cuando se modifica un registro
	El <option value="" (que es el valor que devuelve el combobox cuando se 
	selecciona) corresponde al quinto parámetro de la lista de argumentos 
	(por ejemplo $registro[$arrayparam[4]]). Al inicio no tiene valor, por lo que
	el combobox se muestra en blanco. Si la variable $campo_valor tiene un valor
	(o dato) entonces el combobox lo compara y si coincide con alguno de los
	valores de su lista, activa su opcion ...selected='selected'... y lo muestra.
	Los demas parametros que se agregan a la función después de $campo_valor son 
	los campos que se desean mostrar en la lista del combobox.
	Por ejemplo:
	              cmbfield(
					  "cmb_cod_ubigeo",
					  $Conexion,
					  "SELECT * FROM ubigeo WHERE 1",
					  $cod_ubigeo,
					  "id_ubi","regi_ubi","prov_ubi","dist_ubi");
	A partir del quinto parametro, se pueden agregar muchos más, que serían los 
	campos obtenidos de la consulta SELECT. En el comobobox estos se concatenan
	en el orden en el que se colocan y son separan con : y se muestran en la lista.
	Por lo general el quinto parámetro (en el ejemplo sería "id_ubi") es el que se 
	toma como valor mas importante al seleccionar una opción del combobox.	*/
{
	$campos="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	$resultado_de_consulta = mysqli_query($Conexion,$cadena_sql);
	if (!$resultado_de_consulta)
	{
		echo "Mensaje de error de consulta en cmbfieldJs: ", mysqli_error($Conexion), "<br>";
	}
	else
	{
		$opciones_cmb="";
		$filas=mysqli_num_rows($resultado_de_consulta);
		if ($filas > 0)
		{
			while($registro=mysqli_fetch_array($resultado_de_consulta, MYSQLI_ASSOC))
			{
				for($i = 6; $i < $cuentaparm; $i++)
				{
					$contenido_parametro = $registro[$arrayparam[$i]];
					if ($contenido_parametro==null OR trim($contenido_parametro)=="-") $contenido_parametro=" ";
					$campos.=$contenido_parametro." : ";
				}
				$campos=trim($campos); $campos=substr($campos, 0, strlen($campos)-1);
				if ($campo_valor==$registro[$arrayparam[6]]) $validacion=" selected='selected'"; else $validacion="";
				$opciones_cmb.="<option value='".$registro[$arrayparam[6]]."'".$validacion.">".$campos."</option>";
				$campos="";
			}
		}
	}?>
	<div id="<?php echo $id_tag?>" class="fondo_select" style="display:inline-block;">
		<select name="<?php echo $nomb_select;?>" id="<?php echo $nomb_select;?>" <?php echo $eventoJs;?>>
			<option value=""> </option>
			<?php echo $opciones_cmb; ?>
		</select>
	</div><?php
}
function cmbfieldJs_span($id_tag,$nomb_select,$Conexion,$cadena_sql,$campo_valor,$eventoJs)
{
	$campos="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	$resultado_de_consulta = mysqli_query($Conexion,$cadena_sql);
	if (!$resultado_de_consulta)
	{
		echo "Mensaje de error de consulta en cmbfieldJs: ", mysqli_error($Conexion), "<br>";
	}
	else
	{
		$opciones_cmb="";
		$filas=mysqli_num_rows($resultado_de_consulta);
		if ($filas > 0)
		{
			while($registro=mysqli_fetch_array($resultado_de_consulta, MYSQLI_ASSOC))
			{
				for($i = 6; $i < $cuentaparm; $i++)
				{
					$contenido_parametro = $registro[$arrayparam[$i]];
					if ($contenido_parametro==null OR trim($contenido_parametro)=="-") $contenido_parametro=" ";
					$campos.=$contenido_parametro." : ";
				}
				$campos=trim($campos); $campos=substr($campos, 0, strlen($campos)-1);
				if ($campo_valor==$registro[$arrayparam[6]]) $validacion=" selected='selected'"; else $validacion="";
				$opciones_cmb.="<option value='".$registro[$arrayparam[6]]."'".$validacion.">".$campos."</option>";
				$campos="";
			}
		}
	}?>
	<span id="<?php echo $id_tag?>" class="fondo_select">
		<select name="<?php echo $nomb_select;?>" id="<?php echo $nomb_select;?>" <?php echo $eventoJs;?>>
			<option value=""> </option>
			<?php echo $opciones_cmb; ?>
		</select>
	</span><?php
}
function cmbfield($nombre,$conx,$cadena_sql,$campo_valor)
/* Función que carga el objeto select(combo) con varios campos de una tabla:
$nombre = nombre del objeto select (combobox)
$conx = conexion de la base de datos
$cadena_sql = cadena con los comandos Select, Insert, Update, etc. del sql
$campo_valor = campo que se usa como campo de value para las opciones
El option value (que es es valor que devolvera el combobox al ser seleccionado
corresponde al quinto parámetro de la lista de argumentos ($registro[$arrayparam[4]]).
Los demas parametros que se agregan a la función son los campos que se desean
tener en la lista del select (combobox).
NOTA: En la lista que se agrega se puede incluir tanto campos de la tabla como
una cadena para mezclar la presentación de la lista de opciones. */
{
	$campos="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	//$res_consulta=mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta");
	$res_consulta=mysqli_query ($conx,$cadena_sql);
	if (!$res_consulta) {
		printf("Errormessage: %s\n", mysqli_error($conx));
  }
echo mysqli_error($conx);

	$filas=mysqli_num_rows($res_consulta);
	if ($filas > 0)
	{
		$opciones_cmb="";
		while($registro=mysqli_fetch_array($res_consulta, MYSQLI_ASSOC))
		{
			for($i = 4; $i < $cuentaparm; $i++)
			{
				if (isset($registro[$arrayparam[$i]]))
				{
					if (trim($registro[$arrayparam[$i]])=="-")
					{
						$campos.="  : ";
					}
					else
					{
						$campos.=$registro[$arrayparam[$i]]." : ";
					}
				}
				else
				{
					//$campos.=$arrayparam[$i];
					$campos.="  : ";
				}
				//$campos.=$registro[$arrayparam[$i]]." : ";
			}
			$campos=trim($campos);$campos=substr($campos, 0, strlen($campos)-1);
			if ($campo_valor==$registro[$arrayparam[4]]) $validacion=" selected='selected'"; else $validacion="";
			$opciones_cmb.="<option value='".$registro[$arrayparam[4]]."'".$validacion.">".$campos."</option>";
			$campos="";
		}
	}
	else
	{
		echo "No hubo resultados";
	} ?>
	<div id="fondo_select" style="display:inline-block;">
		<select name="<?php echo $nombre;?>">
			<option value="0"> </option>
			<?php echo $opciones_cmb; ?>
		</select>
	</div> <?php
}
function combo_select($nombre_div, $nombre_combo_select, $Conexion, $cadena_sql, $campo_valor)
/* Función que carga el objeto select(combo) con varios campos de una tabla:

$nombre_div = Nombre del contenedor div, usado para recuperar datos cuando se usa
una función Ajax.
$nombre_combo_select = Nombre del objeto select (combobox)
$Conexion = Conexion de la base de datos
$cadena_sql = Cadena con los comandos Select, Insert, Update, etc. del sql
$campo_valor = Campo que se usa como campo de value para seleccionar la opción
elegida o existente. En caso de que sete valor es vacio el combo select tambien
se muestra vacio a la espera de elegir un valor.

El option value (que es es valor que devolvera el combobox al ser seleccionado)
se corresponde a los parametros que se añaden a la funcion desde el quinto hacia
adelante de la lista de argumentos ($registro[$arrayparam[4]]). Cada campo agregado
se divide entre ellos con ':' y asi aparecen en el select. Por ej.:

combo_select("cmbctl",$Conexion,"SELECT * FROM catalogo",$v_id_cat,"id_cat","abrv_cat","activo_cat", ...)

NOTA: En la lista que se agrega se puede incluir tanto campos de la tabla como
una cadena para mezclar la presentación de la lista de opciones. */
{
	$campos="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	$res_consulta=mysqli_query ($Conexion,$cadena_sql);
	if (!$res_consulta) {
		printf("Errormessage: %s\n", mysqli_error($Conexion));
  }
echo mysqli_error($Conexion);

	$filas=mysqli_num_rows($res_consulta);
	if ($filas > 0)
	{
		$opciones_cmb="";
		while($registro=mysqli_fetch_array($res_consulta, MYSQLI_ASSOC))
		{
			for($i = 5; $i < $cuentaparm; $i++)
			{
				if (isset($registro[$arrayparam[$i]]))
				{
					if (trim($registro[$arrayparam[$i]])=="-")
					{
						$campos.="  : ";
					}
					else
					{
						$campos.=$registro[$arrayparam[$i]]." : ";
					}
				}
				else
				{
					$campos.="  : ";
				}
			}
			$campos=trim($campos);$campos=substr($campos, 0, strlen($campos)-1);
			if ($campo_valor==$registro[$arrayparam[5]]) $validacion=" selected='selected'"; else $validacion="";
			$opciones_cmb.="<option value='".$registro[$arrayparam[5]]."'".$validacion.">".$campos."</option>";
			$campos="";
		}
	}
	else
	{
		echo "No hubo resultados";
	} ?>
	<div id="<?php echo $nombre_div;?>" class="fondo_select">
		<select name="<?php echo $nombre_combo_select;?>">
			<option value="0"> </option>
			<?php echo $opciones_cmb; ?>
		</select>
	</div> <?php
}
function cmb_cliente($nombre,$conx,$cadena_sql,$campo_valor)
/* Función basado en la misma estructura de cmbfield donde se carga al cliente predeterminado. */
{
	$campos=""; $arrayparam = func_get_args(); $cuentaparm = count($arrayparam);
	$res_consulta=mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta");
	$filas=mysqli_num_rows($res_consulta);
	if ($filas > 0)
	{
		$opciones_cmb="";
		while($registro=mysqli_fetch_array($res_consulta, MYSQLI_ASSOC))
		{
			for($i = 4; $i < $cuentaparm; $i++)
			{
				if (isset($registro[$arrayparam[$i]]))
				{
					if (trim($registro[$arrayparam[$i]])=="-")
					{ 	$campos.="  : "; }
					else
					{ 	$campos.=$registro[$arrayparam[$i]]." : "; }
				}
				else
				{ $campos.="  : "; }
			}
			$campos=trim($campos);$campos=substr($campos, 0, strlen($campos)-1);
			if ($campo_valor==$registro[$arrayparam[4]]) $validacion=" selected='selected'"; else $validacion="";
			$opciones_cmb.="<option value='".$registro[$arrayparam[4]]."'".$validacion.">".$campos."</option>";
			$campos="";
		}
	}
	else
	{
		echo "No hubo resultados";
	}
	$texto=valfldmul($conx,"clientes","id_cli",23435,"id_cli", "nom_rzs_cli", "dni_ruc_cli", "direcc_cli", "lugar_cli");
?>
	<div id="fondo_select">
		<select name="<?php echo $nombre;?>">
			<option value="23435"><?php echo $texto; ?></option>
			<?php echo $opciones_cmb; ?>
		</select>
	</div>
<?php
}

function cmbarreglo($nombre, $valor, $datos)
/* Función que carga el objeto select(combo box) con distintos valores desde el arreglo.
La variable $datos luego de $nombre y $valor son los datos del arreglo que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan*/
{
	$arrayparam = func_get_args();
	$cuentaparm = count($datos);
?>
	<div id="fondo_select">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 0; $i < $cuentaparm; $i++)
			{
			?>
				<option value="<?php echo $datos[$i];?>"<?php if($valor==$datos[$i]) echo " selected='selected'";?>><?php echo $datos[$i];?></option>
			<?php
			}
			?>
		</select>
	</div>
<?php
}
?>
<?php
function valfldmul($conx,$tabla,$campoid,$valor)
/* Función que obtiene varios valores desde una tabla y los
concatena en un solo texto, filtrando un único campo para
obtener un solo registro.
$conx : Conexión con la base de datos
$tabla : Nombre de la tabla de donde se obtiene datos
$campoid : Campo de la tabla con el id unico e irrepetible
$valor: Valor usado para filtrar el registro único de la tabla */
{
	$campos="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam); //cuenta cuantos parametros tiene la función
	if (!empty($valor))
	{
		$cadena_sql="SELECT * FROM ".$tabla." WHERE ".$campoid."=".$valor;
		$res_consulta=mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta"); // Realiza una consulta SQL con $conx y $cadena_sql
		if (mysqli_num_rows($res_consulta)>0) // Si hay registros en la consulta
		{
			$registro=mysqli_fetch_array($res_consulta, MYSQLI_ASSOC); // Obtiene el 1er registro de $res_consulta
			for($i = 4; $i < $cuentaparm; $i++) // Obtiene todos los parametros de $arrayparam desde el 4to hasta el ultimo
			{
				$campos.=$registro[$arrayparam[$i]]." : ";
			}
			$campos=trim($campos);$campos=substr($campos, 0, strlen($campos)-1);
		} else {
			$campos="Sin datos del producto.";
		}
		
	}
	return $campos; //valor retornado
}
?>
<?php
function bloque_derecho()
// Genera un bloque en el lado derecho con contenidos diversos: texto, mensajes, imágenes, etc.
{
?>
	<div id="side-col">
        <h3>Nosotros</h3>
        <p><b>ECOSITI S.A.C.</b> es una empresa representante de Bitel Perú como disribuidor autorizado del servicio de telecomunicaciones y datos con presencia en todas regiones del Perú, teniendo como objetivo principal la venta de Servicios y Productos de Telecomunicaciones, cuyo objetivo se sustenta en la integración de las personas a través de las tecnologías de comunicación.</p>
    </div>
<?php
} 
?>
<?php
// Genera el pie de página de la página
function pie_pagina()
{
?>
	<div">
		<p>HELICELL - 2025</p>
	</div>
<?php
}
?>
<?php
function invFech($fecha,$separador='-')
/* Funcion que invierte el formato de fecha para visualizar o guardar
De un formato AA-MM-DD pasa a DD-MM-AA. Solo es para fechas en número. */
{
    if($fecha == '') return NULL;
    $newfecha = explode($separador, $fecha);
    return $newfecha[2].$separador.$newfecha[1].$separador.$newfecha[0]; //valor retornado
}  
?>
<?php
function valfield($conx,$tabla,$campo,$campoid,$valor)
/* Funcion que obtiene un único valor desde una consulta a una tabla
$conx = conexión a la base de datos activa.
$tabla = la tabla desde donde se obtiene el valor de campo
$campo = campo desde donde se obtiene el dato
$campoid = campo id de la tabla para filtrar solo el dato deseado
$valor = variable que contiene el valor a comparar con el $campoid para el filtro */
{
	if (is_null($valor)) { $valor=0; }
	$cadena_sql="SELECT ".$campo." FROM ".$tabla." WHERE ".$campoid."=".$valor;
	//mensaje($cadena_sql);
	$res_consulta=mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta de registro filtrado por Id");
	if (mysqli_num_rows($res_consulta)>0)
	{
		$registro=mysqli_fetch_array($res_consulta);
		return $registro[0]; //valor retornado
	}
	else 
	{
		//mensaje($cadena_sql);
		return ""; //valor retornado
	}
}
?>
<?php
function valfieldlast($conx,$tabla,$campo,$campoid,$valor)
/* Funcion que obtiene un único valor desde una consulta a una tabla igual a función valfield
pero se asegura que sea el ultimo registro ingresado */
{
	if (!is_numeric($valor))
	{
		$cadena_sql="SELECT ".$campo." FROM ".$tabla." WHERE ".$campoid."='".$valor."'";
	}
	else
	{
		$cadena_sql="SELECT ".$campo." FROM ".$tabla." WHERE ".$campoid."=".$valor;
	}
	$res_consulta=mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta de ultimo registro");
	// Cuenta cuantos registros tiene la consulta
	$filas=mysqli_num_rows($res_consulta);
	// Se ubica en el último registro
	mysqli_data_seek($res_consulta, $filas-1); 
	$registro=mysqli_fetch_array($res_consulta);
	return $registro[0]; //valor retornado
}
?>
<?php
function numtoletras($xcifra)
//Funcion que obtiene un numero en letras, usado para precios y valores en letras
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }
    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }
            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                             
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                             
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                             
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO
        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";
        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO CON $xdecimales/100 SOLES ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UNO CON $xdecimales/100 SOLES ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " CON $xdecimales/100 SOLES "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
} // END FUNCTION
function subfijo($xx)
// Esta función regresa un subfijo para la cifra 
{ 
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub; //valor retornado
}
?>
<?php
function num_serie_doc($zona)
/*Obtiene un numero de serie de documento a partir de un nombre de zona
$zona es el nombre de zona */
{
	$ns=0;
	switch ($zona)
	{
		case "PDV_JXU4":
			$ns=1;
            break;
	}
	return $ns; //valor retornado
}
?>
<?php
function fech_nom_num($nombre)
/* Convierte un nombre de mes en un numero de mes
$nombre es el nombre de mes */
{
	if (!empty($nombre))
	{
		switch ($nombre)
		{
			case "Enero":
				$n="01";
			break;
			case "Febrero":
				$n="02";
			break;
			case "Marzo":
				$n="03";
			break;
			case "Abril":
				$n="04";
			break;
			case "Mayo":
				$n="05";
			break;
			case "Junio":
				$n="06";
			break;
			case "Julio":
				$n="07";
			break;
			case "Agosto":
				$n="08";
			break;
			case "Setiembre":
				$n="09";
			break;
			case "Octubre":
				$n="10";
			break;
			case "Noviembre":
				$n="11";
			break;
			case "Diciembre":
				$n="12";
			break;
		}
		return $n; //valor retornado
	}
}
?>
<?php
function fech_num_nom($nmes)
/* Convierte un nombre de mes en un numero de mes
$nombre es el nombre de mes */
{
	if (!empty($nmes))
	{
		switch ($nmes)
		{
			case "01":
				$nom="Enero";
			break;
			case "02":
				$nom="Febrero";
			break;
			case "03":
				$nom="Marzo";
			break;
			case "04":
				$nom="Abril";
			break;
			case "05":
				$nom="Mayo";
			break;
			case "06":
				$nom="Junio";
			break;
			case "07":
				$nom="Julio";
			break;
			case "08":
				$nom="Agosto";
			break;
			case "09":
				$nom="Setiembre";
			break;
			case "10":
				$nom="Octubre";
			break;
			case "11":
				$nom="Noviembre";
			break;
			case "12":
				$nom="Diciembre";
			break;
		}
		return $nom; //valor retornado
	}
}
?>
<?php
function cmbday($nombre, $valor)
/* Función que carga el objeto select(combo box) con valores de dias de mes.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan */
{	
	// Carga en datos la cadena a descomponer en datos
	$datos="01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31";
	$lista=array(); $longdatos=strlen($datos); $cont=$lcc=0;
	// Descompone $datos en bloques de dos caracteres y lo almacena en arreglo $lista
	for ($x=0; $x<=$longdatos-1; $x++)
	{
		$lcc=$lcc+1;
		if (substr($datos,$x,1)==",")
		{
			$lcc=$lcc-1;
			$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
			$lcc=0;
		}
	}
	$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
?>
	<!-- Genera un objeto select(combo box) con los datos de $lista -->
	<div id="fondo_select" style="display: inline-block;">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 1; $i <= $cont; $i++)
			{?>
				<option value="<?php echo $lista[$i];?>"<?php if($valor==$lista[$i]) echo " selected='selected'";?>><?php echo $lista[$i];?></option>
	  <?php }?>
		</select>
	</div>
<?php
}
?>
<?php
function cmbmes($nombre, $valor)
/* Función que carga el objeto select(combo box) con valores de dias de mes.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan */
{	
	// Carga en datos la cadena a descomponer en datos
	$datos="Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Setiembre,Octubre,Noviembre,Diciembre";
	$lista=array(); $longdatos=strlen($datos); $cont=$lcc=0;
	// Descompone $datos en bloques de dos caracteres y lo almacena en arreglo $lista
	for ($x=0; $x<=$longdatos-1; $x++)
	{
		$lcc=$lcc+1;
		if (substr($datos,$x,1)==",")
		{
			$lcc=$lcc-1;
			$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
			$lcc=0;
		}
	}
	$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
?>
	<!-- Genera un objeto select(combo box) con los datos de $lista -->
	<div id="fondo_select" style="display: inline-block;">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 1; $i <= $cont; $i++)
			{?>
				<option value="<?php echo $lista[$i];?>"<?php if($valor==$lista[$i]) echo " selected='selected'";?>><?php echo $lista[$i];?></option>
	  <?php }?>
		</select>
	</div>
<?php
}
?>
<?php
function cmbann($nombre, $valor)
/* Función que carga el objeto select(combo box) con valores de dias de mes.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan */
{	
	// Carga en datos la cadena a descomponer en datos
	$datos="2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030";
	$lista=array(); $longdatos=strlen($datos); $cont=$lcc=0;
	// Descompone $datos en bloques de dos caracteres y lo almacena en arreglo $lista
	for ($x=0; $x<=$longdatos-1; $x++)
	{
		$lcc=$lcc+1;
		if (substr($datos,$x,1)==",")
		{
			$lcc=$lcc-1;
			$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
			$lcc=0;
		}
	}
	$cont=$cont+1; $lista[$cont]=substr($datos, $x-$lcc, $lcc);
?>
	<!-- Genera un objeto select(combo box) con los datos de $lista -->
	<div id="fondo_select" style="display: inline-block;">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 1; $i <= $cont; $i++)
			{?>
				<option value="<?php echo $lista[$i];?>"<?php if($valor==$lista[$i]) echo " selected='selected'";?>><?php echo $lista[$i];?></option>
	  <?php }?>
		</select>
	</div>
<?php
}
?>
<?php
function comp_y_gener_fechas($campo_fecha, $fechainicial, $fechafinal)
/* Función que valida las fechas inicial y final */
{
	date_default_timezone_set("America/Lima");
	$fecha_actual=date("Y-m-d");
	
	if (empty($fechainicial) AND empty($fechafinal))
	{
		return "(".$campo_fecha."='$fecha_actual') AND";
	}
	if (empty($fechainicial) AND !empty($fechafinal))
	{
		return "(".$campo_fecha."='$fechafinal') AND";
	}
	if (!empty($fechainicial) AND empty($fechafinal))
	{
		return "(".$campo_fecha."='$fechainicial') AND";
	}
	if (!empty($fechainicial) AND !empty($fechafinal))
	{
		if (strtotime($fechainicial) < strtotime($fechafinal))
		{
			return "(".$campo_fecha.">='$fechainicial') AND (".$campo_fecha."<='$fechafinal') AND";
		}
		if (strtotime($fechainicial) > strtotime($fechafinal))
		{
			mensaje("Alerta!. La fecha de inicio debe ser siempre menor o igual a la fecha final.");
			return "(".$campo_fecha."='$fecha_actual') AND";
		}
		if (strtotime($fechainicial) == strtotime($fechafinal))
		{
			return "(".$campo_fecha."='$fechainicial') AND";
		}
	}
}
?>
<?php
function comp_y_gener_fechas01($fechainicial, $fechafinal)
/* Función que valida las fechas inicial y final */
{	
	if (empty($fechainicial) AND empty($fechafinal))
	{
		return "";
	}
	if (empty($fechainicial) AND !empty($fechafinal))
	{
		return "(fechareg_rpg='$fechafinal') AND ";
	}
	if (!empty($fechainicial) AND empty($fechafinal))
	{
		return "";
	}
	if (!empty($fechainicial) AND !empty($fechafinal))
	{
		if (strtotime($fechainicial) < strtotime($fechafinal))
		{
			return "(fechareg_rpg>='$fechainicial') AND (fechareg_rpg<='$fechafinal') AND ";
		}
		if (strtotime($fechainicial) > strtotime($fechafinal))
		{
			return "";
		}
		if (strtotime($fechainicial) == strtotime($fechafinal))
		{
			return "(fechareg_rpg='$fechafinal') AND ";
		}
	}
}
function comp_y_gener_fechas02($campo_fecha, $fechainicial, $fechafinal)
/* Función que valida las fechas inicial y final.
Es una variante de la funcion comp_y_gener_fechas, ya que 
incluye el nombre del campo de fecha que se va a comparar y generar.*/
{	
	if (empty($fechainicial) AND empty($fechafinal))
	{
		return "";
	}
	if (empty($fechainicial) AND !empty($fechafinal))
	{
		return "(".$campo_fecha."='$fechafinal') AND ";
	}
	if (!empty($fechainicial) AND empty($fechafinal))
	{
		return "";
	}
	if (!empty($fechainicial) AND !empty($fechafinal))
	{
		if (strtotime($fechainicial) < strtotime($fechafinal))
		{
			return "(".$campo_fecha.">='$fechainicial') AND (".$campo_fecha."<='$fechafinal') AND ";
		}
		if (strtotime($fechainicial) > strtotime($fechafinal))
		{
			return "";
		}
		if (strtotime($fechainicial) == strtotime($fechafinal))
		{
			return "(".$campo_fecha."='$fechafinal') AND ";
		}
	}
}
?>
<?php
function head_tbl()
/* Función que genera la cabecera de una tabla.
Los parametros deben ingresar en cantidades pares y deben tener la siguiente sintaxis:
nombre_de_titulo, ancho_de_titulo, ...*/
{
	$parametros_arreglo = func_get_args();//Obtiene todos los parámetros de la función en un arreglo(array)
	$cantidad_parametros = count($parametros_arreglo);//Obtiene la cantidad de parámetros de la función desde el arreglo
	if (($cantidad_parametros % 2) == 0)//Verifica si la cantidad de parámetros es una cantidad par
	{	
		for ($i=0; $i<$cantidad_parametros; $i++)//Cuenta todos los parámetros empezando por el índice 0
		{
			$i++;//Aumenta el contador del índice una cantidad
			$ancho_titulo = $parametros_arreglo[$i];//Obtiene el valor impar de la cantidad de parámetros (correspondiente a ancho_de_titulo)
			?>
			<col width="<?php echo $ancho_titulo;?>"><!-- Establece el ancho fijo de la columna de la tabla -->
			<?php
		}
		?>
		<tr align="center">
		<?php
		for ($i=0; $i<$cantidad_parametros; $i++)//Cuenta todos los parámetros empezando por el índice 0
		{
			$nom_titulo = $parametros_arreglo[$i];//Obtiene el valor par de la cantidad de parámetros (correspondiente a nombre_de_titulo)
			$i++;//Aumenta el contador del índice una cantidad, esto permite que en la siguiente cuenta se obtenga otro valor par
			?>
			<th><?php echo $nom_titulo;?></th><!-- Genera la cabecera de la columna de la tabla -->
			<?php
		}
		?>
		</tr>
		<?php
	}
	else //Si la cantidad de los parámetros es impar, se muestra un mensaje de advertencia
	{
		echo "Los parametros están incompletos...";
	}
}
?>
<?php
function data_tbl()
/* Función que genera la cabecera de una tabla.
Los parametros deben ingresar en cantidades pares y deben tener la siguiente sintaxis:
nombre_de_titulo, ancho_de_titulo, ...*/
{
	$parametros_arreglo = func_get_args();//Obtiene todos los parámetros de la función en un arreglo(array)
	$cantidad_parametros = count($parametros_arreglo);//Obtiene la cantidad de parámetros de la función desde el arreglo
	?>
	<tr align="center" valign="top"><!-- Genera una fila de la tabla -->
	<?php
	for ($i=0; $i<$cantidad_parametros; $i++)//Cuenta todos los parámetros empezando por el índice 0
	{
		$celda_de_tabla = $parametros_arreglo[$i];//Obtiene el valor impar de la cantidad de parámetros (correspondiente a ancho_de_titulo)
		?>
		<td><?php echo $celda_de_tabla;?></td><!-- Genera la celda del registro de la tabla -->
		<?php
	}
	?>
	</tr>
	<?php
}
?>
<?php
function conversion_de_consulta($cadena)
/* Función que genera la cabecera de una tabla.
Las variables deben tener la siguiente sintaxis de datos:
nombre_de_titulo:ancho */
{
	$v="";
	$long=strlen($cadena);
	for ($x=1; $x<=$long; $x++)
	{
		$c=substr($cadena,$x-1,1);
		if ($c==" ")
		{
			$c=":";
		}
		if ($c=="'")
		{
			$c="^";
		}
		$v=$v.$c;
	}
	return $v;
}
?>
<?php
function conversion_a_consulta($cadena)
/* Función que genera la cabecera de una tabla.
Las variables deben tener la siguiente sintaxis de datos:
nombre_de_titulo:ancho */
{
	$v="";
	$long=strlen($cadena);
	for ($x=1; $x<=$long; $x++)
	{
		$c=substr($cadena,$x-1,1);
		if ($c==":")
		{
			$c=" ";
		}
		if ($c=="^")
		{
			$c="'";
		}
		$v=$v.$c;
	}
	return $v;
}
?>
<?php
function cont_car($valor, &$contador)
/* Cuenta la cantidad de caracteres que tiene la cadena en $valor
y almacena en $contador la longitud mas grande */
{
	if ($contador < strlen($valor)) $contador = strlen($valor);
}
?>
<?php
function fthead($valor, $anchocol)
/* Genera la cabecera de una tabla en función de $valor = contenido de la columna de cabecera
y $anchocol = ancho de la columna de la cabecera */
{
?>
	<th width="<?php echo $anchocol; ?>"><?php echo $valor; ?></th>
<?php
}
function fthead01($valor, $anchocol)
/* Genera la cabecera de una tabla en función de $valor = contenido de la columna de cabecera
y $anchocol = ancho de la columna de la cabecera */
{
?>
	<!--<th width="<?php //echo $anchocol; ?>" style="background:transparent; padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse: collapse;"> <?php //echo $valor; ?></th> -->
	<th width="<?php echo $anchocol; ?>" style="padding:10px; padding-top:5px; padding-bottom:5px; border: 1px solid RGB(0,0,0); border-collapse: collapse;"> <?php echo $valor; ?></th>
<?php
}
?>
<?php
function ftdata($valor, $anchocol)
/* Genera datos de celdas de una tabla en función de $valor = contenido de la columna
y $anchocol = ancho de la columna */
{
?>
	<td width="<?php echo $anchocol; ?>"><?php echo $valor; ?></td>
<?php
}
function ftdata01($valor, $anchocol)
/* Genera datos de celdas de una tabla en función de $valor = contenido de la columna
y $anchocol = ancho de la columna */
{
?>
	<!--<td width="<?php //echo $anchocol; ?>" style="background:transparent; padding:10px; padding-top:2px; padding-bottom:2px; border: 1px solid RGB(0,0,0); border-collapse: collapse;"> <?php //echo $valor; ?></td> -->
	<td width="<?php echo $anchocol; ?>" style="padding:10px; padding-top:2px; padding-bottom:2px; border: 1px solid RGB(0,0,0); border-collapse: collapse;"> <?php echo $valor; ?></td>
<?php
}
?>
<?php
function lblnorm($valor, $id)
/* Genera un texto segun $valor con el estilo según $id */
{
?>
	<span id="<?php echo $id; ?>"><?php echo $valor; ?></span>
<?php
}
function lblnormExt($valor, $clase, $id, $estilo)
/* Genera un texto segun $valor con el estilo según $id */
{
?>
	<span class="<?php echo $clase; ?>" id="<?php echo $id; ?>" style="<?php echo $estilo; ?>"><?php echo $valor; ?></span>
<?php
}
?>
<?php
function tblanchofijo($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo
*/
{
	$j=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 3ro hasta el ultimo
	for($i = 5; $i < $cuentaparametros; $i++)
	{
		$j++;
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div style="width:100%; height:30px;">
		<table class="<?php echo $claseTabla;?>" style="<?php echo $vStylMargIzq;?>">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div style="width:100%; overflow:auto; <?php echo $vStyAltura;?> display:table-caption;">
		<table class="<?php echo $claseTabla;?>" style="<?php echo $vStylMargIzq;?>">
			<?php
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<?php
function buscalongitud($cadena, &$cadena_buscada, &$longitud_busqueda)
/* Obtiene la cadena buscada y la longitud de busqueda de la cadena */
{
	$longitud_cadena=strlen($cadena);
	$cadena_buscada=substr($cadena,1,$longitud_cadena-1);
	$longitud_busqueda=$longitud_cadena-1;
}
?>
<?php
function separa_fecha($fecha, &$dia, &$mes, &$ann)
/* Obtiene la cadena buscada y la longitud de busqueda de la cadena */
{
	$f=explode("-", $fecha);
	$dia=$f[2];
	$mes=fech_num_nom($f[1]);
	$ann=$f[0];
}
?>
<?php
function scroll_doble($namediv1, $namediv2)
/* Mueve el scroll de dos div distintos */
{
?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script>
		$(document).ready(function()
		{
			$("#<?php echo $namediv1;?>").scroll(function ()
			{ 
				//$("#<?php echo $namediv2;?>").scrollTop($("#<?php echo $namediv1;?>").scrollTop());
				$("#<?php echo $namediv2;?>").scrollLeft($("#<?php echo $namediv1;?>").scrollLeft());
			});
			$("#<?php echo $namediv2;?>").scroll(function ()
			{
				//$("#<?php echo $namediv1;?>").scrollTop($("#<?php echo $namediv2;?>").scrollTop());
				$("#<?php echo $namediv1;?>").scrollLeft($("#<?php echo $namediv2;?>").scrollLeft());
			});
		});
	</script>
<?php
}
?>
<?php
function tblanchovariable($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla,$ambito)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 3ro hasta el ultimo
	for($i = 6; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto; overflow-y:scroll;<?php echo $vStyAltura;?>">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
				if ($registro<0) $registro=0;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<?php
function tblanchovariable_01($Conex,$vStylMargIzq,$vSql,$ambito)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 4to hasta el ultimo
	for($i = 4; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:40px; overflow-x:hidden;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<?php
function tblanchovariable_02($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla,$ambito)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$cont_reg=0;
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 3ro hasta el ultimo
	for($i = 6; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto; <?php echo $vStyAltura;?>">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$registro=10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
				?>
				<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
					}
				}
				?>
				</tr>
				<?php
				$cont_reg++;
				if ($registro==10)
				{
					if ($cont_reg>=10)
					{
						break;
					}
				}
			}
			?>
		</table>
	</div>
<?php
}
function tblanchovariable_03($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 5TO hasta el ultimo
	for($i = 5; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto; <?php echo $vStyAltura;?>">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
						if ($variabletmp1[0]=="idLink")
						{
							?><td width="<?php echo $taman[$i];?>" style="background-color:RGB(180,210,250);"><?php echo "<a href='archivosXML.php?id=".$rs[$campos[$i]]."' style='text-decoration:none;'>".$rs[$campos[$i]]."</a>"; ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
function tblanchovariable_05($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla,$rutaArchivoId)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 5TO hasta el ultimo
	for($i = 6; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto; <?php echo $vStyAltura;?>">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
						if ($variabletmp1[0]=="idLink")
						{
							?><td width="<?php echo $taman[$i];?>" class="fondo"><?php echo "<a href='".$rutaArchivoId."?id=".$rs[$campos[$i]]."' style='text-decoration:none;'>".$rs[$campos[$i]]."</a>"; ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
function tblanchovariable_06($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla,$rutaArchivoId)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 5TO hasta el ultimo
	for($i = 6; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	//Calcula porcentajes
	$ancho_porcen=array();
	$suma_ancho_porcen=0;
	for ($i=1; $i <= $j; $i++)
	{
		$ancho_porcen[$i]=round($taman[$i]/$suma*100, 0);
		$suma_ancho_porcen=$suma_ancho_porcen+$ancho_porcen[$i];
	}
	$difer_suma_ancho_porcen=100-$suma_ancho_porcen;
	$ancho_porcen[$j]=$ancho_porcen[$j]+$difer_suma_ancho_porcen;
	//Convierte el $ancho_porcen en valores porcentuales
	$ancho_porcen_valor=array();
	for ($i=1; $i <= $j; $i++)
	{
		$ancho_porcen_valor[$i]=$ancho_porcen[$i]."%";
	}
	?>
	<style>
		.fondo_th { background-color:RGB(180,210,250); cursor:pointer; }
		.fondo_th:hover { background-color:RGB(82,134,202); color:RGB(255,255,255) }
	</style>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<!--<table class="<?php //echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php //echo $vStylMargIzq;?> table-layout:fixed; width:<?php //echo $suma;?>px;">-->
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:100%;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					//fthead($titulos[$i], $taman[$i]);
					fthead($titulos[$i], $ancho_porcen_valor[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto; <?php echo $vStyAltura;?>">
		<!--<table class="<?php //echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php //echo $vStylMargIzq;?> table-layout:fixed; width:<?php //echo $suma;?>px;">-->
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:100%;">
			<?php
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						//ftdata($rs[$campos[$i]], $taman[$i]);
						ftdata($rs[$campos[$i]], $ancho_porcen_valor[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><!--<td width="<?php //echo $taman[$i];?>"><?php //echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td>-->
							<td width="<?php echo $ancho_porcen_valor[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td>
							<?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><!--<td width="<?php //echo $taman[$i];?>"><?php //echo invFech($rs[$campos[$i]],"-"); ?></td>-->
							<td width="<?php echo $ancho_porcen_valor[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td>
							<?php
						}
						if ($variabletmp1[0]=="idLink")
						{
							?><!--<td width="<?php //echo $taman[$i];?>" <?php //echo "onclick='enviar_datos(".$rs[$campos[$i]].");'"; ?> class="fondo_th"><?php //echo $rs[$campos[$i]];?></td>-->
							<td width="<?php echo $ancho_porcen_valor[$i];?>" <?php echo "onclick='enviar_datos(".$rs[$campos[$i]].");'"; ?> class="fondo_th"><?php echo $rs[$campos[$i]];?></td>
							<?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<?php
function tblanchovariable_sunat($Conex,$vStylMargIzq,$vSql,$ambito)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 4to hasta el ultimo
	for($i = 4; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:40px; overflow-x:hidden;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
						if ($variabletmp1[0]=="coddocident")
						{
							$tdoc=tipodocclie($Conex,$rs[$campos[$i]]);
							?><td width="<?php echo $taman[$i];?>"><?php echo coddocident($tdoc); ?></td><?php
						}
						if ($variabletmp1[0]=="cod_comprobante")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo cod_comprobante($rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="res_anulado")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo res_anulado($rs[$campos[$i]],$rs[$variabletmp1[1]]); ?></td><?php
						}
						if ($variabletmp1[0]=="serie_ce")
						{
							$tipo_documento=valfield($Conex,"regvtacaja","tipodoccp_rvi","id_rvc",$rs[$campos[$i]]);
							$serie_documento=valfield($Conex,"regvtacaja","seriecp_rvi","id_rvc",$rs[$campos[$i]]);
							if ($tipo_documento=="Factura")
							{
								$serie="F".substr("000".$serie_documento,-3);
							}
							else
							{
								if ($tipo_documento=="Boleta de venta")
								{
									$serie="B".substr("000".$serie_documento,-3);
								}
								else
								{
									$serie=$serie_documento;
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $serie;?></td><?php
						}
						if ($variabletmp1[0]=="numero_ce")
						{
							$numero_documento=valfield($Conex,"regvtacaja","numcp_rvi","id_rvc",$rs[$campos[$i]]);
							$numero=substr("00000000".$numero_documento,-8);
							?><td width="<?php echo $taman[$i];?>" style="mso-number-format:'@'"><?php echo $numero;?></td><?php
						}
						//añadido (23-05-2022)
						if ($variabletmp1[0]=="nota_credito")
						{
							$nota_credito = "";
							$estado_registro = $rs[$campos[$i]];
							$id_rvc = $rs[$variabletmp1[1]];
							if ($estado_registro == "anulado")
							{
								$nota_credito = valfield($Conex,"regvtacaja","mensjcdr_ncred","id_rvc",$id_rvc);
								if (!empty($nota_credito))
								{
									$nota_credito = substr($nota_credito,26,13);
									//La Nota de credito numero B001-00000001, ha sido aceptada
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $nota_credito;?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
function tblanchovariable_04($Conex,$vStylMargIzq,$vSql,$ambito)
/*
$Conex es la conexión a un conjunto de datos de la tabla obtenido por un Select
$vStylMargIzq contiene una estilo de margen izquierdo del div.
$vStyAltura contiene la altura de la tabla
$vSql es el conjunto de datos de la tabla consultada
$claseTabla es la clase CSS que se va a aplicar a la tabla
Los parametros deben tener el siguiente formato titulo_de_cabecera:campo:ancho_de_columna:funcion
*/
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	// Cuenta cuantos parametros tiene la función
	$cuentaparametros = count($arregloparametros);
	// Obtiene todos los parametros de $arregloparametros desde el 4to hasta el ultimo
	for($i = 4; $i < $cuentaparametros; $i++)
	{
		$j++;//contiene la cantidad de parametros variables
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	//Suma todos los anchos de columna
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<!-- Bloque fijo para la cabecera de la tabla -->
	<div id="div1" style="width:100%; height:25px; overflow-x:hidden;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead01($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<!-- Bloque con scroll para los datos de la tabla -->
	<div id="div2" style="width:100%; overflow:auto;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata01($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo $rs[$campos[$i]].":".valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<?php
function consultaregs1($conex, &$tabla, $cadena, $mensaje)
/* Obtiene la cadena buscada y la longitud de busqueda de la cadena */
{
	$tabla = mysqli_query ($conex,$cadena) or die($mensaje);
	$filas_tabla = mysqli_num_rows($tabla);
	return $filas_tabla;
}
?>
<?php
function vconsulta($conx,$cadena_sql)
/* Funcion que obtiene un único valor desde una consulta a una tabla
$conx = conexión a la base de datos activa.
$cadena_sql = cadena con la consulta sql desde donde se obtiene el valor requerido 
Si no se obtiene resultados se devuelve -1, sino se devuelve el valor del primer registro*/
{
	$res_consulta = mysqli_query ($conx,$cadena_sql) or die ("Error al realizar la consulta de función vconsulta");
	$filas_tabla = mysqli_num_rows($res_consulta);
	if ($filas_tabla==0)
	{
		return -1;
	}
	else 
	{	
		$registro = mysqli_fetch_array($res_consulta);
		return $registro[0]; //valor retornado
	}
}
?>
<?php
function tf($taman,$factor)
/* Funcion que calcula un tamaño en pixeles por la multiplicación del $taman y el $factor
$taman = tamaño de la fuente en pixeles
$factor = factor para multiplicar
Se devuelve un tamaño en formato de cadena */
{
	$fuente_pixel = $taman * $factor;
	return (string)$fuente_pixel; //valor retornado
}
?>
<?php
function cmbarray($nombre, $valor, $arreglo, $cant_arreglo)
/* Función que carga el objeto select(combo box) con distintos valores.
Los parámetros adicionales luego de $nombre y $valor son los datos que se va a añadir
al select(combo) y que van a aparecer en el desplegable en el orden que se cargan*/
{
?>
	<div class="fondo_select">
		<select name="<?php echo $nombre;?>">
			<option value=""> </option>
			<?php
			for($i = 1; $i <= $cant_arreglo; $i++)
			{
			?>
				<option value="<?php echo $arreglo[$i];?>"<?php if($valor==$arreglo[$i]) echo " selected='selected'";?>><?php echo $arreglo[$i];?></option>
			<?php
			}
			?>
		</select>
	</div>
<?php
}
?>
<?php
function insertarsql($conex,$mensaje,$tabla)
/* Función que genera una cadena SQL para ser usada con el comando INSERT.
A partir del segundo parametro se cuentan el campo y seguido su valor. */
{
	$campo="";
	$valor="";
	$valcampo="";
	$arrayparam = func_get_args();
	$cuentaparm = count($arrayparam);
	$cadena = "INSERT INTO ";
	$cadena = $cadena.$arrayparam[2];//Junta INSERT INTO con la tabla
	for($i = 3; $i < $cuentaparm; $i++)
	{
		$campo = $campo.", ".$arrayparam[$i];
		$i++;
		$valcampo = $arrayparam[$i];
		if ($valcampo=="") $valcampo = NULL;
		$valor = $valor.", '".$valcampo."'";
	}
	$campo = substr($campo,2,strlen($campo)-2);
	$valor = substr($valor,2,strlen($valor)-2);
	$cadena = $cadena." (".$campo.") VALUES (".$valor.")";
	$resultado_insert=mysqli_query($conex,$cadena) or die($mensaje);
	//mensaje($cadena);
	return $resultado_insert;
}
?>
<?php
function updatesql($conex,$cadenasql,$mensaje)
/* Función que ejecuta el comando UPDATE.*/
{
	mysqli_query($conex,$cadenasql) or die($mensaje);
}
?>
<?php
function form_num2dec($cadena)
/* Función que convierte un numero a cadena numerica con dos decimales.*/
{
	$conteo=0;
	$caracter="";
	$busqueda_punto=0;
	$longitud=strlen($cadena);
	for($i=$longitud-1; $i>0; $i--)
	{
		$conteo++;
		$caracter=substr($cadena,$i,1);
		if ($caracter==".")
		{
			if ($conteo==1)
			{
				$añade_decimal="00";
			}
			if ($conteo==2)
			{
				$añade_decimal="0";
			}
			if ($conteo>=3)
			{
				$añade_decimal="";
			}
			$busqueda_punto=1;
		}
	}
	if ($busqueda_punto==1)
	{
		$cadena=$cadena.$añade_decimal;
	}
	else
	{
		$cadena=$cadena.".00";
	}
	return $cadena;
}
function detectarroba($cadena)
{ $vc=0;
	$a=strlen($cadena);
	for($b=0; $b<=$a; $b++)
	{
		$c=substr($cadena,$b,1);
		if($c=="@")
		{
			$vc=1;
		}
	}
	return $vc;
}
?>
<?php
function access($usr)
{
	If($usr=="Jhon" OR $usr=="77" OR $usr=="Johan")
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
/* Funcion que detecta el tipo de documento
00	OTROS DOC.
01	DNI
04	CARNET EXTRANJ.
06	RÚC
07	PASAPORTE */
function coddocident($doc)
{
	$codigo="";
	if (!empty($doc))
	{
		switch ($doc)
		{
			case "Otros Doc.":
				$codigo="00";
			break;
			case "DNI":
				$codigo="01";
			break;
			case "Carne Extranj.":
				$codigo="04";
			break;
			case "RUC":
				$codigo="06";
			break;
			case "Pasaporte":
				$codigo="07";
			break;
		}
	}
	return $codigo;
}
/* Funcion que detecta el tipo de documento a
partir de la cantidad de numeros del DNI de la
tabla clientes*/
function tipodocclie($conexion,$id_cliente)
{
	$num_doc=valfield($conexion,"clientes","dni_ruc_cli","id_cli",$id_cliente);
	if (strlen($num_doc)>8)
	{
		$tipodoccli="RUC";
	}
	else
	{
		$tipodoccli="DNI";
	}
	return $tipodoccli;
}
/* Función que devuelve el codigo del tipo de
comprobante de pago.
00	Otros (especificar)
01	Factura
02	Recibo por honorarios
03	Boleta de venta
04	Liquidación de compra
06	Carta porte aéreo 
07	Nota de crédito
08	Nota de débito
12	Ticket 
13	Doc. Bco
14	Recibo por energía
14	Recibo por agua
14	Recibo por teléfono
16	Boleto de viaje
20	Comprobante de Retención
30	Comprobante de emp. Tarjetas
*/
function cod_comprobante($comp)
{
	$codigo="";
	if (!empty($comp))
	{
		switch ($comp)
		{
			case "Otros.":
				$codigo="00";
			break;
			case "Factura":
				$codigo="01";
			break;
			case "Recib.Honorar.":
				$codigo="02";
			break;
			case "Boleta de venta":
				$codigo="03";
			break;
			case "Liquid.Compra":
				$codigo="04";
			break;
			case "Ticket":
				$codigo="12";
			break;
			case "Nota de credito":
				$codigo="07";
			break;
			case "Nota de debito":
				$codigo="08";
			break;
		}
	}
	return $codigo;
}
function cdpu($usuario,$dato)
{
	if ($usuario==5 OR $usuario==35)
	{
		return $dato;
	}
	else
	{
		$dato=conversion_a_consulta($dato);
		return $dato;
	}
}
function res_anulado($estado,$monto)
{
	if ($estado=="anulado")
	{
		return 0;
	}
	else
	{
		return $monto;
	}
}
/*-----------------------------------------------------------------------------------
Función que muestra un mensaje
-------------------------------------------------------------------------------------*/
function mensaje($msj)
{
?>
	<script type="text/javascript">
		cadena="<?php echo $msj;?>";
		alert(cadena);
	</script>
<?php
}
/*-----------------------------------------------------------------------------------
Función que genera espacios en blanco con caracter &nbsp en la cantidad indicada por 
la variable $espacios.
-------------------------------------------------------------------------------------*/
function spc($espacios) {?> <span> <?php for ($x=1; $x<=$espacios; $x++) echo "&nbsp;"; ?> </span> <?php }
/*-------------------------------FUNCIONES PARA ARCHIVOS PLANOS SUNAT------------------------------
1. generar_archivos_sunat($conex,$id_rvc)
2. generar_archivos($Conexion,$id)
3. generar_nombrearchivo(&$nombrearchivo,$resultado,&$estado)
4. generar_archivo_cab(&$archivocab,$resultado)
5. generar_archivo_det(&$archivodet,$resultado)
6. generar_archivo_det(&$archivodet,$resultado)
7. generar_archivo_ley(&$archivoley,$resultado)
8. convert10car($n)
9. archivoexiste($archivo)
10. creararchivo($contenido, $nombarch)
---------------------------------------------------------------------------------------------------*/
function generar_archivos_sunat($conex,$id_rvc,&$nombrearchivo)
{
	$estado="0";
	if (!empty($id_rvc))
	{
		$estado=generar_archivos($conex,$id_rvc,$nombrearchivo);
		if ($estado=="1")
		{
			mensaje("Se emitio un archivo electronico de forma satisfactoria.");
			return $estado;
		}
		else
		{
			mensaje($estado);
			return $estado;
		}
	}
	else
	{
		mensaje("No se ha cargado un Id valido para generar el archivo.");
	}
}
function generar_archivos($Conexion,$id,&$nombrearchivo)
{
	$consulta_sunat="
	SELECT a.id_rvi, a.id_cli, a.id_pro, 
	a.baseimpopgrv_rvi, a.igv_rvi, a.importetot_rvi, a.id_udint, a.id_tipmnd, a.id_tipisc, a.id_cdaf, a.id_tipopr, a.descrip_rvi, 
	b.tipopla_rvi, b.id_pla, b.fechaemi_rvi, b.horaemi_rvi, b.fechaven_rvi, b.codcpg_rvi, b.tipodoccp_rvi, 
	b.seriecp_rvi, b.numcp_rvi, b.formapago_rvi, b.baseimpopngrv_rvi, b.isc_rvi, b.id_usr, b.rgpag_rvc, 
	b.zona_rvi, b.estado_rvc, b.fechapag_rvc, b.id_usr_anula, b.causanul_rvc, b.cee_rvc, b.causamant_rvc, 
	b.id_rvc, b.descrip_rvi, b.baseimpopgrv_rvi AS baseimpopgrv_caja, b.igv_rvi AS igv_caja, b.importetot_rvi AS importetot_caja, 
	b.id_ubi, b.id_undc, b.id_tipcmp, b.id_empe, b.id_tipdoc, b.id_elad,
	c.cod_udint,
	d.cod_tipmnd,
	e.cod_tipisc,
	f.cod_cdaf,
	g.cod_tipopr,
	h.cod_ubi,
	i.codfiscal_undc, i.seriedoc_undc,
	j.cod_tipcmp,
	k.nomb_empe,k.nmbc_empe,k.ndoc_empe,k.id_ubi,k.dir_empe,k.urb_empe,k.dist_empe,k.prov_empe,k.region_empe,k.codpais_empe,
	l.cod_tipdoc,
	m.cod_elad,
	n.dni_ruc_cli, n.nom_rzs_cli,
	o.abrv_pro 
	FROM regventas a 
	LEFT JOIN regvtacaja b ON (a.seriecp_rvi=b.seriecp_rvi AND a.numcp_rvi=b.numcp_rvi AND a.codcpg_rvi=b.codcpg_rvi) 
	LEFT JOIN undinternac c ON a.id_udint=c.id_udint 
	LEFT JOIN tipomoned d ON a.id_tipmnd=d.id_tipmnd 
	LEFT JOIN tiposistisc e ON a.id_tipisc=e.id_tipisc 
	LEFT JOIN codafect f ON a.id_cdaf=f.id_cdaf 
	LEFT JOIN tipoperac g ON a.id_tipopr=g.id_tipopr 
	LEFT JOIN ubigeo h ON b.id_ubi=h.id_ubi 
	LEFT JOIN undcomerc i ON b.id_undc=i.id_undc 
	LEFT JOIN tipocomprob j ON b.id_tipcmp=j.id_tipcmp 
	LEFT JOIN empemisor k ON b.id_empe=k.id_empe 
	LEFT JOIN tipodocident l ON b.id_tipdoc=l.id_tipdoc 
	LEFT JOIN elemadicion m ON b.id_elad=m.id_elad 
	LEFT JOIN clientes n ON a.id_cli=n.id_cli 
	LEFT JOIN productos o ON a.id_pro=o.id_pro 
	WHERE id_rvc='$id'";
	$comprobante=new regvtacaja;
	$det=new ap_bvfac_detalles;
	$tri=new ap_bvfac_tributos_generales;
	$ley=new ap_bvfac_leyendas;
	$aca=new ap_bvfac_adicionales_cabecera;
	$v_tipocomprob=new tipocomprobante;
	$resultado=mysqli_query($Conexion,$consulta_sunat) or die ("Error al traer los datos de regvtacaja de consulta SUNAT.");
	$filas=mysqli_num_rows($resultado);
	if($filas>0)
	{
		mysqli_data_seek($resultado, 0);
		generar_nombrearchivo($nombrearchivo,$resultado,$estado);
		if ($estado=="1")
		{
			generar_archivo_cab($archivocab,$resultado); 
			generar_archivo_det($archivodet,$resultado); 
			generar_archivo_tri($archivotri,$resultado);
			generar_archivo_ley($archivoley,$resultado);
			/*echo $nombrearchivo,"<br>";
			echo $archivocab,"<br>";
			echo $archivodet,"<br>";
			echo $archivotri,"<br>";
			echo $archivoley,"<br>";*/
			if (archivoexiste("../datasunat/".$nombrearchivo.".cab"))
			{
				return "El archivo ".$nombrearchivo." ya existe. No se puede volver a generar.";
			}
			else
			{
				creararchivo($archivocab,$nombrearchivo.".cab");
				creararchivo($archivodet,$nombrearchivo.".det");
				creararchivo($archivotri,$nombrearchivo.".tri");
				creararchivo($archivoley,$nombrearchivo.".ley");
				return "1";
			}
		}
		else 
		{
			return "No se puede generar los nombres de archivo.";
		}
	}
	else
	{
		return "No se han encontrado datos para esta consulta. No se puede generar el archivo.";
	}
}
function generar_nombrearchivo(&$nombrearchivo,$resultado,&$estado)
{
	$a=new tipocomprobante;
	mysqli_data_seek($resultado, 0);
	$d=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$ruc=$d["ndoc_empe"];
	$a->tipo_comprobante($a,$d["tipodoccp_rvi"],$estado);
	$carac_codigo=$a->codigo;
	$carac_inicial=$a->inicial;
	$serie="000".$d["seriecp_rvi"];
	$serie=substr($serie, -3); 
	$serie=$carac_inicial.$serie;
	$numero="00000000".$d["numcp_rvi"];
	$numero=substr($numero, -8);
	$nombrearchivo=$ruc."-".$carac_codigo."-".$serie."-".$numero;
}
function generar_archivo_cab(&$archivocab,$resultado)
{
	$a=new ap_bvfac_cabecera;
	mysqli_data_seek($resultado, 0);
	$d=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$a->tipo_operacion="0101";//1.
	$a->fecha_emision=$d["fechaemi_rvi"];//2.
	$a->hora_emision=$d["horaemi_rvi"];//3.
	$a->fecha_vencimiento=$d["fechaven_rvi"];//4.
	$a->cod_domicil_fiscal=$d["codfiscal_undc"];//5.
	$a->tipo_docum_usuario=$d["cod_tipdoc"];//6.
	$a->num_doc_ident_usuario=$d["dni_ruc_cli"];//7.
	$a->nomb_razsoc_usuario=$d["nom_rzs_cli"];//8.
	$a->tipo_moneda=$d["cod_tipmnd"];//9.
	$a->sumatoria_tributos=$d["igv_caja"];//10.
	$a->total_valor_venta=$d["baseimpopgrv_caja"];//11.
	$a->total_precio_venta=$d["importetot_caja"];//12.
	$a->total_descuentos="0.00";//13.
	$a->sumatoria_otros_cargos="0.00";//14.
	$a->total_anticipos="0.00";//15.
	$a->importe_total=number_format($a->total_precio_venta - $a->total_descuentos + $a->sumatoria_otros_cargos - $a->total_anticipos, 2, '.', '');//16.
	$a->version_UBL="2.1";//17.
	$a->custom_docum="2.0";//18.
	$archivocab=
	$a->tipo_operacion."|".$a->fecha_emision."|".$a->hora_emision."|".$a->fecha_vencimiento."|".$a->cod_domicil_fiscal."|".
	$a->tipo_docum_usuario."|".$a->num_doc_ident_usuario."|".$a->nomb_razsoc_usuario."|".$a->tipo_moneda."|".$a->sumatoria_tributos."|".
	$a->total_valor_venta."|".$a->total_precio_venta."|".$a->total_descuentos."|".$a->sumatoria_otros_cargos."|".$a->total_anticipos."|".
	$a->importe_total."|".$a->version_UBL."|".$a->custom_docum;
}
function generar_archivo_det(&$archivodet,$resultado)
{
	$archivodet="";
	$i=0;
	mysqli_data_seek($resultado, 0);
	while($d=mysqli_fetch_array($resultado, MYSQLI_ASSOC))
	{
		$i++;
		$a[$i]=new ap_bvfac_detalles;
		$a[$i]->cod_unidad_med=$d["cod_udint"]; //1.
		$a[$i]->cant_unidad_item=1; //2.
		$a[$i]->cod_product=convert10car($d["id_pro"]); //3.
		$a[$i]->cod_prod_sunat="-"; //4.
		$a[$i]->descrip_detalle=$d["abrv_pro"]; //5.
		$a[$i]->valor_unitario=$d["baseimpopgrv_rvi"]; //6.
		//---------------------------------- tributos IGV -----------------------------------
		$a[$i]->cod_tipos_tributos_igv="1000"; //8.
		$a[$i]->monto_igv_item=$d["igv_rvi"]; //9.
		$a[$i]->base_imponible_igv_item=$d["baseimpopgrv_rvi"]; //10.
		$a[$i]->nombre_tributo_item="IGV"; //11.
		$a[$i]->cod_tipo_tributo_item="VAT"; //12.
		$a[$i]->afectacion_igv_item=$d["cod_cdaf"]; //13.
		$a[$i]->porcentaje_igv="18.00"; //14.
		//---------------------------------- tributos ISC  ----------------------------------
		$a[$i]->cod_tipos_tributos_isc="-"; //15.
		$a[$i]->monto_isc_item="0.00"; //16.
		$a[$i]->base_imponible_isc_item="0.00"; //17.
		$a[$i]->nombre_tributisc_item=""; //18.
		$a[$i]->cod_tipo_tributisc_item=""; //19.
		$a[$i]->tipo_sistema_isc=""; //20.
		$a[$i]->porcentaje_isc="0.00"; //21.
		//---------------------------------- Otros tributos ---------------------------------
		$a[$i]->cod_tipos_otrostrib="-"; //22.
		$a[$i]->monto_otrostrib_item="0.00"; //23.
		$a[$i]->base_imponible_otrostrib_item="0.00"; //24.
		$a[$i]->nombre_otrostrib_item=""; //25.
		$a[$i]->cod_otrostrib_item=""; //26.
		$a[$i]->porcentaje_otrostrib="0.00"; //27.
		//-----------------------------------------------------------------------------------
		$a[$i]->sumatoria_tributos_item=$a[$i]->monto_igv_item; //7.
		$a[$i]->valor_venta_item=$a[$i]->valor_unitario * $a[$i]->cant_unidad_item; //29. 
		$a[$i]->precio_vta_unitario=$a[$i]->valor_venta_item + $a[$i]->sumatoria_tributos_item; //28.
		$a[$i]->valor_referencial_unitario="0.00"; //30.
		$item_archivodet[$i]=
		$a[$i]->cod_unidad_med."|".$a[$i]->cant_unidad_item."|".$a[$i]->cod_product."|".$a[$i]->cod_prod_sunat."|".
		$a[$i]->descrip_detalle."|".$a[$i]->valor_unitario."|".$a[$i]->sumatoria_tributos_item."|".$a[$i]->cod_tipos_tributos_igv."|".
		$a[$i]->monto_igv_item."|".$a[$i]->base_imponible_igv_item."|".$a[$i]->nombre_tributo_item."|".$a[$i]->cod_tipo_tributo_item."|".
		$a[$i]->afectacion_igv_item."|".$a[$i]->porcentaje_igv."|".$a[$i]->cod_tipos_tributos_isc."|".$a[$i]->monto_isc_item."|".
		$a[$i]->base_imponible_isc_item."|".$a[$i]->nombre_tributisc_item."|".$a[$i]->cod_tipo_tributisc_item."|".
		$a[$i]->tipo_sistema_isc."|".$a[$i]->porcentaje_isc."|".$a[$i]->cod_tipos_otrostrib."|".$a[$i]->monto_otrostrib_item."|".
		$a[$i]->base_imponible_otrostrib_item."|".$a[$i]->nombre_otrostrib_item."|".$a[$i]->cod_otrostrib_item."|".
		$a[$i]->porcentaje_otrostrib."|".$a[$i]->precio_vta_unitario."|".$a[$i]->valor_venta_item."|".$a[$i]->valor_referencial_unitario."\r\n"; //Usado solo en alert() \\n
	}
	for ($x = 1; $x <= count($a); $x++)
	{ 
		$archivodet=$archivodet.$item_archivodet[$x];
	}
}
function generar_archivo_tri(&$archivotri,$resultado)
{
	$a=new ap_bvfac_tributos_generales;
	mysqli_data_seek($resultado, 0);
	$d=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$a->identif_tributi="1000"; //1.
	$a->nombre_tributo="IGV"; //2.
	$a->cod_tributo="VAT"; //3.
	$a->base_imponible=$d["baseimpopgrv_caja"]; //4.
	$a->monto_tributo_item=$d["igv_caja"]; //5.
	$archivotri=$a->identif_tributi."|".$a->nombre_tributo."|".$a->cod_tributo."|".$a->base_imponible."|".$a->monto_tributo_item;
}
function generar_archivo_ley(&$archivoley,$resultado)
{
	$a=new ap_bvfac_leyendas;
	mysqli_data_seek($resultado, 0);
	$d=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$a->cod_leyenda="1000"; //1.
	$a->descrip_leyenda=$d["importetot_caja"]; //2. 
	$archivoley=$a->cod_leyenda."|".numtoletras($a->descrip_leyenda);
}
function convert10car($n)
{
	return substr("0000000000".$n,-10);
}
function archivoexiste($archivo)
{
	if (file_exists($archivo)) return 1;
	else return 0;
}
function ruta_existe($ruta)
{
	if (file_exists($ruta)) return 1;
	else return 0;
}
function comprob_emitido($conex,$id)
{
	if (valfield($conex,"regvtacaja","cee_rvc","id_rvc",$id)==1) return 1;
	else return 0;
}
function creararchivo($contenido, $nombarch)
{
	$nombre_archivo = "../datasunat/".$nombarch;
  if($archivo = fopen($nombre_archivo, "w"))
  {
		$vca=fwrite($archivo, $contenido);
    if(!$vca) echo "Ha habido un problema al crear el archivo ".$nombarch;
    fclose($archivo);
  }
}
function nombre_archivo_xml($Conexion,$id,&$nombrearchivo)
{
	$nombrearchivo="";
	$consulta_sunat="
	SELECT a.id_rvi, b.tipodoccp_rvi, b.seriecp_rvi, b.numcp_rvi,	b.id_empe, c.ndoc_empe 
	FROM regventas a 
	LEFT JOIN regvtacaja b ON (a.seriecp_rvi=b.seriecp_rvi AND a.numcp_rvi=b.numcp_rvi AND a.codcpg_rvi=b.codcpg_rvi) 
	LEFT JOIN empemisor c ON b.id_empe=c.id_empe 
	WHERE id_rvc='$id'";
	$resultado=mysqli_query($Conexion,$consulta_sunat) or die ("Error al traer los datos de regvtacaja de consulta SUNAT.");
	$filas=mysqli_num_rows($resultado);
	if($filas>0)
	{
		mysqli_data_seek($resultado, 0);
		$a=new tipocomprobante;
		$d=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$ruc=$d["ndoc_empe"];
		$a->tipo_comprobante($a,$d["tipodoccp_rvi"],$estado);
		$carac_codigo=$a->codigo;
		$carac_inicial=$a->inicial;
		$serie="000".$d["seriecp_rvi"];
		$serie=substr($serie, -3); 
		$serie=$carac_inicial.$serie;
		$numero="00000000".$d["numcp_rvi"];
		$numero=substr($numero, -8);
		$nombrearchivo=$ruc."-".$carac_codigo."-".$serie."-".$numero;
	}
	else
	{
		return "No se han encontrado datos para esta consulta. No se puede generar el nombre del archivo XML.";
	}
}
function convert6car($n)
{
	return substr("000000".$n,-6);
}
/* Reglamento de Comprobantes de Pago. Art. 10. Notas de Crédito y Notas de Débito. RS-182-2016.
Las notas de crédito se emitirán en los siguientes casos:
- Anulación
- Descuentos
- Bonificación
- Devolución
La creación de los archivos .not están sujetos a esta norma. 
NOTA: Para que el facturador SUNAT V.1.0 envíe documentos automaticamente con el temporizador, todos los directorios
de la carpeta data0/facturador/, como: DATA, ENVIO, FIRMA, ORIDAT, PARSE, REPO, RPTA y TEMP deben esta limpios. */
/*----------------------------------FUNCIONES PARA FINALIZAR LA VENTA----------------------------------
1. finalizar_venta($Conexion,$sql_rgvtatmp,$ident_usuario)
2. borrar_temporales($Conexion,$ident_usuario)
3. insertar_en_regventas($Conexion,$o)
4. actualizar_almacen($Conexion,$a,$clprod)
5. obtener_id_rvc_reciente($Conexion,$a)
6. obtener_consulta_rgvtatmp($Conexion,$nivel_usuario,&$ident_usuario,&$sql_rgvtatmp,$cpg,$ser,$ncp)
-------------------------------------------------------------------------------------------------------*/
function finalizar_venta($Conexion,$ident_usuario,$cpg,$last_id_rvc)
{
	$sql_rgvtatmp = mysqli_query($Conexion,"SELECT a.*, b.tipo_cat, b.clase_cat FROM rgvtatmp a LEFT JOIN productos b ON a.id_pro=b.id_pro WHERE a.id_usr='$ident_usuario' AND a.codcpg_rvi='$cpg'") or die ("Error al traer los datos de rgvtatmp.");
	if (mysqli_num_rows($sql_rgvtatmp)>0)
	{
		$a=new rgvtatmp;
		mysqli_data_seek($sql_rgvtatmp, 0);
		// Traslada datos de regvtatmp a regventas y actualiza almacen de productos
		while($resul = mysqli_fetch_array($sql_rgvtatmp))
		{
			$a->consulta_registro_x_fila($a,$resul);
			$grprod = $resul["tipo_cat"];
			$clprod = $resul["clase_cat"];
			//mensaje($grprod."-".$clprod."-".($grprod<>"Servicios" AND $grprod<>"Juego"));
			$zona_de_usuario = $resul["zona_rvi"];
			$resultado_insercion=insertar_en_regventas($Conexion,$a);
			if ($resultado_insercion=="0") mensaje("Hubo un error al insertar registro en regventas desde rgvtatmp.");
			if ($grprod<>"Servicios" AND $grprod<>"Juego") actualizar_almacen($Conexion,$a,$clprod,$grprod,$zona_de_usuario,$ident_usuario);
			//Actualizar datos de Juego
			actualizar_stock_juego($Conexion,$grprod,$clprod,$a->importetot_rvi,$a->id_pro,$last_id_rvc,$ident_usuario,$zona_de_usuario);
		}
		// Borra los registros de las tablas temporales
		borrar_temporales($Conexion,$ident_usuario);
		// Genera XML de la venta y envia los datos a SUNAT
		envia_datos_venta_a_SUNAT($Conexion,$last_id_rvc);
		//--------------------------------------------------------------------------------------------------------------
		//echo "<script> window.close(); </script>";
	}
	else
	{
		echo "<script> alert('No existen datos de venta. ¡Tenga cuidado al realizar esta operación!'); </script>";
		//echo "<script> window.close(); </script>";
	}
}
function actualizar_stock_juego($Conexion,$tipo_cat,$clase_cat,$importe_total,$id_pro,$id_rvc,$id_usr,$zna_usr)
{
	date_default_timezone_set("America/Lima");
	// $tipo_cat=$grprod; 
	// $clase_cat=$clprod; 
	// $importe_total=$a->importetot_rvi;
	// $id_pro=$a->id_pro;
	// $id_rvc=$last_id_rvc;
	// $id_usr=$ident_usuario;
	if ($tipo_cat=="Juego" AND $clase_cat=="Sorteo")
	{
		$resul_saldo_stkjg=mysqli_query($Conexion,"SELECT saldo_stkjg FROM stock_juego WHERE zona_stkjg='$zna_usr' ORDER BY id_stkjg DESC LIMIT 1");
		if (mysqli_num_rows($resul_saldo_stkjg)==0)
		{
			$saldo_stkjg=0;
		}
		else
		{
			$saldo_stkjg=mysqli_fetch_array($resul_saldo_stkjg,MYSQLI_ASSOC)["saldo_stkjg"];
		}
		if ($saldo_stkjg<$importe_total)
		{
			echo "<script>alert('No se puede generar el registro de stock_juego porque el monto de la venta es mayor que el saldo actual.')</script>";
		}
		else
		{
			$saldo_actual=$saldo_stkjg-$importe_total;
			if ($saldo_actual<=10) { $min_stkjg="S"; } else { $min_stkjg="N"; }
			$resultado_insertar=insertarsql($Conexion,"Error al insertar registro en stock_juego","stock_juego",
			"saldo_stkjg",$saldo_actual,
			"egreso_stkjg",$importe_total,
			"ingreso_stkjg",0,
			"id_pro",$id_pro,
			"id_rvc",$id_rvc,
			"fecha_stkjg",date("Y-m-d"),
			"hora_stkjg",date("H:i:s"),
			"id_usr",$id_usr,
			"min_stkjg",$min_stkjg,
			"proces_stkjg","E",
			"zona_stkjg",$zna_usr);
		}	
	}
}
function borrar_temporales($Conexion,$ident_usuario)
{
	//Elimina los registros de las tablas temporales de acuerdo a id_usr
	mysqli_query($Conexion, "DELETE FROM rgvtatmp WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal rgvtatmp");
	mysqli_query($Conexion, "DELETE FROM codcomprb WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal codcomprb");
	mysqli_query($Conexion, "DELETE FROM datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal datprinctmp");
}
function insertar_en_regventas($Conexion,$o)
{	
	//Modificado por JUAN (10-025-2019): "id_cdaf",'9'  corresponde a EXONERADO
	$resultado_insertar=insertarsql($Conexion,"Error al insertar registro en regventas","regventas",
	"id_cli",$o->id_cli,
	"id_pro",$o->id_pro,
	"tipopla_rvi",$o->tipopla_rvi,
	"id_pla",$o->id_pla,
	"fechaemi_rvi",$o->fechaemi_rvi,
	"fechaven_rvi",$o->fechaven_rvi,
	"tipodoccp_rvi",$o->tipodoccp_rvi,
	"seriecp_rvi",$o->seriecp_rvi,
	"numcp_rvi",$o->numcp_rvi,
	"descrip_rvi",$o->descrip_rvi,
	"formapago_rvi",$o->formapago_rvi,
	"baseimpopgrv_rvi",$o->baseimpopgrv_rvi,
	"baseimpopngrv_rvi",$o->baseimpopngrv_rvi,
	"isc_rvi",$o->isc_rvi,
	"igv_rvi",$o->igv_rvi,
	"importetot_rvi",$o->importetot_rvi,
	"id_usr",$o->id_usr,
	"numcont_rvi",$o->numcont_rvi,
	"numcel_rvi",$o->numcel_rvi,
	"codpqt_rvi",$o->codpqt_rvi,
	"codcpg_rvi",$o->codcpg_rvi,
	"rgpag_rvc",$o->rgpag_rvc,
	"zona_rvi",$o->zona_rvi,
	"imprecef_rvi",$o->imprecef_rvi,
	"id_udint",'1',
	"id_tipmnd",'1',
	"id_cdaf",'9',
	"id_tipopr",'1');
	if ($resultado_insertar) return "1";
	else return "0";
}
function actualizar_almacen($Conexion,$a,$clprod,$grprod,$zona_usuario,$ident_usuario)
{
	$cantanterior=valfield($Conexion,"productos","ultreg_pro","id_pro",$a->id_pro);
	if ($cantanterior<=0)
	{
		//Agregado por JUAN 06-11-2018
		if ($clprod<>"Rec.Virtual")
		{
			//echo "<script> alert('No se puede registrar egreso del almacen de un producto sin stock');</script>";
		}
	}
	else
	{
		if ($clprod=="Rec.Virtual")
		{
			if ($a->tipopla_rvi=="Rec.PDV")
			{
				$cantregist=$a->imprecef_rvi*-1;
			}
			else
			{
				$cantregist=$a->importetot_rvi*-1;
			}
		}
		else
		{
			$cantregist=-1;
		}
		$cantactual = $cantanterior + $cantregist;
		$consulta_kardex = mysqli_query($Conexion, 
		"SELECT id_kar, tiporeg_kar FROM kardex WHERE (id_pro='$a->id_pro') AND (tiporeg_kar='E') AND (activ_kar='1') AND (zona_pro='$zona_usuario')") 
		or die("Error al consultar datos en Kardex");
		if (mysqli_num_rows($consulta_kardex)==0) 
			$consulta_kardex = mysqli_query($Conexion, "SELECT id_kar, tiporeg_kar FROM kardex 
			WHERE (id_pro='$a->id_pro') AND (tiporeg_kar='I') AND (activ_kar='1') AND (zona_pro='$zona_usuario')") 
			or die("Error al consultar datos en Kardex");
		$filas = mysqli_num_rows($consulta_kardex);
		if ($filas<>0)
		{
			mysqli_data_seek($consulta_kardex, 0); 
			$resul = mysqli_fetch_array($consulta_kardex);
			$idkar = $resul[0];//id_kar
			$trkar = $resul[1];//tiporeg_kar
			if ($trkar=="E")
			{
				//DESACTIVAR CUANDO SE TERMINEN LOS PROCESOS DE VERIFICACION DE regventas y regvtacaja
				$cadena_sql_kardex = "UPDATE kardex SET activ_kar=0 WHERE id_kar='$idkar'";
				mysqli_query($Conexion, $cadena_sql_kardex) or die("Error al actualizar activ_kar a 0");
			}
		}
		$var7=$var8=$var9="";
		$var6="0000-00-00";
		$var0=$a->id_rvi;
		$var23=$zona_usuario;
		$cadena_sql_kardex = "INSERT INTO kardex (tipodoc_kar, numdoc_kar, id_pro, feching_kar, fechsal_kar, cantanterior_kar, cantregistrada_kar, cantactual_kar, costoproding_kar, id_rvi, id_cmp, id_usr, tiporeg_kar, zona_pro, activ_kar) 
		VALUES ('".$var7."','".$var8."-".$var9."','".$a->id_pro."','0000-00-00','".$var6."','".$cantanterior."','".$cantregist."','".$cantactual."','0.00','".$var0."','0','".$ident_usuario."','E','".$var23."','1')";
		mysqli_query($Conexion, $cadena_sql_kardex) or die("Error al insertar datos en Kardex");
		$cadena_sql_producto = "UPDATE productos SET ultreg_pro='$cantactual' WHERE id_pro='$a->id_pro'";
		mysqli_query($Conexion, $cadena_sql_producto) or die("Error al actualizar ultreg_pro en Productos");
		//Modificado por JUAN:
		//Actualiza por segunda vez los productos vendidos desde el almacen
		if (($grprod<>"Servicios") AND ($clprod<>"Rec.Virtual"))
		{
			$cadena_pro="UPDATE productos SET activ_pro=0 WHERE id_pro=$a->id_pro";
			mysqli_query ($Conexion,$cadena_pro) or die("Error al agregar datos");
		}
	}
}
function obtener_id_rvc_reciente($Conexion,$a)
{
	$id_rvc=vconsulta($Conexion,"SELECT id_rvc FROM regvtacaja WHERE seriecp_rvi='$a->seriecp_rvi' AND numcp_rvi='$a->numcp_rvi' AND codcpg_rvi='$a->codcpg_rvi'");
	return $id_rvc;
}
function obtener_consulta_rgvtatmp($Conexion,$nivel_usuario,&$ident_usuario,&$sql_rgvtatmp,$cpg,$ser,$ncp)
{
	if ($nivel_usuario=="tot")
	{
		$sql_rgvtatmp=mysqli_query($Conexion,"SELECT * FROM rgvtatmp") or die ("Error al traer los datos de rgvtatmp");
	}
	else
	{
		$sql_rgvtatmp=mysqli_query($Conexion,"SELECT * FROM rgvtatmp WHERE seriecp_rvi='$ser' AND numcp_rvi='$ncp' AND codcpg_rvi='$cpg'") or die ("Error al traer los datos de rgvtatmp");
		$r=mysqli_fetch_array($sql_rgvtatmp, MYSQLI_ASSOC);
		$ident_usuario=$r["id_usr"];
	}
}
/*----------------------------------FUNCIONES PARA CANCELAR LA VENTA-----------------------------------
1. cancelar_venta($Conexion,$datos,$ident_usuario)
2. buscar_registro_pagado($Conexion,$ident_usuario,&$rgpag_datprinctmp,&$rgpag_rgvtatmp)
3. reactivar_productos($Conexion,$ident_usuario)
4. eliminar_temporales($Conexion,$ident_usuario)
-------------------------------------------------------------------------------------------------------*/
function cancelar_venta($Conexion,$datos,$ident_usuario)
{
	if ($datos>0)
	{
		buscar_registro_pagado($Conexion,$ident_usuario,$rgpag_datprinctmp,$rgpag_rgvtatmp);
		if ($rgpag_datprinctmp=="Pagado" OR $rgpag_rgvtatmp=="Pagado")
		{
			mensaje("No se puede eliminar la venta. La venta ya se efectuó!.");
			echo "<script> location.href = 'rgvtatmp.php'; </script>";
		}
		else
		{
			reactivar_productos($Conexion,$ident_usuario);
			eliminar_temporales($Conexion,$ident_usuario);
			echo "<script> window.close(); </script>";
		}
	}
	else
	{
		echo "<script> alert('No hay datos principales para liberar. ¡Tenga cuidado al usar esta función!');  window.close();; </script>";
	}
}
function buscar_registro_pagado($Conexion,$ident_usuario,&$rgpag_datprinctmp,&$rgpag_rgvtatmp)
{
	$resul_datprinctmp=mysqli_query ($Conexion,"SELECT rgpag_rvc FROM datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
	if (mysqli_num_rows($resul_datprinctmp)>0)
	{
		$rd=mysqli_fetch_array($resul_datprinctmp, MYSQLI_ASSOC);
		$rgpag_datprinctmp=$rd["rgpag_rvc"];
	}
	$resul_rgvtatmp=mysqli_query ($Conexion,"SELECT rgpag_rvc FROM rgvtatmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
	if (mysqli_num_rows($resul_rgvtatmp)>0)
	{
		$rr=mysqli_fetch_array($resul_rgvtatmp, MYSQLI_ASSOC);
		$rgpag_rgvtatmp=$rr["rgpag_rvc"];
	}
}
function reactivar_productos($Conexion,$ident_usuario)
{
	$sql_rgvtatmp=mysqli_query($Conexion,"SELECT * FROM rgvtatmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
	while($rr=mysqli_fetch_array($sql_rgvtatmp, MYSQLI_ASSOC))
	{
		$id_pro=$rr["id_pro"];
		mysqli_query($Conexion,"UPDATE productos SET activ_pro=1 WHERE id_pro=$id_pro") or die("Error al actualizar los datos en productos");
	}
}
function eliminar_temporales($Conexion,$ident_usuario)
{
	mysqli_query($Conexion, "DELETE FROM rgvtatmp WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal rgvtatmp");
	mysqli_query($Conexion, "DELETE FROM codcomprb WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal codcomprb");
	mysqli_query($Conexion, "DELETE FROM datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal datprinctmp");
	mysqli_query($Conexion, "DELETE FROM codpaquete WHERE id_usr='$ident_usuario'") or die ("Error al borrar el registro en temporal paquete");
}
//----------------------------------
function vard($variable,$mensaje)
{
	echo "<pre>";
	echo $mensaje,":"; var_dump($variable);
  echo "</pre>";
}
function nombre_comercial_empresa()
{
	echo "HELI CELL SHOP";
}
function enviar_XML_manual_a_SUNAT($Conexion,$id_rvc)
{
	if (ruta_existe("../datasunat/"))
	{
		$resultado_generar_comprobelect="";
		if (comprob_emitido($Conexion,$id_rvc)==0)
		{
			nombre_archivo_xml($Conexion,$id_rvc,$nombrearchivo);
			require_once './sendXML.php';
			$response=sendXMLSUNAT($id_rvc);
			if($response['success'])
			{
				$sql_update="UPDATE regvtacaja SET ticketsunat_rvc=?, codigocdr_rvc=?, mensajecdr_rvc=? WHERE id_rvc=?";
				if($stmt=mysqli_prepare($Conexion, $sql_update))
				{
					mysqli_stmt_bind_param($stmt, "sisi", $response['ticket'], $response['codigo_cdr'], $response['respuesta_cdr'], $id_rvc);
					mysqli_stmt_execute($stmt);
					$resultado_generar_comprobelect="1";
				}
			}
			else
			{
				$sql_update="UPDATE regvtacaja SET ticketsunat_rvc=?, codigocdr_rvc=?, mensajecdr_rvc=? WHERE id_rvc=?";
				if($stmt=mysqli_prepare($Conexion, $sql_update))
				{
					mysqli_stmt_bind_param($stmt, "sisi", $response['ticket'], $response['codigo_cdr'], $response['respuesta_cdr'], $id_rvc);
					mysqli_stmt_execute($stmt);
					$resultado_generar_comprobelect="0";
				}
			}
			if ($resultado_generar_comprobelect=="1")
			{
				updatesql($Conexion,"UPDATE regvtacaja SET cee_rvc=1, nombarch_rvc='$nombrearchivo' WHERE id_rvc='$id_rvc'","Error al actualizar cee_rvc y nombarch_rvc en regvatcaja");
				mensaje("Se emitio un archivo electronico XML de forma satisfactoria.");
			}
		}
		else mensaje("Ya se emitio este comprobante como Comprobante Electrónico. Verifique su condición.");
	}
	else mensaje("No se encontró la ruta del Facturador Electrónico. No se generó el comprobante electrónico.");
}
function generar_PDF_manual($id_rvc)
{
	require_once './comprobante.php';
	$generatePDF=generatePDFComprante($id_rvc);
	if(!$generatePDF['status'])
	{
		echo sprintf("<div display='none'>%s</div>", $generatePDF['error']);
		echo "No se ha generado el PDF correctamente.<br>";
	}
	else
	{
		echo "Se ha generado el PDF correctamente.<br>";
		$response_email=sendComprobanteEmail($id_rvc);
		if (!$response_email['status'])
		{
			echo "No se ha enviado un mail de manera correcta.<br>", $response_email['error'];
			var_dump($response_email); echo "<br>";
		}
		else
		{
			echo "Se ha enviado un mail de manera correcta.<br>";
			echo sprintf("<div display='none'>%s</div>", $response_email['error']);
			var_dump($response_email); echo "<br>";
		}
	}
	//---------------------------------------------------------------------
}
function contar_cant_en_campo($Conexion, $campo, $tabla, &$array_valor_de_datos, &$resultado_de_conteos, $where_as="", $order_by="")
{
	/* Conteo de campos usando comandos de MySQL. Obtiene primero todos los datos distintos de un campo de una tabla cualquiera,
	luego compara esos datos distintos con todos los datos del campo y cuenta sus	cantidades totales.	*/
	$resultado_datos_existentes_distintos = mysqli_query($Conexion,"SELECT DISTINCT $campo FROM $tabla") or die ("Error al obtener $campo de la tabla $tabla.");
	$consulta_de_conteos = "SELECT ";
	while($fila = mysqli_fetch_array($resultado_datos_existentes_distintos, MYSQLI_ASSOC))
	{
		$valor_de_datos = $fila["$campo"];
		$limpiar_valor_de_datos = str_replace(" ", "", $valor_de_datos);
		$corregir_valor_de_datos = str_replace(".", "_", $limpiar_valor_de_datos);
		$cambiar_valor_de_datos_a_titulo = "_".$corregir_valor_de_datos;
		$array_valor_de_datos[] = $cambiar_valor_de_datos_a_titulo;
		$suma_conteo_datos = "SUM(IF($campo='$valor_de_datos',1,0)) AS $cambiar_valor_de_datos_a_titulo, ";
		$consulta_de_conteos = $consulta_de_conteos.$suma_conteo_datos;
	}
	$consulta_de_conteos = substr($consulta_de_conteos,0,strlen($consulta_de_conteos)-2);
	$consulta_de_conteos = $consulta_de_conteos." FROM $tabla";
	$consulta_final_de_conteos = $consulta_de_conteos." ".$where_as." ".$order_by;
	$resultado_de_conteos = mysqli_query($Conexion,$consulta_final_de_conteos) or die ("Error al contar $campo de la tabla $tabla.");
}
function mostrar_resultados_conteo($array_valor_de_campos, $resultado_de_conteos)
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		for($i=0; $i<count($array_valor_de_campos); $i++)
		{
			$cantidad = $fila["$array_valor_de_campos[$i]"];
			echo "<b>",quitar_Subraya_de_Inicio($array_valor_de_campos[$i]),":</b> ",$cantidad,"<br>";
		}
	}
}
function mostrar_resultados_conteo_activos($array_valor_de_campos, $resultado_de_conteos)
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		for($i=0; $i<count($array_valor_de_campos); $i++)
		{
			$cantidad = $fila["$array_valor_de_campos[$i]"];
			if (quitar_Subraya_de_Inicio($array_valor_de_campos[$i]) == "0")
			{
				$nombre_valor_datos = "No Activos";
			}
			else
			{
				$nombre_valor_datos = "Activos";
			}
			echo "<b>",$nombre_valor_datos,":</b> ",$cantidad,"<br>";
		}
	}
}
function quitar_Subraya_de_Inicio($cadena)
{
	$newCadena = substr($cadena,1,strlen($cadena));
	return $newCadena;
}
function corregir_fecha($fecha_verificar)
{
	if ($fecha_verificar=='0') 
	{
		$fecha="";
	}
	else
	{
		$fecha=invFech($_POST["cmbfch"],"-");
	}
	return $fecha;
}
function inicializa_funcion_busca_datos_Ajax()
{
	// La función muestraDatos(id, cadena, archivo) en JavaScript
	// permite solicitar nuevos datos mediante comunicación XMLHttpRequest (AJAX)
	// para actualizar los datos de la pagina sin recargarla.
	// id = Es el nombre o identificador del elemento HTML (por lo general es un
	//      <div id="nombre">) que la función muestraDatos usa para reemplazar al
	//      elemento HTML original o predeterminado mediante la instrucción
	//      JavaScript document.getElementById(id).innerHTML=contenido.responseText
	//      cuando se devuelve la respuesta desde el archivo PHP
	// cadena = Es el valor que se envia al archivo. Se concatena con la variable 'id'
	//      y se envia al archivo donde se realizan las operaciones que luego se devuelven
	//      a la pagina desde donde se llama. El valor 'cadena' puede ser un solo valor o 
	//      un conjunto de valores como por ejemplo en formato Json, solo valores concatenados por
	//      guiones (por ejemplo: 1-Luis-12345678-Av. Los Aires 123) o pueden ser concatenados
	//      con dos puntos (por ejemplo: 1:Luis:12345678:Av. Los Aires 123) o quizas si se
	//      desea se pueden enviar concatenados con lineas verticales (por ejemplo:
	//      1|Luis|12345678|Av. Los Aires 123)
	// archivo = Es el archivo en PHP que recibe la variable 'id' y el valor de 'cadena' y
	//      se realizan las operaciones que luego se devuelven a la pagina desde donde se
	//      llamó sin recargarla
	// Un ejemplo de uso de esta función en JavaScript es usandola de esta forma:
	//        muestraDatos("combo_productos","2345","busca_datos.php")
	echo "
	<script>
	function muestraDatos(id, cadena, archivo)
	{
		if (cadena == '')
		{
			document.getElementById(id).innerHTML = '';
			return;
		} 
		else 
		{
			var datos='id='+cadena;
			var contenido = new XMLHttpRequest();
			contenido.onreadystatechange = respuesta;
			contenido.open('POST', archivo, true);
			contenido.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			contenido.setRequestHeader('Content-length', datos.length);
			contenido.setRequestHeader('Connection', 'close');
			contenido.send(datos);
			function respuesta() 
			{
				if (contenido.readyState == 4 && contenido.status == 200) 
				{
					document.getElementById(id).innerHTML = contenido.responseText;
				}
			};
		}
	}
	</script>";
}
function muestraDatos_x_innerHTML_Js()
{
	//  muestraDatos_x_innerHTML_Js("combo_productos","2345","busca_datos.php")
	echo "
	<script>
	function muestraDatos_x_innerHTML(id, cadena, archivo)
	{
		if (cadena == '')
		{
			document.getElementById(id).innerHTML = '';
			return;
		} 
		else 
		{
			var datos='id='+cadena;
			var contenido = new XMLHttpRequest();
			contenido.onreadystatechange = respuesta;
			contenido.open('POST', archivo, true);
			contenido.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			//contenido.setRequestHeader('Content-length', datos.length);
			//contenido.setRequestHeader('Connection', 'close');
			contenido.send(datos);
			function respuesta() 
			{
				if (contenido.readyState == 4 && contenido.status == 200) 
				{
					document.getElementById(id).innerHTML = contenido.responseText;
				}
			};
		}
	}
	</script>";
}
function cargaDatos_x_value_Js()
{
/* La función cargaDatos_x_value(id, cadena, archivo) en JavaScript permite solicitar 
nuevos datos mediante comunicación XMLHttpRequest (AJAX) para actualizar los datos de
la pagina sin recargarla.
id      = Es el nombre o identificador del elemento HTML (por lo general es un 
			 <div id="nombre">) que la función muestraDatos usa para reemplazar al elemento 
			 HTML original o predeterminado mediante la instrucción JavaScript 
			 document.getElementById(id).innerHTML=contenido.responseText cuando se devuelve
			 la respuesta desde el archivo PHP
cadena  = Es el valor que se envia al archivo. Se concatena con la variable 'id' y se envia 
			 al archivo donde se realizan las operaciones que luego se devuelven a la pagina 
			 desde donde se llama. El valor 'cadena' puede ser un solo valor o un conjunto de
			 valores como por ejemplo en formato Json, solo valores concatenados por guiones 
			 (por ejemplo: 1-Luis-12345678-Av. Los Aires 123) o pueden ser concatenados con 
			 dos puntos (por ejemplo: 1:Luis:12345678:Av. Los Aires 123) o quizas si se desea
			 se pueden enviar concatenados con lineas verticales (por ejemplo: 
			 1|Luis|12345678|Av. Los Aires 123)
archivo = Es el archivo en PHP que recibe la variable 'id' y el valor de 'cadena' y se 
			 realizan las operaciones que luego se devuelven a la pagina desde donde se llamó
			 sin recargarla. Un ejemplo de uso de esta función en JavaScript es usandola de 
			 esta forma: cargaDatos_x_value("combo_productos","2345","busca_datos.php") 
Esta funcion detecta si los parametros id o cadena estan vacios, y si lo estan genera un
mensaje de advertencia.
Por otro lado la función puede devolver varios valores para cargar también a varios
elementos HTML. Este proceso sucede en lo siguiente:
1. El parametro id no solo puede cargar un nombre de id de un elemento HTML, sino varios,
	por ejemplo:
		  cargaDatos_x_value("txt_punto_llegada,cmb_Motivo,txt_ruc_transportista", 
		  id_zna, "guia_remision_tmp.punto_llegada_zna.php");
	En este caso el parametro id esta recibiendo tres valores:
		  "txt_punto_llegada,cmb_Motivo,txt_ruc_transportista"
	Los cuales estan separados por una coma (,). la función separa esos tres valores y los
	usa para cargar los elementos HTML con datos que recibiran desde el archivo:
		  "guia_remision_tmp.punto_llegada_zna.php"
2. Por otro lado el archivo debe devolver también tres valores, y cuando la función los
	reciba, los separa, usando el comando: 
		  resultados=resultado[1].split(':');
	de esta forma tanto los valores de id y la cantidad de valores que recibe del archivo
	deben coincidir.
	El archivo debe devolver los valores usando la siguiente sintaxis: 
			echo "*=valor1:valor2:valor3"; o
			echo "1=valor1;
	El primer caso es para varios valores devueltos. El segundo es para un solo valor.
	La función verifica este primer dato como 1 o *, y de acuerdo a ello realiza una
	lectura de los datos contenidos en la respuesta:
			contenido.responseText
*/
	echo "
	<script>
	function cargaDatos_x_value(id, cadena, archivo)
	{
		//Verifica que los parametros no esten vacíos
		if (id=='' || archivo=='')
		{
			alert('Error en función, el parámetro id o archivo, o ambos pueden estar vacíos.');
		}
		else
		{
			//Asigna a ids todos los datos del parametro id. El parametro id puede contener un
			//solo dato o varios, y en caso de ser varios deben estar separados por comas(,)
			var ids=id.split(',');
			//Si valor de cadena es vacio se reemplaza con vacio el o todos los elementos HTML
			//contenidos en ids
			if (cadena=='')
			{
				if (ids.length>1)
				{
					//Si hay mas de un elemento HTML contenido en ids se hace un recorrido y se
					//reemplaza por vacios
					for (var i=0; i<ids.length; i++)
					{
						document.getElementById(ids[i]).value = '';
					}
				}
				else
				{
					//Si hay un solo elemento HTML en ids, se reemplaza ese unico elmento por vacio
					document.getElementById(id).value = '';
				}
				return;
			} 
			else 
			{
				var datos='datos='+cadena;
				var contenido = new XMLHttpRequest();
				contenido.onreadystatechange = respuesta;
				contenido.open('POST', archivo, true);
				contenido.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				//contenido.setRequestHeader('Content-length', datos.length);
				//contenido.setRequestHeader('Connection', 'close');
				contenido.send(datos);
				//Lee los datos de respuesta enviados por el archivo
				function respuesta() 
				{
					//Si la respuesta es valida se generan los datos de respuesta
					if (contenido.readyState == 4 && contenido.status == 200) 
					{
						//El resultado se divide en dos partes usando como separador el simbolo =
						var resultado=contenido.responseText.split('=');
						if (resultado[0]=='1')
						{
							//Si la primera parte del resultado es 1, entonces se usa el primer dato
							//del arreglo resultado
							document.getElementById(id).value = resultado[1];
						}
						else
						{
							//Si hay mas datos, la segunda parte se divide usando el simbolo :
							resultados=resultado[1].split(':');
							//Se recorre el arreglo resultados para obtener todos los datos
							for (var i=0; i<resultados.length; i++)
							{
								//Se almacena en cada elemento HTML el valor del arreglo resultados
								document.getElementById(ids[i]).value = resultados[i];
							}
						}
					}
				};
			}
		}
	}
	</script>";
}
function inicializa_ventana_busqueda()
{
	echo "
	<script>
	function ventana_busqueda(id, archivo) 
	{
		var opcion = prompt('Ingrese el dato a buscar:');
		if (opcion != null && opcion != '') 
		{
			muestraDatos(id, opcion, archivo);
		}
	}
	</script>";
}
function carga_ventana_tipo01()
{
	// La funcion JavaScript ventana() abre una nueva ventana donde se pueden hacer operaciones
	// o procesos que se pueden devolver como valores a la ventana origen o ventana padre. Todas
	// las operaciones o procesos se hacen dentro del codigo de la ventana abierta (o ventana hijo).
	// Los parametros de esta función son:
	// archivo       = Nombre del archivo PHP que se abrirá cuando se llame a esta función
	// nombreVentana = Nombre de la ventana que se envía con el comando window.open. Los datos de la
	//                 ventana creada se guardan como parte de la variable nombre_ventana
	// anchV         = Ancho de la ventana. El valor es en porcentaje ya que dentro este convertira
   //                 ese valor en su equivalente en pixeles
	// altoV         = Alto de la ventana. El valor es en porcentaje ya que dentro este convertira
	//                 ese valor en su equivalente en pixeles
	echo "
	<script>
		function ventana_tipo01(archivo,nombreVentana,anchV,altoV)
		{
			var x=window.screenX; var y=window.screenY; var ancho=window.outerWidth; var alto=window.outerHeight;
			var ancho_p=Math.round(ancho*anchV/100); var alto_p=Math.round(alto*altoV/100);
			var izquierda=(x+((ancho-ancho_p)/2)).toString(); var arriba=(y+((alto-alto_p)/2)).toString();
			nombre_ventana=window.open(archivo,nombreVentana,'width='+ancho_p.toString()+',height='+alto_p.toString()+',top='+arriba+',left='+izquierda+',toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no');
		}
	</script>
	";
}
function boton_busqueda($id_div, $archivo_busqueda)
{ ?>
	<button type="button" onclick="ventana_busqueda('<?php echo $id_div;?>', '<?php echo $archivo_busqueda;?>')" style="border:none; background:transparent; width:30px; vertical-align:top; padding:0px;"><image src="../imagenes/lupa.png" height ="24" width="26" style="margin-bottom:0px; margin-top:0px; padding:0px;"/></button> <?php
}
function envia_datos_venta_a_SUNAT($Conexion,$id_rvc)
{
	if (ruta_existe("../datasunat/"))
	{
		$resultado_generar_comprobelect="";
		if (comprob_emitido($Conexion,$id_rvc)==0)
		{
			nombre_archivo_xml($Conexion,$id_rvc,$nombrearchivo);
			require_once './sendXML.php';
			$response=sendXMLSUNAT($id_rvc);
			if($response['success'])
			{
				$sql_update="UPDATE regvtacaja SET ticketsunat_rvc=?, codigocdr_rvc=?, mensajecdr_rvc=? WHERE id_rvc=?";
				if($stmt=mysqli_prepare($Conexion, $sql_update))
				{
					mysqli_stmt_bind_param($stmt, "sisi", $response['ticket'], $response['codigo_cdr'], $response['respuesta_cdr'], $id_rvc);
					mysqli_stmt_execute($stmt);
					$resultado_generar_comprobelect="1"; //Resultado de generar archivo XML, enviarlo a SUNAT y recibir respuesta
				}
			}
			else
			{
				$sql_update="UPDATE regvtacaja SET ticketsunat_rvc=?, codigocdr_rvc=?, mensajecdr_rvc=? WHERE id_rvc=?";
				if($stmt=mysqli_prepare($Conexion, $sql_update))
				{
					mysqli_stmt_bind_param($stmt, "sisi", $response['ticket'], $response['codigo_cdr'], $response['respuesta_cdr'], $id_rvc);
					mysqli_stmt_execute($stmt);
					$resultado_generar_comprobelect="0"; // Resultado de generar archivo XML enviado a SUNAT y recibir respuesta verdadera en la variable $resultado_generar_comprobelect="1".
				}
			}
			if ($resultado_generar_comprobelect=="1")
			{
				updatesql($Conexion,"UPDATE regvtacaja SET cee_rvc=1, nombarch_rvc='$nombrearchivo' WHERE id_rvc='$id_rvc'","Error al actualizar cee_rvc y nombarch_rvc en regvatcaja");
				mensaje("Se emitio un archivo electronico XML de forma satisfactoria.");
			}
		}
		else mensaje("Ya se emitio este comprobante como Comprobante Electrónico. Verifique su condición.");
	}
	else mensaje("No se encontró la ruta del Facturador Electrónico. No se generó el comprobante electrónico.");
}
function convertir_serie_a_formato_SUNAT($tipoDocumento,&$serie)
{
	if ($tipoDocumento=="Boleta de venta")
	{
		$caracter_inicial="B";
	}
	if ($tipoDocumento=="Factura")
	{
		$caracter_inicial="F";
	}
	if ($tipoDocumento<>"Boleta de venta" AND $tipoDocumento<>"Factura")
	{
		$caracter_inicial="A";
	}
	$serie = $caracter_inicial.substr("000".$serie, -3);
}
function tbl_lista_comprob_SUNAT($Conex,$vStylMargIzq,$vStyAltura,$vSql,$claseTabla,$soap,$service)
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	$cuentaparametros = count($arregloparametros);
	for($i = 7; $i < $cuentaparametros; $i++)
	{
		$j++;
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<div id="div1" style="width:100%; height:32px; overflow-x:hidden;">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<?php
	$soap->setCredentials('20602109225IDAKENC2', 'jmoptta1U');
	$service->setClient($soap);
	$rucEmisor="20602109225";
	?>
	<div id="div2" style="width:100%; overflow:auto; <?php echo $vStyAltura;?>">
		<table class="<?php echo $claseTabla;?>" border='0' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			mysqli_data_seek($vSql, 0); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="verifica_comprobante")
						{
							$comprobante = explode("-",$rs[$campos[$i]]);
							$tipoDocumento=$comprobante[0];
							$serieComprobante=$comprobante[1];
							$numeroCorrelativo=$comprobante[2];
							$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
							convertir_serie_a_formato_SUNAT($tipoDocumento, $serieComprobante);
							$result = $service->getStatusCdr($rucEmisor, $codigo_tipoDocumento, $serieComprobante, $numeroCorrelativo);
							$validez_consulta = $result->isSuccess() ? "1" : "0";
							$codigo_estado = $result->getCode();
							$mensaje_estado = $result->getMessage();
							$resultado_comprobacion="";
							if ($codigo_estado=="0004")
							{
								$resultado_comprobacion = "Válido";
							}
							if ($codigo_estado=="0127")
							{
								$resultado_comprobacion = "No Válido";
							} 
							?><td width="<?php echo $taman[$i];?>"><?php echo $resultado_comprobacion; ?></td><?php
							$result = NULL;
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
function tbl_verificar_comprobante_sunat_Excel($Conex,$vStylMargIzq,$vSql,$ambito,$soap,$service)
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	$cuentaparametros = count($arregloparametros);
	for($i = 6; $i < $cuentaparametros; $i++)
	{
		$j++;
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<div id="div1" style="width:100%; height:40px; overflow-x:hidden;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<?php
	$soap->setCredentials('20602109225IDAKENC2', 'jmoptta1U');
	$service->setClient($soap);
	$rucEmisor="20602109225";
	?>
	<div id="div2" style="width:100%; overflow:auto;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
						if ($variabletmp1[0]=="coddocident")
						{
							$tdoc=tipodocclie($Conex,$rs[$campos[$i]]);
							?><td width="<?php echo $taman[$i];?>"><?php echo coddocident($tdoc); ?></td><?php
						}
						if ($variabletmp1[0]=="cod_comprobante")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo cod_comprobante($rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="res_anulado")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo res_anulado($rs[$campos[$i]],$rs[$variabletmp1[1]]); ?></td><?php
						}
						if ($variabletmp1[0]=="serie_ce")
						{
							$tipo_documento=valfield($Conex,"regvtacaja","tipodoccp_rvi","id_rvc",$rs[$campos[$i]]);
							$serie_documento=valfield($Conex,"regvtacaja","seriecp_rvi","id_rvc",$rs[$campos[$i]]);
							if ($tipo_documento=="Factura")
							{
								$serie="F".substr("000".$serie_documento,-3);
							}
							else
							{
								if ($tipo_documento=="Boleta de venta")
								{
									$serie="B".substr("000".$serie_documento,-3);
								}
								else
								{
									$serie=$serie_documento;
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $serie;?></td><?php
						}
						if ($variabletmp1[0]=="numero_ce")
						{
							$numero_documento=valfield($Conex,"regvtacaja","numcp_rvi","id_rvc",$rs[$campos[$i]]);
							$numero=substr("00000000".$numero_documento,-8);
							?><td width="<?php echo $taman[$i];?>" style="mso-number-format:'@'"><?php echo $numero;?></td><?php
						}
						//añadido (23-05-2022)
						if ($variabletmp1[0]=="nota_credito")
						{
							$nota_credito = "";
							$estado_registro = $rs[$campos[$i]];
							$id_rvc = $rs[$variabletmp1[1]];
							if ($estado_registro == "anulado")
							{
								$nota_credito = valfield($Conex,"regvtacaja","mensjcdr_ncred","id_rvc",$id_rvc);
								if (!empty($nota_credito))
								{
									$nota_credito = substr($nota_credito,26,13);
									//La Nota de credito numero B001-00000001, ha sido aceptada
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $nota_credito;?></td><?php
						}
						if ($variabletmp1[0]=="verifica_comprobante")
						{
							$comprobante = explode("-",$rs[$campos[$i]]);
							$tipoDocumento=$comprobante[0];
							$serieComprobante=$comprobante[1];
							$numeroCorrelativo=$comprobante[2];
							$codigo_tipoDocumento = cod_comprobante($tipoDocumento);
							convertir_serie_a_formato_SUNAT($tipoDocumento, $serieComprobante);
							$result = $service->getStatusCdr($rucEmisor, $codigo_tipoDocumento, $serieComprobante, $numeroCorrelativo);
							$validez_consulta = $result->isSuccess() ? "1" : "0";
							$codigo_estado = $result->getCode();
							$mensaje_estado = $result->getMessage();
							$resultado_comprobacion="";
							if ($codigo_estado=="0004")
							{
								$resultado_comprobacion = "Válido";
							}
							if ($codigo_estado=="0127")
							{
								$resultado_comprobacion = "No Válido";
							} 
							?><td width="<?php echo $taman[$i];?>"><?php echo $resultado_comprobacion; ?></td><?php
							$result = NULL;
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
//--------- Usado en vez del servicio billConsultService, actualmente inactivo -------------- 
function tbl_validez_comprobante_sunat_Excel($Conex,$vStylMargIzq,$vSql,$ambito,$token)
{
	$j=$suma=0;
	$titulos=array();
	$campos=array();
	$taman=array();
	$funcion=array();
	$arregloparametros = func_get_args();
	$cuentaparametros = count($arregloparametros);
	for($i = 5; $i < $cuentaparametros; $i++)
	{
		$j++;
		$variableparam=$arregloparametros[$i];
		$variabletmp = explode(":", $variableparam);
		$titulos[$j]=$variabletmp[0];
		$campos[$j]=$variabletmp[1];
		$taman[$j]=$variabletmp[2];
		$funcion[$j]=$variabletmp[3];
	}
	for ($i=1; $i <= $j; $i++)
	{
		$suma=$suma+$taman[$i];
	}
	?>
	<div id="div1" style="width:100%; height:40px; overflow-x:hidden;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					fthead($titulos[$i], $taman[$i]);
				}
				?>
			</tr>
		</table>
	</div>
	<?php
	$rucEmisor="20602109225";
	?>
	<div id="div2" style="width:100%; overflow:auto;">
		<table border='1' cellspacing='0' cellpadding='0' style="<?php echo $vStylMargIzq;?> table-layout:fixed; width:<?php echo $suma;?>px;">
			<?php
			if ($ambito=="Normal")
			{
				$numero_filas=mysqli_num_rows($vSql);
				$registro=$numero_filas-10;
			}
			else
			{
				$registro=0;
			}
			mysqli_data_seek($vSql, $registro); 
			while($rs = mysqli_fetch_array($vSql, MYSQLI_ASSOC))
			{
			?>
			<tr>
				<?php
				for ($i=1; $i <= $j; $i++)
				{
					if ($funcion[$i]=="N")
					{
						ftdata($rs[$campos[$i]], $taman[$i]);
					}
					else
					{
						$variabletmp1 = explode("|", $funcion[$i]);
						if ($variabletmp1[0]=="valfield")
						{
							$vtabla=$variabletmp1[1];
							$vcampo=$variabletmp1[2];
							$vid=$variabletmp1[3];
							?><td width="<?php echo $taman[$i];?>"><?php echo valfield($Conex,$vtabla,$vcampo,$vid,$rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="invFech")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo invFech($rs[$campos[$i]],"-"); ?></td><?php
						}
						if ($variabletmp1[0]=="coddocident")
						{
							$tdoc=tipodocclie($Conex,$rs[$campos[$i]]);
							?><td width="<?php echo $taman[$i];?>"><?php echo coddocident($tdoc); ?></td><?php
						}
						if ($variabletmp1[0]=="cod_comprobante")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo cod_comprobante($rs[$campos[$i]]); ?></td><?php
						}
						if ($variabletmp1[0]=="res_anulado")
						{
							?><td width="<?php echo $taman[$i];?>"><?php echo res_anulado($rs[$campos[$i]],$rs[$variabletmp1[1]]); ?></td><?php
						}
						if ($variabletmp1[0]=="serie_ce")
						{
							$tipo_documento=valfield($Conex,"regvtacaja","tipodoccp_rvi","id_rvc",$rs[$campos[$i]]);
							$serie_documento=valfield($Conex,"regvtacaja","seriecp_rvi","id_rvc",$rs[$campos[$i]]);
							if ($tipo_documento=="Factura")
							{
								$serie="F".substr("000".$serie_documento,-3);
							}
							else
							{
								if ($tipo_documento=="Boleta de venta")
								{
									$serie="B".substr("000".$serie_documento,-3);
								}
								else
								{
									$serie=$serie_documento;
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $serie;?></td><?php
						}
						if ($variabletmp1[0]=="numero_ce")
						{
							$numero_documento=valfield($Conex,"regvtacaja","numcp_rvi","id_rvc",$rs[$campos[$i]]);
							$numero=substr("00000000".$numero_documento,-8);
							?><td width="<?php echo $taman[$i];?>" style="mso-number-format:'@'"><?php echo $numero;?></td><?php
						}
						//añadido (23-05-2022)
						if ($variabletmp1[0]=="nota_credito")
						{
							$nota_credito = "";
							$estado_registro = $rs[$campos[$i]];
							$id_rvc = $rs[$variabletmp1[1]];
							if ($estado_registro == "anulado")
							{
								$nota_credito = valfield($Conex,"regvtacaja","mensjcdr_ncred","id_rvc",$id_rvc);
								if (!empty($nota_credito))
								{
									$nota_credito = substr($nota_credito,26,13);
									//La Nota de credito numero B001-00000001, ha sido aceptada
								}
							}
							?><td width="<?php echo $taman[$i];?>"><?php echo $nota_credito;?></td><?php
						}
						if ($variabletmp1[0]=="verifica_comprobante")
						{
							$comprobante = explode("-",$rs[$campos[$i]]);
							$tipoDocumento=$comprobante[0];
							$serieComprobante=$comprobante[1];
							$numeroCorrelativo=$comprobante[2];
							$fecha=$comprobante[3];
							$monto=$comprobante[4];
							convertir_serie_a_formato_SUNAT($tipoDocumento, $serieComprobante);
							$datos_comprobante=datos_de_comprobante($tipoDocumento,$serieComprobante,$numeroCorrelativo,$fecha,$monto);
							consulta_validez($token,$datos_comprobante,$mensaje,$mensaje_estadoCp,$mensaje_estadoRUC,$mensaje_condDomiRuc);
							$resultado_comprobacion="";
							if ($mensaje=="Consulta realizada.")
							{
								$resultado_comprobacion=$mensaje_estadoCp;
								if (!empty($mensaje_estadoRUC)) $resultado_comprobacion=$resultado_comprobacion.", ".$mensaje_estadoRUC.", ".$mensaje_condDomiRuc;
							}
							else
							{
								$resultado_comprobacion=$mensaje;
							}

							// if ($codigo_estado=="0004")
							// {
								// $resultado_comprobacion = "Válido";
							// }
							// if ($codigo_estado=="0127")
							// {
								// $resultado_comprobacion = "No Válido";
							// } 
							?><td width="<?php echo $taman[$i];?>"><?php echo $resultado_comprobacion; ?></td><?php
							$result = NULL;
						}
					}
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
//Funciones para manejo de botones en accesos de perfil
function activar_boton($datos,$resultado_perfil_accesos,$boton)
{
	$id_usr = $datos["id_usr"];
	$categ_usr = $datos["categ_usr"];
	$nivel_usuario = $datos["nivel_usr"];
	$zona_usuario = $datos["zona_usr"];
	$desc_per = $datos["desc_per"];
	if ($id_usr==2 OR ($categ_usr=="Prog" AND $nivel_usuario=="tot") OR ($categ_usr=="Prog" AND $zona_usuario=="Total") OR $desc_per=="Total")
	{
		return true;
	}
	else
	{
		$filas_perfil_accesos = mysqli_num_rows($resultado_perfil_accesos);
		if ($filas_perfil_accesos<>0)
		{
			mysqli_data_seek($resultado_perfil_accesos,0);
			while($resultado = mysqli_fetch_array($resultado_perfil_accesos,MYSQLI_ASSOC))
			{
				$descrip_boton=$resultado["descrip_boton"];
				$activo_boton=$resultado["activo_boton"];
				if ($descrip_boton==$boton AND $activo_boton=="S")
				{
					return true;
				}
			}
			return false;
		}
	}
	// return true;
}
function verificar_procesos_de_boton($resultado_perfil_accesos)
{
	$filas_perfil_accesos = mysqli_num_rows($resultado_perfil_accesos);
	if ($filas_perfil_accesos==0)
	{
		mensaje("No existen accesos permitidos a las operaciones para este módulo.");
	}
}
function cargar_datos_perfil($Conexion,$ident_usuario,$descrip_submenu,&$resultado_perfil_accesos,&$datos,$categ_usuario,$nivel_usuario,$zona_usuario)
{
	$desc_per=valfield($Conexion,"usuarios","desc_per","id_usr",$ident_usuario);
	$sql_perfil_accesos  ="SELECT * FROM perfil_accesos WHERE descrip_perfil='$desc_per' AND descrip_submenu='$descrip_submenu' AND activo_boton='S' ORDER BY orden_menu ASC, orden_submenu ASC, orden_boton ASC";
	$resultado_perfil_accesos = mysqli_query ($Conexion,$sql_perfil_accesos) or die ("Error al traer los datos de consulta de perfil de accesos.");
	$datos = ["id_usr" => $ident_usuario, "categ_usr" => $categ_usuario, "nivel_usr" => $nivel_usuario, "zona_usr" => $zona_usuario,	"desc_per" => $desc_per];
}
//---------------- Consulta de validez de comprobantes ----------------
function obtener_token()
{
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api-seguridad.sunat.gob.pe/v1/clientesextranet/fe9c3d67-a8c4-4993-aa24-eada549551f4/oauth2/token/',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.sunat.gob.pe%2Fv1%2Fcontribuyente%2Fcontribuyentes&client_id=fe9c3d67-a8c4-4993-aa24-eada549551f4&client_secret=i1ndygcCSS4%2BJYIaxCDUPA%3D%3D',
	  CURLOPT_HTTPHEADER => array(
		 'Content-Type: application/x-www-form-urlencoded',
		 'Cookie: TS019e7fc2=019edc9eb8cad0fd8bc6d51c5a226fa5599fbc260a4fddb035aa9321ddcec4bd80602ef30e363d320ea43beebaff3c64b825586466'
	  ),
	));
	$response = curl_exec($curl);
	$resultado = json_decode($response, true);
	curl_close($curl);
	$access_token = $resultado["access_token"];
	$token_type = $resultado["token_type"];
	$expires_in = $resultado["expires_in"];
	return $access_token;
}
function consulta_validez($access_token,$datos_comprobante,&$mensaje,&$mensaje_estadoCp,&$mensaje_estadoRUC,&$mensaje_condDomiRuc)
{
	$dc=explode("|",$datos_comprobante);
	$codComp=$dc[0];
	$numeroSerie=$dc[1];
	$numero=$dc[2];
	$fechaEmision=$dc[3];
	$monto=$dc[4];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/20602109225/validarcomprobante',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		 "numRuc":"20602109225",
		 "codComp":"'.$codComp.'",
		 "numeroSerie":"'.$numeroSerie.'",
		 "numero":"'.$numero.'",
		 "fechaEmision":"'.$fechaEmision.'",
		 "monto":"'.$monto.'"
	}',
	  CURLOPT_HTTPHEADER => array(
		 'Authorization: Bearer '.$access_token,
		 'Content-Type: application/json'
	  ),
	));
	$response = curl_exec($curl);
	$datos = json_decode($response,true);
	if (isset($datos["success"])) { $success = $datos["success"]; } else { $success=false; }
	if (isset($datos["message"])) { $message = $datos["message"]; } else { $message=$response; }
	if ($success)
	{
		$mensaje="Consulta realizada.";
		$data = $datos["data"];
		$data_estadoCp = $data["estadoCp"];
		$mensaje_estadoCp=msj_estadoCp($data_estadoCp);
		if ($data_estadoCp=="0")
		{
			$mensaje_estadoRUC="";
			$mensaje_condDomiRuc="";
		}
		else
		{
			$data_estadoRUC = $data["estadoRuc"];
			$data_condDomiRUC = $data["condDomiRuc"];
			$mensaje_estadoRUC=msj_estadoRUC($data_estadoRUC);
			$mensaje_condDomiRuc=msj_condDomiRuc($data_condDomiRUC);
		}
	}
	else
	{
		$mensaje="Operacion fallida!. Verificar datos del envío.".$message;
		$mensaje_estadoCp="";
		$mensaje_estadoRUC="";
		$mensaje_condDomiRuc="";
	}
	curl_close($curl);
}
function datos_de_comprobante($tipoDocumento,$serie,$correlativo,$fechaemi_rvi,$importetot_rvi)
{
	$codigo_comprobante=cod_comprobante($tipoDocumento);
	$fecha_emision=str_replace("-","/",$fechaemi_rvi);
	$datos_comprobante=$codigo_comprobante."|".$serie."|".$correlativo."|".$fecha_emision."|".$importetot_rvi;
	return $datos_comprobante;
}
//---------------- Fin de consulta de validez de comprobantes ----------------
function msj_estadoCp($data_estadoCp)
{
	$descripcion="";
	switch ($data_estadoCp)
	{
		case "0":
			$descripcion="NO EXISTE";
			break;
		case "1":
			$descripcion="ACEPTADO";
			break;
		case "2":
			$descripcion="ANULADO";
			break;
	}
	return $descripcion;
}

function extension_msj_estadoCp($mensaje_estadoCp)
{
	$descripcion="";
	switch ($mensaje_estadoCp)
	{
		case "NO EXISTE":
			$descripcion="Comprobante no informado";
			break;
		case "ACEPTADO":
			$descripcion="Comprobante aceptado";
			break;
		case "ACEPTADO":
			$descripcion="Comunicado en una baja";
			break;
	}
	return $descripcion;
}


function msj_estadoRUC($data_estadoRUC)
{
	$descripcion="";
	switch ($data_estadoRUC)
	{
		case "00":
			$descripcion="ACTIVO";
			break;
		case "01":
			$descripcion="BAJA PROVISIONAL";
			break;
		case "02":
			$descripcion="BAJA PROV. POR OFICIO";
			break;
		case "03":
			$descripcion="SUSPENSION TEMPORAL";
			break;
		case "10":
			$descripcion="BAJA DEFINITIVA";
			break;
		case "11":
			$descripcion="BAJA DE OFICIO";
			break;
		case "12":
			$descripcion="INHABILITADO-VENT.UNICA";
			break;
	}
	return $descripcion;
}
function msj_condDomiRuc($data_condDomiRUC)
{
	$descripcion="";
	switch ($data_condDomiRUC)
	{
		case "00":
			$descripcion="HABIDO";
			break;
		case "09":
			$descripcion="PENDIENTE";
			break;
		case "11":
			$descripcion="POR VERIFICAR";
			break;
		case "12":
			$descripcion="NO HABIDO";
			break;
		case "20":
			$descripcion="NO HALLADO";
			break;
	}
	return $descripcion;
}
function redireccion($ruta)
{
	echo "<script> location.href = '".$ruta."'; </script>";
}
?>