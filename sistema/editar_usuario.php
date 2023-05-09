<?php
    include "../conexion.php";

    if(!empty($_POST)) {
        $alert = '';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
        } else {
            $idUsuario = $_POST['idUsuario'];
            $nombre = $_POST['nombre'];
            $email = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];
            $query = mysqli_query($connection, "SELECT * FROM usuario 
                                                WHERE (usuario = '$user' AND idusuario != $idUsuario) 
                                                OR (correo = '$email' AND idusuario != $idUsuario)");
            $result = mysqli_fetch_array($query);

            if ($result > 0) {
                $alert = '<p class="msg_error">El correo o el usuario ya existen.</p>';
            } else {
                if (empty($_POST['clave'])) {
                    $sql_update = mysqli_query($connection, "UPDATE usuario
                                                            SET nombre = '$nombre', correo = '$email', usuario = '$user', rol = '$rol'
                                                            WHERE idusuario = $idUsuario");
                } else {
                    $sql_update = mysqli_query($connection, "UPDATE usuario
                                                            SET nombre = '$nombre', correo = '$email', usuario = '$user', clave = '$clave', rol = '$rol'
                                                            WHERE idusuario = $idUsuario");
                }

                if ($sql_update) {
                    $alert = '<p class="msg_save">Usuario modificado correctamente.</p>';
                } else {
                    $alert = '<p class="msg_error">Error al modificar el usuario.</p>';
                }
            }
        }
    }

    // Mostrar datos
    if (empty($_GET['id'])) {
        header('Location: lista_usuarios.php');
    }

    $idUser = $_GET['id'];

    $sql = mysqli_query($connection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE idusuario = $idUser");

    $result_sql = mysqli_num_rows($sql);

    if ($result_sql == 0) {
        header('Location: lista_usuarios.php');
    } else {
        $option = '';
        while ($data = mysqli_fetch_array($sql)) {
            $idUser = $data['idusuario'];
            $nombre = $data['nombre'];
            $correo = $data['correo'];
            $usuario = $data['usuario'];
            $idRol = $data['idrol'];
            $rol = $data['rol'];

            if($idRol == 1) {
                $option = '<option value="'.$idRol.'" select>'.$rol.'</option>';
            } else if ($idRol == 2) {
                $option = '<option value="'.$idRol.'" select>'.$rol.'</option>';
            } else if ($idRol == 3) {
                $option = '<option value="'.$idRol.'" select>'.$rol.'</option>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include 'includes/scripts.php'; ?>
	<title>Actualizar usuario</title>
    <style>
        .notItemOne option:first-child {
            display: none;
        }
    </style>
</head>
<body>
	<?php include 'includes/header.php' ?>
	<section id="container">
		<section class="form_register">
            <h1>Actualizar usuario</h1>
            <hr>
            <section class="alert"><?php echo isset($alert) ? $alert : ''; ?></section>

            <!-- Formulario para crear un usuario nuevo -->
            <form action="" method="post">
                <input type="hidden" name="idUsuario" value="<?php echo $idUser; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">

                <label for="correo">Correo electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">

                <label for="rol">Tipo de usuario</label>
                <?php
                    $query_rol = mysqli_query($connection, "SELECT * FROM rol");
                    $result_rol = mysqli_num_rows($query_rol);
                ?>
                <select name="rol" id="rol" class="notItemOne">
                    <?php
                        echo $option;
                        if ($result_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                                ?>
                                <option value="<?php echo $rol["idrol"]; ?>"> <?php echo $rol["rol"]; ?> </option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <input type="submit" value="Actualizar datos" class="btn_save">
            </form>
        </section>
	</section>

	<?php include 'includes/footer.php' ?>
</body>
</html>