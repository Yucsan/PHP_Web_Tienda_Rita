<?php

  session_start();

  if (!isset($_SESSION['idUsu']) || $_SESSION['rolUsu'] != 'Admin') {
    header('Location: index.php');
  }

  require '../includes/conexion.inc.php';
  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];

// FUNCION USUARIOS PARA CUANDO HAY VARIABLES POST
function users(){
  require '../includes/conexion.inc.php';

    $sqlUsuario="
    SELECT * 
      FROM usuario; 
  ";
  $queryUsu = mysqli_query($conectar, $sqlUsuario);
  return $queryUsu;

}

if($_GET){
  if( (isset($_GET['des']) && !empty($_GET['des'])) ) {

    $des = $_GET['des'];
    $accion = $_GET['accion'];

    $sqldesactiva="
      UPDATE usuario
        SET activo_usuario = '".$accion."'
         WHERE id_usuario LIKE '".$des ."';
    ";
    $queryDes = mysqli_query($conectar, $sqldesactiva);
  }else if( isset($_GET['delete']) && !empty($_GET['delete']) ){

    $delete = $_GET['delete'];

    $sqlBorra="
      UPDATE usuario
        SET nombre_usuario = '💀',
            correo_usuario ='💀',
            clave_usuario = '💀',
            foto_usuario = '💀',
            fdn_usuario = '000',
            fuc_usuario ='💀',
            finc_usuario = '💀',
            fdr_usuario = '💀',
            sexo_usuario = '💀',
            activo_usuario = '3',
            estado_usuario = '3',
            validado_usuario = '3',
            contador_usuario = '3',
            id_rol = '2'
            WHERE id_usuario LIKE '".$delete."';
    ";
    $queryBorra = mysqli_query($conectar, $sqlBorra);


  }

}

    

if($_POST){
  if(isset($_POST['buscar']) && !empty($_POST['buscar'])){

      $sqlUsuario="
         SELECT * 
           FROM usuario
            WHERE nombre_usuario LIKE '%".$_POST['buscar']."%' OR correo_usuario LIKE '%".$_POST['buscar']."%';
       ";
       $queryUsu = mysqli_query($conectar, $sqlUsuario);
    
  }else if((isset($_POST['nombre']) && !empty($_POST['nombre'])) && (isset($_POST['correo']) && !empty($_POST['correo'])) && (isset($_POST['fdn']) && !empty($_POST['fdn'])) && (isset($_POST['sexoNuevoUsu']) && !empty($_POST['sexoNuevoUsu'])) && (isset($_POST['rol']) && !empty($_POST['rol'])) && (isset($_POST['idUsu']) && !empty($_POST['idUsu']))){

      //echo $_POST['nombre'];//echo "<br>";//echo $_POST['correo'];//echo "<br>";//echo $_POST['fdn'];//echo "<br>";//echo $_POST['sexoNuevoUsu'];//echo "<br>";//echo $_POST['rol']; echo $_POST['idUsu'];

      $sqlEditUsuario ="
        UPDATE usuario
          SET nombre_usuario = '".$_POST['nombre']."',
              correo_usuario = '".$_POST['correo']."',
              fdn_usuario = '".$_POST['fdn']."',
              sexo_usuario = '".$_POST['sexoNuevoUsu']."',
              id_rol = '".$_POST['rol']."'
            WHERE id_usuario LIKE ".$_POST['idUsu'].";
      ";
      $queryEditUsuario = mysqli_query($conectar, $sqlEditUsuario);

      //Llamada a SQL usuarios
      $queryUsu = users();

  }else if((isset($_POST['nuevoNombre']) && !empty($_POST['nuevoNombre'])) && (isset($_POST['nuevoCorreo']) && !empty($_POST['nuevoCorreo'])) && (isset($_POST['nuevoSexo']) && !empty($_POST['nuevoSexo'])) && (isset($_POST['nuevoRol']) && !empty($_POST['nuevoRol'])) && (isset($_POST['password']) && !empty($_POST['password']))  && (isset($_POST['rePassword']) && !empty($_POST['rePassword'])) && (isset($_POST['fdn']) && !empty($_POST['fdn']))){

   $nNombre = $_POST['nuevoNombre'];
   $nCorreo = $_POST['nuevoCorreo'];
   $nSexo = $_POST['nuevoSexo'];
   $nRol = $_POST['nuevoRol'];
   $nClave = $_POST['password'];
   $rClave = $_POST['rePassword'];
   $fdn = $_POST['fdn'];
      if($nClave == $rClave){

        $sqlExisteCorreo = "
          SELECT correo_usuario
            FROM usuario
            WHERE correo_usuario LIKE '".$nCorreo."';
        ";
        $queryExisteCorreo = mysqli_query($conectar, $sqlExisteCorreo);

          if (mysqli_num_rows($queryExisteCorreo) > 0) {
          echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> Ese correo ya está registrado. Utilice otro! </div>";
          //VARIABLE QUERY USUARIOS
          $queryUsu = users(); 

          }else{
            
          if ($nSexo == 'Hombre'){
            $fotoPortada = 'users/hombre.jpg';
          }else if($nSexo == 'Mujer'){
            $fotoPortada = 'users/Mujer.jpg';
          }else if($nSexo == 'Otro'){
            $fotoPortada = 'users/Otro.jpg';
          }  

          $sqlNuevoUsuario = "
            INSERT INTO usuario
              VALUES (null, '".$nNombre."', '".$nCorreo."', '".password_hash($nClave, PASSWORD_DEFAULT)."', '".$fotoPortada."', '".$fdn."', '', '', NOW(), '".$nSexo."', 1, 0, 0, 0, 2);
          ";
          $queryNuevoUsuario = mysqli_query($conectar, $sqlNuevoUsuario);
          
          $sqlRecienRegistrado = "
                  SELECT id_usuario
                      FROM usuario
                      WHERE correo_usuario LIKE '".$nCorreo."';
              ";
              $queryRecienRegistrado = mysqli_query($conectar, $sqlRecienRegistrado);
              while ($rowRecienRegistrado = mysqli_fetch_assoc($queryRecienRegistrado)){

                  $ruta = "../users/".$rowRecienRegistrado['id_usuario'];
                  mkdir($ruta);
                  mkdir($ruta."/archivos");
                  mkdir($ruta."/profile");
           }       
          include 'includes/exitoagregausu.html';          

          //VARIABLE QUERY USUARIOS
          $queryUsu = users(); 

          }


      }else{
        echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> Las contraseñas no coinciden! </div>";
      }

  }else{
    echo "<div style='margin-bottom: 0px; border-radius: 0px;' class='alert alert-danger' role='alert'> Debes rellenar todos los campos! </div>";
    $queryUsu = users();
  }



}else{

  $sqlUsuario="
    SELECT * 
      FROM usuario; 
  ";
  $queryUsu = mysqli_query($conectar, $sqlUsuario);
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/sweealert2/css/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="icon/png" href="favicon.png">
	<title>Usuarios</title>
</head>
<body>

 <style type="text/css">

  .editar{ color: darkmagenta; }
  .editar:hover{ color: darkorchid; }

  .desac{ color: deeppink; }
  .desac:hover{ color: tomato; }

  .borrar{ color: indigo; }
  .borrar:hover{ color: black; }


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
          <a class="nav-link active">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">Specs-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ordenprod.php">Orden-Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pedidos.php">Pedidos</a>
        </li>
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
  <!-- Titulo y Desplegable Crear Usuarios  -->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="page-header" style="margin: 7px 5px 5px 5px;">
        <h2 class="pageheader-title" style="color: var(--darkm);">Panel de Usuarios</h2>
        <p class="pageheader-text" style="color: gray">Crea, edita, activa, valida, desactiva y elimina</p>
        <div class="page-breadcrumb">
        </div>
        <button class="btn" onclick="despliega();" style="background: deeppink; color: snow;">Nuevo Usuario</button>
        <div id="nuevoUsu" style="">
          <form name="nuevoUser" action="" method="POST">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Nombre" value="" name="nuevoNombre" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Correo Electrónico" value="" name="nuevoCorreo" required>
            </div>
             <div class="form-group">
              <label class="etiquetas">Fecha de Nacimiento</label>
              <input type="date" name="fdn" value="">
            </div>
            <div class="form-group">
              <label>Sexo</label>
              <select name="nuevoSexo" required>
                <option value="Mujer">Mujer</option>
                <option value="Hombre">Hombre</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            <div class="form-group">
              <label>Rol</label>
              <select name="nuevoRol" required>
                <option value="2" selected>Estándar</option>
                <option value="1">Admin</option>
              </select>
            </div>
            <div class="form-group">
              <input type="password" style="margin-bottom: 14px;" class="form-control" placeholder="Contraseña" value="" name="password" required>
              <input type="password" style="margin-bottom: 14px;" class="form-control" placeholder="Recontraseña" value="" name="rePassword" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn" style="background: var(--morado); color: snow;">CREAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- BUSCADOR USUARIOS  -->
  <div style="background: #CCA6E8; padding: 3px; text-align: center; border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;">
    <div style="padding: 3px; color: snow;">Busqueda por nombre/correo</div>
    <form name="formuBusca" action="" method="POST" style="display: flex; justify-content: center;">
      <input style="border-radius: 3px; border: none; padding: 5px; margin-right: 8px;" type="search" name="buscar" value="" placeholder="Búsqueda..." required>
      <button type="submit" name="busca" class="btn btn-success" style="background: var(--darkm); border:none">Buscar</button>
    </form>


  
  <!-- TABLA USUARIOS -->
    <div class="card tabla1" style="margin: 7px 5px 5px 5px;">
        <h5 class="card-header">Usuarios</h5>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table">
              <thead class="tabla1_head">
                <tr class="border-0">
                  <th class="border-0">#</th>
                  <th class="border-0">Foto</th>
                  <th class="border-0">Nombre</th>
                  <th class="border-0">Correo</th>
                  <th class="border-0">Likes</th>
                  <th class="border-0">Edad</th>
                  <th class="border-0">Registro desde</th>
                  <th class="border-0">Estado</th>
                  <th class="border-0">Validado</th>
                  <th class="border-0">Activo</th>
                  <th class="border-0">Acciones</th>
                </tr>
              </thead>
              <tbody>

              <?php
                // Bucle q pinta usuarios
                while ($rowqueryusu = mysqli_fetch_assoc($queryUsu)){

              ?>
                <tr>
                  <td><?php echo $rowqueryusu['id_usuario'];?></td>
                  <td>
                    <div class="m-r-10"><img src="../<?php echo $rowqueryusu['foto_usuario'];?>" alt="user" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                    </div>
                  </td>
                  <td style="text-transform: capitalize;">
                    <?php echo $rowqueryusu['nombre_usuario'];?>
                  </td>
                  <td><?php echo $rowqueryusu['correo_usuario'];?></td>
                 
                  <td>5</td>
                   <?php
                  $añoActual = date('Y');

                  if( $rowqueryusu['fdn_usuario'] != '999') {

                    $tuAño = substr($rowqueryusu['fdn_usuario'], 0, 4);
                    $mesActual = date('m');
                    $tuMes = substr($rowqueryusu['fdn_usuario'], 5, 2);
                    $diaActual = date('d');
                    $tuDia = substr($rowqueryusu['fdn_usuario'], 8, 2);
                    $edad = $añoActual - $tuAño;
                    if ($tuMes > $mesActual) {
                      $edad--;
                    }elseif ($tuMes == $mesActual){
                      if ($tuDia > $diaActual){
                        $edad--;
                      }
                    }

                  }
                 ?>

                  <td><?php echo $edad; ?></td>
                  <td><?php echo $rowqueryusu['fdr_usuario'];?></td>
                  <td>
                    <?php
                    if ($rowqueryusu['estado_usuario'] ==  1){
                      echo "<span class='badge-dot badge-brand mr-1' style='background: lightgreen;'></span>Online";
                    }else{
                      echo "<span class='badge-dot badge-brand mr-1' style='background: red;'></span>Offline";
                    }
                    ?>
                 </td>
                 <td>
                    <?php
                    if ($rowqueryusu['activo_usuario'] ==  1){
                      echo "<span class='badge-dot badge-brand mr-1' style='background: lightgreen;'></span>Activado";
                    }else{
                      echo "<span class='badge-dot badge-brand mr-1' style='background: red;'></span>Sin Activar";
                    }
                    ?>
                 </td>
                 <td>
                   <?php
                    if ($rowqueryusu['validado_usuario'] ==  1){
                      echo "<span class='badge-dot badge-brand mr-1' style='background: lightgreen;'></span>Válidado";
                    }else{
                      echo "<span class='badge-dot badge-brand mr-1' style='background: red;'></span>Sin validar";
                    }
                    ?>
                 </td>
                 <td>
                  <ul style="list-style: none">
                    <?php
                    if ($rowqueryusu['estado_usuario'] ==  3){
                      echo "<li style='color:red;'> Eliminado </li>";
                    }else{
                      ?>
                    <li><i class="far fa-edit"></i><a class="" href="" data-toggle="modal" data-target="#exampleModal<?php echo $rowqueryusu['id_usuario'];?>">&nbsp;&nbsp;Editar</a></li>
                    <li>
                      <?php

                    }

                    ?>

                    <?php
                    if ($rowqueryusu['activo_usuario'] ==  1){
                      echo "<a class='desac' href='usuarios.php?des=".$rowqueryusu['id_usuario']."&accion=0'><i class='fas fa-user-slash'></i></i>&nbsp;&nbsp;Desactivar</a></li>";
                    }else if($rowqueryusu['activo_usuario'] ==  0){
                      echo "<a style='color: #1ad226;' href='usuarios.php?des=".$rowqueryusu['id_usuario']."&accion=1'><i class='fas fa-user-slash'></i></i>&nbsp;&nbsp;Activar</a></li>";
                    }
                    ?>

                    <?php
                    if ($rowqueryusu['estado_usuario'] ==  3){

                    }else{
                      echo "<li><span id='".$rowqueryusu['id_usuario']."' class='borrar' onclick='delUser(this.id)'><i class='far fa-trash-alt'></i>&nbsp;&nbsp;Borrar</span></li>";
                    }

                    ?>

                  </ul>

                 </td>
               </tr>

               <style type="text/css">
                 .modal-body{
                  display: flex;
                  flex-direction: column;
                  text-align: left
                 }

                 .etiquetas{
                  margin: 7px 0 7px 0;
                  /*color: gray; */
                 }
                 .borrar{
                  cursor: pointer;
                 }

               </style>
                   <!-- MODAL  EDICION DE USUARIOS-->
                  <div class="modal fade" id="exampleModal<?php echo $rowqueryusu['id_usuario'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Editar datos: <span style="color:purple;"><?php echo $rowqueryusu['nombre_usuario'];?> # <?php echo $rowqueryusu['id_usuario'];?></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="POST" name="editaUsu">
                        <div class="modal-body">
                          <label class="etiquetas">Nombre</label>
                          <input type="text" name="nombre" value="<?php echo $rowqueryusu['nombre_usuario'];?>">
                          <label class="etiquetas">Correo</label>
                          <input type="text" name="correo" value="<?php echo $rowqueryusu['correo_usuario'];?>">
                          <label class="etiquetas">Fecha de Nacimiento</label>
                          <input type="date" name="fdn" value="<?php echo $rowqueryusu['fdn_usuario'];?>">
                          <input type="hidden" name="idUsu" value="<?php echo $rowqueryusu['id_usuario']; ?>">
                          <div style="margin: 7px 0 0 0;">
                            <label class="etiquetas">Sexo</label>
                            <select name="sexoNuevoUsu" required>
                              <?php 
                              if($rowqueryusu['sexo_usuario'] == 'Mujer'){
                                echo "<option value='Mujer' selected>Mujer</option><option value='Hombre'>Hombre</option><option value='Otro'>Otro</option>";
                              }else if($rowqueryusu['sexo_usuario'] == 'Hombre'){
                                echo "<option value='Mujer'>Mujer</option><option value='Hombre' selected>Hombre</option><option value='Otro'>Otro</option>";
                              }else{
                                echo "<option value='Mujer'>Mujer</option><option value='Hombre'>Hombre</option><option value='Otro' selected>Otro</option>";
                              }
                              ?>                              
                            </select>
                          </div>
                          
                          <div>
                            <label class="etiquetas">Rol</label>
                            <select name="rol" required>
                              <?php 
                              if($rowqueryusu['id_rol'] == '2'){
                                  echo "<option value='2' selected>Estándar</option><option value='1'>Admin</option>";
                                }else{
                                  echo "<option value='2'>Estándar</option><option value='1' selected>Admin</option>";
                                }
                                ?>
                             </select>   
                          </div>
                            
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" name="btnEditUsu" class="btn btn-primary">Aplicar Cambios</button>
                          </form>
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

</div>

<footer style="margin-top: 35px;">
  <div class="copiRight" style="color:white">
    <div style="padding: 25px; background: var(--darkm);">
      <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
  </div>
</footer>

  <script type="text/javascript" src="assets/vendor/jquery/jquery_3.6.0.min.js"></script>
  <script type="text/javascript" src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/vendor/sweealert2/js/sweetalert2.min.js"></script>
  <script src="assets/vendor/chartjs/Chart.js"></script>
  <script src="assets/vendor/chartjs/utils.js"></script>
  <script type="text/javascript">


//BORRAR USUARIO
  function delUser(id){

    Swal.fire({
          title: 'ESTAS SEGURO QUE DESEAS',
          text: "ELIMINAR ESTE USUARIO",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
          cancelButtonText: 'No, gracias!'
        }).then((result) => {
          if (result.value) {
            //console.log('BORRAS');
            location = 'usuarios.php?delete='+id;
              return true;
          }else{
            console.log('NADA');
              return false;
          }
        }) 
    
 } 


  let agregaEstado = false;
    function despliega(){
      if (agregaEstado== false){
         $('#nuevoUsu').slideDown();
         agregaEstado = true;
      }else{
        $('#nuevoUsu').slideUp();
        agregaEstado = false;
      }
  
    }




  </script>



</body>
</html>