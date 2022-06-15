<?php
session_start();
if (!isset($_SESSION['usuario'])) {
   header("location:../index.php");
} else {
   if ($_SESSION['usuario'] == 'ok') {
      $nombreUsuario = $_SESSION["nombreUsuario"];
   }
}

?>

<!doctype html>
<html lang="en-US">

<head>
   <title>Inicio de administrador</title>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link rel="stylesheet" href="bootstrap/css/bootstrap.css.map" />


</head>

<body>
   <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/webcarro" ?>
   <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="nav navbar-nav">
         <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/inicio.php">Inicio</a>
         <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/seccion/productos.php">Vehículos</a>
         <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/seccion/servicios.php">Servicios</a>
         <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/seccion/accesorios.php">Accesorios</a>
         <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/seccion/cerrar.php">Cerrar</a>
         <a class=" nav-item nav-link" href="<?php echo $url; ?>">Ir sitio web</a>
      </div>
   </nav>
   <div class="container">
      <br>
      <div class="row">