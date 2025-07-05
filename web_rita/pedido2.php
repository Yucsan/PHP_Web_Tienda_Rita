<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	  $nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];
    $idPedido="";
    $productos = array();
    $pyunidades = array();//Productos y unidades
    $precios = array(); 

    $carritoCompra = array();
    $idpedidoActual ="";
    

if($_POST){

    if(isset($_POST) && empty($_POST)) {
        header('Location: productos.php?pag=1');
           
        }else if (!isset($_POST['pedidoGuardado'])) {
            
        //"NO hay pedido Guardado";
       

              foreach ($_POST as $key => $value) {
                //echo $key.": ".$value."<br>";
               
               if (substr($key, 0, 2) == 'id'){
                    //$productos[] += substr($key, 2);
                    $pyunidades[substr($key, 2)] = $value;
               }else if (substr($key, 0, 6) == 'precio'){
                    $precios[substr($key, 6)] = substr($value, 5);
               }


            }
            // ======= DATOS EN CASO NECESITE REVIZAR SIN PEDIDO GUARDADO ========
            //echo "<br>";
            //print_r($productos);
            //print_r($pyunidades);
            //echo "<br>";
            //print_r($_POST);
            //echo "<br>";
            //print_r($precios);
            $suma = array_sum($pyunidades);// suma de CANTIDADES productos
            //$suma = count($pyunidades);// suma de productos            
            $idDomicilio ="";
            
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            //$fecha = date("Y.m.d");
            //$hora  = date("H:i:s");
            
            $sqlIdDom = "
                SELECT id_domicilio
	                FROM domicilio
                    WHERE id_usuario LIKE '".$id."';
            ";
            $queryIdDom = mysqli_query($conectar, $sqlIdDom);
            while($rowIdDom = mysqli_fetch_assoc($queryIdDom)){
                
                 $idDomicilio =  $rowIdDom['id_domicilio'];  
            }

        
            //inserto PEDIDO
            
            $sqlInsertarPedido ="
            INSERT INTO pedido
		            VALUES (null, 'Sin Comentario', 'guardado', '".$suma."', '".$fecha."', '".$hora."', '".$idDomicilio."');
            ";
            $queryInsertarPedido = mysqli_query($conectar, $sqlInsertarPedido);
            
            
            // RESCATO EL NUMERO DE PEDIDO QUE ACABO DE HACER
            $idPedido = ""; 

            $sqlIdPedido = "
                SELECT id_pedido
	                        FROM pedido
	                            WHERE id_domicilio LIKE '".$idDomicilio."';
            ";
            $queryIdPedido = mysqli_query($conectar, $sqlIdPedido);
            while($rowIdPedido = mysqli_fetch_assoc($queryIdPedido)){
                
                $idPedido = $rowIdPedido['id_pedido'];
                
            }
            
                // si el pedido son mas de 1
                if(is_array($idPedido)){
                    
		             $idpedidoActual = max($idPedido);

	              }else{
	            		$idpedidoActual = $idPedido;
	              }
            
            // INSERTO LOS PRODUCTOS EN LA TABLA DE COMPRA
            foreach($pyunidades as $key => $valor){
                        //echo "Insert: ".$valor."<br>";

                    $price = $precios[$key];
                    
                    $sqlCompra = "
                        INSERT INTO compra
		                    VALUES (null, 'tarjeta', '".$price."', '".$idpedidoActual."', '".$key."', '".$valor."', '1');                
                    ";
                    $queryCompra = mysqli_query($conectar,$sqlCompra);
                    
                    // ESTO ES MAGIAAAAAAAA
            }
        
            $sqlCompra ="
                SELECT id_producto, cantidad_compra
	                FROM compra
    	            WHERE id_pedido LIKE '".$idPedido."';
            ";
            $queryCompra = mysqli_query($conectar, $sqlCompra);
            while ($rowCompra = mysqli_fetch_assoc($queryCompra)){
                $carritoCompra[$rowCompra['id_producto']] = $rowCompra['cantidad_compra'];
            }
        
    }else if(isset($_POST['pedidoGuardado'])){
        
        //echo "Hay pedido Guardado";
        //print_r($_POST);
        //echo "<br>";
        
        foreach ($_POST as $key => $value) {
                //echo $key.": ".$value."<br>";              
               if (substr($key, 0, 2) == 'id'){
                    //$productos[] += substr($key, 2);
                    $pyunidades[substr($key, 2)] = $value;
               }
        }

            // ======= DATOS EN CASO NECESITE REVIZAR CON PEDIDO GUARDADO ========
            //print_r($productos);
            //print_r($pyunidades);
            //echo "<br>";
            //print_r($_POST);
            //echo "<br>";
            
             //$suma = array_sum($pyunidades);          
            $idDomicilio =""; //ID Domicilio del user
            
            $fecha = $_POST['fecha'];
            $hora  = $_POST['hora'];
            
            $sqlIdDom = "
                SELECT id_domicilio
	                FROM domicilio
                    WHERE id_usuario LIKE '".$id."';
            ";
            $queryIdDom = mysqli_query($conectar, $sqlIdDom);
            while($rowIdDom = mysqli_fetch_assoc($queryIdDom)){
                
                 $idDomicilio =  $rowIdDom['id_domicilio'];  
            }
            
            $idPedido = ""; //ID Pedido guardado
            $sqlIdPedido ="
                SELECT id_pedido
	                FROM pedido
                    WHERE id_domicilio LIKE '".$idDomicilio."' && estado_pedido LIKE 'guardado';
            ";
            $queryIdPedido = mysqli_query($conectar, $sqlIdPedido);
            while($rowIdPedido = mysqli_fetch_assoc($queryIdPedido)){
                
                $idPedido = $rowIdPedido['id_pedido'];
            }
            
            //Actualizar Pedido FECHA && HORA
            //echo "Actualiza"."<br>";
        
            $sqlActualizarPedido = "
                UPDATE pedido
                    SET fecha_pedido = '".$fecha."',
                        hora_pedido = '".$hora."'
                    WHERE id_pedido LIKE '".$idPedido."';
            ";
            $queryActualizarPedido = mysqli_query($conectar, $sqlActualizarPedido);

                //PRIMERO RESCATAMOS la compra guardada
                $compraRescate = array();
                $sqlCompraSave ="
                    SELECT * 
                        FROM compra 
                        WHERE id_pedido LIKE '".$idPedido."';
                ";
                $queryCompraSave = mysqli_query($conectar, $sqlCompraSave);
                while ($rowCompraSave = mysqli_fetch_assoc($queryCompraSave)){
                    
                    //echo $rowCompraSave['id_producto']." ".$rowCompraSave['cantidad_compra'];
                    //echo "<br>";
                    $compraRescate[$rowCompraSave['id_producto']] = $rowCompraSave['cantidad_compra'];
                
                }
                
                //print_r($compraRescate);
                 
                foreach($pyunidades as $key => $valor){
                    if (array_key_exists($key, $compraRescate)){
                         // si hay producto igual le sumamos cantidad en la db
                        //echo "suma producto";
                    
                        $sqlUpdateCantidadProducto ="
                            UPDATE compra
                                SET cantidad_compra = cantidad_compra+'".$valor."'
                                WHERE id_producto LIKE '".$key."' AND id_pedido LIKE '".$idPedido."';
                        ";
                        $queryUpdteCantidadProducto = mysqli_query($conectar, $sqlUpdateCantidadProducto);


                        //SUMO LA CANTIDAD DE TDOS LOS PRODUCTOS LUEGO DE AÑADIR
                        $nuevototalPedido = "";
                        $sqlNuevoTotal ="
                            SELECT SUM(cantidad_compra) AS 'cantidad'
                                FROM compra
                                    WHERE id_pedido LIKE '".$idPedido."';
                        ";
                        $queryNuevoTotal =  mysqli_query($conectar, $sqlNuevoTotal);
                        while($rowNuevoTotal = mysqli_fetch_assoc($queryNuevoTotal)){
                            $nuevototalPedido = $rowNuevoTotal['cantidad'];
                        }

                        // ACTUALIZO CANTIDAD
                        $sqlActualizaCanti ="
                            UPDATE pedido
                                SET cantidad_pedido = '".$nuevototalPedido."'
                                WHERE id_pedido LIKE '".$idPedido."';
                        ";
                        $queryActualizaCanti = mysqli_query($conectar, $sqlActualizaCanti);
                        // ==================================================
                    }else{
                        // ==================================================
                        $price ="";
                        $sqlPrecioProdu = "
                            SELECT precio_producto
	                            FROM producto
	                            WHERE id_producto LIKE '".$key."';
                        ";
                        $queryPrecioProdu = mysqli_query($conectar, $sqlPrecioProdu);
                        while ($rowPrecioProdu = mysqli_fetch_assoc($queryPrecioProdu)){
                            $price = $rowPrecioProdu['precio_producto'];
                        }
                        
                        //echo "inserta ".$price." ".$idPedido." ".$key." ".$valor;
                         
                            $sqlCompra = "
                            INSERT INTO compra
		                              VALUES (null, 'tarjeta', '".$price."', '".$idPedido."', '".$key."', '".$valor."', '1');
                    
                            ";
                            $queryCompra = mysqli_query($conectar,$sqlCompra); 
                            
                            
                            //SUMO LA CANTIDAD DE TDOS LOS PRODUCTOS LUEGO DE AÑADIR
                            $nuevototalPedido = "";
                            $sqlNuevoTotal ="
                                SELECT SUM(cantidad_compra) AS 'cantidad'
	                                FROM compra
                                        WHERE id_pedido LIKE '".$idPedido."';
                            ";
                            $queryNuevoTotal =  mysqli_query($conectar, $sqlNuevoTotal);
                            while($rowNuevoTotal = mysqli_fetch_assoc($queryNuevoTotal)){
                                $nuevototalPedido = $rowNuevoTotal['cantidad'];
                            }
                            
                            // ACTUALIZO CANTIDAD
                            $sqlActualizaCanti ="
                                UPDATE pedido
                                    SET cantidad_pedido = '".$nuevototalPedido."'
                                    WHERE id_pedido LIKE '".$idPedido."';
                            ";
                            $queryActualizaCanti = mysqli_query($conectar, $sqlActualizaCanti);
                            
                            //COMPRA ACTUAL                            
                            $sqlCompra2 ="
                            SELECT id_producto, cantidad_compra
	                            FROM compra
    	                        WHERE id_pedido LIKE '".$idPedido."';
                            ";
                            $queryCompra2 = mysqli_query($conectar, $sqlCompra2);
                            while ($rowCompra2 = mysqli_fetch_assoc($queryCompra2)){
                                $carritoCompra[$rowCompra2['id_producto']] = $rowCompra2['cantidad_compra'];
                            }
                            
                   }
                    
                }    
      
    }else{
        echo "No hay pedido guardado";
    }
}

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
                WHERE id_usuario LIKE  '".$id."' AND estado_pedido LIKE 'ruta' AND id_estado LIKE 1;
    ";
    $queryPedidosRuta =mysqli_query($conectar, $sqlPedidosRuta);
    while ($rowRutas = mysqli_fetch_assoc($queryPedidosRuta)){
      $pedidosRuta = $rowRutas['id_pedido'];
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
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="icon" type="icon/png" href="favicon.png">
	<title>Los Cuadros de Rita</title>
	<style type="text/css">
	</style>
</head>
 
<body onload="limpiaCarrito();" style="background: #F4F4F4;">
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
          <a class="nav-link  active" href="productos.php?pag=1" >Cuadros</a>
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
    <li class="cerrarS not3">
      <a class="nav-link saveBuy" id="blinkPedido2" id="msn" href="pedidoruta.php" style="color: fuchsia; display: none;">Pedido en Ruta</a>
    </li>
    <li class="cerrarS not2">
      <a class="nav-link saveBuy" id="msn" href="mensajes.php" style="color: fuchsia; display: none;">Mensajes</a>
    </li>
  </ul>
</div> 

<header class="titlePedido" style="">Inventario del pedido</header>

<?php

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
            
            $sqlCarrito = "
                SELECT *
	                FROM usuario
    	              JOIN domicilio USING (id_usuario)
                    JOIN pedido USING (id_domicilio)
                    JOIN compra USING (id_pedido)
                    JOIN producto USING (id_producto)
                      WHERE id_usuario LIKE '".$id."' AND id_pedido LIKE '".$idPedido."';
            ";
            $queryCarrito = mysqli_query($conectar, $sqlCarrito);
            $count = 1;
            echo "<script> var contador = [];</script>";
            while ($rowqueryCarrito = mysqli_fetch_assoc($queryCarrito)){
            
            $idProducto = $rowqueryCarrito['id_producto'];
           
            //if (array_key_exists($idProducto, $carritoCompra)){
                //echo $rowqueryCarrito['nombre_producto'];
            ?>
            
           <li id="<?php echo "produ".$rowqueryCarrito['id_producto']; ?>" class="list-group-item liClass" style="display: flex; align-items: center;"> 
                <img src="<?php echo $rowqueryCarrito['foto_producto'];?>" class="imagencita" style="margin-right: 12px">
                <div class="contePedido" style="" >
                    <input class="nameProduct" style="color: purple; width: 150px; margin-right: 12px;" type="text" value="<?php echo $rowqueryCarrito['nombre_producto'];?>"readonly>
                    
                     <span style="color: gray;">medidas: <input type="text" value="<?php echo $rowqueryCarrito['medida_producto'];?>"  style="width: 100px;" readonly></span>
                    
                     <span style="color: gray;">unidades: <input type="number" value="<?php echo $rowqueryCarrito['cantidad_compra']; ?>" style="width: 80px;" readonly></span>
                    
                     <span style="color: gray;">precio: S/. <input type="number" value="<?php echo $rowqueryCarrito['precio_producto'];?>" style="width: 80px;" readonly></span>
                </div>
                <button id="<?php echo "close".$rowqueryCarrito['id_producto']; ?>" onclick="elimina(this.id);" type="button" class="btn-close" aria-label="Close"></button>
                <?php echo "<script> contador.push('prod'+".$count.");</script>"?>
            </li>

    <?php 
            //}
         
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
            <a class="btnCompra2" href="productos.php?pag=1";><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;volver</a>
            <div class="btnBuyWrapper" style="background: none;">

                <form method="POST" action="tarjeta.php" name="pgotarjeta">
                    <input type="hidden" name="pedido" value="<?php echo $idPedido; ?>">
                    <button class="btntarjeta" type="submit">Pago con tarjeta <i class="fas fa-credit-card"></i></button>
                </form>  

                <a class="btntarjeta" href="pcentrega.php?pedido=<?php echo $idPedido; ?>">Pago contra entrega</a>
            </div>
     
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
<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript">


    // LIMPIAR CARRITO LOCALSTORAGE
    function limpiaCarrito(){
            sessionStorage.clear();
            console.log("Carrito Limpio");
        }

var numPedido = <?php echo json_encode($idPedido); ?>;

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
                fetch('https://loscuadrosderita.com/demo/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
                
                setTimeout(function(){
                     window.location = 'productos.php?pag=1';
                    
                }, 700);
               
                return false;
                       
              }else{
            
                //alert("cancel Submit");
                  return false;            
              }
            })
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
            fetch('https://loscuadrosderita.com/demo/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
            }

    }
    console.log(contador);

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


 