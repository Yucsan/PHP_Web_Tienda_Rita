<?php

    if ($_GET){
        if (isset($_GET['idUsuario']) && !empty($_GET['idUsuario'])){
        
            require 'includes/conexion.inc.php';
            $sqlValidar = "
                UPDATE usuario
                    SET validado_usuario = 1
                    WHERE id_usuario LIKE ".$_GET['idUsuario'].";
            ";
            $queryValidar = mysqli_query($conectar, $sqlValidar);

            mysqli_close($conectar);
            header('Location: index.php?validado');
            
        }else{
            header('Location: index.php');
        }
    }else{
        header('Location: index.php');
    }
    
?>