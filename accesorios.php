<?php include("template/cabecera.php"); ?>

<?php include("administrador/config/bd.php");
$sentenciaSQL = $conexion->prepare("SELECT * FROM accesorios");
$sentenciaSQL->execute();
$listaaccesorios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach ($listaaccesorios as $accesorios) { ?>

   <div class="col-md-3">
      <br>
      <div class="card">
         <img class="card-img-top" src="./img/<?php echo $accesorios['Imagen']; ?>" alt="">
         <div class="card-body">
            <h5 class="card-title"><?php echo $accesorios['Nombre']; ?></h5>
            <h5 class="card-title">Precio : <?php echo $accesorios['Precio']; ?> $</h5>
            <h5 class="card-title">Disponobilidad : <?php echo $accesorios['Cantidad']; ?></h5>
            <a name="" id="" class="btn btn-primary" href="" role="button">Compra</a>
         </div>
      </div>
   </div>

<?php } ?>


<?php include("template/pie.php"); ?>