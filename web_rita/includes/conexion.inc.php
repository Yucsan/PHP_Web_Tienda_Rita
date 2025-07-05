<?php

	// error_reporting(0);

	$servidorBD = "localhost";
	$usuarioBD = "root";
	$claveBD = "";
	$nombreBD = "loscuadrosderita_com_store_db";

	$conectar = mysqli_connect($servidorBD, $usuarioBD, $claveBD, $nombreBD, 3307);

	mysqli_set_charset($conectar, "utf8mb4");

	if (!$conectar) {
		die('Error al conectar con la BBDD. Inténtelo más tarde');
	}

?>