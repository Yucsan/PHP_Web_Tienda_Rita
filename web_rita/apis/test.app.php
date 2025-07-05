<?php
    require '../includes/conexion.inc.php';
    require 'cabeceras.app.php';

    $id = 2;
    $numProducto = 1;

        $sqlConsulta = "
            SELECT id_consulta
	            FROM consulta
                    WHERE id_usuario LIKE '".$id."' && id_producto LIKE '".$numProducto."';
        ";
        $queryConsulta = mysqli_query($conectar, $sqlConsulta);
        
        while ($rowqueryConsulta = mysqli_fetch_assoc($queryConsulta)){
            
            echo $id_consulta = $rowqueryConsulta['id_consulta'];
        }
        
?>        