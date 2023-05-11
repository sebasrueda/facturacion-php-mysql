<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}

include "../conexion.php";

if(!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol'];

        $query = mysqli_query($connection, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'");
        mysqli_close($connection);
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<p class="msg_error">El correo o el usuario ya existen.</p>';
        } else {
            $query_insert = mysqli_query($connection, "INSERT INTO usuario(nombre, correo, usuario, clave, rol) 
                VALUES('$nombre', '$email', '$user', '$clave', '$rol')");
            if ($query_insert) {
                $alert = '<p class="msg_save">Usuario creado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al crear el nuevo usuario.</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include 'includes/scripts.php'; ?>
    <title>Registro de usuarios</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <section class="form_register">
            <h1>Nuevo usuario</h1>
            <hr>
            <section class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </section>

            <!-- Formulario para crear un usuario nuevo -->
            <form action="" method="post">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">

                <label for="correo">Correo electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico">

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">

                <label for="rol">Tipo de usuario</label>
                <?php
                    $query_rol = mysqli_query($connection, "SELECT * FROM rol");
mysqli_close($connection);
$result_rol = mysqli_num_rows($query_rol);
?>
                <select name="rol" id="rol">
                    <?php
        if ($result_rol > 0) {
            while ($rol = mysqli_fetch_array($query_rol)) {
                ?>
                    <option
                        value="<?php echo $rol["idrol"]; ?>">
                        <?php echo $rol["rol"]; ?>
                    </option>
                    <?php
            }
        }
?>
                </select>

                <input type="submit" value="Crear usuario" class="btn_save">
            </form>
        </section>
    </section>

    <?php include 'includes/footer.php' ?>
</body>

</html>