<?php

    session_start();

  if (!isset($_SESSION['idUsu']) || $_SESSION['rolUsu'] != 'Admin') {
    header('Location: index.php');
  }

  require '../includes/conexion.inc.php';
  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];  

  if($_GET){
    
    $ordenar = $_GET['neworder'];

    $nuevoArray = explode("," , $ordenar);
    $nuevoArray2 = array();

      foreach ($nuevoArray as $key => $value) {
        $nuevoArray2[$key+1]=$value;
      }
      //print_r($nuevoArray2);
      
      foreach ($nuevoArray2 as $key => $valor) {
        
        $sqlActualiza = " 

              UPDATE producto
                SET orden_producto = '".$key."'
                  WHERE id_producto LIKE '".$valor."';
        ";
        $queryActualiza = mysqli_query($conectar, $sqlActualiza);

      }


  }else{

  }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="icon/png" href="favicon.png">
	<title>Orden_Productos</title>
</head>
<body>

 <style type="text/css">


</style>
 

  <!-- BARRA DE NAVEGACION -->
<nav class="navbar navbar-expand-lg navbar-light bakcolor">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img class="title" src="assets/rsc/img/logoalpha.gif"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul style="" class="navbar-nav me-auto mb-2 mb-lg-0 dcomand">
        <li class="nav-item">
          <a class="nav-link" href="main.php">Principal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">Specs-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active">Orden-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pedidos.php">Pedidos</a>
        </li>

        <!-- avatar nav-->
        <li class="nav-item dropdown avatar">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span style="color:snow;"><?php echo $nombre;?></span>
            <img class="avatarPic" style="" src="../<?php echo $fotito;?>" alt="Usuario">
          </a>
          <ul class="dropdown-menu avSession" aria-labelledby="navbarDropdownMenuLink">
            <!-- <li class="dropdown-item">Nombre Usu</li>
            <li><a class="dropdown-item" href="#">Configuracion</a></li>
            <li><hr class="dropdown-divider"></li> -->
            <li><a class="dropdown-item" href="../cerrar.php">Cerrar Session</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid dashboard-content ">
  <!-- ============================================================== -->
  <!-- Titulo y Desplegable Crear Usuarios  -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background: #f7f7f7; padding-bottom: 35px;">
      <div class="page-header pageHeader" style="">
        <h2 class="pageheader-title" style="color: var(--darkm);">Orden de Productos</h2>
        <p class="pageheader-text" style="color: gray">Arrastra y ordena los productos en el orden deseado, al finalizar debes hacer click en el boton de "Aplicar Nuevo Orden" o no se realizará el cambio</p>
          <ul id="sortable">

            <?php 
            // SQL PRODUCTOS
            $pinta = array();
            $lista = 1;
            $cuentaExistencias = array();
            $relacion = [];
            $sqlProdu = "
                        SELECT * 
                            FROM producto
                            ORDER BY orden_producto ASC;
                          ";
            
             $queryProdu = mysqli_query($conectar, $sqlProdu);             
             while ($rowqueryProdu = mysqli_fetch_assoc($queryProdu)){

              $cuentaExistencias[] += $rowqueryProdu['orden_producto'];

              $relacion[$rowqueryProdu['id_producto']] = $rowqueryProdu['orden_producto'];

                $pinta[] = $rowqueryProdu['orden_producto'];
            ?>

            <li id="<?php echo $rowqueryProdu['id_producto'];?>" class="ui-state-default car">
              <div id="<?php echo $rowqueryProdu['id_producto'];?>" class="title_carta" style="">
                <span class="nProd" style=""><?php echo $rowqueryProdu['id_producto'];?>:&nbsp;&nbsp;</span><?php echo $rowqueryProdu['nombre_producto']." - ".$rowqueryProdu['orden_producto'];?>
              </div>
              <div class="imgConteCarta" style="">
                <img class="imgCarta" style="" src="../<?php echo $rowqueryProdu['foto_producto']; ?>">
              </div>  
            </li>

            <?php 
              $lista++;
             }

            ?>

          </ul>

      </div>
    </div>
  </div>

</div>
<?php 
       
//print_r($pinta);
 ?>

<div style="background: #f7f7f7; text-align: center; padding-bottom: 35px;">
  <button onclick="nuevoOrden();" class="btn" style="background: darkorange; color: #312b2b;">Aplicar Nuevo Orden</button>
</div>

<footer>
  <div class="copiRight" style="color:white">
    <div style="padding: 25px; background: var(--darkm);">
      <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
  </div>
</footer>



  <script type="text/javascript" src="assets/vendor/jquery/jquery_3.6.0.min.js"></script>
  <script type="text/javascript" src="assets/js/popper.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/vendor/jqueryUI/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="assets/vendor/jqueryUITouchPunch/jquery.ui.touch-punch.min.js"></script>
  <script type="text/javascript" src="assets/vendor/chartjs/Chart.js"></script>
  <script type="text/javascript" src="assets/vendor/chartjs/utils.js"></script>
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script type="text/javascript">



  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );

var numProductos = <?php echo json_encode(max($cuentaExistencias)); ?>;
var reorden =[];

function nuevoOrden(){
  //alert(numProductos);

var lnx = $('#sortable li');

/*
for (let i = 0; i < lnx.length; i++) {
  var txt = lnx[i].innerHTML='hey'+i;
  // Log results on each iteration
  console.log(txt + '\n');
}*/
 
  var es = document.querySelectorAll('#sortable li');
  i=0;
  while(i < es.length){
    data = es[i].getAttribute('id');
    reorden.push(data);
    i++;
  }
  
  //console.log(reorden);
  alert(reorden);
  window.location = 'ordenprod.php?neworder='+reorden;

}



  </script>



</body>
</html>