<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';
    
  if ($_GET){
      
      //echo $_GET['like'];
    

    $sqlLike = "
       SELECT id_producto, like_consulta
	        FROM consulta
    	        JOIN usuario USING (id_usuario)
                    WHERE nombre_usuario LIKE '".$_GET['like']."';
            
    ";

    $likesApi = null;
    $queryLike = mysqli_query($conectar, $sqlLike);
    while ($rowqueryLike = mysqli_fetch_assoc($queryLike)){
        $likesApi[] = $rowqueryLike;
        
    }
    header('Content-type: application/json');
    echo json_encode($likesApi);

 
  }
 
 
 
 
            
?>