<?php include("template/cabecera.php"); ?>

<?php include("administrador/config/bd.php");
$sentenciaSQL = $conexion->prepare("SELECT * FROM carro");
$sentenciaSQL->execute();
$listacarro = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach ($listacarro as $carro) { ?>

   <div class="col-md-3">
      <br>
      <div class="card">
         <img class="card-img-top" src="./img/<?php echo $carro['Imagen']; ?>" alt="">
         <div class="card-body">
            <h5 class="card-title">Marca : <?php echo $carro['Marca']; ?></h5>
            <h5 class="card-title">Modelo : <?php echo $carro['Modelo']; ?></h5>
            <h5 class="card-title">Precio : <?php echo $carro['Precio']; ?> $</h5>
            <a name="compra" id="" class="btn btn-primary" href="" role="button">Comprar</a>

         </div>
      </div>
   </div>

<?php } ?>

<?php include("template/pie.php"); ?>