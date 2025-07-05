<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	
	require 'includes/conexion.inc.php';

  $id = $_SESSION['idUsu'];
  $nombre = $_SESSION['nombreUsu'];
  $fotito = $_SESSION['fotoUsu'];

    //RESCATA INFO SOBRE PEDIDOS ======
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
                WHERE id_usuario LIKE  '".$id."' AND estado_pedido LIKE 'ruta' AND id_estado LIKE 1;
    ";
    $queryPedidosRuta =mysqli_query($conectar, $sqlPedidosRuta);
    while ($rowRutas = mysqli_fetch_assoc($queryPedidosRuta)){
      $pedidosRuta = $rowRutas['id_pedido'];
    }


  if($_POST){
    if(isset($_POST['consulta']) && !empty($_POST['consulta'])){

    $consulta = $_POST['consulta'];
    $hora = $_POST['hora'];
    $fecha = $_POST['fecha'];
    $idCons = $_POST['idCons'];

    $sqlRespuesta ="
          UPDATE consulta
           SET mensaje_consulta = '".$consulta."',
               fecha_consulta = '".$fecha."',
               hora_consulta = '".$hora."'
               WHERE id_consulta LIKE '".$idCons."';
    ";
    $queryRespuesta = mysqli_query($conectar, $sqlRespuesta);


    }
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
      <a href="editarPerfil.php" class="txtCerrar" style="text-decoration:none;">Editar Perfil</a>
    </li>
    <li class="cerrarS not">
      <a href="" class="nav-link saveBuy" id="blinkPedido" style="color: fuchsia; display: none;">Pedido Guardado</a>
    </li>
    <li class="cerrarS not3">
      <a class="nav-link saveBuy" id="blinkPedido2" id="msn" href="pedidoruta.php" style="color: fuchsia; display: none;">Pedido en Ruta</a>
    </li>
    <li class="cerrarS">
      <a class="txtCerrar" style="text-decoration:none; color: blueviolet;">Mensajes</a>
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
?>

<style type="text/css">
  .sectionMesnajes{
    background: none;
    width: 100%;
    display: flex;
    align-items: center;
    height: calc(100vh - 380px);
    position: relative;
    margin-bottom: 129px;
    justify-content: center;
  }

  .tablitaMensaje{
    width: 90%;
    background: #f9f7f7;
    border-radius: 18px;    
  }

  .badge-dot {
    border-radius: 100%;
    padding: 4px;
    display: inline-block;
    margin-right: 3px;
}

.preguntas{
  width: 320px;
  height: 80px;
  border-radius: 10px;
  border: solid 1px gray;
  resize: none;
  color: darkslateblue;
  padding: 5px;
}

.btEnvia{
  width: 60px;
  padding: 8px;
  margin-top: 8px;
  background: blueviolet;
  color: snow;
  border: none;
  border-radius: 7px;
text-align: center;

}

</style>

<section class="sectionMesnajes" style="">
 
<div class="table-responsive tablitaMensaje" style="">
  <h5 style="" class="card-header">Mensajes Enviados</h5>
  <table class="table">
    <thead style="background: #b360cad9;  color: snow;">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Mensaje Enviado</th>
        <th scope="col">Respuesta</th>
        <th scope="col">Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $numMsn ="1";
       $sqlMsn = "
          SELECT *
            FROM consulta
            JOIN producto USING (id_producto)
            WHERE id_usuario LIKE '".$id."' AND mensaje_consulta <> ''
            ORDER BY fecha_consulta DESC;  
        ";
        $queryMsn = mysqli_query($conectar, $sqlMsn);
        while ($rowMsn = mysqli_fetch_assoc($queryMsn)){
      ?>
      <tr>
        <th scope="row"><?php echo $numMsn; ?></th>
        <td>
          <div>
            <img src="<?php echo $rowMsn['foto_producto'] ?>" style="width: 100px; border-radius: 10px;">
            <div style="color: purple; margin-top: 3px;"><?php echo $rowMsn['nombre_producto']; ?></div>
          </div>
        </td>
        <form action="" method="POST" name="question">
          <td style="display: flex; flex-direction: column;">
            <input type="hidden" name="idCons" value="<?php echo $rowMsn['id_consulta'];?>">
            <input type="hidden" class="hora" name="hora" value="">
            <input type="hidden" class="fecha" name="fecha" value="">
            <textarea class="preguntas" name="consulta"><?php echo $rowMsn['mensaje_consulta']; ?></textarea>
            <button type="submit" class="btEnvia">Enviar</button>
          </td>
        </form>  
          <td><?php echo $rowMsn['respuesta_consulta']; ?></td>
          <?php
          $answer = $rowMsn['respuesta_consulta'];
          if ($answer == 'Sin leer'){
            echo "<td><span class=badge-dot badge-brand mr-1 style='background: red;'></span>Sin Respuesta</td>";
          }else{
            echo "<td><span class=badge-dot badge-brand mr-1 style='background: lightgreen;'></span>Respondido</td>";
          }

          ?>
          
        <?php
            $numMsn++;
          }
        ?>
      </tr>
    </tbody>
  </table>
</div>


</section>
	<div class="push"></div>
	
	<footer class="footer2">
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

  
  document.querySelector(id).onchange = function() {
      document.querySelector(id).style.display = 'block';

  };
}

setInterval(function(){ 
 funcionHora();
}, 1000);


var hora =""; 
    function funcionHora(){
        var d = new Date();
        hora = d.toLocaleTimeString();
        var x = document.querySelectorAll('.hora');        
        i=0;
        while(i < x.length){
            x[i].value = hora;
          i++;
        }
    }

    var fecha = "";    
    getfecha();    
    function getfecha(){
        var y = new Date();
        var ano = y.getFullYear();
        var dia = y.getDate();
        var mes = (y.getMonth()+1).toString().padStart(2, '0');
        fecha = ano+'-'+mes+'-'+dia;
        //document.querySelector('#fechaCons').value = fecha;
        var z = document.querySelectorAll('.fecha');        
        i=0;
        while(i < z.length){
            z[i].value = fecha;
          i++;
        }
    }





</script>

















</body>
</html>