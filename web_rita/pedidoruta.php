<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	$nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];
    $idpedidoActual= "";
 
$numPedido="";    
    if($_GET){
        
       if ($_GET['pedido'] == 'eliminado'){
          header('location: productos.php?pag=1&pedido=eliminado'); 
       }
        
        $numPedido = $_GET['pedido'];

        if (isset($numPedido) && !empty($numPedido)){

        $tipoPago ="";
        $estadoCompra ="";
        // TIPO DE PAGO
        $sqlTipodePago = "
          SELECT forma_pago_compra, id_estado
            FROM compra
              WHERE id_pedido LIKE '".$numPedido."';
        ";
        $queryTipodePago = mysqli_query($conectar, $sqlTipodePago);
        while($rowPago = mysqli_fetch_assoc($queryTipodePago)){
          $tipoPago = $rowPago['forma_pago_compra'];
          $estadoCompra = $rowPago['id_estado'];;
        }

        
            $sqlTdaLaCompra = "
                SELECT *
                  FROM usuario
                      JOIN domicilio USING (id_usuario)
                        JOIN pedido USING (id_domicilio)
                        JOIN compra USING (id_pedido)
                        JOIN producto USING (id_producto)
                        WHERE id_usuario LIKE '".$id."'AND estado_pedido LIKE 'ruta';
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
	<title>Los Cuadros de Rita</title>
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
    <li class="cerrarF not">
      <a id="blinkPedido" class="txtCerrar" style="color: fuchsia; text-decoration:none;">Pedido Guardado</a>
    </li>
    <li class="cerrarF">
      <a class="txtCerrar" style="text-decoration:none;">Pedido en Ruta</a>
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

<style type="text/css">
  .estadosPagos{
    color: purple;
    font-family: "patrick";
    font-size: 24px;
    margin-bottom: 18px;
  }

</style>

<header class="titlePedido" style="">
<div>Inventario del pedido</div>  


<?php

  if($tipoPago == 'tarjeta' && $estadoCompra == '2'){
    ?>
    <div class="estadosPagos">El pedido esta pagado con tarjeta y se encuentra en ruta</div>
    <?php
  }else{
    ?>
    <div class="estadosPagos">El pedido se encuentra en ruta y se pagará "Contra Entrega"</div>
    <?php
  }



?>


</header>

<section  style="display: flex; justify-content: center; background: none;">
    <ul class="list-group ulPedido" style="">
        <form class="formPedido">
            
            <?php 
            $count = 1;
            echo "<script> var contador = []; l=1;</script>";
            while ($rowqueryCarrito = mysqli_fetch_assoc($queryCarrito)){
            
            $idProducto = $rowqueryCarrito['id_producto'];
           
            ?>
             
           <li class="list-group-item liClass" style="display: flex; align-items: center; background: aliceblue; color: blueviolet;">Pedido N#: <?php echo $rowqueryCarrito['id_pedido'];?>&nbsp;fecha: <?php echo $rowqueryCarrito['fecha_pedido'];?></li>           
           <li id="<?php echo "produ".$rowqueryCarrito['id_producto']; ?>" class="list-group-item liClass" style="display: flex; align-items: center;"> 
                <img src="<?php echo $rowqueryCarrito['foto_producto'];?>" class="imagencita" style="margin-right: 12px">
                <div class="contePedido" style="" >
                    <input class="nameProduct" style="color: purple; width: 150px; margin-right: 12px;" type="text" value="<?php echo $rowqueryCarrito['nombre_producto'];?>"readonly>
                    
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
            
            <li class="list-group-item direction" style="">Dirección de entrega:&nbsp;<span style="color:var(--darkm)"><?php echo  $direccion; ?></span></li>
            
            <div style="background: none; display: flex; justify-content: space-evenly; width: 100%; margin: 30px 0px 30px 0px;">
            <a class="btnCompra2" href="main.php";><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;volver</a>
        </form>
        </ul>
    </section>

<div class="push"></div>
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

var numPedido = <?php echo json_encode($numPedido); ?>;


    function elimina(ident){
    
        if (contador.length == 1){
            //var conf = confirm('Deseas Eliminar tu pedido?');
            Swal.fire({
              title: 'Deseas Eliminar tu pedido?',
              text: "...",
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, continuar!',
              cancelButtonText: 'No, gracias!'
            }).then((result) => {
              if (result.value) {
                

                let producto = ident.substr(5, 3).trim();  
                console.log(producto);
                let me = document.querySelector('#'+ident);
                console.log(me);
                let padre = me.parentNode.getAttribute("id");
                console.log(padre);
                document.querySelector('#'+padre).remove();
                
                console.log(numPedido);
                console.log(producto);
                fetch('https://loscuadrosderita.com/web/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
                
                setTimeout(function(){
                     window.location = 'productos.php?pag=1';
                    
                }, 700);
               
                return false;
            
            
              }else{
            
                //alert("cancel Submit");
                  return false;
            
              }
            })
            
            /*
            if (conf == true){
                
                 let producto = ident.substr(5, 3).trim();  
                console.log(producto);
                let me = document.querySelector('#'+ident);
                console.log(me);
                let padre = me.parentNode.getAttribute("id");
                console.log(padre);
                document.querySelector('#'+padre).remove();
                
                console.log(numPedido);
                console.log(producto);
                fetch('https://loscuadrosderita.com/web/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
                
                setTimeout(function(){
                     window.location = 'productos.php?pag=1';
                    
                }, 700);
               
                return false;
                
            }else{
                
              return false;
            }
            */
        }
        
        if (contador.length > 1){
        
            let producto = ident.substr(5, 3).trim();  
            //console.log(producto);
            let me = document.querySelector('#'+ident);
            let padre = me.parentNode.getAttribute("id");
            //console.log(padre);
            document.querySelector('#'+padre).remove();
         
            contador.pop();    
            console.log(contador); 
            fetch('https://loscuadrosderita.com/web/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
            }

    }

    console.log(contador);

// BTN PEDIDO GUARDADO ==========
  var btnPedido = document.querySelector('#blinkPedido');
  setInterval(function(){
    btnPedido.style.color = "purple";
    
    setTimeout(function(){
      btnPedido.style.color = "fuchsia";
    }, 500);
  }, 1000);



</script>
	












</body>
</html>


 