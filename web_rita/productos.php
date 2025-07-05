<?php

  session_start();

  if (!isset($_SESSION['idUsu'])) {
    header('Location: index.php');
  }

  require 'includes/conexion.inc.php';
  
  $id = $_SESSION['idUsu'];
  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];
  $cuadros = array();  
  $orden = array();
    $page ="";
    
    if ($_GET){            
      $page = $_GET['pag'];
           
       $sqlTotalProductos ="
           SELECT COUNT(id_producto) AS cuenta
               FROM producto;
       ";
       
      $cuenta = "";
      $queryTotalProductos = mysqli_query($conectar, $sqlTotalProductos);
      while ($rowqueryTotalProductos = mysqli_fetch_assoc($queryTotalProductos)){           
          $cuenta = $rowqueryTotalProductos['cuenta'];
      }
            
      $numPaginas = ceil($cuenta / 8);
      $primerNum = "";
      $segundoNum = "";
      $maximoProducto = $numPaginas*8;
            
      if ($page == 1){
          $primerNum = 1;
          $segundoNum = 8+1;
      }elseif($page >= 2){
          $primerNum = $page*8-8;
          $segundoNum = $page*8;
      }

      //=================AGREGA DE vercuadros.php============================
      // IMPORTANTE SI AGREGAS GET DEBES DECLARAR VERCUADROS = FALSE Y AGREGA = NULL

      if(isset($_GET['agrega']) && !empty($_GET['agrega'])) {

        //$conteAdd = $_GET['conte'];
        $idAgrega = $_GET['agrega'];
        //echo "entra";
        echo "<script> var verCuadros = true; </script>";

      }else if(isset($_GET['falta']) ){

          echo "<script> var verCuadros = false; alert('Debes llenar todos los campos');</script>";
          $idAgrega = null;
      }else{
        echo "<script> var verCuadros = false; </script>";
        $idAgrega = null;
        //$conteAdd = null;
      }
                
    }

    $busqueda = false;
    echo "<script> var search = false;</script>";

    if ($_POST){
        if (isset($_POST['buscar']) && !empty($_POST['buscar'])){
              $sqlProductos ="
                  SELECT * 
                      FROM producto
                      JOIN estilo USING (id_estilo)
                  WHERE nombre_producto LIKE '%".$_POST['buscar']."%' OR
                  tema_estilo LIKE '%".$_POST['buscar']."%';
              ";
              $busqueda = true;
              echo "<script> var search = true;</script>";
        }
            
    }else{
        $sqlProductos ="
            SELECT * 
                FROM producto
            WHERE orden_producto >= '".$primerNum."' AND orden_producto < '". $segundoNum."'
            ORDER BY orden_producto ASC;
        "; 
    }
               
          $queryProductos = mysqli_query($conectar, $sqlProductos);
    
    
    //RESCATA INFO SOBRE PEDIDOS ==============================
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

<body onscroll="alto()" style="background: #F4F4F4;">
<div id="starter" class="body">

<div onclick="main();" class="btnHome">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div  onclick="main();" class="logoHorizontal" style="">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
    
 <form class="buscaNav" method="POST">
        <input class="inputCustom me-2" type="search" placeholder="Buscar" name="buscar" aria-label="Search">
        <button class="btn btn-dark btnCustom" type="submit">Buscar</button>
 </form>

  <div class="container-fluid">

    <div class="logoMovil">
      <img onclick="main();" class="logoWeb2" src="assets/rsc/img/webLogo.gif" style="border-radius: 63px; width: 130px; position: relative; border: indigo solid 6px;">


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
          <a class="nav-link  active">Cuadros</a>
        </li>
      </ul>

    </div>
        <form class="buscaNav2" method="POST">
          <input class="inputCustom2 me-2" type="search" name="buscar" placeholder="buscar" aria-label="Search">
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
      <a href="" class="nav-link saveBuy" id="blinkPedido" href="#" style="color: fuchsia; display: none;">Pedido Guardado</a>
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
    // DIRECCION ====================
    $idDireccionUsu="";
    $sqlDomicilio = "
          SELECT * 
          FROM direccion
            JOIN domicilio USING (id_direccion)
          WHERE id_usuario LIKE '".$id."';
    
    ";
     $queryDomicilio = mysqli_query($conectar, $sqlDomicilio);
     while ($rowqueryDomicilio = mysqli_fetch_assoc($queryDomicilio)){
         
         $idDireccionUsu = $rowqueryDomicilio['id_domicilio'];
         
?>

<!-- ESTE AUN ESTA EN DESARROLLO -->
<!-- <div class="domiDirect" style="">
    <form id="stopi" action="" method="GET" class="formDire" >
            <div style="margin-right: 10px;">
            <label for="domicilios">Domicilio Actual:</label>
            <br>
            <select id="doms" name="domicilios" style ="color:gray;">
                <option value="<?php //echo $rowqueryDomicilio['id_direccion'] ?>"><?php //echo $rowqueryDomicilio['nombre_direccion']." - ".$rowqueryDomicilio['numero_direccion']." - ".$rowqueryDomicilio['distrito_direccion']; ?></option>
            </select>
            </div> 
    </form>
</div>  -->

<?php 
    }
?>

<!--CARRITO DE COMPRA -->
<div class="accordion" id="accordionExample" style="background:transparent;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button style="color:purple;" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <div style="width: 100%; display:flex; justify-content: center; align-items: center;">
            <span>Carrito</span><i class="fas fa-shopping-cart"></i>&nbsp;<span id="total"></span>
        </div>
      </button>
    </h2>
    <div id="collapseOne" onclick="estadoCarrito();" class="accordion-collapse collapse soloyo" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body" style="width: 100%;display: flex;justify-content: space-evenly; align-items: end; position: relative; flex-direction: column">
        <?php
        // CAMBIO EL ACTION dependiendo si el usuario tiene ya registrada la direccion
        if( $SinDireccion == true){
          echo "<form class='bolsa' name='carrito' action='pedido3.php' method='POST'>";
        }else{
          echo "<form class='bolsa' name='carrito' action='pedido2.php' method='POST'>";
        }

        ?>        
            <div id="conteBolsa" style="display: flex; padding: 4px; align-items: end; flex-direction:column;"></div> 
           <hr> 
           <div style="display:flex; justify-content: space-around;">
           <!--<button class="btnCompra" type="submit" style="">confirmar</button>-->
           </div>
        </form>
        <div style="background:none; display:flex; justify-content: center; width: 100%;">

        <button class='btnCompra' onclick='addProducts();'>confirmar</button>

        <div class="trash" style="" onclick="limpiar()">limpiar <i class="fas fa-trash-alt"></i></div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!--<input type='hidden' name='PedidoGuardado' value='true'>-->

<?php 

  //LLAMA AL BTN PEDIDO SI HAY PEDIDO ========================
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
  //RESCATAMOS MENSAJES ====================
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

<!-- SECCION CON PRODUCCTOS -->
<script> var conteEstados = [];</script>

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
    //print_r($gustan);
    
    $contador = 1;
    $conte = 0;
    $pagPrecios = array();
    while ($rowqueryProductos = mysqli_fetch_assoc($queryProductos)){
        
        $idProducto = $rowqueryProductos['id_producto'];
        $precio = $rowqueryProductos['precio_producto'];
        $pagPrecios[] += $precio;
?> 

<!-- CARTA -->
      <div class="card cuadro1" style="">
        <img src="<?php echo $rowqueryProductos['foto_producto']?>" style="border: solid 10px #EDBC41" class="card-img-top" alt="cuadro">
        <div class="card-body" style="display: flex; justify-content: space-around; flex-direction: column;">
   
   <?php
            
    if (array_key_exists($idProducto, $gustan)){
        //echo "existe";
        if ($gustan[$idProducto] == 1){
   ?>
            <i class="fas fa-heart likeCard" id="play<?php echo "$conte"; ?>" style="cursor: pointer; color: purple; text-align: center" onclick = "funcLike(this.id +' '+<?php echo "$idProducto"?>)"></i>
                <?php echo "<script>var estado".$conte." = true; conteEstados.push(estado".$conte."); </script>"; ?>
        <?php
        }elseif($gustan[$idProducto] == 0){
        //echo "ya no te gusta";
        ?>
            <i class="far fa-heart likeCard" id="play<?php echo "$conte"; ?>" style="cursor: pointer; color: gray; text-align: center" onclick = "funcLike(this.id +' '+<?php echo "$idProducto"?>)"></i>
                <?php echo "<script>var estado".$conte." = false; conteEstados.push(estado".$conte."); </script>"; ?>
      <?php
        }
   }else{
        //echo "nada";
       ?>
            <i class="far fa-heart likeCard" id="play<?php echo "$conte"; ?>" style="cursor: pointer; color: gray; text-align: center" onclick = "funcLike(this.id +' '+<?php echo "$idProducto"?>)"></i>
              <?php echo "<script>var estado".$conte." = false; conteEstados.push(estado".$conte."); </script>"; ?>
                
  <?php
    }            
    ?>

            <h5 class="card-title" id="pro<?php echo $rowqueryProductos['id_producto']; ?>" style="color: var(--morado);"><?php echo $rowqueryProductos['nombre_producto']; ?></h5>
            <p class="card-text">Cuadro de estilo Naif inspirado en la primavera. <br>
                <span style="color:var(--morado)">Medidas:</span><span>&nbsp;<?php echo $rowqueryProductos['medida_producto'];?></span><br>
                <span style="color:var(--morado)">Precio:</span><span id="pre<?php echo $rowqueryProductos['id_producto']; ?>">&nbsp;S/.<?php echo $rowqueryProductos['precio_producto'];?></span><br>
                <span style="color:var(--morado)">Materiales:</span><span>&nbsp;Vidrio, lacas vitrales</span>
            </p>

        <div style="background: none; position: relative; display: flex;">
                <?php 
                // SI HAY BUSQUEDA SE LE ASIGNAN EL NUMERO DE PAGINA A LOS PRODUCTOS PARA VOLVER A SU PAG Y PUEDAN SER INCLUIDOS EN EL CARRITO DE COMPRA DINAMICAMENTE
                if ($busqueda == false){
                  ?>
                  <a href="vercuadro2.php?ident=<?php echo $rowqueryProductos['id_producto']?>&pag=<?php echo $page;?>&conte=<?php echo "$conte";?>" class="btn botonCarta">ver cuadro</a>
                  <?php

                }else{

                  //echo $rowqueryProductos['id_producto'];
                  $cuadros[] += $rowqueryProductos['id_producto'];
                  $orden[] += $rowqueryProductos['orden_producto'];
                  ?>                  
                  <a id="a<?php echo $rowqueryProductos['id_producto']?>" href="vercuadro2.php?ident=<?php echo $rowqueryProductos['id_producto']?>&conte=<?php echo "$conte";?>" class="btn botonCarta">ver cuadro</a>
                  <?php
                }

                ?>
                <div class="tooltipCustom" id="n<?php echo $rowqueryProductos['id_producto']; ?>" onclick="agrega(this.id +' '+<?php echo "$idProducto"?>)">

              <i style="position: absolute; right: 0px; bottom: 0px;" class="fas fa-shopping-cart carritoCarta"></i>
              <span class="tooltiptext">Añade a la Cesta</span>
            </div>
          </div>

        </div>
      </div>
      
    
        
<?php 
        //$like++; 
        $contador++; $conte++;
    }
    //print_r($pagPrecios);
?> 
    </div>

    <div class="col-md-12 col-lg-1 R3"></div>
  </div>
</div>

<!-- compaginacion -->
    <nav aria-label="compaginacion" class="navPaginas">
        <ul class="pagination pagination-md pagBtns" style="">
<?php     
    $i=1;
    $suma = "";
    while ($i <= $numPaginas){
        if ($i == $page){
            ?>
            <li class="page-item active" aria-current="page"><a class="page-link"><?php echo $page; ?></a></li>
            <?php
        }else{
            ?>
            <li class="page-item" aria-current="page"><a class="page-link" href="productos.php?pag=<?php echo $i?>"><?php echo $i; ?></a></li>
            <?php
        }  
    $i++;
    }
?>
        </ul>
    </nav>  

<style type="text/css">

</style>

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
 <!--  <script  type="text/javascript" src="assets/js/popper.min.js"></script> -->
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

//GO MAIN
function main(){
  window.location = "main.php";
}

//console.log(search);

// EN QUE PAGINA ESTA EL CUADRO...
if(search == true){

  var nums = [];
  var ubi = [];
  var paginas = <?php echo json_encode($numPaginas); ?>;
  var totalProductos = 8 * paginas;
  var cuadros = <?php echo json_encode($cuadros); ?>;
  var orden = <?php echo json_encode($orden); ?>;
  var maximo = <?php echo json_encode($maximoProducto); ?>;
  console.log('cuadros');
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

//ubi.push(r);

  console.log(ubi);
  // BUCLE QUE PINTA LA VARIABLE GET AL ENLACE
  i=0;
  while (i<ubi.length){
    document.querySelector('#a'+cuadros[i]).href+='&pag='+ubi[i];
    i++;
  }

}

var estadoCar = false;
console.log(estadoCar);
function estadoCarrito(){
  estadoCar = true;
}

function acordion(){
  var collapseElementList = [].slice.call(document.querySelectorAll('.soloyo'))
  var collapseList = collapseElementList.map(function (collapseEl) {
    return new bootstrap.Collapse(collapseEl)
  })
}

var hayPedido = <?php echo json_encode($hayPedido); ?>;
//console.log(hayPedido);

function addProducts(){

    var formulario = document.querySelector('.bolsa');
    var cantContenido = formulario.length;
    //var contenido = formulario;
    console.log(cantContenido);
    
     if (hayPedido){
        
        Swal.fire({
          title: 'Tienes un Pedido Guardado',
          text: "¿Deseas Añadir más productos",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
          cancelButtonText: 'No, gracias!'
        }).then((result) => {
          if (result.value) {
            formulario.submit();
              return true;
          }else{
            //alert("cancel Submit");
              return false;
          }
        }) 
     }else{
         formulario.submit();
              return true;
     }
}

// BTN PEDIDO GUARDADO =================
    var btnPedido = document.querySelector('#blinkPedido');
    setInterval(function(){
      btnPedido.style.color = "purple";
      setTimeout(function(){
        btnPedido.style.color = "fuchsia";
      }, 500);
    }, 1000);

// BTN PEDIDO RUTA ==================
  var btnPedido2 = document.querySelector('#blinkPedido2');
  setInterval(function(){
    btnPedido2.style.color = "purple";
    
    setTimeout(function(){
      btnPedido2.style.color = "fuchsia";
    }, 500);
  }, 1000);


var tdosPrecios = <?php echo json_encode($pagPrecios); ?>;
console.log(tdosPrecios);

var sumaTotal = document.querySelector('#total');
    var almacen = [];
    var almacen2 =[];
  
     if (sessionStorage.getItem('almacenStorage') != null){
         almacen = JSON.parse(sessionStorage.getItem('almacenStorage'));
         cuenta();
     }

    //si hay contenido que se pinte
var formuBolsa = document.querySelector('#conteBolsa');
 
var carrillo = document.querySelector('#collapseOne');   
    if (sessionStorage.getItem('paquete') != null && sessionStorage.getItem('paquete') != "" && sessionStorage.getItem('paquete') != '<input id="haySafe" type="hidden" name="pedidoGuardado" value="true">' ){
        //var cesta =  JSON.parse(sessionStorage.getItem('paquete'));
       var cesta = sessionStorage.getItem('paquete');
        console.log(cesta);
           formuBolsa.innerHTML += cesta; 
            carrillo.classList.add("show"); 
            console.log('esto es');
            cuenta();
    }
    
//RECUPERAR EXISTENCIAS
if (sessionStorage.getItem('exist') != null && sessionStorage.getItem('exist') != ""){
    
    dataExist = JSON.parse(sessionStorage.getItem('exist'));
    almacen2 = dataExist;
    console.log(dataExist);
    
    i=0;
    while(i<dataExist.length){
        //console.log(i);
        var x = dataExist[i];
        var long = x.indexOf(' ');
        var obj = dataExist[i].substr(0,long);//id sin #
        var dat = long+1;
        var val = dataExist[i].substr(dat,2).trim();//value a colocar
        document.querySelector('#'+obj).value = val; 
        
     i++;    
    }
    
} 

 // agregamos "Hay pedido al carrito Formulario DESPUES DE QUE SE PINTE EL CONTENIDO"
   if (hayPedido){
       //alert('tenemos pedido');
       var inputHidden = "hidden";
       var verify = document.querySelector('#conteBolsa').innerHTML;
       
       if (verify.includes(inputHidden)){
           //alert('ya lo tiene');
       }else{
           //alert('vacio');
           document.querySelector('#conteBolsa').innerHTML = "<input id='haySafe' type='hidden' name='pedidoGuardado' value='true'>";
       }
   }   
        
  //FUNCION LIMPIAR
  function limpiar(){
      sessionStorage.clear(); 
      formuBolsa.innerHTML = "";
     almacen = [];
     almacen2 =[];
     cuenta();
  }

    let formu = document.querySelector('#stopi');

var hora =""; 
//funcionHora();
  function funcionHora(){
      var d = new Date();
      var n = d.getHours().toString().padStart(2, '0');
      var m = d.getMinutes().toString().padStart(2, '0');
      hora = n+':'+m;
      //console.log(hora);
  }

  var fecha = "";    
  getfecha();    
  function getfecha(){
      var y = new Date();
      var ano = y.getFullYear();
      var dia = y.getDate();
      var mes = (y.getMonth()+1).toString().padStart(2, '0');
      //console.log(ano+'-'+mes+'-'+dia);
      fecha = ano+'-'+mes+'-'+dia;
      //console.log(fecha);
  }

// VARIABLES CARRITO
var bolsaCarrito = [];

var cont = document.querySelector("#conteBolsa");
var sum1 = 1;
var datito = "";

let selector ="";

var unidades = "0";

    function cuenta(){
      unidades = almacen.length;
      console.log('unidades: '+unidades);
      sumaTotal.innerHTML = unidades;
      //alert(unidades);
      if(unidades == 0 && estadoCar == true){
        acordion();
        estadoCar = false;
        console.log('cierro acordion');
      }
    }


var instancia = 0;

 var valorInput ="";
 var idProducto ="";
 
 var idDomicilio ="";
  var press = "";
 
//RECOGER DATOS PARA EL CARRITO

    function agrega(numero){

      estadoCar = true;
    console.log(estadoCar);
        var px = numero;
        //alert(px);
        var producto = px.substr(1,2).trim();
        console.log(producto)
        idProducto = px.substr(3, 2).trim();//IDPRODUCTO
        idFIX = px.substr(3, 2).trim();
        
        console.log('soy'+producto);
        var nombreP = document.getElementById("pro"+producto).innerHTML;
        selector = nombreP.replace(/\s/g, "").toLowerCase();//Quita los espacios y covierte el nombre a LowerCase 

        console.log('selector: '+selector);

        var existe = almacen.includes(selector);
        
        if(existe){
            console.log('existe');
             
            alert("Ya esta en la cesta, indica la cantidad de existencias desde la cesta");
            document.querySelector('#'+selector).value++;//Suma al Input existencias
            
            //cantidad existencias al darle al producto
            var valorExist = document.querySelector('#'+selector);
            var totali = valorExist.value;
            var ubi ="";
            i=0;
            while(i<almacen2.length){
                
                if(almacen2[i].includes(selector)){
                    ubi = i;
                }
                
             i++;
            }
            
            almacen2[ubi] = selector+' '+totali;
            
            sessionStorage.setItem('exist', JSON.stringify(almacen2));  
            console.log(almacen2);
            location.href = "#accordionExample"; 
            
        }else{
            console.log('NO existe');
            almacen.push(selector);

            sessionStorage.setItem('almacenStorage', JSON.stringify(almacen));
             
            instancia++;
            var x = document.createElement("div");
            x.setAttribute('id', 'ka'+instancia);
            x.setAttribute('class', 'productosCarrito');
            cont.appendChild(x);
            
            // RECOJO EL PRECIO DEL FETCH
             var idfecth = idProducto++;
            
            let nuevoPrecio = document.querySelector('#pre'+producto).innerHTML;
            console.log('precio: '+ nuevoPrecio);
            funcionHora();
            console.log('prueba '+press);
            x.innerHTML += '<div id="del'+selector+'" style = "display: flex; align-items: center;"><label style="padding: 4px;">'+nombreP+'</label>&nbsp;<span style="color: lightgrey">ud</span>&nbsp;<input id="'+selector+'" onchange="numActualiza(this.id)" style="width: 45px;" type="number" min="1" max="99" value=1 name="id'+producto+'"><span style="color: lightgrey">&nbsp;&nbsp;</span><input name="precio'+producto+'" value ="'+nuevoPrecio+'" style="width: 56px;" readonly><input type="hidden" name="hora" value="'+hora+'"><input type="hidden" name="fecha" value="'+fecha+'"><button id="btn'+selector+'" onclick="out(this.id);" type="button" class="btn-close" aria-label="Close"></button></div>';
            carrillo.classList.add("show");
            
            cuenta();//cuenta ud 
            
            rescata();
            function rescata(){
                console.log('rescata');
                valorInput = document.querySelector('#'+selector).value;
            }
            
            // sessionSTORAGE
            var contenido = document.querySelector('#conteBolsa').innerHTML;
            //console.log(contenido);
            sessionStorage.setItem('paquete', contenido);

            //cantidad existencias al darle al producto NO existe
            var valorExist = document.querySelector('#'+selector);
            var totali = valorExist.value;            
            
            if (JSON.parse(sessionStorage.getItem('exist')) ==null){
                almacen2.push(selector+' '+totali);
                sessionStorage.setItem('exist', JSON.stringify(almacen2)); 
            }else{
                temporalExist = JSON.parse(sessionStorage.getItem('exist'));
                 almacen2 = temporalExist;
                 almacen2.push(selector+' '+totali);
                 sessionStorage.setItem('exist', JSON.stringify(almacen2)); 
            }
             
            console.log(almacen2); 
            location.href = "#accordionExample"; 
        }
        
        console.log(almacen);
    }

// SUMA EXISTENCIAS CUANDO LE DAS AL INPUT EN EL CARRITO
function numActualiza(sujeto){
    var valorExis = document.querySelector('#'+sujeto);
    var total = valorExis.value;
    //alert(sujeto+' '+total);
    
    var ubi ="";
    i=0;
    while(i<almacen2.length){
                
        if(almacen2[i].includes(sujeto)){
            ubi = i;
        }
                
     i++;
    }
            
    almacen2[ubi] = sujeto+' '+total;
    sessionStorage.setItem('exist', JSON.stringify(almacen2));  
    //console.log(almacen2);

  if(total < 1){
    document.querySelector('#'+sujeto).value = 1
    //alert('valores solo entre 1 y 20');

    Swal.fire({
        title: 'valores solo entre 1 y 20!',
        text: '',
        icon: 'error',
        confirmButtonText: 'Continuar',
        customClass: {     
              confirmButton: 'confirmSweet',
              title: 'titleSweet'
            },
      })

  }else if(total > 20){
    document.querySelector('#'+sujeto).value = 20
     //alert('valores solo entre 1 y 20');
     Swal.fire({
        title: 'valores solo entre 1 y 20!',
        text: '',
        icon: 'error',
        confirmButtonText: 'Continuar',
        customClass: {     
              confirmButton: 'confirmSweet',
              title: 'titleSweet'
            },
      })
  }
    


}

// FUNCTION QUE ELIMINA 
    function out(producto){
        console.log('entra');
        
        let x = producto.toString();
        let ncut = x.length;
        let idd = x.substr(3,ncut);
        
            //ELIMINAR DEL ARRAY EXISTENCIAS ANTES DE Q SE BORRE TDO SINO DE DONDE SACO EL VALOR =)
            //var valorExis = document.querySelector('#'+idd);
            //var total = valorExis.value;
            //console.log(almacen2);
            var ubi ="";
            
            j=0;
            while(j < almacen2.length){
                //console.log(almacen2[j]);
                var x2 = almacen2[j];
                var long2 = x2.indexOf(' ');
                var obj2 = almacen2[j].substr(0,long2);//id sin #

               if(obj2 == idd){
                    ubi = j;
                }
             j++;
            }
            console.log(ubi);
            console.log('fin del bucle');
            almacen2.splice(ubi,1);
            console.log(almacen2);
            console.log('despues del splice');
            sessionStorage.setItem('exist', JSON.stringify(almacen2));
        
        //ELIMINA EL PRODUCTO DEL CARRITO FRONT
        console.log(idd);
        var pilla = document.querySelector('#del'+idd);
        
        var borraValor = document.querySelector('#'+idd).value;
        unidades =  unidades - borraValor;
        console.log(borraValor);
        //sumaTotal.innerHTML = unidades;

        //document.querySelector('#del'+idd).remove();
        var quien = pilla.parentNode.getAttribute("id");
        document.querySelector('#'+quien).remove();
        console.log(quien);
        
        let posi = almacen.indexOf(selector);
        //console.log('La pos es: '+posi);
        
        almacen.splice(posi,1);
         console.log(almacen);
        sessionStorage.removeItem('almacenStorage');
         
        sessionStorage.setItem('almacenStorage', JSON.stringify(almacen));
         
        //redeclara Storage
        var retry = document.querySelector('#conteBolsa').innerHTML;
        var ajusta = retry.trim();
        console.log(ajusta);
        sessionStorage.removeItem('paquete');
        sessionStorage.setItem('paquete', ajusta);
        cuenta();
    }

  //Recojo los datos de la base de datos y pinto los likes con front
var name = <?php echo json_encode($nombre); ?>

//PROBANDO PARA LOCALHOST

fetch('https://loscuadrosderita.com/web/apis/likes1.app.php?like='+name) 
    .then(response => response.json())
  .then(function(data){
//console.log(data);
    
  });
console.log(conteEstados);


var name = "<?php echo $nombre ?>";
var id = "<?php echo $id ?>";

//funcion que pinta si haces click y envia datos fetch al archivolikes 2 el cual actualiza o inserta en la db
    function funcLike(evento){
      funcionHora();
    //alert(evento);
    //console.log(evento);
    let strEvento = evento.toString();
    let posicion = (strEvento.substr(4, 2)).trim();
    let num1 = strEvento.lastIndexOf(" ");
    console.log('lastINDEX: '+num1);
    let idObjeto = '#'+evento.substr(0,num1);
    console.log(idObjeto);
    console.log(posicion);
    let producto = strEvento.substr((num1+1), 2);
    console.log(producto);
    let yo = document.querySelector(idObjeto);
    
        if (conteEstados[posicion] == false){
            console.log('entra false');
        
            yo.style.color = 'purple';
            yo.className = 'fas fa-heart likeCard';
            conteEstados[posicion] = true;
            console.log(conteEstados);
            console.log(id);
            console.log('producto: '+producto);
            console.log(name);
        
            fetch('https://loscuadrosderita.com/demo/apis/likes2.app.php?id='+id+'&prod='+producto+'&nombre='+name+'&fecha='+fecha+'&hora='+hora+'&accion=1');

            //window.location = 'productos.php?pag=1&var=dust1';

            //localhost/web/apis/likes2.app.php?id=3&prod=2&nombre=Yucsan&fecha=2021-04-02&hora=17:19&accion=1
            // EN LOCAL NO VA FETCH ---> USAR DIRECTAMENTE EN EL NAVEGADOR

        }else if(conteEstados[posicion] == true){
            console.log('entra true');
        
            yo.style.color = 'gray';
            yo.className = 'far fa-heart likeCard';

            conteEstados[posicion] = false;
            console.log(conteEstados);
            console.log(id);
            console.log(producto);
            console.log(name);

            fetch('https://loscuadrosderita.com/demo/apis/likes2.app.php?id='+id+'&prod='+producto+'&nombre='+name+'&fecha='+fecha+'&hora='+hora+'&accion=0');

            //window.location = 'productos.php?pag=1&var=dust0';
        }

    }


function redi(){
  console.log('redirecciona');
  //window.location = 'https://www.w3schools.com';
  //window.open("https://www.w3schools.com"); 
}

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


var agregarProducto = <?php echo json_encode($idAgrega); ?>;
//var conteAdd = <?php //echo json_encode($conteAdd); ?>;

// como jode el "0"
//if(conteAdd == 'cero'){
  //conteAdd = 0;
//}

//console.log('conteADD: '+conteAdd);
console.log('agrega: '+agregarProducto);

if (verCuadros == true){
  agrega('n'+agregarProducto+' '+agregarProducto);
}



</script>
  

</body>
</html>