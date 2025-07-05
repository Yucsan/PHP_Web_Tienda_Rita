<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}

	require 'includes/conexion.inc.php';
	
	$id = $_SESSION['idUsu'];
	$nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];
    
    $sqlActualizaEstado = "
		UPDATE usuario
			SET estado_usuario = 1,
			    fuc_usuario = '".date('Y-m-d H:i')."'
			WHERE id_usuario LIKE ".$id.";
	";
	$queryActualizaEstado = mysqli_query($conectar, $sqlActualizaEstado);
	
	
	$carpeta = "logs";

	if (!file_exists("users/".$id."/".$carpeta)) {
		     //ruta y nombre o solo nombre y se crea en la raiz..
		mkdir("users/".$id."/".$carpeta, 0755);
		//echo "Carpeta Creada";
	}else{
		//echo "La carpeta ya existe";
	}
	
	
	$rutaArchivo = "users/".$id."/logs/registro.log";
	//$rutaArchivo = 'logs/registro.log';

	if (!file_exists($rutaArchivo)) {
		$archivo = fopen($rutaArchivo, "w");
		fwrite($archivo, '['.date('Y-m-d H:i').'] Se ha creado el archivo de registros'.PHP_EOL);
		fclose($archivo);
	}else{
		$archivo = fopen($rutaArchivo, "a");
		fwrite($archivo, '['.date('Y-m-d H:i').'] Ingreso de Usuario '.$nombre.' id='.$id.''.PHP_EOL);
		fclose($archivo);
	}
	
	
	// ACTUALIZA EL NUMERO DE CONEXIONES O VECES QUE PASO X MAIN
	$conexiones = "";
	$sqlCuenta = "
	    SELECT contador_usuario
	        FROM usuario
	        WHERE id_usuario LIKE '".$id."';
	";
	$queryCuenta = mysqli_query($conectar, $sqlCuenta);
	while ($rowCuenta = mysqli_fetch_assoc($queryCuenta)){
	    $conexiones = $rowCuenta['contador_usuario'];
	}
	    
	  $conexiones+=1;
    
    $sqlActualiza ="
        UPDATE usuario
            SET contador_usuario = '".$conexiones."'
            WHERE id_usuario LIKE '".$id."';
    ";
    $queryActualiza = mysqli_query($conectar, $sqlActualiza);
    
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
                WHERE id_usuario LIKE  '".$id."'AND estado_pedido LIKE 'ruta';
    ";
    $queryPedidosRuta =mysqli_query($conectar, $sqlPedidosRuta);
    while ($rowRutas = mysqli_fetch_assoc($queryPedidosRuta)){
      $pedidosRuta = $rowRutas['id_pedido'];
    }
    
 
    //print_r($pedidosRuta);

    $SinDireccion = "";
    $sqlReviza="
      SELECT * 
        FROM domicilio
          WHERE id_usuario LIKE '".$id."';
    ";
    $queryReviza = mysqli_query($conectar,$sqlReviza);

      if (mysqli_num_rows($queryReviza) == 0) {
          //echo "Usuario sin Dirección";
         $SinDireccion = true;
        }else{
          $SinDireccion = false;
          //echo "Usuario con Dirección registrada";
        }


      // TOTAL DE PRODUCTOS
        $sqlTotalProductos ="
           SELECT COUNT(id_producto) AS cuenta
               FROM producto;
       ";
       
      $cuenta = "";
      $queryTotalProductos = mysqli_query($conectar, $sqlTotalProductos);
      while ($rowqueryTotalProductos = mysqli_fetch_assoc($queryTotalProductos)){           
          $cuenta = $rowqueryTotalProductos['cuenta'];
      }

      // NÚMERO DE PÁGINAS
      $numPaginas = ceil($cuenta / 8);
      $maximoProducto = $numPaginas*8;

      if($_GET){
        if(isset($_GET['contraentrega']) && !empty($_GET['contraentrega'])){
          echo "<script>alert('Se te ha enviado un correo de confirmación con las indicaciones además se te contactará via télefonica');</script>";
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
<!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.2/css/all.css"> -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/sweealert2/css/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<link rel="icon" type="icon/png" href="favicon.png">
	<title>Los Cuadros de Rita</title>

	<style type="text/css">
		.accordion-button:not(.collapsed){
            background-color: transparent;
        }
    
        .btnCompra{
            width: 130px;
            margin-left: auto;
            border-radius: 50px;
            background: var(--morado);
            color: white;
            border: none;
            font-family: 'muli';
            padding: 10px;
            font-size: 16px;
        }
        
        .productosCarrito{
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

	</style>
</head>

<body onscroll="alto()" style="background: #F4F4F4;">
<div id="starter" class="body">

<div class="btnHomeIndex" style="">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div class="logoHorizontal" style="">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
    
 <form action="productos.php?pag=1" method="POST" class="buscaNav">
        <input class="inputCustom me-2" type="search" placeholder="Buscar" name="buscar" aria-label="Search">
        <button class="btn btn-dark btnCustom" type="submit">Buscar</button>
 </form>

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
          <a class="nav-link  active" aria-current="page" >Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#sobreMi">Sobre Mi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php?pag=1">Cuadros</a>
        </li>
      </ul>

    </div>
        <form action="productos.php?pag=1" method="POST" class="buscaNav2">
          <input class="inputCustom2 me-2" type="search" placeholder="buscar" name="buscar" aria-label="Search">
          <button class="btn btn-dark btnCustom" type="submit">buscar</button>
        </form>
  </div>
</nav>


<!-- Barra Usuario -->
<div class="barraUsuario" style="">

  <ul class="ulUsuario" style="">
    <li id="persona" class="nombreUser" style="">
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


<!--  -->

         
<!-- CARROUSEL-->
<div class="container-fluid sliderTop2" style="">
  <div class="row">
    <div class="col-md-12 col-lg-1 R1 px-0" style="background:rgba(200,220,220,0.3);"></div>
    <div class="col-md-12 col-lg-10 px-0" style="">
      <div class="swiper-container" style="top:0px;">
       <div class="swiper-wrapper">
         
         <?php 
         
          require 'includes/conexion.inc.php';
          $sliderImgs = array();
          $cuadros = array();
          $orden = array();

            $sqlProduSlider ="
                SELECT * 
                    FROM producto
    	            WHERE slider_producto > 0
                        ORDER BY slider_producto ASC;
            ";
            $queryProduSlider = mysqli_query($conectar, $sqlProduSlider);
            while ($rowqueryProduSlider = mysqli_fetch_assoc($queryProduSlider)){
             $cuadros[] += $rowqueryProduSlider['id_producto'];
             $orden[] += $rowqueryProduSlider['orden_producto'];

         ?>  

         <div class="swiper-slide a1">
          <div class="textoSlide1">
            <h3 class="tituloSlide1">
              <div class="tituloSlide" style=""><?php echo $rowqueryProduSlider['promotxt_producto']; ?></div>
              <div class="txtSlide"><?php echo $rowqueryProduSlider['txtconte_producto']; ?></div>
            </h3>
            <a id="a<?php echo $rowqueryProduSlider['id_producto']; ?>" class="btnSlide1" href="vercuadro2.php?ident=<?php echo $rowqueryProduSlider['id_producto']; ?>">ver cuadro</a>
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

<!--INFORMACION PERSONAL -->
<section id="sobreMi" class="container-fluid sectionMain" style="">

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

      <div class="bd-example txtExpo" style="">
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
            <!-- <a href="#">Seguir leyendo</a> -->
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


<!-- SECCION CON PRODUCTOS -->
<script>var conteEstados = []; </script>

    <ul style="background: none; list-style: none; display: flex; justify-content: center; padding-left: 0; margin-bottom: 0; margin-top: 20px;">
        <li style="padding: 20px;">
           <a href="productos.php?pag=1" style="text-decoration: none; background: var(--morado); padding: 10px; border-radius: 6px; color: snow;">VER TODOS LOS CUADROS</a>  
        </li>    
    </ul> 
<div class="container-fluid productos swiperMain">

  <div class="row">
    <div class="col-md-12 col-lg-1 R1"></div>
    <div class="col-md-12 col-lg-10 bloqueProductos">

    <?php 
    $gustan = array();
    $sqlCustomLikes ="
        SELECT id_producto, like_consulta
	        FROM consulta
    	        JOIN usuario USING (id_usuario)
                    WHERE nombre_usuario LIKE '".$nombre."';
    ";
    $queryCustomLikes = mysqli_query($conectar, $sqlCustomLikes);
    while ($rowqueryCustomLikes = mysqli_fetch_assoc($queryCustomLikes)){
        
        $gustan[$rowqueryCustomLikes['id_producto']] = $rowqueryCustomLikes['like_consulta'];
    }

    $sqlProductos ="
        SELECT * 
            FROM producto
            WHERE id_producto >= 13 AND id_producto <= 16;
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
        <div class="card-body" style="display: flex; justify-content: space-around; flex-direction: column;">
                    
        <h5 class="card-title"  id="pro<?php echo "$conte";?>" style="color: var(--morado);"><?php echo $rowqueryProductos['nombre_producto']; ?></h5>

        </div>
      </div>

    <?php 
        $contador++; $conte++;
    }
    

    ?>


    </div>

    <div class="col-md-12 col-lg-1 R3"></div>
  </div>
</div>
<!-- BTN FLECHA -->
<div style="position: relative;background: lightblue; position: relative; width: 100%; bottom: 90px;">
  <a id="arriba" href="#starter" style=""><i id="flechita" class="fas fa-arrow-up"></i></a>
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
<script  type="text/javascript" src="assets/js/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="assets/vendor/sweealert2/js/sweetalert2.min.js"></script>
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



// EN QUE PAGINA ESTA EL CUADRO...
var nums = [];
var ubi = [];
var paginas = <?php echo json_encode($numPaginas); ?>;
var totalProductos = 8 * paginas;
var maximo = <?php echo json_encode($maximoProducto); ?>;
var cuadros = <?php echo json_encode($cuadros); ?>;
var orden = <?php echo json_encode($orden); ?>;
console.log(cuadros);

i = 0;
while ( i <= totalProductos ){
  nums.push(i);
 i+= 8; 
}
console.log(nums);

  j = 0;
  while (j<orden.length){
    r = 1; k = 0;
    while(k < nums.length){
      if(orden[j] < nums[r]){
        ubi.push(r);
        break; 
      }else if((orden[j] == maximo)){
        ubi.push(nums.length-1);
        break;
      }else if(orden[j] == nums[nums.length] && orden[j] != 8){
        ubi.push(nums.length);
        break;
      }else if(orden[j] == 8){
        ubi.push(1);
        break;
    }
     r++; 
     k++;   
    }
  
   j++;
  }

console.log(ubi);
// BUCLE QUE PINTA LA VARIABLE GET AL ENLACE
i=0;
while (i<ubi.length){
  document.querySelector('#a'+cuadros[i]).href+='&pag='+ubi[i];
  i++;
}


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



// VARIABLES CARRITO
var almacen = [];
var cont = document.querySelector("#conteBolsa");
var sum1 = 1;
var datito = "";

var carrillo = document.querySelector('#collapseOne');
let selector ="";

var unidades = 0;
var sumaTotal = document.querySelector('#total');
var instancia = 0;


var name = "<?php echo $nombre ?>";
var id = "<?php echo $id ?>";


function redi(){
  console.log('redirecciona');
  //window.location = 'https://www.w3schools.com';
  //window.open("https://www.w3schools.com"); 
}

 var swiper = new Swiper('.swiper-container', {
      spaceBetween: 0,
      speed: 300,
      loop: true,
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