<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	
	require 'includes/conexion.inc.php';

  $id = $_SESSION['idUsu'];
  $nombre = $_SESSION['nombreUsu'];
  $fotito = $_SESSION['fotoUsu'];

$idDom ="";
      $sqlDom="
          SELECT id_domicilio
            FROM domicilio
              WHERE id_usuario LIKE '".$id."';
      ";
      $queryDom = mysqli_query($conectar,  $sqlDom);
      while ($rowDom = mysqli_fetch_assoc($queryDom)){
        $idDom = $rowDom['id_domicilio'];
      }

$idDireccion = "";
  $sqlIdDir ="
    SELECT id_direccion
      FROM domicilio
        WHERE id_domicilio LIKE '".$idDom."';
  ";
  $queryIdDir = mysqli_query($conectar, $sqlIdDir);
   while ($rowDirect = mysqli_fetch_assoc($queryIdDir)){
        $idDireccion = $rowDirect['id_direccion'];
      }

if($idDireccion == null){
  //echo "sin direccion";
}

  if ($_POST){
    if (isset($_POST['cambiaDatos'])){
      if ((isset($_POST['nombre']) && !empty($_POST['nombre'])) && (isset($_POST['correo']) && !empty($_POST['correo'])) && (isset($_POST['fdn']) && !empty($_POST['fdn']))){
        $sqlActualizarDatos = "
        UPDATE usuario
        SET nombre_usuario = '".$_POST['nombre']."',
        correo_usuario = '".$_POST['correo']."',
        fdn_usuario = '".$_POST['fdn']."'
        WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
        ";
        $queryActualizarDatos = mysqli_query($conectar, $sqlActualizarDatos);
        if ($queryActualizarDatos){
          $_SESSION['nombreUsu'] = $_POST['nombre'];
          $_SESSION['correoUsu'] = $_POST['correo'];
          $_SESSION['fdnUsu'] = $_POST['fdn'];
        }
        $nombre = $_POST['nombre'];
                //echo "Datos actualizados";
        include "sweets/exitoAct.html";
      }else{
        echo "Debes rellenar todos los campos";
      }
    }elseif (isset($_POST['cambiaClave'])){
      if ((isset($_POST['clave']) && !empty($_POST['clave'])) && (isset($_POST['reclave']) && !empty($_POST['reclave']))) {
        if ($_POST['clave'] == $_POST['reclave']){
          $sqlActualizarDatos = "
          UPDATE usuario
          SET clave_usuario = '".password_hash($_POST['clave'], PASSWORD_DEFAULT)."'
          WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
          ";
          $queryActualizarDatos = mysqli_query($conectar, $sqlActualizarDatos);
          include "sweets/exitocamClave.html";
                    //header('Location: cerrar.php');
        }else{
          include "sweets/errorcamClave.html";
                    //echo "Las contraseñas no coinciden";
        }
      }else{
        echo "Debes rellenar todos los campos";
      }
    }elseif (isset($_POST['cambiaFoto'])){

      $fotoPasada = $_POST['pastFoto'];

      if ($_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png"){
        if ($_FILES['foto']['size'] <= 1048576){
          $fotoFinal = "users/".$_SESSION['idUsu']."/profile/".$_FILES['foto']['name'];
          move_uploaded_file($_FILES['foto']['tmp_name'], $fotoFinal);
          $sqlActualizaFoto = "
          UPDATE usuario
          SET foto_usuario = '".$fotoFinal."'
          WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
          ";
          $queryActualizaFoto = mysqli_query($conectar, $sqlActualizaFoto);

                    //BORRO FOTO PASADA
          if(file_exists($fotoPasada) && ($fotoPasada != $fotoFinal)) {
            if($fotoPasada == 'users/hombre.jpg' || $fotoPasada == 'users/otro.jpg' || $fotoPasada == 'users/mujer.jpg'){
                        //echo "No borrar";
              }else{
                        unlink($fotoPasada); //BORRA LA FOTO PASADA Si existe   
              }
            }else{
                echo "Esa Foto ya existe";
            }

            $_SESSION['fotoUsu'] = $fotoFinal;
            $fotito = $fotoFinal;
        }else{
              echo "El archivo es demasiado grande, reduce su tamaño";
        }
      }else{
          echo "Solo puede subir .JPG ó .PNG";
      }
    }else if(isset($_POST['desactivar'])){
            $des = $_POST['desactivar'];
            $sqldesactiva="
              UPDATE usuario
                SET activo_usuario = '0'
                  WHERE id_usuario LIKE '".$des ."';
            ";
            $queryDes = mysqli_query($conectar, $sqldesactiva);
              header('Location: index.php?desactivo=yes');

    }else if(isset($_POST['direccion']) && !empty($_POST['direccion']) && (isset($_POST['codigoPostal']) && !empty($_POST['codigoPostal'])) && (isset($_POST['pais']) && !empty($_POST['pais'])) && (isset($_POST['provincia']) && !empty($_POST['provincia'])) && (isset($_POST['distrito']) && !empty($_POST['distrito'])) && (isset($_POST['numero']) && !empty($_POST['numero'])) && (isset($_POST['planta']) && !empty($_POST['planta'])) && (isset($_POST['puerta']) && !empty($_POST['puerta'])) && (isset($_POST['escalera']) && !empty($_POST['escalera'])) && (isset($_POST['portal']) && !empty($_POST['portal'])) ){

      $dire = $_POST['direccion'];
      $cp = $_POST['codigoPostal'];
      $pais = $_POST['pais'];
      $provincia = $_POST['provincia'];
      $distrito = $_POST['distrito'];
      $numero = $_POST['numero'];
      $planta = $_POST['planta'];
      $puerta = $_POST['puerta'];
      $escalera = $_POST['escalera'];
      $portal = $_POST['portal'];

     
      $sqlActuDir="
        UPDATE direccion
        SET nombre_direccion = '".$dire."',
            numero_direccion = '".$numero."',
            portal_direccion = '".$portal."',
            planta_direccion = '".$planta."',
            puerta_direccion = '".$puerta."',
            distrito_direccion = '".$distrito."',
            provincia_direccion = '".$provincia."',
            pais_direccion = '".$pais."',
            codigopostal_direccion = '".$cp."'
            WHERE id_direccion LIKE '".$idDireccion."';
      ";
      $queryActuDir = mysqli_query($conectar, $sqlActuDir);

      include "sweets/exitocamDir.html";
    }






}



  // ===== RESCATA INFO SOBRE PEDIDOS ==========
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

  //PEDIDOS EN RUTA===================================

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

?>


<!DOCTYPE html>
<html>
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
	<title>Edita tu perfil</title>
</head>
<body style="background: #F4F4F4;">
<div class="body">

<div  onclick="main();" class="btnHome" style="">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div onclick="main();" class="logoHorizontal" style="">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
    
 <form action="productos.php?pag=1" method="POST" class="buscaNav">
        <input class="inputCustom me-2" type="search" placeholder="Buscar" name="buscar" aria-label="Search">
        <button class="btn btn-dark btnCustom" type="submit">Buscar</button>
 </form>

  <div class="container-fluid">

    <div class="logoMovil">
      <img onclick="main();" class="logoWeb2" src="assets/rsc/img/webLogo.gif" style="">


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
    <li id="persona" class="nombreUser" style="margin-right: 20px;">
      <?php echo $nombre; ?>
     <img src="<?php echo $fotito; ?>" class="fotoUser" style="">
    </li>
    <li class="cerrarS">
      <a href="cerrar.php" class="txtCerrar" style="text-decoration:none;">Cerrar Sesión</a>
    </li>
    <li class="cerrarS">
      <a class="txtCerrar" style="text-decoration:none; color: blueviolet;">Editar Perfil</a>
    </li>
    <li class="cerrarS">
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
    //LLAMA AL BTN PEDIDO SI HAY PEDIDO
    $hayPedido= "";
    if ($idpedidos){
       $ultimoPedido = max(array_keys( $idpedidos ));
           
        if ($idpedidos[$ultimoPedido] == "guardado"){
            //echo "Tienes un pedido guardado";
            echo "<script>document.querySelector('#blinkPedido').style.display = 'block';
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

<style type="text/css">



</style>

<section class="seccionPerfil">
	<form class="cForm" name="cambiarDatos" action="" method="POST">

    <legend>Cambiar datos del perfil</legend>
	    <fieldset class="field1">	        
          <div>
            <div>Nombre</div>
	           <input class="perfilInput" type="text" name="nombre" placeholder="Nombre" value="<?php echo $_SESSION['nombreUsu']; ?>" required>
          </div>  

          <div class="mTop">
            <div class="mx-3">Correo</div>
	           <input class="perfilInput mx-3" type="email" name="correo" placeholder="Correo Electrónico" value="<?php echo $_SESSION['correoUsu']; ?>" required>
          </div> 

          <div class="mTop">
            <div>Fecha de Nacimiento</div>
	          <input class="perfilInput ancho100" type="date" name="fdn" value="<?php echo $_SESSION['fdnUsu']; ?>" required>	          
          </div>

          <button class="btnDataPersonal mTop" type="submit" name="cambiaDatos">Guardar</button>
	    </fieldset>
	</form>
	
	<br><br>

	<form class="cForm" name="cambiarClave" action="" method="POST">
    <legend>Cambiar de Contraseña</legend>
	    <fieldset class="field1">	        
	        <input class="perfilInput" type="password" name="clave" value="" required placeholder="Nueva Contraseña">
	        <input class="perfilInput mx-3 mTop" type="password" name="reclave" value="" required placeholder="Repite Contraseña">
    	    <button class="btnDataPersonal mTop" type="submit" name="cambiaClave">Cambiar</button>
	    </fieldset>
	</form>
	
	<br><br>
<?php
 
if ($idDireccion != null){

  $sqldirecciondata ="
    SELECT *
      FROM direccion
        WHERE id_direccion LIKE '".$idDireccion."';
  ";
  $queryDir = mysqli_query($conectar, $sqldirecciondata);
  while ($rowDire = mysqli_fetch_assoc($queryDir)){

?>
  <form class="cForm" action="" method="POST" name="direction">
    <h3 style="color: purple;">Actualiza la Dirección de Entrega</h3>
          <input class="inpCustom" type="text" name="direccion" value="<?php echo $rowDire['nombre_direccion']?>" required placeholder="direccion*">

          <div class="inpDirePerfil" style="">
            <input class="inp2 cl576" type="text" name="codigoPostal" value="<?php echo $rowDire['codigopostal_direccion']?>" required placeholder="Codigo Postal*">
            <input class="inp2" type="text" name="pais" value="<?php echo $rowDire['pais_direccion']?>" required placeholder="pais*">
          </div>

          <div class="inpDirePerfil" style="">
            <input class="inp2 cl576" type="text" name="provincia" value="<?php echo $rowDire['provincia_direccion']?>" required placeholder="provincia*">
            <input class="inp2" type="text" name="distrito" value="<?php echo $rowDire['distrito_direccion']?>" required placeholder="distrito*">
          </div>

          <div class="inpDire2Perfil dire2Custom" style="">
            <input class="inp2 smallInp" type="number" name="numero" value="<?php echo $rowDire['numero_direccion']?>" required placeholder="numero*">
            <input class="inp2 smallInp" type="text" name="planta" value="<?php echo $rowDire['planta_direccion']?>" required placeholder="planta*">
          </div>

          <div class="wrappInput3Perfil" style="">
            <input class="inp4 agarra ancho" type="text" name="puerta" value="<?php echo $rowDire['puerta_direccion']?>" required placeholder="puerta*">
            <div>
              <label class="retamano" style="margin-right: 5px;">Escalera</label>
              <input class="inp4 ancho" type="text" name="escalera" value="<?php echo $rowDire['escalera_direccion']?>" required placeholder="escalera*">
            </div>

            <div>
              <label class="retamano" style="margin-right: 5px;">Portal</label>
              <input class="inp4 ancho" type="text" name="portal" value="<?php echo $rowDire['portal_direccion']?>" required placeholder="portal*">
            </div>
           </div> 

            <div class="butonera">
              <button class="butonPerfil" type="submit" name="direct" >Cambiar</button>
           </div>

<?php
  }
}  
?>           
           
  </form>
	

<style type="text/css">


</style>

	<form class="cForm" name="cambiarFoto" action="" method="POST" enctype="multipart/form-data">
	    <fieldset>
	        <legend>Cambiar Foto Perfil</legend>
	        <label>
	            Foto Actual:
	            <br>
	            <img src="<?php echo $_SESSION['fotoUsu']; ?>" alt="Mi Foto de Perfil" style="width: 150px;">
	        </label>
	        <br><br>
	        <label>Cambiar Foto por:</label>
	        <!-- <input type="file" name="foto" value="" required> -->
          <input type="hidden" name="pastFoto" value="<?php echo $_SESSION['fotoUsu']; ?>">
             <div style="position: relative; height: 60px;">
                <button class="seekFoto3"  style="position: relative; z-index: 10;" onclick="document.getElementById('getFoto').click();muestra('#getFoto');">Buscar Foto</button>
                <input type="file" name="foto" value="" id="getFoto" required style="display: none; position: relative; top:-32px; left: 47px;">
            </div>

	        <button class="btnDataPersonal2" type="submit" name="cambiaFoto">Aplicar</button>
          <div style="margin: 15px 10px 0px 0px; color: blueviolet;">Tu Foto debe pesar menos de 1 mb</div>
	    </fieldset>
	</form>
</section>  
	<section class="" style="display: flex; justify-content: center; background: none;">
    <form id="darBaja" action="" method="POST" name="baja">
      <div style="background: #f9d7ed; border-radius: 10px; padding: 10px; width: 90%; text-align: center; margin: 10px;">
      <div onclick="des();" type="buton" class="btn btn-danger" href="?desactivar">Desactivar mi cuenta</div>
      <input type="hidden" name="desactivar" value="<?php echo $id; ?>"> 
    </div>
    </form>

  </section>
	 
	<br><br>
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

//GO MAIN
function main(){
  window.location = "main.php";
}

// BTN PEDIDO GUARDADO =========
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


function muestra(id){
    console.log(id);
   //var ident = '#'+id;
   //let numerito = id.substr(0,1);
  
  document.querySelector(id).onchange = function() {
      document.querySelector(id).style.display = 'block';
      //document.querySelector('#fake'+numerito).style.display = 'none';
      //document.querySelector('#action'+numerito).style.display = 'block';
  };
}

//BORRAR CUENTA
  function des(id){

    Swal.fire({
          title: 'ESTAS SEGURO QUE DESEAS',
          text: "DESACTIVAR TU CUENTA",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
          cancelButtonText: 'No, gracias!'
        }).then((result) => {
          if (result.value) {
            //console.log('BORRAS');
            document.querySelector('#darBaja').submit();
              return true;
          }else{
            console.log('NADA');
              return false;
          }
        }) 
    
 } 






</script>

















</body>
</html>