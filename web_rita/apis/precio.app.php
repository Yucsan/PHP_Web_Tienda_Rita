<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';
    

  if ($_GET){
        
        
    $idProdu = $_GET['prod'];

    $sqlPrecio = "
       SELECT precio_producto
	        FROM producto
                    WHERE id_producto LIKE '".$idProdu."';
    ";
    
    $precioApi = null;    
     $queryPrecio = mysqli_query($conectar,  $sqlPrecio);
        while ($rowqueryPrecio = mysqli_fetch_assoc($queryPrecio)){
            
            $precioApi[] = $rowqueryPrecio;

    }
    header('Content-type: application/json');
    echo json_encode($precioApi);
   
  }

 
 ?>