<?php

	if (isset($_COOKIE['idUsuario'])) {
		require 'includes/conexion.inc.php';
		$sqlLogin = "
			SELECT *
				FROM usuario
					JOIN rol USING (id_rol)
				WHERE id_usuario LIKE ".$_COOKIE['idUsuario'].";
		";
		$queryLogin = mysqli_query($conectar, $sqlLogin);
		while ($rowLogin = mysqli_fetch_assoc($queryLogin)) {
			session_start();
			$_SESSION['idUsu'] = $rowLogin['id_usuario'];
			$_SESSION['nombreUsu'] = $rowLogin['nombre_usuario'];
			$_SESSION['correoUsu'] = $rowLogin['correo_usuario'];
			$_SESSION['estadoUsu'] = $rowLogin['estado_usuario'];
			$_SESSION['fdnUsu'] = $rowLogin['fdn_usuario'];
			$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
			$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
			header('Location: main.php');
		}
	}

	if ($_POST) {

		// Comprobamos que lleguen bien los Datos
		if ((isset($_POST['correo']) && !empty($_POST['correo'])) && (isset($_POST['clave']) && !empty($_POST['clave']))) {
			$correo = $_POST['correo'];
			// Conectamos con la Base de Datos
			require 'includes/conexion.inc.php';
			$sqlLogin = "
				SELECT *
					FROM usuario
						JOIN rol USING (id_rol)
					WHERE correo_usuario LIKE '".$correo."';
			";
			$queryLogin = mysqli_query($conectar, $sqlLogin);
			
			if (mysqli_num_rows($queryLogin) < 1) {
			    
				include 'error.html';
				
			}else{
				$clave = $_POST['clave'];
				while ($rowLogin = mysqli_fetch_assoc($queryLogin)) {
					if (password_verify($clave, $rowLogin['clave_usuario'])) {
						if ($rowLogin['validado_usuario'] == 1) {
							if ($rowLogin['activo_usuario'] == 1) {
								session_start();
								$_SESSION['idUsu'] = $rowLogin['id_usuario'];
								$_SESSION['nombreUsu'] = $rowLogin['nombre_usuario'];
								$_SESSION['correoUsu'] = $rowLogin['correo_usuario'];
								$_SESSION['estadoUsu'] = $rowLogin['estado_usuario'];
								$_SESSION['fdnUsu'] = $rowLogin['fdn_usuario'];
								$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
								$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
								if (isset($_POST['recordar'])) {
									setcookie("idUsuario", $_SESSION['idUsu'], time()+63072000);
								}
								header('Location: main.php');
							}else{
								echo "Tu cuenta está desactivada. Por favor, reactívala";
							}
						}else{
							echo "Debes validar tu cuenta para poder acceder.";
						}

					}else{
						echo "Usuario y/o Contraseña incorrectos2";
					}
				}
			}
		}else{
			echo "Debes rellenar todos los campos";
		}
		
	}

  if ($_GET){
    if (isset($_GET['validado'])){
        echo "Gracias por validar tu cuenta. Disfruta de nuestra Web.";

    }else if(isset($_GET['clave']) && !empty($_GET['clave'])){
        echo "<script>alert('Recuperacion de Clave Existoso')</script>";

    }else if(isset($_GET['desactivo']) && !empty($_GET['desactivo'])){

        echo "<script>alert('Cuenta Desactivada')</script>";
    }else if(isset($_GET['reactivame']) && !empty($_GET['reactivame'])){

        echo "<script>alert('Reviza tu correo para activar tu cuenta')</script>";

    }else if(isset($_GET['usuactivo']) && !empty($_GET['usuactivo'])){

      echo "<script>alert('Cuenta Reactivada con Exito')</script>";
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
	<meta name="description" content="e-commerce de Arte de la artista Rita Cam, cuadros con técnica faux vitro o falso vitral de estilo Naif">
	<meta name="keywords" content="Arte, vitral, acrílico, naif, decoración, faux vitro">
	<meta name="robots" content="NoIndex, NoFollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/sweealert2/css/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="icon" type="icon/png" href="favicon.png">
    <title>Los Cuadros de Rita</title>
    <style type="text/css">

    </style>
    </head>

<body onscroll="alto()" onload="start()" style="background: #F4F4F4;"  >
  <div id="starter" class="body">

    <div class="btnHomeIndex" style="">
      <img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
    </div>

    <div class="logoHorizontal" style="">
      <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
        
     <form action="prod.php?pag=1" method="POST" class="buscaNav">
      <input name="buscar" class="inputCustom me-2" type="search" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-dark btnCustom" type="submit">Buscar</button>
    </form>

      <div class="container-fluid">
        <div class="logoMovil">
          <img class="logoWeb2" src="assets/rsc/img/webLogo.gif" style="border-radius: 63px; width: 130px; position: relative; border: indigo solid 6px;">
  
          <button class="navbar-toggler btnToggler modi" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label=" Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
  
        <button class="navbar-toggler btnToggler2 modi1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label=" Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
          <ul class="navbar-nav me-auto mb-0 mb-lg-0 conteNav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#sobreMi">Sobre Mi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="prod.php?pag=1">Cuadros</a>
            </li>
  
            <li class="nav-item dropdown dropCustom">
              <div class="nav-link dropdown-toggle"   onclick="despliega()"  role="button">
                Iniciar Sesión <i class="far fa-user"></i>
              </div>
              <ul class="dropdown-menu"  aria-labelledby="navbarDropdown">
                <form class="formuIniciar" name="login" action="" method="POST">
                  <li class=""><input class="inputDrop" type="email" name="correo" value="" placeholder="Correo Electrónico" required></li> 
                  <li class=""><input class="inputDrop" type="password" name="clave" value="" placeholder="Contraseña" required></li>
                  <li class=""><input type="checkbox" name="recordar" value="si" id="recordar"> <label for="recordar">Recuérdame</label></li>
                  <hr class="dropdown-divider">
                  <li class=""><button class="btnInicio" style="" type="submit" name="iniciar">Acceder</button></li>
                </form>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="registro1.php">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="recupera.php">Recuperar Contraseña</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="activa.php">Re-Activa Cuenta</a>
            </li>
          </ul>
  
        </div>
<!--         <form action="prod.php?pag=1" method="POST" class="buscaNav2">
          <input name="buscar" class="inputCustom2 me-2" type="search" placeholder="buscar" aria-label="Search">
          <button class="btn btn-dark btnCustom" type="submit">buscar</button>
        </form> -->
      </div>
    </nav>

    <div class="buscaNuevo" style="">
  <form method ="POST" class="DesktopBusca" action="prod.php?pag=1">
          <input name = "buscar" class="inputCustom2 me-2" type="search" placeholder="buscar" aria-label="Search">
          <button class="btn btn-dark btnCustom" type="submit">buscar</button>
  </form>
</div>

<!-- Barra Usuario -->
<div class="barraUsuario" style="">

  <ul class="ulUsuarioIndex" style="">
    <li class="nombreUser" style="">
     Sin Usuario
     <img src="assets/rsc/img/sinregistro.jpg" class="fotoUserIndex" style="">
    </li>
  </ul>

</div>

<?php $mensaje="";?>
<div style="color: #f30b0b; text-align:center; font-size: 30px;"><?php echo $mensaje ?></div>

<!-- CARROUSEL-->
<div class="container-fluid sliderTop2" style="">
  <div class="row">
    <div class="col-md-12 col-lg-1 R1 px-0" style="background:rgba(200,220,220,0.3);"></div>
    <div class="col-md-12 col-lg-10 px-0" style="">
      <div class="swiper-container" style="top:0px;">
       <div class="swiper-wrapper">
         <?php 
          require 'includes/conexion.inc.php';
          
            $sqlProduSlider ="
                SELECT * 
                    FROM producto
    	            WHERE slider_producto > 0
                        ORDER BY slider_producto ASC;
            ";
            $queryProduSlider = mysqli_query($conectar, $sqlProduSlider);
            while ($rowqueryProduSlider = mysqli_fetch_assoc($queryProduSlider)){
         ?>  
         <div class="swiper-slide a1">
          <div class="textoSlide1">
            <h3 class="tituloSlide1">
              <div class="tituloSlide" style=""><?php echo $rowqueryProduSlider['promotxt_producto']; ?></div>
              <div class="txtSlide"><?php echo $rowqueryProduSlider['txtconte_producto']; ?></div>
            </h3>
            <a class="btnSlide1" href="vercuadro1.php?ident=<?php echo $rowqueryProduSlider['id_producto']; ?>&pag=1">ver cuadro</a>
          </div>
          <div class="fotoSlide1">              
            <img class="imgSlide1" style="border: solid 10px #EDBC41;" src="<?php echo $rowqueryProduSlider['foto_producto']; ?>">
          </div>
        </div>

        <?php 
            }
        ?>
        
      </div>
      <div class="swiper-pagination"></div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>

  </div>
  <div class="col-md-12 col-lg-1 R1" style="background:rgba(200,220,220,0.3);"></div>
</div>
</div>  

<!-- -->

 
<section class="container-fluid sectionMain" style="">

  <div class="row">
    <div class="col-md-12 col-lg-1 R1"></div>
    <div class="col-md-12 col-lg-10 R2 novedad" style="">
        
       <?php 
            $sqlContenido ="
                SELECT * 
	                FROM contenido
    	                WHERE id_contenido LIKE 1;
            ";
            $queryContenido = mysqli_query($conectar, $sqlContenido);
            while ($rowqueryContenido = mysqli_fetch_assoc($queryContenido)){

          ?>
        
      <div class="expo" style=""><img class="imgExpo" src="<?php echo $rowqueryContenido['foto_contenido']; ?>"></div>

      <div id="sobreMi" class="bd-example txtExpo" style="">
 
        <div class="indexBio" style ="background: none; padding: 15px;">  
            <div class="tituloBio" style="font-family: 'patrick'; font-size:33px; color: var(--morado);"><?php echo $rowqueryContenido['titulo_contenido']; ?></div>
            <div style="font-family: 'muli'; font-size:20px; color: var(--morado);"><?php echo $rowqueryContenido['soporte_contenido']; ?></div>
        </div> 
        
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link fenlace active botonesNov" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Biografia</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link fenlace" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Poema</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
            <p class="textoNovedad" style=""><?php echo $rowqueryContenido['bio_contenido']; ?></p>
            <!--<a href="#">Seguir leyendo</a>-->
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="textoNovedad" style=""><?php echo $rowqueryContenido['poema_contenido']; ?></p>
          </div>
          <?php 
          
            }
          ?>
          
          
        </div>
      </div>
    </div>

    <div class="col-md-12 col-lg-1 R3"></div>
  </div>

</section>

<!-- SECCION CON PRODUCCTOS -->
<script>
    var conteEstados = []; 
    var orden =[];
</script>

<div class="container-fluid productos swiperMain">

	<div class="row objRow">
		<div class="col-md-12 col-lg-1 R1"></div>
		<div class="col-md-12 col-lg-10 bloqueProductos">

			<?php 
			$sqlProductos ="
			SELECT * 
            FROM producto
            WHERE id_producto >= 14 AND id_producto <= 15;
			";
			$queryProductos = mysqli_query($conectar, $sqlProductos);
			
			$contador = 1;
			$conte = 0;
			while ($rowqueryProductos = mysqli_fetch_assoc($queryProductos)){
				
				$idProducto = $rowqueryProductos['id_producto'];
				?> 

				<!-- CARTA -->
				<div class="card cuadro1" style="">
					<img src="<?php echo $rowqueryProductos['foto_producto']?>" style="border: solid 10px #EDBC41" class="card-img-top" alt="cuadro">
					<div class="card-body" style="display: flex; justify-content: end; flex-direction: column;">
						<h5 class="card-title" style="color: var(--morado);"><?php echo $rowqueryProductos['nombre_producto']?></h5>
					</div>
				</div>

				<?php 

				$contador++; $conte++;
			}
			?> 



			<?php 

			$sqlProductos ="
			
			SELECT * 
            FROM producto
            WHERE id_producto >= 27 AND id_producto <= 28;
		
			";
			$queryProductos = mysqli_query($conectar, $sqlProductos);
			
			$contador = 1;
			$conte = 0;
			while ($rowqueryProductos = mysqli_fetch_assoc($queryProductos)){
				
				$idProducto = $rowqueryProductos['id_producto'];
				?> 

				<!-- CARTA -->

				<div class="card cuadro1" style="">
					<img src="<?php echo $rowqueryProductos['foto_producto']?>" style="border: solid 10px #EDBC41" class="card-img-top" alt="cuadro">
					<div class="card-body" style="display: flex; justify-content: end; flex-direction: column;">					
						<h5 class="card-title" style="color: var(--morado);"><?php echo $rowqueryProductos['nombre_producto']?></h5>
					</div>
				</div>

				<?php 

				$contador++; $conte++;
			}
			?> 
		</div>
		
	<ul class="btnProductosbottom" style="">
        <li style="padding: 20px;">
           <a href="prod.php?pag=1" style="text-decoration: none; background: var(--morado); padding: 10px; border-radius: 6px; color: snow;">VER TODOS LOS CUADROS</a>  
        </li>    
    </ul> 

		<div class="col-md-12 col-lg-1 R3"></div>
	</div>
</div>


<?php
    mysqli_close($conectar);
?>
<!-- BTN FLECHA -->
<div style="position: relative;background: lightblue; position: relative; width: 100%; bottom: 90px;">
  <a id="arriba" href="#starter" style="position: fixed; right: 17px; top: 65%; z-index: 100; font-size: 40px; color: purple; display: none;"><i class="fas fa-arrow-up"></i></a>
</div>

<footer>
  <div class="copiRight" style="color:white">

    <div style="padding: 25px; background: var(--darkm);">
      <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
    </div>

    <div style="margin: 20px;">
      <span style="margin-right:15px; color: snow;">Siguenos en:</span>
      <a href="https://www.facebook.com/LosCuadrosDeRita"><img style="width: 50px; margin-right: 10px" src="assets/rsc/img/facebook.svg"></a>
      <a href="https://www.instagram.com/loscuadrosderita"><img style="width: 50px;" src="assets/rsc/img/instagram.svg"></a>
    </div>

  </footer>

</div>

	<noscript>Debes activar JavaScript</noscript>
 <!--  <script  type="text/javascript" src="assets/js/popper.min.js"></script> -->
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/vendor/sweealert2/js/sweetalert2.min.js"></script>
	<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">

// SCRIPT BTN FLECHA
function alto(){
  let medida = window.pageYOffset;
  if (medida > 333){
    document.querySelector('#arriba').style.display = 'block';
  }else{
    document.querySelector('#arriba').style.display = 'none';
  }
  //console.log(medida);
}

    //drop menu
    var ses = document.querySelector('.dropdown-menu');

    function start(){

        importado = sessionStorage.getItem("session");
        //console.log(importado);
        
        if (importado == 'true'){

        ses.style.display = 'block';
        iniEstado = true;

        sessionStorage.removeItem('session');

        }else if(importado == 'true1'){
        ses.style.display = 'block';
  
        //BOOSTRAP DESPLIEGA MENU  
        var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
        var collapseList = collapseElementList.map(function (collapseEl) {
          return new bootstrap.Collapse(collapseEl)
    })

        iniEstado = true;

        sessionStorage.removeItem('session');
        }
        
    }

//sessionStorage.clear(); 


	//DESPLIEGA INICAR SESSION 

    var iniEstado = false;
    function despliega(){
        console.log('pres1');
        
            if (iniEstado == false){
            ses.style.display = 'block';
            iniEstado = true;
  
            }else if(iniEstado == true){
                console.log('pres2');
                ses.style.display = 'none';
                iniEstado = false;

            }

    }


    function redi(){
        console.log('redirecciona');
        //window.location = 'https://www.w3schools.com';
        //window.open("https://www.w3schools.com"); 
    }

    //  swiper
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 0,
      speed: 300,
      loop: true,
      centeredSlides: true,
      /*
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      */ 
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });







	</script>
	






</body>
</html>