<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$dato = $_POST['id'];
$v_id_cat="";
combo_select("div_catalogo","cmbctl",$Conexion,"SELECT * FROM catalogo WHERE abrv_cat LIKE '%$dato%'",$v_id_cat,"id_cat","abrv_cat","activo_cat");
?>