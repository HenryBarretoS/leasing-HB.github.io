<?php include("../template/cabecera.php"); ?>
<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtCantidad = (isset($_POST['txtCantidad'])) ? $_POST['txtCantidad'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {

   case "Agregar":
      $sentenciaSQL = $conexion->prepare("INSERT INTO accesorios (Nombre, Precio, Cantidad, Imagen ) VALUES (:Nombre, :Precio , :Cantidad , :Imagen );");
      $sentenciaSQL->bindParam('Nombre', $txtNombre);
      $sentenciaSQL->bindParam('Precio', $txtPrecio);
      $sentenciaSQL->bindParam('Cantidad', $txtCantidad);

      $fecha = new DateTime();
      $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

      $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
      if ($tmpImagen != "") {
         move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
      }

      $sentenciaSQL->bindParam('Imagen', $nombreArchivo);
      $sentenciaSQL->execute();
      header("Location:accesorios.php");
      break;

   case "Modifica":
      $sentenciaSQL = $conexion->prepare("UPDATE accesorios SET nombre=:nombre WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':nombre', $txtNombre);
      $sentenciaSQL->execute();

      $sentenciaSQL = $conexion->prepare("UPDATE accesorios SET precio=:precio WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':precio', $txtPrecio);
      $sentenciaSQL->execute();

      $sentenciaSQL = $conexion->prepare("UPDATE accesorios SET cantidad=:cantidad WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->bindParam(':cantidad', $txtCantidad);
      $sentenciaSQL->execute();

      if ($txtImagen != "") {
         $fecha = new DateTime();
         $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
         $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
         move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

         $sentenciaSQL = $conexion->prepare("SELECT imagen FROM accesorios WHERE id=:id");
         $sentenciaSQL->bindParam(':id', $txtID);
         $sentenciaSQL->execute();
         $accesorios = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

         if (isset($accesorios["imagen"]) && ($accesorios["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $accesorios["imagen"])) {
               unlink("../../img/" . $accesorios["imagen"]);
            }
         }
         $sentenciaSQL = $conexion->prepare("UPDATE accesorios SET imagen=:imagen WHERE id=:id");
         $sentenciaSQL->bindParam(':id', $txtID);
         $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
         $sentenciaSQL->execute();
      }
      header("Location:accesorios.php");
      break;

   case "Cancelar":
      header("Location:accesorios.php");
      break;

   case "Seleccionar":
      $sentenciaSQL = $conexion->prepare("SELECT * FROM accesorios WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $accesorios = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      $txtNombre = $accesorios['Nombre'];
      $txtPrecio = $accesorios['Precio'];
      $txtCantidad = $accesorios['Cantidad'];
      $txtImagen = $accesorios['Imagen'];

      break;

   case "Borrar":
      $sentenciaSQL = $conexion->prepare("SELECT imagen FROM accesorios WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      $accesorios = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

      if (isset($accesorios["imagen"]) && ($accesorios["imagen"] != "imagen.jpg")) {
         if (file_exists("../../img/" . $accesorios["imagen"])) {
            unlink("../../img/" . $accesorios["imagen"]);
         }
      }

      $sentenciaSQL = $conexion->prepare("DELETE FROM accesorios WHERE id=:id");
      $sentenciaSQL->bindParam(':id', $txtID);
      $sentenciaSQL->execute();
      header("Location:accesorios.php");
      break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM accesorios");
$sentenciaSQL->execute();
$listaaccesorios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-4">
   <div class="card">
      <div class="card-header">
         Datos de Accesorios
      </div>
      <div class="card-body">
         <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
               <label for="txtID">ID :</label>
               <input type="text" required readonly class="form-control" value="<?php echo $txtID ?>" name=" txtID" id="txtID" placeholder="">
            </div>

            <div class="form-group">
               <label for="txtNombre">Nombre :</label>
               <input type="text" required class="form-control" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
            </div>

            <div class="form-group">
               <label for="Precio">Precio : $</label>
               <input type="txt" required id="txtPrecio" value="<?php echo $txtPrecio ?>" name="txtPrecio" placeholder="">
            </div>

            <div class="form-group">
               <label for="txtCantidad">Cantidad :</label>
               <input type="text" required class="form-control" value="<?php echo $txtCantidad ?>" name="txtCantidad" id="txtCantidad" placeholder="Disponibilidad">
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
               <th>Nombre</th>
               <th>Precio</th>
               <th>Cantidad</th>
               <th>Imagen</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($listaaccesorios as $accesorios) { ?>
               <tr>
                  <td><?php echo $accesorios['ID']; ?></td>
                  <td><?php echo $accesorios['Nombre']; ?></td>
                  <td>$<?php echo $accesorios['Precio']; ?></td>
                  <td><?php echo $accesorios['Cantidad']; ?></td>
                  <td>
                     <img class="img-thumbnail rounded" src="../../img/<?php echo $accesorios['Imagen']; ?>" width="100" alt="" srcset="">
                  </td>
                  <td>
                     <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $accesorios['ID']; ?>" />
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