<?php

    if ($_POST) {
		/*
		echo $_POST['correo'];
		echo "<br>";
		echo $_POST['clave'];
		echo "<br>";
		if (isset($_POST['recordar'])) {
			echo $_POST['recordar'];
		}
		*/

		// Comprobamos que lleguen bien los Datos
		if ((isset($_POST['correo']) && !empty($_POST['correo'])) && (isset($_POST['clave']) && !empty($_POST['clave']))) {
			$correo = $_POST['correo'];
			// Conectamos con la Base de Datos
			require '../includes/conexion.inc.php';
			$sqlLogin = "
				SELECT *
					FROM usuario
						JOIN rol USING (id_rol)
					WHERE correo_usuario LIKE '".$correo."';
			";
			$queryLogin = mysqli_query($conectar, $sqlLogin);
			if (mysqli_num_rows($queryLogin) < 1) {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 0px; left: 0px; width: 100%;">Usuario y/o Contraseña incorrectos<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			}else{
				$clave = $_POST['clave'];
				while ($rowLogin = mysqli_fetch_assoc($queryLogin)) {
				    if ($rowLogin['id_rol'] == 1){
				        if (password_verify($clave, $rowLogin['clave_usuario'])) {
    						if ($rowLogin['validado_usuario'] == 1) {
    							if ($rowLogin['activo_usuario'] == 1) {
    								session_start();
    								$_SESSION['idUsu'] = $rowLogin['id_usuario'];
    								$_SESSION['nombreUsu'] = $rowLogin['nombre_usuario'];
    								$_SESSION['correoUsu'] = $rowLogin['correo_usuario'];
    								$_SESSION['estadoUsu'] = $rowLogin['estado_usuario'];
    								$_SESSION['fdnUsu'] = $rowLogin['fdn_usuario'];
    								$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
    								$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
    								if (isset($_POST['recordar'])) {
    									setcookie("idUsuario", $_SESSION['idUsu'], time()+63072000);
    								}
    								header('Location: main.php');
    							}else{
    								echo "Tu cuenta está desactivada. Por favor, reactívala";
    							}
    						}else{
    							echo "Debes validar tu cuenta para poder acceder.";
    						}
    
    					}else{
    						echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 0px; left: 0px; width: 100%;">Usuario y/o Contraseña incorrectos<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    					}
				    }else{
				        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 0px; left: 0px; width: 100%;">No tiene permiso para entrar<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
				    }
				}
			}
		}else{
			echo "Debes rellenar todos los campos";
		}
		
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/all.css">
    <style>
	    html,
	    body {
	        height: 100%;
	    }

	    body {
	        display: -ms-flexbox;
	        display: flex;
	        -ms-flex-align: center;
	        align-items: center;
	        padding-top: 40px;
	        padding-bottom: 40px;
	        justify-content: center;
	    }
    </style>

	<title></title>
</head>
<body>

	<div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="#">
                    <h3 style="color:blueviolet">Los Cuadros de Rita</h3>
                </a>
                <span class="splash-description">Introduce tus credenciales.</span>
            </div>
            <div class="card-body">
                <form name="loginAdmin" action="" method="POST">
                    <div class="form-group">
                        <input style="color:blueviolet" class="form-control form-control-lg" id="correo" name="correo" type="email" placeholder="Correo Electrónico" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input style="color:blueviolet" class="form-control form-control-lg" id="clave" name="clave" type="password" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    


    <script src="assets/vendor/jquery/jquery_3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>