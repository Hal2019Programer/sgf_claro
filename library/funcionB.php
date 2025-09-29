<?php
function conexiondb(&$Conex)
{
    $Conex = mysqli_connect("localhost", "root", "", "sgf_claro") or die("Error en la Conexion con BD Claro.");
    mysqli_set_charset($Conex,'utf8');
}
?>
