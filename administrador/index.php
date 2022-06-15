<?php
session_start();
if ($_POST) {
   if (($_POST['usuario'] == "admin") && ($_POST['password'] == "sistema")) {

      $_SESSION['usuario'] = "ok";
      $_SESSION['nombreUsuario'] = "Administrador";
      header('location:inicio.php');
   } else {
      $mensaje = "Error : El usuario o contraseña son incorrectos";
   }
}
?>
<!doctype html>
<html lang="en">

<head>
   <title>login administrador</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="bootstrap/css/estilos.css">
   <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
   <link rel="stylesheet" type="text/css" href="bootstrap/fuentes/iconic/css/material-design-iconic-font.min.css">
</head>

<body>

   <div class="container-login">
      <div class="wrap-login">
         <form class="login-form validate-form" id="formLogin" action="" method="post">
            <span class="login-form-title">LOGIN</span>

            <?php if (isset($mensaje)) { ?>
               <div class="alert alert-danger" role="alert">
                  <?php echo $mensaje; ?>
               </div>
            <?php } ?>

            <div class="wrap-input100" data-validate="Usuario incorrecto">
               <input class="input100" type="text" id="usuario" name="usuario" placeholder="Usuario">
               <span class="focus-efecto"></span>
            </div>

            <div class="wrap-input100" data-validate="Password incorrecto">
               <input class="input100" type="password" id="password" name="password" placeholder="Contrasenia">
               <span class="focus-efecto"></span>
            </div>

            <div class="container-login-form-btn">
               <div class="wrap-login-form-btn">
                  <div class="login-form-bgbtn"></div>
                  <button type="submit" name="submit" class="login-form-btn">CONECTAR</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</body>

</html>