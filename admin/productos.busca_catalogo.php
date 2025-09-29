<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$dato = $_POST['id'];
$var2="";
combo_select("div_catalogo","cmb_id_cat",$Conexion,"SELECT * FROM catalogo WHERE activo_cat='S' AND abrv_cat LIKE '%$dato%'",$var2,"id_cat","tipo_cat","abrv_cat");
?>