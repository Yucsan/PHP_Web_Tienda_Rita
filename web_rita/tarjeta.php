<?php
    session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	  $nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];
    $correo = $_SESSION['correoUsu'];
    
     $idPedido ="";
    $queryCarrito="";

    //if($_POST){
        


    //}

  if($_POST){        
      if (isset($_POST['pedido']) && !empty($_POST['pedido'])){
        $numPedido = $_POST['pedido'];  
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
      }else if(isset($_POST['idPedido']) && !empty($_POST['idPedido'])){
        $numPedido = $_POST['idPedido'];
          $sqlEnviando ="
            UPDATE pedido
              SET estado_pedido = 'ruta'
                WHERE id_pedido LIKE '".$numPedido."';
          ";
          $queryEnviando = mysqli_query($conectar, $sqlEnviando);
          $sqlEstadoCompra ="
            UPDATE compra
              SET id_estado = '2'
                WHERE id_pedido LIKE '".$numPedido."';
          ";
          $queryEstadoCompra = mysqli_query($conectar, $sqlEstadoCompra);
          //enviar correo
          $receptor = $correo;
                $asunto = "Confirmacion de Pago Los Cuadros de Rita.com, tu pedido está en Ruta ";
                $mensaje = "Tu pedido está en ruta recuerda que se te contactará via telefónica para la confirmción de la dirección y el pedido, cualquier duda escribenos a: consulta@loscuadrosderita.com";
                $cabecera = "MIME-Version: 1.0" . "\r\n";
                $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $cabecera .= 'From: mensajes@loscuadrosderita.com' . "\r\n" .'Reply-To: mensajes@loscuadrosderita.com' . "\r\n";
                mail($receptor, $asunto, $mensaje, $cabecera);
                include 'sweets/pagoexitoAct.html';  
      }


        //RESCATA INFO SOBRE PEDIDOS ===================================
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
        //print_r($idpedidos);
        //PEDIDOS EN RUTA SIN PAGAR ===================================
        $nPedidos = "";// NUMERO DE PEDIDOS EN RUTA
        $pedidosRuta = "";
        $sqlPedidosRuta="
          SELECT id_pedido
              FROM usuario
                  JOIN domicilio USING (id_usuario)
                    JOIN pedido USING (id_domicilio)
                    JOIN compra USING (id_pedido)
                    JOIN producto USING (id_producto)
                    WHERE id_usuario LIKE  '".$id."';
        ";
        $queryPedidosRuta =mysqli_query($conectar, $sqlPedidosRuta);
        while ($rowRutas = mysqli_fetch_assoc($queryPedidosRuta)){
          $pedidosRuta = $rowRutas['id_pedido'];
        }


  }
    
    //$idPedido="5";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Yo">
	<meta name="copyright" content="">
	<meta name="contact" content="mantenimiento@ejemplo.com">
	<meta name="description" content="">
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
	<title>Los Cuadros de Rita</title>

	<style type="text/css">
		

	</style>
</head>

<body style="background: #F4F4F4;">
<div class="body">

<div style="background:  #793DA3; float:left; border-radius: 0px 0px 69px 67px;">
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
          <a class="nav-link" aria-current="page" href="main.php">inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php?pag=1">Cuadros</a>
        </li>

      </ul>
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
      <a class="nav-link saveBuy" id="blinkPedido" href="#" style="color: fuchsia; display: none;">Pedido Guardado</a>
    </li>
    <li class="cerrarS not3">
      <a class="nav-link saveBuy" id="blinkPedido2" id="msn" href="pedidoruta.php" style="color: fuchsia; display: none;">Pedido en Ruta</a>
    </li>
    <li class="cerrarS not2">
      <a class="nav-link saveBuy" id="msn" href="mensajes.php" style="color: fuchsia; display: none;">Mensajes</a>
    </li>
  </ul>
</div> 

<header class="titlePedido" style="">Pago con Tarjeta</header>
<div class="pasaFix" style="">

  <form action="" method="POST" name="pgoTarjeta">
    <input type="hidden" name="idPedido" value="<?php echo $numPedido; ?>">
   <button class="btnPago" type="submit">PAGAR<i class="fas fa-credit-card"></i></button>
    <img class="imgPasa" src="assets/rsc/img/pasaok.jpg">
  </form>
    <!-- <div class="btnBuyWrapper2" style="background: none;"></div> -->    
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
    //============ ACTIVA BOTON PEDIDOS EN RUTA
    //print_r($pedidosRuta);
    if ($pedidosRuta != null || $pedidosRuta != ""){
            echo "<script>document.querySelector('#blinkPedido2').style.display = 'block';
            document.querySelector('.not3').style.display = 'block';
            document.querySelector('#blinkPedido2').href = 'pedidoruta.php?pedido=".$pedidosRuta."';
            </script>";
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



<section  style="display: flex; justify-content: center; background: none;">
    <ul class="list-group ulPedido" style="">
      

    <?php 

    if($queryCarrito != ""){

            $count = 1;
            echo "<script> var contador = []; l=1;</script>";
            while ($rowqueryCarrito = mysqli_fetch_assoc($queryCarrito)){
            
            $idProducto = $rowqueryCarrito['id_producto'];
           
    ?>
                      
           <li id="<?php echo "produ".$rowqueryCarrito['id_producto']; ?>" class="list-group-item liClass" style="display: flex; align-items: center;"> 
                <img src="<?php echo $rowqueryCarrito['foto_producto'];?>" class="imagencitaPago" style="">
                <div class="contePedido" style="" >
                    <input class="nameProduct" style="color: purple; width: 220px; margin-right: 12px;" type="text" value="<?php echo $rowqueryCarrito['nombre_producto'];?>"readonly>
                    
                     <span style="color: gray;">medidas: <input type="text" value="<?php echo $rowqueryCarrito['medida_producto'];?>"  style="width: 100px;" readonly></span>
                    
                     <span style="color: gray;">unidades: <input type="number" value="<?php echo $rowqueryCarrito['cantidad_compra']; ?>" style="width: 80px;" readonly></span>
                    
                     <span style="color: gray;">precio: S/. <input type="number" value="<?php echo $rowqueryCarrito['precio_producto'];?>" style="width: 80px;" readonly></span>
                </div>
                
                
                <?php //echo "<script> contador.push('prod'+l);</script>"?><!--lo mismo pero en JS -->
                <?php echo "<script> contador.push('prod'+".$count.");</script>"?>
            </li>

    <?php 
          echo "<script> l++ </script>";  
         $count++;      
        }
    }    
        
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
            <li class="list-group-item" style="text-align: center; color: gray;">Codigo de pedido: 00TArje <?php echo $numPedido; ?></li>
            
            <li class="list-group-item direction" style="">Dirección de entrega:&nbsp;<span style="color:var(--darkm)"><?php echo  $direccion; ?></span></li>
            
            <div style="background: none; display: flex; justify-content: space-evenly; width: 100%; margin: 30px 0px 30px 0px;">
            
            
   
        </ul>
    </section>

<style type="text/css">


</style>




	<noscript>Debes activar JavaScript</noscript>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">

function myFunction(x) {
  if (x.matches) {
    document.querySelector('.imgPasa').src ='assets/rsc/img/paymovil.jpg';
  } else {
   document.querySelector('.imgPasa').src ='assets/rsc/img/pasaok.jpg';
  }
}

var x = window.matchMedia("(max-width: 780px)")
myFunction(x)
x.addListener(myFunction)


//TOOLTIPS
/*
    var idPedido = <?php echo json_encode($idPedido); ?>;
    //alert(idPedido);
    function pago(){
         
        fetch('https://loscuadrosderita.com/demo/apis/pago.app.php?pay='+idPedido)
        alert('Pago Realizado con Exito');
        window.location.href = "main.php?gracias=1";
    }	
*/


// BTN PEDIDO GUARDADO ==========
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