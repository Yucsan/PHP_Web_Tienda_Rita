<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';
    
//http://loscuadrosderita.com/demo/apis/likes2.app.php?nombre=Pepe&prod=3&accion=1"

  if ($_GET){

    
    $idPay = $_GET['pay'];

    $sqlPay = "
       UPDATE compra
	        SET id_estado = 2
    	        WHERE id_pedido LIKE '".$idPay."';
            
    ";
    $queryPay = mysqli_query($conectar, $sqlPay);
    
  }

 
 ?>
 
 