<?php


	require 'includes/conexion.inc.php';
	
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
            
                if ($page == 1){
                    
                    $primerNum = 1;
                    $segundoNum = 8+1;
                    
                }elseif($page >= 2){
                    
                    $primerNum = $page*8-8;
                    $segundoNum = $page*8;
                    
                }

               if ($_POST){
					if (isset($_POST['buscar']) && !empty($_POST['buscar'])){

                    $sqlProductos ="
                        SELECT * 
                            FROM producto
                            JOIN estilo USING (id_estilo)
		                    WHERE nombre_producto LIKE '%".$_POST['buscar']."%' OR
		                    tema_estilo LIKE '%".$_POST['buscar']."%';
                    ";
                    

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




             if(isset($_GET['nada'])){
              echo "NO HAY RESULTADO DE LA BUSQUEDA";
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
		

	</style>
</head>

<body onscroll="alto()" style="background: #F4F4F4;">
<div id="starter" class="body">

<div class="alert alert-info" id="likesAviso" role="alert" style="display: none; margin-bottom: 0px;">
  Te invitamos a registrarte!, Los me gustan sin registro solo se almacenan en el navegador de este dispositivo y seran eliminados en 48 horas;
</div>

<div onclick="home()" class="btnHome" style="">
<img class="logoWeb" src="assets/rsc/img/webLogo.gif" style="width: 130px; border:  #793DA3 solid 6px; position: relative;z-index: 100;border-radius: 63px;">
</div>

<div onclick="home()" class="logoHorizontal" style="cursor: pointer;">
  <img style="width: 80%" src="assets/rsc/img/weblogorita.gif">
</div>

<nav class="navbar navbar-expand-lg navbar-dark navCustom" style="z-index: 20;">
    
 <form action="" method="POST" class="buscaNav">
        <input name="buscar" class="inputCustom me-2" type="search" placeholder="Buscar" aria-label="Search">
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
          <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php#sobreMi">Sobre Mi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  active" >Cuadros</a>
        </li>
        <li class="nav-item btnIniNavDesktop">
          <a class="nav-link" href="#" onclick="goHome()">
            Iniciar Sesión <i class="far fa-user"></i>
          </a>
        </li>
        <!-- PARA MOVILES -->
        <li class="nav-item btnIniNavMoviles">
          <a class="nav-link" href="#" onclick="goHome2()">
            Iniciar Sesión <i class="far fa-user"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registro1.php">Registro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="recupera.php">Recuperar Contraseña</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="activa.php">Re-Activa Cuenta</a>
        </li>
      </ul>

    </div>
        
  </div>
</nav>

<div class="buscaNuevo" style="">
  <form method ="POST" class="DesktopBusca">
          <input name = "buscar" class="inputCustom2 me-2" type="search" placeholder="buscar" aria-label="Search">
          <button class="btn btn-dark btnCustom" type="submit">buscar</button>
  </form>
</div>

<!-- Barra Usuario -->
<div class="barraUsuario" style="">

  <ul class="ulUsuario extraCss" style="">
    <li class="nombreUser" style="margin-right: 20px;">
     Sin Usuario
     <img src="assets/rsc/img/sinregistro.jpg" class="fotoUser" style="">
    </li>
  </ul>

</div>


<!-- SECCION CON PRODUCCTOS -->
<script>var conteEstados = []; </script>

<div class="container-fluid productos swiperMain">

  <div class="row">
    <div class="col-md-12 col-lg-1 R1"></div>
    <div class="col-md-12 col-lg-10 bloqueProductos">

<?php 
    $pinturita ="";
    $contador = 1;
    $conte = 0;
    while ($rowqueryProductos = mysqli_fetch_assoc($queryProductos)){


        $idProducto = $rowqueryProductos['id_producto'];

        $pinturita = $rowqueryProductos;

?> 

<!-- CARTA -->

      <div class="card cuadro1" style="">
        <img src="<?php echo $rowqueryProductos['foto_producto']?>" style="border: solid 10px #EDBC41" class="card-img-top" alt="cuadro">
            <div class="card-body" style="display: flex; justify-content: end; flex-direction: column;">
   
                <i class="far fa-heart likeCard" id="play<?php echo $rowqueryProductos['id_producto']; ?>" style="cursor: pointer; color: gray; text-align: center" onclick = "sinlike(this.id);"></i>
                <?php echo "<script>var estado".$conte." = false; conteEstados.push(estado".$conte."); </script>"; ?>

                <h5 class="card-title" style="color: var(--morado);"><?php echo $rowqueryProductos['nombre_producto']; ?></h5>
                <p class="card-text">Cuadro de estilo Naif inspirado en la primavera. <br>
                <span style="color:var(--morado)">Medidas:</span><span> 32 cm x 32 cm </span><br>
                <span style="color:var(--morado)">Material:</span><span> Acrilico</span>
                </p>

                <div style="background: none; position: relative;">
                <a href="vercuadro1.php?ident=<?php echo $rowqueryProductos['id_producto']?>&pag=<?php echo $page;?>" class="btn botonCarta">ver cuadro</a>

                <div class="tooltipCustom" onclick="debes();">

              <i style="position: absolute; right: 0px; bottom: 0px;" class="fas fa-shopping-cart carritoCarta"></i>
              <span class="tooltiptext">Debes Registrate para añadir productos</span>
            </div>
          </div>

        </div>
      </div>

<?php 
      
        $contador++; 
        $conte++;
    }
    if($pinturita == null){
      echo "<script>window.location='prod.php?pag=1&nada=na'</script>";
    }
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
            <li class="page-item" aria-current="page"><a class="page-link" href="prod.php?pag=<?php echo $i?>"><?php echo $i; ?></a></li>
            <?php
        }  
    $i++;
    }    
?>
        </ul>
    </nav> 

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
    <img style="width: 50px; margin-right: 10px" src="assets/rsc/img/facebook.svg">
    <img style="width: 50px;" src="assets/rsc/img/instagram.svg">
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


function debes(){
  //alert('Debes Registrate para poder Hacer compras');


      Swal.fire({
        title: 'Debes Registrate!',
        text: 'para poder Hacer compras',
        icon: 'info',
        confirmButtonText: 'Continuar',
        customClass: {     
              confirmButton: 'confirmSweet',
              title: 'titleSweet'
            },
      })

}

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

var safeFecha = localStorage.getItem('fecha');

if (safeFecha == null || safeFecha == "" ){
  getfecha(); 
  console.log('fecha nueva');
}else{

  let ano = safeFecha.substr(0,4);
  let mes = safeFecha.substr(5,2);
  let dia = safeFecha.substr(8,10);

    var w = new Date();
      var nAno = w.getFullYear();
      var nDia = w.getDate();
      var nMes = (w.getMonth()+1).toString().padStart(2, '0');

      if (ano == nAno){
        console.log('mismo Año');
          if(mes == nMes){
            console.log('mismo mes');
              if(dia == nDia){
                console.log('mismo dia');

                  //mayor ó = que 2
              }else if((dia - nDia) >= 2 ){
                console.log('dia+2');
                localStorage.removeItem('safe');
                getfecha();
              }

          }else{
            console.log('Meses');
            localStorage.removeItem('safe');
            getfecha();
          }


      }else{
        console.log('Años');
        localStorage.removeItem('safe');
        getfecha();
      }


}


var pagina = <?php echo json_encode($page); ?>;
var npag = <?php echo json_encode($numPaginas); ?>;


  var fecha = "";      
  function getfecha(){
      var y = new Date();
      var ano = y.getFullYear();
      var dia = y.getDate();
      var mes = (y.getMonth()+1).toString().padStart(2, '0');
      fecha = ano+'-'+mes+'-'+dia;
      localStorage.setItem('fecha', fecha);

  }




dataExist = JSON.parse(localStorage.getItem('safe'));


if(dataExist == null || dataExist == "" ){

  var likes = new Array(npag+1).fill(0).map(() => new Array(0));


}else{

  var likes = dataExist;
  if (likes[pagina-1] != ""){

    console.log('pinto');
    console.log(likes[pagina-1].length);


    i=0;
    while(i < likes[pagina-1].length){
      console.log('#'+likes[pagina-1][i]);
      document.querySelector('#'+likes[pagina-1][i]).className = 'fas fa-heart likeCard';
      document.querySelector('#'+likes[pagina-1][i]).style.color = 'purple';
      i++;
    }


  }else{
    console.log('nada');
  }

}


console.log(likes);



// pinta y guarda LIKES FRONT
  function sinlike(id){
    //console.log(id);
    document.querySelector('#likesAviso').style.display = 'block';  

    var pag = pagina - 1;
    //console.log(pag);

    
    if(likes[pag].includes(id)){

    document.querySelector('#'+id).className = 'far fa-heart likeCard';
    document.querySelector('#'+id).style.color = 'gray';

    let indice = likes[pag].indexOf(id);
    console.log(indice);
    likes[pag].splice(indice, 1);
    console.log(likes); 
    localStorage.setItem('safe', JSON.stringify(likes));
    
    }else{

    document.querySelector('#'+id).className = 'fas fa-heart likeCard';
    document.querySelector('#'+id).style.color = 'purple';

    
    likes [pag].push(id);
    console.log(likes);
    localStorage.setItem('safe', JSON.stringify(likes));

    }

    
  }


function home(){
  window.location = "index.php";
}


function goHome(){
    sessionStorage.setItem('session','true');
    window.location = "index.php";
}

function goHome2(){
    sessionStorage.setItem('session','true1');
    window.location = "index.php";
}


function redi(){
  console.log('redirecciona');
  //window.location = 'https://www.w3schools.com';
  //window.open("https://www.w3schools.com"); 
}

 var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
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