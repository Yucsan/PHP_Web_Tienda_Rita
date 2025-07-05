<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	  $nombre = $_SESSION['nombreUsu'];
    $fotito = $_SESSION['fotoUsu'];
    $correo = $_SESSION['correoUsu'];
    $idpedidoActual= "";
    
  if($_GET){        
       $idpedidoActual = "ContraE".$_GET['pedido'];
      $numPedido = $_GET['pedido'];        
      if (isset($numPedido) && !empty($numPedido)){            
          $sqlTdaLaCompra = "
              SELECT *
	               FROM usuario
  	                JOIN domicilio USING (id_usuario)
                      JOIN pedido USING (id_domicilio)
                      JOIN compra USING (id_pedido)
                      JOIN producto USING (id_producto)
                      WHERE id_usuario LIKE '".$id."' AND id_pedido LIKE '".$numPedido."'; 
          ";
          $queryCarrito = mysqli_query($conectar, $sqlTdaLaCompra);              
      }
  }else{
      header('Location: main.php');
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
    if(isset($_POST['movil']) && !empty($_POST['movil'])){

      $movil = $_POST['movil'];
      $numPedido;
      //echo "<br>";
      $correo;

      
      $sqlEnviando ="
        UPDATE pedido
          SET comentario_pedido = '".$movil."',
              estado_pedido = 'ruta'
              WHERE id_pedido LIKE '".$numPedido."';
      ";
      $queryEnviando = mysqli_query($conectar, $sqlEnviando);
      
      $sqlFormadePago ="
        UPDATE compra
          SET forma_pago_compra = 'Efectivo'
              WHERE id_pedido LIKE '".$numPedido."';
      ";
      $queryFormadePago = mysqli_query($conectar, $sqlFormadePago);


      // ENVIAR CORREO

      $receptor = $correo;
                  $asunto = "Confirmacion de Pedido en Ruta Los Cuadros de Rita.com";
                  $mensaje = "Tu pedido está en ruta recuerda que se te contactará via telefónica para la confirmción de la dirección y el pedido, cualquier duda escribenos a: consulta@loscuadrosderita.com";
                  $cabecera = "MIME-Version: 1.0" . "\r\n";
                  $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                  $cabecera .= 'From: mensajes@loscuadrosderita.com' . "\r\n" .'Reply-To: mensajes@loscuadrosderita.com' . "\r\n";
                  mail($receptor, $asunto, $mensaje, $cabecera);
      


      //header('Location: main.php?contraentrega=yes');
      include 'sweets/pedidoenruta.html';            

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
	<link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/sweealert2/css/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="icon" type="icon/png" href="favicon.png">
	<title>Pago Contra Entrega</title>
	<style type="text/css">
	</style>
</head>
 
<body style="background: #F4F4F4;">
    <div class="body3">

<div style="background:  #793DA3; float:left; border-radius: 0px 0px 69px 67px;">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div class="logoHorizontal" style="">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
  <div class="container-fluid">

    <div class="logoMovil">
      <img class="logoWeb2" src="assets/rsc/img/webLogo.gif" style="border-radius: 63px; width: 130px; position: relative; border: indigo solid 6px;">
      <button class="navbar-toggler btnToggler modi" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <button class="navbar-toggler btnToggler2 modi1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-0 mb-lg-0 conteNav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="main.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="main.php#sobreMi">Sobre Mi</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" aria-current="page" href="productos.php?pag=1">Cuadros</a>
        </li>
      </ul>

    </div>
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
      <a id="blinkPedido" href="" class="txtCerrar" style="text-decoration:none;">Pedido Guardado</a>
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

<header class="titlePedido" style="">Ingresa tu número de telefono</header>
<section  style="display: flex; justify-content: center; background: none;">
    <ul class="list-group ulPedido" style="">
        <form class="formPedido" name="pagoEntrega" method="POST" action="">
                      
    <?php 
                  
   $idDireccionUsu="";
   $nombreDomicilio = "";
    $sqlDomicilio = "
          SELECT *
	        FROM direccion
            JOIN domicilio USING (id_direccion)
    	    WHERE id_usuario LIKE  '".$id."' AND tipo_domicilio LIKE '%entrega%';    
    ";
     $queryDomicilio = mysqli_query($conectar, $sqlDomicilio);
     while ($rowqueryDomicilio = mysqli_fetch_assoc($queryDomicilio)){
         
        $idDireccionUsu = $rowqueryDomicilio['id_domicilio'];            
        $direccion = $rowqueryDomicilio['nombre_direccion'];    
        
     }  
    ?>
            <li class="list-group-item" style="text-align: center; color: gray;">Codigo de pedido: 00 <?php echo $idpedidoActual; ?></li>
            <li class="list-group-item" >
              <label>Ingresa tu número de teléfono</label>

              <input style="padding: 5px; border-radius: 6px;" type="text" name="movil" value="">
            </li>
            
            <li class="list-group-item direction" style="">Dirección de entrega:&nbsp;<span style="color:var(--darkm)"><?php echo  $direccion; ?></span></li>
            
            <div style="background: none; display: flex; justify-content: space-evenly; width: 100%; margin: 30px 0px 30px 0px;">
            <a class="btnCompra2" href="productos.php?pag=1";><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;volver</a>

            <div class="btnBuyWrapperPc" style="background: none;">
                
                <button type="submit" name="tele" class="btntarjeta" style="margin-left: 15px;" href="pcentrega.php">Finalizar Pedido</button>
            </div>
        </form>
        </ul>
    </section>

<style type="text/css">
  .push3{
    height: 350px;
  }
</style>

<div class="push3"></div>
</div>
 <footer class="footer2">
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
<script type="text/javascript" src="assets/vendor/sweealert2/js/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript">



// BTN PEDIDO GUARDADO =========
  var btnPedido = document.querySelector('#blinkPedido');
  setInterval(function(){
    btnPedido.style.color = "purple";
    
    setTimeout(function(){
      btnPedido.style.color = "fuchsia";
    }, 500);
  }, 1000);

  // BTN PEDIDO RUTA ============
  var btnPedido2 = document.querySelector('#blinkPedido2');
  setInterval(function(){
    btnPedido2.style.color = "purple";
    
    setTimeout(function(){
      btnPedido2.style.color = "fuchsia";
    }, 500);
  }, 1000);

</script>
	












</body>
</html>


 