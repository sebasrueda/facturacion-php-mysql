<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}

include '../conexion.php';

if (!empty($_POST)) {
    if ($_POST['idusuario'] == 1) {
        header("location: lista_usuarios.php");
        mysqli_close($connection);
        exit;
    }

    $idusuario = $_POST['idusuario'];
    // $query_delete = mysqli_query($connection, "DELETE FROM usuario WHERE idusuario = $idusuario");
    $query_delete = mysqli_query($connection, "UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");
    mysqli_close($connection);
    if ($query_delete) {
        header("location: lista_usuarios.php");
    } else {
        echo "Error al eliminar el usuario";
    }
}

if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
    header("location: lista_usuarios.php");
    mysqli_close($connection);
} else {
    $idUsuario = $_REQUEST['id'];

    $query = mysqli_query($connection, "SELECT u.nombre, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $idUsuario");
        
    mysqli_close($connection);
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $nombre = $data['nombre'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
        }
    } else {
        header("location: lista_usuarios.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include 'includes/scripts.php'; ?>
    <title>Eliminar usuario</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <section id="container">
        <section class="data_delete">
            <h2>¿Estás seguro de que quieres eliminar el siguiente usuario?</h2>
            <p>Nombre: <span><?php echo $nombre; ?></span></p>
            <p>Usuario: <span><?php echo $usuario; ?></span></p>
            <p>Tipo de usuario: <span><?php echo $rol; ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idusuario"
                    value="<?php echo $idUsuario; ?>">
                <a href="lista_usuarios.php" class="btn_cancelar">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_aceptar">
            </form>
        </section>
    </section>

    <?php include 'includes/footer.php' ?>
</body>

</html>