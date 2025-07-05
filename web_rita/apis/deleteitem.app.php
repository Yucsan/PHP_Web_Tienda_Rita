<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';
    

  if ($_GET){

    $idPedido = $_GET['id'];
    $idProducto = $_GET['prod'];
    
    
    $sqlBorrar = "
        DELETE FROM compra
            WHERE id_pedido LIKE '".$idPedido."' AND id_producto LIKE '".$idProducto."';
    
    ";
    $queryBorrar = mysqli_query($conectar, $sqlBorrar);
    
    // RECUENTO las existencias
    $numExistencias = "";
    $sqlExistencias ="
        SELECT COUNT(*) AS existencias
	        FROM compra
    	        WHERE id_pedido LIKE '".$idPedido."';
    ";
    $queryExistencias = mysqli_query($conectar, $sqlExistencias);
    while ($rowqueryExistencias = mysqli_fetch_assoc($queryExistencias)){
        
         $numExistencias = $rowqueryExistencias['existencias'];
    }
    
    // SI ES 0 ELIMINO EL PEDIDO
    if ($numExistencias == 0){
        
        $sqlBorrarPedido = "
            DELETE FROM pedido
                WHERE id_pedido LIKE '".$idPedido."';
        ";
        $queryBorrarPedido = mysqli_query($conectar, $sqlBorrarPedido);

    }else if($numExistencias > 0){
        
        $sqlActualizaExistencias = "
            UPDATE pedido
                SET cantidad_pedido = '".$numExistencias."'
                WHERE id_pedido LIKE '".$idPedido."';
        ";
        $queryActualizaExistencias = mysqli_query($conectar,  $sqlActualizaExistencias);
        
    }

 
  }
  
  
  
  
  
  