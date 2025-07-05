<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
    require 'includes/conexion.inc.php';
    
    $id = $_SESSION['idUsu'];
	  $nombre = $_SESSION['nombreUsu'];
    $fotito =$_SESSION['fotoUsu'];
    
    
    $pyunidades = array();//Productos y unidades
    
    //$carritoCompra = array();
    //$idpedidoActual ="";    

if($_POST){
  
//print_r($_POST);
    foreach ($_POST as $key => $value) {
                //echo $key.": ".$value."<br>";
             
        if (substr($key, 0, 2) == 'id'){
               
                $pyunidades[substr($key, 2)] = $value;
        }

    }
    //print_r($productos);
    //print_r($pyunidades);//PRODUCTO Y UNIDADES
    //echo "<br>";      

      
}else{
   header('Location: productos.php?pag=1');
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
 
<style type="text/css">
  
.list-group-item{
  background-color: transparent;
  border: none; 
}


</style>


<body style="background: #F4F4F4;">
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
  </ul>
</div> 


<section  style="display: flex; justify-content: center; background: none;">
  
    <div class="table-responsive" style="background: #f9f7f7;">
      <h3 style="text-align: center; color: gray;" class="card-header">Inventario del pedido</h3>
      <table class="table" style="margin-bottom: 0;">
        <thead style="background: #7d777d;  color: snow;">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">medidas</th>
            <th scope="col">Unidades</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>
        <tbody>

    <!-- INICIO DE FORMULARIO -->
    <form class="formPedido" name="compraYdireccion" method="POST" action="pagoydom.php">

      <?php 
      $sqlCarrito = "
      SELECT *
      FROM producto;
      ";
      $queryCarrito = mysqli_query($conectar, $sqlCarrito);
      $count = 1;
      $numeracion = 1;
      echo "<script> var contador = [];</script>";
      while ($rowqueryCarrito = mysqli_fetch_assoc($queryCarrito)){
        $idProducto = $rowqueryCarrito['id_producto'];
        //Filtro solo el pedido
        
        if (array_key_exists($idProducto, $pyunidades)){
          
          // echo $rowqueryCarrito['nombre_producto'];          
      ?>
<tr id="padre<?php echo $rowqueryCarrito['id_producto'];?>">      
<th><?php echo $numeracion; ?></th>
  <td>
      <div id="<?php echo "produ".$rowqueryCarrito['id_producto']; ?>" class="list-group-item liClass" style="display: flex; align-items: center;"> 
        <img src="<?php echo $rowqueryCarrito['foto_producto'];?>" class="imagencita" style="margin-right: 12px">
        <div class="contePedido" style="" >

          <!-- Número de producto y ID  -->
          <input type="hidden" name="<?php echo $rowqueryCarrito['id_producto'];?>" value="<?php echo $pyunidades[$idProducto]?>">
          <input class="nameProduct" style="color: purple; width: 220px; margin-right: 12px;" type="text" value="<?php echo $rowqueryCarrito['nombre_producto'];?>"readonly>
        </div> 
  </td>
  <td>        
          <span style="color: gray;">medidas:
             <input type="text" value="<?php echo $rowqueryCarrito['medida_producto'];?>"  style="width: 100px;" readonly>
          </span>
  </td>
  <td>      
          <!--UNIDADES de PRODUCTO  -->
          <span style="color: gray;">unidades: 
              <input type="number"  value="<?php echo $pyunidades[$idProducto]; ?>" style="width: 80px;">
          </span>
  </td>  
  <td>   
          <span style="color: gray;">precio: S/. 
              <input type="number" value="<?php echo $rowqueryCarrito['precio_producto'];?>" style="width: 80px;" readonly>
          </span>
        </div>
        <button id="<?php echo "close".$rowqueryCarrito['id_producto']; ?>" onclick="elimina(this.id);" type="button" class="btn-close moveB" aria-label="Close"></button>
        <?php echo "<script> contador.push('prod'+".$numeracion.");</script>"?>
  </td>        
</tr>

      <?php 
          $numeracion++;
        }

        $count++;         
      }
      ?>
<tr> 
  <td colspan="5">
      <input type="hidden" id='cuentaFinal' name="total" value="<?php echo $numeracion - 1;?>">

        <div colspan = "5" class="list-group-item" style="text-align: center; /*color: gray;*/">
          <h3 style="color: purple;">Ingresa la Dirección de Entrega</h3>
          <input class="inpCustom" type="text" name="direccion" value="" required placeholder="direccion*">

          <div class="inpDire" style="">
            <input class="inp2 cl576" type="text" name="codigoPostal" value="" required placeholder="Codigo Postal*">
            <input class="inp2" type="text" name="pais" value="" required placeholder="pais*">
          </div>

          <div class="inpDire" style="">
            <input class="inp2 cl576" type="text" name="provincia" value="" required placeholder="provincia*">
            <input class="inp2" type="text" name="distrito" value="" required placeholder="distrito*">
          </div>

          <div class="inpDire2 dire2Custom" style="">
            <input class="inp2 smallInp" type="number" name="numero" value="" required placeholder="numero*">
            <input class="inp2 smallInp" type="text" name="planta" value="" required placeholder="planta*">
          </div>

          <div class="wrappInput3" style="">
            <input class="inp4" type="text" name="puerta" value="" required placeholder="puerta*">
            <div>
              <label style="margin-right: 5px;">Escalera</label>
              <input class="inp4" type="text" name="escalera" value="Sin" required placeholder="escalera*">
            </div>

            <div>
              <label style="margin-right: 5px;">Portal</label>
              <input class="inp4" type="text" name="portal" value="Sin" required placeholder="portal*">
            </div>
            <input type="hidden" id='hour' name="hora" value="">
            <input type="hidden" id='date' name="fecha" value="">
          </div>
        </div>
  </td>      
</tr>    

  </tbody>
 </table>
</div> 
<div class="aviso">
  Debes llenar todos los campos si en caso tu dirección no necesita Escalera, Portal o Planta, los rellenas con "Sin" como ya están marcados si no llenas todos los campos deberás volver a ingresar tu dirección.
</div>

<style type="text/css">
  .aviso{
    width: 60%;
    color: blueviolet;
    text-align: center;
    margin: 10px;
  }

  
</style>

      <div style="background: none; display: flex; justify-content: space-evenly; width: 100%; margin: 30px 0px 30px 0px;">
        <a class="btnCompra2" href="productos.php?pag=1"><i style="font-size: 20px;" class="fas fa-arrow-left"></i>&nbsp;&nbsp;volver</a>
        <div class=".btnBuyWrapperP3" style="background: none;">
          <button onclick="limpiaCarrito()" class="btntarjeta" type="submit">Continuar con la compra</button>
          <!-- <a class="btntarjeta" href="entrega.php">Pago contra entrega</a> -->
        </div>
      </div>  
    </form>

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
<script type="text/javascript" src="assets/vendor/sweealert2/js/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript">


    // LIMPIAR CARRITO LOCALSTORAGE

    function limpiaCarrito(){
            sessionStorage.clear();
            console.log("Carrito Limpio");
        }

    function elimina(ident){
        // Si borras el último producto te vuelve a Productos y se actualia la DB
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
                let me = '#padre'+producto;
                //let padre = me.parentNode.getAttribute("id");
                
                document.querySelector(me).remove();
                fetch('https://loscuadrosderita.com/web/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
                
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
            let me = '#padre'+producto;
            //let padre = me.parentNode.getAttribute("id");

            //console.log(me);
            document.querySelector(me).remove();

            //RESTO AL TOTAL DEL INPUT
            let cuenta = document.querySelector('#cuentaFinal').value;
            cuenta -=1;
            document.querySelector('#cuentaFinal').value = cuenta;

            contador.pop();    
            console.log(contador); 
            fetch('https://loscuadrosderita.com/web/apis/deleteitem.app.php?id='+numPedido+'&prod='+producto);
            }

    }


/* EL ARRAY DE CONTADOR: solo es para saber el número de existencias 
    para cuando solo quede 1 avice que esta a punto de cargarse la compra 
      y volver a la página de productos
*/
    console.log(contador);

var hora =""; 
funcionHora();
    function funcionHora(){
        var d = new Date();
        var n = d.getHours().toString().padStart(2, '0');
        var m = d.getMinutes().toString().padStart(2, '0');
        hora = n+':'+m;
        console.log(hora);
        document.querySelector('#hour').value = hora;
    }


  setInterval(function(){ 
   funcionHora();
  }, 60000);


    var fecha = "";    
    getfecha();    
    function getfecha(){
        var y = new Date();
        var ano = y.getFullYear();
        var dia = y.getDate();
        var mes = (y.getMonth()+1).toString().padStart(2, '0');
        //console.log(ano+'-'+mes+'-'+dia);
        fecha = ano+'-'+mes+'-'+dia;
        console.log(fecha);
        document.querySelector('#date').value = fecha;
    }
    
</script>
	












</body>
</html>


 