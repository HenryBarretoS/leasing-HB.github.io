
<?php
$host = "localhost"; //dirrecion donde se conecta el sevidor
$bd = "sitio carro";
$usuario = "root";
$contrasenia = "";

try {
   $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);
} catch (Exception $ex) {

   echo $ex->getMessage();
}
?>
