<?php
    session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	  $nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];
    
     $idPedido ="";
  
    if($_POST){

      $sqlProductos ="
        SELECT *
          FROM producto;
      ";
      $queryProductos = mysqli_query($conectar, $sqlProductos);
   
      $productos = array();
         while ($rowProd = mysqli_fetch_assoc($queryProductos)){

          $idProd = $rowProd['id_producto'];
          if (array_key_exists($idProd, $_POST)){
              $productos[$idProd] = $_POST[$idProd];
          }
         }
      $suma = array_sum($productos);
         //echo "<br>";
      //$suma = count($productos);
      //echo "<br>";
      //print_r($productos);          
      //echo "<br>";
      //print_r($_POST);

      if((isset($_POST['direccion']) && !empty($_POST['direccion'])) && (isset($_POST['codigoPostal']) && !empty($_POST['codigoPostal'])) && (isset($_POST['pais']) && !empty($_POST['pais'])) && (isset($_POST['provincia']) && !empty($_POST['provincia'])) && (isset($_POST['distrito']) && (isset($_POST['codigoPostal'])&& !empty($_POST['codigoPostal'])) && !empty($_POST['distrito'])) && (isset($_POST['numero']) && !empty($_POST['numero'])) && (isset($_POST['planta']) && !empty($_POST['planta'])) && (isset($_POST['puerta'])&& !empty($_POST['puerta'])) && (isset($_POST['escalera'])&& !empty($_POST['escalera'])) && (isset($_POST['portal'])&& !empty($_POST['portal'])) ){


        $direccion = $_POST['direccion'];
        $codigoPostal = $_POST['codigoPostal'];
        $pais = $_POST['pais'];
        $provincia = $_POST['provincia'];
        $distrito = $_POST['distrito'];
        $numero = $_POST['numero'];
        $planta = $_POST['planta'];
        $puerta = $_POST['puerta'];
        $escalera = $_POST['escalera'];
        $portal = $_POST['portal'];
        $hora = $_POST['hora'];
        $fecha = $_POST['fecha'];
        $idDireccion ="";


        // INSERTA DIRECCION
        $sqlNuevaDireccion = "
            INSERT INTO direccion
              VALUES (null, '".$direccion."','".$numero."','".$portal."','".$planta."','".$puerta."','".$escalera."','".$distrito."','".$provincia."','".$pais."', '".$codigoPostal."');
        ";
        $queryNuevaDireccion = mysqli_query($conectar, $sqlNuevaDireccion);

   
        if (!$queryNuevaDireccion){
            echo "Ocurrió un error inesperado. Inténtelo más tarde 1";
        }else{
        
           // RESCATA id Direccion
          $sqlIdDireccion = "
              SELECT id_direccion
                  FROM direccion
                    WHERE nombre_direccion LIKE '".$direccion."' && numero_direccion LIKE '".$numero."';
          ";
                  
          $queryIdDireccion = mysqli_query($conectar, $sqlIdDireccion);
          while ($rowDireccion = mysqli_fetch_assoc($queryIdDireccion)){

            $idDireccion = $rowDireccion['id_direccion'];

          }
       
      
           // INSERTA Domicilio
             $sqlDomicilio ="
                     INSERT INTO domicilio
                       VALUES (null, '".$id."', '".$idDireccion."', 'Facturación y entrega');
             ";
                            
              $queryDomicilio = mysqli_query($conectar, $sqlDomicilio);

            //RESCATAR Id Domicilio 
            $idDomicilio ="";
            
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
            
            // si el pedido son mas de 1 se va pintar el maximo xq esta en bucle y tiene = NO +=              
            $idpedidoActual = $idPedido;

            //recojo PRECIOS Y PRODUCTOS para insertarlo en compra
            $preciosPro = array();
            $sqlpyP ="
              SELECT id_producto, precio_producto
                  FROM producto;
            ";
            $querypyP = mysqli_query($conectar, $sqlpyP);
            while ($rowpyP = mysqli_fetch_assoc($querypyP)){
              $preciosPro[$rowpyP['id_producto']] = $rowpyP['precio_producto'];
            }


            //INSERTO LA COMPRA
             foreach($productos as $key => $valor){
               //echo "Insert: ".$valor."<br>";

                $sqlCompra = "
                    INSERT INTO compra
                    VALUES (null, 'tarjeta', '".$preciosPro[$key]."', '".$idpedidoActual."', '".$key."', '".$valor."', '1');
                ";
                $queryCompra = mysqli_query($conectar,$sqlCompra);
                // ESTO ES MAGIAAAAAAAA
            }
   

        }
  
    

      
      }else{
        header('Location: productos.php?pag=1&falta=yes');
      }

    }else{
      header('Location: productos.php?pag=1');
    }
 
    
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
  </ul>
</div> 
<section  style="display: flex; justify-content: center; background: none;">
    <ul class="list-group ulPedido" style="width: 70%; margin-top: 20px;">
    <div class="table-responsive" style="background: #f9f7f7;">
      <h5 style="text-align: center;" class="card-header">Productos</h5>
      <table class="table">
        <thead style="background: #7d777d;  color: snow;">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Unidades</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>
        <tbody>
<?php
 $sqlProductos2 ="
        SELECT *
          FROM producto;
      ";
      $queryProductos2 = mysqli_query($conectar, $sqlProductos2);
  $i=1;
   while ($rowProd2 = mysqli_fetch_assoc($queryProductos2)){

          $idProd2 = $rowProd2['id_producto'];
          if (array_key_exists($idProd2, $_POST)){
            //echo $rowProd['nombre_producto'];
            //echo "<br>";

?>  

          <tr>
            <th scope="row"><?php echo $i;?></th>
            <td>
              <div style="display:flex">
                <img src="<?php echo $rowProd2['foto_producto'];?>" style="width: 70px;">
                <span style="margin-left: 8px;"><?php echo $rowProd2['nombre_producto'];?></span>
              </div>
            </td>
            <td><?php echo $_POST[$idProd2];?></td>
            <td>S/.<?php echo $rowProd2['precio_producto'];?></td>
          </tr>

<?php
            $i++;
          }
        }
?>
        </tbody>
      </table>
    </div>
  </ul>
</section>

<style type="text/css">

</style>

<div class="conteBotones">

      <form method="POST" action="tarjeta.php" name="pgotarjeta">
          <input type="hidden" name="pedido" value="<?php echo $idPedido; ?>">
          <button class="btntarjeta" type="submit">Pago con tarjeta <i class="fas fa-credit-card"></i></button>
      </form> 

      <a class="btntarjeta btnsP" href="pcentrega.php?pedido=<?php echo $idPedido; ?>">Pago contra entrega</a>
</div>
	<noscript>Debes activar JavaScript</noscript>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">




//TOOLTIPS
    var idPedido = <?php echo json_encode($idPedido); ?>;
    //alert(idPedido);
    function pago(){
         
        fetch('https://loscuadrosderita.com/demo/apis/pago.app.php?pay='+idPedido)
        alert('Pago Realizado con Exito');
        window.location.href = "main.php?gracias=1";
    }	


function redi(){
  console.log('redirecciona');
  //window.location = 'https://www.w3schools.com';
  //window.open("https://www.w3schools.com"); 
}




	</script>
	






</body>
</html>