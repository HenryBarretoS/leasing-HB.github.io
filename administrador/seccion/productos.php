<?php include("../template/cabecera.php"); ?>
<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtMarca = (isset($_POST['txtMarca'])) ? $_POST['txtMarca'] : "";
$txtModelo = (isset($_POST['txtModelo'])) ? $_POST['txtModelo'] : "";
$txtAño = (isset($_POST['txtAño'])) ? $_POST['txtAño'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtColor = (isset($_POST['txtColor'])) ? $_POST['txtColor'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {

   case "Agregar":
      $sentenciaSQL = $conexion->prepare("INSERT INTO carro (`Marca`, Modelo, `Año` , Precio, Color, Imagen ) VALUES ('mazda',:Modelo, '2022' , :Precio , :Color , :Imagen );");
      $sentenciaSQL->bindParam('Modelo', $txtModelo);
      $sentenciaSQL->bindParam('Precio', $txtPrecio);
      $sentenciaSQL->bindParam('Color', $txtColor);

      $fecha = new DateTime();
      $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

      $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
      if ($tmpImagen != "") {
         move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
      }

      $sentenciaSQL->bindParam('Imagen', $nombreArchivo);
      $sentenciaSQL->execute();
      header("Location:productos.php");
      break;

   case "Modifica":
      $sentenciaSQL = $conexion->prepare("UPDATE carro SET modelo=:modelo WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':modelo', $txtModelo);
      $sentenciaSQL->execute();

      $sentenciaSQL = $conexion->prepare("UPDATE carro SET precio=:precio WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':precio', $txtPrecio);
      $sentenciaSQL->execute();

      $sentenciaSQL = $conexion->prepare("UPDATE carro SET color=:color WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':color', $txtColor);
      $sentenciaSQL->execute();

      if ($txtImagen != "") {
         $fecha = new DateTime();
         $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
         $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
         move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

         $sentenciaSQL = $conexion->prepare("SELECT imagen FROM carro WHERE id=:id");
         $sentenciaSQL->bindParam(':id', $txtID);
         $sentenciaSQL->execute();
         $carro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

         if (isset($carro["imagen"]) && ($carro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $carro["imagen"])) {
               unlink("../../img/" . $carro["imagen"]);
            }
         }
         $sentenciaSQL = $conexion->prepare("UPDATE carro SET imagen=:imagen WHERE id=:id");
         $sentenciaSQL->bindParam(':id', $txtID);
         $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
         $sentenciaSQL->execute();
      }
      header("Location:productos.php");
      break;

   case "Cancelar":
      header("Location:productos.php");
      break;

   case "Seleccionar":
      $sentenciaSQL = $conexion->prepare("SELECT * FROM carro WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $carro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      $txtMarca = $carro['Marca'];
      $txtModelo = $carro['Modelo'];
      $txtAño = $carro['Año'];
      $txtPrecio = $carro['Precio'];
      $txtColor = $carro['Color'];
      $txtImagen = $carro['Imagen'];

      break;

   case "Borrar":
      $sentenciaSQL = $conexion->prepare("SELECT imagen FROM carro WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $carro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      if (isset($carro["imagen"]) && ($carro["imagen"] != "imagen.jpg")) {
         if (file_exists("../../img/" . $carro["imagen"])) {
            unlink("../../img/" . $carro["imagen"]);
         }
      }

      $sentenciaSQL = $conexion->prepare("DELETE FROM carro WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      header("Location:productos.php");
      break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM carro");
$sentenciaSQL->execute();
$listacarro = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-4">
   <div class="card">
      <div class="card-header">
         Datos de Vehiculos
      </div>
      <div class="card-body">
         <form method="POST" enctype="multipart/form-data">


            <div class="form-group">
               <label for="txtID">ID :</label>
               <input type="text" required readonly class="form-control" value="<?php echo $txtID ?>" name=" txtID" id="txtID" placeholder="">
            </div>

            <div class="form-group">
               <label for="txtMarca">Marca :</label>
               <input type="text" required readonly class="form-control" value="<?php echo $txtMarca ?>" name=" txtMarca" id="txtMarca" placeholder="">
            </div>

            <div class="form-group">
               <label for="txtModelo">Modelo :</label>
               <input type="text" required class="form-control" value="<?php echo $txtModelo ?>" name="txtModelo" id="txtModelo" placeholder="Modelo">
            </div>

            <div class="form-group">
               <label for="txtAño">Año :</label>
               <input type="text" required readonly class="form-control" value="<?php echo $txtAño ?>" " name=" txtAño" id="txtAño" placeholder="">
            </div>

            <div class="form-group">
               <label for="Precio">Precio : $</label>
               <input type="txt" required class="txtPrecio" value="<?php echo $txtPrecio ?>" name="txtPrecio" placeholder="">
            </div>

            <div class="form-group">
               <label for="txtColor">Color :</label>
               <input type="text" required class="form-control" value="<?php echo $txtColor ?>" name="txtColor" id="txtColor" placeholder="Color">
            </div>

            <div class="form-group">
               <label for="txtNombre">Imagen :</label>

               <br />

               <?php
               if ($txtImagen != "") { ?>

                  <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="100" alt="" srcset="">

               <?php } ?>



               <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre">
            </div>

            <div class="btn-group" role="group" aria-label="">
               <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
               <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modifica" class="btn btn-info">Modifica</button>
               <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-warning">Cancelar</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="col-md-8">
   <table class="table">
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Marca</th>
               <th>Modelo</th>
               <th>Año</th>
               <th>Precio</th>
               <th>Color</th>
               <th>Imagen</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($listacarro as $carro) { ?>
               <tr>
                  <td><?php echo $carro['ID']; ?></td>
                  <td>Mazda</td>
                  <td><?php echo $carro['Modelo']; ?></td>
                  <td>2022</td>
                  <td>$<?php echo $carro['Precio']; ?></td>
                  <td><?php echo $carro['Color']; ?></td>
                  <td>
                     <img class="img-thumbnail rounded" src="../../img/<?php echo $carro['Imagen']; ?>" width="100" alt="" srcset="">
                  </td>
                  <td>
                     <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $carro['ID']; ?>" />
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                     </form>
                  </td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </table>
</div>
<?php include("../template/pie.php"); ?>