<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$dato = $_POST['id'];
$datos = explode("|",$dato);
$grupo = $datos[0];
$tipo = $datos[1];
$marca = $datos[2];
$modelo = $datos[3];
$activo = $datos[4];
$where_sql="";
if (!empty($grupo)) $where_sql=$where_sql." tipo_cat='$grupo' AND";
if (!empty($tipo)) $where_sql=$where_sql." clase_cat='$tipo' AND";
if (!empty($marca)) $where_sql=$where_sql." marca_cat LIKE '%$marca%' AND";
if (!empty($modelo)) $where_sql=$where_sql." modelo_cat LIKE '%$modelo%' AND";
if (!empty($activo)) $where_sql=$where_sql." activo_cat='$activo' AND";
$where_sql=substr($where_sql,0,strlen($where_sql)-4);
if (!empty($where_sql))
{
	$cadena_consulta="SELECT * FROM catalogo WHERE ".$where_sql;
}
else
{
	$cadena_consulta="SELECT * FROM catalogo";
}
$sql_consulta= mysqli_query ($Conexion,$cadena_consulta)	or die ("Error al traer los datos de consulta al buscar grupo en catalogo.");
$filas_catalogo=mysqli_num_rows($sql_consulta);
if ($filas_catalogo>0) 
{
	echo "Cantidad de registros: ".$filas_catalogo;
	tblanchovariable_05($Conexion,"margin-left:10px;","height:210px;",$sql_consulta,"tblnormal","catalogo.php",
	"ID:id_cat:25:idLink|",
	"Grupo:tipo_cat:75:N",
	"Tipo:clase_cat:80:N",
	"Modelo:modelo_cat:170:N",
	"Marca:marca_cat:80:N",
	"Fecha:fechreg_cat:80:N",
	"Abreviado:abrv_cat:300:N",
	"Activo:activo_cat:45:N");
}
else
{
	echo "No hay datos.<br>";
}
?>