<?php

session_start();

if (!isset($_SESSION['idUsu']) || $_SESSION['rolUsu'] != 'Admin') {
  header('Location: index.php');
}

require '../includes/conexion.inc.php';

  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];

  echo "<script>var activa = false; var scroller = false; var scrollProducto = false; var colu = ''; var scrollBorra = false;</script>";




// FUNCTION QUE VUELVE A CARGAR LOS PRODUCTOS
function prots(){
 require '../includes/conexion.inc.php';
   
    $sqlProdu = "
      SELECT * 
      FROM producto
      JOIN material USING (id_producto)
      JOIN estilo USING (id_estilo)
      ORDER BY orden_producto ASC;
    ";
  $queryProdu = mysqli_query($conectar, $sqlProdu); 

  return $queryProdu;
}


// CANTIDAD TOTAL
$enTotal = contador();
//print_r($enTotal);

function contador(){
  require '../includes/conexion.inc.php';

  $somos="";
    $sqlCounter ="
      SELECT COUNT(id_producto) AS 'totales'
        FROM producto;
    ";
    $queryCount = mysqli_query($conectar, $sqlCounter);
     while ($rowqueryCount = mysqli_fetch_assoc($queryCount)){
             $somos = $rowqueryCount['totales'];
           }
    return $somos;
}

//VARIABLE CANTIDAD
$cantidadTotal ="";
  $sqlCounter ="
    SELECT COUNT(id_producto) AS 'totale'
      FROM producto;
  ";
  $queryCount = mysqli_query($conectar, $sqlCounter);
   while ($rowqueryCount = mysqli_fetch_assoc($queryCount)){
     $cantidadTotal =$rowqueryCount['totale'];
   }
           


if ($_POST) {
      //CAMBIAR FOTO
      if(isset($_POST['picture'])){
        $idProdu = $_POST['idProducto'];
        if ($_FILES['fotoChange']['type'] == "image/jpeg" || $_FILES['fotoChange']['type'] == "image/png"){
             if ($_FILES['fotoChange']['size'] <= 2097152){
                $fotoFinal = "../assets/rsc/img2/".$_FILES['fotoChange']['name'];
                $nuevaRuta = "assets/rsc/img2/".$_FILES['fotoChange']['name'];
                move_uploaded_file($_FILES['fotoChange']['tmp_name'], $fotoFinal);
                if(file_exists('../'.$_POST['pastFoto']) && (('../'.$_POST['pastFoto'])!= $fotoFinal)){
                  if($_POST['pastFoto'] == 'assets/rsc/img2/nofoto.jpg'){
                    echo "No borrar";
                  }else{
                   unlink('../'.$_POST['pastFoto']);//BORRA LA FOTO PASADA Si existe 
                  } 
                }
                //echo "Foto Subida";
                  $sqlActualizaFoto = "
                     UPDATE producto
                            SET foto_producto = '". $nuevaRuta."'
                            WHERE id_producto LIKE ".$idProdu.";
                  ";
                  $queryActualizaFoto = mysqli_query($conectar, $sqlActualizaFoto);
                  echo "<script>colu = ".$idProdu."; scrollProducto = true;</script>";
                  include 'includes/exitofoto.html';
                  //VUELVO A CAGAR LOS PRODUCTOS LUEGO DE ACTUALIZAR FOTO
                  $queryProdu = prots();
             }else{
                echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> El archivo es demasiado grande, reduce su tamaño a 2mb como Máximo! </div>";
                $queryProdu = prots();
             }
        }else{
          echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> Solo puede subir .JPG ó .PNG! </div>";
          $queryProdu = prots();
        }
      //ACTUALIZA PRODUCTOS  
      }else if(isset($_POST['specs'])){
             if((isset($_POST['nombreProd']) && !empty($_POST['nombreProd'])) && (isset($_POST['medidaProd']) && !empty($_POST['medidaProd'])) && (isset($_POST['precioProd'])&& !empty($_POST['precioProd']))&& (isset($_POST['materialProd']) && !empty($_POST['materialProd'])) && (isset($_POST['estilo']) && !empty($_POST['estilo'])) && (isset($_POST['infoProducto']) && !empty($_POST['infoProducto'])) && (isset($_POST['idProdSpecs']) && !empty($_POST['idProdSpecs']))){
              // ACTUALIZO LA TABLA DE PRODUCTO 
              $sqlActuProdu = "
                UPDATE producto
                  SET nombre_producto = '".$_POST['nombreProd']."',
                      medida_producto = '".$_POST['medidaProd']."',
                      precio_producto = '".$_POST['precioProd']."',
                      id_estilo = '".$_POST['estilo']."',
                      info_producto = '".$_POST['infoProducto']."'
                        WHERE id_producto LIKE ".$_POST['idProdSpecs'].";
              ";
              $queryActuProdu = mysqli_query($conectar, $sqlActuProdu);
              // ACTUALIZO LA TABLA DE MATERIAL
              $sqlActuMate ="
                UPDATE material
                  SET nombre_material = '".$_POST['materialProd']."'
                  WHERE id_producto LIKE ".$_POST['idProdSpecs'].";
              ";
               $queryActuMate = mysqli_query($conectar, $sqlActuMate);
               echo "<script>window.location = '#columna".$_POST['idProdSpecs']."' </script>";
              //VUELVO A CAGAR LOS PRODUCTOS LUEGO DE ACTUALIZAR SPECS
               $queryProdu = prots();
             }else{
               echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> Debes rellenar todos los campos! </div>";
                $queryProdu = prots();
             }
      // AGREGA NUEVO PRODUCTO                     
      }else if(isset($_POST['AddNew'])){
        if(isset($_POST['nombreAgrega']) && !empty($_POST['nombreAgrega']) && (isset($_POST['medidaAgrega']) && !empty($_POST['precioAgrega'])) && (isset($_POST['precioAgrega']) && !empty($_POST['medidaAgrega'])) && (isset($_POST['materialesAgrega']) && !empty($_POST['materialesAgrega'])) && (isset($_POST['estiloNuevoAdd']) && !empty($_POST['estiloNuevoAdd'])) && (isset($_POST['addInfoProducto']) && !empty($_POST['addInfoProducto']))){
          $nuevoNombre = $_POST['nombreAgrega'];         
          $nuevaMedida = $_POST['medidaAgrega'];      
          $nuevoPrecio = $_POST['precioAgrega'];
          $nuevoMaterial = $_POST['materialesAgrega'];
          $nuevoEstilo = $_POST['estiloNuevoAdd'];
          $nuevaInfo = $_POST['addInfoProducto'];
          $countProd = "";
          $sqlCantidad ="
            SELECT COUNT(id_producto) AS 'total'
              FROM producto;
          ";
          $queryCantidad = mysqli_query($conectar, $sqlCantidad);
          while ($rowqueryCantidad = mysqli_fetch_assoc($queryCantidad)){
            $countProd = $rowqueryCantidad['total'];
          }
          $countProd++;
          //echo $countProd;
          $sqlAddProduct = "
            INSERT INTO producto
              VALUES (null, '".$countProd."','".$nuevoNombre."','assets/rsc/img2/nofoto.jpg','".$nuevoPrecio."','A pedido','".$nuevoEstilo."','".$nuevaMedida."','".$nuevaInfo."','','',0,0);
          ";
          $queryAddProduct = mysqli_query($conectar, $sqlAddProduct);
          $sqlAddMaterial ="
            INSERT INTO material
              VALUES (null, '".$nuevoMaterial."','".$countProd."');
          ";
          $queryAddMaterial = mysqli_query($conectar, $sqlAddMaterial);
          //VUELVO A CAGAR LOS PRODUCTOS LUEGO AGREGAR PRODUCTO
          $queryProdu = prots();
          echo "<script>var scroller = true;</script>";
          include 'includes/exitoagrega.html';
        }else{
          echo "Debes rellenar tdos los campos";
        }
      }else if(isset($_POST['borra'])){
          if(isset($_POST['productoBorrar']) && !empty($_POST['productoBorrar'])){
            echo "Borrar".$_POST['productoBorrar'];
              //BORRA MATERIAL
              $sqlBorrarM ="
                UPDATE material
                SET nombre_material = 'borrado'
                  WHERE id_producto LIKE '".$_POST['productoBorrar']."';
              ";
              $queryBorrarM = mysqli_query($conectar, $sqlBorrarM);
              //BORRA PRODUCTO
              $sqlBorrar2 ="
                UPDATE producto
                SET nombre_producto = '',
                    foto_producto = 'assets/rsc/img2/nofoto.jpg',
                    precio_producto = 00,
                    id_estilo = '6',
                    medida_producto = '',
                    stock_producto = '',
                    info_producto = '',
                    slider_producto =0
                  WHERE id_producto LIKE '".$_POST['productoBorrar']."';
              ";
              $queryBorrar2 = mysqli_query($conectar, $sqlBorrar2);              
              //VUELVO A CAGAR LOS PRODUCTOS LUEGO DE BORRAR
              $queryProdu = prots();
              echo "<script>var scrollBorra = true;</script>";
              include 'includes/exitoborra.html';
          }
        }else if(isset($_POST['elimina'])){
          //echo "elimina".$_POST['productoBorrar'];
            //BORRA MATERIAL
              $sqlBorrarM ="
                DELETE FROM material
                  WHERE id_producto LIKE '".$_POST['productoBorrar']."';
              ";
              $queryBorrarM = mysqli_query($conectar, $sqlBorrarM);
              //SET AUTOINCREMENTO
              $sqlAutoMat ="
                ALTER TABLE material
                  AUTO_INCREMENT = 1;
              ";
              $queryAutoMat = mysqli_query($conectar, $sqlAutoMat);
              //BORRA PRODUCTO
              $sqlBorrar2 ="
                DELETE FROM producto
                  WHERE id_producto LIKE '".$_POST['productoBorrar']."';
              ";
              $queryBorrar2 = mysqli_query($conectar, $sqlBorrar2);              
              //SET AUTOINCREMENTO
              $sqlAutoPro ="
                ALTER TABLE producto
                  AUTO_INCREMENT = 1;
              ";
              $queryAutoPro = mysqli_query($conectar, $sqlAutoPro);
          // CARGA NUEVAMENTE SQL PRODUCTOS    
          $queryProdu = prots();
        //BUSCADOR DE PRODUCTOS  
        }else if(isset($_POST['buscar']) && !empty($_POST['buscar'])){
          $sqlProdu ="
              SELECT * 
                  FROM producto
                  JOIN material USING (id_producto)
                  JOIN estilo USING (id_estilo)
              WHERE nombre_producto LIKE '%".$_POST['buscar']."%' OR
              tema_estilo LIKE '%".$_POST['buscar']."%';
          ";
          $queryProdu = mysqli_query($conectar, $sqlProdu); 
        }
    //SI NO HAY POST CARGA TODOS LOS PRODUCTOS  
    }else{
      $sqlProdu = "
          SELECT * 
          FROM producto
          JOIN material USING (id_producto)
          JOIN estilo USING (id_estilo)
          ORDER BY orden_producto ASC;
        ";
      $queryProdu = mysqli_query($conectar, $sqlProdu);            
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
	<title>Specs Productos</title>
</head>
<body>

 <style type="text/css">

.editar{ color: darkmagenta; }
.editar:hover{ color: darkorchid; }


.borrar{ color: tomato; }
.borrar:hover{ color: deeppink; }

.borra{
  width: 105px;
  color: tomato;
  background: black;
  padding: 6px;
  border-radius: 12px;
  border: none;
}

.borra2{
  width: 155px;
  background: red;
  color: white;
  padding: 6px;
  border-radius: 12px;
  border: none;
  margin: 25px 0 0 0;
}

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
          <a class="nav-link active">Specs-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ordenprod.php">Orden-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pedidos.php">Pedidos</a>
        </li>
        <!-- AVATAR -->
        <li class="nav-item dropdown avatar">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span style="color:snow;"><?php echo $nombre;?></span>
            <img class="avatarPic" src="../<?php echo $fotito;?>" alt="Usuario">
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
  <!-- Titulo y Desplegable Crear Productos  -->
  <!-- ============================================================== -->
<div class="row">
 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header" style="margin: 7px 5px 5px 5px;">
      <h2 class="pageheader-title" style="color: var(--darkm);">Características de Productos</h2>
        <p class="pageheader-text" style="color: gray">Crea, edita, y elimina</p>
        <button class="btn" onmouseover="showIcone()" onmouseout="hideIcone()" onclick="despliega();" style="background: chartreuse; color: #312b2b;">Nuevo Producto&nbsp;&nbsp;<i id='icone' class="fas fa-arrow-circle-down" style="display: none;"></i></button>
        
        <style type="text/css">
          
          .colour{
            color: purple;
          }

          .cinp{
            border-radius: 6px;
            border: none;
            padding: 5px;
            margin-bottom: 8px;
          }

          .estiloInput{
            padding: 3px;
            margin: 0px 15px 0px 0px;
            width: 183px;
            border-radius: 6px;
            border: none;
          }

          #nuevoUsuFIX{
            width: 820px;
            margin-top: 14px;
            display: none;
            margin-bottom: 41px;
            background: #c3b3ff;
            padding: 15px;
            border-radius: 7px;
          }

          .labelCustom{
            margin-bottom: 0;
          }
        </style>
        <!--  ============================AGREGAR NUEVO PRODUCTO =============================-->
          <div id="nuevoUsuFIX" style="">
            <div>
               Para Agregar un nuevo producto debes:<br>
              1.- Rellenar TODAS sus caracteristicas en el siguiente formulario. ,<br> 
              2.- Hacer click en el "boton de Agregar Producto" ,<br> 
              3.- Tu producto ya estaría creado, para cambiar la foto lo haces desde el Panel de Productos Existentes (el que está debajo de este). 
            </div>
              <div style="display: flex;">
                <div style="background: #6f54b9; align-items: center; display: flex; padding: 20px;">
                    <img src="assets/rsc/img/nofoto.jpg" alt="user" style="height: 250px; border: solid 6px #EDBC41; /*object-fit: cover;*/">
                </div>
            
                <form class="formSpecs1" style="" action="" method="POST" name="NuevoProductoZ">
                
                  <label class="labelCustom">Nombre:</label>
                  <input class="cinp" type="text" name="nombreAgrega" value="" required>
                  <label class="labelCustom">Medida:</label>
                  <input class="cinp" type="text" name="medidaAgrega" value="" required>
                  <label class="labelCustom">Precio:</label>
                  <input class="cinp" type="text" name="precioAgrega" value="" required>
                  <label class="labelCustom">Materiales:</label>
                  <input class="cinp" type="text" name="materialesAgrega" value="" required>
                  <label class="labelCustom">Estilo:</label>
                  <select class="estiloInput" name="estiloNuevoAdd" required>
                    <?php

                    $sqlAddTematica ="
                        SELECT * 
                          FROM estilo;
                      ";
                      $queryAddTematica = mysqli_query($conectar, $sqlAddTematica); 
                      while ($rowqueryAddEstilo = mysqli_fetch_assoc($queryAddTematica)){

                      ?>
                    <option value="<?php echo $rowqueryAddEstilo['id_estilo']?>"><?php echo $rowqueryAddEstilo['tema_estilo']?></option>
                    <?php
                     }
                    ?>
                  </select>
                  <span style="margin-top: 10px;">Info del Producto</span>
                  <br>
                  <textarea id="textoArea" name="addInfoProducto" rows="2" cols="50" style="resize: none; border-radius: 5px; border: none; padding: 5px;" required></textarea>
                  <button class="btn_insert" type="submit" name="AddNew">Agregar Producto</button>
                </form>
               </div>
               <!-- <hr style="background: #ff96db;">   -->  
          </div> 


     

   </div>
  <!-- BUSCADOR PRODUCTOS  -->
  <div style="background: #806B99; padding: 3px; text-align: center; border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;">
    <div style="padding: 3px; color: snow;">Busqueda por nombre/código</div>
    <form name="formuBusca" action="" method="POST" style="display: flex; justify-content: center;">
      <input style="border-radius: 3px; border: none; padding: 5px; margin-right: 8px;" type="search" name="buscar" value="" placeholder="Búsqueda..." required>
      <button type="submit" name="busca" class="btn btn-success" style="background: var(--darkm); border:none">Buscar</button>
    </form>
  



  <!-- TABLA PRODUCTOS-->
    <div class="card tabla1" style="margin: 7px 5px 5px 5px;">
        <h4 class="card-header">Panel de Productos Existentes</h4>

<!--  ============================ EDITOR DE LAS CARACTERÍSTICAS DEL PRODUCTO =============================-->
<?php
    
   
    $produ_tema = array();
               
      while ($rowqueryProdu = mysqli_fetch_assoc($queryProdu)){  

        $produ_tema[$rowqueryProdu['id_producto']] = $rowqueryProdu['tema_estilo'];
        $id_producto = $rowqueryProdu['id_producto'];
?>


        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table" style="text-align: left;">
              <thead class="tabla1_head">
                <tr class="border-0">
                  <th class="border-0">#</th>
                  <th class="border-0">Foto</th>
                  <th class="border-0">Características</th>
                  <th class="border-0">Eliminar_Producto</th>
                </tr>
              </thead>
              <tbody>
                <tr id="columna<?php echo $rowqueryProdu['id_producto'];?>">
                  <td>Numero_<?php echo $rowqueryProdu['orden_producto'];?></td>
                  <td class="coluFoto" style="">
                      <form class="formFotos" name="picture<?php echo $rowqueryProdu['id_producto'];?>" action="" method="POST" enctype="multipart/form-data">
                        <label>
                            Foto Actual:
                            <br>
                            <img src="../<?php echo $rowqueryProdu['foto_producto'];?>" alt="user" style="width: 150px; border: solid 6px #EDBC41;; object-fit: cover;">
                        </label>
                        <br><br>
                        <label>Cambiar Foto por:</label>
                       <div style="position: relative; height: 60px;">
                          <button class="seekFoto2"  style="position: relative; z-index: 10;" onclick="document.getElementById('get<?php echo $rowqueryProdu['id_producto'];?>').click();muestra('#get<?php echo $rowqueryProdu['id_producto'];?>');">Buscar Foto</button>
                          <input type="file" name="fotoChange" value="" id="get<?php echo $rowqueryProdu['id_producto'];?>" required style="display: none; position: relative; top:-28px; left: 47px;">
                        </div>
                        <input type="hidden" name="pastFoto" value="<?php echo $rowqueryProdu['foto_producto'];?>">
                    
                        <input type="hidden" name="idProducto" value="<?php echo $rowqueryProdu['id_producto'];?>">
                        <!-- <div id="fake<?php echo $rowqueryProdu['id_producto'];?>"class="btn_falso">Aplicar</div> -->
                        <button class="btn_fotoProd" id="action<?php echo $rowqueryProdu['id_producto'];?>" type="submit" name="picture" style="display:block; margin-top: 0;">Aplicar</button>
                      </form>
                  </td>
                  <td  class="coluSpec" style="">
                    <form class="formSpecs" name="cambiarSpecs" action="" method="POST">
                      <label class="labelCustom">Nombre:</label>
                      <input class="cinp" type="text" name="nombreProd" value="<?php echo $rowqueryProdu['nombre_producto'];?>" required>
                      <label class="labelCustom">Medida:</label>
                      <input class="cinp" type="text" name="medidaProd" value="<?php echo $rowqueryProdu['medida_producto'];?>" required>
                      <label class="labelCustom">Precio:</label>
                      <input class="cinp" type="text" name="precioProd" value="<?php echo $rowqueryProdu['precio_producto'];?>" required>
                      <label class="labelCustom">Materiales:</label>
                      <input class="cinp" type="text" name="materialProd" value="<?php echo $rowqueryProdu['nombre_material'];?>" required>
  
                      <div style="margin: 10px 0px 10px; flex-direction: column; display:flex;">Temática:<br>
                      <?php

                      $sqlTematica ="
                        SELECT * 
                          FROM estilo;
                      ";
                      $queryTematica = mysqli_query($conectar, $sqlTematica);   
                        while($rowqueryTematica = mysqli_fetch_assoc($queryTematica)){

                          if(array_key_exists($id_producto, $produ_tema)){
                            if($produ_tema[$id_producto] == $rowqueryTematica['tema_estilo']){
                              ?>
                                <span>
                                <input type="radio" name="estilo" checked required value="<?php echo $rowqueryTematica['id_estilo']?>" id="<?php echo $rowqueryTematica['tema_estilo']?>"><label for="<?php echo $rowqueryTematica['tema_estilo']?>"><?php echo $rowqueryTematica['tema_estilo']?></label>
                                </span>
                              <?php
                            }else{
                              ?>
                                <span>
                                <input type="radio" name="estilo" required value="<?php echo $rowqueryTematica['id_estilo']?>" id="<?php echo $rowqueryTematica['tema_estilo']?>"><label for="<?php echo $rowqueryTematica['tema_estilo']?>"><?php echo $rowqueryTematica['tema_estilo']?></label>
                                </span>
                              <?php
                            }
                           
                          }

                      ?>
                      <?php
                      } 
                      ?>   
                      </div>
                      Info del producto<br>
                       <textarea id="textoArea" name="infoProducto" rows="2" cols="50" style="resize: none; border-radius: 5px; border: none;" required><?php echo $rowqueryProdu['info_producto'];?></textarea>                     
                        <input type="hidden" name="idProdSpecs" value="<?php echo $rowqueryProdu['id_producto'];?>">
                      <button class="btn_fotoProd" type="submit" name="specs">Cambiar</button>
                    </form>
                  </td>
              
                 <td>
                  <ul style="list-style: none">
                    <form accion="" method="POST"  name="borrarP">
                      <div style="display: flex; flex-direction: column;">
                      <input type="hidden" name="productoBorrar" value="<?php echo $rowqueryProdu['id_producto'];?>">
                      <button class="borra" name="borra"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Borrar</button>
                      <?php 

                        if ($rowqueryProdu['id_producto'] == $enTotal){
                          echo "<button class='borra2' name='elimina'><i class='far fa-trash-alt'></i>&nbsp;&nbsp;Borrar Campo</button>";  
                        }
                      ?>
                      
                      </div>  
                    </form>
                  </ul>
                 </td>
               </tr>
             </tbody>
           </table>
         </div>
       </div>
      <?php
       }
        //print_r($produ_tema);
        //echo"<br>";
        //print_r($id_producto);
      ?>

     </div>

  </div>  
 </div>
 </div>
</div>


<footer style="margin-top: 35px;">
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



function muestra(id){
 //var ident = '#'+id;
 let numerito = id.substr(0,1);

document.querySelector(id).onchange = function() {
    document.querySelector(id).style.display = 'block';
    //document.querySelector('#fake'+numerito).style.display = 'none';
    //document.querySelector('#action'+numerito).style.display = 'block';
};


/*
 $(id).change(function(){ 
    document.querySelector(id).style.opacity = '1';
  });
*/

  
} 


  let iconX = document.querySelector('#icone');
  let agregaEstado = false;
    function despliega(){
      if (agregaEstado== false){
         $('#nuevoUsuFIX').slideDown();

         iconX.className = 'fas fa-arrow-circle-up';
         iconX.classList.add('colour');
         agregaEstado = true;
      }else{
        $('#nuevoUsuFIX').slideUp();

        iconX.className = 'fas fa-arrow-circle-down';
        agregaEstado = false;
      }
  
    }




  function showIcone(){
      $('#icone').show()
  }

 function hideIcone(){
    $('#icone').hide()
  }

let icoEstado = false;
  
 
  if (activa == true){
    despliega();
    activa = false;
  }

//var enTotal = <?php echo json_encode($cantidadTotal); ?>;
var enTotal = <?php echo json_encode($enTotal); ?>;
enTotal++;
//alert(enTotal);
//window.scrollTo(0, 30000);

 if (scroller == true){
  window.location = "#columna"+enTotal;
//window.scrollTo(0, 30000);
//window.location = "#columna33";
 }


var cuenta = <?php echo json_encode($cantidadTotal); ?>;
 if (scrollBorra == true){
  window.location = "#columna"+cuenta;
 }

 if (scrollProducto = true){
   window.location = "#columna"+colu;
   //console.log(colu);
   //console.log(scrollProducto);
 }


console.log(enTotal);

var esta = <?php echo json_encode($enTotal)?>

console.log(esta);

//productos.php#columna33





  </script>



</body>
</html>