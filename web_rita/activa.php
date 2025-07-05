<?php

    $mensajeMail="";
	if ($_POST) {
	
		$correo = $_POST['correo'];
    $mensajeMail="";
		
		if ((isset($correo) && !empty($correo))) {
		
				require 'includes/conexion.inc.php';
				$sqlExisteCorreo = "
					SELECT id_usuario
						FROM usuario
						WHERE correo_usuario LIKE '".$correo."';
				";
				$queryExisteCorreo = mysqli_query($conectar, $sqlExisteCorreo);
				if (mysqli_num_rows($queryExisteCorreo) == null) {
					echo "Ese correo no está registrado. Registrate por favor";
					 mysqli_close($conectar);
				}else{
				    
				        $idUser ="";
				        while($rowExisteCorreo = mysqli_fetch_assoc($queryExisteCorreo)){
				            $idUser = $rowExisteCorreo['id_usuario'];
				        } 

					   $receptor = $correo;
					   $asunto = "Re-Activar Cuenta Los Cuadros de Rita";             
					   $mensaje = "Para reactivar tu cuenta  pulsa <a href='https://loscuadrosderita.com/demo/activate.php?id=".$idUser."' target='blank'>aquí</a>";
					   $cabecera = "MIME-Version: 1.0" . "\r\n";
					   $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					   $cabecera .= 'From: mensajes@loscuadrosderita.com' . "\r\n" .'Reply-To: mensajes@loscuadrosderita.com' . "\r\n";
					   mail($receptor, $asunto, $mensaje, $cabecera);	
					   
				        
				         mysqli_close($conectar);
                 header('Location: index.php?reactivame=yes');
                 //echo "<script>alert('Revisa tu correo')<script>";
					  }
				 
					  
					
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

<body class="bodyRecupera" style="">

<div onclick="home()" class="btnHome" style="">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div onclick="home()" class="logoHorizontal" style="">
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
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php#sobreMi">Sobre Mi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="prod.php?pag=1">Cuadros</a>
        </li>
        <li class="nav-item btnIniNavDesktop">
          <a class="nav-link" href="#" onclick="goHome()">
            Iniciar Sesión <i class="far fa-user"></i>
          </a>
        </li>
        <!-- PARA MOVILES -->
        <li class="nav-item btnIniNavMoviles">
          <a class="nav-link" href="#" onclick="goHome2()">
            Iniciar Sesión <i class="far fa-user"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="recupera.php">Recuperar Contraseña</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active">Re-Activa Cuenta</a>
        </li>

<!--         <li class="nav-item">
          <a class="nav-link" href="#">Iniciar Session </a>
        </li> -->

      </ul>

    </div>
  </div>
</nav>


<section class="sectionRecupera" style="">
 
 <div class="marcoRecupera" style="">
   <div class="conteRegistro" style="">
      <h1 class="titleR">Re-Activa Cuenta</h1>
    <form class="formuRegistro" style="" name="recupera" action="" method="POST">
      <input class="inp" type="email" name="correo" value="" required placeholder="Correo Electrónico">
        <button class="btnRegistro" type="submit">Enviar</button>
        <div><?php echo  $mensajeMail; ?></div>
      </div>
    </form>
  </div> 
</div>

</section>





<footer class="footerRecupera" style="">
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


function home(){
  window.location = "index.php";
}

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