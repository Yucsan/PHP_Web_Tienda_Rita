<?php

  session_start();

  if (!isset($_SESSION['idUsu']) || $_SESSION['rolUsu'] != 'Admin') {
    header('Location: index.php');
  }

  require '../includes/conexion.inc.php';
    
  $nombre = $_SESSION['nombreUsu'];
  $fotito =$_SESSION['fotoUsu'];


  if($_POST){
    if( isset($_POST['respuesta']) && !empty($_POST['respuesta']) ){
      $resp = $_POST['respuesta'];
      $idConsulta = $_POST['idCons'];

        $sqlRespuesta ="
          UPDATE consulta
           SET respuesta_consulta = '".$resp."'
           WHERE id_consulta LIKE '".$idConsulta."';
        ";
        $queryRespuesta = mysqli_query($conectar, $sqlRespuesta);

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
	<title></title>
</head>
<body>


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
          <a class="nav-link active">Principal</a>
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
          <a class="nav-link" href="pedidos.php">Pedidos</a>
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


<!-- GRAFICAS -->
<div class="datos1" style="">

  <div id="canvas-holder" class="bloques" style="">
      <canvas id="chart-area"></canvas>
      <div class="titulosGraficas">Cuadros con más me gustan('LIKES')</div>
  </div>

  <div class="bloques" style="">
    <canvas id="canvas"></canvas>
    <div class="titulosGraficas">Título Gráfica 2</div>
  </div>

  <div class="bloques" style="">
    <canvas id="canvas3"></canvas>
    <div class="titulosGraficas">Título Gráfica 3</div>
  </div>
</div> 



<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
  <div class="card tabla1" style="margin: 15px;">
    <h5 class="card-header">Mensajes</h5>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table">
          <thead class="tabla1_head">
            <tr class="border-0">
              <th class="border-0">Imagen</th>
              <th class="border-0">Correo</th>
              <th class="border-0">Nombre</th>
              <th class="border-0">#cons</th>
              <th class="border-0">Cuadro</th>
              <th class="border-0">Mensaje</th>
              <th class="border-0">Respuesta</th>
              <th class="border-0">Fecha</th>
              <th class="border-0">Hora</th>
              <th class="border-0">Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sqlMensajes ="
              SELECT id_usuario, foto_usuario, correo_usuario, nombre_usuario,  id_consulta, id_producto, mensaje_consulta, respuesta_consulta, fecha_consulta, hora_consulta, estado_consulta, foto_producto, id_producto, nombre_producto 
              FROM consulta
              JOIN usuario USING (id_usuario)
              JOIN producto USING (id_producto)
              WHERE respuesta_consulta LIKE 'Sin leer' 
              ORDER BY fecha_consulta DESC;
            ";
            $queryMensajes = mysqli_query($conectar, $sqlMensajes);
              while ($rowMensajes = mysqli_fetch_assoc($queryMensajes)) {
              
            ?>
            <tr>
              <td>
                <div><img class="imgTabla" src="../<?php echo $rowMensajes['foto_usuario']?>" alt="user">
                </div>
              </td>
              <td class="tam14"><?php echo $rowMensajes['correo_usuario']?></td>
              <td class="tam14C"><?php echo $rowMensajes['nombre_usuario']?></td>
              <td class="tam14" ><?php echo $rowMensajes['id_consulta']?></td>
             
              <td class="tam14" ><a data-toggle="modal" data-target="#exampleModal<?php echo $rowMensajes['id_producto'];?>" href=""><img class="imgTabla" src="../<?php echo $rowMensajes['foto_producto']?>"></a></td>

              <td><?php echo $rowMensajes['mensaje_consulta']?></td>
              <td>
                <form class="formRespuesta" method="POST" action="" name="responder">
                  <input type="hidden" name="idCons" value="<?php echo $rowMensajes['id_consulta']?>">
                  <input class="resp" type="text" value="<?php echo $rowMensajes['respuesta_consulta']?>" name="respuesta" required placeholder="respuesta">
                  <button class="btnRes" type="submit">Enviar</button>
                </form>
              </td>
              <td class="tam14"><?php echo $rowMensajes['fecha_consulta']?></td>
              <td class="tam14"><?php echo $rowMensajes['hora_consulta']?></td>
              <td>
              <?php
                $answer =  $rowMensajes['respuesta_consulta'];
                if($answer == 'Sin leer'){
                  echo "<span class=badge-dot badge-brand mr-1 style='background: red;'></span>No";
                }else{
                  echo "<span class=badge-dot badge-brand mr-1 style='background: lightgreen;'></span>Si";
                }
              ?>
              </td>
           </tr>
           <!-- MODAL  EDICION DE USUARIOS-->
                  <div class="modal fade" id="exampleModal<?php echo $rowMensajes['id_producto'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Nombre Cuadro: <span style="color:purple;"><?php echo $rowMensajes['nombre_producto'];?></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <img src="../<?php echo $rowMensajes['foto_producto'];?>">
                        <form action="" method="POST" name="modalRespuesta">
                        <div class="modal-body">
                          <label class="etiquetas">Pregunta: <?php echo $rowMensajes['nombre_usuario'];?>"</label>
                          <p style="margin-bottom: 3px;"><?php echo $rowMensajes['mensaje_consulta'];?></p>
                          <div style="display: flex; flex-direction: column;">
                            <label class="etiquetas">respuesta</label>
                            <textarea name="respuesta" class="rModal" style=""></textarea>
                            <input type="hidden" name="idCons" value="<?php echo $rowMensajes['id_consulta']?>">
                          </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="submit" name="btnEditUsu" class="btn btn-success">Enviar Respuesta</button>
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

<style type="text/css">

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

  .btnRes{
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

  .tam14{
    font-size: 14px;
  }

  .tam14C{
    font-size: 14px;
    text-transform: capitalize;
  }

  .imgTabla{
    border-radius: .25rem !important;
    width: 45px; 
    height: 45px; 
    object-fit: cover;
  }


</style> 


<footer>
  <div class="copiRight" style="color:white">
    <div style="padding: 25px; background: var(--darkm);">
      <img style="height: 23px; opacity:0.5;" src="assets/rsc/img/logo3.svg"></div>
  </div>
</footer>


<!-- GRAFICAS CHARTSETS -->

<?php
  
  $arrayLikes = array();
  $cuadros = array();
  $labels = array();

  $sqldataLikes ="
    SELECT id_producto, nombre_producto, COUNT(like_consulta) AS likes
      FROM consulta
          JOIN producto USING (id_producto)
          WHERE like_consulta LIKE 1
              GROUP BY id_producto
                  ORDER BY likes DESC
                    LIMIT 4;
  ";
  $querydataLikes = mysqli_query($conectar, $sqldataLikes);

  while($rowLikes = mysqli_fetch_assoc($querydataLikes)){

    $arrayLikes[$rowLikes['id_producto']] = $rowLikes['likes'];
    $cuadros[] = $rowLikes['id_producto'];
    $labels[] = $rowLikes['nombre_producto'];  

  }

//print_r($arrayLikes);
//echo "<br>";
//print_r($cuadros);
//echo $cuadros[0]; 
//echo $labels[0];
//echo "<br>";
//echo $arrayLikes[$cuadros[0]];
//echo "<br>";
//echo $cuadros[1];
//echo $labels[1]; 
//echo "<br>";
//echo $cuadros[2];
//echo $labels[2];
//echo "<br>";
//echo $cuadros[3];
//echo $labels[3];

?>


    <script type="text/javascript" src="assets/vendor/jquery/jquery_3.6.0.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/vendor/chartjs/Chart.js"></script>
    <script src="assets/vendor/chartjs/utils.js"></script>

    <script type="text/javascript">

 // GRAFICA DE PIE ---

var dat1 = <?php echo json_encode($arrayLikes[$cuadros[0]]); ?>;
var dat2 = <?php echo json_encode($arrayLikes[$cuadros[1]]); ?>;
var dat3 = <?php echo json_encode($arrayLikes[$cuadros[2]]); ?>;
var dat4 = <?php echo json_encode($arrayLikes[$cuadros[3]]); ?>;

var label1 = <?php echo json_encode($labels[0]); ?>;
var label2 = <?php echo json_encode($labels[1]); ?>;
var label3 = <?php echo json_encode($labels[2]); ?>;
var label4 = <?php echo json_encode($labels[3]); ?>;

    /*dat1 = 15
    dat2 = 20
    dat3 = 65
    dat4 = 32*/

    var config1 = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
            dat1,
            dat2,
            dat3,
            dat4,
          ],
          backgroundColor: [
            window.chartColors.tomato,
            window.chartColors. yellow,
            window.chartColors.purple,
            window.chartColors.green,
          ],
          label: 'Dataset 1'
        }],
        labels: [
          label1+' = '+dat1+'%',
          label2+' = '+dat2+'%',
          label3+' = '+dat3+'%',
          label4+' = '+dat4+'%'
        ]
      },
      options: {
        responsive: true
      }
    };


    // GRAFICA DE LINEAS ---

    var config2 = {
      type: 'line',
      data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
        datasets: [{
          label: 'My First dataset',
          backgroundColor: window.chartColors.grey,
          borderColor: window.chartColors.tomato,
          data: [
            10,
            5,
            30,
            8,
          ],
          fill: false,
        }, {
          label: 'My Second dataset',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.purple,
          data: [
            2,
            7,
            13,
            8,
          ],
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Chart.js Line Chart'
          },
          tooltip: {
            mode: 'index',
            intersect: false,
          }
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Month'
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Value'
            }
          }
        }
      }
    };

//  BARRAS -----
    var color = Chart.helpers.color;
    var barChartData = {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
      datasets: [{
        label: 'Likes',
        backgroundColor: color(window.chartColors.tomato).alpha(0.5).rgbString(),
        borderColor: window.chartColors.tomato,
        borderWidth: 1,
        data: [
          10,
          6,
          9,
          2,
          7,
          2,
          7
        ]
      }, {
        label: 'Dataset 2',
        backgroundColor: color(window.chartColors.purple).alpha(0.5).rgbString(),
        borderColor: window.chartColors.purple,
        borderWidth: 1,
        data: [
          4,
          2,
          8,
          6,
          9,
          1,
          5
        ]
      }]

    };
 



    window.onload = function() {
      var ctx1 = document.getElementById('chart-area').getContext('2d');
      window.myPie = new Chart(ctx1, config1);
        var ctx2 = document.getElementById('canvas').getContext('2d');
      window.myLine = new Chart(ctx2, config2);

      var ctx3 = document.getElementById('canvas3').getContext('2d');
      window.myBar = new Chart(ctx3, {
        type: 'bar',
        data: barChartData,
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Chart.js Bar Chart'
            }
          }
        }
      });

    };





    </script>



</body>
</html>