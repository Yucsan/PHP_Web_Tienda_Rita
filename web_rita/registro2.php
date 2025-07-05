<?php

	if ($_POST) {

		 $nombre = $_POST['nombre'];
		 $correo = $_POST['correo'];
		 $clave = $_POST['clave'];
		 $reclave = $_POST['reclave'];
		 $fdn = $_POST['fdn'];
		 $sexo = $_POST['sexo'];
		 $cPostal = $_POST['codigoPostal'];
		 $pais = $_POST['pais'];
		 $provincia = $_POST['provincia'];
		 $distrito = $_POST['distrito'];
		 $direccion = $_POST['direccion'];
		 $numero = $_POST['numero'];
		 $planta = $_POST['planta'];
		 $puerta = $_POST['puerta'];
		 $escalera = $_POST['escalera'];
		 $portal = $_POST['portal'];
		
		if ((isset($correo) && !empty($correo)) && (isset($nombre) && !empty($nombre)) && (isset($clave) && !empty($clave)) && (isset($reclave) && !empty($reclave)) && (isset($fdn) && !empty($fdn))) {
			if ($clave == $reclave) {
				require 'includes/conexion.inc.php';
				$sqlExisteCorreo = "
					SELECT correo_usuario
						FROM usuario
						WHERE correo_usuario LIKE '".$correo."';
				";
				$queryExisteCorreo = mysqli_query($conectar, $sqlExisteCorreo);
				if (mysqli_num_rows($queryExisteCorreo) > 0) {
					echo "Ese correo ya está registrado. Utilice otro";
				}else{
					$sqlNuevoUsuario = "
						INSERT INTO usuario
							VALUES (null, '".$nombre."', '".$correo."', '".password_hash($clave, PASSWORD_DEFAULT)."', 'users/hombre.jpg', '".$fdn."', '', '', NOW(), '".$sexo."', 1, 0, 0, 0, 2);
					";
					$queryNuevoUsuario = mysqli_query($conectar, $sqlNuevoUsuario);
				if (!$queryNuevoUsuario) {
						echo "Ocurrió un error inesperado. Inténtelo más tarde 1";
				}else{
					 $sqlNuevaDireccion = "
					    INSERT INTO direccion
	                        VALUES (null, '".$direccion."','".$numero."','".$portal."','".$planta."','".$puerta."','".$escalera."','".$distrito."','".$provincia."','".$pais."', '".$cPostal."');
					";
					$queryNuevaDireccion = mysqli_query($conectar, $sqlNuevaDireccion);
					    
					    
					$sqlSexo = "
                        SELECT sexo_usuario
	                        FROM usuario
                             WHERE correo_usuario LIKE '".$correo."';
                    ";
                    $querySexo = mysqli_query($conectar, $sqlSexo);
                while($rowSexo = mysqli_fetch_assoc($querySexo)){ 
                   
                    if ($rowSexo['sexo_usuario'] == 'Hombre'){
                    //echo "Hombre";
                        $sqlFotoSexo ="
                            UPDATE usuario 
                                SET foto_usuario = 'users/hombre.jpg'
                                    WHERE correo_usuario LIKE '".$correo."'; 
                        ";
                        $queryFotoSexo = mysqli_query($conectar, $sqlFotoSexo);
                     
                    }elseif($rowSexo['sexo_usuario'] == 'Mujer'){
                        //echo "Mujer";
                        $sqlFotoSexo ="
                            UPDATE usuario 
                                SET foto_usuario = 'users/mujer.jpg'
                                    WHERE correo_usuario LIKE '".$correo."'; 
                        ";
                        $queryFotoSexo = mysqli_query($conectar, $sqlFotoSexo);
                    }elseif($rowSexo['sexo_usuario'] == 'Otro'){
                        //echo "Otro";
                        $sqlFotoSexo ="
                            UPDATE usuario 
                                SET foto_usuario = 'users/otro.jpg'
                                    WHERE correo_usuario LIKE '".$correo."'; 
                        ";
                        $queryFotoSexo = mysqli_query($conectar, $sqlFotoSexo);
                    }
                }
					    $sqlRecienRegistrado = "
					        SELECT id_usuario
					            FROM usuario
					            WHERE correo_usuario LIKE '".$correo."';
					    ";
					    $queryRecienRegistrado = mysqli_query($conectar, $sqlRecienRegistrado);
					    while ($rowRecienRegistrado = mysqli_fetch_assoc($queryRecienRegistrado)){
					        $ruta = "users/".$rowRecienRegistrado['id_usuario'];
					        mkdir($ruta);
					        mkdir($ruta."/archivos");
					        mkdir($ruta."/profile");
					        
					        $receptor = $correo;
					        $asunto = "Valida tu cuenta";
					        $mensaje = "Bienvenid@ a LOS CUADROS DE RITA.COM <br> Para validar tu cuenta pulsa <a href='https://loscuadrosderita.com/demo/validar.php?idUsuario=".$rowRecienRegistrado['id_usuario']."' target='blank'>aquí</a>";
					        $cabecera = "MIME-Version: 1.0" . "\r\n";
					        $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					        $cabecera .= 'From: mensajes@loscuadrosderita.com' . "\r\n" .'Reply-To: mensajes@loscuadrosderita.com' . "\r\n";
					        mail($receptor, $asunto, $mensaje, $cabecera);
					        
					        $idUsu = $rowRecienRegistrado['id_usuario'];
					       
					        $sqlIdDireccion = "
					            SELECT id_direccion
	                                FROM direccion
    	                                WHERE nombre_direccion LIKE '".$direccion."' && numero_direccion LIKE '".$numero."';
					        ";
					        
					        $queryIdDireccion = mysqli_query($conectar, $sqlIdDireccion);
                     while ($rowIdDireccion = mysqli_fetch_assoc($queryIdDireccion)){
                          $idDireccion = $rowIdDireccion['id_direccion'];
                          
                             $sqlDomicilio ="
                                 INSERT INTO domicilio
	                                 VALUES (null, '".$idUsu."', '".$idDireccion."', 'Facturación y entrega');
                             ";
                            
                             $queryDomicilio = mysqli_query($conectar, $sqlDomicilio);
                                
                  }
                             
					    }
						echo "Usuario registrado correctamente. Revise su correo electrónico.";
					}
				}
			}else{
				echo "Las contraseñas no coinciden";
			}
		}else {
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
 <form class="buscaNav">
        <input class="inputCustom me-2" type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-dark btnCustom" type="submit">Buscar</button>
 </form>


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
          <a class="nav-link" aria-current="page" href="#">Sobre Mi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Cuadros</a>
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
          <a class="nav-link active">Registro</a>
        </li>

<!--         <li class="nav-item">
          <a class="nav-link" href="#">Iniciar Session </a>
        </li> -->

      </ul>

    </div>
            <form class="buscaNav2">
          <input class="inputCustom2 me-2" type="search" placeholder="buscar" aria-label="Search">
          <button class="btn btn-dark btnCustom" type="submit">buscar</button>
        </form>
  </div>
</nav>


<section class="sectionRegistro rCompra" style="">
 
 <div class="marcoRegistro" style="">
   <div class="conteRegistro" style="">
      <h1 class="titleR">Registro</h1>
    <form class="formuRegistro" style="" name="registro" action="" method="POST">
      <input class="inp" type="text" name="nombre" value="" required placeholder="Nombre*">
      <input class="inp" type="email" name="correo" value="" required placeholder="Correo Electrónico*">
      <input class="inp" type="password" name="clave" value="" required placeholder="Contraseña*">
      
      <input class="inp" type="password" name="reclave" value="" required placeholder="Repite Contraseña*">
        
      <div class="dateWrapper2" style="">
        <div class="inputDateCustom" style="">
          <input class="dateInpCompra teset" type="date" name="fdn" value="" style="" required><br>
          <span style="color: snow; line-height: 18px;">Fecha de Nacimiento*</span>
        </div>

        <select class="form-select selectSexo2" name="sexo">
            <option value="">-- Sexo</option>
            <option value="Mujer">Mujer</option>
            <option value="Hombre">Hombre</option>
            <option value="Otro">Otro</option>
        </select>

      </div>

<!--       <div class="btnWrapper" style=" ">

        
      </div> -->

      <div class="inpDire" style="">
        <input class="inp2 cl576" type="text" name="codigoPostal" value="" required placeholder="Codigo Postal*">
        <input class="inp2" type="text" name="pais" value="" required placeholder="pais*">
      </div>
      

      <div class="inpDire" style="">
        <input class="inp2 cl576" type="text" name="provincia" value="" required placeholder="provincia*">
        <input class="inp2" type="text" name="distrito" value="" required placeholder="distrito*">
      </div>

       <input class="inp" type="text" name="direccion" value="" required placeholder="direccion*">

      <div class="inpDire2 dire2Custom" style="">
        <input class="inp2 smallInp" type="number" name="numero" value="" required placeholder="numero*">
        <input class="inp2 smallInp" type="number" name="planta" value="" required placeholder="planta*">
      </div>

      <div class="wrappInput3" style="">
        <input class="inp3" type="text" name="puerta" value="" required placeholder="puerta*">
        <input class="inp3" type="text" name="escalera" value="" placeholder="escalera">
        <input class="inp3" type="text" name="portal" value="" placeholder="portal">
      </div>

      <button class="btnRegistro" type="submit">Regístrame</button>
    </form>

    <p class="enlaceFinalDESKTOP" style="">Ya tengo cuenta. <span onclick="goHome()" style="color: purple; cursor: pointer">Iniciar Sesión</span></p>

    <!-- ENLACE PARA MOVILES, DESPLIEGA EL MENU Y ABRE EL LOGIN -->
    <p class="enlaceFinal" style="">Ya tengo cuenta. <span onclick="goHome2()" style="color: purple; cursor: pointer">Iniciar Sesión</span>
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

	<noscript>Debes activar JavaScript</noscript>
 <!--  <script  type="text/javascript" src="assets/js/popper.min.js"></script> -->
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">

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
