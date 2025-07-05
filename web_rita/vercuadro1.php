<?php

  require 'includes/conexion.inc.php';

	if ($_GET){
    if ((isset($_GET['ident']) && !empty($_GET['ident'])) && (isset($_GET['pag']) && !empty($_GET['pag']))){

      $idCuadro = $_GET['ident'];
      $volver = $_GET['pag'];

      $sqlProducto ="

        SELECT *
          FROM producto
          WHERE id_producto LIKE '".$idCuadro."';

      ";  
      $queryProducto = mysqli_query($conectar,  $sqlProducto);

    }else{
      header("Location: prod.php?pag=1");
    }
    


  }else{
    header("Location: prod.php?pag=1");
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

<body style="background: #F4F4F4;"  >
  <div class="body">

    <div onclick="home()" class="btnHome" style="">
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
            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php#sobreMi">Sobre Mi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="prod.php?pag=1">Cuadros</a>
          </li>
          <!-- DESKTOP -->
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
          </li>
          <li class="nav-item">
            <a class="nav-link" href="registro1.php">Registro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="recupera.php">Recuperar Contraseña</a>
          </li>
          
        </ul>
        
      </div>
      <form action="prod.php?pag=1" method="POST" class="buscaNav2">
        <input name="buscar" class="inputCustom2 me-2" type="search" placeholder="buscar" aria-label="Search">
        <button class="btn btn-dark btnCustom" type="submit">buscar</button>
      </form>
    </div>
  </nav>

  <!-- Barra Usuario -->
  <div class="barraUsuario" style="">

    <ul class="ulUsuarioIndex" style="">
      <li class="nombreUser" style="">
       Sin Usuario
       <img src="assets/rsc/img/sinregistro.jpg" class="fotoUserIndex" style="">
     </li>
   </ul>

 </div>

 <style type="text/css">



 </style>

 <section  style="display: flex; justify-content: center; background: none;" >

  <div class="contenedorCuadros" style="">
  <a href="prod.php?pag=<?php echo $volver;?>" class="botonVolver1"><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;Volver</a>

  <?php
    while ($rowProd = mysqli_fetch_assoc($queryProducto)){    
  
  ?>  

    <section class="sect1">
      <img class="showImg" style="" src="<?php echo $rowProd['foto_producto']; ?>"> 
    </section>
    
    <section class="sect2" style="">
 
    <div>Nombre Cuadro:
       <div style="color: purple; font-size: 1.5rem;"><?php echo $rowProd['nombre_producto'];  ?></div>  
    </div>

    <div>Medidas:
      <span style="color: gray; font-size: 1rem;"><?php echo $rowProd['medida_producto']; ?></span>  
    </div>

    <div>Stock:
      <span style="color: gray; font-size: 1rem;"><?php echo $rowProd['stock_producto']; ?></span>  
    </div>

    <div>Leyenda:
      <div style="color: gray; font-size: 1rem;"><?php echo $rowProd['info_producto']; ?><div>  
    </div>

    <div>Precio:
       <span style="color: black; font-size: 1.5rem;">S/.&nbsp;<?php echo $rowProd['precio_producto']; ?></span>  
    </div>

 <?php
    }
  ?>

  <style type="text/css">



      


  </style>

    <div class="contAvisoVer">
      <div class="avisoRegistro" style="">
        Te invitamos a registrarte para poder Escribirnos, comprar y demas privilegios de la página, no hay publicidad en la página ni compartimos los datos con otra web
      </div>
        <a class="enviaRegistro" style="" href="registro1.php">Registrarme</a>

    </div>

<!--      <form id="fConsulta" action="" method="POST" name="formuConsulta" style="">
      <label>Comentario ó Consulta</label>
      <textarea id="textoComent" name="consulta"  style="border-radius: 10px; border: none; background: #e1d9e6; color: purple; resize: none;"></textarea>
      <button id="botonComentarios" >Enviar comentario</button>
    </form>

    <style type="text/css">


    </style>


    <button class="botonCompra">
      <i style="color: snow;" class="fas fa-shopping-cart carritoCarta"></i>
      <span>Añadir al carrito</span>
    </button> -->
  </section>
  
  
</div>

</section>





<?php
mysqli_close($conectar);
?>

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

//sessionStorage.clear(); 

    //drop menu
    var ses = document.querySelector('.dropdown-menu');

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



    function redi(){
        console.log('redirecciona');
        //window.location = 'https://www.w3schools.com';
        //window.open("https://www.w3schools.com"); 
    }

    //  swiper
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 0,
      centeredSlides: true,
      /*
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },*/
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