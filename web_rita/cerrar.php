<?php

	session_start();
	require 'includes/conexion.inc.php';

	$id = $_SESSION['idUsu'];
	$sqlActualizaEstado = "
		UPDATE usuario
			SET estado_usuario = 0,
			    finc_usuario = '".date('Y-m-d H:i')."'
			WHERE id_usuario LIKE ".$id.";
	";
	$queryActualizaEstado = mysqli_query($conectar, $sqlActualizaEstado);

	mysqli_close($conectar);
	session_destroy();
	setcookie("idUsuario", "", time()-63072000);
	header('Location: index.php');

?>