<?php
        
        $idUser = "";
        
        if ($_GET){
            if ((isset($_GET['id']) && !empty($_GET['id']))){
                $idUser = $_GET['id'];
            }
        }else{
              header('Location: index.php');
        }
  
    
        if (isset($_POST['cambiaClave'])){
            if ((isset($_POST['clave']) && !empty($_POST['clave'])) && (isset($_POST['reclave']) && !empty($_POST['reclave']))) {
                if ($_POST['clave'] == $_POST['reclave']){
                    
                 require 'includes/conexion.inc.php';   
                    
                    $sqlActualizarDatos = "
                        UPDATE usuario
                            SET clave_usuario = '".password_hash($_POST['clave'], PASSWORD_DEFAULT)."'
                            WHERE id_usuario LIKE ".$idUser.";
                    ";
                    $queryActualizarDatos = mysqli_query($conectar, $sqlActualizarDatos);
                     mysqli_close($conectar);

                    header('Location: index.php?clave=listo');
                    //echo "Realizado";
                    
                }else{
                    echo "Las contraseñas no coinciden";
                }
            }else{
                echo "Debes rellenar todos los campos";
            }
        }
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="yucsan2018@alumnos.cei.es">
	<meta name="copyright" content="yucsan2018@alumnos.cei.es">
	<meta name="contact" content="yucsan2018@alumnos.cei.es">
	<meta name="description" content="Registro Los Cuadros de Rita">
	<meta name="keywords" content="">
	<meta name="robots" content="NoIndex, NoFollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="assets/css/all.min.css">
<!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.2/css/all.css"> -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
 
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<link rel="icon" type="icon/png" href="favicon.png">
	<title>Registra tu cuenta</title>

	<style type="text/css">
		

	</style>
</head>

<body style="/*background: #F4F4F4;*/">
<!-- <div class="body"> -->

<div onclick="home()" class="btnHome" style="background:  #793DA3; float:left; border-radius: 0px 0px 69px 67px;">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div class="logoHorizontal" style="">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
  <div class="container-fluid">
    <div class="logoMovil">
      <img class="logoWeb2" src="assets/rsc/img/webLogo.gif" style="border-radius: 63px; width: 130px; position: relative; border: indigo solid 6px;">
      <button class="navbar-toggler btnToggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    </div>
      <button class="navbar-toggler btnToggler2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-0 mb-lg-0 conteNav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<section class="sectionRegistro" style="">
 
 <div class="marcoRegistro" style="">
   <div class="conteRegistro" style="">
      <h1 class="titleR">Ingresa tu Nueva Contraseña</h1>
    <form class="formuRegistro" style="" name="cambiaClave" action="" method="POST">
      <input class="inp" type="password" name="clave" value="" required placeholder="Nueva contraseña">
      <input class="inp" type="password" name="reclave" value="" required placeholder="Confirma tu nueva contraseña">
        <button class="btnRegistro" name="cambiaClave" type="submit">Enviar</button>
      </div>
    </form>
    </p>

  </div> 
</div>

</section>





<footer class="registroFooter" style="">
  <div class="copiRight" style="color:white">

  <div style="padding: 25px; background: var(--darkm);">
    <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
  </div>

  <div style="margin: 20px;">
    <span style="margin-right:15px; color: snow;">Siguenos en:</span>
    <img style="width: 50px; margin-right: 10px" src="assets/rsc/img/facebook.svg">
    <img style="width: 50px;" src="assets/rsc/img/instagram.svg">
  </div>



</footer>
<!-- <div style="background: green; height: 250px;"></div> -->
<!-- </div> -->

	<noscript>Debes activar JavaScript</noscript>
 <!--  <script  type="text/javascript" src="assets/js/popper.min.js"></script> -->
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">


//TOOLTIPS


function goHome(){
  sessionStorage.setItem('session','true');
  window.location = "index.php";
}

function goHome2(){
  sessionStorage.setItem('session','true1');
  window.location = "index.php";
}




	</script>
	






</body>
</html>