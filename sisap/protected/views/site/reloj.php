<center>
<?php
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:5; url=$self"); //Refrescamos cada 300 segundos
date_default_timezone_set("America/Lima");
$hoy = date("Y-n-j");
$hora = date("H:i:s");
echo '<h3 class="badge-info">'.$hoy.'</h3>';
echo '<h4 class="badge-info">'.$hora.'</h4>'; 
?>
</center>