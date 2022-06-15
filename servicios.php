<?php include("template/cabecera.php"); ?>

<?php include("administrador/config/bd.php");
$sentenciaSQL = $conexion->prepare("SELECT * FROM servicios");
$sentenciaSQL->execute();
$listaservicios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach ($listaservicios as $servicios) { ?>

   <div class="col-md-3">
      <br>
      <div class="card">
         <img class="card-img-top" src="./img/<?php echo $servicios['Imagen']; ?>" alt="">
         <div class="card-body">
            <h5 class="card-title"><?php echo $servicios['Nombre']; ?></h5>
            <h5 class="card-title">Precio : <?php echo $servicios['Precio']; ?> $</h5>
            <h5 class="card-title">Disponobilidad : <?php echo $servicios['Cantidad']; ?></h5>
            <a name="" id="" class="btn btn-primary" href="" role="button">Comprar</a>
         </div>
      </div>
   </div>

<?php } ?>


<?php include("template/pie.php"); ?>