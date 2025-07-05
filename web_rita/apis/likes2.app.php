<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';
    
//http://loscuadrosderita.com/demo/apis/likes2.app.php?nombre=Pepe&prod=3&accion=1"

  if ($_GET){

     //echo $_GET['nombre'];
    echo $id = $_GET['id'];
    echo $nombre = $_GET['nombre'];
    echo $numProducto = $_GET['prod'];
    echo $fecha = $_GET['fecha'];
    echo $hora = $_GET['hora'];
    echo $accion = $_GET['accion'];

    $sqlDataLike = "
       SELECT id_producto, like_consulta
	        FROM consulta
    	        JOIN usuario USING (id_usuario)
                    WHERE id_usuario LIKE '".$id."';
            
    ";

    //$likesApi = null;
    $queryDataLike = mysqli_query($conectar, $sqlDataLike);
    
    $estados = array();
    $productos = array();
    
    while ($rowqueryDataLike = mysqli_fetch_assoc($queryDataLike)){
        //$likesApi[] = $rowqueryLike;
        
        $productos[] = $rowqueryDataLike['id_producto'];
       
       
          $estados[] = $rowqueryDataLike['like_consulta'];
           
    }
    
    //print_r($productos);
      //echo "<br>";
     //print_r($estados);
    
    echo "<br>";
     


     
     if (in_array($numProducto, $productos)){
         echo "existe: ".$numProducto;
         
            //rescata id_consulta
            $id_consulta = "";
    
            $sqlConsulta = "
            SELECT id_consulta
	            FROM consulta
                    WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$numProducto."';
            ";
            $queryConsulta = mysqli_query($conectar, $sqlConsulta);
        
            while ($rowqueryConsulta = mysqli_fetch_assoc($queryConsulta)){
            
                $id_consulta = $rowqueryConsulta['id_consulta'];
            }
            
            //actualiza Like
            $sqlActualizaLike ="
            UPDATE consulta
                SET like_consulta = '".$accion."', fecha_consulta = '".$fecha."', hora_consulta = '".$hora."'
                    WHERE id_consulta LIKE '".$id_consulta."';
            ";
            $queryActualizaLike = mysqli_query($conectar, $sqlActualizaLike);
        
        
        }else{
            echo "No existe: ".$numProducto;
            
        //echo "Insertar".$numProducto;
            $sqlInsertLike ="
                INSERT INTO consulta
                    VALUES (null, '".$id."', '".$numProducto."','','','".$accion."','".$fecha."','".$hora."','' );
            ";
            $queryInsertLike = mysqli_query($conectar, $sqlInsertLike);
        }
        

 
  }
 

 
 ?>
 
 
 
 
 