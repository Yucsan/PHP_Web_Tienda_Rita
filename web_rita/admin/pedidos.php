<?php

  session_start();

  if (!isset($_SESSION['idUsu']) || $_SESSION['rolUsu'] != 'Admin') {
    header('Location: index.php');
  }

  require '../includes/conexion.inc.php';
    
  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];


  if($_POST){
   
    //ESTADO COMPRA PAGADO O SIN PAGAR
     $idUsu = $_POST['idusu'];
     //echo "<br>";
     $idpedido = $_POST['idp'];
     //echo "<br>";
     $accion = $_POST['accion']; 
    
    $sqlEstadoCompra ="
      UPDATE compra
        SET id_estado = '".$accion."'
          WHERE id_pedido LIKE '".$idpedido."'
    ";
    $queryEstadoCompra = mysqli_query($conectar, $sqlEstadoCompra);
   
  }


  if($_GET){
    if(isset($_GET['archivar'])){
      $idped = $_GET['id']; 
      
      $sqlArchivar ="
      UPDATE pedido
        SET estado_pedido = 'fin'
          WHERE id_pedido LIKE '".$idped."'
      ";
      $queryArchivar = mysqli_query($conectar, $sqlArchivar);

    }else if(isset($_GET['eliminar'])){

      $idped2 = $_GET['id']; 

      $sqlElimina ="
      UPDATE pedido
        SET estado_pedido = 'eliminado'
          WHERE id_pedido LIKE '".$idped2."'
      ";
      $queryElimina = mysqli_query($conectar, $sqlElimina);
    }
    

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
	<title>Pedidos</title>
</head>
<body class="fondillo">
 <div class="body3">

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
          <a class="nav-link" href="ordenprod.php">Orden-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active">Pedidos</a>
        </li>
        <li class="nav-item dropdown avatar">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span style="color:snow;"><?php echo $nombre;?></span>
            <img class="avatarPic" src="../<?php echo $fotito;?>" alt="Usuario">
          </a>
          <ul class="dropdown-menu avSession" aria-labelledby="navbarDropdownMenuLink">
            <!-- <li class="dropdown-item"></li> -->
            <!-- <li><a class="dropdown-item" href="#">Configuracion</a></li>
            <li><hr class="dropdown-divider"></li> -->
            <li><a class="dropdown-item" href="../cerrar.php">Cerrar Session</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>





<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
  <div class="card tabla1" style="margin: 15px;">
    <h5 class="card-header">Pedidos</h5>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table">
          <thead class="tabla1_head">
            <tr class="border-0">
              <th class="border-0">#Pedido</th>
              <th class="border-0">Correo</th>
              <th class="border-0">Nombre</th>
              <th class="border-0">Proceso</th>
              <th class="border-0">Pago con:</th>
              <th class="border-0">Ver Pedido</th>
              <th class="border-0">Fecha</th>
              <th class="border-0">Hora</th>
              <th class="border-0">Estado</th>
              <th class="border-0">Accion</th>
            </tr>
          </thead>
          <tbody>
            <?php
            
            $sqlPedidos ="
              SELECT * 
                FROM pedido
                  JOIN domicilio USING (id_domicilio)
                  JOIN usuario USING (id_usuario)
                  JOIN direccion USING (id_direccion)
                  JOIN compra USING (id_pedido)
                  WHERE estado_pedido NOT LIKE 'fin' AND estado_pedido NOT LIKE 'guardado' AND estado_pedido NOT LIKE 'eliminado'
                  GROUP BY id_pedido;
            ";
            $queryPedidos = mysqli_query($conectar, $sqlPedidos);
              while ($rowPedidos = mysqli_fetch_assoc($queryPedidos)) {
             
            ?>
            <tr>
              <td><?php echo $rowPedidos['id_pedido']?></td>
              <td class="letraM"><?php echo $rowPedidos['correo_usuario']?></td>
              <td class="tam14C"><?php echo $rowPedidos['nombre_usuario']?></td>
              <td class="tam14"><?php echo $rowPedidos['estado_pedido']?></td>
              <td class="tam14">
                <?php
                  if($rowPedidos['forma_pago_compra'] != 'tarjeta'){
                    ?>
                    <ul style="list-style: none">
                      <li style="color:green">Contra Entrega</li>
                      <li><span class="letraG2">telefono: </span><span class="letraN2"><?php echo $rowPedidos['comentario_pedido']?></span></li>                  
                    </ul>
                    <?php
                    }else{
                      echo "Tarjeta";
                    }                  
                ?>                
              </td>             
              <td class="tam14"><a data-toggle="modal" data-target="#exampleModal<?php echo $rowPedidos['id_pedido']?>" href="">Ver Pedido</td>
              <td><?php echo $rowPedidos['fecha_pedido']?></td>
              <td class="tam14"><?php echo $rowPedidos['hora_pedido']?></td>
              <td>
                <form class="formEstado" method="POST" action="" name="responder">
                  <div class="form-group">
    
 
                      <?php
                      if($rowPedidos['id_estado'] == 1){
                        ?>
                        <ul style="list-style: none;">
                          <li><input type="hidden" name="idusu" value="<?php echo $rowPedidos['id_usuario'];?>"></li>
                          <li><input type="hidden" name="idp" value="<?php echo $rowPedidos['id_pedido'];?>"></li>
                          <li><label style="color:red;">Sin pagar</label><input type="radio" name="accion" checked required required value="1"></li>
                          <li><label style="color:green;">Pagado</label><input type="radio" name="accion" required required value="2"></li>
                        </ul>
                        <?php
                      }else{
                        ?>
                        <ul style="list-style: none;">
                          <li><input type="hidden" name="idusu" value="<?php echo $rowPedidos['id_usuario'];?>"></li>
                          <li><input type="hidden" name="idp" value="<?php echo $rowPedidos['id_pedido'];?>"></li>
                          <li><label style="color:red;">Sin pagar</label><input type="radio" name="accion" required required value="1"></li>
                          <li><label style="color:green;">Pagado</label><input type="radio" name="accion" checked required required value="2"></li>
                        </ul> 
                        <?php
                      }
                      ?>                      

                  </div>
                  <button class="btnAply" name="estado" type="submit">Aplicar</button>
                </form>
              </td>              
              <td class="tam14">
                <ul style="list-style: none">
                  <li><a class='desac' href="?id=<?php echo $rowPedidos['id_pedido'];?>&archivar=yes">Archivar</a></li>
                  <li><a class='borrar' href="?id=<?php echo $rowPedidos['id_pedido'];?>&eliminar=yes">Eliminar</a></li>
                </ul>
              </td>
           </tr>
           <!-- MODAL VER PEDIDO-->
                  <div class="modal fade" id="exampleModal<?php echo $rowPedidos['id_pedido']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Pedido: <?php echo $rowPedidos['nombre_usuario']?><span style="color:purple;"></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php
                        $pedido = $rowPedidos['id_pedido'];
                        $sqlcompra="
                          SELECT *
                            FROM compra
                              JOIN producto USING (id_producto)
                               WHERE id_pedido LIKE '".$pedido."';
                        ";
                        $queryCompra = mysqli_query($conectar, $sqlcompra);
                        while($rowCompra = mysqli_fetch_assoc($queryCompra)){

                        ?>
                        <div class="modalPedido">
                         <img style="width: 100px;" src="../<?php echo $rowCompra['foto_producto'] ?>">
                         <span class="letraG2" style="margin-left: 10px;">Nombre" <span class="letraM2"><?php echo $rowCompra['nombre_producto'] ?></span> </span>
                         <span class="letraG">unids: <span class="letraN2"><?php echo $rowCompra['cantidad_compra'] ?></span></span> 
                        </div>
                        <?php
                          }
                        ?>
                        <div class="modal-body">
                          <span class="letraG2">Dirección: <span class="letraN2"><?php echo $rowPedidos['nombre_direccion']?></span> </span>
                          <div>
                            <span class="letraG2">N: <span class="letraN2"><?php echo $rowPedidos['numero_direccion']?></span> </span> <span class="letraG2">Portal: <span class="letraN2"><?php echo $rowPedidos['portal_direccion']?></span> </span>
                          </div>
                          <div>
                            <span class="letraG2">Puerta: <span class="letraN2"><?php echo $rowPedidos['puerta_direccion']?></span> </span> <span class="letraG2">Planta: <span class="letraN2"><?php echo $rowPedidos['planta_direccion']?></span> </span>
                            <span class="letraG2">Escalera: <span class="letraN2"><?php echo $rowPedidos['escalera_direccion']?></span> </span>
                          </div>
                          <div>
                            <div class="letraG2">Distrito: <span class="letraN2"><?php echo $rowPedidos['distrito_direccion']?></span></div>
                            <div class="letraG2">Provincia: <span class="letraN2"><?php echo $rowPedidos['provincia_direccion']?></span></div>
                            <div class="letraG2">Pais: <span class="letraN2"><?php echo $rowPedidos['pais_direccion']?></span></div>
                            <div class="letraG2">Codigo Postal: <span class="letraN2"><?php echo $rowPedidos['codigopostal_direccion']?></span></div>
                          </div>
                        </div>  
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                          
                        </div>
                      </div>
                    </div>
                  </div>  
           <?php
                
              }
           ?>
         </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<style type="text/css">

  .modalPedido{
    padding: 10px;

  }

  .desac{ color: deeppink; }
  .desac:hover{ color: tomato; }

  .borrar{ color: indigo; }
  .borrar:hover{ color: black; }

  .btn_res{

  }

  .rModal{
    width: 100%;
    border-radius: 10px;
    border: none;
    background: #f2e4ff;
    width: 100%; 
    height: 70px;
    margin-bottom: 5px; 
  }

  .formRespuesta{
    display: flex;
    flex-direction: column;
  }

  .btnAply{
    background: blueviolet;
    padding: 5px;
    border:none;
    border-radius: 10px;
    color: snow;
    width: 100px;
    margin-top: 8px;
  }

  .resp{
    padding: 3px;
    border-radius: 6px;
    border: solid 1px gray;
  }

  .letraM{
    font-size: 16px;
    color: blueviolet;
  }

  .letraM2{
    font-size: 18px;
    color: blueviolet;
  }
  .letraG{
    font-size: 14px;
    color: gray;
  }

  .letraN{
    font-size: 14px;
    color: black;
  }
  .letraG2{
    font-size: 16px;
    color: gray;
  }

  .letraN2{
    font-size: 16px;
    color: black;
  }
  .tam14C{
    /*font-size: 14px;*/
    text-transform: capitalize;
  }

  .imgTabla{
    border-radius: .25rem !important;
    width: 45px; 
    height: 45px; 
    object-fit: cover;
  }


</style> 

</div>

<div class="push"></div>
<footer class="footer2">
  <div class="copiRight" style="color:white">
    <div style="padding: 25px; background: var(--darkm);">
      <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
  </div>
</footer>





<script type="text/javascript" src="assets/vendor/jquery/jquery_3.6.0.min.js"></script>
<script type="text/javascript" src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/vendor/chartjs/Chart.js"></script>
<script src="assets/vendor/chartjs/utils.js"></script>
<script type="text/javascript">

 




</script>



</body>
</html>