<?php
$alert = '';

session_start();
if(!empty($_SESSION['active'])) {
    header('location: sistema/');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = 'Debe ingresar el usuario y la contraseña.';
        } else {
            require_once 'conexion.php';

            $user = mysqli_real_escape_string($connection, $_POST['usuario']);
            $pass = md5(mysqli_real_escape_string($connection, $_POST['clave']));
    
            $query = mysqli_query($connection, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
            mysqli_close($connection);
            $result = mysqli_num_rows($query);
    
            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SERVER['idUser'] = $data['idusuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['user'] = $data['usuario'];
                $_SESSION['rol'] = $data['rol'];
    
                header('location: sistema/');
            } else {
                $alert = 'El usuario o la contraseña son incorrectos.';
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de facturación</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section id="container">
        <form action="" method="post">
            <h3>Iniciar sesión</h3>
            <img src="img/login.jfif" alt="Ícono de login">

            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <section class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </section>
            <input type="submit" value="Ingresar">
        </form>
    </section>
</body>

</html>