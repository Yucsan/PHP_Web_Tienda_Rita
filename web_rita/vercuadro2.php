<?php

session_start();

  if (!isset($_SESSION['idUsu'])) {
    header('Location: index.php');
  }

    require 'includes/conexion.inc.php';

    $id = $_SESSION['idUsu'];
    $nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];

    $opcion = false;

	 if ($_GET){
      // si en el GET llega 0 es como que esta vacio...
      if ((isset($_GET['ident']) && !empty($_GET['ident'])) && (isset($_GET['pag']) && !empty($_GET['pag']))) {

        /*
        $conte = $_GET['conte'];

        if($conte == 0){
          //echo "entra";
          $conte = 'cero';
        }*/

        $idCuadro = $_GET['ident'];
        $volver = $_GET['pag'];
        //INFORMACION CARACTERISTICAS DEL CUADRO
        $sqlProducto ="
          SELECT *
            FROM producto
            WHERE id_producto LIKE '".$idCuadro."';
        ";  
        $queryProducto = mysqli_query($conectar,  $sqlProducto);

         //INFORMACION SOBRE CONSULTAS

         // SQL RECOGE DATOS PARA PINTAR CONVERSACION
        $pregunta = "";
        $respuesta = "";

        $sqlUsuCons1 ="
          SELECT mensaje_consulta, respuesta_consulta
            FROM consulta   
              WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$idCuadro."';
        ";
        $queryUsuCons1 = mysqli_query($conectar, $sqlUsuCons1);

        while($rowCharla = mysqli_fetch_assoc($queryUsuCons1)){
          $pregunta = $rowCharla['mensaje_consulta'];
          $respuesta = $rowCharla['respuesta_consulta'];;
        }




      }else{
        header("Location: productos.php?pag=1");
      }
    }else{
      header("Location: productos.php?pag=1");
    }
    
   //RESCATA INFO SOBRE PEDIDOS
    $idpedidos = array();
    $ultimoPedido = "";
    $sqlEstadoPedido = "
        SELECT *
          FROM usuario
              JOIN domicilio USING (id_usuario)
                JOIN pedido USING (id_domicilio)
                JOIN compra USING (id_pedido)
                JOIN producto USING (id_producto)
                WHERE id_usuario LIKE '".$id."';
    ";
    $queryEstadoPedido = mysqli_query($conectar, $sqlEstadoPedido);
    while ($rowqueryPedido = mysqli_fetch_assoc($queryEstadoPedido)){
        
       $idpedidos[$rowqueryPedido['id_pedido']] = $rowqueryPedido['estado_pedido'];
    }

    if($_POST){

      if((isset($_POST['consulta']) && !empty($_POST['consulta'])) && (isset($_POST['idProducto']) && !empty($_POST['idProducto']))){

        $consulta = $_POST['consulta'];
        $idProd = $_POST['idProducto'];
        $horaCons = $_POST['hora'];
        $fechaCons = $_POST['fecha'];

        // SQL RECOGE DATOS
        $sqlUsuCons ="
          SELECT id_consulta
            FROM consulta   
              WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$idProd."';
        ";
        $queryUsuCons = mysqli_query($conectar, $sqlUsuCons);

        // DATOS EN VARIABLE LOCAL
        $box = "";
          while ($rowUsuCons = mysqli_fetch_assoc($queryUsuCons)) {
            $box = $rowUsuCons['id_consulta'];
          }
          
          // VEMOS SI YA TIENE GENERADO CONSULTAS SOBRE ESTE CUADRO, SI YA SE ACTUA;IZA SI NO SE INSERTA ...
          if ($box == null){
            //echo "No hay consulta"; 

            $sqlInsCons ="
              INSERT INTO consulta
                VALUES(null, '".$id."','".$idProd."','".$consulta."','Sin leer', 0,'".$fechaCons."','".$horaCons."','Sin Responder');
            ";
            $queryInsCons = mysqli_query($conectar, $sqlInsCons);



              $pregunta = "";
              $respuesta = "";

                $sqlUsuCons1 ="
                  SELECT mensaje_consulta, respuesta_consulta
                    FROM consulta   
                      WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$idCuadro."';
                ";
                $queryUsuCons1 = mysqli_query($conectar, $sqlUsuCons1);
        
                while($rowCharla = mysqli_fetch_assoc($queryUsuCons1)){
                  $pregunta = $rowCharla['mensaje_consulta'];
                  $respuesta = $rowCharla['respuesta_consulta'];;
                }

                $sqlProducto ="
                  SELECT *
                    FROM producto
                    WHERE id_producto LIKE '".$idCuadro."';
                ";  
                $queryProducto = mysqli_query($conectar,  $sqlProducto);

          }else{

            $sqlActualizaCons ="
              UPDATE consulta
                SET mensaje_consulta = '".$consulta."',
                    fecha_consulta = '".$fechaCons."',
                    hora_consulta = '".$horaCons."',
                    respuesta_consulta = 'Sin leer',
                    estado_consulta = 'Sin Leer'
                    WHERE id_consulta LIKE '".$box."';
            ";
            $queryActualizaCons = mysqli_query($conectar, $sqlActualizaCons);

            $pregunta = "";
              $respuesta = "";

                $sqlUsuCons1 ="
                  SELECT mensaje_consulta, respuesta_consulta
                    FROM consulta   
                      WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$idCuadro."';
                ";
                $queryUsuCons1 = mysqli_query($conectar, $sqlUsuCons1);
        
                while($rowCharla = mysqli_fetch_assoc($queryUsuCons1)){
                  $pregunta = $rowCharla['mensaje_consulta'];
                  $respuesta = $rowCharla['respuesta_consulta'];;
                }

                $sqlProducto ="
                  SELECT *
                    FROM producto
                    WHERE id_producto LIKE '".$idCuadro."';
                ";  
                $queryProducto = mysqli_query($conectar,  $sqlProducto);

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

    <div onclick="home();" class="btnHome" style="">
      <img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
    </div>

    <div onclick="home();" class="logoHorizontal" style="">
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
            <a class="nav-link active" aria-current="page" href="main.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="main.php#sobreMi">Sobre Mi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos.php?pag=1">Cuadros</a>
          </li>
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

  <ul class="ulUsuario" style="">
    <li id="persona" class="nombreUser" style="margin-right: 20px;">
      <?php echo $nombre; ?>
     <img src="<?php echo $fotito; ?>" class="fotoUser" style="">
    </li>
    <li class="cerrarS">
      <a href="cerrar.php" class="txtCerrar" style="text-decoration:none;">Cerrar Sesión</a>
    </li>
    <li class="cerrarS">
      <a href="editarPerfil.php" class="txtCerrar" style="text-decoration:none;">Editar Perfil</a>
    </li>
    <li class="cerrarS not">
      <a href="" class="nav-link saveBuy" id="blinkPedido" href="#" style="color: fuchsia; display: none;">Pedido Guardado</a>
    </li>
    <li class="cerrarS not2">
      <a class="nav-link saveBuy" id="msn" href="mensajes.php" style="color: fuchsia; display: none;">Mensajes</a>
    </li>
  </ul>
</div>

<?php 
    //LLAMA AL BTN PEDIDO SI HAY PEDIDO
    $hayPedido= "";
    if ($idpedidos){
       $ultimoPedido = max(array_keys( $idpedidos ));
           
        if ($idpedidos[$ultimoPedido] == "guardado"){
            //echo "Tienes un pedido guardado";
            echo "<script>document.querySelector('#blinkPedido').style.display = 'block';
            document.querySelector('.not').style.display = 'block';
            document.querySelector('#blinkPedido').href = 'pedidosave.php?pedido=".$ultimoPedido."';
            </script>";

            $hayPedido = "true";
        }
    }

    $RescueMsn = "";
      //RESCATAMOS MENSAJES
        $sqlMsn = "
          SELECT mensaje_consulta
            FROM consulta
            WHERE id_usuario LIKE '".$id."' AND mensaje_consulta <> '';  
        ";
        $queryMsn = mysqli_query($conectar, $sqlMsn);
        while ($rowMsn = mysqli_fetch_assoc($queryMsn)){
          $RescueMsn = $rowMsn;
        }

        if($RescueMsn == null){
          //echo "no Hay mesajes";
        }else{
          //echo "Hay mesajes PINTAR BOTON";
          echo "<script>document.querySelector('#msn').style.display = 'block';
          document.querySelector('.not2').style.display = 'block';
          </script>";
        }


?>

 <section  style="display: flex; justify-content: center; background: none; margin-top: 30px;" >

  <div class="contenedorCuadros" style="">
  <a href="productos.php?pag=<?php echo $volver;?>" class="botonVolver1"><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;Volver</a >

  <?php

   
      while ($rowProd = mysqli_fetch_assoc($queryProducto)){     
  
  ?>  
    <section class="sect1">
      <img class="showImg" style="" src="<?php echo $rowProd['foto_producto']; ?>"> 
    </section>
    
    <section class="sect2" style="">
 
    <div>Nombre Cuadro:
       <span style="color: purple; font-size: 1.5rem;"><?php echo $rowProd['nombre_producto'];  ?></span>  
    </div>

    <div>Medidas:
      <span style="color: gray; font-size: 1rem;"><?php echo $rowProd['medida_producto']; ?></span>  
    </div>

    <div>Stock:
      <span style="color: gray; font-size: 1rem;"><?php echo $rowProd['stock_producto']; ?></span>  
    </div>

    <div>Leyenda:
      <span style="color: gray; font-size: 1rem;"><?php echo $rowProd['info_producto']; ?><span>  
    </div>

    <div>Precio:
       <span style="color: black; font-size: 1.5rem;"><?php echo $rowProd['precio_producto']; ?></span>  
    </div>


     <form id="fConsulta" action="" method="POST" name="formuConsulta" style="">
      <div style="color:gray"><?php echo $nombre;?>&nbsp;:</div>
      <div style="color: #1710ea; font-size: 20px; margin-bottom: 5px;"><?php echo $pregunta;?></div>

      <div style="color:#f923eb">Rita :</div>
      <div style="color: #2aca14; font-size: 20px; margin-bottom: 5px;"><?php echo $respuesta;?></div>

      <label>Comentario ó Consulta</label>
      <textarea id="textoComent" name="consulta"  style="border-radius: 10px; border: none; background: #e1d9e6; color: purple; resize: none;"></textarea>
      <input type="hidden" name="idProducto" value="<?php echo $rowProd['id_producto']; ?>">
      <input id="horaCons" type="hidden" name="hora" value="">
      <input id="fechaCons" type="hidden" name="fecha" value="">
      <div class="botoneraVer" style="">
        <button id="botonComentarios" >Enviar comentario</button>
        <div class="botonCompra" onmouseenter="btnAc1();" onmouseleave="btnAc2();"  >
          <i style="" class="fas fa-shopping-cart carritoCartaVer"></i>
          <a class="verAgrega" href="productos.php?pag=<?php echo $volver; ?>&agrega=<?php echo $rowProd['id_producto'];?>">Añadir al carrito</a>
        </div>
      </div>
    </form>
<!-- Seguir desarrollando para la 2da version -->
    
      
   
 <?php
     
   }
   ?>

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


//ONMOUSE ENTER BOTON AGREGA DE VER
function btnAc1(){
document.querySelector('.carritoCartaVer').style.color = "darkorange";
document.querySelector('.verAgrega').style.color = "darkorange";
}

//ONMOUSE LEAVE BOTON AGREGA DE VER
function btnAc2(){
document.querySelector('.carritoCartaVer').style.color = "snow";
document.querySelector('.verAgrega').style.color = "snow";
}


// BTN PEDIDO GUARDADO
    var btnPedido = document.querySelector('#blinkPedido');
    
    setInterval(function(){
      btnPedido.style.color = "purple";
      
      setTimeout(function(){
        btnPedido.style.color = "fuchsia";
      }, 500);
    }, 1000);


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
    window.location = "main.php";
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



setInterval(function(){ 
 funcionHora();
}, 1000);


var hora =""; 
    function funcionHora(){
        var d = new Date();
        hora = d.toLocaleTimeString();
        document.querySelector('#horaCons').value = hora;
    }

    var fecha = "";    
    getfecha();    
    function getfecha(){
        var y = new Date();
        var ano = y.getFullYear();
        var dia = y.getDate();
        var mes = (y.getMonth()+1).toString().padStart(2, '0');
        fecha = ano+'-'+mes+'-'+dia;
        document.querySelector('#fechaCons').value = fecha;
    }





	</script>
	






</body>
</html>